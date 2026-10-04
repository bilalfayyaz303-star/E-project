'use strict';

(function ($) {
    $(window).on('load', function () {
        $(".loader").fadeOut();
        $("#preloder").delay(200).fadeOut("slow");
    });

    $('.set-bg').each(function () {
        var bg = $(this).data('setbg');
        if (bg) {
            $(this).css('background-image', 'url(' + bg + ')');
        }
    });

    if ($.fn.slicknav && $('.mobile-menu').length) {
        $(".mobile-menu").slicknav({
            prependTo: '#mobile-menu-wrap',
            allowParentLinks: true
        });
    }

    if ($.fn.owlCarousel && $('.event__slider').length) {
        $(".event__slider").owlCarousel({
            loop: true,
            margin: 0,
            items: 3,
            dots: false,
            nav: true,
            navText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
            smartSpeed: 1200,
            autoHeight: false,
            autoplay: true,
            responsive: {
                992: { items: 3 },
                768: { items: 2 },
                0: { items: 1 }
            }
        });
    }

    if ($.fn.owlCarousel && $('.videos__slider').length) {
        $(".videos__slider").owlCarousel({
            loop: true,
            margin: 0,
            items: 4,
            dots: false,
            nav: true,
            navText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
            smartSpeed: 1200,
            autoHeight: false,
            autoplay: true,
            responsive: {
                992: { items: 4 },
                768: { items: 3 },
                576: { items: 2 },
                0: { items: 1 }
            }
        });
    }

    if ($.fn.magnificPopup && $('.video-popup').length) {
        $('.video-popup').magnificPopup({
            type: 'iframe'
        });
    }

    if ($.fn.countdown && $('#countdown-time').length) {
        var targetDate = new Date();
        targetDate.setDate(targetDate.getDate() + 14);
        var targetDateString = (targetDate.getMonth() + 1) + '/' + targetDate.getDate() + '/' + targetDate.getFullYear();

        $("#countdown-time").countdown(targetDateString, function (event) {
            $(this).html(event.strftime(
                "<div class='countdown__item'><span>%D</span> <p>Days</p> </div>" +
                "<div class='countdown__item'><span>%H</span> <p>Hours</p> </div>" +
                "<div class='countdown__item'><span>%M</span> <p>Minutes</p> </div>" +
                "<div class='countdown__item'><span>%S</span> <p>Seconds</p> </div>"
            ));
        });
    }

    if ($.fn.barfiller) {
        if ($('#bar1').length) $('#bar1').barfiller({ barColor: "#ffffff" });
        if ($('#bar2').length) $('#bar2').barfiller({ barColor: "#ffffff" });
        if ($('#bar3').length) $('#bar3').barfiller({ barColor: "#ffffff" });
    }

    if ($.fn.niceScroll && $('.nice-scroll').length) {
        $(".nice-scroll").niceScroll({
            cursorcolor: "#111111",
            cursorwidth: "5px",
            background: "#e1e1e1",
            cursorborder: "",
            autohidemode: false,
            horizrailenabled: false
        });
    }
})(jQuery);