<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (!function_exists('pix_blog_item')) {
	function pix_blog_item($query_blog, $attr, $divider_out = '') {
		extract(shortcode_atts(array(
			'blog_style'						=> '',
			'blog_size'							=> 'lg',
			'title'								=> '',
			'count'								=> 5,
			'items_count'						=> 3,
			'category'							=> '',
			'category_multi'					=> '',
			'more'								=> '',
			'blog_style_box'					=> false,
			'css'								=> '',
			'rounded_img'  						=> 'rounded-lg',
			'style' 							=> '',
			'hover_effect' 						=> '',
			'add_hover_effect' 					=> '',
			'animation' 						=> '',
			'delay' 							=> '0',
			'bottom_divider_select'				=> '',
			'bottom_moving_divider_color'		=> '',
			'bottom_layers'						=> '3',
			'pix_param_section_1'				=> '',
			'b_1_color'							=> '#fff',
			'b_2_color'							=> 'rgba(255,255,255,0.8)',
			'b_2_animation'						=> 'fade-in-up',
			'b_2_delay'							=> '300',
			'b_3_animation'						=> 'fade-in-up',
			'b_3_delay'							=> '400',
			'b_divider_in_front'				=> 'true',
			'b_flip_h'							=> '',
		), $attr));

		$output = '';
		if ($query_blog && $query_blog->have_posts()) {

			$query_blog->the_post();

			
			$classes = array();

			array_push($classes, $rounded_img);
			

			$effectsClasses = \PixfortCore::instance()->coreFunctions->getEffectsClasses($style, $hover_effect, $add_hover_effect);
            array_push($classes, $effectsClasses);

			$class_names = join(' ', $classes);

			$theme_blog_layouts = array('transparent', 'with-padding', 'full-img', 'default', 'left-img', 'right-img');
			if (in_array($blog_style, $theme_blog_layouts)) {
				if (function_exists('pixfort_get_post_excerpt_template')) {
					$output = pixfort_get_post_excerpt_template(array(
						'blog_layout'	=> $blog_style,
						'blog_type'	=> 'masonry',
						'blog_style_box'	=> $blog_style_box,
						'rounded_img'  => $rounded_img,
						'style' 		=> $style,
						'hover_effect' 		=> $hover_effect,
						'add_hover_effect' 		=> $add_hover_effect,
						'padding_bottom' 		=> 'pix-pb-0',
						'blog_size'				=> $blog_size,
						'animation' 	=> $animation,
						'delay' 	=> $delay,
					));
				}
			} else {
				$size = array(1244, 800);
				$round = '';
				if ($blog_style == 'padding') {
					$round = $rounded_img;
				}
				$attrs = array(
					'class'	=> 'img-fluid ' . $round . ' card-img-top',
					'style'	=> 'height:200px;width:100%;object-fit: cover;',
					// 'loading' => 'lazy',
					'alt'	=> get_the_title()
				);

				$full_image_url = wp_get_attachment_image(get_post_thumbnail_id(), 'pix-blog-small', false, $attrs);
				$img_src = $full_image_url;

				$cat_args = array('fields' => 'all');
				$cats = wp_get_post_categories(get_the_ID(), $cat_args);

				$cats_str = '';

				/* RTL */
				$padding1 = 'pr-1';
				$margin1 = 'mr-1';
				$margin2 = 'mr-2';
				$readMoreIconClasses = 'ml-1 align-middle pix-hover-right';
				$custom_css = 'padding:5px 10px;line-height:12px;';
				$tooltipPosition = 'right';
				if (is_rtl()) {
					$padding1 = 'pl-1';
					$margin1 = 'ml-1';
					$margin2 = 'ml-2';
					$readMoreIconClasses = 'mr-1 align-middle pix-hover-right';
					$custom_css = 'padding:5px 10px;line-height:12px;';
					$tooltipPosition = 'left';
				}  
				foreach ($cats as $key => $value) {
					$badge_attrs = array(
						'text'	=> $value->name,
						'text_size'	=> 'custom',
						'text_custom_size'		=> '12px',
						'bold'  => 'font-weight-bold',
						'secondary-font'  => 'secondary-font',
						'custom_css'	=> $custom_css,
						'link'      => get_category_link($value->term_id)
					);
					$cats_str .= \PixfortCore::instance()->elementsManager->renderElement('Badge', $badge_attrs);
				}


				$img_classes = '';
				$content_classes = 'pix-p-20';
				$footer_classes = '';
				$thumb_classes = '';
				if ($blog_style == 'padding') {
					$img_classes = 'pix-px-20 pix-pt-20';
					$thumb_classes = $rounded_img;
					$footer_classes .= ' pix-m-20 pix-p-20 ' . $rounded_img;
				}

				$box_classes = '';

				if ($blog_style_box) {
					$box_classes = 'shadow-hover-sm2 shadow-sm2 bg-white ';
				} else {
					$footer_classes .= ' ' . $rounded_img;
					$thumb_classes = $rounded_img;
				}

				$anim_type = '';
				$anim_delay = '';
				$anim = '';
				if (!empty($animation)) {
					$anim = 'animate-in';
					$anim_type = 'data-anim-type="' . $animation . '"';
					$anim_delay = 'data-anim-delay="' . $delay . '"';
				}

				$output .= '<div class="pix-content-box pix-post-meta-element pix-post-meta-basic fly-sm2 d-flex align-content-between flex-wrap align-self-stretch ' . $class_names . ' overflow-hidden w-100 ' . $anim . ' ' . implode(' ', get_post_class($box_classes)) . '" ' . $anim_type . ' ' . $anim_delay . '>
				<div class="d-flex align-items-start w-100">
					<div class="w-100">';
				if (!empty($img_src)) {
					$output .= '<div class="d-block ' . $img_classes . '">';
					$output .= '<a href="' . get_permalink() . '">';
					$output .= '<div class="' . $thumb_classes . ' overflow-hidden position-relative d-block pix-fit-cover" style="height:200px;width:100%;">';
					$output .= $img_src;
					$output .= $divider_out;
					$output .= '</div>';
					$output .= '</a>';
					$output .= '</div>';
				} else {

					$output .= '<div class="d-block ' . $img_classes . '">';
					$output .= '<a href="' . get_permalink() . '">';
					$output .= '<div class="' . $thumb_classes . ' overflow-hidden position-relative d-block pix-fit-cover" style="height:200px !important;width:100%;">';
					$output .= '<div class="d-inline-block w-100 h-100 bg-primary" style="min-height:200px;"></div>';
					$output .= $divider_out;
					$output .= '</div>';
					$output .= '</a>';
					$output .= '</div>';
				}

				$output .= '<div class="d-block ' . $content_classes . ' position-relative">
							<span class="pix-post-meta-categories text-sm pb-1 mb-1">' . $cats_str . '</span>
							<a class="text-heading-default" href="' . get_permalink() . '"><div class="card-title mb-2 h5 secondary-font font-weight-bold">' . get_the_title() . '</div></a>';


				$output .= '<a class="pix-post-meta-date pix-blog-post-text text-sm mb-0 d-inline-block text-body-default svg-body-default" href="' . get_permalink() . '">';
				// $output .= '<img class="pr-2 align-middle2" src="'.PIX_CORE_PLUGIN_URI.'functions/images/blog/blog-post-date-icon.svg"/>';
				$output .= '<span class="' . $padding1 . '">
								' . pixGetFileContents( '/functions/images/blog/blog-post-date-icon.svg') . '
								</span>';
				$output .= '<span class="text-body-default pix-blog-post-text">' . get_the_date() . '</span>';
				$output .= '</a>';
				if ($blog_size == 'lg') {
					$output .= '<p class="card-text pix-pt-10 text-body-default pix-blog-post-text">' . get_the_excerpt() . '</p>';
				}

				$output .= '</div>
					</div>
				</div>';

				$comment_link = get_comments_link();
				$comment_count = get_comments_number();
				$author = get_the_author();
				$author_img = get_avatar(get_the_author_meta('ID'), 24, '', $author, array('class' => 'pix_blog_sm_avatar'));
				if (empty($author_img)) {
					$author_img = pixGetFileContents( '/functions/images/blog/blog-post-author-icon.svg');
				}

				$likes = '';
				if (function_exists('get_pixfort_likes')) {
					$likes .= get_pixfort_likes();
				}

				if ($blog_size == 'lg' || $blog_size == 'md') {
					$output .= '<div class="blog-card-meta-area card-footer2 bg-gray-1 text-right d-flex align-items-center w-100 pix-p-20 ' . $footer_classes . '" style="line-height:0;">
									<div class="pix-post-meta-author text-left ' . $padding1 . '">
										<span class="text-sm '.$margin2.'" data-toggle="tooltip" data-placement="'.$tooltipPosition.'" title="' . esc_attr__('By', 'pixfort-core') . ' ' . $author . '">
											<span class="' . $padding1 . '">
											' . $author_img . '
											</span>
										</span>
									</div>';
					if (comments_open()) {
						$output .= '<div class="pix-post-meta-comments text-left ' . $padding1 . '">';
						$output .= '<a href="' . $comment_link . '" class="text-xs '.$margin1.' text-body-default svg-body-default pix-blog-post-text">
												<span class="' . $padding1 . '">
												' . pixGetFileContents( '/functions/images/blog/blog-post-comments-icon.svg') . '
												</span>
												<span class="align-middle font-weight-bold">' . $comment_count . '</span>
											</a>
										</div>';
					}
					$output .= $likes . '
									<div class="flex-fill text-right">
										<a href="' . get_permalink() . '" class="btn d-inline-flex align-items-center btn-sm p-0 mx-0 btn-link text-body-default svg-body-default font-weight-bold pix-hover-item pix-blog-post-text">
											<span class="d-flex align-items-center">
												<span class="d-flex">' . esc_attr__('Read more', 'pixfort-core') . '</span>
												<span class="' . $readMoreIconClasses . '">';
												if(is_rtl()){
													$output .= \PixfortCore::instance()->icons->getIcon('Line/pixfort-icon-arrow-left-2', 24, 'text-18');
												}else{
													$output .= \PixfortCore::instance()->icons->getIcon('Line/pixfort-icon-arrow-right-2', 24, 'text-18');
												}
												$output .= '</span>
											</span>
										</a>
									</div>
								</div>';
				}
				$output .= '</div>';
			}
		}
		return $output;
	}
}
