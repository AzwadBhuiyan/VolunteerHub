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
        <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="text-lg font-semibold">Idea Interactions</h3>
            <p class="text-2xl font-bold text-orange-600">{{ Auth::user()->volunteer->idea_interactions_count }}</p>
        </div>      
    </div>



    <!-- Activity Graph Section -->
    <div class="my-2 px-4 rounded-lg shadow-lg border border-gray-200">
        <div class="w-full p-8 mb-4">
            <h2 class="text-xl font-bold text-gray-800 text-center mb-6">Your Activity Hours in {{ date('Y') }}</h2>
            
            @php
                $monthlyHours = DB::table('activities')
                    ->join('activity_volunteers', 'activities.activityid', '=', 'activity_volunteers.activityid')
                    ->where('activity_volunteers.volunteer_userid', Auth::user()->volunteer->userid)
                    ->where('activity_volunteers.approval_status', 'approved')
                    ->whereYear('date', date('Y'))
                    ->selectRaw('MONTH(date) as month, SUM(duration) as hours')
                    ->groupBy('month')
                    ->get()
                    ->pluck('hours', 'month')
                    ->toArray();

                // Fill missing months with 0
                for ($i = 1; $i <= 12; $i++) {
                    if (!isset($monthlyHours[$i])) {
                        $monthlyHours[$i] = 0;
                    }
                }
                ksort($monthlyHours);

                $maxHours = max($monthlyHours) ?: 1;
                $maxHours = ceil($maxHours * 1.2);

                $months = [
                    1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
                    5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug',
                    9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'
                ];
            @endphp

            <!-- Graph structure similar to organization dashboard -->
            <div class="relative h-96 mx-8 hidden md:block">
                <div class="h-full flex items-end justify-between relative px-4">
                    <!-- Y-axis (Hours) -->
                    <div class="absolute inset-0 h-full">
                        @for ($i = 0; $i <= $maxHours; $i += max(1, ceil($maxHours/8)))
                            <div class="absolute w-full border-b border-gray-200"
                                style="top: {{ 100 - ($i / $maxHours) * 100 }}%">
                                <span class="absolute -left-8 -translate-y-1/2 text-sm text-gray-600">{{ $i }}h</span>
                            </div>
                        @endfor
                    </div>

                    <!-- Bars -->
                    @foreach ($monthlyHours as $month => $hours)
                        <div class="relative flex flex-col items-center group">
                            <div class="absolute bottom-0 w-12" style="height: {{ ($hours / $maxHours) * 100 }}%">
                                <div class="w-full h-full bg-gradient-to-t from-purple-600 to-purple-400 rounded-t"></div>
                            </div>
                            <div class="absolute bottom-0 translate-y-full mt-2 text-sm text-gray-600">
                                {{ $months[$month] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Activities Table Section -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Your Activities</h3>
        </div>
        <div class="border-t border-gray-200 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Approval Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($recentActivities as $activity)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $activity->title }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $activity->date->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $activity->pivot->approval_status === 'approved' ? 'bg-green-100 text-green-800' : 
                                       ($activity->pivot->approval_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($activity->pivot->approval_status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="flex space-x-4">
                                    <a href="{{ route('activities.show', $activity) }}" class="text-blue-500 hover:text-blue-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </a>
                                    @if($activity->pivot->approval_status === 'approved')
                                        <a href="{{ route('activities.timeline', $activity) }}" 
                                           class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-indigo-700 bg-indigo-100 hover:bg-indigo-200">
                                            Timeline
                                            @php
                                                $unreadCount = Auth::user()->volunteer->getUnreadMilestonesCount($activity->activityid);
                                            @endphp
                                            @if($unreadCount > 0)
                                                <span class="ml-1.5 px-2 py-0.5 text-xs font-medium bg-red-100 text-red-800 rounded-full">
                                                    {{ $unreadCount }}
                                                </span>
                                            @endif
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>