<?php




function pix_elementor_templates_cta(){

    $thumbPath = 'https://wordpress.assets.pixfort.com/conseil/library/sections/cta/';
    
    $templatesList = [

        ['demo_name' => 'Consulting', 'title' => 'About CTA', 'categories' => ['cta']],
        ['demo_name' => 'Consulting', 'title' => 'CTA', 'categories' => ['cta']],
        ['demo_name' => 'Consulting', 'title' => 'Features CTA', 'categories' => ['cta']],
        ['demo_name' => 'Consulting', 'title' => 'Services Testimonials CTA', 'categories' => ['cta', 'testimonials', 'marquee']],

        ['demo_name' => 'Digital Agency', 'title' => 'CTA', 'categories' => ['cta']],
        ['demo_name' => 'Digital Agency', 'title' => 'Home Clients Marquee CTA', 'categories' => ['cta', 'clients', 'marquee']],
        ['demo_name' => 'Digital Agency', 'title' => 'Services CTA Circles', 'categories' => ['cta']],

        ['demo_name' => 'Advisory', 'title' => 'About CTA Clients Marquee', 'categories' => ['cta', 'clients', 'marquee']],
        ['demo_name' => 'Advisory', 'title' => 'Careers CTA Clients Marquee', 'categories' => ['cta', 'clients', 'marquee']],
        ['demo_name' => 'Advisory', 'title' => 'CTA', 'categories' => ['cta']],
        ['demo_name' => 'Advisory', 'title' => 'Home CTA Video Popup', 'categories' => ['cta', 'video']],

        ['demo_name' => 'Growth', 'title' => 'CTA', 'categories' => ['cta']],

        ['demo_name' => 'Vision', 'title' => 'CTA', 'categories' => ['cta']],
        ['demo_name' => 'Vision', 'title' => 'Services CTA Content Vertical Marquee', 'categories' => ['cta', 'content', 'marquee']],

        ['demo_name' => 'Partners', 'title' => 'Careers CTA', 'categories' => ['cta']],
        ['demo_name' => 'Partners', 'title' => 'CTA', 'categories' => ['cta']],

        ['demo_name' => 'Prime', 'title' => 'CTA', 'categories' => ['cta']],

        ['demo_name' => 'Trust', 'title' => 'CTA', 'categories' => ['cta']],
        ['demo_name' => 'Trust', 'title' => 'Home CTA Clients Marquee Rating', 'categories' => ['cta', 'clients', 'marquee']],

        ['demo_name' => 'RTL', 'title' => 'CTA', 'categories' => ['cta']],

        ['demo_name' => 'App', 'title' => 'Home CTA', 'categories' => ['cta', 'content']],

        ['demo_name' => 'SaaS', 'title' => 'Services CTA', 'categories' => ['cta']],
        ['demo_name' => 'SaaS', 'title' => 'Singe Service CTA', 'categories' => ['cta']],
        ['demo_name' => 'SaaS', 'title' => 'Singe Service Circles CTA', 'categories' => ['cta']],
        ['demo_name' => 'SaaS', 'title' => 'CTA', 'categories' => ['cta']],

    ];

    return pix_generate_templates($templatesList, 'cta', $thumbPath);
}




 ?>
