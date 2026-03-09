<?php

function renderTopbar($topbar_val, $opts, $containerWidth = 'default', $containerScrollWidth = 'default') {
	// Check if there are no columns to render, exit early
    if (empty($topbar_val)) {
        return;
    }
	// extract(shortcode_atts(array(
	// 	'style'         => '',
	// 	'sticky'        => ''
	// ), $opts));
	// Extract options once at the beginning
    $style = $opts['style'] ?? '';
    $sticky = $opts['sticky'] ?? '';
    $is_topbar_empty = true;

	// Loop through columns to check if any column has values
	foreach ($topbar_val as $col) {
		if (!empty($col->val)) {
			$is_topbar_empty = false;
			break; // Exit the loop if we find a non-empty column
		}
	}

	// Only render the topbar if it's not empty
	if (!$is_topbar_empty) {
?>
		<div data-area="topbar" class="pixfort-header-area pixfort-area-content <?php echo $sticky; ?> pix-topbar position-relative2 pix-header-desktop pix-topbar-normal" data-width="<?php echo $containerWidth; ?>" data-scroll-width="<?php echo $containerScrollWidth; ?>">
			<div class="container">
				<div class="pix-row d-flex align-items-center align-items-stretch">
					<?php
					$columnIndex = 0;
					$areaColsCount = count((array) $topbar_val);
					$emptyCol3 = false;
					if($areaColsCount===3){
						if(!empty($topbar_val->topbar_3)) {
							if(empty($topbar_val->topbar_3->val)){
								$emptyCol3 = true;
							}
						}
					}
					foreach ($topbar_val as $col) {
						if (!empty($col->val)) {
							$col_opts = $opts;
							$defaultAlign = '';
							if ($columnIndex === 0) {
								$defaultAlign = 'text-left';
							} else if ($columnIndex === 1) {
								if($areaColsCount===3&&!$emptyCol3){
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
							// extract(shortcode_atts(array(
							// 	'size'          => 'flex-fill',
							// 	'custom_classes' => '',
							// 	'align'         => ''
							// ), $col_opts));
							$size = $col_opts['size'] ?? 'flex-1';
							$custom_classes = $col_opts['custom_classes'] ?? '';
							// $align = $col_opts['align'] ?? $defaultAlign;
							$align = $defaultAlign;
							if (!empty($col_opts['align']) && $col_opts['align'] !== 'default') {
								$align = $col_opts['align'];
							}
							// if (empty($align)) $align = $defaultAlign;
							$align = pix_align_to_flex($align);
							$display_col = sizeof($col->val) > 0 ? 'pix-header-min-height' : '';
					?>
							<div data-col="<?php echo $col->name; ?>" class="pixfort-header-col col column <?php echo $custom_classes; ?> <?php echo $size; ?> <?php echo esc_attr($display_col); ?> <?php echo esc_attr($align); ?> py-md-0 d-flex align-items-center">
								<?php
								foreach ($col->val as $key => $value) {
									pix_get_header_elem('topbar', $value, $opts);
								}
								?>
							</div>
					<?php
							$columnIndex++;
						}
					}
					?>
				</div>
				<?php if ($style == "border-bottom"): ?>
					<div class="pix-header-area-line pix-topbar-line"></div>
				<?php endif; ?>
			</div>
			<?php if ($style == "border-bottom-wide"): ?>
					<div class="pix-header-area-line pix-topbar-line"></div>
				<?php endif; ?>
		</div>
<?php
	}
}
?>