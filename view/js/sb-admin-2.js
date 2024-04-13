//Cuando el Documento este cargado
$(document).ready(function(){
  if($(window).width()<768){
    $('#content-wrapper').css('margin-left','6.5rem');
    $('.navbar').css('width','calc(100% - 6.5rem)');
  }else{
    $('#content-wrapper').css('margin-left','14rem');
    $('.navbar').css('width','calc(100% - 14rem)');
  }
});

(function($) {
  let num = 1;
  "use strict"; 
  //Cuando se adapte la pantalla a dispositivos moviles
  $(window).resize(function() {
    if($(window).width()<768){
      if(num==1){
        $('#content-wrapper').css('margin-left','6.5rem');
        $('.navbar').css('width','calc(100% - 6.5rem)');
      }else{
        $('#content-wrapper').css('margin-left','0');
        $('.navbar').css('width','100%');
      }
    }else{
      if(num==1){
        $('#content-wrapper').css('margin-left','14rem');
        $('.navbar').css('width','calc(100% - 14rem)');
      }else{
        $('#content-wrapper').css('margin-left','6.5rem');
        $('.navbar').css('width','calc(100% - 6.5rem)');
      }
    }
  });
  // Toogled del sidebar de navegacion
    $("#sidebarToggleTop").on('click', function(e) {
    $("body").toggleClass("sidebar-toggled");
    $(".sidebar").toggleClass("toggled");
    if ($(".sidebar").hasClass("toggled")) {
      $('.sidebar .collapse').collapse('hide');
    };
  });

  // Close any open menu accordions when window is resized below 768px
  $(window).resize(function() {
    if ($(window).width() < 768) {
      $('.sidebar .collapse').collapse('hide');
      $('#content-wrapper').addClass('.margin-mod');
    };
  });
  
  $('#sidebarToggleTop').click(function(){
    if($(window).width()>768){
      //Si la pantalla es de ordenador
      if (num==1){
        $('#content-wrapper').css('margin-left','6.5rem');
        $('.navbar').css('width','calc(100% - 6.5rem)');
        num = 0;
        if($(window).width()<768){
          $('#content-wrapper').css('margin-left','0');
          $('.navbar').css('width','calc(100% - 6.5rem)')
        };
      }else{
        $('#content-wrapper').css('margin-left','14rem');
        $('.navbar').css('width','calc(100% - 14rem)');
        num = 1;
        if($(window).width()<768){
          $('#content-wrapper').css('margin-left','6.5rem');
        }
      }
    }else{
      //Si la pantalla es de movil
      if (num==1){
        $('#content-wrapper').css('margin-left','6.5rem');
        $('.navbar').css('width','100%');
        num = 0;
        if($(window).width()<768){
          $('#content-wrapper').css('margin-left','0');
        }
      }else{
        $('#content-wrapper').css('margin-left','14rem');
        $('.navbar').css('width','calc(100% - 6.5rem)');
        num = 1;
        if($(window).width()<768){
          $('#content-wrapper').css('margin-left','6.5rem');
        }
      }
    }
  });
  // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
  $('body.fixed-nav .sidebar').on('mousewheel DOMMouseScroll wheel', function(e) {
    if ($(window).width() > 768) {
      var e0 = e.originalEvent,
        delta = e0.wheelDelta || -e0.detail;
      this.scrollTop += (delta < 0 ? 1 : -1) * 30;
      e.preventDefault();
    }
  });

  // Scroll to top button appear
  $(document).on('scroll', function() {
    var scrollDistance = $(this).scrollTop();
    if (scrollDistance > 100) {
      $('.scroll-to-top').fadeIn();
    } else {
      $('.scroll-to-top').fadeOut();
    }
  });

  // Smooth scrolling using jQuery easing
  $(document).on('click', 'a.scroll-to-top', function(e) {
    var $anchor = $(this);
    $('html, body').stop().animate({
      scrollTop: ($($anchor.attr('href')).offset().top)
    }, 1000, 'easeInOutExpo');
    e.preventDefault();
  });

})(jQuery); // End of use strict
