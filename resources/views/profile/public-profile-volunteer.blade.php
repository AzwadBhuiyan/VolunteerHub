<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="flex items-center space-x-4">
                    <img src="{{ $profile->profile_picture ?? asset('images/default-avatar.png') }}" alt="{{ $profile->Name }}" class="w-24 h-24 rounded-full">
                    <div>
                        <h2 class="text-2xl font-bold">{{ $profile->Name }}</h2>
                        <p class="text-gray-600">{{ $profile->email }}</p>
                        <p class="mt-2">{{ $profile->bio }}</p>
                    </div>
                </div>
                @if(Auth::id() == $profile->userid)
                    <a href="{{ route('profile.edit') }}" class="mt-4 inline-block bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded">
                        Edit Profile
                    </a>
                @endif
                <div class="mt-4">
                    <h3 class="text-lg font-semibold">Badges</h3>
                    <div class="flex space-x-2 mt-2">
                        @if($profile->Badges && is_array(json_decode($profile->Badges, true)) && count(json_decode($profile->Badges, true)) > 0)
                            @foreach(json_decode($profile->Badges, true) as $badge)
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded">{{ $badge }}</span>
                            @endforeach
                        @else
                            <span class="text-gray-500">No badges yet</span>
                        @endif
                    </div>
                </div>
                <div class="mt-4">
                    <h3 class="text-lg font-semibold">Points</h3>
                    <p>{{ $profile->Points }}</p>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-xl font-semibold mb-4">Completed Activities</h3>
                @foreach($completedActivities as $activity)
                    <div class="mb-4 p-4 border rounded">
                        <h4 class="font-semibold">{{ $activity->title }}</h4>
                        <p class="text-sm text-gray-600">{{ $activity->date }}</p>
                        <p>{{ Str::limit($activity->description, 100) }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>