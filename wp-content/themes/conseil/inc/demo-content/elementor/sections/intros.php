<?php




function pix_elementor_templates_intros(){

    $thumbPath = 'https://wordpress.assets.pixfort.com/conseil/library/sections/intros/';
    
    $templatesList = [

        
        ['demo_name' => 'Consulting', 'title' => 'Home Intro', 'categories' => ['intros', 'marquee']],
        ['demo_name' => 'Consulting', 'title' => 'Features Intro', 'categories' => ['intros', 'content']],
        ['demo_name' => 'Consulting', 'title' => 'Services Intro', 'categories' => ['intros', 'cta', 'marquee']],
        ['demo_name' => 'Consulting', 'title' => 'Case Studies Intro', 'categories' => ['intros', 'marquee']],
        ['demo_name' => 'Consulting', 'title' => 'Pricing Intro', 'categories' => ['intros', 'marquee', 'cta']],
        ['demo_name' => 'Consulting', 'title' => 'About Intro', 'categories' => ['intros', 'marquee']],
        ['demo_name' => 'Consulting', 'title' => 'Contact Intro', 'categories' => ['intros', 'contact']],
        
        ['demo_name' => 'Digital Agency', 'title' => 'Home Intro', 'categories' => ['intros', 'video']],
        ['demo_name' => 'Digital Agency', 'title' => 'Services Intro', 'categories' => ['intros', 'features']],
        ['demo_name' => 'Digital Agency', 'title' => 'Features Intro', 'categories' => ['intros', 'marquee', 'cta']],
        ['demo_name' => 'Digital Agency', 'title' => 'Showcase Intro', 'categories' => ['intros', 'video']],
        ['demo_name' => 'Digital Agency', 'title' => 'Pricing Intro', 'categories' => ['intros', 'pricing']],
        ['demo_name' => 'Digital Agency', 'title' => 'Reviews Intro Clients Marquee', 'categories' => ['intros', 'reviews', 'clients', 'marquee']],
        ['demo_name' => 'Digital Agency', 'title' => 'About Intro Marquee Clients CTA Awards', 'categories' => ['intros', 'marquee', 'clients', 'cta']],
        ['demo_name' => 'Digital Agency', 'title' => 'Contact Intro Information', 'categories' => ['intros', 'contact']],
        
        ['demo_name' => 'Advisory', 'title' => 'Home Intro', 'categories' => ['intros']],
        ['demo_name' => 'Advisory', 'title' => 'Services Intro Marquee', 'categories' => ['intros', 'marquee']],
        ['demo_name' => 'Advisory', 'title' => 'Features Intro Clients Marquee', 'categories' => ['intros', 'features', 'clients', 'marquee']],
        ['demo_name' => 'Advisory', 'title' => 'Pricing Intro Pricing Tables', 'categories' => ['intros', 'pricing']],
        ['demo_name' => 'Advisory', 'title' => 'Reviews Intro Clients Marquee Testimonial', 'categories' => ['intros', 'reviews', 'clients', 'marquee', 'testimonials']],
        ['demo_name' => 'Advisory', 'title' => 'Careers Intro Numbers', 'categories' => ['intros', 'numbers']],
        ['demo_name' => 'Advisory', 'title' => 'About Intro Gallery Numbers', 'categories' => ['intros', 'gallery', 'numbers']],
        ['demo_name' => 'Advisory', 'title' => 'Contact Intro CTA', 'categories' => ['intros', 'contact', 'cta']],
        
        ['demo_name' => 'SaaS', 'title' => 'Help Center Intro Search', 'categories' => ['intros', 'miscellaneous']],
        ['demo_name' => 'SaaS', 'title' => 'Singe Service Intro Marquee CTA', 'categories' => ['intros', 'marquee', 'cta']],
        ['demo_name' => 'SaaS', 'title' => 'Services Intro Clients Marquee', 'categories' => ['intros', 'clients', 'marquee']],
        ['demo_name' => 'SaaS', 'title' => 'Pricing Intro Pricing Table Tabs', 'categories' => ['intros', 'pricing', 'tabs']],
        ['demo_name' => 'SaaS', 'title' => 'Product Intro', 'categories' => ['intros', 'cta', 'content']],
        ['demo_name' => 'SaaS', 'title' => 'Home Intro Marquee Clients', 'categories' => ['intros', 'marquee', 'clients']],
        ['demo_name' => 'SaaS', 'title' => 'Custom Intro', 'categories' => ['intros', 'miscellaneous']],

        ['demo_name' => 'Growth', 'title' => 'Home Intro Marquee', 'categories' => ['intros', 'marquee']],
        ['demo_name' => 'Growth', 'title' => 'Services Intro', 'categories' => ['intros']],
        ['demo_name' => 'Growth', 'title' => 'Features Intro Video', 'categories' => ['intros', 'video']],
        ['demo_name' => 'Growth', 'title' => 'Reviews Intro Awards CTA', 'categories' => ['intros', 'reviews', 'cta']],
        ['demo_name' => 'Growth', 'title' => 'Careers Intro CTA', 'categories' => ['intros', 'cta']],
        ['demo_name' => 'Growth', 'title' => 'Pricing Intro Tables Clients', 'categories' => ['intros', 'pricing', 'clients']],
        ['demo_name' => 'Growth', 'title' => 'About Intro Slider', 'categories' => ['intros', 'sliders']],
        ['demo_name' => 'Growth', 'title' => 'Contact Intro CTA', 'categories' => ['intros', 'contact', 'cta']],

        ['demo_name' => 'Vision', 'title' => 'Home Intro Clients', 'categories' => ['intros', 'clients']],
        ['demo_name' => 'Vision', 'title' => 'Product Intro Marquee Fancy Mockup', 'categories' => ['intros', 'marquee', 'miscellaneous']],
        ['demo_name' => 'Vision', 'title' => 'Services Intro Features', 'categories' => ['intros', 'features']],
        ['demo_name' => 'Vision', 'title' => 'Pricing Intro Tables', 'categories' => ['intros', 'pricing']],
        ['demo_name' => 'Vision', 'title' => 'Help Center Intro Search', 'categories' => ['intros', 'miscellaneous']],
        ['demo_name' => 'Vision', 'title' => 'Contact Form Intro', 'categories' => ['intros', 'contact']],

        ['demo_name' => 'Partners', 'title' => 'About Intro Carousel Slider', 'categories' => ['intros', 'sliders']],
        ['demo_name' => 'Partners', 'title' => 'Careers Intro Marquee', 'categories' => ['intros', 'marquee']],
        ['demo_name' => 'Partners', 'title' => 'Home Intro Slider Clients', 'categories' => ['intros', 'sliders', 'clients']],
        ['demo_name' => 'Partners', 'title' => 'Pricing Intro CTA', 'categories' => ['intros', 'pricing', 'cta']],
        ['demo_name' => 'Partners', 'title' => 'Services Intro Features CTA', 'categories' => ['intros', 'features', 'cta']],

        ['demo_name' => 'Prime', 'title' => 'Intro Vertical Marquee Clients CTA', 'categories' => ['intros', 'marquee', 'clients', 'cta']],

        ['demo_name' => 'Trust', 'title' => 'Home Intro Slider Clients', 'categories' => ['intros', 'sliders', 'clients']],
        ['demo_name' => 'Trust', 'title' => 'Solutions Intro Slider Video Features', 'categories' => ['intros', 'video', 'features', 'sliders']],
        ['demo_name' => 'Trust', 'title' => 'Services Intro Slider Features', 'categories' => ['intros', 'features', 'sliders']],
        ['demo_name' => 'Trust', 'title' => 'Reviews Intro Slider Card', 'categories' => ['intros', 'reviews', 'sliders']],
        ['demo_name' => 'Trust', 'title' => 'Contact Intro Information Slider', 'categories' => ['intros', 'contact', 'sliders']],

        ['demo_name' => 'RTL', 'title' => 'Home Intro Marquee', 'categories' => ['intros', 'marquee']],
        ['demo_name' => 'RTL', 'title' => 'Services Intro', 'categories' => ['intros']],
        ['demo_name' => 'RTL', 'title' => 'Features Intro Video', 'categories' => ['intros', 'video']],
        ['demo_name' => 'RTL', 'title' => 'Reviews Intro Awards CTA', 'categories' => ['intros', 'reviews', 'cta']],
        ['demo_name' => 'RTL', 'title' => 'Careers Intro CTA', 'categories' => ['intros', 'cta']],
        ['demo_name' => 'RTL', 'title' => 'Pricing Intro Tables Clients', 'categories' => ['intros', 'pricing', 'clients']],
        ['demo_name' => 'RTL', 'title' => 'About Intro Slider', 'categories' => ['intros', 'sliders']],
        ['demo_name' => 'RTL', 'title' => 'Contact Intro CTA', 'categories' => ['intros', 'contact', 'cta']],

        ['demo_name' => 'App', 'title' => 'Home Intro Carousel Awards Reviews', 'categories' => ['intros', 'reviews', 'image_carousel']],

    ];

    return pix_generate_templates($templatesList, 'intros', $thumbPath);
}




 ?>
