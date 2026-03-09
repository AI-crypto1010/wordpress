<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Popup Type
 *
 * 
 *
 * @since 1.0
 */
class PopupType {

    public function __construct() {
        $this->load();
    }

    public function load() {
        add_action('init', [$this, 'pix_pixpopup_post_type']);
        add_filter('manage_posts_columns', [$this, 'revealid_add_id_column'], 5);
        add_action('manage_posts_custom_column', [$this, 'revealid_id_column_content'], 5, 2);
        add_action('admin_menu', [$this, 'pix_pixpopup_meta_add']);
        add_action('save_post_pixpopup', [$this, 'pix_pixpopup_save_data']);

        add_action('wp_ajax_pix_get_popup_content', [$this, 'pix_popup_content']);
        add_action('wp_ajax_nopriv_pix_get_popup_content', [$this, 'pix_popup_content']);
        add_action('wp_ajax_pix_get_page_popups_content', [$this, 'pix_page_popups_content']);
        add_action('wp_ajax_nopriv_pix_get_page_popups_content', [$this, 'pix_page_popups_content']);
    }

    public function pix_pixpopup_post_type() {
        $pixpopup_item_slug = 'pixpopup-item';
        $labels = array(
            'name'                     => __('Popups', 'pixfort-core'),
            'singular_name'         => __('Popup item', 'pixfort-core'),
            'add_new'                 => __('Add New Popup', 'pixfort-core'),
            'add_new_item'             => __('Add New Popup Item', 'pixfort-core'),
            'edit_item'             => __('Edit Popup item', 'pixfort-core'),
            'new_item'                 => __('New Popup item', 'pixfort-core'),
            'view_item'             => __('View Popup item', 'pixfort-core'),
            'search_items'             => __('Search Popup items', 'pixfort-core'),
            'not_found'             => __('No Popup items found', 'pixfort-core'),
            'not_found_in_trash'     => __('No Popup items found in Trash', 'pixfort-core'),
            'parent_item_colon'     => ''
        );
        $args = array(
            'labels'                 => $labels,
            'menu_icon'             => PIX_CORE_PLUGIN_URI . 'functions/images/admin/popups.svg',
            'public'                 => true,
            'publicly_queryable'     => true,
            'show_ui'                 => true,
            'query_var'             => true,
            'capability_type'         => 'post',
            'hierarchical'             => false,
            'menu_position'         => null,
            'exclude_from_search'     => true,
            'rewrite'                 => array('slug' => $pixpopup_item_slug, 'with_front' => true),
            'supports'                 => array('title', 'editor', 'author', 'excerpt', 'thumbnail', 'page-attributes'),
        );
        register_post_type('pixpopup', $args);
        register_taxonomy('pixpopup-types', 'pixpopup', array(
            'hierarchical'             => true,
            'label'                 =>  __('pixpopup categories', 'pixfort-core'),
            'singular_label'         =>  __('pixpopup category', 'pixfort-core'),
            'rewrite'                => true,
            'query_var'             => true
        ));
    }

    public function pix_pixpopup_meta_add() {
        global $pix_pixpopup_meta_box;

        // Custom menu ------------------------------
        $aMenus = array(0 => '-- Default --');
        $oMenus = get_terms('nav_menu', array('hide_empty' => false));

        if (is_array($oMenus)) {
            foreach ($oMenus as $menu) {
                $aMenus[$menu->term_id] = $menu->name;
            }
        }
        $pix_pixpopup_meta_box = array(
            'id'         => 'pix-meta-page',
            'title'     => __('pixfort Popup Options', 'pixfort-core'),
            'page'         => 'pixpopup',
            'post_types'    => array('pixheader'),
            'context'     => 'normal',
            'priority'     => 'high',
            'fields'    => array(
                array(
                    'id'         => 'pix-popup-size',
                    'type'         => 'select',
                    'title'     => __('Popup ize', 'pixfort-core'),
                    'sub_desc'     => __('Select the width of the popup.', 'pixfort-core'),
                    'options'     => array(
                        'col-12 col-sm-4'            => 'Extra small (4 Columns)',
                        'col-12 col-sm-6'            => 'Small (6 Columns)',
                        'col-12 col-sm-8'            => 'Medium (8 Columns)',
                        'col-12 col-sm-10'            => 'Big (10 Columns)',
                        'col-12'                    => 'Full width (12 Columns)',
                    ),
                    'std'        => 'col-12 col-sm-6'
                ),
                array(
                    'id'         => 'pix-popup-width',
                ),
                array(
                    'id'         => 'popup-condition',
                ),
                array(
                    'id'         => 'popup-onpageload',
                ),
                array(
                    'id'         => 'popup-onpageload-after',
                ),
                array(
                    'id'         => 'popup-onscroll',
                ),
                array(
                    'id'         => 'popup-onscroll-percentage',
                ),
                array(
                    'id'         => 'popup-onclick',
                ),
                array(
                    'id'         => 'popup-onpageexit',
                ),
                array(
                    'id'         => 'popup-onscrollelement',
                ),
                array(
                    'id'         => 'popup-onscrollelement-selector',
                ),
                array(
                    'id'         => 'popup-border-radius',
                ),
                array(
                    'id'         => 'pix-overflow-visible',
                ),
                array(
                    'id'         => 'pix-popup-animation',
                ),
                array(
                    'id'         => 'pix-popup-height',
                ),
                array(
                    'id'         => 'popup-height-custom',
                ),
                array(
                    'id'         => 'pix-popup-position-x',
                ),
                array(
                    'id'         => 'pix-popup-position-y',
                ),
                array(
                    'id'         => 'popup-padding',
                ),
                array(
                    'id'         => 'pix-popup-shadow',
                ),
                array(
                    'id'         => 'popup-background-color',
                ),
                array(
                    'id'         => 'popup-background-custom-color',
                ),
                array(
                    'id'         => 'pix-popup-close-x',
                ),
                array(
                    'id'         => 'pix-popup-close-y',
                ),
                array(
                    'id'         => 'popup-close-color',
                ),
                array(
                    'id'         => 'pix-close-icon',
                ),
                array(
                    'id'         => 'pix-disable-backdrop',
                ),
                array(
                    'id'         => 'popup-backdrop-color',
                ),
                array(
                    'id'         => 'popup-backdrop-blur',
                ),
                array(
                    'id'         => 'pix-backdrop-disable-close',
                ),
                array(
                    'id'         => 'pix-esc-disable-close',
                ),
                array(
                    'id'         => 'pix-enable-launcher',
                ),
                array(
                    'id'         => 'pix-launcher-position',
                ),
                array(
                    'id'         => 'pix-launcher-bottom-value',
                ),
                array(
                    'id'         => 'pix-launcher-horizontal-value',
                ),
                array(
                    'id'         => 'pix-attach-popup-launcher',
                ),
                array(
                    'id'         => 'pix-launcher-in-front',
                ),
                array(
                    'id'         => 'pix-launcher-background-color',
                ),
                array(
                    'id'         => 'pix-launcher-background-custom-color',
                ),
                array(
                    'id'         => 'pix-launcher-icon-color',
                ),
                array(
                    'id'         => 'pix-launcher-icon-custom-color',
                ),
                array(
                    'id'         => 'pix-launcher-logo',
                ),
                array(
                    'id'         => 'pix-launcher-icon',
                ),
                array(
                    'id'         => 'pix-launcher-logo-image',
                ),
                array(
                    'id'         => 'pix-launcher-logo-padding',
                ),
                array(
                    'id'         => 'pix-popup-launcher-shadow',
                ),
                array(
                    'id'         => 'popup-backdrop-custom-color',
                ),
                array(
                    'id'         => 'pix-enable-showtimes',
                ),
                array(
                    'id'         => 'pix-showtimes',
                ),
                array(
                    'id'         => 'pix-popup-id',
                ),
                array(
                    'id'         => 'pix-display-devices',
                ),
                array(
                    'id'         => 'popup-custom-css',
                ),
            ),
        );

        add_meta_box($pix_pixpopup_meta_box['id'], $pix_pixpopup_meta_box['title'], [$this, 'pix_pixpopup_show_box'], $pix_pixpopup_meta_box['page'], $pix_pixpopup_meta_box['context'], $pix_pixpopup_meta_box['priority']);
    }
    public function revealid_add_id_column($columns) {
        $post_type = get_post_type();
        if ($post_type == 'pixpopup') {
            $columns['revealid_id'] = esc_html__('Popup Link', 'pixfort-core');
        }
        return $columns;
    }

    public function revealid_id_column_content($column, $id) {
        $post_type = get_post_type();
        if ($post_type == 'pixpopup') {
            if ('revealid_id' == $column) { ?>
                <input onfocus="this.select();" type="text" value="#pix_popup_<?php echo esc_attr($id); ?>" readonly>
        <?php
            }
        }
    }

    public function pix_pixpopup_show_box() {
        global $post;

        /*
        * Migration from old options
        */
        $oldSizes = array(
            'col-12 col-sm-4'            => 'popup-width-xs',
            'col-12 col-sm-6'            => 'popup-width-sm',
            'col-12 col-sm-8'            => 'popup-width-md',
            'col-12 col-sm-10'           => 'popup-width-lg',
            'col-12'                     => 'popup-width-xl',
        );
        if (!get_post_meta($post->ID, 'pix-popup-width', true) && $popupSize = get_post_meta($post->ID, 'pix-popup-size', true)) {
            if (array_key_exists($popupSize, $oldSizes)) {
                $newPopupWidth = $oldSizes[$popupSize];
                update_post_meta($post->ID, 'pix-popup-width', $newPopupWidth);
            }
        }


        // Use nonce for verification
        echo '<div id="pix-wrapper"  class="pix-header-options-area">';
        echo '<input type="hidden" name="pix_page_meta_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
        echo '<table class="form-table">';
        echo '<tbody>';

        $pixfortBuilder = new PixfortOptions();
        $pixfortBuilder->initOptions(
            'meta',
            $post,
            true,
            [
                'tabs'  => [
                    'general'    => ['title'    => __('General', 'pixfort-core'), 'icon' => 'general'],
                    'triggers'    => ['title'    => __('Triggers', 'pixfort-core'), 'icon' => 'triggers'],
                    'design'    => ['title'    => __('Design', 'pixfort-core'), 'icon' => 'design'],
                    'launcher'    => ['title'    => __('Launcher', 'pixfort-core'), 'icon' => 'launcher'],
                    'advanced'    => ['title'    => __('Advanced', 'pixfort-core'), 'icon' => 'advanced'],
                ],
                'helpLink' => \PixfortCore::instance()->adminCore->getParam('docs_create_popup'),
            ]
        );


        $pixfortBuilder->addOption(
            'popup-condition',
            [
                'type' => 'conditions',
                'label' => __('Display Conditions', 'pixfort-core'),
                'default' => '',
                'tab'             => 'general',
                'tooltipText'   => '<strong>Note:</strong> After setting the display conditions, in order to show the popup in the selected pages don\'t forget to choose the popup triggers from the <strong>"Triggers"</strong> tab.',
                // 'tooltipImage'   => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/tooltips/popup-tooltip-example.svg',
                'description' => __('Add conditions to define where the popup will be displayed on your website.', 'pixfort-core'),
            ]
        );


        // $pixfortBuilder->addOption(
        //     'pix-popup-size',
        //     [
        //         'type'             => 'select',
        //         'label'         => 'Popup Size',
        //         'default'         => 'col-12 col-sm-6',
        //         'tab'             => 'general',
        //         'options'        => [
        //             'col-12 col-sm-4'            => 'Extra small (4 Columns)',
        //             'col-12 col-sm-6'            => 'Small (6 Columns)',
        //             'col-12 col-sm-8'            => 'Medium (8 Columns)',
        //             'col-12 col-sm-10'            => 'Big (10 Columns)',
        //             'col-12'                    => 'Full width (12 Columns)',
        //         ],
        //         'description'     => __('Select the width of the popup.', 'pixfort-core'),
        //     ]
        // );

        $pixfortBuilder->addOption(
            'pix-popup-width',
            [
                'type' => 'radio',
                'label' => __('Popup Width', 'pixfort-core'),
                'default' => 'popup-width-md',
                'tab'             => 'general',
                'description' => __('Choose the width of your popup.', 'pixfort-core'),
                'options'        => array(
                    [
                        'name'            => __('Extra Small', 'pixfort-core'),
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/thumbnails/width/popup-extra-small.svg',
                        'value'            => 'popup-width-xs'
                    ],
                    [
                        'name'            => __('Small', 'pixfort-core'),
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/thumbnails/width/popup-small.svg',
                        'value'            => 'popup-width-sm'
                    ],
                    [
                        'name'            => __('Medium', 'pixfort-core'),
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/thumbnails/width/popup-medium.svg',
                        'value'            => 'popup-width-md'
                    ],
                    [
                        'name'            => __('Large', 'pixfort-core'),
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/thumbnails/width/popup-large.svg',
                        'value'            => 'popup-width-lg'
                    ],
                    [
                        'name'            => __('Extra Large', 'pixfort-core'),
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/thumbnails/width/popup-extra-large.svg',
                        'value'            => 'popup-width-xl'
                    ],
                    [
                        'name'            => __('Full Width', 'pixfort-core'),
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/thumbnails/width/popup-full-width.svg',
                        'value'            => 'popup-width-full'
                    ],
                    [
                        'name'            => __('Content Width', 'pixfort-core'),
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/thumbnails/width/popup-content-width.svg',
                        'value'            => 'popup-width-content'
                    ]
                ),
            ]
        );

        $pixfortBuilder->addOption(
            'pix-popup-height',
            [
                'type' => 'radio',
                'label' => __('Popup Height', 'pixfort-core'),
                'default' => 'popup-height-content',
                'hideBorderBottom'  => true,
                'tab'             => 'general',
                'description' => __('Choose the height of your popup.', 'pixfort-core'),
                'options'        => array(
                    [
                        'name'            => __('Content Height', 'pixfort-core'),
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/thumbnails/height/popup-height-content.svg',
                        'value'            => 'popup-height-content'
                    ],
                    [
                        'name'            => __('Full Height', 'pixfort-core'),
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/thumbnails/height/popup-height-full.svg',
                        'value'            => 'popup-height-full'
                    ],
                    [
                        'name'            => __('Custom', 'pixfort-core'),
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/thumbnails/height/popup-height-custom.svg',
                        'value'            => 'popup-height-custom'
                    ]
                ),
            ]
        );

        $pixfortBuilder->addOption(
            'popup-height-custom',
            [
                'type'              => 'text',
                'label'             => __('Custom Height', 'pixfort-core'),
                // 'default'           => '500px',
                'placeholder'       => 'Examples: 500px, 60%, etc...',
                'showBorderTop'     => true,
                'hideBorderBottom'  => true,
                'responsive'        => true,
                'tab'               => 'general',
                'description'       => __('Choose a custom height for the popup (with the unit: px, %,.. etc).', 'pixfort-core'),
                'tooltipText'       => 'For example: "<strong>500px</strong>", "<strong>60%</strong>",.. etc.',
                'dependency'        => [
                    'field'             => "pix-popup-height",
                    'val'               => ['popup-height-custom']
                ]
            ]
        );

        $pixfortBuilder->addOption(
            'popup-onpageload',
            [
                'type'             => 'checkbox',
                'tab'             => 'triggers',
                'label'         => __('Show Popup on Page Load', 'pixfort-core'),
                'default'         => '0',
                'options'        => array('1' => 'On', '0' => 'Off'),
                'description' => __('Popup will show after loading the page.', 'pixfort-core'),
            ]
        );
        $pixfortBuilder->addOption(
            'popup-onpageload-after',
            [
                'type' => 'text',
                'label' => __('Delay Time on Page Load', 'pixfort-core'),
                'default' => '0',
                'tab'             => 'triggers',
                'description' => __('Show popup after a delay time, leave empty to display directly.', 'pixfort-core'),
                'tooltipText'   => 'The delay time (in seconds) to show the popup after opening the page. <br> For example, to show the popup after 5 seconds of loading the page enter 5 in the field.',
                'placeholder'   => 'Example: 5',
                'pattern'   => '^[0-9]+([.][0-9]+)?$',
                'dependency' => [
                    'field' => 'popup-onpageload',
                    'val' => [true, 'true']
                ]
            ]
        );

        $pixfortBuilder->addOption(
            'popup-onpageexit',
            [
                'type'             => 'checkbox',
                'tab'             => 'triggers',
                'label'         => __('Show Popup on Page Exit', 'pixfort-core'),
                'description' => __('Popup will show when the user cursor exit the browser window.', 'pixfort-core'),
                'default'         => '0',
                'options'        => array('1' => 'On', '0' => 'Off'),
            ]
        );

        $pixfortBuilder->addOption(
            'popup-onscroll',
            [
                'type'             => 'checkbox',
                'tab'             => 'triggers',
                'label'         => __('Show Popup on Scroll', 'pixfort-core'),
                'default'         => '0',
                'options'        => array('1' => 'On', '0' => 'Off'),
                'description'     => __('Popup will show when scrolling the page.', 'pixfort-core'),
            ]
        );
        $pixfortBuilder->addOption(
            'popup-onscroll-percentage',
            [
                'type' => 'range',
                'label' => __('On Scroll Percentage', 'pixfort-core'),
                'description' => __('Show popup when scrolling a specific percentage of the page.', 'pixfort-core'),
                'default' => '50',
                'tab'             => 'triggers',
                'min'             => '0',
                'max'             => '100',
                'dependency' => [
                    'field' => 'popup-onscroll',
                    'val' => [true, 'true']
                ]
            ]
        );

        $pixfortBuilder->addOption(
            'popup-onscrollelement',
            [
                'type'             => 'checkbox',
                'tab'             => 'triggers',
                'label'         => __('Show Popup on Scroll to Element', 'pixfort-core'),
                'default'         => '0',
                'options'        => array('1' => 'On', '0' => 'Off'),
                'description' => __('Popup will show when the user reaches a specific element in the page.', 'pixfort-core'),
                'tooltipText'   => 'If this option is enabled, you need to enter the element selector in the option below (Element Selector).',
            ]
        );
        $pixfortBuilder->addOption(
            'popup-onscrollelement-selector',
            [
                'type' => 'text',
                'label' => __('Element Selector', 'pixfort-core'),
                'default' => '',
                'tab'             => 'triggers',
                'description' => __('Input the selector of the element (css selector).', 'pixfort-core'),
                'tooltipText'   => 'CSS selectors define the pattern to select elements to which a set of CSS rules are then applied. <br/> For more information about <strong>CSS selectors</strong> you can check <a href="https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_Selectors" target="_blank"><strong>this article.</strong></a>',
                'placeholder'   => __('Example: .class', 'pixfort-core'),
                'dependency' => [
                    'field' => 'popup-onscrollelement',
                    'val' => [true, 'true']
                ]
            ]
        );
        $pixfortBuilder->addOption(
            'pix-enable-showtimes',
            [
                'type'             => 'checkbox',
                'tab'             => 'triggers',
                'label'         => __('Display up to X times', 'pixfort-core'),
                'tooltipText'   => __('When enabling this option, you can choose how many times you want to show the popup for each user (each popup dismiss counts as 1 time).', 'pixfort-core'),
                'default'         => '0',
                'options'        => array('1' => 'On', '0' => 'Off'),
                'description'     => __('The popup will be displayed a specific number of times for each user (each popup dismiss counts as 1 time).', 'pixfort-core'),
                'dependency'        => [
                    'fields'             => ['popup-onpageload', 'popup-onpageexit', 'popup-onscroll', 'popup-onscrollelement'],
                    'val'               => ['true', true]
                ]
            ]
        );

        $pixfortBuilder->addOption(
            'pix-showtimes',
            [
                'type' => 'range',
                'label' => __('Display Count', 'pixfort-core'),
                'tooltipText'   => __('For example, if you set this display count to 3 the popup will be shown to each user 3 times (each popup dismiss counts as 1 time).', 'pixfort-core'),
                'default' => '1',
                'tab'             => 'triggers',
                'min'             => '1',
                'max'             => '100',
                'description' => __('How many times to show the popup for each user.', 'pixfort-core'),
                'dependency'        => [
                    'field'             => 'pix-enable-showtimes',
                    'val'               => ['true', true]
                ]
            ]
        );
        $pixfortBuilder->addOption(
            'pix-popup-id',
            [
                'type' => 'pixid',
                'label' => __('Reset Display Count', 'pixfort-core'),
                'description' => __('The reset display count will apply to all users.', 'pixfort-core'),
                'default' => '',
                'auto' => false,
                'tab'             => 'triggers',
                'dependency'        => [
                    'field'             => 'pix-enable-showtimes',
                    'val'               => ['true', true]
                ]
            ]
        );
        $pixfortBuilder->addOption(
            'popup-openfromlink',
            [
                'type' => 'text',
                'label' => __('Open from Link', 'pixfort-core'),
                'default' => '0',
                'hideBorderBottom'  => true,
                'tab'             => 'triggers',
                'description' => __('Copy this popup link to open it from any link in your site.', 'pixfort-core'),
                'tooltipText'   => __('To open the popup from any link in your website, copy the popup link and paste it in the desired link field in your website.', 'pixfort-core'),
                'placeholder'   => '',
                'value' => '#pix_popup_' . get_the_ID(),
                'readOnly'  => true,
                'copy'  => 'true',
            ]
        );

        /*
        * Position
        */
        $pixfortBuilder->addOption(
            'pix-heading-position',
            [
                'type'             => 'heading',
                'label'         => __('Position', 'pixfort-core'),
                'tab'             => 'design',
                'icon'            => 'position'
            ]
        );
        $pixfortBuilder->addOption(
            'pix-position-alert',
            [
                'type'             => 'alert',
                'label'         => __('Popup position is attached to Launcher', 'pixfort-core'),
                'tab'             => 'design',
                'description'     => __('The popup position is set to <strong>"Attach Popup to Launcher"</strong> in the <strong>Launcher</strong> tab. Therefore, the Horizontal and Vertical positions below will be ignored in the pages that contain the popup launcher.', 'pixfort-core'),
                'hidePaddingBottom' => true,
                'style' => 'clean',
                'icon'  =>  'info',
                'dependency'        => [
                    'field'             => 'pix-attach-popup-launcher',
                    'val'               => ['true', true]
                ]
            ]
        );
        $pixfortBuilder->addOption(
            'pix-popup-position-x',
            [
                'type' => 'radio',
                'label' => __('Horizontal Position', 'pixfort-core'),
                'default' => 'popup-horizontal-center',
                'tab'             => 'design',
                'description' => __('Choose popup horizontal position.', 'pixfort-core'),
                'options'        => array(
                    [
                        'name'            => 'Left',
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/thumbnails/position/popup-horizontal-left.svg',
                        'value'            => 'popup-horizontal-left'
                    ],
                    [
                        'name'            => 'Center',
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/thumbnails/position/popup-horizontal-center.svg',
                        'value'            => 'popup-horizontal-center'
                    ],
                    [
                        'name'            => 'Right',
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/thumbnails/position/popup-horizontal-right.svg',
                        'value'            => 'popup-horizontal-right'
                    ]
                )
            ]
        );
        $pixfortBuilder->addOption(
            'pix-popup-position-y',
            [
                'type' => 'radio',
                'label' => __('Vertical Position', 'pixfort-core'),
                'default' => 'popup-vertical-center',
                'tab'             => 'design',
                'description' => __('Choose popup vertical position.', 'pixfort-core'),
                'options'        => array(
                    [
                        'name'            => 'Top',
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/thumbnails/position/popup-vertical-top.svg',
                        'value'            => 'popup-vertical-top'
                    ],
                    [
                        'name'            => 'Center',
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/thumbnails/position/popup-vertical-center.svg',
                        'value'            => 'popup-vertical-center'
                    ],
                    [
                        'name'            => 'Bottom',
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/thumbnails/position/popup-vertical-bottom.svg',
                        'value'            => 'popup-vertical-bottom'
                    ]
                )
            ]
        );
        $pixfortBuilder->addOption(
            'popup-padding',
            [
                'type' => 'range',
                'label' => __('Popup Margin', 'pixfort-core'),
                'description' => __('The spacing around the popup (in pixels).', 'pixfort-core'),
                'responsive' => true,
                'hideBorderBottom'  => true,
                'tooltipText'   => __('The popup margin is used mainly to add space between the popup and the browser edges, especially when the popup is aligned to one of the browser edges.', 'pixfort-core'),
                'tooltipImage'   => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/tooltips/popup-tooltip-popup-margin.png',
                'tab'             => 'design',
                'min'             => '0',
                'max'             => '100',
            ]
        );

        $pixfortBuilder->addOption(
            'pix-heading-style',
            [
                'type'             => 'heading',
                'label'         => __('Style', 'pixfort-core'),
                'tab'             => 'design',
                'icon'            => 'style'
            ]
        );

        $pixfortBuilder->addOption(
            'pix-popup-shadow',
            [
                'type' => 'radio',
                'label' => __('Shadow', 'pixfort-core'),
                'default' => 'popup-shadow-none',
                'tab'             => 'design',
                'description' => __('Choose popup shadow.', 'pixfort-core'),
                'options'        => array(
                    [
                        'name'            => __('None', 'pixfort-core'),
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/thumbnails/shadows/popup-shadow-none.svg',
                        'value'            => 'popup-shadow-none'
                    ],
                    [
                        'name'            => __('Small', 'pixfort-core'),
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/thumbnails/shadows/popup-shadow-small.svg',
                        'value'            => 'popup-shadow-small'
                    ],
                    [
                        'name'            => __('Medium', 'pixfort-core'),
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/thumbnails/shadows/popup-shadow-medium.svg',
                        'value'            => 'popup-shadow-medium'
                    ],
                    [
                        'name'            => __('Large', 'pixfort-core'),
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/thumbnails/shadows/popup-shadow-large.svg',
                        'value'            => 'popup-shadow-large'
                    ]
                )
            ]
        );
        $pixfortBuilder->addOption(
            'popup-background-color',
            [
                'type'             => 'select',
                'label'         => __('Background Color', 'pixfort-core'),
                'default'         => 'transparent',
                'tab'             => 'design',
                // 'options' => \PixfortCore::instance()->coreFunctions->getColorsArray(['blur' => true,'lightBasicText' => true, 'transparent' => true, 'dynamicBlur' => true]),
                'options' => \PixfortCore::instance()->coreFunctions->getColorsArray(['lightBasicText' => true, 'transparent' => true]),
                'groups' => true,
            ]
        );
        $pixfortBuilder->addOption(
            'popup-background-custom-color',
            [
                'type'             => 'color',
                'tab'             => 'design',
                'label'         => __('Background Custom Color', 'pixfort-core'),
                'default'         => '#fff',
                'disableAlpha'         => false,
                'dependency' => [
                    'field' => 'popup-background-color',
                    'val' => ['custom']
                ]
            ]
        );
        $pixfortBuilder->addOption(
            'popup-border-radius',
            [
                'type' => 'range',
                'label' => __('Border Radius', 'pixfort-core'),
                'responsive' => true,
                'default' => [
                    'desktop'   => '0'
                ],
                'tab'             => 'design',
                'min'             => '0',
                'max'             => '100',
            ]
        );
        $pixfortBuilder->addOption(
            'pix-overflow-visible',
            [
                'type'              => 'checkbox',
                'tab'               => 'design',
                'label'             => __('Visible Content Overflow', 'pixfort-core'),
                'default'           => '',
                'description'       => __('Make the content that overflow outside the popup visible instead of hiding it.', 'pixfort-core'),
                'options'           => array('1' => 'On', '0' => 'Off'),
            ]
        );
        $pixfortBuilder->addOption(
            'pix-popup-animation',
            [
                'type'             => 'select',
                'label'         => __('Popup Animation', 'pixfort-core'),
                'default'         => 'animation-none',
                'hideBorderBottom'  => true,
                'tab'             => 'design',
                'options'        => array(
                    'animation-none'            => __('None', 'pixfort-core'),
                    'animation-scale'            => __('Scale', 'pixfort-core'),
                    'animation-fade'            => __('Fade in', 'pixfort-core'),
                    'animation-fade-in-left'   => __('Fade in left', 'pixfort-core'),
                    'animation-fade-in-right'   => __('Fade in right', 'pixfort-core'),
                    'animation-fade-in-up'   => __('Fade in up', 'pixfort-core'),
                    'animation-fade-in-down'   => __('Fade in down', 'pixfort-core'),
                    'animation-fade-in-bottom-left'   => __('Fade in bottom left', 'pixfort-core'),
                    'animation-fade-in-bottom-right'   => __('Fade in bottom right', 'pixfort-core'),
                    'animation-fade-in-top-left'   => __('Fade in top left', 'pixfort-core'),
                    'animation-fade-in-top-right'   => __('Fade in top right', 'pixfort-core'),
                ),
            ]
        );
        /*
        * Backdrop
        */
        $pixfortBuilder->addOption(
            'pix-heading-backdrop',
            [
                'type'             => 'heading',
                'label'         => __('Backdrop', 'pixfort-core'),
                'tab'             => 'design',
                'icon'            => 'canvas'
            ]
        );
        $pixfortBuilder->addOption(
            'pix-disable-backdrop',
            [
                'type'              => 'checkbox',
                'tab'               => 'design',
                'label'             => __('Disable Popup Backdrop', 'pixfort-core'),
                'default'           => '0',
                'hideBorderBottom'  => true,
                'description'       => __('If the backdrop is disabled the page content in the background will be accessible while the popup is opened.', 'pixfort-core'),  
                'tooltipText'   => '<strong>'.__('Popup Backdrop', 'pixfort-core').'</strong> '. __('is the overlay layer that appears behind the popup.', 'pixfort-core'),
                'tooltipImage'   => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/tooltips/popup-tooltip-popup-backdrop.png',
                'options'           => array('1' => 'On', '0' => 'Off'),
            ]
        );
        $pixfortBuilder->addOption(
            'popup-backdrop-color',
            [
                'type'              => 'select',
                'label'             => __('Backdrop Color', 'pixfort-core'),
                'default'           => 'dark-opacity-8',
                'tab'               => 'design',
                'options' => \PixfortCore::instance()->coreFunctions->getColorsArray(['blur' => true,'lightBasicText' => true, 'transparent' => true, 'dynamicBlur' => true]),
                'groups' => true,
                'showBorderTop'   => true,
                'dependency'        => [
                    'field'             => 'pix-disable-backdrop',
                    'val'               => ['1', true, 'true'],
                    'op'                => '!='
                ]
            ]
        );
        $pixfortBuilder->addOption(
            'popup-backdrop-custom-color',
            [
                'type'              => 'color',
                'tab'               => 'design',
                'label'             => __('Backdrop Custom Color', 'pixfort-core'),
                'default'           => 'rgba(0,0,0,0.8)',
                'disableAlpha'      => false,
                'dependency'        => [
                    'field'             => 'popup-backdrop-color',
                    'val'               => ['custom']
                ]
            ]
        );
        $pixfortBuilder->addOption(
            'popup-backdrop-blur',
            [
                'type' => 'range',
                'label' => __('Backdrop Blur', 'pixfort-core'),
                'tooltipText'   => __('Applies a Gaussian blur to the backdrop.', 'pixfort-core'),
                'tab'             => 'design',
                'min'             => '0',
                'max'             => '100',
                'dependency'        => [
                    'field'             => 'pix-disable-backdrop',
                    'val'               => ['1', true, 'true'],
                    'op'                => '!='
                ]
            ]
        );
        $pixfortBuilder->addOption(
            'pix-backdrop-disable-close',
            [
                'type'              => 'checkbox',
                'tab'               => 'design',
                'label'             => __('Disable Popup Backdrop Close', 'pixfort-core'),
                'default'           => '',
                'hideBorderBottom'  => true,
                'description'       => __('By default clicking on the Backdrop will close the Popup, enable this option if you want to prevent closing the popup.', 'pixfort-core'),
                'options'           => array('1' => 'On', '0' => 'Off'),
                'dependency'        => [
                    'field'             => 'pix-disable-backdrop',
                    'val'               => ['1', true, 'true'],
                    'op'                => '!='
                ]
            ]
        );
        /*
        * Close
        */
        $pixfortBuilder->addOption(
            'pix-heading-close',
            [
                'type'             => 'heading',
                'label'         => __('Close Button', 'pixfort-core'),
                'tab'             => 'design',
                'icon'            => 'cross'
            ]
        );
        $pixfortBuilder->addOption(
            'pix-popup-close-x',
            [
                'type'              => 'radio',
                'label'             => __('Close Button Align', 'pixfort-core'),
                'default'           => 'popup-close-right',
                'tab'               => 'design',
                'description'       => __('Choose the close button align.', 'pixfort-core'),
                'options'           => array(
                    [
                        'name'          => __('None', 'pixfort-core'),
                        'image'         => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/thumbnails/close/popup-close-none.svg',
                        'value'         => 'popup-close-none'
                    ],
                    [
                        'name'          => __('Left', 'pixfort-core'),
                        'image'         => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/thumbnails/close/popup-close-left.svg',
                        'value'         => 'popup-close-left'
                    ],
                    [
                        'name'          => __('Right', 'pixfort-core'),
                        'image'         => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/thumbnails/close/popup-close-inside.svg',
                        'value'         => 'popup-close-right'
                    ],
                ),
            ]
        );
        $pixfortBuilder->addOption(
            'pix-popup-close-y',
            [
                'type'              => 'radio',
                'label'             => __('Close Button Position', 'pixfort-core'),
                'default'           => 'popup-close-ouside',
                'tab'               => 'design',
                'checkPosition'     => 'left',
                'description'       => __('Choose the close button position.', 'pixfort-core'),
                'options'           => array(
                    [
                        'name'          => __('Outside', 'pixfort-core'),
                        'image'         => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/thumbnails/close/popup-close-outside.svg',
                        'value'         => 'popup-close-ouside'
                    ],
                    [
                        'name'          => __('Inside', 'pixfort-core'),
                        'image'         => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/thumbnails/close/popup-close-inside.svg',
                        'value'         => 'popup-close-inside'
                    ],
                ),
                'dependency'             => [
                    'field'                 => 'pix-popup-close-x',
                    'val'                   => ['popup-close-left', 'popup-close-right']
                ]
            ]
        );
        if(PixfortCore::instance()->dynamicColors) {
            $pixfortBuilder->addOption(
                'popup-close-color',
                [
                    'type'              => 'color',
                    'tab'               => 'design',
                    'label'             => __('Close Icon Color', 'pixfort-core'),
                    'default'           => '#eee',
                    'dynamic'           => true,
                    'description' => __('Choose the icon color for the close button.', 'pixfort-core'),
                    'disableAlpha'      => false,
                    'dependency'        => [
                        'field'             => 'pix-popup-close-x',
                        'val'               => ['popup-close-left', 'popup-close-right']
                    ]
                ]
            );
        } else {
            $pixfortBuilder->addOption(
                'popup-close-color',
                [
                    'type'              => 'color',
                    'tab'               => 'design',
                    'label'             => __('Close Icon Color', 'pixfort-core'),
                    'default'           => '#eee',
                    'description' => __('Choose the icon color for the close button.', 'pixfort-core'),
                    'disableAlpha'      => false,
                    'dependency'        => [
                        'field'             => 'pix-popup-close-x',
                        'val'               => ['popup-close-left', 'popup-close-right']
                    ]
                ]
            );    
        }
        
        $pixfortBuilder->addOption(
            'pix-close-icon',
            [
                'type' => 'radio',
                'label' => __('Close Button Icon', 'pixfort-core'),
                'hideBorderBottom'  => true,
                'default' => 'line/pixfort-icon-cross-1',
                'tab'             => 'design',
                'description' => __('Choose the icon for the close button.', 'pixfort-core'),
                'disableCheck'  => true,
                'options'        => array(
                    [
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/backend-icons/line/pixfort-icon-cross-1.svg',
                        'value'            => 'line/pixfort-icon-cross-1'
                    ],
                    [
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/backend-icons/colored/pixfort-icon-cross-circle-1.svg',
                        'value'            => 'colored/pixfort-icon-cross-circle-1'
                    ],
                    [
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/backend-icons/colored/pixfort-icon-cross-square-1.svg',
                        'value'            => 'colored/pixfort-icon-cross-square-1'
                    ],
                    [
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/backend-icons/duotone/pixfort-icon-cross-circle-1.svg',
                        'value'            => 'duotone/pixfort-icon-cross-circle-1'
                    ],
                    [
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/backend-icons/duotone/pixfort-icon-cross-square-1.svg',
                        'value'            => 'duotone/pixfort-icon-cross-square-1'
                    ],
                    [
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/backend-icons/line/pixfort-icon-cross-circle-1.svg',
                        'value'            => 'line/pixfort-icon-cross-circle-1'
                    ],
                    [
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/backend-icons/line/pixfort-icon-cross-square-1.svg',
                        'value'            => 'line/pixfort-icon-cross-square-1'
                    ],
                    [
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/backend-icons/solid/pixfort-icon-cross-circle-1.svg',
                        'value'            => 'solid/pixfort-icon-cross-circle-1'
                    ],
                    [
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/backend-icons/solid/pixfort-icon-cross-square-1.svg',
                        'value'            => 'solid/pixfort-icon-cross-square-1'
                    ],
                    [
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/backend-icons/custom/cross-icon-custom-1.svg',
                        'value'            => 'custom/cross-icon-custom-1'
                    ],
                    [
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/backend-icons/custom/cross-icon-custom-2.svg',
                        'value'            => 'custom/cross-icon-custom-2'
                    ],
                ),
                'dependency'        => [
                    'field'             => 'pix-popup-close-x',
                    'val'               => ['popup-close-left', 'popup-close-right']
                ]
            ]
        );
        $pixfortBuilder->addOption(
            'pix-esc-disable-close',
            [
                'type'              => 'checkbox',
                'tab'               => 'design',
                'label'             => __('Disable Close via Escape Key', 'pixfort-core'),
                'default'           => '',
                'hideBorderBottom'  => true,
                'tooltipText'   => __('By default clicking on the Escape key will close the popup, enable this option if you want to prevent closing the popup using the Escape key.', 'pixfort-core'),
                'description'       => __('Prevent closing the popup via the Escape key.', 'pixfort-core'),
                'options'           => array('1' => 'On', '0' => 'Off'),
            ]
        );
        /*
        * Launcher
        */
        $pixfortBuilder->addOption(
            'pix-enable-launcher',
            [
                'type'             => 'checkbox',
                'tab'             => 'launcher',
                'label'         => __('Enable Popup Launcher', 'pixfort-core'),
                'description' => __('Add popup Launcher to your page.', 'pixfort-core'),
                'hideBorderBottom'  => true,
                'default'         => '0',
                'tooltipText'   => '<strong>Popup Launcher</strong> is a sticky circle button to launch your popup, it can be placed in the bottom right or left corner of the screen. <br><br><strong>Note:</strong> The Launcher will show in the pages specified in the <strong>"Display Conditions"</strong> field in the <strong>General</strong> tab.',
                'tooltipImage'   => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/tooltips/popup-tooltip-launcher.png',
                'options'        => array('1' => 'On', '0' => 'Off'),
            ]
        );
        $pixfortBuilder->addOption(
            'pix-heading-launcher-position',
            [
                'type'             => 'heading',
                'label'         => __('Position', 'pixfort-core'),
                'tab'             => 'launcher',
                'icon'            => 'position',
                'dependency'        => [
                    'field'             => 'pix-enable-launcher',
                    'val'               => ['true', true]
                ]
            ]
        );
        $pixfortBuilder->addOption(
            'pix-launcher-position',
            [
                'type' => 'radio',
                'label' => __('Launcher Position', 'pixfort-core'),
                'default' => 'launcher-bottom-right',
                'tab'             => 'launcher',
                'description' => __('Choose Launcher position.', 'pixfort-core'),
                'options'        => array(
                    [
                        'name'            => __('Left', 'pixfort-core'),
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/thumbnails/launcher-position/launcher-bottom-left.svg',
                        'value'            => 'launcher-bottom-left'
                    ],
                    [
                        'name'            => __('Right', 'pixfort-core'),
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/thumbnails/launcher-position/launcher-bottom-right.svg',
                        'value'            => 'launcher-bottom-right'
                    ]
                ),
                'dependency'        => [
                    'field'             => 'pix-enable-launcher',
                    'val'               => ['true', true]
                ]
            ]
        );
        $pixfortBuilder->addOption(
            'pix-launcher-bottom-value',
            [
                'type' => 'range',
                'label' => __('Launcher Bottom Spacing', 'pixfort-core'),
                'description' => __('The space between the Launcher and bottom of the screen (in pixels).', 'pixfort-core'),
                'responsive' => true,
                'default' => [
                    'desktop'   => '20'
                ],
                'tab'             => 'launcher',
                'min'             => '0',
                'max'             => '200',
                'dependency'        => [
                    'field'             => 'pix-enable-launcher',
                    'val'               => ['true', true]
                ]
            ]
        );
        $pixfortBuilder->addOption(
            'pix-launcher-horizontal-value',
            [
                'type' => 'range',
                'label' => __('Launcher Horizontal Spacing', 'pixfort-core'),
                'description' => __('The space between the Launcher and side of the screen (in pixels).', 'pixfort-core'),
                'responsive' => true,
                'hideBorderBottom'  => false,
                'default' => [
                    'desktop'   => '20'
                ],
                'tab'             => 'launcher',
                'min'             => '0',
                'max'             => '200',
                'dependency'        => [
                    'field'             => 'pix-enable-launcher',
                    'val'               => ['true', true]
                ]
            ]
        );
        $pixfortBuilder->addOption(
            'pix-attach-popup-launcher',
            [
                'type'             => 'checkbox',
                'tab'             => 'launcher',
                'label'         => __('Attach Popup to Launcher', 'pixfort-core'),
                'default'         => '0',
                'options'        => array('1' => 'On', '0' => 'Off'),
                'description'     => __('The popup will be on top of the Launcher automatically depending on the selected Launcher position above.', 'pixfort-core'),
                'tooltipText'   => '<strong>Note:</strong> If this option is enabled, the popup position selected in the <strong>Design tab</strong> will be ignored in the pages that contain the popup launcher.',
                'tooltipImage'   => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/tooltips/popup-tooltip-attach-launcher.png',
                'hideBorderBottom'  => true,
                'dependency'        => [
                    'field'             => 'pix-enable-launcher',
                    'val'               => ['true', true]
                ]
            ]
        );
        $pixfortBuilder->addOption(
            'pix-launcher-in-front',
            [
                'type'             => 'checkbox',
                'tab'             => 'launcher',
                'label'         => __('Display Launcher Above Popup', 'pixfort-core'),
                'showBorderTop'  => true,
                'hideBorderBottom'  => true,
                'default'         => '0',
                'options'        => array('1' => 'On', '0' => 'Off'),
                'description'     => __('The Launcher button will be visible above the popup in case of overlap.', 'pixfort-core'),
                'tooltipText'   => 'If this option is enabled, the Launcher will still be visible in case of an overlap with the popup and it will be above the popup backdrop.',
                'tooltipImage'   => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/tooltips/popup-tooltip-launcher-above-popup.png',
                'dependency'        => [
                    'field'             => 'pix-attach-popup-launcher',
                    'val'               => ['false', false]
                ]
            ]
        );
        $pixfortBuilder->addOption(
            'pix-heading-launcher-logo',
            [
                'type'             => 'heading',
                'label'         => __('Logo', 'pixfort-core'),
                'tab'             => 'launcher',
                'icon'            => 'logo',
                'dependency'        => [
                    'field'             => 'pix-enable-launcher',
                    'val'               => ['true', true]
                ]
            ]
        );
        $pixfortBuilder->addOption(
            'pix-launcher-logo',
            [
                'type' => 'radio',
                'label' => __('Launcher Logo', 'pixfort-core'),
                'default' => 'launcher-logo-icon',
                'hideBorderBottom'  => true,
                'tab'             => 'launcher',
                'description' => __('Choose Launcher Logo.', 'pixfort-core'),
                'options'        => array(
                    [
                        'name'            => __('Default Icons', 'pixfort-core'),
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/thumbnails/launcher-logo/popup-launcher-default-icons.svg',
                        'value'            => 'launcher-logo-icon'
                    ],
                    [
                        'name'            => __('Custom Logo', 'pixfort-core'),
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/thumbnails/launcher-logo/popup-launcher-custom-logo.svg',
                        'value'            => 'launcher-logo-image'
                    ],

                ),
                'dependency'        => [
                    'field'             => 'pix-enable-launcher',
                    'val'               => ['true', true]
                ]
            ]
        );
        $pixfortBuilder->addOption(
            'pix-launcher-icon',
            [
                'type' => 'radio',
                'label' => __('Launcher Logo', 'pixfort-core'),
                'default' => 'line/pixfort-icon-bolt-1',
                'showBorderTop'  => true,
                'hideBorderBottom'  => true,
                'tab'             => 'launcher',
                'description' => __('Choose from the available default icons below.', 'pixfort-core'),
                'options'        => array(
                    [
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/backend-icons/line/pixfort-icon-bolt-1.svg',
                        'value'            => 'line/pixfort-icon-bolt-1'
                    ],
                    [
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/backend-icons/line/pixfort-icon-chat-left-1.svg',
                        'value'            => 'line/pixfort-icon-chat-left-1'
                    ],
                    [
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/backend-icons/line/pixfort-icon-mail-closed-1.svg',
                        'value'            => 'line/pixfort-icon-mail-closed-1'
                    ],
                    [
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/backend-icons/line/pixfort-icon-menu-1.svg',
                        'value'            => 'line/pixfort-icon-menu-1'
                    ],
                    [
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/backend-icons/line/pixfort-icon-menu-2.svg',
                        'value'            => 'line/pixfort-icon-menu-2'
                    ],
                    [
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/backend-icons/line/pixfort-icon-question-mark-1.svg',
                        'value'            => 'line/pixfort-icon-question-mark-1'
                    ],
                    [
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/backend-icons/line/pixfort-icon-question-mark-circle-1.svg',
                        'value'            => 'line/pixfort-icon-question-mark-circle-1'
                    ],
                    [
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/backend-icons/line/pixfort-icon-social-share-1.svg',
                        'value'            => 'line/pixfort-icon-social-share-1'
                    ],
                    [
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/backend-icons/line/pixfort-icon-support-help-1.svg',
                        'value'            => 'line/pixfort-icon-support-help-1'
                    ],
                    [
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/backend-icons/line/pixfort-icon-telephone-1.svg',
                        'value'            => 'line/pixfort-icon-telephone-1'
                    ],
                    [
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/backend-icons/line/pixfort-icon-user-circle-1.svg',
                        'value'            => 'line/pixfort-icon-user-circle-1'
                    ],
                    [
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/backend-icons/line/pixfort-icon-search-2.svg',
                        'value'            => 'line/pixfort-icon-search-2'
                    ],
                    [
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/backend-icons/line/pixfort-icon-bag-1.svg',
                        'value'            => 'line/pixfort-icon-bag-1'
                    ],
                    [
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/backend-icons/line/pixfort-icon-cart-1.svg',
                        'value'            => 'line/pixfort-icon-cart-1'
                    ],
                ),
                'dependency'        => [
                    'field'             => 'pix-launcher-logo',
                    'val'               => ['launcher-logo-icon']
                ]
            ]
        );
        $pixfortBuilder->addOption(
            'pix-launcher-logo-image',
            [
                'type'             => 'image',
                'label'         => 'Launcher Custom Logo',
                'default'         => '',
                'local'         => true,
                'tab'             => 'launcher',
                'description'     => __('Select an image for the Launcher. For best results use square images (at least 80x80px).', 'pixfort-core'),
                'tooltipText'   => 'Personalize the Launcher by uploading your own custom image.<br><strong>Use square images for best results.</strong>',
                'tooltipImage'   => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/tooltips/popup-tooltip-launcher-custom-logo.png',
                'showBorderTop'   => true,
                'dependency'        => [
                    'field'             => 'pix-launcher-logo',
                    'val'               => ['launcher-logo-image']
                ]
            ]
        );
        $pixfortBuilder->addOption(
            'pix-launcher-logo-padding',
            [
                'type' => 'range',
                'label' => 'Launcher Logo Padding',
                'default' => '',
                'hideBorderBottom'  => true,
                'tab'             => 'launcher',
                'description' => __('Choose Launcher Logo padding.', 'pixfort-core'),
                'min'             => '0',
                'max'             => '20',
                'tooltipText'   => 'The padding around the custom logo image in the Launcher.',
                'tooltipImage'   => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/tooltips/popup-tooltip-launcher-logo-padding.png',
                'dependency'        => [
                    'field'             => 'pix-launcher-logo',
                    'val'               => ['launcher-logo-image']
                ]
            ]
        );
        $pixfortBuilder->addOption(
            'pix-heading-launcher-style',
            [
                'type'             => 'heading',
                'label'         => __('Style', 'pixfort-core'),
                'tab'             => 'launcher',
                'icon'            => 'style',
                'dependency'        => [
                    'field'             => 'pix-enable-launcher',
                    'val'               => ['true', true]
                ]
            ]
        );
        $pixfortBuilder->addOption(
            'pix-launcher-background-color',
            [
                'type'             => 'select',
                'label'         => __('Launcher Background Color', 'pixfort-core'),
                'default'         => 'white',
                'tab'             => 'launcher',
                'options' => \PixfortCore::instance()->coreFunctions->getColorsArray(['blur' => true,'lightBasicText' => true, 'transparent' => true]),
                'groups' => true,
                'dependency'        => [
                    'field'             => 'pix-enable-launcher',
                    'val'               => ['true', true]
                ]
            ]
        );
        $pixfortBuilder->addOption(
            'pix-launcher-background-custom-color',
            [
                'type'             => 'color',
                'tab'             => 'launcher',
                'label'         => __('Background Custom Color', 'pixfort-core'),
                'default'         => 'rgba(255,255,255,1)',
                'disableAlpha'         => false,
                'dependency' => [
                    'field' => 'pix-launcher-background-color',
                    'val' => ['custom']
                ]
            ]
        );
        $pixfortBuilder->addOption(
            'pix-launcher-icon-color',
            [
                'type'             => 'select',
                'label'         => __('Launcher Icon Color', 'pixfort-core'),
                'default'         => 'primary',
                'tab'             => 'launcher',
                'tooltipText'   => __('The color of the Launcher icon in case of using one of the default icons, in addition to the color of the close icon of the Launcher.', 'pixfort-core'),
                'options' => \PixfortCore::instance()->coreFunctions->getColorsArray(['blur' => true,'lightBasicText' => true, 'transparent' => true]),
                'groups' => true,
                'dependency'        => [
                    'field'             => 'pix-enable-launcher',
                    'val'               => ['true', true]
                ]
            ]
        );
        $pixfortBuilder->addOption(
            'pix-launcher-icon-custom-color',
            [
                'type'             => 'color',
                'tab'             => 'launcher',
                'label'         => __('Icon Custom Color', 'pixfort-core'),
                'default'         => '#333',
                'disableAlpha'         => false,
                'dependency' => [
                    'field' => 'pix-launcher-icon-color',
                    'val' => ['custom']
                ]
            ]
        );
        $pixfortBuilder->addOption(
            'pix-popup-launcher-shadow',
            [
                'type' => 'radio',
                'label' => __('Launcher Shadow', 'pixfort-core'),
                'default' => 'launcher-shadow-none',
                'hideBorderBottom'  => true,
                'tab'             => 'launcher',
                'description' => __('Choose Launcher shadow.', 'pixfort-core'),
                'options'        => array(
                    [
                        'name'            => __('None', 'pixfort-core'),
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/thumbnails/launcher-shadows/popup-launcher-shadow-none.svg',
                        'value'            => 'launcher-shadow-none'
                    ],
                    [
                        'name'            => __('Small', 'pixfort-core'),
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/thumbnails/launcher-shadows/popup-launcher-shadow-small.svg',
                        'value'            => 'launcher-shadow-small'
                    ],
                    [
                        'name'            => __('Medium', 'pixfort-core'),
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/thumbnails/launcher-shadows/popup-launcher-shadow-medium.svg',
                        'value'            => 'launcher-shadow-medium'
                    ],
                    [
                        'name'            => __('Large', 'pixfort-core'),
                        'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/thumbnails/launcher-shadows/popup-launcher-shadow-large.svg',
                        'value'            => 'launcher-shadow-large'
                    ]
                ),
                'dependency'        => [
                    'field'             => 'pix-enable-launcher',
                    'val'               => ['true', true]
                ]
            ]
        );
        $pixfortBuilder->addOption(
            'pix-display-devices',
            [
                'type' => 'multi-select',
                'label' => __('Display on Devices', 'pixfort-core'),
                'tab'             => 'advanced',
                'placeholder'   => __('All Devices', 'pixfort-core'),
                'options' => [
                    [
                        'name'            => __('Desktop', 'pixfort-core'),
                        'value'            => 'desktop'
                    ],
                    [
                        'name'            => __('Tablet', 'pixfort-core'),
                        'value'            => 'tablet'
                    ],
                    [
                        'name'            => __('Mobile', 'pixfort-core'),
                        'value'            => 'mobile'
                    ]
                ],
                'description' => __('Choose on which screen sizes the popup will be displayed by the triggers.', 'pixfort-core'),
                'tooltipText'       => '<strong>Note:</strong> The display on devices option concerns all the triggers except "<strong>Open from Link</strong>" which will open the popup from any device size. <br><br>
                <strong>Tip:</strong> The Responsive Breakpoints are:<br>
                    <strong>Desktop</strong> ≥ 1024px <br>
                    1024px > <strong>Tablet</strong> ≥ 576px <br>
                    576px &#62; <strong>Mobile</strong>',
            ]
        );
        
        $docsPopupCustomCssLink = \PixfortCore::instance()->adminCore->getParam('docs_popup_custom_css');
        $pixfortBuilder->addOption(
            'popup-custom-css',
            [
                'type'             => 'code',
                'tab'             => 'advanced',
                'label'         => __('Custom CSS', 'pixfort-core'),
                'hideBorderBottom'  => true,
                'default'         => '',
                'description'     => __('Add custom CSS to be loaded with the Popup.', 'pixfort-core'),
                'tooltipText'   => __('To apply the custom css only in this Popup please make sure to add the Popup class:</br> <strong>.pix-popup-' . get_the_ID() . '</strong> before any css statement.</br></br>For more information please check <a href="'.$docsPopupCustomCssLink.'" target="_blank"><strong>this article</strong></a> from our knowledge base.', 'pixfort-core'),
            ]
        );
        $pixfortBuilder->loadOptionsData();
        echo '<div id="fu3obnz"></div>';
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    }

    /*-----------------------------------------------------------------------------------*/
    /*	Save data when page is edited
    /*-----------------------------------------------------------------------------------*/
    public function pix_pixpopup_save_data($post_id) {
        global $pix_pixpopup_meta_box;
        // verify nonce
        if (key_exists('pix_page_meta_nonce', $_POST)) {
            if (!wp_verify_nonce($_POST['pix_page_meta_nonce'], basename(__FILE__))) {
                return $post_id;
            }
        }
        // check autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }
        // check permissions
        if ((key_exists('post_type', $_POST)) && ('page' == $_POST['post_type'])) {
            if (!current_user_can('edit_page', $post_id)) {
                return $post_id;
            }
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }
        // check and save fields ( $pix_pixpopup_meta_box['fields'] )
        if (!empty($pix_pixpopup_meta_box)) {
            foreach ((array)$pix_pixpopup_meta_box['fields'] as $field) {
                $old = get_post_meta($post_id, $field['id'], true);
                if (key_exists($field['id'], $_POST)) {
                    $new = $_POST[$field['id']];
                } else {
                    // $new = ""; // problem with "quick edit"
                    if (!empty($field['type']) && $field['type'] == 'switch') {
                        $new = '0';
                    } else {
                        continue;
                    }
                }

                if (isset($new) && $new != $old) {
                    update_post_meta($post_id, $field['id'], $new);
                } elseif ('' == $new && $old) {
                    delete_post_meta($post_id, $field['id'], $old);
                }
            }
            PixfortCore::instance()->areasCache->refreshPostConditions('popup', $post_id, 'popup-condition');
            $this->generatePopupData($post_id);
            $transientID = 'pixpopup_' . $post_id;
            delete_transient($transientID);
        }
    }

    public function generatePopupData($popup) {
        $data = [
            'popupOptions' => [],
            'popupClasses' => [],
            'launcherOptions' => [],
            'launcherClasses' => [],
        ];
        $itemOptions = [];
        /*
        * Migration from old options
        */
        $oldSizes = array(
            'col-12 col-sm-4'            => 'popup-width-xs',
            'col-12 col-sm-6'            => 'popup-width-sm',
            'col-12 col-sm-8'            => 'popup-width-md',
            'col-12 col-sm-10'           => 'popup-width-lg',
            'col-12'                     => 'popup-width-xl',
        );
        if(!metadata_exists('post', $popup, 'pix-popup-width')){ 
			if ($popupSize = get_post_meta($popup, 'pix-popup-size', true)) {
				if (array_key_exists($popupSize, $oldSizes)) {
					$newPopupWidth = $oldSizes[$popupSize];
					update_post_meta($popup, 'pix-popup-width', $newPopupWidth);
				}
			}
		}

        $onpageload = get_post_meta($popup, 'popup-onpageload', true);
        if ($onpageload && $onpageload !== 'false') {
            $showAfter = 0;
            $showAfterValue = get_post_meta($popup, 'popup-onpageload-after', true);
            if ($showAfterValue) {
                $showAfter = 1000 * (int) $showAfterValue;
            }
            $itemOptions['onpageload'] = [
                'value'         => true,
                'showAfter'    => $showAfter
            ];
        }

        $onpageexit = get_post_meta($popup, 'popup-onpageexit', true);
        if ($onpageexit && $onpageexit !== 'false') {
            $itemOptions['onpageexit'] = true;
        }

        if (get_post_meta($popup, 'pix-enable-showtimes', true) && get_post_meta($popup, 'pix-enable-showtimes', true) !== 'false') {
            if ($showTimes = get_post_meta($popup, 'pix-showtimes', true)) {
                $itemOptions['showTimes'] = $showTimes;
            }
        }
        if ($popupDevices = get_post_meta($popup, 'pix-display-devices', true)) {
            $itemOptions['popupDevices'] = $popupDevices;
        }
        if (get_post_meta($popup, 'popup-onscroll', true) && get_post_meta($popup, 'popup-onscroll', true) !== 'false') {
            if ($popupScrollPercentage = get_post_meta($popup, 'popup-onscroll-percentage', true)) {
                $itemOptions['onscroll'] = $popupScrollPercentage;
            } else {
                $itemOptions['onscroll'] = '0';
            }
        }

        $onscrollelement = get_post_meta($popup, 'popup-onscrollelement', true);
        if ($onscrollelement && $onscrollelement !== 'false') {
            $scrollSelector = get_post_meta($popup, 'popup-onscrollelement-selector', true);
            if ($scrollSelector) {
                $itemOptions['onscrollelement'] = [
                    'value'         => 'true',
                    'scrollSelector'    => $scrollSelector
                ];
            }
        }
        // $popupCssVars = [
        //     'popup-close-color' =>  '--pix-dialog-close-color',
        // ];
        $itemOptions['customStyle'] = [];
        // foreach ($popupCssVars as $key => $value) {
        //     if ($varValue = get_post_meta($popup, $key, true)) {
        //         $itemOptions['customStyle'][$value] = $varValue;
        //     }
        // }
        if ($closeColorValue = get_post_meta($popup, 'popup-close-color', true)) {
            // Try to parse as JSON first
            $parsedValue = null;
            if (is_string($closeColorValue)) {
                $parsedValue = json_decode($closeColorValue);
            }
            
            // If it's a valid JSON object with a light property, use that
            if (is_object($parsedValue) && !empty($parsedValue->light)) {
                $itemOptions['customStyle']['--pix-dialog-close-color'] = $parsedValue->light;
                if(!empty($parsedValue->dark)) {
                    $itemOptions['customStyle']['--pix-dialog-close-color-dark'] = $parsedValue->dark;
                } else {
                    $itemOptions['customStyle']['--pix-dialog-close-color-dark'] = $parsedValue->light;
                }
            } else {
                // Otherwise use the value directly
                $itemOptions['customStyle']['--pix-dialog-close-color'] = $closeColorValue;
                $itemOptions['customStyle']['--pix-dialog-close-color-dark'] = $closeColorValue;
            }
        }
        $responsiveOptions = [
            'popup-border-radius' => '--pix-dialog-border-radius',
            'popup-height-custom' =>  '--pix-dialog-height',
            'popup-padding' => '--pix-dialog-padding',
            'pix-launcher-bottom-value' => '--pix-launcher-bottom-value'
        ];
        $withoutPx = ['popup-height-custom'];
        foreach ($responsiveOptions as $key => $value) {
            if ($varValue = get_post_meta($popup, $key, true)) {
                $unit = 'px';
                if (in_array($key, $withoutPx)) $unit = '';
                try {
                    $optionArray = json_decode($varValue);
                    if ($optionArray) {
                        if (property_exists($optionArray, 'desktop') && isset($optionArray->desktop) && $optionArray->desktop !== '') {
                            $itemOptions['customStyle'][$value] = $optionArray->desktop . $unit;
                        }
                        if (property_exists($optionArray, 'tablet') && isset($optionArray->tablet) && $optionArray->tablet !== '') {
                            $itemOptions['customStyle'][$value . '-tablet'] = $optionArray->tablet . $unit;
                        }
                        if (property_exists($optionArray, 'mobile') && isset($optionArray->mobile) && $optionArray->mobile !== '') {
                            $itemOptions['customStyle'][$value . '-mobile'] = $optionArray->mobile . $unit;
                        }
                    }
                } catch (\JsonException $exception) {
                    // echo $exception->getMessage(); // displays "Syntax error"  
                }
            }
        }
        if ($backdropBlur = get_post_meta($popup, 'popup-backdrop-blur', true)) {
            $itemOptions['customStyle']['--pix-dialog-backdrop-filter'] = 'blur(' . $backdropBlur . 'px)';
        }
        if ($backgroundColor = get_post_meta($popup, 'popup-background-color', true)) {
            if ($backgroundColor === 'custom') {
                if ($backgroundCustomColor = get_post_meta($popup, 'popup-background-custom-color', true)) {
                    $itemOptions['customStyle']['--pix-dialog-background-color'] = $backgroundCustomColor;
                }
            } else {
                $itemOptions['customStyle']['--pix-dialog-background-color'] = 'var(--pix-' . $backgroundColor . ')';
                if($backgroundColor === 'dynamic-blur' || $backgroundColor === 'dark-blur' || $backgroundColor === 'light-blur') {
                    $itemOptions['customStyle']['--pix-dialog-background-display-blur'] = 'block';
                    // $itemOptions['customStyle']['--pix-dialog-container-backdrop-blur'] = '20px';
                }
            }
        }
        if ($backdropColor = get_post_meta($popup, 'popup-backdrop-color', true)) {
            if ($backdropColor === 'custom') {
                if ($backdropCustomColor = get_post_meta($popup, 'popup-backdrop-custom-color', true)) {
                    $itemOptions['customStyle']['--pix-dialog-backdrop-bg'] = $backdropCustomColor;
                }
            } else {
                $itemOptions['customStyle']['--pix-dialog-backdrop-bg'] = 'var(--pix-' . $backdropColor . ')';
            }
        }

        if (!empty($itemOptions)) {
            $data['popupOptions'] = $itemOptions;
            // update_post_meta($popup, 'pix-popup-options-data', $itemOptions);
        } else {
            // delete_post_meta($popup, 'pix-popup-options-data');
        }
        $popupClasses = [];
        array_push($popupClasses, 'd-' . $popup);
        $popupOptions = [
            'pix-popup-width',
            'pix-popup-height',
            'pix-popup-shadow',
            'pix-popup-position-x',
            'pix-popup-position-y',
            'pix-popup-animation',
            'pix-popup-close-y',
            'pix-popup-close-x'
        ];
        foreach ($popupOptions as $option) {
            if ($optionValue = get_post_meta($popup, $option, true)) {
                array_push($popupClasses, $optionValue);
            }
        }
        if (get_post_meta($popup, 'pix-overflow-visible', true) && get_post_meta($popup, 'pix-overflow-visible', true) !== 'false') {
            array_push($popupClasses, 'pix-overflow-visible');
        }
        if (get_post_meta($popup, 'pix-disable-backdrop', true) && get_post_meta($popup, 'pix-disable-backdrop', true) !== 'false') {
            array_push($popupClasses, 'pix-disable-backdrop');
        }
        if (get_post_meta($popup, 'pix-esc-disable-close', true) && get_post_meta($popup, 'pix-esc-disable-close', true) !== 'false') {
            array_push($popupClasses, 'pix-disable-esc');
        }
        /*
        * Launcher
        */
        $launcherClasses = [];
        $launcherOptions = [];
        $launcherOptions['launcherStyle'] = [];
        $data['launcherOptions'] = [];
        if (get_post_meta($popup, 'pix-enable-launcher', true) && get_post_meta($popup, 'pix-enable-launcher', true) !== 'false') {
            $launcherOptions['launcherOptions']['enabled'] = true;
            array_push($popupClasses, 'pix-popup-has-launacher');
            if ($launcherShadow = get_post_meta($popup, 'pix-popup-launcher-shadow', true)) {
                array_push($launcherClasses, $launcherShadow);
            }
            if (get_post_meta($popup, 'pix-attach-popup-launcher', true) && get_post_meta($popup, 'pix-attach-popup-launcher', true) !== 'false') {
                array_push($popupClasses, 'attach-popup-launcher');
                // array_push($launcherClasses, 'launcher-in-front' );
            } elseif ($launcherFront = get_post_meta($popup, 'pix-launcher-in-front', true)) {
                if ($launcherFront !== 'false') {
                    array_push($launcherClasses, 'launcher-in-front');
                }
            }
            if ($launcherPosition = get_post_meta($popup, 'pix-launcher-position', true)) {
                array_push($launcherClasses, $launcherPosition);
                array_push($popupClasses, $launcherPosition);
            }
            if ($launcherBg = get_post_meta($popup, 'pix-launcher-background-color', true)) {
                if ($launcherBg !== 'custom') {
                    $launcherOptions['launcherStyle']['--pix-launcher-background-color'] = 'var(--pix-' . $launcherBg . ')';
                } else {
                    if ($launcherCustomBgColor = get_post_meta($popup, 'pix-launcher-background-custom-color', true)) {
                        $launcherOptions['launcherStyle']['--pix-launcher-background-color'] = $launcherCustomBgColor;
                    }
                }
            }
            if ($launcherColor = get_post_meta($popup, 'pix-launcher-icon-color', true)) {
                if ($launcherColor !== 'custom') {
                    $launcherOptions['launcherStyle']['--pix-launcher-color'] = 'var(--pix-' . $launcherColor . ')';
                } else {
                    if ($launcherCustomColor = get_post_meta($popup, 'pix-launcher-icon-custom-color', true)) {
                        $launcherOptions['launcherStyle']['--pix-launcher-color'] = $launcherCustomColor;
                    }
                }
            }
            if ($launcherPadding = get_post_meta($popup, 'pix-launcher-logo-padding', true)) {
                $launcherOptions['launcherStyle']['--pix-launcher-padding'] = $launcherPadding . 'px';
            }

            $responsiveLauncherOptions = [
                'pix-launcher-bottom-value' => '--pix-launcher-bottom-value',
                'pix-launcher-horizontal-value' => '--pix-launcher-horizontal-value'
            ];
            foreach ($responsiveLauncherOptions as $key => $value) {
                if ($varValue = get_post_meta($popup, $key, true)) {
                    $unit = 'px';
                    try {
                        $optionArray = json_decode($varValue);
                        if ($optionArray) {
                            if (property_exists($optionArray, 'desktop') && !empty($optionArray->desktop)) {
                                $launcherOptions['launcherStyle'][$value] = $optionArray->desktop . $unit;
                            }
                            if (property_exists($optionArray, 'tablet') && $optionArray->tablet !== '') {
                                $launcherOptions['launcherStyle'][$value . '-tablet'] = $optionArray->tablet . $unit;
                            }
                            if (property_exists($optionArray, 'mobile') && $optionArray->mobile !== '') {
                                $launcherOptions['launcherStyle'][$value . '-mobile'] = $optionArray->mobile . $unit;
                            }
                        }
                    } catch (\JsonException $exception) {
                        // echo $exception->getMessage(); // displays "Syntax error"  
                    }
                }
            }
            $launcherClasses = join(' ', $launcherClasses);
            $data['launcherClasses'] = $launcherClasses;
            $data['launcherOptions'] = $launcherOptions;
        } else {
            $data['launcherOptions']['enabled'] = false;
        }
        $popupClasses = join(' ', $popupClasses);
        if (!empty($popupClasses)) {
            $data['popupClasses'] = $popupClasses;
        }
        update_post_meta($popup, 'pix-popup-data', $data);
        update_post_meta($popup, 'pix-popup-loaded', true);
    }
    /*
    * Get Popup content via Ajax
    */
    public function pix_popup_content($pid = false) {
        $id = false;
        if ($pid && !empty($pid)) {
            $id = (int)$pid;
        } else {
            if (empty($_REQUEST['id'])) {
                exit('Error: Popup ID is missing!');
            }
            $id = (int)$_REQUEST['id'];
        }
        if (!$id) exit('Error: Popup ID is missing!');
        $popup_main_id = $id;
        $transientID = 'pixpopup_' . $id;
        if (is_user_logged_in()) delete_transient($transientID);
        // $cachedPopup = false;
        // if(is_user_logged_in()) $cachedPopup = get_transient( $transientID );
        $cachedPopup = get_transient($transientID);
        $data = [];
        if ($cachedPopup) {
            if (!$pid) {
                echo $cachedPopup;
            } else {
                return $cachedPopup;
            }
        } else {
            global $post;
            $post = get_post($id, OBJECT);
            if ($post) setup_postdata($post);
            if (function_exists('icl_get_languages')) {
                $id = apply_filters('wpml_object_id', $id, 'pixpopup', true);
            }
            if (get_post_status($id) === 'publish' && get_post_type($id) === 'pixpopup') {
                $dynamicImport = false;
                if (class_exists('Vc_Manager')) {
                    $vc_manager = Vc_Manager::getInstance();
                    $vc_manager->loadComponents();
                }
                if (pix_plugin_get_option('pix-enable-popup-enqueue')) {
                    $dynamicImport = true;
                    global $wp_scripts;
                    global $wp_styles;
                    unset($wp_scripts->registered);
                    unset($wp_styles->registered);
                    ob_start();
                    wp_head();
                    the_content();
                    ob_get_clean();
                }
                if (function_exists('vc_frontend_editor')) {
                    vc_frontend_editor()->enqueueRequired();
                }
                if (class_exists('WPBMap')) {
                    WPBMap::addAllMappedShortcodes();
                }
                $html = $this->print_popup($popup_main_id, false);
                $result = [];
                $result['scripts'] = [];
                $result['styles'] = [];
                $footer_content = '';
                if ($dynamicImport) {
                    if (!empty($wp_styles->registered['elementor-frontend'])) {
                        unset($wp_styles->registered['elementor-frontend']);
                    }
                    if(!empty($wp_styles->registered['js_composer_front'])){
                        unset( $wp_styles->registered['js_composer_front'] );	
                    }
                    ob_start();
                    ob_flush();
                    wp_footer();
                    $footer_content = ob_get_contents();
                    ob_get_clean();
                    if (ob_get_length()) ob_end_clean();
                    unset($wp_styles->registered['essentials-bootstrap']);

                    // Get all loaded Scripts
                    foreach ($wp_scripts->queue as $script) :
                        if (!empty($wp_scripts->registered[$script]->src) && $wp_scripts->registered[$script]->src) {
                            if (!in_array($wp_scripts->registered[$script]->handle, ['elementor-common', 'elementor-app-loader'])) {
                                $result['scripts'][$wp_scripts->registered[$script]->handle] =  $wp_scripts->registered[$script];
                            }
                        }
                    endforeach;

                    // Get all loaded Styles (CSS)
                    foreach ($wp_styles->queue as $style) :
                        if (!empty($wp_styles->registered[$style]->src) && $wp_styles->registered[$style]->src) {
                            if($wp_styles->registered[$style]->handle!=='js_composer_front'){
                                $result['styles'][$wp_styles->registered[$style]->handle] =  $wp_styles->registered[$style];
                            }
                        }
                    endforeach;
                } else {
                    $defaultStyles = [
                        'pixfort-animated-heading-style'     => 'animated-heading',
                        'pixfort-chart-style'                 => 'chart',
                        'pixfort-map-style'                 => 'map',
                        'pixfort-levels-style'                 => 'levels',
                        'pix-marquee-handle'                 => 'marquee',
                        'pixfort-video-style'                 => 'video',
                        'pixfort-story-style'                 => 'story',
                        'pixfort-circles-style'             => 'circles',
                        'pixfort-carousel-style'             => 'carousel',
                    ];
                    foreach ($defaultStyles as $Key => $style) :
                        $result['styles'][$Key] =  PIX_CORE_PLUGIN_URI . 'includes/assets/css/elements/' . $style . '.min.css';
                    endforeach;
                }
                $popupOptions = [];
                $popupData = get_post_meta($id, 'pix-popup-data', true);
                if (is_array($popupData)) {
                    if (array_key_exists('popupOptions', $popupData)) $popupOptions = $popupData['popupOptions'];
                }
                $data = array(
                    'id' => $id,
                    'html' => $html,
                    'size'    => '',
                    'result'    => $result,
                    'footer_content' => $footer_content,
                    'popupOptions' => $popupOptions
                    // 'popupClasses' => $popupClasses
                );
                if (!is_user_logged_in()) {
                    set_transient($transientID, json_encode($data), 43200);
                }
            }
            wp_reset_postdata();
            if (!$pid) {
                echo json_encode($data);
            } else {
                return json_encode($data);
            }
        }
        wp_die();
    }

    public function pix_page_popups_content() {
        if (empty($_REQUEST['popups'])) {
            exit('Error: Popups data is missing!');
        }
        $data = $_REQUEST['popups'];
        $out = [];
        if (is_array($data)) {
            foreach ($data as $id) {
                $cleanId = (int)$id;
                array_push($out, $this->pix_popup_content($cleanId));
            }
        }
        wp_send_json($out);
    }

    /*
    * Print Popup HTML output
    */
    public function print_editor_popup($popup) {
        setup_postdata($popup);
        if (get_post_status($popup)) {
            $built_with_elementor = false;
            $launcherClasses = '';
            if (class_exists('\Elementor\Plugin')) {
                if (Elementor\Plugin::instance()->documents->get($popup)) {
                    if (Elementor\Plugin::instance()->documents->get($popup)->is_built_with_elementor()) {
                        $built_with_elementor = true;
                    }
                }
            }
            $popupClasses = '';
            if(!metadata_exists('post', $popup, 'pix-popup-loaded')||!metadata_exists('post', $popup, 'pix-popup-data')){
                $this->generatePopupData($popup);
            }
            $popupData = get_post_meta($popup, 'pix-popup-data', true);
            if (is_array($popupData)) {
                if (array_key_exists('popupClasses', $popupData)) $popupClasses = $popupData['popupClasses'];
                if (array_key_exists('launcherClasses', $popupData)) $launcherClasses = $popupData['launcherClasses'];
            } else {
                $popupClasses .= ' animation-fade ';
                $oldSizes = array(
                    'col-12 col-sm-4'            => 'popup-width-xs',
                    'col-12 col-sm-6'            => 'popup-width-sm',
                    'col-12 col-sm-8'            => 'popup-width-md',
                    'col-12 col-sm-10'           => 'popup-width-lg',
                    'col-12'                     => 'popup-width-xl',
                );
                if ($popupSize = get_post_meta($popup, 'pix-popup-size', true)) {
                    if (array_key_exists($popupSize, $oldSizes)) {
                        $popupClasses .= $oldSizes[$popupSize];
                    }
                }
            }
            $closeIcon = 'line/pixfort-icon-cross-1';
            if (get_post_meta($popup, 'pix-close-icon', true)) {
                $closeIcon = get_post_meta($popup, 'pix-close-icon', true);
            }
            $popupDisplayID = '1';
            if (get_post_meta($popup, 'pix-popup-id', true)) {
                $popupDisplayID = get_post_meta($popup, 'pix-popup-id', true);
            }
            $backdropClose = '';
            if (get_post_meta($popup, 'pix-backdrop-disable-close', true) && get_post_meta($popup, 'pix-backdrop-disable-close', true) !== 'false') {
                $backdropClose = 'is-disabled';
            }
            $popupClasses .= ' displayed transitioned';
            if ($customCSS = get_post_meta($popup, 'popup-custom-css', true)) {
                wp_register_style('pix-popup-' . $popup, false);
                wp_enqueue_style('pix-popup-' . $popup);
                wp_add_inline_style('pix-popup-' . $popup, $customCSS);
            }
            echo '<dialog id="pix_popup_' . $popup . '" data-id="' . $popup . '" data-display-id="' . $popupDisplayID . '" class="pix-popup pix-popup-' . $popup . ' pix-editor ' . $popupClasses . ' dynamicc">';
            echo '<div class="pix-dialog-backdrop ' . $backdropClose . '"></div>';
            echo '<div class="pix-dialog-container">';
            echo '<div class="pix-popup-close">' . pixGetFileContents( '/includes/assets/icons/' . $closeIcon . '.svg') . '</div>';

            if ($built_with_elementor) {
                echo '<div class="pix-dialog-inner">';
                the_post();
                the_content();
                echo '</div>';
            } else {
                echo '<div class="pix-dialog-inner">';
                echo '<div class="container">';
                echo apply_filters('the_content', do_shortcode(get_post_field('post_content', $popup)));
                echo '</div>';
                echo '<style type="text/css" data-type="vc_shortcodes-custom-css">' . get_post_meta($popup, '_wpb_shortcodes_custom_css', true) . '</style>';
                echo '</div>';
            }

            echo '</div>';
            echo '</dialog>';
            if (get_post_meta($popup, 'pix-enable-launcher', true) && get_post_meta($popup, 'pix-enable-launcher', true) !== 'false') {
                echo '<a id="pix_launcher_' . $popup . '" aria-label="' . get_the_title($popup) . '" class="pix-popup-launcher pix-launcher-' . $popup . ' d-none overflow-hidden rounded-circle ' . $launcherClasses . '" href="#" data-href="#pix_popup_' . $popup . '" data-id="' . $popup . '">';
                if ($launcherLogo = get_post_meta($popup, 'pix-launcher-logo', true)) {
                    if ($launcherLogo === 'launcher-logo-image' && $launcherLogoImage = get_post_meta($popup, 'pix-launcher-logo-image', true)) {
                        if(function_exists('pixGetImageID')){
                            $imageArray = pixGetImageID($launcherLogoImage);
                            $imageID = $imageArray['light'];
                            echo '<span class="pix-launcher-main">' . wp_get_attachment_image($imageID, "full") . '</span>';
                        }
                    } else {
                        $launcherIcon = 'line/pixfort-icon-bolt-1';
                        if (get_post_meta($popup, 'pix-launcher-icon', true)) {
                            $launcherIcon = get_post_meta($popup, 'pix-launcher-icon', true);
                        }
                        echo '<span class="pix-launcher-main">' . pixGetFileContents( '/includes/assets/icons/' . $launcherIcon . '.svg') . '</span>';
                    }
                }
                echo '<span class="pix-launcher-close d-none">' . pixGetFileContents( '/includes/assets/icons/line/pixfort-icon-cross-1.svg') . '</span>';
                echo '</a>';
            }
        }
        wp_reset_postdata();
    }

    /*
    * Print Popup HTML output
    */
    public function print_popup($popup, $print = true, $editor = false) {
        $popup_main_id = $popup;
        if (function_exists('icl_get_languages')) {
            $popup = apply_filters('wpml_object_id', $popup, 'pixpopup', true);
        }
        $popupPost = get_post($popup, OBJECT);
        if ($popupPost) setup_postdata($popupPost);
        $html = '';
        if (get_post_status($popup)) {
            $built_with_elementor = false;
            if (class_exists('\Elementor\Plugin')) {
                if (Elementor\Plugin::instance()->documents->get($popup)) {
                    if (Elementor\Plugin::instance()->documents->get($popup)->is_built_with_elementor()) {
                        $built_with_elementor = true;
                    }
                }
            }
            $popupClasses = '';
            $launcher = '';
            $launcherClasses = '';
            if(!metadata_exists('post', $popup, 'pix-popup-loaded')||!metadata_exists('post', $popup, 'pix-popup-data')){
                $this->generatePopupData($popup);
            }

            $popupData = get_post_meta($popup, 'pix-popup-data', true);
            if (is_array($popupData)) {
                if (array_key_exists('popupClasses', $popupData)) $popupClasses = $popupData['popupClasses'];
                if (array_key_exists('launcherClasses', $popupData)) $launcherClasses = $popupData['launcherClasses'];
            } else {
                $popupClasses .= ' animation-fade ';
                $oldSizes = array(
                    'col-12 col-sm-4'            => 'popup-width-xs',
                    'col-12 col-sm-6'            => 'popup-width-sm',
                    'col-12 col-sm-8'            => 'popup-width-md',
                    'col-12 col-sm-10'           => 'popup-width-lg',
                    'col-12'                     => 'popup-width-xl',
                );
                if ($popupSize = get_post_meta($popup, 'pix-popup-size', true)) {
                    if (array_key_exists($popupSize, $oldSizes)) {
                        $popupClasses .= $oldSizes[$popupSize];
                    }
                }
            }
            $closeIcon = 'duotone/pixfort-icon-cross-circle-1';
            if (get_post_meta($popup, 'pix-close-icon', true)) {
                $closeIcon = get_post_meta($popup, 'pix-close-icon', true);
            }
            $popupDisplayID = '1';
            if (get_post_meta($popup, 'pix-popup-id', true)) {
                $popupDisplayID = get_post_meta($popup, 'pix-popup-id', true);
            }
            $backdropClose = '';
            if (get_post_meta($popup, 'pix-backdrop-disable-close', true) && get_post_meta($popup, 'pix-backdrop-disable-close', true) !== 'false') {
                $backdropClose = 'is-disabled';
            }
            if ($customCSS = get_post_meta($popup, 'popup-custom-css', true)) {
                wp_register_style('pix-popup-' . $popup, false);
                wp_enqueue_style('pix-popup-' . $popup);
                wp_add_inline_style('pix-popup-' . $popup, $customCSS);
            }
            if ($editor) {
                $popupClasses .= ' displayed transitioned';
            }
            $html .= '<dialog id="pix_popup_' . $popup_main_id . '" data-id="' . $popup_main_id . '" data-display-id="' . $popupDisplayID . '" class="pix-popup pix-init-popup pix-popup-' . $popup_main_id . ' ' . $popupClasses . ' dynamicc">';
            $html .= '<div class="pix-dialog-backdrop ' . $backdropClose . '"></div>';
            $html .= '<div class="pix-dialog-container">';
            $html .= '<div class="pix-popup-close">' . pixGetFileContents( '/includes/assets/icons/' . $closeIcon . '.svg') . '</div>';
            if ($built_with_elementor) {
                $html .= '<div class="pix-dialog-inner">';
                $frontOut = \Elementor\plugin::instance()->frontend->get_builder_content($popup, true);
                $html .= $frontOut;
                if ($editor && empty($frontOut)) {
                    $html .= apply_filters('the_content', do_shortcode(get_post_field('post_content', $popup)));
                }
                $html .= '</div>';
            } else {
                $html .= '<div class="pix-dialog-inner">';
                $html .= '<div class="container">';
                if ($print) {
                    $html .= do_shortcode(get_post_field('post_content', $popup));
                } else {
                    $html .= apply_filters('the_content', do_shortcode(get_post_field('post_content', $popup)));
                }
                $html .= '</div>';
                $html .= '<style type="text/css" data-type="vc_shortcodes-custom-css">' . get_post_meta($popup, '_wpb_shortcodes_custom_css', true) . '</style>';
                $html .= '</div>';
            }

            $html .= '</div>';
            $html .= '</dialog>';
            if (get_post_meta($popup, 'pix-enable-launcher', true) && get_post_meta($popup, 'pix-enable-launcher', true) !== 'false') {
                $launcher .= '<a id="pix_launcher_' . $popup . '" aria-label="' . get_the_title($popup) . '" class="pix-popup-launcher pix-launcher-' . $popup . ' d-none overflow-hidden rounded-circle ' . $launcherClasses . '" href="#" data-href="#pix_popup_' . $popup . '" data-id="' . $popup . '">';
                if ($launcherLogo = get_post_meta($popup, 'pix-launcher-logo', true)) {
                    if ($launcherLogo === 'launcher-logo-image' && $launcherLogoImage = get_post_meta($popup, 'pix-launcher-logo-image', true)) {
                        if(function_exists('pixGetImageID')){
                            $imageArray = pixGetImageID($launcherLogoImage);
                            $imageID = $imageArray['light'];
                            $launcher .= '<span class="pix-launcher-main">' . wp_get_attachment_image($imageID, 'full') . '</span>';
                        }
                    } else {
                        $launcherIcon = 'line/pixfort-icon-bolt-1';
                        if (get_post_meta($popup, 'pix-launcher-icon', true)) {
                            $launcherIcon = get_post_meta($popup, 'pix-launcher-icon', true);
                        }
                        $launcher .= '<span class="pix-launcher-main">' . pixGetFileContents( '/includes/assets/icons/' . $launcherIcon . '.svg') . '</span>';
                    }
                }
                $launcher .= '<span class="pix-launcher-close d-none">' . pixGetFileContents( '/includes/assets/icons/line/pixfort-icon-cross-1.svg') . '</span>';
                $launcher .= '</a>';
            }
            if ($print) {
                echo $html;
                echo $launcher;
            }
        }
        wp_reset_postdata();
        return $html;
    }
}
