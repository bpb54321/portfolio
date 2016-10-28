<?php

/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB2 directory)
 *
 * Be sure to replace all instances of 'cmb2_' with your project's prefix.
 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
 *
 * @category YourThemeOrPlugin
 * @package  Demo_CMB2
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/WebDevStudios/CMB2
 */

/**
 * Get the bootstrap! If using the plugin from wordpress.org, REMOVE THIS!
 */

if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/cmb2/init.php';
} elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/CMB2/init.php';
}

/**
 * Conditionally displays a metabox when used as a callback in the 'show_on_cb' cmb2_box parameter
 *
 * @param  CMB2 object $cmb CMB2 object
 *
 * @return bool             True if metabox should show
 */
function cmb2_show_if_front_page( $cmb ) {
	// Don't show this metabox if it's not the front page template
	if ( $cmb->object_id !== get_option( 'page_on_front' ) ) {
		return false;
	}
	return true;
}


/**
 * Conditionally displays a field when used as a callback in the 'show_on_cb' field parameter
 *
 * @param  CMB2_Field object $field Field object
 *
 * @return bool                     True if metabox should show
 */
function cmb2_hide_if_no_cats( $field ) {
	// Don't show this field if not in the cats category
	if ( ! has_tag( 'cats', $field->object_id ) ) {
		return false;
	}
	return true;
}

/**
 * Conditionally displays a message if the $post_id is 2
 *
 * @param  array             $field_args Array of field parameters
 * @param  CMB2_Field object $field      Field object
 */
function cmb2_before_row_if_2( $field_args, $field ) {
	if ( 2 == $field->object_id ) {
		echo '<p>Testing <b>"before_row"</b> parameter (on $post_id 2)</p>';
	} else {
		echo '<p>Testing <b>"before_row"</b> parameter (<b>NOT</b> on $post_id 2)</p>';
	}
}

add_action( 'cmb2_admin_init', 'register_about_page_template_metaboxes' );
function register_about_page_template_metaboxes()
{
    $prefix = 'about_page_';
    $about_page_metabox = new_cmb2_box( array(
        'id'            => $prefix . 'metabox',
        'title'         => __( 'About Page Employee List Settings', 'cmb2' ),
        'object_types'  => array( 'page', ), // Post type
        // 'show_on_cb' => 'cmb2_show_if_front_page', // function should return a bool value
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true, // Show field names on the left
        'show_on'      => array( 'key' => 'page-template', 'value' => 'page-about.php' ), //Templates to show on
        // 'cmb_styles' => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // true to keep the metabox closed by default
    ) );

    $employee_group_field = $about_page_metabox->add_field( array(
        'id'          => $prefix . 'employee_group',
        'type'        => 'group',
        'description' => __( 'An employee', 'cmb2' ),
        'options'     => array(
            'group_title'   => __( 'Employee {#}', 'cmb2' ), // {#} gets replaced by row number
            'add_button'    => __( 'Add Another Employee', 'cmb2' ),
            'remove_button' => __( 'Remove Employee', 'cmb2' ),
            'sortable'      => true, // beta
            // 'closed'     => true, // true to have the groups closed by default
        ),
    ) );

    $about_page_metabox->add_group_field( $employee_group_field, array(
        'name'       => __( 'Employee Name', 'cmb2' ),
        'desc'       => __( '', 'cmb2' ),
        'id'         => 'name',
        'type'       => 'text',
        //'default' => '',
    ) );

    $about_page_metabox->add_group_field( $employee_group_field, array(
        'name'       => __( 'Employee Title', 'cmb2' ),
        'desc'       => __( '', 'cmb2' ),
        'id'         => 'title',
        'type'       => 'text',
        //'default' => '',
    ) );

    $about_page_metabox->add_group_field( $employee_group_field, array(
        'name'       => __( 'Employee Bio/Summary', 'cmb2' ),
        'desc'       => __( '', 'cmb2' ),
        'id'         => 'bio',
        'type'       => 'textarea',
        //'default' => '',
    ) );

    $about_page_metabox->add_group_field( $employee_group_field, array(
        'name'       => __( 'Employee Email', 'cmb2' ),
        'desc'       => __( '', 'cmb2' ),
        'id'         => 'email',
        'type'       => 'text',
        //'default' => '',
    ) );

    $about_page_metabox->add_group_field( $employee_group_field, array(
        'name'       => __( 'Employee Phone', 'cmb2' ),
        'desc'       => __( '', 'cmb2' ),
        'id'         => 'phone',
        'type'       => 'text',
        //'default' => '',
    ) );

    $about_page_metabox->add_group_field( $employee_group_field, array(
        'name' => __( 'Employee Thumbnail Photo', 'cmb2' ),
        'desc' => __( 'Select or upload a photo.', 'cmb2' ),
        'id'   => 'photo',
        'type' => 'file',
    ) );
}

add_action( 'cmb2_admin_init', 'cmb2_register_page_metaboxes' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function cmb2_register_page_metaboxes() {
	
//--------------------------------File Upload/Link to File Metabox--------------------//
	$prefix = 'link_to_file_';
	$link_to_file_metabox = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => __( 'Link to Media File (for uploading a brochure, etc)', 'cmb2' ),
		'object_types'  => array( 'project', 'page' ), // Post type
		// 'show_on_cb' => 'cmb2_show_if_front_page', // function should return a bool value
		// 'context'    => 'normal',
		// 'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
	) );

	$link_group = $link_to_file_metabox->add_field( array(
		'id'          => $prefix . 'link_group',
		'type'        => 'group',
		'description' => __( 'A link for a brochure, etc.', 'cmb2' ),
		'options'     => array(
			'group_title'   => __( 'Link {#}', 'cmb2' ), // {#} gets replaced by row number
			'add_button'    => __( 'Add Another Link', 'cmb2' ),
			'remove_button' => __( 'Remove Link', 'cmb2' ),
			'sortable'      => true, // beta
			// 'closed'     => true, // true to have the groups closed by default
		),
	) );

	$link_to_file_metabox->add_group_field( $link_group, array(
		'name'       => __( 'Link Text', 'cmb2' ),
		'desc'       => __( 'The text for link.', 'cmb2' ),
		'id'         => $prefix . 'text',
		'type'       => 'text',
		//'default' => 'Brochure {#}',
	) );

	$link_to_file_metabox->add_group_field( $link_group, array(
		'name' => __( 'Media File Upload', 'cmb2' ),
		'desc' => __( 'Select or upload a media file.', 'cmb2' ),
		'id'   => $prefix . 'media_file',
		'type' => 'file',
	) );


//--------------------------------Front Page Top CTA Button--------------------//
	$prefix = 'front_page_top_cta_button_';
	$front_page_image_links_metabox = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => __( 'Front Page Top CTA Button', 'cmb2' ),
		'object_types'  => array( 'page', ), // Post type
		'show_on_cb' => 'cmb2_show_if_front_page', // function should return a bool value
		// 'context'    => 'normal',
		// 'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		'closed'     => false, // true to keep the metabox closed by default
	) );

	$front_page_image_links_metabox->add_field( array(
		'name'             => __( 'Button Text', 'cmb2' ),
		'desc'             => __( 'The text in the button.', 'cmb2' ),
		'id'               => $prefix . 'text',
		'type'             => 'text_small',
	) );
//-------------------------------------------------------------------------//
//--------------------------------Front Page Project Grid Num Columns--------------------//
	$prefix = 'front_page_project_grid_num_columns_';
	$front_page_project_grid_num_columns_metabox = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => __( 'Front Page Project Grid Num Columns', 'cmb2' ),
		'object_types'  => array( 'page', ), // Post type
		'show_on_cb' => 'cmb2_show_if_front_page', // function should return a bool value
		// 'context'    => 'normal',
		// 'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		'closed'     => false, // true to keep the metabox closed by default
	) );

	$front_page_project_grid_num_columns_metabox->add_field( array(
		'name'             => __( 'Number of Columns Per Row of Project Grid', 'cmb2' ),
		'desc'             => __( 'Select the number of columns per row for the project/model grid on the home page.', 'cmb2' ),
		'id'               => $prefix . 'selection',
		'type'             => 'select',
		'show_option_none' => false,
		'options'          => [
								'3' => '3',
								'2' => '2',
								],
	) );
//-------------------------------------------------------------------------//
//--------------------------------Repeatable Front Page Image Links--------------------//
	$prefix = 'front_page_image_links_';
	$front_page_image_links_metabox = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => __( 'Front Page Image Links', 'cmb2' ),
		'object_types'  => array( 'page', ), // Post type
		'show_on_cb' => 'cmb2_show_if_front_page', // function should return a bool value
		// 'context'    => 'normal',
		// 'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		'closed'     => false, // true to keep the metabox closed by default
	) );

	$front_page_image_links_metabox->add_field( array(
		'name'             => __( 'Number of Columns Per Row for Image Link Grid', 'cmb2' ),
		'desc'             => __( 'Select the number of columns per row for the image link grid on the home page.', 'cmb2' ),
		'id'               => $prefix . 'num_columns',
		'type'             => 'select',
		'show_option_none' => false,
		'options'          => [
								'2' => '2',
								'3' => '3',
								],
	) );

	$pages_array = create_pages_array();



	//error_log('-----------------$pages_array------------------');
	//error_log( print_r( $pages_array,true) );

	$image_link_group = $front_page_image_links_metabox->add_field( array(
		'id'          => $prefix . 'image_link_group',
		'type'        => 'group',
		'description' => __( 'An image link to a page.', 'cmb2' ),
		'options'     => array(
			'group_title'   => __( 'Image Link {#}', 'cmb2' ), // {#} gets replaced by row number
			'add_button'    => __( 'Add Another Image Link', 'cmb2' ),
			'remove_button' => __( 'Remove Image Link', 'cmb2' ),
			'sortable'      => true, // beta
			// 'closed'     => true, // true to have the groups closed by default
		),
	) );

	$front_page_image_links_metabox->add_group_field( $image_link_group, array(
		'name'             => __( 'Page to Link To', 'cmb2' ),
		'desc'             => __( 'Select a page from the site to link to.', 'cmb2' ),
		'id'               => $prefix . 'selection',
		'type'             => 'select',
		'show_option_none' => true,
		'options'          => $pages_array,
	) );

	$front_page_image_links_metabox->add_group_field( $image_link_group, array(
		'name' => __( 'Subheader Text', 'cmb2' ),
		'desc' => __( 'A small paragraph that will appear under the page title.  Text will be cut off if too long.', 'cmb2' ),
		'id'   => $prefix . 'subheader_text',
		'type' => 'textarea',
	) );

	/*$front_page_image_links_metabox->add_field( array(
		'name'             => __( 'Page to Link To', 'cmb2' ),
		'desc'             => __( 'There will be an image link on the front page linking to each selected page.', 'cmb2' ),
		'id'               => $prefix . 'selection',
		'type'             => 'select',
		'show_option_none' => true,
		'options'          => $pages_array,
		'repeatable' 	   => true,
	) );

	$front_page_image_links_metabox->add_field( array(
		'name'             => __( 'Subheader Text', 'cmb2' ),
		'desc'             => __( 'A small paragraph that will appear under the page title.  Text will be cut off if too long.', 'cmb2' ),*/
//-------------------------------------------------------------------------//
//--------------------------------Secondary Content Editor for Front Page--------------------//
	$prefix = 'front_page_secondary_editor_';
	$front_page_secondary_editor = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => __( 'Front Page Secondary Content Editor (content will appear below the hero image)', 'cmb2' ),
		'object_types'  => array( 'page', ), // Post type
		'show_on_cb' => 'cmb2_show_if_front_page', // function should return a bool value
		// 'context'    => 'normal',
		// 'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		'closed'     => false, // true to keep the metabox closed by default
	) );

	$front_page_secondary_editor->add_field( array(
		'name'    => __( 'Content Editor', 'cmb2' ),
		'desc'    => __( 'Add additional content here, which will appear below the hero image.', 'cmb2' ),
		'id'      => $prefix . 'wysiwyg',
		'type'    => 'wysiwyg',
		'options' => array( 
				'textarea_rows' => 15, 
				'wpautop' => false, // use wpautop? Automatically adds paragraph tags
		),
	) );
//-------------------------------------------------------------------------//

}

//add_action( 'cmb2_admin_init', 'cmb2_register_repeatable_group_field_metabox' );
/**
 * Hook in and add a metabox to demonstrate repeatable grouped fields
 */
function cmb2_register_repeatable_group_field_metabox() {
	$prefix = 'cmb2_group_';

	//
	// Repeatable Field Groups
	//
	$cmb_group = new_cmb2_box( array(
		'id'           => $prefix . 'metabox',
		'title'        => __( 'Repeating Field Group', 'cmb2' ),
		'object_types' => array( 'page', ),
	) );

	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$group_field_id = $cmb_group->add_field( array(
		'id'          => $prefix . 'demo',
		'type'        => 'group',
		'description' => __( 'Generates reusable form entries', 'cmb2' ),
		'options'     => array(
			'group_title'   => __( 'Entry {#}', 'cmb2' ), // {#} gets replaced by row number
			'add_button'    => __( 'Add Another Entry', 'cmb2' ),
			'remove_button' => __( 'Remove Entry', 'cmb2' ),
			'sortable'      => true, // beta
			// 'closed'     => true, // true to have the groups closed by default
		),
	) );

	//
	 // Group fields works the same, except ids only need
	 // to be unique to the group. Prefix is not needed.
	 //
	 // The parent field's id needs to be passed as the first argument.
	 ///
	$cmb_group->add_group_field( $group_field_id, array(
		'name'       => __( 'Entry Title', 'cmb2' ),
		'id'         => 'title',
		'type'       => 'text',
		// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
	) );

	$cmb_group->add_group_field( $group_field_id, array(
		'name'        => __( 'Description', 'cmb2' ),
		'description' => __( 'Write a short description for this entry', 'cmb2' ),
		'id'          => 'description',
		'type'        => 'textarea_small',
	) );

	$cmb_group->add_group_field( $group_field_id, array(
		'name' => __( 'Entry Image', 'cmb2' ),
		'id'   => 'image',
		'type' => 'file',
	) );

	$cmb_group->add_group_field( $group_field_id, array(
		'name' => __( 'Image Caption', 'cmb2' ),
		'id'   => 'image_caption',
		'type' => 'text',
	) );

}

//add_action( 'cmb2_admin_init', 'cmb2_register_user_profile_metabox' );
/**
 * Hook in and add a metabox to add fields to the user profile pages
 */
function cmb2_register_user_profile_metabox() {
	$prefix = 'cmb2_user_';

	/**
	 * Metabox for the user profile screen
	 */
	$cmb_user = new_cmb2_box( array(
		'id'               => $prefix . 'edit',
		'title'            => __( 'User Profile Metabox', 'cmb2' ), // Doesn't output for user boxes
		'object_types'     => array( 'user' ), // Tells CMB2 to use user_meta vs post_meta
		'show_names'       => true,
		'new_user_section' => 'add-new-user', // where form will show on new user page. 'add-existing-user' is only other valid option.
	) );

	$cmb_user->add_field( array(
		'name'     => __( 'Extra Info', 'cmb2' ),
		'desc'     => __( 'field description (optional)', 'cmb2' ),
		'id'       => $prefix . 'extra_info',
		'type'     => 'title',
		'on_front' => false,
	) );

	$cmb_user->add_field( array(
		'name'    => __( 'Avatar', 'cmb2' ),
		'desc'    => __( 'field description (optional)', 'cmb2' ),
		'id'      => $prefix . 'avatar',
		'type'    => 'file',
	) );

	$cmb_user->add_field( array(
		'name' => __( 'Facebook URL', 'cmb2' ),
		'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'facebookurl',
		'type' => 'text_url',
	) );

	$cmb_user->add_field( array(
		'name' => __( 'Twitter URL', 'cmb2' ),
		'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'twitterurl',
		'type' => 'text_url',
	) );

	$cmb_user->add_field( array(
		'name' => __( 'Google+ URL', 'cmb2' ),
		'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'googleplusurl',
		'type' => 'text_url',
	) );

	$cmb_user->add_field( array(
		'name' => __( 'Linkedin URL', 'cmb2' ),
		'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'linkedinurl',
		'type' => 'text_url',
	) );

	$cmb_user->add_field( array(
		'name' => __( 'User Field', 'cmb2' ),
		'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'user_text_field',
		'type' => 'text',
	) );

}

//add_action( 'cmb2_admin_init', 'cmb2_register_taxonomy_metabox' );
/**
 * Hook in and add a metabox to add fields to taxonomy terms
 */
function cmb2_register_taxonomy_metabox() {
	$prefix = 'cmb2_term_';

	/**
	 * Metabox to add fields to categories and tags
	 */
	$cmb_term = new_cmb2_box( array(
		'id'               => $prefix . 'edit',
		'title'            => __( 'Category Metabox', 'cmb2' ), // Doesn't output for term boxes
		'object_types'     => array( 'term' ), // Tells CMB2 to use term_meta vs post_meta
		'taxonomies'       => array( 'category', 'post_tag' ), // Tells CMB2 which taxonomies should have these fields
		// 'new_term_section' => true, // Will display in the "Add New Category" section
	) );

	$cmb_term->add_field( array(
		'name'     => __( 'Extra Info', 'cmb2' ),
		'desc'     => __( 'field description (optional)', 'cmb2' ),
		'id'       => $prefix . 'extra_info',
		'type'     => 'title',
		'on_front' => false,
	) );

	$cmb_term->add_field( array(
		'name' => __( 'Term Image', 'cmb2' ),
		'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'avatar',
		'type' => 'file',
	) );

	$cmb_term->add_field( array(
		'name' => __( 'Arbitrary Term Field', 'cmb2' ),
		'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'term_text_field',
		'type' => 'text',
	) );

}

//add_action( 'cmb2_admin_init', 'cmb2_register_theme_options_metabox' );
/**
 * Hook in and register a metabox to handle a theme options page
 */
function cmb2_register_theme_options_metabox() {

	$option_key = 'cmb2_theme_options';

	/**
	 * Metabox for an options page. Will not be added automatically, but needs to be called with
	 * the `cmb2_metabox_form` helper function. See wiki for more info.
	 */
	$cmb_options = new_cmb2_box( array(
		'id'      => $option_key . 'page',
		'title'   => __( 'Theme Options Metabox', 'cmb2' ),
		'hookup'  => false, // Do not need the normal user/post hookup
		'show_on' => array(
			// These are important, don't remove
			'key'   => 'options-page',
			'value' => array( $option_key )
		),
	) );

	/**
	 * Options fields ids only need
	 * to be unique within this option group.
	 * Prefix is not needed.
	 */
	$cmb_options->add_field( array(
		'name'    => __( 'Site Background Color', 'cmb2' ),
		'desc'    => __( 'field description (optional)', 'cmb2' ),
		'id'      => 'bg_color',
		'type'    => 'colorpicker',
		'default' => '#ffffff',
	) );

}
/**
 * Return an associative array of all the site's pages, in the form 'page_id'=>'page_title'.
 */
function create_pages_array() {

	//Query the database for the list of all available page titles
	$args = array(
		'posts_per_page'   => 999,
		//'offset'           => 0,
		//'category'         => '',
		//'category_name'    => '',
		'orderby'          => 'title',
		'order'            => 'ASC',
		//'include'          => '',
		//'exclude'          => '',
		//'meta_key'         => '',
		//'meta_value'       => '',
		'post_type'        => 'page',
		//'post_mime_type'   => '',
		//'post_parent'      => '',
		//'author'	   => '',
		'post_status'      => 'publish',
		'suppress_filters' => true 
	);
	$posts_array = get_posts( $args );

	//error_log( print_r('--------------------------$posts_array-------------------------',true) );
	//error_log( print_r($posts_array,true) );

	//Build the list of pages as an associative array
	$choices_array = [];
	foreach( $posts_array as $page ) {
		$choices_array[$page->ID] = $page->post_title;
	}
	return $choices_array;
}
