<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Idea Thread') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('idea_board.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title:</label>
                            <input type="text" name="title" id="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
                            <textarea name="description" id="description" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="poll_question" class="block text-gray-700 text-sm font-bold mb-2">Poll Question (optional):</label>
                            <input type="text" name="poll_question" id="poll_question" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <p class="text-sm text-gray-600 mt-1">If you want to create a poll instead of an idea thread copy your title here and add poll options which will appear below</p>
                        </div>

                        <div id="poll_options" class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Poll Options:</label>
                            <div class="poll-option">
                                <input type="text" name="poll_options[]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-2">
                            </div>
                            <button type="button" id="add_option" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add Option</button>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Create Idea Thread') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pollQuestion = document.getElementById('poll_question');
            const pollOptionsContainer = document.getElementById('poll_options');
            const addOptionButton = document.getElementById('add_option');
            let optionCount = 1;

            // Initially hide poll options
            pollOptionsContainer.style.display = 'none';

            // Show/hide poll options based on poll question
            pollQuestion.addEventListener('input', function() {
                pollOptionsContainer.style.display = this.value ? 'block' : 'none';
            });

            addOptionButton.addEventListener('click', function() {
                if (optionCount < 10) {
                    optionCount++;
                    const newOption = document.createElement('div');
                    newOption.className = 'poll-option';
                    newOption.innerHTML = `<input type="text" name="poll_options[]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-2">`;
                    pollOptionsContainer.insertBefore(newOption, addOptionButton);

                    if (optionCount === 10) {
                        addOptionButton.style.display = 'none';
                    }
                }
            });
        });
    </script>
</x-app-layout>
