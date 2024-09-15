<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Organization Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your organization's profile information.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="logo" :value="__('Logo')" />
            <input id="logo" name="logo" type="file" class="mt-1 block w-full" accept="image/*" />
            <x-input-error class="mt-2" :messages="$errors->get('logo')" />
        </div>

        <div>
            <x-input-label for="cover_image" :value="__('Cover Image')" />
            <input id="cover_image" name="cover_image" type="file" class="mt-1 block w-full" accept="image/*" />
            <x-input-error class="mt-2" :messages="$errors->get('cover_image')" />
        </div>

        <div>
            <x-input-label for="description" :value="__('Description')" />
            <x-text-area id="description" name="description" class="mt-1 block w-full" required>{{ old('description', $profile->description) }}</x-text-area>
            <x-input-error class="mt-2" :messages="$errors->get('description')" />
        </div>

        <div>
            <x-input-label for="website" :value="__('Website')" />
            <x-text-input id="website" name="website" type="url" class="mt-1 block w-full" :value="old('website', $profile->website)" required />
            <x-input-error class="mt-2" :messages="$errors->get('website')" />
        </div>

        <!-- <div>
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" name="phone" type="tel" class="mt-1 block w-full" :value="old('phone', $profile->phone)" required />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <div>
            <x-input-label for="address" :value="__('Address')" />
            <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $profile->address)" required />
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div> -->

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
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
</section>