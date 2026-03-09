<?php




function pix_elementor_templates_features(){

    $thumbPath = 'https://wordpress.assets.pixfort.com/conseil/library/sections/features/';
    
    $templatesList = [

        ['demo_name' => 'Consulting', 'title' => 'Case Studies Features', 'categories' => ['features']],
        ['demo_name' => 'Consulting', 'title' => 'Features Boxes', 'categories' => ['features']],
        ['demo_name' => 'Consulting', 'title' => 'Home Features', 'categories' => ['features']],
        ['demo_name' => 'Consulting', 'title' => 'Services Content 3D Box Features', 'categories' => ['features', 'content']],
        ['demo_name' => 'Consulting', 'title' => 'Services Features', 'categories' => ['features']],

        ['demo_name' => 'Digital Agency', 'title' => 'Features Boxes', 'categories' => ['features']],
        ['demo_name' => 'Digital Agency', 'title' => 'Features Cards', 'categories' => ['features', 'content']],
        ['demo_name' => 'Digital Agency', 'title' => 'Features Cards Clients', 'categories' => ['features', 'clients', 'content']],
        ['demo_name' => 'Digital Agency', 'title' => 'Home Features', 'categories' => ['features']],
        ['demo_name' => 'Digital Agency', 'title' => 'Home Features Cards', 'categories' => ['features', 'content']],
        ['demo_name' => 'Digital Agency', 'title' => 'Project Page Features', 'categories' => ['features']],

        ['demo_name' => 'Advisory', 'title' => 'Features Grid', 'categories' => ['features']],
        ['demo_name' => 'Advisory', 'title' => 'Home Cards', 'categories' => ['features', 'content']],
        ['demo_name' => 'Advisory', 'title' => 'Home Features Grid', 'categories' => ['features']],
        ['demo_name' => 'Advisory', 'title' => 'Home Features Simple', 'categories' => ['features']],
        ['demo_name' => 'Advisory', 'title' => 'Services Cards', 'categories' => ['features', 'content']],
        ['demo_name' => 'Advisory', 'title' => 'Services Features', 'categories' => ['features', 'content']],

        ['demo_name' => 'Growth', 'title' => 'Home Features Numbers', 'categories' => ['features', 'numbers', 'content']],
        ['demo_name' => 'Growth', 'title' => 'Features CTA', 'categories' => ['features', 'cta', 'content']],
        ['demo_name' => 'Growth', 'title' => 'Features Numbers Sticky Content', 'categories' => ['features', 'numbers', 'content']],

        ['demo_name' => 'Vision', 'title' => 'Home Features', 'categories' => ['features']],
        ['demo_name' => 'Vision', 'title' => 'Product Features', 'categories' => ['features']],
        ['demo_name' => 'Vision', 'title' => 'Services Features', 'categories' => ['features']],
        ['demo_name' => 'Vision', 'title' => 'Help Center Features Links', 'categories' => ['features']],

        ['demo_name' => 'Partners', 'title' => 'Home Features', 'categories' => ['features']],
        ['demo_name' => 'Partners', 'title' => 'Home Features Box', 'categories' => ['features']],

        ['demo_name' => 'Prime', 'title' => 'Content Features Cards', 'categories' => ['features', 'content']],
        ['demo_name' => 'Prime', 'title' => 'Features Grid', 'categories' => ['features']],

        ['demo_name' => 'Trust', 'title' => 'Home Features', 'categories' => ['features']],
        ['demo_name' => 'Trust', 'title' => 'Home Category Features', 'categories' => ['features']],
        ['demo_name' => 'Trust', 'title' => 'Reviews Features Rating Promo Box', 'categories' => ['features', 'reviews']],
        ['demo_name' => 'Trust', 'title' => 'Services Features', 'categories' => ['features']],
        ['demo_name' => 'Trust', 'title' => 'Solutions Features Sticky Content', 'categories' => ['features', 'content']],

        ['demo_name' => 'RTL', 'title' => 'Home Features Numbers', 'categories' => ['features', 'numbers', 'content']],
        ['demo_name' => 'RTL', 'title' => 'Features CTA', 'categories' => ['features', 'cta', 'content']],
        ['demo_name' => 'RTL', 'title' => 'Features Numbers Sticky Content', 'categories' => ['features', 'numbers', 'content']],

        ['demo_name' => 'App', 'title' => 'Home Bento Features Vertical Marquee Video', 'categories' => ['features', 'marquee', 'video', 'content']],
        ['demo_name' => 'App', 'title' => 'Home Features Boxes CTA', 'categories' => ['features', 'cta']],

        ['demo_name' => 'SaaS', 'title' => 'Help Center Feature Boxes Links', 'categories' => ['features', 'links']],
        ['demo_name' => 'SaaS', 'title' => 'Singe Service Steps Features', 'categories' => ['features', 'miscellaneous', 'content']],
        ['demo_name' => 'SaaS', 'title' => 'Singe Service Feature Boxes', 'categories' => ['features']],
        ['demo_name' => 'SaaS', 'title' => 'Product Features Grid Sticky Content', 'categories' => ['features', 'content']],
        ['demo_name' => 'SaaS', 'title' => 'Home Features Comparison CTA', 'categories' => ['features', 'cta', 'content']],
        ['demo_name' => 'SaaS', 'title' => 'Pricing Addons Features List', 'categories' => ['features', 'pricing', 'miscellaneous', 'content']],
        ['demo_name' => 'SaaS', 'title' => 'Product Video Clients Marquee Features', 'categories' => ['features', 'video', 'clients', 'marquee']],
        ['demo_name' => 'SaaS', 'title' => 'Home Features Grid', 'categories' => ['features']],
        ['demo_name' => 'SaaS', 'title' => 'Home Features Bento Boxes', 'categories' => ['features']],

    ];

    return pix_generate_templates($templatesList, 'features', $thumbPath);
}




 ?>
