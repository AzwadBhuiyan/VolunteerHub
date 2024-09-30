<x-app-layout>
    <!-- Cover Image -->
    <div class="w-full aspect-[21/9]">
        <!-- // to check if image exists -->
        @php
            $coverPath = 'images/cover/' . $profile->userid . '.jpg';
            $fullCoverPath = public_path($coverPath);
            $coverExists = file_exists($fullCoverPath);
        @endphp
        <img src="{{ $coverExists ? asset($coverPath) : asset('images/defaults/default-cover.jpg') }}" alt="Cover Image" class="w-full h-full object-cover">
    </div>

    <div class="container mx-auto p-4">

        <!-- Main Content -->
        <main class="bg-white shadow-md rounded-lg overflow-hidden">
            <!-- Profile Info -->
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <!-- // to check if image exists -->
                    @php
                        $logoPath = 'images/logos/' . $profile->userid . '.jpg';
                        $fullLogoPath = public_path($logoPath);
                        $logoExists = file_exists($fullLogoPath);
                    @endphp
                    <img src="{{ $logoExists ? asset($logoPath) : asset('images/defaults/default-logo.png') }}" alt="{{ $profile->Name }}" class="w-20 h-20 rounded-full object-cover mr-4">
                    <div>
                        <h1 class="text-gray-600">{{ $profile->org_name }}</h1>
                        <p class="text-gray-600">{{ $profile->description }}</p>
                        <a href="{{ $profile->website }}" class="text-blue-600 hover:underline">{{ $profile->website }}</a>
                        @if(Auth::id() == $profile->userid)
                            <a href="{{ route('profile.edit') }}" class="btn">
                                <i class="fas fa-pen"></i> Edit Profile
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex space-x-2 mb-4 justify-between">
                    <button class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Social</button>
                    <button class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">About</button>
                    <button class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Contact</button>
                    <button class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Website</button>
                </div>

                <!-- Activities Section -->
                <div x-data="{ tab: 'ongoing' }" class="mb-6">
                    <div class="flex justify-center space-x-2 mb-4">
                        <button @click="tab = 'ongoing'" :class="{'bg-green-600': tab === 'ongoing'}" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Ongoing</button>
                        <button @click="tab = 'completed'" :class="{'bg-green-600': tab === 'completed'}" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Completed</button>
                    </div>

                    <div x-show="tab === 'ongoing'">
                        @foreach($ongoingActivities as $activity)
                            <div class="mb-4 p-4 border rounded">
                                <h4 class="font-semibold">{{ $activity->title }}</h4>
                                <p class="text-sm text-gray-600">{{ $activity->date }}</p>
                                <p>{{ Str::limit($activity->description, 100) }}</p>
                                
                                <!-- Activity Image -->
                                @php
                                    $imagePath = 'images/activities/' . $activity->activityid . '/' . $activity->activityid . '.jpg';
                                    $fullImagePath = public_path($imagePath);
                                    $imageExists = file_exists($fullImagePath);
                                @endphp
                                @if($imageExists)
                                    <div class="mt-2">
                                        <img src="{{ asset($imagePath) }}" alt="{{ $activity->title }}" class="w-full h-48 object-cover rounded">
                                    </div>
                                @endif
                                <!-- Activity Buttons -->
                                <div class="flex space-x-2 mb-4 mt-4 px-2">
                                    <a href="#" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 inline-block">View more details</a>
                                    @auth
                                        @if(Auth::user()->volunteer)
                                            <a href="#" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 inline-block">Register now</a>
                                        @elseif(Auth::user()->organization && Auth::id() == $activity->userid)
                                            <a href="{{ route('activities.edit', $activity) }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 inline-block">Edit activity</a>
                                        @endif
                                    @endauth                            
                                </div>
                            </div>                            
                        @endforeach
                    </div>

                    <div x-show="tab === 'completed'" class="space-y-8">
                        @foreach($completedActivities as $activity)
                            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                                <!-- Activity Header -->
                                
                                <div class="px-6 py-4 flex items-center space-x-4 border-b border-gray-100">
                                    <img src="{{ $logoExists ? asset($logoPath) : asset('images/defaults/default-logo.png') }}" alt="{{ $profile->Name }}" class="w-12 h-12 rounded-full object-cover">
                                    <div>
                                        <h4 class="text-lg font-semibold text-gray-800">{{ $activity->title }}</h4>
                                        <p class="text-sm text-gray-500">{{ $activity->date->format('M d, Y') }}</p>
                                    </div>
                                </div>

                                <!-- Accomplishment Description -->
                                <div class="px-6 py-4">
                                    <p class="text-gray-700 leading-relaxed">{{ $activity->accomplished_description }}</p>
                                </div>

                                <!-- Accomplishment Photos -->
                                <div class="px-6 py-4">
                                    <div class="flex space-x-2 overflow-x-auto pb-2">
                                        @php
                                            $accomplishedPath = 'images/activities/' . $activity->activityid . '/accomplished/';
                                            $accomplishedFullPath = public_path($accomplishedPath);
                                            $accomplishedPhotos = File::exists($accomplishedFullPath) ? File::files($accomplishedFullPath) : [];
                                        @endphp
                                        @foreach($accomplishedPhotos as $photo)
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
    </div>
</x-app-layout>