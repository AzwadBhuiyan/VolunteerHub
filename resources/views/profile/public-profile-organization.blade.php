<x-app-layout>
    @push('body-class')
        organization-profile
    @endpush

    <link href="{{ asset('css/org-profile.css') }}" rel="stylesheet">
    <!-- Link to custom CSS for styling the volunteer profile -->


    {{-- <div class=" sm:py-12 bg-blue-500 h-full">  <!-- Main container with vertical padding --> --}}
    <div class="max-w-7xl mx-auto px-1 sm:px-6 lg:px-8 space-y-6 min-h-screen">
        
        <!-- Centered container with responsive padding and vertical spacing -->
        {{-- <div class=" h-screen"> --}}
        <!-- Profile information card with padding, background color, shadow, and rounded corners, and full height of the website -->

        <!-- Cover Image -->



        <!-- Main Content -->
        <main class="bg-white shadow-md mb-0">
            

            <!-- // to check if image exists -->
            @php
                $coverPath = 'images/cover/' . $profile->userid . '.*';
                $matchingFiles = glob(public_path($coverPath));
                $coverImage = !empty($matchingFiles) ? basename($matchingFiles[0]) : null;
            @endphp
            <img src="{{ $coverImage ? asset('images/cover/' . $coverImage) : asset('images/defaults/default-cover.jpg') }}"
                alt="Cover Image" class="cover-photo">

            <!-- Profile Info -->
            <div class="my-4">
                <div class="flex items-center">
                    <!-- // to check if image exists -->
                    <img src="{{ asset($profile->getLogoPath()) }}" alt="{{ $profile->org_name }}"
                        class="w-24 h-24 rounded-full object-cover mx-2">
                    <div>
                        <h1 class="text-2xl font-bold">{{ $profile->org_name }}</h1>
                        <p class="text-gray-600">{{ $profile->description }}</p>
                    </div>


                </div>


                <div class="btn-group"> <!-- Button group for profile actions -->
                    @auth
                        @if (Auth::user()->volunteer)
                            @php
                                $isFollowing = Auth::user()->volunteer->followedOrganizations->contains(
                                    $profile->userid,
                                );
                            @endphp
                            <form
                                action="{{ $isFollowing ? route('organizations.unfollow', $profile) : route('organizations.follow', $profile) }}"
                                method="POST">
                                @csrf
                                @if ($isFollowing)
                                    @method('DELETE')
                                @endif
                                <button type="submit" class="btn">
                                    <i class="fas fa-heart" style="color: {{ $isFollowing ? 'red' : 'inherit' }}"></i>
                                    {{ $isFollowing ? 'Following' : 'Follow' }}
                                </button>
                            </form>
                            @if ($isFollowing)
                                <script>
                                    document.querySelector('form').addEventListener('submit', function(e) {
                                        if (!confirm('Are you sure you want to unfollow?')) {
                                            e.preventDefault();
                                        }
                                    });
                                </script>
                            @endif
                        @endif
                    @endauth

                    @if (Auth::id() == $profile->userid)
                        <!-- Check if the logged-in user is the profile owner -->
                        <a href="{{ route('profile.edit') }}" class="btn" data-tutorial="edit-profile"> <!-- Link to edit profile -->
                            <i class="fas fa-pen"></i> Edit Profile <!-- Icon and text for editing profile -->
                        </a>
                    @endif
                    <div class="dropdown" data-tutorial="share-profile"> <!-- Dropdown for sharing options -->
                        <button class="btn"> <!-- Share profile button -->
                            <i class="fas fa-share-alt"></i> Share Profile <!-- Icon and text for sharing profile -->
                        </button>
                        <div class="dropdown-content"> <!-- Dropdown menu for sharing options -->
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                                target="_blank">Facebook</a> <!-- Share on Facebook -->
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}"
                                target="_blank">Twitter</a> <!-- Share on Twitter -->
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->url()) }}"
                                target="_blank">LinkedIn</a> <!-- Share on LinkedIn -->
                            <a href="#" class="copy-link" data-url="{{ request()->url() }}">Copy Link</a>
                            <!-- Copy link option -->
                        </div>
                    </div>
                </div>
                
                <!-- profile completion -->
                @if(Auth::id() == $profile->userid && $profile->getProfileCompletionPercentage() < 100)
                    <div class="mt-2 w-full max-w-xs mx-auto">
                        <div class="bg-gray-600 rounded-full h-4 overflow-hidden relative shadow-md">
                            <div class="bg-gradient-to-r from-green-400 to-blue-500 h-full rounded-full transition-all duration-700" 
                                    style="width: {{ $profile->getProfileCompletionPercentage() }}%">
                                <span class="absolute inset-0 flex items-center justify-center text-white text-xs font-semibold">
                                    Profile {{ $profile->getProfileCompletionPercentage() }}% Complete
                                </span>
                            </div>
                        </div>
                        <div class="relative mt-2 text-center">
                            <div class="hidden absolute bg-white shadow-lg rounded-lg p-4 text-sm text-gray-700 w-full z-50 transform transition-transform duration-300" 
                                    id="incomplete-fields" 
                                    style="left: 50%; transform: translateX(-50%) translateY(-10px);">
                                <p class="font-bold mb-2">Complete your profile by adding:</p>
                                <ul class="list-disc list-outside pl-5 mb-2 text-left">
                                    @foreach($profile->getIncompleteFields() as $field)
                                        <li>{{ $field }}</li>
                                    @endforeach
                                </ul>
                                <p class="">
                                    Go to <strong>Edit Profile</strong> to add more information.
                                </p>
                            </div>
                        </div>
                        <script>
                            document.querySelector('.bg-gradient-to-r').addEventListener('mouseenter', function() {
                                document.getElementById('incomplete-fields').classList.remove('hidden');
                            });
                            document.querySelector('.bg-gradient-to-r').addEventListener('mouseleave', function() {
                                document.getElementById('incomplete-fields').classList.add('hidden');
                            });
                        </script>
                    </div>
                @endif



                <!-- Action Buttons -->
                <div class="flex space-x-2 my-2 justify-center p-2" data-tutorial="about-contact">
                    <a href="{{ route('profile.about', $profile) }}" class="btn-rounded custom-btn">About</a>
                    <a href="{{ route('profile.contact', $profile) }}" class="btn-rounded custom-btn">Contact</a>
                    <a href="{{ $profile->website }}" class="btn-rounded custom-btn">Website</a>
                </div>
                <h3 class="text-lg sm:text-xl font-semibold mb-4 py-3 text-center" 
                style="border-bottom: 2px solid #8B9467; width: 70%; margin: 0 auto;">
                Volunteer Projects
            </h3>
                <hr class="mt-2  mb-4">

              
                <!-- Activities Section -->
                
                <div x-data="{ tab: 'ongoing' }" class="mb-6" data-tutorial="activities-section">
                    <div class="flex justify-center space-x-2 mb-4 w-full">
                        <button @click="tab = 'ongoing'"
                            :class="{ 'bg-gray-700': tab === 'ongoing', 'bg-gray-400': tab !== 'ongoing', 'shadow-lg': tab === 'ongoing', 'border-2 border-black': tab === 'ongoing', 'hover:bg-gray-400': tab !== 'ongoing', 'hover:bg-gray-700': tab === 'ongoing' }"
                            class="w-1/2 px-4 py-2 text-white rounded flex items-center justify-center">
                            <i class="fas fa-check mr-2" x-show="tab === 'ongoing'"></i> Ongoing
                        </button>
                        <button @click="tab = 'completed'"
                            :class="{ 'bg-gray-700': tab === 'completed', 'bg-gray-400': tab !== 'completed', 'shadow-lg': tab === 'completed', 'border-2 border-black': tab === 'completed', 'hover:bg-gray-400': tab !== 'completed', 'hover:bg-gray-700': tab === 'completed' }"
                            class="w-1/2 px-4 py-2 text-white rounded flex items-center justify-center">
                            <i class="fas fa-check mr-2" x-show="tab === 'completed'"></i> Accomplished
                        </button>
                    </div>

                    <div x-show="tab === 'ongoing'" class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-4">
                        @foreach ($ongoingActivities as $activity)
                            <x-activity-card :activity="$activity" />
                        @endforeach
                    </div>

                    <div x-show="tab === 'completed'" class="space-y-8">
                        <!-- Activities Section -->
                        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 mt-4 mb-0 pb-0">
                            @foreach ($completedActivities as $activity)
                                <div
                                    class="rounded-lg mb-4 overflow-hidden flex flex-col shadow-lg border border-gray-200">
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
                                    <div class="px-3 py-1"> <!-- Added padding -->
                                        <p class="text-sm text-gray-700 leading-relaxed">
                                            {{ $activity->accomplished_description }}
                                        </p>
                                    </div>

                                    <!-- Activity Images -->
                                    <div class="px-2 py-2">
                                        <div class="aspect-w-1 aspect-h-1 w-full h-64">
                                            <a href="{{ route('activities.show_accomplished', $activity) }}" class="block w-full h-full">
                                                <x-activity-completed-images :activity="$activity" class="hover:opacity-90 transition-opacity" />
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Activity Footer -->
                                    @if ($activity->status !== 'completed')
                                        <div class="px-2 py-2 bg-gray-500 mt-auto">
                                            <div class="flex justify-between items-center">
                                                <a href="{{ route('activities.show', $activity) }}"
                                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded">
                                                    View Details
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </main>
        {{-- </div> --}}
    </div>

    @if (Auth::id() == $profile->userid)
        <x-tutorial-popup/>
    @endif

</x-app-layout>
