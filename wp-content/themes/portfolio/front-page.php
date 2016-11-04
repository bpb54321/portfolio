
<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<?php
		$secondary_content = get_post_meta($post->ID, 'front_page_secondary_editor_wysiwyg', true);
		//error_log('----------------------------$secondary_content------------------');
		//error_log( var_export($secondary_content,true) );
	?>

	<!--Image Link Grid for Models -->
	<?php
		//Include the function that generates the link grid HTML
		include_once( get_template_directory() . '/parts/components-image-link-grid.php' );

		//Query all available projects
		$args = array (
			'post_type'              => array( 'project' ),
			'post_status'            => array( 'publish' ),
			'nopaging'               => false,
			'posts_per_page'         => 999,
		);

		// The Query
		$projects_query = new WP_Query( $args );
		//error_log( var_export($projects_query,true) );

		$num_projects_row_medium = get_post_meta($post->ID, 'front_page_project_grid_num_columns_selection', true);
		//error_log('-----------------$num_projects_row_medium------------------');
		//error_log( print_r( $num_projects_row_medium,true) );

		if ( $num_projects_row_medium === '' ) {
			$num_projects_row_medium = 3; //Default value in case the meta value hasn't been saved to the db yet
		}

		$image_overlay_style = "hover_title_categories";
		//$image_overlay_style = "static_title_only";

		echo_image_link_grid( $projects_query, $num_projects_row_medium, $image_overlay_style, false );
	?>

	<section class="summary-text">
		<?php the_content(); ?>
	</section>

	<div class="row">
		<div class="columns large-6">This is the left section.</div>
		<div class="columns large-6">This is the right section.</div>
	</div>
	<?php get_template_part( 'parts/footer', 'cta' ); ?>

<?php endwhile; else : ?>

	<?php get_template_part( 'parts/content', 'missing' ); ?>

<?php endif; ?>

<?php get_footer(); ?>
