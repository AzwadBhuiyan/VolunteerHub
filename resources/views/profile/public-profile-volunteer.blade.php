<x-app-layout>
    <link href="{{ asset('css/volunteer-profile.css') }}" rel="stylesheet">  <!-- Link to custom CSS for styling the volunteer profile -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">  <!-- Link to Font Awesome for icon usage -->

    <div class="py-6 sm:py-12">  <!-- Main container with vertical padding -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">  <!-- Centered container with responsive padding and vertical spacing -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">  <!-- Profile information card with padding, background color, shadow, and rounded corners -->
                <div class="flex flex-col sm:flex-row items-center sm:space-x-4">  <!-- Flex container for profile picture and details -->
                    <div class="flex-shrink-0 w-24 h-24 mb-4 sm:mb-0">  <!-- Profile picture container with fixed size -->
                        @php
                            $imagePath = 'images/profile_pictures/' . $profile->userid . '.*';  // Define path to profile picture based on user ID
                            $matchingFiles = glob(public_path($imagePath));  // Get matching profile picture files
                            $profilePicture = !empty($matchingFiles) ? basename($matchingFiles[0]) : null;  // Get the first matching file or null if none found
                        @endphp
                        <img src="{{ $profilePicture ? asset('images/profile_pictures/' . $profilePicture) : asset('images/defaults/default-avatar.png') }}"                        
                            alt="{{ $profile->name }}" 
                            class="profile-picture">  <!-- Display profile picture or default avatar if none exists -->
                    </div>
                    <div class="text-center sm:text-left">  <!-- Text container for profile details -->
                        <h2 class="text-xl sm:text-2xl font-bold">{{ $profile->Name }}</h2>  <!-- Display profile name -->
                        <p class="text-gray-600">{{ $profile->email }}</p>  <!-- Display profile email -->
                        <p class="mt-2">{{ $profile->bio }}</p>  <!-- Display profile bio -->
                    </div>
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
                <div class="profile-stats">  <!-- Section for displaying profile statistics -->
                    <div class="stat-item">  <!-- Badges statistic -->
                        <h3>Badges</h3>  <!-- Badges header -->
                        <div class="badges-list">  <!-- Container for badges -->
                            @if($profile->Badges && is_array(json_decode($profile->Badges, true)) && count(json_decode($profile->Badges, true)) > 0)  <!-- Check if there are badges -->
                                @foreach(json_decode($profile->Badges, true) as $badge)  <!-- Loop through each badge -->
                                    <span class="badge">{{ $badge }}</span>  <!-- Display each badge -->
                                @endforeach
                            @else
                                <span class="no-badge">No badges yet</span>  <!-- Message if no badges -->
                            @endif
                        </div>
                    </div>
                    <div class="stat-item">  <!-- Points statistic -->
                        <h3>Points</h3>  <!-- Points header -->
                        <p>{{ $profile->Points }}</p>  <!-- Display points -->
                    </div>
                    <div class="stat-item">  <!-- Level statistic -->
                        <h3>Level</h3>  <!-- Level header -->
                        <p>{{ $profile->getLevel() }}</p>  <!-- Display user level -->
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">  <!-- Accomplishments card -->
                <h3 class="text-lg sm:text-xl font-semibold mb-4">Accomplishments</h3>  <!-- Accomplishments section header -->
                <div class="space-y-8">  <!-- Container for individual accomplishments -->
                    @foreach($completedActivities as $activity)  <!-- Loop through completed activities -->
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden">  <!-- Individual activity card -->
                            <!-- Activity Header -->
                            <div class="px-6 py-4 flex items-center space-x-4 border-b border-gray-100">  <!-- Header for activity -->
                                @php
                                    $logoPath = 'images/logos/' . $activity->organization->userid . '.*';  // Path to organization logo
                                    $fullLogoPath = public_path($logoPath);  // Full path to logo
                                    $logoExists = file_exists($fullLogoPath);  // Check if logo file exists
                                @endphp
                                <img src="{{ $logoExists ? asset($logoPath) : asset('images/defaults/default-logo.png') }}" 
                                     alt="{{ $activity->organization->org_name }}" 
                                     class="w-12 h-12 rounded-full object-cover">  <!-- Display organization logo or default logo -->
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-800">{{ $activity->title }}</h4>  <!-- Display activity title -->
                                    <p class="text-sm text-gray-500">{{ $activity->date->format('M d, Y') }}</p>  <!-- Display activity date -->
                                </div>
                            </div>

                            <!-- Accomplishment Description -->
                            <div class="px-6 py-4">  <!-- Description container -->
                                <p class="text-gray-700 leading-relaxed">{{ $activity->accomplished_description }}</p>  <!-- Display description of the accomplishment -->
                            </div>

                            <!-- Accomplishment Photos -->
                            <div class="px-6 py-4">  <!-- Photos container -->
                                <div class="flex space-x-2 overflow-x-auto pb-2">  <!-- Flex container for photos -->
                                    @php
                                        $accomplishedPath = 'images/activities/' . $activity->activityid . '/accomplished/';  // Path to accomplished activity photos
                                        $accomplishedFullPath = public_path($accomplishedPath);  // Full path to photos
                                        $accomplishedPhotos = File::exists($accomplishedFullPath) ? File::files($accomplishedFullPath) : [];  // Get photos if they exist
                                    @endphp
                                    @foreach($accomplishedPhotos as $photo)  <!-- Loop through each accomplished photo -->
                                        <img src="{{ asset($accomplishedPath . $photo->getFilename()) }}" 
                                             alt="Accomplished Activity Photo" 
                                             class="w-40 h-40 object-cover rounded-lg shadow-md flex-shrink-0 clickable-image cursor-pointer"
                                             data-full-src="{{ asset($accomplishedPath . $photo->getFilename()) }}"  <!-- Full-size image source for popup -->
                                             data-carousel="true"
                                             data-carousel-images='{{ json_encode(array_map(function($p) use ($accomplishedPath) { return asset($accomplishedPath . $p->getFilename()); }, $accomplishedPhotos)) }}'>  <!-- JSON for carousel images -->
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <x-image-popup />  <!-- Component for image popup functionality -->

    @push('scripts')
        @vite(['resources/js/popup.js'])  <!-- Include JavaScript for popup functionality -->
    @endpush
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {  // Wait for the DOM to load
        const copyLink = document.querySelector('.copy-link');  // Select the copy link element
        if (copyLink) {  // Check if the copy link exists
            copyLink.addEventListener('click', function(e) {  // Add click event listener
                e.preventDefault();  // Prevent default link behavior
                const url = this.getAttribute('data-url');  // Get the URL to copy
                navigator.clipboard.writeText(url).then(function() {  // Copy URL to clipboard
                    alert('Profile link copied to clipboard!');  // Alert user on success
                }, function(err) {
                    console.error('Could not copy text: ', err);  // Log error if copy fails
                });
            });
        }
    });
</script>