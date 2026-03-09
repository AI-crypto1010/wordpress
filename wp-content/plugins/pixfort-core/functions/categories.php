<?php

// categories

function pix_category_fields($term) {
	if (defined('DOING_AJAX') && DOING_AJAX) {
		return false;
	}
	$editList = array('category_edit_form_fields', 'product_cat_edit_form_fields', 'edited_product_cat');
	$addList = array('category_add_form_fields', 'product_cat_add_form_fields', 'create_product_cat');
	if (in_array(current_filter(), $editList)) {
		$rawvalue = get_term_meta($term->term_id, 'category_intro_img', true);
		$image = !$rawvalue ? '' : wp_get_attachment_image($rawvalue, 'thumbnail', false, array('style' => 'max-width:300px;height:auto;margin-top:20px;'));

?>
		<tr class="form-field">
			<th valign="top" scope="row"><label for="term_fields[category_intro_img]"><?php _e('Image'); ?></label></th>
			<td>
				<input class="widefat meta-box-upload-value" id="term_fields[category_intro_img]" name="term_fields[category_intro_img]" type="hidden" value="<?php echo esc_attr($rawvalue); ?>" />
				<button class="meta-box-upload-button button button-primary">Upload Image</button>
				<input type='button' id='$name-remove' class='button meta-box-upload-button-remove' value='Remove' />
				<div class='image-preview'><?php echo wp_kses_post($image); ?></div>
				<br />
			</td>
		</tr>



	<?php } elseif (in_array(current_filter(), $addList)) {
	?>
		<tr class="form-field">
			<th valign="top" scope="row"><label for="term_fields[category_intro_img]"><?php _e('Intro image'); ?></label></th>
			<td>
				<input class="widefat meta-box-upload-value" id="term_fields[category_intro_img]" name="<?php _e('Short description'); ?>" type="hidden" value="" />
				<button class="meta-box-upload-button button button-primary">Upload Image</button>
				<input type='button' id='$name-remove' class='button meta-box-upload-button-remove' value='Remove' />
				<div class='image-preview'></div>
				<br />
			</td>
		</tr>
<?php
	}
}

// Add the fields, using our callback function
add_action('category_add_form_fields', 'pix_category_fields', 10, 2);
add_action('category_edit_form_fields', 'pix_category_fields', 10, 2);
add_action('product_cat_add_form_fields', 'pix_category_fields', 10, 2);
add_action('product_cat_edit_form_fields', 'pix_category_fields', 10, 2);
add_action('edited_product_cat', 'pix_category_fields', 10, 2);
add_action('create_product_cat', 'pix_category_fields', 10, 2);

function pix_save_category_fields($term_id) {
	if (!isset($_POST['term_fields'])) {
		return;
	}

	foreach ($_POST['term_fields'] as $key => $value) {
		update_term_meta($term_id, $key, sanitize_text_field($value));
	}
}

// Save the fields values, using our callback function
add_action('edited_category', 'pix_save_category_fields', 10, 2);
add_action('create_category', 'pix_save_category_fields', 10, 2);
add_action('product_cat_add_form_fields', 'pix_save_category_fields', 10, 2);
add_action('product_cat_edit_form_fields', 'pix_save_category_fields', 10, 2);
add_action('edited_product_cat', 'pix_save_category_fields', 10, 2);
add_action('create_product_cat', 'pix_save_category_fields', 10, 2);



?>