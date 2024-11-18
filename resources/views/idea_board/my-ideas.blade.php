<x-app-layout>
    <link href="{{ asset('css/volunteer-profile.css') }}" rel="stylesheet">

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 min-h-screen">
        <div class="p-1 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="w-full p-5 mx-auto shadow-lg mb-4 flex flex-col items-center justify-center bg-gray-800 text-white">
                <i class="fas fa-list text-lg text-yellow-500"></i>

                @if (Auth::user()->organization)
                    <h2 class="bg-gradient-to-r from-blue-600 via-green-500 to-blue-500 inline-block text-transparent bg-clip-text text-lg font-bold mt-2 mb-2">
                        My Created Ideas
                    </h2>
                    <p class="text-base text-center">Track and manage all the ideas you've shared with the community.</p>
                @else
                    <h2 class="bg-gradient-to-r from-blue-600 via-green-500 to-blue-500 inline-block text-transparent bg-clip-text text-lg font-bold mt-2 mb-2">
                        My Engaged Ideas
                    </h2>
                    <p class="text-base text-center">View all the ideas you've interacted with through comments and votes.</p>
                @endif

                <a href="{{ route('idea_board.index') }}"
                    class="mt-4 text-white bg-gradient-to-br from-green-400 to-blue-600 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2">
                    <i class="fas fa-arrow-left"></i> Back to All Ideas
                </a>
            </div>

            <div class="mt-6">
                @foreach ($ideaThreads as $idea)
                    <x-idea-card :idea="$idea" />
                @endforeach

                {{ $ideaThreads->links() }}
            </div>
        </div>
    </div>
</x-app-layout>