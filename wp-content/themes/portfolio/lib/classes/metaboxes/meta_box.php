<?php

// metaboxes directory constant
define( 'CUSTOM_METABOXES_DIR', get_template_directory_uri() . '/lib/classes/metaboxes' );

/**
 * recives data about a form field and spits out the proper html
 *
 * @param	array					$field			array with various bits of information about the field
 * @param	string|int|bool|array	$meta			the saved data for this field
 * @param	array					$repeatable		if is this for a repeatable field, contains parent id and the current integer
 * @param 	WP_Post                 $post_to_render_box_on:  The bost that the metabox is being rendered on.
 *
 * @return	string									html for the field
 */ 
function custom_meta_box_field( $field, $meta = null, $repeatable = null, $post_to_render_box_on) {
	
	//error_log('----------------------Top of custom_meta_box_field()--------------------------');
	
	//error_log('---------------------------$field---------------------------------------------');
	//error_log( var_export($field,true) );

	//error_log('---------------------------$meta---------------------------------------------');
	//error_log( var_export($meta,true) );

	if ( ! ( $field || is_array( $field ) ) )
		return;
	
	// get field data
	$type = isset( $field['type'] ) ? $field['type'] : null;
	$class = isset( $field['class'] ) ? $field['class'] : null;
	$label = isset( $field['label'] ) ? $field['label'] : null;
	$default = isset( $field['default'] ) ? $field['default'] : null;
	$desc = isset( $field['desc'] ) ? '<span class="description">' . $field['desc'] . '</span>' : null;
	$place = isset( $field['place'] ) ? $field['place'] : null;
	$size = isset( $field['size'] ) ? $field['size'] : null;
	$post_type = isset( $field['post_type'] ) ? $field['post_type'] : null;
	$options = isset( $field['options'] ) ? $field['options'] : null;
	$settings = isset( $field['settings'] ) ? $field['settings'] : null;
	$repeatable_fields = isset( $field['repeatable_fields'] ) ? $field['repeatable_fields'] : null;

	$taxonomy_setting = isset( $field['taxonomy'] ) ? $field['taxonomy'] : $field['id'];

	// Use default value if the meta is not yet set
	if( $meta == null && !empty($default) ) {
		$meta = $default;
	}


	
	// the id and name for each field
	$id = $name = isset( $field['id'] ) ? $field['id'] : null;
	if ( $repeatable ) {
		$name = $repeatable[0] . '[' . $repeatable[1] . '][' . $id .']';
		$id = $repeatable[0] . '_' . $repeatable[1] . '_' . $id;
	}

	//error_log('-----------------------ID-----------------------------');
	//error_log( print_r( $id, true) );

	switch( $type ) {
		case 'break':
			echo '<hr/>';
			break;
		// basic
		case 'text':
		case 'tel':
		case 'email':
		default:
			echo '<input type="' . $type . '" name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '" value="' . esc_attr( $meta ) . '" class="regular-text" size="30" />
					<br />' . $desc;
		break;
		case 'url':
			echo '<input type="' . $type . '" name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '" value="' . esc_url( $meta ) . '" class="regular-text" size="30" />
					<br />' . $desc;
		break;
		case 'number':
			echo '<input type="' . $type . '" name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '" value="' . intval( $meta ) . '" class="regular-text" size="30" />
					<br />' . $desc;
		break;
		// textarea
		case 'textarea':
			echo '<textarea name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '" cols="60" rows="4">' . esc_textarea( $meta ) . '</textarea>
					<br />' . $desc;
		break;
		// editor
		case 'editor':
			if ( $repeatable ) {
				$settings['textarea_name'] = $name;
				echo wp_editor( $meta, $id, $settings ) . '<br />' . $desc;
			} else {
				echo wp_editor( $meta, $id, $settings ) . '<br />' . $desc;
			}
		break;
		// checkbox
		case 'checkbox':
			echo '<input type="checkbox" name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '" ' . checked( $meta, true, false ) . ' value="1" />
					<label for="' . esc_attr( $id ) . '">' . $desc . '</label>';
		break;
		// select, chosen
		case 'select':
		case 'chosen':
			echo '<select name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '"' , $type == 'chosen' ? ' class="chosen"' : '' , isset( $multiple ) && $multiple == true ? ' multiple="multiple"' : '' , '>
					<option value="">Select One</option>'; // Select One
			foreach ( $options as $option )
				echo '<option' . selected( $meta, $option['value'], false ) . ' value="' . $option['value'] . '">' . $option['label'] . '</option>';
			echo '</select><br />' . $desc;
		break;
		// Simplified Select:
		case 'akselect':
			echo '<select name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '"' , $type == 'chosen' ? ' class="chosen"' : '' , isset( $multiple ) && $multiple == true ? ' multiple="multiple"' : '' , '>';
				if(!$default) {
					echo 		'<option value="">Select One</option>'; // Select One
				}
			foreach ( $options as $key => $value )
				echo '<option' . selected( $meta, $value, false ) . ' value="' . $value . '">' . $key . '</option>';
			echo '</select><br />' . $desc;
		break;
		// radio
		case 'radio':
			echo '<ul class="meta_box_items">';
			foreach ( $options as $option )
				echo '<li><input type="radio" name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '-' . $option['value'] . '" value="' . $option['value'] . '" ' . checked( $meta, $option['value'], false ) . ' />
						<label for="' . esc_attr( $id ) . '-' . $option['value'] . '">' . $option['label'] . '</label></li>';
			echo '</ul>' . $desc;
		break;

		// checkbox_group
		case 'checkbox_group':
			echo '<ul class="meta_box_items">';
			foreach ( $options as $option )
				echo '<li><input type="checkbox" value="' . $option['value'] . '" name="' . esc_attr( $name ) . '[]" id="' . esc_attr( $id ) . '-' . $option['value'] . '"' , is_array( $meta ) && in_array( $option['value'], $meta ) ? ' checked="checked"' : '' , ' /> 
						<label for="' . esc_attr( $id ) . '-' . $option['value'] . '">' . $option['label'] . '</label></li>';
			echo '</ul>' . $desc;
		break;
		// color
		case 'color':
			$meta = $meta ? $meta : '#';
			echo '<input type="text" name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '" value="' . $meta . '" size="10" />
				<br />' . $desc;
			echo '<div id="colorpicker-' . esc_attr( $id ) . '"></div>
				<script type="text/javascript">
				jQuery(function(jQuery) {
					jQuery("#colorpicker-' . esc_attr( $id ) . '").hide();
					jQuery("#colorpicker-' . esc_attr( $id ) . '").farbtastic("#' . esc_attr( $id ) . '");
					jQuery("#' . esc_attr( $id ) . '").bind("blur", function() { jQuery("#colorpicker-' . esc_attr( $id ) . '").slideToggle(); } );
					jQuery("#' . esc_attr( $id ) . '").bind("focus", function() { jQuery("#colorpicker-' . esc_attr( $id ) . '").slideToggle(); } );
				});
				</script>';
		break;
		// post_select, post_chosen
		case 'post_select':
		case 'post_list':
		case 'post_chosen':
			echo '<select data-placeholder="Select One" name="' . esc_attr( $name ) . '[]" id="' . esc_attr( $id ) . '"' , $type == 'post_chosen' ? ' class="chosen"' : '' , isset( $multiple ) && $multiple == true ? ' multiple="multiple"' : '' , '>
					<option value=""></option>'; // Select One
			$posts = get_posts( array( 'post_type' => $post_type, 'posts_per_page' => -1, 'orderby' => 'name', 'order' => 'ASC' ) );
			foreach ( $posts as $item )
				echo '<option value="' . $item->ID . '"' . selected( is_array( $meta ) && in_array( $item->ID, $meta ), true, false ) . '>' . $item->post_title . '</option>';
			$post_type_object = get_post_type_object( $post_type );
			echo '</select> &nbsp;<span class="description"><a href="' . admin_url( 'edit.php?post_type=' . $post_type . '">Manage ' . $post_type_object->label ) . '</a></span><br />' . $desc;
		break;
		// post_checkboxes
		case 'post_checkboxes':
			$posts = get_posts( array( 'post_type' => $post_type, 'posts_per_page' => -1 ) );
			echo '<ul class="meta_box_items">';
			foreach ( $posts as $item ) 
				echo '<li><input type="checkbox" value="' . $item->ID . '" name="' . esc_attr( $name ) . '[]" id="' . esc_attr( $id ) . '-' . $item->ID . '"' , is_array( $meta ) && in_array( $item->ID, $meta ) ? ' checked="checked"' : '' , ' />
						<label for="' . esc_attr( $id ) . '-' . $item->ID . '">' . $item->post_title . '</label></li>';
			$post_type_object = get_post_type_object( $post_type );
			echo '</ul> ' . $desc , ' &nbsp;<span class="description"><a href="' . admin_url( 'edit.php?post_type=' . $post_type . '">Manage ' . $post_type_object->label ) . '</a></span>';
		break;
		// post_drop_sort
		case 'post_drop_sort':
			//areas
			$post_type_object = get_post_type_object( $post_type );
			echo '<p>' . $desc . ' &nbsp;<span class="description"><a href="' . admin_url( 'edit.php?post_type=' . $post_type . '">Manage ' . $post_type_object->label ) . '</a></span></p><div class="post_drop_sort_areas">';
			
			foreach ( $areas as $area ) {
				echo '<ul id="area-' . $area['id']  . '" class="sort_list">
						<li class="post_drop_sort_area_name">' . $area['label'] . '</li>';
						if ( is_array( $meta ) ) {
							$items = explode( ',', $meta[$area['id']] );
							foreach ( $items as $item ) {
								$output = $display == 'thumbnail' ? get_the_post_thumbnail( $item, array( 204, 30 ) ) : get_the_title( $item ); 
								echo '<li id="' . $item . '">' . $output . '</li>';
							}
						}
				echo '</ul>
					<input type="hidden" name="' . esc_attr( $name ) . '[' . $area['id'] . ']" 
					class="store-area-' . $area['id'] . '" 
					value="' , $meta ? $meta[$area['id']] : '' , '" />';
			}
			echo '</div>';
			// source
			$exclude = null;
			if ( !empty( $meta ) ) {
				$exclude = implode( ',', $meta ); // because each ID is in a unique key
				$exclude = explode( ',', $exclude ); // put all the ID's back into a single array
			}
			$posts = get_posts( array( 'post_type' => $post_type, 'posts_per_page' => -1, 'post__not_in' => $exclude ) );
			echo '<ul class="post_drop_sort_source sort_list">
					<li class="post_drop_sort_area_name">Available ' . $label . '</li>';
			foreach ( $posts as $item ) {
				$output = $display == 'thumbnail' ? get_the_post_thumbnail( $item->ID, array( 204, 30 ) ) : get_the_title( $item->ID ); 
				echo '<li id="' . $item->ID . '">' . $output . '</li>';
			}
			echo '</ul>';
		break;




		case 'attachment_drop_sort':
			
			$current_post_object = $post_to_render_box_on;

			$post_id = $current_post_object->ID;
			
			//error_log('--------------------$current_post_object-----------------------');
			//error_log( var_export($current_post_object,true) );

			$post_type_object = get_post_type_object ( $post_type ); //The type of post that we will be drag & drop sorting
			//error_log( '------------------------------------$post_type_object---------------------------------');
			//error_log( print_r($post_type_object, true) );

			echo '<p>' . $desc . ' &nbsp;<span class="description"><a href="' . admin_url( 'edit.php?post_type=' . $post_type . '">Manage ' . $post_type_object->label ) . '</a></span></p>';
			
			//----------------ACTIVE POSTS (The ones on the left side that will be displayed)-------------------------------------//

			echo '<div class="post_drop_sort_areas">';
				echo '<ul id="area-' . $field['id']  . '" class="sort_list">
						<li class="post_drop_sort_area_name">' . $field['label'] . '</li>';

						//If the attachment id's meta value already is saved to the database
						if ( isset($meta) && $meta != '' ) {
							//error_log('----------------META IS SET---------------');
							
							$attachment_ids = explode( ',', $meta );

						//If no attachment_drop_sort meta value is present in the database
						} else {
							//error_log('----------------META NOT SET---------------');
							$attachment_ids = [];
						}

						//error_log( '------------------------------------$attachment_ids---------------------------------');
						//error_log( print_r($attachment_ids, true) );

						//Write them to the "Active" area on the left
						foreach ( $attachment_ids as $attachment_id ) {
							$output = wp_get_attachment_image( $attachment_id, 'thumbnail');
							//error_log( '------------------------------------$output---------------------------------');
							//error_log( print_r($output, true) );
							echo '<li id="' . $attachment_id . '">' . $output . '</li>';
						}	
						
						

						//Turn it into a comma-separated string
						$meta = join( ',', $attachment_ids );
						//error_log( '------------------------------------$meta---------------------------------');
						//error_log( print_r( $meta, true) );

						//Write the meta value to the database
						update_post_meta( $post_id, $field['id'], $meta );

				echo '</ul>';
				//Create a hidden input with 'value' attribute set to the comma-separated id string = the meta value
				echo '<input type="hidden" name="' . $field['id'] . '" class="store-area-' . $field['id'] . '" value="' . $meta . '" />';
			echo '</div>';
			
			//----------------SOURCE POSTS (The ones on the right side that are not "Active": We exclude posts that are already "active"-------//
			echo '<ul class="post_drop_sort_source sort_list">
					<li class="post_drop_sort_area_name">Drag Here to Remove from Slideshow</li>'; //'label' key when defining the metabox
			
			/*foreach ( $excluded_connected_images as $item ) {
				$output = $item->post_title; 
				echo '<li id="' . $item->ID . '">' . $output . '</li>';
			}*/

			echo '</ul>';

		break;




	
		case 'tax_apply':
			echo '<select name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '">
					<option>Select One</option>'; // Select One

			//Get all possible terms for the given taxonomy
			$args = [
						'hide_empty' => 0 //Show all terms, regardless of whether they are assigned to any posts.
					];
			$all_terms_array = get_terms ( $taxonomy_setting, $args );

			//Get selected terms for the given taxonomy for the given post
			$checked_term_object_array = get_the_terms( get_the_ID(), $taxonomy_setting );

			//error_log('----------------------------------------CHECKED TERM OBJECT ARRAY ----------------------------');
		    //error_log( print_r( $checked_term_object_array,true ) );

			//If $checked_term_object_array is not false (no terms attached to post) or is not an object (WP_Error object)
			if (  !( $checked_term_object_array == false || is_object($checked_term_object_array) )  ) {
		    	$first_checked_term = $checked_term_object_array[0];
		    	$selected = $first_checked_term->slug;
		    } else {
		    	$selected = '';		
		    }

		    //Iterate through all the possible terms, and create <option> elements
			foreach ( $all_terms_array as $term ) {
				$term_value = $term->slug;
				echo '<option value="' . $term_value . '"' . selected( $selected, $term_value, false ) . '>' . $term->name . '</option>'; 
			}
			echo '</select> &nbsp;<span class="description"><a href="'.get_bloginfo( 'url' ) . '/wp-admin/edit-tags.php?taxonomy=' . $taxonomy_setting . '">Manage ' . $label . '</a></span>
				<br />' . $desc;
		break;

		// tax_select
		case 'tax_select':
			echo '<select name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '">
					<option value="">All</option>'; // Select One
			$terms = get_terms( $taxonomy_setting, 'get=all' );
			$post_terms = wp_get_object_terms( get_the_ID(), $taxonomy_setting );
			$taxonomy = get_taxonomy( $taxonomy_setting ); //$taxonomy = get_taxonomy( $id );
			//$selected = $post_terms ? $taxonomy->hierarchical ? $post_terms[0]->term_id : $post_terms[0]->slug : null;
			$selected = $meta;
			foreach ( $terms as $term ) {
				$term_value = $taxonomy->hierarchical ? $term->term_id : $term->slug;
				echo '<option value="' . $term_value . '"' . selected( $meta, $term_value, false ) . '>' . $term->name . '</option>'; 
			}
			echo '</select> &nbsp;<span class="description"><a href="'.get_bloginfo( 'url' ) . '/wp-admin/edit-tags.php?taxonomy=' . $taxonomy_setting . '">Manage ' . $taxonomy->label . '</a></span>
				<br />' . $desc;
		break;


		// tax_checkboxes
		case 'tax_checkboxes':
			$terms = get_terms( $id, 'get=all' );
			$post_terms = wp_get_object_terms( get_the_ID(), $id );
			$taxonomy = get_taxonomy( $id );
			$checked = $post_terms ? $taxonomy->hierarchical ? $post_terms[0]->term_id : $post_terms[0]->slug : null;
			foreach ( $terms as $term ) {
				$term_value = $taxonomy->hierarchical ? $term->term_id : $term->slug;
				echo '<input type="checkbox" value="' . $term_value . '" name="' . $id . '[]" id="term-' . $term_value . '"' . checked( $checked, $term_value, false ) . ' /> <label for="term-' . $term_value . '">' . $term->name . '</label><br />';
			}
			echo '<span class="description">' . $field['desc'] . ' <a href="'.get_bloginfo( 'url' ) . '/wp-admin/edit-tags.php?taxonomy=' . $id . '&post_type=' . $page . '">Manage ' . $taxonomy->label . '</a></span>';
		break;
		// date
		case 'date':
			echo '<input type="text" class="datepicker" name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '" value="' . $meta . '" size="30" />
					<br />' . $desc;
		break;
		// slider
		case 'slider':
		$value = $meta != '' ? intval( $meta ) : '0';
			echo '<div id="' . esc_attr( $id ) . '-slider"></div>
					<input type="text" name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '" value="' . $value . '" size="5" />
					<br />' . $desc;
		break;
		// image
		case 'image':
			$image = CUSTOM_METABOXES_DIR . '/images/image.png';	
			echo '<div class="meta_box_image"><span class="meta_box_default_image" style="display:none">' . $image . '</span>';
			if ( $meta ) {
				$image = wp_get_attachment_image_src( intval( $meta ), 'tiny' );
				$image = $image[0];
			}				
			echo	'<input name="' . esc_attr( $name ) . '" type="hidden" class="meta_box_upload_image" value="' . intval( $meta ) . '" />
						<img src="' . esc_attr( $image ) . '" class=" meta_box_preview_image" alt="" />
						<div class="">
							<a href="#" class="left meta_box_upload_image_button button" rel="' . get_the_ID() . '">Choose Image</a>';
							if ($meta) {
								echo '<a href="#" class=" left button meta_box_clear_image_button">Remove Image</a>';
							}
							echo '</div></div>
							' . $desc;
		break;
		// multi-image
		case 'multi-image':
			//Multi-image does not need to display its meta values, because it is only being used as an image uploader.
			//We are not saving any post meta data, but rather creating connections using the Posts_2_Posts plugin.
			//We will display thumbnails of the images that are selected before the Update button creates the connections.
			
			echo    '<div class="multi_image_metabox_div">';
				echo 	"<div class='multi_image_item_container clearfix'>"; //Container for image items
				echo 	"</div>";
				echo    "<br>";	
				//The Select Images button allows us to select multiple attachments/images.  Their attachment id's are stored in <input> elements, then used to assign connections.		
				echo	'<div class="meta_box_buttons">
							<a href="#" class="left meta_box_upload_multi_image_button button" data-name="' . esc_attr( $name ) . '" rel="' . get_the_ID() . '">Select Images to Connect</a>';
				echo 	'</div>';
				echo    $desc;
			echo    '</div>';
			break;





			
		// file
		case 'file': 		
			$iconClass = 'meta_box_file';
			if ( $meta ) $iconClass .= ' checked';
			echo	'<div class="meta_box_file_stuff"><input name="' . esc_attr( $name ) . '" type="hidden" class="meta_box_upload_file" value="' . esc_url( $meta ) . '" />
						<span class="' . $iconClass . '"></span>
						<span class="meta_box_filename">' . esc_url( $meta ) . '</span>
							<a href="#" class="meta_box_upload_file_button button" rel="' . get_the_ID() . '">Choose File</a>
							<small>&nbsp;<a href="#" class="meta_box_clear_file_button">Remove File</a></small></div>
							<br clear="all" />' . $desc;
		break;
		// repeatable
		case 'repeatable':
			echo '<table id="' . esc_attr( $id ) . '-repeatable" class="meta_box_repeatable" cellspacing="0">
				<thead>
					<tr>
						<th><span class="sort_label"></span></th>
						<th>Fields<a class="meta_box_repeatable_add" href="#"></a></th>
						<th><a class="meta_box_repeatable_add" href="#"></a></th>
					</tr>
				</thead>
				<tbody>';
			$i = 0;
			// create an empty array
			if ( $meta == '' || $meta == array() ) {
				$keys = wp_list_pluck( $repeatable_fields, 'id' );
				$meta = array ( array_fill_keys( $keys, null ) );
			}
			$meta = array_values( $meta );
			foreach( $meta as $row ) {
				echo '<tr>
						<td><span class="sort hndle"></span></td><td>';
				foreach ( $repeatable_fields as $repeatable_field ) {
					if ( ! array_key_exists( $repeatable_field['id'], $meta[$i] ) )
						$meta[$i][$repeatable_field['id']] = null;
					echo "<div class='repeatable-part {$repeatable_field['class']}'>";
					echo '<label>' . $repeatable_field['label']  . '</label><p>';
					echo custom_meta_box_field( $repeatable_field, $meta[$i][$repeatable_field['id']], array( $id, $i ) );
					echo '</p></div>';
				} // end each field
				echo '</td><td><a class="meta_box_repeatable_remove" href="#"></a></td></tr>';
				$i++;
			} // end each row
			echo '</tbody>';
			echo '
				<tfoot>
					<tr>
						<th><span class="sort_label"></span></th>
						<th>Fields</th>
						<th><a id="' . esc_attr( $id ) . '-' . $i . '" class="meta_box_repeatable_add" href="#' . esc_attr( $id ) . '-' . $i . '"></a></th>
					</tr>
				</tfoot>';
			echo '</table>
				' . $desc;
		break;
		
	} //end switch
		
}


/**
 * Finds any item in any level of an array
 *
 * @param	string	$needle 	field type to look for
 * @param	array	$haystack	an array to search the type in
 *
 * @return	bool				whether or not the type is in the provided array
 */
function meta_box_find_field_type( $needle, $haystack ) {
	foreach ( $haystack as $h )
		if ( isset( $h['type'] ) && $h['type'] == 'repeatable' )
			return meta_box_find_field_type( $needle, $h['repeatable_fields'] );
		elseif ( ( isset( $h['type'] ) && $h['type'] == $needle ) || ( isset( $h['repeatable_type'] ) && $h['repeatable_type'] == $needle ) )
			return true;
	return false;
}

/**
 * Find repeatable
 *
 * This function does almost the same exact thing that the above function 
 * does, except we're exclusively looking for the repeatable field. The 
 * reason is that we need a way to look for other fields nested within a 
 * repeatable, but also need a way to stop at repeatable being true. 
 * Hopefully I'll find a better way to do this later.
 *
 * @param	string	$needle 	field type to look for
 * @param	array	$haystack	an array to search the type in
 *
 * @return	bool				whether or not the type is in the provided array
 */
function meta_box_find_repeatable( $needle = 'repeatable', $haystack ) {
	foreach ( $haystack as $h )
		if ( isset( $h['type'] ) && $h['type'] == $needle )
			return true;
	return false;
}

/**
 * sanitize boolean inputs
 */
function meta_box_santitize_boolean( $string ) {
	if ( ! isset( $string ) || $string != 1 || $string != true )
		return false;
	else
		return true;
}

/**
 * outputs properly sanitized data
 *
 * @param	string	$string		the string to run through a validation function
 * @param	string	$function	the validation function
 *
 * @return						a validated string
 */
function meta_box_sanitize( $string, $function = 'sanitize_text_field' ) {
	
	//error_log("-----------------------METABOX SANITIZE TYPE------------------------");
	//error_log( print_r( $function, true) );


	switch ( $function ) {
		case 'none':
			return $string;
		case 'intval':
			return intval( $string );
		case 'absint':
			return absint( $string );
		case 'wp_kses_post':
			return wp_kses_post( $string );
		case 'wp_kses_data':
			return wp_kses_data( $string );
		case 'esc_url_raw':
			return esc_url_raw( $string );
		case 'is_email':
			return is_email( $string );
		case 'sanitize_title':
			return sanitize_title( $string );
		case 'santitize_boolean':
			return santitize_boolean( $string );
		case 'sanitize_text_field':
			return $string;
		default:
			//return sanitize_text_field( $string );
			return wp_kses_post( $string );
	}
}

/**
 * Map a multideminsional array
 *
 * @param	string	$func		the function to map
 * @param	array	$meta		a multidimensional array
 * @param	array	$sanitizer	a matching multidimensional array of sanitizers
 *
 * @return	array				new array, fully mapped with the provided arrays
 */
function meta_box_array_map_r( $func, $meta, $sanitizer ) {
		
	$newMeta = array();
	$meta = array_values( $meta );
	
	foreach( $meta as $key => $array ) {
		if ( $array == '' )
			continue;
		/**
		 * some values are stored as array, we only want multidimensional ones
		 */
		if ( ! is_array( $array ) ) {
			return array_map( $func, $meta, (array)$sanitizer );
			break;
		}
		/**
		 * the sanitizer will have all of the fields, but the item may only 
		 * have valeus for a few, remove the ones we don't have from the santizer
		 */
		$keys = array_keys( $array );
		$newSanitizer = $sanitizer;
		if ( is_array( $sanitizer ) ) {
			foreach( $newSanitizer as $sanitizerKey => $value )
				if ( ! in_array( $sanitizerKey, $keys ) )
					unset( $newSanitizer[$sanitizerKey] );
		}
		/**
		 * run the function as deep as the array goes
		 */
		foreach( $array as $arrayKey => $arrayValue )
			if ( is_array( $arrayValue ) )
				$array[$arrayKey] = meta_box_array_map_r( $func, $arrayValue, $newSanitizer[$arrayKey] );
		
		$array = array_map( $func, $array, $newSanitizer );
		$newMeta[$key] = array_combine( $keys, array_values( $array ) );
	}
	return $newMeta;
}

/**
 * takes in a few peices of data and creates a custom meta box
 *
 * @param	string			$id			meta box id
 * @param	string			$title		title
 * @param	array			$fields		array of each field the box should include
 * @param	string|array	$page		post type to add meta box to
 */
class Custom_Add_Meta_Box {
	
	var $id;
	var $title;
	var $fields;
	var $page;
	
    public function __construct( $id, $title, $fields, $page ) {
		$this->id = $id;
		$this->title = $title;
		$this->fields = $fields;
		$this->page = $page;
		
		if( ! is_array( $this->page ) )
			$this->page = array( $this->page );
		
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		add_action( 'admin_head',  array( $this, 'admin_head' ) );
		add_action( 'add_meta_boxes', array( $this, 'add_box' ), 10, 2 );
		add_action( 'save_post',  array( $this, 'save_box' ) );

		//Special case for saving the post when the post type is 'attachment'
		if ( $this->page[0] == 'attachment' ) {
			add_action( 'edit_attachment', array( $this, 'save_box' ) );	
		}
		
    }
	
	/**
	 * enqueue necessary scripts and styles
	 */
	function admin_enqueue_scripts() {
		global $pagenow;
		if ( in_array( $pagenow, array( 'post-new.php', 'post.php' ) ) && in_array( get_post_type(), $this->page ) ) {
			// js
			$deps = array( 'jquery' );
			if ( true || meta_box_find_field_type( 'date', $this->fields ) )
				$deps[] = 'jquery-ui-datepicker';
			if ( true ||  meta_box_find_field_type( 'slider', $this->fields ) ) //let's just turn this on.
				$deps[] = 'jquery-ui-slider';
			if ( true ||  meta_box_find_field_type( 'color', $this->fields ) )
				$deps[] = 'farbtastic';
			if ( true ||  in_array( true, array(
				meta_box_find_field_type( 'chosen', $this->fields ),
				meta_box_find_field_type( 'post_chosen', $this->fields )
			) ) ) {
				wp_register_script( 'chosen', CUSTOM_METABOXES_DIR . '/js/chosen.js', array( 'jquery' ) );
				$deps[] = 'chosen';
				wp_enqueue_style( 'chosen', CUSTOM_METABOXES_DIR . '/css/chosen.css' );
			}
			if ( true ||  in_array( true, array( 
				meta_box_find_field_type( 'date', $this->fields ), 
				meta_box_find_field_type( 'slider', $this->fields ),
				meta_box_find_field_type( 'color', $this->fields ),
				meta_box_find_field_type( 'chosen', $this->fields ),
				meta_box_find_field_type( 'post_chosen', $this->fields ),
				meta_box_find_repeatable( 'repeatable', $this->fields ),
				meta_box_find_field_type( 'image', $this->fields ),
				meta_box_find_field_type( 'file', $this->fields )
			) ) )
				wp_enqueue_script( 'meta_box', CUSTOM_METABOXES_DIR . '/js/scripts.js', $deps );
			
			// css
			$deps = array();
			wp_register_style( 'jqueryui', CUSTOM_METABOXES_DIR . '/css/jqueryui.css' );
			//if ( meta_box_find_field_type( 'date', $this->fields ) || meta_box_find_field_type( 'slider', $this->fields ) )
				$deps[] = 'jqueryui';
			if ( true ||  meta_box_find_field_type( 'color', $this->fields ) )
				$deps[] = 'farbtastic';
			wp_enqueue_style( 'meta_box', CUSTOM_METABOXES_DIR . '/css/meta_box.css', $deps );
		}
	}
	
	/**
	 * adds scripts to the head for special fields with extra js requirements
	 */
	function admin_head() {
		if ( in_array( get_post_type(), $this->page ) && ( meta_box_find_field_type( 'date', $this->fields ) || meta_box_find_field_type( 'slider', $this->fields ) ) ) {
		
			echo '<script type="text/javascript">
						jQuery(function( $) {';
			
			foreach ( $this->fields as $field ) {
				switch( $field['type'] ) {
					// date
					case 'date' :
						echo '$("#' . $field['id'] . '").datepicker({
								dateFormat: \'yy-mm-dd\'
							});';
					break;
					// slider
					case 'slider' :
					$value = get_post_meta( get_the_ID(), $field['id'], true );
					if ( $value == '' )
						$value = $field['min'];
					echo '
							if ( $.isFunction($.fn.slider) ) {
								$( "#' . $field['id'] . '-slider" ).slider({
									value: ' . $value . ',
									min: ' . $field['min'] . ',
									max: ' . $field['max'] . ',
									step: ' . $field['step'] . ',
									slide: function( event, ui ) {
										$( "#' . $field['id'] . '" ).val( ui.value );
									}
								});
							}';
					break;
				}
			}
			
			echo '});
				</script>';
		
		}
	}
	
	/**
	 * adds the meta box for every post type in $page
	 * @param $post_type, $post: post type and post object for the post that the meta box is being renedered on.
	 */
	function add_box($post_type, $post) {
		
		//error_log('---------------------------add_box being called---------------------------------------');
		//error_log('');
		//error_log('---------------------------$post---------------------------------------------');
		//error_log( var_export($post,true) );

		foreach ( $this->page as $page ) {
			/*http://codex.wordpress.org/Function_Reference/add_meta_box*/
			add_meta_box( $this->id, $this->title, array( $this, 'meta_box_callback' ), $page, 'normal', 'high', [ $post ] );
		}
	}
	
	/**
	 * outputs the html for the meta box
	 * @param $post_to_render_box_on: The post that the metabox is being rendered on.
	 */
	function meta_box_callback( $post_to_render_box_on  ) {

		//error_log('---------------------------$param1---------------------------------------------');
		//error_log( var_export($param1,true) );

		//error_log('---------------------------$param2---------------------------------------------');
		//error_log( var_export($param2,true) );

		// Use nonce for verification
		wp_nonce_field( 'custom_meta_box_nonce_action', 'custom_meta_box_nonce_field' );
		
		// Begin the field table and loop
		echo '<table class="form-table meta_box">';
		foreach ( $this->fields as $field) {

			$class = '';
			$classes = '';
			

			$data = '';
			if( isset( $field['dependent']) ) {

				$on 	= $field['dependent']['field']; // Which field are we watching?
				$values = $field['dependent']['value']; // Array of values
				$not 	= $field['dependent']['not'];

				if( is_array($values) ) {
					$values = implode(' ', $values);
				}
				

				if( is_array($not) ) {
					$not = "data-not='" . implode(' ', $not) . "' ";
				}

				$data = " data-watch='{$on}' data-values='{$values}' {$not} ";

				$classes .= ' dependent';

			}

			//if( isset( $field['class'] ) || isset( $classes ) ) {
			//	$class = " class='{$field['class']} {$classes}' ";
			//}

			echo "<tr {$class} {$data}>";

			if ( $field['type'] == 'section' ) {
				
					echo    '<td colspan="2">
								<h2>' . $field['label'] . '</h2>
							</td>';
					
			} elseif ( $field['type'] == 'repeatable' ) {
				echo '<td colspan="2">
							<h2>' . $field['label'] . '</h2>
						</td>
					</tr>';
					echo '<tr class="' . $field["class"] . '">
							<td colspan="2">';
							
							$meta = get_post_meta( get_the_ID(), $field['id'], true);
							echo custom_meta_box_field( $field, $meta );
							
					echo     '</td>';
			} else {
				echo '<th style="width:15%"><label for="' . $field['id'] . '">' . $field['label'] . '</label></th>
						<td>';
						
						$meta = get_post_meta( get_the_ID(), $field['id'], true);
						echo custom_meta_box_field( $field, $meta, null, $post_to_render_box_on );
						
				echo     '</td>';
			}

			echo '</tr>';

		} // end foreach
		echo '</table>'; // end table
	}
	
	/**
	 * saves the captured data - will be run once per metabox
	 */
	function save_box( $post_id ) {

		//error_log( '------------------------------------$_POST---------------------------------');
		//error_log( print_r($_POST, true) );

		$post_type = get_post_type();
		
		// verify nonce
		if ( ! isset( $_POST['custom_meta_box_nonce_field'] ) )
			return $post_id;
		if ( ! ( in_array( $post_type, $this->page ) || wp_verify_nonce( $_POST['custom_meta_box_nonce_field'],  'custom_meta_box_nonce_action' ) ) ) 
			return $post_id;
		// check autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;
		// check permissions
		if ( ! current_user_can( 'edit_page', $post_id ) )
			return $post_id;

		foreach ( $this->fields as $field ) { //Loop through all the metabox's fields
			if ( $field['id']=='slam_photo_uploader' || $field['id']=='slam_photo_order' ) {
				//Skip the regular procedure for this special case
			} else {
				if (  isset(  $_POST[ $field['id'] ]  )  ) {
					update_post_meta( $post_id, $field['id'], $_POST[ $field['id'] ] );
				}
			}
		} 
		//Check for the special case of if a photo uploader/sorter is present
		if ( isset( $_POST[ 'slam_photo_uploader' ] ) || isset( $_POST[ 'slam_photo_order' ] ) ) {
			//Add the data from the photo uploader if it's present to the date from the attachment drop sort
			if ( isset( $_POST[ 'slam_photo_uploader' ] ) ) {
				//The new image id's that you want to add to the gallery that you've uploaded
				$new_image_id_array = $_POST[ 'slam_photo_uploader' ];
				//error_log( '---------------------------$NEW_image_id_array---------------------');
				//error_log( print_r($new_image_id_array, true) );
			} else {
				$new_image_id_array = [];
				//error_log( '---------------------------$NEW_image_id_array---------------------');
				//error_log( print_r($new_image_id_array, true) );
			}
			
			if ( isset($_POST['slam_photo_order']) ) {
				$current_drop_sort_meta_string = $_POST['slam_photo_order'];
				//error_log( '------------------------------------$current_drop_sort_meta_string---------------------------------');
				//error_log( print_r($current_drop_sort_meta_string, true) );	

			} else {
				$current_drop_sort_meta_string = '';
			}
			
			//Explode the comma-separated list into an array
			if( $current_drop_sort_meta_string === '' ) {
				$drop_sort_id_array = [];
			} else {
				$drop_sort_id_array = explode( ',', $current_drop_sort_meta_string );
			}
			//error_log( '------------------------------------$drop_sort_id_array---------------------------------');
			//error_log( print_r($drop_sort_id_array, true) );

			//Combine the new id's with the old/current
			$combined_id_array = array_merge($drop_sort_id_array, $new_image_id_array);
			//error_log( '---------------------------$combined_id_array---------------------');
			//error_log( print_r($combined_id_array, true) );

			//Transform the combined id array back to a comma-separated list
			$revised_id_list = join(",", $combined_id_array);
			//error_log( '---------------------------$revised_id_list---------------------');
			//error_log( print_r($revised_id_list, true) );

			update_post_meta( $post_id, 'slam_photo_order', $revised_id_list );
		}
	}	
}