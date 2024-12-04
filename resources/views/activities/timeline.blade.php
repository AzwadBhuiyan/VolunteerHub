<x-app-layout>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 min-h-screen">
        <div
            class="w-full p-5 mx-auto shadow-lg flex flex-col items-center justify-center bg-gray-800 text-white">
            <i class="fas fa-history text-lg text-green-500 animate-spin-slow"></i>

            <h2
                class="bg-gradient-to-r from-blue-600 via-green-500 to-blue-500 inline-block text-transparent bg-clip-text text-lg font-bold mt-2 mb-2">
                Project Timeline
            </h2>
            <p class="text-sm text-gray-300 mb-4">Follow the journey and track key milestones</p>

            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center justify-center px-6 py-2.5 border border-gray-300 text-sm font-medium text-gray-200 bg-gray-700 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200 shadow hover:shadow-md">
                <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
            </a>
        </div>
        <!-- Centered container with responsive padding and vertical spacing -->
        <div class="p-1 sm:p-8 bg-white shadow sm:rounded-lg">


            {{-- <div class="py-12"> --}}
            {{-- <div class="max-w-4xl mx-auto sm:px-6 lg:px-8"> --}}
            {{-- <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg"> --}}
            <div class="p-1">
                {{-- <h3 class="text-base mb-2">{{ $activity->title }}</h3> --}}

                <x-activity-timeline :activity="$activity" :isOrganizer="Auth::id() === $activity->userid" />
            </div>
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- </div> --}}
        </div>
    </div>
</x-app-layout>
