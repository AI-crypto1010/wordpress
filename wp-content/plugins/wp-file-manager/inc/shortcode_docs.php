<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php
//$settings = get_option('wp_file_manager_pro_settings');	
$this->fm_custom_assets(); 
?>

<div class="wrap fmShorcodePage">
<div class="fmInnerWrap">
<h3 class="mainHeading">
<span class="headingIcon"><img src="<?php echo plugins_url( 'images/fm-shortcode-icon.png', __FILE__ );?>"></span>
<span class="headingText"><?php _e('File Manager - Shortcode','wp-file-manager'); ?></span>
</h3>

<div class="fm_codeParaTxt">
<div class="para"><div class="lftText"><strong><?php _e('USE:' , 'wp-file-manager'); ?></strong></div>  <div class="rtTxt"><code>[wp_file_manager_admin]</code> -> <?php _e('It will show file manager on front end. You can control all settings from file manager settings. It will work same as backend WP File Manager.','wp-file-manager'); ?></div></div>

<div class="para"><div class="lftText"><strong><?php _e('USE:', 'wp-file-manager'); ?></strong></div>  <div class="rtTxt"> <code>[wp_file_manager]</code> -> <?php _e('It will show file manager on front end. But only Administrator can access it and will control from file manager settings.', 'wp-file-manager'); ?></div></div>

<div class="para"><div class="lftText"><strong><?php _e('USE:', 'wp-file-manager'); ?></strong></div>  <div class="rtTxt"> <code>[wp_file_manager view="list" lang="en" theme="light" dateformat="d M, Y h:i A" allowed_roles="editor,author" access_folder="wp-content/plugins" write = "true" read = "false" hide_files = "kumar,abc.php" lock_extensions=".php,.css" allowed_operations="upload,download" ban_user_ids="2,3"]</code></div></div>

</div>

<label class="labelHeading"><?php _e('Parameters:', 'wp-file-manager'); ?></label> 

<ul class="shortcodeDocList">
<li><div class="lftTxt"><span class="num">1</span></div>  <div class="rtTxt"><span class="strongText">allowed_roles = "*"</span> <span class="lineText">-> <?php _e('It will allow all roles to access file manager on front end or You can simple use for particular user roles as like allowed_roles="editor,author" (seprated by comma(,))' ,'wp-file-manager'); ?></span></div> </li>

<li><div class="lftTxt"><span class="num">2</span></div>  <div class="rtTxt"> <span class="strongText">access_folder="test"</span> <span class="lineText">-> <?php _e('Here "test" is the name of folder which is located on root directory, or you can give path for sub folders as like "wp-content/plugins". If leave blank or empty it will access all folders on root directory. Default: Root directory', 'wp-file-manager'); ?></span></div> </li>

<li><div class="lftTxt"><span class="num">3</span></div>  <div class="rtTxt"> <span class="strongText">write = "true"</span> <span class="lineText">-> <?php _e('for access to write files permissions, note: true/false, default: false', 'wp-file-manager'); ?></span></div> </li>

<li><div class="lftTxt"><span class="num">4</span></div>  <div class="rtTxt"> <span class="strongText">read = "true"</span> <span class="lineText">-> <?php _e('for access to read files permission, note: true/false, default: true', 'wp-file-manager'); ?></span></div> </li>

<li><div class="lftTxt"><span class="num">5</span></div>  <div class="rtTxt"> <span class="strongText">hide_files = "wp-content/plugins,wp-config.php"</span> <span class="lineText">-> <?php _e('it will hide mentioned here. Note: seprated by comma(,). Default: Null', 'wp-file-manager'); ?></span></div> </li>

<li><div class="lftTxt"><span class="num">6</span></div>  <div class="rtTxt"> <span class="strongText">lock_extensions=".php,.css"</span> <span class="lineText">-> <?php _e('It will lock mentioned in commas. you can lock more as like ".php,.css,.js" etc. Default: Null', 'wp-file-manager'); ?></span></div> </li>

<li><div class="lftTxt"><span class="num">7</span></div>  <div class="rtTxt"> <span class="strongText">allowed_operations="*"</span> <span class="lineText">-> <?php _e('* for all operations and to allow some operation you can mention operation name as like, allowed_operations="upload,download". Note: seprated by comma(,). Default: *', 'wp-file-manager'); ?></span> </div></li>

</ul>

<div class="subHeading"><span class="num">7.1</span><?php _e('File Operations List:', 'wp-file-manager'); ?> </div>

<div class="twoColListWrap">
<ul class="numList numListCol">
<li><span class="num">1.</span> <span class="strongText"><?php _e('mkdir ->', 'wp-file-manager'); ?></span> <span class="lineText"><?php _e('Make directory or folder', 'wp-file-manager'); ?></span> </li>
<li><span class="num">2.</span> <span class="strongText"><?php _e('mkfile ->', 'wp-file-manager'); ?></span> <span class="lineText"><?php _e('Make file', 'wp-file-manager'); ?></span> </li>
<li><span class="num">3.</span> <span class="strongText"><?php _e('rename ->', 'wp-file-manager'); ?></span> <span class="lineText"><?php _e('Rename a file or folder', 'wp-file-manager'); ?></span> </li>
<li><span class="num">4.</span> <span class="strongText"><?php _e('duplicate ->', 'wp-file-manager'); ?></span> <span class="lineText"><?php _e('Duplicate or clone a folder or file', 'wp-file-manager'); ?></span> </li>
<li><span class="num">5.</span> <span class="strongText"><?php _e('paste ->', 'wp-file-manager'); ?></span> <span class="lineText"> <?php _e('Paste a file or folder', 'wp-file-manager'); ?></span> </li>
<li><span class="num">6.</span> <span class="strongText"><?php _e('ban ->', 'wp-file-manager'); ?></span> <span class="lineText"><?php _e('Ban', 'wp-file-manager'); ?> </span> </li>
<li><span class="num">7.</span> <span class="strongText"><?php _e('archive ->', 'wp-file-manager'); ?></span> <span class="lineText"><?php _e('To make a archive or zip' ,'wp-file-manager'); ?></span> </li>
<li><span class="num">8.</span> <span class="strongText"><?php _e('extract ->', 'wp-file-manager'); ?></span> <span class="lineText"><?php _e('Extract archive or zipped file' , 'wp-file-manager'); ?></span> </li>
<li><span class="num">9.</span> <span class="strongText"><?php _e('copy ->', 'wp-file-manager'); ?></span> <span class="lineText"><?php _e('Copy files or folders', 'wp-file-manager'); ?></span> </li>
</ul>

<ul class="numList numListCol">
<li><span class="num">10.</span> <span class="strongText"><?php _e('cut ->', 'wp-file-manager'); ?></span> <span class="lineText"><?php _e('Simple cut a file or folder', 'wp-file-manager'); ?></span> </li>
<li><span class="num">11.</span> <span class="strongText"><?php _e('edit ->', 'wp-file-manager'); ?></span> <span class="lineText"><?php _e('Edit a file', 'wp-file-manager'); ?></span> </li>
<li><span class="num">12.</span> <span class="strongText"><?php _e('rm ->', 'wp-file-manager'); ?></span> <span class="lineText"><?php _e('Remove or delete files and folders', 'wp-file-manager'); ?></span> </li>
<li><span class="num">13.</span> <span class="strongText"><?php _e('download ->', 'wp-file-manager'); ?></span> <span class="lineText"><?php _e('Download files', 'wp-file-manager'); ?></span> </li>
<li><span class="num">14.</span> <span class="strongText"><?php _e('upload ->', 'wp-file-manager'); ?></span> <span class="lineText"><?php _e('Upload files', 'wp-file-manager'); ?></span> </li>
<li><span class="num">15.</span> <span class="strongText"><?php _e('search -> ', 'wp-file-manager'); ?></span> <span class="lineText"><?php _e('Search things', 'wp-file-manager'); ?></span> </li>
<li><span class="num">16.</span> <span class="strongText"><?php _e('info ->', 'wp-file-manager'); ?></span> <span class="lineText"><?php _e('Info of file', 'wp-file-manager'); ?></span> </li>
<li><span class="num">17.</span> <span class="strongText"><?php _e('help ->', 'wp-file-manager'); ?></span> <span class="lineText"><?php _e('Help', 'wp-file-manager'); ?></span> </li>
</ul>

</div>

<ul class="shortcodeDocList">
<li><div class="lftTxt"><span class="num">8</span></div>  <div class="rtTxt"> <span class="strongText">ban_user_ids="2,3"</span> <span class="lineText"><?php _e('->  It will ban particular users by just putting their ids seprated by commas(,). If user is Ban then they will not able to access wp file manager on front end.', 'wp-file-manager'); ?></span></div> </li>
<li><div class="lftTxt"><span class="num">9</span></div>  <div class="rtTxt"> <span class="strongText">view="list"</span> <span class="lineText"><?php _e('-> Filemanager UI View. Default: grid', 'wp-file-manager'); ?></span> </div></li>
<li><div class="lftTxt"><span class="num">10</span></div>  <div class="rtTxt"> <span class="strongText">dateformat="d M, Y h:i A"</span> <span class="lineText"><?php _e('-> File Modified or Create date format. Default: d M, Y h:i A', 'wp-file-manager'); ?> </span> </div></li>
<li><div class="lftTxt"><span class="num">11</span></div>  <div class="rtTxt"> <span class="strongText">lang="en"</span> <span class="lineText"><?php _e('-> File manager Language. Default: English(en)', 'wp-file-manager'); ?> </span> </div></li>
<li><div class="lftTxt"><span class="num">12</span></div>  <div class="rtTxt"> <span class="strongText">theme="light"</span> <span class="lineText"><?php _e('-> File Manager Theme. Default: Light', 'wp-file-manager'); ?> </span> </div></li>
</ul>

</div>
</div>