<x-app-layout>
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
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @foreach($activities as $activity)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
                    <!-- Activity Header -->
                    <div class="px-6 py-4 flex items-center space-x-4 border-b border-gray-100">
                        @php
                            $logoPath = 'images/logos/' . $activity->organization->userid . '.jpg';
                            $fullLogoPath = public_path($logoPath);
                            $logoExists = file_exists($fullLogoPath);
                        @endphp
                        <img src="{{ $logoExists ? asset($logoPath) : asset('images/defaults/default-logo.png') }}" alt="{{ $activity->organization->org_name }}" class="w-12 h-12 rounded-full object-cover">
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800">{{ $activity->title }}</h4>
                            <p class="text-sm text-gray-500">{{ $activity->date->format('M d, Y') }}</p>
                        </div>
                    </div>

                    <!-- Activity Content -->
                    <div class="px-6 py-4">
                        @if($activity->status === 'completed')
                            <p class="text-gray-700 leading-relaxed">{{ $activity->accomplished_description }}</p>
                        @else
                            <p class="text-gray-700 leading-relaxed">{{ Str::limit($activity->description, 150) }}</p>
                        @endif
                    </div>

                    <!-- Activity Image -->
                    <div class="px-6 py-4">
                        @php
                            $imagePath = 'images/activities/' . $activity->activityid . '/' . $activity->activityid . '.jpg';
                            $fullImagePath = public_path($imagePath);
                            $imageExists = file_exists($fullImagePath);
                        @endphp
                        @if($imageExists)
                            <img src="{{ asset($imagePath) }}" alt="{{ $activity->title }}" class="w-full h-48 object-cover rounded">
                        @endif
                    </div>

                    <!-- Accomplishment Photos (for completed activities) -->
                    @if($activity->status === 'completed')
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
                    @endif

                    <!-- Activity Details and Actions -->
                    <div class="px-6 py-4">
                        <div class="mb-4">
                            <p><strong>Category:</strong> {{ $activity->category }}</p>
                            <p><strong>District:</strong> {{ $activity->district }}</p>
                            @if($activity->status !== 'completed')
                                <p><strong>Deadline:</strong> {{ $activity->deadline->format('M d, Y H:i') }}</p>
                                <p><strong>Volunteers Needed:</strong> {{ $activity->min_volunteers }} - {{ $activity->max_volunteers ?? 'No limit' }}</p>
                            @endif
                        </div>
                        <div class="flex justify-between items-center">
                            <a href="{{ route('profile.public', $activity->organization) }}" class="text-blue-500 hover:underline">
                                Organized by: {{ $activity->organization->org_name }}
                            </a>
                            <div>
                                <a href="{{ route('activities.show', $activity) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mr-2">
                                    View Details
                                </a>
                                @auth
                                    @if(Auth::user()->volunteer && $activity->status !== 'completed')
                                        @php
                                            $volunteerStatus = $activity->getVolunteerStatus(Auth::user()->volunteer->userid);
                                        @endphp
                                        @if($volunteerStatus === 'approved')
                                            <button disabled class="bg-gray-300 text-gray-500 font-bold py-2 px-4 rounded cursor-not-allowed">
                                                Already Registered
                                            </button>
                                        @elseif($volunteerStatus === 'pending')
                                            <form action="{{ route('activities.cancel_registration', $activity) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                                    Cancel Registration
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('activities.register', $activity) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                                    Register
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                @else
                                    @if($activity->status !== 'completed')
                                        <a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                            Login to Register
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="mt-4">
                {{ $activities->links() }}
            </div>
        </div>
    </div>
</x-app-layout>