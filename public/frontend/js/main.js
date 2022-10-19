/*price range*/

$("#sl2").slider();

var RGBChange = function() {
    $("#RGB").css(
        "background",
        "rgb(" + r.getValue() + "," + g.getValue() + "," + b.getValue() + ")"
    );
};

/*scroll to top*/

$(document).ready(function() {
    $(function() {
        $.scrollUp({
            scrollName: "scrollUp", // Element ID
            scrollDistance: 300, // Distance from top/bottom before showing element (px)
            scrollFrom: "top", // 'top' or 'bottom'
            scrollSpeed: 300, // Speed back to top (ms)
            easingType: "linear", // Scroll to top easing (see http://easings.net/)
            animation: "fade", // Fade, slide, none
            animationSpeed: 200, // Animation in speed (ms)
            scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
            //scrollTarget: false, // Set a custom target element for scrolling to the top
            scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
            scrollTitle: false, // Set a custom <a> title if required.
            scrollImg: false, // Set true to use image
            activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
            zIndex: 2147483647 // Z-Index for the overlay
        });
    });
});

$("#product-carousel").carousel({
    interval: false
});

$(function() {
    var positionTop = 0;
    $(document).scroll(function() {
        if ($(".maintain").height() > $(".left-sidebar").height()) {
            if (
                ($(window).scrollTop() + $(window).height() >= $("#slider-carousel").position().top) &&
                ($(window).scrollTop() < $("#slider-carousel").position().top + $("#slider-carousel").height())
            ) {
                $(".left-sidebar").css("position", "relative");
                $(".left-sidebar").css("top", 0);
                $(".left-sidebar").css("padding", "0");
                
            } else {
                $(".left-sidebar").css("position", "absolute");
                $(".left-sidebar").css(
                    "top",
                    $(window).scrollTop() - ($("#slider-carousel").position().top + $("#slider-carousel").height()) - 5
                );
                $(".left-sidebar").css("padding", "0 15px");
                $(".left-sidebar").css("left", 0);
                $(".left-sidebar").css("width", "100%");
                $(".left-sidebar")
                    .parent("div")
                    .css("position", "relative");
    
                    if (
                        ($(window).scrollTop() + $(window).height()) - ($("#main").position().top + $("#main").height()) < 10
                    ) {
                        positionTop =   $(window).scrollTop() - ($("#slider-carousel").position().top + $("#slider-carousel").height())
                    }
            
                    if (
                        ($(window).scrollTop() + $(window).height()) - ($("#main").position().top + $("#main").height()) > 10
                    ) {
                        $(".left-sidebar").css("top", positionTop);
                    }
            }
        } else {
            $(".left-sidebar").css("position", "relative");
            $(".left-sidebar").css("top", 0);
            $(".left-sidebar").css("padding", "0");
        }
    });
});
