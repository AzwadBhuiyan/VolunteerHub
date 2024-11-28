const backToTopButton = document.getElementById('backToTop');

function toggleBackToTop() {
    if (window.scrollY > 300) {
        backToTopButton.classList.remove('opacity-0', 'translate-y-10');
        backToTopButton.classList.add('opacity-100', 'translate-y-0');
    } else {
        backToTopButton.classList.add('opacity-0', 'translate-y-10');
        backToTopButton.classList.remove('opacity-100', 'translate-y-0');
    }
}

function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

// Throttle scroll event
let isScrolling = false;
window.addEventListener('scroll', () => {
    if (!isScrolling) {
        window.requestAnimationFrame(() => {
            toggleBackToTop();
            isScrolling = false;
        });
        isScrolling = true;
    }
});

backToTopButton.addEventListener('click', scrollToTop);