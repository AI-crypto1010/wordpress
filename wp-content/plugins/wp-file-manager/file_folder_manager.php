<?php
/**
  Plugin Name: WP File Manager
  Plugin URI: https://wordpress.org/plugins/wp-file-manager
  Description: Manage your WP files.
  Author: mndpsingh287
  Version: 8.0.2
  Author URI: https://profiles.wordpress.org/mndpsingh287
  License: GPLv2
 **/
if (!defined('WP_FILE_MANAGER_DIRNAME')) {
    define('WP_FILE_MANAGER_DIRNAME', plugin_basename(dirname(__FILE__)));
}
if ( ! defined( 'WP_FM_SITE_URL' ) ) {
    define( 'WP_FM_SITE_URL', 'https://filemanagerpro.io' );
}
define('WP_FILE_MANAGER_PATH', plugin_dir_path(__FILE__));
if (!class_exists('mk_file_folder_manager')):
    class mk_file_folder_manager
    {
        protected $SERVER = 'https://filemanagerpro.io/api/plugindata/api.php';
        var $ver = '8.0.2';
        /* Auto Load Hooks */
        public function __construct()
        {
	        add_action('activated_plugin', array(&$this, 'deactivate_file_manager_pro'));
            add_action('admin_menu', array(&$this, 'ffm_menu_page'));
            add_action('network_admin_menu', array(&$this, 'ffm_menu_page'));
            add_action('admin_enqueue_scripts', array(&$this, 'ffm_admin_things'));
            add_action('admin_enqueue_scripts', array(&$this, 'ffm_admin_script'));
            add_action('wp_ajax_mk_file_folder_manager', array(&$this, 'mk_file_folder_manager_action_callback'));
            add_action('wp_ajax_mk_fm_close_fm_help', array($this, 'mk_fm_close_fm_help'));
            add_filter('plugin_action_links', array(&$this, 'mk_file_folder_manager_action_links'), 10, 2);
            do_action('load_filemanager_extensions');
            add_action('plugins_loaded', array(&$this, 'filemanager_load_text_domain'));
            /*
            File Manager Verify Email
            */
            add_action('wp_ajax_mk_filemanager_verify_email', array(&$this, 'mk_filemanager_verify_email_callback'));
            add_action('wp_ajax_verify_filemanager_email', array(&$this, 'verify_filemanager_email_callback'));
            /*
            Media Upload
            */
            add_action('wp_ajax_mk_file_folder_manager_media_upload', array(&$this, 'mk_file_folder_manager_media_upload'));
            /* New Feature */
            add_action('init', array(&$this, 'create_auto_directory'));
            /* Backup - Feature */
            add_action('wp_ajax_mk_file_manager_backup', array(&$this, 'mk_file_manager_backup_callback'));
            add_action('wp_ajax_mk_file_manager_backup_remove', array(&$this, 'mk_file_manager_backup_remove_callback'));
            add_action('wp_ajax_mk_file_manager_single_backup_remove', array(&$this, 'mk_file_manager_single_backup_remove_callback'));
            add_action('wp_ajax_mk_file_manager_single_backup_logs', array(&$this, 'mk_file_manager_single_backup_logs_callback'));
            add_action('wp_ajax_mk_file_manager_single_backup_restore', array(&$this, 'mk_file_manager_single_backup_restore_callback'));
            add_action( 'rest_api_init', function () {
            if(current_user_can('manage_options') || (is_multisite() && current_user_can( 'manage_network' ))){
                    register_rest_route( 'v1', '/fm/backup/(?P<backup_id>[a-zA-Z0-9-=]+)/(?P<type>[a-zA-Z0-9-=]+)/(?P<key>[a-zA-Z0-9-=]+)', array(
                        'methods' => 'GET',
                        'callback' => array( $this, 'fm_download_backup' ),
                        'permission_callback' => '__return_true',
                    ));
                
                    register_rest_route( 'v1', '/fm/backupall/(?P<backup_id>[a-zA-Z0-9-=]+)/(?P<type>[a-zA-Z0-9-=]+)/(?P<key>[a-zA-Z0-9-=]+)/(?P<all>[a-zA-Z]+)', array(
                        'methods' => 'GET',
                        'callback' => array( $this, 'fm_download_backup_all' ),
                        'permission_callback' => '__return_true',
                    ));
                }
            });
        }

	    /**
	     * Checks if another version of Filemanager/Filemanager PRO is active and deactivates it.
	     * Hooked on `activated_plugin` so other plugin is deactivated when current plugin is activated.
	     *
	     * @return void
	     */
	    public function deactivate_file_manager_pro($plugin) {

		    if ( ! in_array( $plugin, array(
			    'wp-file-manager/file_folder_manager.php',
			    'wp-file-manager-pro/file_folder_manager_pro.php'
		    ), true ) ) {
			    return;
		    }

		    $plugin_to_deactivate  = 'wp-file-manager/file_folder_manager.php';

		    // If we just activated the free version, deactivate the pro version.
		    if ( $plugin === $plugin_to_deactivate ) {
			    $plugin_to_deactivate  = 'wp-file-manager-pro/file_folder_manager_pro.php';
		    }

		    if ( is_multisite() && is_network_admin() ) {
			    $active_plugins = (array) get_site_option( 'active_sitewide_plugins', array() );
			    $active_plugins = array_keys( $active_plugins );
		    } else {
			    $active_plugins = (array) get_option( 'active_plugins', array() );
		    }

		    foreach ( $active_plugins as $plugin_basename ) {
			    if ( $plugin_to_deactivate === $plugin_basename ) {
				    deactivate_plugins( $plugin_basename );
				    return;
			    }
		    }
	    }

        /* Auto Directory */
        public function create_auto_directory() {
            $upload_dir = wp_upload_dir();
            $backup_dirname = $upload_dir['basedir'].'/wp-file-manager-pro/fm_backup';
            if (!file_exists($backup_dirname)) {
                wp_mkdir_p($backup_dirname);
            }

            // security fix
            $myfile = $backup_dirname."/.htaccess";
            if(!file_exists($myfile)){
                $myfileHandle = @fopen($myfile, 'w+');
                if(!is_bool($myfileHandle)){
                     $txt = '<FilesMatch "\.(zip|gz)$">';
                    $txt .= "\nOrder allow,deny\n";
                    $txt .= "Deny from all\n";
                    $txt .= "</Files>";
                    @fwrite($myfileHandle, $txt);
                    @fclose($myfileHandle);
                }
            }

            // creating blank index.php inside fm_backup
            $ourFileName = $backup_dirname."/index.html";
            if(!file_exists($ourFileName)){
                $ourFileHandle = @fopen($ourFileName, 'w');
                if(!is_bool($ourFileHandle)){
                    @fclose($ourFileHandle);
                    @chmod($ourFileName, 0755);
                }
            }

        }

        /*
        Backup - Restore
        */
        public function mk_file_manager_single_backup_restore_callback() {
            WP_Filesystem(); 
            global $wp_filesystem;
            $nonce = sanitize_text_field($_POST['nonce']);
            if(current_user_can('manage_options') && wp_verify_nonce( $nonce, 'wpfmbackuprestore' )) {
                global $wpdb;
                $fmdb = $wpdb->prefix.'wpfm_backup';
                $upload_dir = wp_upload_dir();
                $backup_dirname = $upload_dir['basedir'].'/wp-file-manager-pro/fm_backup/';
                $bkpid = intval($_POST['id']);
                $result = array();
                $filesDestination = WP_CONTENT_DIR.'/';

                if ( strcmp($backup_dirname, "/") === 0 ) {
                    $backup_path = $backup_dirname;
                }else{
                    $backup_path = $backup_dirname."/";
                }
                
                $database = sanitize_text_field($_POST['database']);
                $plugins = sanitize_text_field($_POST['plugins']);
                $themes = sanitize_text_field($_POST['themes']);
                $uploads = sanitize_text_field($_POST['uploads']);
                $others = sanitize_text_field($_POST['others']);
                if($bkpid) {
                    include('classes/files-restore.php');
                    $restoreFiles = new wp_file_manager_files_restore();
                    $fmbkp = $wpdb->get_row(
                        $wpdb->prepare('select * from '.$fmdb.' where id = %d', $bkpid)
                    );
                    if($themes == 'true') {
                        // case 1 - Themes
                        if(file_exists($backup_dirname.$fmbkp->backup_name.'-themes.zip')) {
                            $wp_filesystem->delete($filesDestination.'themes',true);
                            $restoreThemes = $restoreFiles->extract($backup_dirname.$fmbkp->backup_name.'-themes.zip',$filesDestination.'themes');
                            if($restoreThemes) {
                                echo wp_json_encode(array('step' => 1, 'database' => $database,'plugins' => $plugins,'themes' => 'false', 'uploads'=> $uploads, 'others' => $others,'bkpid' => $bkpid,'msg' => '<li class="fm-running-list fm-custom-checked">'.__('Themes backup restored successfully.', 'wp-file-manager').'</li>'));  
                                die;
                            } else {
                                echo wp_json_encode(array('step' => 1, 'database' => $database,'plugins' => $plugins,'themes' => 'false', 'uploads'=> $uploads, 'others' => $others,'bkpid' => $bkpid,'msg' => '<li class="fm-running-list fm-custom-unchecked">'.__('Unable to restore themes.', 'wp-file-manager').'</li>'));   
                                die;
                            }            
                        }else {
                            echo wp_json_encode(array('step' => 1, 'database' => $database,'plugins' => $plugins,'themes' => 'false', 'uploads'=> $uploads, 'others' => $others,'bkpid' => $bkpid,'msg' => ''));   
                            die;
                        }   
                    } 
                    else if($uploads == 'true'){
                        // case 2 - Uploads
                        if ( is_multisite() ) { 
                            $path_direc =  $upload_dir['basedir'];
                        } else {
                            $path_direc =   $filesDestination.'uploads';
                        }
                        if(file_exists($backup_dirname.$fmbkp->backup_name.'-uploads.zip')) {
                            $alllist = $wp_filesystem->dirlist($path_direc);
                            if(is_array($alllist) && !empty($alllist))
                            {
                                foreach($alllist as $key=>$value)
                                {
                                    if($key!= 'wp-file-manager-pro')
                                    {
                                        $wp_filesystem->delete($path_direc.'/'.$key,true);
                                    }
                                }
                            }

                            $restoreUploads = $restoreFiles->extract($backup_dirname.$fmbkp->backup_name.'-uploads.zip',$path_direc);
                            if($restoreUploads) {
                                echo wp_json_encode(array('step' => 1, 'database' => $database,'plugins' => $plugins,'themes' => $themes, 'uploads'=> 'false', 'others' => $others,'bkpid' => $bkpid,'msg' => '<li class="fm-running-list fm-custom-checked">'.__('Uploads backup restored successfully.', 'wp-file-manager').'</li>'));  
                                die;
                        
                            } else {
                                echo wp_json_encode(array('step' => 1, 'database' => $database,'plugins' => $plugins,'themes' => $themes, 'uploads'=> 'false', 'others' => $others,'bkpid' => $bkpid,'msg' => '<li class="fm-running-list fm-custom-unchecked">'.__('Unable to restore uploads.', 'wp-file-manager').'</li>')); 
                                die;
                        
                            }                    
                        } else {
                            echo wp_json_encode(array('step' => 1, 'database' => $database,'plugins' => $plugins,'themes' => $themes, 'uploads'=> 'false', 'others' => $others,'bkpid' => $bkpid,'msg' => '')); 
                            die;
                    
                        }   
                    }
                    else if($others == 'true'){
                    // case 3 - Others
                        if(file_exists($backup_dirname.$fmbkp->backup_name.'-others.zip')) {
                            $alllist = $wp_filesystem->dirlist($filesDestination);
                            if(is_array($alllist) && !empty($alllist))
                            {
                                foreach($alllist as $key=>$value)
                                {
                                    if($key != 'themes' && $key != 'uploads' && $key != 'plugins')
                                    {
                                        $wp_filesystem->delete($filesDestination.$key,true);
                                    }
                                }
                            }
                            $restoreOthers = $restoreFiles->extract($backup_dirname.$fmbkp->backup_name.'-others.zip',$filesDestination);
                            if($restoreOthers) {
                                echo wp_json_encode(array('step' => 1, 'database' => $database,'plugins' => $plugins,'themes' => $themes, 'uploads'=> $uploads, 'others' => 'false','bkpid' => $bkpid,'msg' => '<li class="fm-running-list fm-custom-checked">'.__('Others backup restored successfully.', 'wp-file-manager').'</li>')); 
                                die;
                        
                            } else {
                                echo wp_json_encode(array('step' => 1, 'database' => $database,'plugins' => $plugins,'themes' => $themes, 'uploads'=> $uploads, 'others' => 'false','bkpid' => $bkpid,'msg' => '<li class="fm-running-list fm-custom-unchecked">'.__('Unable to restore others.', 'wp-file-manager').'</li>')); 
                                die;
                        
                            }                  
                        }else {
                            echo wp_json_encode(array('step' => 1, 'database' => $database,'plugins' => $plugins,'themes' => $themes, 'uploads'=> $uploads, 'others' => 'false','bkpid' => $bkpid,'msg' => '')); 
                            die;
                        }
                    }
                    else if($plugins == 'true'){
                        // case 4- Plugins
                        if(file_exists($backup_path.$fmbkp->backup_name.'-plugins.zip')) {
                            $alllist = $wp_filesystem->dirlist($filesDestination.'plugins');
                            if(is_array($alllist) && !empty($alllist))
                            {
                                foreach($alllist as $key=>$value)
                                {
                                    if($key!= 'wp-file-manager')
                                    {
                                        $wp_filesystem->delete($filesDestination.'plugins/'.$key,true);
                                    }
                                }
                            }

                            $restorePlugins = $restoreFiles->extract($backup_path.$fmbkp->backup_name.'-plugins.zip',$filesDestination.'plugins');
                            if($restorePlugins) {
                                echo wp_json_encode(array('step' => 1, 'database' => $database,'plugins' => 'false','themes' => $themes, 'uploads'=> $uploads, 'others' => $others,'bkpid' => $bkpid,'msg' => '<li class="fm-running-list fm-custom-checked">'.__('Plugins backup restored successfully.', 'wp-file-manager').'</li>'));  
                                die;
                    
                            } else {
                                echo wp_json_encode(array('step' => 1, 'database' => $database,'plugins' => 'false','themes' => $themes, 'uploads'=> $uploads, 'others' => $others,'bkpid' => $bkpid,'msg' => '<li class="fm-running-list fm-custom-unchecked">'.__('Unable to restore plugins.', 'wp-file-manager').'</li>')); 
                                die;
                            }                                      
                        }else {
                            echo wp_json_encode(array('step' => 1, 'database' => $database,'plugins' => 'false','themes' => $themes, 'uploads'=> $uploads, 'others' => $others,'bkpid' => 0,'msg' => '')); 
                            die;
                    
                        }   
                    } 
                    else if($database == 'true'){
                        // case 5- Database
                        if(file_exists($backup_dirname.$fmbkp->backup_name.'-db.sql.gz')) {    
                            include('classes/db-restore.php');
                            $restoreDatabase = new Restore_Database($fmbkp->backup_name.'-db.sql.gz');
                            if($restoreDatabase->restoreDb()) {
                                echo wp_json_encode(array('step' => 0, 'database' => 'false','plugins' => $plugins,'themes' => $themes, 'uploads'=> $uploads, 'others' => $others,'bkpid' => '','msg' => '<li class="fm-running-list fm-custom-checked">'.__('Database backup restored successfully.', 'wp-file-manager').'</li>',  'msgg' => '<li class="fm-running-list fm-custom-checked">'.__('All Done', 'wp-file-manager').'</li>')); 
                                die;
                            } else {
                                echo wp_json_encode(array('step' => 0, 'database' => 'false','plugins' => $plugins,'themes' => $themes, 'uploads'=> $uploads, 'others' => $others,'bkpid' => $bkpid,'msg' => '<li class="fm-running-list fm-custom-unchecked">'.__('Unable to restore DB backup.', 'wp-file-manager').'</li>'));  
                                die;
                            }
                        }else {
                            echo wp_json_encode(array('step' => 1, 'database' => 'false','plugins' => $plugins,'themes' => $themes, 'uploads'=> $uploads, 'others' => $others,'bkpid' => $bkpid,'msg' => ''));  
                            die;
                        }  
                    }else {
                        echo wp_json_encode(array('step' => 0, 'database' => 'false','plugins' => 'false','themes' => 'false','uploads'=> 'false','others' => 'false', 'bkpid' => '', 'msg' => '<li class="fm-running-list fm-custom-checked">'.__('All Done', 'wp-file-manager').'</li>'));                        
                        die;
                    }
                } else {
                        echo wp_json_encode(array('step' => 0, 'database' => 'false','plugins' => 'false','themes' => 'false', 'uploads'=> 'false', 'others' => 'false','bkpid' => '','msg' => '<li class="fm-running-list fm-custom-unchecked">'.__('Unable to restore plugins.', 'wp-file-manager').'</li>'));
                        die;
                }
                die;
            }
        }
        /*
        Backup - Remove
        */
        public function mk_file_manager_backup_remove_callback(){
            $nonce = sanitize_text_field($_POST['nonce']);
            if(current_user_can('manage_options') && wp_verify_nonce( $nonce, 'wpfmbackupremove' )) {
            global $wpdb;
            $fmdb = $wpdb->prefix.'wpfm_backup';
            $upload_dir = wp_upload_dir();
            $backup_dirname = $upload_dir['basedir'].'/wp-file-manager-pro/fm_backup/';
            $bkpRids = $_POST['delarr'];
            $isRemoved = false;        
            if(isset($bkpRids)) {
                foreach($bkpRids as $bkRid) {
                    $bkRid = intval($bkRid);
                    $fmbkp = $wpdb->get_row(
                        $wpdb->prepare('select * from '.$fmdb.' where id = %d',$bkRid)
                    );
                    if(file_exists($backup_dirname.$fmbkp->backup_name.'-db.sql.gz')) {
                        unlink($backup_dirname.$fmbkp->backup_name.'-db.sql.gz');
                    }
                    if(file_exists($backup_dirname.$fmbkp->backup_name.'-others.zip')) {
                        unlink($backup_dirname.$fmbkp->backup_name.'-others.zip');
                    }
                    if(file_exists($backup_dirname.$fmbkp->backup_name.'-plugins.zip')) {
                        unlink($backup_dirname.$fmbkp->backup_name.'-plugins.zip');
                    }
                    if(file_exists($backup_dirname.$fmbkp->backup_name.'-themes.zip')) {
                        unlink($backup_dirname.$fmbkp->backup_name.'-themes.zip');
                    }
                    if(file_exists($backup_dirname.$fmbkp->backup_name.'-uploads.zip')) {
                        unlink($backup_dirname.$fmbkp->backup_name.'-uploads.zip');
                    }
                    // removing from db
                    $wpdb->delete($fmdb, array('id' => $bkRid));
                    $isRemoved = true;
                }
            }
            if($isRemoved) {
                
                echo __('Backups removed successfully!','wp-file-manager');
            } else {
                echo __('Unable to removed backup!','wp-file-manager'); 
            }
            die;
        }
        }
        /*
        Backup Logs
        */
        public function mk_file_manager_single_backup_logs_callback() {
            $nonce = sanitize_text_field($_POST['nonce']);
            if(current_user_can('manage_options') && wp_verify_nonce( $nonce, 'wpfmbackuplogs' )) {
            global $wpdb;
            $fmdb = $wpdb->prefix.'wpfm_backup';
            $upload_dir = wp_upload_dir();
            $backup_dirname = $upload_dir['basedir'].'/wp-file-manager-pro/fm_backup/';
            $bkpId = intval($_POST['id']);
            $logs = array(); 
            $logMessage = '';       
            if(isset($bkpId)) {
                    $fmbkp = $wpdb->get_row(
                        $wpdb->prepare('select * from '.$fmdb.' where id = %d', $bkpId)
                    );
                    if(file_exists($backup_dirname.$fmbkp->backup_name.'-db.sql.gz')) {
                        $size = filesize($backup_dirname.$fmbkp->backup_name.'-db.sql.gz');
                        $logs[] = __('Database backup done on date ', 'wp-file-manager').$fmbkp->backup_date.' ('.$fmbkp->backup_name.'-db.sql.gz) ('.$this->formatSizeUnits($size).')';
                    }                    
                    if(file_exists($backup_dirname.$fmbkp->backup_name.'-plugins.zip')) {
                        $size = filesize($backup_dirname.$fmbkp->backup_name.'-plugins.zip');
                        $logs[] = __('Plugins backup done on date ', 'wp-file-manager').$fmbkp->backup_date.' ('.$fmbkp->backup_name.'-plugins.zip) ('.$this->formatSizeUnits($size).')';
                    }
                    if(file_exists($backup_dirname.$fmbkp->backup_name.'-themes.zip')) {
                        $size = filesize($backup_dirname.$fmbkp->backup_name.'-themes.zip');
                        $logs[] = __('Themes backup done on date ', 'wp-file-manager').$fmbkp->backup_date.' ('.$fmbkp->backup_name.'-themes.zip) ('.$this->formatSizeUnits($size).')';
                    }
                    if(file_exists($backup_dirname.$fmbkp->backup_name.'-uploads.zip')) {
                        $size = filesize($backup_dirname.$fmbkp->backup_name.'-uploads.zip');
                        $logs[] = __('Uploads backup done on date ', 'wp-file-manager').$fmbkp->backup_date.' ('.$fmbkp->backup_name.'-uploads.zip) ('.$this->formatSizeUnits($size).')';
                    }
                    if(file_exists($backup_dirname.$fmbkp->backup_name.'-others.zip')) {
                        $size = filesize($backup_dirname.$fmbkp->backup_name.'-others.zip');
                        $logs[] = __('Others backup done on date ', 'wp-file-manager').$fmbkp->backup_date.' ('.$fmbkp->backup_name.'-others.zip) ('.$this->formatSizeUnits($size).')';
                    }
            }
            $count = 1;
            $logMessage = '<h3 class="fm_console_log_pop log_msg_align_center">'.__('Logs', 'wp-file-manager').'</h3>';
            if(isset($logs)) {
                foreach($logs as $log) {
                    $logMessage .= '<p class="fm_console_success">('.$count++.') '.$log.'</p>';
                }
            } else {
                $logMessage .= '<p class="fm_console_error">'.__('No logs found!', 'wp-file-manager').'</p>';
            }
            echo $logMessage;
            die; 
        }
        }
       /*
       Returning Valid Format
       */
        public function formatSizeUnits($bytes) {
            if ($bytes >= 1073741824)
            {
                $bytes = number_format($bytes / 1073741824, 2) . ' GB';
            }
            elseif ($bytes >= 1048576)
            {
                $bytes = number_format($bytes / 1048576, 2) . ' MB';
            }
            elseif ($bytes >= 1024)
            {
                $bytes = number_format($bytes / 1024, 2) . ' KB';
            }
            elseif ($bytes > 1)
            {
                $bytes = $bytes . ' bytes';
            }
            elseif ($bytes == 1)
            {
                $bytes = $bytes . ' byte';
            }
            else
            {
                $bytes = '0 bytes';
            }

            return $bytes;
        }
        /*
        Backup - Remove
        */
        public function mk_file_manager_single_backup_remove_callback(){
            $nonce = sanitize_text_field($_POST['nonce']);
            if(current_user_can('manage_options') && wp_verify_nonce( $nonce, 'wpfmbackupremove' )) {
            global $wpdb;
            $fmdb = $wpdb->prefix.'wpfm_backup';
            $upload_dir = wp_upload_dir();
            $backup_dirname = $upload_dir['basedir'].'/wp-file-manager-pro/fm_backup/';
            $bkpId = intval($_POST['id']);
            $isRemoved = false;        
            if(isset($bkpId)) {
                    $fmbkp = $wpdb->get_row(
                        $wpdb->prepare('select * from '.$fmdb.' where id = %d',$bkpId)
                    );
                    if(file_exists($backup_dirname.$fmbkp->backup_name.'-db.sql.gz')) {
                        unlink($backup_dirname.$fmbkp->backup_name.'-db.sql.gz');
                    }
                    if(file_exists($backup_dirname.$fmbkp->backup_name.'-others.zip')) {
                        unlink($backup_dirname.$fmbkp->backup_name.'-others.zip');
                    }
                    if(file_exists($backup_dirname.$fmbkp->backup_name.'-plugins.zip')) {
                        unlink($backup_dirname.$fmbkp->backup_name.'-plugins.zip');
                    }
                    if(file_exists($backup_dirname.$fmbkp->backup_name.'-themes.zip')) {
                        unlink($backup_dirname.$fmbkp->backup_name.'-themes.zip');
                    }
                    if(file_exists($backup_dirname.$fmbkp->backup_name.'-uploads.zip')) {
                        unlink($backup_dirname.$fmbkp->backup_name.'-uploads.zip');
                    }
                    // removing from db
                    $wpdb->delete($fmdb, array('id' => $bkpId));
                    $isRemoved = true;
            }
            if($isRemoved) {
                echo  "1";
            } else {
                echo "2";
            }
            die;
        }
        }
        /*
        Backup - Ajax - Feature
        */
        public function mk_file_manager_backup_callback(){
            
            $nonce = sanitize_text_field( $_POST['nonce'] );
            if( current_user_can( 'manage_options' ) && wp_verify_nonce( $nonce, 'wpfmbackup' ) ) {
            global $wpdb;
            $fmdb = $wpdb->prefix.'wpfm_backup';
            $date = date('Y-m-d H:i:s');
            $file_number = 'backup_'.date('Y_m_d_H_i_s-').bin2hex(openssl_random_pseudo_bytes(4));
            $database = sanitize_text_field($_POST['database']);
            $files = sanitize_text_field($_POST['files']);
            $plugins = sanitize_text_field($_POST['plugins']);
            $themes = sanitize_text_field($_POST['themes']);
            $uploads = sanitize_text_field($_POST['uploads']);
            $others = sanitize_text_field($_POST['others']);
            $bkpid = isset($_POST['bkpid']) ? sanitize_text_field($_POST['bkpid']) : '';
            if($database == 'false' && $files == 'false' && $bkpid == '') {
                echo wp_json_encode(array('step' => '0', 'database' => 'false','files' => 'false','plugins' => 'false','themes' => 'false', 'uploads'=> 'false', 'others' => 'false', 'bkpid' => '0', 'msg' => '<li class="fm-running-list fm-custom-unchecked">'.__('Nothing selected for backup','wp-file-manager').'</li>'));
                die; 
            }
            if($bkpid == '') {
                $wpdb->insert( 
                    $fmdb, 
                    array( 
                        'backup_name' => $file_number, 
                        'backup_date' => $date
                    ), 
                    array( 
                        '%s', 
                        '%s' 
                    ) 
                );
                $id = $wpdb->insert_id;
            } else {
                $id = $bkpid;
            }
            if ( ! wp_verify_nonce( $nonce, 'wpfmbackup' ) ) {
                echo wp_json_encode(array('step' => 0, 'msg' => '<li class="fm-running-list fm-custom-unchecked">'.__('Security Issue.', 'wp-file-manager').'</li>'));
            } else {
                $fileName = $wpdb->get_row(
                  $wpdb->prepare("select * from ".$fmdb." where id=%d",$id)
                );              
                //database
                if($database == 'true') {
                    include('classes/db-backup.php'); 
                    $backupDatabase = new Backup_Database($fileName->backup_name);
                    $result = $backupDatabase->backupTables(TABLES);
                    if($result == '1'){
                        echo wp_json_encode(array('step' => 1, 'database' => 'false','files' => $files,'plugins' => $plugins,'themes' => $themes, 'uploads'=> $uploads, 'others' => $others,'bkpid' => $id,'msg' => '<li class="fm-running-list fm-custom-checked">'.__('Database backup done.', 'wp-file-manager').'</li>'));  
                        die;
                    } else {
                        echo wp_json_encode(array('step' => 1, 'database' => 'false','files' => $files,'plugins' => $plugins,'themes' => $themes, 'uploads'=> $uploads, 'others' => $others,'bkpid' => $id, 'msg' => '<li class="fm-running-list fm-custom-unchecked">'.__('Unable to create database backup.', 'wp-file-manager').'</li>'));   
                        die;
                    }                   
                }
                else if($files == 'true') {
                    include('classes/files-backup.php');
                    $upload_dir = wp_upload_dir();
                    $backup_dirname = $upload_dir['basedir'].'/wp-file-manager-pro/fm_backup';
                    $filesBackup = new wp_file_manager_files_backup();
                     // plugins
                     if($plugins == 'true') {
                        $plugin_dir = WP_PLUGIN_DIR;  
                        $backup_plugins = $filesBackup->zipData( $plugin_dir,$backup_dirname.'/'.$fileName->backup_name.'-plugins.zip');
                        if($backup_plugins) {
                            echo wp_json_encode(array('step' => 1, 'database' => 'false','files' => 'true','plugins' => 'false','themes' => $themes, 'uploads'=> $uploads, 'others' => $others,'bkpid' => $id, 'msg' => '<li class="fm-running-list fm-custom-checked">'.__('Plugins backup done.', 'wp-file-manager').'</li>'));
                            die;
                        } else {
                            echo wp_json_encode(array('step' => 1, 'database' => 'false','files' => 'true','plugins' => 'false','themes' => $themes, 'uploads'=> $uploads, 'others' => $others, 'bkpid' => $id, 'msg' => '<li class="fm-running-list fm-custom-unchecked">'.__('Plugins backup failed.', 'wp-file-manager').'</li>')); 
                            die;
                        }
                     } 
                     // themes
                     else if($themes == 'true') {
                        $themes_dir = get_theme_root();
                        $backup_themes = $filesBackup->zipData( $themes_dir,$backup_dirname.'/'.$fileName->backup_name.'-themes.zip');
                        if($backup_themes) {
                            echo wp_json_encode(array('step' => 1, 'database' => 'false','files' => 'true','plugins' => 'false','themes' => 'false', 'uploads'=> $uploads, 'others' => $others, 'bkpid' => $id, 'msg' => '<li class="fm-running-list fm-custom-checked">'.__('Themes backup done.', 'wp-file-manager').'</li>'));
                            die;
                        } else {
                            echo wp_json_encode(array('step' => 1, 'database' => 'false','files' => 'true','plugins' => 'false','themes' => $themes, 'uploads'=> $uploads, 'others' => $others, 'bkpid' => $id, 'msg' => '<li class="fm-running-list fm-custom-unchecked">'.__('Themes backup failed.', 'wp-file-manager').'</li>')); 
                            die;
                        }
                     }
                     // uploads
                     else if($uploads == 'true') {
                        $wpfm_upload_dir = wp_upload_dir();
                        $uploads_dir = $wpfm_upload_dir['basedir'];
                        $backup_uploads = $filesBackup->zipData( $uploads_dir,$backup_dirname.'/'.$fileName->backup_name.'-uploads.zip');
                        if($backup_uploads) {
                            echo wp_json_encode(array('step' => 1, 'database' => 'false','files' => 'true','plugins' => 'false','themes' => 'false', 'uploads'=> 'false', 'others' => $others, 'bkpid' => $id, 'msg' => '<li class="fm-running-list fm-custom-checked">'.__('Uploads backup done.', 'wp-file-manager').'</li>'));
                            die;
                        } else {
                            echo wp_json_encode(array('step' => 1, 'database' => 'false','files' => 'true','plugins' => 'false','themes' => 'false', 'uploads'=> 'false', 'others' => $others, 'bkpid' => $id, 'msg' => '<li class="fm-running-list fm-custom-unchecked">'.__('Uploads backup failed.', 'wp-file-manager').'</li>'));
                            die;
                        }
                     } 
                     // other
                     else if($others == 'true') {
                        $others_dir = WP_CONTENT_DIR;
                        $backup_others = $filesBackup->zipOther( $others_dir,$backup_dirname.'/'.$fileName->backup_name.'-others.zip');
                        if($backup_others) {
                            echo wp_json_encode(array('step' => 1, 'database' => 'false','files' => 'true','plugins' => 'false','themes' => 'false', 'uploads'=> 'false', 'others' => 'false', 'bkpid' => $id, 'msg' => '<li class="fm-running-list fm-custom-checked">'.__('Others backup done.', 'wp-file-manager').'</li>'));
                            die; 
                        } else {
                            echo wp_json_encode(array('step' => 1, 'database' => 'false','files' => 'true','plugins' => 'false','themes' => 'false', 'uploads'=> 'false', 'others' => 'false', 'bkpid' => $id, 'msg' => '<li class="fm-running-list fm-custom-unchecked">'.__('Others backup failed.', 'wp-file-manager').'</li>'));
                            
                        }                        
                     } else {
                        echo wp_json_encode(array('step' => 0, 'database' => 'false', 'files' => 'false','plugins' => 'false','themes' => 'false','uploads'=> 'false','others' => 'false', 'bkpid' => $id, 'msg' => '<li class="fm-running-list fm-custom-checked">'.__('All Done', 'wp-file-manager').'</li>'));
                        die;
                     }
                } else {
                 echo wp_json_encode(array('step' => 0, 'database' => 'false', 'files' => 'false','plugins' => 'false','themes' => 'false','uploads'=> 'false','others' => 'false','bkpid' => $id, 'msg' => '<li class="fm-running-list fm-custom-checked">'.__('All Done', 'wp-file-manager').'</li>'));
                }
            }
            } else {
                die(__('Invalid security token!', 'wp-file-manager'));
            }
            die;
        }

        /* Verify Email*/
        public function mk_filemanager_verify_email_callback()
        {
            $current_user = wp_get_current_user();
            $nonce = sanitize_text_field($_REQUEST['vle_nonce']);
            if (wp_verify_nonce($nonce, 'verify-filemanager-email')) {
                $action = sanitize_text_field($_POST['todo']);
                $lokhal_email = sanitize_email($_POST['lokhal_email']);
                $lokhal_fname = sanitize_text_field(htmlentities($_POST['lokhal_fname']));
                $lokhal_lname = sanitize_text_field(htmlentities($_POST['lokhal_lname']));
                // case - 1 - close
                if ($action == 'cancel') {
                    set_transient('filemanager_cancel_lk_popup_'.$current_user->ID, 'filemanager_cancel_lk_popup_'.$current_user->ID, 60 * 60 * 24 * 30);
                    update_option('filemanager_email_verified_'.$current_user->ID, 'yes');
                } elseif ($action == 'verify') {
                    $engagement = '75';
                    update_option('filemanager_email_address_'.$current_user->ID, $lokhal_email);
                    update_option('verify_filemanager_fname_'.$current_user->ID, $lokhal_fname);
                    update_option('verify_filemanager_lname_'.$current_user->ID, $lokhal_lname);
                    update_option('filemanager_email_verified_'.$current_user->ID, 'yes');
                    /* Send Email Code */
                    $subject = 'Email Verification';
                    $message = "
					<html>
					<head>
					<title>Email Verification</title>
					</head>
					<body>
					<p>Thanks for signing up! Just click the link below to verify your email and we’ll keep you up-to-date with the latest and greatest brewing in our dev labs!</p>	
					<p><a href='".admin_url('admin-ajax.php?action=verify_filemanager_email&token='.md5($lokhal_email))."'>Click Here to Verify
</a></p>				
					</body>
					</html>
					";
                    // Always set content-type when sending HTML email
                    $headers = 'MIME-Version: 1.0'."\r\n";
                    $headers .= 'Content-type:text/html;charset=UTF-8'."\r\n";
                    $headers .= 'From: noreply@filemanagerpro.io'."\r\n";
                    $mail = mail($lokhal_email, $subject, $message, $headers);
                    $data = $this->verify_on_server($lokhal_email, $lokhal_fname, $lokhal_lname, $engagement, 'verify', '0');
                    if ($mail) {
                        echo '1';
                    } else {
                        echo '2';
                    }
                }
            } else {
                echo 'Nonce';
            }
            die;
        }

        /*
        * Verify Email
        */
        public function verify_filemanager_email_callback()
        {
            $email = sanitize_text_field($_GET['token']);
            $current_user = wp_get_current_user();
            $lokhal_email_address = md5(get_option('filemanager_email_address_'.$current_user->ID));
            if ($email == $lokhal_email_address) {
                $this->verify_on_server(get_option('filemanager_email_address_'.$current_user->ID), get_option('verify_filemanager_fname_'.$current_user->ID), get_option('verify_filemanager_lname_'.$current_user->ID), '100', 'verified', '1');
                update_option('filemanager_email_verified_'.$current_user->ID, 'yes');
                echo '<p>Email Verified Successfully. Redirecting please wait.</p>';
                echo '<script>';
                echo 'setTimeout(function(){window.location.href="https://filemanagerpro.io?utm_redirect=wp" }, 2000);';
                echo '</script>';
            }
            die;
        }

        /*
        Send Data To Server
        */
        public function verify_on_server($email, $fname, $lname, $engagement, $todo, $verified)
        {
            global $wpdb, $wp_version;
            if (get_bloginfo('version') < '3.4') {
                $theme_data = get_theme_data(get_stylesheet_directory().'/style.css');
                $theme = $theme_data['Name'].' '.$theme_data['Version'];
            } else {
                $theme_data = wp_get_theme();
                $theme = $theme_data->Name.' '.$theme_data->Version;
            }

            // Try to identify the hosting provider
            $host = false;
            if (defined('WPE_APIKEY')) {
                $host = 'WP Engine';
            } elseif (defined('PAGELYBIN')) {
                $host = 'Pagely';
            }
            $mysql_ver = @mysqli_get_server_info($wpdb->dbh);
            $id = get_option('page_on_front');
            $info = array(
                         'email' => $email,
                         'first_name' => $fname,
                         'last_name' => $lname,
                         'engagement' => $engagement,
                         'SITE_URL' => site_url(),
                         'PHP_version' => phpversion(),
                         'upload_max_filesize' => ini_get('upload_max_filesize'),
                         'post_max_size' => ini_get('post_max_size'),
                         'memory_limit' => ini_get('memory_limit'),
                         'max_execution_time' => ini_get('max_execution_time'),
                         'HTTP_USER_AGENT' => $_SERVER['HTTP_USER_AGENT'],
                         'wp_version' => $wp_version,
                         'plugin' => 'wp file manager',
                         'nonce' => 'um235gt9duqwghndewi87s34dhg',
                         'todo' => $todo,
                         'verified' => $verified,
                );
            $str = http_build_query($info);
            $args = array(
                'body' => $str,
                'timeout' => '5',
                'redirection' => '5',
                'httpversion' => '1.0',
                'blocking' => true,
                'headers' => array(),
                'cookies' => array(),
            );

            $response = wp_remote_post($this->SERVER, $args);

            return $response;
        }

        /**
		* Generate plugin key
		**/
		
		private static function fm_generate_key(){
			return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(25/strlen($x)) )),1,25);
        }
        
        /**
		* Generate plugin key
		**/
		
		private static function fm_get_key(){
			return get_option('fm_key');
		}

        /* File Manager text Domain */
        public function filemanager_load_text_domain()
        {
            $domain = dirname(plugin_basename(__FILE__));
            $locale = apply_filters('plugin_locale', get_locale(), $domain);
            load_textdomain($domain, trailingslashit(WP_LANG_DIR).'plugins'.'/'.$domain.'-'.$locale.'.mo');
            load_plugin_textdomain($domain, false, basename(dirname(__FILE__)).'/languages/');

            ////// Creating key
            $fmkey = self::fm_generate_key();
            if(self::fm_get_key() == ""){
                update_option('fm_key',$fmkey);
            }
        }

        /* Menu Page */
        public function ffm_menu_page()
        {
            add_menu_page(
            __('WP File Manager', 'wp-file-manager'),
            __('WP File Manager', 'wp-file-manager'),
            'manage_options',
            'wp_file_manager',
            array(&$this, 'ffm_settings_callback'),
            plugins_url('images/wp_file_manager.svg', __FILE__)
            );
            /* Only for admin */
            add_submenu_page('wp_file_manager', __('Settings', 'wp-file-manager'), __('Settings', 'wp-file-manager'), 'manage_options', 'wp_file_manager_settings', array(&$this, 'wp_file_manager_settings'));
            /* Only for admin */
            add_submenu_page('wp_file_manager', __('Preferences', 'wp-file-manager'), __('Preferences', 'wp-file-manager'), 'manage_options', 'wp_file_manager_preferences', array(&$this, 'wp_file_manager_root'));
            /* Only for admin */
            add_submenu_page('wp_file_manager', __('System Properties', 'wp-file-manager'), __('System Properties', 'wp-file-manager'), 'manage_options', 'wp_file_manager_sys_properties', array(&$this, 'wp_file_manager_properties'));
            /* Only for admin */
            add_submenu_page('wp_file_manager', __('Shortcode - PRO', 'wp-file-manager'), __('Shortcode - PRO', 'wp-file-manager'), 'manage_options', 'wp_file_manager_shortcode_doc', array(&$this, 'wp_file_manager_shortcode_doc'));
            add_submenu_page('wp_file_manager', __('Logs', 'wp-file-manager'), __('Logs', 'wp-file-manager'), 'manage_options', 'wpfm-logs', array(&$this, 'wp_file_manager_logs'));
            add_submenu_page('wp_file_manager', __('Backup/Restore', 'wp-file-manager'), __('Backup/Restore', 'wp-file-manager'), 'manage_options', 'wpfm-backup', array(&$this, 'wp_file_manager_backup'));             
        }       
        /* Main Role */
        public function ffm_settings_callback()
        {
            if (is_admin()):
             include 'lib/wpfilemanager.php';
            endif;
        }

        /*Settings */
        public function wp_file_manager_settings()
        {
            if (is_admin()):
             include 'inc/settings.php';
            endif;
        }

        /* Shortcode Doc */
        public function wp_file_manager_shortcode_doc()
        {
            if (is_admin()):
             include 'inc/shortcode_docs.php';
            endif;
        }
        /*  Backup */
        public function wp_file_manager_backup() {
            if (is_admin()):
                include 'inc/backup.php';
            endif;
        }

        /* System Properties */
        public function wp_file_manager_properties()
        {
            if (is_admin()):
             include 'inc/system_properties.php';
            endif;
        }	
        /*
         Root
        */
        public function wp_file_manager_root()
        {
            if (is_admin()):
             include 'inc/root.php';
            endif;
        }		
		/* System Properties */
        public function wp_file_manager_logs()
        {
            if (is_admin()):
             include 'inc/logs.php';
            endif;
        }

        public function ffm_admin_script(){
            wp_enqueue_style( 'fm_menu_common', plugins_url('/css/fm_common.css', __FILE__) );
        }

         /* Admin  Things */
         public function ffm_admin_things()
         {
           
            $getPage = isset($_GET['page']) ? sanitize_text_field($_GET['page']) : '';
            $allowedPages = array(
                'wp_file_manager',
            );
           
           // Languages
            $lang = isset($_GET['lang']) && !empty($_GET['lang']) && in_array(sanitize_text_field(htmlentities($_GET['lang'])), $this->fm_languages()) ? sanitize_text_field(htmlentities($_GET['lang'])) : '';
            if (!empty($getPage) && in_array($getPage, $allowedPages)):
                if( isset( $_GET['lang'] ) && !empty( $_GET['lang'] ) && !wp_verify_nonce( isset( $_GET['nonce'] ) ? $_GET['nonce'] : '', 'wp-file-manager-language' )) {
                    //Access Denied
                } else {
                global $wp_version;
                $fm_nonce = wp_create_nonce('wp-file-manager');
                $wp_fm_lang = get_transient('wp_fm_lang');
                $wp_fm_theme = get_transient('wp_fm_theme');
                $opt = get_option('wp_file_manager_settings');
                 wp_enqueue_style('jquery-ui', plugins_url('css/jquery-ui.css', __FILE__), '', $this->ver);
                 wp_enqueue_style('fm_commands', plugins_url('lib/css/commands.css', __FILE__), '', $this->ver);
                 wp_enqueue_style('fm_common', plugins_url('lib/css/common.css', __FILE__), '', $this->ver);
                 wp_enqueue_style('fm_contextmenu', plugins_url('lib/css/contextmenu.css', __FILE__), '', $this->ver);
                 wp_enqueue_style('fm_cwd', plugins_url('lib/css/cwd.css', __FILE__), '', $this->ver);
                 wp_enqueue_style('fm_dialog', plugins_url('lib/css/dialog.css', __FILE__), '', $this->ver);
                 wp_enqueue_style('fm_fonts', plugins_url('lib/css/fonts.css', __FILE__), '', $this->ver);
                 wp_enqueue_style('fm_navbar', plugins_url('lib/css/navbar.css', __FILE__), '', $this->ver);
                 wp_enqueue_style('fm_places', plugins_url('lib/css/places.css', __FILE__), '', $this->ver);
                 wp_enqueue_style('fm_quicklook', plugins_url('lib/css/quicklook.css', __FILE__), '', $this->ver);
                 wp_enqueue_style('fm_statusbar', plugins_url('lib/css/statusbar.css', __FILE__), '', $this->ver);
                 wp_enqueue_style('theme', plugins_url('lib/css/theme.css', __FILE__), '', $this->ver);
                 wp_enqueue_style('fm_toast', plugins_url('lib/css/toast.css', __FILE__), '', $this->ver);
                 wp_enqueue_style('fm_toolbar', plugins_url('lib/css/toolbar.css', __FILE__), '', $this->ver);
				 
                 wp_enqueue_script('jquery');          
                 
                 wp_enqueue_script('fm_jquery_js', plugins_url('js/top.js', __FILE__), '', $this->ver);
                
                $jquery_ui_js = 'jquery-ui-1.11.4.js';
                // 5.6 jquery ui issue fix
                if ( version_compare( $wp_version, '5.6', '>=' ) ) {
                    $jquery_ui_js = 'jquery-ui-1.13.2.js';
                }

                wp_enqueue_script('fm_jquery_ui', plugins_url('lib/jquery/'.$jquery_ui_js, __FILE__), $this->ver);
                wp_enqueue_script('fm_elFinder_min', plugins_url('lib/js/elfinder.min.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_elFinder', plugins_url('lib/js/elFinder.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_elFinder_version', plugins_url('lib/js/elFinder.version.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_jquery_elfinder', plugins_url('lib/js/jquery.elfinder.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_elFinder_mimetypes', plugins_url('lib/js/elFinder.mimetypes.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_elFinder_options', plugins_url('lib/js/elFinder.options.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_elFinder_options_netmount', plugins_url('lib/js/elFinder.options.netmount.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_elFinder_history', plugins_url('lib/js/elFinder.history.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_elFinder_command', plugins_url('lib/js/elFinder.command.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_elFinder_resources', plugins_url('lib/js/elFinder.resources.js', __FILE__), '', $this->ver);

                wp_enqueue_script('fm_dialogelfinder', plugins_url('lib/js/jquery.dialogelfinder.js', __FILE__), '', $this->ver);
                 
           
                    if (!empty($lang)) {
                        set_transient('wp_fm_lang', $lang, 60 * 60 * 720);
                        wp_enqueue_script('fm_lang', plugins_url('lib/js/i18n/elfinder.'.$lang.'.js', __FILE__), '', $this->ver);
                    } elseif (false !== ($wp_fm_lang = get_transient('wp_fm_lang'))) {
                        wp_enqueue_script('fm_lang', plugins_url('lib/js/i18n/elfinder.'.$wp_fm_lang.'.js', __FILE__), '', $this->ver);
                    } else {
                        wp_enqueue_script('fm_lang', plugins_url('lib/js/i18n/elfinder.en.js', __FILE__), '', $this->ver);  
                    }
                wp_enqueue_script('fm_ui_button', plugins_url('lib/js/ui/button.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_ui_contextmenu', plugins_url('lib/js/ui/contextmenu.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_ui_cwd', plugins_url('lib/js/ui/cwd.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_ui_dialog', plugins_url('lib/js/ui/dialog.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_ui_fullscreenbutton', plugins_url('lib/js/ui/fullscreenbutton.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_ui_navbar', plugins_url('lib/js/ui/navbar.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_ui_navdock', plugins_url('lib/js/ui/navdock.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_ui_overlay', plugins_url('lib/js/ui/overlay.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_ui_panel', plugins_url('lib/js/ui/panel.js', __FILE__), '', $this->ver);

                wp_enqueue_script('fm_ui_path', plugins_url('lib/js/ui/path.js', __FILE__), '', $this->ver);

                wp_enqueue_script('fm_ui_searchbutton', plugins_url('lib/js/ui/searchbutton.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_ui_sortbutton', plugins_url('lib/js/ui/sortbutton.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_ui_stat', plugins_url('lib/js/ui/stat.js', __FILE__), '', $this->ver);


                wp_enqueue_script('fm_ui_toast', plugins_url('lib/js/ui/toast.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_ui_toolbar', plugins_url('lib/js/ui/toolbar.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_ui_tree', plugins_url('lib/js/ui/tree.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_ui_uploadButton', plugins_url('lib/js/ui/uploadButton.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_ui_viewbutton', plugins_url('lib/js/ui/viewbutton.js', __FILE__), '', $this->ver);

                wp_enqueue_script('fm_ui_workzone', plugins_url('lib/js/ui/workzone.js', __FILE__), '', $this->ver);           

                wp_enqueue_script('fm_command_archive', plugins_url('lib/js/commands/archive.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_command_back', plugins_url('lib/js/commands/back.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_command_chmod', plugins_url('lib/js/commands/chmod.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_command_colwidth', plugins_url('lib/js/commands/colwidth.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_command_copy', plugins_url('lib/js/commands/copy.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_command_cut', plugins_url('lib/js/commands/cut.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_command_download', plugins_url('lib/js/commands/download.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_command_duplicate', plugins_url('lib/js/commands/duplicate.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_command_edit', plugins_url('lib/js/commands/edit.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_command_empty', plugins_url('lib/js/commands/empty.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_command_extract', plugins_url('lib/js/commands/extract.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_command_forward', plugins_url('lib/js/commands/forward.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_command_fullscreen', plugins_url('lib/js/commands/fullscreen.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_command_getfile', plugins_url('lib/js/commands/getfile.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_command_help', plugins_url('lib/js/commands/help.js', __FILE__), '', $this->ver); 
                
                wp_enqueue_script('fm_command_hidden', plugins_url('lib/js/commands/hidden.js', __FILE__), '', $this->ver);  
                wp_enqueue_script('fm_command_hide', plugins_url('lib/js/commands/hide.js', __FILE__), '', $this->ver);  
                wp_enqueue_script('fm_command_home', plugins_url('lib/js/commands/home.js', __FILE__), '', $this->ver);  
                wp_enqueue_script('fm_command_info', plugins_url('lib/js/commands/info.js', __FILE__), '', $this->ver);  
                wp_enqueue_script('fm_command_mkdir', plugins_url('lib/js/commands/mkdir.js', __FILE__), '', $this->ver);  
                wp_enqueue_script('fm_command_mkfile', plugins_url('lib/js/commands/mkfile.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_command_netmount', plugins_url('lib/js/commands/netmount.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_command_open', plugins_url('lib/js/commands/open.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_command_opendir', plugins_url('lib/js/commands/opendir.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_command_opennew', plugins_url('lib/js/commands/opennew.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_command_paste', plugins_url('lib/js/commands/paste.js', __FILE__), '', $this->ver);

                wp_enqueue_script('fm_command_places', plugins_url('lib/js/commands/places.js', __FILE__), '', $this->ver);

                wp_enqueue_script('fm_command_quicklook', plugins_url('lib/js/commands/quicklook.js', __FILE__), '', $this->ver);

                wp_enqueue_script('fm_command_quicklook_plugins', plugins_url('lib/js/commands/quicklook.plugins.js', __FILE__), '', $this->ver);

                wp_enqueue_script('fm_command_reload', plugins_url('lib/js/commands/reload.js', __FILE__), '', $this->ver);

                wp_enqueue_script('fm_command_rename', plugins_url('lib/js/commands/rename.js', __FILE__), '', $this->ver);

                wp_enqueue_script('fm_command_resize', plugins_url('lib/js/commands/resize.js', __FILE__), '', $this->ver);

                wp_enqueue_script('fm_command_restore', plugins_url('lib/js/commands/restore.js', __FILE__), '', $this->ver);

                wp_enqueue_script('fm_command_rm', plugins_url('lib/js/commands/rm.js', __FILE__), '', $this->ver);

                wp_enqueue_script('fm_command_search', plugins_url('lib/js/commands/search.js', __FILE__), '', $this->ver);

                wp_enqueue_script('fm_command_selectall', plugins_url('lib/js/commands/selectall.js', __FILE__), '', $this->ver);

                wp_enqueue_script('fm_command_selectinvert', plugins_url('lib/js/commands/selectinvert.js', __FILE__), '', $this->ver);

                wp_enqueue_script('fm_command_selectnone', plugins_url('lib/js/commands/selectnone.js', __FILE__), '', $this->ver);

                wp_enqueue_script('fm_command_sort', plugins_url('lib/js/commands/sort.js', __FILE__), '', $this->ver);

                wp_enqueue_script('fm_command_undo', plugins_url('lib/js/commands/undo.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_command_up', plugins_url('lib/js/commands/up.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_command_upload', plugins_url('lib/js/commands/upload.js', __FILE__), '', $this->ver);
                wp_enqueue_script('fm_command_view', plugins_url('lib/js/commands/view.js', __FILE__), '', $this->ver);

                wp_enqueue_script('fm_quicklook_googledocs', plugins_url('lib/js/extras/quicklook.googledocs.js', __FILE__), '', $this->ver);         
                     
                 // code mirror
                wp_enqueue_script('fm-codemirror-js', plugins_url('lib/codemirror/lib/codemirror.js', __FILE__), '', $this->ver);

                wp_enqueue_style('fm-codemirror', plugins_url('lib/codemirror/lib/codemirror.css', __FILE__), '', $this->ver);

                wp_enqueue_style('fm-3024-day', plugins_url('lib/codemirror/theme/3024-day.css', __FILE__), '', $this->ver);
                // File - Manager UI               
                wp_register_script( "file_manager_free_shortcode_admin", plugins_url('js/file_manager_free_shortcode_admin.js',  __FILE__ ), array(), rand(0,9999) );
                 wp_localize_script( 'file_manager_free_shortcode_admin', 'fmfparams', array(
                     'ajaxurl' => admin_url('admin-ajax.php'),
                     'nonce' => $fm_nonce,
                     'plugin_url' => plugins_url('lib/', __FILE__),
                     'lang' => isset($_GET['lang']) && in_array(sanitize_text_field(htmlentities($_GET['lang'])), $this->fm_languages()) ? sanitize_text_field(htmlentities($_GET['lang'])) : (($wp_fm_lang !== false) ? $wp_fm_lang : 'en'),
                     'fm_enable_media_upload' => (isset($opt['fm_enable_media_upload']) && $opt['fm_enable_media_upload'] == '1') ? '1' : '0',
                     'is_multisite'=> is_multisite() ? '1' : '0',
                     'network_url'=> is_multisite() ? network_home_url() : '',
                     )
                 );        
                 wp_enqueue_script( 'file_manager_free_shortcode_admin' );               
                
             $theme = isset($_GET['theme']) && !empty($_GET['theme']) ? sanitize_text_field(htmlentities($_GET['theme'])) : '';
             // New Theme
             if (!empty($theme)) {
                 delete_transient('wp_fm_theme');
                 set_transient('wp_fm_theme', $theme, 60 * 60 * 720);
                 if ($theme != 'default') {
                     wp_enqueue_style('theme-latest', plugins_url('lib/themes/'.$theme.'/css/theme.css', __FILE__), '', $this->ver);
                 }
             } elseif (false !== ($wp_fm_theme = get_transient('wp_fm_theme'))) {
                 if ($wp_fm_theme != 'default') {
                     wp_enqueue_style('theme-latest', plugins_url('lib/themes/'.$wp_fm_theme.'/css/theme.css', __FILE__), '', $this->ver);
                 }
             } else {}
             
            }
             endif;
             
         }

        /*
        * Admin Links
        */
        public function mk_file_folder_manager_action_links($links, $file)
        {
            if ($file == plugin_basename(__FILE__)) {
                $mk_file_folder_manager_links = '<a href="https://filemanagerpro.io/product/file-manager/" title="Buy Pro Now" target="_blank" style="font-weight:bold">'.__('Buy Pro', 'wp-file-manager').'</a>';
                $mk_file_folder_manager_donate = '<a href="http://www.webdesi9.com/donate/?plugin=wp-file-manager" title="Donate Now" target="_blank" style="font-weight:bold">'.__('Donate', 'wp-file-manager').'</a>';
                array_unshift($links, $mk_file_folder_manager_donate);
                array_unshift($links, $mk_file_folder_manager_links);
            }

            return $links;
        }

        /*
        * Ajax request handler
        * Run File Manager
        */
        public function mk_file_folder_manager_action_callback()
        {
            $path = ABSPATH;
            $settings      = get_option( 'wp_file_manager_settings' );
            $mk_restrictions = array();
            $mk_restrictions[] = array(
                                  'pattern' => '/.tmb/',
                                   'read' => false,
                                   'write' => false,
                                   'hidden' => true,
                                   'locked' => false,
                                );
            $mk_restrictions[] = array(
                                  'pattern' => '/.quarantine/',
                                   'read' => false,
                                   'write' => false,
                                   'hidden' => true,
                                   'locked' => false,
                                );
            $nonce = sanitize_text_field($_REQUEST['_wpnonce']);
            if (wp_verify_nonce($nonce, 'wp-file-manager')) {
                require 'lib/php/autoload.php';
                if (isset($settings['fm_enable_trash']) && $settings['fm_enable_trash'] == '1') {
                    $mkTrash = array(
                            'id' => '1',
                            'driver' => 'Trash',
                            'path' => WP_FILE_MANAGER_PATH.'lib/files/.trash/',
                            'tmbURL' => site_url().'/lib/files/.trash/.tmb/',
                            'winHashFix' => DIRECTORY_SEPARATOR !== '/',
                            'uploadDeny' => array(''),
                            'uploadAllow' => array(''),
                            'uploadOrder' => array('deny', 'allow'),
                            'accessControl' => 'access',
                            'attributes' => $mk_restrictions,
                        );
                    $mkTrashHash = 't1_Lw';
                } else {
                    $mkTrash = array();
                    $mkTrashHash = '';
                }
                $path_url      =  is_multisite() ? network_home_url() : site_url();
                /**
                 * @Preference
                 * If public root path is changed.
                 */
                $absolute_path = str_replace( '\\', '/', $path ); 
                $path_length   = strlen( $absolute_path );
                $access_folder = isset( $settings['public_path'] ) && ! empty( $settings['public_path'] ) ? substr( $settings['public_path'], $path_length ) : '';
                if ( isset( $settings['public_path'] ) && ! empty( $settings['public_path'] ) ) {
                    $path     = $settings['public_path'];
                    $path_url = is_multisite() ? network_home_url() .'/'. ltrim( $access_folder, '/' ) : site_url() .'/'. ltrim( $access_folder, '/' );
                }
                $opts = array(
                       'debug' => false,
                       'roots' => array(
                        array(
                            'driver' => 'LocalFileSystem',
                            'path' => $path,
                            'URL' => $path_url,
                            'trashHash' => $mkTrashHash,
                            'winHashFix' => DIRECTORY_SEPARATOR !== '/',
                            'uploadDeny' => array(),
                            'uploadAllow' => array('image', 'text/plain'),
                            'uploadOrder' => array('deny', 'allow'),
                            'accessControl' => 'access',
                            'acceptedName' => 'validName',
                            'disabled' => array('help', 'preference','hide','netmount'),
                            'attributes' => $mk_restrictions,
                        ),
                        $mkTrash,
                    ),
                );
                //run elFinder
                $connector = new elFinderConnector(new elFinder($opts));
                $connector->run();
            }
            die;
        }

        /*
        permisions
        */
        public function permissions()
        {
            $permissions = 'manage_options';

            return $permissions;
        }

        /*
         Load Help Desk
        */
        public function load_help_desk()
        {
            $mkcontent = '';
            $mkcontent .= '<div class="wfmrs">';
            $mkcontent .= '<div class="l_wfmrs">';
            $mkcontent .= '';
            $mkcontent .= '</div>';
            $mkcontent .= '<div class="r_wfmrs">';
            $mkcontent .= '<a class="close_fm_help fm_close_btn" href="javascript:void(0)" data-ct="rate_later" title="close">X</a><strong>WP File Manager</strong><p>We love and care about you. Our team is putting maximum efforts to provide you the best functionalities. It would be highly appreciable if you could spend a couple of seconds to give a Nice Review to the plugin to appreciate our efforts. So we can work hard to provide new features regularly :)</p><a class="close_fm_help fm_close_btn_1" href="javascript:void(0)" data-ct="rate_later" title="Remind me later">Later</a> <a class="close_fm_help fm_close_btn_2" href="https://wordpress.org/support/plugin/wp-file-manager/reviews/?filter=5" data-ct="rate_now" title="Rate us now" target="_blank">Rate Us</a> <a class="close_fm_help fm_close_btn_3" href="javascript:void(0)" data-ct="rate_never" title="Not interested">Never</a>';
            $mkcontent .= '</div></div>';
            if (false === ($mk_fm_close_fm_help_c_fm = get_option('mk_fm_close_fm_help_c_fm'))) {
                echo apply_filters('the_content', $mkcontent);
            }
        }

        /*
         Close Help
        */
        public function mk_fm_close_fm_help()
        {
            $what_to_do = sanitize_text_field($_POST['what_to_do']);
            $expire_time = 15;
            if ($what_to_do == 'rate_now' || $what_to_do == 'rate_never') {
                $expire_time = 365;
            } elseif ($what_to_do == 'rate_later') {
                $expire_time = 15;
            }
            if (false === ($mk_fm_close_fm_help_c_fm = get_option('mk_fm_close_fm_help_c_fm'))) {
                $set = update_option('mk_fm_close_fm_help_c_fm', 'done');
                if ($set) {
                    echo 'ok';
                } else {
                    echo 'oh';
                }
            } else {
                echo 'ac';
            }
            die;
        }

        /*
         Loading Custom Assets
        */
        public function load_custom_assets()
        {                 
            wp_enqueue_script('fm-custom-script', plugins_url('js/fm_script.js', __FILE__), array('jquery'), $this->ver);
            wp_localize_script( 'fm-custom-script', 'fmscript', array(
                'nonce' => wp_create_nonce('wp-file-manager-language')
            )); 
            wp_enqueue_style('fm-custom-script-style', plugins_url('css/fm_script.css', __FILE__), '', $this->ver);
        }

        /*
         custom_css
        */
        public function custom_css()
        {
            wp_enqueue_style('fm-custom-style', plugins_url('css/fm_custom.css', __FILE__), '', $this->ver);
        }

        /* Languages */
        public function fm_languages()
        {
            $langs = array('English' => 'en',
                          'Arabic' => 'ar',
                          'Bulgarian' => 'bg',
                          'Catalan' => 'ca',
                          'Czech' => 'cs',
                          'Danish' => 'da',
                          'German' => 'de',
                          'Greek' => 'el',
                          'Español' => 'es',
                          'Persian-Farsi' => 'fa',
                          'Faroese translation' => 'fo',
                          'French' => 'fr',
                          'Hebrew (עברית)' => 'he',
                          'hr' => 'hr',
                          'magyar' => 'hu',
                          'Indonesian' => 'id',
                          'Italiano' => 'it',
                          'Japanese' => 'ja',
                          'Korean' => 'ko',
                          'Dutch' => 'nl',
                          'Norwegian' => 'no',
                          'Polski' => 'pl',
                          'Português' => 'pt_BR',
                          'Română' => 'ro',
                          'Russian (Русский)' => 'ru',
                          'Slovak' => 'sk',
                          'Slovenian' => 'sl',
                          'Serbian' => 'sr',
                          'Swedish' => 'sv',
                          'Türkçe' => 'tr',
                          'Uyghur' => 'ug_CN',
                          'Ukrainian' => 'uk',
                          'Vietnamese' => 'vi',
                          'Simplified Chinese (简体中文)' => 'zh_CN',
                          'Traditional Chinese' => 'zh_TW',
                          );

            return $langs;
        }

        /* get All Themes */
        public function get_themes()
        {
            $dir = dirname(__FILE__).'/lib/themes';
            $theme_files = array_diff(scandir($dir), array('..', '.'));

            return $theme_files;
        }

        /* Success Message */
        public function success($msg)
        {
            _e('<div class="updated settings-error notice is-dismissible" id="setting-error-settings_updated"> 
<p><strong>'.$msg.'</strong></p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>', 'te-editor');
        }

        /* Error Message */
        public function error($msg)
        {
            _e('<div class="error settings-error notice is-dismissible" id="setting-error-settings_updated"> 
<p><strong>'.$msg.'</strong></p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>', 'te-editor');
        }

        /*
         * Admin - Assets
        */
        public function fm_custom_assets()
        {
            wp_enqueue_style('fm_custom_style', plugins_url('/css/fm_custom_style.css', __FILE__));
        }
        /* 
        * Media Upload
        */
        public function mk_file_folder_manager_media_upload() {	
            $nonce = sanitize_text_field($_REQUEST['_wpnonce']);
            if (current_user_can('manage_options') && wp_verify_nonce($nonce, 'wp-file-manager')) {
                $uploadedfiles = isset($_POST['uploadefiles']) ? $_POST['uploadefiles'] : '';
                if(!empty($uploadedfiles)) {
                    foreach($uploadedfiles as $uploadedfile) {
                        $uploadedfile = esc_url_raw($uploadedfile);
                        /* Start - Uploading Image to Media Lib */
                        if(is_multisite() && isset($_REQUEST['networkhref']) && !empty($_REQUEST['networkhref']))
                        {
                            $network_home = network_home_url();
                            $uploadedfile =  $network_home.basename($uploadedfile);
                        }
                        $this->upload_to_media_library($uploadedfile);
                        /* End - Uploading Image to Media Lib */
                    }
                }
            }
            die;
        }
       /* Upload Images to Media Library */
		 public function upload_to_media_library($image_url) {
            $allowed_exts = array('jpg','jpe',
                'jpeg','gif',
                'png','svg',
                'pdf','zip',
                'ico','pdf',
                'doc','docx',
                'ppt','pptx',
                'pps','ppsx',
                'odt','xls',
                'xlsx','psd',
                'mp3','m4a',
                'ogg','wav',
                'mp4','m4v',
                'mov','wmv',
                'avi','mpg',
                'ogv','3gp',
                '3g2'
            );
            $image_url = str_replace('..', '', $image_url);
            $url = $image_url;
            preg_match('/[^\?]+\.(jpg|jpe|jpeg|gif|png|pdf|zip|ico|pdf|doc|docx|ppt|pptx|pps|ppsx|odt|xls|xlsx|psd|mp3|m4a|ogg|wav|mp4|m4v|mov|wmv|avi|mpg|ogv|3gp|3g2)/i', $url, $matches);
             if(isset($matches[1]) && in_array($matches[1], $allowed_exts)) {
			// Need to require these files
					if ( !function_exists('media_handle_upload') ) {
						require_once(ABSPATH . "wp-admin" . '/includes/image.php');
						require_once(ABSPATH . "wp-admin" . '/includes/file.php');
						require_once(ABSPATH . "wp-admin" . '/includes/media.php');
					}
				
					$tmp = download_url( $url );
					$post_id = 0;
					$desc = "";
					$file_array = array();     
                    $file_array['name'] = basename($matches[0]);
                    $file_info = pathinfo($file_array['name']);
					$desc = $file_info['filename'];				
					// If error storing temporarily, unlink
					if ( is_wp_error( $tmp ) ) {
						@unlink($file_array['tmp_name']);
						$file_array['tmp_name'] = '';
					} else {
						$file_array['tmp_name'] = $tmp;
					}
					$id = media_handle_sideload( $file_array, $post_id, $desc );
					if ( is_wp_error($id) ) {
						@unlink($file_array['tmp_name']);
						return $id;
                    }
            }
         }

         /**
         * Function to download backup
         */

         public function fm_download_backup($request){
            $params = $request->get_params();
            $backup_id = isset($params["backup_id"]) ? trim($params["backup_id"]) : '';
            $type = isset($params["type"]) ? trim($params["type"]) : '';
            if(!empty($backup_id) && !empty($type)){
                $id = (int) base64_decode(trim($params["backup_id"]));
                $type = base64_decode(trim($params["type"]));
                $fmkey = self::fm_get_key();
                if(base64_encode(site_url().$fmkey) === $params['key']){
                    global $wpdb;
                    $upload_dir = wp_upload_dir();
                    $backup = $wpdb->get_var(
                        $wpdb->prepare("select backup_name from ".$wpdb->prefix."wpfm_backup where id=%d",$id)
                    );
                    $backup_dirname = $upload_dir['basedir'].'/wp-file-manager-pro/fm_backup/';
                    $backup_baseurl = $upload_dir['baseurl'].'/wp-file-manager-pro/fm_backup/';
                    if($type == "db"){
                        $bkpName = $backup.'-db.sql.gz';
                    }else{
                        $directory_separators = ['../', './','..\\', '.\\', '..'];
                        $type = str_replace($directory_separators, '', $type);
                        $bkpName = $backup.'-'.$type.'.zip';
                    }
                    $file = $backup_dirname.$bkpName;
                    if(file_exists($file)){
                        //Set Headers:
                        $memory_limit = intval( ini_get( 'memory_limit' ) );
                        if ( ! extension_loaded( 'suhosin' ) && $memory_limit < 512 ) {
                            @ini_set( 'memory_limit', '1024M' );
                        }
                        @ini_set( 'max_execution_time', 6000 );
                        @ini_set( 'max_input_vars', 10000 );
                        $etag = md5_file($file);
                        header('Pragma: public');
                        header('Expires: 0');
                        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                        header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($file)) . ' GMT');
                        header("Etag: ".$etag);
                        header('Content-Type: application/force-download');
                        header('Content-Disposition: inline; filename="'.$bkpName.'"');
                        header('Content-Transfer-Encoding: binary');
                        header('Content-Length: ' . filesize($file));
                        header('Connection: close');
                        if(ob_get_level()){
                            ob_end_clean();
                        }
                        readfile($file);
                        exit();
                    }
                    else{
                        $messg = __( 'File doesn\'t exist to download.', 'wp-file-manager-pro');
                        return new WP_Error( 'fm_file_exist', $messg, array( 'status' => 404 ) );
                    }
                }
                else {
                    $messg = __( 'Invalid Security Code.', 'wp-file-manager-pro');
                    return new WP_Error( 'fm_security_issue', $messg, array( 'status' => 404 ) );
                }
            }
            if(!isset($params["backup_id"])){
                $messg1 = __( 'Missing backup id.', 'wp-file-manager-pro');
                return new WP_Error( 'fm_missing_params', $messg1, array( 'status' => 401 ) );
            } elseif(!isset($params["type"])){
                $messg2 = __( 'Missing parameter type.', 'wp-file-manager-pro');
                return new WP_Error( 'fm_missing_params', $messg2, array( 'status' => 401 ) );
            } else {
                $messg4 = __( 'Missing required parameters.', 'wp-file-manager-pro');
                return new WP_Error( 'fm_missing_params', $messg4, array( 'status' => 401 ) );
            }
        }

        /**
         * Function to download all backup zip in one
         */

        public function fm_download_backup_all($request){
            $params = $request->get_params();
            $backup_id = isset($params["backup_id"]) ? trim($params["backup_id"]) : '';
            $type = isset($params["type"]) ? trim($params["type"]) : '';
            $all = isset($params["all"]) ? trim($params["all"]) : '';
            if(!empty($backup_id) && !empty($type) && !empty($all)){
                $id = (int) base64_decode(trim($params["backup_id"]));
                $type = base64_decode(trim($params["type"]));
                $fmkey = self::fm_get_key();
                if(base64_encode(site_url().$fmkey) === $params['key']){
                    global $wpdb;
                    $upload_dir = wp_upload_dir();
                    $backup = $wpdb->get_var(
                        $wpdb->prepare("select backup_name from ".$wpdb->prefix."wpfm_backup where id=%d",$id)
                    );
                    
                    $backup_dirname = $upload_dir['basedir'].'/wp-file-manager-pro/fm_backup/';
                    $dir_list = scandir($backup_dirname, 1);
                    $zip = new ZipArchive(); 
                    $zip_name = $backup."-all.zip"; 
                    if ($zip->open($zip_name, ZIPARCHIVE::CREATE  || ZipArchive::OVERWRITE) === true) {
                    foreach($dir_list as $key => $file_name){
                        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                        if($file_name != '.' && $file_name != '..' && (is_dir($backup_dirname.'/'.$file_name) || $ext == 'zip' || $ext == 'gz') ){
                          
                                if(strpos($file_name,$backup) !== false ){
                                    $source_file = $backup_dirname.$dir_list[$key];
                                    $source_file = str_replace('\\', '/', realpath($source_file));
                                    $zip->addFromString(basename($source_file), file_get_contents($source_file));
                                  
                                }
                            }
                        }
                    }
              
                    $zip->close();
                    if(file_exists($zip_name)){
                        //Set Headers:
                        $memory_limit = intval( ini_get( 'memory_limit' ) );
                        if ( ! extension_loaded( 'suhosin' ) && $memory_limit < 512 ) {
                            @ini_set( 'memory_limit', '1024M' );
                        }
                        @ini_set( 'max_execution_time', 6000 );
                        @ini_set( 'max_input_vars', 10000 );
                        $etag = md5_file($zip_name);
                        header('Pragma: public');
                        header('Expires: 0');
                        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                        header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($zip_name)) . ' GMT');
                        header("Etag: ".$etag);
                        header('Content-Type: application/force-download');
                        header('Content-Disposition: inline; filename="'.$zip_name.'"');
                        header('Content-Transfer-Encoding: binary');
                        header('Content-Length: ' . filesize($zip_name));
                        header('Connection: close');
                        if(ob_get_level()){
                            ob_end_clean();
                        }
                        readfile($zip_name);
                        unlink($zip_name);
                        exit();
                    }
                    else{
                        $messg = __( 'File doesn\'t exist to download.', 'wp-file-manager-pro');
                        return new WP_Error( 'fm_file_exist', $messg, array( 'status' => 404 ) );
                    }
                }
                else {
                    $messg = __( 'Invalid Security Code.', 'wp-file-manager-pro');
                    return new WP_Error( 'fm_security_issue', $messg, array( 'status' => 404 ) );
                }
            }
            if(!isset($params["backup_id"])){
                $messg1 = __( 'Missing backup id.', 'wp-file-manager-pro');
                return new WP_Error( 'fm_missing_params', $messg1, array( 'status' => 401 ) );
            } elseif(!isset($params["type"])){
                $messg2 = __( 'Missing parameter type.', 'wp-file-manager-pro');
                return new WP_Error( 'fm_missing_params', $messg2, array( 'status' => 401 ) );
            } else {
                $messg4 = __( 'Missing required parameters.', 'wp-file-manager-pro');
                return new WP_Error( 'fm_missing_params', $messg4, array( 'status' => 401 ) );
            }
        }

        /*
        * Redirection
        */
        public static function mk_fm_redirect($url){
            $url= esc_url_raw($url);
            wp_register_script( 'mk-fm-redirect', '', array("jquery"));
            wp_enqueue_script( 'mk-fm-redirect' );
            wp_add_inline_script('mk-fm-redirect','window.location.href="'.$url.'"');
        }

    }
    $filemanager = new mk_file_folder_manager();
    global $filemanager;
    /* end class */
endif;

if(!function_exists('mk_file_folder_manager_wp_fm_create_tables')) {
	function mk_file_folder_manager_wp_fm_create_tables(){
		global $wpdb;
		$table_name = $wpdb->prefix . 'wpfm_backup';
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
			$charset_collate = $wpdb->get_charset_collate();
			$sql = "CREATE TABLE ".$table_name." (
                    id int(11) NOT NULL AUTO_INCREMENT,
                    backup_name text NULL,
                    backup_date text NULL,
                    PRIMARY KEY  (id)
                ) $charset_collate;";
			dbDelta( $sql );
		}
	}
}

if(!function_exists('mk_file_folder_manager_create_tables')){
	function mk_file_folder_manager_create_tables(){
		if ( is_multisite() ) {
			global $wpdb;
			// Get all blogs in the network and activate plugin on each one
			$blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
			foreach ( $blog_ids as $blog_id ) {
				switch_to_blog( $blog_id );
				mk_file_folder_manager_wp_fm_create_tables();
				restore_current_blog();
			}
		} else {
			mk_file_folder_manager_wp_fm_create_tables();
		}
	}
}

register_activation_hook( __FILE__, 'mk_file_folder_manager_create_tables' );
