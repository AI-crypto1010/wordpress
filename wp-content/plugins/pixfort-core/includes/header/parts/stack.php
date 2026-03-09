<?php
function renderStack($stack_data, $opts, $containerWidth = 'default', $containerScrollWidth = 'default') {
	$stack_val = $stack_data->val;
	if (
		!empty($stack_val->stack_1->val)
		|| !empty($stack_val->stack_2->val)
		|| !empty($stack_val->stack_3->val)
	) {
		extract(shortcode_atts(array(
			'style' 		=> '',
			'sticky' 		=> ''
		), $opts));
?>
		<div data-area="stack" class="pixfort-header-area pixfort-area-content <?php echo $sticky; ?> pix-header-desktop d-block position-relative2 w-100 pix-header-stack" data-width="<?php echo $containerWidth; ?>" data-scroll-width="<?php echo $containerScrollWidth; ?>">
			<?php if ($style == "border-top-wide" || $style == "border-both-wide"): ?>
				<div class="pix-header-area-line pix-header-border pix-stack-line"></div>
			<?php endif; ?>
			<div class="container">
				<?php if ($style == "border-top" || $style == "border-both"): ?>
					<div class="pix-header-area-line pix-header-border pix-stack-line"></div>
				<?php endif; ?>
				<div class="pix-row d-flex align-items-center align-items-stretch">
					<?php
					$columnIndex = 0;
					$areaColsCount = count((array) $stack_val);
					foreach ($stack_val as $col) {
						$col_opts = $opts;
						$defaultAlign = '';
						if ($columnIndex === 0) {
							$defaultAlign = 'text-left';
						} else if ($columnIndex === 1) {
							if($areaColsCount===3){
								$defaultAlign = 'text-center';
							}else{
								$defaultAlign = 'text-right';
							}
						} else if ($columnIndex === 2) {
							$defaultAlign = 'text-right';
						}

						if (!empty($col->opts)) {
							foreach ($col->opts as $i => $v) {
								if (!empty($v->name)) $col_opts[$v->name] = $v->val;
							}
						}
						extract(shortcode_atts(array(
							'size' 		=> 'flex-1',
							'custom_classes' 		=> '',
							'align' 		=> ''
						), $col_opts));
						if (empty($align)||$align==='default') $align = $defaultAlign;
						$align = pix_align_to_flex($align);
						$display_col = sizeof($col->val) > 0 ? 'pix-header-min-height' : '';
					?>
						<div data-col="<?php echo $col->name; ?>" class="pixfort-header-col <?php echo $custom_classes; ?> <?php echo esc_attr($display_col); ?> <?php echo $size; ?> column <?php echo esc_attr($display_col); ?> <?php echo esc_attr($align); ?> d-flex align-items-center">
							<?php
							foreach ($col->val as $key => $value) {
								pix_get_header_elem('stack', $value, $col_opts);
							}
							?>
						</div>
					<?php
						$columnIndex++;
					}
					?>
				</div>
				<?php if ($style == "border-bottom" || $style == "border-both"): ?>
					<div class="pix-header-area-line pix-header-border pix-stack-line"></div>
				<?php endif; ?>
			</div>
			<?php if ($style == "border-bottom-wide" || $style == "border-both-wide"): ?>
				<div class="pix-header-area-line pix-header-border pix-stack-line"></div>
			<?php endif; ?>
		</div>
<?php }
}
