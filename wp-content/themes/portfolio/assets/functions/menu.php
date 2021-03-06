<?php
// Register theme_location's for menus
register_nav_menus(
	array(
		'main-nav' => __( 'The Main Menu', 'jointswp' ),   // Main nav in header
		'top-footer-menu' => 'Top Footer Menu',
        'bottom-footer-menu' => 'Bottom Footer Menu',
        'middle-footer-menu' => 'Middle Footer Menu',
	)
);

// The Top Menu
function joints_top_nav() {
	 wp_nav_menu(array(
        'container' => false,                           // Remove nav container
        'menu_class' => '',       // Adding custom nav class
        'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
        'theme_location' => 'main-nav',        			// Where it's located in the theme
        'depth' => 5,                                   // Limit the depth of the nav
        'fallback_cb' => false,                         // Fallback function (see below)
        'walker' => new Topbar_Menu_Walker()
    ));
}

// Big thanks to Brett Mason (https://github.com/brettsmason) for the awesome walker
class Topbar_Menu_Walker extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = Array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"menu\">\n";
    }
}

// The Off Canvas Menu
function joints_off_canvas_nav() {
	 wp_nav_menu(array(
        'container' => false,                           // Remove nav container
        'menu_class' => 'vertical menu',       // Adding custom nav class
        'items_wrap' => '<ul id="%1$s" class="%2$s" data-accordion-menu>%3$s</ul>',
        'theme_location' => 'main-nav',        			// Where it's located in the theme
        'depth' => 5,                                   // Limit the depth of the nav
        'fallback_cb' => false,                         // Fallback function (see below)
        'walker' => new Off_Canvas_Menu_Walker()
    ));
}

class Off_Canvas_Menu_Walker extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = Array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"vertical menu\">\n";
    }
}

// The Footer Menu
/*function joints_footer_links() {
    wp_nav_menu(array(
    	'container' => 'false',                         // Remove nav container
    	'menu' => __( 'Footer Links', 'jointswp' ),   	// Nav name
    	'menu_class' => 'menu',      					// Adding custom nav class
    	'theme_location' => 'footer-links',             // Where it's located in the theme
        'depth' => 0,                                   // Limit the depth of the nav
    	'fallback_cb' => ''  							// Fallback function
	));
} */

// Refine Footer Top Menu
function refine_top_footer_menu() {
    wp_nav_menu(array(
        'container' => 'false',                         // Remove nav container
        //'menu' => 'Footer Top Menu',                    // Nav name
        'menu_class' => 'footer-list',                  // Adding custom nav class
        'theme_location' => 'top-footer-menu',          // Where it's located in the theme
        'depth' => 0,                                   // Limit the depth of the nav
        'fallback_cb' => ''                             // Fallback function
    ));
} /* End Footer Menu */

// Refine Footer Bottom Menu
function refine_bottom_footer_menu() {
    wp_nav_menu(array(
        'container' => 'false',                         // Remove nav container
        //'menu' => 'Footer Bottom Menu',                    // Nav name
        'menu_class' => 'footer-list justify-content-center',                  // Adding custom nav class
        'theme_location' => 'bottom-footer-menu',          // Where it's located in the theme
        'depth' => 0,                                   // Limit the depth of the nav
        'fallback_cb' => ''                             // Fallback function
    ));
} /* End Footer Menu */

// Refine Footer Middle Menu
function refine_middle_footer_menu() {
    wp_nav_menu(array(
        'container' => 'false',                         // Remove nav container
        //'menu' => 'Footer Bottom Menu',                    // Nav name
        'menu_class' => 'footer-list justify-content-center',                  // Adding custom nav class
        //'theme_location' => 'bottom-footer-menu',       // Where it's located in the theme
        'depth' => 0,                                   // Limit the depth of the nav
        'fallback_cb' => ''                             // Fallback function
    ));
} /* End Footer Menu */

// Header Fallback Menu
function joints_main_nav_fallback() {
	wp_page_menu( array(
		'show_home' => true,
    	'menu_class' => '',      						// Adding custom nav class
		'include'     => '',
		'exclude'     => '',
		'echo'        => true,
        'link_before' => '',                           // Before each link
        'link_after' => ''                             // After each link
	) );
}

// Footer Fallback Menu
function joints_footer_links_fallback() {
	/* You can put a default here if you like */
}

// Add Foundation active class to menu
function required_active_nav_class( $classes, $item ) {
    if ( $item->current == 1 || $item->current_item_ancestor == true ) {
        $classes[] = 'active';
    }
    return $classes;
}
add_filter( 'nav_menu_css_class', 'required_active_nav_class', 10, 2 );

//Attempt to add a Facebook scheme to a menu link tag, but not working
/*function filter_menu_for_facebook( $items, $args ) {

    if ( $args->menu->slug == "footer-social-icons" ) {
        $items = str_replace ( "http://facebook.com" , "fb://pages" , $items );

        error_log('----------------$items----------------');
        error_log( print_r( $items, true) );
        error_log('----------------$args----------------');
        error_log( print_r( $args, true) );
    }
}
//Filter the html for the social links menu
add_filter ( "wp_nav_menu_items", 'filter_menu_for_facebook', 10, 2 );*/
