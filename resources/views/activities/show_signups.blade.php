<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Volunteer Sign-ups for') }} {{ $activity->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Volunteers</h3>
                    @if($activity->status == 'closed')
                        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">This activity is closed and no longer accepting new registrations.</span>
                        </div>
                    @endif
                    <!-- Display accepted volunteers count -->
                    <p class="mb-4">
                        Accepted Volunteers: {{ $activity->confirmed_volunteers_count }} / {{ $activity->max_volunteers ?? 'No limit' }}
                    </p>

                    <!-- Display success message -->
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <!-- Display error message -->
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <!-- Search and Filter Form -->
                    <form action="{{ route('activities.show_signups', $activity) }}" method="GET" class="mb-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-1">
                                <label for="search" class="block text-sm font-medium text-gray-700">Search by Name</label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                            <div class="flex-1">
                                <label for="points_range" class="block text-sm font-medium text-gray-700">Filter by Points (0-1000)</label>
                                <div class="flex items-center space-x-2">
                                    <input type="range" name="min_points" id="min_points" min="0" max="1000" value="{{ request('min_points', 0) }}" class="w-full">
                                    <span id="min_points_value">{{ request('min_points', 0) }}</span>
                                    <span>-</span>
                                    <input type="range" name="max_points" id="max_points" min="0" max="1000" value="{{ request('max_points', 1000) }}" class="w-full">
                                    <span id="max_points_value">{{ request('max_points', 1000) }}</span>
                                </div>
                            </div>
                            <div class="flex-none">
                                <button type="submit" class="mt-6 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                    Apply Filters
                                </button>
                            </div>
                        </div>
                    </form>

                    @if($volunteers->isEmpty())
                        <p>No volunteers have signed up yet.</p>
                    @else
                        <form action="{{ route('activities.update_multiple_volunteer_status', $activity) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="overflow-x-auto">
                                <table class="w-full table-auto">
                                    <thead>
                                        <tr class="bg-gray-100">
                                            <th class="px-4 py-2 text-left">
                                                <input type="checkbox" id="select-all" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            </th>
                                            <th class="px-4 py-2 text-left">Name</th>
                                            <th class="px-4 py-2 text-left">Points</th>
                                            <th class="px-4 py-2 text-left">Badges</th>
                                            <th class="px-4 py-2 text-left">Status</th>
                                            <th class="px-4 py-2 text-left">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($volunteers as $volunteer)
                                            <tr class="border-b">
                                                <td class="px-4 py-2">
                                                    <input type="checkbox" name="selected_volunteers[]" value="{{ $volunteer->userid }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                </td>
                                                <td class="px-4 py-2">{{ $volunteer->Name }}</td>
                                                <td class="px-4 py-2">{{ $volunteer->Points }}</td>
                                                <td class="px-4 py-2">Badges</td>
                                                <td class="px-4 py-2">
                                                    {{ ucfirst($volunteer->pivot->approval_status) }}
                                                </td>
                                                <td class="px-4 py-2">
                                                    <a href="{{ route('profile.public', $volunteer->userid) }}" class="text-blue-500 hover:underline">View Profile</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4 flex items-center">
                                <select name="approval_status" class="mr-2 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="pending">Pending</option>
                                    <option value="approved">Approved</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                    Update Selected Volunteers
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('select-all').addEventListener('change', function() {
            var checkboxes = document.getElementsByName('selected_volunteers[]');
            for (var checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        });

        // Update point range values
        document.getElementById('min_points').addEventListener('input', function() {
            document.getElementById('min_points_value').textContent = this.value;
        });
        document.getElementById('max_points').addEventListener('input', function() {
            document.getElementById('max_points_value').textContent = this.value;
        });
    </script>
</x-app-layout>