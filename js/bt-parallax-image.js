(function (Drupal, once) {
  'use strict';
  Drupal.behaviors.btParallaxImage = {
    attach: function (context) {
      once('parallax-processed', '.parallax-section .parallax-element', context).forEach(function (element) {
        var imageUrl = element.getAttribute('data');
        if (imageUrl) {
          element.style.backgroundImage = 'url(' + imageUrl + ')';
        }
      });
    }
  };
})(Drupal, once);


