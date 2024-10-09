<x-app-layout>
    <link href="{{ asset('css/volunteer-profile.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <div class="p-4 sm:p-8 bg-white items-center shadow sm:rounded-lg">
        <div class="px-1">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-8">
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
                            Edit Favorites
                        </a>
                    </div>
                @endif

                <div x-data="{ tab: 'ongoing' }">
                    <div class="flex justify-center mb-4">
                        <button @click="tab = 'ongoing'" :class="{ 'bg-blue-500 text-white': tab === 'ongoing', 'bg-gray-200 text-gray-700': tab !== 'ongoing' }" class="px-4 py-2 rounded-l-md">Ongoing Activities</button>
                        <button @click="tab = 'ideas'" :class="{ 'bg-blue-500 text-white': tab === 'ideas', 'bg-gray-200 text-gray-700': tab !== 'ideas' }" class="px-4 py-2 rounded-r-md">Ideas</button>
                    </div>

                    <div x-show="tab === 'ongoing'">
                        @if ($ongoingActivities->isEmpty())
                            <div class="bg-white rounded-xl shadow-lg p-6">
                                <p class="text-gray-700">No ongoing activities match your favorites.</p>
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
                                <p class="text-gray-700">No idea threads from followed organizations yet.</p>
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
        </div>
    </div>
    <x-image-popup />
</x-app-layout>