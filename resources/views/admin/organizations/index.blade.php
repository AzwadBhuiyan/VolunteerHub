<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-6 bg-gradient-to-r from-blue-600 via-green-500 to-blue-500 inline-block text-transparent bg-clip-text">
                        Organization Management
                    </h2>

                    <!-- Search and Filter Section -->
                    <form action="" method="GET" class="mb-6">
                    <div class="mb-6 flex flex-col sm:flex-row gap-4">
                        <div class="flex-1">
                            <input type="text" 
                                   name="search"
                                   placeholder="Search organizations..." 
                                   value="{{ request('search') }}"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        </div>
                        <div class="flex gap-4">
                            <select name="verification" class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <option value="">Filter by Verification</option>
                                <option value="verified" {{ request('verification') == 'verified' ? 'selected' : '' }}>Verified</option>
                                <option value="unverified" {{ request('verification') == 'unverified' ? 'selected' : '' }}>Unverified</option>
                            </select>
                            <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <option value="">Filter by Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
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
                                    <th class="px-4 py-2 text-left">Organization</th>
                                    <th class="px-4 py-2 text-left">Contact Info</th>
                                    <th class="px-4 py-2 text-left">Address</th>
                                    <th class="px-4 py-2 text-left">Stats</th>
                                    <th class="px-4 py-2 text-left">Status</th>
                                    <th class="px-4 py-2 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($organizations as $organization)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-4 py-2">
                                            <div class="flex items-center space-x-3">
                                                <img src="{{ asset($organization->getLogoPath()) }}" 
                                                     alt="{{ $organization->org_name }}" 
                                                     class="w-10 h-10 rounded-full object-cover">
                                                <div>
                                                    <span class="font-medium">{{ $organization->org_name }}</span>
                                                    <p class="text-sm text-gray-600">ID: {{ $organization->userid }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-2">
                                            <div class="text-sm">
                                                <p>Email: {{ $organization->user->email }}</p>
                                                <p>Mobile: {{ $organization->org_mobile }}</p>
                                                <p>Tel: {{ $organization->org_telephone }}</p>
                                                <p class="text-blue-600">{{ $organization->website }}</p>
                                            </div>
                                        </td>
                                        <td class="px-4 py-2">
                                            <div class="text-sm">
                                                <p><strong>Primary:</strong> {{ $organization->primary_address }}</p>
                                                @if($organization->secondary_address)
                                                    <p><strong>Secondary:</strong> {{ $organization->secondary_address }}</p>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-4 py-2">
                                            <div class="text-sm">
                                                <p>Activities: {{ $organization->activities->count() }}</p>
                                                <p>Followers: {{ $organization->followers->count() }}</p>
                                                <p>Ideas: {{ $organization->ideaThreads->count() }}</p>
                                            </div>
                                        </td>
                                        <td class="px-4 py-2">
                                            <div class="flex flex-col gap-2">
                                                <span class="px-2 py-1 text-xs rounded-full {{ $organization->user->verified ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $organization->user->verified ? 'Active' : 'Suspended' }}
                                                </span>
                                                <form action="{{ route('admin.users.toggle-status', $organization->user) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-sm text-blue-600 hover:text-blue-900">
                                                        {{ $organization->user->verified ? 'Suspend Account' : 'Activate Account' }}
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.organizations.toggle-verification', $organization) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-sm text-blue-600 hover:text-blue-900">
                                                        {{ $organization->verification_status === 'verified' ? 'Revoke Verification' : 'Verify Documents' }}
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                        <td class="px-4 py-2">
                                            <div class="flex flex-col gap-2">
                                                <a href="{{ route('admin.organizations.edit', $organization) }}" 
                                                   class="text-blue-600 hover:text-blue-900">
                                                    Edit Details
                                                </a>
                                                <a href="{{ route('profile.public', $organization->url) }}" 
                                                   class="text-green-600 hover:text-green-900"
                                                   target="_blank">
                                                    Public Profile
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $organizations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>