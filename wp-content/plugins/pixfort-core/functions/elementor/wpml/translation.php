<?php
add_action( 'elementor/init', function() {
    include_once('items/accordion.php');
    include_once('items/highlighted-text.php');
    include_once('items/progress-bars.php');
}, 15 );
/**
 * Make our widgets compatible with WPML elementor list
 *
 * @param array $widgets
 * @return array
 */
function pix_wpml_widgets_to_translate_list($widgets) {

    $widgets['pix-accordion'] = array(
        'conditions'        => array('widgetType' => 'pix-accordion'),
        'fields'            => array(),
        'integration-class' => 'Pix_WPML_Elementor_Accordion',
    );

    $widgets['pix-alert'] = array(
        'conditions' => array('widgetType' => 'pix-alert'),
        'fields'     => array(
            array(
                'field'       => 'title',
                'type'        => __('Title', 'pixfort-core'),
                'editor_type' => 'LINE'
            ),
        ),
    );

    $widgets['pix-badge'] = array(
        'conditions' => array('widgetType' => 'pix-badge'),
        'fields'     => array(
            array(
                'field'       => 'text',
                'type'        => __('Text', 'pixfort-core'),
                'editor_type' => 'LINE'
            ),
        ),
    );

    $widgets['pix-chart'] = array(
        'conditions' => array('widgetType' => 'pix-chart'),
        'fields'     => array(
            array(
                'field'       => 'title',
                'type'        => __('title', 'pixfort-core'),
                'editor_type' => 'LINE'
            ),
            array(
                'field'       => 'text',
                'type'        => __('text', 'pixfort-core'),
                'editor_type' => 'AREA'
            ),
        ),
    );


    $widgets['pix-faq'] = array(
        'conditions' => array('widgetType' => 'pix-faq'),
        'fields'     => array(
            array(
                'field'       => 'title',
                'type'        => __('title', 'pixfort-core'),
                'editor_type' => 'LINE'
            ),
            array(
                'field'       => 'content',
                'type'        => __('content', 'pixfort-core'),
                'editor_type' => 'AREA'
            ),
        ),
    );

    $widgets['pix-heading'] = array(
        'conditions' => array('widgetType' => 'pix-heading'),
        'fields'     => array(
            array(
                'field'       => 'title',
                'type'        => __('title', 'pixfort-core'),
                'editor_type' => 'LINE'
            ),
        ),
    );

    $widgets['pix-highlighted-text'] = array(
        'conditions' => array('widgetType' => 'pix-highlighted-text'),
        'fields'     => array(),
        'integration-class' => 'Pix_WPML_Elementor_Highlighted_Text',
    );

    $widgets['pix-map'] = array(
        'conditions' => array('widgetType' => 'pix-map'),
        'fields'     => array(
            array(
                'field'       => 'address',
                'type'        => __('address', 'pixfort-core'),
                'editor_type' => 'LINE'
            ),
        ),
    );

    $widgets['pix-numbers'] = array(
        'conditions' => array('widgetType' => 'pix-numbers'),
        'fields'     => array(
            array(
                'field'       => 'text_before',
                'type'        => __('Text Before', 'pixfort-core'),
                'editor_type' => 'LINE'
            ),
            array(
                'field'       => 'text_after',
                'type'        => __('Text After', 'pixfort-core'),
                'editor_type' => 'LINE'
            ),
            array(
                'field'       => 'content',
                'type'        => __('content', 'pixfort-core'),
                'editor_type' => 'AREA'
            ),
        ),
    );

    $widgets['pix-progress-bars'] = array(
        'conditions' => array('widgetType' => 'pix-progress-bars'),
        'fields'     => array(),
        'integration-class' => 'Pix_WPML_Elementor_Progress_Bars',
    );

    $widgets['pix-shop-category'] = array(
        'conditions' => array('widgetType' => 'pix-shop-category'),
        'fields'     => array(
            array(
                'field'       => 'alt',
                'type'        => __('alt', 'pixfort-core'),
                'editor_type' => 'LINE'
            ),
            array(
                'field'       => 'title',
                'type'        => __('title', 'pixfort-core'),
                'editor_type' => 'LINE'
            ),
            array(
                'field'       => 'link_text',
                'type'        => __('link_text', 'pixfort-core'),
                'editor_type' => 'LINE'
            ),
        ),
    );

    $widgets['pix-sliding-text'] = array(
        'conditions' => array('widgetType' => 'pix-sliding-text'),
        'fields'     => array(
            array(
                'field'       => 'content',
                'type'        => __('Content', 'pixfort-core'),
                'editor_type' => 'AREA'
            ),
        ),
    );

    $widgets['pix-text'] = array(
        'conditions' => array('widgetType' => 'pix-text'),
        'fields'     => array(
            array(
                'field'       => 'content',
                'type'        => __('content', 'pixfort-core'),
                'editor_type' => 'AREA'
            ),
            array(
                'field'       => 'content_wysiwyg',
                'type'        => __('content', 'pixfort-core'),
                'editor_type' => 'VISUAL'
            ),
        ),
    );


    return $widgets;
}

/**
 * Add filter on wpml elementor widgets node when init action.
 *
 * @return void
 */
function pix_wpml_widgets_to_translate_filter() {
    add_filter('wpml_elementor_widgets_to_translate', 'pix_wpml_widgets_to_translate_list');
}
add_action('init', 'pix_wpml_widgets_to_translate_filter');
