<?php

if (!defined('ABSPATH')) {
    exit;
}

class coreFunctions {

    function __construct() {
        add_action('wp_ajax_pix_get_nonces', [$this, 'pix_get_nonces']);
        add_action('wp_ajax_nopriv_pix_get_nonces', [$this, 'pix_get_nonces']);
        add_action('wp_ajax_pix_ajax_search', [$this, 'pix_ajax_search']);
        add_action('wp_ajax_nopriv_pix_ajax_search', [$this, 'pix_ajax_search']);
        add_action('wp_ajax_pix_loop_grid_load_more', [$this, 'pix_loop_grid_load_more_handler']);
        add_action('wp_ajax_nopriv_pix_loop_grid_load_more', [$this, 'pix_loop_grid_load_more_handler']);
    }

    function pix_get_nonces() {
        // Create nonces for all potential AJAX endpoints
        $nonces = array(
            'search_nonce' => wp_create_nonce('search_nonce'),
            'loop_grid_load_more_nonce' => wp_create_nonce('loop_grid_load_more_nonce'),
            // Add more nonces here as needed for other AJAX actions
            // 'contact_nonce' => wp_create_nonce('contact_nonce'),
            // 'wishlist_nonce' => wp_create_nonce('wishlist_nonce'),
            // 'cart_nonce' => wp_create_nonce('cart_nonce'),
        );
        if (class_exists('WooCommerce')) {
            $nonces['product_nonce'] = wp_create_nonce('product_nonce');
            $nonces['product_add_nonce'] = wp_create_nonce('product_add_nonce');
        }

        // Allow other plugins/themes to add their nonces
        $nonces = apply_filters('pixfort_ajax_nonces', $nonces);

        nocache_headers(); // send no-cache headers
        wp_send_json_success($nonces);
    }

    // AJAX handler for Loop Grid load more
    function pix_loop_grid_load_more_handler() {
        // Verify nonce
        $nonce = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : '';
        if (!wp_verify_nonce($nonce, 'loop_grid_load_more_nonce')) {
            wp_send_json_error(['message' => 'Invalid security token']);
            wp_die();
        }

        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $query_json = isset($_POST['query']) ? $_POST['query'] : '';

        if (empty($query_json)) {
            wp_send_json_error(['message' => 'Invalid query']);
            wp_die();
        }

        $args = json_decode(stripslashes($query_json), true);
        if (!is_array($args)) {
            wp_send_json_error(['message' => 'Invalid query format']);
            wp_die();
        }

        // Extract meta data before querying
        $template_id = isset($args['_template_id']) ? intval($args['_template_id']) : 0;
        $animation = isset($args['_animation']) ? sanitize_text_field($args['_animation']) : '';
        $animation_delay = isset($args['_animation_delay']) ? intval($args['_animation_delay']) : 100;

        // Remove meta keys from query args
        unset($args['_template_id']);
        unset($args['_animation']);
        unset($args['_animation_delay']);

        // Check if this is a taxonomy query
        $is_taxonomy_query = isset($args['template_type']) && in_array($args['template_type'], ['post_taxonomy', 'product_taxonomy']);

        $html = '';
        $max_pages = 1;
        $found_items = 0;

        if ($is_taxonomy_query) {
            // Handle taxonomy term pagination
            $template_type = $args['template_type'];
            $taxonomy = isset($args['taxonomy']) ? $args['taxonomy'] : ($template_type === 'product_taxonomy' ? 'product_cat' : 'category');
            $posts_per_page = isset($args['posts_per_page']) ? intval($args['posts_per_page']) : 8;

            // Build term query args
            $term_args = [
                'taxonomy' => $taxonomy,
                'hide_empty' => (!empty($args['taxonomy_hide_empty']) && $args['taxonomy_hide_empty'] === 'yes'),
                'orderby' => !empty($args['taxonomy_orderby']) ? $args['taxonomy_orderby'] : 'name',
                'order' => !empty($args['taxonomy_order']) ? $args['taxonomy_order'] : 'DESC',
                'number' => $posts_per_page,
                'offset' => ($page - 1) * $posts_per_page,
            ];

            // Filter by manual selection
            if (!empty($args['taxonomy_filter_by']) && $args['taxonomy_filter_by'] === 'manual') {
                if (!empty($args['taxonomy_term_ids'])) {
                    $term_ids = is_array($args['taxonomy_term_ids']) ? $args['taxonomy_term_ids'] : explode(',', $args['taxonomy_term_ids']);
                    $term_args['include'] = array_map('intval', $term_ids);
                }
            }

            // Filter by parent
            if (!empty($args['taxonomy_filter_by']) && $args['taxonomy_filter_by'] === 'by_parent') {
                if (!empty($args['taxonomy_parent_term_id'])) {
                    $term_args['parent'] = intval($args['taxonomy_parent_term_id']);
                } else {
                    $term_args['parent'] = 0; // Top-level terms only
                }
            }

            $terms = get_terms($term_args);

            if (!empty($terms) && !is_wp_error($terms)) {
                // Calculate total terms for pagination
                $count_args = $term_args;
                $count_args['number'] = 0; // Remove limit to get total count
                $count_args['fields'] = 'count'; // Only count, don't fetch terms
                $total_terms = get_terms($count_args);
                $max_pages = ceil($total_terms / $posts_per_page);
                $found_items = $total_terms;

                $item_index = 0;
                foreach ($terms as $term) {
                    $item_index++;

                    // Calculate animation delay for this item
                    $item_delay = $animation_delay * $item_index;

                    // Build animation attributes
                    $anim_attrs = '';
                    $item_classes = ['pix-loop-grid-item'];
                    if (!empty($animation)) {
                        $item_classes[] = 'animate-in';
                        $anim_attrs = ' data-anim-type="' . esc_attr($animation) . '" data-anim-delay="' . esc_attr($item_delay) . '"';
                    }

                    $html .= '<div class="' . implode(' ', $item_classes) . '"' . $anim_attrs . '>';

                    if ($template_id && class_exists('\Elementor\Plugin')) {
                        // Set up the query context for this term
                        global $wp_query;
                        $wp_query->loop_term = $term;

                        $template_id = apply_filters('wpml_object_id', $template_id, 'elementor_library', true);
                        $html .= \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($template_id, true);
                    }

                    $html .= '</div>';
                }
            }
        } else {
            // Handle regular post/product pagination
            // Update paged parameter
            $args['paged'] = $page;

            // Recalculate offset if it was set
            if (isset($args['offset']) && $args['offset'] > 0) {
                $original_offset = isset($args['original_offset']) ? intval($args['original_offset']) : $args['offset'];
                $posts_per_page = isset($args['posts_per_page']) ? intval($args['posts_per_page']) : 10;
                $args['offset'] = ($page - 1) * $posts_per_page + $original_offset;
            }

            $query = new WP_Query($args);

            if ($query->have_posts()) {
                $item_index = 0;
                while ($query->have_posts()) {
                    $query->the_post();
                    $item_index++;

                    // Calculate animation delay for this item
                    $item_delay = $animation_delay * $item_index;

                    // Build animation attributes
                    $anim_attrs = '';
                    $item_classes = ['pix-loop-grid-item'];
                    if (!empty($animation)) {
                        $item_classes[] = 'animate-in';
                        $anim_attrs = ' data-anim-type="' . esc_attr($animation) . '" data-anim-delay="' . esc_attr($item_delay) . '"';
                    }

                    $html .= '<div class="' . implode(' ', $item_classes) . '"' . $anim_attrs . '>';

                    if ($template_id && class_exists('\Elementor\Plugin')) {
                        $template_id = apply_filters('wpml_object_id', $template_id, 'elementor_library', true);
                        $html .= \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($template_id, true);
                    }

                    $html .= '</div>';
                }
                wp_reset_postdata();
            }

            $max_pages = $query->max_num_pages;
            $found_items = $query->found_posts;
        }

        wp_send_json_success([
            'html' => $html,
            'max_pages' => $max_pages,
            'found_posts' => $found_items,
            'has_animation' => !empty($animation)
        ]);
        wp_die();
    }


    function pix_ajax_search() {
        // Verify nonce for security
        $nonce = isset($_REQUEST['nonce']) ? sanitize_text_field($_REQUEST['nonce']) : '';
        if (!wp_verify_nonce($nonce, 'search_nonce')) {
            wp_send_json_error(array(
                'message' => 'Unauthorized: Invalid security token'
            ), 403);
        }

        // Validate search term
        if (empty($_REQUEST['term'])) {
            wp_send_json_error(array(
                'message' => 'Error: Search term is missing!'
            ), 400);
        }

        // Sanitize and validate search term
        $search_term = sanitize_text_field($_REQUEST['term']);
        $search_term = trim($search_term);

        // Minimum search length check
        if (strlen($search_term) < 2) {
            wp_send_json_error(array(
                'message' => 'Search term too short. Minimum 2 characters required.'
            ), 400);
        }

        // Maximum search length check (prevent abuse)
        if (strlen($search_term) > 100) {
            wp_send_json_error(array(
                'message' => 'Search term too long. Maximum 100 characters allowed.'
            ), 400);
        }

        // Get allowed post types with filter
        $search_post_type = array('post', 'page', 'product', 'portfolio');
        $search_post_type = apply_filters('pixfort_search_post_type', $search_post_type);

        // Validate post types to prevent injection
        $search_post_type = array_filter($search_post_type, function ($post_type) {
            return post_type_exists($post_type);
        });

        // If no valid post types, return error
        if (empty($search_post_type)) {
            wp_send_json_error(array(
                'message' => 'No valid post types available for search.'
            ), 500);
        }

        $suggestions_count = 5;
        $suggestions_count = apply_filters('pixfort_search_suggestions_count', $suggestions_count);

        // Search arguments with security considerations
        // Using WP_Query instead of get_posts() to match WordPress default search behavior
        $args = array(
            'post_type'       => $search_post_type,
            'posts_per_page'  => $suggestions_count,
            'post_status'     => 'publish',
            's'               => $search_term,
            'orderby'         => 'relevance', // Match default WordPress search ordering
            'order'           => 'DESC',
            'no_found_rows'   => true, // Performance optimization
            'ignore_sticky_posts' => true, // Don't prioritize sticky posts in search
            'suppress_filters' => false // Allow filters for customization
        );

        // Allow filtering of search arguments
        $args = apply_filters('pixfort_search_args', $args, $search_term);

        try {
            // Retrieve posts using WP_Query to match WordPress default search behavior
            $search_query = new WP_Query($args);
            $suggestions = array();

            if ($search_query->have_posts()) {
                while ($search_query->have_posts()) {
                    $search_query->the_post();

                    // Verify user can read this post
                    if (!is_post_publicly_viewable(get_post())) {
                        continue;
                    }

                    $suggestion = array(
                        'value' => esc_url(get_permalink()),
                        'text'  => esc_html(get_the_title()),
                    );

                    // Add thumbnail if available
                    $thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
                    if ($thumbnail) {
                        $suggestion['icon'] = esc_url($thumbnail);
                    }

                    // Add post type for frontend filtering if needed
                    $suggestion['post_type'] = get_post_type();

                    $suggestions[] = $suggestion;
                }
                wp_reset_postdata();
            }

            // Apply filter to allow customization of suggestions
            $suggestions = apply_filters('pixfort_search_suggestions', $suggestions, $search_term, $search_query->posts);

            // Send successful response
            wp_send_json_success($suggestions);
        } catch (Exception $e) {
            // Log error and send generic error message
            error_log('PixFort Search Error: ' . $e->getMessage());
            wp_send_json_error(array(
                'message' => 'Search request failed. Please try again.'
            ), 500);
        }
    }

    /**
     * Retrieve an image URL from various input formats:
     * - Direct URL
     * - Attachment ID
     * - Attachment array with 'id' key
     *
     * @param mixed $image
     * @return string|false
     */
    public function getImageSrc($image, $size = 'full') {
        // Default return structure
        $output = array(
            'url'    => '',
            'width'  => 0,
            'height' => 0,
        );

        // If empty, return the defaults
        if (empty($image)) {
            return $output;
        }

        // Case 1: If $image is already a URL
        if (is_string($image) && substr($image, 0, 4) === 'http') {
            $output['url'] = $image;
            // Width and height remain 0 because we only know the raw URL
            return $output;
        }

        // Case 2: If $image is an array that contains 'id'
        if (is_array($image) && !empty($image['id'])) {
            $attachment_id = $image['id'];
        }
        // Case 3: If $image is numeric (attachment ID)
        elseif (is_numeric($image)) {
            $attachment_id = (int) $image;
        } else {
            if (!empty($image['url'])) {
                $output['url'] = $image['url'];
            }
            // If not a valid scenario, return defaults
            return $output;
        }

        // Retrieve attachment info (URL, width, height) via WP function
        $imgInfo = wp_get_attachment_image_src($attachment_id, $size);
        if (!empty($imgInfo)) {
            $output['url']    = $imgInfo[0];
            $output['width']  = isset($imgInfo[1]) ? (int) $imgInfo[1] : 0;
            $output['height'] = isset($imgInfo[2]) ? (int) $imgInfo[2] : 0;
        }

        // Retrieve the srcset for responsive images
        // $srcset = wp_get_attachment_image_srcset($attachment_id, $size);
        // if ($srcset) {
        //     $output['srcset'] = $srcset;
        // }

        return $output;
    }

    /**
     * Returns an <img> HTML string from either a WordPress attachment (ID or array with 'id') 
     * or a direct URL.
     *
     * @param mixed  $image           An attachment ID, an array with 'id' key, or a URL string.
     * @param string $size            Image size to use when fetching from WP. Defaults to 'full'.
     * @param array  $attributes      Optional. Additional attributes for the <img> tag 
     *                                (e.g., array('class' => 'my-image-class', 'alt' => '...')).
     *
     * @return string                 HTML for the <img> tag, or an empty string on failure.
     */
    public function getImage($image, $size = 'full', $attributes = []) {
        // If empty, return nothing.
        if (empty($image)) {
            return '';
        }

        /**
         * 1) If $image is already a URL (string starting with 'http'),
         *    generate a basic <img> tag manually.
         */
        if (is_string($image) && substr($image, 0, 4) === 'http') {
            // Ensure 'src' is set in our attributes array
            $attributes['src'] = $image;

            // Build the <img> tag attributes
            $html_attributes = $this->build_img_attributes($attributes);

            return '<img ' . $html_attributes . ' />';
        }

        /**
         * 2) If $image is an array with 'id', or a numeric ID,
         *    treat as a WordPress attachment.
         */
        $attachment_id = null;

        // Array with 'id'
        if (is_array($image) && !empty($image['id'])) {
            $attachment_id = (int) $image['id'];
            if (is_int($attachment_id)) {
                $attachment_id = apply_filters('wpml_object_id', $attachment_id, 'attachment', true);
            }
        }
        // Numeric
        elseif (is_numeric($image)) {
            $attachment_id = (int) $image;
            if (is_int($attachment_id)) {
                $attachment_id = apply_filters('wpml_object_id', $attachment_id, 'attachment', true);
            }
        }

        // If we do not have a valid ID, return nothing
        if (!$attachment_id) {
            return '';
        }

        // If the 'alt' attribute is defined but empty, remove it
        // so wp_get_attachment_image() can use the default alt instead.
        if (isset($attributes['alt']) && $attributes['alt'] === '') {
            unset($attributes['alt']);
        }

        // Pass any extra attributes to wp_get_attachment_image()
        $html = wp_get_attachment_image($attachment_id, $size, false, $attributes);

        // If wp_get_attachment_image() fails (e.g. invalid ID), return empty string
        return $html ? $html : '';
    }

    public function getImageDark($image, $size = 'full', $attributes = []) {
        if (!empty($image) && \PixfortCore::instance()->styleFunctions && \PixfortCore::instance()->styleFunctions->darkModeEnabled) {
            return $this->getImage($image, $size, $attributes);
        }
        return '';
    }

    public function newGetDynamicImage($image, $size = 'full', $attributes = [], $darkImage = null) {
        if (empty($image)) return '';

        if (\PixfortCore::instance()->styleFunctions && \PixfortCore::instance()->styleFunctions->darkModeEnabled && !empty($darkImage) && !empty($darkImage['id'])) {
            // Get light image information
            $lightImageInfo = $this->getImageSrc($image, $size);
            // Get dark image information
            $darkImageInfo = $this->getImageSrc($darkImage, $size);

            if (!empty($lightImageInfo['url']) && !empty($darkImageInfo['url'])) {
                // Create combined attributes with data attributes for both light and dark
                $combinedAttributes = $attributes;

                // Set main image attributes (light image as default)
                $combinedAttributes['src'] = $lightImageInfo['url'];
                if (!isset($combinedAttributes['alt'])) {
                    $combinedAttributes['alt'] = '';
                }
                if ($lightImageInfo['width'] > 0) {
                    $combinedAttributes['width'] = $lightImageInfo['width'];
                }
                if ($lightImageInfo['height'] > 0) {
                    $combinedAttributes['height'] = $lightImageInfo['height'];
                }

                // Add data attributes for light image
                $combinedAttributes['data-light-src'] = $lightImageInfo['url'];
                $combinedAttributes['data-light-alt'] = isset($attributes['alt']) ? $attributes['alt'] : '';
                if ($lightImageInfo['width'] > 0) {
                    $combinedAttributes['data-light-width'] = $lightImageInfo['width'];
                }
                if ($lightImageInfo['height'] > 0) {
                    $combinedAttributes['data-light-height'] = $lightImageInfo['height'];
                }

                // Add data attributes for dark image
                $combinedAttributes['data-dark-src'] = $darkImageInfo['url'];
                $combinedAttributes['data-dark-alt'] = isset($attributes['alt']) ? $attributes['alt'] : '';
                if ($darkImageInfo['width'] > 0) {
                    $combinedAttributes['data-dark-width'] = $darkImageInfo['width'];
                }
                if ($darkImageInfo['height'] > 0) {
                    $combinedAttributes['data-dark-height'] = $darkImageInfo['height'];
                }

                // Build the img tag with all attributes
                $html_attributes = $this->build_img_attributes($combinedAttributes);
                return '<img ' . $html_attributes . ' />';
            }
        }

        // Fallback to regular image output
        return $this->getImage($image, $size, $attributes);
    }

    public function getDynamicImage($image, $size = 'full', $attributes = [], $darkImage = null) {
        if (empty($image)) return '';
        $imageOutput = '';
        $imageOutputDark = '';
        if (\PixfortCore::instance()->styleFunctions->darkModeEnabled) {
            $lightClass = '';
            if (!empty($darkImage) && !empty($darkImage['id'])) {
                $darkAttributes = $attributes;
                $darkAttributes['class'] = (isset($attributes['class']) ? $attributes['class'] : '') . ' pix-dark-element';
                $imageOutputDark = $this->getImage($darkImage, $size, $darkAttributes);
                if (!empty($imageOutputDark)) {
                    $lightClass = 'pix-light-element';
                }
            }
            $lightAttributes = $attributes;
            if (!empty($lightClass)) {
                $lightAttributes['class'] = (isset($attributes['class']) ? $attributes['class'] : '') . ' ' . $lightClass;
            }
            $imageOutput = $this->getImage($image, $size, $lightAttributes);
        } else {
            $imageOutput = $this->getImage($image, $size, $attributes);
        }
        if (!empty($imageOutputDark)) {
            $imageOutput .= $imageOutputDark;
        }
        return $imageOutput;
    }

    /**
     * Helper to build an attributes string (e.g., key="value") for a custom <img> tag.
     *
     * @param array $attributes
     * @return string
     */
    private function build_img_attributes($attributes = array()) {
        // Default alt text if none is set
        if (!isset($attributes['alt'])) {
            $attributes['alt'] = '';
        }

        // Convert array of attributes into a string of key="value"
        // using proper escaping
        $attr_str = '';
        foreach ($attributes as $key => $value) {
            // Make sure we escape all attribute keys and values
            $attr_str .= sprintf(' %s="%s"', esc_attr($key), esc_attr($value));
        }

        return trim($attr_str);
    }

    /**
     * Get shadow/hover class names based on style, hover effect, and additional hover effect.
     *
     * @param string $style            The style key (e.g. '1', '2', '3', etc.).
     * @param string $hover_effect     The hover effect key.
     * @param string $add_hover_effect The additional hover effect key.
     *
     * @return string                  A space-separated string of class names.
     */
    function getEffectsClasses($style = '', $hover_effect = '', $add_hover_effect = '') {

        $style_arr = [
            ""  => "",
            "1" => "shadow-sm",
            "2" => "shadow",
            "3" => "shadow-lg",
            "4" => "shadow-inverse-sm",
            "5" => "shadow-inverse",
            "6" => "shadow-inverse-lg",
        ];
        $hover_effect_arr = [
            ""  => "",
            "1" => "shadow-hover-sm",
            "2" => "shadow-hover",
            "3" => "shadow-hover-lg",
            "4" => "shadow-inverse-hover-sm",
            "5" => "shadow-inverse-hover",
            "6" => "shadow-inverse-hover-lg",
        ];
        $add_hover_effect_arr = [
            ""  => "",
            "1" => "fly-sm",
            "2" => "fly",
            "3" => "fly-lg",
            "4" => "scale-sm",
            "5" => "scale",
            "6" => "scale-lg",
            "7" => "scale-inverse-sm",
            "8" => "scale-inverse",
            "9" => "scale-inverse-lg",
        ];

        $classes = [];

        // Check if the selected keys exist in the arrays before adding
        if (isset($style_arr[$style])) {
            $classes[] = $style_arr[$style];
        }

        if (isset($hover_effect_arr[$hover_effect])) {
            $classes[] = $hover_effect_arr[$hover_effect];
        }

        if (isset($add_hover_effect_arr[$add_hover_effect])) {
            $classes[] = $add_hover_effect_arr[$add_hover_effect];
        }

        // Join them into a space-separated string (trim in case of empty entries)
        $class_names = trim(implode(' ', array_filter($classes)));

        return $class_names;
    }

    function getColorsArray($options = []) {
        // Define default values
        $defaults = [
            'bg' => false,
            'mainLight' => false,
            'transparent' => false,
            'defaultValue' => false,
            'custom' => true,
            'defaultColors' => true,
            'gradients' => true,
            'blur' => false,
            'lightBasicText' => false,
            'advancedValues' => false,
            'dynamicBlur' => false,
        ];

        // Merge provided options with defaults
        $options = array_merge($defaults, $options);

        // Extract values for easier use
        $bg = $options['bg'];
        $mainLight = $options['mainLight'];
        $transparent = $options['transparent'];
        $defaultValue = $options['defaultValue'];
        $custom = $options['custom'];
        $defaultColors = $options['defaultColors'];
        $gradients = $options['gradients'];
        $blur = $options['blur'];
        $lightBasicText = $options['lightBasicText'];
        $advancedValues = $options['advancedValues'];
        $dynamicBlur = $options['dynamicBlur'];

        $colors = [];
        $mainColors = [];

        if ($defaultValue && is_array($defaultValue)) {
            foreach ($defaultValue as $key => $value) {
                $mainColors[$key] = $value;
            }
        }

        // Main colors
        if ($bg) {
            if ($defaultColors) {
                $mainColors = array_merge($mainColors, [
                    "body-default"            => __('Body default', 'pixfort-core'),
                    "heading-default"        => __('Heading default', 'pixfort-core'),
                ]);
            }

            $mainColors = array_merge($mainColors, [
                "primary"                => __('Primary', 'pixfort-core'),
                "primary-light"            => __('Primary Light', 'pixfort-core'),
                "secondary"                => __('Secondary', 'pixfort-core'),
                "secondary-light"        => __('Secondary Light', 'pixfort-core')
            ]);
            if ($gradients) {
                $mainColors = array_merge($mainColors, [
                    "gradient-primary"        => __('Primary Gradient', 'pixfort-core'),
                    "gradient-primary-light"    => __('Primary Gradient Light', 'pixfort-core'),
                ]);
            }
        } else {
            if ($defaultColors) {
                $mainColors = array_merge($mainColors, [
                    "body-default"            => __('Body default', 'pixfort-core'),
                    "heading-default"        => __('Heading default', 'pixfort-core')
                ]);
            }
            if ($mainLight) {
                $mainColors = array_merge($mainColors, [
                    "primary"                => __('Primary', 'pixfort-core'),
                    "primary-light"            => __('Primary Light', 'pixfort-core'),
                    "secondary"                => __('Secondary', 'pixfort-core'),
                    "secondary-light"        => __('Secondary Light', 'pixfort-core')
                ]);
            } else {
                $mainColors = array_merge($mainColors, [
                    "primary"                => __('Primary', 'pixfort-core'),
                    "secondary"                => __('Secondary', 'pixfort-core'),
                ]);
            }
            if ($gradients) {
                $mainColors = array_merge($mainColors, [
                    "gradient-primary"        => __('Primary Gradient', 'pixfort-core'),
                ]);
            }
        }



        // Initialize the colors array with Elementor optgroup structure
        $colors['main_colors'] = [
            'label' => __('Main Colors', 'pixfort-core'),
            'options' => $mainColors
        ];



        // Basic colors
        if ($bg) {
            $basicColors = [
                "white"                    => __('White', 'pixfort-core'),
                "black"                    => __('Black', 'pixfort-core'),
                "green"                    => __('Green', 'pixfort-core'),
                "green-light"            => __('Green Light', 'pixfort-core'),
                "blue"                    => __('Blue', 'pixfort-core'),
                "blue-light"            => __('Blue Light', 'pixfort-core'),
                "red"                    => __('Red', 'pixfort-core'),
                "red-light"                => __('Red Light', 'pixfort-core'),
                "yellow"                => __('Yellow', 'pixfort-core'),
                "yellow-light"            => __('Yellow Light', 'pixfort-core'),
                "brown"                    => __('Brown', 'pixfort-core'),
                "brown-light"            => __('Brown Light', 'pixfort-core'),
                "purple"                => __('Purple', 'pixfort-core'),
                "purple-light"            => __('Purple Light', 'pixfort-core'),
                "orange"                => __('Orange', 'pixfort-core'),
                "orange-light"            => __('Orange Light', 'pixfort-core'),
                "cyan"                    => __('Cyan', 'pixfort-core'),
                "cyan-light"            => __('Cyan Light', 'pixfort-core'),
                "gray-1"                => __('Gray 1', 'pixfort-core'),
                "gray-2"                => __('Gray 2', 'pixfort-core'),
                "gray-3"                => __('Gray 3', 'pixfort-core'),
                "gray-4"                => __('Gray 4', 'pixfort-core'),
                "gray-5"                => __('Gray 5', 'pixfort-core'),
                "gray-6"                => __('Gray 6', 'pixfort-core'),
                "gray-7"                => __('Gray 7', 'pixfort-core'),
                "gray-8"                => __('Gray 8', 'pixfort-core'),
                "gray-9"                => __('Gray 9', 'pixfort-core')
            ];
        } else {
            if ($lightBasicText) {
                $basicColors = [
                    "white"                    => __('White', 'pixfort-core'),
                    "black"                    => __('Black', 'pixfort-core'),
                    "green"                    => __('Green', 'pixfort-core'),
                    "green-light"            => __('Green Light', 'pixfort-core'),
                    "blue"                    => __('Blue', 'pixfort-core'),
                    "blue-light"            => __('Blue Light', 'pixfort-core'),
                    "red"                    => __('Red', 'pixfort-core'),
                    "red-light"                => __('Red Light', 'pixfort-core'),
                    "yellow"                => __('Yellow', 'pixfort-core'),
                    "yellow-light"            => __('Yellow Light', 'pixfort-core'),
                    "brown"                    => __('Brown', 'pixfort-core'),
                    "brown-light"            => __('Brown Light', 'pixfort-core'),
                    "purple"                => __('Purple', 'pixfort-core'),
                    "purple-light"            => __('Purple Light', 'pixfort-core'),
                    "orange"                => __('Orange', 'pixfort-core'),
                    "orange-light"            => __('Orange Light', 'pixfort-core'),
                    "cyan"                    => __('Cyan', 'pixfort-core'),
                    "cyan-light"            => __('Cyan Light', 'pixfort-core'),
                    "gray-1"                => __('Gray 1', 'pixfort-core'),
                    "gray-2"                => __('Gray 2', 'pixfort-core'),
                    "gray-3"                => __('Gray 3', 'pixfort-core'),
                    "gray-4"                => __('Gray 4', 'pixfort-core'),
                    "gray-5"                => __('Gray 5', 'pixfort-core'),
                    "gray-6"                => __('Gray 6', 'pixfort-core'),
                    "gray-7"                => __('Gray 7', 'pixfort-core'),
                    "gray-8"                => __('Gray 8', 'pixfort-core'),
                    "gray-9"                => __('Gray 9', 'pixfort-core')
                ];
            } else {
                $basicColors = [
                    "white"                    => __('White', 'pixfort-core'),
                    "black"                    => __('Black', 'pixfort-core'),
                    "green"                    => __('Green', 'pixfort-core'),
                    "blue"                    => __('Blue', 'pixfort-core'),
                    "red"                    => __('Red', 'pixfort-core'),
                    "yellow"                => __('Yellow', 'pixfort-core'),
                    "brown"                    => __('Brown', 'pixfort-core'),
                    "purple"                => __('Purple', 'pixfort-core'),
                    "orange"                => __('Orange', 'pixfort-core'),
                    "cyan"                    => __('Cyan', 'pixfort-core'),
                    "gray-1"                => __('Gray 1', 'pixfort-core'),
                    "gray-2"                => __('Gray 2', 'pixfort-core'),
                    "gray-3"                => __('Gray 3', 'pixfort-core'),
                    "gray-4"                => __('Gray 4', 'pixfort-core'),
                    "gray-5"                => __('Gray 5', 'pixfort-core'),
                    "gray-6"                => __('Gray 6', 'pixfort-core'),
                    "gray-7"                => __('Gray 7', 'pixfort-core'),
                    "gray-8"                => __('Gray 8', 'pixfort-core'),
                    "gray-9"                => __('Gray 9', 'pixfort-core')
                ];
            }
        }

        if ($transparent) {
            $basicColors['transparent'] = __('Transparent', 'pixfort-core');
        }

        $colors['basic_colors'] = [
            'label' => __('Basic Colors', 'pixfort-core'),
            'options' => $basicColors
        ];



        if (PixfortCore::instance()->getThemeParam('dynamic_colors')) {
            $dynamicColors = [
                "dynamic-heading"        => __('Dynamic Heading', 'pixfort-core'),
                "dynamic-background"    => __('Dynamic Background', 'pixfort-core'),
                "dynamic-gray-50"        => __('Dynamic Gray 50', 'pixfort-core'),
                "dynamic-gray-100"        => __('Dynamic Gray 100', 'pixfort-core'),
                "dynamic-gray-200"        => __('Dynamic Gray 200', 'pixfort-core'),
                "dynamic-gray-300"        => __('Dynamic Gray 300', 'pixfort-core'),
                "dynamic-gray-400"        => __('Dynamic Gray 400', 'pixfort-core'),
                "dynamic-gray-500"        => __('Dynamic Gray 500', 'pixfort-core'),
                "dynamic-gray-600"        => __('Dynamic Gray 600', 'pixfort-core'),
                "dynamic-gray-700"        => __('Dynamic Gray 700', 'pixfort-core'),
                "dynamic-gray-800"        => __('Dynamic Gray 800', 'pixfort-core'),
                "dynamic-gray-900"        => __('Dynamic Gray 900', 'pixfort-core'),
                "dynamic-gray-950"        => __('Dynamic Gray 950', 'pixfort-core'),
            ];




            $colors['dynamic_colors'] = [
                'label' => __('Dynamic Colors', 'pixfort-core'),
                'options' => $dynamicColors
            ];
        }
        if (PixfortCore::instance()->getThemeParam('custom_colors', false)) {

            // Custom colors
            $customColors = [];
            // if (!empty(pix_plugin_get_option('pix-enable-dynamic-colors'))) {
            $customColorsItems = pix_plugin_get_option('pix-custom-colors-items');
            if (!empty($customColorsItems)) {
                foreach ($customColorsItems as $color) {
                    if (is_array($color) || is_object($color)) {
                        $color = (array) $color;
                        $color_id = null;
                        $color_label = null;
                        if (isset($color['id']) && !empty($color['id'])) {
                            // $color_id = 'pix-c-'.$color['id'];
                            $color_id = 'c-' . $color['id'];
                        }
                        if (isset($color['label']) && !empty($color['label'])) {
                            $color_label = $color['label'];
                        }
                        if ($color_id && $color_label) {
                            $customColors[$color_id] = $color_label;
                        }
                    }
                }
            }
            // }

            // Add custom colors section if there are any custom colors

            if (!empty($customColors)) {
                $colors['custom_colors'] = [
                    'label' => __('Custom Colors', 'pixfort-core'),
                    'options' => $customColors
                ];
            }
        }

        $opacityColors = [
            "dark-opacity-1"        => __('Dark opacity 1', 'pixfort-core'),
            "dark-opacity-2"        => __('Dark opacity 2', 'pixfort-core'),
            "dark-opacity-3"        => __('Dark opacity 3', 'pixfort-core'),
            "dark-opacity-4"        => __('Dark opacity 4', 'pixfort-core'),
            "dark-opacity-5"        => __('Dark opacity 5', 'pixfort-core'),
            "dark-opacity-6"        => __('Dark opacity 6', 'pixfort-core'),
            "dark-opacity-7"        => __('Dark opacity 7', 'pixfort-core'),
            "dark-opacity-8"        => __('Dark opacity 8', 'pixfort-core'),
            "dark-opacity-9"        => __('Dark opacity 9', 'pixfort-core'),
            "light-opacity-1"        => __('Light opacity 1', 'pixfort-core'),
            "light-opacity-2"        => __('Light opacity 2', 'pixfort-core'),
            "light-opacity-3"        => __('Light opacity 3', 'pixfort-core'),
            "light-opacity-4"        => __('Light opacity 4', 'pixfort-core'),
            "light-opacity-5"        => __('Light opacity 5', 'pixfort-core'),
            "light-opacity-6"        => __('Light opacity 6', 'pixfort-core'),
            "light-opacity-7"        => __('Light opacity 7', 'pixfort-core'),
            "light-opacity-8"        => __('Light opacity 8', 'pixfort-core'),
            "light-opacity-9"        => __('Light opacity 9', 'pixfort-core'),
        ];

        $colors['opacity_colors'] = [
            'label' => __('Opacity Colors', 'pixfort-core'),
            'options' => $opacityColors
        ];


        $advancedColors = [];
        if ($blur) {
            $advancedColors['dark-blur'] = __('Dark blur', 'pixfort-core');
            $advancedColors['light-blur'] = __('Light blur', 'pixfort-core');
        }

        if ($dynamicBlur) {
            $advancedColors = array_merge($advancedColors, [
                "dynamic-blur"        => __('Dynamic Blur', 'pixfort-core'),
            ]);
        }


        if ($advancedValues && is_array($advancedValues)) {
            foreach ($advancedValues as $key => $value) {
                $advancedColors[$key] = $value;
            }
        }


        // Add the custom option in its own section
        if ($custom) {
            $advancedColors['custom'] = __('Custom', 'pixfort-core');
        }

        if (!empty($advancedColors)) {
            $colors['advanced'] = [
                'label' => __('Advanced', 'pixfort-core'),
                'options' => $advancedColors
            ];
        }

        return $colors;
    }
}
