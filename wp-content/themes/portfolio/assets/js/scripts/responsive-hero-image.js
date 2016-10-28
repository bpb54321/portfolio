jQuery(document).ready(function() {
    //Responsively select image files for the hero static image or image slideshow
    var windowInnerWidth = window.innerWidth;
    var theHeroImage = jQuery(".hero-image");
    var theHeroImageSlides = jQuery(".hero-image-slide");

    var jqImageObjects = {};
    if (theHeroImage.length > 0) {
        jqImageObjects = theHeroImage;
    } else if (theHeroImageSlides.length > 0) {
        jqImageObjects = theHeroImageSlides;
    }

    for ( var j = 0; j < jqImageObjects.length; j++ ) {
        var singleImageObject = jQuery( jqImageObjects[j] );
        var thisImageUrl = '';
        var imageInfoObject = singleImageObject.data("imageData");
        if ( imageInfoObject !== undefined ) { //If imageInfoObject = undefined, there is not a header image or header slideshow, so don't do anything
            for ( var i = 0; i < imageInfoObject.length; i++ ) {
                var imageWidth = imageInfoObject[i]["width"];
                if ( imageWidth < (windowInnerWidth)  ) {
                    //continue;
                } else {
                    thisImageUrl = imageInfoObject[i]["url"];
                    break;
                }
            }
            if ( thisImageUrl === '') { //The largest image was never bigger than windowInnerWidth
                thisImageUrl = imageInfoObject[ imageInfoObject.length-1 ]["url"]; //Use the biggest image
            }
            singleImageObject.css("background-image", "url('" + thisImageUrl +"')");
        }
    }
});