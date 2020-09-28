import Scrollbar from "smooth-scrollbar";

export default function () {
}

window.jQuery = window.$ = require('jquery');

(function ($) {
    "use strict";

    // NEW selector
    jQuery.expr[':'].Contains = function (a, i, m) {
        return jQuery(a).text().toUpperCase()
            .indexOf(m[3].toUpperCase()) >= 0;
    };

    $(document).on("click", '[data-toggle="lightbox"]', function (event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });

    $(document).ready(function () {
        $(".news_slider").slick({
            dots: false,
            infinite: true,
            centerMode: true,
            slidesToShow: 3,
            slidesToScroll: 1,
            centerPadding: '150px',
            draggable: false,
            speed: 1200,
            autoplaySpeed: 5000,
            adaptiveHeight: false,
            autoplay: true,
            variableWidth: false,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: true,
                        centerPadding: '50px',
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        centerPadding: '150px',
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        centerPadding: '30px',
                    }
                }
            ]
        });
    });

    $(document).ready(function () {
        $(".actions_slider").slick({
            dots: false,
            infinite: true,
            centerMode: true,
            slidesToShow: 3,
            slidesToScroll: 1,
            centerPadding: '150px',
            draggable: false,
            speed: 1200,
            autoplaySpeed: 5000,
            adaptiveHeight: false,
            autoplay: true,
            variableWidth: false,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: true,
                        centerPadding: '50px',
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        centerPadding: '150px',
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        centerPadding: '30px',
                    }
                }
            ]
        });
    });

    $(window).on('load', function () {
        // fullpage slider

        $(".c-slider-init").slick({
            dots: false,
            nav: false,
            // arrows: false,
            infinite: true,
            speed: 1200,
            autoplaySpeed: 5000,
            slidesToShow: 1,
            adaptiveHeight: false,
            autoplay: true,
            draggable: false,
            pauseOnFocus: false,
            pauseOnHover: false,
            prevArrow: '.c-slider .prev-arrow',
            nextArrow: '.c-slider .next-arrow'
        });

        $(".slick-current").addClass("initialAnimation");

        let transitionSetup = {
            target: ".slick-list",
            enterClass: "u-scale-out",
            doTransition: function () {
                var slideContainer = document.querySelector(this.target);
                slideContainer.classList.add(this.enterClass);
                $(".slick-current").removeClass("animateIn");
            },
            exitTransition: function () {
                var slideContainer = document.querySelector(this.target);
                setTimeout(() => {
                    slideContainer.classList.remove(this.enterClass);
                    $(".slick-current").addClass("animateIn");
                }, 2000);
            }
        };

        var i = 0;
        // On before slide change
        $(".c-slider-init").on("beforeChange", function (
            event,
            slick,
            currentSlide,
            nextSlide
        ) {
            if (i == 0) {
                event.preventDefault();
                transitionSetup.doTransition();
                i++;
            } else {
                i = 0;
                transitionSetup.exitTransition();
            }

            $(".c-slider-init").slick("slickNext");
            $(".slick-current").removeClass("initialAnimation");
        });
    });

    $(document).ready(function () {

        /*
    variables slick slider
                    */

        var $imagesSlider = $(".gallery-slider .gallery-slider__images>div"),
            $thumbnailsSlider = $(".gallery-slider__thumbnails>div");

        /*
            sliders
        */

        // images options
        $imagesSlider.slick({
            speed: 300,
            slidesToShow: 1,
            slidesToScroll: 1,
            cssEase: 'linear',
            fade: true,
            draggable: false,
            asNavFor: ".gallery-slider__thumbnails>div",
            prevArrow: '.gallery-slider__images .prev-arrow',
            nextArrow: '.gallery-slider__images .next-arrow'
        });

        // thumbnails options
        $thumbnailsSlider.slick({
            speed: 300,
            slidesToShow: 5,
            slidesToScroll: 1,
            cssEase: 'linear',
            centerMode: true,
            draggable: false,
            focusOnSelect: true,
            asNavFor: ".gallery-slider .gallery-slider__images>div",
            prevArrow: '.gallery-slider__thumbnails .prev-arrow',
            nextArrow: '.gallery-slider__thumbnails .next-arrow',
            responsive: [
                {
                    breakpoint: 720,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 4
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 350,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                }
            ]
        });

        /*
            captions
        */

        var $caption = $('.gallery-slider .caption');

        // get the initial caption text
        var captionText = $('.gallery-slider__images .slick-current img').attr('alt');
        updateCaption(captionText);

        // hide the caption before the image is changed
        $imagesSlider.on('beforeChange', function (event, slick, currentSlide, nextSlide) {
            $caption.addClass('hide');
        });

        // update the caption after the image is changed
        $imagesSlider.on('afterChange', function (event, slick, currentSlide, nextSlide) {
            captionText = $('.gallery-slider__images .slick-current img').attr('alt');
            updateCaption(captionText);
        });

        function updateCaption(text) {
            // if empty, add a no breaking space
            if (text === '') {
                text = '&nbsp;';
            }
            $caption.html(text);
            $caption.removeClass('hide');
        }
    });


    /* ..............................................
    Loader
    ................................................. */

    $(window).on('load', function () {
        $('.preloader').fadeOut();
        $('#preloader').delay(550).fadeOut('slow');
        $('body').delay(450).css({'overflow': 'visible'});
    });

    /* ..............................................
    Navbar Bar
    ................................................. */

    $('.navbar-nav .nav-link').on('click', function () {
        var toggle = $('.navbar-toggler').is(':visible');
        if (toggle) {
            $('.navbar-collapse').collapse('hide');
        }
    });

    $('.navbar-nav li a').click(function () {
        $('li a').removeClass("active");
        $(this).addClass("active");
    });


    /* ..............................................
    Fixed Menu
    ................................................. */

    $(window).on('scroll', function () {
        if ($(window).scrollTop() > 50) {
            $('.top_header').addClass('fixed-menu');
        } else {
            $('.top_header').removeClass('fixed-menu');
        }
    });

    /* ..............................................
    Scroll To Top
    ................................................. */

    $(document).ready(function () {

        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('#scroll-to-top').fadeIn();
            } else {
                $('#scroll-to-top').fadeOut();
            }
        });

        $('#scroll-to-top').click(function () {
            $("html, body").animate({
                scrollTop: 0
            }, 600);
            return false;
        });

    });

    $(document).ready(function () {
        var searchEvent;
        var  debounceSearchFunction  =  function (searchWord, delay) {
            clearTimeout(searchEvent)

            // Executes the func after delay time.
            searchEvent  =  setTimeout(function(){
                $('.post-entry-1').parent().parent().fadeOut(500);
                $('.post-entry-1 h2:Contains("' + searchWord + '")').parent().parent().parent().parent().fadeIn(500);
            }, delay)
        }
        $('#shopSelect').on('change', function () {
            window.location = this.value;
        });
        $('#searchShopName').on('input', function () {
            var searchWord = $('#searchShopName').val();
            debounceSearchFunction(searchWord, 700);
        });
    });
}(jQuery));

