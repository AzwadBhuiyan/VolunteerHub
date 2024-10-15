<section class="text-center">

    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Additional Details') }}
        </h2>
        <link href="{{ asset('css/volunteer-profile.css') }}" rel="stylesheet"> 
    </header>

    <form method="post" action="{{ route('profile.update.volunteer.additional') }}" class="mt-1 space-y-6 p-4"> <!-- Added padding to the form -->
        @csrf
        @method('patch')

        <div class="flex items-center"> <!-- Adjusted flex container for label and input -->
            <x-input-label for="nid" :value="__('NID')" class="w-1/4 mr-2 text-left" /> <!-- Added margin-right and text-left -->
            <x-text-input id="nid" name="nid" type="text" class="mt-1 block w-full" :value="old('nid', $profile->NID)" />
        </div>
        <x-input-error class="mt-2" :messages="$errors->get('nid')" />

        <div class="flex items-center"> <!-- Adjusted flex container for label and input -->
            <x-input-label for="present_address" :value="__('Present Address')" class="w-1/4 mr-2 text-left" />
            <x-text-area id="present_address" name="present_address" class="mt-1 block w-full" required>{{ old('present_address', $profile->PresentAddress) }}</x-text-area>
        </div>
        <x-input-error class="mt-2" :messages="$errors->get('present_address')" />

        <div class="flex items-center"> <!-- Adjusted flex container for label and input -->
            <x-input-label for="permanent_address" :value="__('Permanent Address')" class="w-1/4 mr-2 text-left" />
            <x-text-area id="permanent_address" name="permanent_address" class="mt-1 block w-full" required>{{ old('permanent_address', $profile->PermanentAddress) }}</x-text-area>
        </div>
        <x-input-error class="mt-2" :messages="$errors->get('permanent_address')" />

        <div class="flex items-center"> <!-- Adjusted flex container for label and input -->
            <x-input-label for="district" :value="__('District')" class="w-1/4 mr-2 text-left" />
            <x-select id="district" name="district" class="mt-1 block w-full" required>
                @foreach(['Dhaka', 'Chittagong', 'Rajshahi', 'Khulna', 'Barisal', 'Sylhet', 'Rangpur', 'Mymensingh'] as $district)
                    <option value="{{ $district }}" {{ old('district', $profile->District) == $district ? 'selected' : '' }}>{{ $district }}</option>
                @endforeach
            </x-select>
        </div>
        <x-input-error class="mt-2" :messages="$errors->get('district')" />

        <div class="flex items-center"> <!-- Adjusted flex container for checkbox -->
            <label for="trained_in_emergency" class="inline-flex items-center">
                <input id="trained_in_emergency" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="trained_in_emergency" value="1" {{ old('trained_in_emergency', $profile->TrainedInEmergencyResponse) ? 'checked' : '' }}>
                <span class="ml-2 text-sm text-gray-600">{{ __('Trained in Emergency Response') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-center gap-4"> <!-- Centered the button group -->
            <x-primary-button>{{ __('Save Additional Details') }}</x-primary-button>

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