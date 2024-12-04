<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 min-h-screen">
        <div class="p-1 sm:p-8 bg-white">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-800 via-gray-900 to-black px-6 py-4 rounded-t-lg shadow-lg">
                        <h2 class="font-semibold text-2xl bg-gradient-to-r from-green-400 to-blue-500 text-transparent bg-clip-text tracking-wide animate-gradient">
                            {{ __('Complete Activity') }}: {{ $activity->title }}
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
                        <form method="POST" action="{{ route('activities.complete.store', $activity) }}" class="space-y-4" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="space-y-6">
                                <!-- Accomplished Description -->
                                <div>
                                    <textarea id="accomplished_description" name="accomplished_description" rows="4" 
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                        required placeholder="{{ __('Describe what you did, felt, and learned from this activity') }}">{{ old('accomplished_description') }}</textarea>
                                    <x-input-error :messages="$errors->get('accomplished_description')" class="mt-2" />
                                </div>

                                <!-- Duration -->
                                <div>
                                    <x-text-input id="duration" class="block mt-1 w-full" type="number" name="duration" 
                                        :value="old('duration')" step="0.5" min="0.5" required placeholder="{{ __('Duration (in hours)') }}" />
                                    <x-input-error :messages="$errors->get('duration')" class="mt-2" />
                                    <p class="text-xs text-gray-500 mt-2">Enter duration in hours (Minimum 1 hour)</p>
                                </div>

                                <!-- Photos -->
                                <div>
                                    <x-input-label for="photos" :value="__('Photos (1-5)')" />
                                    <input id="photos" name="photos[]" type="file" 
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" 
                                        accept="image/*" multiple required onchange="handlePhotoPreview(this)" />
                                    <x-input-error :messages="$errors->get('photos')" class="mt-2" />
                                    <p class="text-xs text-gray-500 mt-2">You can upload 1-5 photos. Maximum file size: 5MB each.</p>
                                    
                                    <!-- Photo Preview Grid -->
                                    <div id="photoPreviewGrid" class="mt-4 w-full h-64 hidden">
                                        <!-- Preview images will be inserted here -->
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6">
                                <x-primary-button class="w-full bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white font-semibold py-3 px-4 rounded-lg shadow-lg transition duration-150 ease-in-out transform hover:scale-105">
                                    {{ __('Complete Activity') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function handlePhotoPreview(input) {
            const previewGrid = document.getElementById('photoPreviewGrid');
            previewGrid.innerHTML = ''; // Clear existing previews
            
            if (input.files.length > 0) {
                previewGrid.classList.remove('hidden');
                
                if (input.files.length === 1) {
                    // Single image layout
                    const img = createImageElement(input.files[0]);
                    img.className = 'w-full h-full object-cover rounded';
                    previewGrid.appendChild(img);
                } else {
                    // Multiple images layout
                    const gridDiv = document.createElement('div');
                    gridDiv.className = `grid gap-2 w-full h-full ${input.files.length > 2 ? 'grid-cols-2 grid-rows-2' : 'grid-cols-1 grid-rows-2'} justify-items-center items-center`;
                    
                    Array.from(input.files).forEach((file, index) => {
                        const containerDiv = document.createElement('div');
                        containerDiv.className = 'relative w-full h-full';
                        
                        // Apply specific layout rules based on number of photos
                        if (input.files.length === 2) {
                            containerDiv.className += ' row-span-1';
                        } else if (input.files.length === 3 && index === 2) {
                            containerDiv.className += ' col-span-2';
                        }
                        
                        const img = createImageElement(file);
                        img.className = 'absolute inset-0 w-full h-full object-cover rounded';
                        
                        containerDiv.appendChild(img);
                        gridDiv.appendChild(containerDiv);
                    });
                    
                    previewGrid.appendChild(gridDiv);
                }
            } else {
                previewGrid.classList.add('hidden');
            }
        }

        function createImageElement(file) {
            const img = document.createElement('img');
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
            }
            reader.readAsDataURL(file);
            return img;
        }
    </script>
</x-app-layout>