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




                                @if($thread->comments->isNotEmpty())
                                    @php
                                        $lastComment = $thread->comments->sortByDesc('created_at')->first();
                                    @endphp
                                    <div class="mt-2 p-2 bg-gray-100 rounded">
                                        <p class="text-sm"><strong>Latest Comment:</strong> </p>
                                        <p>{{ Str::limit($lastComment->comment, 100) }}</p>
                                        <p class="text-xs text-gray-500">By: {{ $lastComment->volunteer->Name }}</p>
                                    </div>
                                    @auth
                                        @if(Auth::user()->volunteer)
                                            @php
                                                $authUserId = Auth::id();
                                                $userComment = $thread->comments->where('volunteer_userid', $authUserId)->first();
                                            @endphp
                                            @if($userComment)
                                                <div class="mt-2 p-2 bg-blue-100 rounded">
                                                    <p class="text-sm"><strong>Your Comment:</strong></p>
                                                    <p>{{ Str::limit($userComment->comment, 100) }}</p>
                                                </div>
                                            @endif
                                        @endif
                                    @endauth
                                @endif

                                <a href="{{ route('idea_board.show', $thread) }}#comment-section" class="mt-2 inline-block bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-sm">
                                    View All Comments
                                </a>

                                <!-- Comment Form -->
                                @auth
                                    @if(Auth::user()->volunteer)
                                        <form method="POST" action="{{ route('idea_board.comment', $thread) }}" class="mt-4">
                                            @csrf
                                            <div class="mb-4">
                                                <label for="comment" class="block text-gray-700 text-sm font-bold mb-2">Your Comment:</label>
                                                <textarea name="comment" id="comment" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required maxlength="200"></textarea>
                                            </div>
                                            <div class="flex items-center justify-end mt-4">
                                            @if($thread->comments->where('volunteer_userid', Auth::id())->count()>0)
                                                <p class="text-yellow-600">You have already commented on this idea.</p>
                                            @else
                                                <p class="text-yellow-600">You can only comment once, so prepare your comment well.</p>
                                            @endif
                                                <x-primary-button class="ml-4">
                                                    {{ __('Submit Comment') }}
                                                </x-primary-button>
                                            </div>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        @endforeach
                    </div>

                    {{ $ideaThreads->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>