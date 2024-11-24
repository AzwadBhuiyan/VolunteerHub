<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 min-h-screen">
        <div
            class="w-full p-5 mx-auto shadow-lg flex flex-col items-center justify-center bg-gray-800 text-white text-center">
            <i class="fas fa-list text-lg text-green-500"></i>

            <h2
                class="bg-gradient-to-r from-blue-600 via-green-500 to-blue-500 inline-block text-transparent bg-clip-text text-lg font-bold mt-2 mb-2">
                Volunteer Activity Requests</h2>
            <p class="text-base">Explore volunteer activity requests from various regions across Bangladesh.
                Transform these requests into impactful projects and contribute to community development.
            </p>
        </div>

        <!-- Centered container with responsive padding and vertical spacing -->
        <div class="p-1 sm:p-8 bg-white shadow mb-0">



            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">

                <div class="max-w-3xl mx-auto mt-4 mb-0 pb-0">
                    @foreach ($completedActivities as $activity)
                        <div class="border border-gray-300 shadow-lg rounded-lg overflow-hidden mb-4">
                            <!-- Activity Header -->
                            <div class="p-3 flex items-center space-x-4 border-b border-gray-100">
                                <img src="{{ asset($activity->organization->getLogoPath()) }}"
                                    alt="{{ $activity->organization->org_name }}"
                                    class="w-10 h-10 rounded-full object-cover">
                                <div class="flex flex-col ml-4">
                                    <h4 class="text-base font-semibold text-gray-800">{{ $activity->title }}</h4>
                                    <div class="text-xs text-gray-500">
                                        <a href="{{ route('profile.public', $activity->organization->url) }}"
                                            class="text-blue-500 hover:underline">
                                            {{ $activity->organization->org_name }}
                                        </a>
                                        <span>.</span>
                                        <span>{{ $activity->date->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Activity Description -->
                            <div class="px-3 py-1">
                                <p class="text-sm text-gray-700 leading-relaxed">
                                    {{ $activity->accomplished_description }}
                                </p>
                            </div>

                            <!-- Activity Images -->
                            <div class="px-2 py-2">
                                <div class="aspect-w-1 aspect-h-1 w-full h-64">
                                    <x-activity-completed-images :activity="$activity" class="clickable-image" />
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="mt-4">
                        {{ $completedActivities->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-image-popup />
</x-app-layout>
