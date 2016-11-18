(function( $ ) {

  $('.project-thumbnail').imagesLoaded( { background: true } ).progress( function( instance, image ) {
    //After each background image is loaded, hide the overlay with the spinning progress wheel
    $(image.element).children(".project-thumbnail-overlay").css("display", "none");
  });

})( jQuery );
