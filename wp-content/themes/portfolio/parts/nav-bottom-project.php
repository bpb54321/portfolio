<?php
  $prev_project_permalink = get_adjacent_custom_post_type( $post, 'project', 'before' );
  $next_project_permalink = get_adjacent_custom_post_type( $post, 'project', 'after' );
 ?>
<div class="row">
	<div class="small-12 columns">
		<a href="<?php echo get_bloginfo( 'url' ); ?>" class="back-to-work">Back to Work</a>
		<div class="prev-next-container">
			<?php if( $prev_project_permalink !== '' ) : ?>
				<a href="<?=$prev_project_permalink?>" class="prev">prev</a>
			<?php endif; ?>
			<?php if ( ( $prev_project_permalink !== '' ) && ( $next_project_permalink !== '' ) ) : ?>
				/
			<?php endif; ?>
			<?php if( $next_project_permalink !== '' ) : ?>
				<a href="<?=$next_project_permalink?>" class="next">next</a>
			<?php endif; ?>
		</div>
	</div>
</div>
