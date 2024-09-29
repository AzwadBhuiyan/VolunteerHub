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
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">{{ $activity->title }}</h3>
                            <span class="text-sm text-gray-500">{{ $activity->date->format('M d, Y') }}</span>
                        </div>
                        <p class="text-gray-700 mb-4">{{ Str::limit($activity->description, 150) }}</p>
                        @if($activity->image)
                            <img src="{{ asset('images/activities/' . $activity->activityid . '/' . $activity->activityid . '.*') }}" 
                                 alt="{{ $activity->title }}" 
                                 class="w-full h-64 object-cover mb-4 rounded">
                        @endif
                        <div class="mb-4">
                            <p><strong>Category:</strong> {{ $activity->category }}</p>
                            <p><strong>District:</strong> {{ $activity->district }}</p>
                            <p><strong>Deadline:</strong> {{ $activity->deadline->format('M d, Y H:i') }}</p>
                            <p><strong>Volunteers Needed:</strong> {{ $activity->min_volunteers }} - {{ $activity->max_volunteers ?? 'No limit' }}</p>
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
                                    @if(Auth::user()->volunteer)
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
                                    <a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Login to Register
                                    </a>
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