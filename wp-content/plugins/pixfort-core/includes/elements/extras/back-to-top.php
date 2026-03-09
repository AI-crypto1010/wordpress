<?php
$back_pos = '';
if (pix_plugin_get_option('back-to-top')) {
    $back_pos = pix_plugin_get_option('back-to-top');
}
if ($back_pos !== 'disable') {
?>
<a href="#" class="shadow shadow-hover rounded-circle bg-dynamic-gray-100 d-flex align-items-center justify-content-center back_to_top <?php echo esc_attr($back_pos); ?>" title="<?php esc_attr_e('Go to top', 'pixfort-theme'); ?>">
    <?php
        echo \PixfortCore::instance()->icons->getIcon('Line/pixfort-icon-arrow-top-2');
    ?>
</a>
<?php
}
