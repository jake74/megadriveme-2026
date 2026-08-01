// passive listener
// jQuery.event.special.touchstart = {
//   setup: function( _, ns, handle ){
//     this.addEventListener("touchstart", handle, { passive: true });
//   }
// };

document.addEventListener('DOMContentLoaded', function () {
  if (typeof Swiper === 'undefined') {
    return;
  }

  new Swiper('.showcase-content', {
    direction: 'horizontal',
    loop: true,
    speed: 1000,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
    },
    effect: 'fade',
    fadeEffect: {
      crossFade: true,
    },
  });
});

function hex2rgb($hex) {
  var hex_color = $hex
    , pattern_color = "^#([A-Fa-f0-9]{6})$";
  if (hex_color.match(pattern_color)) {
    var hex_color = hex_color.replace("#", "")
      , r = parseInt(hex_color.substring(0, 2), 16)
      , g = parseInt(hex_color.substring(2, 4), 16)
      , b = parseInt(hex_color.substring(4, 6), 16);
    return 'rgb(' + r + ',' + g + ',' + b + ')';
  }
}

function getAverageColorFromImage(imageId) {
  var image = document.getElementById(imageId);
  var avgHexColor = '';
  var avgColorWithoutHash = '';
  var complementColor = '';
  var complementHexColor = '';
  var compHexColorRGB = '';

  if (image.complete) {
    extractColor();
  } else {
    image.addEventListener('load', extractColor);
  }

  function extractColor() {
    try {
      var avgColor = window.ColorThief.getColorSync(image);      
      let avgHexColor = avgColor.hex();

      let avgColorWithoutHash = avgHexColor.replace('#', '');
      let complementColor = (0xFFFFFF ^ parseInt(avgColorWithoutHash, 16)).toString(16);
      
      var hexComp = hex2rgb('#' + complementColor);
      var hexCompRGBA = hexComp.replace('rgb', 'rgba').replace(')', ', 0.20)');

      document.querySelector('.game-detail-cover').classList.add('ready');
      // document.querySelector('.game-detail-cover').insertAdjacentHTML('beforeend', '<style>.game-detail-cover { background-image: linear-gradient(135deg, ' + avgHexColor + ' 0%, ' + hexCompRGBA + ' 99%); }</style>');
      // the above replaces transparent for a complementary color, but if you want to keep it transparent, you can use the following line instead:
      document.querySelector('.cover-wrapper').insertAdjacentHTML('beforeend', '<style>.cover-wrapper { background-image: linear-gradient(135deg, ' + avgHexColor + ' 0%, transparent 99%); }</style>');

    } catch (error) {
      console.error('getColorSync failed', error);
    }
  }
}

document.addEventListener('DOMContentLoaded', function () {
  // set the average color of the cover image as a background gradient
  var coverImage = document.getElementById('cover-image');
  if (coverImage) {
    getAverageColorFromImage('cover-image');
  }

  // toggle full-screen cover on click
  document.addEventListener('click', function(e) {
    if (e.target.closest('.game-case')) {
      document.querySelector('.game-detail-cover').classList.toggle('full-screen');
    }
  });

});


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

});