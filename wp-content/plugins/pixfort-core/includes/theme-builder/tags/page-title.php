<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (!class_exists('Page_Title')) {
	class Page_Title extends \Elementor\Core\DynamicTags\Tag {
		public function get_name() {
			return 'page-title';
		}

		public function get_title() {
			return esc_html__('Page Title', 'pixfort-core');
		}

		public function get_group() {
			return ['pixfort-site'];
		}

		public function get_categories() {
			return [\Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY];
		}

		public function render() {
			if (is_home() && 'yes' !== $this->get_settings('show_home_title')) {
				return;
			}

			$include_context = 'yes' === $this->get_settings('include_context');
			$title = $this->get_page_title($include_context);

			echo wp_kses_post($title);
		}

		protected function register_controls() {
			$this->add_control(
				'include_context',
				[
					'label' => esc_html__('Include Context', 'pixfort-core'),
					'type' => \Elementor\Controls_Manager::SWITCHER,
				]
			);

			$this->add_control(
				'show_home_title',
				[
					'label' => esc_html__('Show Home Title', 'pixfort-core'),
					'type' => \Elementor\Controls_Manager::SWITCHER,
				]
			);
		}

		/**
		 * Get page title with context support
		 * Simplified version without Elementor Pro dependencies
		 */
		private function get_page_title($include_context = false) {
			$title = '';

			if (is_singular()) {
				$title = get_the_title();
			} elseif (is_archive()) {
				// Handle WooCommerce shop page specifically
				if (function_exists('is_shop') && is_shop()) {
					// For shop page, always return just "Shop" without archive prefix
					// $shop_page_id = wc_get_page_id('shop');
					// if ($shop_page_id && $shop_page_id > 0) {
					// 	$title = get_the_title($shop_page_id);
					// } else {
					// 	$title = esc_html__('Shop', 'pixfort-core');
					// }
                    if ( is_cart()||is_checkout()) {
                        $title = get_the_title();
                    } else {
                        $title = woocommerce_page_title(false);
                    }
				} else {
					$title = get_the_archive_title();
					if ($include_context) {
						// Archive titles already include context
						return $title;
					} else {
						// Remove context prefixes like "Category:", "Tag:", etc.
						$title = preg_replace('/^[^:]+:\s*/', '', $title);
					}
				}
			} elseif (is_search()) {
				$title = sprintf(esc_html__('Search Results for: %s', 'pixfort-core'), get_search_query());
			} elseif (is_404()) {
				$title = esc_html__('Page not found', 'pixfort-core');
			} elseif (is_home()) {
				if (is_front_page()) {
					$title = get_bloginfo('name');
				} else {
					$posts_page = get_option('page_for_posts');
					if ($posts_page) {
						$title = get_the_title($posts_page);
					} else {
						$title = esc_html__('Blog', 'pixfort-core');
					}
				}
			} else {
				$title = get_the_title();
			}

			return $title;
		}
	}
}
