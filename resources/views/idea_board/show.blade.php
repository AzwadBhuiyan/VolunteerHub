<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 min-h-screen">
        <div class="p-1 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="rounded-xl mb-4 overflow-hidden flex flex-col shadow border border-gray-200 p-4">
                <!-- Thread Header -->
                <div class="flex items-center space-x-4 border-b border-gray-100 pb-2">
                    <img src="{{ asset($ideaThread->organization->getLogoPath()) }}"
                        alt="{{ $ideaThread->organization->org_name }}"
                        class="w-10 h-10 rounded-full object-cover">
                    <div class="flex flex-col ml-2 flex-grow">
                        <div class="flex items-center justify-between">
                            <h4 class="text-lg font-semibold text-gray-900">
                                {{ $ideaThread->title }}
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
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('idea_board.show', $ideaThread)) }}" 
                                        target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fab fa-facebook mr-2"></i>Share on Facebook
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('idea_board.show', $ideaThread)) }}" 
                                        target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fab fa-twitter mr-2"></i>Share on Twitter
                                    </a>
                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('idea_board.show', $ideaThread)) }}" 
                                        target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fab fa-linkedin mr-2"></i>Share on LinkedIn
                                    </a>
                                    <button onclick="navigator.clipboard.writeText('{{ route('idea_board.show', $ideaThread) }}')"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-link mr-2"></i>Copy Link
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="text-sm text-gray-500">
                            <a href="{{ route('profile.public', $ideaThread->organization->url) }}"
                                class="text-blue-500 hover:underline">
                                {{ $ideaThread->organization->org_name }}
                            </a>
                            <span>.</span>
                            <span>{{ ucfirst($ideaThread->status) }}</span>
                            <span>.</span>
                            <span>{{ $ideaThread->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Thread Description -->
                <div class="px-4 py-1" name="idea-details-container">
                    @if ($ideaThread->poll)
                        <p class="text-sm text-gray-600 mb-3">{{ $ideaThread->poll->question }}</p>
                        <form action="{{ route('idea_board.poll_vote', ['poll' => $ideaThread->poll->id]) }}" method="POST">
                            @csrf
                            @foreach ($ideaThread->poll->options as $option)
                                <div class="mb-3">
                                    <button type="submit" name="option_id" value="{{ $option->id }}"
                                        class="w-full relative border {{ $option->hasVotedBy(Auth::id()) ? 'border-blue-500' : 'border-gray-300' }} rounded-md overflow-hidden">
                                        <div class="flex items-center">
                                            <div class="w-full">
                                                <div class="absolute top-0 left-0 h-full bg-gradient-to-r from-blue-100 to-green-100"
                                                    style="width: {{ $option->getPercentage() }}%; z-index: 0; opacity: 0.4">
                                                </div>
                                                @if ($option->hasVotedBy(Auth::id()))
                                                    <div class="absolute top-0 left-0 h-full bg-gradient-to-r from-blue-100 to-green-100"
                                                        style="width: {{ $option->getPercentage() }}%; z-index: 0; opacity: 0.8">
                                                    </div>
                                                @endif
                                                <div class="px-4 py-2 relative z-10 flex justify-between items-center {{ $option->hasVotedBy(Auth::id()) ? 'text-blue-600 font-medium' : '' }}">
                                                    <span>{{ $option->option_text }}</span>
                                                    @if ($ideaThread->poll->hasVotedBy(Auth::id()))
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
                            <span>{{ $ideaThread->poll->getTotalVotes() }} votes</span>
                            @if ($ideaThread->poll->hasVotedBy(Auth::id()))
                                <span class="text-blue-600">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    You voted
                                </span>
                            @endif
                        </div>
                    @else
                        <p class="text-gray-700 leading-relaxed">{{ $ideaThread->description }}</p>
                        @php
                            $votableType = 'thread';
                            $votable = $ideaThread;
                        @endphp
                        <div class="mt-2 flex items-center">
                            <button type="button" 
                                class="new-vote-btn text-gray-500 hover:text-blue-500 {{ $ideaThread->hasVotedBy(Auth::id()) ? 'text-blue-500' : '' }}"
                                data-new-votable-type="{{ $votableType }}" 
                                data-new-votable-id="{{ $ideaThread->id }}"
                                data-new-vote-status="{{ $ideaThread->hasVotedBy(Auth::id()) ? 'true' : 'false' }}">
                                <i class="fas fa-thumbs-up mr-1 new-vote-icon {{ $ideaThread->hasVotedBy(Auth::id()) ? 'text-blue-500' : '' }}"></i>
                            </button>
                            <span class="mx-2 new-vote-count">{{ $ideaThread->getVoteCount() }}</span>
                        </div>

                        <!-- Comment Form -->
                        @auth
                            @if (Auth::user()->volunteer && !$ideaThread->comments->where('volunteer_userid', Auth::id())->count())
                                <div class="mt-4">
                                    <form method="POST" action="{{ route('idea_board.comment', $ideaThread) }}" class="space-y-4">
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

                @if ($ideaThread->status === 'closed' && $ideaThread->winnerComment)
                    <div class="px-4 py-2 bg-green-50 border border-green-200 rounded-lg">
                        <p class="text-sm font-semibold text-green-800">Winner Comment:</p>
                        <p class="mt-1">{{ $ideaThread->winnerComment->comment }}</p>
                        <div class="mt-2 text-xs text-green-600">
                            <span>By: {{ $ideaThread->winnerComment->volunteer->Name }}</span>
                            <span>•</span>
                            <span>{{ $ideaThread->winnerComment->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @endif

                <!-- Comments Section -->
                @if ($comments->isNotEmpty())
                    <div class="mt-4 flex justify-between items-center">
                        <h4 class="text-lg font-semibold">Comments</h4>
                        <div class="flex justify-end">
                            <div class="relative inline-flex rounded-full bg-gray-800 p-0.5 shadow-md">
                                <button type="button"
                                    class="sort-button relative z-10 px-3 py-1 text-xs font-medium transition-all duration-300 ease-in-out rounded-full text-white"
                                    data-sort="recent">
                                    <i class="fas fa-clock mr-1 text-xs"></i>
                                    Most Recent
                                </button>
                                
                                <div class="h-4 w-px bg-gray-600 my-auto mx-0.5"></div>
                                
                                <button type="button"
                                    class="sort-button relative z-10 px-3 py-1 text-xs font-medium transition-all duration-300 ease-in-out rounded-full text-gray-400"
                                    data-sort="likes">
                                    <i class="fas fa-heart mr-1 text-xs"></i>
                                    Most Liked
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="comments-container border border-gray-200 rounded-lg relative" 
                        data-thread-id="{{ $ideaThread->id }}" 
                        style="max-height: 500px; overflow-y: auto; scrollbar-width: thin;">
                        
                        <!-- Loading Animation -->
                        <div class="loading-animation absolute inset-0 bg-white bg-opacity-90 flex items-center justify-center">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
                        </div>

                        <!-- Comments List -->
                        @foreach ($comments as $comment)
                            <div class="p-4 border-b border-gray-100 last:border-b-0 hover:bg-gray-50 transition duration-150 
                                {{ $comment->volunteer_userid === Auth::id() ? 'bg-blue-50' : '' }}">
                                <div class="flex space-x-3">
                                    <img src="{{ $comment->volunteer->getProfilePicturePath() }}" 
                                        alt="{{ $comment->volunteer->Name }}" 
                                        class="w-8 h-8 rounded-full object-cover">
                                    
                                    <div class="flex-1">
                                        <div class="bg-gray-100 rounded-2xl px-4 py-2">
                                            <div class="font-semibold text-sm text-gray-900">
                                                {{ $comment->volunteer->Name }}
                                            </div>
                                            <p class="text-sm text-gray-700">{{ $comment->comment }}</p>
                                        </div>
                                        
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
                                            </div>
                                            @if (Auth::id() === $ideaThread->userid && $ideaThread->status === 'open')
                                                <button type="button"
                                                    class="select-winner-btn text-green-600 hover:text-green-700"
                                                    data-thread-id="{{ $ideaThread->id }}"
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
                @endif
            </div>
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
        document.addEventListener('DOMContentLoaded', function() {
            function showLoading() {
                const loadingAnimation = document.querySelector('.loading-animation');
                if (loadingAnimation) {
                    loadingAnimation.classList.remove('hidden');
                }
            }

            function hideLoading() {
                const loadingAnimation = document.querySelector('.loading-animation');
                if (loadingAnimation) {
                    loadingAnimation.classList.add('hidden');
                }
            }

            function initializeVoteButtons() {
                const newVoteButtons = document.querySelectorAll('.new-vote-btn');
                if (typeof initializeNewVoteButton === 'function') {
                    newVoteButtons.forEach(button => initializeNewVoteButton(button));
                }
            }

            function handleSort(sortType) {
                const threadContainer = document.querySelector('.comments-container');
                const threadId = threadContainer.dataset.threadId;
                showLoading();

                // Update button styles
                document.querySelectorAll('.sort-button').forEach(btn => {
                    btn.classList.remove('text-white');
                    btn.classList.add('text-gray-400');
                });
                const activeButton = document.querySelector(`.sort-button[data-sort="${sortType}"]`);
                activeButton.classList.remove('text-gray-400');
                activeButton.classList.add('text-white');

                fetch(`/idea-board/${threadId}/sort-comments?sort=${sortType}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) throw new Error(data.message);
                        
                        // Clear and reload comments
                        threadContainer.innerHTML = '';
                        data.comments.forEach(comment => {
                            const commentHtml = `
                                <div class="p-4 border-b border-gray-100 last:border-b-0 hover:bg-gray-50 transition duration-150 
                                    {{ !Auth::user()->organization && $comment->volunteer_userid === Auth::id() ? 'bg-blue-50' : '' }}">
                                    <div class="flex space-x-3">
                                        <img src="${comment.volunteer_avatar}" 
                                            alt="${comment.volunteer_name}" 
                                            class="w-8 h-8 rounded-full object-cover">
                                        
                                        <div class="flex-1">
                                            <div class="bg-gray-100 rounded-2xl px-4 py-2">
                                                <div class="font-semibold text-sm text-gray-900">
                                                    ${comment.volunteer_name}
                                                </div>
                                                <p class="text-sm text-gray-700">${comment.comment}</p>
                                            </div>
                                            
                                            <div class="flex items-center space-x-4 mt-1 text-xs text-gray-500">
                                                <span>${comment.created_at}</span>
                                                <div class="flex items-center">
                                                    <button type="button" 
                                                        class="new-vote-btn text-gray-500 hover:text-blue-500 ${comment.has_voted ? 'text-blue-500' : ''}"
                                                        data-new-votable-type="comment" 
                                                        data-new-votable-id="${comment.id}"
                                                        data-new-vote-status="${comment.has_voted}">
                                                        <i class="fas fa-thumbs-up mr-1 new-vote-icon ${comment.has_voted ? 'text-blue-500' : ''}"></i>
                                                    </button>
                                                    <span class="mx-2 new-vote-count">${comment.vote_count}</span>
                                                </div>
                                                ${comment.can_select_winner ? `
                                                    <button type="button"
                                                        class="select-winner-btn text-green-600 hover:text-green-700"
                                                        data-thread-id="${comment.thread_id}"
                                                        data-comment-id="${comment.id}">
                                                        <i class="fas fa-crown mr-1"></i>
                                                        Select as Winner
                                                    </button>
                                                ` : ''}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                            threadContainer.innerHTML += commentHtml;
                        });
                        
                        initializeVoteButtons();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        threadContainer.innerHTML = `
                            <div class="p-4 text-center text-red-500">
                                <p>Error loading comments</p>
                                <p class="text-sm">${error.message}</p>
                            </div>
                        `;
                    })
                    .finally(() => {
                        hideLoading();
                    });
            }

            // Add click handlers to sort buttons
            document.querySelectorAll('.sort-button').forEach(button => {
                button.addEventListener('click', () => handleSort(button.dataset.sort));
            });

            // Initialize vote buttons
            initializeVoteButtons();
            
            // Hide initial loading animation
            setTimeout(hideLoading, 500);
        });
    </script>
    <script src="{{ asset('js/vote_new.js') }}" defer></script>
</x-app-layout>
