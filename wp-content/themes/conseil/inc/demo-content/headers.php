<?php

function pixfort_demo_headers(){
    $data = array();

    $import_url = 'https://import.pixfort.com/conseil/';
    $import_image_url = 'https://wordpress.assets.pixfort.com/conseil/thumbnails/headers/';

    $demo_names = [ 
        'SaaS',
        'App',
        'Advisory', 
        'Digital Agency', 
        'Consulting', 
        'Growth', 
        'Vision', 
        'Partners', 
        'Prime', 
        'Trust', 
        'RTL'
    ];
    

    foreach ($demo_names as $name) {
        $name_with_hyphens = str_replace(' ', '-', strtolower($name));
        $demo = array(
            'import_file_name'          => ucwords($name).' Header',
            'categories'                   => array( 'Headers' ),
            'import_file_url'           => $import_url . 'demo-content/' . $name_with_hyphens . '/' . $name_with_hyphens . '-header.xml',
            'import_preview_image_url' => $import_image_url . 'header-' . $name_with_hyphens . '.webp',
            'preview_url'               => 'https://conseil.pixfort.com/' . $name_with_hyphens . '/',
        );
        array_push($data, $demo);
    }
    // $demo = array(
    //     'import_file_name'             => 'Original Header',
    //     'categories'                   => array( 'Headers' ),
    //     'import_file_url'            => $import_url.'demo-content/original/original-header.xml',
    //     'import_preview_image_url'     => $import_image_url.'sheader-original.webp',
    //     'preview_url'                  => 'https://theme.pixfort.com/original/',
    // );
    // array_push($data, $demo);


    return $data;
}
     ?>
