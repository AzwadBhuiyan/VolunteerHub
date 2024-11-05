<!-- this is for favorites blade -->
{{-- <div class="p-6 flex items-center space-x-4 border-b border-gray-100">
    <img src="{{ asset($idea->organization->getLogoPath()) }}" alt="{{ $idea->organization->org_name }}" class="w-16 h-16 rounded-full object-cover">
    <div>
        <h4 class="text-xl font-semibold text-gray-800">{{ $idea->title }}</h4>
        <p class="text-sm text-gray-500">{{ $idea->created_at->format('M d, Y') }}</p>
    </div>
</div> --}}
<div class="p-3 flex items-center space-x-4 border-b border-gray-100 relative">
    <div class="absolute top-3 right-3" x-data="{ open: false }">
        <button @click="open = !open" 
            class="flex items-center space-x-1 px-2 py-0.5 text-xs border border-gray-300 rounded-md hover:bg-gray-50 transition duration-150">
            <i class="fas fa-share-alt"></i>
            <span>Share</span>
        </button>
        <div x-show="open" @click.away="open = false" 
            class="fixed right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border transform translate-x-0" 
            style="min-width: 12rem; position: absolute !important;">
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('idea_board.show', $idea)) }}" 
                target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <i class="fab fa-facebook mr-2"></i>Share on Facebook
            </a>
            <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('idea_board.show', $idea)) }}" 
                target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <i class="fab fa-twitter mr-2"></i>Share on Twitter
            </a>
            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('idea_board.show', $idea)) }}" 
                target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 whitespace-nowrap">
                <i class="fab fa-linkedin mr-2"></i>Share on LinkedIn
            </a>
            <button onclick="navigator.clipboard.writeText('{{ route('idea_board.show', $idea) }}')"
                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 whitespace-nowrap">
                <i class="fas fa-link mr-2"></i>Copy Link
            </button>
        </div>
    </div>

    <img src="{{ asset($idea->organization->getLogoPath()) }}"
        alt="{{ $idea->organization->org_name }}"
        class="w-10 h-10 rounded-full object-cover">
    <div class="flex flex-col ml-4 flex-grow">
        <h4 class="text-base font-semibold text-gray-800">{{ $idea->title }}
        </h4>
        <div class="text-xs text-gray-500">
            <a href="{{ route('profile.public', $idea->organization->url) }}"
                class="text-blue-500 hover:underline">{{ $idea->organization->org_name }}</a>
            <span>.</span>
            <span>{{ $idea->created_at->format('M d, Y') }}</span>
        </div>
    </div>
</div>

<div class="px-3 py-1">
    <p class="text-sm text-gray-700 leading-relaxed">
        {{ Str::limit($idea->description, 150) }}
    </p>
</div>

@if($idea->is_poll)
    <div class="px-3 py-2">
        <div class="text-sm text-gray-600">
            <i class="fas fa-poll mr-1"></i>
            {{ $idea->votes->count() }} {{ Str::plural('vote', $idea->votes->count()) }}
        </div>
        <div class="mt-2 space-y-2">
            @foreach($idea->poll_options as $option)
                <div class="bg-gray-50 rounded-md p-2">
                    <div class="flex justify-between text-sm">
                        <span>{{ $option->option_text }}</span>
                        <span>{{ $option->votes->count() }} votes</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@else
    <div x-data="{ showComments: false }" class="px-3 py-2">
        <button @click="showComments = !showComments" class="text-sm text-gray-600 hover:text-gray-800 transition duration-150">
            <i class="far fa-comment mr-1"></i>
            {{ $idea->comments->count() }} {{ Str::plural('comment', $idea->comments->count()) }}
        </button>
        
        <div x-show="showComments" class="mt-2 bg-gray-50 rounded-md p-3">
            <div class="max-h-60 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                @foreach($idea->comments as $comment)
                    <div class="mb-2 last:mb-0 p-2 bg-white rounded shadow-sm">
                        <p class="text-sm text-gray-800">{{ $comment->comment }}</p>
                        <div class="text-xs text-gray-500 mt-1">
                            {{ $comment->volunteer->Name }} • {{ $comment->created_at->diffForHumans() }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif

<div class="px-2 py-2 bg-gray-50 mt-auto">
    <a href="{{ route('idea_board.show', $idea) }}"
        class="block text-center text-sm bg-gradient-to-br from-green-400 to-blue-600 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800 text-white font-bold py-2 px-4 rounded">
        View Details
    </a>
</div>