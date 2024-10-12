<x-app-layout>
    <link href="{{ asset('css/volunteer-profile.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    {{-- <div class="p-4 sm:p-8 bg-white items-center shadow sm:rounded-lg">
        <div class="px-1">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-8"> --}}

                <div class="max-w-7xl mx-auto px-1 sm:px-6 lg:px-8">
                    <!-- Centered container with responsive padding and vertical spacing -->
                    <div class="p-4 sm:p-8 bg-white items-center shadow sm:rounded-lg">
                @if (!$favorites || (empty($favorites->favorite_categories) && empty($favorites->favorite_districts)) && $volunteer->followedOrganizations->isEmpty())
                    <div class="bg-yellow-100 border-yellow-500 text-yellow-700 p-4 mb-4 flex items-center" role="alert">
                        <i class="bi bi-exclamation-triangle-fill text-2xl mr-4"></i>
                        <p>Please select your favorite categories and locations to see your favorite activities here.</p>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('favorites.edit') }}" class="btn mb-2">
                            <i class="fas fa-plus"></i>Add Favorites
                        </a>
                    </div>
                @else
                    <div class="text-center">
                        <a href="{{ route('favorites.edit') }}" class="btn text-center mb-2">
                            <i class="fas fa-pen"></i>Edit Favorites
                        </a>
                    </div>
                @endif

                <div x-data="{ tab: 'ongoing' }" class="mb-6 mt-6">
                    <div class="flex justify-center space-x-2 mb-4 w-full">
                        <button @click="tab = 'ongoing'"
                            :class="{ 'bg-gray-800': tab === 'ongoing', 'bg-gray-400': tab !== 'ongoing', 'shadow-lg': tab === 'ongoing', 'border-2 border-black': tab === 'ongoing'}"
                            class="w-1/2 px-4 py-2 text-white rounded flex items-center justify-center">
                            <i class="fas fa-check mr-2" x-show="tab === 'ongoing'"></i> Ongoing
                        </button>
                        <button @click="tab = 'ideas'"
                            :class="{ 'bg-gray-800': tab === 'ideas', 'bg-gray-400': tab !== 'ideas', 'shadow-lg': tab === 'ideas', 'border-2 border-black': tab === 'ideas'}"
                            class="w-1/2 px-4 py-2 text-white rounded flex items-center justify-center">
                            <i class="fas fa-check mr-2" x-show="tab === 'ideas'"></i> Ideas
                        </button>
                    </div>

                    <div x-show="tab === 'ongoing'">
                        @if ($ongoingActivities->isEmpty())
                            <div class="bg-white rounded-xl shadow-lg p-6">
                                <p class="text-gray-700">There is no ongoing activities that match your favorites.</p>
                            </div>
                        @else
                            @foreach ($ongoingActivities as $activity)
                                <div class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col mb-4">
                                    <!-- Activity content -->
                                    @include('components.activity-card', ['activity' => $activity])
                                    <div class="px-4 py-2 bg-gray-100">
                                        <p class="text-sm text-gray-600">Priority Score: {{ $activity->priority_score }}</p>
                                    </div>
                                </div>
                            @endforeach
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