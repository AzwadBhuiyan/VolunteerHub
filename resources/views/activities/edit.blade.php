<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 min-h-screen">
        <div class="p-1 sm:p-8 bg-white">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-800 via-gray-900 to-black px-6 py-4 rounded-t-lg shadow-lg">
                        <h2 class="font-semibold text-2xl bg-gradient-to-r from-green-400 to-blue-500 text-transparent bg-clip-text tracking-wide animate-gradient">
                            {{ __('Edit Volunteer Project') }}
                        </h2>
                    </div>
                    <style>
                        @keyframes gradient {
                            0% { background-position: 0% 50%; }
                            100% { background-position: 100% 50%; }
                        }
                        .animate-gradient {
                            background-size: 200% 200%;
                            animation: gradient 3s linear infinite;
                        }
                    </style>

                    <div class="p-3">
                        <form method="POST" action="{{ route('activities.update', $activity) }}" class="space-y-4" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-6">
                                <div class="flex items-center justify-center w-full">
                                    <div class="relative w-full h-68 bg-gray-100 rounded-lg overflow-hidden">
                                        @php
                                            $imageSrc = $activity->image 
                                                ? (Str::startsWith($activity->image, ['http://', 'https://']) 
                                                    ? $activity->image 
                                                    : (Str::startsWith($activity->image, 'public/') 
                                                        ? Storage::url(Str::replaceFirst('public/', '', $activity->image))
                                                        : Storage::url($activity->image)))
                                                : asset('images/defaults/default-activity.jpg');
                                        @endphp
                                        <img id="imagePreview" 
                                            src="{{ $imageSrc }}" 
                                            alt="{{ $activity->title }}"
                                            class="w-full h-full object-cover">
                                        <label for="image" class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white p-2 text-center cursor-pointer hover:bg-opacity-60 transition" 
                                            style="height: 15%; width: 100%; bottom: 0; display: flex; align-items: center; justify-content: center;">
                                            <span class="text-sm font-medium">{{ __('Change Project Photo') }}</span>
                                            <input id="image" name="image" type="file" class="hidden" accept="image/*" onchange="previewImage(this, 'imagePreview')" />
                                        </label>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">Maximum file size: 5MB</p>
                                <x-input-error class="mt-1" :messages="$errors->get('image')" />
                            </div>

                            <div class="space-y-6">
                                <!-- Title -->
                                <div>
                                    <x-input-label for="title" value="Title" />
                                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $activity->title)" required />
                                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                                </div>

                                <!-- Description -->
                                <div>
                                    <x-input-label for="description" value="Description" />
                                    <textarea id="description" name="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('description', $activity->description) }}</textarea>
                                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                </div>

                                <!-- Date and Time -->
                                <div class="grid grid-cols-2 gap-6">
                                    <div>
                                        <div class="relative">
                                            <input type="text" id="date" name="date" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="{{ old('date', $activity->date->format('M d, Y')) }}" required placeholder="Select Date" />
                                        </div>
                                        <x-input-error :messages="$errors->get('date')" class="mt-2" />
                                    </div>

                                    <div>
                                        <div class="relative">
                                            <input type="text" id="time" name="time" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="{{ old('time', $activity->time->format('h:i A')) }}" required placeholder="Select Time" />
                                        </div>
                                        <x-input-error :messages="$errors->get('time')" class="mt-2" />
                                    </div>
                                </div>

                                <!-- Category and District -->
                                <div class="grid grid-cols-2 gap-6">
                                    <div>
                                        <x-input-label for="category" value="Category" />
                                        <select id="category" name="category" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                            <option value="">Select category</option>
                                            @foreach($categories->sortBy('name') as $category)
                                                <option value="{{ $category->name }}" {{ old('category', $activity->category) == $category->name ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('category')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="district" value="District" />
                                        <select id="district" name="district" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                            <option value="">Select District</option>
                                            @foreach(collect(config('districts.districts'))->sort() as $district)
                                                <option value="{{ $district }}" {{ old('district', $activity->district) === $district ? 'selected' : '' }}>
                                                    {{ $district }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('district')" class="mt-2" />
                                    </div>
                                </div>

                                <!-- Difficulty -->
                                <div>
                                    <x-input-label for="difficulty" value="Difficulty" />
                                    <select id="difficulty" name="difficulty" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                        <option value="">Select difficulty level</option>
                                        <option value="easy" {{ old('difficulty', $activity->difficulty) === 'easy' ? 'selected' : '' }}>Easy</option>
                                        <option value="medium" {{ old('difficulty', $activity->difficulty) === 'medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="hard" {{ old('difficulty', $activity->difficulty) === 'hard' ? 'selected' : '' }}>Hard</option>
                                        <option value="severe" {{ old('difficulty', $activity->difficulty) === 'severe' ? 'selected' : '' }}>Severe</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('difficulty')" class="mt-2" />
                                </div>

                                <!-- Address -->
                                <div>
                                    <x-input-label for="address" value="Address" />
                                    <textarea id="address" name="address" class="block w-full h-20 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required placeholder="Project Address">{{ old('address', $activity->address) }}</textarea>
                                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                                </div>

                                <!-- Google Maps Link -->
                                <div>
                                    <x-input-label for="google_maps_link" value="Google Maps Link" />
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-map-marker-alt text-gray-400"></i>
                                        </div>
                                        <x-text-input id="google_maps_link" class="block w-full pl-10" type="text" name="google_maps_link" :value="old('google_maps_link', $activity->google_maps_link)" placeholder="Google maps direction link (optional)" />
                                    </div>
                                    <x-input-error :messages="$errors->get('google_maps_link')" class="mt-2" />
                                </div>

                                <!-- Volunteers -->
                                <div class="grid grid-cols-2 gap-6">
                                    <div>
                                        <x-input-label for="min_volunteers" value="Minimum Volunteers" />
                                        <x-text-input id="min_volunteers" class="block w-full" type="number" name="min_volunteers" :value="old('min_volunteers', $activity->min_volunteers)" required min="1" placeholder="Minimum Volunteers" />
                                        <x-input-error :messages="$errors->get('min_volunteers')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="max_volunteers" value="Maximum Volunteers" />
                                        <x-text-input id="max_volunteers" class="block w-full" type="number" name="max_volunteers" :value="old('max_volunteers', $activity->max_volunteers)" min="1" placeholder="Maximum Volunteers (Optional)" />
                                        <x-input-error :messages="$errors->get('max_volunteers')" class="mt-2" />
                                    </div>
                                </div>

                                <!-- Deadline -->
                                <div class="w-full mb-6">
                                    <x-input-label for="deadline" value="Registration Deadline" />
                                    <div class="relative w-full">
                                        <input type="text" id="deadline" name="deadline" class="w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="{{ old('deadline', $activity->deadline->format('M d, Y h:i A')) }}" required readonly placeholder="Select Registration Deadline" />
                                    </div>
                                    <x-input-error :messages="$errors->get('deadline')" class="mt-2" />
                                </div>

                                <!-- Profession -->
                                <div class="w-full">
                                    <x-input-label for="required_profession" value="Required Profession" />
                                    <select id="required_profession" name="required_profession" class="block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <option value="">Profession (optional)</option>
                                        @php
                                            $professions = [
                                                'Accountant', 'Architect', 'Carpenter', 'Chef', 'Doctor', 'Electrician',
                                                'Engineer', 'IT Professional', 'Lawyer', 'Nurse', 'Plumber', 'Psychologist',
                                                'Social Worker', 'Student', 'Teacher'
                                            ];
                                        @endphp
                                        @foreach($professions as $profession)
                                            <option value="{{ $profession }}" {{ old('required_profession', $activity->required_profession) === $profession ? 'selected' : '' }}>
                                                {{ $profession }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('required_profession')" class="mt-2" />
                                </div>

                                <div class="mt-6">
                                    <x-primary-button class="w-full bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white font-semibold py-3 px-4 rounded-lg shadow-lg transition duration-150 ease-in-out transform hover:scale-105">
                                        {{ __('Update Activity') }}
                                    </x-primary-button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#date", {
            enableTime: false,
            dateFormat: "M d, Y",
            defaultDate: "{{ $activity->date->format('Y-m-d') }}",
            onChange: function(selectedDates, dateStr, instance) {
                document.getElementById('date').value = dateStr;
            },
            theme: "material_blue",
            disableMobile: true,
            clickOpens: true
        });

        flatpickr("#time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "h:i K",
            defaultDate: "{{ $activity->time->format('H:i') }}",
            time_24hr: false,
            onChange: function(selectedDates, timeStr, instance) {
                document.getElementById('time').value = timeStr;
            },
            theme: "material_blue",
            disableMobile: true,
            clickOpens: true
        });

        flatpickr("#deadline", {
            enableTime: true,
            dateFormat: "M d, Y h:i K",
            defaultDate: "{{ $activity->deadline->format('Y-m-d H:i') }}",
            onChange: function(selectedDates, dateStr, instance) {
                document.getElementById('deadline').value = dateStr;
            },
            theme: "material_blue",
            disableMobile: true,
            clickOpens: true
        });

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