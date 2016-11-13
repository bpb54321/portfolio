jQuery(document).ready(function() {
  jQuery("#mobile-menu-link").on("click", function() {
    jQuery("#menu-primary-navigation").toggleClass("mobile-menu-revealed");
  });
});
