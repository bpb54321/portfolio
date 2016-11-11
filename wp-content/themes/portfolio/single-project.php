<?php get_header(); ?>
<?php
	$ftd_img_id = get_post_thumbnail_id ( $post );
	$ftd_img_default_src = wp_get_attachment_image_src( $ftd_img_id, 'large');
	$ftd_img_srcset = wp_get_attachment_image_srcset( $ftd_img_id, $size = 'medium', $image_meta = null );
	// error_log('-----------------------------------$ftd_img_srcset----------------------------------------');
	// error_log( print_r($ftd_img_srcset, true) );
	// error_log('-----------------------------------$ftd_img_srcset----------------------------------------');
	//
	// error_log('-----------------------------------$ftd_img_metadata----------------------------------------');
	// error_log( print_r($ftd_img_metadata, true) );
	// error_log('-----------------------------------$ftd_img_metadata----------------------------------------');
 ?>

<div class="row">
	<div class="large-8 columns">
		<img src="<?=$ftd_img_default_src?>" srcset="<?=$ftd_img_srcset?>" alt="Project Featured Image">
	</div>
	<div class="large-4 columns">
		<div class="single-project-copy">
			<h1 class="project-title">Project title</h1>
			<p class="project-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
			<a>View Site</a>
		</div>
	</div>
</div>

<?php get_template_part( 'parts/footer', 'cta' ); ?>

<?php get_footer(); ?>
