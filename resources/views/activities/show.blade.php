<x-app-layout>
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 min-h-screen">
        <div class="p-1 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="p-2 bg-white border-b border-gray-200">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                <div class="p-3 flex items-center space-x-4 border-b border-gray-100">
                    <img src="{{ asset($activity->organization->getLogoPath()) }}" alt="{{ $activity->organization->org_name }}"
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

                <p class="text-gray-700 text-sm p-2 leading-relaxed">{{ $activity->description }}</p>


                @php
                    $imagePath = 'images/activities/' . $activity->activityid . '/';
                    $imageFullPath = public_path($imagePath);
                    $imageFiles = File::exists($imageFullPath) ? File::files($imageFullPath) : [];
                    $imageExists = !empty($imageFiles);
                    $imageSrc = $imageExists
                        ? asset($imagePath . basename($imageFiles[0]))
                        : asset('images/defaults/default-activity.jpg');
                @endphp
                @if ($imageSrc)
                    {{-- <div class="mb-2 text-sm text-gray-500">
                            Debug path: {{ $imagePath }}
                        </div> --}}
                    <div class="mb-6">
                        <img src="{{ $imageSrc }}" alt="{{ $activity->title }}"
                            class="w-full h-[250px] object-cover rounded-lg cursor-pointer clickable-image"
                            data-full-src="{{ $imageSrc }}">
                    </div>
                @else
                    <div class="mb-2 text-sm text-gray-500">No image available</div>
                @endif


                <div class="bg-gradient-to-br from-gray-50 to-white rounded-2xl p-5 shadow-lg border border-gray-100">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6 text-center">Activity Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <!-- Date -->
                            <div class="flex items-center space-x-3">
                                <div
                                    class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Event Date</p>
                                    <p class="text-sm font-semibold text-gray-900">
                                        {{ $activity->date->format('M d, Y') }}</p>
                                </div>
                            </div>

                            <!-- Time -->
                            <div class="flex items-center space-x-3">
                                <div
                                    class="flex-shrink-0 w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Time</p>
                                    <p class="text-sm font-semibold text-gray-900">
                                        {{ $activity->time->format('h:i A') }}</p>
                                </div>
                            </div>

                            <!-- Category -->
                            <div class="flex items-center space-x-3">
                                <div
                                    class="flex-shrink-0 w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h18v18H3V3zm3 3v12h12V6H6z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Category</p>
                                    <p class="text-sm font-semibold text-gray-900">{{ $activity->category }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <!-- Deadline -->
                            <div class="flex items-center space-x-3">
                                <div
                                    class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 2h12M6 22h12M6 2v6a6 6 0 0012 0V2M6 22v-6a6 6 0 0112 0v6" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Registration Deadline</p>
                                    <p class="text-sm font-semibold text-gray-900">
                                        {{ $activity->deadline->format('M d, Y (h:i A)') }}</p>
                                </div>
                            </div>

                            <!-- Volunteers Required -->
                            <div class="flex items-center space-x-3">
                                <div
                                    class="flex-shrink-0 w-10 h-10 bg-teal-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 11c1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3 1.34 3 3 3zm-8 0c1.66 0 3-1.34 3-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm8 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm-8 0c-2.33 0-7 1.17-7 3.5V19h7v-2.5c0-2.33 4.67-3.5 7-3.5z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Volunteers Required</p>
                                    <p class="text-sm font-semibold text-gray-900">{{ $activity->min_volunteers }}
                                    </p>
                                </div>
                            </div>

                            <!-- District -->
                            <div class="flex items-center space-x-3">
                                <div
                                    class="flex-shrink-0 w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">District</p>
                                    <p class="text-sm font-semibold text-gray-900">{{ $activity->district }}</p>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- Location -->
                    <div class="flex items-center space-x-3 pt-4 text-left">
                        <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500">Location</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $activity->address }}</p>
                        </div>
                    </div>
                    @if ($activity->google_maps_link)
                        <div class="flex justify-center mt-4">
                            <a href="{{ $activity->google_maps_link }}" target="_blank"
                                class="inline-flex items-center px-4 py-2 bg-white border-2 border-gray-300 rounded-lg text-sm font-medium text-gray-800 hover:bg-gray-100 hover:border-gray-400 transition duration-300 shadow-md max-w-max">
                                <svg class="w-5 h-5 mr-2 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" />
                                </svg>
                                <span class="text-blue-500">G</span><span class="text-red-500">o</span><span
                                    class="text-yellow-500">o</span><span class="text-blue-500">g</span><span
                                    class="text-green-500">l</span><span class="text-red-500">e</span> Maps - Get
                                Directions
                            </a>
                        </div>
                    @endif

                    @auth
                        @if (Auth::id() === $activity->userid ||
                                (Auth::user()->volunteer &&
                                    $activity->volunteers()->wherePivot('volunteer_userid', Auth::user()->volunteer->userid)->wherePivot('approval_status', 'approved')->exists()))
                            <div class="flex justify-center mt-1">
                                <a href="{{ route('activities.timeline', $activity) }}"
                                    class="inline-flex items-center justify-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-blue-600 to-blue-800 hover:from-green-900 hover:to-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-lg hover:shadow-xl">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    View Activity Timeline
                                </a>
                            </div>
                        @endif
                    @endauth
                @auth
                    @if (Auth::id() === $activity->userid)
                        <div class="flex justify-center mt-1">
                            <a href="{{ route('activities.edit', $activity) }}"
                                class="inline-flex items-center justify-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-blue-600 to-blue-800 hover:from-green-900 hover:to-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                                </svg>
                                Edit Activity
                            </a>
                        </div>
                    @endif
                @endauth
                </div>

                <div class="flex gap-4 mt-4">
                    @auth
                     

                        @if (Auth::user()->volunteer)
                            @php
                                $isRegistered = $activity
                                    ->volunteers()
                                    ->wherePivot('volunteer_userid', Auth::user()->volunteer->userid)
                                    ->exists();
                            @endphp

                            @if ($isRegistered)
                                <button disabled
                                    class="px-4 py-2 bg-gray-400 text-white font-medium rounded-md cursor-not-allowed">
                                    Already Registered
                                </button>
                                @if ($activity->deadline->isFuture())
                                    <form action="{{ route('activities.cancel_registration', $activity) }}"
                                        method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-md transition-colors">
                                            Cancel Registration
                                        </button>
                                    </form>
                                @else
                                    <button disabled
                                        class="px-4 py-2 bg-gray-400 text-white font-medium rounded-md cursor-not-allowed">
                                        Cannot Cancel (Deadline Passed)
                                    </button>
                                @endif
                            @else
                                @if(Auth::user()->volunteer && Auth::user()->volunteer->getProfileCompletionPercentage() < 100)
                                    <div class="flex flex-col space-y-4">
                                        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4">
                                            <p class="font-bold">Profile Incomplete</p>
                                            <p>Please complete your profile before registering for activities. 
                                            <a href="{{ route('profile.edit') }}" class="underline">Complete Profile</a>
                                            </p>
                                        </div>
                                        @endif
                                        <form action="{{ route('activities.register', $activity) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition-colors">
                                                Register for this Activity
                                            </button>
                                    </div>
                                </form>
                                
                            @endif
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition-colors">
                            Login to Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
