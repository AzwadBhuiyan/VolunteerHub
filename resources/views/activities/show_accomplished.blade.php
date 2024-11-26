<x-app-layout>
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 py-12">
        <div class="bg-white shadow-lg rounded-2xl overflow-hidden transition-all duration-300 hover:shadow-xl">
            {{-- Header Section --}}
            <div class="p-4 border-b bg-gradient-to-r from-gray-50 to-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        @if ($activity->organization->logo)
                            <img src="{{ asset($activity->organization->getLogoPath()) }}"
                                alt="{{ $activity->organization->org_name }}"
                                class="w-10 h-10 rounded-full object-cover ring-2 ring-blue-100 transform hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center ring-2 ring-blue-100 transform hover:scale-105 transition-transform duration-300">
                                <span class="text-xl font-bold text-white">{{ substr($activity->organization->org_name, 0, 1) }}</span>
                            </div>
                        @endif
                        <div>
                            <a href="{{ route('profile.public', $activity->organization->url) }}"
                                class="text-base font-semibold text-gray-900 hover:text-blue-600 transition">
                                {{ $activity->organization->org_name }}
                            </a>
                            <div class="flex items-center text-sm text-gray-500 mt-0.5">
                                <span>{{ $activity->date->format('M d, Y') }}</span>
                                <span class="mx-1.5">•</span>
                                <span>{{ $activity->time->format('g:i A') }}</span>
                                <span class="mx-1.5">•</span>
                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-green-600 font-medium ml-1">Accomplished</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Title & Description --}}
            <div class="p-3">
                <h1 class="text-2xl font-bold text-gray-900 mb-2 hover:text-blue-600 transition-colors duration-300">
                    {{ $activity->title }}
                </h1>
                <p class="text-gray-700 text-base leading-relaxed mb-2 bg-gray-50 p-2 rounded-lg">
                    {{ $activity->accomplished_description }}
                </p>

                {{-- Activity Details --}}
                <div class="flex flex-wrap gap-2 mb-2">
                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-pink-100 text-pink-800 shadow-sm hover:bg-pink-200 transition-all duration-300 transform hover:scale-105">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022l-.074.997zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342l-.36.933zm1.37.71a7.01 7.01 0 0 0-.439-.27l.493-.87a8.025 8.025 0 0 1 .979.654l-.615.789a6.996 6.996 0 0 0-.418-.302zm1.834 1.79a6.99 6.99 0 0 0-.653-.796l.724-.69c.27.285.52.59.747.91l-.818.576zm.744 1.352a7.08 7.08 0 0 0-.214-.468l.893-.45a7.976 7.976 0 0 1 .45 1.088l-.95.313a7.023 7.023 0 0 0-.179-.483zm.53 2.507a6.991 6.991 0 0 0-.1-1.025l.985-.17c.067.386.106.778.116 1.17l-1 .025zm-.131 1.538c.033-.17.06-.339.081-.51l.993.123a7.957 7.957 0 0 1-.23 1.155l-.964-.267c.046-.165.086-.332.12-.501zm-.952 2.379c.184-.29.346-.594.486-.908l.914.405c-.16.36-.345.706-.555 1.038l-.845-.535zm-.964 1.205c.122-.122.239-.248.35-.378l.758.653a8.073 8.073 0 0 1-.401.432l-.707-.707z" />
                            <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0v1z" />
                            <path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z" />
                        </svg>
                        {{ $activity->duration }} hours
                    </span>
                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800 shadow-sm hover:bg-blue-200 transition-all duration-300 transform hover:scale-105">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                        </svg>
                        {{ $activity->category }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-purple-100 text-purple-800 shadow-sm hover:bg-purple-200 transition-all duration-300 transform hover:scale-105">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                        </svg>
                        {{ $activity->district }}
                    </span>
                </div>

                {{-- Volunteers Section --}}
                <div class="flex flex-wrap gap-4 mb-6">
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800 shadow-sm hover:bg-green-200 transition-all duration-300 transform hover:scale-105 cursor-pointer" onclick="toggleVolunteerList()">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        {{ $activity->volunteers->count() }} {{ Str::plural('volunteer', $activity->volunteers->count()) }} participated
                    </span>
                </div>
                {{-- Popup with Volunteer Names and Profile Pictures --}}
                <div id="volunteerListPopup" class="hidden bg-white shadow-lg rounded-lg p-4 absolute z-50 border border-gray-200 backdrop-blur-sm bg-white/90">
                    <ul class="space-y-2">
                        @foreach ($activity->volunteers as $volunteer)
                            <li class="flex items-center text-sm text-gray-700 hover:bg-gray-50 p-2 rounded-lg transition-colors duration-300">
                                <a href="{{ route('profile.public', $volunteer->url) }}" class="flex items-center w-full">
                                    <img src="{{ $volunteer->getProfilePicturePath() }}" alt="{{ $volunteer->Name }}'s profile picture" 
                                         class="w-8 h-8 rounded-full mr-3 ring-2 ring-blue-100">
                                    <span class="font-medium hover:text-blue-600 transition-colors duration-300">{{ $volunteer->Name }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <script>
                    function toggleVolunteerList() {
                        const popup = document.getElementById('volunteerListPopup');
                        popup.classList.toggle('hidden');
                    }
                </script>

                {{-- Images Section --}}
                <div class="space-y-4">
                    @foreach ($accomplishedPhotos as $index => $photo)
                        <div class="w-full rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
                            <img src="{{ asset('images/activities/' . $activity->activityid . '/accomplished/' . basename($photo)) }}"
                                alt="Activity Photo {{ $index + 1 }}" 
                                class="w-full max-h-[600px] object-contain transform hover:scale-[1.02] transition-transform duration-300">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
