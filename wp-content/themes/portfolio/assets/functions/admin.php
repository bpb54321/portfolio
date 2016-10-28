<?php
// This file handles the admin area and functions - You can use this file to make changes to the dashboard.

/************* DASHBOARD WIDGETS *****************/
// Disable default dashboard widgets
function disable_default_dashboard_widgets() {
	// Remove_meta_box('dashboard_right_now', 'dashboard', 'core');    // Right Now Widget
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'core'); // Comments Widget
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');  // Incoming Links Widget
	remove_meta_box('dashboard_plugins', 'dashboard', 'core');         // Plugins Widget

	// Remove_meta_box('dashboard_quick_press', 'dashboard', 'core');  // Quick Press Widget
	remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');   // Recent Drafts Widget
	remove_meta_box('dashboard_primary', 'dashboard', 'core');         //
	remove_meta_box('dashboard_secondary', 'dashboard', 'core');       //

	// Removing plugin dashboard boxes
	remove_meta_box('yoast_db_widget', 'dashboard', 'normal');         // Yoast's SEO Plugin Widget

}

/*
For more information on creating Dashboard Widgets, view:
http://digwp.com/2010/10/customize-wordpress-dashboard/
*/

// RSS Dashboard Widget
function joints_rss_dashboard_widget() {
	if(function_exists('fetch_feed')) {
		include_once(ABSPATH . WPINC . '/feed.php');               // include the required file
		$feed = fetch_feed('http://jointswp.com/feed/rss/');        // specify the source feed
		$limit = $feed->get_item_quantity(5);                      // specify number of items
		$items = $feed->get_items(0, $limit);                      // create an array of items
	}
	if ($limit == 0) echo '<div>' . __( 'The RSS Feed is either empty or unavailable.', 'jointswp' ) . '</div>';   // fallback message
	else foreach ($items as $item) { ?>

	<h4 style="margin-bottom: 0;">
		<a href="<?php echo $item->get_permalink(); ?>" title="<?php echo mysql2date(__('j F Y @ g:i a', 'jointswp'), $item->get_date('Y-m-d H:i:s')); ?>" target="_blank">
			<?php echo $item->get_title(); ?>
		</a>
	</h4>
	<p style="margin-top: 0.5em;">
		<?php echo substr($item->get_description(), 0, 200); ?>
	</p>
	<?php }
}

// Calling all custom dashboard widgets
function joints_custom_dashboard_widgets() {
	wp_add_dashboard_widget('joints_rss_dashboard_widget', __('Custom RSS Feed (Customize in admin.php)', 'jointswp'), 'joints_rss_dashboard_widget');
	/*
	Be sure to drop any other created Dashboard Widgets
	in this function and they will all load.
	*/
}
// removing the dashboard widgets
add_action('admin_menu', 'disable_default_dashboard_widgets');
// adding any custom widgets
add_action('wp_dashboard_setup', 'joints_custom_dashboard_widgets');

/************* CUSTOMIZE ADMIN *******************/
// Custom Backend Footer
function joints_custom_admin_footer() {
	_e('<span id="footer-thankyou">Developed by <a href="#" target="_blank">Your Site Name</a></span>.', 'jointswp');
}

// adding it to the admin area
add_filter('admin_footer_text', 'joints_custom_admin_footer');

/***************CUSTOMIZE THE THEME CUSTOMIZER************/
function refinestl_customize_register( $wp_customize ) {
  // Do stuff with $wp_customize, the WP_Customize_Manager object.
	$wp_customize->add_section( 'logo_section', array(
        'title'    => __( 'Logos', 'textdomain' ),
        'priority' => 101,
    ) );
 
    $wp_customize->add_setting( 'site_logo', array(
        'type' => 'theme_mod',
        'default'           => '',
        'transport'         => 'postMessage',
        'sanitize_callback' => '',
    ) );
 
    $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'media_control', array(
    'label' => __( 'Site Logo' ),
    'section' => 'logo_section',
    'settings' => 'site_logo',
) ) );

    //----------------------Google Analytics Snippet Section-------------------------//
	$wp_customize->add_section( 'google_analytics_section', array(
        'title'    => __( 'Googe Analytics', 'textdomain' ),
        'priority' => 101,
    ) );

	$wp_customize->add_setting( 'google_analytics_code_snippet', array(
        'type' => 'theme_mod',
        'default'           => '',
        'transport'         => 'postMessage',
        'sanitize_callback' => '',
    ) );

	$wp_customize->add_control( 'analytics_code_snipper_control', array(
		'label' => __( 'Google Analytics Code Snippet' ),
		'description' => __( 'Copy and paste your Google Analytics embed code here.' ),
		'section' => 'google_analytics_section',
		'type' => 'textarea',
		'settings' => 'google_analytics_code_snippet',
	) );


	//--------------------------------------------------------------------------------//
}
add_action( 'customize_register', 'refinestl_customize_register' );

/*********************ENQUEUE SCRIPTS AND STYLES FOR CUSTOM METABOXES****************************/

function load_custom_wp_admin_style() {
	//Enqueue stylesheets for metaboxes
    wp_enqueue_style( 'meta-box-css', get_template_directory_uri() . '/lib/classes/metaboxes/css/meta_box.css', array(), '', 'all' );
    wp_enqueue_style( 'jqueryui-css', get_template_directory_uri() . '/lib/classes/metaboxes/css/jqueryui.css', array(), '', 'all' );
    wp_enqueue_style( 'chosen-css', get_template_directory_uri() . '/lib/classes/metaboxes/css/chosen.css', array(), '', 'all' );

    //Enqueue scripts for metaboxes
    wp_enqueue_script( 'chosen-js', get_template_directory_uri() . '/lib/classes/metaboxes/js/chosen.js', array( 'jquery' ), '', true );
    //For some reason, this is being enqueued in another spot, but I don't know where else it's being enqueued!  In any case, we only need one.
    //wp_enqueue_script( 'scripts-js', get_template_directory_uri() . '/lib/classes/metaboxes/js/scripts.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'scripts-ck-js', get_template_directory_uri() . '/lib/classes/metaboxes/js/scripts-ck.js', array( 'jquery' ), '', true );


}
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );
/************************************************************************************************/