<div class="cc_meta_control">
	<textarea name="_inpost_head_script[synth_header_script]" rows="5" style="width:98%;" <?php disabled(!current_user_can( 'unfiltered_html') ); ?>><?php 
		$allowed_html = array(
			'script' => array(),
		);
		
		if(!empty($meta['synth_header_script'])) echo wp_kses($meta['synth_header_script'], $allowed_html); 
	?></textarea>
	<?php
        if(!current_user_can( 'unfiltered_html' )) {
        	echo '<p style="color:#ffc107"><b>Note:</b> ' . __('You do not have permission to add or edit scripts. Please contact your administrator.', 'collectchat') . '</p>';
        } else {
			echo '<p>'.__('Copy and paste the code snippet to add bot to this post or page', 'collectchat').'</p>'	;
		}
    ?>
</div>
