<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 py-8">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                    <h2 class="font-semibold text-xl text-white">
                        {{ __('Create Activity') }}
                    </h2>
                </div>

                <div class="p-6">
                    <form method="POST" action="{{ route('activities.store') }}" class="space-y-4" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-6">
                            <div class="flex items-center justify-center w-full">
                                <div class="relative w-full h-48 bg-gray-100 rounded-lg overflow-hidden">
                                    <img id="imagePreview" src="{{ asset('images/defaults/default-activity.jpg') }}" 
                                         class="w-full h-full object-cover">
                                    <label for="image" class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white p-2 text-center cursor-pointer hover:bg-opacity-60 transition">
                                        <span class="text-sm font-medium">{{ __('Change Project Photo') }}</span>
                                        <input id="image" name="image" type="file" class="hidden" accept="image/*" onchange="previewImage(this, 'imagePreview')" />
                                    </label>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Maximum file size: 5MB</p>
                            <x-input-error class="mt-1" :messages="$errors->get('image')" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-2">
                                <x-text-input 
                                    id="title" 
                                    class="block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 transition" 
                                    type="text" 
                                    name="title" 
                                    :value="old('title')" 
                                    placeholder="Enter Project Title"
                                    required 
                                    autofocus 
                                />
                            </div>

                            <div class="mb-4">
                                <x-input-label for="description" :value="__('Description')" />
                                <textarea id="description" name="description" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" rows="4" required>{{ old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <x-input-label for="date" :value="__('Date')" />
                                <x-text-input id="date" class="block mt-1 w-full" type="date" name="date" :value="old('date')" required />
                                <x-input-error :messages="$errors->get('date')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <x-input-label for="time" :value="__('Time')" />
                                <x-text-input id="time" class="block mt-1 w-full" type="time" name="time" :value="old('time')" required />
                                <x-input-error :messages="$errors->get('time')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <x-input-label for="category" :value="__('Category')" />
                                <select id="category" name="category" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option value="">Select a category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->name }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('category')" class="mt-2" />
                            </div>


                        @php
                            $districts = config('districts.districts');
                        @endphp

                        <div>
                            <x-input-label for="district" :value="__('District')" />
                            <select id="district" name="district" class="mt-1 block w-full" required>
                                @foreach($districts as $district)
                                    <option value="{{ $district }}">{{ $district }}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('district')" />
                        </div>

                            <div class="mb-4">
                                <x-input-label for="difficulty" :value="__('Difficulty')" />
                                <select id="difficulty" name="difficulty" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option value="">Select difficulty level</option>
                                    <option value="easy">Easy</option>
                                    <option value="medium">Medium</option>
                                    <option value="hard">Hard</option>
                                    <option value="severe">Severe</option>
                                </select>
                                <x-input-error :messages="$errors->get('difficulty')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <x-input-label for="address" :value="__('Address')" />
                                <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required />
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <x-input-label for="deadline" :value="__('Registration Deadline')" />
                                <x-text-input id="deadline" class="block mt-1 w-full" type="datetime-local" name="deadline" :value="old('deadline')" required />
                                <x-input-error :messages="$errors->get('deadline')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <x-input-label for="min_volunteers" :value="__('Minimum Volunteers')" />
                                <x-text-input id="min_volunteers" class="block mt-1 w-full" type="number" name="min_volunteers" :value="old('min_volunteers')" required min="1" />
                                <x-input-error :messages="$errors->get('min_volunteers')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <x-input-label for="max_volunteers" :value="__('Maximum Volunteers (optional)')" />
                                <x-text-input id="max_volunteers" class="block mt-1 w-full" type="number" name="max_volunteers" :value="old('max_volunteers')" min="1" />
                                <x-input-error :messages="$errors->get('max_volunteers')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <x-input-label for="required_profession" :value="__('Required Profession (optional)')" />
                                <x-text-input id="required_profession" name="required_profession" type="text" class="block mt-1 w-full" :value="old('required_profession')" placeholder="e.g., Doctor, Engineer, Teacher" />
                                <x-input-error :messages="$errors->get('required_profession')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-6 bg-blue-50 rounded-lg p-4">
                            <p class="text-sm text-blue-600">
                                <i class="fas fa-info-circle mr-2"></i>
                                Activity will automatically change status to "closed" when date or deadline is reached
                            </p>
                        </div>

                        <div class="mt-6">
                            <x-primary-button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-150 ease-in-out">
                                {{ __('Create Activity') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input, previewId) {
            var preview = document.getElementById(previewId);
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.src = "{{ asset('images/defaults/default-activity.jpg') }}";
                preview.classList.add('hidden');
            }
        }
    </script>

</x-app-layout>