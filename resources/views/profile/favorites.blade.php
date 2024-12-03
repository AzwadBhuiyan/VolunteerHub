<x-app-layout>
    <link href="{{ asset('css/volunteer-profile.css') }}" rel="stylesheet">
 

 <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 min-h-screen">
        <!-- Centered container with responsive padding and vertical spacing -->
            @if (!$favorites ||(empty($favorites->favorite_categories) &&
                    empty($favorites->favorite_districts) &&
                    $volunteer->followedOrganizations->isEmpty()))
                <div  data-tutorial="add-favorites" class="bg-yellow-100 border-yellow-500 text-yellow-700 p-4 mt-4 flex items-center" role="alert">
                    <i class="bi bi-exclamation-triangle-fill text-2xl mr-4"></i>
                    <p>Please select your favorite categories and locations to see your favorite activities here.</p>
                </div>
                <div class="text-center">
                    <a href="{{ route('favorites.edit') }}" class="btn mt-4">
                        <i class="fas fa-plus"></i>Add Favorites
                    </a>
                </div>
            @else

            <div  data-tutorial="add-favorites" class="w-full p-5 mx-auto shadow-lg mb-4 flex flex-col items-center justify-center bg-gray-800 text-white">
                {{-- <h1 class="text-3xl font-bold mb-4">Explore Idea Board</h1> --}}
                <i class="fas fa-heart text-lg text-green-500"></i>
           

                <h2 class="bg-gradient-to-r from-blue-600 via-green-500 to-blue-500 inline-block text-transparent bg-clip-text text-lg font-bold mt-2 mb-2 ">
                    Explore Your Favorite Activities!</h2>
                    <p class="text-base">Here you can check out the latest accomplishments of the organizations and volunteers that you follow.</p>

                <div class="flex flex-col sm:flex-row gap-4 mt-4">
                    <a href="{{ route('following.index') }}" class="inline-flex items-center justify-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-blue-600 to-blue-800 hover:from-green-900 hover:to-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-lg hover:shadow-xl">
                        <i class="fas fa-users mr-2"></i> View Following
                    </a>

                    <a href="{{ route('favorites.edit') }}" class="inline-flex items-center justify-center px-6 py-2.5 border border-gray-300 text-sm font-medium rounded-md text-gray-200 bg-gray-700 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200 shadow hover:shadow-md">
                        <i class="fas fa-pen mr-2"></i> Edit Favorites
                    </a>
                </div>

                
            </div>
        
            @endif

            <div class="p-1 sm:p-8 bg-white shadow sm:rounded-lg">


            <h3 class="text-lg sm:text-xl font-semibold mb-4 py-3 text-center"
            style="border-bottom: 2px solid transparent; border-image: linear-gradient(to right, #3B82F6, #10B981, #3B82F6); border-image-slice: 1; width: 70%; margin: 0 auto;" data-tutorial="favorite-content">Favorite Activities & Ideas</h3>


            <div x-data="{ tab: 'ongoing' }" class="mb-6 mt-6">
                <div class="flex justify-center space-x-2 mb-4 w-full">
                    <button @click="tab = 'ongoing'"
                        :class="{ 'bg-gray-800': tab === 'ongoing', 'bg-gray-400': tab !== 'ongoing', 'shadow-lg': tab === 'ongoing', 'border-2 border-black': tab === 'ongoing' }"
                        class="w-1/2 px-4 py-2 text-white rounded flex items-center justify-center">
                        <i class="fas fa-check mr-2" x-show="tab === 'ongoing'"></i> Activities
                    </button>
                    <button @click="tab = 'ideas'"
                        :class="{ 'bg-gray-800': tab === 'ideas', 'bg-gray-400': tab !== 'ideas', 'shadow-lg': tab === 'ideas', 'border-2 border-black': tab === 'ideas' }"
                        class="w-1/2 px-4 py-2 text-white rounded flex items-center justify-center">
                        <i class="fas fa-check mr-2" x-show="tab === 'ideas'"></i> Ideas
                    </button>
                </div>

                <div x-show="tab === 'ongoing'">
                    @if ($ongoingActivities->isEmpty())
                        <div class="bg-white rounded-xl  p-6">
                            <p class="text-gray-700">There are no ongoing activities that match your favorites.</p>
                        </div>
                    @else
                        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-4">
                            <!-- Match the same container structure -->
                            @foreach ($ongoingActivities as $activity)
                            <x-activity-card :activity="$activity" />

                            {{-- <div class="rounded-lg mb-4 overflow-hidden flex flex-col shadow-lg border border-gray-200">

                                    <!-- Activity Header -->
                                    <div class="p-3 flex items-center space-x-4 border-b border-gray-100">
                                        <img src="{{ asset($activity->organization->getLogoPath()) }}"
                                            alt="{{ $activity->organization->org_name }}"
                                            class="w-10 h-10 rounded-full object-cover">
                                        <div class="flex flex-col ml-4 flex-grow">
                                            <h4 class="text-base font-semibold text-gray-800">{{ $activity->title }}
                                            </h4>
                                            <div class="text-xs text-gray-500 flex justify-between">
                                                <div>
                                                    <a href="{{ route('profile.public', $activity->organization->url) }}"
                                                        class="text-blue-500 hover:underline">{{ $activity->organization->org_name }}</a>
                                                    <span>.</span>
                                                    <span>{{ $activity->date->format('M d, Y') }}</span>
                                                </div>
                                                <span>
                                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                                    {{ $activity->district }}
                                                </span>
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
                                        <a href="{{ route('activities.show', $activity) }}"
                                            class="block text-center text-sm bg-gradient-to-br from-green-400 to-blue-600 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800 text-white font-bold py-2 px-4 rounded">
                                            View Details
                                        </a>
                                    </div>

                                    <!-- Priority Score -->
                                    {{-- <div class="px-4 py-2 bg-gray-100">
                                            <p class="text-sm text-gray-600">Priority Score: {{ $activity->priority_score }}</p>
                                        </div> --}}
                                {{-- </div>  --}}
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

    <x-tutorial-popup/>


</x-app-layout>
