<x-app-layout>

    <div class="p-4 sm:p-8 bg-white items-center shadow sm:rounded-lg">

        <div class="max-w-3xl mx-auto px-1 sm:px-6 lg:px-8">
            <!-- Centered container with responsive padding and vertical spacing -->
            <div class="p-4 sm:p-8 bg-white items-center shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    Select Your Favorite Activity Categories and Locations
                </h3>
                <p class="text-sm text-gray-600 mb-4">
                    Choose categories & locations to get a more personalized activity suggestions in your
                    favorites tab.
                </p>

                <form method="post" action="{{ route('favorites.update') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('patch')

                    <div class="mb-4">
                        <x-input-label for="category_select" :value="__('Favorite Categories')" />
                        <select id="category_select" class="mt-1 block w-1/2">
                            <option value="">Select a category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="district_select" :value="__('Favorite Districts')" />
                        <select id="district_select" class="mt-1 block w-1/2">
                            <option value="">Select a district</option>
                            @foreach ($districts as $district)
                                <option value="{{ $district }}">{{ $district }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <div id="selected_categories" class="mb-2">
                            <h5 class="text-sm font-medium text-gray-600">Selected Categories:</h5>
                            <div id="category_tags" class="flex flex-wrap gap-2"></div>
                        </div>
                        <div id="selected_districts" class="mb-2">
                            <h5 class="text-sm font-medium text-gray-600">Preferred Locations:</h5>
                            <div id="district_tags" class="flex flex-wrap gap-2"></div>
                        </div>
                    </div>

                    <input type="hidden" name="favorite_categories" id="favorite_categories">
                    <input type="hidden" name="favorite_districts" id="favorite_districts">

                    <div class="flex items-center gap-4">
                        <button type="button" id="clear_selections"
                            class="px-4 py-1 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Clear
                            Selections</button>
                        <x-primary-button>{{ __('Save') }}</x-primary-button>

                        @if (session('status') === 'favorites-updated')
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                class="px-4 py-1 text-gray-600">{{ __('Saved.') }}</p>
                        @endif
                    </div>
                </form>

            </div>
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categorySelect = document.getElementById('category_select');
            const districtSelect = document.getElementById('district_select');
            const categoryTags = document.getElementById('category_tags');
            const districtTags = document.getElementById('district_tags');
            const favoriteCategories = document.getElementById('favorite_categories');
            const favoriteDistricts = document.getElementById('favorite_districts');
            const clearSelectionsBtn = document.getElementById('clear_selections');

            let selectedCategories = [];
            let selectedDistricts = [];

            function updateHiddenInputs() {
                favoriteCategories.value = JSON.stringify(selectedCategories);
                favoriteDistricts.value = JSON.stringify(selectedDistricts);
            }

            function createTag(text, type) {
                const tag = document.createElement('span');
                tag.textContent = text;
                tag.className = 'px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-sm';

                const removeBtn = document.createElement('button');
                removeBtn.textContent = '×';
                removeBtn.className = 'ml-1 text-blue-600 hover:text-blue-800 focus:outline-none';
                removeBtn.onclick = function() {
                    if (type === 'category') {
                        selectedCategories = selectedCategories.filter(c => c.name !== text);
                        categoryTags.removeChild(tag);
                    } else {
                        selectedDistricts = selectedDistricts.filter(d => d !== text);
                        districtTags.removeChild(tag);
                    }
                    updateHiddenInputs();
                };

                tag.appendChild(removeBtn);
                return tag;
            }

            categorySelect.addEventListener('change', function() {
                if (this.value) {
                    const selectedOption = this.options[this.selectedIndex];
                    const category = {
                        id: this.value,
                        name: selectedOption.text
                    };
                    if (!selectedCategories.some(c => c.id === category.id)) {
                        selectedCategories.push(category);
                        categoryTags.appendChild(createTag(category.name, 'category'));
                        updateHiddenInputs();
                    }
                }
                this.value = '';
            });

            districtSelect.addEventListener('change', function() {
                if (this.value) {
                    if (!selectedDistricts.includes(this.value)) {
                        selectedDistricts.push(this.value);
                        districtTags.appendChild(createTag(this.value, 'district'));
                        updateHiddenInputs();
                    }
                }
                this.value = '';
            });

            clearSelectionsBtn.addEventListener('click', function() {
                selectedCategories = [];
                selectedDistricts = [];
                categoryTags.innerHTML = '';
                districtTags.innerHTML = '';
                updateHiddenInputs();
            });

            // Initialize with existing favorites
            @if ($favorites && $favorites->favorite_categories)
                @foreach ($favorites->favorite_categories as $categoryId => $categoryName)
                    selectedCategories.push({
                        id: '{{ $categoryId }}',
                        name: '{{ $categoryName }}'
                    });
                    categoryTags.appendChild(createTag('{{ $categoryName }}', 'category'));
                @endforeach
            @endif
            @if ($favorites && $favorites->favorite_districts)
                @foreach ($favorites->favorite_districts as $district)
                    selectedDistricts.push('{{ $district }}');
                    districtTags.appendChild(createTag('{{ $district }}', 'district'));
                @endforeach
            @endif
            updateHiddenInputs();
        });
    </script>

</x-app-layout>
