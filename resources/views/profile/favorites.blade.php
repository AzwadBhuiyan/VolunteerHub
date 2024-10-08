<x-app-layout>
    <link href="{{ asset('css/volunteer-profile.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <div class="p-4 sm:p-8 bg-white items-center shadow sm:rounded-lg">

    <div class="px-1">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-8">
            @if (!$favorites || (empty($favorites->favorite_categories) && empty($favorites->favorite_districts)) && $volunteer->followedOrganizations->isEmpty()))
                <div class="bg-yellow-100 border-yellow-500 text-yellow-700 p-4 mb-4 flex items-center"
                    role="alert">
                    <i class="bi bi-exclamation-triangle-fill text-2xl mr-4"></i>
                    <p>Please select your favorite categories and locations to see your favorite activities here.</p>
                </div>
        </div>
            <div class="text-center">
                <a href="{{ route('favorites.edit') }}" class="btn mb-2">
                    <i class="fas fa-plus"></i>Add Favorites
                </a>
            </div>
        @else
        <div class="text-center">
            <a href="{{ route('favorites.edit') }}" class="btn text-center mb-2">
                Edit Favorites
            </a>
        </div>
            @endif

        @if ($activities->isEmpty())
            <div class="bg-white rounded-xl shadow-lg p-6">
                <p class="text-gray-700">No ongoing activities match your favorites. Showing all available activities
                    instead.</p>
            </div>
        @endif

        @foreach ($activities as $activity)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col">
                <!-- Activity Header -->
                <div class="p-6 flex items-center space-x-4 border-b border-gray-100">
                    @php
                        $logoPath = 'images/logos/' . $activity->organization->userid . '.*';
                        $fullLogoPath = public_path($logoPath);
                        $logoExists = file_exists($fullLogoPath);
                    @endphp
                    <img src="{{ $logoExists ? asset($logoPath) : asset('images/defaults/default-logo.png') }}"
                        alt="{{ $activity->organization->org_name }}" class="w-16 h-16 rounded-full object-cover">
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
                        <a href="{{ route('profile.public', $activity->organization->url) }}"
                            class="text-blue-500 hover:underline">
                            Organized by: {{ $activity->organization->org_name }}
                        </a>
                        <a href="{{ route('activities.show', $activity) }}"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="mt-8">
            {{ $activities->links() }}
        </div>
    </div>
    </div>
</div>
    <x-image-popup />
</x-app-layout>
