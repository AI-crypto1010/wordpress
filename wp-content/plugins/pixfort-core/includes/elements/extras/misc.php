<?php

if (!function_exists('sc_pix_br')) {
	function sc_pix_br($attr, $content = null) {
		return '<br />';
	}
}
add_shortcode('pix_br', 'sc_pix_br');

if (!function_exists('pixfort_dynamic_site_url')) {
    function pixfort_dynamic_site_url($attr) {
        return site_url();
    }
}
add_shortcode( 'site_url', 'pixfort_dynamic_site_url' );

/* ---------------------------------------------------------------------------
* date [pix_date]
* --------------------------------------------------------------------------- */

if (!function_exists('sc_pix_date')) {
    function sc_pix_date($attr) {
        extract(shortcode_atts(array(
            'type'     => 'year',
        ), $attr));
        switch ($type) {
            case 'month':
                return date_i18n('F Y');
                break;
            case 'full':
                return date_i18n('y-m-d');
                break;
            case 'month-year':
                return date_i18n('F Y');
                break;
        }
        return date_i18n('Y');
    }
}
add_shortcode('pix_date', 'sc_pix_date');

/* ---------------------------------------------------------------------------
* Bold [pix_bold]
* --------------------------------------------------------------------------- */
if (!function_exists('sc_pix_bold')) {
    function sc_pix_bold($attr, $content = null) {
        return '<strong>' . do_shortcode($content) . '</strong>';
    }
}
add_shortcode('pix_bold', 'sc_pix_bold');

/* ---------------------------------------------------------------------------
* Italic [pix_italic]
* --------------------------------------------------------------------------- */
if (!function_exists('sc_pix_italic')) {
    function sc_pix_italic($attr, $content = null) {
        return '<em>' . do_shortcode($content) . '</em>';
    }
}
add_shortcode('pix_italic', 'sc_pix_italic');

/* ---------------------------------------------------------------------------
* Italic [pix_italic]
* --------------------------------------------------------------------------- */
if (!function_exists('sc_pix_underline')) {
    function sc_pix_underline($attr, $content = null) {
        return '<u>' . do_shortcode($content) . '</u>';
    }
}
add_shortcode('pix_underline', 'sc_pix_underline');
