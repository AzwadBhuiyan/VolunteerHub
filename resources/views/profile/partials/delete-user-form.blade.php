<section class="delete-section space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('By proceeding with account deletion, you acknowledge that all associated data, including but not limited to personal information, activity history, and any other content, will be irreversibly removed from our systems. This action is final and cannot be undone. Please ensure that you have read and understood our terms and conditions before proceeding.') }}
        </p>
    </header>
    <div class="flex items-center">
        <input type="checkbox" id="terms" name="terms" required>
        <label for="terms" class="ml-2 text-sm text-gray-600">I confirm that I have read and understood the terms, and I wish to permanently delete my account.</label>
    </div>

    <x-danger-button
        x-data=""
        x-on:click.prevent="checkTerms()"
    >{{ __('Delete Account') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>

<script>
    function checkTerms() {
        const checkbox = document.getElementById('terms');
        if (!checkbox.checked) {
            alert("Please read the terms and check the box before deleting your account.");
        } else {
            // Open the modal for confirmation
            $dispatch('open-modal', 'confirm-user-deletion');
        }
    }
</script>
