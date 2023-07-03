(function ($) {
  "user strict";

  // preloader
  $(".preloader").delay(800).animate({
    "opacity": "0"
  }, 800, function () {
      $(".preloader").css("display", "none");
  });

  // chosen-select
  var config = {
    '.chosen-select': {},
    '.chosen-select-deselect': { allow_single_deselect: true },
    '.chosen-select-no-single': { disable_search_threshold: 10 },
    '.chosen-select-no-results': { no_results_text: 'Oops, nothing found!' },
    '.chosen-select-width': { width: "95%" }
  }
  for (var selector in config) {
    jQuery(selector).chosen(config[selector]);
  }

// wow
if ($('.wow').length) {
  var wow = new WOW({
    boxClass: 'wow',
    // animated element css class (default is wow)
    animateClass: 'animated',
    // animation css class (default is animated)
    offset: 0,
    // distance to the element when triggering the animation (default is 0)
    mobile: false,
    // trigger animations on mobile devices (default is true)
    live: true // act on asynchronously loaded content (default is true)
  });
  wow.init();
}

//Create Background Image
(function background() {
  let img = $('.bg_img');
  img.css('background-image', function () {
    var bg = ('url(' + $(this).data('background') + ')');
    return bg;
  });
})();

// navbar-click
$(".navbar li a").on("click", function () {
  var element = $(this).parent("li");
  if (element.hasClass("show")) {
    element.removeClass("show");
    element.find("li").removeClass("show");
  }
  else {
    element.addClass("show");
    element.siblings("li").removeClass("show");
    element.siblings("li").find("li").removeClass("show");
  }
});


// scroll-to-top
var ScrollTop = $(".scrollToTop");
$(window).on('scroll', function () {
  if ($(this).scrollTop() < 500) {
      ScrollTop.removeClass("active");
  } else {
      ScrollTop.addClass("active");
  }
});

//slider
var swiper = new Swiper('.category-slider', {
  slidesPerView: 1,
  spaceBetween: 30,
  navigation: {
    nextEl: '.slider-next',
    prevEl: '.slider-prev',
  },
  autoplay: {
    speed: 1000,
    delay: 3000,
  },
  speed: 1000,
  breakpoints: {
    1200: {
      slidesPerView: 4,
    },
    992: {
      slidesPerView: 3,
    },
    768: {
      slidesPerView: 2,
    }
  }
});

     
   
// ui-js
$("#slider-range").slider({
  range: true,
  min: 1.00,
  max: 999.00,
  values: [1.00, 999.00],
  slide: function (event, ui) {
    $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
    $('input[name=min_price]').val(ui.values[0]);
    $('input[name=max_price]').val(ui.values[1]);
  },
  change: function () {
    var brand = [];
    var min = $('input[name="min_price"]').val();
    var max = $('input[name="max_price"]').val();
    $('.brand-filter input:checked').each(function () {
      brand.push(parseInt($(this).attr('value')));
    });
  }
});

$("#amount").val("$" + $("#slider-range").slider("values", 0) + " - $" + $("#slider-range").slider("values", 1));

// grid and list view 
$(".list-btn").each(function () {
  $(this).on('click', function () {
    // add active class with "list-btn"
    var element = $(this).parent("li");
    if (element.hasClass("active")) {
      element.find("li").removeClass("active");
    }
    else {
      element.addClass("active");
      element.siblings("li").removeClass("active");
      element.siblings("li").find("li").removeClass("active");
    }
  });
});

// grid-view-btn
// list-view-btn
$('.grid-view-btn').on('click', function () {
  $('.item-card-wrapper').addClass('grid-view').removeClass('list-view');
})

$('.list-view-btn').on('click', function () {
  $('.item-card-wrapper').addClass('list-view').removeClass('grid-view');
})

// footer-toggle
$('.footer-toggle').on('click', function (e) {
  var element = $(this).parent('.footer-wrapper');
  if (element.hasClass('open')) {
    element.removeClass('open');
    element.find('.footer-bottom-area').removeClass('open');
    element.find('.footer-bottom-area').slideUp(300, "swing");
  } else {
    element.addClass('open');
    element.children('.footer-bottom-area').slideDown(300, "swing");
    element.siblings('.footer-wrapper').children('.footer-bottom-area').slideUp(300, "swing");
    element.siblings('.footer-wrapper').removeClass('open');
    element.siblings('.footer-wrapper').find('.footer-toggle').removeClass('open');
    element.siblings('.footer-wrapper').find('.footer-bottom-area').slideUp(300, "swing");
  }
});

// short-menu
var shortMenu = $('.short-menu');
$('.short-menu-open-btn').on('click', function () {
  shortMenu.addClass('open');
});
$('.short-menu-close-btn').on('click', function () {
  shortMenu.removeClass('open');
});

// sidebar
$(".has-sub > a").on("click", function () {
  var element = $(this).parent("li");
  if (element.hasClass("active")) {
    element.removeClass("active");
    element.children("ul").slideUp(500);
  }
  else {
    element.siblings("li").removeClass('active');
    element.addClass("active");
    element.siblings("li").find("ul").slideUp(500);
    element.children('ul').slideDown(500);
  }
});

//dashboard-sidebar
var dashboardSidebar = $('.dashboard-sidebar');
$('.dashboard-sidebar-open').on('click', function () {
  dashboardSidebar.addClass('open');
});
$('.dashboard-sidebar-close').on('click', function () {
  dashboardSidebar.removeClass('open');
});

//upload
function proPicURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      var preview = $(input).parents('.thumb').find('.profilePicPreview');
      $(preview).css('background-image', 'url(' + e.target.result + ')');
      $(preview).addClass('has-image');
      $(preview).hide();
      $(preview).fadeIn(650);
    }
    reader.readAsDataURL(input.files[0]);
  }
}
$(".profilePicUpload").on('change', function () {
  proPicURL(this);
});

$(".remove-image").on('click', function () {
  $(this).parents(".profilePicPreview").css('background-image', 'none');
  $(this).parents(".profilePicPreview").removeClass('has-image');
  $(this).parents(".thumb").find('input[type=file]').val('');
});


$('.reply-btn').each(function(){
  $(this).on('click', function() {
    $(this).siblings('.reply-form-area').slideToggle();
  });
});
  

})(jQuery);