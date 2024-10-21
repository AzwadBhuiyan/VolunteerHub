<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Search Bar -->
        <div class="my-4">
            <input type="text" placeholder="Search..." class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Welcome Message -->
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 text-white p-8 rounded-lg shadow-lg mb-8">
            <h1 class="text-4xl font-bold mb-4">Welcome to {{ config('app.name', 'Laravel') }}</h1>
            <p class="text-xl">Join our community and make a difference!</p>
        </div>

<!-- Stats -->
<div class="flex justify-center gap-6 mb-8 relative">
    @php
        $totalHours = \App\Models\Activity::where('status', 'completed')->sum('duration');
        $totalVolunteers = \App\Models\Volunteer::whereHas('user', function($query) {
            $query->where('verified', true);
        })->count();
        $totalCompletedActivities = \App\Models\Activity::where('status', 'completed')->count();
    @endphp

    <!-- Total Hours -->
    <div class="stat-item flex-1 text-center p-6 relative flex flex-col items-center">
        <h2 class="text-3xl font-bold text-blue-600 mb-1">
            <span id="totalHours" data-target="{{ $totalHours }}">0</span>
        </h2>
        <h3 class="text-lg font-bold mt-auto">Hours of Activity</h3>
    </div>

    <!-- Registered Volunteers -->
    <div class="stat-item flex-1 text-center p-6 relative flex flex-col items-center border-l border-gray-300">
        <h2 class="text-3xl font-bold text-green-600 mb-1">
            <span id="totalVolunteers" data-target="{{ $totalVolunteers }}">0</span>
        </h2>
        <h3 class="text-lg font-bold mt-auto">Active Volunteers</h3>
    </div>

    <!-- Completed Activities -->
    <div class="stat-item flex-1 text-center p-6 relative flex flex-col items-center border-l border-gray-300">
        <h2 class="text-3xl font-bold text-purple-600 mb-1">
            <span id="totalCompletedActivities" data-target="{{ $totalCompletedActivities }}">0</span>
        </h2>
        <h3 class="text-lg font-bold mt-auto">Successful Programs</h3>
    </div>
</div>




        <!-- Idea Board Link -->
        <div class="bg-gradient-to-r from-green-500 to-teal-600 text-white p-8 rounded-lg shadow-lg mb-8 cursor-pointer" onclick="window.location.href='{{ route('idea_board.index') }}'">
            <h2 class="text-4xl font-bold mb-4">Explore Idea Board</h2>
            <p class="text-xl">Discover and contribute to innovative ideas!</p>
        </div>

        <!-- Activity Feed -->
        <h2 class="text-2xl font-bold mb-4">Activity Feed</h2>
        <div class="space-y-8">
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
