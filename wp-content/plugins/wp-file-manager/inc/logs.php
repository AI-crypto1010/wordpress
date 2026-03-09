<?php if (!defined('ABSPATH')) { exit; } 
$images_url = WP_FM_SITE_URL.'/wp-content/uploads/2024/08';
?>
<style>
.buy-now:hover,
.buy-now:focus{ box-shadow:none !important; }
</style>
<div class="wrap">
<p class="danger" style="color:#F00"><strong><?php  _e('Note: These are demo screenshots. Please buy File Manager pro to Logs functions.', 'wp-file-manager'); ?></strong>
<a href="https://filemanagerpro.io/product/file-manager" class="button button-primary buy-now" target="_blank" title="<?php  _e('Click to Buy PRO', 'wp-file-manager'); ?>"><?php  _e('Buy PRO', 'wp-file-manager'); ?></a></p>
<h3><?php  _e('Edit Files Logs', 'wp-file-manager'); ?></h3>	
<img src="<?php echo $images_url.'/logs-001.jpg';?>">
<h3><?php  _e('Download Files Logs', 'wp-file-manager'); ?></h3>	
<img src="<?php echo $images_url.'/logs-002.jpg';?>">
<h3><?php  _e('Upload Files Logs', 'wp-file-manager'); ?></h3>		
<img src="<?php echo $images_url.'/logs-003.jpg';?>">
</div>