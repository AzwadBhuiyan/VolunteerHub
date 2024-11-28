<x-guest-layout>
    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold mb-6 text-center text-gray-900">Contact Us</h2>
            
            <div class="bg-white p-6 rounded-lg shadow-md">
                <form class="space-y-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="your@email.com">
                    </div>

                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
                        <textarea name="subject" id="subject" rows="4" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="How can we help you?"></textarea>
                    </div>

                    <div class="flex justify-end">
                        <!-- <button type="submit" 
                            class="inline-flex justify-center rounded-md border border-transparent bg-blue-600 !important py-2 px-4 text-sm font-medium text-white !important shadow-md hover:bg-blue-700 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
                            Send Message
                        </button> -->
                        <button type="submit" 
                            class="x-secondary-button">
                            Send Message
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>