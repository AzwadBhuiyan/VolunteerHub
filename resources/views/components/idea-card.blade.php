<div class="rounded-xl mb-4 overflow-hidden flex flex-col shadow border border-gray-200 p-4">
    <!-- Thread Header -->
    <div class="flex items-center space-x-4 border-b border-gray-100 pb-2">
        <img src="{{ asset($idea->organization->getLogoPath()) }}"
            alt="{{ $idea->organization->org_name }}"
            class="w-12 h-12 rounded-full object-cover">
        <div class="flex flex-col ml-2 flex-grow">
            <div class="flex items-center justify-between">
                <h4 class="text-lg font-semibold">
                    <a href="{{ route('idea_board.show', $idea) }}"
                        class="text-gray-900 hover:text-gray-700">
                        {{ $idea->title }}
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
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('idea_board.show', $idea)) }}" 
                            target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fab fa-facebook mr-2"></i>Share on Facebook
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('idea_board.show', $idea)) }}" 
                            target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fab fa-twitter mr-2"></i>Share on Twitter
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('idea_board.show', $idea)) }}" 
                            target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fab fa-linkedin mr-2"></i>Share on LinkedIn
                        </a>
                        <button onclick="navigator.clipboard.writeText('{{ route('idea_board.show', $idea) }}')"
                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-link mr-2"></i>Copy Link
                        </button>
                    </div>
                </div>
            </div>
            <div class="text-sm text-gray-500">
                <a href="{{ route('profile.public', $idea->organization->url) }}"
                    class="text-blue-500 hover:underline">
                    {{ $idea->organization->org_name }}
                </a>
                <span>.</span>
                <span>{{ ucfirst($idea->status) }}</span>
                <span>.</span>
                <span>{{ $idea->created_at->diffForHumans() }}</span>
            </div>
        </div>
    </div>

    <!-- Thread Content -->
    <div class="px-4 py-1">
        @if ($idea->poll)
            <div class="bg-white p-4 rounded-lg border border-gray-200">
                <p class="text-sm text-gray-600 mb-3">{{ $idea->poll->question }}</p>
                <form action="{{ route('idea_board.poll_vote', ['poll' => $idea->poll->id]) }}" method="POST">
                    @csrf
                    @foreach($idea->poll->options as $option)
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
                                            @if ($idea->poll->hasVotedBy(Auth::id()))
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
                    <span>{{ $idea->poll->getTotalVotes() }} votes</span>
                    @if ($idea->poll->hasVotedBy(Auth::id()))
                        <span class="text-blue-600">
                            <i class="fas fa-check-circle mr-1"></i>
                            You voted
                        </span>
                    @endif
                </div>
            </div>
        @else
            <div>
                <p class="text-gray-700 leading-relaxed">{{ Str::limit($idea->description, 150) }}</p>
                
                @if (!$idea->poll)
                    @php
                        $votableType = 'thread';
                        $votable = $idea;
                    @endphp
                    <div class="mt-2 flex items-center">
                        <button type="button" class="vote-button text-gray-500 hover:text-blue-500" 
                            data-votable-type="{{ $votableType }}" data-votable-id="{{ $votable->id }}">
                            <svg class="w-5 h-5 vote-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" 
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                            </svg>
                        </button>
                        <span class="mx-2 vote-count">{{ $votable->getVoteCount() }}</span>
                    </div>
                @endif

                <!-- Comments Section -->
                <div class="mt-4 flex justify-between items-center">
                    <h4 class="text-lg font-semibold">Comments</h4>
                    <div class="flex justify-end" x-data="{ activeSort: 'recent' }">
                        <div class="relative inline-flex rounded-full bg-gray-800 p-0.5 shadow-md" style="width: fit-content;">
                            <button
                                @click="activeSort = 'recent'"
                                class="sort-comments relative z-10 px-3 py-1 text-xs font-medium transition-all duration-300 ease-in-out rounded-full"
                                :class="activeSort === 'recent' ? 'text-white transform scale-105' : 'text-gray-400 hover:text-gray-200'"
                                data-thread-id="{{ $idea->id }}" 
                                data-sort="recent">
                                <i class="fas fa-clock mr-1 text-xs"></i>
                                Most Recent
                            </button>
                            
                            <div class="h-4 w-px bg-gray-600 my-auto mx-0.5"></div>
                            
                            <button
                                @click="activeSort = 'likes'"
                                class="sort-comments relative z-10 px-3 py-1 text-xs font-medium transition-all duration-300 ease-in-out rounded-full"
                                :class="activeSort === 'likes' ? 'text-white transform scale-105' : 'text-gray-400 hover:text-gray-200'"
                                data-thread-id="{{ $idea->id }}" 
                                data-sort="likes">
                                <i class="fas fa-thumbs-up mr-1 text-xs"></i>
                                Most Liked
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="comments-container" data-thread-id="{{ $idea->id }}">
                    @foreach($idea->comments->take(5) as $comment)
                        <div class="mb-2 p-2 border rounded {{ $comment->is_winner ? 'bg-green-50' : '' }}">
                            <p>{{ $comment->comment }}</p>
                            <div class="flex justify-between items-center">
                                <div class="text-xs text-gray-400">
                                    <span>By: </span>
                                    <span class="text-gray-500">{{ $comment->volunteer->Name }}</span>
                                    <span class="mx-1">•</span>
                                    <span>{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                @if($idea->userid === Auth::id() && $idea->status !== 'closed')
                                    <button type="button"
                                        class="select-winner-btn bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm"
                                        data-thread-id="{{ $idea->id }}"
                                        data-comment-id="{{ $comment->id }}">
                                        Select as Winner
                                    </button>
                                @endif
                            </div>
                            <div class="mt-2 flex items-center">
                                <button type="button" class="vote-button text-gray-500 hover:text-blue-500" 
                                    data-votable-type="comment" data-votable-id="{{ $comment->id }}">
                                    <svg class="w-5 h-5 vote-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" 
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                    </svg>
                                </button>
                                <span class="mx-2 vote-count">{{ $comment->getVoteCount() }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($idea->comments->count() > 5)
                    <button type="button"
                        class="view-more-comments text-sm text-blue-500 hover:text-blue-700 mt-2"
                        data-thread-id="{{ $idea->id }}"
                        data-offset="5">
                        View More Comments
                    </button>
                @endif
            </div>
        @endif
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function createCommentElement(comment) {
        const div = document.createElement('div');
        div.className = 'mb-2 p-2 border rounded';
        div.innerHTML = `
            <p>${comment.comment}</p>
            <div class="flex justify-between items-center">
                <div class="text-xs text-gray-400">
                    <span>By: </span>
                    <span class="text-gray-500">${comment.volunteer_name}</span>
                    <span class="mx-1">•</span>
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

    const buttons = document.querySelectorAll('.sort-comments');
    
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const threadId = this.dataset.threadId;
            const sort = this.dataset.sort;
            const commentsContainer = document.querySelector(
                `.comments-container[data-thread-id="${threadId}"]`);
            const viewMoreButton = commentsContainer.nextElementSibling;

            // Update button styles
            const sortButtons = document.querySelectorAll(`.sort-comments[data-thread-id="${threadId}"]`);
            sortButtons.forEach(btn => {
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
        });
    });
});
</script>
</div>