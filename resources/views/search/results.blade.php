<x-app-layout>

    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 min-h-screen mt-24">
        <div class="p-1 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-4">
                <h2 class="text-xl font-semibold mb-4 text-left">Search Results for "{{ $query }}"</h2>

                @foreach($results as $result)
                    @if($category === 'activities')
                        <x-activity-card :activity="$result" />
                    @elseif($category === 'ideas')
                        <x-idea-card :idea="$result" :category="$category" />
                    @else
                        <x-search-result-card :user="$result" :category="$category" />
                    @endif
                @endforeach
            </div>

            <div class="flex justify-center my-2">
                <div id="loading-spinner" class="hidden">
                    <svg class="animate-spin h-8 w-8 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('js/search.js') }}"></script>
    @endpush
</x-app-layout>

