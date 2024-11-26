<x-app-layout>
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 min-h-screen">
        <div class="p-1 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex items-center mb-6">
                        @if($activity->organization->logo)
                            <img src="{{ asset($activity->organization->getLogoPath()) }}" 
                                alt="{{ $activity->organization->org_name }}" 
                                class="w-14 h-14 rounded-full object-cover mr-4">
                        @else
                            <div class="w-14 h-14 rounded-full bg-gray-200 flex items-center justify-center mr-4">
                                <span class="text-xl font-bold text-gray-600">{{ substr($activity->organization->org_name, 0, 1) }}</span>
                            </div>
                        @endif
                        <div>
                            <a href="{{ route('profile.public', $activity->organization->url) }}" class="text-lg font-semibold text-gray-900 hover:underline">
                                {{ $activity->organization->org_name }}
                            </a>
                            <p class="text-sm text-gray-500">Completed on {{ $activity->updated_at->format('M d, Y') }}</p>
                        </div>
                    </div>

                    <h1 class="text-2xl font-bold text-gray-900 mb-4">
                        {{ $activity->title }}
                    </h1>

                    <div class="mb-6 relative">
                        <div id="carousel" class="relative w-full overflow-hidden rounded-lg">
                            <div class="flex transition-transform duration-500 ease-in-out">
                                @foreach($accomplishedPhotos as $index => $photo)
                                    <div class="w-full flex-shrink-0">
                                        <img src="{{ asset('images/activities/' . $activity->activityid . '/accomplished/' . basename($photo)) }}"
                                             alt="Activity Photo {{ $index + 1 }}"
                                             class="w-full h-[400px] object-cover">
                                    </div>
                                @endforeach
                            </div>
                            
                            @if(count($accomplishedPhotos) > 1)
                                <button onclick="moveSlide(-1)" class="absolute left-0 top-1/2 -translate-y-1/2 bg-black/50 text-white p-2 rounded-r">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                </button>
                                <button onclick="moveSlide(1)" class="absolute right-0 top-1/2 -translate-y-1/2 bg-black/50 text-white p-2 rounded-l">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>

                                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                                    @foreach($accomplishedPhotos as $index => $photo)
                                        <button onclick="goToSlide({{ $index }})" 
                                                class="w-2 h-2 rounded-full bg-white/70 hover:bg-white transition-colors"
                                                id="dot-{{ $index }}">
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="bg-green-50 rounded-lg p-4 mb-8">
                        <h3 class="text-lg font-semibold text-green-800 mb-2">Accomplishment Description:</h3>
                        <p class="text-gray-700 text-lg leading-relaxed">{{ $activity->accomplished_description }}</p>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-6 mb-8">
                        <div class="text-center mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 inline-block border-b-2 border-gray-300 pb-2">Activity Details</h3>
                        </div>
                        <div class="grid grid-cols-2 gap-y-6 gap-x-8">
                            <div class="space-y-1">
                                <span class="block font-bold text-gray-700">Date:</span>
                                <span class="text-gray-600">{{ $activity->date->format('M d, Y') }}</span>
                            </div>
                            <div class="space-y-1">
                                <span class="block font-bold text-gray-700">Time:</span>
                                <span class="text-gray-600">{{ $activity->time->format('H:i') }}</span>
                            </div>
                            <div class="space-y-1">
                                <span class="block font-bold text-gray-700">Category:</span>
                                <span class="text-gray-600">{{ $activity->category }}</span>
                            </div>
                            <div class="space-y-1">
                                <span class="block font-bold text-gray-700">District:</span>
                                <span class="text-gray-600">{{ $activity->district }}</span>
                            </div>
                            <div class="col-span-2 space-y-1">
                                <span class="block font-bold text-gray-700">Location:</span>
                                <span class="text-gray-600">{{ $activity->address }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentSlide = 0;
        const slides = document.querySelectorAll('#carousel .flex-shrink-0');
        const totalSlides = slides.length;

        function updateCarousel() {
            const carousel = document.querySelector('#carousel .flex');
            carousel.style.transform = `translateX(-${currentSlide * 100}%)`;
            
            document.querySelectorAll('[id^="dot-"]').forEach((dot, index) => {
                dot.classList.toggle('bg-white', index === currentSlide);
                dot.classList.toggle('bg-white/70', index !== currentSlide);
            });
        }

        function moveSlide(direction) {
            currentSlide = (currentSlide + direction + totalSlides) % totalSlides;
            updateCarousel();
        }

        function goToSlide(index) {
            currentSlide = index;
            updateCarousel();
        }

        updateCarousel();
    </script>
</x-app-layout>