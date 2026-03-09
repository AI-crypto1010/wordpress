<?php
class wp_file_manager_files_restore {

   public function extract($source, $destination) {
      if (extension_loaded('zip') === true) {
            if (file_exists($source) === true) {
                $zip = new ZipArchive();
                $res = $zip->open($source);
                if ($res === TRUE) {
                    $allfiles = [];
                    for($i = 0; $i < $zip->numFiles; $i++) {
                        $filename = $zip->getNameIndex($i);
                        if (strpos($filename,'wp-file-manager') === false) {
                            $allfiles[] =  $zip->getNameIndex($i);
                        }
                    }

                    $zip->extractTo($destination, $allfiles);
                    $zip->close();
                    
                    $isLocal = explode(':\\',$destination);
                    $path = count($isLocal) > 1 ? str_replace(DIRECTORY_SEPARATOR,'/',$isLocal[1]) : str_replace(DIRECTORY_SEPARATOR,'/',$isLocal[0]);
                    if(is_dir($destination.'/'.$path)){
                        $is_copied = copy_dir( $destination.'/'.$path, $destination);
                        if($is_copied){
                            $folderarr = explode('/',$path);
                            if(is_dir($destination.'/'.$folderarr[0])){
                                $is_deleted = $this->fm_rmdir($destination.'/'.$folderarr[0]);
                            }
                            return true;
                        }
                    }
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
        return false;
   }

    public function fm_rmdir($src) {
        $dir = opendir($src);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                $full = $src . '/' . $file;
                if ( is_dir($full) ) {
                    $this->fm_rmdir($full);
                }
                else {
                    unlink($full);
                }
            }
        }
        closedir($dir);
        rmdir($src);
    }

}