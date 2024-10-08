<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Activity') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('activities.update', $activity) }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $activity->title)" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" rows="4" required>{{ old('description', $activity->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="date" :value="__('Date')" />
                            <x-text-input id="date" class="block mt-1 w-full" type="date" name="date" :value="old('date', $activity->date->format('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('date')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="time" :value="__('Time')" />
                            <x-text-input id="time" class="block mt-1 w-full" type="time" name="time" :value="old('time', $activity->time->format('H:i'))" required />
                            <x-input-error :messages="$errors->get('time')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="category" :value="__('Category')" />
                            <select id="category" name="category" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->name }}" {{ old('category', $activity->category) == $category->name ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="district" :value="__('District')" />
                            <select id="district" name="district" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                <option value="western" {{ old('district', $activity->district) === 'western' ? 'selected' : '' }}>Western</option>
                                <option value="central" {{ old('district', $activity->district) === 'central' ? 'selected' : '' }}>Central</option>
                                <option value="eastern" {{ old('district', $activity->district) === 'eastern' ? 'selected' : '' }}>Eastern</option>
                            </select>
                            <x-input-error :messages="$errors->get('district')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="difficulty" :value="__('Difficulty')" />
                            <select id="difficulty" name="difficulty" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                <option value="easy" {{ old('difficulty', $activity->difficulty) === 'easy' ? 'selected' : '' }}>Easy</option>
                                <option value="medium" {{ old('difficulty', $activity->difficulty) === 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="hard" {{ old('difficulty', $activity->difficulty) === 'hard' ? 'selected' : '' }}>Hard</option>
                                <option value="severe" {{ old('difficulty', $activity->difficulty) === 'sever' ? 'selected' : '' }}>Severe</option>
                            </select>
                            <x-input-error :messages="$errors->get('difficulty')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="address" :value="__('Address')" />
                            <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address', $activity->address)" required />
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="deadline" :value="__('Registration Deadline')" />
                            <x-text-input id="deadline" class="block mt-1 w-full" type="datetime-local" name="deadline" :value="old('deadline', $activity->deadline->format('Y-m-d\TH:i'))" required />
                            <x-input-error :messages="$errors->get('deadline')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="min_volunteers" :value="__('Minimum Volunteers')" />
                            <x-text-input id="min_volunteers" class="block mt-1 w-full" type="number" name="min_volunteers" :value="old('min_volunteers', $activity->min_volunteers)" required min="1" />
                            <x-input-error :messages="$errors->get('min_volunteers')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="max_volunteers" :value="__('Maximum Volunteers (optional)')" />
                            <x-text-input id="max_volunteers" class="block mt-1 w-full" type="number" name="max_volunteers" :value="old('max_volunteers', $activity->max_volunteers)" min="1" />
                            <x-input-error :messages="$errors->get('max_volunteers')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="image" :value="__('Activity Image')" />
                            <div class="flex items-center space-x-4">                            
                                <div class="flex items-center">
                                    <img id="imagePreview" src="{{ asset('images/activities/' . $activity->activityid . '/' . $activity->activityid . '.*') }}" class="w-32 h-16 object-cover mr-2">
                                    <input id="image" name="image" type="file" class="mt-1 block" accept="image/*" onchange="previewImage(this, 'imagePreview')" />
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('image')" />
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 mt-1">Maximum file size: 5MB</p>

                        <!-- <div class="mb-4">
                            <x-input-label for="status" :value="__('Status')" />
                            <select id="status" name="status" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                @foreach(App\Models\Activity::STATUSES as $status)
                                    <option value="{{ $status }}" {{ old('status', $activity->status) === $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div> -->

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Update Activity') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- TODO: move this to single js file -->
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
            }
        }
    </script>
</x-app-layout>