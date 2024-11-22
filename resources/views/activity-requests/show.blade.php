<x-app-layout>
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 min-h-screen">
        <div class="p-1 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex items-center mb-6">
                        <img src="{{ asset($request->volunteer->getProfilePicturePath()) }}" 
                            alt="{{ $request->volunteer->Name }}" 
                            class="w-14 h-14 rounded-full object-cover mr-4">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">
                                {{ $request->volunteer->Name }}
                            </h2>
                            <p class="text-sm text-gray-500">Requested on {{ $request->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>

                    <h1 class="text-2xl font-bold text-gray-900 mb-4">
                        {{ $request->title }}
                    </h1>

                    <div class="mb-6">
                        <img src="{{ asset($request->getImagePath()) }}" 
                            alt="{{ $request->title }}" 
                            class="w-full h-[250px] object-cover rounded-lg">
                    </div>

                    <p class="text-gray-700 text-lg mb-8 leading-relaxed">{{ $request->description }}</p>
                    
                    <div class="bg-gray-50 rounded-lg p-6 mb-8">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <span class="font-bold text-gray-700">District:</span>
                                <span class="text-gray-600 ml-2">{{ $request->district }}</span>
                            </div>
                            <div>
                                <span class="font-bold text-gray-700">Volunteer Level:</span>
                                <span class="text-gray-600 ml-2">{{ $request->volunteer->getLevel() }}</span>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('activity-requests.approve', $request) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-md transition-colors">
                            Create Activity from Request
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>