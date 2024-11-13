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
            <div class="flex justify-between items-start">
                <h4 class="text-base font-semibold text-gray-800 hover:bg-gradient-to-r hover:from-blue-600 hover:via-green-500 hover:to-blue-600 hover:bg-clip-text hover:text-transparent transition-all duration-300"><a href="{{ route('activities.show', $activity) }}" class="text-gray-800">{{ $activity->title }}</a></h4>
                <div class="relative ml-4" x-data="{ open: false }">
                    <button @click="open = !open" 
                        class="flex items-center space-x-1 px-2 py-0.5 text-xs border border-gray-300 rounded-md hover:bg-gray-50 transition duration-150">
                        <i class="fas fa-share-alt"></i>
                        <span>Share</span>
                    </button>
                    <div x-show="open" @click.away="open = false" 
                        class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 border">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('activities.show', $activity)) }}" 
                            target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fab fa-facebook mr-2"></i>Share on Facebook
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('activities.show', $activity)) }}" 
                            target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fab fa-twitter mr-2"></i>Share on Twitter
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('activities.show', $activity)) }}" 
                            target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fab fa-linkedin mr-2"></i>Share on LinkedIn
                        </a>
                        <button onclick="navigator.clipboard.writeText('{{ route('activities.show', $activity) }}')"
                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-link mr-2"></i>Copy Link
                        </button>
                    </div>
                </div>
            </div>
            <div class="text-xs text-gray-500 flex justify-between mt-1">
                <div>
                    <a href="{{ route('profile.public', $activity->organization->url) }}"
                        class="text-blue-500 hover:underline">{{ $activity->organization->org_name }}</a>
                    <span>.</span>
                    <span>{{ $activity->date->format('M d, Y') }}</span>
                </div>
                <span class="mr-4">
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
    @if($activity->required_profession)
        <div class="mt-2 flex items-center">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                <i class="fas fa-briefcase mr-1"></i>
                Required Profession: {{ $activity->required_profession }}
            </span>
        </div>
    @endif
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
