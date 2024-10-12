<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Idea Board') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(Auth::user()->organization)
                        <a href="{{ route('idea_board.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Create New Idea Thread
                        </a>
                    @endif

                    <div class="mt-6">
                        @foreach($ideaThreads as $thread)
                            <div class="mb-4 p-4 border rounded">
                                <h3 class="text-lg font-semibold">
                                    <a href="{{ route('idea_board.show', $thread) }}" class="text-blue-600 hover:text-blue-800">
                                        {{ $thread->title }}
                                    </a>
                                </h3>
                                <p class="text-sm text-gray-600">Posted by: {{ $thread->organization->org_name }}</p>
                                <p class="text-sm text-gray-600">Status: {{ ucfirst($thread->status) }}</p>
                                <p class="mt-2">{{ Str::limit($thread->description, 100) }}</p>

                                <!-- voting button -->
                                 @php
                                    $votableType = 'thread';
                                    $votable = $thread;
                                 @endphp
                                <div class="mt-2 flex items-center">
                                    <button type="button" class="vote-button text-gray-500 hover:text-blue-500" data-votable-type="{{ $votableType }}" data-votable-id="{{ $votable->id }}">
                                        <svg class="w-5 h-5 vote-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                    </button>
                                    <span class="mx-2 vote-count">{{ $votable->getVoteCount() }}</span>
                                </div>
                                <!-- sorting -->
                                <div class="mt-2 flex justify-end">
                                    <button class="sort-comments mr-2" data-thread-id="{{ $thread->id }}" data-sort="likes">Most Liked</button>
                                    <button class="sort-comments" data-thread-id="{{ $thread->id }}" data-sort="recent">Most Recent</button>
                                </div>


                                <!-- view more comments -->

                                <div class="mt-4">
                                    <h4 class="text-lg font-semibold mb-2">Comments</h4>
                                    <div class="comments-container" data-thread-id="{{ $thread->id }}" style="max-height: 300px; overflow-y: auto;">
                                        @foreach($thread->comments->take(1) as $comment)
                                            <div class="mb-2 p-2 border rounded">
                                                <p>{{ $comment->comment }}</p>
                                                <p class="text-sm text-gray-600">By: {{ $comment->volunteer->Name }}</p>
                                                @php
                                                    $votableType = 'comment';
                                                    $votable = $comment;
                                                @endphp
                                                <div class="mt-2 flex items-center">
                                                    <button type="button" class="vote-button text-gray-500 hover:text-blue-500" data-votable-type="{{ $votableType }}" data-votable-id="{{ $votable->id }}">
                                                        <svg class="w-5 h-5 vote-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                                    </button>
                                                    <span class="mx-2 vote-count">{{ $votable->getVoteCount() }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @if($thread->comments->count() > 1)
                                        <button class="view-more-comments mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm" data-thread-id="{{ $thread->id }}" data-offset="1">
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
                                                    <p>{{ Str::limit($userComment->comment, 100) }}
                                                    @if (strlen($userComment->comment) > 100)
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
                            </div>
                        @endforeach
                    </div>

                    {{ $ideaThreads->appends(['sort' => request('sort', 'likes')])->links() }}
                </div>
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

    function loadMoreComments() {
        const threadId = this.dataset.threadId;
        const offset = parseInt(this.dataset.offset);
        const commentsContainer = document.querySelector(`.comments-container[data-thread-id="${threadId}"]`);

        fetch(`/idea-board/${threadId}/comments?offset=${offset}`)
            .then(response => response.json())
            .then(data => {
                if (data.comments.length > 0) {
                    const commentElement = createCommentElement(data.comments[0]);
                    commentsContainer.appendChild(commentElement);

                    this.dataset.offset = offset + 1;
                    commentsContainer.scrollTop = commentsContainer.scrollHeight;
                }

                if (data.comments.length < 1) {
                    this.style.display = 'none';
                }
            });
    }

    function sortComments() {
        const threadId = this.dataset.threadId;
        const sort = this.dataset.sort;
        const commentsContainer = document.querySelector(`.comments-container[data-thread-id="${threadId}"]`);
        const viewMoreButton = commentsContainer.nextElementSibling;

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
                    viewMoreButton.dataset.offset = '1';
                    viewMoreButton.style.display = 'inline-block';
                }
            });
    }

    function createCommentElement(comment) {
        const div = document.createElement('div');
        div.className = 'mb-2 p-2 border rounded';
        div.innerHTML = `
            <p>${comment.comment}</p>
            <p class="text-sm text-gray-600">By: ${comment.volunteer_name}</p>
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
</script>