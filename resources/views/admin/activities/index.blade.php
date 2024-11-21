<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-6 bg-gradient-to-r from-blue-600 via-green-500 to-blue-500 inline-block text-transparent bg-clip-text">Activity Management</h2>

                    <!-- search and filter -->
                    <form action="" method="GET" class="mb-6">
                    <div class="mb-6 flex flex-col sm:flex-row gap-4">
                        <div class="flex-1">
                            <input type="text" 
                                name="search"
                                placeholder="Search activities..." 
                                value="{{ request('search') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        </div>
                        <div class="flex gap-4">
                            <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <option value="">Filter by Status</option>
                                <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                                <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                            <select name="organization" class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <option value="">Filter by Organization</option>
                                @foreach($organizations as $org)
                                    <option value="{{ $org->userid }}" {{ request('organization') == $org->userid ? 'selected' : '' }}>
                                        {{ $org->org_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">
                            Apply Filters
                        </button>
                    </div>
                    </form>
                    
                    <!-- Add Close Expired Activities Button -->
                    <form action="{{ route('admin.activities.close-expired') }}" method="POST" class="inline ml-2">
                        @csrf
                        <button type="submit" 
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"/>
                            </svg>
                            Close Expired Activities
                        </button>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2">Title</th>
                                    <th class="px-4 py-2">Organization</th>
                                    <th class="px-4 py-2">Date</th>
                                    <th class="px-4 py-2">Status</th>
                                    <th class="px-4 py-2">Volunteers</th>
                                    <th class="px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($activities as $activity)
                                <tr class="border-b">
                                    <td class="px-4 py-2">{{ $activity->title }}</td>
                                    <td class="px-4 py-2">{{ $activity->organization->org_name }}</td>
                                    <td class="px-4 py-2">{{ $activity->date->format('M d, Y') }}</td>
                                    <td class="px-4 py-2">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($activity->status === 'completed') bg-green-100 text-green-800 
                                            @elseif($activity->status === 'ongoing') bg-blue-100 text-blue-800
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                            {{ ucfirst($activity->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2">{{ $activity->volunteers->count() }}</td>
                                    <td class="px-4 py-2">
                                        <a href="{{ route('activities.show', $activity) }}" 
                                           class="text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded inline-block">
                                            View
                                        </a>
                                        
                                        <form action="{{ route('admin.activities.delete', $activity) }}" method="POST" class="inline ml-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded"
                                                    onclick="return confirm('Are you sure you want to delete this activity?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $activities->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>