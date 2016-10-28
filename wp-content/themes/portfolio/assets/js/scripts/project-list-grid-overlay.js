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