// Define tutorials first
const volunteerDashboardTutorial = {
    steps: [
        {
            target: '[data-tutorial="request-activity"]',
            content: "You can request for an activity that organizations can see and start officially",
            position: 'bottom'
        },
        {
            target: '[data-tutorial="stats-section"]',
            content: "Shows your completed projects, hours you have contributed and interactions with ideas",
            position: 'bottom'
        },
        {
            target: '[data-tutorial="graph-section"]',
            content: "Will show your Activity Hours Summary for each year",
            position: 'bottom'
        },
        {
            target: '[data-tutorial="activities-section"]',
            content: "Will show each activity that you are registered in. For each activity you can see its status, its timeline and its details",
            position: 'bottom'
        }
    ],
    pageName: 'volunteer_dashboard'
};

const volunteerProfileTutorial = {
    steps: [
        {
            target: '[data-tutorial="edit-profile"]',
            content: "Complete your profile to get the maximum out of Kormonno. You CANNOT REGISTER for job posts by organizations unless you complete your profile. You can also change various settings here.",
            position: 'bottom'
        },
        {
            target: '[data-tutorial="share-profile"]',
            content: "Most parts of your profile page can always be seen by everyone. You can directly share your achievements from here.",
            position: 'bottom'
        },
        {
            target: '[data-tutorial="profile-stats"]',
            content: "As you do more these numbers will reflect how much you've contributed for the good of the world.",
            position: 'top'
        },
        {
            target: '[data-tutorial="accomplishments"]',
            content: "Every activity that gets completed by you will be shown here. They will only appear after the creator organization chooses to do so. You can hide this part from edit profile.",
            position: 'top'
        }
    ],
    pageName: 'volunteer_profile'
};

const favoritesTutorial = {
    steps: [
        {
            target: '[data-tutorial="add-favorites"]',
            content: "Select categories and districts that you prefer and you will see activities and ideas related to selected ones. You can also manage your following from here.",
            position: 'bottom'
        },
        {
            target: '[data-tutorial="favorite-content"]',
            content: "Posts from your favorite selection will be shown here. You can always edit your chosen selection.",
            position: window.innerWidth <= 640 ? 'top' : 'bottom'
        }
    ],
    pageName: 'favorites'
};

const homeTutorial = {
    steps: [
        {
            target: '[data-tutorial="accomplished-section"]',
            content: "View projects that have been completed by our organization and volunteers combined",
            position: 'top'
        },
        {
            target: '[data-tutorial="idea-board-section"]',
            content: "This is where you can contribute to questions posed by organizations and help them solve problems.",
            position: 'top'
        },
        {
            target: '[data-tutorial="latest-activities"]',
            content: "Here you can see all open activities that you can register for right now and start your journey with Kormonno",
            position: 'top'
        }
    ],
    pageName: 'home'
};

// Then the rest of the code starting with the DOMContentLoaded event
document.addEventListener('DOMContentLoaded', function() {

    // First check if tutorial should be shown
    //DO NOT DELETE THIS PATH CANNOT BE EMPTY
    // 'h' IS ACCOUNTED FOR IN THE CONTROLLER
    if(window.location.pathname == '' || window.location.pathname == '/') path = "h";
    else path = window.location.pathname.replace(/^\/+/, '');
    // console.log(path);
    fetch(`/api/tutorial-progress/${path}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            // console.log('Tutorial progress:', data);
            if (data.dont_show_again) {
                // console.log('Tutorial disabled for this page');
                return;
            }
            initializeTutorial();
        })
        .catch(error => {
            console.error('Error checking tutorial progress:', error);
        });

    function updateTutorialProgress(data) {
        // console.log('Updating tutorial progress:', data);
        // console.log('CSRF Token:', document.querySelector('meta[name="csrf-token"]')?.content);
        return fetch('/api/tutorial-progress', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                page_name: data.page_name,
                dont_show_again: data.dont_show_again
            }),
            credentials: 'same-origin'
        })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => {
                    console.error('Response text:', text);
                    throw new Error(`HTTP error! status: ${response.status}`);
                });
            }
            return response.json();
        })
        .catch(error => {
            console.error('Error updating tutorial progress:', error);
            popup.classList.add('hidden');
        });
    }
    

    function initializeTutorial() {
        let currentTutorial;
        let currentStep = 0;
        const path = window.location.pathname;

        // Check if tutorial popup elements exist
        const popup = document.getElementById('tutorial-popup');
        const content = document.getElementById('tutorial-content');
        const nextBtn = document.getElementById('tutorial-next');
        const dontShowBtn = document.getElementById('tutorial-dont-show');

        if (!popup || !content || !nextBtn || !dontShowBtn) {
            console.error('Tutorial popup elements not found');
            return;
        }

        // Determine which tutorial to use
        if (path === '/dashboard') {
            currentTutorial = volunteerDashboardTutorial;
        } else if (path.match(/^\/profile\/[^/]+$/)) {
            currentTutorial = volunteerProfileTutorial;
        } else if (path === '/favorites') {
            currentTutorial = favoritesTutorial;
        } else if (path === '/' || path === '') {
            currentTutorial = homeTutorial;
        }

        if (!currentTutorial) {
            return;
        }

        // Clean up function to remove highlight
        function cleanupHighlight(element) {
            if (element) {
                element.style.position = '';
                element.style.zIndex = '';
                element.style.boxShadow = '';
                element.style.outline = '';
            }
        }

        function showTutorialStep(step) {
            // Remove previous highlight
            currentTutorial.steps.forEach((tutorialStep) => {
                const element = document.querySelector(tutorialStep.target);
                cleanupHighlight(element);
            });

            const targetElement = document.querySelector(currentTutorial.steps[step].target);
            
            if (!targetElement) {
                console.error('Target element not found for step', step);
                return;
            }

            // Create overlay if it doesn't exist yet
            let overlay = document.getElementById('tutorial-overlay');
            if (!overlay) {
                overlay = document.createElement('div');
                overlay.id = 'tutorial-overlay';
                overlay.style.position = 'fixed';
                overlay.style.top = '0';
                overlay.style.left = '0';
                overlay.style.width = '100%';
                overlay.style.height = '100%';
                overlay.style.backgroundColor = 'rgba(0, 0, 0, 0.2)'; // Lighter overlay
                overlay.style.zIndex = '99997';
                overlay.style.pointerEvents = 'none'; // Allow interactions with highlighted area
                document.body.appendChild(overlay);
            }

            // Function to update overlay cutout
            function updateOverlayCutout() {
                const currentTargetElement = document.querySelector(currentTutorial.steps[currentStep].target);
                if (currentTargetElement) {
                    const targetRect = currentTargetElement.getBoundingClientRect();
                    overlay.style.clipPath = `polygon(
                        0% 0%, 
                        0% 100%, 
                        ${targetRect.left}px 100%, 
                        ${targetRect.left}px ${targetRect.top}px, 
                        ${targetRect.right}px ${targetRect.top}px, 
                        ${targetRect.right}px ${targetRect.bottom}px, 
                        ${targetRect.left}px ${targetRect.bottom}px, 
                        ${targetRect.left}px 100%, 
                        100% 100%, 
                        100% 0%
                    )`;
                }
            }

            // Update overlay cutout on scroll and resize
            window.addEventListener('scroll', updateOverlayCutout);
            window.addEventListener('resize', updateOverlayCutout);

            // Initial update of overlay cutout
            updateOverlayCutout();

            // Add highlight only to current target element
            targetElement.style.position = 'relative';
            targetElement.style.zIndex = '99998';
            targetElement.style.boxShadow = '0 0 10px 5px rgba(0, 255, 0, 0.7), 0 0 20px 10px rgba(0, 0, 255, 0.7)';
            targetElement.style.outline = 'none';
            targetElement.style.borderRadius = '10px';

            // Calculate the scroll position to center the target element
            const targetRect = targetElement.getBoundingClientRect();
            const targetTop = targetRect.top + window.pageYOffset;
            const targetCenter = targetTop - (window.innerHeight / 2) + (targetRect.height / 2);

            // Smooth scroll to center the target element
            window.scrollTo({
                top: targetCenter,
                behavior: 'smooth'
            });

            // Set popup content
            content.textContent = currentTutorial.steps[step].content;

            // Position the popup at the bottom of the page with margin and highest z-index
            popup.style.position = 'fixed';
            popup.style.bottom = '40px';  // Increased bottom margin
            popup.style.left = '50%';
            popup.style.transform = 'translateX(-50%)';
            popup.style.zIndex = '99999'; // Highest z-index to show above everything

            // Update Next/Close button based on step
            if (step === currentTutorial.steps.length - 1) {
                nextBtn.innerHTML = `
                    <span class="text-sm font-medium">Close</span>
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                `;
            } else {
                nextBtn.innerHTML = `
                    <span class="text-sm font-medium mr-2">Next</span>
                    <svg class="w-4 h-4 transform group-hover:translate-x-0.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                `;
            }

            popup.classList.remove('hidden');
        }

        // Global close function
        window.closeTutorial = function() {
            const currentElement = document.querySelector(currentTutorial.steps[currentStep].target);
            cleanupHighlight(currentElement);
            
            // Remove the overlay
            const overlay = document.getElementById('tutorial-overlay');
            if (overlay) {
                overlay.remove();
            }
            
            popup.classList.add('hidden');
        };

        nextBtn.addEventListener('click', function() {
            if (currentStep + 1 >= currentTutorial.steps.length) {
                // On last step, behave like close button
                closeTutorial();
                return;
            }

            // If not the last step, proceed to next step
            currentStep++;
            showTutorialStep(currentStep);
        });

        dontShowBtn.addEventListener('click', function() {
            const currentElement = document.querySelector(currentTutorial.steps[currentStep].target);
            updateTutorialProgress({
                page_name: currentTutorial.pageName,
                dont_show_again: true,
            }).finally(() => {
                closeTutorial();
            });
        });

        // Start tutorial
        setTimeout(() => {
            const allTargets = currentTutorial.steps.map(step => 
                document.querySelector(step.target)
            );
            
            if (allTargets.every(el => el)) {
                showTutorialStep(0);
            } else {
                console.error('Some tutorial targets are missing');
            }
        }, 500);
    }
    
});