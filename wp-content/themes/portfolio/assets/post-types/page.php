<?php
/**
 * This file is used to add custom meta boxes, etc to the page post type.
 */

$testimonial_fields = [
	[ 
		'label'	=> 'Testimonial Text', // <label>
		'desc'	=> 'The text of the testimonial.  Only displays when this page is the site home page.', // description
		'id'	=> 'slam_testimonial_text', // field id and name
		'type'	=> 'text', // type of field
	],
	[ 
		'label'	=> 'Testimonial Author', // <label>
		'desc'	=> 'The person who gave the testimonial.  Only displays when this page is the site home page.', // description
		'id'	=> 'slam_testimonial_author', // field id and name
		'type'	=> 'text', // type of field
	],
];
$testimonial_metabox = new Custom_Add_Meta_Box( 'testimonial_metabox', 'Home Page Customer Testimonial', $testimonial_fields, 'page' );

$image_uploader_fields = [
	[ 
		'label'	=> 'Slideshow Photo Uploader', // <label>
		'desc'	=> 'Use this upload button to add photos to this projects gallery.', // description
		'id'	=> 'slam_photo_uploader', // field id and name
		'type'	=> 'multi-image', // type of field
		'bulk-apply-tax' => 'image_type', //the taxonomy name to bulk-apply terms for
		'bulk-apply-term' => 'Photo' //the term from a given taxonomy to bulk apply to each attachment
	],
	[ 
		'label'	=> 'Slideshow Photo Order', // <label>
		'desc'	=> '', // description
		'id'	=> 'slam_photo_order', // field id and name
		'type'	=> 'attachment_drop_sort', // type of field
		'post_type' => 'attachment', //The "available to order" section will be populated by posts of this post type that are conected to the post you are editing.
	],
];
/**
 * takes in a few peices of data and creates a custom meta box
 *
 * @param	string			$id			meta box id
 * @param	string			$title		title
 * @param	array			$fields		array of each field the box should include
 * @param	string|array	$page		post type to add meta box to
 */
$image_uploader_metabox = new Custom_Add_Meta_Box( 'image_uploader_metabox', 'Slideshow Image Uploader', $image_uploader_fields, 'page' );

