jQuery(function($) {
	//console.log('Metabox Scripts');

	// Dependent Fields
	$('.dependent').each(function(){

		var field = $(this);

		field.hide();

		var watch = field.data('watch');
		var values = field.data('values');
		var not_values = field.data('not');

		//alert(watch + ' ' + values);

		var watchField = $('#' + watch);
		var watchValue = watchField.val();

		if (typeof values != 'undefined' && watchValue) {
			if ( values.search(watchValue) > -1 ) {
				field.show();
				console.log(watch, values, watchValue, values.search(watchValue));
			}
		}

		if (typeof not_values != 'undefined') {
			if ( not_values.search(watchValue) == -1 ) {
				field.show();
			}
		}

		watchField.change(function(){

			watchValue = watchField.val();	

			if ( values.search(watchValue) > -1 && watchValue) {
				field.show();
			} else {
				field.hide();
			}

			if (typeof not_values != 'undefined') {
				if ( not_values.search(watchValue) == -1 ) {
					field.show();
				} else {
					field.hide();
				}
			}



		});


	});

	// Single Image Upload
	// the upload image button, saves the id and outputs a preview of the image
	var imageFrame;
	$('.meta_box_upload_image_button').click(function(event) {
		event.preventDefault();
		
		var options, attachment;
		
		$self = $(event.target);
		$div = $self.closest('div.meta_box_image');
		
		// if the frame already exists, open it
		if ( imageFrame ) {
			imageFrame.open();
			return;
		}
		
		// set our settings
		imageFrame = wp.media({
			title: 'Choose Image',
			multiple: false,
			library: {
		 		type: 'image'
			},
			button: {
		  		text: 'Use This Image'
			}
		});
		
		// set up our select handler
		imageFrame.on( 'select', function() {
			selection = imageFrame.state().get('selection');
			
			if ( ! selection )
			return;
			
			// loop through the selected files
			selection.each( function( attachment ) {
				console.log(attachment);
				var src = attachment.attributes.sizes.full.url;
				var id = attachment.id;
				
				$div.find('.meta_box_preview_image').attr('src', src);
				$div.find('.meta_box_upload_image').val(id);
			} );
		});
		
		// open the frame
		imageFrame.open();
	});
	
	// Multi Image Upload
	//Make the "Remove From Slideshow Box" as tall as the "Slideshow Photo Order" box
	var slideshowPhotoOrderHeight = $('#image_uploader_metabox div.post_drop_sort_areas').css('height');
	$('#image_uploader_metabox ul.post_drop_sort_source').css('height', slideshowPhotoOrderHeight );

	// the upload image button, saves the id and outputs a preview of the image
	var imageFrame;
	$('.meta_box_upload_multi_image_button').click(function(event) {
		event.preventDefault();
		
		var options, attachment;

		//Variables that start with $ in javascript designate a variable of type jQuery object
		$self = $(event.target); //Get the element that triggered this callback
		$metabox_div = $self.closest('div.multi_image_metabox_div');
		$item_container = $metabox_div.find('.multi_image_item_container'); //$.find() finds child elements
		
		// if the frame already exists, open it
		if ( imageFrame ) {
			imageFrame.open();
			return;
		}
		
		// set our settings
		imageFrame = wp.media({
			title: 'Choose Image',
			multiple: true,
			library: {
		 		type: 'image'
			},
			button: {
		  		text: 'Use These Images'
			}
		});
		
		// set up our select handler
		imageFrame.on( 'select', function() {
			selection = imageFrame.state().get('selection'); // Selection is an array of attachments
			
			if ( ! selection ) 
			return;

			//Loop through the selected files; http://api.jquery.com/jQuery.each/
			selection.each( function( attachment ) {

				var src = attachment.attributes.sizes.thumbnail.url;
				var id = attachment.id;
				
				var inputName = $self.context.attributes[2].nodeValue;  //This corresponds to the name/id of the metabox object. This will be the name of the key in $_POST object that holds an array of attachment ids.  This will also be the base name for each hidden <input>.
				
				var $collectionOfImageItems = $item_container.children(); //Get collection of all image items
				var $numOfImageItems = $collectionOfImageItems.length; //Find its length
				var $nextImageIndex = $numOfImageItems; //Based on 0-based indexing. This is the index that will be added to the hidden <input>'s 'name' attribute.  This will ensure that the image id's get attached to the $_POST object as an array.

				// Create new item div with: Image, Input and Close Button
				var item = '';
				item += "<div class='meta_box_multi_image_item left' id='"+ id +"'>";
				item += 	"<input name='" + inputName + "[" + $nextImageIndex +   "]' type='hidden' class='meta_box_multi_image_input' value='"+ id +"' />"; //The id of each image is stored as the value of each hidden <input> element
				item +=    "<img src='" + src + "' class='meta_box_multi_image_item_preview' />";
				item += 	"<br><a class='delete_button button'>Delete</a>";
				item += "</div>";

				// Append new Item Div to Item Container
				$item_container.append(item);

				//When the "Update" <input> button is clicked on the Post Edit page, it sends a post request to post.php.  	
			} );
			
			//Add event listener to all a.delete_button to remove its parent image item div when the delete button is clicked.
			$('a.delete_button').click( function() {
				//Select parent div.meta_box_multi_image_item
				var $imageItemDiv = $( this ).parent();

				//Remove $imageItemDiv
				$imageItemDiv.remove();
			});
		});
		
		// open the frame
		imageFrame.open();
	});
	
	// the remove image link, removes the image id from the hidden field and replaces the image preview
	$('.meta_box_clear_image_button').click(function() {
		var defaultImage = $(this).parent().siblings('.meta_box_default_image').text();
		$(this).parent().siblings('.meta_box_upload_image').val('');
		$(this).parent().siblings('.meta_box_preview_image').attr('src', defaultImage);
		return false;
	});
	
	// the file image button, saves the id and outputs the file name
	var fileFrame;
	$('.meta_box_upload_file_button').click(function(e) {
		e.preventDefault();
		
		var options, attachment;
		
		$self = $(event.target);
		$div = $self.closest('div.meta_box_file_stuff');
		 
		// if the frame already exists, open it
		if ( fileFrame ) {
			fileFrame.open();
			return;
		}
		
		// set our settings
		fileFrame = wp.media({
			title: 'Choose File',
			multiple: false,
			library: {
		 		type: 'file'
			},
			button: {
		  		text: 'Use This File'
			}
		});
		
		// set up our select handler
		fileFrame.on( 'select', function() {
			selection = fileFrame.state().get('selection');
			
			if ( ! selection )
			return;
			
			// loop through the selected files
			selection.each( function( attachment ) {
				console.log(attachment);
				var src = attachment.attributes.url;
				var id = attachment.id;
				
				$div.find('.meta_box_filename').text(src);
				$div.find('.meta_box_upload_file').val(src);
				$div.find('.meta_box_file').addClass('checked');
			} );
		});
		
		// open the frame
		fileFrame.open();
	});
	
	// the remove image link, removes the image id from the hidden field and replaces the image preview
	$('.meta_box_clear_file_button').click(function() {
		$(this).parent().siblings('.meta_box_upload_file').val('');
		$(this).parent().siblings('.meta_box_filename').text('');
		$(this).parent().siblings('.meta_box_file').removeClass('checked');
		return false;
	});
	
	// function to create an array of input values
	function ids(inputs) {
		var a = [];
		for (var i = 0; i < inputs.length; i++) {
			a.push(inputs[i].val);
		}
		//$("span").text(a.join(" "));
    }
	// repeatable fields
	$('.meta_box_repeatable_add').live('click', function() {
		// clone
		var row = $(this).closest('.meta_box_repeatable').find('tbody tr:last-child');
		var clone = row.clone();
		clone.find('select.chosen').removeAttr('style', '').removeAttr('id', '').removeClass('chzn-done').data('chosen', null).next().remove();
		clone.find('input.regular-text, textarea, select').val('');
		clone.find('input[type=checkbox], input[type=radio]').attr('checked', false);
		row.after(clone);
		// increment name and id
		clone.find('input, textarea, select')
			.attr('name', function(index, name) {
				if( typeof(name) != "undefined") {
					console.log('Name: ' + name);
					return name.replace(/(\d+)/, function(fullMatch, n) {
						//alert('replacement:' + (Number(fullMatch) + 1));
						console.log('New Value: ' + (Number(fullMatch) + 1)) ;
						return (Number(fullMatch) + 1);
					});
				}
			});
		clone.find('*').attr('id', function(index, id) {
				if( typeof(id) != "undefined") {
					console.log('ID: ' + id);
					return id.replace(/(\d+)/, function(fullMatch, n) {
						//alert('replacement:' + (Number(fullMatch) + 1));
						console.log('New Value: ' + (Number(fullMatch) + 1)) ;
						return (Number(fullMatch) + 1);
					});
				}
			});

		clone.find('input, textarea, select').each(function(){
			console.log( $(this).attr('name'));
		});

		// What is this stuff doing?
		var arr = [];

		$('input.repeatable_id:text').each(function(){ 
			arr.push($(this).val()); 
		}); 
		
		clone.find('input.repeatable_id')
			.val( Number(Math.max.apply( Math, arr )) + 1);
		if (!!$.prototype.chosen) {
			clone.find('select.chosen')
				.chosen({allow_single_deselect: true});
		}

		
		// tinymce.init({
		//     selector: "textarea.wp-editor-area",
		// });
		

		//$("form#post").submit();


		//
		return false;
	});
	
	$('.meta_box_repeatable_remove').live('click', function(){
		$(this).closest('tr').remove();
		return false;
	});
		
	$('.meta_box_repeatable tbody').sortable({
		opacity: 0.6,
		revert: true,
		cursor: 'move',
		handle: '.hndle'
	});
	
	// post_drop_sort	
	$('.sort_list').sortable({
		connectWith: '.sort_list',
		opacity: 0.6,
		revert: true,
		cursor: 'move',
		cancel: '.post_drop_sort_area_name',
		items: 'li:not(.post_drop_sort_area_name)',
        update: function(event, ui) {
			var result = $(this).sortable('toArray');
			var thisID = $(this).attr('id');
			$('.store-' + thisID).val(result) 
		}
    });

	$('.sort_list').disableSelection();

	// turn select boxes into something magical
	if (!!$.prototype.chosen)
		$('.chosen').chosen({ allow_single_deselect: true });


	//console.log('End metabox Scripts');
});