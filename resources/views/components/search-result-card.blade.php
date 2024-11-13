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
            <div class="flex justify-between items-center w-full">
                <div class="flex flex-col">
                    <a href="{{ route('profile.public', $user->url) }}" 
                       class="text-base font-semibold text-gray-800 hover:text-blue-600">
                        {{ $user->Name }}
                    </a>
                </div>
                {{-- <div class="flex items-center justify-center bg-gradient-to-br from-blue-500 via-blue-600 to-blue-700 w-14 h-16 shadow-lg relative" style="clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%); border: 3px solid #2563eb;">
                    <div class="text-white text-sm font-bold">
                        <span class="block text-center">Lvl</span>
                        <span class="block text-center text-lg">{{ $user->getLevel() }}</span> --}}
                        
                        <div class="flex items-center justify-center px-3 py-1">
                    <div class="text-gray-700 text-sm font-semibold">
                        Level {{ $user->getLevel() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>