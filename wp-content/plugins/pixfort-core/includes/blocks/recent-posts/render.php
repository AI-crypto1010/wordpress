<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Make sure WP_Query is available
if (!class_exists('WP_Query')) {
    require_once(ABSPATH . 'wp-includes/class-wp-query.php');
}
if (!function_exists('render_pix_recent_posts_block')) {
    function render_pix_recent_posts_block($attributes) {
        // $title = isset($attributes['title']) ? $attributes['title'] : '';
        $count = isset($attributes['count']) ? $attributes['count'] : 3;

        ob_start();

        // if (!empty($title)) {
        //     echo '<h5 class="font-weight-bold text-heading-default pix-mb-10">' . esc_html($title) . '</h5>';
        // }

        $query = new WP_Query(array(
            'posts_per_page' => $count,
            'post_status' => 'publish',
            'ignore_sticky_posts' => true,
        ));
        $imgDivStyle = 'top: 50%; left: 50%; transform: translate(-50%, -50%);z-index:-1;';
		if(is_rtl()) {
			$imgDivStyle = 'top: 50%; right: 50%; transform: translate(50%, -50%);z-index:-1;';
		}

        if ($query->have_posts()) :
            echo '<div class="recent-posts-block d-flex flex-column">';
            $post_count = $query->post_count;
            $current_post = 0;
            while ($query->have_posts()) :
                $query->the_post();
                $current_post++;
                $is_last_item = ($current_post == $post_count);
                $thumb = get_the_post_thumbnail_url();
                $img_src = '';
                if ($thumb && $thumb != '') {
                    $img_attrs = array(
                        'class' => 'card-img pix-opacity-5 img-fluid pix-fit-cover pix-img-scale',
                        'style' => 'width:100%;',
                        'alt' => esc_attr(get_the_title() ? get_the_title() : get_the_ID())
                    );
                    $full_image_url = wp_get_attachment_image(get_post_thumbnail_id(), 'pix-blog-small', false, $img_attrs);
                    $img_src = $full_image_url;
                }
?>
                <div class="position-relative d-inline-block w-100">
                    <div class="w-100 overflow-hidden pix-hover-item shadow shadow-hover fly-sm d-block <?php echo (!$is_last_item) ? 'pix-mb-10' : ''; ?> rounded-xl">
                        <div class="card bg-gray-9">
                            <div class="align-self-center pix-opacity-4 pix-hover-opacity-6 position-absolute pix-fit-cover w-100" style="<?php echo $imgDivStyle; ?>">
                                <?php echo $img_src; ?>
                            </div>
                            <div class="pix-p-20 d-flex flex-wrap h-100">
                                <div class="d-flex align-items-center justify-content-between w-100">
                                    <a class="pix-opacity-7 pix-hover-opacity-10" href="<?php the_permalink(); ?>">
                                        <h6 class="card-title text-gray-1 mb-0 font-weight-bold line-clamp-2">
                                            <?php echo get_the_title() ? get_the_title() : get_the_ID(); ?>
                                        </h6>
                                    </a>
                                    <div class="d-inline position-relative" style="min-width:40px;">
                                        <div class="pl-2 d-inline position-relative justify-content-sm-center text-right" style="min-width:40px;">
                                            <?php
                                            if (function_exists('get_pixfort_likes')) {
                                                echo get_pixfort_likes();
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                                        </div>
<?php
            endwhile;
            echo '</div>';
            wp_reset_postdata();
        endif;

        return ob_get_clean();
    }
}
echo render_pix_recent_posts_block($attributes);
