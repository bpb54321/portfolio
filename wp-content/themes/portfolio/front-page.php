<?php get_header(); ?>

<?php get_template_part( 'parts/header', 'hero-image' ); ?>



<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	<?php 
		$secondary_content = get_post_meta($post->ID, 'front_page_secondary_editor_wysiwyg', true);
		//error_log('----------------------------$secondary_content------------------');
		//error_log( var_export($secondary_content,true) );
	?>
	<section class="summary-text">
		<?php echo $secondary_content; ?>
		<?php get_template_part( 'parts/components', 'cta-button' ); ?>
	</section>
	
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

	<!--Image Link Grid for Pages -->
	<?php 
		//Include the function that generates the link grid HTML
		include_once( get_template_directory() . '/parts/components-image-link-grid.php' ); 

		$image_link_data_array = get_post_meta($post->ID, 'front_page_image_links_image_link_group');
		$image_link_data_array = $image_link_data_array[0];

		//error_log('-----------------$image_link_data_array------------------');
		//error_log( print_r( $image_link_data_array,true) );

		//Iterate through each page_id-subheader_text group
		$image_link_page_ids = [];
		$image_link_subheaders = [];
		foreach ( $image_link_data_array as $image_link_group ) {
			if ( isset( $image_link_group['front_page_image_links_selection'] ) ) {
				$image_link_page_ids[] = $image_link_group['front_page_image_links_selection'];	
			}
			if ( isset( $image_link_group['front_page_image_links_subheader_text'] ) ) {
				$image_link_subheaders[] = $image_link_group['front_page_image_links_subheader_text'];	
			}
		}

		//error_log('-----------------$image_link_page_ids------------------');
		//error_log( print_r( $image_link_page_ids,true) );

		//error_log('-----------------$image_link_subheaders------------------');
		//error_log( print_r( $image_link_subheaders,true) );
		
		//Query all available projects
		$args = array (
			'post_type'				 => 'page',
			'post_status'            => array( 'publish' ),
			'nopaging'               => false,
			'posts_per_page'         => 999,
			'post__in'				 => $image_link_page_ids,
		);

		// The Query
		$query = new WP_Query( $args );
		//error_log( print_r( $query,true ) );

		$num_projects_row_medium = get_post_meta( $post->ID, 'front_page_image_links_num_columns', true );

		if ( $num_projects_row_medium === '' ) { //Default number of columns
			$num_projects_row_medium = 2; //Must divide evenly into 12	
		}

		//$image_overlay_style = "hover_title_categories"; 
		$image_overlay_style = "static_title_only";

		echo_image_link_grid( $query, $num_projects_row_medium, $image_overlay_style, true, $image_link_subheaders );
	?>

	<?php 
		$slam_testimonial_text = get_post_meta($post->ID, 'slam_testimonial_text', true);
		$slam_testimonial_author = get_post_meta($post->ID, 'slam_testimonial_author', true);
	?>
	<?php if( $slam_testimonial_text !== '' ) : ?>
		<section class="testimonial">
			<div class="row">
				<div class="small-12 columns">
					<p id="quote"><?php echo $slam_testimonial_text; ?></p>
					<p id="customer-name">-<?php echo $slam_testimonial_author; ?></p>
				</div>
			</div>
		</section>
	<?php endif; ?>

	


	<?php get_template_part( 'parts/footer', 'cta' ); ?>

<?php endwhile; else : ?>

	<?php get_template_part( 'parts/content', 'missing' ); ?>

<?php endif; ?>

<?php get_footer(); ?>