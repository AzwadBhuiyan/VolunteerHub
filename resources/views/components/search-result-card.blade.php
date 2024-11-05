<div class="rounded-lg overflow-hidden shadow-sm border border-gray-200 p-4">
    <div class="flex flex-col items-center">
        @if($category === 'organizations')
            <img src="{{ asset($user->getLogoPath()) }}" 
                 alt="{{ $user->org_name }}" 
                 class="w-16 h-16 rounded-full object-cover mb-2">
            <a href="{{ route('profile.public', $user->url) }}" 
               class="text-blue-500 hover:underline text-center font-medium">
                {{ $user->organization->org_name }}
            </a>
            @if($user->organization->description)
                <p class="text-sm text-gray-600 mt-2 text-center">
                    {{ Str::limit($user->organization->description, 100) }}
                </p>
            @endif
        @else
            <img src="{{ asset($user->getProfilePicturePath()) }}" 
                 alt="{{ $user->Name }}" 
                 class="w-16 h-16 rounded-full object-cover mb-2">
            <a href="{{ route('profile.public', $user->url) }}" 
               class="text-blue-500 hover:underline text-center font-medium">
                {{ $user->Name }}
            </a>
            @if($user->bio)
                <p class="text-sm text-gray-600 mt-2 text-center">
                    {{ Str::limit($user->bio, 100) }}
                </p>
            @endif
        @endif
    </div>
</div>