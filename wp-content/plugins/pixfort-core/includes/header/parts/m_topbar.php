<?php
function renderMobileTopbar( $m_topbar_val,$opts ) {
    extract(shortcode_atts([
        'style'         => '',
        'sticky'        => ''
    ], $opts));
    if (count($m_topbar_val->m_topbar_1->val) > 0) {
?>
        <div data-area="m_topbar" class="pixfort-header-area pixfort-area-content <?php echo $sticky; ?> pix-topbar pix-header-mobile pix-topbar-normal">
            <div class="container-fluid">
                    <?php
                    $col_opts = $opts;
                    if (!empty($m_topbar_val->m_topbar_1->opts)) {
                        foreach ($m_topbar_val->m_topbar_1->opts as $i => $v) {
                            $col_opts[$v->name] = $v->val;
                        }
                    }
                    extract(shortcode_atts(array(
                        'size' 		=> 'flex-1',
                        'align'         => 'text-left',
                        'custom_classes' 		=> ''
                    ), $col_opts));
                    $align = pix_align_to_flex($align);
                    if ($align == 'd-flex') $align = $align . ' justify-content-between';
                    ?>
                    <div data-col="m_topbar_1" class="pixfort-header-col <?php echo $custom_classes; ?> <?php echo $size; ?> <?php echo esc_attr($align); ?> py-2">
                        <?php
                        foreach ($m_topbar_val->m_topbar_1->val as $key => $value) {
                            pix_get_header_elem('m_topbar', $value, $opts);
                        }
                        ?>
                    </div>
                <?php if ($style == "border-bottom"){ ?>
                    <div class="pix-header-area-line"></div>
                <?php } ?>
            </div>
            <?php if ($style == "border-bottom-wide"){ ?>
                <div class="pix-header-area-line"></div>
            <?php } ?>
        </div>
<?php }
}
