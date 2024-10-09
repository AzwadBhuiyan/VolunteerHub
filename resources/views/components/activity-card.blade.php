<!-- this is for favorites blade -->
<div class="p-6 flex items-center space-x-4 border-b border-gray-100">
    <img src="{{ asset($activity->organization->getLogoPath()) }}" alt="{{ $activity->organization->org_name }}" class="w-16 h-16 rounded-full object-cover">
    <div>
        <h4 class="text-xl font-semibold text-gray-800">{{ $activity->title }}</h4>
        <p class="text-sm text-gray-500">{{ $activity->date->format('M d, Y') }}</p>
    </div>
</div>
<div class="p-6">
    <p class="text-gray-700 leading-relaxed">
        {{ Str::limit($activity->description, 150) }}
    </p>
</div>
<div class="p-6">
    <div class="aspect-w-1 aspect-h-1">
        <x-activity-ongoing-image :activity="$activity" />
    </div>
</div>
<div class="px-6 py-4 bg-gray-50 mt-auto">
    <div class="flex justify-between items-center">
        <a href="{{ route('profile.public', $activity->organization->url) }}" class="text-blue-500 hover:underline">
            Organized by: {{ $activity->organization->org_name }}
        </a>
        <a href="{{ route('activities.show', $activity) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            View Details
        </a>
    </div>
</div>