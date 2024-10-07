<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Favorites') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        Select Your Favorite Categories and Districts
                    </h3>
                    <p class="text-sm text-gray-600 mb-4">
                        Choose up to 3 favorite categories and 3 favorite districts. These will help us suggest activities that match your interests and preferred locations.
                    </p>
                    <p class="text-sm text-gray-600 mb-4">
                        You will still be able to see activities from other categories and districts
                    </p>
                    <form method="post" action="{{ route('favorites.update') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('patch')

                        <div class="mb-4">
                            <x-input-label for="category_select" :value="__('Favorite Categories (Select up to 3)')" />
                            <select id="category_select" class="mt-1 block w-full">
                                <option value="">Select a category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="district_select" :value="__('Favorite Districts (Select up to 3)')" />
                            <select id="district_select" class="mt-1 block w-full">
                                <option value="">Select a district</option>
                                @foreach ($districts as $district)
                                    <option value="{{ $district }}">{{ $district }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <h4 class="font-medium text-gray-700 mb-2">Selected Favorites:</h4>
                            <div id="selected_categories" class="mb-2">
                                <h5 class="text-sm font-medium text-gray-600">Categories:</h5>
                                <div id="category_tags" class="flex flex-wrap gap-2"></div>
                            </div>
                            <div id="selected_districts">
                                <h5 class="text-sm font-medium text-gray-600">Districts:</h5>
                                <div id="district_tags" class="flex flex-wrap gap-2"></div>
                            </div>
                        </div>

                        <input type="hidden" name="favorite_categories" id="favorite_categories">
                        <input type="hidden" name="favorite_districts" id="favorite_districts">

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                            <button type="button" id="clear_selections" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Clear Selections</button>

                            @if (session('status') === 'favorites-updated')
                                <p
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    x-init="setTimeout(() => show = false, 2000)"
                                    class="text-sm text-gray-600"
                                >{{ __('Saved.') }}</p>
                            @endif
                        </div>
                    </form>
                </div>
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
                if (this.value && selectedCategories.length < 3) {
                    const selectedOption = this.options[this.selectedIndex];
                    const category = {id: this.value, name: selectedOption.text};
                    if (!selectedCategories.some(c => c.id === category.id)) {
                        selectedCategories.push(category);
                        categoryTags.appendChild(createTag(category.name, 'category'));
                        updateHiddenInputs();
                    }
                }
                this.value = '';
            });

            districtSelect.addEventListener('change', function() {
                if (this.value && selectedDistricts.length < 3) {
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
            @if($favorites && $favorites->favorite_categories)
                @foreach($favorites->favorite_categories as $categoryId => $categoryName)
                    selectedCategories.push({id: '{{ $categoryId }}', name: '{{ $categoryName }}'});
                    categoryTags.appendChild(createTag('{{ $categoryName }}', 'category'));
                @endforeach
            @endif
            @if($favorites && $favorites->favorite_districts)
                @foreach($favorites->favorite_districts as $district)
                    selectedDistricts.push('{{ $district }}');
                    districtTags.appendChild(createTag('{{ $district }}', 'district'));
                @endforeach
            @endif
            updateHiddenInputs();
        });
    </script>

</x-app-layout>