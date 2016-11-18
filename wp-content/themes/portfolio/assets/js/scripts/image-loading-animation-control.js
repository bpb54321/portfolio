(function( $ ) {

  $('.project-thumbnail').imagesLoaded( { background: true } ).progress( function( instance, image ) {
    console.log('#container background images have loaded');
  });

})( jQuery );
