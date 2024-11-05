<x-app-layout>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 min-h-screen">
        <!-- Centered container with responsive padding and vertical spacing -->
        <div class="p-1 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Following
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Accomplished activities from organizations and volunteers you follow.
                </p>
                <div class="mt-4 text-center">
                    <a href="{{ route('following.manage') }}" class="btn text-center">
                        Manage Following
                    </a>
                </div>
                <a href="{{ route('favorites.show') }}" class="btn text-center">
                    <i class="fas fa-arrow-left"></i> Back to Favorites
                </a>
            </div>


            <div x-data="{ activityTab: 'organizations' }" class="border-t border-gray-200 mt-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 px-4 py-5 sm:px-6">
                    Recent Accomplished Activities
                </h3>
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
    <x-image-popup />
</x-app-layout>
