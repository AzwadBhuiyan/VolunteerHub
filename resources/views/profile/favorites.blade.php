<x-app-layout>
    <link href="{{ asset('css/volunteer-profile.css') }}" rel="stylesheet">
 
    {{-- <div class="p-4 sm:p-8 bg-white items-center shadow sm:rounded-lg">
        <div class="px-1">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-8"> --}}

    <div class="max-w-7xl mx-auto px-1 sm:px-6 lg:px-8 min-h-screen">
        <!-- Centered container with responsive padding and vertical spacing -->
        <div class="p-1 sm:p-8 bg-white items-center shadow sm:rounded-lg h-full bg-red-500">
            @if (
                !$favorites ||
                    (empty($favorites->favorite_categories) &&
                        empty($favorites->favorite_districts) &&
                        $volunteer->followedOrganizations->isEmpty()))
                <div class="bg-yellow-100 border-yellow-500 text-yellow-700 p-4 mt-4 flex items-center" role="alert">
                    <i class="bi bi-exclamation-triangle-fill text-2xl mr-4"></i>
                    <p>Please select your favorite categories and locations to see your favorite activities here.</p>
                </div>
                <div class="text-center">
                    <a href="{{ route('favorites.edit') }}" class="btn mt-4">
                        <i class="fas fa-plus"></i>Add Favorites
                    </a>
                </div>
            @else
                <div class="text-center">
                    <a href="{{ route('favorites.edit') }}" class="btn text-center mt-4">
                        <i class="fas fa-pen"></i>Edit Favorites
                    </a>
                    <a href="{{ route('following.index') }}" class="btn text-center mt-4 ml-4">
                        <i class="fas fa-users"></i>Following
                    </a>
                </div>
            @endif

            <div x-data="{ tab: 'ongoing' }" class="mb-6 mt-6">
                <div class="flex justify-center space-x-2 mb-4 w-full">
                    <button @click="tab = 'ongoing'"
                        :class="{ 'bg-gray-800': tab === 'ongoing', 'bg-gray-400': tab !== 'ongoing', 'shadow-lg': tab === 'ongoing', 'border-2 border-black': tab === 'ongoing' }"
                        class="w-1/2 px-4 py-2 text-white rounded flex items-center justify-center">
                        <i class="fas fa-check mr-2" x-show="tab === 'ongoing'"></i> Ongoing
                    </button>
                    <button @click="tab = 'ideas'"
                        :class="{ 'bg-gray-800': tab === 'ideas', 'bg-gray-400': tab !== 'ideas', 'shadow-lg': tab === 'ideas', 'border-2 border-black': tab === 'ideas' }"
                        class="w-1/2 px-4 py-2 text-white rounded flex items-center justify-center">
                        <i class="fas fa-check mr-2" x-show="tab === 'ideas'"></i> Ideas
                    </button>
                </div>

                <div x-show="tab === 'ongoing'">
                    @if ($ongoingActivities->isEmpty())
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <p class="text-gray-700">There are no ongoing activities that match your favorites.</p>
                        </div>
                    @else
                        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-4">
                            <!-- Match the same container structure -->
                            @foreach ($ongoingActivities as $activity)
                                <div
                                    class="rounded-lg mb-4 overflow-hidden flex flex-col shadow-lg border border-gray-200">
                                    <!-- Activity Header -->
                                    <div class="p-3 flex items-center space-x-4 border-b  border-gray-100">
                                        <img src="{{ asset($activity->organization->getLogoPath()) }}"
                                            alt="{{ $activity->organization->org_name }}"
                                            class="w-10 h-10 rounded-full object-cover">
                                        <div class="flex flex-col ml-4">
                                            <h4 class="text-base font-semibold text-gray-800">{{ $activity->title }}
                                            </h4>
                                            <div class="text-xs text-gray-500">
                                                <a href="{{ route('profile.public', $activity->organization->url) }}"
                                                    class="text-blue-500 hover:underline">{{ $activity->organization->org_name }}</a>
                                                <span>.</span>
                                                <span>{{ $activity->date->format('M d, Y') }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Activity Description -->
                                    <div class="px-3 py-1">
                                        <p class=" text-sm text-gray-700 leading-relaxed">
                                            {{ Str::limit($activity->description, 150) }}</p>
                                    </div>

                                    <!-- Activity Images -->
                                    <div class="px-2 py-2">
                                        <div class="aspect-w-1 aspect-h-1">
                                            <x-activity-ongoing-image :activity="$activity" />
                                        </div>
                                    </div>

                                    <!-- Activity Footer -->
                                    <div class="px-2 py-2 bg-gray-50 mt-auto">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <span class="text-sm ">Organized by:</span>
                                                <a href="{{ route('profile.public', $activity->organization->url) }}"
                                                    class="text-blue-500 hover:underline">{{ $activity->organization->org_name }}</a>
                                            </div>
                                            <a href="{{ route('activities.show', $activity) }}"
                                                class=" text-sm bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded">View
                                                Details</a>
                                        </div>
                                    </div>

                                    <!-- Priority Score -->
                                    {{-- <div class="px-4 py-2 bg-gray-100">
                                            <p class="text-sm text-gray-600">Priority Score: {{ $activity->priority_score }}</p>
                                        </div> --}}
                                </div>
                            @endforeach
                        </div>
                        {{ $ongoingActivities->links() }}
                    @endif
                </div>


                <div x-show="tab === 'ideas'">
                    @if ($ideas->isEmpty())
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <p class="text-gray-700">There is no new idea threads from your following organizations</p>
                        </div>
                    @else
                        @foreach ($ideas as $idea)
                            <div class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col mb-4">
                                <!-- Idea content -->
                                @include('components.idea-card', ['idea' => $idea])
                            </div>
                        @endforeach
                        {{ $ideas->links() }}
                    @endif
                </div>
            </div>
        </div>
        {{-- </div> --}}
    </div>
    <x-image-popup />
</x-app-layout>
