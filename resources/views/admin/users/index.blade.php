<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-4">User Management</h2>

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2">User ID</th>
                                    <th class="px-4 py-2">Email</th>
                                    <th class="px-4 py-2">Role</th>
                                    <th class="px-4 py-2">Status</th>
                                    <th class="px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr class="border-b">
                                    <td class="px-4 py-2">{{ $user->userid }}</td>
                                    <td class="px-4 py-2">{{ $user->email }}</td>
                                    <td class="px-4 py-2">{{ ucfirst($user->role) }}</td>
                                    <td class="px-4 py-2">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $user->verified ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $user->verified ? 'Active' : 'Disabled' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2">
                                        <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded">
                                                {{ $user->verified ? 'Disable' : 'Enable' }}
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('admin.users.delete', $user) }}" method="POST" class="inline ml-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded"
                                                onclick="return confirm('Are you sure you want to delete this user?')">
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
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>