jQuery(document).foundation();
jQuery(document).ready(function() {	

	//Add a click listener for the hamburger menu icon
	jQuery('button.menu-icon').click( function() {
		jQuery('#primary-menu').css("display","flex");
		jQuery('#primary-menu').animate( 
			{
			    right: 0,

			}, 500 
		);
		jQuery("button.menu-icon").hide();
	});

	//Add a click listener for the close icon "X"
	jQuery('#menu-close-x').click( function() {
		var primaryMenu  = jQuery('#primary-menu');
		var menuWidth = primaryMenu.css("width");
		primaryMenu.animate( 
			{
			    right: "-" + menuWidth, //Because menuWidth is actually a string
			}, 500, "swing", function() {
				jQuery('#primary-menu').css("display","none");
				jQuery("button.menu-icon").show();
			}
		);
		
	});
}); 
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
jQuery(document).ready(function() {	
	
	
	//Logic that tells the javascript to not add event listeners and just make the project thumbnail overlays appear
	//If we are in the project list page
	var bodyObject = document.querySelector("body"); 
	var classList = bodyObject.classList;

	//Check to see if the body classes indicate that the current page is using the Project List Template
	var isProjectListTemplate = false;
	for (var i = 0; i<classList.length; i++ ) {
		if ( classList[i] === "page-template-page-project-list" ) {
			isProjectListTemplate = true;
			break;
		}
	}

	//Find the screen width for mobile vs desktop styling
	var largeBreakpoint = 1024; //px
	isLargeScreen = false;
	if ( window.innerWidth>largeBreakpoint ) {
		isLargeScreen = true;
	}

	//This adds a link to Google Maps for mobile sizes, since we've disabled mouse events in _contact-form.scss.
	//This is pretty much a hack
	if (!isLargeScreen) {
		jQuery(".google-map").parent().click(function() {
			//alert("I am a window!");
			window.location.href = "https://maps.google.com/maps?ll=38.620425,-90.257603&z=16&t=m&hl=en-US&gl=US&mapclient=embed&q=1607%20Tower%20Grove%20Ave%20St.%20Louis%2C%20MO%2063110";
		});
	}
	
	var projectGalleries; 
	if (isProjectListTemplate) {
		//projectGallery = document.getElementById("project-list-grid");
		projectGalleries = jQuery("#project-list-grid");
	} else {
		//Get the number of project thumbnails that are in the document
		projectGalleries = jQuery(".project-gallery"); 
	}
	
	//console.log( projectGallery );
	if ( projectGalleries !== null ) {
		for ( var j = 0; j < projectGalleries.length; j++ ) {
			var projectGallery = projectGalleries[j];
			var numberProjectThumbnails = projectGallery.dataset.projectCount;

			for (var i = 0; i < numberProjectThumbnails; i++) {

					if ( isLargeScreen ) {
						//Make divProjectOverlay fadeIn and fadeOut on mouseover and mouseleave
					
						if (!isProjectListTemplate) {
							var divProjectThumbnail = jQuery(projectGallery).find(".project-thumbnail-" + i );
							//Add event listener for fadeIn()
							divProjectThumbnail.on("mouseenter", function() {
								var divProjectOverlay = this.children[0].children[0]; 
								//console.log(divProjectOverlay); 
								jQuery(divProjectOverlay).animate({
														    opacity: 1.00,
														  }, 500 );
							});

							//Add event listener for fadeOut()
							divProjectThumbnail.on("mouseleave", function() {
								var divProjectOverlay = this.children[0].children[0];
								jQuery(divProjectOverlay).animate({
														    opacity: 0,
														  }, 500 );
							});	
						} else {
							var divProjectThumbnailContainer = document.getElementById("project-thumbnail-container-" + i );
							divProjectThumbnailContainer.addEventListener("mouseenter", function() {
								var divProjectDetails = jQuery(this).find(".project-thumbnail-details");
								//console.log(divProjectDetails); 
								divProjectDetails = divProjectDetails[0]; //Get the first element of the jQuery array
								/*jQuery(divProjectDetails).css({
													    backgroundColor: "#efebd0",
													  });*/
							    jQuery(divProjectDetails).addClass("project-details-darkened-bg");
							});

							//Add event listener for fadeOut()
							divProjectThumbnailContainer.addEventListener("mouseleave", function() {
								var divProjectDetails = jQuery(this).find(".project-thumbnail-details");
								//console.log(divProjectDetails); 
								divProjectDetails = divProjectDetails[0];
								/*jQuery(divProjectDetails).css({
													    backgroundColor: "white",
													  });*/
							    jQuery(divProjectDetails).removeClass("project-details-darkened-bg");
							});	
						}
					} else {
						//Make divProjectOverlay fadeIn when the thumbnail is completely in the viewport and fadeOut when completely out of the viewport
						//Uses the Waypoints API (http://imakewebthings.com/waypoints/) 
						if (!isProjectListTemplate) {
							var elementCollection = jQuery(projectGallery).find(".project-thumbnail-" + i );
							
							//debugger;
							var inview = new Waypoint.Inview({
							  element: elementCollection[0],
							  entered: function(direction) {
							    var divProjectOverlay = this.element.children[0].children[0];
								jQuery(divProjectOverlay).animate({
														    opacity: 1.00,
														  }, 500 );
							  },
							  exited: function(direction) {
							    var divProjectOverlay = this.element.children[0].children[0];
								jQuery(divProjectOverlay).animate({
														    opacity: 0,
														  }, 500 );
							  }
							});	
						} else {
					
						}
					}	
				//}
			}			
		}

	}
	
}); 
//This file has been subsumed into project-list-grid-overlay.js.
/*jQuery(document).ready(function() {	
	
	
	//Logic that tells the javascript to not add event listeners and just make the project thumbnail overlays appear
	//If we are in the project list page
	var bodyObject = document.querySelector("body"); 
	var classList = bodyObject.classList;

	//Check to see if the body classes indicate that the current page is using the Project List Template
	var isProjectListTemplate = false;
	for (var i = 0; i<classList.length; i++ ) {
		if ( classList[i] === "page-template-page-project-list" ) {
			isProjectListTemplate = true;
			break;
		}
	}

	//No longer checking for project list template
	isProjectListTemplate = false; 

	//Find the screen width for mobile vs desktop styling
	var largeBreakpoint = 1024; //px
	isLargeScreen = false;
	if ( window.innerWidth>largeBreakpoint ) {
		isLargeScreen = true;
	}
	
	//Get the number of project thumbnails that are in the document
	var projectGallery = document.getElementById("project-gallery");
	//console.log( projectGallery );
	if ( projectGallery !== null ) {
		var numberProjectThumbnails = projectGallery.dataset.projectCount;

		for (var i = 0; i < numberProjectThumbnails; i++) {
			
			if (isProjectListTemplate) { //If it's the projectListTemplate, just show the overlays, don't animate them
				var divProjectThumbnail = document.getElementById("project-thumbnail-" + i );
				var divProjectOverlay = divProjectThumbnail.children[0].children[0];
				jQuery(divProjectOverlay).css({
												opacity: 1.00,
											});
			} else {

				if ( isLargeScreen ) {
					//Make divProjectOverlay fadeIn and fadeOut on mouseover and mouseleave

					//Add event listener for fadeIn()
					var divProjectThumbnail = document.getElementById("project-thumbnail-" + i );
					divProjectThumbnail.addEventListener("mouseenter", function() {
						var divProjectOverlay = this.children[0].children[0]; 
						//console.log(divProjectOverlay); 
						jQuery(divProjectOverlay).animate({
												    opacity: 1.00,
												  }, 500 );
					});

					//Add event listener for fadeOut()
					divProjectThumbnail.addEventListener("mouseleave", function() {
						var divProjectOverlay = this.children[0].children[0];
						jQuery(divProjectOverlay).animate({
												    opacity: 0,
												  }, 500 );
					});	
				} else {
					//Make divProjectOverlay fadeIn when the thumbnail is completely in the viewport and fadeOut when completely out of the viewport
					//Uses the Waypoints API (http://imakewebthings.com/waypoints/) 
					var inview = new Waypoint.Inview({
					  element: document.getElementById("project-thumbnail-" + i ),
					  entered: function(direction) {
					    var divProjectOverlay = this.element.children[0].children[0];
						jQuery(divProjectOverlay).animate({
												    opacity: 1.00,
												  }, 500 );
					  },
					  exited: function(direction) {
					    var divProjectOverlay = this.element.children[0].children[0];
						jQuery(divProjectOverlay).animate({
												    opacity: 0,
												  }, 500 );
					  }
					}); 
				}	
			}
		}
	}
	
}); */
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
/* 
These functions make sure WordPress 
and Foundation play nice together.
*/

jQuery(document).ready(function() {
    
    // Remove empty P tags created by WP inside of Accordion and Orbit
    jQuery('.accordion p:empty, .orbit p:empty').remove();
    
	 // Makes sure last grid item floats left
	jQuery('.archive-grid .columns').last().addClass( 'end' );
	
	// Adds Flex Video to YouTube and Vimeo Embeds
	//jQuery('iframe[src*="youtube.com"], iframe[src*="vimeo.com"]').wrap("<div class='flex-video'/>"); 

});
//# sourceMappingURL=scripts.js.map
