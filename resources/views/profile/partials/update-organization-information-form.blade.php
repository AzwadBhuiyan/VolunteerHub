<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Organization Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your organization's profile information.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update.organization') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- URL field -->
        <div>
            <x-input-label for="url" :value="__('Profile URL')" />
            <x-text-input id="url" name="url" type="text" class="mt-1 block w-full" :value="old('url', $profile->url)" required />
            <x-input-error class="mt-2" :messages="$errors->get('url')" />
        </div>

        <div class="flex items-center space-x-4">
            <x-input-label for="logo" :value="__('Logo')" />
            <div class="flex items-center">
                @php
                    $logoPath = public_path('images/logos/' . $profile->userid . '.*');
                    $fullLogoPath = public_path($logoPath);
                    $logoExists = file_exists($fullLogoPath);
                @endphp
                <img id="logoPreview" src="{{ $logoExists ? asset($logoPath) : asset('images/defaults/default-logo.png') }}" alt="Current Logo" class="w-16 h-16 object-cover mr-2">

                <input id="logo" name="logo" type="file" class="mt-1 block" accept="image/*" onchange="previewImage(this, 'logoPreview')" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('logo')" />
        </div>
        <p class="text-sm text-gray-600 mt-1">Maximum file size: 5MB</p>

        <div class="flex items-center space-x-4 mt-4">
            <x-input-label for="cover_image" :value="__('Cover Image')" />
            <div class="flex items-center">
                @php
                    $coverPath = 'images/cover/' . $profile->userid . '.*';
                    $fullCoverPath = public_path($coverPath);
                    $coverExists = file_exists($fullCoverPath);
                @endphp
                <img id="coverPreview" src="{{ $coverExists ? asset($coverPath) : asset('images/defaults/default-cover.jpg') }}" alt="Current Cover Image" class="w-32 h-16 object-cover mr-2">
                <input id="cover_image" name="cover_image" type="file" class="mt-1 block" accept="image/*" onchange="previewImage(this, 'coverPreview')" />
            </div>
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