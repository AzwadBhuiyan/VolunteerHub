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
                        @php
                            $logoPath = 'images/logos/' . $profile->userid . '.*';
                            $matchingFiles = glob(public_path($logoPath));
                            $logoImage = !empty($matchingFiles) ? basename($matchingFiles[0]) : null;
                        @endphp
                        <img src="{{ $logoImage ? asset('images/logos/' . $logoImage) : asset('images/defaults/default-logo.png') }}"
                            alt="{{ $profile->Name }}" class="org-logo">
                        <div>
                            <h1 class="h1">{{ $profile->org_name }}</h1>
                            <p class="text-gray-600 mb-2">{{ $profile->description }}</p>
                           
                        </div>
                        
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
                    <hr class="mt-2 mb-2">
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

                    
                    




                        <div x-show="tab === 'ongoing'">
                            @foreach ($ongoingActivities as $activity)
                                <div class="mb-4 p-4 border rounded">
                                    <h4 class="font-semibold">{{ $activity->title }}</h4>
                                    <p class="text-sm text-gray-600">{{ $activity->date }}</p>
                                    <p>{{ Str::limit($activity->description, 100) }}</p>

                                    <!-- Activity Image -->
                                    @php
                                        $imagePath =
                                            'images/activities/' .
                                            $activity->activityid .
                                            '/' .
                                            $activity->activityid .
                                            '.jpg';
                                        $fullImagePath = public_path($imagePath);
                                        $imageExists = file_exists($fullImagePath);
                                    @endphp
                                    @if ($imageExists)
                                        <div class="mt-2">
                                            <img src="{{ asset($imagePath) }}" alt="{{ $activity->title }}"
                                                class="w-full h-48 object-cover rounded">
                                        </div>
                                    @endif
                                    <!-- Activity Buttons -->
                                    <div class="flex space-x-2 mb-4 mt-4 px-2">
                                        <a href="#"
                                            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 inline-block">View
                                            more details</a>
                                        @auth
                                            @if (Auth::user()->volunteer)
                                                <a href="#"
                                                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 inline-block">Register
                                                    now</a>
                                            @elseif(Auth::user()->organization && Auth::id() == $activity->userid)
                                                <a href="{{ route('activities.edit', $activity) }}"
                                                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 inline-block">Edit
                                                    activity</a>
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div x-show="tab === 'completed'" class="space-y-8">
                            @foreach ($completedActivities as $activity)
                                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                                    <!-- Activity Header -->

                                    <div class="px-6 py-4 flex items-center space-x-4 border-b border-gray-100">
                                        <img src="{{ $logoImage ? asset('images/logos/' . $logoImage) : asset('images/defaults/default-logo.png') }}"
                                            alt="{{ $profile->Name }}" class="w-12 h-12 rounded-full object-cover">
                                        <div>
                                            <h4 class="text-lg font-semibold text-gray-800">{{ $activity->title }}
                                            </h4>
                                            <p class="text-sm text-gray-500">{{ $activity->date->format('M d, Y') }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Accomplishment Description -->
                                    <div class="px-6 py-4">
                                        <p class="text-gray-700 leading-relaxed">
                                            {{ $activity->accomplished_description }}</p>
                                    </div>

                                    <!-- Accomplishment Photos -->
                                    <div class="px-6 py-4">
                                        <div class="flex space-x-2 overflow-x-auto pb-2">
                                            @php
                                                $accomplishedPath =
                                                    'images/activities/' . $activity->activityid . '/accomplished/';
                                                $accomplishedFullPath = public_path($accomplishedPath);
                                                $accomplishedPhotos = File::exists($accomplishedFullPath)
                                                    ? File::files($accomplishedFullPath)
                                                    : [];
                                            @endphp
                                            @foreach ($accomplishedPhotos as $photo)
                                                <img src="{{ asset($accomplishedPath . $photo->getFilename()) }}"
                                                    alt="Accomplished Activity Photo"
                                                    class="w-40 h-40 object-cover rounded-lg shadow-md flex-shrink-0">
                                            @endforeach
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

</x-app-layout>
