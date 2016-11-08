jQuery(document).ready(function() {
  var $menuLinks = jQuery("#menu-primary-navigation a");
  var currentPagePathname = window.location.pathname;
  var theMenuLink;
  for ( var i = 0; i < $menuLinks.length; i++ ) {
    theMenuLink = $menuLinks[i];
    if ( theMenuLink.pathname === currentPagePathname ) {
      jQuery(theMenuLink).addClass("active-link");
      break;
    }
  }
});

jQuery(document).foundation();
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
