<?php

function fifu_woo_zoom() {
    return fifu_is_on('fifu_wc_zoom') ? 'inline' : 'none';
}

function fifu_woo_lbox() {
    return fifu_is_on('fifu_wc_lbox');
}

function fifu_woo_theme() {
    return file_exists(get_template_directory() . '/woocommerce');
}

function fifu_woocommerce_gallery_image_html_attachment_image_params($params, $attachment_id, $image_size, $main_image) {
    return $params;
}

add_filter('woocommerce_gallery_image_html_attachment_image_params', 'fifu_woocommerce_gallery_image_html_attachment_image_params', 10, 4);
