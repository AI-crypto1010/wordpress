<?php




function pix_elementor_templates_testimonials(){

    $thumbPath = 'https://wordpress.assets.pixfort.com/conseil/library/sections/testimonials/';
    
    $templatesList = [

        ['demo_name' => 'Digital Agency', 'title' => 'Pricing Testimonial Clients Marquee', 'categories' => ['testimonials', 'clients', 'marquee']],

        ['demo_name' => 'Advisory', 'title' => 'Features Review Testimonial', 'categories' => ['testimonials', 'reviews']],
        ['demo_name' => 'Advisory', 'title' => 'Home Review Testimonial Clients', 'categories' => ['testimonials', 'reviews', 'clients']],

        ['demo_name' => 'Growth', 'title' => 'Reviews Testimonial CTA', 'categories' => ['testimonials', 'reviews', 'cta']],

    ];

    return pix_generate_templates($templatesList, 'testimonials', $thumbPath);
}




 ?>
