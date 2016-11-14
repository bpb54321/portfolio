<?php get_header(); ?>
<?php
	$ftd_img_id = get_post_thumbnail_id ( $post );
	$ftd_img_srcset = wp_get_attachment_image_srcset( $ftd_img_id, $size = 'medium', $image_meta = null );
	$project_url = get_post_meta( $post->ID, 'project_details_url', true );
?>
<div class="row main-content">
	<div class="large-8 columns">
		<img srcset="<?=$ftd_img_srcset?>" sizes="(max-width: 1024px) 100vw, 75vw" alt="Project Featured Image">
	</div>

	<div class="large-4 columns">
		<div class="single-project-copy">
			<h1 class="project-title"><?php echo $post->post_title; ?></h1>
			<p class="project-details"><?php echo $post->post_content; ?></p>
			<a target="_blank" href="<?=$project_url?>">View Site</a>
		</div>
	</div>
</div>

<?php get_template_part('parts/nav', 'bottom-project'); ?>
<?php get_footer(); ?>
