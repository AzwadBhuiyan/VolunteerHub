<x-app-layout>
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 min-h-screen">
        <div class="p-1 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="flex items-center mb-6">
                        @if($activity->organization->logo)
                            <img src="{{ asset($activity->organization->getLogoPath()) }}" 
                                alt="{{ $activity->organization->org_name }}" 
                                class="w-14 h-14 rounded-full object-cover mr-4">
                        @else
                            <div class="w-14 h-14 rounded-full bg-gray-200 flex items-center justify-center mr-4">
                                <span class="text-xl font-bold text-gray-600">{{ substr($activity->organization->org_name, 0, 1) }}</span>
                            </div>
                        @endif
                        <div>
                            <a href="{{ route('profile.public', $activity->organization->url) }}" class="text-lg font-semibold text-gray-900 hover:underline">
                                {{ $activity->organization->org_name }}
                            </a>
                            <p class="text-sm text-gray-500">Posted on {{ $activity->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>

                    <h1 class="text-2xl font-bold text-gray-900 mb-4">
                        {{ $activity->title }}
                    </h1>

                    @php
                        $imagePath = 'images/activities/' . $activity->activityid . '/';
                        $imageFullPath = public_path($imagePath);
                        $imageFiles = File::exists($imageFullPath) ? File::files($imageFullPath) : [];
                        $imageExists = !empty($imageFiles);
                        $imageSrc = $imageExists ? asset($imagePath . basename($imageFiles[0])) : asset('images/defaults/default-activity.jpg');
                    @endphp
                    @if($imageSrc)
                        {{-- <div class="mb-2 text-sm text-gray-500">
                            Debug path: {{ $imagePath }}
                        </div> --}}
                        <div class="mb-6">
                            <img src="{{ $imageSrc }}" 
                                alt="{{ $activity->title }}" 
                                class="w-full h-[250px] object-cover rounded-lg cursor-pointer clickable-image" 
                                data-full-src="{{ $imageSrc }}">
                        </div>
                    @else
                        <div class="mb-2 text-sm text-gray-500">No image available</div>
                    @endif

                    <p class="text-gray-700 text-lg mb-8 leading-relaxed">{{ $activity->description }}</p>
                    
                    <div class="bg-gray-50 rounded-lg p-6 mb-8">
                        <div class="text-center mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 inline-block border-b-2 border-gray-300 pb-2">Activity Details</h3>
                        </div>
                        <div class="grid grid-cols-2 gap-y-6 gap-x-8">
                            <div class="space-y-1">
                                <span class="block font-bold text-gray-700">Date:</span>
                                <span class="text-gray-600">{{ $activity->date->format('M d, Y') }}</span>
                            </div>
                            <div class="space-y-1">
                                <span class="block font-bold text-gray-700">Time:</span>
                                <span class="text-gray-600">{{ $activity->time->format('H:i') }}</span>
                            </div>
                            <div class="space-y-1">
                                <span class="block font-bold text-gray-700">Category:</span>
                                <span class="text-gray-600">{{ $activity->category }}</span>
                            </div>
                            <div class="space-y-1">
                                <span class="block font-bold text-gray-700">District:</span>
                                <span class="text-gray-600">{{ $activity->district }}</span>
                            </div>
                            <div class="space-y-1">
                                <span class="block font-bold text-gray-700">Deadline:</span>
                                <span class="text-gray-600">{{ $activity->deadline->format('M d, Y H:i') }}</span>
                            </div>
                            <div class="space-y-1">
                                <span class="block font-bold text-gray-700">Volunteers Required:</span>
                                <span class="text-gray-600">{{ $activity->min_volunteers }}</span>
                            </div>
                            <div class="col-span-2 space-y-1">
                                <span class="block font-bold text-gray-700">Location:</span>
                                <span class="text-gray-600">{{ $activity->address }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        @auth
                            @if(Auth::id() === $activity->userid || 
                                (Auth::user()->volunteer && $activity->volunteers()
                                    ->wherePivot('volunteer_userid', Auth::user()->volunteer->userid)
                                    ->wherePivot('approval_status', 'approved')
                                    ->exists()))
                                <a href="{{ route('activities.timeline', $activity) }}" 
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md text-sm font-medium transition-colors">
                                    View Activity Timeline
                                </a>
                            @endif

                            @if(Auth::user()->volunteer)
                                @php
                                    $isRegistered = $activity->volunteers()
                                        ->wherePivot('volunteer_userid', Auth::user()->volunteer->userid)
                                        ->exists();
                                @endphp
                                
                                @if($isRegistered)
                                    <button disabled class="px-4 py-2 bg-gray-400 text-white font-medium rounded-md cursor-not-allowed">
                                        Already Registered
                                    </button>
                                    @if($activity->deadline->isFuture())
                                        <form action="{{ route('activities.cancel_registration', $activity) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-md transition-colors">
                                                Cancel Registration
                                            </button>
                                        </form>
                                    @else
                                        <button disabled class="px-4 py-2 bg-gray-400 text-white font-medium rounded-md cursor-not-allowed">
                                            Cannot Cancel (Deadline Passed)
                                        </button>
                                    @endif
                                @else
                                    <form action="{{ route('activities.register', $activity) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition-colors">
                                            Register for this Activity
                                        </button>
                                    </form>
                                @endif
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition-colors">
                                Login to Register
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <x-image-popup/> -->
</x-app-layout>