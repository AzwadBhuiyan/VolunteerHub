<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Favorites') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <form method="post" action="{{ route('favorites.update') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('patch')

                        @for ($i = 0; $i < 5; $i++)
                            <div>
                                <x-input-label for="favorite_{{ $i }}" :value="__('Favorite ' . ($i + 1))" />
                                <x-text-input id="favorite_{{ $i }}" name="favorites[]" type="text" class="mt-1 block w-full" :value="old('favorites.' . $i, $favorites[$i] ?? '')" />
                                <x-input-error :messages="$errors->get('favorites.' . $i)" class="mt-2" />
                            </div>
                        @endfor

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>

                            @if (session('status') === 'favorites-updated')
                                <p
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    x-init="setTimeout(() => show = false, 2000)"
                                    class="text-sm text-gray-600"
                                >{{ __('Saved.') }}</p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>