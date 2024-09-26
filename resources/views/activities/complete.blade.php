<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Complete Activity') }}: {{ $activity->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('activities.complete.store', $activity) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="mb-4">
                            <x-input-label for="accomplished_description" :value="__('Accomplished Description')" />
                            <textarea id="accomplished_description" name="accomplished_description" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" rows="4" required>{{ old('accomplished_description') }}</textarea>
                            <x-input-error :messages="$errors->get('accomplished_description')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="duration" :value="__('Duration (in hours)')" />
                            <x-text-input id="duration" class="block mt-1 w-full" type="number" name="duration" :value="old('duration')" step="0.5" min="0.5" required />
                            <x-input-error :messages="$errors->get('duration')" class="mt-2" />
                            <p class="text-sm text-gray-600 mt-1">Enter duration in hours. Minimum 1 hour. Will be rounded up to the nearest hour.</p>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="photos" :value="__('Photos (1-5)')" />
                            <input id="photos" name="photos[]" type="file" class="mt-1 block w-full" accept="image/*" multiple required />
                            <x-input-error :messages="$errors->get('photos')" class="mt-2" />
                            <p class="text-sm text-gray-600 mt-1">You can upload 1-5 photos. Maximum file size: 5MB each. Your post view will differ based on the number of photos</p>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Complete Activity') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>