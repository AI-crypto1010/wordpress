<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* Levels
* --------------------------------------------------------------------------- */
class PixLevels {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'items_count' 		=> 4,
			'items' 		=> '',
			'active' 		=> '',
			'bold'		=> 'font-weight-bold',
			'italic'		=> '',
			'secondary_font'		=> '',
			'color'		=> 'heading-default',
			'custom_color'		=> '',
            'title_size'		=> 'h5',
			'title_custom_size'		=> '',
			'text_bold'		=> 'secondary-font',
			'text_italic'		=> '',
			'text_secondary_font'		=> '',
			'text_color'		=> 'body-default',
			'text_custom_color'		=> '',
			'active_color'		=> 'primary',
			'active_custom_color'		=> '',
			'not_active_color'		=> 'gray-2',
			'not_active_custom_color'		=> '',
			'css' 		=> '',
		), $attr));

		$css_class = '';
		if(function_exists('vc_shortcode_custom_css_class')){
		    $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );
		}
		wp_enqueue_style('pixfort-levels-style', PIX_CORE_PLUGIN_URI.'includes/assets/css/elements/levels.min.css', false, PIXFORT_PLUGIN_VERSION, 'all');
		$levels = [];
		if(is_array($items)){
			$levels = $items;
		}else{
			if(function_exists('vc_param_group_parse_atts')){
				$levels = vc_param_group_parse_atts( $items );
			}
		}

		$title_classes = pix_get_text_format_classes($bold, $italic, $secondary_font, $color);
  		$text_classes = pix_get_text_format_classes($text_bold, $text_italic, $text_secondary_font, $text_color);

		$title_style = '';
		$text_style = '';
		$title_tag = 'h5';
		if($title_size=='custom'){
			$title_tag = 'div';
			$title_style .= 'font-size:'.$title_custom_size.';';
		}else{
			$title_tag = $title_size;
		}

		if($color=='custom'){
			$title_style .= 'color:'.$custom_color.' !important;';
		}
		if($text_color=='custom'){
			$text_style = 'style="color:'.$text_custom_color.';"';
		}
		$title_style = 'style="'.$title_style.'"';
		$levels_out = '';
		$col = 12 / $items_count;
		$totalCount = count($levels);
		$colCount = 0;
		$colIt = 0;
		$itemWidthClass = 'col-md-'.$col;
		if($items_count==5){
			$itemWidthClass = 'col-md';
		}
		foreach ($levels as $key => $value) {
			$active_class = 'complete';
			$dot_class = 'bg-'.$active_color;
			$dot_style = '';
			$not_active_class = 'gray-2';

			if($active_color=='custom'){
				if(!empty($active_custom_color)){
					$dot_style = 'style="background:'.$active_custom_color.';"';
				}else{
					$dot_class = 'bg-primary';
				}
			}
			$not_active_class = 'bg-'.$not_active_color;
			$not_active_style = '';
			if($not_active_color=='custom'){
				if(!empty($not_active_custom_color)){
					$not_active_style = 'style="background:'.$not_active_custom_color.';"';
				}else{
					$not_active_class = 'bg-gray-2';
				}
			}
			if(!empty($active)&&$key==($active-1)){
				$active_class = 'active';
			}
			if(!empty($active)&&$key>($active-1)){
				$dot_class = $not_active_class;
				$dot_style = $not_active_style;
			}

			$levels_out .= '<div class="col-xs-12 '.$itemWidthClass.' pix-levels-step d-flex flex-column '.$active_class.' px-0">
			  <'.$title_tag.' class="pix-levels-title text-center '.$title_classes.' pb-3 d-flex flex-column align-items-center justify-content-center" '.$title_style.'>'.$value['title'].'</'.$title_tag.'>
			  <div class="position-relative w-100 text-center mb-3">
				  <div class="progress '.$not_active_class.'" '.$not_active_style.'><div class="progress-bar '.$dot_class.'" '.$dot_style.'></div></div>
				  <div class="pix-leveles-dot-div">';
				  	if(!empty($value['link'])){
						if(empty($value['target'])){$value['target']='';}
						$levels_out .= '<a href="'.$value['link'].'" target="'.$value['target'].'" class="pix-levels-dot '.$dot_class.'" '.$dot_style.'>
				  						  <span class="pix-levels-dot-inner bg-dark-opacity-3"></span>
				  					  </a>';
					}else{
						$levels_out .= '<span class="pix-levels-dot '.$dot_class.'" '.$dot_style.'>
										  <span class="pix-levels-dot-inner bg-dark-opacity-3"></span>
									  </span>';
					}

				  $levels_out .= '</div>
			  </div>';
			  if(!empty($value['text'])) $levels_out .= '<p class="text-center pix-p-10 '.$text_classes.'" '.$text_style.'>'.$value['text'].'</p>';
			$levels_out .= '</div>';
			$colCount++;
			$colIt++;
			if($colCount==$items_count&&$items_count!=$totalCount&&$colIt!==$totalCount){
				$colCount=0;
				$levels_out .= '<div class="w-100"></div>';
			}
		}

        $output = '';
        $output .= '<div class="row pix-levels mb-3 mb-sm-0 mx-0 '.$css_class.'" style="border-bottom:0;">';
        	$output .= $levels_out;
        $output .= '</div>';

		return $output;
	}
}
