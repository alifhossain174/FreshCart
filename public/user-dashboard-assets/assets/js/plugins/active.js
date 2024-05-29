(function ($) {
  "use strict";
  $(document).on("ready", function () {
    /*=====================
      Nice Select JS
    ==========================*/
    $("select").niceSelect();

    /*=====================
      Header Sticky JS
    ==========================*/
    $(window).scroll(function () {
      if ($(this).scrollTop() > 100) {
        $("header").addClass("active");
      } else {
        $("header").removeClass("active");
      }
    });

    /*=====================
      Tap to Top js
    ==========================*/
    $(document).ready(function () {
      $(window).scroll(function () {
        if ($(this).scrollTop() > 50) {
          $(".back-to-top").fadeIn();
        } else {
          $(".back-to-top").fadeOut();
        }
      });
      // scroll body to 0px on click
      $(".back-to-top").click(function () {
        $("body,html").animate(
          {
            scrollTop: 0,
          },
          400
        );
        return false;
      });
    });
  });
})(jQuery);
