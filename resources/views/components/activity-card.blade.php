<!-- ````````````````````````` -->
<!-- this is for favorites blade -->
<!-- this is for favorites blade -->
<!-- this is for favorites blade -->
<!-- this is for favorites blade -->
<!-- this is for favorites blade -->
<!-- this is for favorites blade -->
<!-- ````````````````````````` -->

<div class="rounded-lg mb-4 overflow-hidden flex flex-col shadow-lg border border-gray-200">

    <div class="p-3 flex items-center space-x-4 border-b border-gray-100">
        <img src="{{ asset($activity->organization->getLogoPath()) }}" alt="{{ $activity->organization->org_name }}"
            class="w-10 h-10 rounded-full object-cover">
        <div class="flex flex-col ml-4 flex-grow">
            <h4 class="text-base font-semibold text-gray-800">{{ $activity->title }}
            </h4>
            <div class="text-xs text-gray-500 flex justify-between">
                <div>
                    <a href="{{ route('profile.public', $activity->organization->url) }}"
                        class="text-blue-500 hover:underline">{{ $activity->organization->org_name }}</a>
                    <span>.</span>
                    <span>{{ $activity->date->format('M d, Y') }}</span>
                </div>
                <span>
                    <i class="fas fa-map-marker-alt mr-1"></i>
                    {{ $activity->district }}
                </span>
            </div>
        </div>
    </div>
    <div class="px-4 py-1">
        <p class="text-sm text-gray-700 leading-relaxed">
            {{ Str::limit($activity->description, 150) }}
        </p>
    </div>
    <div class="px-2 py-2">
        <div class="aspect-w-4 aspect-h-3">
            <x-activity-ongoing-image :activity="$activity" />
        </div>
    </div>
    <div class="px-2 py-2 bg-gray-50 mt-auto">
        <a href="{{ route('activities.show', $activity) }}"
            class="block text-center text-sm bg-gradient-to-br from-green-400 to-blue-600 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800 text-white font-bold py-2 px-4 rounded">
            View Details
        </a>
    </div>
</div>
