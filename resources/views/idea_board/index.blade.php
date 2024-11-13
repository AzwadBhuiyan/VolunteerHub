<x-app-layout>
    <link href="{{ asset('css/volunteer-profile.css') }}" rel="stylesheet">

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 min-h-screen">
        <!-- Centered container with responsive padding and vertical spacing -->
        <div class="p-1 sm:p-8 bg-white shadow sm:rounded-lg">
            <!-- Profile information card with padding, background color, shadow, and rounded corners -->

            {{-- <div class="py-12">
          <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg"> --}}
            {{-- <div class="p-6 bg-white border-b border-gray-200"> --}}
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

                    <a href="{{ route('idea_board.create') }}"
                        class="mt-4 text-white bg-gradient-to-br from-green-400 to-blue-600 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2">
                        <i class="fas fa-list"></i> My Ideas
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
                            <div class="px-4 py-1">
                                @if ($thread->poll)
                                    <div class="bg-white p-4 rounded-lg border border-gray-200">
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
                                    </div>
                                @else
                                    <p class="text-gray-700 leading-relaxed">
                                        {{ Str::limit($thread->description, 150) }}</p>
                                @endif
                            </div>
                            <!-- upvote buttone for thread -->
                            @php
                                $votableType = 'thread';
                                $votable = $thread;
                            @endphp
                            <div class="mt-2 flex items-center">
                                <button type="button" class="vote-button text-gray-500 hover:text-blue-500"
                                    data-votable-type="{{ $votableType }}" data-votable-id="{{ $thread->id }}">
                                    <svg class="w-5 h-5 vote-icon" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 15l7-7 7 7"></path>
                                    </svg>
                                </button>
                                <span class="mx-2 vote-count">{{ $thread->getVoteCount() }}</span>
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
                                <div class=" flex justify-end" x-data="{ activeSort: '{{ $sort }}' }">
                                    <div class="relative inline-flex rounded-full bg-gray-800 p-0.5 shadow-md" style="width: fit-content;">
                                        <button
                                            @click="activeSort = 'recent'"
                                            class="sort-comments relative z-10 px-3 py-1 text-xs font-medium transition-all duration-300 ease-in-out rounded-full"
                                            :class="activeSort === 'recent' ? 'text-white transform scale-105' : 'text-gray-400 hover:text-gray-200'"
                                            data-thread-id="{{ $thread->id }}" 
                                            data-sort="recent">
                                            <i class="fas fa-clock mr-1 text-xs"></i>
                                            Recent
                                        </button>
                                        
                                        <div class="h-4 w-px bg-gray-600 my-auto mx-0.5"></div>
                                        
                                        <button
                                            @click="activeSort = 'likes'"
                                            class="sort-comments relative z-10 px-3 py-1 text-xs font-medium transition-all duration-300 ease-in-out rounded-full"
                                            :class="activeSort === 'likes' ? 'text-white transform scale-105' : 'text-gray-400 hover:text-gray-200'"
                                            data-thread-id="{{ $thread->id }}" 
                                            data-sort="likes">
                                            <i class="fas fa-heart mr-1 text-xs"></i>
                                            Likes
                                        </button>
                                        
                                        <div 
                                            class="absolute inset-y-0 w-[45%] rounded-full shadow-md transition-all duration-300 ease-in-out"
                                            :class="{'translate-x-0': activeSort === 'recent', 'translate-x-[120%]': activeSort === 'likes'}"
                                            :style="{ 
                                                'background': 'linear-gradient(135deg, #3B82F6 0%, #10B981 50%, #3B82F6 100%)',
                                                'z-index': '1'
                                            }">
                                        </div>
                                    </div>
                                </div>
                            </div>

                                <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const buttons = document.querySelectorAll('.sort-comments');
                                    
                                    buttons.forEach(button => {
                                        button.addEventListener('click', function() {
                                            // Remove active class from all buttons
                                            buttons.forEach(btn => {
                                                btn.classList.remove('text-white', 'scale-105');
                                                btn.classList.add('text-gray-400');
                                            });
                                            
                                            // Add active class to clicked button with animation
                                            this.classList.remove('text-gray-400');
                                            this.classList.add('text-white');
                                            
                                            // Add subtle pop animation
                                            this.style.transform = 'scale(1.05)';
                                            setTimeout(() => {
                                                this.style.transform = 'scale(1)';
                                            }, 200);
                                        });
                                    });
                                });
                                </script>


                                <!-- view more comments -->

                                <div class="mt-4">
                                    <div class="comments-container border border-gray-200 rounded-lg" data-thread-id="{{ $thread->id }}"
                                        style="max-height: 300px; overflow-y: auto; scrollbar-width: thin;">
                                        @foreach ($thread->comments->take(5) as $comment)
                                            <div class="p-3 border-b border-gray-100 last:border-b-0 hover:bg-gray-50 transition duration-150">
                                                <p class="text-gray-800">{{ $comment->comment }}</p>
                                                <div class="flex justify-between items-center mt-2">
                                                    <div class="text-sm text-gray-600">
                                                        <span class="font-medium">{{ $comment->volunteer->Name }}</span>
                                                        <span class="mx-1">•</span>
                                                        <span>{{ $comment->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    @if (Auth::id() === $thread->userid && $thread->status === 'open')
                                                        <button type="button"
                                                            class="select-winner-btn bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-full text-sm transition duration-150"
                                                            data-thread-id="{{ $thread->id }}"
                                                            data-comment-id="{{ $comment->id }}">
                                                            Select as Winner
                                                        </button>
                                                    @endif
                                                </div>
                                                <div class="mt-2 flex items-center">
                                                    <button type="button"
                                                        class="vote-button text-gray-500 hover:text-blue-500 transition duration-150"
                                                        data-votable-type="comment"
                                                        data-votable-id="{{ $comment->id }}">
                                                        <svg class="w-5 h-5 vote-icon" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 15l7-7 7 7"></path>
                                                        </svg>
                                                    </button>
                                                    <span class="mx-2 vote-count">{{ $comment->getVoteCount() }}</span>
                                                </div>
                                                @if (Auth::user()->is_admin)
                                                    <form action="{{ route('admin.comments.delete', $comment) }}" 
                                                        method="POST" 
                                                        class="inline-block ml-2"
                                                        onsubmit="return confirm('Are you sure you want to delete this comment?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                    @if ($thread->comments->count() > 1)
                                        <div class="text-center mt-2">
                                            <button
                                                class="view-more-comments inline-flex items-center text-blue-600 hover:text-blue-800 text-sm font-medium transition duration-150"
                                                data-thread-id="{{ $thread->id }}" data-offset="5">
                                                <span>View more comments</span>
                                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    @endif
                                </div>

                                @if ($thread->comments->isNotEmpty())
                                    @auth
                                        @if (Auth::user()->volunteer)
                                            @php
                                                $authUserId = Auth::id();
                                                $userComment = $thread->comments
                                                    ->where('volunteer_userid', $authUserId)
                                                    ->first();
                                            @endphp

                                            @if (!$userComment)
                                                <form method="POST" action="{{ route('idea_board.comment', $thread) }}"
                                                    class="mt-4">
                                                    @csrf
                                                    <div class="mb-4">
                                                        <label for="comment"
                                                            class="block text-gray-700 text-sm font-bold mb-2">Your
                                                            Comment:</label>
                                                        <textarea name="comment" id="comment" rows="3"
                                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                            required maxlength="200"></textarea>
                                                    </div>
                                                    <div class="flex items-center justify-end mt-4">
                                                        <p class="text-yellow-600">You can only comment once, so prepare
                                                            your comment well.</p>
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
                                                            <a href="#"
                                                                class="text-blue-500 hover:underline view-full-description"
                                                                data-full-description="{{ $userComment->comment }}">View
                                                                full</a>
                                                        @endif
                                                    </p>
                                                    <p class="text-xs text-gray-500">By:
                                                        {{ $userComment->volunteer->Name }}</p>
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
                                    @if (Auth::user()->volunteer)
                                        @if ($thread->comments->where('volunteer_userid', Auth::id())->count() > 0)
                                            <p class="text-yellow-600">You have already commented on this idea.</p>
                                        @endif
                                    @endif
                                @endauth
                            @endif


                            <!-- Priority Score -->
                            <!-- {{-- <div class="px-4 py-2 bg-gray-100">
                                <p class="text-sm text-gray-600">Priority Score: {{ $thread->priority_score }}</p>
                            </div> --}} -->


                        </div>
                    @endforeach

                    {{ $ideaThreads->appends(['sort' => request('sort', 'likes')])->links() }}
                </div>

                {{ $ideaThreads->links() }}
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
            const commentsContainer = document.querySelector(
                `.comments-container[data-thread-id="${threadId}"]`);

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
            const commentsContainer = document.querySelector(
                `.comments-container[data-thread-id="${threadId}"]`);
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
            const likeText = this.querySelector('span');
            const countContainer = this.closest('.text-xs').querySelector('.flex.items-center');

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
                    // Toggle like text color
                    likeText.classList.toggle('text-blue-600', data.voted);
                    
                    // Update or create like count
                    if (data.newVoteCount > 0) {
                        if (!countContainer) {
                            const newCount = document.createElement('div');
                            newCount.className = 'flex items-center';
                            newCount.innerHTML = `
                                <span class="inline-flex items-center justify-center bg-blue-500 rounded-full w-4 h-4">
                                    <i class="fas fa-thumbs-up text-[10px] text-white"></i>
                                </span>
                                <span class="ml-1">${data.newVoteCount}</span>
                            `;
                            this.closest('.text-xs').appendChild(newCount);
                        } else {
                            countContainer.querySelector('span:last-child').textContent = data.newVoteCount;
                        }
                    } else if (countContainer) {
                        countContainer.remove();
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
