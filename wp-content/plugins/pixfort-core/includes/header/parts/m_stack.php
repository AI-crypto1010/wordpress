<?php
function renderMobileStack($m_stack_val, $opts) {
    extract(shortcode_atts([
        'style'         => '',
        'sticky'        => ''
    ], $opts));
    if (count($m_stack_val->m_stack_1->val) > 0) {
?>
        <div data-area="m_stack" class="pixfort-header-area pixfort-area-content <?php echo $sticky; ?> w-100 pix-header-mobile pix-stack-mobile">
            <?php if ($style == "border-top-wide" || $style == "border-both-wide"): ?>
                <div class="pix-header-area-line pix-header-border"></div>
            <?php endif; ?>
            <div class="container-fluid">
                <?php if ($style == "border-top" || $style == "border-both"): ?>
                    <div class="pix-header-area-line pix-header-border"></div>
                <?php endif; ?>
                    <?php
                    $col_opts = $opts;
                    if (!empty($m_stack_val->m_stack_1->opts)) {
                        foreach ($m_stack_val->m_stack_1->opts as $i => $v) {
                            $col_opts[$v->name] = $v->val;
                        }
                    }
                    extract(shortcode_atts([
                        'size' 		=> 'flex-1',
                        'align'         => 'text-left',
                        'custom_classes' 		=> ''
                    ], $col_opts));
                    $align = pix_align_to_flex($align);
                    if ($align == 'd-flex') $align = $align . ' justify-content-between';
                    
                    ?>
                    <div data-col="m_stack_1" class="pixfort-header-col <?php echo $custom_classes; ?> <?php echo $size; ?> <?php echo esc_attr($align); ?> py-2">
                        <?php
                        foreach ($m_stack_val->m_stack_1->val as $key => $value) {
                            pix_get_header_elem('m_stack', $value, $col_opts);
                        }
                        ?>
                    </div>
                <?php if ($style == "border-bottom" || $style == "border-both"): ?>
                    <div class="pix-header-area-line pix-header-border"></div>
                <?php endif; ?>
            </div>
            <?php if ($style == "border-bottom-wide" || $style == "border-both-wide"): ?>
                <div class="pix-header-area-line pix-header-border"></div>
            <?php endif; ?>
        </div>
<?php }
}
