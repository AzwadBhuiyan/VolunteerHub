<x-guest-layout>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet"> 
    <h2> Create your account</h2>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- User Type -->
        <div>
            <x-input-label for="user_type" :value="__('User Type')" />
            <select id="user_type" name="user_type" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required onchange="toggleUserType()">
                <option value="volunteer">Volunteer</option>
                <option value="organization">Organization</option>
            </select>
            <x-input-error :messages="$errors->get('user_type')" class="mt-2" />
        </div>

        <!-- volunteer fields -->
        <div id="volunteer-fields">
            <!-- Name -->
            <div class="mt-4">
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Full Name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- UserID -->
            <div class="mt-4">
                <x-text-input id="userid" class="block mt-1 w-full" type="text" name="userid" :value="old('userid')" required autocomplete="username" placeholder="UserID" />
                <x-input-error :messages="$errors->get('userid')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Email" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Phone -->
            <div class="mt-4">
                <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone')" required placeholder="Phone" />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>

            <!-- NID -->
            <div class="mt-4">
                <x-text-input id="nid" class="block mt-1 w-full" type="text" name="nid" :value="old('nid')" placeholder="NID (optional)" />
                <x-input-error :messages="$errors->get('nid')" class="mt-2" />
            </div>

            <!-- Gender -->
            <div class="mt-4">
                <x-input-label for="gender" :value="__('Gender')" />
                <select id="gender" name="gender" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    <option value="M">Male</option>
                    <option value="F">Female</option>
                    <option value="O">Other</option>
                </select>
                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
            </div>

            <!-- Date of Birth -->
            <div class="mt-4">
                <x-text-input id="dob" class="block mt-1 w-full" type="date" name="dob" :value="old('dob')" required placeholder="Date of Birth" />
                <x-input-error :messages="$errors->get('dob')" class="mt-2" />
            </div>

            <!-- Blood Group -->
            <div class="mt-4">
                <x-input-label for="blood_group" :value="__('Blood Group')" />
                <select id="blood_group" name="blood_group" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                </select>
                <x-input-error :messages="$errors->get('blood_group')" class="mt-2" />
            </div>

            <!-- Present Address -->
            <div class="mt-4">
                <textarea id="present_address" name="present_address" rows="3" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required placeholder="Present Address">{{ old('present_address') }}</textarea>
                <x-input-error :messages="$errors->get('present_address')" class="mt-2" />
            </div>

            <!-- Permanent Address -->
            <div class="mt-4">
                <textarea id="permanent_address" name="permanent_address" rows="3" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required placeholder="Permanent Address">{{ old('permanent_address') }}</textarea>
                <x-input-error :messages="$errors->get('permanent_address')" class="mt-2" />
            </div>

            <!-- District -->
            <div class="mt-4">
                <x-input-label for="district" :value="__('District')" />
                <select id="district" name="district" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    @foreach(['Dhaka', 'Chittagong', 'Rajshahi', 'Khulna', 'Barisal', 'Sylhet', 'Rangpur', 'Mymensingh', 'Comilla', 'Narayanganj', 'Gazipur'] as $district)
                        <option value="{{ $district }}">{{ $district }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('district')" class="mt-2" />
            </div>
            &nbsp;
            <p>Note: Your password must be atleast 8 characters long</p>
            <!-- Password -->
            <div class="mt-4">
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" placeholder="Password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Trained in Emergency Response -->
            <div class="mt-4">
                <label for="trained_in_emergency_response" class="inline-flex items-center">
                    <input id="trained_in_emergency_response" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="trained_in_emergency_response" value="1">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Trained in Emergency Response') }}</span>
                </label>
            </div>
        </div>

        <!-- organization fields -->
        <div id="organization-fields" style="display: none;">
            <div class="mt-4">
                <x-text-input id="org_name" class="block mt-1 w-full" type="text" name="org_name" :value="old('org_name')" required placeholder="Organization Name" />
                <x-input-error :messages="$errors->get('org_name')" class="mt-2" />
            </div>

            <!-- UserID -->
            <div class="mt-4">
                <x-text-input id="org_userid" class="block mt-1 w-full" type="text" name="org_userid" :value="old('org_userid')" required autocomplete="username" placeholder="Organization UserID" />
                <x-input-error :messages="$errors->get('org_userid')" class="mt-2" />
            </div>
            
            
            <!-- Password -->
            <div class="mt-4">
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" placeholder="Password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            
            <!-- Confirm Password -->
            <div class="mt-4">
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
            &nbsp;
            <p>Note: Your password must be atleast 8 characters long</p>

            <!-- Primary Address -->
            <div class="mt-4">
                <textarea id="primary_address" name="primary_address" rows="3" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required placeholder="Primary Address">{{ old('primary_address') }}</textarea>
                <x-input-error :messages="$errors->get('primary_address')" class="mt-2" />
            </div>

            <!-- Secondary Address -->
            <div class="mt-4">
                <textarea id="secondary_address" name="secondary_address" rows="3" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required placeholder="Secondary Address">{{ old('secondary_address') }}</textarea>
                <x-input-error :messages="$errors->get('secondary_address')" class="mt-2" />
            </div> 

            <!-- Website -->
            <div class="mt-4">
                <x-text-input id="website" class="block mt-1 w-full" type="url" name="website" :value="old('website')" required placeholder="Website" />
                <x-input-error :messages="$errors->get('website')" class="mt-2" />
            </div>

            <!-- Organization mobile -->
            <div class="mt-4">
                <x-text-input id="org_mobile" class="block mt-1 w-full" type="tel" name="org_mobile" :value="old('org_mobile')" required placeholder="Organization mobile +880" />
                <x-input-error :messages="$errors->get('org_mobile')" class="mt-2" />
            </div>
            <!-- Organization Telephone -->
            <div class="mt-4">
                <x-text-input id="org_telephone" class="block mt-1 w-full" type="tel" name="org_telephone" :value="old('org_telephone')" required placeholder="Organization telephone" />
                <x-input-error :messages="$errors->get('org_telephone')" class="mt-2" />
            </div>
        </div>

        <!-- <input type="hidden" name="user_type" value="volunteer"> -->

        

            <div class="mt-4">
                <button type="submit" class="w-full py-3 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">
                    {{ __('Register') }}
                </button>
            </div>
    </form>
&nbsp;
    <p>Already registered?

    <a class="login-link text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
        <span class="login-text">Login</span>
    </a>
</p>
    <script>
        function toggleUserType() {
            const userType = document.getElementById('user_type').value;
            const volunteerFields = document.getElementById('volunteer-fields');
            const organizationFields = document.getElementById('organization-fields');

            if (userType === 'organization') {
                volunteerFields.style.display = 'none';
                organizationFields.style.display = 'block';
            } else {
                volunteerFields.style.display = 'block';
                organizationFields.style.display = 'none';
            }
        }
    </script>

</x-guest-layout>
