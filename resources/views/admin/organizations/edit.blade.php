<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold bg-gradient-to-r from-blue-600 via-green-500 to-blue-500 inline-block text-transparent bg-clip-text">
                            Edit Organization: {{ $organization->org_name }}
                        </h2>
                        <a href="{{ route('admin.organizations.index') }}" class="text-blue-500 hover:underline">
                            ← Back to List
                        </a>
                    </div>

                    <form action="{{ route('admin.organizations.update', $organization) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="org_name" :value="__('Organization Name')" />
                                <x-text-input id="org_name" name="org_name" type="text" class="mt-1 block w-full" :value="old('org_name', $organization->org_name)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('org_name')" />
                            </div>

                            <div>
                                <x-input-label for="primary_address" :value="__('Primary Address')" />
                                <x-text-input id="primary_address" name="primary_address" type="text" class="mt-1 block w-full" :value="old('primary_address', $organization->primary_address)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('primary_address')" />
                            </div>

                            <div>
                                <x-input-label for="secondary_address" :value="__('Secondary Address')" />
                                <x-text-input id="secondary_address" name="secondary_address" type="text" class="mt-1 block w-full" :value="old('secondary_address', $organization->secondary_address)" />
                                <x-input-error class="mt-2" :messages="$errors->get('secondary_address')" />
                            </div>

                            <div>
                                <x-input-label for="website" :value="__('Website')" />
                                <x-text-input id="website" name="website" type="url" class="mt-1 block w-full" :value="old('website', $organization->website)" />
                                <x-input-error class="mt-2" :messages="$errors->get('website')" />
                            </div>

                            <div>
                                <x-input-label for="org_mobile" :value="__('Mobile Number')" />
                                <x-text-input id="org_mobile" name="org_mobile" type="tel" class="mt-1 block w-full" :value="old('org_mobile', $organization->org_mobile)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('org_mobile')" />
                            </div>

                            <div>
                                <x-input-label for="org_telephone" :value="__('Telephone Number')" />
                                <x-text-input id="org_telephone" name="org_telephone" type="tel" class="mt-1 block w-full" :value="old('org_telephone', $organization->org_telephone)" />
                                <x-input-error class="mt-2" :messages="$errors->get('org_telephone')" />
                            </div>

                            <div>
                                <x-input-label for="description" :value="__('Description')" />
                                <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" rows="3" required>{{ old('description', $organization->description) }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('description')" />
                            </div>

                            <div>
                                <x-input-label for="url" :value="__('Profile URL')" />
                                <x-text-input id="url" name="url" type="text" class="mt-1 block w-full" :value="old('url', $organization->url)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('url')" />
                            </div>
                        </div>

                        <div class="flex justify-end mt-6">
                            <x-primary-button>{{ __('Update Organization') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>