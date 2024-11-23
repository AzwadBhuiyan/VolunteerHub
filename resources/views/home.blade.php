<x-app-layout>

    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>


    <div class="max-w-full overflow-x-hidden mt-20">
        {{-- @include('search.search-bar') --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <!-- Centered container with responsive padding and vertical spacing -->
           


            <!-- Main Content -->
            <main class="bg-white shadow-md p-1">
                {{-- <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"> --}}
                <!-- Search Bar -->
                {{-- <div class="my-4">
                    <input type="text" placeholder="Search..."
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div> --}}
               


                <!-- Welcome Message -->
                <div class="text-white px-5 py-10 rounded-lg shadow-lg mb-4 animate-gradient">
                    <h1 class="text-4xl font-bold mb-3 italic">Welcome to {{ config('app.name', 'Laravel') }}</h1>
                    <p class="text-base">Join our community and make a difference! Connect with opportunities to volunteer, support events, and share your skills. Let's create a better world together!</p>
                </div>

                <!-- admin dashboard -->
                @if(Auth::check() && Auth::user()->role === 'admin')
                    <div class="mt-4 flex justify-center">
                        <a href="{{ route('admin.dashboard') }}" 
                        class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                            </svg>
                            Admin Dashboard
                        </a>
                    </div>
                @endif

                <style>
                    @keyframes gradient {
                        0% {
                            background-position: 0% 50%;
                        }
                        50% {
                            background-position: 100% 50%;
                        }
                        100% {
                            background-position: 0% 50%;
                        }
                    }
                    .animate-gradient {
                        background: linear-gradient(to right, #10b981, #3b82f6, #10b981);
                        background-size: 200% 200%;
                        animation: gradient 6s linear infinite;
                    }
                </style>

                <!-- Stats -->
                <!-- Total Hours -->
                <div class="stat-item flex-1 text-center p-6 relative flex flex-col items-center">
                    <h1 class="text-6xl font-extrabold italic mb-1 bg-gradient-to-r from-blue-600 via-green-500 to-blue-500 text-transparent bg-clip-text">
                        <span id="totalHours" data-target="{{ $totalHours }}">0</span>
                    </h1>
                    <h2 class="text-2xl font-bold mt-auto italic ">Hours of Volunteer Work</h2>
                </div>
                <div class="flex justify-center gap-3 mb-4 relative mx-auto" style="max-width: 50vw;">
                    @php
                        $totalHours = \App\Models\Activity::where('status', 'completed')->sum('duration');
                        $totalVolunteers = \App\Models\Volunteer::whereHas('user', function ($query) {
                            $query->where('verified', true);
                        })->count();
                        $totalCompletedActivities = \App\Models\Activity::where('status', 'completed')->count();
                    @endphp

                    <!-- Total volunteers -->
                    <div class="stat-item flex-1 text-center p-6 relative flex flex-col items-center">
                        <h2 class="text-4xl font-bold mb-1 text-center bg-gradient-to-r from-green-500 to-blue-600 text-transparent bg-clip-text">
                            <span id="totalVolunteers"
                                data-target="{{ $totalVolunteers }}">{{ $totalVolunteers }}</span>
                        </h2>
                        <h3 class="text-sm font-bold mt-auto text-center">Active Volunteers</h3>
                    </div>

                    <!-- Registered organizations -->
                    <div
                        class="stat-item flex-1 text-center p-6 relative flex flex-col items-center border-l border-gray-300">
                        <h2 class="text-4xl font-bold mb-1 text-center bg-gradient-to-r from-green-500 to-green-700 text-transparent bg-clip-text">
                            <span id="totalVolunteers"
                                data-target="{{ $totalOrganizations }}">{{ $totalOrganizations }}</span>
                        </h2>
                        <h3 class="text-sm font-bold mt-auto text-center">Active Organizations</h3>
                    </div>

                    <!-- Completed Activities -->
                    <div
                        class="stat-item flex-1 text-center p-6 relative flex flex-col items-center border-l border-gray-300">
                        <h2 class="text-4xl font-bold mb-1 text-center bg-gradient-to-r from-blue-600 via-green-500 to-blue-500 text-transparent bg-clip-text">
                            <span id="totalCompletedActivities"
                                data-target="{{ $totalCompletedActivities }}">{{ $totalCompletedActivities }}</span>
                        </h2>
                        <h3 class="text-sm font-bold mt-auto text-center">Successful Programs</h3>
                    </div>
                </div>




                <!-- Idea Board Link -->
                <div class="w-full p-5 mx-auto shadow-lg mb-4 flex flex-col items-center justify-center mt-4 bg-gray-800 text-white">
                    {{-- <h1 class="text-3xl font-bold mb-4">Explore Idea Board</h1> --}}
                    <i class="fas fa-lightbulb text-lg text-yellow-600"></i>




                    <h2
                        class="bg-gradient-to-r from-blue-600 via-green-500 to-blue-500 inline-block text-transparent bg-clip-text text-lg font-bold mt-2 mb-2 ">
                        Discover & Contribute Innovative Ideas!</h2>
                        <p class="text-base">Join our community where you can share innovative ideas, participate in polls, and engage in meaningful discussions to shape positive change together!</p>

                    <a href="{{ route('idea_board.index') }}"
                        class="mt-8 inline-flex items-center justify-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-blue-600 to-blue-800 hover:from-green-900 hover:to-blue-900 hover:border-blue-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-lg hover:shadow-xl">
                        Explore Now
                    </a>
                    
                    <div class="flex justify-center mb-8">
                        <a href="{{ route('activities.feed') }}" 
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-br from-green-400 to-blue-600 hover:bg-gradient-to-bl text-white font-bold rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-1">
                            <i class="fas fa-trophy mr-2"></i>
                            View Accomplished Activities
                        </a>
                    </div>


                </div>
                {{-- <h1 class="text-3xl font-bold mb-4">Explore Idea Board</h1> --}}
                <h3 class="text-lg sm:text-xl font-semibold mb-4 py-3 text-center"
                    style="border-bottom: 2px solid transparent; border-image: linear-gradient(to right, #3B82F6, #10B981, #3B82F6); border-image-slice: 1; width: 50%; margin: 0 auto;">Latest Activities</h3>
                
                    

                <div class="space-y-8 mt-4" id="activities-container">
                    <x-activity-feed :activities="$activities" />
                </div>

        </div>
        <x-image-popup />


</x-app-layout>

<script>
    function animateValue(obj, start, end, duration) {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            obj.innerHTML = Math.floor(progress * (end - start) + start);
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    }

    function isElementInViewport(el) {
        const rect = el.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }

    function handleScroll() {
        const elements = document.querySelectorAll('#totalHours, #totalVolunteers, #totalCompletedActivities');
        elements.forEach(element => {
            if (isElementInViewport(element) && !element.classList.contains('animated')) {
                const end = parseInt(element.getAttribute('data-target'));
                animateValue(element, 0, end, 1000);
                element.classList.add('animated');
            }
        });
    }

    // Initial check on page load
    handleScroll();

    // Add scroll event listener
    window.addEventListener('scroll', handleScroll);
</script>
{{-- 
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


 --}}
