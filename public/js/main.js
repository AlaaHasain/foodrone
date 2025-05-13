$(document).ready(function(){

  // Initialize Owl Carousel
  $('.owl-carousel').owlCarousel({
    loop: true,
    margin: 10,
    nav: true,
    dots: false,
    autoplay: true,
    autoplayTimeout: 3000,
    items: 1
  });

  // Initialize Bootstrap Carousel
  $('#customCarousel1').carousel({
    interval: 3000, // ينتقل كل ثانية
    ride: 'carousel',
    pause: false
  });

  // Initialize Isotope for menu filtering
  var $grid = $('.grid').isotope({
    itemSelector: '.all',
    layoutMode: 'fitRows'
  });

  $('.filters_menu li').click(function(){
    $('.filters_menu li').removeClass('active');
    $(this).addClass('active');

    var filterValue = $(this).attr('data-filter');
    $grid.isotope({ filter: filterValue });
  });

  // Initialize Nice Select
  $('select').niceSelect();

});






