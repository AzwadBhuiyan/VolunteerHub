import Swiper from 'swiper';
import { Navigation } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';

document.addEventListener('DOMContentLoaded', function() {
    const imagePopup = document.getElementById('image-popup');
    const popupImage = document.getElementById('popup-image');
    const closePopup = document.getElementById('close-popup');
    const imageCarousel = document.getElementById('image-carousel');
    const swiper = new Swiper('.swiper', {
        modules: [Navigation],
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });

    function setupCarousel(carouselImages) {
        const swiperWrapper = document.querySelector('.swiper-wrapper');
        swiperWrapper.innerHTML = '';
        carouselImages.forEach(src => {
            const slide = document.createElement('div');
            slide.className = 'swiper-slide';
            const image = document.createElement('img');
            image.src = src;
            image.alt = 'Activity Photo';
            image.className = 'max-w-full max-h-full object-contain';
            slide.appendChild(image);
            swiperWrapper.appendChild(slide);
        });
        swiper.update();
    }

    document.querySelectorAll('.clickable-image').forEach(img => {
        img.addEventListener('click', function() {
            const imgSrc = this.getAttribute('data-full-src');
            const isCarousel = this.getAttribute('data-carousel') === 'true';
            
            if (isCarousel) {
                imageCarousel.style.display = 'block';
                popupImage.style.display = 'none';
                const carouselImages = JSON.parse(this.getAttribute('data-carousel-images'));
                setupCarousel(carouselImages);
            } else {
                imageCarousel.style.display = 'none';
                popupImage.style.display = 'block';
                popupImage.src = imgSrc;
            }
            
            imagePopup.classList.remove('hidden');
        });
    });

    closePopup.addEventListener('click', function() {
        imagePopup.classList.add('hidden');
    });

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            imagePopup.classList.add('hidden');
        }
    });
});