
<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<!--Image Link Grid for Projects -->
	<?php

		//Query all available projects
		$args = array (
			'post_type'              => array( 'project' ),
			'post_status'            => array( 'publish' ),
			'nopaging'               => false,
			'posts_per_page'         => 999,
		);

		// The Query
		$projects_query = new WP_Query( $args );

		$num_projects_row_medium = get_post_meta($post->ID, 'front_page_project_grid_num_columns_selection', true);

		if ( $num_projects_row_medium === '' ) {
			$num_projects_row_medium = 3; //Default value in case the meta value hasn't been saved to the db yet
		}

		$image_overlay_style = "hover_title_categories";

		$total_available_projects = sizeof($projects_query->posts);

		$num_project_rows = ceil( $total_available_projects/$num_projects_row_medium ) ;

		$num_columns_project = 12 / $num_projects_row_medium;
		?>

		<section class='project-gallery' data-project-count='<?=$total_available_projects?>'>
			<?php for ( $project_count = 0, $row_count = 0; $project_count < $total_available_projects; $project_count++, $row_count = floor($project_count/$num_projects_row_medium) ) : ?>
				<?php
					$project = $projects_query->posts[$project_count];
					$image_src_string = get_featured_image_src( $project, 'large' );
					$project_permalink = get_permalink( $project );
				?>
				<?php if ( $project_count % $num_projects_row_medium == 0 ) : ?>
					<div class='row'>
				<?php endif; ?>
						<div class='small-12 medium-<?=$num_columns_project?> columns project-thumbnail-container'>
							<a href='<?=$project_permalink?>'>
								<div class='project-thumbnail project-thumbnail-<?=$project_count?>' style='background-image: url( <?=$image_src_string?> )'>
									<div class="project-thumbnail-overlay">
										<div class="spinning-ring"></div>
									</div>
								</div>
								<h5 class='project-title'><?=$project->post_title?></h5>
						  </a>
						</div>
				<?php if ( $project_count%$num_projects_row_medium == ($num_projects_row_medium-1) ) : ?>
					</div><!--End .row-->
				<?php endif; ?>
			<?php endfor; ?>
		</section>

	<section class="summary-text">
		<?php the_content(); ?>
	</section>

	<?php get_template_part( 'parts/footer', 'cta' ); ?>

<?php endwhile; else : ?>

	<?php get_template_part( 'parts/content', 'missing' ); ?>

<?php endif; ?>

<?php get_footer(); ?>
