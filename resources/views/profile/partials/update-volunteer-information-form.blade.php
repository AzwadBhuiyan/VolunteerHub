<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Volunteer Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your volunteer profile information.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="profile_picture" :value="__('Profile Picture')" />
            <input id="profile_picture" name="profile_picture" type="file" class="mt-1 block w-full" />
            <x-input-error class="mt-2" :messages="$errors->get('profile_picture')" />
        </div>

        <div>
            <x-input-label for="bio" :value="__('Bio')" />
            <x-text-area id="bio" name="bio" class="mt-1 block w-full" required>{{ old('bio', $profile->bio) }}</x-text-area>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>


        <div>
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" name="phone" type="tel" class="mt-1 block w-full" :value="old('phone', $profile->Phone)" required />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <div>
            <x-input-label for="blood_group" :value="__('Blood Group')" />
            <x-select id="blood_group" name="blood_group" class="mt-1 block w-full" required>
                @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $group)
                    <option value="{{ $group }}" {{ old('blood_group', $profile->BloodGroup) == $group ? 'selected' : '' }}>{{ $group }}</option>
                @endforeach
            </x-select>
            <x-input-error class="mt-2" :messages="$errors->get('blood_group')" />
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