<x-app-layout>

    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <div class="bg-gray-800 py-1 px-3">
        <form action="{{ route('search') }}" method="GET" class="max-w-lg mx-auto my-4">
            <input type="hidden" name="category" id="selected-category" value="" required>
            <div class="flex">
                
                <div class="dropdown">
                    <button id="dropdown-button" data-dropdown-toggle="dropdown" 
                            class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-s-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100"
                            type="button">
                        <span id="selected-category-text">Categories</span>
                        <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg>
                    </button>
                    
                    <div id="dropdown"
                        class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                            aria-labelledby="dropdown-button">
                            <li>
                                <button type="button" data-category="organizations"
                                    class="category-btn inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                    Organizations
                                </button>
                            </li>
                            <li>
                                <button type="button" data-category="volunteers"
                                    class="category-btn inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                    Volunteers
                                </button>
                            </li>
                            <li>
                                <button type="button" data-category="activities"
                                    class="category-btn inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                    Activities
                                </button>
                            </li>
                            <li>
                                <button type="button" data-category="ideas"
                                    class="category-btn inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                    Ideas
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="relative w-full">
                    <input type="search" id="search-dropdown"
                        name="query"
                        class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-e-lg border-s-gray-50 border-s-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-s-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
                        placeholder="Search" required />
                    <button type="submit"
                        class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-white bg-blue-700 rounded-e-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                        <span class="sr-only">Search</span>
                    </button>
                </div>
            </div>
        </form>
        <!-- error msg for search -->
        @if(session('error'))
            <div class="max-w-lg mx-auto mt-2 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

    </div>
    {{-- <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 min-h-screen">
        
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg"> --}}

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 min-h-screen">
                <!-- Centered container with responsive padding and vertical spacing -->
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


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchForm = document.querySelector('form');
        const categoryInput = document.getElementById('selected-category');
        const selectedCategoryText = document.getElementById('selected-category-text');
        
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const selectedCategory = categoryInput.value;
            if (!selectedCategory || selectedCategory === '') {
                // Remove any existing error message
                const existingError = document.querySelector('.search-error');
                if (existingError) existingError.remove();
                
                // Create and insert error message
                const errorDiv = document.createElement('div');
                errorDiv.className = 'search-error max-w-lg mx-auto mt-2 p-3 bg-red-100 border border-red-400 text-red-700 rounded';
                errorDiv.textContent = 'Please select a category before searching';
                searchForm.insertAdjacentElement('afterend', errorDiv);
                
                // Remove error message after 3 seconds
                setTimeout(() => {
                    errorDiv.remove();
                }, 3000);
                
                return;
            }
            
            this.submit();
        });
    
        const categoryButtons = document.querySelectorAll('.category-btn');
        categoryButtons.forEach(button => {
            button.addEventListener('click', function() {
                const category = this.getAttribute('data-category');
                categoryInput.value = category;
                selectedCategoryText.textContent = this.textContent.trim();
            });
        });
    });
    </script>
    