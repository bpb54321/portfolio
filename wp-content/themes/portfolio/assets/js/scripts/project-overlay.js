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