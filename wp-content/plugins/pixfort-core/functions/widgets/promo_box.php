<?php

// Creating the widget
class pix_promo_box extends WP_Widget {
    function __construct() {
        parent::__construct(
            // Base ID of your widget
            'pix_promo_box',
            // Widget name will appear in UI
            __('pixfort Legacy Promo Box', 'pixfort-core'),
            // Widget description
            [
                'description' => __('Promo Box widget', 'pixfort-core'),
                'show_instance_in_rest' => true
            ]
        );
    }
    // Creating widget front-end
    public function widget($args, $instance) {
        $title = apply_filters('widget_title', $instance['title']);
        $bg_img = apply_filters('widget_title', $instance['bg_img']);
        $badge = apply_filters('widget_title', $instance['badge']);
        $heading = apply_filters('widget_title', $instance['heading']);
        $link_text = apply_filters('widget_title', $instance['link_text']);
        $link = apply_filters('widget_title', $instance['link']);
        if (empty($instance['blank'])) $instance['blank'] = '';
        $blank = apply_filters('widget_title', $instance['blank']);

        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if (!empty($title)) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        $attrs = array(
            'image'  => $bg_img,
            'link_text'  => $link_text,
            'title'  => $heading,
            'link'     => $link,
            'target'     => $blank,
            'badge'     => $badge,
            'rounded_img'  => 'rounded-xl',
            'title_size'        => 'h4',
            'animation'     => 'fade-in',
            'delay'     => '200',
            'height'     => '350px',
            'badge_text_color'     => 'light-opacity-5',
            'badge_bg_color'     => 'dark-opacity-5',
            'custom_css'    => 'padding:5px 10px;margin-right:3px;line-height:12px;',
        );
        echo \PixfortCore::instance()->elementsManager->renderElement('PromoBox', $attrs );
        echo $args['after_widget'];
    }

    // Widget Backend
    public function form($instance) {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('Promo Box', 'pixfort-core');
        }
        if (isset($instance['heading'])) {
            $heading = $instance['heading'];
        } else {
            $heading = __('Promo box heading', 'pixfort-core');
        }
        if (isset($instance['badge'])) {
            $badge = $instance['badge'];
        } else {
            $badge = '';
        }
        if (isset($instance['link_text'])) {
            $link_text = $instance['link_text'];
        } else {
            $link_text = __('Check it out', 'pixfort-core');
        }
        if (isset($instance['link'])) {
            $link = $instance['link'];
        } else {
            $link = '#';
        }
        $blankChecked = '';
        if (isset($instance['blank'])) {
            $blank = $instance['blank'];
            if (!empty($blank)) {
                $blankChecked = 'checked';
            }
        } else {
            $blank = '';
        }
        if (isset($instance['bg_img'])) {
            $bg_img = $instance['bg_img'];
        } else {
            $bg_img = '';
        }
        $image = !$bg_img ? '' : wp_get_attachment_image($bg_img, 'thumbnail', false, array('style' => 'max-width:300px;height:auto;margin-top:20px;'));

        // Widget admin form
?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat promo-widget-title" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('heading'); ?>"><?php _e('Heading:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('heading'); ?>" name="<?php echo $this->get_field_name('heading'); ?>" type="text" value="<?php echo esc_attr($heading); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('badge'); ?>"><?php _e('Badge text (Optional):'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('badge'); ?>" name="<?php echo $this->get_field_name('badge'); ?>" type="text" value="<?php echo esc_attr($badge); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('link_text'); ?>"><?php _e('Link text:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('link_text'); ?>" name="<?php echo $this->get_field_name('link_text'); ?>" type="text" value="<?php echo esc_attr($link_text); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Link:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo esc_attr($link); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('blank'); ?>"><?php _e('Open in a new tab?'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('blank'); ?>" name="<?php echo $this->get_field_name('blank'); ?>" type="checkbox" value="_blank" <?php echo esc_attr($blankChecked); ?> />
        </p>
        <input class="widefat meta-box-upload-value" id="<?php echo $this->get_field_id('bg_img'); ?>" name="<?php echo $this->get_field_name('bg_img'); ?>" type="hidden" value="<?php echo esc_attr($bg_img); ?>" />
        <button class="meta-box-upload-button button button-primary">Background image</button>
        <input type='button' id='$name-remove' class='button meta-box-upload-button-remove' value='Remove' />
        <div class='image-preview'><?php echo $image; ?></div>
<?php
    }

    // Updating widget replacing old instances with new
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['heading'] = (!empty($new_instance['heading'])) ? strip_tags($new_instance['heading']) : '';
        $instance['badge'] = (!empty($new_instance['badge'])) ? strip_tags($new_instance['badge']) : '';
        $instance['link_text'] = (!empty($new_instance['link_text'])) ? strip_tags($new_instance['link_text']) : '';
        $instance['link'] = (!empty($new_instance['link'])) ? strip_tags($new_instance['link']) : '';
        $instance['blank'] = (!empty($new_instance['blank'])) ? strip_tags($new_instance['blank']) : '';
        $instance['bg_img'] = (!empty($new_instance['bg_img'])) ? strip_tags($new_instance['bg_img']) : '';
        return $instance;
    }
}
