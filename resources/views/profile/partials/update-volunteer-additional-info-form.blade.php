<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Additional Details') }}
        </h2>
        <link href="{{ asset('css/volunteer-profile.css') }}" rel="stylesheet"> 

       
    </header>

    <form method="post" action="{{ route('profile.update.volunteer.additional') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>

            <x-input-label for="nid" :value="__('NID')" />
            <x-text-input id="nid" name="nid" type="text" class="mt-1 block w-full" :value="old('nid', $profile->NID)" />
            <x-input-error class="mt-2" :messages="$errors->get('nid')" />
        </div>

        <div>
            <x-input-label for="present_address" :value="__('Present Address')" />
            <x-text-area id="present_address" name="present_address" class="mt-1 block w-full" required>{{ old('present_address', $profile->PresentAddress) }}</x-text-area>
            <x-input-error class="mt-2" :messages="$errors->get('present_address')" />
        </div>

        <div>
            <x-input-label for="permanent_address" :value="__('Permanent Address')" />
            <x-text-area id="permanent_address" name="permanent_address" class="mt-1 block w-full" required>{{ old('permanent_address', $profile->PermanentAddress) }}</x-text-area>
            <x-input-error class="mt-2" :messages="$errors->get('permanent_address')" />
        </div>

        <div>
            <x-input-label for="district" :value="__('District')" />
            <x-select id="district" name="district" class="mt-1 block w-full" required>
                @foreach(['Dhaka', 'Chittagong', 'Rajshahi', 'Khulna', 'Barisal', 'Sylhet', 'Rangpur', 'Mymensingh'] as $district)
                    <option value="{{ $district }}" {{ old('district', $profile->District) == $district ? 'selected' : '' }}>{{ $district }}</option>
                @endforeach
            </x-select>
            <x-input-error class="mt-2" :messages="$errors->get('district')" />
        </div>

        <div>
            <label for="trained_in_emergency" class="inline-flex items-center">
                <input id="trained_in_emergency" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="trained_in_emergency" value="1" {{ old('trained_in_emergency', $profile->TrainedInEmergencyResponse) ? 'checked' : '' }}>
                <span class="ml-2 text-sm text-gray-600">{{ __('Trained in Emergency Response') }}</span>
            </label>
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