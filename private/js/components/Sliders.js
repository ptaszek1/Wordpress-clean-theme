import Swiper from "swiper";

/**
 * Initializes the Sliders component.
 */

const Sliders = () => {
	// Below just an example of how to use Swiper
	const gridSlider = new Swiper(".example-slider", {
		slidesPerView: 1,
		watchSlidesProgress: true,
		centerInsufficientSlides: true,
		pagination: {
			el: ".swiper-pagination",
			type: "bullets",
		},
		loop: true,
		autoplay: {
			delay: 5000,
		},
		breakpoints: {
			// when window width is >= 5750px
			575: {
				slidesPerView: 2,
			},
			// when window width is >= 1024px
			1024: {
				slidesPerView: 3,
			},
		},
	});
};

export default Sliders;
