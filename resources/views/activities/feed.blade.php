<x-public-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Activities Feed') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @if (session('success'))
            <div class="max-w-3xl mx-auto px-4 py-3 mb-4 bg-green-100 text-green-700 border border-green-400 rounded">
                {{ session('success') }}
            </div>
        @endif
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-8">
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
                            @if($activity->status === 'completed')
                                {{ $activity->accomplished_description }}
                            @else
                                {{ Str::limit($activity->description, 150) }}
                            @endif
                        </p>
                    </div>

                    <!-- Activity Images -->
                    <div class="p-6">
                        <div class="aspect-w-1 aspect-h-1">
                            @if($activity->status === 'completed')
                                <x-activity-completed-images :activity="$activity" />
                            @else
                                <x-activity-ongoing-image :activity="$activity" />
                            @endif
                        </div>
                    </div>

                    <!-- Activity Footer -->
                    <div class="px-6 py-4 bg-gray-50 mt-auto">
                        <div class="flex justify-between items-center">
                            <a href="{{ route('profile.public', $activity->organization->url) }}" class="text-blue-500 hover:underline">
                                Organized by: {{ $activity->organization->org_name }}
                            </a>
                            @if ($activity->status !== 'completed')
                            <a href="{{ route('activities.show', $activity) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                View Details
                            </a>
                            @endif
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
</x-public-layout>