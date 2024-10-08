<x-app-layout>
    <link href="{{ asset('css/org-profile.css') }}" rel="stylesheet">
    <!-- Link to custom CSS for styling the volunteer profile -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Link to Font Awesome for icon usage -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    {{-- <div class=" sm:py-12 bg-blue-500 h-full">  <!-- Main container with vertical padding --> --}}
    <div class="max-w-7xl mx-auto px-1 sm:px-6 lg:px-8 space-y-6">
        <!-- Centered container with responsive padding and vertical spacing -->
        {{-- <div class=" h-screen"> --}}
            <!-- Profile information card with padding, background color, shadow, and rounded corners, and full height of the website -->

            <!-- Cover Image -->






            <!-- Main Content -->
            <main class="bg-white mb-0">

                <!-- // to check if image exists -->
                @php
                    $coverPath = 'images/cover/' . $profile->userid . '.*';
                    $matchingFiles = glob(public_path($coverPath));
                    $coverImage = !empty($matchingFiles) ? basename($matchingFiles[0]) : null;
                @endphp
                <img src="{{ $coverImage ? asset('images/cover/' . $coverImage) : asset('images/defaults/default-cover.jpg') }}"
                    alt="Cover Image" class="cover-photo">

                <!-- Profile Info -->
                <div class="p-2">
                    <div class="flex items-center mb-2">
                        <!-- // to check if image exists -->
                        <img src="{{ asset($profile->getLogoPath()) }}" alt="{{ $profile->org_name }}" class="w-16 h-16 rounded-full object-cover">
                        <div>
                            <h1 class="h1">{{ $profile->org_name }}</h1>
                            <p class="text-gray-600 mb-2">{{ $profile->description }}</p>
                           
                        </div>

                        @auth
                            @if(Auth::user()->volunteer)
                                @php
                                    $isFollowing = Auth::user()->volunteer->followedOrganizations->contains($profile->userid);
                                @endphp
                                <form action="{{ $isFollowing ? route('organizations.unfollow', $profile) : route('organizations.follow', $profile) }}" method="POST">
                                    @csrf
                                    @if($isFollowing)
                                        @method('DELETE')
                                    @endif
                                    <button type="submit" class="btn {{ $isFollowing ? 'btn-danger' : 'btn-primary' }}">
                                        {{ $isFollowing ? 'Unfollow' : 'Follow' }}
                                    </button>
                                </form>
                            @endif
                        @endauth
                        
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex space-x-2 mb-4 justify-center">
                        <a href="#" class="btn-rounded custom-btn">About</a>
                        <a href="#" class="btn-rounded custom-btn">Contact</a>
                        <a href="{{ $profile->website }}" class="btn-rounded custom-btn">Website</a>
                    </div>
                    <div class="btn-group">  <!-- Button group for profile actions -->
                        @if(Auth::id() == $profile->userid)  <!-- Check if the logged-in user is the profile owner -->
                            <a href="{{ route('profile.edit') }}" class="btn">  <!-- Link to edit profile -->
                                <i class="fas fa-pen"></i> Edit Profile  <!-- Icon and text for editing profile -->
                            </a>
                        @endif
                        <div class="dropdown">  <!-- Dropdown for sharing options -->
                            <button class="btn">  <!-- Share profile button -->
                                <i class="fas fa-share-alt"></i> Share Profile  <!-- Icon and text for sharing profile -->
                            </button>
                            <div class="dropdown-content">  <!-- Dropdown menu for sharing options -->
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank">Facebook</a>  <!-- Share on Facebook -->
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}" target="_blank">Twitter</a>  <!-- Share on Twitter -->
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->url()) }}" target="_blank">LinkedIn</a>  <!-- Share on LinkedIn -->
                                <a href="#" class="copy-link" data-url="{{ request()->url() }}">Copy Link</a>  <!-- Copy link option -->
                            </div>
                        </div>
                    </div>
                    <hr class="mt-2 mt-4 mb-4">

                    <!-- Activities Section -->
                    <div x-data="{ tab: 'ongoing' }" class="mb-6">
                        <div class="flex justify-center space-x-2 mb-4 w-full">
                            <button @click="tab = 'ongoing'" :class="{ 'bg-gray-700': tab === 'ongoing', 'bg-gray-400': tab !== 'ongoing', 'shadow-lg': tab === 'ongoing', 'border-2 border-black': tab === 'ongoing', 'hover:bg-gray-400': tab !== 'ongoing', 'hover:bg-gray-700': tab === 'ongoing' }"
                                class="w-1/2 px-4 py-2 text-white rounded flex items-center justify-center">
                                <i class="fas fa-check mr-2" x-show="tab === 'ongoing'"></i> Ongoing
                            </button>
                            <button @click="tab = 'completed'" :class="{ 'bg-gray-700': tab === 'completed', 'bg-gray-400': tab !== 'completed', 'shadow-lg': tab === 'completed', 'border-2 border-black': tab === 'completed', 'hover:bg-gray-400': tab !== 'completed', 'hover:bg-gray-700': tab === 'completed' }"
                                class="w-1/2 px-4 py-2 text-white rounded flex items-center justify-center">
                                <i class="fas fa-check mr-2" x-show="tab === 'completed'"></i> Accomplished
                            </button>
                        </div>
                        
                        <!-- Activities Section -->
                        <div x-show="tab === 'ongoing'" class="space-y-8">
                            @foreach ($ongoingActivities as $activity)
                                <div class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col">
                                    <!-- Activity Header -->
                                    <div class="p-6 flex items-center space-x-4 border-b border-gray-100">
                                    <img src="{{ asset($profile->getLogoPath()) }}" alt="{{ $profile->org_name }}" class="w-16 h-16 rounded-full object-cover">
                                        <div>
                                            <h4 class="text-xl font-semibold text-gray-800">{{ $activity->title }}</h4>
                                            <p class="text-sm text-gray-500">{{ $activity->date->format('M d, Y') }}</p>
                                        </div>
                                    </div>

                                    <!-- Activity Description -->
                                    <div class="p-6">
                                        <p class="text-gray-700 leading-relaxed">
                                            {{ Str::limit($activity->description, 150) }}
                                        </p>
                                    </div>

                                    <!-- Activity Images -->
                                    <div class="p-6">
                                        <div class="aspect-w-1 aspect-h-1">
                                            <x-activity-ongoing-image :activity="$activity" />
                                        </div>
                                    </div>

                                    <!-- Activity Footer -->
                                    <div class="px-6 py-4 bg-gray-50 mt-auto">
                                        <div class="flex justify-between items-center">
                                            <span class="text-blue-500">
                                                Organized by: {{ $profile->org_name }}
                                            </span>
                                            <a href="{{ route('activities.show', $activity) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div x-show="tab === 'completed'" class="space-y-8">
                            @foreach ($completedActivities as $activity)
                                <div class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col">
                                    <!-- Activity Header -->
                                    <div class="p-6 flex items-center space-x-4 border-b border-gray-100">
                                    <img src="{{ asset($profile->getLogoPath()) }}" alt="{{ $profile->org_name }}" class="w-16 h-16 rounded-full object-cover">
                                        <div>
                                            <h4 class="text-xl font-semibold text-gray-800">{{ $activity->title }}</h4>
                                            <p class="text-sm text-gray-500">{{ $activity->date->format('M d, Y') }}</p>
                                        </div>
                                    </div>

                                    <!-- Activity Description -->
                                    <div class="p-6">
                                        <p class="text-gray-700 leading-relaxed">
                                            {{ $activity->accomplished_description }}
                                        </p>
                                    </div>

                                    <!-- Activity Images -->
                                    <div class="p-6">
                                        <div class="aspect-w-1 aspect-h-1">
                                            <x-activity-completed-images :activity="$activity" />
                                        </div>
                                    </div>

                                    <!-- Activity Footer -->
                                    <div class="px-6 py-4 bg-gray-50 mt-auto">
                                        <div class="flex justify-between items-center">
                                            <a href="{{ route('profile.public', $activity->organization->url) }}" class="text-blue-500 hover:underline">
                                                Organized by: {{ $activity->organization->org_name }}
                                            </a>
                                            @if ($activity->status !== 'completed')
                                                <a href="{{ route('activities.show', $activity) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                                    View Details
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                </div>
            </main>
        {{-- </div> --}}
    </div>
    <x-image-popup />
    
</x-app-layout>
