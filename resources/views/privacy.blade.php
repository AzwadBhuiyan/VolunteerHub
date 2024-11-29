<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 min-h-screen">
        <!-- Centered container with responsive padding and vertical spacing -->
        <div class="p-1 sm:p-8 bg-white shadow sm:rounded-lg">
    {{-- <div class="py-8 ">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8"> --}}
            <h2 class="text-2xl font-bold text-center text-gray-900" 
                style="border-bottom: 2px solid transparent; border-image: linear-gradient(to right, #3B82F6, #10B981, #3B82F6); border-image-slice: 1; width: 50%; margin: 0 auto; margin-bottom: 4rem;">
                Privacy Policy
            </h2>
            
            {{-- <div class="bg-white p-6 rounded-lg shadow-md prose prose-blue max-w-none"> --}}
                <!-- Introduction -->
                <h3 class="text-xl font-semibold mb-4">Introduction</h3>
                <p class="mb-4">At Kormonno, we are committed to protecting your privacy. This Privacy Policy outlines how we collect, use, and safeguard your personal information when you use our platform.</p>

                <!-- Consent -->
                <h3 class="text-xl font-semibold mb-4">Consent</h3>
                <p class="mb-4">By using our platform, you consent to the terms of this Privacy Policy. If you do not agree with any part of this policy, please do not use our services.</p>

                <!-- Changes to Privacy Policy -->
                <h3 class="text-xl font-semibold mb-4">Changes to Privacy Policy</h3>
                <p class="mb-4">We may update this Privacy Policy from time to time. Any changes will be posted on this page, and we will notify you of significant changes through email or a notice on our platform.</p>
                <!-- Information Collection -->
                <h3 class="text-xl font-semibold mb-4">1. Information We Collect</h3>
                <p class="mb-4">To facilitate volunteer connections, we collect:</p>
                <ul class="list-disc pl-6 mb-4">
                    <li>Profile information (name, contact details)</li>
                    <li>Volunteer preferences and history</li>
                    <li>Organization details and opportunities</li>
                    <li>Activity logs and participation records</li>
                </ul>

                <!-- Information Usage -->
                <h3 class="text-xl font-semibold mb-4">2. How We Use Your Information</h3>
                <p class="mb-4">We use your information to:</p>
                <ul class="list-disc pl-6 mb-4">
                    <li>Match volunteers with opportunities</li>
                    <li>Verify organization legitimacy</li>
                    <li>Track volunteer impact</li>
                    <li>Improve our services</li>
                </ul>

                <!-- Data Protection -->
                <h3 class="text-xl font-semibold mb-4">3. Data Protection</h3>
                <p class="mb-4">We implement security measures to protect your data:</p>
                <ul class="list-disc pl-6 mb-4">
                    <li>Encrypted data transmission</li>
                    <li>Secure data storage</li>
                    <li>Regular security audits</li>
                    <li>Access controls</li>
                </ul>

                <!-- Data Sharing -->
                <h3 class="text-xl font-semibold mb-4">4. Information Sharing</h3>
                <p class="mb-4">We share information only:</p>
                <ul class="list-disc pl-6 mb-4">
                    <li>Between matched volunteers and organizations</li>
                    <li>When required by law</li>
                    <li>With your explicit consent</li>
                </ul>

                <!-- User Rights -->
                <h3 class="text-xl font-semibold mb-4">5. Your Rights</h3>
                <p class="mb-4">You have the right to:</p>
                <ul class="list-disc pl-6 mb-4">
                    <li>Access your personal data</li>
                    <li>Request data correction</li>
                    <li>Delete your account</li>
                    <li>Opt-out of communications</li>
                </ul>

                <!-- Contact Information -->
                <h3 class="text-xl font-semibold mb-4">6. Contact Us</h3>
                <p class="mb-4">For privacy concerns, <a href="{{ route('contact') }}" class="text-blue-500 hover:text-blue-700">contact us here</a></p>
            {{-- </div> --}}
        </div>
    </div>
{{-- </div>
</div> --}}
</x-app-layout>