<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Additional Organization Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your organization's additional contact information.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update.organization.additional') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="primary_address" :value="__('Primary Address')" />
            <x-text-input id="primary_address" name="primary_address" type="text" class="mt-1 block w-full" :value="old('primary_address', $profile->primary_address)" required />
            <x-input-error class="mt-2" :messages="$errors->get('primary_address')" />
        </div>

        <div>
            <x-input-label for="secondary_address" :value="__('Secondary Address')" />
            <x-text-input id="secondary_address" name="secondary_address" type="text" class="mt-1 block w-full" :value="old('secondary_address', $profile->secondary_address)" />
            <x-input-error class="mt-2" :messages="$errors->get('secondary_address')" />
        </div>

        <div>
            <x-input-label for="org_mobile" :value="__('Mobile Number')" />
            <x-text-input id="org_mobile" name="org_mobile" type="tel" class="mt-1 block w-full" :value="old('org_mobile', $profile->org_mobile)" required />
            <x-input-error class="mt-2" :messages="$errors->get('org_mobile')" />
        </div>

        <div>
            <x-input-label for="org_telephone" :value="__('Telephone Number')" />
            <x-text-input id="org_telephone" name="org_telephone" type="tel" class="mt-1 block w-full" :value="old('org_telephone', $profile->org_telephone)" />
            <x-input-error class="mt-2" :messages="$errors->get('org_telephone')" />
        </div>

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