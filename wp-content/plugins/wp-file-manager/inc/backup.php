<?php if (!defined('ABSPATH')) { exit; } 
$backupDirs = array('uploads.zip','plugins.zip','themes.zip','others.zip','db.sql.gz');
$upload_dir = wp_upload_dir();
$backup_dirname = $upload_dir['basedir'].'/wp-file-manager-pro/fm_backup/';
$backup_baseurl = site_url().'/wp-json/v1/fm/backup/';
$backupall_baseurl = site_url().'/wp-json/v1/fm/backupall/';
global $wpdb;
$fmdb = $wpdb->prefix.'wpfm_backup';
$backups = $wpdb->get_results("select * from ".$fmdb." order by id desc");
$settings = get_option('wp_file_manager_settings');
if(isset($settings['fm_max_packet_allowed'])){
    $default_packet_value = intval($settings['fm_max_packet_allowed']*1000000);
}else{
    $max_allowed_packet = 'max_allowed_packet';
    $packet_obj = $wpdb->get_row( $wpdb->prepare( "SHOW SESSION VARIABLES WHERE (variable_name = %s)", $max_allowed_packet ) );
    $default_packet_value = intval($packet_obj->Value);
}

wp_enqueue_style('fm_backup_css', plugins_url('../css/fm-backup.css', __FILE__), '', $this->ver);
wp_register_script( "fm_backup", plugins_url('../js/fm-backup.js',  __FILE__ ), array(), rand(0,9999) );
wp_localize_script( 'fm_backup', 'fmbackupparams', array(
    'ajaxurl' => admin_url('admin-ajax.php'),
    'plugin_url' => plugins_url('lib/', __FILE__),
    'packet_error_msg' => __('Error: Unable to restore backup because database backup is heavy in size. Please try to increase Maximum allowed size  from Preferences settings.','wp-file-manager'),
    'delete_backup' => __('Select backup(s) to delete!','wp-file-manager'),
    'confirm_del' => __('Are you sure want to remove selected backup(s)?','wp-file-manager'),
    'wpfmbackup'   => wp_create_nonce( 'wpfmbackup' ),
    'wpfmbackupremove' => wp_create_nonce( 'wpfmbackupremove' ),
    'wpfmbackuplogs' => wp_create_nonce( 'wpfmbackuplogs' ),
    'wpfmbackuprestore' => wp_create_nonce( 'wpfmbackuprestore' ),
    'backup_running' => __('Backup is running, please wait','wp-file-manager'),
    'restore_running' => __('Restore is running, please wait','wp-file-manager'),
    'backup_empty_error' => __('Nothing selected for backup.','wp-file-manager'),
    'backup_baseurl' => $backup_baseurl,
    'backupall_baseurl' => $backupall_baseurl,
    'default_packet_value' => $default_packet_value,
    )
);        
wp_enqueue_script( 'fm_backup' ); 

?>

<div class="wrap restore-sec">
	<div class="title">
		<h3> <?php _e('WP File Manager - Backup/Restore', 'wp-file-manager'); ?></h3>
	</div>
	
	<div class="schedule-back">

        <div class="double-col">
            <h4><?php _e('Backup Options:', 'wp-file-manager'); ?></h4>
            <div class="inner-col-wrap">
                <div class="inner-col-half">
                    <div class="colmn-div3">
                        <span class="styledCheckbox mrt10">
                            <input type="checkbox" name="fm_bkp_database" id="fm_bkp_database" value="5" checked="checked"> <span class="fm_checkmark"></span>
                        </span>
                        <span class="chk-label"><?php _e('Database Backup', 'wp-file-manager'); ?></span>
                    </div>
                    <div class="colmn-div3">
                        <span class="styledCheckbox mrt10">
                            <input type="checkbox" class="chk-all-files" name="fm_bkp_files" id="fm_bkp_files" value="files" checked="checked"> <span class="fm_checkmark"></span>
                        </span>
                        <span class="chk-label"><a href="javascript:void(0)" id="fm_open_files_option"><?php _e('Files Backup', 'wp-file-manager'); ?></a></span>
                        <div id="fm_open_files_options" class="fm_open_files_options">
                            <li><span class="styledCheckbox mrt10">
                                <input type="checkbox" class="chk-files" id="fm_bkp_plugins" name="fm_bkp_plugins" value="1" checked="checked"> <span class="fm_checkmark"></span>
                            </span> <span class="chk-label"><?php _e('Plugins', 'wp-file-manager'); ?></span></li>
                                <li><span class="styledCheckbox mrt10">
                                <input type="checkbox" class="chk-files" id="fm_bkp_themes" name="fm_bkp_themes" value="2" checked="checked"> <span class="fm_checkmark"></span>
                            </span> <span class="chk-label"><?php _e('Themes', 'wp-file-manager'); ?></span></li>
                                <li><span class="styledCheckbox mrt10">
                                <input type="checkbox" class="chk-files" id="fm_bkp_uploads" name="fm_bkp_uploads" value="3" checked="checked"> <span class="fm_checkmark"></span>
                            </span> <span class="chk-label"><?php _e('Uploads', 'wp-file-manager'); ?></span></li>
                                <li><span class="styledCheckbox mrt10">
                                <input type="checkbox" class="chk-files" id="fm_bkp_other" name="fm_bkp_other" value="4" checked="checked"> <span class="fm_checkmark"></span>
                            </span> <span class="chk-label"><?php _e('Others (Any other directories found inside wp-content)', 'wp-file-manager'); ?></span></li>
                        </div>
                    </div>
                    <div class="colmn-div3 inner-col-half">
                        <button id="wpfm-backupnow-button" type="button" class="backup_btn"><?php _e('Backup Now', 'wp-file-manager'); ?></button>
                    </div>
                </div>
            </div>                    
        </div>
        
        <div class="double-col">
            <div class="well">
                <b><?php _e('Time now', 'wp-file-manager'); ?></b>:  <?php echo date('D, F d, Y H:i');?>
            </div>
        </div>

		<div class="dlt_success_popup">
            <div class="dlt_success_popup_tbl">
                <div class="dlt_success_popup_cel">
                    <div class="dlt_success_popup_inner">
                        <a href="javascript:void(0)" class="close_dlt_success">&times;</a>
		                <div id="dlt_success_success"> 
                            <h3><?php _e('SUCCESS', 'wp-file-manager'); ?></h3>
                            <div class="dlt_success_wrap">
                                <p><?php _e('Backup successfully deleted.', 'wp-file-manager'); ?></p>
                                <button class="dlt_confirmed_success backup_btn_common"><?php _e('Ok', 'wp-file-manager'); ?></button>
                            </div>
                        </div>
                    </div><!--dlt_success_popup_inner-->
                </div>
            </div>
        </div>
        <!--dlt_success_popup-->

		<div class="dlt_backup_popup">
            <div class="dlt_backup_popup_tbl">
                <div class="dlt_backup_popup_cel">
                    <div class="dlt_backup_popup_inner">
                        <a href="javascript:void(0)" class="close_dlt_backup">&times;</a>
		                <div id="dlt_backup">
                            <h3><?php _e('DELETE FILES', 'wp-file-manager'); ?></h3>
                            <div class="dlt_btn_wrap">
                                <p><?php _e('Are you sure you want to delete this backup?', 'wp-file-manager'); ?></p>
                                <button class="dlt_cancel backup_btn_common"><?php _e('Cancel', 'wp-file-manager'); ?></button>
                                <button class="dlt_confirmed backup_btn_common"><?php _e('Confirm', 'wp-file-manager'); ?></button>
                            </div>
                        </div>
                    </div><!--dlt_backup_popup_inner-->
                </div>
            </div>
        </div>
        <!--dlt_backup_popup-->

		<div class="restore_backup_popup">
            <div class="restore_backup_popup_tbl">
                <div class="restore_backup_popup_cel">
                    <div class="restore_backup_popup_inner">
                        <a href="javascript:void(0)" class="close_restore_backup">&times;</a>
		                <div id="restore_backup"> 
                            <h3><?php _e('RESTORE FILES', 'wp-file-manager'); ?></h3>
                            <div class="restore_btn_wrap">
                                <p><?php _e('Are you sure you want to restore this backup?', 'wp-file-manager'); ?></p>
                                <button class="restore_cancel backup_btn_common"><?php _e('Cancel', 'wp-file-manager'); ?></button>
                                <button class="restore_confirmed backup_btn_common"><?php _e('Confirm', 'wp-file-manager'); ?></button>
                            </div>
                        </div>
                    </div><!--restore_backup_popup_inner-->
                </div>
            </div>
        </div>
        <!--restore_backup_popup-->

		<div class="fmbkp_console_popup">
            <div class="fmbkp_console_popup_tbl">
                <div class="fmbkp_console_popup_cel">
                    <div class="fmbkp_console_popup_inner">
                        <a href="javascript:void(0)" class="close_fm_console">&times;</a>
		                <div id="fmbkp_console"></div>
                        <div class="fmbkp_console_loader">
                            <img src="<?php echo plugins_url('images/loader-fm-console.gif', dirname(__FILE__)); ?>"/>
                        </div>
                    </div><!--fmbkp_console_popup_inner-->
                </div>
            </div>
        </div>
        <!--fmbkp_console_popup-->
	</div>
	
	<div class="log-message">
		<h3><?php _e('Last Log Message', 'wp-file-manager'); ?></h3>
        <p>
        <?php if(isset($backups) && !empty($backups)) { ?>
            <?php _e('The backup apparently succeeded and is now complete.', 'wp-file-manager'); ?> (<?php echo date('j M, Y H:i A', strtotime($backups[0]->backup_date));?>)
             <?php } else { ?>
                <?php _e('No log message', 'wp-file-manager'); ?> 
             <?php } ?>
		</p>
	</div>
	
	<div class="existing-back">
		<h3><?php _e('Existing Backup(s)', 'wp-file-manager'); ?> <span><?php echo count($backups);?></span> </h3>		
	</div>
	
	<div class="backup-main">
		<div class="backup-date">
            <span class="styledCheckbox mrt10">
                <input type="checkbox" class="bkpchkCheckAll" <?php echo count($backups) == 0 ? 'disabled="disabled"' : "";?>> <span class="fm_checkmark"></span>
            </span> <span class="chk-label"> <?php _e('Backup Date', 'wp-file-manager'); ?> </span>
		</div>
		<div class="download bck_action">
			 <span> <?php _e('Backup data (click to download)', 'wp-file-manager'); ?></span>
		</div>
        <div class="action_ele">
			 <span> <?php _e('Action', 'wp-file-manager'); ?></span>
		</div>
	</div>
	

    <?php if(isset($backups) && !empty($backups)) {
        $count = 1;
        $todayDate = date('Y-m-d');
        $todayDate = strtotime($todayDate);
		foreach($backups as $backup) { 
            $backupNameExp = $backup->backup_date; 
            $compareDate = date("Y-m-d", strtotime($backupNameExp));
            $compareDate = strtotime($compareDate);
            $backupName = date("M d, Y H:i", strtotime($backupNameExp));
		?>
	<div class="database-sec <?php echo($count++%2 == 0) ? 'even' : 'odd'?>">
		<div class="backup-date">
            <span class="styledCheckbox mrt10">
                <input type="checkbox" value="<?php echo $backup->id;?>" name="backupids[]" class="backupids"> <span class="fm_checkmark"></span>
            </span>
            <span class="chk-label"><?php echo date('j M, Y H:i A', strtotime($backupName)); ?> <?php echo ($todayDate == $compareDate) ? '('.__("Today", "wp-file-manager").')' : '';?> </span>
		</div>
		<div class="download bck_action">
          
		    <?php 
              $backup_count = 0;
            foreach($backupDirs as $backupDir) {
                $bkpName = $backup->backup_name.'-'.$backupDir;
                $dir = $backup_dirname.$bkpName;
                if(file_exists($dir)) {   
                    $backup_count++;
                    if($backupDir == 'db.sql.gz') {
                        $dirName = 'Database';
                    } else {
                        $dirName = str_replace('.zip','',$backupDir);
                    }
                    $size = filesize($dir);
                    $backup_type = explode('.',$backupDir);
                    $id = (int) $backup->id;
               ?>
                <a href="javascript:void(0)" class="bck-icon" data-token="<?php echo base64_encode($backup->id).'/'.base64_encode($backup_type[0]).'/'.base64_encode(site_url().self::fm_get_key());?>"><?php echo ucfirst($dirName); ?> (<?php echo $this->formatSizeUnits($size); ?>)</a>
              <?php } 
            }
            if($backup_count > 1){  ?>
                <div class="fm-download-all button">Download All</div>
                   <?php   }
            ?>
		</div>
        <div class="action_ele">
			 <button class="exitBackBtn restore_btn bkpRestoreID" id="<?php echo $backup->id; ?>"><?php _e('Restore', 'wp-file-manager'); ?></button>
             <button class="exitBackBtn del_btn bkpDeleteID" id="<?php echo $backup->id; ?>"><?php _e('Delete', 'wp-file-manager'); ?></button>
             <button class="exitBackBtn log_btn bkpViewLog" id="<?php echo $backup->id; ?>"><?php _e('View Log', 'wp-file-manager'); ?></button>
		</div>
	</div>
	<?php } ?>
	<?php } else { ?>
           <p class="no_backup"><?php _e('Currently no backup(s) found.', 'wp-file-manager'); ?></p>
          <?php } ?>
	<div class="action-sec">
		<strong> <?php _e('Actions upon selected backup(s)', 'wp-file-manager'); ?></strong>
        <button class="exitBackBtn bkpDelete del_btn disabled_btn"><?php _e('Delete', 'wp-file-manager'); ?></button>
		<button class="exitBackBtn bkpCheckAll restore_btn <?php echo count($backups) == 0 ? 'disabled_btn' : '';?>"><?php _e('Select All', 'wp-file-manager'); ?></button>
        <button class="exitBackBtn bkpUnCheckAll log_btn disabled_btn"><?php _e('Deselect', 'wp-file-manager'); ?></button>	
	</div>
    
</div>
