<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Welcome, {{ Auth::user()->volunteer->Name }}!</h1>
        <p class="text-gray-600">Track your volunteer activities and impact</p>
    </div>

    <!-- Stats Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="text-lg font-semibold">Activities Joined</h3>
            <p class="text-2xl font-bold text-blue-600">{{ Auth::user()->volunteer->activities()->wherePivot('approval_status', 'approved')->count() }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="text-lg font-semibold">Hours Contributed</h3>
            <p class="text-2xl font-bold text-green-600">{{ Auth::user()->volunteer->activities()->wherePivot('approval_status', 'approved')->sum('duration') }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="text-lg font-semibold">Organizations Following</h3>
            <p class="text-2xl font-bold text-purple-600">{{ Auth::user()->volunteer->followedOrganizations->count() }}</p>
        </div>
    </div>

    <!-- Recent Activities Section -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-4">Recent Activities</h2>
        @if(isset($recentActivities) && $recentActivities->count() > 0)
            <!-- Add recent activities list here -->
            <div class="space-y-4">
                @foreach($recentActivities as $activity)
                    <div class="border-b pb-4">
                        <h3 class="font-semibold">{{ $activity->title }}</h3>
                        <p class="text-sm text-gray-600">{{ $activity->date->format('M d, Y') }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600">No recent activities found.</p>
        @endif
    </div>
</div>