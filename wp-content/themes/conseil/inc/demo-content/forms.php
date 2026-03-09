<?php

function pixfort_demo_forms(){
    $data = array();

    $import_url = 'https://import.pixfort.com/conseil/';
    $import_image_url = 'https://theme.assets.pixfort.com/thumbnails/forms/';

    $demo = array(
        'import_file_name'             => 'Simple Contact Form',
        'categories'                   => array( 'Contact Form 7' ),
        'import_file_url'            => $import_url.'demo-content/contact-forms/simple-contact-form.xml',
        'import_preview_image_url'     => $import_image_url.'simple-contact-form.webp',
        'import_notice'                => esc_html__( 'Contact Form 7 plugin should be installed and activated in order to import & use the forms.', 'conseil' ),
    );
    array_push($data, $demo);

    $demo = array(
        'import_file_name'             => 'Newsletter Form',
        'categories'                   => array( 'Contact Form 7' ),
        'import_file_url'            => $import_url.'demo-content/contact-forms/newsletter-form.xml',
        'import_preview_image_url'     => $import_image_url.'newsletter-subscription-form.webp',
        'import_notice'                => esc_html__( 'Contact Form 7 plugin should be installed and activated in order to import & use the forms.', 'conseil' ),
    );
    array_push($data, $demo);

    $demo = array(
        'import_file_name'             => 'Simple Subscription Form',
        'categories'                   => array( 'Contact Form 7' ),
        'import_file_url'            => $import_url.'demo-content/contact-forms/simple-subscription-form.xml',
        'import_preview_image_url'     => $import_image_url.'simple-subscription-form.webp',
        'import_notice'                => esc_html__( 'Contact Form 7 plugin should be installed and activated in order to import & use the forms.', 'conseil' ),
    );
    array_push($data, $demo);

    $demo = array(
        'import_file_name'             => 'Horizontal Subscription Form',
        'categories'                   => array( 'Contact Form 7' ),
        'import_file_url'            => $import_url.'demo-content/contact-forms/horizontal-subscription-form.xml',
        'import_preview_image_url'     => $import_image_url.'horizontal-subscription-form.webp',
        'import_notice'                => esc_html__( 'Contact Form 7 plugin should be installed and activated in order to import & use the forms.', 'conseil' ),
    );
    array_push($data, $demo);

    $demo = array(
        'import_file_name'             => 'Contact Form',
        'categories'                   => array( 'Contact Form 7' ),
        'import_file_url'            => $import_url.'demo-content/contact-forms/contact-form.xml',
        'import_preview_image_url'     => $import_image_url.'contact-form.webp',
        'import_notice'                => esc_html__( 'Contact Form 7 plugin should be installed and activated in order to import & use the forms.', 'conseil' ),

    );
    array_push($data, $demo);

    $demo = array(
        'import_file_name'             => 'Advanced Contact Form',
        'categories'                   => array( 'Contact Form 7' ),
        'import_file_url'            => $import_url.'demo-content/contact-forms/advanced-contact-form.xml',
        'import_preview_image_url'     => $import_image_url.'advanced-contact-form.webp',
        'import_notice'                => esc_html__( 'Contact Form 7 plugin should be installed and activated in order to import & use the forms.', 'conseil' ),

    );
    array_push($data, $demo);

    $demo = array(
        'import_file_name'             => 'Vertical Subscription Form',
        'categories'                   => array( 'Contact Form 7' ),
        'import_file_url'            => $import_url.'demo-content/contact-forms/vertical-subscription-form.xml',
        'import_preview_image_url'     => $import_image_url.'vertical-subscription-form.webp',
        'import_notice'                => esc_html__( 'Contact Form 7 plugin should be installed and activated in order to import & use the forms.', 'conseil' ),

    );
    array_push($data, $demo);



    return $data;
}
     ?>
