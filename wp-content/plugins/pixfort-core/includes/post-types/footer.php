<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Footer Type
 *
 * 
 *
 * @since 1.0
 */
class FooterType {

    public $postType = 'pixfooter';

    public function __construct() {
        $this->load();
    }

    public function load() {
        add_action('init', [$this, 'pix_pixfooter_post_type']);
        add_action('admin_menu', [$this, 'pix_footer_meta_add']);
        add_action('save_post_pixfooter', [$this, 'pix_footer_save_data']);
    }

    function pix_pixfooter_post_type() {
        $pixfooter_item_slug = "pixfooter-item";

        $labels = array(
            'name'                  => __('Footers', 'pixfort-core'),
            'singular_name'         => __('Footer item', 'pixfort-core'),
            'add_new'               => __('Add New Footer', 'pixfort-core'),
            'add_new_item'          => __('Add New Footer Item', 'pixfort-core'),
            'edit_item'             => __('Edit Footer item', 'pixfort-core'),
            'new_item'              => __('New Footer item', 'pixfort-core'),
            'view_item'             => __('View Footer item', 'pixfort-core'),
            'search_items'          => __('Search Footer items', 'pixfort-core'),
            'not_found'             => __('No Footer items found', 'pixfort-core'),
            'not_found_in_trash'    => __('No Footer items found in Trash', 'pixfort-core'),
            'parent_item_colon'     => ''
        );

        $args = array(
            'labels'                => $labels,
            'menu_icon'             => PIX_CORE_PLUGIN_URI . 'functions/images/admin/footer-icon.svg',
            'public'                => true,
            'publicly_queryable'    => true,
            'has_archive'           => true,
            'show_ui'               => true,
            'query_var'             => true,
            'capability_type'       => 'post',
            'hierarchical'          => false,
            'menu_position'         => null,
            'exclude_from_search'   => true,
            'rewrite'               => array('slug' => $pixfooter_item_slug, 'with_front' => true),
            'supports'              => array('title', 'editor', 'author', 'revisions', 'custom-fields', 'excerpt', 'thumbnail', 'page-attributes'),
        );

        register_post_type($this->postType, $args);

        register_taxonomy('pixfooter-types', 'pixfooter', array(
            'hierarchical'          => true,
            'label'                 => __('pixfooter categories', 'pixfort-core'),
            'singular_label'        => __('pixfooter category', 'pixfort-core'),
            'rewrite'               => true,
            'query_var'             => true
        ));
    }

    public function pix_footer_meta_add() {
        $pix_meta_box = array(
            'id'         => 'pix-meta-page',
            'title'      => __('pixfort Options', 'pixfort-core'),
            'page'       => $this->postType,
            'post_types' => [$this->postType],
            'context'    => 'normal',
            'priority'   => 'high',
            'fields'     => [
                [
                    'id' => 'footer-condition'
                ]
            ],
        );

        add_meta_box($pix_meta_box['id'], $pix_meta_box['title'], [$this, 'pix_footer_show_box'], $pix_meta_box['page'], $pix_meta_box['context'], $pix_meta_box['priority']);
    }

    public function pix_footer_show_box() {
        global $post;

        // Use nonce for verification
        echo '<div id="pix-wrapper" class="pix-header-options-area">';
        echo '<input type="hidden" name="pix_page_meta_nonce" value="', esc_attr(wp_create_nonce(basename(__FILE__))), '" />';
        echo '<table class="form-table">';
        echo '<tbody>';

        $pixfortBuilder = new PixfortOptions();
        $pixfortBuilder->initOptions(
            'meta',
            $post,
            false,
            [
                'tabs'  => [
                    'general'    => ['title' => __('General', 'pixfort-core'), 'icon' => 'general'],
                    'triggers'   => ['title' => __('Triggers', 'pixfort-core'), 'icon' => 'triggers'],
                    'design'     => ['title' => 'Design', 'icon' => 'design'],
                    'launcher'   => ['title' => 'Launcher', 'icon' => 'launcher'],
                    'advanced'   => ['title' => 'Advanced', 'icon' => 'advanced'],
                ],
                'helpLink' => \PixfortCore::instance()->adminCore->getParam('docs_create_footer'),
            ]
        );

        // Check if current footer is set as website footer
        $current_footer_id = get_the_ID();
        $website_footer = pix_plugin_get_option('pix-footer');
        if ($current_footer_id && $website_footer && $current_footer_id == $website_footer) {
            $pixfortBuilder->addOption(
                'website-footer-note',
                [
                    'type' => 'alert',
                    'label' => __('Important', 'pixfort-core'),
                    'description' => __('This footer is currently set as the global website footer in <strong>Theme Options → Layout → Footer</strong>.<br/> If you are looking to set display conditions for this footer, please make sure to disable this global footer from the Theme Options first.', 'pixfort-core'),
                    'style' => 'clean',
                    'icon' => 'info',
                    'hidePaddingBottom' => true,
                ]
            );
        }

        $pixfortBuilder->addOption(
            'footer-condition',
            [
                'type'        => 'conditions',
                'label'       => __('Footer Display Conditions', 'pixfort-core'),
                'default'     => '',
                'tab'         => 'general',
                'description' => __('Add conditions to define where the footer will be displayed on your website.', 'pixfort-core'),
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
    public function pix_footer_save_data($post_id) {
        // Skip if this is an Elementor save
        if (isset($_POST['action']) && $_POST['action'] === 'elementor_ajax') {
            return $post_id;
        }

        $pix_footer_meta_box = [
            [
                'id' => 'footer-condition',
            ]
        ];

        // verify nonce
        if (isset($_POST['pix_page_meta_nonce']) && !wp_verify_nonce($_POST['pix_page_meta_nonce'], basename(__FILE__))) {
            return $post_id;
        }

        // check autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }

        // check permissions
        if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return $post_id;
            }
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }

        if (!empty($pix_footer_meta_box)) {
            foreach ((array)$pix_footer_meta_box as $field) {
                $old = get_post_meta($post_id, $field['id'], true);
                $new = isset($_POST[$field['id']]) ? $_POST[$field['id']] : (isset($field['type']) && $field['type'] == 'switch' ? '0' : null);

                if (isset($new) && $new != $old) {
                    update_post_meta($post_id, $field['id'], $new);
                } elseif ('' == $new && $old) {
                    delete_post_meta($post_id, $field['id'], $old);
                }
            }
            PixfortCore::instance()->areasCache->refreshPostConditions('footer', $post_id, 'footer-condition');
        }
    }
}
