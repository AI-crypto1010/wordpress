<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* ProductsCarousel
* --------------------------------------------------------------------------- */
class PixProductsCarousel {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'product_style'  => '',

			'count'  => 6,
			'category'  => '',
			'category_multi'  => '',
			'orderby'  => 'title',
			'order'  => 'ASC',
			'display_outstock'  => false,

			'rounded_img' 		=> 'rounded-lg',
			'style' 		=> '',
			'hover_effect' 		=> '',
			'add_hover_effect' 		=> '',


			'align'  => 'text-left',
			'slider_num'  => '3',
			'pix_scroll_parallax' 	=> '',
			'pix_tilt' 	=> '',
			'pix_tilt_size' 	=> 'tilt',
			'xaxis' 	=> '',
			'yaxis' 	=> '',
			'animation' 	=> '',
			'delay' 	=> '0',
			'style' 		=> '',
			'hover_effect' 		=> '',
			'add_hover_effect' 		=> '',
			'pix_infinite_animation' 		=> '',
			'pix_infinite_speed' 		=> '',
			// 'dots_style' 	=> '',

			'slider_num'  => '3',
			'slider_num_mobile'  => '1',
			'dots_style' 	=> '',
			'slider_style' 	=> 'pix-style-standard',
			'slider_effect' 	=> 'pix-effect-standard',
			'autoplay' 	=> false,
			'autoplay_time' 	=> '1500',
			'freescroll' 	=> false,
			'prevnextbuttons' 	=> true,
			'adaptiveheight' 	=> false,
			'pagedots' 	=> true,
			'dots_align' 	=> '',
			'cellalign' 	=> 'center',
			'slider_scale' 	=> '',
			'cellpadding' 	=> 'pix-p-10',
			'slider_wrap' 	=> false,
			'righttoleft' 	=> false,
			'visible_y' 	=> '',
			'visible_overflow' 	=> '',


			'css' 		=> '',
			'is_elementor' 	=> false,
		), $attr));

		if (!class_exists('WC_Product_Query')) return '';
		$css_class = '';
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
		}
		wp_enqueue_style('pixfort-carousel-style', PIX_CORE_PLUGIN_URI . 'includes/assets/css/elements/carousel-2.min.css', false, PIXFORT_PLUGIN_VERSION, 'all');
		
		$output = '';
		$classes = array();
		$anim_type = '';
		$anim_delay = '';
		if (!empty($align)) {
			array_push($classes, $align);
			array_push($classes, "w-100");
		}
		array_push($classes, 'd-inline-block');
		$class_names = join(' ', $classes);

		if (!filter_var($autoplay, FILTER_VALIDATE_BOOLEAN)) {
			$autoplay_time = false;
		} else {
			$autoplay_time = (int)$autoplay_time;
		}
		if(is_rtl()){
			if($slider_effect == 'pix-circular-left'){
				$slider_effect = 'pix-circular-right';
			}else if($slider_effect == 'pix-circular-right'){
				$slider_effect = 'pix-circular-left';
			}
		}
		$slider_data = '';
		$pix_id = "pix-slider-" . rand(1, 200000000);
		$slider_opts = array(
			"autoPlay"			=> $autoplay_time,
			"freeScroll"		=> filter_var($freescroll, FILTER_VALIDATE_BOOLEAN),
			"prevNextButtons"	=> filter_var($prevnextbuttons, FILTER_VALIDATE_BOOLEAN),
			"wrapAround"		=> filter_var($slider_wrap, FILTER_VALIDATE_BOOLEAN),
			"pageDots"			=> filter_var($pagedots, FILTER_VALIDATE_BOOLEAN),
			"adaptiveHeight"	=> filter_var($adaptiveheight, FILTER_VALIDATE_BOOLEAN),
			"rightToLeft"		=> filter_var($righttoleft, FILTER_VALIDATE_BOOLEAN),
			"cellAlign" 		=> $cellalign,
			"contain"			=> true,
			"slider_effect"			=> $slider_effect,
			"slider_style"			=> $slider_style,
			"pix_id"			=>  '#' . $pix_id,
		);
		$slider_data = json_encode($slider_opts);
		$slider_data = 'data-flickity=\'' . $slider_data . '\'';
		if ($visible_overflow == 'pix-overflow-all-visible') $visible_y = '';



		$extra_classes = [];
		
		$effectsClasses = \PixfortCore::instance()->coreFunctions->getEffectsClasses($style, $hover_effect, $add_hover_effect);
		array_push($extra_classes, $effectsClasses);

		$extra_classes = join(' ', $extra_classes);
		$extra_classes .= ' ' . $rounded_img;
		$oldOutput = '';
		$oldOutput  .= '<div class="' . $css_class . '">';
		$oldOutput  .= '<div id="' . $pix_id . '" class="pix-main-slider pix-shop-carousel ' . $visible_overflow . ' ' . $slider_style . ' ' . $slider_effect . ' ' . $slider_scale . ' ' . $visible_y . ' pix-slider-' . $slider_num . ' pix-slider-dots ' . $dots_style . ' ' . $dots_align . '" ' . $slider_data . '>';

		$args = array(
			// 'sku' => $groupSku,
			'post_type' => 'product',
			'orderby' => $orderby,
			'order' => $order,
			'posts_per_page' => $count,
			'status' => array('publish'),
			// 'stock_status' => 'instock'
			// 'orderby' => $ordered_by,
			// 'exclude' => array($product->get_id())
		);
		if (!$display_outstock) {
			$args['stock_status'] = 'instock';
		}
		// categories
		if ($category_multi) {
			$args['category'] = explode(',', trim($category_multi));
		} elseif ($category) {
			$args['category'] = $category;
		}
		$query = new WC_Product_Query($args);
		$sku_products = $query->get_products();
		
		$itemsOutputArray = [];

		if ($sku_products) :
			foreach ($sku_products as $sku_product) {
				$itemOutput = '';
				if (($display_outstock) || ($sku_product->get_stock_status() !== 'outofstock')) {
					$oldOutput .= '<div class="carousel-cell">';
					$oldOutput .= '<div class="slide-inner ' . $cellpadding . '">';
					$oldOutput .= '<div class="pix-slider-effects">';

					global $item_style;
					global $item_extra_classes;
					$item_style = $product_style;
					$item_extra_classes = $extra_classes;
					// $post_object = get_post($sku_product->get_id());
					// setup_postdata($GLOBALS['post'] =& $post_object);
					// wc_get_template_part('content', 'product');
					// $oldOutput .= get_template_part( 'woocommerce/pixfort/product-top-img' );
					$itemOutput .= do_shortcode('[products test6="asd" ids="' . $sku_product->get_id() . '"]');
					$oldOutput .= $itemOutput;
					$oldOutput .= '</div>';
					$oldOutput .= '</div>';
					$oldOutput .= '</div>';
					$itemsOutputArray[] = $itemOutput;
				}
			}


		endif;
		wp_reset_postdata();




		$oldOutput .= '</div>';
		$oldOutput .= '</div>';

		if (defined('PIXFORT_SLIDER_OLD')) {
			wp_enqueue_script('pix-flickity-js');
			$output .= $oldOutput;
		}
		if (defined('PIXFORT_SLIDER_SWIPER')) {
			require_once PIX_CORE_PLUGIN_DIR . '/includes/elements/extras/slider.php';
			if (!filter_var($is_elementor, FILTER_VALIDATE_BOOLEAN)) {
				$attr['enable_wpb_navigation_styling'] = true;
			}
			if($cellalign === 'right'){
				if(!$righttoleft){
					$attr['reverseDirection'] = true;
					$first = $itemsOutputArray[0];
					$rest  = array_slice($itemsOutputArray, 1);
					$restR = array_reverse($rest);
					$itemsOutputArray = array_merge([$first], $restR);
				} 
				$attr['righttoleft'] = true;
			}
			$attr['items'] = $itemsOutputArray;
			$attr['cellpadding'] = $cellpadding;
			$output .= pixfort_slider($attr, $content);
		}

		return $output;
	}
}
