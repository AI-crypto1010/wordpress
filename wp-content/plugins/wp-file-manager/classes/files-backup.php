<?php 
class wp_file_manager_files_backup {

    public function zipData($source, $destination) {
        $source = str_replace('..', '', $source);
        $destination = str_replace('..', '', $destination);
        if (extension_loaded('zip') === true) {
            if (file_exists($source) === true) {
                $zip = new ZipArchive();
                if ($zip->open($destination, ZIPARCHIVE::CREATE) === true) {
                    $source = str_replace('\\', '/', realpath($source));
                    if (is_dir($source) === true) {
                        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);
                        foreach ($files as $file) {
                            if(strpos($file,'fm_backup') === false && (strpos($file,'opt') === false || strpos($file,'opt'))) {
                                $file = str_replace('\\', '/', realpath($file));
                                $relative_path = substr($file, strlen($source) + 1);
                                if (is_dir($file) === true) {
                                    if($relative_path !== false){
                                        $zip->addEmptyDir($relative_path);
                                    }
                                } else if (is_file($file) === true) {
                                    $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
                                }
                            }
                        }
                    } else if (is_file($source) === true) {
                        $zip->addFromString(basename($source), file_get_contents($source));
                    }
                }
                return $zip->close();
            }
        }
        return false;
    }
    public function zipOther($source, $destination) {
        $source = str_replace('..', '', $source);
        $destination = str_replace('..', '', $destination);
        if (extension_loaded('zip') === true) {
            if (file_exists($source) === true) {
                $zip = new ZipArchive();
                if ($zip->open($destination, ZIPARCHIVE::CREATE) === true) {
                    $source = str_replace('\\', '/', realpath($source));
                    if (is_dir($source) === true) {
                        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST); 
                        foreach ($files as $file) {
                           $file = str_replace('\\', '/', realpath($file));
                           $allfolders= explode("wp-content",$file);
                           if(isset($allfolders[1])){
                                $allfoldersdata= explode("/",$allfolders[1]);
                                if(isset($allfoldersdata[1]) && ($allfoldersdata[1] != 'themes' && $allfoldersdata[1] != 'plugins' && $allfoldersdata[1] != 'uploads')){
                                    $file = str_replace('\\', '/', realpath($file));
                                    $relative_path = substr($file, strlen($source) + 1);
                                    if (is_dir($file) === true) {
                                        if($relative_path !== false){
                                            $zip->addEmptyDir($relative_path);
                                        }
                                    } else if (is_file($file) === true) {
                                        $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
                                    }
                                }
                            }

                        }
                    } else if (is_file($source) === true) {
                        $zip->addFromString(basename($source), file_get_contents($source));
                    }
                }
                return $zip->close();
            }
        }
        return false;
    }
}