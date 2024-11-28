<?php

namespace App\Http\Controllers;

use App\Models\IdeaThread;
use App\Models\IdeaComment;
use App\Models\IdeaPoll;
use App\Models\PollOption;
use App\Models\IdeaVote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PollVote;
use Illuminate\Support\Facades\DB;

class IdeaThreadController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->query('sort', 'recent');
    
        $ideaThreads = IdeaThread::with(['organization', 'comments', 'poll.options'])
            ->when($sort === 'recent', function ($query) {
                return $query->orderBy('created_at', 'desc');
            })
            ->when($sort === 'likes', function ($query) {
                return $query->withCount('votes')->orderByDesc('votes_count');
            })
            ->paginate(10);
    
        return view('idea_board.index', compact('ideaThreads', 'sort'));
    }

    public function create()
    {
        return view('idea_board.create');
    }

    public function store(Request $request)
    {
        // First, let's validate the basic thread requirements
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
        ]);

        DB::beginTransaction();
        try {
            // Create the basic thread
            $ideaThread = IdeaThread::create([
                'userid' => Auth::id(),  // Make sure this matches your column name
                'title' => $request->title,
                'description' => $request->description,
            ]);

            // Only handle poll if question exists and has options
            if ($request->filled('poll_question') && is_array($request->poll_options)) {
                // Validate poll data
                $request->validate([
                    'poll_question' => 'string|max:255',
                    'poll_options' => 'array|min:2',
                    'poll_options.*' => 'string|max:100',
                ]);

                $poll = IdeaPoll::create([
                    'idea_thread_id' => $ideaThread->id,
                    'question' => $request->poll_question,
                ]);

                // Only create options that aren't empty
                foreach ($request->poll_options as $option) {
                    if (trim($option) !== '') {
                        PollOption::create([
                            'idea_poll_id' => $poll->id,
                            'option_text' => $option,
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('idea_board.index', $ideaThread)
                ->with('success', 'Idea thread created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Failed to create idea thread: ' . $e->getMessage());
            return back()->with('error', 'Failed to create idea thread. Please try again.')
                ->withInput();
        }
    }

    public function show(IdeaThread $ideaThread)
    {
        $ideaThread->load('organization', 'comments.volunteer', 'poll.options');
        return view('idea_board.show', compact('ideaThread'));
    }

    public function comment(Request $request, IdeaThread $ideaThread)
    {
        $request->validate([
            'comment' => 'required|max:2500',
        ]);

        $volunteerUserId = Auth::id();

        // Check if the volunteer has already commented
        if ($ideaThread->comments()->where('volunteer_userid', $volunteerUserId)->exists()) {
            return back()->with('error', 'You have already commented on this idea.');
        }

        IdeaComment::create([
            'idea_thread_id' => $ideaThread->id,
            'volunteer_userid' => $volunteerUserId,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Comment added successfully.');
    }


    public function vote(Request $request)
    {
        $request->validate([
            'votable_type' => 'required|in:thread,comment',
            'votable_id' => 'required|integer',
            'vote' => 'required|in:1,-1',
        ]);

        $votableType = $request->votable_type === 'thread' ? IdeaThread::class : IdeaComment::class;
        $votable = $votableType::findOrFail($request->votable_id);

        $existingVote = IdeaVote::where([
            'user_userid' => Auth::id(),
            'idea_thread_id' => $request->votable_type === 'thread' ? $votable->id : $votable->idea_thread_id,
            'idea_comment_id' => $request->votable_type === 'comment' ? $votable->id : null,
        ])->first();

        if ($existingVote) {
            $existingVote->delete();
            $voted = false;
        } else {
            IdeaVote::create([
                'user_userid' => Auth::id(),
                'idea_thread_id' => $request->votable_type === 'thread' ? $votable->id : $votable->idea_thread_id,
                'idea_comment_id' => $request->votable_type === 'comment' ? $votable->id : null,
                'vote' => $request->vote
            ]);
            $voted = true;
        }

        return response()->json([
            'success' => true,
            'newVoteCount' => $votable->getVoteCount(),
            'voted' => $voted
        ]);
    }

    public function pollVote(Request $request, IdeaPoll $poll)
    {
        $request->validate([
            'option_id' => [
                'required',
                'exists:poll_options,id',
                function ($attribute, $value, $fail) use ($poll) {
                    if (!$poll->options()->where('id', $value)->exists()) {
                        $fail('The selected option does not belong to this poll.');
                    }
                },
            ]
        ]);

        $userId = Auth::id();

        DB::transaction(function () use ($poll, $userId, $request) {
            // First check for existing vote
            $existingVote = $poll->votes()->where('user_id', $userId)->first();
            
            if ($existingVote) {
                // If voting for the same option, do nothing
                if ($existingVote->poll_option_id == $request->option_id) {
                    return;
                }
                
                // Decrement votes count for the old option
                $poll->options()->where('id', $existingVote->poll_option_id)->decrement('votes');
                
                // Delete the old vote
                $existingVote->delete();
            }

            // Create new vote
            PollVote::create([
                'user_id' => $userId,
                'poll_option_id' => $request->option_id,
                'idea_poll_id' => $poll->id
            ]);

            // Increment votes for the new option
            $poll->options()->where('id', $request->option_id)->increment('votes');
        });

        return back()->with('success', 'Your vote has been recorded.');
    }

    public function loadMoreComments(IdeaThread $thread, Request $request)
    {
        $offset = $request->query('offset', 0);
        $sort = $request->query('sort', 'recent');
    
        $comments = $thread->comments()->with('volunteer')
            ->when($sort === 'likes', function ($query) {
                return $query->withCount('votes')->orderByDesc('votes_count');
            })
            ->when($sort === 'recent', function ($query) {
                return $query->orderBy('created_at', 'desc');
            })
            ->skip($offset)
            ->take(5)
            ->get();
    
        return response()->json([
            'comments' => $comments->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'comment' => $comment->comment,
                    'volunteer_name' => $comment->volunteer->Name,
                    'vote_count' => $comment->getVoteCount(),
                    'created_at' => $comment->created_at->diffForHumans(),
                ];
            })
        ]);
    }

    public function close(Request $request, IdeaThread $ideaThread)
    {
        // Verify the authenticated user owns the thread
        if ($ideaThread->userid !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'winner_comment_id' => 'required|exists:idea_comments,id'
        ]);

        // Verify the comment belongs to this thread
        $comment = IdeaComment::where('id', $request->winner_comment_id)
            ->where('idea_thread_id', $ideaThread->id)
            ->firstOrFail();

        $ideaThread->update([
            'status' => 'closed',
            'winner_comment_id' => $request->winner_comment_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thread closed successfully',
            'winner_comment' => [
                'comment' => $comment->comment,
                'volunteer_name' => $comment->volunteer->Name,
                'created_at' => $comment->created_at->diffForHumans()
            ]
        ]);
    }

    public function myIdeas()
    {
        $user = Auth::user();
        $query = IdeaThread::with(['organization', 'comments.volunteer', 'poll.options', 'winnerComment']);

        if ($user->organization) {
            // For organizations: show threads they created
            $ideaThreads = $query->where('userid', $user->userid)
                                ->orderBy('created_at', 'desc')
                                ->paginate(10);
        } else {
            // For volunteers: show threads they've commented on or voted on
            $ideaThreads = $query->where(function($q) use ($user) {
                $q->whereHas('comments', function($q) use ($user) {
                    $q->where('volunteer_userid', $user->userid);
                })->orWhereHas('votes', function($q) use ($user) {
                    $q->where('user_userid', $user->userid);
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        }

        return view('idea_board.my-ideas', compact('ideaThreads'));
    }

}
