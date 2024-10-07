<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Favorite Activities') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-8">
            @if (!$favorites || (empty($favorites->favorite_categories) && empty($favorites->favorite_districts)))
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4" role="alert">
                    <p>You haven't selected any favorites yet. Please select your favorite categories and districts to see personalized activities.</p>
                </div>
                <a href="{{ route('favorites.edit') }}" class="mt-2 inline-block bg-black hover:bg-gray-800 text-white font-bold py-2 px-4 rounded">
                        Select Favorites
                    </a>
            @else
                <div class="mb-4 text-right">
                    <a href="{{ route('favorites.edit') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        Edit Favorites
                    </a>
                </div>
            @endif

            @if ($activities->isEmpty())
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <p class="text-gray-700">No ongoing activities match your favorites. Showing all available activities instead.</p>
                </div>
            @endif

            @foreach($activities as $activity)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col">
                    <!-- Activity Header -->
                    <div class="p-6 flex items-center space-x-4 border-b border-gray-100">
                        @php
                            $logoPath = 'images/logos/' . $activity->organization->userid . '.*';
                            $fullLogoPath = public_path($logoPath);
                            $logoExists = file_exists($fullLogoPath);
                        @endphp
                        <img src="{{ $logoExists ? asset($logoPath) : asset('images/defaults/default-logo.png') }}" alt="{{ $activity->organization->org_name }}" class="w-16 h-16 rounded-full object-cover">
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
                            <a href="{{ route('profile.public', $activity->organization->url) }}" class="text-blue-500 hover:underline">
                                Organized by: {{ $activity->organization->org_name }}
                            </a>
                            <a href="{{ route('activities.show', $activity) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
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

    <x-image-popup />
</x-app-layout>