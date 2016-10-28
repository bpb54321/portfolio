<?php
	//Logic processing for the page
	$link_to_file_link_group = get_post_meta($post->ID, 'link_to_file_link_group', false);
	
?>
<?php get_header(); ?>

<?php get_template_part( 'parts/header', 'hero-image' ); ?>

<section class="content">

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<article class="main-article">
			<h3 class="title"><?php the_title(); ?></h3>

<?php if ( sizeof( $link_to_file_link_group ) > 0 ) : ?>

	<?php $link_to_file_link_group = $link_to_file_link_group[0]; ?>
					
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


