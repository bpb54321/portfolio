<!doctype html>

  <html class="no-js"  <?php language_attributes(); ?>>

	<head>
		<meta charset="utf-8">

		<!-- Force IE to use the latest rendering engine available -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<!-- Mobile Meta -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta class="foundation-mq">

    <!-- Web Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400|PT+Sans:400,700" rel="stylesheet">
    <!-- End Web Fonts -->

		<!-- Icons & Favicons -->
		<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		<!--<link href="<?php //echo get_template_directory_uri(); ?>/assets/images/apple-icon-touch.png" rel="apple-touch-icon" /> -->
		<!--[if IE]>
			<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		<![endif]-->

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

	</head>

	<!-- Uncomment this line if using the Off-Canvas Menu -->

	<body <?php body_class(); ?>>

				<div class="off-canvas-content" data-off-canvas-content>

					<header class="header row column" role="banner">

               <h1 id="site-title"><?php bloginfo("site_title"); ?></h1>
               <?php joints_top_nav(); ?>

					</header> <!-- end .header -->
