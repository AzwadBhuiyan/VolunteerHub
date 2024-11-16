<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-6 bg-gradient-to-r from-blue-600 via-green-500 to-blue-500 inline-block text-transparent bg-clip-text">Activity Management</h2>

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