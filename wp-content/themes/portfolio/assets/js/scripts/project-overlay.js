jQuery(document).ready(function() {

	var $projectThumbnails = jQuery(".project-thumbnail");
  $projectThumbnails.on("mouseover", function() {
    jQuery(this).addClass("lightened-image");
    jQuery(this).removeClass("normal-image");
  });
  $projectThumbnails.on("mouseleave", function() {
    jQuery(this).addClass("normal-image");
    jQuery(this).removeClass("lightened-image");
  });

});
