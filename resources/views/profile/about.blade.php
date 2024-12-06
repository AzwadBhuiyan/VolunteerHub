<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 min-h-screen">
        <div class="p-1 sm:p-8 bg-white shadow sm:rounded-lg">
            <h2 class="text-2xl font-bold text-center text-gray-900" 
                style="border-bottom: 2px solid transparent; border-image: linear-gradient(to right, #3B82F6, #10B981, #3B82F6); border-image-slice: 1; width: 50%; margin: 0 auto; margin-bottom: 4rem;">
                About {{ $organization->org_name }}
            </h2>
            
            <!-- Mission Section with Icon -->
            <div class="flex items-start space-x-4 mb-8">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-4">Our Mission</h3>
                    <p class="mb-4">{{ $organization->mission ?? 'Our mission statement will be added soon.' }}</p>
                </div>
            </div>

            <!-- Who We Are Section with Icon -->
            <div class="flex items-start space-x-4 mb-8">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-4">Who We Are</h3>
                    <p class="mb-4">{{ $organization->description }}</p>
                </div>
            </div>

            <!-- Vision Section with Icon -->
            <div class="flex items-start space-x-4 mb-8">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-4">Our Vision</h3>
                    <p class="mb-4">{{ $organization->vision ?? 'Our vision statement will be added soon.' }}</p>
                </div>
            </div>

            <!-- Core Values Section -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-4">Our Core Values</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($organization->values)
                        @foreach(json_decode($organization->values) as $value)
                            <div class="p-4 border rounded-lg">
                                <h4 class="font-semibold text-blue-600">{{ $value->title }}</h4>
                                <p>{{ $value->description }}</p>
                            </div>
                        @endforeach
                    @else
                        <div class="p-4 border rounded-lg">
                            <p class="text-gray-500">Core values will be added soon.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Contact CTA -->
            <div class="text-center bg-gray-50 p-6 rounded-lg">
                <h3 class="text-xl font-semibold mb-4">Get Involved</h3>
                <p class="mb-4">Interested in our mission? Join us in making a difference!</p>
                <div class="space-x-4">
                    <a href="{{ route('organizations.contact', $organization) }}" 
                       class="inline-block bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                        Contact Us
                    </a>
                    @auth
                        @if(Auth::user()->volunteer && !Auth::user()->volunteer->followedOrganizations->contains($organization->userid))
                            <form action="{{ route('organizations.follow', $organization) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition-colors">
                                    Follow Us
                                </button>
                            </form>
                        @endif
                    @endauth
                </div>
            </div>

            @if(Auth::id() == $organization->userid)
                <div class="mt-4 text-center">
                    <a href="{{ route('profile.edit') }}" 
                       class="text-blue-500 hover:text-blue-700">
                        <i class="fas fa-pen mr-2"></i>Edit Organization Details
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>