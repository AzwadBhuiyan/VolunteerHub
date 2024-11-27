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
            position: 'top'
        },
        {
            target: '[data-tutorial="activities-section"]',
            content: "Will show each activity that you are registered in. For each activity you can see its status, its timeline and its details",
            position: 'top'
        }
    ],
    pageName: 'volunteer_dashboard'
};

const volunteerProfileTutorial = {
    steps: [
        {
            target: '[data-tutorial="edit-profile"]',
            content: "Complete your profile to get the maximum out of Kormonno. You can also change various settings here.",
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
            position: 'bottom'
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
            position: 'top'
        }
    ],
    pageName: 'favorites'
};

const homeTutorial = {
    steps: [
        {
            target: '[data-tutorial="accomplished-section"]',
            content: "View projects that have been completed by our organization and volunteers combined",
            position: 'bottom'
        },
        {
            target: '[data-tutorial="idea-board-section"]',
            content: "This is where you can contribute to questions posed by organizations and help them solve problems.",
            position: 'bottom'
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
    if(window.location.pathname == '' || window.location.pathname == '/') path = "h";
    else path = window.location.pathname.replace(/^\/+/, '');
    console.log(path);
    fetch(`/api/tutorial-progress/${path}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Tutorial progress:', data);
            if (data.dont_show_again) {
                console.log('Tutorial disabled for this page');
                return;
            }
            initializeTutorial();
        })
        .catch(error => {
            console.error('Error checking tutorial progress:', error);
        });

    function initializeTutorial() {
        // Determine which tutorial to use based on the current page
        let currentTutorial;
        const path = window.location.pathname;

        if (path === '/dashboard') {
            currentTutorial = volunteerDashboardTutorial;
        } else if (path.match(/^\/profile\/[^/]+$/)) {
            // Matches /profile/{url} pattern
            currentTutorial = volunteerProfileTutorial;
        } else if (path === '/favorites') {
            currentTutorial = favoritesTutorial;
        } else if (path === '/' || path === '') {
            currentTutorial = homeTutorial;
        }

        if (!currentTutorial) {
            // console.log('No tutorial defined for this page');
            return;
        }

        // Debug all tutorial targets at start
        currentTutorial.steps.forEach((step, index) => {
            const element = document.querySelector(step.target);
            console.log(`Step ${index} (${step.target}):`, element ? 'Found' : 'Not found');
        });

        // Tutorial functionality
        const popup = document.getElementById('tutorial-popup');
        const content = document.getElementById('tutorial-content');
        const nextBtn = document.getElementById('tutorial-next');
        const dontShowBtn = document.getElementById('tutorial-dont-show');
        let currentStep = 0;

        function showTutorialStep(step) {
            const targetElement = document.querySelector(currentTutorial.steps[step].target);
            
            if (!targetElement) {
                console.error('Target element not found for step', step);
                return;
            }

            // Remove highlight from previous element if exists
            if (step > 0) {
                const previousElement = document.querySelector(currentTutorial.steps[step - 1].target);
                if (previousElement) {
                    previousElement.style.position = '';
                    previousElement.style.zIndex = '';
                    previousElement.style.boxShadow = '';
                }
            }

            // Scroll element into view first
            targetElement.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });

            // Set popup content
            content.textContent = currentTutorial.steps[step].content;
            popup.setAttribute('data-position', currentTutorial.steps[step].position);

            // Position popup fixed relative to viewport
            const viewportHeight = window.innerHeight;
            const position = currentTutorial.steps[step].position;
            
            if (position === 'bottom') {
                popup.style.position = 'fixed';
                popup.style.top = '60%';
                popup.style.transform = 'translateY(-50%)';
            } else {
                popup.style.position = 'fixed';
                popup.style.top = '40%';
                popup.style.transform = 'translateY(-50%)';
            }

            // Center horizontally
            popup.style.left = '50%';
            popup.style.transform += ' translateX(-50%)';
            
            popup.classList.remove('hidden');

            // Add highlight to current target element
            targetElement.style.position = 'relative';
            targetElement.style.zIndex = '99998';
            targetElement.style.boxShadow = '0 0 0 4px rgba(59, 130, 246, 0.5)';
        }

        function updateTutorialProgress(data) {
            console.log('Updating tutorial progress:', data);
            console.log('CSRF Token:', document.querySelector('meta[name="csrf-token"]')?.content);
            return fetch('/api/tutorial-progress', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    page_name: data.page_name,
                    dont_show_again: data.dont_show_again
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .catch(error => {
                console.error('Error updating tutorial progress:', error);
                popup.classList.add('hidden');
            });
        }

        nextBtn.addEventListener('click', function() {
            if (currentStep + 1 >= currentTutorial.steps.length) {
                // Remove highlight from last element
                const lastElement = document.querySelector(currentTutorial.steps[currentStep].target);
                if (lastElement) {
                    lastElement.style.position = '';
                    lastElement.style.zIndex = '';
                    lastElement.style.boxShadow = '';
                }

                updateTutorialProgress({
                    page_name: currentTutorial.pageName,
                    last_step_seen: currentStep
                }).finally(() => {
                    popup.classList.add('hidden');
                });
                return;
            }
            currentStep++;
            showTutorialStep(currentStep);
        });

        dontShowBtn.addEventListener('click', function() {
            // Remove highlight from current element
            const currentElement = document.querySelector(currentTutorial.steps[currentStep].target);
            if (currentElement) {
                currentElement.style.position = '';
                currentElement.style.zIndex = '';
                currentElement.style.boxShadow = '';
            }

            updateTutorialProgress({
                page_name: currentTutorial.pageName,
                dont_show_again: true,
            }).finally(() => {
                popup.classList.add('hidden');
            });
        });

        // Ensure all elements are present
        setTimeout(() => {
            const allTargets = currentTutorial.steps.map(step => 
                document.querySelector(step.target)
            );
            console.log('All tutorial targets:', allTargets);
            
            // Only start if all elements are found
            if (allTargets.every(el => el)) {
                showTutorialStep(0);
            } else {
                console.error('Some tutorial targets are missing');
            }
        }, 500);
    }
    
});