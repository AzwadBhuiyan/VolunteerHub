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
                            </div>
                        @endforeach
                    </div>

                    {{ $ideaThreads->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>