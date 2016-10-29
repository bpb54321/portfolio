<!doctype html>

  <html class="no-js"  <?php language_attributes(); ?>>

	<head>
		<meta charset="utf-8">

		<!-- Force IE to use the latest rendering engine available -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<!-- Mobile Meta -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta class="foundation-mq">


		<!-- Icons & Favicons -->
		<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		<!--<link href="<?php //echo get_template_directory_uri(); ?>/assets/images/apple-icon-touch.png" rel="apple-touch-icon" /> -->
		<!--[if IE]>
			<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		<![endif]-->
		<!-- <meta name="msapplication-TileColor" content="#f01d4f"> -->
		<!--<meta name="msapplication-TileImage" content="<?php //echo get_template_directory_uri(); ?>/assets/images/win8-tile-icon.png">-->
    	<!-- <meta name="theme-color" content="#121212"> -->


		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

		<!--Manually enqueue Gravity Forms scripts and styles-->
		<?php
		/**
		 * Detect plugin. For use on Front End only.
		 */
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		// check for plugin using plugin name
		if ( is_plugin_active( 'gravityforms/gravityforms.php' ) ) {
			gravity_form_enqueue_scripts( 1, true );
		} ?>
		<!--End Gravity Forms enqueue-->

		<?php wp_head(); ?>

		<!-- Drop Google Analytics here -->
		<?php
			$analytics_script = get_theme_mod('google_analytics_code_snippet');
			//error_log('--------------------$analytics_script------------------------');
			//error_log( var_export($analytics_script, true) );
			echo $analytics_script;
		?>
		<!-- end analytics -->

		<!--Font Awesome CDN -->
		<script src="https://use.fontawesome.com/645de6072f.js"></script>
		<!--End Font Awesome CDN-->

	</head>

	<!-- Uncomment this line if using the Off-Canvas Menu -->

	<body <?php body_class(); ?>>

				<div class="off-canvas-content" data-off-canvas-content>

					<header class="header" role="banner">

						 <!-- This navs will be applied to the topbar, above all content
							  To see additional nav styles, visit the /parts directory -->
						 <?php get_template_part( 'parts/nav', 'vertical-overlay' ); ?>

					</header> <!-- end .header -->
