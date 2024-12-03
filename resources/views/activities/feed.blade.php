<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 min-h-screen">
        <div
            class="w-full p-5 mx-auto shadow-lg flex flex-col items-center justify-center bg-gray-800 text-white text-center">
            <i class="fas fa-trophy text-lg text-yellow-500"></i>

            <h2
                class="bg-gradient-to-r from-blue-600 via-green-500 to-blue-500 inline-block text-transparent bg-clip-text text-lg font-bold mt-2 mb-2">
                Our Accomplishments</h2>
            <p class="text-base">Organizations and volunteers from across Bangladesh have demonstrated their unwavering dedication and commitment to creating positive change through these remarkable projects.
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
                                <div class="flex flex-col ml-4 flex-grow">
                                    <div class="flex justify-between items-start">
                                        <h4 class="text-base font-semibold text-gray-800 hover:bg-gradient-to-r hover:from-blue-600 hover:via-green-500 hover:to-blue-600 hover:bg-clip-text hover:text-transparent transition-all duration-300">
                                            <a href="{{ route('activities.show_accomplished', $activity) }}" class="text-gray-800">
                                                {{ $activity->title }}
                                            </a>
                                        </h4>
                                        <div class="relative ml-4" x-data="{ open: false }">
                                            <button @click="open = !open" 
                                                class="flex items-center space-x-1 px-2 py-0.5 text-xs border border-gray-300 rounded-md hover:bg-gray-50 transition duration-150">
                                                <i class="fas fa-share-alt"></i>
                                                <span>Share</span>
                                            </button>
                                            <div x-show="open" @click.away="open = false" 
                                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 border">
                                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('activities.show_accomplished', $activity)) }}" 
                                                    target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                    <i class="fab fa-facebook mr-2"></i>Share on Facebook
                                                </a>
                                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('activities.show_accomplished', $activity)) }}" 
                                                    target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                    <i class="fab fa-twitter mr-2"></i>Share on Twitter
                                                </a>
                                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('activities.show_accomplished', $activity)) }}" 
                                                    target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                    <i class="fab fa-linkedin mr-2"></i>Share on LinkedIn
                                                </a>
                                                <button @click="navigator.clipboard.writeText('{{ route('activities.show_accomplished', $activity) }}').then(() => { open = false; const popup = document.createElement('div'); popup.textContent = 'Link copied!'; popup.className = 'fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-green-100 text-green-800 text-center rounded-md py-2 px-4 shadow-md'; document.body.appendChild(popup); setTimeout(() => { popup.remove(); }, 2000); })"
                                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                    <i class="fas fa-link mr-2"></i>Copy Link
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-xs text-gray-500 flex justify-between mt-1">
                                        <div>
                                            <a href="{{ route('profile.public', $activity->organization->url) }}"
                                                class="text-blue-500 hover:underline">{{ $activity->organization->org_name }}</a>
                                            <span>.</span>
                                            <span>{{ $activity->date->format('M d, Y') }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-map-marker-alt mr-1"></i>
                                            <span>{{ $activity->district }}</span>
                                        </div>
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
                                    <a href="{{ route('activities.show_accomplished', $activity) }}" class="block w-full h-full">
                                        <x-activity-completed-images :activity="$activity" class="clickable-image hover:opacity-90 transition-opacity" />
                                    </a>
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
</x-app-layout>
