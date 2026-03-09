<?php



function pix_elementor_templates_countdown(){
    
    $thumbPath = 'https://wordpress.assets.pixfort.com/conseil/library/sections/countdown/';
    
    $templatesList = [

        ['demo_name' => 'Consulting', 'title' => 'Coming Soon Countdown', 'categories' => ['countdown', 'miscellaneous']],

        ['demo_name' => 'Vision', 'title' => 'Coming Soon Countdown', 'categories' => ['countdown', 'miscellaneous']],

        ['demo_name' => 'Partners', 'title' => 'Coming Soon Countdown Slider Clients', 'categories' => ['countdown', 'sliders', 'clients']],

        ['demo_name' => 'Trust', 'title' => 'Coming Soon Countdown Slider', 'categories' => ['countdown', 'sliders']],

    ];

    return pix_generate_templates($templatesList, 'countdown', $thumbPath);
}



 ?>
