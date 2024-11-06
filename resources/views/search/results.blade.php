<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-semibold mb-4">Search Results for "{{ $query }}"</h2>
                
                <div class="mb-6">
                    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-4">
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
                </div>

                <div class="flex justify-center my-4">
                    <div id="loading-spinner" class="hidden">
                        <svg class="animate-spin h-8 w-8 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('js/search.js') }}"></script>
    @endpush
</x-app-layout>