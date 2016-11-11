<?php get_header(); ?>
<?php
	$ftd_img_id = get_post_thumbnail_id ( $post );
	//$ftd_img_default_src = wp_get_attachment_image_src( $ftd_img_id, 'large');
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
		<img srcset="<?=$ftd_img_srcset?>" sizes="(max-width: 1024px) 100vw, 75vw" alt="Project Featured Image">
	</div>
	<div class="large-4 columns">
		<div class="single-project-copy">
			<h1 class="project-title"><?php echo $post->post_title; ?></h1>
			<p class="project-description"><?php echo $post->post_content; ?></p>

			<a>View Site</a>
		</div>
	</div>
</div>

<?php get_template_part( 'parts/footer', 'cta' ); ?>

<?php get_footer(); ?>
