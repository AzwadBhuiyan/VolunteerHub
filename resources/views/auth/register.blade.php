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

         

            <!-- Volunteer Fields -->
            <div id="volunteer-fields" style="display: none;">
                <!-- Name -->
                <div class="mt-4">
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                        :value="old('name')" data-required autofocus autocomplete="name" placeholder="Full Name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Phone -->
                <div class="mt-4">
                    <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone"
                        :value="old('phone')" data-required placeholder="Phone" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                      <!-- Gender -->
                      <div class="mt-4 flex items-center">
                        <label for="gender" class="mr-2 whitespace-nowrap">Gender:</label>
                        <select id="gender" name="gender" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" data-required>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                            <option value="O">Other</option>
                        </select>
                        <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                    </div>
    
                    <!-- Date of Birth -->
                    <div class="mt-4 flex items-center">
                        <label for="dob" class="mr-2 whitespace-nowrap" style="min-width: 100px;">Date of Birth:</label>
                        <x-text-input id="dob" class="block w-full" type="date" name="dob"
                            :value="old('dob')" data-required placeholder="Date of Birth" />
                        <x-input-error :messages="$errors->get('dob')" class="mt-2" />
                    </div>
    
                

                    <!-- Present Address -->
                    <div class="mt-4">
                        <textarea id="present_address" name="present_address" rows="3"
                            class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            data-required placeholder="Present Address">{{ old('present_address') }}</textarea>
                        <x-input-error :messages="$errors->get('present_address')" class="mt-2" />
                    </div>
    
                    <!-- District -->
                    @php
                        $districts = config('districts.districts');
                    @endphp
                    <div class="mt-4 flex items-center">
                        <label for="district" class="mr-2 whitespace-nowrap">District:</label>
                        <select id="district" name="district" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" data-required>
                            @foreach ($districts as $district)
                                <option value="{{ $district }}">{{ $district }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('district')" class="mt-2" />
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
        </div>

        <!-- Organization Fields -->
        <div id="organization-fields" style="display: none;">
            <!-- Organization Name -->
            <div class="mt-4">
                <x-text-input id="org_name" class="block mt-1 w-full" type="text" name="org_name"
                    :value="old('org_name')" data-required placeholder="Organization Name" />
                <x-input-error :messages="$errors->get('org_name')" class="mt-2" />
            </div>
            <!-- Description -->
            <div class="mt-4">
                <textarea id="description" name="description" rows="3"
                    class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    placeholder="Organization Description (optional)">{{ old('description') }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <!-- Primary Address -->
            <div class="mt-4">
                <textarea id="primary_address" name="primary_address" rows="3"
                    class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    data-required placeholder="Primary Address">{{ old('primary_address') }}</textarea>
                <x-input-error :messages="$errors->get('primary_address')" class="mt-2" />
            </div>

            <!-- Secondary Address -->
            <div class="mt-4">
                <textarea id="secondary_address" name="secondary_address" rows="3"
                    class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    data-required placeholder="Secondary Address">{{ old('secondary_address') }}</textarea>
                <x-input-error :messages="$errors->get('secondary_address')" class="mt-2" />
            </div>

            <!-- Website -->
            <div class="mt-4">
                <x-text-input id="website" class="block mt-1 w-full" type="url" name="website"
                    :value="old('website')" data-required placeholder="Website" />
                <x-input-error :messages="$errors->get('website')" class="mt-2" />
            </div>

            <!-- Organization mobile -->
            <div class="mt-4">
                <x-text-input id="org_mobile" class="block mt-1 w-full" type="tel" name="org_mobile"
                    :value="old('org_mobile')" data-required placeholder="Organization mobile +880" />
                <x-input-error :messages="$errors->get('org_mobile')" class="mt-2" />
            </div>
            <!-- Organization Telephone -->
            <div class="mt-4">
                <x-text-input id="org_telephone" class="block mt-1 w-full" type="tel" name="org_telephone"
                    :value="old('org_telephone')" data-required placeholder="Organization telephone" />
                <x-input-error :messages="$errors->get('org_telephone')" class="mt-2" />
            </div>
            <!-- Password -->
            <div class="mt-4">
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" 
                    data-required placeholder="Password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" 
                    name="password_confirmation" data-required placeholder="Confirm Password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
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
            form.addEventListener('submit', function(event) {
                const userType = document.getElementById('user_type').value;
                const volunteerFields = document.getElementById('volunteer-fields');
                const organizationFields = document.getElementById('organization-fields');

                if (userType === 'volunteer') {
                    disableFields(organizationFields);
                } else {
                    disableFields(volunteerFields);
                }
            });
        });
    </script>

</x-guest-layout>
