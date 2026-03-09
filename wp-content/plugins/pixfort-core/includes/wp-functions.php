<?php

/**
 * Functions which enhance the site by hooking into WordPress
 *
 * @package pixfort core
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
if (!function_exists('pix_body_classes')) {
	function pix_body_classes($classes) {
		// Adds a class of hfeed to non-singular pages.
		if (! is_singular()) {
			$classes[] = 'hfeed';
		}

		// Adds a class of no-sidebar when there is no sidebar present.
		if (! is_active_sidebar('sidebar-1')) {
			$classes[] = 'no-sidebar';
		}

		if (pix_plugin_get_option('pix-body-padding') && pix_plugin_get_option('pix-body-padding') !== 'none') {
			$classes[] = ' pix-padding-style ';
			$classes[] = pix_plugin_get_option('pix-body-padding');
			if (pix_plugin_get_option('pix-use-clip-path')) {
				$classes[] = ' use-clip-path ';
			}
		}
		if (pix_plugin_get_option('pix-body-bg-color')) {
			if (pix_plugin_get_option('pix-body-bg-color') != 'custom') {
				$classes[] = ' bg-' . pix_plugin_get_option('pix-body-bg-color');
			}
		}
		if (pix_plugin_get_option('pix-boxed-layout')) {
			$classes[] = ' pix-boxed-layout';
		}

		if (!is_archive() && !is_search()) {
			if (get_post_meta(get_the_ID(), 'pix-sections-stack', true) && get_post_meta(get_the_ID(), 'pix-sections-stack', true) !== 'false') {
				$classes[] = ' pix-sections-stack ';
			}
		}
		if (pix_plugin_get_option('pix-sticky-footer')) {
			$classes[] = ' pix-is-sticky-footer ';
		}
		if (get_post_meta(get_the_ID(), 'pix-sections-stack-dark', true)) {
			$classes[] = ' pix-dark-v-nav ';
		}
		// if(pix_plugin_get_option('pix-exit-popup')){
		//     if( function_exists( 'pix_show_exit_popup' ) && pix_show_exit_popup() ) {
		//         $classes[] = ' pix-exit-popup';
		//     }
		// }
		// if(pix_plugin_get_option('pix-automatic-popup')){
		//     if( function_exists( 'pix_show_automatic_popup' ) && pix_show_automatic_popup() ){
		//         $classes[] = ' pix-auto-popup';
		//     }
		// }
		if (pix_plugin_get_option('site-disable-loading-bar')) {
			$classes[] = ' pix-disable-loading-bar';
		}
		$pageTransition = 'default';
		if (!empty(pix_plugin_get_option('site-page-transition'))) {
			$pageTransition = pix_plugin_get_option('site-page-transition');
		}
		$classes[] = ' site-render-' . $pageTransition;
		// if(pix_plugin_get_option('pix-custom-boxed')){
		// $classes[] = ' pix-custom-boxed-layout';
		// }

		return $classes;
	}
}
add_filter('body_class', 'pix_body_classes');


if (!function_exists('pix_filter_excerpt')) {
	function pix_filter_excerpt($excerpt) {
		$excerpt = strip_shortcodes($excerpt);
		return $excerpt;
	}
}
add_filter('get_the_excerpt', 'pix_filter_excerpt');

if (!function_exists('pix_custom_excerpt_length')) {
	function pix_custom_excerpt_length($length) {
		return 40;
	}
}
add_filter('excerpt_length', 'pix_custom_excerpt_length', 999);

function pixfort_new_excerpt_more($more) {
	return '...';
}
add_filter('excerpt_more', 'pixfort_new_excerpt_more');

/**
 * Adds custom classes to the tag cloud widget.
 *
 * @param array $classes Classes for the widget links.
 * @return array
 */
function pixfort_tagcloud_classes($tag_data) {
	return array_map(
		function ($item) {
			$item['class'] .= ' btn btn-sm pix-mr-5 pix-my-5 btn-white rounded-xl text-body-default text-sm shadow-sm shadow-hover-sm fly-sm font-weight-bold';
			$item['font_size'] = 14;
			return $item;
		},
		(array) $tag_data
	);
}
add_filter('wp_generate_tag_cloud_data', 'pixfort_tagcloud_classes');

/**
 * Modifies tag cloud widget arguments to display all tags in the same font size
 * and use list format for better accessibility.
 *
 * @param   array $args Arguments for tag cloud widget.
 * @return  array The filtered arguments for tag cloud widget.
 */
function pixfort_widget_tag_cloud_args($args) {
	$args['largest']  = 16;
	$args['smallest'] = 16;
	$args['unit']     = 'px';
	return $args;
}
add_filter('widget_tag_cloud_args', 'pixfort_widget_tag_cloud_args');


/**
 * WPML
 */
add_filter('wpml_pb_shortcode_encode', 'pix_wpml_pb_shortcode_encode_urlencoded_json', 10, 3);
if (!function_exists('pix_wpml_pb_shortcode_encode_urlencoded_json')) {
	function pix_wpml_pb_shortcode_encode_urlencoded_json($string, $encoding, $original_string) {
		if ('urlencoded_json' === $encoding) {
			$output = array();
			foreach ($original_string as $combined_key => $value) {
				$parts = explode('_', $combined_key);
				$i = array_pop($parts);
				$key = implode('_', $parts);
				$output[$i][$key] = $value;
			}
			$string = urlencode(json_encode($output));
		}
		return $string;
	}
}

add_filter('wpml_pb_shortcode_decode', 'pix_wpml_pb_shortcode_decode_urlencoded_json', 10, 3);
if (!function_exists('pix_wpml_pb_shortcode_decode_urlencoded_json')) {
	function pix_wpml_pb_shortcode_decode_urlencoded_json($string, $encoding, $original_string) {
		if ('urlencoded_json' === $encoding) {
			$rows = json_decode(urldecode($original_string), true);
			$string = array();
			foreach ($rows as $i => $row) {
				foreach ($row as $key => $value) {
					$string[$key . '_' . $i] = array('value' => $value, 'translate' => true);
				}
			}
		}
		return $string;
	}
}



/**
 * Add custom styles to the WordPress embed template
 */
function pixfort_custom_embed_styles() {
	wp_add_inline_style(
		'wp-embed-template',
		'.wp-embed {
            border-radius: 15px;
        }
        .wp-embed-featured-image img {
            border-radius: 5px;
            overflow: hidden;
        }'
	);
}
add_action('embed_head', 'pixfort_custom_embed_styles');

/**
 * Filters the thumbnail image size for embeds.
 *
 * @param string|int[] $image_size Image size or array of width and height values.
 * @return string Image size string. Use 'large', 'full', or a custom registered size.
 */
function pixfort_custom_embed_thumbnail_size($image_size) {
	// You can change 'large' to 'full' or any other registered image size.
	return 'full';
}
add_filter('embed_thumbnail_image_size', 'pixfort_custom_embed_thumbnail_size');



if (! function_exists('pixfortGetBreadcrumbs')) {
	function pixfortGetBreadcrumbs($align = 'justify-content-start', $color = 'body-default', $animation = '') {
		$link_classes = 'text-' . $color;
		$active_link_classes = 'text-' . $color;
		global $post;
		global $woocommerce;
		$homeURL = esc_url(home_url('/'));
		$homeTitle = esc_attr__('Home', 'pixfort-core');
		if ($woocommerce && (is_product() || is_product_category() || is_checkout() || is_cart())) {
			$shopPage = wc_get_page_id('shop');
			$homeTitle = get_the_title($shopPage);
			$homeURL = get_permalink($shopPage);
		} elseif (get_post_type() === 'post' && (is_single() || is_tag())) {
			$blog_page_id = get_option('page_for_posts');
			if (!empty($blog_page_id) && $blog_page_id) {
				$homeURL = get_permalink($blog_page_id);
				$homeTitle = get_the_title($blog_page_id);
			}
		}
		/* RTL */
		$arrowIcon = 'Line/pixfort-icon-arrow-right-2';
		$margin1 = 'mr-1';
		$animationClass = '';
		$animationType = '';
		if ($animation === 'default') {
			$animationType = 'fade-in-left';
			$animationClass = 'animate-in';
			if (is_rtl()) {
				$arrowIcon = 'Line/pixfort-icon-arrow-left-2';
				$margin1 = 'ml-1';
				$animationType = 'fade-in-right';
			}
		} else if ($animation !== '') {
			$animationType = $animation;
			$animationClass = 'animate-in';
		}

		$delay = 500;
		if (!is_front_page()) {
			// Start the breadcrumb with a link to your homepage
?>
			<nav class="text-center" aria-label="breadcrumb">
				<ol class="breadcrumb px-0 mb-0 <?php echo esc_attr($align); ?>">
					<li class="breadcrumb-item <?php echo esc_attr($animationClass); ?>" data-anim-type="<?php echo esc_attr($animationType); ?>" data-anim-delay="<?php echo esc_attr($delay); ?>"><a class="<?php echo esc_attr($link_classes); ?>" href="<?php echo esc_url($homeURL); ?>"><?php echo esc_html($homeTitle); ?></a></li>
					<?php
					// Check if the current page is a category, an archive or a single page. If so show the category or archive name.
					if (is_category() || is_tag() || is_single()) {
						$customCats = array(
							'portfolio'	=> 'portfolio-types'
						);
						$customCats = apply_filters('pixfort/custom_types/categories', $customCats);
						if (array_key_exists(get_post_type(), $customCats)) {
							$portfolio_category = get_the_terms($post->ID, $customCats[get_post_type()]);
							if (!empty($portfolio_category)) $portfolio_category = $portfolio_category[0];
							$portfolio_parents = array();
							while ($portfolio_category) {
								array_push($portfolio_parents, $portfolio_category);
								if (!empty($portfolio_category->parent)) {
									$portfolio_category = $portfolio_category->parent;
									$portfolio_category = get_term($portfolio_category, $customCats[get_post_type()]);
								} else {
									$portfolio_category = false;
								}
							}
							$portfolio_parents = array_reverse($portfolio_parents);
							foreach ($portfolio_parents as $key => $parent_cat) {
								$delay += 50;
					?>
								<li class="breadcrumb-item <?php echo esc_attr($animationClass); ?>" data-anim-type="<?php echo esc_attr($animationType); ?>" data-anim-delay="<?php echo esc_attr($delay); ?>">
									<span>
										<?php
										echo \PixfortCore::instance()->icons->getIcon($arrowIcon, 24, esc_attr($link_classes) . ' ' . $margin1);
										?>
									</span>
									<a class="<?php echo esc_attr($link_classes); ?>" href="<?php echo esc_url(get_term_link($parent_cat)); ?>"><?php echo esc_html($parent_cat->name); ?></a>
								</li>
								<?php
							}
						} else {
							// Get the category based on the current context
							$cat = null;
							if (is_category()) {
								// On category archive page, get the current category
								$cat = get_queried_object();
							} elseif (is_single() && get_the_category()) {
								// On single post, get the first category of the post
								$cat = get_the_category()[0];
							}
							if ($cat) {
								$parents = array();
								while ($cat) {
									array_push($parents, $cat);
									if (!empty($cat->parent)) {
										$cat = $cat->parent;
										$cat = get_category($cat);
									} else {
										$cat = false;
									}
								}
								$parents = array_reverse($parents);
								foreach ($parents as $key => $parent_cat) {
									$delay += 50;
								?>
									<li class="breadcrumb-item <?php echo esc_attr($animationClass); ?>" data-anim-type="<?php echo esc_attr($animationType); ?>" data-anim-delay="<?php echo esc_attr($delay); ?>">
										<span>
											<?php
											echo \PixfortCore::instance()->icons->getIcon($arrowIcon, 24, esc_attr($link_classes) . ' ' . $margin1);
											?>
										</span>
										<a class="<?php echo esc_attr($link_classes); ?>" href="<?php echo esc_url(get_category_link($parent_cat)); ?>"><?php echo esc_html($parent_cat->cat_name); ?></a>
									</li>
						<?php
								}
							}
						}
					}

					// Handle tag archive pages
					if (is_tag()) {
						$tag = get_queried_object();
						if ($tag) {
							$delay += 50;
							?>
							<li class="breadcrumb-item <?php echo esc_attr($active_link_classes); ?> active <?php echo esc_attr($animationClass); ?>" data-anim-type="<?php echo esc_attr($animationType); ?>" data-anim-delay="<?php echo esc_attr($delay); ?>" aria-current="page">
								<span><?php
										echo \PixfortCore::instance()->icons->getIcon($arrowIcon, 24, 'position-relative2 ' . $margin1);
										?></span>
								<?php echo esc_html($tag->name); ?>
							</li>
							<?php
						}
					}
					
					// If the current page is a single post, show its title with the separator
					if ($woocommerce && (is_shop())) {
						?>
						<li class="breadcrumb-item <?php echo esc_attr($active_link_classes); ?> active <?php echo esc_attr($animationClass); ?>" data-anim-type="<?php echo esc_attr($animationType); ?>" data-anim-delay="600" aria-current="page">
							<span><?php
									echo \PixfortCore::instance()->icons->getIcon($arrowIcon, 24, 'position-relative2 ' . $margin1);
									?></span>
							<?php echo esc_attr(woocommerce_page_title(false)); ?>
						</li>
						<?php

					}
					if ($woocommerce && (is_product() || is_product_category())) {
						if (is_product_category()) {
							$product_cat = $GLOBALS['wp_query']->get_queried_object();
						} else {
							$product_cat = get_the_terms($post->ID, 'product_cat');
							if (!empty($product_cat)) $product_cat = $product_cat[0];
						}
						$product_parents = array();
						while ($product_cat) {
							array_push($product_parents, $product_cat);
							if (!empty($product_cat->parent)) {
								$product_cat = $product_cat->parent;
								$product_cat = get_term($product_cat, 'product_cat');
							} else {
								$product_cat = false;
							}
						}
						$product_parents = array_reverse($product_parents);
						foreach ($product_parents as $key => $parent_cat) {
							$delay += 100;
						?>
							<li class="breadcrumb-item <?php echo esc_attr($animationClass); ?>" data-anim-type="<?php echo esc_attr($animationType); ?>" data-anim-delay="<?php echo esc_attr($delay); ?>">
								<span>
									<?php
									echo \PixfortCore::instance()->icons->getIcon($arrowIcon, 24, esc_attr($link_classes) . ' ' . $margin1);
									?>
								</span>

								</span>
								<a class="<?php echo esc_attr($link_classes); ?>" href="<?php echo esc_url(get_term_link($parent_cat)); ?>"><?php echo esc_html($parent_cat->name); ?></a>
							</li>
						<?php
						}
					}


					if (is_single() && !is_attachment()) {


						$delay += 50;
						?>
						<li class="breadcrumb-item <?php echo esc_attr($active_link_classes); ?> active <?php echo esc_attr($animationClass); ?>" data-anim-type="<?php echo esc_attr($animationType); ?>" data-anim-delay="<?php echo esc_attr($delay); ?>" aria-current="page">
							<span><?php
									echo \PixfortCore::instance()->icons->getIcon($arrowIcon, 24, 'position-relative2 ' . $margin1);
									?></span>
							<?php the_title(); ?>
						</li>
					<?php
					} elseif (is_page() && !$post->post_parent) {
						$delay += 50;
					?>
						<li class="breadcrumb-item <?php echo esc_attr($active_link_classes); ?> active <?php echo esc_attr($animationClass); ?>" data-anim-type="<?php echo esc_attr($animationType); ?>" data-anim-delay="<?php echo esc_attr($delay); ?>" aria-current="page">
							<span>
								<?php
								echo \PixfortCore::instance()->icons->getIcon($arrowIcon, 24, 'position-relative2 ' . $margin1);
								?>
							</span>
							<?php the_title(); ?>
						</li>
						<?php

					} elseif (is_page() && $post->post_parent) {
						$parent_id  = $post->post_parent;
						$parents = array();
						while ($parent_id) {
							$page = get_page($parent_id);
							array_push($parents, $page->ID);
							$parent_id  = $page->post_parent;
						}
						$parents = array_reverse($parents);
						foreach ($parents as $key => $parent_el) {
							$delay += 50;
						?>
							<li class="breadcrumb-item <?php echo esc_attr($link_classes); ?> <?php echo esc_attr($animationClass); ?>" data-anim-type="<?php echo esc_attr($animationType); ?>" data-anim-delay="<?php echo esc_attr($delay); ?>" aria-current="page">
								<a class="<?php echo esc_attr($link_classes); ?>" href="<?php echo get_permalink($parent_el); ?>">
									<span>
										<?php
										echo \PixfortCore::instance()->icons->getIcon($arrowIcon, 24, 'position-relative2 ' . $margin1);
										?>
									</span>
									<?php echo get_the_title($parent_el); ?>
								</a>
							</li>
						<?php
						}
						$delay += 50;
						?>
						<li class="breadcrumb-item <?php echo esc_attr($active_link_classes); ?> active <?php echo esc_attr($animationClass); ?>" data-anim-type="<?php echo esc_attr($animationType); ?>" data-anim-delay="<?php echo esc_attr($delay); ?>" aria-current="page">
							<span><?php
									echo \PixfortCore::instance()->icons->getIcon($arrowIcon, 24, 'position-relative2 ' . $margin1);
									?></span>
							<?php the_title(); ?>
						</li>
					<?php
					} elseif (is_search()) {
						$delay += 50;
					?>
						<li class="breadcrumb-item <?php echo esc_attr($active_link_classes); ?> active <?php echo esc_attr($animationClass); ?>" data-anim-type="<?php echo esc_attr($animationType); ?>" data-anim-delay="<?php echo esc_attr($delay); ?>" aria-current="page">
							<span>
								<?php
								echo \PixfortCore::instance()->icons->getIcon($arrowIcon, 24, 'position-relative2 ' . $margin1);
								?>
							</span>
							<?php printf(esc_html__('Search Results for: %s', 'pixfort-core'), get_search_query()); ?>
						</li>
					<?php
					}
					?>
				</ol>
			</nav>
			<?php
		}
	}
}

if (! function_exists('pixfort_footer_extras')) {
	function pixfort_footer_extras() {
		if (class_exists('PixfortCore')) {
			if (\PixfortCore::instance()->elementsManager->searchOverlayState) {
				echo pixfort_search_overlay();
				$nonce = wp_create_nonce("search_nonce");
				$link = admin_url('admin-ajax.php?action=pix_ajax_search&nonce=' . $nonce);
				$extraClasses = '';

				$titleColor = 'text-white';
				$textColor = 'text-light-opacity-5';
				if (!empty(pix_plugin_get_option('search-overlay-title-color'))) {
					$titleColor = 'text-' . pix_plugin_get_option('search-overlay-title-color');
				}
				if (!empty(pix_plugin_get_option('search-overlay-text-color'))) {
					$textColor = 'text-' . pix_plugin_get_option('search-overlay-text-color');
				} else {
					if (!empty(pix_plugin_get_option('search-dark-overlay')) && pix_plugin_get_option('search-dark-overlay')) {
						$titleColor = 'text-black';
						$textColor = 'text-dark-opacity-5';
					}
				}
			?>
				<div class="pix-overlay d-none">
					<div class="">
						<div class="pix-search <?php echo esc_attr($extraClasses); ?>">
							<div class="container">
								<div class="row d-flex justify-content-center">
									<div class="col-12 col-md-12">
										<div class="pix-overlay-item pix-overlay-item--style-6">
											<a href="#" class="pix-search-close"><span class="screen-reader-text sr-only"><?php echo esc_html__('Close', 'pixfort-core'); ?></span>
												<?php
												echo \PixfortCore::instance()->icons->getIcon('Line/pixfort-icon-cross-circle-1', 24, $titleColor);
												?>
											</a>
											<div class="pb-0">
												<div class="search-title h1 heading-font display-2 <?php echo esc_attr($titleColor); ?> font-weight-bold"><?php esc_html_e('Search', 'pixfort-core'); ?></div>
											</div>
										</div>
										<div class="slide-in-container pb-2 pix-overlay-item pix-overlay-item--style-6">
											<p class="text-gray-3s text-20 mb-2 secondary-font search-note <?php echo esc_attr($textColor); ?>"><?php esc_html_e('Hit enter to search or ESC to close', 'pixfort-core'); ?></p>
										</div>
										<div class="search-bar pix-overlay-item pix-overlay-item--style-6">
											<div class="search-content">
												<form class="pix-search-form" method="get" action="<?php echo esc_url(home_url('/')); ?>">
													<div class="media pix-ajax-search-container">
														<button class="pix-search-submit align-self-center" aria-label="search" type="submit">
															<?php
															echo \PixfortCore::instance()->icons->getIcon('Line/pixfort-icon-search-left-1');
															?>
														</button>
														<div class="media-body">
															<label class="w-100 m-0">
																<span class="screen-reader-text sr-only"><?php echo esc_html__('Search for:', 'pixfort-core'); ?></span>
																<input value="<?php echo get_search_query(); ?>" name="s" id="s" class="pix-search-input pix-ajax-search" type="search" autocomplete="off" placeholder="<?php esc_attr_e('Search', 'pixfort-core'); ?>" data-search-link="<?php echo esc_url($link); ?>" />
															</label>
														</div>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			<?php
			}
		}
		$sidebarState = false;
		if (class_exists('WooCommerce') && class_exists('PixfortCore')) {
			$sidebarState = \PixfortCore::instance()->wooManager->sidebarState;
		}
		if ($sidebarState || is_user_logged_in() || function_exists('pixfort_demo_widget_cart')) { ?>
			<div class="pix-sidebar">
				<div class="sidebar-inner shadow-lg">
					<div class="sidebar-content">
						<?php pix_sidebar_cart_content(); ?>
					</div>
				</div>
			</div>
		<?php
			wp_enqueue_style('pixfort-sidebar-style', PIX_CORE_PLUGIN_URI . 'includes/assets/css/elements/sidebar.min.css', false, PIXFORT_PLUGIN_VERSION, 'all');
		}
	}
}

if (! function_exists('pix_sidebar_cart_content')) {
	function pix_sidebar_cart_content() {
		?>
		<div class="pix-p-20 d-flex w-100 justify-content-between2 align-items-center">
			<div class="flex-fill pb-0"><span class="search-title line-height-0 text-heading-default text-20 secondary-font font-weight-bold"><?php esc_html_e('Your shopping cart', 'pixfort-core'); ?></span></div>
			<a href="#" aria-label="<?php esc_attr_e('Close Cart Sidebar', 'pixfort-core'); ?>" class="pix-close-sidebar d-inline-block text-20 d-flex align-items-center text-gray-4">
				<?php
				echo \PixfortCore::instance()->icons->getIcon('Line/pixfort-icon-cross-circle-1', 22, 'align-self-center');
				?>
			</a>
		</div>
		<div class="pix-line-divider thin bg-dark-opacity-1 dark:bg-light-opacity-1 p-0 my-0 line-height-0 d-block w-100"></div>
		<div class=" pixfort-widget pix-sidebar-widget d-block w-100">
			<?php
			if (class_exists('WooCommerce')) {
				the_widget('WC_Widget_Cart');
			} else {
				if (function_exists('pixfort_demo_widget_cart')) {
					pixfort_demo_widget_cart();
				} else {
			?>
					<div class="pix-p-20 text-sm">
						<?php echo esc_html__('WooCommerce should be installed and activated!', 'pixfort-core'); ?>
					</div>
			<?php
				}
			}
			?>
		</div>
	<?php
	}
}

if (! function_exists('pixGetImageID')) {
	function pixGetImageID($value) {
		$result = [
			'light' => '',
			'dark' => ''
		];

		if (empty($value)) {
			return $result;
		}

		// If it's a string URL (legacy format)
		if (is_string($value)) {
			// Check if it's a JSON string first
			$decoded = json_decode($value, true);
			if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
				// Handle JSON string with light/dark structure
				if (isset($decoded['light']) && isset($decoded['light']['url'])) {
					$result['light'] = $decoded['light']['id'];
				}
				if (isset($decoded['dark']) && isset($decoded['dark']['url'])) {
					$result['dark'] = $decoded['dark']['id'];
				}
				// Legacy format - assign to light if no light/dark structure
				if (empty($result['light']) && empty($result['dark']) && isset($decoded['url'])) {
					$result['light'] = $decoded['id'];
				}
			} else {
				// If not JSON, assume it's a direct URL string - assign to light
				$result['light'] = $value;
			}
		}

		// If it's an array with light/dark structure
		elseif (is_array($value)) {
			if (isset($value['light']) && isset($value['light']['url'])) {
				$result['light'] = $value['light']['id'];
			}
			if (isset($value['dark']) && isset($value['dark']['url'])) {
				$result['dark'] = $value['dark']['id'];
			}
			// Legacy format - assign to light if no light/dark structure
			if (empty($result['light']) && empty($result['dark']) && isset($value['url'])) {
				$result['light'] = $value['id'];
			}
		}

		// If it's an object
		elseif (is_object($value)) {
			if (isset($value->light) && isset($value->light->url)) {
				$result['light'] = $value->light->id;
			}
			if (isset($value->dark) && isset($value->dark->url)) {
				$result['dark'] = $value->dark->id;
			}
			// Legacy format - assign to light if no light/dark structure
			if (empty($result['light']) && empty($result['dark']) && isset($value->url)) {
				$result['light'] = $value->id;
			}
		}

		return $result;
	}
}

if (!function_exists('pix_migrate_box_to_advanced')) {
	function pix_migrate_box_to_advanced($item) {
		$legacyDarkHeading = pix_plugin_get_option('opt-dark-heading-color');
		$legacyDarkBody = pix_plugin_get_option('opt-dark-body-color');
		if (!function_exists('fields_list')) return;

		$sections = fields_list();
		if (!isset($sections['pix_box_section'])) return;
		$box_fields = $sections['pix_box_section'];
		$opts_key = 'menu-item-pix_menu_opts';
		$opts_value = get_post_meta($item->ID, $opts_key, true);

		// Try different WordPress decoding approaches
		$obj = null;

		// Strategy 1: Try html_entity_decode
		$decoded = html_entity_decode($opts_value, ENT_QUOTES);
		$obj = json_decode($decoded, true);
		if (!is_array($obj)) {
			// Strategy 2: Check if it's maybe_unserialize
			$unserialized = maybe_unserialize($opts_value);
			if (is_array($unserialized)) {
				$obj = $unserialized;
			} else {
				// Strategy 3: Try with get_post_meta without true (might be serialized)
				$raw_meta = get_post_meta($item->ID, $opts_key);
				if (!empty($raw_meta[0])) {
					$obj = json_decode($raw_meta[0], true);
					if (!is_array($obj)) {
						$obj = [];
					}
				} else {
					$obj = [];
				}
			}
		}

		if (!is_array($obj)) $obj = [];

		$migrated = false;
		foreach ($box_fields as $box_key => $field) {
			$mig_key = 'menu-item-' . $box_key;
			$mig_value = get_post_meta($item->ID, $mig_key, true);
			if (empty($mig_value)) continue;

			$exists = false;
			foreach ($obj as $o_item) {
				if (isset($o_item['name']) && $o_item['name'] === $box_key) {
					$exists = true;
					break;
				}
			}
			if ($exists) continue;

			if ($box_key === 'pix_bg_image') {
				if (is_numeric($mig_value) && intval($mig_value) > 0) {
					$attachment = get_post($mig_value);
					if (!$attachment || $attachment->post_type !== 'attachment') continue;
					$full_src = wp_get_attachment_image_src($mig_value, 'full');
					if (!$full_src) continue;
					$thumb_src = wp_get_attachment_image_src($mig_value, 'thumbnail');
					$url = $full_src[0];
					$width = $full_src[1];
					$height = $full_src[2];
					$thumbnail = $thumb_src ? $thumb_src[0] : '';
					$title = $attachment->post_title;
					$caption = $attachment->post_excerpt;
					$description = $attachment->post_content;
					$alt = get_post_meta($mig_value, '_wp_attachment_image_alt', true);
					$mig_value = [
						'light' => [
							'url' => $url,
							'id' => (int)$mig_value,
							'height' => $height,
							'width' => $width,
							'thumbnail' => $thumbnail,
							'title' => $title,
							'caption' => $caption,
							'alt' => $alt,
							'description' => $description
						],
						'dark' => null
					];
				} else {
					$mig_value = [
						'light' => [
							'url' => $mig_value,
							'id' => null,
							'height' => null,
							'width' => null,
							'thumbnail' => null,
							'title' => null,
							'caption' => null,
							'alt' => null,
							'description' => null
						],
						'dark' => null
					];
				}
			}

			$obj[] = ['name' => $box_key, 'val' => $mig_value];
			$migrated = true;
		}

		// Skip color migration if any color option already exists
		$color_keys = ['pix_box_title_color', 'pix_box_button_color', 'pix_box_text_color'];
		$colors_exist = false;

		foreach ($color_keys as $ck) {
			foreach ($obj as $o_item) {
				if (isset($o_item['name']) && $o_item['name'] === $ck) {
					$colors_exist = true;
					break 2;
				}
			}
		}
		if (!$colors_exist) {
			// Check for pix_is_box_dark == '1' and add new colors if missing
			$is_dark = false;
			foreach ($obj as $o_item) {
				if (isset($o_item['name']) && $o_item['name'] === 'pix_is_box_dark' && $o_item['val'] === '1') {
					$is_dark = true;
					break;
				}
			}
			if ($is_dark) {
				$new_items = [
					'pix_box_title_color' => $legacyDarkHeading,
					'pix_box_button_color' => $legacyDarkHeading,
					'pix_box_text_color' => $legacyDarkBody
				];
				foreach ($new_items as $new_name => $new_val) {
					if (empty($new_val)) continue;
					$exists = false;
					foreach ($obj as $o_item) {
						if (isset($o_item['name']) && $o_item['name'] === $new_name) {
							$exists = true;
							break;
						}
					}
					if (!$exists) {
						$obj[] = ['name' => $new_name, 'val' => $new_val];
						$migrated = true;
					}
				}
			}
			if ($migrated) {
				$new_json = json_encode($obj);
				update_post_meta($item->ID, $opts_key, esc_attr($new_json));
			}
		}
	}
}

if (!function_exists('pixAuthorBox')) {
	function pixAuthorBox($author_id = false, $settings = array()) {
		if (!$author_id) {
			$author_id = get_the_author_meta('ID');
		}

		$author_data = get_userdata($author_id);
		if (!$author_data) {
			return;
		}

		// Default settings
		$defaults = array(
			'show_avatar' => true,
			'avatar_size' => 80,
			'show_name' => true,
			'link_to_author' => true,
			'show_description' => true,
			'show_job' => true,
			'show_url' => true,
			'description_length' => 0, // 0 = full description
			'shadow' => '1',
			'hover_effect' => '',
			'add_hover_effect' => '',
			'avatar_shadow' => '1',
		);

		$settings = wp_parse_args($settings, $defaults);

		// Get author name
		if (!empty($author_data->first_name)) {
			$author = $author_data->first_name;
			$author .= ' ' . $author_data->last_name;
		} else {
			$author = $author_data->display_name;
		}

		$effectsClasses = \PixfortCore::instance()->coreFunctions->getEffectsClasses($settings['shadow'], $settings['hover_effect'], $settings['add_hover_effect']);

		$avatar_shadow_classes = \PixfortCore::instance()->coreFunctions->getEffectsClasses($settings['avatar_shadow'], '', '');
	?>
		<div class="pix-author-box media rounded-xl pix-p-30 <?php echo esc_attr($effectsClasses); ?>">
			<?php if ($settings['show_avatar']): ?>
				<?php
				echo get_avatar(get_the_author_meta('ID', $author_id), $settings['avatar_size'], '', $author, array('class' => 'pix-author-avatar ' . $avatar_shadow_classes));
				?>
			<?php endif; ?>
			<div class="media-body">
				<?php if ($settings['show_name']): ?>
					<?php if ($settings['link_to_author']): ?>
						<a class="text-heading-default" href="<?php echo get_author_posts_url($author_id); ?>">
							<div class="pix-author-name h6 mt-0 font-weight-bold"><?php echo esc_html($author); ?></div>
						</a>
					<?php else: ?>
						<div class="pix-author-name h6 mt-0 font-weight-bold"><?php echo esc_html($author); ?></div>
					<?php endif; ?>
				<?php endif; ?>

				<?php
				if ($settings['show_job'] && !empty(get_the_author_meta('job', $author_id))) {
				?>
					<div class="mb-0 pix-pt-5 text-sm pix-author-job"><?php echo get_the_author_meta('job', $author_id); ?></div>
				<?php
				}

				if ($settings['show_url'] && !empty(get_the_author_meta('user_url', $author_id))) {
					$url_txt = get_the_author_meta('user_url', $author_id);
					if (strpos($url_txt, 'http://') === 0) {
						$url_txt = substr($url_txt, strlen('http://'));
					}
					if (strpos($url_txt, 'https://') === 0) {
						$url_txt = substr($url_txt, strlen('https://'));
					}
				?>
					<a class="text-sm text-heading-default font-weight-bold pix-author-url" href="<?php echo esc_url(get_the_author_meta('user_url', $author_id)); ?>"><?php echo esc_html($url_txt); ?></a>
				<?php
				}

				if ($settings['show_description'] && !empty(get_the_author_meta('description', $author_id))) {
					$description = get_the_author_meta('description', $author_id);
					if ($settings['description_length'] > 0) {
						$description = wp_trim_words($description, $settings['description_length'], '...');
					}
				?>
					<p class="mb-0 pix-pt-10 pix-author-biography"><?php echo wp_kses_post($description); ?></p>
				<?php } ?>
			</div>
		</div>
<?php

	}
}
