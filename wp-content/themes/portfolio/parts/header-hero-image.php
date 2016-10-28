<?php
//Check to see if any functions are hooked to the 'mh_display_media_header' action

if ( has_action('mh_display_media_header') ) {
    do_action( 'mh_display_media_header', $post->ID ); //The Media Header plugin uses this hook to display a media header.
} else {
    //Display a default responsive header featured image
    $post_thumbnail_id = get_post_thumbnail_id ( $post_id );

    $widths_and_urls = get_image_widths_and_urls( $post_thumbnail_id );

    $json_widths_and_urls = json_encode($widths_and_urls);

    echo "<div class='hero-image' data-image-data='{$json_widths_and_urls}'></div>";
}