<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 min-h-screen">
        <!-- Centered container with responsive padding and vertical spacing -->
        <div class="p-1 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="w-full p-5 mx-auto shadow-lg mb-4 flex flex-col items-center justify-center bg-gray-800 text-white">
                <i class="fas fa-users text-lg text-green-500"></i>
           
                <h2 class="bg-gradient-to-r from-blue-600 via-green-500 to-blue-500 inline-block text-transparent bg-clip-text text-lg font-bold mt-2 mb-2">
                    Manage Your Following Network
                </h2>
                <p class="text-base text-center">Stay connected with inspiring organizations and fellow volunteers. Manage who you follow to curate your volunteer network.</p>

                <div class="flex flex-col sm:flex-row gap-4 mt-4">
                    <a href="{{ route('following.index') }}" class="inline-flex items-center justify-center px-6 py-2.5 border border-gray-300 text-sm font-medium rounded-md text-gray-200 bg-gray-700 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200 shadow hover:shadow-md">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Following
                    </a>
                </div>
            </div>

            <!-- Organizations Section -->
            <div class="border border-gray-300 bg-white rounded-lg shadow-lg mb-8">
                <h4 class="px-6 py-4 text-lg font-semibold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-blue-600 bg-gray-800 border-b-2 border-gray-200 rounded-t-lg flex items-center sticky top-0 z-10">
                    <i class="fas fa-building mr-2 text-blue-400"></i>
                    Organizations You Follow
                </h4>
                <div class="h-[300px] overflow-y-auto scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-100">
                    <ul class="divide-y divide-gray-200">
                        @forelse ($followedOrganizations as $organization)
                            <li class="px-6 py-5 hover:bg-gray-50 transition duration-150" x-data="{ showConfirmModal: false }">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <img class="h-14 w-14 rounded-lg object-cover border-2 border-gray-200 shadow-sm" 
                                                 src="{{ asset($organization->getLogoPath()) }}" 
                                                 alt="{{ $organization->org_name }}">
                                        </div>
                                        <div>
                                            <a href="{{ route('profile.public', $organization->url) }}" 
                                               class="text-base font-semibold text-gray-900 hover:text-blue-600 transition">
                                                {{ $organization->org_name }}
                                            </a>
                                            <p class="text-sm text-gray-500 mt-1">Organization • Active Member</p>
                                        </div>
                                    </div>
                                    <form class="mt-2">
                                        <button type="button" 
                                                @click="showConfirmModal = true"
                                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition shadow-sm">
                                            <i class="fas fa-user-minus mr-2"></i>
                                            Unfollow
                                        </button>
                                    </form>

                                    <!-- Compact Centered Modal -->
                                    <div x-show="showConfirmModal" 
                                         class="fixed inset-0 z-50 flex items-center justify-center" 
                                         style="display: none;">
                                        <div class="fixed inset-0 bg-black bg-opacity-30 transition-opacity" @click="showConfirmModal = false"></div>
                                        <div class="relative bg-white rounded-lg shadow-xl transform transition-all max-w-max">
                                            <div class="p-4">
                                                <div class="text-center">
                                                    <h3 class="text-sm font-medium text-gray-900 whitespace-nowrap">
                                                        Are you sure you want to unfollow {{ $organization->org_name }}?
                                                    </h3>
                                                    <div class="flex justify-center gap-2 mt-3">
                                                        <button @click="showConfirmModal = false" 
                                                                class="px-3 py-1.5 text-xs text-gray-600 border border-gray-300 rounded hover:bg-gray-50">
                                                            Cancel
                                                        </button>
                                                        <form action="{{ route('organizations.unfollow', $organization) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                    class="px-3 py-1.5 text-xs text-white bg-red-500 rounded hover:bg-red-600">
                                                                Unfollow
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="px-6 py-10 text-center">
                                <p class="text-gray-500 text-base">You are not following any organizations yet.</p>
                                <p class="text-sm text-gray-400 mt-2">Follow organizations to see their activities in your feed.</p>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- Volunteers Section -->
            <div class="border border-gray-300 bg-white rounded-lg shadow-lg">
                <h4 class="px-6 py-4 text-lg font-semibold text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-green-600 bg-gray-800 border-b-2 border-gray-200 rounded-t-lg flex items-center sticky top-0 z-10">
                    <i class="fas fa-users mr-2 text-green-400"></i>
                    Volunteers You Follow
                </h4>
                <div class="h-[300px] overflow-y-auto scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-100">
                   
                    <ul class="divide-y divide-gray-200">
                        @forelse ($followedVolunteers as $volunteer)
                            <li class="px-6 py-5 hover:bg-gray-50 transition duration-150">
                                <div class="flex items-center justify-between" x-data="{ showConfirmModal: false }">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <img class="h-14 w-14 rounded-full object-cover border-2 border-gray-200 shadow-sm" 
                                                 src="{{ asset($volunteer->getProfilePicturePath()) }}" 
                                                 alt="{{ $volunteer->Name }}">
                                        </div>
                                        <div>
                                            <a href="{{ route('profile.public', $volunteer->url) }}" 
                                               class="text-base font-semibold text-gray-900 hover:text-blue-600 transition">
                                                {{ $volunteer->Name }}
                                            </a>
                                            <p class="text-sm text-gray-500 mt-1">Volunteer • Community Member</p>
                                        </div>
                                    </div>
                                    <form class="mt-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                @click="showConfirmModal = true"
                                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition shadow-sm">
                                            <i class="fas fa-user-minus mr-2"></i>
                                            Unfollow
                                        </button>
                                    </form>

                                    <!-- Compact Centered Modal -->
                                    <div x-show="showConfirmModal" 
                                         class="fixed inset-0 z-50 flex items-center justify-center" 
                                         style="display: none;">
                                        <div class="fixed inset-0 bg-black bg-opacity-30 transition-opacity" @click="showConfirmModal = false"></div>
                                        <div class="relative bg-white rounded-lg shadow-xl transform transition-all max-w-max">
                                            <div class="p-4">
                                                <div class="text-center">
                                                    <h3 class="text-sm font-medium text-gray-900 whitespace-nowrap">
                                                        Are you sure you want to unfollow {{ $volunteer->Name }}?
                                                    </h3>
                                                    <div class="flex justify-center gap-2 mt-3">
                                                        <button @click="showConfirmModal = false" 
                                                                class="px-3 py-1.5 text-xs text-gray-600 border border-gray-300 rounded hover:bg-gray-50">
                                                            Cancel
                                                        </button>
                                                        <form action="{{ route('volunteers.unfollow', $volunteer) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                    class="px-3 py-1.5 text-xs text-white bg-red-500 rounded hover:bg-red-600">
                                                                Unfollow
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="px-6 py-10 text-center">
                                <p class="text-gray-500 text-base">You are not following any volunteers yet.</p>
                                <p class="text-sm text-gray-400 mt-2">Follow other volunteers to see their activities in your feed.</p>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
     
    </div>
</x-app-layout>