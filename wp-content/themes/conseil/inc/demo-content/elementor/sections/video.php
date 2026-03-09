<?php



function pix_elementor_templates_video(){
    
    $thumbPath = 'https://wordpress.assets.pixfort.com/conseil/library/sections/video/';
    
    $templatesList = [

        ['demo_name' => 'Consulting', 'title' => 'Case Studies Video CTA', 'categories' => ['video', 'cta', 'content']],
        ['demo_name' => 'Consulting', 'title' => 'Features Video', 'categories' => ['video', 'features', 'content']],
        ['demo_name' => 'Consulting', 'title' => 'Services Video Features', 'categories' => ['video', 'features', 'content']],

        ['demo_name' => 'Advisory', 'title' => 'Features Video', 'categories' => ['video']],

        ['demo_name' => 'Vision', 'title' => 'Home Video', 'categories' => ['video', 'content']],

    ];

    return pix_generate_templates($templatesList, 'video', $thumbPath);
}




 ?>
