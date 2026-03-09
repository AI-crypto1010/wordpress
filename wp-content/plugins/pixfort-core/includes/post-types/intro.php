<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Intro Type
 *
 * 
 *
 * @since 1.0
 */
class IntroType {

    public $postType = 'pixintro';

    public function __construct() {
        $this->load();
    }

    public function load() {
        add_action('init', [$this, 'pix_pixintro_post_type']);
        add_action('admin_menu', [$this, 'pix_intro_meta_add']);
        add_action('save_post_pixintro', [$this, 'pix_intro_save_data']);
    }

    function pix_pixintro_post_type() {
        $pixintro_item_slug = "pixintro-item";

        $labels = array(
            'name'                  => __('Intros', 'pixfort-core'),
            'singular_name'         => __('Intro item', 'pixfort-core'),
            'add_new'               => __('Add New Intro', 'pixfort-core'),
            'add_new_item'          => __('Add New Intro Item', 'pixfort-core'),
            'edit_item'             => __('Edit Intro item', 'pixfort-core'),
            'new_item'              => __('New Intro item', 'pixfort-core'),
            'view_item'             => __('View Intro item', 'pixfort-core'),
            'search_items'          => __('Search Intro items', 'pixfort-core'),
            'not_found'             => __('No Intro items found', 'pixfort-core'),
            'not_found_in_trash'    => __('No Intro items found in Trash', 'pixfort-core'),
            'parent_item_colon'     => ''
        );

        $args = array(
            'labels'                => $labels,
            'menu_icon'             => PIX_CORE_PLUGIN_URI . 'functions/images/admin/intro-icon.svg',
            'public'                => true,
            'publicly_queryable'    => true,
            'has_archive'           => false,
            'show_ui'               => true,
            'query_var'             => true,
            'capability_type'       => 'post',
            'hierarchical'          => false,
            'menu_position'         => null,
            'exclude_from_search'   => true,
            'rewrite'               => array('slug' => $pixintro_item_slug, 'with_front' => true),
            'supports'              => array('title', 'editor', 'author', 'revisions', 'custom-fields', 'excerpt', 'thumbnail', 'page-attributes'),
        );

        register_post_type($this->postType, $args);

        register_taxonomy('pixintro-types', 'pixintro', array(
            'hierarchical'          => true,
            'label'                 => __('pixintro categories', 'pixfort-core'),
            'singular_label'        => __('pixintro category', 'pixfort-core'),
            'rewrite'               => true,
            'query_var'             => true
        ));
    }

    public function pix_intro_meta_add() {
        $pix_meta_box = array(
            'id'         => 'pix-meta-page',
            'title'      => __('pixfort Options', 'pixfort-core'),
            'page'       => $this->postType,
            'post_types' => [$this->postType],
            'context'    => 'normal',
            'priority'   => 'high',
            'fields'     => [
                [
                    'id' => 'intro-condition'
                ]
            ],
        );

        add_meta_box($pix_meta_box['id'], $pix_meta_box['title'], [$this, 'pix_intro_show_box'], $pix_meta_box['page'], $pix_meta_box['context'], $pix_meta_box['priority']);
    }

    public function pix_intro_show_box() {
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
                'helpLink' => \PixfortCore::instance()->adminCore->getParam('docs_create_intro'),
            ]
        );

        // Check if current intro is set as website intro
        $current_intro_id = get_the_ID();
        $website_intro = pix_plugin_get_option('pix-intro');
        if ($current_intro_id && $website_intro && $current_intro_id == $website_intro) {
            $pixfortBuilder->addOption(
                'website-intro-note',
                [
                    'type' => 'alert',
                    'label' => __('Important', 'pixfort-core'),
                    'description' => __('This intro is currently set as the global website intro in <strong>Theme Options → Layout → Intro</strong>.<br/> If you are looking to set display conditions for this intro, please make sure to disable this global intro from the Theme Options first.', 'pixfort-core'),
                    'style' => 'clean',
                    'icon' => 'info',
                    'hidePaddingBottom' => true,
                ]
            );
        }

        $pixfortBuilder->addOption(
            'intro-condition',
            [
                'type'        => 'conditions',
                'label'       => __('Intro Display Conditions', 'pixfort-core'),
                'default'     => '',
                'tab'         => 'general',
                'description' => __('Add conditions to define where the intro will be displayed on your website.', 'pixfort-core'),
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
    public function pix_intro_save_data($post_id) {
        // Skip if this is an Elementor save
        if (isset($_POST['action']) && $_POST['action'] === 'elementor_ajax') {
            return $post_id;
        }

        $pix_intro_meta_box = [
            [
                'id' => 'intro-condition',
            ]
        ];

        // verify nonce - return early if nonce is not present (WPBakery frontend editor, etc.)
        if (!isset($_POST['pix_page_meta_nonce'])) {
            return $post_id;
        }

        // verify nonce validity
        if (!wp_verify_nonce($_POST['pix_page_meta_nonce'], basename(__FILE__))) {
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

        if (!empty($pix_intro_meta_box)) {
            foreach ((array)$pix_intro_meta_box as $field) {
                $old = get_post_meta($post_id, $field['id'], true);
                $new = isset($_POST[$field['id']]) ? $_POST[$field['id']] : (isset($field['type']) && $field['type'] == 'switch' ? '0' : null);

                if (isset($new) && $new != $old) {
                    update_post_meta($post_id, $field['id'], $new);
                } elseif ('' == $new && $old) {
                    delete_post_meta($post_id, $field['id'], $old);
                }
            }
            PixfortCore::instance()->areasCache->refreshPostConditions('intro', $post_id, 'intro-condition');
        }
    }
}
