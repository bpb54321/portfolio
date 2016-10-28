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