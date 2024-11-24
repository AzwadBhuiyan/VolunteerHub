<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Accomplished Activity: {{ $activity->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p class="font-bold">Accomplished Activitys</p>
                        <p>This activity has been successfully completed.</p>
                    </div>

                    <h3 class="text-2xl font-bold mb-4">{{ $activity->title }}</h3>

                    <div class="mb-6">
                        <h4 class="text-xl font-semibold mb-2">Accomplishment Description:</h4>
                        <p class="text-gray-700">{{ $activity->accomplished_description }}</p>
                    </div>

                    <div class="mb-6">
                        <h4 class="text-xl font-semibold mb-2">Activity Details:</h4>
                        <p><strong>Date:</strong> {{ $activity->date->format('M d, Y') }}</p>
                        <p><strong>Time:</strong> {{ $activity->time->format('H:i') }}</p>
                        <p><strong>Category:</strong> {{ $activity->category }}</p>
                        <p><strong>District:</strong> {{ $activity->district }}</p>
                        <p><strong>Address:</strong> {{ $activity->address }}</p>
                    </div>

                    <div class="mb-6">
                        <h4 class="text-xl font-semibold mb-2">Accomplishment Photos:</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                            @php
                                $accomplishedPath = 'images/activities/' . $activity->activityid . '/accomplished/';
                                $accomplishedFullPath = public_path($accomplishedPath);
                                $accomplishedPhotos = File::exists($accomplishedFullPath) ? File::files($accomplishedFullPath) : [];
                            @endphp
                            @foreach($accomplishedPhotos as $photo)
                                <img src="{{ asset($accomplishedPath . $photo->getFilename()) }}" 
                                     alt="Accomplished Activity Photo" 
                                     class="w-full h-48 object-cover rounded shadow-md">
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-4">
                        Organized by:
                        <a href="{{ route('profile.public', $activity->organization->url) }}" class="text-blue-500 hover:underline">
                             {{ $activity->organization->org_name }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>