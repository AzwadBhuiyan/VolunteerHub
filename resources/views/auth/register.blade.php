<x-guest-layout>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <h3 class="mt-6 text-center text-2xl font-extrabold">
        Create your account</h3>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- User Type -->
        <div class="mt-4 flex items-center" style="min-width: 300px">
            <label for="user_type" class="mr-2 whitespace-nowrap" style="min-width: 80px">User Type:</label>
            <select id="user_type" name="user_type"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                data-required onchange="toggleUserType()">
                <option value="volunteer">Volunteer</option>
                <option value="organization">Organization</option>
            </select>
            <x-input-error :messages="$errors->get('user_type')" class="mt-2" />
        </div>

        <!-- Volunteer Fields -->
        <div id="volunteer-fields" style="display: none;">
            <!-- Name -->
            <div class="mt-4">
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                    :value="old('name')" data-required autofocus autocomplete="name" placeholder="Full Name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
        </div>

        <!-- Organization Fields -->
        <div id="organization-fields" style="display: none;">
            <!-- Organization Name -->
            <div class="mt-4">
                <x-text-input id="org_name" class="block mt-1 w-full" type="text" name="org_name"
                    :value="old('org_name')" data-required placeholder="Organization Name" />
                <x-input-error :messages="$errors->get('org_name')" class="mt-2" />
            </div>
        </div>

        <!-- Common Fields -->
        <div id="common-fields">
            <!-- Hidden UserID field -->
            <input type="hidden" id="userid" name="userid" value="auto-generate">

            <!-- Email Address -->
            <div class="mt-4">
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    data-required autocomplete="username" placeholder="Email" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                    data-required autocomplete="new-password" placeholder="Password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" data-required autocomplete="new-password"
                    placeholder="Confirm Password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

        </div>
        <!-- Terms and Conditions Acceptance -->
        <div class="mt-4">
            <label class="flex items-center">
                <input type="checkbox" 
                       name="terms_acceptance" 
                       id="terms_acceptance" 
                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                       required>
                <span class="ml-2 text-sm text-gray-600">
                    I accept the 
                    <a href="{{ route('terms') }}" 
                       class="text-blue-600 hover:text-blue-700 underline"
                       target="_blank">
                        Terms and Conditions
                    </a>
                </span>
            </label>
        </div>

        <div class="mt-4">
            <button type="submit"
                class="w-full mb-4 py-3 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">
                {{ __('Register') }}
            </button>
        </div>
    </form>
   
    <p>Already registered?
        <a class="login-link text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            href="{{ route('login') }}">
            <span class="login-text">Login</span>
        </a>
    </p>
<br> <br> <br>
    <script>
        function toggleUserType() {
            const userType = document.getElementById('user_type').value;
            const volunteerFields = document.getElementById('volunteer-fields');
            const organizationFields = document.getElementById('organization-fields');

            if (userType === 'organization') {
                volunteerFields.style.display = 'none';
                organizationFields.style.display = 'block';
                disableFields(volunteerFields);
                enableFields(organizationFields);
            } else {
                volunteerFields.style.display = 'block';
                organizationFields.style.display = 'none';
                enableFields(volunteerFields);
                disableFields(organizationFields);
            }
        }

        function disableFields(container) {
            container.querySelectorAll('input, select, textarea').forEach(el => {
                el.disabled = true;
                el.required = false;
            });
        }

        function enableFields(container) {
            container.querySelectorAll('input, select, textarea').forEach(el => {
                el.disabled = false;
                el.required = el.hasAttribute('data-required');
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            toggleUserType();

            const form = document.querySelector('form');
            const submitButton = form.querySelector('button[type="submit"]');
            const termsCheckbox = document.getElementById('terms_acceptance');

            // Initially disable submit button
            submitButton.disabled = true;
            submitButton.classList.add('opacity-50', 'cursor-not-allowed');

            // Toggle submit button based on checkbox
            termsCheckbox.addEventListener('change', function() {
                submitButton.disabled = !this.checked;
                if (this.checked) {
                    submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
                } else {
                    submitButton.classList.add('opacity-50', 'cursor-not-allowed');
                }
            });

            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent default submission
                
                // Check if terms are accepted
                const termsCheckbox = document.getElementById('terms_acceptance');
                if (!termsCheckbox.checked) {
                    // Create or show error message
                    let errorMsg = document.getElementById('terms-error');
                    if (!errorMsg) {
                        errorMsg = document.createElement('p');
                        errorMsg.id = 'terms-error';
                        errorMsg.className = 'mt-2 text-sm text-red-600';
                        errorMsg.textContent = 'Please accept the Terms and Conditions to continue';
                        termsCheckbox.parentElement.parentElement.appendChild(errorMsg);
                    }
                    errorMsg.style.display = 'block';
                    return;
                }
                
                const userType = document.getElementById('user_type').value;
                const volunteerFields = document.getElementById('volunteer-fields');
                const organizationFields = document.getElementById('organization-fields');

                // Enable all fields in the active section before submission
                if (userType === 'volunteer') {
                    enableFields(volunteerFields);
                    disableFields(organizationFields);
                } else {
                    enableFields(organizationFields);
                    disableFields(volunteerFields);
                }

                // Now submit the form
                this.submit();
            });

            // Add event listener to hide error message when checkbox is checked
            termsCheckbox.addEventListener('change', function() {
                const errorMsg = document.getElementById('terms-error');
                if (errorMsg) {
                    errorMsg.style.display = this.checked ? 'none' : 'block';
                }
            });
        });
    </script>

</x-guest-layout>
