<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 min-h-screen">
        <div class="p-1 sm:p-8 bg-white shadow sm:rounded-lg">
            <h2 class="text-2xl font-bold text-center text-gray-900" 
                style="border-bottom: 2px solid transparent; border-image: linear-gradient(to right, #3B82F6, #10B981, #3B82F6); border-image-slice: 1; width: 50%; margin: 0 auto; margin-bottom: 4rem;">
                About Us
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
                    <p class="mb-4">Kormonno is dedicated to connecting passionate volunteers with meaningful opportunities to serve their communities and make a positive impact in society. We strive to:</p>
                    <ul class="list-disc pl-6 mb-4">
                        <li>Facilitate meaningful volunteer connections</li>
                        <li>Empower organizations to achieve their goals</li>
                        <li>Create lasting positive change in communities</li>
                        <li>Make volunteering accessible to everyone</li>
                    </ul>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                @php
                    $totalVolunteers = \App\Models\Volunteer::whereHas('user', function ($query) {
                        $query->where('verified', true);
                    })->count();
                    $totalOrganizations = \App\Models\Organization::whereHas('user', function ($query) {
                        $query->where('verified', true);
                    })->count();
                    $totalCompletedActivities = \App\Models\Activity::where('status', 'completed')->count();
                @endphp
                
                <div class="text-center p-4 bg-blue-50 rounded-lg">
                    <div class="text-3xl font-bold text-blue-600">{{ $totalVolunteers }}+</div>
                    <div class="text-gray-600">Active Volunteers</div>
                </div>
                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <div class="text-3xl font-bold text-green-600">{{ $totalOrganizations }}+</div>
                    <div class="text-gray-600">Organizations</div>
                </div>
                <div class="text-center p-4 bg-indigo-50 rounded-lg">
                    <div class="text-3xl font-bold text-indigo-600">{{ $totalCompletedActivities }}+</div>
                    <div class="text-gray-600">Completed Projects</div>
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
                    <p class="mb-4">We are a platform that bridges the gap between volunteers and organizations, facilitating meaningful connections and fostering a culture of community service. Our team consists of passionate individuals who believe in the power of volunteering to transform communities.</p>
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
                    <p class="mb-4">We envision a future where every individual has the opportunity to contribute to social causes and every organization has access to dedicated volunteers who share their mission. Our goals include:</p>
                    <ul class="list-disc pl-6 mb-4">
                        <li>Building stronger, more connected communities</li>
                        <li>Promoting sustainable volunteer engagement</li>
                        <li>Fostering long-term partnerships</li>
                        <li>Measuring and celebrating volunteer impact</li>
                    </ul>
                </div>
            </div>

            <!-- Core Values Section -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-4">Our Core Values</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 border rounded-lg">
                        <h4 class="font-semibold text-blue-600">Integrity</h4>
                        <p>We maintain the highest standards of honesty and transparency in all our operations.</p>
                    </div>
                    <div class="p-4 border rounded-lg">
                        <h4 class="font-semibold text-green-600">Community Focus</h4>
                        <p>We prioritize the needs and well-being of the communities we serve.</p>
                    </div>
                    <div class="p-4 border rounded-lg">
                        <h4 class="font-semibold text-indigo-600">Innovation</h4>
                        <p>We continuously improve our platform to better serve volunteers and organizations.</p>
                    </div>
                    <div class="p-4 border rounded-lg">
                        <h4 class="font-semibold text-purple-600">Inclusivity</h4>
                        <p>We welcome and support volunteers and organizations from all backgrounds.</p>
                    </div>
                </div>
            </div>

            <!-- Contact CTA -->
            <div class="text-center bg-gray-50 p-6 rounded-lg">
                <h3 class="text-xl font-semibold mb-4">Join Our Mission</h3>
                <p class="mb-4">Ready to make a difference? Join our community of changemakers today!</p>
                <a href="{{ route('contact') }}" class="inline-block bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                    Contact Us
                </a>
            </div>
        </div>
    </div>
</x-app-layout>