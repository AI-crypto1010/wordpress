<?php




function pix_elementor_templates_reviews(){

    $thumbPath = 'https://wordpress.assets.pixfort.com/conseil/library/sections/reviews/';
    
    $templatesList = [

        ['demo_name' => 'Consulting', 'title' => 'Home Reviews', 'categories' => ['reviews', 'marquee', 'testimonials']],
        ['demo_name' => 'Consulting', 'title' => 'Pricing Reviews', 'categories' => ['reviews', 'testimonials']],

        ['demo_name' => 'Digital Agency', 'title' => 'Home Reviews Testimonials', 'categories' => ['reviews', 'testimonials']],
        ['demo_name' => 'Digital Agency', 'title' => 'Reviews Content Sticky', 'categories' => ['reviews', 'content']],
        ['demo_name' => 'Digital Agency', 'title' => 'Reviews Single Numbers', 'categories' => ['reviews', 'numbers']],
        ['demo_name' => 'Digital Agency', 'title' => 'Services Reviews Testimonials Clients Marquee', 'categories' => ['reviews', 'testimonials', 'clients', 'marquee']],

        ['demo_name' => 'Advisory', 'title' => 'Reviews Highlighted Testimonial Numbers', 'categories' => ['reviews', 'testimonials', 'numbers']],
        ['demo_name' => 'Advisory', 'title' => 'Reviews Sticky Content', 'categories' => ['reviews', 'content']],
        ['demo_name' => 'Advisory', 'title' => 'Services Reviews Testimonials', 'categories' => ['reviews', 'testimonials']],

        ['demo_name' => 'Growth', 'title' => 'Home Reviews Testimonials', 'categories' => ['reviews', 'testimonials']],
        ['demo_name' => 'Growth', 'title' => 'Reviews Testimonials', 'categories' => ['reviews', 'testimonials']],
        ['demo_name' => 'Growth', 'title' => 'Services Reviews Testimonials', 'categories' => ['reviews', 'testimonials']],

        ['demo_name' => 'Vision', 'title' => 'Home Award Reviews Rating', 'categories' => ['reviews', 'miscellaneous']],
        ['demo_name' => 'Vision', 'title' => 'Product Review Testimonial', 'categories' => ['reviews', 'testimonials']],
        ['demo_name' => 'Vision', 'title' => 'Services Reviews Testimonials Ratings Award', 'categories' => ['reviews', 'testimonials']],

        ['demo_name' => 'Partners', 'title' => 'Home Reviews Testimonials', 'categories' => ['reviews', 'testimonials']],

        ['demo_name' => 'Trust', 'title' => 'Solutions Reviews Testimonials', 'categories' => ['reviews', 'testimonials']],
        ['demo_name' => 'Trust', 'title' => 'Services Testimonial Review Clients', 'categories' => ['reviews', 'testimonials', 'clients']],
        ['demo_name' => 'Trust', 'title' => 'Reviews Testimonials', 'categories' => ['reviews', 'testimonials']],

        ['demo_name' => 'RTL', 'title' => 'Home Reviews Testimonials', 'categories' => ['reviews', 'testimonials']],
        ['demo_name' => 'RTL', 'title' => 'Reviews Testimonials', 'categories' => ['reviews', 'testimonials']],
        ['demo_name' => 'RTL', 'title' => 'Services Reviews Testimonials', 'categories' => ['reviews', 'testimonials']],

        ['demo_name' => 'App', 'title' => 'Home Reviews Testimonials', 'categories' => ['reviews', 'testimonials']],

        ['demo_name' => 'SaaS', 'title' => 'Services Reviews Rating', 'categories' => ['reviews']],
        ['demo_name' => 'SaaS', 'title' => 'Singe Service Reviews', 'categories' => ['reviews']],
        ['demo_name' => 'SaaS', 'title' => 'Home Reviews', 'categories' => ['reviews']],
        ['demo_name' => 'SaaS', 'title' => 'Product Review', 'categories' => ['reviews']],

    ];

    return pix_generate_templates($templatesList, 'reviews', $thumbPath);
}




 ?>
