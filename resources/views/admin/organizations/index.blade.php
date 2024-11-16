<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-6 bg-gradient-to-r from-blue-600 via-green-500 to-blue-500 inline-block text-transparent bg-clip-text">Organization Management</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($organizations as $organization)
                            <div class="bg-white p-4 rounded-lg shadow border border-gray-200">
                                <div class="flex items-center space-x-4">
                                    <img src="{{ asset($organization->getLogoPath()) }}"
                                         alt="{{ $organization->org_name }}" 
                                         class="w-16 h-16 rounded-full object-cover">
                                    <div>
                                        <h3 class="font-semibold">{{ $organization->org_name }}</h3>
                                        <p class="text-sm text-gray-600">ID: {{ $organization->user->userid }}</p>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('admin.organizations.edit', $organization) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors">
                                        Edit Details
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        {{ $organizations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>