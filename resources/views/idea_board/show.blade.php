<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $ideaThread->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-2">{{ $ideaThread->title }}</h3>
                    <p class="text-sm text-gray-600">Posted by: {{ $ideaThread->organization->org_name }}</p>
                    <p class="text-sm text-gray-600">Status: {{ ucfirst($ideaThread->status) }}</p>
                    <p class="mt-4">{{ $ideaThread->description }}</p>

                    <div class="mt-6">
                        <h4 class="text-lg font-semibold mb-2">Comments</h4>
                        @foreach($ideaThread->comments as $comment)
                            <div class="mb-4 p-4 border rounded {{ $comment->is_winner ? 'bg-green-100' : '' }}">
                                <p>{{ $comment->comment }}</p>
                                <p class="text-sm text-gray-600">By: {{ $comment->volunteer->Name }}</p>
                                @if($comment->is_winner)
                                    <p class="text-sm font-semibold text-green-600">Winner</p>
                                @elseif(Auth::id() === $ideaThread->userid && $ideaThread->status === 'open')
                                    <form method="POST" action="{{ route('idea_board.select_winner', [$ideaThread, $comment]) }}">
                                        @csrf
                                        <button type="submit" class="text-sm text-blue-600 hover:text-blue-800">Select as Winner</button>
                                    </form>
                                @endif
                            </div>
                        @endforeach

                        @if(Auth::user()->volunteer && $ideaThread->status === 'open' && !$ideaThread->comments->where('volunteer_userid', Auth::id())->count())
                            <form method="POST" action="{{ route('idea_board.comment', $ideaThread) }}" class="mt-4">
                                @csrf
                                <div class="mb-4">
                                    <label for="comment" class="block text-gray-700 text-sm font-bold mb-2">Your Comment:</label>
                                    <textarea name="comment" id="comment" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required maxlength="200"></textarea>
                                </div>
                                <div class="flex items-center justify-end mt-4">
                                    <x-primary-button class="ml-4">
                                        {{ __('Submit Comment') }}
                                    </x-primary-button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>