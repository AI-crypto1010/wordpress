<?php

// For information: available categories for $pagesList:
// 'all',
// 'homepages',
// 'inner_pages',
// 'about',
// 'services',
// 'features',
// 'pricing',
// 'social_proof',
// 'miscellaneous',
// 'contact',
// 'showcase',
// 'portfolio',
// 'coming_soon',
// '404_page'

$thumbPath = 'https://wordpress.assets.pixfort.com/conseil/library/pages/';

$pagesList = [
    // Homepages
    ['demo_name' => 'SaaS', 'title' => 'Home', 'categories' => ['homepages']],
    ['demo_name' => 'Advisory', 'title' => 'Home', 'categories' => ['homepages']],
    ['demo_name' => 'Digital Agency', 'title' => 'Home', 'categories' => ['homepages']],
    ['demo_name' => 'Growth', 'title' => 'Home', 'categories' => ['homepages']],
    ['demo_name' => 'App', 'title' => 'Home', 'categories' => ['homepages', 'showcase', 'features']],
    ['demo_name' => 'Vision', 'title' => 'Home', 'categories' => ['homepages']],
    ['demo_name' => 'Prime', 'title' => 'Home', 'categories' => ['homepages']],
    ['demo_name' => 'Consulting', 'title' => 'Home', 'categories' => ['homepages']],
    ['demo_name' => 'Partners', 'title' => 'Home', 'categories' => ['homepages']],
    ['demo_name' => 'Trust', 'title' => 'Home', 'categories' => ['homepages']],
    ['demo_name' => 'RTL', 'title' => 'Home', 'categories' => ['homepages']],
    
    // Advisory Inner Pages
    ['demo_name' => 'Advisory', 'title' => 'About', 'categories' => ['inner_pages', 'about']],
    ['demo_name' => 'Advisory', 'title' => 'Services', 'categories' => ['inner_pages', 'services']],
    ['demo_name' => 'Advisory', 'title' => 'Features', 'categories' => ['inner_pages', 'features']],
    ['demo_name' => 'Advisory', 'title' => 'Pricing', 'categories' => ['inner_pages', 'pricing']],
    ['demo_name' => 'Advisory', 'title' => 'Reviews', 'categories' => ['inner_pages', 'social_proof']],
    ['demo_name' => 'Advisory', 'title' => 'Careers', 'categories' => ['inner_pages', 'miscellaneous']],
    ['demo_name' => 'Advisory', 'title' => 'Job Description', 'categories' => ['inner_pages', 'miscellaneous']],
    ['demo_name' => 'Advisory', 'title' => 'Contact', 'categories' => ['inner_pages', 'contact']],
    ['demo_name' => 'Advisory', 'title' => 'Privacy policy', 'categories' => ['inner_pages', 'miscellaneous']],
    ['demo_name' => 'Advisory', 'title' => 'Terms of Use', 'categories' => ['inner_pages', 'miscellaneous']],
    ['demo_name' => 'Advisory', 'title' => 'Coming Soon', 'categories' => ['inner_pages', 'coming_soon']],
    ['demo_name' => 'Advisory', 'title' => '404 Page', 'categories' => ['inner_pages', '404_page']],
    
    // Digital Agency Inner Pages
    ['demo_name' => 'Digital Agency', 'title' => 'About', 'categories' => ['inner_pages', 'about']],
    ['demo_name' => 'Digital Agency', 'title' => 'Services', 'categories' => ['inner_pages', 'services']],
    ['demo_name' => 'Digital Agency', 'title' => 'Features', 'categories' => ['inner_pages', 'features']],
    ['demo_name' => 'Digital Agency', 'title' => 'Showcase', 'categories' => ['inner_pages', 'showcase', 'portfolio']],
    ['demo_name' => 'Digital Agency', 'title' => 'Project Page', 'categories' => ['inner_pages', 'portfolio', 'showcase']],
    ['demo_name' => 'Digital Agency', 'title' => 'Pricing', 'categories' => ['inner_pages', 'pricing']],
    ['demo_name' => 'Digital Agency', 'title' => 'Reviews', 'categories' => ['inner_pages', 'social_proof']],
    ['demo_name' => 'Digital Agency', 'title' => 'Contact', 'categories' => ['inner_pages', 'contact']],
    ['demo_name' => 'Digital Agency', 'title' => 'Privacy policy', 'categories' => ['inner_pages', 'miscellaneous']],
    ['demo_name' => 'Digital Agency', 'title' => 'Terms of Use', 'categories' => ['inner_pages', 'miscellaneous']],
    ['demo_name' => 'Digital Agency', 'title' => 'Coming Soon', 'categories' => ['inner_pages', 'coming_soon']],
    ['demo_name' => 'Digital Agency', 'title' => '404 Page', 'categories' => ['inner_pages', '404_page']],
    
    
    // Growth Inner Pages
    ['demo_name' => 'Growth', 'title' => 'About', 'categories' => ['inner_pages', 'about']],
    ['demo_name' => 'Growth', 'title' => 'Services', 'categories' => ['inner_pages', 'services']],
    ['demo_name' => 'Growth', 'title' => 'Features', 'categories' => ['inner_pages', 'features']],
    ['demo_name' => 'Growth', 'title' => 'Pricing', 'categories' => ['inner_pages', 'pricing']],
    ['demo_name' => 'Growth', 'title' => 'Reviews', 'categories' => ['inner_pages', 'social_proof']],
    ['demo_name' => 'Growth', 'title' => 'Careers', 'categories' => ['inner_pages', 'miscellaneous']],
    ['demo_name' => 'Growth', 'title' => 'Job Description', 'categories' => ['inner_pages', 'miscellaneous']],
    ['demo_name' => 'Growth', 'title' => 'Contact', 'categories' => ['inner_pages', 'contact']],
    ['demo_name' => 'Growth', 'title' => 'Privacy policy', 'categories' => ['inner_pages', 'miscellaneous']],
    ['demo_name' => 'Growth', 'title' => 'Terms of Use', 'categories' => ['inner_pages', 'miscellaneous']],
    ['demo_name' => 'Growth', 'title' => 'Coming Soon', 'categories' => ['inner_pages', 'coming_soon']],
    ['demo_name' => 'Growth', 'title' => '404 Page', 'categories' => ['inner_pages', '404_page']],
    
    // Consulting Inner Pages
    ['demo_name' => 'Consulting', 'title' => 'Services', 'categories' => ['inner_pages', 'services']],
    ['demo_name' => 'Consulting', 'title' => 'Features', 'categories' => ['inner_pages', 'features']],
    ['demo_name' => 'Consulting', 'title' => 'Case Studies', 'categories' => ['inner_pages', 'showcase', 'portfolio']],
    ['demo_name' => 'Consulting', 'title' => 'Pricing', 'categories' => ['inner_pages', 'pricing']],
    ['demo_name' => 'Consulting', 'title' => 'Contact', 'categories' => ['inner_pages', 'contact']],
    ['demo_name' => 'Consulting', 'title' => 'About', 'categories' => ['inner_pages', 'about']],
    ['demo_name' => 'Consulting', 'title' => 'Privacy policy', 'categories' => ['inner_pages', 'miscellaneous']],
    ['demo_name' => 'Consulting', 'title' => 'Terms of Use', 'categories' => ['inner_pages', 'miscellaneous']],
    ['demo_name' => 'Consulting', 'title' => 'Coming Soon', 'categories' => ['inner_pages', 'coming_soon']],
    ['demo_name' => 'Consulting', 'title' => '404 Page', 'categories' => ['inner_pages', '404_page']],

    // Vision Inner Pages
    ['demo_name' => 'Vision', 'title' => 'Services', 'categories' => ['inner_pages', 'services']],
    ['demo_name' => 'Vision', 'title' => 'Product', 'categories' => ['inner_pages', 'features', 'showcase']],
    ['demo_name' => 'Vision', 'title' => 'Pricing', 'categories' => ['inner_pages', 'pricing']],
    ['demo_name' => 'Vision', 'title' => 'Help Center', 'categories' => ['inner_pages', 'miscellaneous']],
    ['demo_name' => 'Vision', 'title' => 'Quick Links', 'categories' => ['inner_pages', 'miscellaneous']],
    ['demo_name' => 'Vision', 'title' => 'Contact', 'categories' => ['inner_pages', 'contact']],
    ['demo_name' => 'Vision', 'title' => 'Privacy policy', 'categories' => ['inner_pages', 'miscellaneous']],
    ['demo_name' => 'Vision', 'title' => 'Terms of Use', 'categories' => ['inner_pages', 'miscellaneous']],
    ['demo_name' => 'Vision', 'title' => 'Coming Soon', 'categories' => ['inner_pages', 'coming_soon']],
    ['demo_name' => 'Vision', 'title' => '404 Page', 'categories' => ['inner_pages', '404_page']],

    // SaaS Inner Pages
    ['demo_name' => 'SaaS', 'title' => 'Product', 'categories' => ['inner_pages', 'features', 'showcase', 'services']],
    ['demo_name' => 'SaaS', 'title' => 'Pricing', 'categories' => ['inner_pages', 'pricing']],
    ['demo_name' => 'SaaS', 'title' => 'Services', 'categories' => ['inner_pages', 'services']],
    ['demo_name' => 'SaaS', 'title' => 'Single Service', 'categories' => ['inner_pages', 'services', 'showcase']],
    ['demo_name' => 'SaaS', 'title' => 'Contact', 'categories' => ['inner_pages', 'contact']],
    ['demo_name' => 'SaaS', 'title' => 'Help Center', 'categories' => ['inner_pages', 'miscellaneous']],
    ['demo_name' => 'SaaS', 'title' => 'Links', 'categories' => ['inner_pages', 'miscellaneous']],
    ['demo_name' => 'SaaS', 'title' => 'Custom Post', 'categories' => ['inner_pages', 'miscellaneous']],
    ['demo_name' => 'SaaS', 'title' => 'Changelog', 'categories' => ['inner_pages', 'miscellaneous']],
    ['demo_name' => 'SaaS', 'title' => 'Privacy policy', 'categories' => ['inner_pages', 'miscellaneous']],
    ['demo_name' => 'SaaS', 'title' => 'Terms of Use', 'categories' => ['inner_pages', 'miscellaneous']],
    ['demo_name' => 'SaaS', 'title' => 'Coming Soon', 'categories' => ['inner_pages', 'coming_soon']],
    ['demo_name' => 'SaaS', 'title' => '404 Page', 'categories' => ['inner_pages', '404_page']],
    
    // Partners Inner Pages
    ['demo_name' => 'Partners', 'title' => 'About', 'categories' => ['inner_pages', 'about']],
    ['demo_name' => 'Partners', 'title' => 'Services', 'categories' => ['inner_pages', 'services']],
    ['demo_name' => 'Partners', 'title' => 'Pricing', 'categories' => ['inner_pages', 'pricing']],
    ['demo_name' => 'Partners', 'title' => 'Careers', 'categories' => ['inner_pages', 'miscellaneous']],
    ['demo_name' => 'Partners', 'title' => 'Job Description', 'categories' => ['inner_pages', 'miscellaneous']],
    ['demo_name' => 'Partners', 'title' => 'Contact', 'categories' => ['inner_pages', 'contact']],
    ['demo_name' => 'Partners', 'title' => 'Coming Soon', 'categories' => ['inner_pages', 'coming_soon']],
    ['demo_name' => 'Partners', 'title' => '404 Page', 'categories' => ['inner_pages', '404_page']],
    
    // Trust Inner Pages
    ['demo_name' => 'Trust', 'title' => 'Solutions', 'categories' => ['inner_pages', 'features', 'services']],
    ['demo_name' => 'Trust', 'title' => 'Services', 'categories' => ['inner_pages', 'services']],
    ['demo_name' => 'Trust', 'title' => 'Reviews', 'categories' => ['inner_pages', 'social_proof']],
    ['demo_name' => 'Trust', 'title' => 'Contact', 'categories' => ['inner_pages', 'contact']],
    ['demo_name' => 'Trust', 'title' => 'Coming Soon', 'categories' => ['inner_pages', 'coming_soon']],
    ['demo_name' => 'Trust', 'title' => '404 Page', 'categories' => ['inner_pages', '404_page']],
    
    // RTL Inner Pages
    ['demo_name' => 'RTL', 'title' => 'About', 'categories' => ['inner_pages', 'about']],
    ['demo_name' => 'RTL', 'title' => 'Services', 'categories' => ['inner_pages', 'services']],
    ['demo_name' => 'RTL', 'title' => 'Features', 'categories' => ['inner_pages', 'features']],
    ['demo_name' => 'RTL', 'title' => 'Pricing', 'categories' => ['inner_pages', 'pricing']],
    ['demo_name' => 'RTL', 'title' => 'Reviews', 'categories' => ['inner_pages', 'social_proof']],
    ['demo_name' => 'RTL', 'title' => 'Careers', 'categories' => ['inner_pages', 'miscellaneous']],
    ['demo_name' => 'RTL', 'title' => 'Job Description', 'categories' => ['inner_pages', 'miscellaneous']],
    ['demo_name' => 'RTL', 'title' => 'Contact', 'categories' => ['inner_pages', 'contact']],
    ['demo_name' => 'RTL', 'title' => 'Privacy policy', 'categories' => ['inner_pages', 'miscellaneous']],
    ['demo_name' => 'RTL', 'title' => 'Terms of Use', 'categories' => ['inner_pages', 'miscellaneous']],
    ['demo_name' => 'RTL', 'title' => 'Coming Soon', 'categories' => ['inner_pages', 'coming_soon']],
    ['demo_name' => 'RTL', 'title' => '404 Page', 'categories' => ['inner_pages', '404_page']],
    
];

$pages = pix_generate_templates($pagesList, 'pages', $thumbPath);

return $pages;

 ?>
