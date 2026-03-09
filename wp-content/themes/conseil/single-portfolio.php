<?php

/**
 * The template for displaying all single portfolio posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package pixfort theme
 */

get_header();

$bg_class = '';
$bg_style = '';
$add_intro_placeholder = false;
if (!empty(pix_get_option('portfolio-bg-color'))) {
	if (pix_get_option('portfolio-bg-color') == 'custom') {
		$bg_style = 'style="background:' . pix_get_option('custom-portfolio-bg-color') . ';"';
	} else {
		$bg_class = 'bg-' . pix_get_option('portfolio-bg-color');
	}
}
if (!empty(pix_get_option('portfolio-with-intro')) && pix_get_option('portfolio-with-intro')) {
	get_template_part('template-parts/intro');
} else {
	$add_intro_placeholder = true;
}

$customTemplate = false;
if (
	class_exists('PixfortCore')
	&& method_exists(\PixfortCore::instance()->themeBuilder, 'hasPageTemplate')
) {
	$customTemplate = \PixfortCore::instance()->themeBuilder->hasPageTemplate();
}

echo '<div class="pix-portfolio-site-content ' . $bg_class . '" ' . $bg_style . '>';
if ($customTemplate) {
	if (
		class_exists('PixfortCore')
		&& method_exists(\PixfortCore::instance()->themeBuilder, 'getPageTemplate')
	) {
		echo \PixfortCore::instance()->themeBuilder->getPageTemplate();
	}
} else {

	while (have_posts()) :
		the_post();

		if ($add_intro_placeholder) {
?>
			<div class="pix-main-intro-placeholder"></div>
<?php
		}

		$layout = 'default';
		if (get_post_meta(get_the_ID(), 'pix-post-custom-layout', true)) {
			$layout = get_post_meta(get_the_ID(), 'pix-post-custom-layout', true);
		} elseif (!empty(pix_get_option('portfolio-layout'))) {
			$layout = pix_get_option('portfolio-layout');
		}
		get_template_part('template-parts/portfolio-item', $layout);


		$prevProject = esc_attr__('Previous project', 'conseil');
		$nextProject = esc_attr__('Next project', 'conseil');

		$prevIcon = '';
		$nextIcon = '';
		if (pixCheckIconsAvailable()) {
			$prevIcon = \PixfortCore::instance()->icons->getIcon('Line/pixfort-icon-arrow-left-2', 24, 'text-body-default mr-3 pix-hover-left');
			$nextIcon = \PixfortCore::instance()->icons->getIcon('Line/pixfort-icon-arrow-right-2', 24, 'text-body-default ml-3 pix-hover-right');
			if (is_rtl()) {
				$prevIcon = \PixfortCore::instance()->icons->getIcon('Line/pixfort-icon-arrow-right-2', 24, 'text-body-default ml-3 pix-hover-left');
				$nextIcon = \PixfortCore::instance()->icons->getIcon('Line/pixfort-icon-arrow-left-2', 24, 'text-body-default mr-3 pix-hover-right');
			}
		}

		echo '<div class="pix-portfolio-footer-nav">';
		if (!empty(pix_get_option('portfolio-navigation'))) {
			$prev = '<div class="card shadow-hover-sm shadow-sm d-inline-block m-3 pix-hover-item pix-base-background">
	                      <div class="card-body pix-px-20 pix-py-10">
	                          <div class="d-flex justify-content-between align-items-center">
							  	' . $prevIcon . '
								<div>
								<div class="text-body-default text-xs line-height-1">' . $prevProject . '</div>
								<p class="card-title mb-0 text text-heading-default font-weight-bold line-height-1">%title</p>
								</div>
	                        </div>
	                      </div>
	                    </div>';
			$next = '<div class="card shadow-hover-sm shadow-sm d-inline-block m-3 pix-hover-item pix-base-background">
	                      <div class="card-body pix-px-20 pix-py-10">
	                          <div class="d-flex justify-content-between align-items-center">
								<div>
								<div class="text-body-default text-xs line-height-1">' . $nextProject . '</div>
								<p class="card-title mb-0 text text-heading-default font-weight-bold line-height-1">%title</p>
								</div>
								' . $nextIcon . '
	                        </div>
	                      </div>
	                    </div>';
			$navigatioArgs = array(
				'prev_text'                  => $prev,
				'next_text'                  => $next,
				'screen_reader_text' => esc_attr__('Continue Reading', 'conseil'),
			);
			if (!empty(pix_get_option('portfolio-in-same-term'))) {
				$navigatioArgs['in_same_term'] = true;
				$navigatioArgs['taxonomy'] = 'portfolio-types';
			}
			the_post_navigation($navigatioArgs);
		}
		if (function_exists('get_pixfort_likes')) {
			echo '<div class="pix-portfolio-like-btn">';
			echo get_pixfort_likes();
			echo '</div>';
		}
		echo '</div>';

		// If comments are open or we have at least one comment, load up the comment template.
		if (comments_open() || get_comments_number()) :
			comments_template();
		endif;

	endwhile; // End of the loop.
}
echo '</div>';

get_footer();
