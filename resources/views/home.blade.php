<x-app-layout>
    @auth
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div data-user-type="{{ Auth::user()->role === 'organization' ? 'organization' : 'volunteer' }}">
        @endauth

        <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

        <div class="max-w-full overflow-x-hidden">
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
                    <div class="text-white px-5 py-10 rounded-lg shadow-lg mb-4 animate-gradient-bd">
                        <h1 class="text-4xl font-bold mb-3 italic">Welcome to {{ config('app.name', 'Laravel') }}</h1>
                        <p class="text-base">Join our community and make a difference! Connect with opportunities to
                            volunteer, support events, and share your skills. Let's create a better world together!</p>
                    </div>

                    <!-- admin dashboard -->
                    @if (Auth::check() && Auth::user()->role === 'admin')
                        <div class="mt-4 flex justify-center">
                            <a href="{{ route('admin.dashboard') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                        clip-rule="evenodd" />
                                </svg>
                                Admin Dashboard
                            </a>
                        </div>
                    @endif

                    <style>
                        @keyframes gradientBD {
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

                        .animate-gradient-bd {
                            background: linear-gradient(-45deg,
                                    #008a4e,
                                    #27ae60,
                                    #f42a41,
                                    #2ecc71,
                                    #008a4e);
                            background-size: 400% 400%;
                            animation: gradientBD 20s ease-in-out infinite;
                            transition: all 0.3s ease;
                        }


                        .animate-gradient-bd:hover::before {
                            opacity: 0.8;
                        }
                    </style>

                    <!-- Stats -->
                    <!-- Total Hours -->
                    <div class="stat-item flex-1 text-center p-6 relative flex flex-col items-center">
                        <h1
                            class="text-6xl font-extrabold italic mb-1 bg-gradient-to-r from-green-500 to-green-900 text-transparent bg-clip-text">
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
                            <h2
                                class="text-4xl font-bold mb-1 text-center bg-gradient-to-r from-green-500 to-green-900 text-transparent bg-clip-text">
                                <span id="totalVolunteers"
                                    data-target="{{ $totalVolunteers }}">{{ $totalVolunteers }}</span>
                            </h2>
                            <h3 class="text-sm font-bold mt-auto text-center">Active Volunteers</h3>
                        </div>

                        <!-- Registered organizations -->
                        <div class="stat-item flex-1 text-center p-6 relative flex flex-col items-center border-l border-gray-200"
                            style="height: 25%;">
                            <h2
                                class="text-4xl font-bold mb-1 text-center bg-gradient-to-r from-green-500 to-green-900 text-transparent bg-clip-text">
                                <span id="totalVolunteers"
                                    data-target="{{ $totalOrganizations }}">{{ $totalOrganizations }}</span>
                            </h2>
                            <h3 class="text-sm font-bold mt-auto text-center">Active Organizations</h3>
                        </div>

                        <!-- Completed Activities -->
                        <div class="stat-item flex-1 text-center p-6 relative flex flex-col items-center border-l border-gray-200"
                            style="height: 25%;">
                            <h2
                                class="text-4xl font-bold mb-1 text-center bg-gradient-to-r from-green-500 to-green-900 text-transparent bg-clip-text">
                                <span id="totalCompletedActivities"
                                    data-target="{{ $totalCompletedActivities }}">{{ $totalCompletedActivities }}</span>
                            </h2>
                            <h3 class="text-sm font-bold mt-auto text-center">Successful Programs</h3>
                        </div>
                    </div>

                    <div class="flex justify-center mb-8" data-tutorial="accomplished-section">
                        <a href="{{ route('activities.feed') }}"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-br from-green-500 to-green-900 hover:bg-gradient-to-bl text-white font-bold rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-1">
                            <i class="fas fa-trophy mr-2"></i>
                            View Accomplished Projects
                        </a>
                    </div>



                    <!-- Idea Board Link -->
                    <div data-tutorial="idea-board-section"
                        class="w-full p-5 mx-auto shadow-lg mb-4 flex flex-col items-center justify-center mt-4 bg-gray-800 text-white">
                        {{-- <h1 class="text-3xl font-bold mb-4">Explore Idea Board</h1> --}}
                        <i class="fas fa-lightbulb text-lg" style="color: #d32f2f;"></i> <!-- Red light color -->

                        <h2
                            class="bg-gradient-to-r from-green-600 via-red-500 to-green-600 inline-block text-transparent bg-clip-text text-lg font-bold mt-2 mb-2 ">
                            Discover & Contribute Innovative Ideas!</h2>
                        <!-- Green, red, green gradient to reflect the Bangladeshi flag -->
                        <p class="text-base">Join our community where you can share innovative ideas, participate in
                            polls, and engage in meaningful discussions to shape positive change together!</p>

                        <a href="{{ route('idea_board.index') }}"
                            class="mt-8 inline-flex items-center justify-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-blue-600 to-blue-800 hover:from-green-900 hover:to-blue-900 hover:border-blue-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-lg hover:shadow-xl">
                            Explore Now
                        </a>
                    </div>
                    {{-- <h1 class="text-3xl font-bold mb-4">Explore Idea Board</h1> --}}
                    <h3 data-tutorial="latest-activities"
                        class="text-lg sm:text-xl font-semibold mb-4 py-3 text-center latest-activities"
                        style="border-bottom: 2px solid transparent; border-image: linear-gradient(to right, #3B82F6, #10B981, #3B82F6); border-image-slice: 1; width: 50%; margin: 0 auto;">
                        Latest Activities
                    </h3>


                    <div class="space-y-8 mt-4" id="activities-container">
                        <x-activity-feed :activities="$activities" />
                    </div>

            </div>

            @if (auth()->check() && auth()->user()->user_type === 'volunteer')
                <x-tutorial-popup />
            @endif


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
