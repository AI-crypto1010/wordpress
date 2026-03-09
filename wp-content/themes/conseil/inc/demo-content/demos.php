<?php

function pixfort_demo_sites() {
    $data = array();

    $import_url = 'https://import.pixfort.com/conseil/';
    $import_image_url = 'https://wordpress.assets.pixfort.com/conseil/thumbnails/demos/';

    $elementor = false;

    if (class_exists('\Elementor\Plugin')) {
        $elementor = true;
    }

    if ($elementor) {

        $demo_names = [
            ['name' => 'SaaS'],
            ['name' => 'App'],
            ['name' => 'Advisory'],
            ['name' => 'Digital Agency'],
            ['name' => 'Consulting'],
            ['name' => 'Growth'],
            ['name' => 'Vision'],
            ['name' => 'Partners'],
            ['name' => 'Prime'],
            ['name' => 'Trust'],
            ['name' => 'RTL']
        ];

        foreach ($demo_names as $demo_data) {
            $name = $demo_data['name'];
            $name_with_hyphens = str_replace(' ', '-', strtolower($name));
            $demo = array(
                'import_file_name'          => ucwords($name),
                'categories'                => array('Demos'),
                'import_file_url'           => $import_url . 'demo-content/' . $name_with_hyphens . '/' . $name_with_hyphens . '-main.xml',
                'local_import_widget_file'      => trailingslashit(get_template_directory()) . 'inc/demo-content/widgets/blog-widgets.wie',
                'import_notice'             => esc_html__('Please make sure that Elementor plugin is installed and activated, and Elementor Flexbox container option is enabled before importing this demo content.', 'conseil'),
                'import_redux'              => array(
                    array(
                        'file_url'              => $import_url . 'demo-content/' . $name_with_hyphens . '/' . $name_with_hyphens . '-options.json',
                        'option_name'           => 'pix_options',
                    ),
                ),
                'import_preview_image_url' => $import_image_url . 'demo-import-thumbnail-' . $name_with_hyphens . '-1.webp',
                'preview_url'               => 'https://conseil.pixfort.com/' . $name_with_hyphens . '/',
            );
            
            // Add includes_woo flag if it exists
            if (isset($demo_data['includes_woo'])) {
                $demo['includes_woo'] = $demo_data['includes_woo'];
            }
            
            array_push($data, $demo);
        }
        // $demo = array(
        //     'import_file_name'          => 'Original',
        //     'categories'                => array('Demos'),
        //     'import_file_url'           => $import_url . 'demo-content/original/original-elementor.xml',
        //     'import_widget_file_url'    => $import_url . 'demo-content/blog-widgets.wie',
        //     'import_notice'             => esc_html__('Please make sure that Elementor plugin is installed and activated before importing this demo content.', 'conseil'),
        //     'import_redux'              => array(
        //         array(
        //             'file_url'              => $import_url . 'demo-content/original/original-options.json',
        //             'option_name'           => 'pix_options',
        //         ),
        //     ),
        //     'import_preview_image_url' => $import_image_url . 'demo-import-thumbnail-original-1.webp',
        //     'preview_url'               => 'https://theme.pixfort.com/original/',
        // );
        // array_push($data, $demo);

    }
    return $data;
}
