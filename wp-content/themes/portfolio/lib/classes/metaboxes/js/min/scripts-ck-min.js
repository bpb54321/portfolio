jQuery(function(e){function t(e){for(var t=[],i=0;i<e.length;i++)t.push(e[i].val)}var i;e(".meta_box_upload_image_button").click(function(t){t.preventDefault();var o,a;return $self=e(t.target),$div=$self.closest("div.meta_box_image"),i?void i.open():(i=wp.media({title:"Choose Image",multiple:!1,library:{type:"image"},button:{text:"Use This Image"}}),i.on("select",function(){selection=i.state().get("selection"),selection&&selection.each(function(e){console.log(e);var t=e.attributes.sizes.full.url,i=e.id;$div.find(".meta_box_preview_image").attr("src",t),$div.find(".meta_box_upload_image").val(i)})}),void i.open())}),e(".meta_box_clear_image_button").click(function(){var t=e(this).parent().siblings(".meta_box_default_image").text();return e(this).parent().siblings(".meta_box_upload_image").val(""),e(this).parent().siblings(".meta_box_preview_image").attr("src",t),!1});var o;e(".meta_box_upload_file_button").click(function(t){t.preventDefault();var i,a;return $self=e(event.target),$div=$self.closest("div.meta_box_file_stuff"),o?void o.open():(o=wp.media({title:"Choose File",multiple:!1,library:{type:"file"},button:{text:"Use This File"}}),o.on("select",function(){selection=o.state().get("selection"),selection&&selection.each(function(e){console.log(e);var t=e.attributes.url,i=e.id;$div.find(".meta_box_filename").text(t),$div.find(".meta_box_upload_file").val(t),$div.find(".meta_box_file").addClass("checked")})}),void o.open())}),e(".meta_box_clear_file_button").click(function(){return e(this).parent().siblings(".meta_box_upload_file").val(""),e(this).parent().siblings(".meta_box_filename").text(""),e(this).parent().siblings(".meta_box_file").removeClass("checked"),!1}),e(".meta_box_repeatable_add").live("click",function(){var t=e(this).closest(".meta_box_repeatable").find("tbody tr:last-child"),i=t.clone();i.find("select.chosen").removeAttr("style","").removeAttr("id","").removeClass("chzn-done").data("chosen",null).next().remove(),i.find("input.regular-text, textarea, select").val(""),i.find("input[type=checkbox], input[type=radio]").attr("checked",!1),t.after(i),i.find("input, textarea, select").attr("name",function(e,t){return"undefined"!=typeof t?(console.log("Name: "+t),t.replace(/(\d+)/,function(e,t){return console.log("New Value: "+(Number(e)+1)),Number(e)+1})):void 0}),i.find("*").attr("id",function(e,t){return"undefined"!=typeof t?(console.log("ID: "+t),t.replace(/(\d+)/,function(e,t){return console.log("New Value: "+(Number(e)+1)),Number(e)+1})):void 0});var o=[];return e("input.repeatable_id:text").each(function(){o.push(e(this).val())}),i.find("input.repeatable_id").val(Number(Math.max.apply(Math,o))+1),!e.prototype.chosen||i.find("select.chosen").chosen({allow_single_deselect:!0}),!1}),e(".meta_box_repeatable_remove").live("click",function(){return e(this).closest("tr").remove(),!1}),e(".meta_box_repeatable tbody").sortable({opacity:.6,revert:!0,cursor:"move",handle:".hndle"}),e(".sort_list").sortable({connectWith:".sort_list",opacity:.6,revert:!0,cursor:"move",cancel:".post_drop_sort_area_name",items:"li:not(.post_drop_sort_area_name)",update:function(t,i){var o=e(this).sortable("toArray"),a=e(this).attr("id");e(".store-"+a).val(o)}}),e(".sort_list").disableSelection(),!e.prototype.chosen||e(".chosen").chosen({allow_single_deselect:!0})});