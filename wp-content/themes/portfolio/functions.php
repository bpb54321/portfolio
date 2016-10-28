<?php
// Theme support options
require_once(get_template_directory().'/assets/functions/theme-support.php'); 

// WP Head and other cleanup functions
require_once(get_template_directory().'/assets/functions/cleanup.php'); 

// Register scripts and stylesheets
require_once(get_template_directory().'/assets/functions/enqueue-scripts.php'); 

// Register custom menus and menu walkers
require_once(get_template_directory().'/assets/functions/menu.php'); 

// Register sidebars/widget areas
require_once(get_template_directory().'/assets/functions/sidebar.php'); 

//Require the file that registers all theme widgets
require_once(get_template_directory().'/assets/functions/register-widgets.php'); 

// Makes WordPress comments suck less
require_once(get_template_directory().'/assets/functions/comments.php'); 

// Replace 'older/newer' post links with numbered navigation
require_once(get_template_directory().'/assets/functions/page-navi.php'); 

// Adds support for multiple languages
require_once(get_template_directory().'/assets/translation/translation.php'); 

// Remove 4.2 Emoji Support
// require_once(get_template_directory().'/assets/functions/disable-emoji.php'); 

// Adds site styles to the WordPress editor
//require_once(get_template_directory().'/assets/functions/editor-styles.php'); 

// Related post function - no need to rely on plugins
// require_once(get_template_directory().'/assets/functions/related-posts.php'); 

//Add support for Custom_Add_Meta_Box class
require_once( get_template_directory().'/lib/classes/metaboxes/meta_box.php');

// Require project post type file
require_once(get_template_directory().'/assets/post-types/project.php');

//This file is used to customize the Edit Page screen of Pages
require_once(get_template_directory().'/assets/post-types/page.php');

// Customize the WordPress login menu
// require_once(get_template_directory().'/assets/functions/login.php'); 

// Customize the WordPress admin
require_once(get_template_directory().'/assets/functions/admin.php'); 

//Create custom metaboxes using the CMB2 library
require_once( get_template_directory() . '/cmb2-functions.php' );

//Helper function for getting the widths and url's of all the available crops of an image.
// @param: Number $id: The id of the image that you need the info for
// @return: An associative array with array["widths"] containing an array of widths and array["urls"] containing the corresponding image urls.
function get_image_widths_and_urls($id) {
	//Get all the possible image sizes
	$image_size_array = get_intermediate_image_sizes();
	//error_log('--------------------$image_size_array------------------------'); 
	//error_log( var_export($image_size_array, true) );
	
	$image_width_array = [];
	//$image_url_array = [];
	$widths_and_urls = [];
	$i = 0;
	foreach ( $image_size_array as $image_size_name ) {
		$image_info_array = wp_get_attachment_image_src($id, $image_size_name);
		$image_url = $image_info_array[0];
		$image_width = $image_info_array[1];
		if ( $image_width > 300 ) { //Don't want to include any images smaller than 300px, since they won't really ever be useful
			$image_width_array[] = $image_width;
			$widths_and_urls[$i] = [
				"width" => $image_width,
				"url" => $image_url,
			];
			//error_log('--------------------$image_info_array------------------------'); 
			//error_log( var_export($image_info_array, true) );	
			$i++;
		}
	}
	array_multisort ($image_width_array, SORT_ASC, SORT_NUMERIC, $widths_and_urls); //Sorts $widths_and_urls by the "width" key
	/*return [
		"widths" => $image_width_array,
		"urls" => $image_url_array,
	];*/
	return $widths_and_urls;
}


//Helper function for getting the image source of a post's featured image
// @param: WP_Post $post: The post object that you are getting the featured image for
// @param: String $size: The Wordpress keyword for the image size (thumbnail, medium, large, full);
// @return: String The URL of the featured image.
function get_featured_image_src($post, $size) {
	//error_log('--------------------$post------------------------'); 
	//error_log( var_export($post, true) );

	$post_thumbnail_id = get_post_thumbnail_id ( $post );
	$image_src_array = wp_get_attachment_image_src ( $post_thumbnail_id, $size, false );
	//error_log('--------------------$image_src_array------------------------'); 
	//error_log( var_export($image_src_array, true) );
	
	$image_src_string = $image_src_array[0];
	//error_log('--------------------$image_src_string------------------------'); 
	//error_log( var_export($image_src_string, true) );

	return $image_src_string;
}

//Helper function for getting the post's categories in a comma-connected string
// @param: WP_Post $post: The post object that you are getting the categories for
// @return: String The comma-connected string of the post's categories.
function get_post_category_string($post) {
	$category_object_array = get_the_category($post); 
	//error_log('--------------------$category_object_array------------------------'); 
	//error_log( var_export($category_object_array, true) );

	//error_log('--------------------sizeof($category_object_array)------------------------'); 
	//error_log( var_export( sizeof($category_object_array), true ) );

	if ( sizeof($category_object_array) == 0 )  {
		//return '&nbsp;'; //Non-breaking space
		return false;
	} else {
		$category_text_array = [];
		foreach ($category_object_array as $category_object) {
			$category_text_array[] = $category_object->cat_name;
		}
		//error_log('--------------------$category_text_array------------------------'); 
		//error_log( var_export($category_text_array, true) );

		$category_text_string = join( ", ", $category_text_array );

		return $category_text_string;
	}
}


