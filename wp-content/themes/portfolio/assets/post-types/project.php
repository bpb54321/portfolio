<?php
/* joints Custom Post Type Example
This page walks you through creating 
a custom post type and taxonomies. You
can edit this one or copy the following code 
to create another one. 

I put this in a separate file so as to 
keep it organized. I find it easier to edit
and change things if they are concentrated
in their own file.

*/


function register_project_post_type() { 
	// creating (registering) the custom type 
	register_post_type( 'project', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
		array('labels' => array(
			'name' => __('Projects', 'jointswp'), /* This is the Title of the Group */
			'singular_name' => __('Project', 'jointswp'), /* This is the individual type */
			'all_items' => __('All Projects', 'jointswp'), /* the all items menu item */
			'add_new' => __('Add New', 'jointswp'), /* The add new menu item */
			'add_new_item' => __('Add New Project', 'jointswp'), /* Add New Display Title */
			'edit' => __( 'Edit', 'jointswp' ), /* Edit Dialog */
			'edit_item' => __('Edit Projects', 'jointswp'), /* Edit Display Title */
			'new_item' => __('New Project', 'jointswp'), /* New Display Title */
			'view_item' => __('View Project', 'jointswp'), /* View Display Title */
			'search_items' => __('Search Projects', 'jointswp'), /* Search Custom Type Title */ 
			'not_found' =>  __('Nothing found in the Database.', 'jointswp'), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __('Nothing found in Trash', 'jointswp'), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( '', 'jointswp' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => 'dashicons-book', /* the icon for the Project type menu. uses built-in dashicons (CSS class name) */
			'rewrite'	=> array( 'slug' => 'projects', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => false, //'projects-archive', /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
	 	) /* end of options */
	); /* end of register post type */
	
	/* this adds your post categories to your Project type */
	register_taxonomy_for_object_type('category', 'project');
	/* this adds your post tags to your custom post type */
	//register_taxonomy_for_object_type('post_tag', 'custom_type');
	
} 

	// adding the function to the Wordpress init
	add_action( 'init', 'register_project_post_type');
	
	/*
	for more information on taxonomies, go here:
	http://codex.wordpress.org/Function_Reference/register_taxonomy
	*/
    
    /*
    	looking for custom meta boxes?
    	check out this fantastic tool:
    	https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
    */

    //$prefix = 'slam_'; //For namespacing.
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
	$image_uploader_metabox = new Custom_Add_Meta_Box( 'image_uploader_metabox', 'Slideshow Image Uploader', $image_uploader_fields, 'project' );

	$project_attributes_fields = [
		[ 
			'label'	=> 'Project Year', // <label>
			'desc'	=> 'Year the project was completed.', // description
			'id'	=> 'slam_project_year', // field id and name
			'type'	=> 'text', // type of field
		],
	];
	$project_attributes_metabox = new Custom_Add_Meta_Box( 'project_attributes_metabox', 'Project Attributes', $project_attributes_fields, 'project' );

