<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-6 bg-gradient-to-r from-blue-600 via-green-500 to-blue-500 inline-block text-transparent bg-clip-text">Idea Thread Management</h2>

                    <!-- search and filer -->
                    <form action="" method="GET" class="mb-6">
                    <div class="mb-6 flex flex-col sm:flex-row gap-4">
                        <div class="flex-1">
                            <input type="text" 
                                name="search"
                                placeholder="Search idea threads..." 
                                value="{{ request('search') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        </div>
                        <div class="flex gap-4">
                            <select name="organization" class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <option value="">Filter by Organization</option>
                                @foreach($organizations as $org)
                                    <option value="{{ $org->userid }}" {{ request('organization') == $org->userid ? 'selected' : '' }}>
                                        {{ $org->org_name }}
                                    </option>
                                @endforeach
                            </select>
                            <select name="date" class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <option value="">Filter by Date</option>
                                <option value="today" {{ request('date') == 'today' ? 'selected' : '' }}>Today</option>
                                <option value="week" {{ request('date') == 'week' ? 'selected' : '' }}>This Week</option>
                                <option value="month" {{ request('date') == 'month' ? 'selected' : '' }}>This Month</option>
                            </select>
                        </div>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">
                            Apply Filters
                        </button>
                    </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2">Title</th>
                                    <th class="px-4 py-2">Organization</th>
                                    <th class="px-4 py-2">Created</th>
                                    <th class="px-4 py-2">Comments</th>
                                    <th class="px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ideaThreads as $thread)
                                <tr class="border-b">
                                    <td class="px-4 py-2">{{ $thread->title }}</td>
                                    <td class="px-4 py-2">{{ $thread->organization->org_name }}</td>
                                    <td class="px-4 py-2">{{ $thread->created_at->format('M d, Y') }}</td>
                                    <td class="px-4 py-2">{{ $thread->comments->count() }}</td>
                                    <td class="px-4 py-2">
                                        <a href="{{ route('idea_board.show', $thread) }}" 
                                           class="text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded inline-block">
                                            View
                                        </a>
                                        
                                        <form action="{{ route('admin.idea-threads.delete', $thread) }}" method="POST" class="inline ml-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded"
                                                    onclick="return confirm('Are you sure you want to delete this idea thread?')">
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
                        {{ $ideaThreads->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>