<x-app-layout>
    <link href="{{ asset('css/volunteer-profile.css') }}" rel="stylesheet">
    <!-- Link to custom CSS for styling the volunteer profile -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Link to Font Awesome for icon usage -->

    <div class="max-w-7xl mx-auto px-1 sm:px-6 lg:px-8">
        <!-- Centered container with responsive padding and vertical spacing -->
        <div class="p-4 sm:p-8 bg-white items-center shadow sm:rounded-lg">
            <!-- Profile information card with padding, background color, shadow, and rounded corners -->

            <div class="flex flex-col items-center"> <!-- Centering the profile picture and name -->
                @php
                    $imagePath = 'images/profile_pictures/' . $profile->userid . '.*'; // Define path to profile picture based on user ID
                    $matchingFiles = glob(public_path($imagePath)); // Get matching profile picture files
                    $profilePicture = !empty($matchingFiles) ? basename($matchingFiles[0]) : null; // Get the first matching file or null if none found
                @endphp
                <img src="{{ $profilePicture ? asset('images/profile_pictures/' . $profilePicture) : asset('images/defaults/default-avatar.png') }}"
                    alt="{{ $profile->name }}" class=" profile-picture ">
                <!-- Use object-cover to maintain aspect ratio -->
            </div>
            <h2 class="text-xl sm:text-2xl font-bold text-center">{{ $profile->Name }}</h2>
            <!-- Display profile name directly under the picture -->

            <div class="btn-group"> <!-- Button group for profile actions -->
                @if (Auth::id() == $profile->userid)
                    <!-- Check if the logged-in user is the profile owner -->
                    <a href="{{ route('profile.edit') }}" class="btn"> <!-- Link to edit profile -->
                        <i class="fas fa-pen"></i> Edit Profile <!-- Icon and text for editing profile -->
                    </a>
                @endif
                <div class="dropdown"> <!-- Dropdown for sharing options -->
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
            <div class="profile-stats"> <!-- Section for displaying profile statistics -->
                <div class="stat-item"> <!-- Badges statistic -->
                    <h3>Badges</h3> <!-- Badges header -->
                    <div class="badges-list"> <!-- Container for badges -->
                        @if ($profile->Badges && is_array(json_decode($profile->Badges, true)) && count(json_decode($profile->Badges, true)) > 0)
                            <!-- Check if there are badges -->
                            @foreach (json_decode($profile->Badges, true) as $badge)
                                <!-- Loop through each badge -->
                                <span class="badge">{{ $badge }}</span> <!-- Display each badge -->
                            @endforeach
                        @else
                            <span class="no-badge">No badges yet</span> <!-- Message if no badges -->
                        @endif
                    </div>
                </div>
                <div class="stat-item"> <!-- Points statistic -->
                    <h3>Points</h3> <!-- Points header -->
                    <p>{{ $profile->Points }}</p> <!-- Display points -->
                </div>
                <div class="stat-item"> <!-- Level statistic -->
                    <h3>Level</h3> <!-- Level header -->
                    <p>{{ $profile->getLevel() }}</p> <!-- Display user level -->
                </div>
            </div>
            {{-- </div> --}}

            {{-- <div class="bg-white shadow sm:rounded-lg"> --}}
            <h3 class="text-lg sm:text-xl font-semibold mb-4 py-3 text-center"
                style="border-bottom: 2px solid #8B9467; width: 50%; margin: 0 auto;">Accomplishments</h3>
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8  mt-4 mb-0 pb-0">
                @foreach ($completedActivities as $activity)
                    <div class="rounded-xl mb-4 overflow-hidden flex flex-col shadow-lg border border-gray-200">
                        <!-- Activity Header -->
                        <div class="p-4 flex items-center space-x-4 border-b border-gray-100">
                            @php
                                $logoPath = 'images/logos/' . $activity->organization->userid . '.*';
                                $fullLogoPath = public_path($logoPath);
                                $logoExists = file_exists($fullLogoPath);
                            @endphp
                            <img src="{{ $logoExists ? asset($logoPath) : asset('images/defaults/default-logo.png') }}"
                                alt="{{ $activity->organization->org_name }}"
                                class="w-12 h-12 rounded-full object-cover">
                            <div class="flex flex-col ml-4">
                                <h4 class="text-xl font-semibold text-gray-800">{{ $activity->title }}</h4>
                                <div class="text-sm text-gray-500">
                                    <a href="{{ route('profile.public', $activity->organization->url) }}"
                                        class="text-blue-500 hover:underline">
                                        Organized by: {{ $activity->organization->org_name }}
                                    </a>
                                    <span>.</span>
                                    <span>{{ $activity->date->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Activity Description -->
                        <div class="px-4">
                            <p class="text-gray-700 leading-relaxed">
                                {{ $activity->accomplished_description }}
                            </p>
                        </div>

                        <!-- Activity Images -->
                        <div class="px-4 py-4">
                            <div class="aspect-w-1 aspect-h-1">
                                <x-activity-completed-images :activity="$activity" />
                            </div>
                        </div>

                        <!-- Activity Footer -->
                        @if ($activity->status !== 'completed')
                            <div class="px-6 py-4 bg-gray-500 mt-auto">
                                <div class="flex justify-between items-center">

                                    {{-- @if ($activity->status !== 'completed') --}}
                                    <a href="{{ route('activities.show', $activity) }}"
                                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                        View Details
                                    </a>
                                    {{-- @endif --}}
                                </div>
                            </div>
                        @endif


                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <x-image-popup /> <!-- Component for image popup functionality -->

    @push('scripts')
        @vite(['resources/js/popup.js']) <!-- Include JavaScript for popup functionality -->
    @endpush
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() { // Wait for the DOM to load
        const copyLink = document.querySelector('.copy-link'); // Select the copy link element
        if (copyLink) { // Check if the copy link exists
            copyLink.addEventListener('click', function(e) { // Add click event listener
                e.preventDefault(); // Prevent default link behavior
                const url = this.getAttribute('data-url'); // Get the URL to copy
                navigator.clipboard.writeText(url).then(function() { // Copy URL to clipboard
                    alert('Profile link copied to clipboard!'); // Alert user on success
                }, function(err) {
                    console.error('Could not copy text: ', err); // Log error if copy fails
                });
            });
        }
    });
</script>
