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
    public function index()
    {
        $ideaThreads = IdeaThread::with('organization')->latest()->paginate(10);
        return view('idea_board.index', compact('ideaThreads'));
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
            'comment' => 'required|max:200',
        ]);

        IdeaComment::create([
            'idea_thread_id' => $ideaThread->id,
            'volunteer_userid' => Auth::id(),
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Comment added successfully.');
    }

    public function vote(Request $request, IdeaThread $ideaThread)
    {
        $request->validate([
            'vote' => 'required|in:1,-1',
        ]);

        $vote = IdeaVote::updateOrCreate(
            ['idea_thread_id' => $ideaThread->id, 'user_userid' => Auth::id()],
            ['vote' => $request->vote]
        );

        $ideaThread->votes = $ideaThread->votes()->sum('vote');
        $ideaThread->save();

        return back()->with('success', 'Vote recorded successfully.');
    }

    public function pollVote(Request $request, PollOption $pollOption)
    {
        $pollOption->increment('votes');
        return back()->with('success', 'Poll vote recorded successfully.');
    }
}