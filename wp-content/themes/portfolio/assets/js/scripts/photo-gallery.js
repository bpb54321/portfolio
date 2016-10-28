jQuery(document).ready(function() {	
	//Get the number of photos that are in the gallery
  var galleryContainer = document.querySelector(".gallery-container");
  var mediumBreakpoint = 640; //px

  if ( galleryContainer !== null ) {

    var numPhotos = galleryContainer.dataset.numPhotos;
    //console.log(numPhotos); 

    if ( numPhotos === "0" ) {
      //Do not initialize Slick
    } else {
      var slidesToShow;
      var idealNumberSlidesToShow = 5;
      if ( numPhotos <= idealNumberSlidesToShow ) {
        slidesToShow = numPhotos - 1;
      } else {
        slidesToShow = idealNumberSlidesToShow;
      }
      jQuery('.featured-image-gallery').slick({ 
        //slidesToShow: 1, //Irrelevant when variableWidth is true
        infinite: true,
        slidesToScroll: 1,
        arrows: true,
        //fade: true,
        //asNavFor: '.image-gallery',
        variableWidth: true, 
        centerMode: true,
        //adaptiveHeight: true,
        responsive: [
          {
            breakpoint: mediumBreakpoint,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
              arrows: true,
              //variableWidth: true,
              //adaptiveHeight: true,
              centerMode: true,
              infinite: true, 
            }
          },
          // You can unslick at a given breakpoint now by adding:
          // settings: "unslick"
          // instead of a settings object
        ],
      });

      /*jQuery('.image-gallery').slick({
        slidesToShow: slidesToShow, //Set this to one less than the number of slides
        infinite: true,
        slidesToScroll: 1,
        arrows: true,
        asNavFor: '.featured-image-gallery',
        //variableWidth: true,
        //centerMode: true,
        //adaptiveHeight: true,
      });*/

      //Remove thumbnail gallery for mobile 
      
/*      if ( window.innerWidth<mediumBreakpoint ) {
        jQuery('.image-gallery').hide();
      } */
    }
  }
});