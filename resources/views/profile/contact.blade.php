<x-app-layout>
    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold mb-6 text-center text-gray-900">Contact {{ $organization->org_name }}</h2>
            
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="mb-6">
                    <div class="flex items-center space-x-4 mb-4">
                        <img src="{{ asset($organization->getLogoPath()) }}" 
                             alt="{{ $organization->org_name }}" 
                             class="w-16 h-16 rounded-full object-cover">
                        <div>
                            <h3 class="text-lg font-semibold">{{ $organization->org_name }}</h3>
                            <p class="text-gray-600">{{ $organization->description }}</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="p-3 bg-gray-50 rounded">
                            <p class="text-sm font-medium text-gray-700">Mobile</p>
                            <p>{{ $organization->org_mobile }}</p>
                        </div>
                        @if($organization->org_telephone)
                        <div class="p-3 bg-gray-50 rounded">
                            <p class="text-sm font-medium text-gray-700">Telephone</p>
                            <p>{{ $organization->org_telephone }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <form action="{{ route('profile.send-message', $organization) }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Your Email</label>
                        <input type="email" name="email" id="email" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               placeholder="your@email.com"
                               value="{{ Auth::user()->email ?? old('email') }}"
                               required>
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                        <textarea name="message" id="message" rows="4" 
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                  placeholder="Your message here..."
                                  required></textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" 
                                class="inline-flex justify-center rounded-md border border-transparent bg-blue-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                            Send Message
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>