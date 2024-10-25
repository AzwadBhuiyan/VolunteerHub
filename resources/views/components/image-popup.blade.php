<!-- Main popup container - covers entire screen when visible -->

<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">





<div id="image-popup" class="image-popup hidden fixed inset-0 bg-black bg-opacity-90">
    <!-- Content wrapper - takes full width/height of the popup -->
    <div class="popup-content relative w-2/3 h-2/3 bg-white rounded-lg shadow-lg">
        <!-- Close button - positioned at top-right corner -->
        <span id="close-popup"
            class="close-popup text-white absolute top-4 right-4 text-2xl cursor-pointer">&times;</span>

        <!-- Image container - centers the image both vertically and horizontally -->
        <div class="absolute mx-auto my-auto w-4/5 inset-2">
            <!-- The actual image - maintains aspect ratio and fits within container -->
            <img id="popup-image" class="popup-image" src="" alt="Full-size image">

            <!-- Carousel container - hidden by default, used for multiple images -->
            <div id="image-carousel" class="swiper" style="display: none;">
                <!-- Wrapper for slide items -->
                <div class="swiper-wrapper"></div>

            </div>
        </div>
        <!-- Navigation buttons -->
        <div class="swiper-button-next" data-keyboard="true" data-keycodes="39" tabindex="0" role="button" aria-label="Next slide"></div>
        <div class="swiper-button-prev" data-keyboard="true" data-keycodes="37" tabindex="0" role="button" aria-label="Previous slide"></div>
        <script>
            document.addEventListener('keydown', (e) => {
                if (e.keyCode === 37) { // Left arrow
                    document.querySelector('.swiper-button-prev').click();
                } else if (e.keyCode === 39) { // Right arrow
                    document.querySelector('.swiper-button-next').click();
                }
            });
        </script>
    </div>
</div>
