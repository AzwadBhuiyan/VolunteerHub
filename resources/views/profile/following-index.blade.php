<x-app-layout>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 min-h-screen">
        <!-- Centered container with responsive padding and vertical spacing -->
        <div class="p-1 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="w-full p-5 mx-auto shadow-lg mb-4 flex flex-col items-center justify-center bg-gray-800 text-white">
                <i class="fas fa-users text-lg text-green-500"></i>
           
                <h2 class="bg-gradient-to-r from-blue-600 via-green-500 to-blue-500 inline-block text-transparent bg-clip-text text-lg font-bold mt-2 mb-2">
                    Your Volunteer Network
                </h2>
                <p class="text-base text-center">Stay connected with inspiring organizations and fellow volunteers. Together, we create a stronger community of changemakers dedicated to making a positive impact.</p>

                <div class="flex flex-col sm:flex-row gap-4 mt-4">
                    <a href="{{ route('following.manage') }}" class="inline-flex items-center justify-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-blue-600 to-blue-800 hover:from-green-900 hover:to-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-lg hover:shadow-xl">
                        <i class="fas fa-users mr-2"></i> Manage Following
                    </a>

                    <a href="{{ route('favorites.show') }}" class="inline-flex items-center justify-center px-6 py-2.5 border border-gray-300 text-sm font-medium rounded-md text-gray-200 bg-gray-700 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200 shadow hover:shadow-md">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Favorites
                    </a>
                </div>
            </div>

            <h3 class="text-lg sm:text-xl font-semibold mb-4 py-3 text-center"
            style="border-bottom: 2px solid #8B9467; width: 50%; margin: 0 auto;">Recent Accomplishments from your Following</h3>
            <div x-data="{ activityTab: 'organizations' }" class="border-t border-gray-200 mt-6">
             
                <div class="flex justify-center space-x-2 mb-4 w-full">
                    <button @click="activityTab = 'organizations'"
                        :class="{ 'bg-gray-800': activityTab === 'organizations', 'bg-gray-400': activityTab !== 'organizations' }"
                        class="w-1/2 px-4 py-2 text-white rounded">
                        Organizations
                    </button>
                    <button @click="activityTab = 'volunteers'"
                        :class="{ 'bg-gray-800': activityTab === 'volunteers', 'bg-gray-400': activityTab !== 'volunteers' }"
                        class="w-1/2 px-4 py-2 text-white rounded">
                        Volunteers
                    </button>
                </div>

                <div x-show="activityTab === 'organizations'">
                    @if ($followedOrganizations->isEmpty())
                            <div class="bg-white rounded-xl shadow-lg p-6">
                                <p class="text-gray-700">You are not following any organizations yet.</p>
                            </div>
                    @endif
                    @if ($completedOrganizationActivities->isEmpty())
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <p class="text-gray-700">No recent activities from followed organizations.</p>
                        </div>
                    @else
                        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-4">
                            @foreach ($completedOrganizationActivities as $activity)
                                <div class="rounded-lg mb-4 overflow-hidden flex flex-col shadow-lg border border-gray-200">
                                    <div class="p-3 flex items-center space-x-4 border-b border-gray-100">
                                        <img src="{{ asset($activity->organization->getLogoPath()) }}"
                                            alt="{{ $activity->organization->org_name }}"
                                            class="w-10 h-10 rounded-full object-cover">
                                        <div class="flex flex-col ml-4">
                                            <h4 class="text-base font-semibold text-gray-800">
                                                <a href="{{ route('activities.show_accomplished', $activity) }}" class="hover:text-blue-600 transition-colors">
                                                    {{ $activity->title }}
                                                </a>
                                            </h4>
                                            <div class="text-xs text-gray-500">
                                                <a href="{{ route('profile.public', $activity->organization->url) }}"
                                                    class="text-blue-500 hover:underline">{{ $activity->organization->org_name }}</a>
                                                <span>.</span>
                                                <span>{{ $activity->date->format('M d, Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-3 py-1">
                                        <p class="text-sm text-gray-700 leading-relaxed">
                                            {{ Str::limit($activity->accomplished_description, 150) }}</p>
                                    </div>
                                    <div class="px-2 py-2">
                                        <div class="aspect-w-1 aspect-h-1 w-full h-64">
                                            <a href="{{ route('activities.show_accomplished', $activity) }}" class="block w-full h-full">
                                                <x-activity-completed-images :activity="$activity" class="clickable-image hover:opacity-90 transition-opacity" />
                                            </a>
                                        </div>
                                    </div>
                                    
                                </div>
                            @endforeach
                        </div>
                        {{ $completedOrganizationActivities->links() }}
                    @endif
                </div>

                <div x-show="activityTab === 'volunteers'">
                    @if ($followedVolunteers->isEmpty())
                            <div class="bg-white rounded-xl shadow-lg p-6">
                                <p class="text-gray-700">You are not following any volunteers yet.</p>
                            </div>
                    @endif
                    @if ($completedVolunteerActivities->isEmpty())
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <p class="text-gray-700">No recent activities from followed volunteers.</p>
                        </div>
                    @else
                        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-4">
                            @foreach ($completedVolunteerActivities as $activity)
                                <div class="rounded-lg mb-4 overflow-hidden flex flex-col shadow-lg border border-gray-200">
                                    <div class="p-3 flex items-center space-x-4 border-b border-gray-100">
                                        <img src="{{ asset($activity->organization->getLogoPath()) }}"
                                            alt="{{ $activity->organization->org_name }}"
                                            class="w-10 h-10 rounded-full object-cover">
                                        <div class="flex flex-col ml-4">
                                            <h4 class="text-base font-semibold text-gray-800">{{ $activity->title }}</h4>
                                            <div class="text-xs text-gray-500">
                                                <a href="{{ route('profile.public', $activity->organization->url) }}"
                                                    class="text-blue-500 hover:underline">{{ $activity->organization->org_name }}</a>
                                                <span>.</span>
                                                <span>{{ $activity->date->format('M d, Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-3 py-1">
                                        <p class="text-sm text-gray-700 leading-relaxed">
                                            {{ Str::limit($activity->accomplished_description, 150) }}</p>
                                    </div>
                                    <div class="px-2 py-2">
                                        <div class="aspect-w-1 aspect-h-1 w-full h-64">
                                            <x-activity-completed-images :activity="$activity" />
                                        </div>
                                    </div>
                                    <div class="px-2 py-2 bg-gray-50 mt-auto">

                                        <!-- list of followed volunteers involved -->
                                        <div class="px-2 py-2 bg-gray-50">
                                            <h5 class="text-sm font-semibold text-gray-700 mb-2">Followed Volunteers Involved:</h5>
                                            @if ($activity->volunteers->isNotEmpty())
                                                <p class="text-xs text-gray-600">
                                                    @foreach ($activity->volunteers as $volunteer)
                                                        <a href="{{ route('profile.public', $volunteer->url) }}" class="text-blue-500 hover:underline">
                                                            {{ $volunteer->Name }}
                                                        </a>{{ !$loop->last ? ', ' : '' }}
                                                    @endforeach
                                                </p>
                                            @else
                                                <p class="text-xs text-gray-500">No followed volunteers involved in this activity.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{ $completedVolunteerActivities->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- <x-image-popup /> -->
</x-app-layout>
