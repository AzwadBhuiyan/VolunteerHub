<section class="text-center"> <!-- Added class for center alignment -->
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update your information') }}
        </h2>
        <link href="{{ asset('css/volunteer-profile.css') }}" rel="stylesheet"> 
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-1 space-y-6 p-4 w-full" enctype="multipart/form-data"> <!-- Adjusted width to be full -->
        @csrf
        @method('patch')

        {{-- <x-input-label for="profile_picture" :value="__('Upload Profile Picture')" /> --}}
        <div class="flex items-center justify-center space-x-4"> <!-- Centered the flex items -->
            <div class="flex items-center">
                @php
                    $profilePicturePath = 'images/profile_pictures/' . $profile->userid . '.*';
                    $matchingFiles = glob(public_path($profilePicturePath));
                    $profilePicture = !empty($matchingFiles) ? basename($matchingFiles[0]) : null;
                @endphp
                <img id="profilePicturePreview" src="{{ $profilePicture ? asset('images/profile_pictures/' . $profilePicture) : asset('images/defaults/default-avatar.png') }}" alt="{{$profile->name}}" class="profile-picture mr-2">

                {{-- <input id="profile_picture" name="profile_picture" type="file" class="mt-1 block" accept="image/*" onchange="previewImage(this, 'profilePicturePreview')" /> --}}
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('profile_picture')" />
        </div>
        <p class="text-sm text-gray-600 mt-1">Maximum file size: 5MB</p>

        <div class="relative">
            <input id="profile_picture" name="profile_picture" type="file" class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*" onchange="previewImage(this, 'profilePicturePreview')"/>
            <button type="button" class="mt-1 block w-1/2 bg-blue-500 text-white py-2 rounded-full hover:bg-blue-600 mx-auto flex items-center justify-center px-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-upload mr-2" viewBox="0 0 16 16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
                    <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708z"/>
                </svg>
                {{ __('Upload Profile Picture') }}
            </button>
        </div>

        <div class="flex items-center"> <!-- Adjusted flex container for label and input -->
            <x-input-label for="bio" :value="__('Bio')" class="w-1/4 mr-2 text-left" /> <!-- Added margin-right and text-left -->
            <x-text-area id="bio" name="bio" class="mt-1 block w-full" required>{{ old('bio', $profile->bio) }}</x-text-area> <!-- Set width to full -->
        </div>
        <x-input-error class="mt-2" :messages="$errors->get('bio')" />

        <div class="flex items-center"> <!-- Adjusted flex container for label and input -->
            <x-input-label for="url" :value="__('Profile URL')" class="w-1/4 mr-2 text-left" />
            <x-text-input id="url" name="url" type="text" class="mt-1 block w-full" :value="old('url', $profile->url)" required />
        </div>
        <p class="text-sm text-gray-500">Note: When you share your profile this is what will show in the website url</p>
        <x-input-error class="mt-2" :messages="$errors->get('url')" />

        <div class="flex items-center"> <!-- Adjusted flex container for label and input -->
            <x-input-label for="phone" :value="__('Phone')" class="w-1/4 mr-2 text-left" />
            <x-text-input id="phone" name="phone" type="tel" class="mt-1 block w-full" :value="old('phone', $profile->Phone)" required />
        </div>
        <x-input-error class="mt-2" :messages="$errors->get('phone')" />

        <div class="flex items-center"> <!-- Adjusted flex container for label and input -->
            <x-input-label for="blood_group" :value="__('Blood Group')" class="w-1/4 mr-2 text-left" />
            <x-select id="blood_group" name="blood_group" class="mt-1 block w-full" required>
                @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $group)
                    <option value="{{ $group }}" {{ old('blood_group', $profile->BloodGroup) == $group ? 'selected' : '' }}>{{ $group }}</option>
                @endforeach
            </x-select>
        </div>
        <x-input-error class="mt-2" :messages="$errors->get('blood_group')" />

        <!-- FOLLOWER CONTROL ALLOW/DISALLOW -->
        <!-- <div class="flex items-center mt-4">
            <x-input-label for="allow_follow" :value="__('Follow Settings')" class="w-1/4 mr-2 text-left" />
            <div class="flex flex-col space-y-2">
                <label class="inline-flex items-center">
                    <input type="radio" 
                        name="allow_follow" 
                        value="1" 
                        class="form-radio" 
                        {{ $profile->allow_follow ? 'checked' : '' }}>
                    <span class="ml-2">Allow other volunteers to follow me</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" 
                        name="allow_follow" 
                        value="0" 
                        class="form-radio" 
                        {{ !$profile->allow_follow ? 'checked' : '' }}>
                    <span class="ml-2">Don't allow new followers</span>
                </label>
                <p class="text-sm text-gray-500">Note: Existing followers will remain even if you disable new follows</p>
            </div>
        </div> -->

        <div class="flex items-center justify-center gap-4"> <!-- Centered the button group -->
            <x-primary-button>{{ __('Save Primary Details') }}</x-primary-button>

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

    <!-- TODO: move this to single js file -->
    <script>
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById(previewId).src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

</section>