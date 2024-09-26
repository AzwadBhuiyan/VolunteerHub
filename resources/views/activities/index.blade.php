<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Activity Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Activities</h3>
                    @if($activities->isEmpty())
                        <p>No activities found.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full table-auto">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-4 py-2 text-left">Title</th>
                                        <th class="px-4 py-2 text-left">Date</th>
                                        <th class="px-4 py-2 text-left">Status</th>
                                        <th class="px-4 py-2 text-left">Change Status</th>
                                        <th class="px-4 py-2 text-left">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($activities as $activity)
                                        <tr class="border-b">
                                            <td class="px-4 py-2">{{ $activity->title }}</td>
                                            <td class="px-4 py-2">{{ $activity->date->format('Y-m-d') }}</td>
                                            <td class="px-4 py-2">{{ ucfirst($activity->status) }}</td>
                                            <td class="px-4 py-2">
                                                <form action="{{ route('activities.updateStatus', $activity) }}" method="POST" class="flex items-center">
                                                    @csrf
                                                    @method('PATCH')
                                                    <select name="status" class="mr-2 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                        @foreach(App\Models\Activity::STATUSES as $status)
                                                            <option value="{{ $status }}" {{ $activity->status === $status ? 'selected' : '' }}>
                                                                {{ ucfirst($status) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @if($activity->status !== 'completed')
                                                    <button type="submit" class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                                                        Change Status
                                                    </button>
                                                    @endif
                                                </form>
                                            </td>
                                            <td class="px-4 py-2">
                                                <a href="{{ route('activities.show', $activity) }}" class="text-blue-500 hover:underline">Show</a>
                                                <a href="{{ route('activities.edit', $activity) }}" class="text-green-500 hover:underline ml-2">Edit</a>
                                                <a href="{{ route('activities.show_signups', $activity) }}" class="text-purple-500 hover:underline ml-2">Manage Volunteers</a>
                                                @if($activity->status !== 'completed')
                                                    <a href="{{ route('activities.complete', $activity) }}" class="text-yellow-500 hover:underline ml-2">Complete Activity</a>
                                                @endif
                                            </td>
                                            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $activities->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>