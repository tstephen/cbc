<?php

function fifu_get_attribute($attribute, $html) {
    $attribute = $attribute . '=';
    if (strpos($html, $attribute) === false)
        return null;

    $aux = explode($attribute, $html);
    if ($aux)
        $aux = $aux[1];

    $aux = explode('"', $aux);
    if ($aux)
        return $aux[1];

    return null;
}

function fifu_is_on($option) {
    return get_option($option) == 'toggleon';
}

function fifu_is_off($option) {
    return get_option($option) == 'toggleoff';
}

function fifu_get_post_types() {
    $arr = array();
    foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'thumbnail'))
            array_push($arr, $post_type);
    }
    return $arr;
}

function fifu_maximum($dimension) {
    $dimension = 'fifu_image_' . $dimension . '_';
    $size = null;

    if (is_home()) {
        $size = get_option($dimension . 'home');
    } else if (class_exists('WooCommerce') && is_shop()) {
        $size = get_option($dimension . 'shop');
    } else if (class_exists('WooCommerce') && is_product_category()) {
        $size = get_option($dimension . 'ctgr');
    } else if (is_singular('post') || is_author() || is_search()) {
        $size = get_option($dimension . 'post');
    } else if (is_singular('page')) {
        $size = class_exists('WooCommerce') && is_cart() ? get_option($dimension . 'cart') : get_option($dimension . 'page');
    } else if (is_singular('product')) {
        $size = get_option($dimension . 'prod');
    } else if (is_archive()) {
        $size = get_option($dimension . 'arch');
    }

    return $size ? $size : null;
}

/* dimensions */

function fifu_curl($url) {
    $curl = curl_init($url);
    if (fifu_is_off('fifu_save_dimensions_redirect')) {
        $headers = array("Range: bytes=0-32768");
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($curl);
    curl_close($curl);
    return $data;
}

function fifu_get_dimension_backend($url) {
    $raw = fifu_curl($url);
    $img = imagecreatefromstring($raw);
    $width = imagesx($img);
    $height = imagesy($img);
    return ($width && $height) ? $width . ";" . $height : null;
}

