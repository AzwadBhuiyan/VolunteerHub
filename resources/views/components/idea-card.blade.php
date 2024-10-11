<!-- this is for favorites blade -->
<div class="p-6 flex items-center space-x-4 border-b border-gray-100">
    <img src="{{ asset($idea->organization->getLogoPath()) }}" alt="{{ $idea->organization->org_name }}" class="w-16 h-16 rounded-full object-cover">
    <div>
        <h4 class="text-xl font-semibold text-gray-800">{{ $idea->title }}</h4>
        <p class="text-sm text-gray-500">{{ $idea->created_at->format('M d, Y') }}</p>
    </div>
</div>
<div class="p-6">
    <p class="text-gray-700 leading-relaxed">
        {{ Str::limit($idea->description, 150) }}
    </p>
</div>
<div class="px-6 py-4 bg-gray-50 mt-auto">
    <div class="flex justify-between items-center">
        <span class="text-blue-500">
            Posted by: {{ $idea->organization->org_name }}
        </span>
        <a href="{{ route('idea_board.show', $idea) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            View Idea
        </a>
    </div>
</div>