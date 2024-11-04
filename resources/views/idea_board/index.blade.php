<x-app-layout>
    <link href="{{ asset('css/volunteer-profile.css') }}" rel="stylesheet">

    <div class="max-w-7xl mx-auto px-1 sm:px-6 lg:px-8 ">
        <!-- Centered container with responsive padding and vertical spacing -->
        <div class="p-4 sm:p-8 bg-white items-center shadow sm:rounded-lg">
            <!-- Profile information card with padding, background color, shadow, and rounded corners -->

            {{-- <div class="py-12">
          <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg"> --}}
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="text-center">
                    @if (Auth::user()->organization)
                        <a href="{{ route('idea_board.create') }}" class="btn">
                            <i class="fas fa-plus"></i>Create New Idea Thread
                        </a>
                    @endif

                    <a href="{{ route('idea_board.create') }}" class="btn">
                        <i class="fas fa-pen"></i>My Idea Threads
                    </a>
                </div>

                <div class="mt-6">
                    @foreach ($ideaThreads as $thread)
                        <div class="rounded-xl mb-4 overflow-hidden flex flex-col shadow border border-gray-200 p-4">
                            <!-- Thread Header -->
                            <div class="flex items-center space-x-4 border-b border-gray-100 pb-2">
                                <img src="{{ asset($thread->organization->getLogoPath()) }}"
                                    alt="{{ $thread->organization->org_name }}"
                                    class="w-12 h-12 rounded-full object-cover">
                                <div class="flex flex-col ml-2">
                                    <h4 class="text-lg font-semibold text-gray-800">
                                        <a href="{{ route('idea_board.show', $thread) }}"
                                            class="text-blue-500 hover:underline">
                                            {{ $thread->title }}
                                        </a>
                                    </h4>
                                    <div class="text-sm text-gray-500">
                                        <a href="{{ route('profile.public', $thread->organization->url) }}"
                                            class="text-blue-500 hover:underline">
                                            {{ $thread->organization->org_name }}
                                        </a>
                                        <span>.</span>
                                        <span>{{ ucfirst($thread->status) }}</span>
                                        <span>.</span>
                                        <span>{{ $thread->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Thread Description -->
                            <div class="px-4 py-1">
                                @if($thread->poll)
                                    <div class="bg-blue-50 p-4 rounded-lg">
                                        <h4 class="text-lg font-semibold mb-2 py-2">{{ $thread->description }}</h4>
                                        <form action="{{ route('idea_board.poll_vote', ['poll' => $thread->poll->id]) }}" method="POST">
                                            @csrf
                                            @foreach($thread->poll->options as $option)
                                                <div class="mb-2">
                                                    <button type="submit" name="option_id" value="{{ $option->id }}" 
                                                        class="w-full text-left p-2 bg-white hover:bg-blue-100 border border-blue-200 rounded 
                                                        {{ $option->hasVotedBy(Auth::id()) ? 'bg-blue-200' : '' }}">
                                                        {{ $option->option_text }}
                                                        <span class="float-right">{{ $option->votes }} votes ({{ number_format($option->getPercentage(), 1) }}%)</span>
                                                    </button>
                                                </div>
                                            @endforeach
                                        </form>
                                        <p class="mt-2 text-sm text-gray-600">Total votes: {{ $thread->poll->getTotalVotes() }}</p>
                                        @if($thread->poll->hasVotedBy(Auth::id()))
                                            <p class="mt-2 text-sm text-blue-600">You have voted in this poll. You can change your vote by selecting a different option.</p>
                                        @endif
                                    </div>
                                @else
                                    <p class="text-gray-700 leading-relaxed">{{ Str::limit($thread->description, 150) }}</p>
                                @endif
                            </div>
                            <!-- upvote buttone for thread -->
                            @php
                                $votableType = 'thread';
                                $votable = $thread;
                            @endphp
                            <div class="mt-2 flex items-center">
                                <button type="button" class="vote-button text-gray-500 hover:text-blue-500" data-votable-type="{{ $votableType }}" data-votable-id="{{ $thread->id }}">
                                    <svg class="w-5 h-5 vote-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                </button>
                                <span class="mx-2 vote-count">{{ $thread->getVoteCount() }}</span>

                                
                            </div>
                            @if($thread->status === 'closed' && $thread->winnerComment)
                                    <div class="px-4 py-2 bg-green-50 border border-green-200 rounded-lg">
                                        <p class="text-sm font-semibold text-green-800">Winner Comment:</p>
                                        <p class="mt-1">{{ $thread->winnerComment->comment }}</p>
                                        <div class="mt-2 text-xs text-green-600">
                                            <span>By: {{ $thread->winnerComment->volunteer->Name }}</span>
                                            <span>•</span>
                                            <span>{{ $thread->winnerComment->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                            @endif

                            <!-- Thread Footer (Comments Section) -->
                            @if ($thread->comments->isNotEmpty())
                                
                                <!-- sorting -->
                                <div class="mt-2 flex justify-end">
                                    <button class="sort-comments mr-2 {{ $sort === 'recent' ? 'text-blue-500 font-bold' : '' }}" data-thread-id="{{ $thread->id }}" data-sort="recent">Most Recent</button>
                                    <button class="sort-comments {{ $sort === 'likes' ? 'text-blue-500 font-bold' : '' }}" data-thread-id="{{ $thread->id }}" data-sort="likes">Most Liked</button>
                                </div>


                                <!-- view more comments -->

                                <div class="mt-4">
                                    <h4 class="text-lg font-semibold mb-2">Comments</h4>
                                    <div class="comments-container" data-thread-id="{{ $thread->id }}" style="max-height: 300px; overflow-y: auto;">
                                        @foreach($thread->comments->take(5) as $comment)
                                            <div class="mb-2 p-2 border rounded">
                                                <p>{{ $comment->comment }}</p>
                                                <div class="flex justify-between items-center">
                                                    <div class="text-sm text-gray-600">
                                                        <span>By: {{ $comment->volunteer->Name }}</span>
                                                        <span>•</span>
                                                        <span>{{ $comment->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    @if(Auth::id() === $thread->userid && $thread->status === 'open')
                                                        <button 
                                                            type="button"
                                                            class="select-winner-btn bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm"
                                                            data-thread-id="{{ $thread->id }}"
                                                            data-comment-id="{{ $comment->id }}">
                                                            Select as Winner
                                                        </button>
                                                    @endif
                                                </div>
                                                <div class="mt-2 flex items-center">
                                                    <button type="button" class="vote-button text-gray-500 hover:text-blue-500" data-votable-type="comment" data-votable-id="{{ $comment->id }}">
                                                        <svg class="w-5 h-5 vote-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                                    </button>
                                                    <span class="mx-2 vote-count">{{ $comment->getVoteCount() }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @if($thread->comments->count() > 1)
                                        <button class="view-more-comments mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm" data-thread-id="{{ $thread->id }}" data-offset="5">
                                            View More Comments
                                        </button>
                                    @endif
                                </div>

                                @if($thread->comments->isNotEmpty())
                                    @auth
                                        @if(Auth::user()->volunteer)
                                            @php
                                                $authUserId = Auth::id();
                                                $userComment = $thread->comments->where('volunteer_userid', $authUserId)->first();
                                            @endphp
                                            
                                            @if(!$userComment)
                                                <form method="POST" action="{{ route('idea_board.comment', $thread) }}" class="mt-4">
                                                    @csrf
                                                    <div class="mb-4">
                                                        <label for="comment" class="block text-gray-700 text-sm font-bold mb-2">Your Comment:</label>
                                                        <textarea name="comment" id="comment" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required maxlength="200"></textarea>
                                                    </div>
                                                    <div class="flex items-center justify-end mt-4">
                                                        <p class="text-yellow-600">You can only comment once, so prepare your comment well.</p>
                                                        <x-primary-button class="ml-4">
                                                            {{ __('Submit Comment') }}
                                                        </x-primary-button>
                                                    </div>
                                                </form>
                                            @else
                                                <div class="mt-2 p-2 bg-gray-100 rounded">
                                                    <p class="text-sm"><strong>Your Comment:</strong> </p>
                                                    <p>{{ Str::limit($userComment->comment, 250) }}
                                                    @if (strlen($userComment->comment) > 250)
                                                        <a href="#" class="text-blue-500 hover:underline view-full-description" data-full-description="{{ $userComment->comment }}">View full</a>
                                                    @endif
                                                    </p>
                                                    <p class="text-xs text-gray-500">By: {{ $userComment->volunteer->Name }}</p>
                                                </div>
                                            @endif
                                        @endif
                                    @endauth
                                @endif

                                <!-- <a href="{{ route('idea_board.show', $thread) }}#comment-section" class="mt-2 inline-block bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-sm">
                                    View All Comments
                                </a> -->

                                <!-- Comment Form -->
                                @auth
                                    @if(Auth::user()->volunteer)
                                        @if($thread->comments->where('volunteer_userid', Auth::id())->count()>0)
                                            <p class="text-yellow-600">You have already commented on this idea.</p>
                                        @endif
                                    @endif
                                @endauth
                            @endif


                            <!-- Priority Score -->
                            {{-- <div class="px-4 py-2 bg-gray-100">
                                <p class="text-sm text-gray-600">Priority Score: {{ $thread->priority_score }}</p>
                            </div> --}}

                            
                        </div>
                    @endforeach

                    {{ $ideaThreads->appends(['sort' => request('sort', 'likes')])->links() }}
                </div>

                {{ $ideaThreads->links() }}
            </div>
        </div>
    </div>

    <!-- Winner Selection Modal -->
    <div id="winner-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-xl max-w-md w-full mx-4">
            <h3 class="text-lg font-semibold mb-4">Confirm Winner Selection</h3>
            <p class="mb-4">Select the chosen comment as winner? This will close the current thread.</p>
            <div class="flex justify-end space-x-3">
                <button type="button" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded" onclick="closeWinnerModal()">
                    Cancel
                </button>
                <button type="button" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded" onclick="confirmWinnerSelection()">
                    Confirm
                </button>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const viewMoreButtons = document.querySelectorAll('.view-more-comments');
    const sortButtons = document.querySelectorAll('.sort-comments');

    viewMoreButtons.forEach(button => {
        button.addEventListener('click', loadMoreComments);
    });

    sortButtons.forEach(button => {
        button.addEventListener('click', sortComments);
    });

    // Use event delegation for vote buttons
    document.addEventListener('click', function(event) {
        if (event.target.closest('.vote-button')) {
            vote.call(event.target.closest('.vote-button'));
        }
    });

    function loadMoreComments() {
        const threadId = this.dataset.threadId;
        const offset = parseInt(this.dataset.offset);
        const commentsContainer = document.querySelector(`.comments-container[data-thread-id="${threadId}"]`);

        fetch(`/idea-board/${threadId}/comments?offset=${offset}`)
            .then(response => response.json())
            .then(data => {
                if (data.comments.length > 0) {
                    data.comments.forEach(comment => {
                        const commentElement = createCommentElement(comment);
                        commentsContainer.appendChild(commentElement);
                    });

                    this.dataset.offset = offset + data.comments.length;
                    commentsContainer.scrollTop = commentsContainer.scrollHeight;
                }

                if (data.comments.length < 5) {
                    this.style.display = 'none';
                }
            });
    }

    function sortComments() {
        const threadId = this.dataset.threadId;
        const sort = this.dataset.sort;
        const commentsContainer = document.querySelector(`.comments-container[data-thread-id="${threadId}"]`);
        const viewMoreButton = commentsContainer.nextElementSibling;

        // Update button styles
        const sortButtons = document.querySelectorAll(`.sort-comments[data-thread-id="${threadId}"]`);
        sortButtons.forEach(button => {
            button.classList.toggle('text-blue-500', button.dataset.sort === sort);
            button.classList.toggle('font-bold', button.dataset.sort === sort);
        });

        fetch(`/idea-board/${threadId}/comments?sort=${sort}`)
            .then(response => response.json())
            .then(data => {
                commentsContainer.innerHTML = '';
                data.comments.forEach(comment => {
                    const commentElement = createCommentElement(comment);
                    commentsContainer.appendChild(commentElement);
                });

                // Reset the view more button
                if (viewMoreButton) {
                    viewMoreButton.dataset.offset = '5';
                    viewMoreButton.style.display = data.comments.length >= 5 ? 'inline-block' : 'none';
                }
            });
    }

    function vote() {
        const votableType = this.dataset.votableType;
        const votableId = this.dataset.votableId;
        const voteCount = this.nextElementSibling;
        const voteIcon = this.querySelector('.vote-icon');

        fetch('/idea-board/vote', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                votable_type: votableType,
                votable_id: votableId,
                vote: 1
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                voteCount.textContent = data.newVoteCount;
                if (data.voted) {
                    voteIcon.setAttribute('fill', 'currentColor');
                    this.classList.add('text-blue-500');
                } else {
                    voteIcon.setAttribute('fill', 'none');
                    this.classList.remove('text-blue-500');
                }
            }
        });
    }

    function createCommentElement(comment) {
        const div = document.createElement('div');
        div.className = 'mb-2 p-2 border rounded';
        div.innerHTML = `
            <p>${comment.comment}</p>
            <div class="flex justify-between items-center">
                <div class="text-sm text-gray-600">
                    <span>By: ${comment.volunteer_name}</span>
                    <span>•</span>
                    <span>${comment.created_at}</span>
                </div>
                ${comment.can_select_winner ? `
                    <button 
                        type="button"
                        class="select-winner-btn bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm"
                        data-thread-id="${comment.thread_id}"
                        data-comment-id="${comment.id}">
                        Select as Winner
                    </button>
                ` : ''}
            </div>
            <div class="mt-2 flex items-center">
                <button type="button" class="vote-button text-gray-500 hover:text-blue-500" data-votable-type="comment" data-votable-id="${comment.id}">
                    <svg class="w-5 h-5 vote-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                </button>
                <span class="mx-2 vote-count">${comment.vote_count}</span>
            </div>
        `;
        return div;
    }
});

let currentThreadId = null;
let currentCommentId = null;

document.addEventListener('click', function(event) {
    if (event.target.matches('.select-winner-btn')) {
        currentThreadId = event.target.dataset.threadId;
        currentCommentId = event.target.dataset.commentId;
        document.getElementById('winner-modal').style.display = 'flex';
    }
});

function closeWinnerModal() {
    document.getElementById('winner-modal').style.display = 'none';
}

function confirmWinnerSelection() {
    fetch(`/idea-board/${currentThreadId}/close`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            winner_comment_id: currentCommentId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Replace the comments section with winner display
            const threadElement = document.querySelector(`[data-thread-id="${currentThreadId}"]`).closest('.rounded-xl');
            const commentsSection = threadElement.querySelector('.comments-container').closest('.mt-4');
            
            // Create winner display
            const winnerDisplay = document.createElement('div');
            winnerDisplay.className = 'px-4 py-2 bg-green-50 border border-green-200 rounded-lg';
            winnerDisplay.innerHTML = `
                <p class="text-sm font-semibold text-green-800">Winner Comment:</p>
                <p class="mt-1">${data.winner_comment.comment}</p>
                <div class="mt-2 text-xs text-green-600">
                    <span>By: ${data.winner_comment.volunteer_name}</span>
                    <span>•</span>
                    <span>${data.winner_comment.created_at}</span>
                </div>
            `;
            
            commentsSection.replaceWith(winnerDisplay);
            closeWinnerModal();
            
            // Update thread status in the header
            const statusElement = threadElement.querySelector('.text-sm.text-gray-500 span:nth-child(2)');
            if (statusElement) {
                statusElement.textContent = 'Closed';
            }
        }
    });
}
</script>