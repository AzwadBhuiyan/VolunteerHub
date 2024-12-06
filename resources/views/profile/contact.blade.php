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
                    
                    <div class="grid grid-cols-1 gap-4">
                        @if($organization->contact_email)
                        <div class="p-3 bg-gray-50 rounded">
                            <p class="text-sm font-medium text-gray-700">Email</p>
                            <p>{{ $organization->contact_email }}</p>
                        </div>
                        @endif

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

                        @if($organization->website)
                        <div class="p-3 bg-gray-50 rounded">
                            <p class="text-sm font-medium text-gray-700">Website</p>
                            <a href="{{ $organization->website }}" target="_blank" class="text-blue-600 hover:underline">
                                {{ $organization->website }}
                            </a>
                        </div>
                        @endif

                        <div class="p-3 bg-gray-50 rounded">
                            <p class="text-sm font-medium text-gray-700">Address</p>
                            <p>{{ $organization->primary_address }}</p>
                            @if($organization->secondary_address)
                                <p class="mt-2 text-gray-600">Secondary Address:</p>
                                <p>{{ $organization->secondary_address }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>