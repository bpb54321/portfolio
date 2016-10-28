<?php
/*
Widget Name: CTA Widget
Description: Creates a custom CTA bar widget.
Author: Brian Blosser
Version: 1.0
Author Email: brian@slamagency.com
 */
class CTAWidget extends WP_Widget
{
	function __construct() {
		$widget_ops = array( 
			'classname' => 'cta_widget',
			'description' => 'Outputs a call-to-action bar in a Widget Area.',
		);
		parent::__construct( 'cta_widget', 'CTA Widget', $widget_ops );
	}
	
	//Outputs the UI
	/*
	 * @param: $args - Arguments from the theme.
	 * @instance: instance of the widget class
	 */
	function widget( $args, $instance ) {
		extract ( $args, EXTR_SKIP ); //Contains things like $before_widget, $after_widget, $title, etc
		extract ( $instance, EXTR_SKIP ); //EXTR_SKIP makes sure to not overwrite any existing variables

		//error_log('----------------$args-----------------');
		//error_log( var_export($args,true) );

		//error_log('----------------$instance-----------------');
		//error_log( var_export($instance,true) );

		if ( !isset($cta_text) ) {
			$cta_text = '';
		}
		if ( !isset($button_text) ) {
			$button_text = '';
		}
		?>
		<?php echo $before_widget; ?>
			<h6><?php echo $cta_text; ?></h6>
			<a data-open="exampleModal1"><button class="cta-button"><?php echo $button_text; ?></button></a>
			<!--Reveal Modal Content-->
			<div class="reveal" id="exampleModal1" data-reveal>
			  <?php 
			  	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				// check for plugin using plugin name
				if ( is_plugin_active( 'gravityforms/gravityforms.php' ) ) {
			  		gravity_form( 1, false , false, false, false, true ); 
			  	}
	  		  ?>
			  <button class="close-button" data-close aria-label="Close modal" type="button">
			    <span aria-hidden="true">&times;</span>
			  </button>
			</div>
			<!--End Reveal Modal Content-->
		<?php echo $after_widget; ?>

		<?php 
	}
	
	function update($new_instance, $old_instance) {
		//Can alter the new instance values if you want in this function
		$instance = $new_instance;
		return $instance;
	}
	
	function form($instance) {
		//Input for cta text
		$cta_text = ! empty( $instance['cta_text'] ) ? $instance['cta_text'] : 'Example cta text';
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'cta_text' ); ?>"><?php echo 'CTA Text'; ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'cta_text' ); ?>" name="<?php echo $this->get_field_name( 'cta_text' ); ?>" type="text" value="<?php echo esc_attr( $cta_text ); ?>">
		</p>
		<?php 	

		//Input for button text
		$button_text = ! empty( $instance['button_text'] ) ? $instance['button_text'] : 'Example button text';
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'button_text' ); ?>"><?php echo 'Button Text'; ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'button_text' ); ?>" name="<?php echo $this->get_field_name( 'button_text' ); ?>" type="text" value="<?php echo esc_attr( $button_text ); ?>">
		</p>
		<?php 
	}
}

function cta_widget_init() {
	register_widget("CTAWidget");
}
add_action('widgets_init', 'cta_widget_init');