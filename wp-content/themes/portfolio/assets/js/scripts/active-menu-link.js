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
