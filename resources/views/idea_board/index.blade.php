<x-app-layout>
    <link href="{{ asset('css/volunteer-profile.css') }}" rel="stylesheet">
    <script src="{{ asset('js/vote_new.js') }}" defer></script>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 min-h-screen">
        <!-- Centered container with responsive padding and vertical spacing -->
        <div
        class="w-full p-5 mx-auto shadow-lg mb-4 flex flex-col items-center justify-center bg-gray-800 text-white">
        <i class="fas fa-lightbulb text-lg text-yellow-500"></i>

        <h2
            class="bg-gradient-to-r from-blue-600 via-green-500 to-blue-500 inline-block text-transparent bg-clip-text text-lg font-bold mt-2 mb-2">
            Share Your Ideas & Make a Difference!</h2>
        <p class="text-base text-center">Join our community in creating positive change. Every idea can spark
            meaningful impact in our society.</p>

        @if (Auth::user()->organization)
            <a href="{{ route('idea_board.create') }}"
                class="mt-4 text-white bg-gradient-to-br from-green-400 to-blue-600 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2">
                <i class="fas fa-plus"></i> Create New Idea Thread
            </a>
        @endif

        <a href="{{ route('idea_board.my-ideas') }}"
            class="mt-4 text-white bg-gradient-to-br from-green-400 to-blue-600 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2">
            <i class="fas fa-list"></i> My Ideas
        </a>
    </div>
        <div class="p-1 sm:p-8 bg-white shadow sm:rounded-lg">
            <!-- Profile information card with padding, background color, shadow, and rounded corners -->
                <div class="mt-2">
                    @foreach ($ideaThreads as $thread)
                        <div class="rounded-xl mb-4 overflow-hidden flex flex-col shadow border border-gray-200 p-4">
                            <!-- Thread Header -->
                            <div class="flex items-center space-x-4 border-b border-gray-100 pb-2">
                                <img src="{{ asset($thread->organization->getLogoPath()) }}"
                                    alt="{{ $thread->organization->org_name }}"
                                    class="w-10 h-10 rounded-full object-cover">
                                <div class="flex flex-col ml-2 flex-grow">
                                    <div class="flex items-center justify-between">
                                        <h4 class="text-lg font-semibold">
                                            <a href="{{ route('idea_board.show', $thread) }}"
                                                class="text-gray-900 hover:text-gray-700">
                                                {{ $thread->title }}
                                            </a>
                                        </h4>
                                        <!-- Share Dropdown -->
                                        <div class="relative ml-4" x-data="{ open: false }">
                                            <button @click="open = !open" 
                                                class="flex items-center space-x-1 px-2 py-0.5 text-xs border border-gray-300 rounded-md hover:bg-gray-50 transition duration-150">
                                                <i class="fas fa-share-alt"></i>
                                                <span>Share</span>
                                            </button>
                                            <div x-show="open" @click.away="open = false" 
                                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border">
                                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('idea_board.show', $thread)) }}" 
                                                    target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                    <i class="fab fa-facebook mr-2"></i>Share on Facebook
                                                </a>
                                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('idea_board.show', $thread)) }}" 
                                                    target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                    <i class="fab fa-twitter mr-2"></i>Share on Twitter
                                                </a>
                                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('idea_board.show', $thread)) }}" 
                                                    target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                    <i class="fab fa-linkedin mr-2"></i>Share on LinkedIn
                                                </a>
                                                <button onclick="navigator.clipboard.writeText('{{ route('idea_board.show', $thread) }}')"
                                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                    <i class="fas fa-link mr-2"></i>Copy Link
                                                </button>
                                            </div>
                                        </div>
                                    </div>
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
                            <div class="px-4 py-1" name="idea-details-container">
                                @if ($thread->poll)
                                    <p class="text-sm text-gray-600 mb-3">{{ $thread->poll->question }}</p>
                                    <form
                                        action="{{ route('idea_board.poll_vote', ['poll' => $thread->poll->id]) }}"
                                        method="POST">
                                        @csrf
                                        @foreach ($thread->poll->options as $option)
                                            <div class="mb-3">
                                                <button type="submit" name="option_id" value="{{ $option->id }}"
                                                    class="w-full relative border {{ $option->hasVotedBy(Auth::id()) ? 'border-blue-500' : 'border-gray-300' }} rounded-md overflow-hidden">
                                                    <div class="flex items-center">
                                                        <div class="w-full">
                                                            <!-- Base gradient progress bar for ALL options -->
                                                            <div class="absolute top-0 left-0 h-full bg-gradient-to-r from-blue-100 to-green-100"
                                                                style="width: {{ $option->getPercentage() }}%; z-index: 0; opacity: 0.4">
                                                            </div>
                                                            <!-- Additional overlay with higher opacity only for voted option -->
                                                            @if ($option->hasVotedBy(Auth::id()))
                                                                <div class="absolute top-0 left-0 h-full bg-gradient-to-r from-blue-100 to-green-100"
                                                                    style="width: {{ $option->getPercentage() }}%; z-index: 0; opacity: 0.8">
                                                                </div>
                                                            @endif
                                                            <div
                                                                class="px-4 py-2 relative z-10 flex justify-between items-center {{ $option->hasVotedBy(Auth::id()) ? 'text-blue-600 font-medium' : '' }}">
                                                                <span>{{ $option->option_text }}</span>
                                                                @if ($thread->poll->hasVotedBy(Auth::id()))
                                                                    <span>{{ number_format($option->getPercentage(), 1) }}%</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </button>
                                            </div>
                                        @endforeach
                                    </form>
                                    <div class="mt-3 text-sm text-gray-500 flex justify-between items-center">
                                        <span>{{ $thread->poll->getTotalVotes() }} votes</span>
                                        @if ($thread->poll->hasVotedBy(Auth::id()))
                                            <span class="text-blue-600">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                You voted
                                            </span>
                                        @endif
                                    </div>

                                @else
                                    <p class="text-gray-700 leading-relaxed">
                                        {{ Str::limit($thread->description, 150) }}</p>
                                        <!-- upvote buttone for thread -->
                                        @php
                                            $votableType = 'thread';
                                            $votable = $thread;
                                        @endphp
                                        <div class="mt-2 flex items-center">
                                            <button type="button" 
                                                class="new-vote-btn text-gray-500 hover:text-blue-500 {{ $thread->hasVotedBy(Auth::id()) ? 'text-blue-500' : '' }}"
                                                data-new-votable-type="{{ $votableType }}" 
                                                data-new-votable-id="{{ $thread->id }}"
                                                data-new-vote-status="{{ $thread->hasVotedBy(Auth::id()) ? 'true' : 'false' }}">
                                                <i class="fas fa-thumbs-up mr-1 new-vote-icon {{ $thread->hasVotedBy(Auth::id()) ? 'text-blue-500' : '' }}"></i>
                                            </button>
                                            <span class="mx-2 new-vote-count">{{ $thread->getVoteCount() }}</span>
                                        </div>
                                    
                                    

                                    <!-- Comment Form - -->
                                    @auth
                                        @if (Auth::user()->volunteer && !$thread->comments->where('volunteer_userid', Auth::id())->count())
                                            <div class="mt-4">
                                                <form method="POST" action="{{ route('idea_board.comment', $thread) }}" class="space-y-4">
                                                    @csrf
                                                    <textarea name="comment" rows="2" 
                                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500"
                                                        placeholder="Share your thoughts..." required></textarea>
                                                        
                                                    <p class="text-sm text-gray-600 mb-2">You can only comment once so prepare well</p>
                                                    <button type="submit" 
                                                        class="float-right px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-150">
                                                        Comment
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    @endauth
                                @endif
                            </div>
                            
                            @if ($thread->status === 'closed' && $thread->winnerComment)
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
                                <div class="mt-4 flex justify-between items-center">
                                    <h4 class="text-lg font-semibold">Comments</h4>
                                <div class="flex justify-end" x-data="{ activeSort: 'recent' }">
                                    <!-- SORTING IS MOVED TO SHOW.BLADE -->
                                    <!-- <div class="relative inline-flex rounded-full bg-gray-800 p-0.5 shadow-md" style="width: fit-content;">
                                        <button
                                            class="sort-comments relative z-10 px-3 py-1 text-xs font-medium transition-all duration-300 ease-in-out rounded-full text-white scale-105"
                                            data-thread-id="{{ $thread->id }}" 
                                            data-sort="recent">
                                            <i class="fas fa-clock mr-1 text-xs"></i>
                                            Most Recent
                                        </button>
                                        
                                        <div class="h-4 w-px bg-gray-600 my-auto mx-0.5"></div>
                                        
                                        <button
                                            class="sort-comments relative z-10 px-3 py-1 text-xs font-medium transition-all duration-300 ease-in-out rounded-full text-gray-400"
                                            data-thread-id="{{ $thread->id }}" 
                                            data-sort="likes">
                                            <i class="fas fa-heart mr-1 text-xs"></i>
                                            Most Liked
                                        </button>
                                        
                                        <div 
                                            class="absolute inset-y-0 w-[45%] rounded-full shadow-md transition-all duration-300 ease-in-out bg-gradient-to-r from-blue-500 to-blue-600"
                                            style="z-index: 1; transform: translateX(0);">
                                        </div>
                                    </div> -->
                                </div>
                            </div>

                                <!-- view more comments -->

                                <div class="mt-4">
                                    <div class="comments-container border border-gray-200 rounded-lg" data-thread-id="{{ $thread->id }}" style="max-height: 300px; overflow-y: auto; scrollbar-width: thin;">
                                        @foreach ($thread->comments->take(5) as $comment)
                                            <div class="p-4 border-b border-gray-100 last:border-b-0 hover:bg-gray-50 transition duration-150 {{ $comment->volunteer_userid === Auth::id() ? 'bg-blue-50' : '' }}">
                                                <div class="flex space-x-3">
                                                    <!-- User Avatar -->
                                                    <img src="{{ $comment->volunteer->getProfilePicturePath() }}" 
                                                        alt="{{ $comment->volunteer->Name }}" 
                                                        class="w-8 h-8 rounded-full object-cover">
                                                    
                                                    <div class="flex-1">
                                                        <!-- Comment Content -->
                                                        <div class="bg-gray-100 rounded-2xl px-4 py-2">
                                                            <div class="font-semibold text-sm text-gray-900">
                                                                {{ $comment->volunteer->Name }}
                                                            </div>
                                                            <p class="text-sm text-gray-700">{{ $comment->comment }}</p>
                                                        </div>
                                                        
                                                        <!-- Actions and Timestamp -->
                                                        <div class="flex items-center space-x-4 mt-1 text-xs text-gray-500">
                                                            <span>{{ $comment->created_at->diffForHumans() }}</span>
                                                            <div class="flex items-center">
                                                                <button type="button" 
                                                                    class="new-vote-btn text-gray-500 hover:text-blue-500 {{ $comment->hasVotedBy(Auth::id()) ? 'text-blue-500' : '' }}"
                                                                    data-new-votable-type="comment" 
                                                                    data-new-votable-id="{{ $comment->id }}"
                                                                    data-new-vote-status="{{ $comment->hasVotedBy(Auth::id()) ? 'true' : 'false' }}">
                                                                    <i class="fas fa-thumbs-up mr-1 new-vote-icon {{ $comment->hasVotedBy(Auth::id()) ? 'text-blue-500' : '' }}"></i>
                                                                </button>
                                                                <span class="mx-2 new-vote-count">{{ $comment->getVoteCount() }}</span>
                                                            </button>
                                                            </div>
                                                            @if (Auth::id() === $thread->userid && $thread->status === 'open')
                                                                <button type="button"
                                                                    class="select-winner-btn text-green-600 hover:text-green-700"
                                                                    data-thread-id="{{ $thread->id }}"
                                                                    data-comment-id="{{ $comment->id }}">
                                                                    <i class="fas fa-crown mr-1"></i>
                                                                    Select as Winner
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @if ($thread->comments->count() > 4)
                                        <div class="text-center mt-2">
                                            <a href="{{ route('idea_board.show', $thread) }}"
                                                class="inline-flex items-center text-blue-600 hover:text-blue-800 text-sm font-medium transition duration-150">
                                                <span>View all comments</span>
                                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach

                    {{ $ideaThreads->appends(['sort' => request('sort', 'likes')])->links() }}
                </div>

                <!-- $ideaThreads->links() -->
            {{-- </div> --}}
        </div>
    </div>

    <!-- Winner Selection Modal -->
    <div id="winner-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-xl max-w-md w-full mx-4">
            <h3 class="text-lg font-semibold mb-4">Confirm Winner Selection</h3>
            <p class="mb-4">Select the chosen comment as winner? This will close the current thread.</p>
            <div class="flex justify-end space-x-3">
                <button type="button" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded"
                    onclick="closeWinnerModal()">
                    Cancel
                </button>
                <button type="button" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded"
                    onclick="confirmWinnerSelection()">
                    Confirm
                </button>
            </div>
        </div>
    </div>

<script>

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
                    const threadElement = document.querySelector(`[data-thread-id="${currentThreadId}"]`).closest(
                        '.rounded-xl');
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
</x-app-layout>