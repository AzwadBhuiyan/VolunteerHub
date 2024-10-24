<?php

namespace App\Http\Controllers;

use App\Models\IdeaThread;
use App\Models\IdeaComment;
use App\Models\IdeaPoll;
use App\Models\PollOption;
use App\Models\IdeaVote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IdeaThreadController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->query('sort', 'recent');
    
        $ideaThreads = IdeaThread::with(['organization', 'comments'])
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
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'poll_question' => 'nullable|string|max:255',
            'poll_options' => 'nullable|array|min:2',
            'poll_options.*' => 'required|string|max:100',
        ]);

        $ideaThread = IdeaThread::create([
            'userid' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
        ]);

        if ($request->filled('poll_question')) {
            $poll = IdeaPoll::create([
                'idea_thread_id' => $ideaThread->id,
                'question' => $request->poll_question,
            ]);

            foreach ($request->poll_options as $option) {
                PollOption::create([
                    'idea_poll_id' => $poll->id,
                    'option_text' => $option,
                ]);
            }
        }

        return redirect()->route('idea_board.show', $ideaThread)->with('success', 'Idea thread created successfully.');
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

    public function pollVote(Request $request, PollOption $pollOption)
    {
        $pollOption->increment('votes');
        return back()->with('success', 'Poll vote recorded successfully.');
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
                ];
            })
        ]);
    }
}
