// page init
jQuery(function(){
	initSlickCarousel();
	initSelect2();
    initFancybox();
	initStickyHeader();
	initMobileNav();
	initResizeEffect();
	initPriceRange();
	initCustomFunctions();
	new PureCounter();

	jQuery(document).click(function(e) {
		var target = e.target;
		if(jQuery('body').hasClass('nav-active')) {
			if (!jQuery(target).hasClass('nav-opener') && !jQuery(target).parents('.main-nav').length) {
				jQuery('body').removeClass('nav-active');
			}
		}
	})
});
// loaded state script
(function(w) {
	w.addEventListener('load', function() {
		var loader = document.querySelector('html');
		if (loader) {
			loader.classList.add('loaded');
		}
	});
}(window));

// slick init
function initSlickCarousel() {
		jQuery('.testimonials-slider').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: false,
		fade: true,
		asNavFor: '.thumbnail-slider',
		focusOnSelect: true,
		autoplay: true,
	});

	jQuery('.thumbnail-slider').slick({
		slidesToShow: 3,
		slidesToScroll: 1,
		asNavFor: '.testimonials-slider',
		dots: false,
		arrows: false,
		centerMode: true,
		focusOnSelect: true,
		autoplay: true,
		centerPadding: '0',
	});

	jQuery('.gallery-slider').slick({
		slidesToScroll: 1,
		slidesToShow: 3,
		rows: 0,
		arrows: false,
		dots: true,
		focusOnSelect: false,
		infinite: true,
		autoplay: true,
		responsive: [
		    {
				breakpoint: 768,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
				},
		    },
		    {
				breakpoint: 576,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				},
		    },
		],
	});

	jQuery('.similar-slider').slick({
		slidesToScroll: 1,
		slidesToShow: 3,
		rows: 0,
		arrows: false,
		dots: true,
		focusOnSelect: false,
		infinite: true,
		autoplay: true,
		responsive: [
		    {
				breakpoint: 1200,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
				},
		    },
		    {
				breakpoint: 768,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				},
		    },
		],
	});

	jQuery('.tweets-slider').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		dots: true,
		arrows: false,
		autoplay: true,
	});

	jQuery('.trending-categories-slider').slick({
		slidesToScroll: 1,
		slidesToShow: 5,
		rows: 0,
		arrows: false,
		dots: true,
		focusOnSelect: false,
		infinite: true,
		autoplay: true,
		responsive: [
			{
				breakpoint: 1375,
				settings: {
					slidesToShow: 4,
					slidesToScroll: 1,
				},
		    },
		    {
				breakpoint: 1200,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 1,
				},
		    },
		    {
				breakpoint: 992,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
				},
		    },
		    {
				breakpoint: 576,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				},
		    },
		],
	});

	jQuery('.quotes-slider').slick({
		slidesToScroll: 1,
		slidesToShow: 3,
		rows: 0,
		arrows: true,
		prevArrow: '<button class="slick-prev"><i class="jobcircle-icon-chevron-left icon"></i></button>',
		nextArrow: '<button class="slick-next"><i class="jobcircle-icon-chevron-right icon"></i></button>',
		dots: true,
		focusOnSelect: false,
		infinite: true,
		autoplay: true,
		responsive: [
		    {
				breakpoint: 992,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
				},
		    },
		    {
				breakpoint: 768,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				},
		    },
		],
	});

	jQuery('.jobs-listing-slider').slick({
		slidesToScroll: 1,
		slidesToShow: 4,
		rows: 0,
		arrows: true,
		prevArrow: '<button class="slick-prev"><i class="jobcircle-icon-chevron-left"></i></button>',
		nextArrow: '<button class="slick-next"><i class="jobcircle-icon-chevron-right"></i></button>',
		dots: true,
		focusOnSelect: false,
		infinite: true,
		autoplay: true,
		responsive: [
		    {
				breakpoint: 1200,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 1,
				},
		    },
			{
				breakpoint: 992,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
				},
		    },
		    {
				breakpoint: 576,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				},
		    },
		],
	});

	jQuery('.usa-jobs-slider').slick({
		slidesToScroll: 1,
		slidesToShow: 4,
		rows: 0,
		arrows: false,
		dots: true,
		variableWidth: false,
		infinite: true,
		autoplay: false,
		responsive: [
		    {
				breakpoint: 1200,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 1,
					variableWidth: false,
				},
		    },
			{
				breakpoint: 992,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
					variableWidth: false,
				},
		    },
		    {
				breakpoint: 576,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					variableWidth: false,
				},
		    },
		],
	});

	jQuery('.companies-slider').slick({
		slidesToScroll: 1,
		slidesToShow: 3,
		rows: 0,
		arrows: true,
		prevArrow: '<button class="slick-prev"><i class="jobcircle-icon-chevron-left "></i></button>',
		nextArrow: '<button class="slick-next"><i class="jobcircle-icon-chevron-right "></i></button>',
		dots: true,
		focusOnSelect: false,
		infinite: true,
		autoplay: true,
		responsive: [
		    {
				breakpoint: 992,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
					arrows: false,
				},
		    },
		    {
				breakpoint: 576,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					arrows: false,
				},
		    },
		],
	});
	
	jQuery('.expert-slider').slick({
		slidesToScroll: 1,
		slidesToShow: 4,
		rows: 0,
		arrows: true,
		prevArrow: '<button class="slick-prev"><i class="jobcircle-icon-chevron-left"></i></button>',
		nextArrow: '<button class="slick-next"><i class="jobcircle-icon-chevron-right"></i></button>',
		dots: false,
		focusOnSelect: false,
		infinite: true,
		autoplay: true,
		responsive: [
			{
				breakpoint: 1200,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 1,
					arrows: false,
				},
		    },
		    {
				breakpoint: 992,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 1,
					arrows: false,
				},
		    },
		    {
				breakpoint: 768,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
					arrows: false,
				},
		    },
		    {
				breakpoint: 576,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					arrows: false,
				},
		    },
		],
	});

	jQuery('.recent_candidate_slider').slick({
		slidesToScroll: 1,
		slidesToShow: 4,
		rows: 0,
		arrows: false,
		dots: true,
		focusOnSelect: false,
		infinite: true,
		autoplay: true,
		responsive: [
			{
				breakpoint: 1200,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 1,
					arrows: false,
				},
		    },
		    {
				breakpoint: 992,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 1,
					arrows: false,
				},
		    },
		    {
				breakpoint: 768,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
					arrows: false,
				},
		    },
		    {
				breakpoint: 576,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					arrows: false,
				},
		    },
		],
	});

	jQuery('.client_testimonials_slider').slick({
		slidesToScroll: 1,
		slidesToShow: 3,
		rows: 0,
		arrows: true,
		prevArrow: '<button class="slick-prev"><i class="jobcircle-icon-chevron-left"></i></button>',
		nextArrow: '<button class="slick-next"><i class="jobcircle-icon-chevron-right"></i></button>',
		dots: false,
		centerMode:true,
		centerPadding:0,
		infinite: true,
		autoplay: false,
		responsive: [{
				breakpoint: 992,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
				},
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				},
			},
		],
	});

	jQuery('.leading_brands_slider').slick({
		slidesToScroll: 1,
		slidesToShow: 2,
		rows: 0,
		prevArrow: '<button class="slick-prev"><i class="jobcircle-icon-chevron-left"></i></button>',
		nextArrow: '<button class="slick-next"><i class="jobcircle-icon-chevron-right"></i></button>',
		dots: false,
		infinite: true,
		autoplay: false,
		responsive: [{
				breakpoint: 992,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				},
			},
			{
				breakpoint: 576,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				},
			},
		],
	});

	jQuery('.featured_candidate_slider').slick({
		slidesToScroll: 1,
		slidesToShow: 2,
		rows: 0,
		arrows: false,
		dots: true,
		infinite: true,
		autoplay: false,
		responsive: [{
				breakpoint: 992,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				},
			},
			{
				breakpoint: 576,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				},
			},
		],
	});
	
	jQuery('.jobs-carousel').slick({
		slidesToScroll: 1,
		slidesToShow: 1,
		rows: 0,
		arrows: false,
		dots: true,
		focusOnSelect: false,
		mobileFirst: true,
		infinite: true,
		autoplay: false,
		responsive: [{
				breakpoint: 991,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 1,
					arrows: false,
					dots: false
				},
			},
			{
				breakpoint: 767,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
					arrows: false,
					dots: false
				},
			},
			{
				breakpoint: 575,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					arrows: false,
				},
			},
		]
	});
	jQuery('.slick-prev').click(function(e) {
		jQuery('.jobs-carousel').slick('slickPrev');
	});

	jQuery('.slick-next').click(function(e) {
		jQuery('.jobs-carousel').slick('slickNext');
	});

	jQuery('.carousel-nav').slick({
		slidesToScroll: 1,
		slidesToShow: 1,
		rows: 0,
		arrows: true,
		dots: false,
		centerMode: true,
		centerPadding: '0px',
		prevArrow: '<button class="slick-prev"><i class="jobcircle-icon-chevron-left icon"></i></button>',
		nextArrow: '<button class="slick-next"><i class="jobcircle-icon-chevron-right icon"></i></button>',
		focusOnSelect: false,
		asNavFor: '.quotes-main',
		mobileFirst: true,
		infinite: true,
		autoplay: false,
		responsive: [{
				breakpoint: 991,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 1,
					dots: false
				},
			},
			{
				breakpoint: 767,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
					dots: false
				},
			},
			{
				breakpoint: 575,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				},
			},
		]
	});
	jQuery('.quotes-main').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: false,
		fade: true,
		asNavFor: '.carousel-nav'
	});

	jQuery('.news-carousel').slick({
		slidesToScroll: 1,
		slidesToShow: 1,
		rows: 0,
		arrows: false,
		dots: true,
		mobileFirst: true,
		focusOnSelect: false,
		infinite: true,
		autoplay: false,
		responsive: [{
				breakpoint: 767,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
				}
			},
			{
				breakpoint: 575,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				}
			},
		],
	});

	jQuery('.client-reviews-carousel').slick({
		slidesToScroll: 1,
		slidesToShow: 1,
		rows: 0,
		arrows: false,
		dots: true,
		mobileFirst: true,
		focusOnSelect: false,
		infinite: true,
		autoplay: false,
		responsive: [{
				breakpoint: 767,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
				}
			},
			{
				breakpoint: 575,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				}
			},
		],
	});
	jQuery('.slick-prev').click(function(e) {
		jQuery('.client-reviews-carousel').slick('slickPrev');
	});

	jQuery('.slick-next').click(function(e) {
		jQuery('.client-reviews-carousel').slick('slickNext');
	});

	jQuery('.customers-reviews-slider').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		rows: 0,
		arrows: false,
		autoplay: false,
	});

	jQuery('.slick-prev').click(function(e) {
		jQuery('.customers-reviews-slider').slick('slickPrev');
	});

	jQuery('.slick-next').click(function(e) {
		jQuery('.customers-reviews-slider').slick('slickNext');
	});

	// services carousel
	jQuery('.services-carousel').slick({
		slidesToScroll: 1,
		slidesToShow: 1,
		arrows: true,
		prevArrow: '<button class="slick-prev"><i class="jobcircle-icon-chevron-left icon"></i></button>',
		nextArrow: '<button class="slick-next"><i class="jobcircle-icon-chevron-right icon"></i></button>',
		dots: true,
		mobileFirst: true,
		focusOnSelect: false,
		infinite: true,
		autoplay: true,
		responsive: [{
				breakpoint: 1199,
				settings: {
					slidesToShow: 4,
					slidesToScroll: 1,
				}
			},
			{
				breakpoint: 991,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 1,
				}
			},
			{
				breakpoint: 575,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
				}
			},
			{
				breakpoint: 449,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				}
			},
		],
	});

	jQuery('.latest-jobs-carousel').slick({
		slidesToScroll: 1,
		slidesToShow: 1,
		arrows: false,
		dots: true,
		centerMode: true,
		centerPadding: '0px',
		mobileFirst: true,
		focusOnSelect: false,
		infinite: true,
		autoplay: true,
		responsive: [{
				breakpoint: 1200,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 1
				}
			},
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 1
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1
				}
			},
			{
				breakpoint: 576,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
				}
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				}
			},
		],
	});

	jQuery('.thumbs-list').slick({
		slidesToScroll: 1,
		slidesToShow: 4,
		arrows: false,
		dots: false,
		focusOnSelect: true,
		asNavFor: '.text-info-slider',
		mobileFirst: true,
		infinite: true,
		autoplay: true,
		responsive: [{
				breakpoint: 992,
				settings: {
					slidesToShow: 6,
					slidesToScroll: 1
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 6,
					slidesToScroll: 1
				}
			},
			{
				breakpoint: 576,
				settings: {
					slidesToShow: 6,
					slidesToScroll: 1
				}
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 4,
					slidesToScroll: 1
				}
			}
		]
	});
	jQuery('.text-info-slider').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: false,
		fade: true,
		autoplay: false,
		asNavFor: '.thumbs-list',
		vertical: false
	});

	jQuery('.companies-carousel').slick({
		slidesToScroll: 1,
		slidesToShow: 1,
		rows: 0,
		arrows: true,
		dots: true,
		centerMode: true,
		centerPadding: '0px',
		focusOnSelect: false,
		mobileFirst: true,
		infinite: true,
		autoplay: true,
		responsive: [{
				breakpoint: 1024,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 1,
					arrows: false,
				}
			},
			{
				breakpoint: 992,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
					arrows: false,
				}
			},
			{
				breakpoint: 576,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					arrows: false,
				}
			}
		],
	});

	
	jQuery('.trending-slider').slick({
		slidesToScroll: 1,
		slidesToShow: 4,
		rows: 0,
		arrows: true,
		prevArrow: '<button class="slick-prev"><i class="jobcircle-icon-arrow-right1 icon"></i></button>',
		nextArrow: '<button class="slick-next"><i class="jobcircle-icon-arrow-right1 icon"></i></button>',
		dots: true,
		focusOnSelect: false,
		infinite: true,
		autoplay: false,
		responsive: [
			{
				breakpoint: 1200,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 1,
					arrows: false,
				},
		    },
		    {
				breakpoint: 992,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 1,
					arrows: false,
				},
		    },
		    {
				breakpoint: 768,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
					arrows: false,
				},
		    },
		    {
				breakpoint: 576,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					arrows: false,
				},
		    },
		],
	});

	// featured jobs carousel
	jQuery('.featured-jobs-carousel').slick({
		slidesToScroll: 1,
		slidesToShow: 1,
		arrows: false,
		dots: true,
		mobileFirst: true,
		focusOnSelect: false,
		infinite: true,
		autoplay: true,
		responsive: [{
				breakpoint: 1199,
				settings: {
					slidesToShow: 4,
					slidesToScroll: 1,
				}
			},
			{
				breakpoint: 991,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 1,
				}
			},
			{
				breakpoint: 575,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
				}
			},
			{
				breakpoint: 449,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				}
			},
		],
	});

	// companies remote slider
	jQuery('.companies-remote-carousel').slick({
		slidesToScroll: 1,
		slidesToShow: 3,
		rows: 0,
		arrows: true,
		prevArrow: '<button class="slick-prev"><i class="jobcircle-icon-chevron-left"></i></button>',
		nextArrow: '<button class="slick-next"><i class="jobcircle-icon-chevron-right"></i></button>',
		dots: true,
		centerMode: true,
		centerPadding: '0px',
		focusOnSelect: false,
		infinite: true,
		autoplay: true,
		responsive: [
		    {
				breakpoint: 992,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
					arrows: false,
				},
		    },
		    {
				breakpoint: 576,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					arrows: false,
				},
		    },
		],
	});

	// Quotes carousel
	jQuery('.quotes-carousel').slick({
		slidesToScroll: 1,
		slidesToShow: 1,
		arrows: false,
		dots: true,
		fade: true,
		focusOnSelect: false,
		infinite: true,
		autoplay: true
	});

	// trending jobs slider
	jQuery('.trending-jobs-carousel').slick({
		slidesToScroll: 1,
		slidesToShow: 1,
		rows: 0,
		arrows: false,
		dots: true,
		centerMode: true,
		centerPadding: '0px',
		mobileFirst: true,
		focusOnSelect: false,
		infinite: true,
		autoplay: true,
		responsive: [
		    {
				breakpoint: 1024,
				settings: {
					slidesToShow: 4,
					slidesToScroll: 1,
					arrows: false,
				}
		    },
		    {
				breakpoint: 992,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 1,
					arrows: false,
				}
		    },
		    {
				breakpoint: 768,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 1,
					arrows: false,
				}
		    },
		    {
				breakpoint: 576,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
					arrows: false,
				}
		    },
		    {
				breakpoint: 486,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					arrows: false,
				}
		    }
		]
	});

	// clients testimonials slider
	jQuery('.clients-testimonials-slider').slick({
		slidesToScroll: 1,
		slidesToShow: 1,
		rows: 0,
		arrows: false,
		dots: true,
		mobileFirst: true,
		focusOnSelect: false,
		infinite: true,
		autoplay: true,
		responsive: [
		    {
				breakpoint: 576,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
					arrows: false,
				}
		    },
		    {
				breakpoint: 486,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					arrows: false,
				}
		    }
		]
	});
}

// select2 init
function initSelect2() {
	jQuery('.select2').select2({
		minimumResultsForSearch: -1,
		// placeholder: 'Select an option'
	});
}
  
// Fancybox init
function initFancybox() {
	jQuery('a.lightbox, [data-fancybox]').fancybox();
}

// StickyHeader init
function initStickyHeader() {
	jQuery(window).scroll(function () {
		var scroll = jQuery(window).scrollTop();
		if (scroll >= 1) {
			jQuery("body").addClass("sticky-header");
		} else {
			jQuery("body").removeClass("sticky-header");
		}
	});
}

// MobileNav init
function initMobileNav() {
	jQuery('.nav-opener').click(function (e) {
		e.preventDefault();

		if(jQuery('body').hasClass('nav-active')) {
			jQuery('body').removeClass('nav-active');
		}
		else {
			jQuery('body').addClass('nav-active');
		}
	});

	jQuery('.nav-close').click(function (e) {
		e.preventDefault();

		if(jQuery('body').hasClass('nav-active')) {
			jQuery('body').removeClass('nav-active');
		}
	});
}

// Resize Effect function
function initResizeEffect() {
	jQuery(window).resize(function () {
		if(jQuery(window).width() > 991) {
			jQuery('body').removeClass('nav-active');
		}
	});
}

// Price Range function
function initPriceRange() {
	$("#slider-range").slider({
		range: true,
		min: 0,
		max: 100000,
		step: 5000,
		values: [0, 100000],
		slide: function(event, ui) {
		  $("#amount-start").val("$ " + ui.values[0]);
		  $("#amount-end").val("$ " + ui.values[1]);
		}
	  });
	  
	  $("#amount-start").val("$ " + $("#slider-range").slider("values", 0));
	  $("#amount-end").val("$ " + $("#slider-range").slider("values", 1));
}


// Custom Functions
function initCustomFunctions() {
	// Checkbox Limit Function
	jQuery('.buttonShowMore').click(function (e) {
		e.preventDefault();

		if(jQuery('.checkbox-limit').hasClass('options-active')) {
			jQuery('.checkbox-limit').removeClass('options-active');
		}
		else {
			jQuery('.checkbox-limit').addClass('options-active');
		}
	});
	jQuery('.creatalert').click(function (e) {
		e.preventDefault();

		if(jQuery('.checkbox-creat-alert').hasClass('options-active')) {
			jQuery('.checkbox-creat-alert').removeClass('options-active');
		}
		else {
			jQuery('.checkbox-creat-alert').addClass('options-active');
		}
	});

	// Filters Hide Show for Mobile Function
	jQuery('.filters-opener').click(function (e) {
		e.preventDefault();

	if(jQuery('.filters-sidebar').hasClass('filters-active')) {
			jQuery('.filters-sidebar').removeClass('filters-active');
			jQuery('body').removeClass('filters-show');
			jQuery('.filters-opener').removeClass('opener-active');
		}
		else {
			jQuery('.filters-sidebar').addClass('filters-active');
			jQuery('body').addClass('filters-show');
			jQuery('.filters-opener').addClass('opener-active');
		}
	});
}

$window = jQuery(window);
$slick_slider = jQuery('.candidate-carousel');
settings = {
	slidesToScroll: 1,
	slidesToShow: 1,
	rows: 0,
	arrows: false,
	dots: true,
	focusOnSelect: false,
	mobileFirst: true,
	infinite: true,
	autoplay: true,
	responsive: [{
			breakpoint: 991,
			settings: "unslick"
		},
		{
			breakpoint: 768,
			settings: {
				slidesToShow: 3,
				slidesToScroll: 1,
				arrows: false
			}
		},
		{
			breakpoint: 480,
			settings: {
				slidesToShow: 2,
				slidesToScroll: 1,
				arrows: false
			}
		},
		{
			breakpoint: 375,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
				arrows: false
			}
		}
	]
};
$slick_slider.slick(settings);

jQuery(window).on('resize', function() {
	if (jQuery(window).width() > 991) {
		if ($slick_slider.hasClass('slick-initialized')) {
			$slick_slider.slick('unslick');
		}
		return
	}
	if (!$slick_slider.hasClass('slick-initialized')) {
		return $slick_slider.slick(settings);
	}
});

$articles_slider = jQuery('.acticles-carousel, .acticles-slider');
settings = {
	slidesToScroll: 1,
	slidesToShow: 1,
	rows: 0,
	arrows: false,
	dots: true,
	focusOnSelect: false,
	mobileFirst: true,
	infinite: true,
	autoplay: true,
	responsive: [{
			breakpoint: 1024,
			settings: "unslick"
		},
		{
			breakpoint: 992,
			settings: {
				slidesToShow: 3,
				slidesToScroll: 1,
				arrows: false
			}
		},
		{
			breakpoint: 576,
			settings: {
				slidesToShow: 2,
				slidesToScroll: 1,
				arrows: false
			}
		},
		{
			breakpoint: 375,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
				arrows: false
			}
		}
	]
};
$articles_slider.slick(settings);

jQuery(window).on('resize', function() {
	if (jQuery(window).width() > 991) {
		if ($articles_slider.hasClass('slick-initialized')) {
			$articles_slider.slick('unslick');
		}
		return
	}
	if (!$articles_slider.hasClass('slick-initialized')) {
		return $articles_slider.slick(settings);
	}
});


$news_articles_slider = jQuery('.news-acticles-carousel');
settings = {
	slidesToScroll: 1,
	slidesToShow: 1,
	rows: 0,
	arrows: false,
	dots: true,
	focusOnSelect: false,
	mobileFirst: true,
	infinite: true,
	autoplay: true,
	responsive: [{
			breakpoint: 1024,
			settings: "unslick"
		},
		{
			breakpoint: 992,
			settings: {
				slidesToShow: 3,
				slidesToScroll: 1,
				arrows: false
			}
		},
		{
			breakpoint: 576,
			settings: {
				slidesToShow: 2,
				slidesToScroll: 1,
				arrows: false
			}
		},
		{
			breakpoint: 375,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
				arrows: false
			}
		}
	]
};
$news_articles_slider.slick(settings);

jQuery(window).on('resize', function() {
	if (jQuery(window).width() > 991) {
		if ($news_articles_slider.hasClass('slick-initialized')) {
			$news_articles_slider.slick('unslick');
		}
		return
	}
	if (!$news_articles_slider.hasClass('slick-initialized')) {
		return $news_articles_slider.slick(settings);
	}
});