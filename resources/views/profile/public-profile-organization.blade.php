<x-app-layout>
    <div class="relative">
        <img src="{{ $profile->cover_image ?? asset('images/default-cover.jpg') }}" alt="Cover Image" class="w-full h-64 object-cover">
        <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white p-4">
            <h1 class="text-3xl font-bold">{{ $profile->Name }}</h1>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="flex items-center space-x-4">
                    <img src="{{ $profile->logo ?? asset('images/default-logo.png') }}" alt="{{ $profile->Name }}" class="w-24 h-24 rounded-full">
                    <div>
                        <p class="mt-2">{{ $profile->description }}</p>
                        <a href="{{ $profile->website }}" class="text-blue-600 hover:underline">Visit Website</a>
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-xl font-semibold mb-4">Activities</h3>
                <div x-data="{ tab: 'ongoing' }">
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex">
                            <button @click="tab = 'ongoing'" :class="{'border-indigo-500 text-indigo-600': tab === 'ongoing'}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 w-1/2 py-4 px-1 text-center border-b-2 font-medium text-sm">
                                Ongoing Activities
                            </button>
                            <button @click="tab = 'completed'" :class="{'border-indigo-500 text-indigo-600': tab === 'completed'}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 w-1/2 py-4 px-1 text-center border-b-2 font-medium text-sm">
                                Completed Activities
                            </button>
                        </nav>
                    </div>
                    <div x-show="tab === 'ongoing'">
                        @foreach($ongoingActivities as $activity)
                            <div class="mb-4 p-4 border rounded">
                                <h4 class="font-semibold">{{ $activity->title }}</h4>
                                <p class="text-sm text-gray-600">{{ $activity->date }}</p>
                                <p>{{ Str::limit($activity->description, 100) }}</p>
                            </div>
                        @endforeach
                    </div>
                    <div x-show="tab === 'completed'">
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
        </div>
    </div>
</x-app-layout>