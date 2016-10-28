<?php
	$button_text = get_post_meta($post->ID, 'front_page_top_cta_button_text', true);
	//error_log('----------------------------$button_text------------------');
	//error_log( var_export($button_text,true) );
?>
<?php if ( $button_text != '' ) : ?>
	<a data-open="exampleModal1"><button class="cta-button"><?php echo $button_text; ?></button></a>
	<!--Reveal Modal Content-->
	<div class="reveal" id="exampleModal1" data-reveal>
	  <?php 

		/**
		 * Detect plugin. For use on Front End only.
		 */
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		// check for plugin using plugin name
		if ( is_plugin_active( 'gravityforms/gravityforms.php' ) ) {
		  //plugin is activated
			gravity_form( 1, false , false, false, false, true ); 
		} 
	  	
		?>
	  <button class="close-button" data-close aria-label="Close modal" type="button">
	    <span aria-hidden="true">&times;</span>
	  </button>
	</div>
	<!--End Reveal Modal Content-->
<?php endif; ?>