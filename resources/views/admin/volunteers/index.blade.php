<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-6 bg-gradient-to-r from-blue-600 via-green-500 to-blue-500 inline-block text-transparent bg-clip-text">
                        Volunteer Management
                    </h2>

                    <!-- Search and Filter Section -->
                    <form action="" method="GET" class="mb-6">
                    <div class="mb-6 flex flex-col sm:flex-row gap-4">
                        <div class="flex-1">
                            <input type="text" 
                                   name="search"
                                   placeholder="Search volunteers..." 
                                   value="{{ request('search') }}"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        </div>
                        <div class="flex gap-4">
                            <select name="district" class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <option value="">Filter by District</option>
                                @foreach(config('districts.districts') as $district)
                                    <option value="{{ strtolower($district) }}" {{ request('district') == strtolower($district) ? 'selected' : '' }}>
                                        {{ $district }}
                                    </option>
                                @endforeach
                            </select>
                            <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <option value="">Filter by Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">
                            Apply Filters
                        </button>
                    </form>
                    </div>

                    <!-- Table Section -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 text-left">Profile</th>
                                    <th class="px-4 py-2 text-left">Basic Info</th>
                                    <th class="px-4 py-2 text-left">Contact</th>
                                    <th class="px-4 py-2 text-left">Stats</th>
                                    <th class="px-4 py-2 text-left">Status</th>
                                    <th class="px-4 py-2 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($volunteers as $volunteer)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-4 py-2">
                                            <div class="flex items-center space-x-3">
                                                <img src="{{ $volunteer->getProfilePicturePath() }}" 
                                                     alt="{{ $volunteer->Name }}" 
                                                     class="w-10 h-10 rounded-full object-cover">
                                                <span class="font-medium">{{ $volunteer->Name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-2">
                                            <div class="text-sm">
                                                <p>ID: {{ $volunteer->user->userid }}</p>
                                                <p>Age: {{ \Carbon\Carbon::parse($volunteer->DOB)->age }}</p>
                                                <p>Gender: {{ $volunteer->Gender }}</p>
                                            </div>
                                        </td>
                                        <td class="px-4 py-2">
                                            <div class="text-sm">
                                                <p>{{ $volunteer->Phone }}</p>
                                                <p>{{ $volunteer->user->email }}</p>
                                                <p>{{ $volunteer->District }}</p>
                                            </div>
                                        </td>
                                        <td class="px-4 py-2">
                                            <div class="text-sm">
                                                <p>Activities: {{ $volunteer->activities->count() }}</p>
                                                <p>Hours: {{ $volunteer->activities->sum('duration') }}</p>
                                                <p>Following: {{ $volunteer->followedOrganizations->count() }}</p>
                                            </div>
                                        </td>
                                        <td class="px-4 py-2">
                                            <span class="px-2 py-1 text-xs rounded-full {{ $volunteer->user->verified ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $volunteer->user->verified ? 'Active' : 'Suspended' }}
                                            </span>
                                            <form action="{{ route('admin.users.toggle-status', $volunteer->user) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-sm text-blue-600 hover:text-blue-900">
                                                    {{ $volunteer->user->verified ? 'Suspend Account' : 'Activate Account' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td class="px-4 py-2">
                                            <a href="{{ route('admin.volunteers.edit', $volunteer) }}" 
                                               class="text-blue-600 hover:text-blue-900">
                                                Edit Details
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $volunteers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>