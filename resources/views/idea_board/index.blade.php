<x-app-layout>
    <div class="max-w-7xl mx-auto px-1 sm:px-6 lg:px-8">
        <!-- Centered container with responsive padding and vertical spacing -->
        <div class="p-4 sm:p-8 bg-white items-center shadow sm:rounded-lg">
            <!-- Profile information card with padding, background color, shadow, and rounded corners -->

            {{-- <div class="py-12">
          <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg"> --}}
            <div class="p-6 bg-white border-b border-gray-200">
                @if (Auth::user()->organization)
                    <a href="{{ route('idea_board.create') }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Create New Idea Thread
                    </a>
                @endif

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
                                    </div>
                                </div>
                            </div>

                            <!-- Thread Description -->
                            <div class="px-4 py-1">
                                <p class="text-gray-700 leading-relaxed">{{ Str::limit($thread->description, 150) }}</p>
                            </div>

                            <!-- Thread Footer (Comments Section) -->
                            @if ($thread->comments->isNotEmpty())
                                @php
                                    $lastComment = $thread->comments->sortByDesc('created_at')->first();
                                @endphp
                                <div class="px-4 py-2 bg-gray-50">
                                    <p class="text-sm"><strong>Latest Comment:</strong></p>
                                    <p>{{ Str::limit($lastComment->comment, 100) }}</p>
                                    <p class="text-xs text-gray-500">By: {{ $lastComment->volunteer->Name }}</p>
                                </div>

                                @auth
                                    @if (Auth::user()->volunteer)
                                        @php
                                            $authUserId = Auth::id();
                                            $userComment = $thread->comments
                                                ->where('volunteer_userid', $authUserId)
                                                ->first();
                                        @endphp
                                        @if ($userComment)
                                            <div class="mt-2 p-2 bg-blue-100 rounded">
                                                <p class="text-sm"><strong>Your Comment:</strong></p>
                                                <p>{{ Str::limit($userComment->comment, 100) }}</p>
                                            </div>
                                        @endif
                                    @endif
                                @endauth
                            @endif

                            <!-- View All Comments -->
                            <a href="{{ route('idea_board.show', $thread) }}#comment-section"
                                class="mt-2 inline-block bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-sm">
                                View All Comments
                            </a>

                            <!-- Comment Form -->
                            @auth
                                @if (Auth::user()->volunteer)
                                    <form method="POST" action="{{ route('idea_board.comment', $thread) }}"
                                        class="mt-4">
                                        @csrf
                                        <div class="mb-4">
                                            <label for="comment" class="block text-gray-700 text-sm font-bold mb-2">Your
                                                Comment:</label>
                                            <textarea name="comment" id="comment" rows="3"
                                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                required maxlength="200"></textarea>
                                        </div>
                                        <div class="flex items-center justify-end mt-4">
                                            @if ($thread->comments->where('volunteer_userid', Auth::id())->count() > 0)
                                                <p class="text-yellow-600">You have already commented on this idea.</p>
                                            @else
                                                <p class="text-yellow-600">You can only comment once, so prepare your
                                                    comment well.</p>
                                            @endif
                                            <x-primary-button class="ml-4">
                                                {{ __('Submit Comment') }}
                                            </x-primary-button>
                                        </div>
                                    </form>
                                @endif
                            @endauth

                            <!-- Priority Score -->
                            {{-- <div class="px-4 py-2 bg-gray-100">
                                <p class="text-sm text-gray-600">Priority Score: {{ $thread->priority_score }}</p>
                            </div> --}}
                        </div>
                    @endforeach

                </div>

                {{ $ideaThreads->links() }}
            </div>
        </div>
    </div>

</x-app-layout>
