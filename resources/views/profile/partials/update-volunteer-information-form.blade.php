<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Volunteer Information') }}
        </h2>
        <link href="{{ asset('css/volunteer-profile.css') }}" rel="stylesheet"> 

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your volunteer profile information.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

     

        <x-input-label for="profile_picture" :value="__('Upload Profile Picture')" />
        <div class="flex items-center space-x-4">            
            <div class="flex items-center">
                @php
                    $profilePicturePath = 'images/profile_pictures/' . $profile->userid . '.jpg';
                    $fullProfilePicturePath = public_path($profilePicturePath);
                    $profilePictureExists = file_exists($fullProfilePicturePath);
                @endphp
                <img id="profilePicturePreview" src="{{ $profilePictureExists ? asset($profilePicturePath) : asset('images/defaults/default-avatar.png') }}" alt="{{$profile->name}}" class="profile-picture mr-2">

                {{-- <input id="profile_picture" name="profile_picture" type="file" class="mt-1 block" accept="image/*" onchange="previewImage(this, 'profilePicturePreview')" /> --}}
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('profile_picture')" />
        </div>
        <p class="text-sm text-gray-600 mt-1">Maximum file size: 5MB</p>

        <div class="relative">
            <input id="profile_picture" name="profile_picture" type="file" class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*" onchange="previewImage(this, 'profilePicturePreview')"/>
            <button type="button" class="mt-1 block w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">
                {{ __('Upload Profile Picture') }}
            </button>
        </div>



        <div>
            <x-input-label for="bio" :value="__('Bio')" />
            <x-text-area id="bio" name="bio" class="mt-1 block w-full" required>{{ old('bio', $profile->bio) }}</x-text-area>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

   <!-- URL field -->
   <div>
    <x-input-label for="url" :value="__('Profile URL')" />
    <x-text-input id="url" name="url" type="text" class="mt-1 block w-full" :value="old('url', $profile->url)" required />
    <x-input-error class="mt-2" :messages="$errors->get('url')" />
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