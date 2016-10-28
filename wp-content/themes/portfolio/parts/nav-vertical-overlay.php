<?php ?>

<!-- <div class="title-bar" data-responsive-toggle="top-bar-menu" data-hide-for="all">
  <button class="menu-icon" type="button" data-toggle></button>
  <div class="title-bar-title"><?php //_e( 'Menu', 'jointswp' ); ?></div>
  <div class="title-bar-right">
    <button class="menu-icon" type="button" data-open="offCanvasRight"></button>
  </div>
</div>

<div class="top-bar" id="top-bar-menu">
	<div class="top-bar-left">
		<ul class="menu">
			<li><a href="<?php //echo home_url(); ?>"><?php //bloginfo('name'); ?></a></li>
		</ul>
	</div>
	<div class="top-bar-right">
		<?php //joints_top_nav(); ?>
	</div>
</div> -->

<div id="top-navigation">
	<!-- <div id="logo-container"> -->
	<?php 
		$logo_img_id = get_theme_mod('site_logo');
		$img_array = wp_get_attachment_image_src ( $logo_img_id, 'medium', false );
		$img_src = $img_array[0];
		//error_log( var_export($img_array, true) );
	?>
	<a id="logo-link-wrapper" href="<?php echo home_url(); ?>"><img id="logo" src='<?php echo $img_src; ?>'></img></a>
	<!-- </div> -->
	<div id="hamburger-container">
    	<button class="menu-icon" type="button"></button>
    </div>
	<div id="primary-menu"  >
		<div id="menu-close-div">
			<a id="menu-close-x">X</a>
		</div>
		<?php joints_top_nav(); ?>
	</div>
</div>