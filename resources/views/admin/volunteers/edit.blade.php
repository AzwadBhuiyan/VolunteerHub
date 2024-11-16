<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold bg-gradient-to-r from-blue-600 via-green-500 to-blue-500 inline-block text-transparent bg-clip-text">
                            Edit Volunteer: {{ $volunteer->Name }}
                        </h2>
                        <a href="{{ route('admin.volunteers.index') }}" class="text-blue-500 hover:underline">
                            ← Back to List
                        </a>
                    </div>

                    <form action="{{ route('admin.volunteers.update', $volunteer) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="Name" :value="__('Name')" />
                                <x-text-input id="Name" name="Name" type="text" class="mt-1 block w-full" :value="old('Name', $volunteer->Name)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('Name')" />
                            </div>

                            <div>
                                <x-input-label for="Phone" :value="__('Phone')" />
                                <x-text-input id="Phone" name="Phone" type="text" class="mt-1 block w-full" :value="old('Phone', $volunteer->Phone)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('Phone')" />
                            </div>

                            <div>
                                <x-input-label for="NID" :value="__('NID')" />
                                <x-text-input id="NID" name="NID" type="text" class="mt-1 block w-full" :value="old('NID', $volunteer->NID)" />
                                <x-input-error class="mt-2" :messages="$errors->get('NID')" />
                            </div>

                            <div>
                                <x-input-label for="Gender" :value="__('Gender')" />
                                <select id="Gender" name="Gender" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="Male" {{ $volunteer->Gender === 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ $volunteer->Gender === 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ $volunteer->Gender === 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('Gender')" />
                            </div>

                            <div>
                                <x-input-label for="DOB" :value="__('Date of Birth')" />
                                <x-text-input id="DOB" name="DOB" type="date" class="mt-1 block w-full" :value="old('DOB', $volunteer->DOB->format('Y-m-d'))" required />
                                <x-input-error class="mt-2" :messages="$errors->get('DOB')" />
                            </div>

                            <div>
                                <x-input-label for="BloodGroup" :value="__('Blood Group')" />
                                <select id="BloodGroup" name="BloodGroup" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $group)
                                        <option value="{{ $group }}" {{ $volunteer->BloodGroup === $group ? 'selected' : '' }}>{{ $group }}</option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('BloodGroup')" />
                            </div>

                            <div>
                                <x-input-label for="PresentAddress" :value="__('Present Address')" />
                                <x-text-input id="PresentAddress" name="PresentAddress" type="text" class="mt-1 block w-full" :value="old('PresentAddress', $volunteer->PresentAddress)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('PresentAddress')" />
                            </div>

                            <div>
                                <x-input-label for="PermanentAddress" :value="__('Permanent Address')" />
                                <x-text-input id="PermanentAddress" name="PermanentAddress" type="text" class="mt-1 block w-full" :value="old('PermanentAddress', $volunteer->PermanentAddress)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('PermanentAddress')" />
                            </div>

                            <div>
                                <x-input-label for="District" :value="__('District')" />
                                <x-text-input id="District" name="District" type="text" class="mt-1 block w-full" :value="old('District', $volunteer->District)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('District')" />
                            </div>

                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="TrainedInEmergencyResponse" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ $volunteer->TrainedInEmergencyResponse ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-600">Trained in Emergency Response</span>
                                </label>
                            </div>

                            <div>
                                <x-input-label for="profession" :value="__('Profession')" />
                                <x-text-input id="profession" name="profession" type="text" class="mt-1 block w-full" :value="old('profession', $volunteer->profession)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('profession')" />
                            </div>

                            <div>
                                <x-input-label for="bio" :value="__('Bio')" />
                                <textarea id="bio" name="bio" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" rows="3">{{ old('bio', $volunteer->bio) }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('bio')" />
                            </div>

                            <div>
                                <x-input-label for="url" :value="__('Profile URL')" />
                                <x-text-input id="url" name="url" type="text" class="mt-1 block w-full" :value="old('url', $volunteer->url)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('url')" />
                            </div>
                        </div>

                        <div class="flex justify-end mt-6">
                            <x-primary-button>{{ __('Update Volunteer') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>