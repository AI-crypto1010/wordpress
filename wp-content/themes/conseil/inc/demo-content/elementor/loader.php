<?php

if( !function_exists('pixfort_elementor_library_data')) {
    function pixfort_elementor_library_data() {
        require_once('library.php');
        return $library;
    }
}