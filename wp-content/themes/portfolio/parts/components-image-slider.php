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
	foreach ($photo_gallery_id_array as $photo_gallery_id ) {
		$large_image_src_array = wp_get_attachment_image_src ( $photo_gallery_id, 'large', false );
		//error_log('--------------------$large_image_src_array------------------------'); 
		//error_log( var_export($large_image_src_array, true) );
		$large_image_src_string = $large_image_src_array[0];

		//If the image size does not exist, it returns the full image path
		$img_600w_src_array = wp_get_attachment_image_src ( $photo_gallery_id, 'img_600w', false );
		//error_log('--------------------$img_600w_src_array------------------------'); 
		//error_log( var_export($img_600w_src_array, true) );
		$img_600w_src_string = $img_600w_src_array[0];

		$img_900w_src_array = wp_get_attachment_image_src ( $photo_gallery_id, 'img_900w', false );
		$img_900w_src_string = $img_900w_src_array[0];

		$img_1200w_src_array = wp_get_attachment_image_src ( $photo_gallery_id, 'img_1200w', false );
		$img_1200w_src_string = $img_1200w_src_array[0];

		$img_1500w_src_array = wp_get_attachment_image_src ( $photo_gallery_id, 'img_1500w', false );
		$img_1500w_src_string = $img_1500w_src_array[0];

		$img_html = "<picture>" . 
						"<source media='(min-width: 20px) and (max-width: 1024px)' srcset='{$img_600w_src_string}' />" .
						"<source media='(min-width: 1024px) and (max-width: 1356px)' srcset='{$img_900w_src_string}' />" .
						"<source media='(min-width: 1356px) and (max-width: 1700px )' srcset='{$img_1200w_src_string}' />" .
						"<source media='(min-width: 1700px)' srcset='{$img_1500w_src_string}' />" .
						"<img src='{$large_image_src_string}' />" .
					"</picture>";

		$featured_gallery_html .= $img_html;

	}
	$featured_gallery_html .= '</div>' . "\r"; //Close the gallery divs

	$num_photos_in_gallery = count( $photo_gallery_id_array );

	$total_gallery_html = "<div class='gallery-container' data-num-photos='{$num_photos_in_gallery}' > \r";
	$total_gallery_html .= 	$featured_gallery_html;
	$total_gallery_html .= '</div>' . "\r";

	echo $total_gallery_html;
?>