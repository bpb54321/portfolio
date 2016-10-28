<?php 
/*
Template Name: Project List Page
 */
?>
<?php get_header(); ?>

<?php get_template_part( 'parts/header', 'hero-image' ); ?>

<section class="content">

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<article class="main-article">
			<h3 class="title"><?php the_title(); ?></h3>
	    	<?php the_content(); ?>
		</article>
		
		<?php 
			$num_project_rows = 3; 
			$num_projects_row_medium = 3; //Must divide evenly into 12
			$total_displayed_projects = $num_project_rows * $num_projects_row_medium;
			$num_columns_project = 12 / $num_projects_row_medium; 

			// WP_Query arguments
			$args = array (
				'post_type'              => array( 'project' ),
				'post_status'            => array( 'publish' ),
				'nopaging'               => false,
				'posts_per_page'         => $total_displayed_projects,
			);

			// The Query
			$projects_query = new WP_Query( $args );
			//error_log( var_export($projects_query,true) );
			$total_available_projects = sizeof($projects_query->posts); //In case there are fewer projects than you requested
		?>
		<section id="project-list-grid" data-project-count="<?php echo $total_available_projects; ?>">
			<?php for ( $project_count=0, $row_count=0; $project_count<$total_available_projects; $project_count++, $row_count=floor($project_count/$num_projects_row_medium) ) : ?>
				<?php //error_log('$project_count = ' . $project_count . ' ' . '$row_count = ' . $row_count . ' ' ); ?>
				<?php //error_log('$project_count%$num_projects_row_medium = ' . $project_count%$num_projects_row_medium ); ?>
				<?php if ( $project_count%$num_projects_row_medium==0 ) : ?>
					<?php //error_log('Adding div.row'); ?>
					<div class="row">
				<?php endif; ?>
						<div id="project-thumbnail-container-<?php echo $project_count; ?>" class="small-12 medium-<?php echo $num_columns_project; ?> columns project-thumbnail-container">
						<?php
							$project = $projects_query->posts[$project_count];
							$image_src_string = get_featured_image_src( $project, 'large' );

							$project_permalink = get_permalink( $project );
							//error_log('--------------------$project_permalink------------------------'); 
							//error_log( var_export($project_permalink, true) );
							
							$project_title = $project->post_title;
							//error_log('--------------------$project_title------------------------'); 
							//error_log( var_export($project_title, true) );
							
							//the get_post_category_string function (functions.php) already inserts a &nbsp if categories are empty.
							$project_categories = get_post_category_string($project);


							//error_log('--------------------$project_categories------------------------'); 
							//error_log( var_export($project_categories, true) );
							
							$project_year = get_post_meta($project->ID, 'slam_project_year', true);
							if ( $project_year === '' ) { //Check for blank values for styling purposes
								$project_year = '&nbsp;';
							} 
						?>
							<a href="<?php echo $project_permalink; ?>">
								<div class="project-thumbnail" id="project-thumbnail-<?php echo $project_count; ?>" style="background-image: url('<?php echo $image_src_string; ?>')">
								</div>
								<div class="project-thumbnail-details">
									<h5 class="project-title"><?php echo $project_title; ?></h5>
									<!-- <hr> -->
									<h5 class="project-category"><?php echo $project_categories; ?></h5>
									<h5 class="project-year"><?php echo $project_year; ?></h5>
								</div>
							</a>
							
						</div>
				<?php if ( $project_count%$num_projects_row_medium==($num_projects_row_medium-1) ) : ?>
					<?php //error_log('Closing div.row'); ?>
					</div><!--End .row-->
				<?php endif; ?>
			<?php endfor; wp_reset_postdata(); ?>
		</section>
    	
    <?php endwhile; else : ?>

   		<?php get_template_part( 'parts/content', 'missing' ); ?>

    <?php endif; ?>

</section>

<?php get_template_part( 'parts/footer', 'cta' ); ?>

<?php get_footer(); ?>


