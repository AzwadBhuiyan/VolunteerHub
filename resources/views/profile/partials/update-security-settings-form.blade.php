<section class="text-center">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Security Settings') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Manage your account security preferences.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update.security') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        @if($user->volunteer)
            <!-- Follow Settings -->
            <div class="flex items-center mt-4">
                <x-input-label for="allow_follow" :value="__('Follow Settings')" class="w-1/4 mr-2 text-left" />
                <div class="flex flex-col space-y-2">
                    <label class="inline-flex items-center">
                        <input type="radio" 
                            name="allow_follow" 
                            value="1" 
                            class="form-radio" 
                            {{ $user->volunteer->allow_follow ? 'checked' : '' }}>
                        <span class="ml-2">Allow other volunteers to follow me</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" 
                            name="allow_follow" 
                            value="0" 
                            class="form-radio" 
                            {{ !$user->volunteer->allow_follow ? 'checked' : '' }}>
                        <span class="ml-2">Don't allow new followers</span>
                    </label>
                    <p class="text-sm text-gray-500">Note: Existing followers will remain even if you disable new follows</p>
                </div>
            </div>
        @endif

        <!-- Two Factor Authentication -->
        <div class="flex items-center">
            <x-input-label for="two_factor_enabled" :value="__('Two-Factor Authentication')" class="w-1/4 mr-2 text-left" />
            <div class="flex flex-col space-y-2">
                <label class="inline-flex items-center">
                    <input type="radio" 
                        name="two_factor_enabled" 
                        value="1" 
                        class="form-radio" 
                        {{ $user->two_factor_enabled ? 'checked' : '' }}>
                    <span class="ml-2">Enable email verification at login</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" 
                        name="two_factor_enabled" 
                        value="0" 
                        class="form-radio" 
                        {{ !$user->two_factor_enabled ? 'checked' : '' }}>
                    <span class="ml-2">Disable two-factor authentication</span>
                </label>
                <p class="text-sm text-gray-500">When enabled, an OTP will be sent to your email for verification when you login</p>
            </div>
        </div>

        <!-- Account Lockout Settings -->
        <div class="flex items-center">
            <x-input-label for="max_attempts" :value="__('Maximum Login Attempts')" class="w-1/4 mr-2 text-left" />
            <div class="w-3/4">
                <x-text-input id="max_attempts" 
                    name="max_attempts" 
                    type="number" 
                    class="mt-1 block w-full" 
                    :value="old('max_attempts', 5)"
                    min="3"
                    max="10"
                />
                <p class="text-xs text-gray-500 mt-1">Account will be temporarily locked after specified failed attempts</p>
            </div>
        </div>

        <!-- Post Visibility Settings -->
        <div class="flex items-center">
            <x-input-label for="show_posts" :value="__('Post Visibility')" class="w-1/4 mr-2 text-left" />
            <div class="flex flex-col space-y-2">
                <label class="inline-flex items-center">
                    <input type="radio" 
                        name="show_posts" 
                        value="1" 
                        class="form-radio" 
                        {{ $user->show_posts ? 'checked' : '' }}>
                    <span class="ml-2">Show my posts on profile</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" 
                        name="show_posts" 
                        value="0" 
                        class="form-radio" 
                        {{ !$user->show_posts ? 'checked' : '' }}>
                    <span class="ml-2">Hide my posts from profile</span>
                </label>
                <p class="text-sm text-gray-500">When hidden, other users won't be able to see your posts on your profile. You will still see them.</p>
            </div>
        </div>

        <!-- Tutorial Settings -->
        <div class="flex items-center">
            <x-input-label for="show_tutorials" :value="__('Tutorial Guidance')" class="w-1/4 mr-2 text-left" />
            <div class="flex flex-col space-y-2">
                <label class="inline-flex items-center">
                    <input type="radio" 
                        name="show_tutorials" 
                        value="1" 
                        class="form-radio" 
                        {{ !$anyTutorialDisabled ? 'checked' : '' }}>
                    <span class="ml-2">Enable all tutorials</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" 
                        name="show_tutorials" 
                        value="0" 
                        class="form-radio" 
                        {{ $anyTutorialDisabled ? 'checked' : '' }}>
                    <span class="ml-2">Disable all tutorials</span>
                </label>
                <p class="text-sm text-gray-500">When enabled, tutorial guidance will be shown for all pages</p>
            </div>
        </div>

        <!-- Password Strength Indicator -->
         <br><br>
        <div class="mt-6">
            <h3 class="text-sm font-medium text-gray-900 mb-2">{{ __('Current Password Strength') }}</h3>
            <div class="w-full bg-gray-200 rounded-full h-2.5">
                @php
                    $strength = 0;
                    // Add logic here to calculate password strength
                    $strengthClass = match($strength) {
                        0 => 'bg-red-500',
                        1 => 'bg-orange-500',
                        2 => 'bg-yellow-500',
                        3 => 'bg-green-500',
                        default => 'bg-gray-500'
                    };
                @endphp
                <div class="{{ $strengthClass }} h-2.5 rounded-full" style="width: 45%"></div>
            </div>
            <div class="mt-2 text-sm text-gray-600">
                <p class="font-medium">Password Suggestions:</p>
                <ul class="list-disc list-inside text-xs space-y-1 mt-1">
                    <li>Use at least 8 characters</li>
                    <li>Include uppercase and lowercase letters</li>
                    <li>Add numbers and special characters</li>
                    <li>Avoid common words and patterns</li>
                </ul>
            </div>
        </div>

        <div class="flex items-center justify-center gap-4 mt-6">
            <x-primary-button>{{ __('Save Security Settings') }}</x-primary-button>

            @if (session('status') === 'security-updated')
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

