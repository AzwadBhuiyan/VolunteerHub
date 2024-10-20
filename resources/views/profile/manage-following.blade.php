<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Manage Following
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Visit more organization profiles to follow them!
                </p>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Organizations you are currently following:
                </p>
            </div>
            <div class="border-t border-gray-200">
                <ul class="divide-y divide-gray-200">
                    @forelse ($followedOrganizations as $organization)
                        <li class="px-4 py-4 sm:px-6 flex justify-between items-center">
                            <div class="flex items-center">
                                <img class="h-10 w-10 rounded-full" src="{{ asset($organization->getLogoPath()) }}" alt="{{ $organization->org_name }}">
                                <a href="{{ route('profile.public', $organization->url) }}" class="ml-3 text-sm font-medium text-blue-600 hover:text-blue-800">
                                    {{ $organization->org_name }}
                                </a>
                            </div>
                            <form action="{{ route('organizations.unfollow', $organization) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                    Unfollow
                                </button>
                            </form>
                        </li>
                    @empty
                        <li class="px-4 py-4 sm:px-6 text-sm text-gray-500">
                            You are not following any organizations yet.
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
        <div class="mt-4 text-center">
            <a href="{{ route('favorites.show') }}" class="btn text-center">
                <i class="fas fa-arrow-left"></i> Back to Favorites
            </a>
        </div>
    </div>
</x-app-layout>
