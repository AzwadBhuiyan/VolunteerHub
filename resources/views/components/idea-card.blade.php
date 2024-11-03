<!-- this is for favorites blade -->
{{-- <div class="p-6 flex items-center space-x-4 border-b border-gray-100">
    <img src="{{ asset($idea->organization->getLogoPath()) }}" alt="{{ $idea->organization->org_name }}" class="w-16 h-16 rounded-full object-cover">
    <div>
        <h4 class="text-xl font-semibold text-gray-800">{{ $idea->title }}</h4>
        <p class="text-sm text-gray-500">{{ $idea->created_at->format('M d, Y') }}</p>
    </div>
</div> --}}
<div class="p-3 flex items-center space-x-4 border-b border-gray-100">
    <img src="{{ asset($activity->organization->getLogoPath()) }}"
        alt="{{ $activity->organization->org_name }}"
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
         
        </div>
    </div>
</div>
<div class="p-6">
    <p class="text-gray-700 leading-relaxed">
        {{ Str::limit($idea->description, 150) }}
    </p>
</div>
{{-- <div class="px-6 py-4 bg-gray-50 mt-auto">
    <div class="flex justify-between items-center">
        <span class="text-blue-500">
            Posted by: {{ $idea->organization->org_name }}
        </span>
        <a href="{{ route('idea_board.show', $idea) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            View Idea
        </a>
    </div>
</div> --}}

<div class="px-2 py-2 bg-gray-50 mt-auto">
    <a href="{{ route('idea_board.show', $idea) }}"
        class="block text-center text-sm bg-gradient-to-br from-green-400 to-blue-600 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800 text-white font-bold  px-4 rounded">
        View Details
    </a>
</div>