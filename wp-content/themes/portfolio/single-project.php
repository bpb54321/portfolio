<?php get_header(); ?>
<?php
	$ftd_img_id = get_post_thumbnail_id ( $post );
	$ftd_img_srcset = wp_get_attachment_image_srcset( $ftd_img_id, $size = 'medium', $image_meta = null );
	$project_url = get_post_meta( $post->ID, 'project_details_url', true );

	$prev_project_permalink = get_adjacent_custom_post_type( $post, 'project', 'before' );
	error_log('-----------------------------------$prev_project_permalink----------------------------------------');
	error_log( print_r($prev_project_permalink, true) );
	error_log('-----------------------------------$prev_project_permalink----------------------------------------');

	$next_project_permalink = get_adjacent_custom_post_type( $post, 'project', 'after' );
	error_log('-----------------------------------$next_project_permalink----------------------------------------'); 
	error_log( print_r($next_project_permalink, true) ); 
	error_log('-----------------------------------$next_project_permalink----------------------------------------');
?>

<div class="row">
	<div class="large-8 columns">
		<img srcset="<?=$ftd_img_srcset?>" sizes="(max-width: 1024px) 100vw, 75vw" alt="Project Featured Image">
	</div>
	<div class="large-4 columns">
		<div class="single-project-copy">
			<h1 class="project-title"><?php echo $post->post_title; ?></h1>
			<p class="project-details"><?php echo $post->post_content; ?></p>
			<a href="<?=$project_url?>">View Site</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="small-12 columns">
		<a href="<?php echo get_bloginfo( 'url' ); ?>" class="back-to-work">Back to Work</a>
		<div class="prev-next-container">
			<?php if( $prev_project_permalink !== '' ) : ?>
				<a href="<?=$prev_project_permalink?>" class="prev">prev</a>
			<?php endif; ?>
			<?php if( $next_project_permalink !== '' ) : ?>
				<a href="<?=$next_project_permalink?>" class="next">next</a>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php get_template_part( 'parts/footer', 'cta' ); ?>

<?php get_footer(); ?>
