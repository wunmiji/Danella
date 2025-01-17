const swiper = new Swiper('.swiper', {
    speed: 400,
    spaceBetween: 100,
    autoplay: {
        delay: 5000,
    },
    // Default parameters
    slidesPerView: 1,
    breakpointsBase: 'container',
    breakpoints: {
        320: {
            slidesPerView: 1,
            spaceBetween: 10
        },
        480: {
            slidesPerView: 1.3,
            spaceBetween: 15
        },
        576: {
            slidesPerView: 1.8,
            spaceBetween: 15
        },
        640: {
            slidesPerView: 2,
            spaceBetween: 20,
        },
        768: {
            slidesPerView: 3,
            spaceBetween: 30,
        },

    },
    centeredSlides: true,
    centeredSlidesBounds: true,
    pagination: {
        el: '.swiper-pagination',
        type: 'bullets',
        clickable: true,
    },
});
