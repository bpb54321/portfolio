<?php get_header(); ?>

<?php get_template_part( 'parts/header', 'hero-image' ); ?>

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<article class="main-article">
			<h3 class="title"><?php the_title(); ?></h3>
	    	<?php the_content(); ?>
		</article>
		
		<?php
			//-----------------------Photo Gallery-------------------------------------//
			$photo_gallery_id_string = get_post_meta( $post->ID, 'slam_photo_order', true); //True that it will be single value
			//error_log( '------------------------------------$photo_gallery_id_string---------------------------------');
			//error_log( print_r($photo_gallery_id_string, true) );
			if ( $photo_gallery_id_string == '' ) {
				$photo_gallery_id_array = [];
			} else {
				$photo_gallery_id_array = explode(',', $photo_gallery_id_string);
			}
			//error_log( '------------------------------------$photo_gallery_id_array---------------------------------');
			//error_log( print_r($photo_gallery_id_array, true) );

			$featured_gallery_html =	'<div class="featured-image-gallery" >' . "\r";
			$gallery_html =			'<div class="image-gallery" >' . "\r";
			foreach ($photo_gallery_id_array as $photo_gallery_id ) {
				$image_src_array = wp_get_attachment_image_src ( $photo_gallery_id, 'large', false );
				//error_log('--------------------$image_src_array------------------------'); 
				//error_log( var_export($image_src_array, true) );
	
				$image_src_string = $image_src_array[0];
				$featured_gallery_html .= 	"<img class='gallery-item'  src='{$image_src_string}' > \r";
				$gallery_html .= 	"<img class='gallery-item'  src='{$image_src_string}' > \r";
			}
			$featured_gallery_html .= '</div>' . "\r"; //Close the gallery divs
			$gallery_html .=          '</div>' . "\r";

			$num_photos_in_gallery = count( $photo_gallery_id_array );

			$total_gallery_html = "<div class='gallery-container' data-num-photos='{$num_photos_in_gallery}' > \r";
			$total_gallery_html .= 	$featured_gallery_html;
			$total_gallery_html .= 	$gallery_html ;
			$total_gallery_html .= '</div>' . "\r";


			echo $total_gallery_html;
		?>
    	
    <?php endwhile; else : ?>

   		<?php get_template_part( 'parts/content', 'missing' ); ?>

    <?php endif; ?>

</section>

<section class="call-to-action">
	<h6>Ready to remodel? Talk to a designer today.</h6>
	<button class="cta-button">Request a Design Consultation</button>
</section>

<?php get_footer(); ?>


