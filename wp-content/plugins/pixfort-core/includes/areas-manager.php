<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/**
 * Areas Manager.
 *
 * 
 *
 * @since 1.0.0
 */
class AreasManager {

	protected $conditions = [];

	private $cache;

	public function __construct() {
		$this->cache = new AreasCache();
		add_action('wp_footer', [$this, 'print_popups']);
	}

	public function getLocationTemplates($location) {
		$validItems = [];
		$itemsList = $this->cache->getAreaByLocation($location);
		/* 
        *   1- verify each item conditions
        *   2- return only valid items
        */
		foreach ($itemsList as $id => $itemConditions) {
			$addItem = false;
			foreach ($itemConditions as $cid => $condition) {
				$isMatch = false;
				$subIDValue = null;
				if (!empty($condition['subIDValue'])) {
					$subIDValue = $condition['subIDValue'];
				}
				if (empty($condition['general'])) continue;
				if (function_exists('icl_get_languages')) {
					$subIDValue = apply_filters('wpml_object_id', $subIDValue, 'post', true);
				}
				switch ($condition['general']) {
					case 'all':
						/*
                        * All site pages
                        */
						$isMatch = true;
						break;
					case 'singular':
						/*
                        * Singular
                        */
						$product = false;
						if (function_exists('is_woocommerce') && is_woocommerce()) {
							if (is_product()) {
								$product = true;
							}
						}
						if (!$product && is_singular()) {
							if (!empty($condition['nestedValue']) && $condition['nestedValue'] !== 'all') {
								if ($condition['nestedValue'] === 'page' && is_page()) {
									/*
                                    * Page
                                    */
									if (!empty($subIDValue && $subIDValue !== 'all')) {
										if ($subIDValue == get_the_ID()) {
											$isMatch = true;
										}
									} else {
										$isMatch = true;
									}
								} elseif ($condition['nestedValue'] === 'frontpage' && is_front_page()) {
									$isMatch = true;
								} elseif ($condition['nestedValue'] === 'post' && get_post_type() === 'post') {
									/*
                                    * Post
                                    */
									if (!empty($subIDValue && $subIDValue !== 'all')) {
										if ($subIDValue == get_the_ID()) {
											$isMatch = true;
										}
									} else {
										$isMatch = true;
									}
								} elseif ($condition['nestedValue'] === 'portfolio' && get_post_type() === 'portfolio') {
									/*
                                    * Portfolio
                                    */
									if (!empty($subIDValue && $subIDValue !== 'all')) {
										if ($subIDValue == get_the_ID()) {
											$isMatch = true;
										}
									} else {
										$isMatch = true;
									}
								} elseif ($condition['nestedValue'] === 'cat' ) {
									/*
                                    * In Category
                                    */
									if (!empty($subIDValue && $subIDValue !== 'all')) {
										if (has_category($subIDValue)) {
											$isMatch = true;
										} elseif (has_term($subIDValue, 'portfolio-types', get_the_ID())) {
											$isMatch = true;
										}
									} else {
										$isMatch = true;
									}
							} elseif ($condition['nestedValue'] === 'in_category_children') {
								/*
                                    * In Child Categories
                                    */
								if (!empty($subIDValue && $subIDValue !== 'all')) {
									// Check regular categories
									$post_categories = get_the_category();
									if (!empty($post_categories)) {
										foreach ($post_categories as $category) {
											// Check if the parent category is an ancestor at any level
											if (cat_is_ancestor_of($subIDValue, $category->term_id)) {
												$isMatch = true;
												break;
											}
										}
									}
									
									// Also check portfolio types taxonomy
									if (!$isMatch) {
										$portfolio_terms = get_the_terms(get_the_ID(), 'portfolio-types');
										if (!empty($portfolio_terms) && !is_wp_error($portfolio_terms)) {
											foreach ($portfolio_terms as $term) {
												// Check if the parent term is an ancestor at any level
												if (term_is_ancestor_of($subIDValue, $term->term_id, 'portfolio-types')) {
													$isMatch = true;
													break;
												}
											}
										}
									}
								}
								} elseif ($condition['nestedValue'] === 'child_of') {
									/*
                                    * Child of
                                    */
									if (is_singular()) {
										$condID = (int) $subIDValue;
										$parent_id = wp_get_post_parent_id(get_the_ID());
										if ((0 === $condID && 0 < $parent_id) || ($parent_id === $condID && $condID !== 0)) {
											$isMatch = true;
										}
									}
								} else {
									/*
                                    * Handle custom post types from external plugins
                                    */
									$post_type_obj = get_post_type_object($condition['nestedValue']);
									if ($post_type_obj && $post_type_obj->public && get_post_type() === $condition['nestedValue']) {
										if (!empty($subIDValue && $subIDValue !== 'all')) {
											if ($subIDValue == get_the_ID()) {
												$isMatch = true;
											}
										} else {
											$isMatch = true;
										}
									}
								}
							} else {
								$isMatch = true;
							}
						}
						break;
					case 'archives':
						/*
                        * Archives
                        */
						$isWooCommerce = false;
						if (function_exists('is_woocommerce') && is_woocommerce()) {
							$isWooCommerce = true;
						}
						if ((is_archive() || is_search() || is_category() || is_tag()) && !$isWooCommerce) {
							
							if (!empty($condition['nestedValue']) && $condition['nestedValue'] !== 'all') {
								if ($condition['nestedValue'] === 'author' && is_author()) {
									/*
                                    * Author
                                    */
									if (!empty($subIDValue && $subIDValue !== 'all')) {
										if ($subIDValue == get_the_ID()) {
											$isMatch = true;
										}
									} else {
										$isMatch = true;
									}
								} elseif ($condition['nestedValue'] === 'date' && is_date()) {
									/*
                                    * Date
                                    */
									$isMatch = true;
								} elseif ($condition['nestedValue'] === 'search' && is_search()) {
									/*
                                    * Search
                                    */
									$isMatch = true;
								} elseif ($condition['nestedValue'] === 'category' && is_category()) {
									/*
                                    * Category
                                    */
									$category = get_queried_object();
									if (!empty($subIDValue && $subIDValue !== 'all' && !empty($category->term_id))) {
										if ($subIDValue == $category->term_id) {
											$isMatch = true;
										}
									} else {
										$isMatch = true;
									}
								} elseif ($condition['nestedValue'] === 'tag' && is_tag()) {
									/*
                                    * Tag
                                    */
									$tag = get_queried_object();
									if (!empty($subIDValue && $subIDValue !== 'all' && !empty($tag->term_id))) {
										if ($subIDValue == $tag->term_id) {
											$isMatch = true;
										}
									} else {
										$isMatch = true;
									}
								}
							} else if(!is_search()) {
								$isMatch = true;
							}
						}
						break;
					case 'woocommerce':
						/*
                        * WooCommerce
                        */
						if (function_exists('is_woocommerce') && is_woocommerce()) {
							if (!empty($condition['nestedValue']) && $condition['nestedValue'] !== 'all') {
								if ($condition['nestedValue'] === 'product_archives' && (is_product_category() || is_product_tag() || is_shop())) {
									$isMatch = true;
								} elseif ($condition['nestedValue'] === 'shop' && is_shop()) {
									/*
                                    * Date
                                    */
									$isMatch = true;
								} elseif ($condition['nestedValue'] === 'search' && is_search()) {
									/*
                                    * Search
                                    */
									$isMatch = true;
								} elseif ($condition['nestedValue'] === 'product_cat' && is_product_category()) {
									/*
                                    * Product Category
                                    */
									if (!empty($subIDValue && $subIDValue !== 'all')) {
										if ($subIDValue == get_the_ID()) {
											$isMatch = true;
										}
									} else {
										$isMatch = true;
									}
								} elseif ($condition['nestedValue'] === 'product_tag' && is_product_tag()) {
									/*
                                    * Product Tag
                                    */
									if (!empty($subIDValue && $subIDValue !== 'all')) {
										if ($subIDValue == get_the_ID()) {
											$isMatch = true;
										}
									} else {
										$isMatch = true;
									}
								} elseif ($condition['nestedValue'] === 'product' && is_product()) {
									/*
                                    * Product
                                    */
									if (!empty($subIDValue && $subIDValue !== 'all')) {
										if ($subIDValue == get_the_ID()) {
											$isMatch = true;
										}
									} else {
										$isMatch = true;
									}
								}
							} else {
								$isMatch = true;
							}
						}
						break;
					default:
						/*
                        * Handle custom post type sections
                        */
						if (strpos($condition['general'], 'custom_') === 0) {
							// Extract the post type slug from the general value (remove 'custom_' prefix)
							$post_type_slug = substr($condition['general'], 7);
							
							if (is_singular() && get_post_type() === $post_type_slug) {
								if (!empty($condition['nestedValue']) && $condition['nestedValue'] !== 'all') {
									if ($condition['nestedValue'] === $post_type_slug) {
										/*
                                        * Specific custom post type posts
                                        */
										if (!empty($subIDValue && $subIDValue !== 'all')) {
											if ($subIDValue == get_the_ID()) {
												$isMatch = true;
											}
										} else {
											$isMatch = true;
										}
									} elseif ($condition['nestedValue'] === $post_type_slug . '_by_author') {
										/*
                                        * Custom post type posts by specific author
                                        */
										if (!empty($subIDValue && $subIDValue !== 'all')) {
											$post_author_id = get_post_field('post_author', get_the_ID());
											if ($subIDValue == $post_author_id) {
												$isMatch = true;
											}
										} else {
											// All posts by any author (essentially same as "All")
											$isMatch = true;
										}
									} else {
										/*
                                        * Check if this is a taxonomy condition for the custom post type
                                        */
										$taxonomy_obj = get_taxonomy($condition['nestedValue']);
										if ($taxonomy_obj && in_array($post_type_slug, $taxonomy_obj->object_type)) {
											if (!empty($subIDValue && $subIDValue !== 'all')) {
												if (has_term($subIDValue, $condition['nestedValue'], get_the_ID())) {
													$isMatch = true;
												}
											} else {
												// Check if current post has any term in this taxonomy
												$terms = get_the_terms(get_the_ID(), $condition['nestedValue']);
												if (!empty($terms) && !is_wp_error($terms)) {
													$isMatch = true;
												}
											}
										}
									}
								} else {
									/*
                                    * All posts of this custom post type
                                    */
									$isMatch = true;
								}
							}
						}
						break;
				}
				if ($isMatch) {
					if ($condition['include']) {
						$addItem = true;
					} else {
						$addItem = false;
						break;
					}
				}
			}
			if ($addItem) {
				if (function_exists('icl_get_languages')) {
					$id = apply_filters('wpml_object_id', $id, 'post', true);
				}
				if (!in_array($id, $validItems)) {	
					array_push($validItems, $id);
				}
			}
		}
		return $validItems;
	}

	public function print_popups() {
		if (defined('DOING_AJAX') && DOING_AJAX) {
			return false;
		}
		// $options = get_option('pix_options');
		// if (!empty($options['pix-old-popups'])) {
		// 	return false;
		// }
		/*
        *   1- Get cache Popup location items after validation
        *   2- Print popup data into footer
        */
		if (get_post_type() && get_post_type() !== 'pixpopup') {
			$popups = $this->getLocationTemplates('popup');
			$core = PixfortCore::instance();
			$itemsOptions = [];
			if (pix_plugin_get_option('pix-exit-popup')) {
				if (!in_array(pix_plugin_get_option('pix-exit-popup'), $popups)) {
					array_push($popups, pix_plugin_get_option('pix-exit-popup'));
				}
			}
			if (pix_plugin_get_option('pix-automatic-popup')) {
				if (!in_array(pix_plugin_get_option('pix-automatic-popup'), $popups)) {
					array_push($popups, pix_plugin_get_option('pix-automatic-popup'));
				}
			}

			$popups = array_unique($popups);
			$addedPopups = [];
			foreach ($popups as $popup) {
				$itemOptions = [];
				if (function_exists('icl_get_languages')) {
					$popup = apply_filters('wpml_object_id', $popup, 'pixpopup', true);
				}
				if (in_array($popup, $addedPopups)) {
					continue;
				}
				$popupData = get_post_meta($popup, 'pix-popup-data', true);
				if (is_array($popupData)) {
					if (array_key_exists('popupOptions', $popupData)) $itemOptions = array_merge($itemOptions, $popupData['popupOptions']);
					if (array_key_exists('launcherOptions', $popupData)) $itemOptions = array_merge($itemOptions, $popupData['launcherOptions']);
				}

				if (!empty($itemOptions)) {
					$core->popupType->print_popup($popup);
					$itemsOptions[$popup] = $itemOptions;
					$addedPopups[] = $popup;
				}
			}
			wp_localize_script('pix-main-pixfort', 'PIX_POPUPS_OPTIONS', $itemsOptions);
		}
		if (defined('IS_PIXFORT_THEME') && get_option('pixfort_site_type') === 'staging') {
			echo '<div class="bg-orange text-dark-opacity-5 text-small font-weight-bold text-center p-3 shadow-lg d-flex align-items-center justify-content-center flex-lg-row flex-column" style="width: 100%; gap: 10px;">';
			echo '<span class="h5 mb-lg-0 mb-2 d-flex align-items-center justify-content-center">' . \PixfortCore::instance()->icons->getIcon('Duotone/pixfort-icon-information-circle-1', 100, '') . '</span>';
			echo '<div class="d-flex align-items-center flex-wrap justify-content-center" style="gap: 5px;">';
			echo __('This site is registered on', 'pixfort-core');
			echo '<a href="https://pixfort.com/websites/" target="_blank" style="text-decoration: underline !important; text-underline-offset: 6px !important; text-decoration-thickness: 1px !important; color: #000 !important; text-decoration-color: currentColor !important;">pixfort.com</a>';
			echo __('as a Staging site. Switch to a live site activation to remove this banner.', 'pixfort-core');
			echo '</div>';
			echo '<a href="https://theme.pixfort.com/docs/migrate-staging-site-to-live-site/" target="_blank" class="mt-lg-0 mt-2" style="text-decoration: underline !important; text-underline-offset: 6px !important; text-decoration-thickness: 1px !important; color: #000 !important; text-decoration-color: currentColor !important; white-space: nowrap;">' . __('Learn how to migrate to live site', 'pixfort-core') . '</a>';
			echo '</div>';
		}
	}
}
