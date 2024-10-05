<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Activity') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('activities.store') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
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
                                <option value="environmental">Environmental</option>
                                <option value="social">Social</option>
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
                            <x-input-label for="image" :value="__('Activity Image')" />
                            <div class="flex items-center space-x-4">                            
                                <div class="flex items-center">
                                    <img id="imagePreview" src="{{ asset('images/defaults/default-activity.jpg') }}" class="w-32 h-16 object-cover mr-2 hidden">
                                    <input id="image" name="image" type="file" class="mt-1 block" accept="image/*" onchange="previewImage(this, 'imagePreview')" />
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('image')" />
                            </div>
                            <p class="text-sm text-gray-600 mt-1">Maximum file size: 5MB</p>
                        </div>
                        

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
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