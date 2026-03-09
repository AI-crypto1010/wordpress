<?php


function pixServerStatus() {

$result = array();

// Check site protocol configuration
$site_url = site_url();
$is_https = (strpos($site_url, 'https://') === 0); // True if site URL starts with https://
$protocol_config = $is_https ? 'https:' : 'http:';

array_push($result, array(
    'label'         => esc_attr__('Site protocol configuration', 'pixfort-core'),
    'status'        => 'warning',
    'protocol'        => $protocol_config,
    'helpText'          => esc_attr__('Help', 'pixfort-core'),
    'helpLink'      => \PixfortCore::instance()->adminCore->getParam('docs_use_https'),
));

// Check if WP Debug mode is enabled
if (defined('WP_DEBUG') && WP_DEBUG) {
    array_push($result, array(
        'label'         => esc_attr__('WP Debug mode is enabled', 'pixfort-core'),
        'status'        => 'warning',
        'helpText'      => esc_attr__('Help', 'pixfort-core'),
        'helpLink'      => 'https://wordpress.org/support/article/debugging-in-wordpress/',
    ));
}

$uploads_dir = wp_upload_dir();
$is_writable = wp_is_writable($uploads_dir['basedir'] . '/');

array_push($result, array(
    'label'         => esc_attr__('Writable uploads directory', 'pixfort-core'),
    'status'        => $is_writable,
    'helpText'          => esc_attr__('Help', 'pixfort-core'),
    'helpLink'          => \PixfortCore::instance()->adminCore->getParam('docs_server_configuration') .'#pix_section_writable_uploads_directory'
));

$memory_limit = ini_get('memory_limit');
$memory_limit_byte = wp_convert_hr_to_bytes($memory_limit);
$res_memory_limit = $memory_limit_byte >= 268435456;

array_push($result, array(
    'label'         => __('Memory limit (256MB)', 'pixfort-core'),
    'status'        => $res_memory_limit,
    'helpText'          => esc_attr__('Help', 'pixfort-core'),
    'helpLink'          => \PixfortCore::instance()->adminCore->getParam('docs_server_configuration') .'#pix_section_memory_limit'
));

$upload_max_filesize_min = '64M';
$upload_max_filesize = ini_get('upload_max_filesize');
$upload_max_filesize_byte = wp_convert_hr_to_bytes($upload_max_filesize);
$upload_max_filesize_status = $upload_max_filesize_byte >= 67108864;

array_push($result, array(
    'label'         => __('Upload max filesize (64MB)', 'pixfort-core'),
    'status'        => $upload_max_filesize_status,
    'helpText'          => esc_attr__('Help', 'pixfort-core'),
    'helpLink'          => \PixfortCore::instance()->adminCore->getParam('docs_server_configuration') .'#pix_section_upload_max_filesize'
));

$post_max_size_min = '128M';
$post_max_size = ini_get('post_max_size');
$post_max_size_byte = wp_convert_hr_to_bytes($post_max_size);
$post_max_size_status = ($post_max_size_byte >= 67108864);

array_push($result, array(
    'label'         => __('Post max size (64MB)', 'pixfort-core'),
    'status'        => $post_max_size_status,
    'helpText'          => esc_attr__('Help', 'pixfort-core'),
    'helpLink'          => \PixfortCore::instance()->adminCore->getParam('docs_server_configuration') .'#pix_section_post_max_size'
));

$max_input_vars_min = 3000;
$max_input_vars = ini_get('max_input_vars');
$max_input_vars_status = $max_input_vars >= $max_input_vars_min;

array_push($result, array(
    'label'         => __('Max input vars (3000)', 'pixfort-core'),
    'status'        => $max_input_vars_status,
    'helpText'          => esc_attr__('Help', 'pixfort-core'),
    'helpLink'          => \PixfortCore::instance()->adminCore->getParam('docs_server_configuration') .'#pix_section_max_input_vars'
));

$max_execution_time_min = 300;
$max_execution_time = ini_get('max_execution_time');
$max_execution_time_status = $max_execution_time >= $max_execution_time_min;

array_push($result, array(
    'label'         => __('Max execution time (300s)', 'pixfort-core'),
    'status'        => $max_execution_time_status,
    'helpText'          => esc_attr__('Help', 'pixfort-core'),
    'helpLink'          => \PixfortCore::instance()->adminCore->getParam('docs_server_configuration') .'#pix_section_max_execution_time'
));

$xmlReady = false;
if (class_exists('XMLReader')) {
    $xmlReady = true;
} elseif (function_exists('simplexml_load_file')) {
    //simplexml available
    $xmlReady = true;
}
array_push($result, array(
    'label'         => __('XML Reader', 'pixfort-core'),
    'status'        => $xmlReady,
    'helpText'          => esc_attr__('Help', 'pixfort-core'),
    'helpLink'          => \PixfortCore::instance()->adminCore->getParam('docs_server_configuration') .'#pix_section_xml_not_found'
));

// Check if the site URL uses HTTPS using site_url()
array_push($result, array(
    'label'         => __('HTTPS protocol', 'pixfort-core'),
    'status'        => $is_https,
    'helpText'          => esc_attr__('Help', 'pixfort-core'),
    'helpLink'      => \PixfortCore::instance()->adminCore->getParam('docs_use_https'),
));

return $result;

}