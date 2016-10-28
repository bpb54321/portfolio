<?php 
/**
 * @param Boolean $expanded : Whether the image link grid should expand to full width, or have a Foundation default max-width.
 */
function echo_image_link_grid( $projects_query, $num_projects_row_medium, $image_overlay_style, $expanded = true, $subheader_array = null ) {

	if ( $expanded ) {
		$expanded_class = "expanded";
	} else {
		$expanded_class = "";
	}
	
	$total_available_projects = sizeof($projects_query->posts);

	$num_project_rows = ceil( $total_available_projects/$num_projects_row_medium ) ;

	$num_columns_project = 12 / $num_projects_row_medium; 

	echo "<section class='project-gallery' data-project-count='{$total_available_projects}'>";
		for ( $project_count = 0, $row_count = 0; $project_count < $total_available_projects; $project_count++, $row_count = floor($project_count/$num_projects_row_medium) ) {
			if ( $project_count % $num_projects_row_medium == 0 ) {
				echo "<div class='row {$expanded_class}'>";
			}
					echo "<div class='small-12 medium-{$num_columns_project} columns project-thumbnail-container'>";
						$project = $projects_query->posts[$project_count];
						$image_src_string = get_featured_image_src( $project, 'large' );
						$project_permalink = get_permalink( $project );
					
						if ( $image_overlay_style == "hover_title_categories" ) {
							$project_post_category_string = get_post_category_string($project);
							$project_grid_tile_html = 

							"<div class='project-thumbnail project-thumbnail-{$project_count}' style='background-image: url( {$image_src_string} )'>
								<a href='{$project_permalink}'>
									<div class='project-thumbnail-overlay'>
										<h5 class='project-title'>{$project->post_title}</h5>
										<hr>
										<h5 class='project-category'>{$project_post_category_string}</h5>
									</div>
								</a>
							</div>";
						} elseif ( $image_overlay_style == "static_title_only") {
							$project_grid_tile_html =

							"<div class='project-thumbnail project-thumbnail-{$project_count}' style='background-image: url( {$image_src_string} )'>
								<a href='{$project_permalink}'>
									<div class='project-thumbnail-overlay'>
									</div>
									<div class='image-link-overlay'>
										<div class='il-overlay-text-container'>
											<h5 class='image-link-title'>{$project->post_title}</h5>
											<p class='image-link-subheader'>{$subheader_array[$project_count]}</p>
										</div>
									</div>
								</a>
							</div>";
						}
							
						echo $project_grid_tile_html;
					echo "</div>";
			if ( $project_count%$num_projects_row_medium==($num_projects_row_medium-1) ) {
				echo "</div><!--End .row-->";
			}
		} 
		wp_reset_postdata();
	echo "</section>";
}