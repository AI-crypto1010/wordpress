<?php

/**
 * Renders the Categories block
 *
 * @param array $attributes The block attributes.
 * @return string The block HTML.
 */
if (!function_exists('pixfort_core_render_categories_block')) {
    function pixfort_core_render_categories_block($attributes) {
        ob_start();
?>
        <div <?php echo get_block_wrapper_attributes(); ?>>
            <div class="pix_categories_widget">
                <?php foreach (get_categories() as $category) : ?>
                    <a href="<?php echo esc_url(get_category_link($category)); ?>" class="d-flex align-items-center w-100 justify-content-center bg-white shadow-sm shadow-hover-sm fly-sm rounded-lg pix-mb-10 pix-p-5 text-center text-sm font-weight-bold text-body-default">
                        <?php echo esc_html($category->name); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
<?php

        return ob_get_clean();
    }
}
echo pixfort_core_render_categories_block($attributes);
