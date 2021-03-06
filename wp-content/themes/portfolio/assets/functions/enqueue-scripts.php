<?php
function site_scripts() {
  global $wp_styles; // Call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way

    // Load What-Input files in footer
    wp_enqueue_script( 'what-input', get_template_directory_uri() . '/vendor/what-input/what-input.min.js', array(), '', true );

    // Adding Foundation scripts file in the footer
    wp_enqueue_script( 'foundation-js', get_template_directory_uri() . '/assets/js/foundation.js', array( 'jquery' ), '6.2', true );

    // Adding Waypoints framework
    wp_enqueue_script( 'waypoints', get_template_directory_uri() . '/node_modules/waypoints/lib/jquery.waypoints.min.js', array( 'jquery' ), '', true );

    // Adding the Waypoints Inview framework
    wp_enqueue_script( 'waypoints-inview', get_template_directory_uri() . '/node_modules/waypoints/lib/shortcuts/inview.min.js', array( 'jquery' ), '', true );

    //Adding the Slick.js photo gallery framework
    wp_enqueue_script( 'slick-js', get_template_directory_uri() . '/vendor/slick/slick.min.js', array( 'jquery' ), '', true );

    //Enqueue Images Loaded JS
    wp_enqueue_script( 'images-loaded', 'https://npmcdn.com/imagesloaded@4.1/imagesloaded.pkgd.min.js', array( 'jquery' ), null, true );

    // Adding scripts file in the footer
    wp_enqueue_script( 'site-js', get_template_directory_uri() . '/assets/js/scripts.js', array( 'jquery', 'images-loaded' ), '', true );

    // Register main stylesheet
    wp_enqueue_style( 'site-css', get_template_directory_uri() . '/assets/css/style.min.css', array(), '', 'all' );

    // Comment reply script for threaded comments
    if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
      wp_enqueue_script( 'comment-reply' );
    }

}
add_action('wp_enqueue_scripts', 'site_scripts', 999);
