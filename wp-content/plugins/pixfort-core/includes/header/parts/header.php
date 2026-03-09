<?php
function renderHeaderDefault($header_data, $opts, $header_sticky, $containerWidth = 'default', $containerScrollWidth = 'default') {
	if (!empty($header_data->val)) {
		if (!empty($header_data->val->header_1)) {
			$header_val = $header_data->val;
			extract(shortcode_atts(array(
				'style'                         => '',
				'sticky'                         => '',
			), $opts));
			if(empty($sticky)){
				$sticky = $header_sticky;
				if(empty($sticky)){
					$sticky = 'is-sticky';
				}
			}
			$col_opts = array();
			if (!empty($header_val->header_1->opts)) {
				foreach ($header_val->header_1->opts as $i => $v) {
					if(!empty($v->name)) $col_opts[$v->name] = $v->val;
				}
			}
			extract(shortcode_atts(array(
				'align'         => 'text-left'
			), $col_opts));
			$align = pix_align_to_flex($align);
			
			
			// $headerClasses = '';
			// if (!empty(get_post_field('pix-enable-sticky', $post))) {
			// 	if (get_post_field('pix-enable-sticky', $post) == 'smart') {
			// 		$headerClasses .= ' is-smart-sticky';
			// 	}
			// }
			?>
			<header data-area="header" id="masthead" class="pixfort-header-area pixfort-area-content pix-header <?php echo $sticky; ?> pix-header-desktop d-block pix-header-normal pix-header-container-area" data-width="<?php echo $containerWidth; ?>" data-scroll-width="<?php echo $containerScrollWidth; ?>">
				<div class="container">
					<div class="pix-row position-relative d-flex justify-content-between">
						<?php
						foreach ($header_val as $col) {
							$col_opts = $opts;
							if (!empty($col->opts)) {
								foreach ($col->opts as $i => $v) {
									if(!empty($v->name)) $col_opts[$v->name] = $v->val;
								}
							}
							extract(shortcode_atts(array(
								'size' 		=> 'flex-1',
								'align' 		=> '',
								'custom_classes' 		=> ''
							), $col_opts));
							$align = pix_align_to_flex($align);
						?>
							<nav data-col="<?php echo $col->name; ?>" class="pixfort-header-col <?php echo $size; ?> navbar <?php echo $custom_classes; ?> <?php echo esc_attr($align); ?> pix-main-menu navbar-hover-drop navbar-expand-lg navbar-light <?php echo esc_attr($align); ?>">
								<?php

								foreach ($col->val as $key => $value) {
									pix_get_header_elem('header', $value, $opts);
								}
								?>
							</nav>
						<?php
						}
						?>
					</div>
					<?php if ($style == "border-bottom") : ?>
						<div class="pix-header-area-line pix-header-border pix-main-header-line"></div>
					<?php endif; ?>

				</div>
				<?php if ($style == "border-bottom-wide") { ?>
					<div class="pix-header-area-line pix-header-border pix-main-header-line"></div>
				<?php
				}
				?>
			</header>
<?php
		}
	}
}
