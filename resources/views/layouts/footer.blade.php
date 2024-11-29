<footer class="{{ isset($isGuestLayout) ? 'bg-transparent border-t border-white/20' : 'bg-gray-700 border-t border-gray-600' }}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <!-- Left side links -->
            <div class="flex flex-wrap gap-4 mb-4 md:mb-0">
                <a href="{{ route('terms') }}" class="{{ isset($isGuestLayout) ? 'text-base text-white/90 hover:text-white' : 'text-base text-white hover:text-gray-300' }}">
                    Terms and Conditions
                </a>
                <a href="{{ route('privacy') }}" class="{{ isset($isGuestLayout) ? 'text-base text-white/90 hover:text-white' : 'text-base text-white hover:text-gray-300' }}">
                    Privacy Policy
                </a>
                <a href="{{ route('about') }}" class="{{ isset($isGuestLayout) ? 'text-base text-white/90 hover:text-white' : 'text-base text-white hover:text-gray-300' }}">
                    About Us
                </a>
                <a href="{{ route('contact') }}" class="{{ isset($isGuestLayout) ? 'text-base text-white/90 hover:text-white' : 'text-base text-white hover:text-gray-300' }}">
                    Contact Us
                </a>
            </div>

            <!-- Right side social icons -->
            <div class="flex gap-4">
                <a href="#" class="{{ isset($isGuestLayout) ? 'text-base text-white/90 hover:text-white' : 'text-base text-white hover:text-gray-300' }}">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M18.77 7.46H14.5v-1.9c0-.9.6-1.1 1-1.1h3V.5h-4.33C10.24.5 9.5 3.44 9.5 5.32v2.15h-3v4h3v12h5v-12h3.85l.42-4z"/>
                    </svg>
                </a>
                <a href="#" class="{{ isset($isGuestLayout) ? 'text-base text-white/90 hover:text-white' : 'text-base text-white hover:text-gray-300' }}">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                </a>
                <a href="#" class="{{ isset($isGuestLayout) ? 'text-base text-white/90 hover:text-white' : 'text-base text-white hover:text-gray-300' }}">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Copyright text -->
        <div class="mt-6 pt-4 border-t {{ isset($isGuestLayout) ? 'border-white/20 text-white/90' : 'border-gray-600 text-white' }} text-center text-base">
            Copyright © {{ date('Y') }} | {{ config('app.name') }} | All Rights Reserved
        </div>
    </div>
</footer>