{{-- <div class="space-y-6"> --}}
    <!-- Welcome Section -->
    
    <div class="w-full p-5 mx-auto shadow-lg flex flex-col items-center justify-center bg-gray-800 text-white">
        {{-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#34C759" class="h-10 w-10"
            viewBox="0 0 16 16">
            <path
                d="M0 11.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-2zm4-3a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-5zm4-3a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-8zm4-3a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5v11a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-11z"
                fill="#34C759" stroke="#34C759" stroke-width="0.5" />
        </svg> --}}

        <h2
            class="bg-gradient-to-r from-blue-600 via-green-500 to-blue-500 inline-block text-transparent bg-clip-text text-lg font-bold mt-2 mb-2">
            Welcome, {{ Auth::user()->volunteer->Name }}!
        </h2>
        {{-- <p class="text-base text-center">
            Your commitment to volunteering creates ripples of positive change in our community. </p> --}}
        <p class="text-base text-center mb-2">
            View your stats, completed projects, request new activities and more.
        </p>

        @php
            use App\Models\ActivityRequest;
            $volunteerLevel = Auth::user()->volunteer->getLevel();
            $monthlyLimit = match ($volunteerLevel) {
                '2' => 1,
                '3', '4' => 3,
                '5' => 5,
                default => 0,
            };

            $usedRequests = ActivityRequest::getMonthlyRequestCount(Auth::user()->volunteer->userid);
            $remainingRequests = max(0, $monthlyLimit - $usedRequests);
            $canRequest = $remainingRequests > 0;
        @endphp

   @if ($monthlyLimit >= 0)
                <div class="flex flex-col items-center">
                    @if ($canRequest)
                        <a href="{{ route('activity-requests.create') }}"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-green-600 text-white rounded-full hover:from-blue-700 hover:to-green-700 transition-all duration-300 shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Request New Activity
                        </a>
                        <p class="text-sm text-gray-500 mt-3">
                            Monthly Requests Remaining: <span class="font-semibold">{{ $remainingRequests }}</span> of <span class="font-semibold">{{ $monthlyLimit }}</span>
                        </p>
                    @else
                        <div class="text-yellow-700 bg-yellow-100 px-4 py-3 rounded-lg mt-3">
                            <p class="text-sm">
                                You've reached your monthly limit of <span class="font-semibold">{{ $monthlyLimit }}</span> requests.
                                New requests will be available next month.
                            </p>
                        </div>
                    @endif
                </div>
            @endif
  
    </div>
    <div class="p-1 sm:p-8 bg-white shadow mb-0">

    

        <!-- Stats Section -->
        <div class="flex flex-row flex-wrap gap-2 mb-6 mx-1 overflow-x-hidden">
            <div
                class="flex-1 min-w-[120px] max-w-[calc(50%-0.5rem)] bg-gradient-to-br from-blue-200 to-blue-300 p-3 rounded-lg shadow hover:from-blue-200 hover:to-blue-300 transition-all duration-300 border border-blue-100">
                <h3 class="text-sm font-semibold text-black">Completed Projects</h3>
                <p class="text-lg font-bold text-black">
                    {{ Auth::user()->volunteer->activities()->wherePivot('approval_status', 'approved')->count() }}</p>
            </div>
            <div
                class="flex-1 min-w-[120px] max-w-[calc(50%-0.5rem)] bg-gradient-to-br from-indigo-100 to-indigo-200 p-3 rounded-lg shadow hover:from-indigo-100 hover:to-indigo-200 transition-all duration-300 border border-indigo-100">
                <h3 class="text-sm font-semibold text-black">Hours Contributed</h3>
                <p class="text-lg font-bold text-black">
                    {{ Auth::user()->volunteer->activities()->wherePivot('approval_status', 'approved')->sum('duration') }}
                </p>
            </div>
            <div
                class="flex-1 min-w-[120px] max-w-[calc(50%-0.5rem)] bg-gradient-to-br from-green-100 to-green-200 p-3 rounded-lg shadow hover:from-green-100 hover:to-green-200 transition-all duration-300 border border-green-100">
                <h3 class="text-sm font-semibold text-black">Idea Interactions</h3>
                <p class="text-lg font-bold text-black">{{ Auth::user()->volunteer->idea_interactions_count }}</p>
            </div>
        </div>

      



        <!-- Activity Graph Section -->
        <div class="my-2 px-4 rounded-lg shadow-lg border border-gray-200">
            <div class="w-full p-8 mb-4">
                @php
                    $currentYear = request('year', date('Y'));
                @endphp

                <div class="flex items-center justify-center gap-4 mb-4">
                    <button id="yearSelectorBtn"
                        class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition-colors flex items-center gap-2 shadow-md">
                        <span>Select Year: {{ $currentYear }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                </div>

                <h2 class="text-xl font-bold text-gray-800 text-center mb-6">Volunteer Activity Hours Summary for
                    {{ $currentYear }}</h2>

                @php
                    $monthlyHours = DB::table('activities')
                        ->join('activity_volunteers', 'activities.activityid', '=', 'activity_volunteers.activityid')
                        ->where('activity_volunteers.volunteer_userid', Auth::user()->volunteer->userid)
                        ->where('activity_volunteers.approval_status', 'approved')
                        ->whereYear('date', $currentYear)
                        ->selectRaw('MONTH(date) as month, SUM(duration) as hours')
                        ->groupBy('month')
                        ->get()
                        ->pluck('hours', 'month')
                        ->toArray();

                    // Fill in missing months with 0
                    for ($i = 1; $i <= 12; $i++) {
                        if (!isset($monthlyHours[$i])) {
                            $monthlyHours[$i] = 0;
                        }
                    }
                    ksort($monthlyHours);

                    $maxHours = max($monthlyHours) ?: 1;
                    $maxHours = ceil($maxHours * 1.2);

                    $months = [
                        1 => 'January',
                        2 => 'February',
                        3 => 'March',
                        4 => 'April',
                        5 => 'May',
                        6 => 'June',
                        7 => 'July',
                        8 => 'August',
                        9 => 'September',
                        10 => 'October',
                        11 => 'November',
                        12 => 'December',
                    ];
                @endphp

                <!-- Desktop View -->
                <div class="relative h-96 mx-8 hidden md:block">
                    @php
                        $step = ceil($maxHours / 8);
                        $yAxisValues = range(0, $maxHours, $step);
                    @endphp

                    <!-- Graph container -->
                    <div class="h-full flex items-end justify-between relative px-4">
                        <!-- Y-axis values and grid lines -->
                        <div class="absolute inset-0 h-full">
                            @foreach ($yAxisValues as $value)
                                @php
                                    $percentage = 100 - ($value / $maxHours) * 100;
                                @endphp
                                <div class="absolute w-full border-b border-gray-200"
                                    style="top: {{ $percentage }}%">
                                    <span
                                        class="absolute -left-8 -translate-y-1/2 text-sm text-gray-600">{{ $value }}h</span>
                                </div>
                            @endforeach
                        </div>

                        <!-- X-axis line -->
                        <div class="absolute bottom-0 left-0 w-full h-0.5 bg-gray-300"></div>

                        <!-- Bars -->
                        @foreach ($monthlyHours as $month => $hours)
                            <div class="relative flex flex-col items-center group" style="height: 100%;">
                                <!-- Bar -->
                                <div class="absolute bottom-0 w-12" style="height: {{ ($hours / $maxHours) * 100 }}%">
                                    <div
                                        class="w-full h-full {{ $hours > 0 ? 'bg-gradient-to-t from-green-600 to-green-400' : 'bg-gray-200' }} 
                                    rounded-t-lg transition-all duration-300 hover:opacity-80">
                                    </div>
                                </div>
                                <!-- Month label -->
                                <div class="absolute -bottom-8 text-sm font-medium text-gray-600">
                                    {{ substr($months[$month], 0, 3) }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Mobile View -->
                <div class="relative h-80 mx-2 md:hidden mt-8">
                    @php
                        $step = ceil($maxHours / 8);
                        $yAxisValues = range(0, $maxHours, $step);
                    @endphp

                    <!-- Graph container -->
                    <div class="h-full flex items-end justify-between relative px-1">
                        <!-- Y-axis values and grid lines -->
                        <div class="absolute inset-0 h-full">
                            @foreach ($yAxisValues as $value)
                                @php
                                    $percentage = 100 - ($value / $maxHours) * 100;
                                @endphp
                                <div class="absolute w-full border-b border-gray-200"
                                    style="top: {{ $percentage }}%">
                                    <span
                                        class="absolute -left-8 -translate-y-1/2 text-xs text-gray-600">{{ $value }}h</span>
                                </div>
                            @endforeach
                        </div>

                        <!-- X-axis line -->
                        <div class="absolute bottom-0 left-0 w-full h-0.5 bg-gray-300"></div>

                        <!-- Bars -->
                        @foreach ($monthlyHours as $month => $hours)
                            <div class="relative flex flex-col items-center group" style="height: 100%;">
                                <!-- Bar -->
                                <div class="absolute bottom-0 w-6" style="height: {{ ($hours / $maxHours) * 100 }}%">
                                    <div
                                        class="w-full h-full {{ $hours > 0 ? 'bg-gradient-to-t from-green-600 to-green-400' : 'bg-gray-200' }} 
                                    rounded-t transition-all duration-300 hover:opacity-80">
                                    </div>
                                </div>
                                <!-- Month label -->
                                <div class="absolute -bottom-8 text-xs font-medium text-gray-600">
                                    {{ substr($months[$month], 0, 3) }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Activity Counts Legend -->
                <div class="flex justify-between mt-2 px-1 md:hidden">
                    @foreach ($monthlyHours as $month => $hours)
                        <div class="text-sm font-bold {{ $hours > 0 ? 'text-green-600' : 'text-gray-400' }} w-6 text-center"
                            style="margin-top: 20px;">
                            {{ $hours }}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Year Picker Modal -->
        <div id="yearPickerModal"
            class="fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center z-50 backdrop-blur-sm">
            <div class="bg-gray-900 rounded-2xl p-6 w-64 shadow-2xl border border-gray-700">
                <div class="text-center mb-4">
                    <h3 class="text-lg font-semibold text-white">Select Year</h3>
                </div>

                <div class="relative h-48 overflow-hidden rounded-xl bg-gray-800">
                    <div id="yearPicker" class="absolute inset-0 overflow-y-scroll hide-scrollbar">
                        <div class="absolute inset-0 pointer-events-none"
                            style="background: linear-gradient(180deg, rgba(31,41,55,0.9) 0%, rgba(31,41,55,0) 20%, rgba(31,41,55,0) 80%, rgba(31,41,55,0.9) 100%);">
                        </div>
                        <div class="py-20">
                            @for ($year = 2024; $year >= 1990; $year--)
                                <div class="year-option h-12 flex items-center justify-center text-lg cursor-pointer transition-all duration-200 {{ $currentYear == $year ? 'text-blue-400 font-bold bg-gray-700' : 'text-gray-300 hover:bg-gray-700' }}"
                                    data-year="{{ $year }}" onclick="selectYear({{ $year }})">
                                    {{ $year }}
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>

                <div class="mt-4 flex justify-end">
                    <button id="closeYearPicker"
                        class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600 transition-colors">
                        Done
                    </button>
                </div>
            </div>
        </div>

        <style>
            .hide-scrollbar::-webkit-scrollbar {
                display: none;
            }

            .hide-scrollbar {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }

            .relative:hover .tooltip-text {
                visibility: visible;
                opacity: 1;
            }
        </style>

        <script>
            function selectYear(year) {
                window.location.href = '?year=' + year;
            }

            document.addEventListener('DOMContentLoaded', function() {
                const modal = document.getElementById('yearPickerModal');
                const picker = document.getElementById('yearPicker');
                const openBtn = document.getElementById('yearSelectorBtn');
                const closeBtn = document.getElementById('closeYearPicker');

                // Show modal
                openBtn.addEventListener('click', function() {
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                    // Center the current year
                    const currentYearElement = picker.querySelector(
                        '.year-option[data-year="{{ $currentYear }}"]');
                    if (currentYearElement) {
                        picker.scrollTop = currentYearElement.offsetTop - (picker.offsetHeight / 2) + (
                            currentYearElement.offsetHeight / 2);
                    }
                });

                // Hide modal
                closeBtn.addEventListener('click', function() {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                });

                // Close modal when clicking outside
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                    }
                });
            });
        </script>

        <!-- Activities Table Section -->
        <div class="bg-white overflow-hidden shadow-xl rounded-lg my-6">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-700 bg-gray-800">
                <h2 class="text-lg font-semibold text-white text-center">My Activities</h2>
            </div>

            @if ($recentActivities->isEmpty())
                <div class="p-4 text-center text-gray-500">
                    No activities found.
                </div>
            @else
                <!-- Table Container -->
                <div class="p-1 bg-gray-100 border border-gray-200">
                    <div class="h-[400px] overflow-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th
                                        class="sticky left-0 z-10 bg-gray-100 px-4 py-2 text-left whitespace-nowrap w-[200px] sm:w-[250px] border border-gray-300">
                                        Title
                                    </th>
                                    <th
                                        class="px-4 py-2 text-left whitespace-nowrap border border-gray-300 w-[120px] sm:w-[150px]">
                                        Date
                                    </th>
                                    <th
                                        class="px-4 py-2 text-left whitespace-nowrap border border-gray-300 w-[120px] sm:w-[150px]">
                                        Status
                                    </th>
                                    <th
                                        class="px-4 py-2 text-left whitespace-nowrap border border-gray-300 w-[200px] sm:w-[250px]">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                @foreach ($recentActivities as $activity)
                                    <tr class="{{ $loop->even ? 'bg-gray-200' : 'bg-white' }}">
                                        <td
                                            class="sticky left-0 z-10 px-4 py-2 whitespace-nowrap border border-gray-300 {{ $loop->even ? 'bg-gray-200' : 'bg-white' }}">
                                            <div class="flex flex-col">
                                                @php
                                                    $words = explode(' ', $activity->title);
                                                    $line1 = '';
                                                    $line2 = '';

                                                    $currentLine = &$line1;
                                                    foreach ($words as $word) {
                                                        if (strlen($currentLine . ' ' . $word) <= 20) {
                                                            $currentLine .= ($currentLine ? ' ' : '') . $word;
                                                        } else {
                                                            $currentLine = &$line2;
                                                            $currentLine .= ($currentLine ? ' ' : '') . $word;
                                                        }
                                                    }

                                                    $line2 =
                                                        strlen($line2) > 20 ? substr($line2, 0, 22) . '...' : $line2;
                                                @endphp
                                                <div>{{ $line1 }}</div>
                                                <div>{{ $line2 }}</div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-2 whitespace-nowrap border border-gray-300">
                                            {{ $activity->date->format('Y-m-d') }}
                                        </td>
                                        <td class="px-4 py-2 whitespace-nowrap border border-gray-300">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $activity->pivot->approval_status === 'approved'
                                                ? 'bg-green-100 text-green-800'
                                                : ($activity->pivot->approval_status === 'pending'
                                                    ? 'bg-yellow-100 text-yellow-800'
                                                    : 'bg-red-100 text-red-800') }}">
                                                {{ ucfirst($activity->pivot->approval_status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <div class="flex items-center space-x-4">
                                                @if ($activity->pivot->approval_status === 'approved')
                                                    <div class="relative">
                                                        <a href="{{ route('activities.timeline', $activity) }}"
                                                            class="inline-flex items-center px-2 py-2 bg-purple-100 text-purple-700 rounded hover:bg-purple-200 transition-colors border border-purple-300">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-5 w-5 mr-1" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            Timeline
                                                            @php
                                                                $unreadCount = Auth::user()->volunteer->getUnreadMilestonesCount(
                                                                    $activity->activityid,
                                                                );
                                                            @endphp
                                                            @if ($unreadCount > 0)
                                                                <span
                                                                    class="absolute -top-2 -right-2 px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full border border-red-700">
                                                                    {{ $unreadCount }}
                                                                </span>
                                                            @endif
                                                        </a>
                                                    </div>
                                                @endif

                                                <div class="relative ml-8">
                                                    <a href="{{ route('activities.show', $activity) }}"
                                                        class="text-purple-600 hover:text-purple-900">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" fill="#3B82F6"
                                                            class="bi bi-eye translate-y-[2px] group relative"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zm-8 4.5a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9z" />
                                                            <path d="M8 5a3 3 0 1 0 0 6 3 3 0 0 0 0-6z" />
                                                        </svg>
                                                        <span
                                                            class="tooltip-text absolute invisible bg-black text-white text-xs rounded py-1 px-2 -mt-16 -ml-8 whitespace-nowrap opacity-0 transition-opacity duration-300 hover:opacity-100">View
                                                            Details</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
{{-- </div> --}}
