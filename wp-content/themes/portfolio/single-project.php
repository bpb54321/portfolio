<?php get_header(); ?>

<?php get_template_part( 'parts/header', 'hero-image' ); ?>

<?php 
	$slam_project_year = get_post_meta($post->ID, 'slam_project_year', true);
	$project_categories = get_post_category_string($post);
	//$link_file_url = get_post_meta($post->ID, 'link_to_file_media_file', true);
	//$link_file_text = get_post_meta($post->ID, 'link_to_file_text', true);
	$link_to_file_link_group = get_post_meta($post->ID, 'link_to_file_link_group', false);


	//error_log('------------------$link_file_url----------------');
	//error_log( print_r($link_file_url, true) );

	//error_log('------------------$link_file_text----------------');
	//error_log( print_r($link_file_text, true) );

	$link_to_file_link_group = $link_to_file_link_group[0];

	//error_log('------------------$link_to_file_link_group----------------');
	//error_log( print_r($link_to_file_link_group, true) );



?>

<section class="content">

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<article class="main-article">
			<h3 class="title"><?php the_title(); ?></h3>
			<?php if( $project_categories !== false || $slam_project_year !== '' ) : ?>
				<div class="categories">
					<?php if( $project_categories !== false ) {
						echo "<h3 class='single-project-category-string'>";
						echo get_post_category_string($post); //Defined in functions.php
						echo "</h3>";
					}
					?>
					<?php if( $slam_project_year !== '' ) {
						echo "<h3 class='single-project-year-string'>";
						echo $slam_project_year;
						echo "</h3>";
					}
					?>
				</div>
			<?php endif; ?>
			<?php 
				//if( $link_file_url !== '' ) {
				if ( sizeof( $link_to_file_link_group ) > 0 ) : ?>
					<div class='link-to-file'>
					<?php foreach ( $link_to_file_link_group as $link_array ) : ?>
						<a target='_blank' href='<?php echo $link_array["link_to_file_media_file"]; ?>'><?php echo $link_array["link_to_file_text"]; ?></a>
					<?php endforeach; ?>
					</div>
				<?php endif; ?>
	    	<?php the_content(); ?>
		</article>
		
		<?php get_template_part('parts/components', 'image-slider'); ?>
    	
    <?php endwhile; else : ?>

   		<?php get_template_part( 'parts/content', 'missing' ); ?>

    <?php endif; ?>

</section>

<?php get_template_part( 'parts/footer', 'cta' ); ?>

<?php get_footer(); ?>


