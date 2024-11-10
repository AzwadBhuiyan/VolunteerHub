<div class="rounded-lg mb-4 overflow-hidden flex flex-col shadow-lg border border-gray-200">
    <div class="p-3 flex items-center space-x-4 hover:bg-gray-100">
        @if($category === 'organizations')
            <a href="{{ route('profile.public', $user->url) }}" class="flex-shrink-0">
                <img src="{{ asset($user->getLogoPath()) }}" 
                     alt="{{ $user->org_name }}" 
                     class="w-10 h-10 rounded-full object-cover">
            </a>
            <div class="flex flex-col flex-grow">
                <a href="{{ route('profile.public', $user->url) }}" 
                   class="text-base font-semibold text-gray-800 hover:text-blue-600">
                    {{ $user->org_name }}
                </a>
                <div class="text-sm text-gray-500">
                    {{ $user->website ?? 'No website provided' }}
                </div>
            </div>
        @else
            <a href="{{ route('profile.public', $user->url) }}" class="flex-shrink-0">
                <img src="{{ asset($user->getProfilePicturePath()) }}" 
                     alt="{{ $user->Name }}" 
                     class="w-10 h-10 rounded-full object-cover">
            </a>
            <div class="flex flex-col flex-grow">
                <a href="{{ route('profile.public', $user->url) }}" 
                   class="text-base font-semibold text-gray-800 hover:text-blue-600">
                    {{ $user->Name }}
                </a>
                <div class="text-sm text-gray-500">
                    Level: {{ $user->getLevel() }}
                </div>
            </div>
        @endif
    </div>
</div>