<?php

function renderHeaderBoxed($header_data, $opts, $header_sticky, $stack_data, $stackOpts, $pix_topbar_background = '', $topbarScrollBg = '', $topbarSticky = '', $is_topbar_empty = false) {
    if (!empty($header_data->val)) {
        if (!empty($header_data->val->header_1)) {
            $header_val = $header_data->val;
            extract(shortcode_atts(array(
                'background'         => 'white',
                'style'         => '',
                'sticky'                         => '',
            ), $opts));
            
            if(empty($sticky)){
				$sticky = $header_sticky;
                if(empty($sticky)){
					$sticky = 'is-sticky';
				}
			}
            
            // $bg = '';
            // if (!empty($background)) {
            //     $bg = 'bg-' . $background;
            // }

            $box_classes = '';
            $header_classes = '';
            $stack_classes = '';

            if ($is_topbar_empty) {
                $header_classes = 'pix-no-topbar pix-mt-20 ';
            } else if(!empty($pix_topbar_background) && $pix_topbar_background !== 'transparent' && $background !== 'transparent') {
                $header_classes = 'pix-mt-20 ';
            } else {
                $header_classes = 'pix-transparent-topbar ';
            }
            if($topbarSticky === 'is-sticky' || $topbarSticky === 'is-smart-sticky') {
                if($topbarScrollBg === 'transparent') {
                    $header_classes .= ' pix-transparent-topbar-scroll ';
                } else {
                    $header_classes .= ' pix-bg-topbar-scroll ';
                }
            } else {
                $header_classes .= ' pix-scroll-top-margin ';
            }

            // $stack_opts = [];
            if ($stack_data) {
                $stack_val = $stack_data->val;
                // if (!empty($stack_data->opts)) {
                //     foreach ($stack_data->opts as $i => $v) {
                //         $stack_opts[$v->name] = $v->val;
                //     }
                // }
                
                // if (!empty($stack_opts['background'])) {
                //     if ($stack_opts['background'] == 'transparent') {
                //         // $box_classes .= ' rounded-xl';
                //     } else {
                //         // $box_classes .= ' pix-header-box-rounded-top';
                //     }
                // }
                if (
                    empty($stack_val->stack_1->val)
                    && empty($stack_val->stack_2->val)
                    && empty($stack_val->stack_3->val)
                ) {
                    $box_classes .= ' pix-rounded-header-area';
                }

                $col_opts = array();
                if (!empty($header_val->header_1->opts)) {
                    foreach ($header_val->header_1->opts as $i => $v) {
                        if (!empty($v->name)) $col_opts[$v->name] = $v->val;
                    }
                }
                // $headerClasses = '';
                // if (!empty(get_post_field('pix-enable-sticky', $post))) {
                //     if (get_post_field('pix-enable-sticky', $post) == 'smart') {
                //         $headerClasses .= ' is-smart-sticky';
                //     }
                // }
                extract(shortcode_atts(array(
                    'align'         => 'text-left'
                ), $col_opts));
                $align = pix_align_to_flex($align);
            }
            $boxRoundedClasses = pixGetRoundedClasses($opts, $stackOpts);
            $header_classes .= $boxRoundedClasses['header'];
            $stack_classes .= $boxRoundedClasses['stack'];
?>
            <header id="masthead" class=" pix-header pix-header-desktop position-relative pix-header-box ">
                <div class="container">
                    <div data-area="header" class="pixfort-header-area pixfort-area-content pix-header-box-1 pix-header-box-part <?php echo $sticky; ?> <?php echo esc_attr($header_classes); ?> pix-main-part pix-header-container-area <?php echo esc_attr($box_classes); ?>">
                        <div class="pix-row d-flex justify-content-between">
                            <?php
                            foreach ($header_val as $col) {
                                $col_opts = $opts;
                                if (!empty($col->opts)) {
                                    foreach ($col->opts as $i => $v) {
                                        if (!empty($v->name)) $col_opts[$v->name] = $v->val;
                                    }
                                }
                                extract(shortcode_atts(array(
                                    'size'         => 'flex-1',
                                    'align'         => '',
                                    'custom_classes' 		=> ''
                                ), $col_opts));
                                $align = pix_align_to_flex($align);
                            ?>
                                <nav data-col="<?php echo $col->name; ?>" class="pixfort-header-col <?php echo $custom_classes; ?> <?php echo $size; ?> navbar <?php echo esc_attr($align); ?> pix-main-menu navbar-hover-drop navbar-expand-lg navbar-light <?php echo esc_attr($align); ?>"><?php

                                    foreach ($col->val as $key => $value) {
                                        pix_get_header_elem('header', $value, $opts);
                                    }
                                ?></nav>
                            <?php
                            }
                            ?>
                        </div>
                        <?php if ($style == "border-bottom" || $style == "border-bottom-wide" ) { ?>
                            <div class="pix-header-area-line pix-main-header-line"></div>
                        <?php } ?>
                    </div>
                    <?php

                    if ($stack_data) {
                        extract(shortcode_atts(array(
                            'style'         => '',
                            'sticky'        => '',
                        ), $stackOpts));
                        // if ($bg == 'bg-transparent') {
                        //     $stack_classes .= ' rounded-xl';
                        // }
                    ?>
                        <?php if ($style == "border-top-wide" || $style == "border-both-wide"): ?>
                            <div class="pix-header-area-line pix-header-border"></div>
                        <?php endif; ?>
                        <div data-area="stack" class="pixfort-header-area pixfort-area-content <?php echo $sticky; ?> pix-header-desktop pix-header-stack <?php echo esc_attr($stack_classes); ?> pix-header-box-2 pix-header-box-part">
                            <?php if ($style == "border-top" || $style == "border-both"): ?>
                                <div class="pix-header-area-line pix-header-border"></div>
                            <?php endif; ?>
                            <div class="container">
                                <div class="pix-row row">

                                    <?php
                                    $columnIndex = 0;
                                    $areaColsCount = count((array) $stack_val);
                                    foreach ($stack_val as $col) {
                                        $col_opts = $stackOpts;
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
                                            'size'         => 'flex-1',
                                            'align'         => '',
                                            'custom_classes' 		=> ''
                                        ), $col_opts));
                                        if (empty($align)||$align==='default') $align = $defaultAlign;
                                        $align = pix_align_to_flex($align);
                                        $display_col = sizeof($col->val) > 0 ? 'pix-header-min-height' : '';
                                    ?>
                                        <div data-col="<?php echo $col->name; ?>" class="pixfort-header-col <?php echo $custom_classes; ?> <?php echo esc_attr($display_col); ?> <?php echo $size; ?> column <?php echo esc_attr($display_col); ?> <?php echo esc_attr($align); ?> d-flex align-items-center"><?php
                                            foreach ($col->val as $key => $value) {
                                                pix_get_header_elem('stack', $value, $col_opts);
                                            }
                                        ?></div>
                                    <?php
                                        $columnIndex++;
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php if ($style == "border-bottom" || $style == "border-both") { ?>
                                <div class="pix-header-area-line pix-header-border"></div>
                            <?php } ?>
                        </div>
                        <?php if ($style == "border-bottom-wide" || $style == "border-both-wide") { ?>
                            <div class="pix-header-area-line pix-stack-line pix-header-border"></div>
                    <?php }
                    } ?>
                </div>
            </header>
<?php
        }
    }
}


// function pixGetRoundedClasses($headerOpts, $stackOpts ) {
//     $headerResult = '';
//     $stackResult = '';

//     $transparentHeader = false;
//     $transparentStack = false;
    
//     $isStickyHeader = false;
//     $isStickyStack = false;

//     $isSmartHeader = false;
//     $isSmartStack = false;

//     $transparentHeaderScroll = false;
//     $transparentStackScroll = false;

//     if(!empty($headerOpts['background']) && $headerOpts['background'] == 'transparent') {
//         $transparentHeader = true;
//     }
//     if(!empty($headerOpts['scroll_background']) && $headerOpts['scroll_background'] == 'transparent') {
//         $transparentHeaderScroll = true;
//     }
//     if(!empty($headerOpts['sticky'])) {
//         if($headerOpts['sticky'] == 'is-sticky') {
//             $isStickyHeader = true;
//         } elseif($headerOpts['sticky'] == 'is-smart-sticky') {
//             $isSmartHeader = true;
//         }
//     }
//     if(!empty($stackOpts['sticky'])) {
//         if($stackOpts['sticky'] == 'is-sticky') {
//             $isStickyStack = true;
//         } elseif($stackOpts['sticky'] == 'is-smart-sticky') {
//             $isSmartStack = true;
//         }
//     }
//     if(!empty($stackOpts['background']) && $stackOpts['background'] == 'transparent') {
//         $transparentStack = true;
//     }
//     if(!empty($stackOpts['scroll_background']) && $stackOpts['scroll_background'] == 'transparent') {
//         $transparentStackScroll = true;
//     }
//     if($transparentHeader) {
//         $stackResult .= ' static-rounded';
//     }
//     if($transparentStack) {
//         $headerResult .= ' static-rounded';
//     }

//     if(!$isStickyHeader && !$isSmartHeader) {
//         $stackResult .= ' scroll-rounded';
//     } else {
//         if($transparentHeaderScroll) {
//             $stackResult .= ' scroll-rounded';
//         } else if($isSmartHeader && ($isStickyHeader || $isSmartHeader)) {
//             $stackResult .= ' is-smart-header-rounded';
//         }
//     }
//     if(!$isStickyStack && !$isSmartStack) {
//         $headerResult .= ' scroll-rounded';
//     } else {
//         if($transparentStackScroll) {
//             $headerResult .= ' scroll-rounded';
//         } else if($isSmartStack && ($isStickyHeader || $isSmartHeader)) {
//             $headerResult .= ' is-smart-stack-rounded';
//         }
//     }
//     return [
//         'header' => $headerResult,
//         'stack' => $stackResult
//     ];
// }

function pixGetRoundedClasses($headerOpts, $stackOpts) {
    $headerResult = '';
    $stackResult = '';

    // Check transparency for header and stack
    $transparentHeader = !empty($headerOpts['background']) && $headerOpts['background'] == 'transparent';
    $transparentHeaderScroll = !empty($headerOpts['scroll_background']) && $headerOpts['scroll_background'] == 'transparent';
    $transparentStack = !empty($stackOpts['background']) && $stackOpts['background'] == 'transparent';
    $transparentStackScroll = !empty($stackOpts['background']) && $stackOpts['background'] == 'transparent';
    if(!empty($stackOpts['scroll_background'])){
        $transparentStackScroll = $stackOpts['scroll_background'] == 'transparent';
    }

    // Check sticky options for header and stack
    $isStickyHeader = !empty($headerOpts['sticky']) && $headerOpts['sticky'] == 'is-sticky';
    $isSmartHeader = !empty($headerOpts['sticky']) && $headerOpts['sticky'] == 'is-smart-sticky';
    $isStickyStack = !empty($stackOpts['sticky']) && $stackOpts['sticky'] == 'is-sticky';
    $isSmartStack = !empty($stackOpts['sticky']) && $stackOpts['sticky'] == 'is-smart-sticky';

    // Header & stack static rounded classes
    if ($transparentHeader) {
        $stackResult .= ' static-rounded';
    }
    if ($transparentStack) {
        $headerResult .= ' static-rounded';
    }

    // Header & stack scroll/sticky conditions
    if (!$isStickyHeader && !$isSmartHeader) {
        $stackResult .= ' scroll-rounded';
    } elseif ($transparentHeaderScroll) {
        // $stackResult .= ' scroll-rounded';
    } elseif ($isSmartHeader) {
        $stackResult .= ' is-smart-header-rounded';
    }

    if (!$isStickyStack && !$isSmartStack) {
        $headerResult .= ' scroll-rounded';
    } elseif ($transparentStackScroll) {
        $headerResult .= ' scroll-rounded';
    } elseif ($isSmartStack) {
        $headerResult .= ' is-smart-stack-rounded';
    }

    return [
        'header' => $headerResult,
        'stack' => $stackResult
    ];
}
