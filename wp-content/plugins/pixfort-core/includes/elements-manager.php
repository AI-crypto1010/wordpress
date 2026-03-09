<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/**
 * Elements Manager.
 *
 * 
 *
 * @since 1.0.0
 */
class ElementsManager {

	public $searchOverlayState = false;

	public static $elementsCSS = '';

	/**
	 * Whitelist of allowed element names for security validation
	 * This prevents path traversal attacks in include statements
	 */
	private $allowedElements = [
		'3dbox',
		'Accordion',
		'AccordionTab',
		'AccordionText',
		'AdvancedText',
		'Alert',
		'AnimatedHeading',
		'AutoVideo',
		'Badge',
		'Blog',
		'BlogSlider',
		'Breadcrumbs',
		'Button',
		'Card',
		'CardWide',
		'Chart',
		'Circles',
		'Clients',
		'ClientsSlider',
		'ComparisonTable',
		'ContentBox',
		'ContentStack',
		'ContentTab',
		'ContentTabs',
		'Countdown',
		'Cta',
		'Dividers',
		'Event',
		'FancyBox',
		'FancyMockup',
		'Faq',
		'Feature',
		'FeatureList',
		'Gallery',
		'GlobalTemplate',
		'Heading',
		'HighlightBox',
		'HighlightedText',
		'Icon',
		'Img',
		'ImgBox',
		'ImgCarousel',
		'ImgSlider',
		'Levels',
		'LoopGrid',
		'Map',
		'Marquee',
		'Menu',
		'Numbers',
		'PhotoBox',
		'PhotoStack',
		'Portfolio',
		'PortfolioSlider',
		'Pricing',
		'PricingGroup',
		'ProductsCarousel',
		'ProgressBars',
		'PromoBox',
		'ResponsiveSpacer',
		'Review',
		'ReviewsSlider',
		'Runtime',
		'Search',
		'TemplatesCarousel',
		'TemplateCarousel',
		'ShopCategory',
		'Slider',
		'SlidingText',
		'SocialIcons',
		'SocialShareButton',
		'Story',
		'TableOfContents',
		'Tabs',
		'TabsHText',
		'TabsVText',
		'TeamMember',
		'TeamMemberCircle',
		'Testimonial',
		'TestimonialMasonry',
		'TestimonialsSlider',
		'Text',
		'Video',
		'VideoPopup',
		'VideoSlider'
	];

	private $shortcodes = [
		'alertblock'				=> 'Alert',
		'alert'						=> 'Alert',
		'pix_advanced_text'			=> 'AdvancedText',
		'pix_accordion'				=> 'Accordion',
		'pix_accordion_tab'			=> 'AccordionTab',
		'pix_runtime'				=> 'Runtime',
		'animated-heading'			=> 'AnimatedHeading',
		'pix_auto_video'			=> 'AutoVideo',
		'pix_responsive_spacer'		=> 'ResponsiveSpacer',
		'pix_feature'				=> 'Feature',
		'pix_promo_box'				=> 'PromoBox',
		'pix_card_wide'				=> 'CardWide',
		'chart'						=> 'Chart',
		'circles'					=> 'Circles',
		'clients'					=> 'Clients',
		'clients_slider'			=> 'ClientsSlider',
		'pix_comparison_table'		=> 'ComparisonTable',
		'pix_content_stack'			=> 'ContentStack',
		'pix_countdown'				=> 'Countdown',
		'pix_cta'					=> 'Cta',
		'pix_event'					=> 'Event',
		'pix_3d_box'				=> '3dbox',
		'fancy_box'					=> 'FancyBox',
		'pix_fancy_mockup'			=> 'FancyMockup',
		'pix_faq'					=> 'Faq',
		'pix_gallery'				=> 'Gallery',
		'pix_global_template'		=> 'GlobalTemplate',
		'pix_highlight_box'			=> 'HighlightBox',
		'pix_img_carousel'			=> 'ImgCarousel',
		'pix_img_box'				=> 'ImgBox',
		'pix_img_slider'			=> 'ImgSlider',
		'pix_levels'				=> 'Levels',
		'pix_map'					=> 'Map',
		'pix_marquee'				=> 'Marquee',
		'pix_numbers'				=> 'Numbers',
		'pix_photo_box'				=> 'PhotoBox',
		'pix_photo_stack'			=> 'PhotoStack',
		'pix_products_carousel'		=> 'ProductsCarousel',
		'pix_template_carousel'		=> 'TemplatesCarousel',
		'pix_progress_bars'			=> 'ProgressBars',
		'pix_shop_category'			=> 'ShopCategory',
		'pix_slider'				=> 'Slider',
		'pix_tabs'					=> 'Tabs',
		// 'pix_h_text_tabs'		=> 'TabsHText', Elementor Only
		// 'pix_v_text_tabs'		=> 'TabsVText', Elementor Only
		'pix_team_member'			=> 'TeamMember',
		'pix_team_member_circle'	=> 'TeamMemberCircle',
		'pix_testimonial'			=> 'Testimonial',
		'pix_testimonial_masonry'	=> 'TestimonialMasonry',
		'testimonials_slider'		=> 'TestimonialsSlider',
		'pix_review'				=> 'Review',
		'pix_reviews_slider'		=> 'ReviewsSlider',
		'pix_text'					=> 'Text',
		'pix_video'					=> 'Video',
		'pix_video_popup'			=> 'VideoPopup',
		'pix_video_slider'			=> 'VideoSlider',
		'pix_story'					=> 'Story',
		'pix-social-icons'			=> 'SocialIcons',
		'pix-social-share-button'	=> 'SocialShareButton',
		'pix_pricing'				=> 'Pricing',
		'pix_pricing_group'			=> 'PricingGroup',
		'pix_feature_list'			=> 'FeatureList',
		'content_box'				=> 'ContentBox',
		'pix_content_tab'			=> 'ContentTab',
		'content_tabs'				=> 'ContentTabs',
		'pix_vertical_tabs'			=> 'ContentTabs',
		'pix_card'					=> 'Card',
		'pix_dividers'				=> 'Dividers',
		'pix_img'					=> 'Img',
		'pix_button'				=> 'Button',
		'pix-button'				=> 'Button',
		'pix_blog_slider'			=> 'BlogSlider',
		'pix_icon'					=> 'Icon',
		'pix_highlighted_text'		=> 'HighlightedText',
		'pix_portfolio_slider'		=> 'PortfolioSlider',
		'pix_portfolio'				=> 'Portfolio',
		'pix_badge'					=> 'Badge',
		'pix_search'				=> 'Search',
		'heading'					=> 'Heading',
		'sliding-text'				=> 'SlidingText',
		'pix_blog'					=> 'Blog',
		'pix_breadcrumbs'			=> 'Breadcrumbs',
	];

	public function __construct() {
		$this->initShortcodes();
		add_action('wp_footer', [$this, 'pixfortFooter'], 19);
		add_action('wp_footer', [$this, 'pixfortCookies'], 20);
	}

	public function initShortcodes() {
		foreach ($this->shortcodes as $shortcode => $functionName) {
			add_shortcode($shortcode, [$this, 'handleShortcode']);
		}
		add_shortcode('pixfort_template', [$this, 'handleTemplateShortcode']);
		include_once('elements/extras/misc.php');
	}

	/**
	 * Validates element name against whitelist to prevent path traversal attacks
	 * 
	 * @param string $elementName The element name to validate
	 * @return bool True if element name is valid and safe to include
	 */
	private function isValidElementName($elementName) {
		// Remove any potential path traversal characters
		$elementName = basename($elementName);

		// Check if element name is in whitelist
		if (!in_array($elementName, $this->allowedElements, true)) {
			error_log("Attempted to access invalid element: " . $elementName);
			return false;
		}

		// Final check: verify file actually exists
		$filePath = PIXFORT_PLUGIN_DIR . 'includes/elements/' . $elementName . '.php';
		if (!file_exists($filePath)) {
			error_log("PixFort Security: Element file does not exist: " . $filePath);
			return false;
		}

		return true;
	}

	public function renderElement($name, $attr = [], $content = null) {
		// Validate element name to prevent path traversal attacks
		if (!$this->isValidElementName($name)) {
			error_log("renderElement() invalid element name: " . $name);
			return '';
		}

		// Sanitize the name (remove any remaining unsafe characters)
		$safeName = basename($name);

		// Include the validated element file
		include_once('elements/' . $safeName . '.php');
		$class = 'Pix' . $safeName;

		if (class_exists($class)) {
			try {
				$shortcode = new $class();
				if (method_exists($shortcode, 'render')) {
					return $shortcode->render($attr, $content);
				}
			} catch (Exception $e) {
				error_log("Failed to render element {$safeName}: " . $e->getMessage());
			}
		}
		return '';
	}

	public function handleShortcode($attr, $content = null, $shortcode = '') {
		if (!isset($this->shortcodes[$shortcode])) {
			return ''; // Shortcode not found
		}

		$name = $this->shortcodes[$shortcode];

		// Validate element name to prevent path traversal attacks
		if (!$this->isValidElementName($name)) {
			// Log security attempt and return empty string
			error_log("handleShortcode() invalid element name for shortcode '{$shortcode}' -> element '{$name}'");
			return '';
		}

		// Sanitize the name (remove any remaining unsafe characters)
		$safeName = basename($name);

		// Include the validated element file
		include_once('elements/' . $safeName . '.php');
		$class = 'Pix' . $safeName;

		if (class_exists($class)) {
			try {
				$elementInstance = new $class();
				if (method_exists($elementInstance, 'render')) {
					return $elementInstance->render($attr, $content);
				}
			} catch (Exception $e) {
				error_log("Failed to handle shortcode {$shortcode} with element {$safeName}: " . $e->getMessage());
			}
		}
		return '';
	}

	public function enableSearchOverlay() {
		$this->searchOverlayState = true;
	}

	public static function pixAddInlineStyle($css) {
		self::$elementsCSS .= $css;
		// if (defined('DOING_AJAX') && DOING_AJAX) {
		// 	$element_id = 'pix-inline-style-' . hash('md5', json_encode($css));
		// 	wp_register_style($element_id, false);
		// 	wp_enqueue_style($element_id);
		// 	wp_add_inline_style($element_id, $css);
		// }
	}

	public function pixfortFooter() {
		if (!empty(self::$elementsCSS)) {
			wp_register_style('pixfort-elements-handle', false);
			wp_enqueue_style('pixfort-elements-handle');
			wp_add_inline_style('pixfort-elements-handle', $this::$elementsCSS);
		}
		if (!empty(pix_plugin_get_option('pic-custom-css'))) {
			wp_register_style('pix-custom-css', false);
			wp_enqueue_style('pix-custom-css');
			wp_add_inline_style('pix-custom-css', pix_plugin_get_option('pic-custom-css'));
		}
	}

	public function pixfortCookies() {
		if ((defined('DOING_AJAX') && DOING_AJAX) || wp_doing_ajax()) {
			return false;
		}
		$options = get_option('pix_options');
		if (!empty($options['pix-enable-cookies'])) {
			include_once('elements/extras/cookies.php');
		}
	}

	public function handleTemplateShortcode($attr, $content = null, $shortcode = '') {
		$output = '';
		if (!empty($attr['id'])) {
			$template_id = $attr['id'];
			$built_with_elementor = false;
			if (class_exists('\Elementor\Plugin')) {
				if (Elementor\Plugin::instance()->documents->get($template_id)) {
					if (Elementor\Plugin::instance()->documents->get($template_id)->is_built_with_elementor()) {
						$built_with_elementor = true;
					}
				}
			}
			if($built_with_elementor) {
				// Elementor
				if (get_post_status($template_id)) {
					setup_postdata($template_id);
					$output = \Elementor\plugin::instance()->frontend->get_builder_content($template_id, true);
				}
			} else if (defined('WPB_VC_VERSION')) {
				$output = do_shortcode(get_post_field('post_content', $template_id));
			}
			wp_reset_postdata();
		}
		return $output;
	}
}
