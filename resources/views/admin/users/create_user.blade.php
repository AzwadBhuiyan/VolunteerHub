<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-6 bg-gradient-to-r from-blue-600 via-green-500 to-blue-500 inline-block text-transparent bg-clip-text">
                        Create New User
                    </h2>

                    <form method="POST" action="{{ route('admin.users.store') }}">
                        @csrf

                        <!-- User Type Selection -->
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
                            <input type="hidden" id="userid" name="userid" value="auto-generate">

                            <div class="mt-4">
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                                    data-required placeholder="Email" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                                    data-required placeholder="Password" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Account Status -->
                            <div class="mt-4 flex items-center">
                                <label for="verified" class="mr-2 whitespace-nowrap">Account Status:</label>
                                <select id="verified" name="verified" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
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
                        </div>

                        <div class="mt-6 flex items-center justify-end gap-4">
                            <a href="{{ route('admin.users.index') }}" 
                               class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors">
                                Create User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
                event.preventDefault(); // Prevent default submission
                
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
        });
    </script>
</x-app-layout>