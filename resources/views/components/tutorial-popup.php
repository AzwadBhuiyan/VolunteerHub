<!-- tutorial popup -->
<div id="tutorial-popup" class="hidden fixed bottom-4 left-1/2 transform -translate-x-1/2 z-50">
    <div class="bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 rounded-2xl p-4 relative tutorial-bubble w-[600px] border border-white/90 backdrop-blur-sm">
        <div class="tutorial-arrow"></div>
        
        <!-- Close button -->
        <button id="tutorial-close" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 transition-colors duration-200" onclick="closeTutorial();">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
     
        
        <!-- Avatar Section  -->
        <div class="flex items-center space-x-3 mb-3">
            <div class="w-11 h-11 rounded-full bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center ring-2 ring-white/80 shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0012 18.75c-1.03 0-1.96-.464-2.58-1.191l-.547-.547z" />
                </svg>
            </div>
            <div class="text-base font-semibold text-gray-800">Tutorial Guide</div>
        </div>

         <!-- Content -->
        <p id="tutorial-content" class="text-gray-700 text-sm leading-relaxed mb-3"></p>

        <!-- Buttons Side by Side  -->
        <div class="flex space-x-3 mb-0">
            <button id="tutorial-dont-show" 
                class="flex-1 inline-flex items-center justify-center h-10 px-4 rounded-xl bg-white text-gray-700 shadow-md hover:shadow-lg transition-all duration-300 group border border-gray-100 hover:border-gray-200">
                <svg class="w-4 h-4 mr-2 text-gray-400 group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                <span class="text-sm font-medium group-hover:text-gray-900">Don't show again</span>
            </button>
            
            <button id="tutorial-next" 
                class="flex-1 inline-flex items-center justify-center h-10 px-4 rounded-xl bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 text-white shadow-md hover:shadow-lg transition-all duration-300 group hover:translate-x-0.5">
                <span class="text-sm font-medium mr-2">Next</span>
                <svg class="w-4 h-4 transform group-hover:translate-x-0.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </div>
</div>

<script>
function positionTutorialPopup(targetElement) {
    const popup = document.getElementById('tutorial-popup');
    const arrow = popup.querySelector('.tutorial-arrow');
    
    if (targetElement && popup) {
        const targetRect = targetElement.getBoundingClientRect();
        const padding = 15; // Space between target and popup
        
        // Position popup directly under the target element
        popup.style.position = 'fixed';
        popup.style.left = `${targetRect.left}px`;
        popup.style.top = `${targetRect.bottom + padding}px`;
        
        // Ensure popup stays within viewport
        const popupRect = popup.getBoundingClientRect();
        const viewportWidth = window.innerWidth;
        
        // Adjust horizontal position if popup goes outside viewport
        if (popupRect.right > viewportWidth - 20) {
            popup.style.left = `${viewportWidth - popupRect.width - 20}px`;
            arrow.style.left = `${targetRect.left - (viewportWidth - popupRect.width - 20)}px`;
        } else {
            arrow.style.left = '20px'; // Default arrow position aligned with target
        }
        
        popup.classList.remove('hidden');
    }
}

// Example usage:
// To show the popup under a highlighted element with class 'highlighted-area'
document.addEventListener('DOMContentLoaded', function() {
    const highlightedElement = document.querySelector('.highlighted-area'); // or any selector for your blue box
    if (highlightedElement) {
        positionTutorialPopup(highlightedElement);
    }
    
    const closeButton = document.getElementById('tutorial-close');
    const popup = document.getElementById('tutorial-popup');
    
    if (closeButton && popup) {
        closeButton.addEventListener('click', function() {
            popup.classList.add('hidden');
        });
    }
});

// If you're highlighting elements dynamically, you can call it like this:
function showTutorialForElement(element) {
    if (element) {
        // First, add your highlight/blue box effect
        element.classList.add('highlighted-area'); // or whatever class you use for highlighting
        
        // Then position the popup
        positionTutorialPopup(element);
    }
}
</script>

<style>
.tutorial-bubble {
    animation: fadeIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    box-shadow: 
        0 0 30px -5px rgba(66, 56, 157, 0.2),   /* Indigo shadow */
        0 0 50px -10px rgba(168, 85, 247, 0.2),  /* Purple shadow */
        0 0 40px -15px rgba(236, 72, 153, 0.2),  /* Pink shadow */
        0 10px 40px -10px rgba(0, 0, 0, 0.2),    /* Bottom shadow */
        0 20px 60px -15px rgba(0, 0, 0, 0.3),    /* Deep bottom shadow */
        0 0 80px 10px rgba(255, 255, 255, 0.2);  /* Outer glow */
}

@keyframes fadeIn {
    from { 
        opacity: 0; 
        transform: scale(0.95) translateY(10px); 
    }
    to { 
        opacity: 1; 
        transform: scale(1) translateY(0); 
    }
}

.tutorial-arrow {
    position: absolute;
    width: 12px;
    height: 12px;
    background: inherit;
    border: inherit;
    border-right: 0;
    border-bottom: 0;
    transform: rotate(45deg);
    box-shadow: -3px -3px 5px rgba(0, 0, 0, 0.1);
}

/* Add this if you need to highlight elements */
.highlighted-area {
    position: relative;
    z-index: 40; /* Lower than popup's z-index */
    background-color: rgba(59, 130, 246, 0.1); /* Light blue highlight */
    border-radius: 0.5rem;
}

#tutorial-close {
    transition: transform 0.2s ease-in-out;
}

#tutorial-close:hover {
    transform: scale(1.1);
}
</style>