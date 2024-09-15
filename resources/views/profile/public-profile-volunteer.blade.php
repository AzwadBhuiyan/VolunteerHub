<x-app-layout>
    <link href="{{ asset('css/volunteer-profile.css') }}" rel="stylesheet"> 

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="flex flex-col sm:flex-row items-center sm:space-x-4">
                    <div class="flex-shrink-0 w-24 h-24 mb-4 sm:mb-0">
                        @php
                            $imagePath = 'images/profile_pictures/' . $profile->userid . '.jpg';
                            $fullPath = public_path($imagePath);
                            $exists = file_exists($fullPath);
                        @endphp
                        <!-- <img src="{{ $profile->profile_picture ? asset('images/profile_pictures/' . $profile->userid . '.jpg') : asset('images/defaults/default-avatar.png') }}"  -->
                        <img src="{{ $exists ? asset($imagePath) : asset('images/defaults/default-avatar.png') }}"                        
                            alt="{{ $profile->Name }}" 
                            class="profile-picture">
                    </div>
                    <div class="text-center sm:text-left">
                        <h2 class="text-xl sm:text-2xl font-bold">{{ $profile->Name }}</h2>
                        <p class="text-gray-600">{{ $profile->email }}</p>
                        <p class="mt-2">{{ $profile->bio }}</p>
                    </div>
                </div>
                <div class="btn-group">
                    @if(Auth::id() == $profile->userid)
                        <a href="{{ route('profile.edit') }}" class="btn">
                            <i class="fas fa-pen"></i> Edit Profile
                        </a>
                    @endif
                    <div class="dropdown">
                        <button class="btn">
                            <i class="fas fa-share-alt"></i> Share Profile
                        </button>
                        <div class="dropdown-content">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank">Facebook</a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}" target="_blank">Twitter</a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->url()) }}" target="_blank">LinkedIn</a>
                            <a href="#" class="copy-link" data-url="{{ request()->url() }}">Copy Link</a>
                        </div>
                    </div>
                </div>
                <div class="profile-stats">
                    <div class="stat-item">
                        <h3>Badges</h3>
                        <div class="badges-list">
                            @if($profile->Badges && is_array(json_decode($profile->Badges, true)) && count(json_decode($profile->Badges, true)) > 0)
                                @foreach(json_decode($profile->Badges, true) as $badge)
                                    <span class="badge">{{ $badge }}</span>
                                @endforeach
                            @else
                                <span class="no-badge">No badges yet</span>
                            @endif
                        </div>
                    </div>
                    <div class="stat-item">
                        <h3>Points</h3>
                        <p>{{ $profile->Points }}</p>
                    </div>
                    <div class="stat-item">
                        <h3>Level</h3>
                        <p>{{ $profile->Level }}</p>
                    </div>
                </div>

                {{-- <div class="mt-4">
                    <h3 class="text-lg font-semibold">Accomplishements</h3>
                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($completedActivities as $activity)
                            <div class="p-4 border rounded">
                                <h4 class="font-semibold">{{ $activity->title }}</h4>
                                <p class="text-sm text-gray-600">{{ $activity->date }}</p>
                                <p>{{ Str::limit($activity->description, 100) }}</p>
                            </div>
                        @endforeach
                    </div>
                </div> --}}
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg sm:text-xl font-semibold mb-4">Accomplishment</h3>
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($completedActivities as $activity)
                        <div class="p-4 border rounded">
                            <h4 class="font-semibold">{{ $activity->title }}</h4>
                            <p class="text-sm text-gray-600">{{ $activity->date }}</p>
                            <p>{{ Str::limit($activity->description, 100) }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const copyLink = document.querySelector('.copy-link');
        if (copyLink) {
            copyLink.addEventListener('click', function(e) {
                e.preventDefault();
                const url = this.getAttribute('data-url');
                navigator.clipboard.writeText(url).then(function() {
                    alert('Profile link copied to clipboard!');
                }, function(err) {
                    console.error('Could not copy text: ', err);
                });
            });
        }
    });
</script>