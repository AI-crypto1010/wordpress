<?php if (!defined('ABSPATH')) { exit; }
$this->custom_css();
global $wpdb;
$path = str_replace('\\', '/', ABSPATH);
if (isset($_POST['submit']) && wp_verify_nonce(sanitize_text_field($_POST['wp_filemanager_root_nonce_field']), 'wp_filemanager_root_action')) {
  $directory_separators = ['../', './','..\\', '.\\', '..'];
  $public_path = isset($_POST['public_path']) ? str_replace($directory_separators, '', htmlentities(trim($path.$_POST['public_path']))): $path;
  $save_array = 	array(
    'public_path' => $public_path,
    'fm_enable_trash' => isset($_POST['fm_enable_trash']) ? intval($_POST['fm_enable_trash']) : '',
    'fm_enable_media_upload' => isset($_POST['fm_enable_media_upload']) ? intval($_POST['fm_enable_media_upload']) : '',
    'fm_max_packet_allowed' => isset($_POST['fm_max_packet_allowed']) ? intval($_POST['fm_max_packet_allowed']) : '',
);
  if(isset($_POST['fm_max_packet_allowed'])){
    $fm_max_packet_allowed = intval($_POST['fm_max_packet_allowed']);
    $packet_value = intval($fm_max_packet_allowed * 1000000);
    if($packet_value <= 0 ){
        
        $prev_value = get_option('wp_file_manager_settings',true);
        $packet_value = isset($prev_value['fm_max_packet_allowed']) ? intval($prev_value['fm_max_packet_allowed']) : 0;
        $save_array['fm_max_packet_allowed'] = $packet_value;
        $packet_value = intval($packet_value * 1000000);
    } else {
        $save_array['fm_max_packet_allowed'] = isset($packet_value) ? intval($packet_value/1000000) : '';
        $set_packet_value = $wpdb->query($wpdb->prepare("SET GLOBAL max_allowed_packet = %d",$packet_value));
    }
    }
    $save = update_option('wp_file_manager_settings', $save_array);

    if ($save) {
      mk_file_folder_manager::mk_fm_redirect('admin.php?page=wp_file_manager_preferences&status=1');
    } else {
      mk_file_folder_manager::mk_fm_redirect('admin.php?page=wp_file_manager_preferences&status=2');
    }
}
$settings = get_option('wp_file_manager_settings'); 
$max_allowed_packet = 'max_allowed_packet';
$packet_obj = $wpdb->get_row( $wpdb->prepare( "SHOW SESSION VARIABLES WHERE (variable_name = %s)", $max_allowed_packet ) );
$default_packet_value = intval($packet_obj->Value);
$default_packet_value = intval($default_packet_value / 1000000);
?>
<div class="wrap fm_rootWrap">
<?php if (isset($_GET['status']) && intval($_GET['status']) == '1'):?>
<div class="updated settings-error notice is-dismissible" id="setting-error-settings_updated"> 
<p><strong><?php _e('Settings saved.', 'wp-file-manager'); ?></strong></p><button id="ad_dismiss" class="notice-dismiss" type="button"><span class="screen-reader-text"><?php _e('Dismiss this notice.', 'wp-file-manager'); ?></span></button></div>
<?php elseif (isset($_GET['status']) && intval($_GET['status']) == '2'):?>
<div class="error updated settings-error notice is-dismissible" id="setting-error-settings_updated"> 
<p><strong><?php _e('You have not made any changes to be saved.', 'wp-file-manager'); ?></strong></p><button id="ad_dismiss" class="notice-dismiss" type="button"><span class="screen-reader-text"><?php _e('Dismiss this notice.', 'wp-file-manager'); ?></span></button></div>
<?php endif; ?>
<h3 class="fm_headingTitle"><?php _e('Preferences', 'wp-file-manager'); ?></h3>
<?php $path = str_replace('\\', '/', ABSPATH); ?>
<div class="fm_whiteBg">
<form action="" method="post">
<?php wp_nonce_field('wp_filemanager_root_action', 'wp_filemanager_root_nonce_field'); ?>
<table class="form-table">
<tr>
<th><?php _e('Public Root Path', 'wp-file-manager'); ?></th>
<td>
<?php 
$path_length = strlen($path);
$access_folder = isset($settings['public_path']) && !empty($settings['public_path']) ? substr($settings['public_path'],$path_length) : '';
?>
<div class="input-addon"><strong><?php _e('Default', 'wp-file-manager'); ?>: </strong><?php echo $path; ?></div>
<input type="text" name="public_path" id="public_path" placeholder="<?php _e('Path of the folder to display e.g wp-content/uploads', 'wp-file-manager'); ?>" value="<?php echo $access_folder; ?>" class="regular-text fmInput"/>
<p style="color:#F00" class="description mb15"><?php _e('Please change this carefully, wrong path can lead file manager plugin to go down.', 'wp-file-manager'); ?></p>
</td>
</tr>
<tr>
<th><?php _e('Enable Trash?', 'wp-file-manager'); ?></th>
<td class="fm-tr-inline">
<input name="fm_enable_trash" type="checkbox" id="fm_enable_trash" value="1" class="regular-text" <?php echo (isset($settings['fm_enable_trash']) && !empty($settings['fm_enable_trash']) && $settings['fm_enable_trash'] == 1) ? 'checked="checked"' : ''; ?>>
<p class="description mb15"><?php _e('After enable trash, your files will go to trash folder.', 'wp-file-manager'); ?>
</p>
</td>
</tr>
<tr>
<th><?php _e('Enable Files Upload to Media Library?', 'wp-file-manager'); ?></th>
<td class="fm-tr-inline">
<input name="fm_enable_media_upload" type="checkbox" id="fm_enable_media_upload" value="1" class="regular-text" <?php echo (isset($settings['fm_enable_media_upload']) && !empty($settings['fm_enable_media_upload']) && $settings['fm_enable_media_upload'] == 1) ? 'checked="checked"' : ''; ?>>
<p class="description mb15"><?php _e('After enabling this all files will go to media library.', 'wp-file-manager'); ?>
</p>
</td>
</tr>
<tr>
<th><?php _e('Maximum allowed size at the time of database backup restore.', 'wp-file-manager'); ?></th>
<td>
  <div class="fm-packet-area">
    <input name="fm_max_packet_allowed" type="number" id="fm_max_packet_allowed" min="1" class="regular-text" value="<?php echo (isset($settings['fm_max_packet_allowed']) && !empty($settings['fm_max_packet_allowed'])) ? intval($settings['fm_max_packet_allowed']) : $default_packet_value; ?>"><span class="mb-value"><?php _e('MB', 'wp-file-manager'); ?> </span>
  </div>
  <p class="description mb15"><?php _e('Please increase field value if you are getting error message at the time of backup restore.', 'wp-file-manager'); ?>
  </p>
</td>
</tr>
</table>
<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Save Changes', 'wp-file-manager'); ?>"></p>
</form>
</div>
</div>
<?php
$admin_page_url = admin_url('admin.php?page=wp_file_manager_preferences');
wp_register_script( 'fm-dismiss-notice-js', '', array("jquery"), '', true );
wp_enqueue_script( 'fm-dismiss-notice-js' );
wp_add_inline_script(
'fm-dismiss-notice-js',
	'setTimeout(function() {
  window.history.replaceState({}, document.title, "'.$admin_page_url.'");
  }, 1000);
  jQuery(document).on("click", "#ad_dismiss", function(){
    jQuery(this).closest(".notice").remove();
  });'
);
?>