<div class="w-full p-5 mx-auto shadow-lg mb-4 flex flex-col items-center justify-center bg-gray-800 text-white">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#34C759" class="h-7 w-7" viewBox="0 0 16 16">
        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" fill="#34C759" stroke="#34C759" stroke-width="0.5"/>
        <path d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zm0 12.93A5.93 5.93 0 1 1 8 2.07 5.93 5.93 0 0 1 8 13.93z" fill="#34C759" stroke="#34C759" stroke-width="0.5"/>
    </svg>

    <h2 class="bg-gradient-to-r from-blue-600 via-green-500 to-blue-500 inline-block text-transparent bg-clip-text text-lg font-bold mt-2 mb-2">
        Create New Volunteer Activities!</h2>
    <p class="text-base">Start organizing impactful volunteer activities and make a difference in your community.</p>

    <a href="{{ route('activities.create') }}">
        <button type="button" class="mt-4 text-white bg-gradient-to-br from-green-400 to-blue-600 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2">
            Create Activity
        </button>
    </a>
</div>

<!-- Stats Section -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white p-4 rounded-lg shadow">
        <h3 class="text-lg font-semibold">Total Activities</h3>
        <p class="text-2xl font-bold text-blue-600">
            {{ Auth::user()->organization->activities()->count() }}
        </p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow">
        <h3 class="text-lg font-semibold">Completed Activities</h3>
        <p class="text-2xl font-bold text-green-600">
            {{ Auth::user()->organization->activities()->where('status', 'completed')->count() }}
        </p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow">
        <h3 class="text-lg font-semibold">Total Hours Completed</h3>
        <p class="text-2xl font-bold text-purple-600">
            {{ Auth::user()->organization->activities()->where('status', 'completed')->sum('duration') }}
        </p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow">
        <h3 class="text-lg font-semibold">Total Idea Threads</h3>
        <p class="text-2xl font-bold text-orange-600">
            {{ Auth::user()->organization->ideaThreads()->count() }}
        </p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow">
        <h3 class="text-lg font-semibold">Total Unique Volunteers</h3>
        <p class="text-2xl font-bold text-yellow-600">
            {{ Auth::user()->organization->activities()
                ->join('activity_volunteers', 'activities.activityid', '=', 'activity_volunteers.activityid')
                ->where('activity_volunteers.approval_status', 'approved')
                ->distinct('activity_volunteers.volunteer_userid')
                ->count('activity_volunteers.volunteer_userid') }}
        </p>
    </div>
</div>

<div class="my-2 px-4 rounded-lg shadow-lg border border-gray-200">
    <div class="w-full p-8 mb-4">
        @php
            $currentYear = request('year', date('Y'));
        @endphp

        <div class="flex items-center justify-center gap-4 mb-4">
                <!-- Year selector button -->
            <button id="yearSelectorBtn" 
                class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition-colors flex items-center gap-2 shadow-md">
                <span>Select Year: {{ $currentYear }}</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
        </div>

        <!-- Modal for year selection -->
        <div id="yearPickerModal" class="fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center z-50 backdrop-blur-sm">
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
                                    data-year="{{ $year }}"
                                    onclick="selectYear({{ $year }})">
                                    {{ $year }}
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>

                <div class="mt-4 flex justify-end">
                    <button id="closeYearPicker" class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600 transition-colors">
                        Done
                    </button>
                </div>
            </div>
        </div>

        <h2 class="text-xl font-bold text-gray-800 text-center mb-6">Completed Activities in {{ $currentYear }}</h2>

        @php
            $monthlyData = Auth::user()
                ->organization->activities()
                ->selectRaw('MONTH(date) as month, COUNT(*) as count')
                ->whereYear('date', $currentYear)
                ->where('status', 'completed')
                ->groupBy('month')
                ->get()
                ->pluck('count', 'month')
                ->toArray();

            // Fill in missing months with 0
            for ($i = 1; $i <= 12; $i++) {
                if (!isset($monthlyData[$i])) {
                    $monthlyData[$i] = 0;
                }
            }
            ksort($monthlyData);

            // Get max value for percentage calculation
            $maxValue = max($monthlyData) ?: 1;
            // Add extra buffer to max value
            $maxValue = ceil($maxValue * 1.2);

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

        <!-- Desktop View - Hidden on mobile -->
        <div class="relative h-96 mx-8 hidden md:block">
            @php
                $step = ceil($maxValue / 8);
                $yAxisValues = range(0, $maxValue, $step);
            @endphp

            <!-- Graph container -->
            <div class="h-full flex items-end justify-between relative px-4">
                <!-- Y-axis values and grid lines -->
                <div class="absolute inset-0 h-full">
                    @foreach ($yAxisValues as $value)
                        @php
                            $percentage = 100 - ($value / $maxValue) * 100;
                        @endphp
                        <div class="absolute w-full border-b border-gray-200"
                            style="top: {{ $percentage }}%">
                            <span
                                class="absolute -left-8 -translate-y-1/2 text-sm text-gray-600">{{ $value }}</span>
                        </div>
                    @endforeach
                </div>

                <!-- X-axis line -->
                <div class="absolute bottom-0 left-0 w-full h-0.5 bg-gray-300"></div>

                <!-- Bars -->
                @foreach ($monthlyData as $month => $count)
                    <div class="relative flex flex-col items-center group" style="height: 100%;">
                        <!-- Bar -->
                        <div class="absolute bottom-0 w-12"
                            style="height: {{ ($count / $maxValue) * 100 }}%">
                            <div
                                class="w-full h-full {{ $count > 0 ? 'bg-gradient-to-t from-green-600 to-green-400' : 'bg-gray-200' }} 
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

        <!-- Mobile View - Hidden on desktop -->
        <div class="relative h-80 mx-2 md:hidden mt-8">
            @php
                $step = ceil($maxValue / 8);
                $yAxisValues = range(0, $maxValue, $step);
            @endphp

            <!-- Graph container -->
            <div class="h-full flex items-end justify-between relative px-1">
                <!-- Y-axis values and grid lines -->
                <div class="absolute inset-0 h-full">
                    @foreach ($yAxisValues as $value)
                        @php
                            $percentage = 100 - ($value / $maxValue) * 100;
                        @endphp
                        <div class="absolute w-full border-b border-gray-200"
                            style="top: {{ $percentage }}%">
                            <span
                                class="absolute -left-8 -translate-y-1/2 text-xs text-gray-600">{{ $value }}</span>
                        </div>
                    @endforeach
                </div>

                <!-- X-axis line -->
                <div class="absolute bottom-0 left-0 w-full h-0.5 bg-gray-300"></div>

                <!-- Bars -->
                @foreach ($monthlyData as $month => $count)
                    <div class="relative flex flex-col items-center group" style="height: 100%;">
                        <!-- Bar -->
                        <div class="absolute bottom-0 w-6"
                            style="height: {{ ($count / $maxValue) * 100 }}%">
                            <div
                                class="w-full h-full {{ $count > 0 ? 'bg-gradient-to-t from-green-600 to-green-400' : 'bg-gray-200' }} 
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
            @foreach ($monthlyData as $month => $count)
                <div class="text-sm font-bold {{ $count > 0 ? 'text-green-600' : 'text-gray-400' }} w-6 text-center" style="margin-top: 20px;">
                    {{ $count }}
                </div>
            @endforeach
        </div>
    </div>
</div>


<div class="py-4 max-w-full mx-auto">
    <div class="bg-white overflow-hidden shadow-lg rounded-lg border border-gray-200">
        <div class="bg-white border-b-2 border-gray-200">
            <h2 class="text-lg text-center my-2 font-semibold">Activities</h2>
            @if ($activities->isEmpty())
                <p class="text-center">No activities found.</p>
            @else
                <!-- Container with responsive width -->
                <div class="h-[200px] overflow-scroll border border-gray-300 shadow-inner sm:w-full md:w-4/5 lg:w-3/4 mx-auto">
                    <table class="border-collapse w-full">
                        <thead class="bg-gray-100">
                            <tr>
                                <!-- Title column fixed width -->
                                <th
                                    class="sticky left-0 z-10 bg-gray-100 px-4 py-2 text-left whitespace-nowrap w-[200px] sm:w-[250px] border border-gray-300">
                                    Title</th>
                                <!-- Other columns with responsive width -->
                                <th
                                    class="px-4 py-2 text-left whitespace-nowrap border border-gray-300 w-[120px] sm:w-[150px]">
                                    Date</th>
                                <th
                                    class="px-4 py-2 text-left whitespace-nowrap border border-gray-300 w-[160px] sm:w-[200px]">
                                    Change Status</th>
                                <th
                                    class="px-4 py-2 text-left whitespace-nowrap border border-gray-300 w-[200px] sm:w-[250px]">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @foreach ($activities as $activity)
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
                                                        $currentLine .=
                                                            ($currentLine ? ' ' : '') . $word;
                                                    } else {
                                                        $currentLine = &$line2;
                                                        $currentLine .=
                                                            ($currentLine ? ' ' : '') . $word;
                                                    }
                                                }

                                                $line2 =
                                                    strlen($line2) > 20
                                                        ? substr($line2, 0, 22) . '...'
                                                        : $line2;
                                            @endphp
                                            <div>{{ $line1 }}</div>
                                            <div>{{ $line2 }}</div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap border border-gray-300">
                                        {{ $activity->date->format('Y-m-d') }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap border border-gray-300">
                                        @if ($activity->status === 'completed')
                                            <span class="text-green-600 font-medium">Completed</span>
                                        @else
                                            <form
                                                action="{{ route('activities.updateStatus', $activity) }}"
                                                method="POST" class="flex items-center">
                                                @csrf
                                                @method('PATCH')
                                                <div class="flex w-[140px]">
                                                    <select name="status"
                                                        class="text-xs w-24 rounded-l-md border-r-0 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                        @foreach (App\Models\Activity::STATUSES as $status)
                                                            @if ($status !== 'completed')
                                                                <option value="{{ $status }}"
                                                                    {{ $activity->status === $status ? 'selected' : '' }}>
                                                                    {{ ucfirst($status) }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    <button type="submit"
                                                        class="px-1.5 py-0.5 bg-blue-500 text-white text-xs rounded-r-md hover:bg-blue-600 border border-blue-500">
                                                        save
                                                    </button>
                                                </div>
                                            </form>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap border border-gray-300">
                                        <div class="relative inline-block">
                                            <a href="{{ route('activities.show', $activity) }}"
                                                class="text-blue-500 hover:underline inline-flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" fill="currentColor"
                                                    class="bi bi-eye translate-y-[2px]"
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

                                        <div class="relative inline-block ml-8">
                                            <a href="{{ route('activities.edit', $activity) }}"
                                                class="hover:underline inline-flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" fill="black"
                                                    class="bi bi-pencil-square translate-y-[2px]"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                    <path fill-rule="evenodd"
                                                        d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                                </svg>
                                                <span
                                                    class="tooltip-text absolute invisible bg-black text-white text-xs rounded py-1 px-2 -mt-16 -ml-8 whitespace-nowrap opacity-0 transition-opacity duration-300 hover:opacity-100">Edit
                                                    Activity</span>
                                            </a>
                                        </div>

                                        <div class="relative inline-block ml-8">
                                            <a href="{{ route('activities.show_signups', $activity) }}"
                                                class="text-purple-500 hover:underline inline-flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" fill="purple"
                                                    class="bi bi-people-fill translate-y-[2px]"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                                </svg>
                                                <span
                                                    class="tooltip-text absolute invisible bg-black text-white text-xs rounded py-1 px-2 -mt-16 -ml-8 whitespace-nowrap opacity-0 transition-opacity duration-300 hover:opacity-100">Manage
                                                    Volunteers</span>
                                            </a>
                                        </div>

                                        <div class="relative inline-block ml-8">
                                            <a href="{{ route('activities.timeline', $activity) }}" 
                                               class="text-indigo-700 hover:underline inline-flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" 
                                                     class="bi bi-clock-history translate-y-[2px]" viewBox="0 0 16 16">
                                                    <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022l-.074.997zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342l-.36.933zm1.37.71a7.01 7.01 0 0 0-.439-.27l.493-.87a8.025 8.025 0 0 1 .979.654l-.615.789a6.996 6.996 0 0 0-.418-.302zm1.834 1.79a6.99 6.99 0 0 0-.653-.796l.724-.69c.27.285.52.59.747.91l-.818.576zm.744 1.352a7.08 7.08 0 0 0-.214-.468l.893-.45a7.976 7.976 0 0 1 .45 1.088l-.95.313a7.023 7.023 0 0 0-.179-.483zm.53 2.507a6.991 6.991 0 0 0-.1-1.025l.985-.17c.067.386.106.778.116 1.17l-1 .025zm-.131 1.538c.033-.17.06-.339.081-.51l.993.123a7.957 7.957 0 0 1-.23 1.155l-.964-.267c.046-.165.086-.332.12-.501zm-.952 2.379c.184-.29.346-.594.486-.908l.914.405c-.16.36-.345.706-.555 1.038l-.845-.535zm-.964 1.205c.122-.122.239-.248.35-.378l.758.653a8.073 8.073 0 0 1-.401.432l-.707-.707z"/>
                                                    <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0v1z"/>
                                                    <path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z"/>
                                                </svg>
                                                <span class="tooltip-text absolute invisible bg-black text-white text-xs rounded py-1 px-2 -mt-16 -ml-8 whitespace-nowrap opacity-0 transition-opacity duration-300 hover:opacity-100">
                                                    View Timeline
                                                </span>
                                            </a>
                                        </div>

                                        @if ($activity->status !== 'completed')
                                            <div class="relative inline-block ml-8">
                                                <a href="{{ route('activities.complete', $activity) }}"
                                                    class="inline-flex items-center px-2 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        width="20" height="20"
                                                        fill="currentColor" class="bi bi-check mr-1"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                                                    </svg>
                                                    Complete
                                                </a>
                                            </div>
                                        @endif

                                        <style>
                                            .relative:hover .tooltip-text {
                                                visibility: visible;
                                                opacity: 1;
                                            }
                                        </style>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
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
        const currentYearElement = picker.querySelector('.year-option[data-year="{{ $currentYear }}"]');
        if (currentYearElement) {
            picker.scrollTop = currentYearElement.offsetTop - (picker.offsetHeight / 2) + (currentYearElement.offsetHeight / 2);
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