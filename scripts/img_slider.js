const slider = document.querySelector('.slider');
const slides = document.querySelectorAll('.slide');
let index = 0;

const autoSlide = () => {
    index++;
    if (index >= slides.length) index = 0;
    slider.scrollTo({
        left: slider.clientWidth * index,
        behavior: 'smooth'
    });
};

setInterval(autoSlide, 2000);
