<?php

/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package pixfort theme
 */
function pixfort_custom_404_title($title) {
	if (is_404()) {
		if (!empty(pix_get_option('pix-enable-custom-404')) && !empty(pix_get_option('pix-custom-404-page'))) {
			$page = pix_get_option('pix-custom-404-page');
			if (function_exists('icl_get_languages')) {
				$correct_id = apply_filters('wpml_object_id', $page, 'page', true);
				$post = get_post($correct_id);
			} else {
				$post = get_post($page);
			}
			if ($post && !empty($post->ID)) {
				$title['title'] = get_the_title($post->ID); // Change to your desired title
			}
		}
	}
	return $title;
}
add_filter('document_title_parts', 'pixfort_custom_404_title');
get_header();

$classes = '';
$styles = '';
if (!empty(pix_get_option('pages-bg-color'))) {
	if (pix_get_option('pages-bg-color') == 'custom') {
		$styles = 'background:' . pix_get_option('custom-pages-bg-color') . ';';
	} else {
		$classes = 'bg-' . pix_get_option('pages-bg-color') . ' ';
	}
}

$page = false;
$pageID = false;
$hide_top_area = false;
$add_intro_placeholder = false;
if (!empty(pix_get_option('pix-enable-custom-404')) && !empty(pix_get_option('pix-custom-404-page'))) {
	$page = pix_get_option('pix-custom-404-page');
	if (function_exists('icl_get_languages')) {
		$correct_id = apply_filters('wpml_object_id', $page, 'page', true);
		$post = get_post($correct_id);
	} else {
		$post = get_post($page);
	}
	if ($post && !empty($post->ID)) {
		$pageID = $post->ID;
		if (get_post_meta($pageID, 'pix-hide-top-area', true)) {
			if (get_post_meta($pageID, 'pix-hide-top-area', true) === '1') {
				$hide_top_area = true;
			}
		}
		if (pix_should_add_top_padding($pageID)) {
			$classes .= 'pt-5';
		}
	}

	if (!$hide_top_area) get_template_part('template-parts/intro');
} else {
	$classes .= ' text-center pix-py-100';
	if (empty(pix_get_option('pages-with-intro')) || !pix_get_option('pages-with-intro')) {
		$hide_top_area = true;
		$add_intro_placeholder = true;
	}

	if (!$hide_top_area) {
		if (pix_get_option('pix-header')) {
			$single_header = pix_get_option('pix-header');
			if (!empty($single_header)) {
				$post = get_post($single_header);
				if (!empty(get_post_field('pix-header-style', $post))) {
					$header_style = get_post_field('pix-header-style', $post);
					if (!empty($header_style)) {
						if (
							$header_style == 'boxed'
							|| $header_style == 'boxed-full'
							|| $header_style == 'transparent'
							|| $header_style == 'transparent-full'
						) {
							get_template_part('template-parts/intro');
						}
					}
				}
			}
		}
	}
}

$containerClass = 'container';
if (class_exists('\Elementor\Plugin')) {
	$document = Elementor\Plugin::instance()->documents->get(get_the_ID());
	if (is_object($document) && method_exists($document, 'is_built_with_elementor')) {
		if ($document->is_built_with_elementor()) {
			$containerClass = 'container-fluid px-0';
		}
	}
}

?>

<div id="content" class="site-content <?php echo esc_attr($classes); ?> error-404 not-found" style="<?php echo esc_attr($styles); ?>">
	<div class="<?php echo esc_attr($containerClass); ?>">
		<div class="row">
			<?php
			if ($add_intro_placeholder) {
			?>
				<div class="pix-main-intro-placeholder"></div>
			<?php
			}
			if ($page) {
			?>
				<div class="col-12 my-0 py-0">
					<?php
					// Elementor
					if (get_post_status($page)) {
						setup_postdata($page);
						the_content();
					}
					wp_reset_postdata();
					?>
				</div>
			<?php
			} else {
			?>
				<header class="page-header w-100">
					<div class="w-100">
						<img src="<?php echo esc_url(get_template_directory_uri()) . '/inc/images/404.svg'; ?>" />
						<?php
						if (class_exists('PixfortCore')) {
							echo \PixfortCore::instance()->elementsManager->renderElement('SlidingText', [
								'position'  => 'inherit',
								'size'  => 'h1',
								'secondary_font'  => 'secondary-font',
								'el_class'  => 'page-title2 h4 pix-mt-10 font-weight-bold',
								'el_id'  => 'pix-intro-sliding-text',
								'remove_mb'  => true
							],  esc_html('Oops! That page can&rsquo;t be found.', 'conseil'));
						} else {
						?>
							<h4 class="page-title2 pix-mt-10 font-weight-bold"><?php esc_html_e('Oops! That page can&rsquo;t be found.', 'conseil'); ?></h4>
						<?php
						}
						?>

					</div>
				</header><!-- .page-header -->
				<div class="page-content text-center w-100 pix-pt-20">
					<?php
					if (class_exists('PixfortCore')) {
					?>
						<p><?php esc_html_e('It looks like nothing was found at this location. Maybe try a search?', 'conseil'); ?></p>
					<?php
					echo \PixfortCore::instance()->elementsManager->renderElement('Search', [
						'max_width'		=> '600px'
					] );
					}
					?>
				</div>
			<?php } ?>
		</div>
	</div>
</div>
<?php
get_footer();
