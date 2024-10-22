<x-app-layout>

    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>


    <div class="max-w-full overflow-x-hidden">
        <div class="bg-gray-800 py-1 px-3">
            <form class="max-w-lg mx-auto my-4">
                <div class="flex">
                    <label for="search-dropdown"
                        class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Your Email</label>
                    <button id="dropdown-button" data-dropdown-toggle="dropdown"
                        class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-s-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600"
                        type="button">Categories <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 4 4 4-4" />
                        </svg></button>
                    <div id="dropdown"
                        class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                            aria-labelledby="dropdown-button">
                            <li>
                                <button type="button"
                                    class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Organizations</button>
                            </li>
                            <li>
                                <button type="button"
                                    class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Volunteers</button>
                            </li>
                            <li>
                                <button type="button"
                                    class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Activities</button>
                            </li>
                            <li>
                                <button type="button"
                                    class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Ideas</button>
                            </li>
                        </ul>
                    </div>
                    <div class="relative w-full">
                        <input type="search" id="search-dropdown"
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
        </div>
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
                <div style="background: linear-gradient(to right, #3b82f6, #8b5cf6);"
                    class="text-white px-5 py-10 rounded-lg shadow-lg mb-4">
                    <h1 class="text-4xl font-bold mb-3 italic">Welcome to {{ config('app.name', 'Laravel') }}</h1>
                    <p class="text-base">Join our community and make a difference! Lorem Ipsum is simply dummy text of
                        the printing and typesetting industry. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                </div>

                <!-- Stats -->
                <!-- Total Hours -->
                <div class="stat-item flex-1 text-center p-6 relative flex flex-col items-center">
                    <h1 class="text-6xl font-extrabold italic  mb-1">
                        <span id="totalHours" data-target="{{ $totalHours }}">0</span>
                    </h1>
                    <h2 class="text-2xl font-bold mt-auto italic ">Hours of Volunteer Work</h2>
                </div>
                <div class="flex justify-center gap-6 mb-4 relative mx-auto" style="max-width: 50vw;">
                    @php
                        $totalHours = \App\Models\Activity::where('status', 'completed')->sum('duration');
                        $totalVolunteers = \App\Models\Volunteer::whereHas('user', function ($query) {
                            $query->where('verified', true);
                        })->count();
                        $totalCompletedActivities = \App\Models\Activity::where('status', 'completed')->count();
                    @endphp

                    <!-- Total volunteers -->
                    <div class="stat-item flex-1 text-center p-6 relative flex flex-col items-center">
                        <h2 class="text-4xl font-bold text-blue-600 mb-1 text-center">
                            <span id="totalVolunteers"
                                data-target="{{ $totalVolunteers }}">{{ $totalVolunteers }}</span>
                        </h2>
                        <h3 class="text-sm font-bold mt-auto text-center">Active Volunteers</h3>
                    </div>

                    <!-- Registered organizations -->
                    <div
                        class="stat-item flex-1 text-center p-6 relative flex flex-col items-center border-l border-gray-300">
                        <h2 class="text-4xl font-bold text-green-600 mb-1 text-center">
                            <span id="totalVolunteers"
                                data-target="{{ $totalVolunteers }}">{{ $totalVolunteers }}</span>
                        </h2>
                        <h3 class="text-sm font-bold mt-auto text-center">Active Organizations</h3>
                    </div>

                    <!-- Completed Activities -->
                    <div
                        class="stat-item flex-1 text-center p-6 relative flex flex-col items-center border-l border-gray-300">
                        <h2 class="text-4xl font-bold text-purple-600 mb-1 text-center">
                            <span id="totalCompletedActivities"
                                data-target="{{ $totalCompletedActivities }}">{{ $totalCompletedActivities }}</span>
                        </h2>
                        <h3 class="text-sm font-bold mt-auto text-center">Successful Programs</h3>
                    </div>
                </div>




                <!-- Idea Board Link -->
                <div class="w-full p-5 mx-auto shadow-lg mb-4 flex flex-col items-center justify-center mt-4 bg-gray-800 text-white">
                    {{-- <h1 class="text-3xl font-bold mb-4">Explore Idea Board</h1> --}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                        fill="{{ request()->routeIs('idea_board.index') ? '#007bff' : '#34C759' }}"
                        class="h-7 w-7 nav-icon {{ request()->routeIs('idea_board.index') ? 'active-icon' : '' }}"
                        viewBox="0 0 16 16">
                        <path
                            d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zm0 12.93A5.93 5.93 0 1 1 8 2.07 5.93 5.93 0 0 1 8 13.93z"
                            fill="{{ request()->routeIs('idea_board.index') ? '#007bff' : '#34C759' }}"
                            stroke="{{ request()->routeIs('idea_board.index') ? '#007bff' : '#34C759' }}"
                            stroke-width="0.5" />
                        <path
                            d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"
                            fill="{{ request()->routeIs('idea_board.index') ? '#007bff' : '#34C759' }}"
                            stroke="{{ request()->routeIs('idea_board.index') ? '#007bff' : '#34C759' }}"
                            stroke-width="0.5" />
                    </svg>




                    <h1
                        class="bg-gradient-to-r from-blue-600 via-green-500 to-blue-500 inline-block text-transparent bg-clip-text text-lg font-bold mt-2 mb-2 ">
                        Discover & Contribute Innovative Ideas!</h1>
                        <p class="text-base">Join our community and make a difference! Lorem Ipsum is simply dummy text of
                            the printing and typesetting industry.</p>

                    <button type="button"
                        class="mt-4 text-white bg-gradient-to-br from-green-400 to-blue-600 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2">
                        Explore Now
                    </button>



                </div>
                {{-- <h1 class="text-3xl font-bold mb-4">Explore Idea Board</h1> --}}

                <h3 class="text-lg sm:text-xl font-semibold mb-4 py-3 text-center"
                    style="border-bottom: 2px solid #8B9467; width: 50%; margin: 0 auto;">Latest Activities</h3>

                <div class="space-y-8 mt-4">
                    <x-activity-feed :activities="$activities" />
                </div>
        </div>
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
