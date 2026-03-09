<?php



function pix_elementor_templates_image_carousel(){

    $thumbPath = 'https://wordpress.assets.pixfort.com/conseil/library/sections/image_carousel/';
    
    $templatesList = [

        ['demo_name' => 'Consulting', 'title' => 'Home Content Left Image Carousel', 'categories' => ['image_carousel', 'content']],

    ];

    return pix_generate_templates($templatesList, 'image_carousel', $thumbPath);
}




 ?>
