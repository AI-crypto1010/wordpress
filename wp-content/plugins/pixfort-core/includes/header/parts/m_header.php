<?php
function renderMobileHeader($m_header_val, $opts, $post = null) {

    if (!empty($m_header_val->m_header_1)) {
        extract(shortcode_atts([
            'style'         => '',
            'sticky'        => ''
        ], $opts));
        
        $smarSticky = get_post_field('pix-enable-mobile-sticky', $post);
        if (!empty($smarSticky)) {
            if ($smarSticky == 'enable') {
                $sticky = 'is-sticky';
            } else if ($smarSticky == 'smart') {
                $sticky = 'is-smart-sticky';
            }
        }

        $col_opts = [];
        if (!empty($m_header_val->m_header_1->opts)) {
            foreach ($m_header_val->m_header_1->opts as $i => $v) {
                $col_opts[$v->name] = $v->val;
            }
        }
        extract(shortcode_atts([
            'size' 		=> 'flex-1',
            'align'         => '',
            'custom_classes' 		=> ''
        ], $col_opts));
        $align = pix_align_to_flex($align);
        $align = pix_align_to_flex($align);
        ?>
        <header data-area="m_header" id="mobile_head" class="pixfort-header-area pixfort-area-content pix-header <?php echo $sticky; ?> pix-header-mobile d-inline-block pix-header-normal pix-scroll-shadow">
            <div class="container-fluid">
                <?php if (!empty($m_header_val->m_header_1->val)) { ?>
                    <nav data-col="m_header_1" class="pixfort-header-col navbar navbar-hover-drop navbar-light <?php echo $custom_classes; ?> <?php echo $size; ?> <?php echo esc_attr($align); ?>">
                        <?php
                        foreach ($m_header_val->m_header_1->val as $key => $value) {
                            pix_get_header_elem('m_header', $value, $opts);
                        }
                        ?>
                    </nav>
                <?php }
                if ($style == "border-bottom") { ?>
                    <div class="pix-header-area-line pix-header-border"></div>
                <?php } ?>
            </div>
            <?php if ($style == "border-bottom-wide") { ?>
                <div class="pix-header-area-line pix-header-border"></div>
            <?php } ?>
        </header>
<?php
    }
}
