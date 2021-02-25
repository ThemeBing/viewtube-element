(function($) {
    "use strict";

    // Mega menu button
    $(function() {
        $('.dropdown-mega-menu-toggle').on('hover', function(event) {
            event.preventDefault();

            const dropdown = $(this).closest('.menu-item');

            if (dropdown.is('.open')) {
                dropdown.removeClass('open');
            } else {
                dropdown.addClass('open');
            }
        });

        $('.mega-menu-content').on('mouseenter', function(event) {
            $(this).closest('.menu-item').addClass('open');
        });

        $('.mega-menu-content').on('mouseleave', function(event) {
            $(this).closest('.menu-item').removeClass('open');
        });
    });

    // Slick RTL Support
    function rtl_slick() {
        if ($('body').hasClass("rtl")) {
            return true;
        } else {
            return false;
        }
    }

    // product items
    $('.banners').slick({
        arrows: true,
        infinite: true,
        autoplay: true,
        autoplaySpeed: 2000,
        infinite: true,
        speed: 2000,
        fade: true,
        rtl: rtl_slick(),
        "slidesToShow": 1,
        "slidesToScroll": 1,
        nextArrow: '<i class="fas fa-chevron-right"></i>',
        prevArrow: '<i class="fas fa-chevron-left"></i>'
    });

    // product items
    $('.video-items').slick({
        arrows: true,
        infinite: true,
        rtl: rtl_slick(),
        "slidesToShow": 3,
        "slidesToScroll": 3,
        "responsive": [{
                "breakpoint": 1200,
                "settings": {
                    "slidesToShow": 3,
                    "slidesToScroll": 3
                }
            },
            {
                "breakpoint": 1024,
                "settings": {
                    "slidesToShow": 2,
                    "slidesToScroll": 2
                }
            },
            {
                "breakpoint": 600,
                "settings": {
                    "slidesToShow": 1,
                    "slidesToScroll": 1
                }
            }
        ],
        nextArrow: '<i class="fas fa-chevron-right"></i>',
        prevArrow: '<i class="fas fa-chevron-left"></i>'
    });

    // product items tab
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        $('.product-items').slick('setPosition');
    });

    // Countdown
    $('[data-date]').each(function(i, obj) {

        var CounterID = '#' + this.id;
        // Countdown
        var countDownDate = new Date($(this).data('date')).getTime();

        // Update the count down every 1 second
        var x = setInterval(function() {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            $(CounterID).html(`
            <div class="countdown-date">
                <span>${hours}</span> <b>:</b> <span>${minutes}</span> <b>:</b> <span>${seconds}</span>
            </div>
            `);

            // If the count down is finished, write some text
            if (distance < 0) {
                clearInterval(x);
                $(CounterID).html("EXPIRED");
            }
        }, 1000);
    });

    // Elementor front-end
    $(window).on('elementor/frontend/init', function() {

        elementorFrontend.hooks.addAction('frontend/element_ready/banner.default', function($scope, $) {

            $scope.find('.banners').not('.slick-initialized').slick({
                arrows: true,
                infinite: true,
                "slidesToShow": 1,
                "slidesToScroll": 1,
                nextArrow: '<i class="fas fa-chevron-right"></i>',
                prevArrow: '<i class="fas fa-chevron-left"></i>'
            });

        });

        elementorFrontend.hooks.addAction('frontend/element_ready/video.default', function($scope, $) {

            $scope.find('.video-items').not('.slick-initialized').slick({
                arrows: true,
                infinite: true,
                "slidesToShow": 4,
                "slidesToScroll": 4,
                nextArrow: '<i class="fas fa-chevron-right"></i>',
                prevArrow: '<i class="fas fa-chevron-left"></i>'
            });

        });

    });

})(jQuery);