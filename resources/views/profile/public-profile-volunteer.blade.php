<x-app-layout>
    <link href="{{ asset('css/volunteer-profile.css') }}" rel="stylesheet">
    <!-- Link to custom CSS for styling the volunteer profile -->

    <!-- Link to Font Awesome for icon usage -->

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 min-h-screen">
        <!-- Centered container with responsive padding and vertical spacing -->
        <div class="p-1 sm:p-8 bg-white shadow sm:rounded-lg">
            <!-- Profile information card with padding, background color, shadow, and rounded corners -->

            <div class="flex flex-col items-center pt-6"> <!-- Centering the profile picture and name -->
                @php
                    $imagePath = 'images/profile_pictures/' . $profile->userid . '.*'; // Define path to profile picture based on user ID
                    $matchingFiles = glob(public_path($imagePath)); // Get matching profile picture files
                    $profilePicture = !empty($matchingFiles) ? basename($matchingFiles[0]) : null; // Get the first matching file or null if none found
                @endphp
                <img src="{{ $profilePicture ? asset('images/profile_pictures/' . $profilePicture) : asset('images/defaults/default-avatar.png') }}"
                    alt="{{ $profile->name }}" class=" profile-picture ">
                <!-- Use object-cover to maintain aspect ratio -->
            </div>
            <h2 class="text-2xl sm:text-2xl font-bold text-center">{{ $profile->Name }}</h2>
            <p class="text-base sm:text-xl px-3 text-center">{{ $profile->bio }}</p>
            <!-- Display profile name directly under the picture -->

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
                        <div class="hidden absolute bg-white shadow-lg rounded-lg p-4 text-sm text-gray-700 w-full z-50 transform transition-transform duration-300" id="incomplete-fields" style="left: 50%; transform: translateX(-50%) translateY(-10px);">
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
           

            <div class="btn-group"> <!-- Button group for profile actions -->
                @if (Auth::id() == $profile->userid)
                    <!-- Check if the logged-in user is the profile owner -->
                    <a href="{{ route('profile.edit') }}" class="btn" data-tutorial="edit-profile">
                        <i class="fas fa-pen"></i> Edit Profile
                    </a>
                @else
                    @if (Auth::check() && Auth::user()->volunteer)
                        @if (Auth::user()->volunteer->followedVolunteers->contains($profile->userid))
                            <form action="{{ route('volunteers.unfollow', $profile) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn">
                                    <i class="fas fa-user-minus"></i> Unfollow
                                </button>
                            </form>
                        @else
                            <form action="{{ route('volunteers.follow', $profile) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn">
                                    <i class="fas fa-user-plus"></i> Follow
                                </button>
                            </form>
                        @endif
                    @endif                    
                @endif
                
                <div class="dropdown" data-tutorial="share-profile">
                    <button class="btn">
                        <i class="fas fa-share-alt"></i> Share Profile
                    </button>
                    <div class="dropdown-content">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                            target="_blank">Facebook</a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}"
                            target="_blank">Twitter</a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->url()) }}"
                            target="_blank">LinkedIn</a>
                        <a href="#" class="copy-link" data-url="{{ request()->url() }}">Copy Link</a>
                    </div>
                </div>
               
            </div>

             @if (session('status'))
                 <div class="mt-2 text-center text-sm text-gray-600">
                     {{ session('status') }}
                 </div>
             @endif

         
            <div class="profile-stats" data-tutorial="profile-stats">
                <div class="stat-item">
                    <h3>Projects</h3>
                    <p>{{ $completedActivities->count() }}</p>
                </div>
                <div class="stat-item">
                    <h3>Points</h3>
                    <p>{{ $profile->Points }}</p>
                </div>
                <div class="stat-item">
                    <h3>Level</h3>
                    <p>{{ $profile->getLevel() }}</p>
                </div>
            </div>

            
            <h3 class="text-lg sm:text-xl font-semibold mb-4 py-3 text-center" 
                data-tutorial="accomplishments"
                style="border-bottom: 2px solid transparent; border-image: linear-gradient(to right, #3B82F6, #10B981, #3B82F6); border-image-slice: 1; width: 50%; margin: 0 auto;">
                Accomplishments
            </h3>
                @php
                    $visibleActivities = $completedActivities->filter(function($activity) use ($profile) {
                        $volunteerPivot = $activity->volunteers->first();
                        return Auth::id() == $profile->userid || ($volunteerPivot && $volunteerPivot->pivot->visibility);
                    });
                @endphp

                @if ($visibleActivities->isEmpty())
                    <div class="text-center py-8 px-4 bg-gray-100 rounded-lg shadow-inner my-4">
                        <i class="fas fa-info-circle text-gray-500 text-2xl mb-2"></i>
                        <p class="text-gray-700 font-medium">No accomplishments are available for display at this time. This may be due to the absence of activities or the privacy settings of the posts.</p>
                    </div>
                @endif
                @if(!$profile->user->show_posts && Auth::id() !== $profile->userid)
                    <div class="text-center py-8 bg-gray-50 rounded-lg shadow-inner my-4">
                        <i class="fas fa-eye-slash text-gray-400 text-3xl mb-2"></i>
                        <p class="text-gray-600">This user has chosen to keep their posts private</p>
                    </div>
                @else
                    <div class="max-w-3xl mx-auto  mt-4 mb-0 pb-0">
                        @foreach ($completedActivities as $activity)
                            @php
                                $volunteerPivot = $activity->volunteers->first();
                                $activityVisibility = $volunteerPivot ? $volunteerPivot->pivot->visibility : true;
                            @endphp
                            @if (Auth::id() == $profile->userid || $activityVisibility)
                                <div class="border border-gray-300 shadow-lg rounded-lg overflow-hidden mb-4 ">

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
                                                <div class="flex space-x-2">
                                                    <div class="relative" x-data="{ open: false }">
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
                                                    @if (Auth::id() == $profile->userid)
                                                        <form action="{{ route('activities.toggle-visibility', ['activity' => $activity]) }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" 
                                                                class="flex items-center space-x-1 px-2 py-0.5 text-xs border border-gray-300 rounded-md hover:bg-gray-700 hover:text-white transition duration-150"
                                                                title="Make {{ $volunteerPivot && $volunteerPivot->pivot->visibility ? 'Private' : 'Public' }}">
                                                                <i class="fas {{ $volunteerPivot && $volunteerPivot->pivot->visibility ? 'fa-eye' : 'fa-eye-slash' }}"></i>
                                                                <span>{{ $volunteerPivot && $volunteerPivot->pivot->visibility ? 'Public' : 'Private' }}</span>
                                                            </button>
                                                        </form>
                                                    @endif
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
                                    <div class="px-4 py-1">
                                        <p class="text-sm text-gray-700 leading-relaxed">
                                            {{ $activity->description }}
                                        </p>
                                    </div>

                                    <!-- Activity Images -->
                                    <div class="px-2 py-2">
                                        <div class="aspect-w-1 aspect-h-1 w-full h-64">
                                            <a href="{{ route('activities.show_accomplished', $activity) }}" class="block w-full h-full">
                                                <x-activity-completed-images :activity="$activity" class="clickable-image hover:opacity-90 transition-opacity"/>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Activity Footer -->
                                    @if ($activity->status !== 'completed')
                                        <div class="px-6 py-4 bg-gray-500 mt-auto">
                                            <div class="flex justify-between items-center">
                                                <a href="{{ route('activities.show', $activity) }}"
                                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                                    View Details
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>

                @endif
        </div>
    </div>


    @push('scripts')
        @vite(['resources/js/popup.js']) <!-- Include JavaScript for popup functionality -->
    @endpush
    
    @if (Auth::id() == $profile->userid)
        <x-tutorial-popup/>
    @endif


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


