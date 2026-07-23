// passive listener
// jQuery.event.special.touchstart = {
//   setup: function( _, ns, handle ){
//     this.addEventListener("touchstart", handle, { passive: true });
//   }
// };

// rolling start!
$(function(){
  if ('ontouchstart' in window || 'ontouch' in window) {
    $('body').addClass('touch');
  }

  // hamburger action
  $(document).on('click', '.hamburger', function(){
    $(this).toggleClass('is-active');
    $('body').toggleClass('menu-active');
  });

  // $('.gallery').each(function() { // the containers for all your galleries
  //   $(this).magnificPopup({
  //     delegate: 'a', // the selector for gallery item
  //     type: 'image',
  //     gallery: {
  //       enabled: true,
  //       navigateByImgClick: true,
  //       preload: [0,1] // Will preload 0 - before current, and 1 after the current image
  //     },
  //     image: {
  //       tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
  //       /*titleSrc: function(item) {
  //         return item.el.attr('title') + '<small>by Marsel Van Oosten</small>';
  //       }*/
  //     }
  //   });
  // });

  // $('.modal-video').magnificPopup({
  //   type: 'iframe',
  //   mainClass: 'mfp-fade',
  //   removalDelay: 160,
  //   preloader: false,
  //   fixedContentPos: false
  // });

  // $('.play-trailer').magnificPopup({
  //   type: 'iframe',
  //   mainClass: 'mfp-fade',
  //   removalDelay: 160,
  //   preloader: false,
  //   fixedContentPos: false,

  //   callbacks: {
  //     open: function() {
  //       // Will fire when this exact popup is opened
  //       // this - is Magnific Popup object
  //       var vid = $('.screen-one').find('video');
  //       if (vid.length > 0) {
  //         $(vid)[0].pause();
  //       }
  //     },
  //     close: function() {
  //       // Will fire when popup is closed
  //       var vid = $('.screen-one').find('video');
  //       if (vid.length > 0) {
  //         $(vid)[0].play();
  //       }
  //     }
  //   }
  // });

});