<?php

function fifu_get_attribute($attribute, $html) {
    $attribute = $attribute . '=';
    if (strpos($html, $attribute) === false)
        return null;

    $aux = explode($attribute, $html);
    if ($aux)
        $aux = $aux[1];

    $quote = $aux[0];
    $aux = explode($quote, $aux);
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

function fifu_get_delimiter($property, $html) {
    $delimiter = explode($property . '=', $html);
    return $delimiter ? substr($delimiter[1], 0, 1) : null;
}

function fifu_is_ajax_call() {
    return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') || wp_doing_ajax();
}

function fifu_normalize($tag) {
    $tag = str_replace('amp;', '', $tag);
    $tag = str_replace('#038;', '', $tag);
    return $tag;
}

function fifu_starts_with($text, $substr) {
    return substr($text, 0, strlen($substr)) === $substr;
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

function fifu_dashboard() {
    return !is_home() &&
            !is_singular('post') &&
            !is_author() &&
            !is_search() &&
            !is_singular('page') &&
            !is_singular('product') &&
            !is_archive() &&
            (!class_exists('WooCommerce') || (class_exists('WooCommerce') && (!is_shop() && !is_product_category() && !is_cart())));
}

// developers

function fifu_dev_set_image($post_id, $image_url) {
    fifu_update_or_delete($post_id, 'fifu_image_url', esc_url_raw($image_url));
    fifu_update_fake_attach_id($post_id);
}

// active plugins

function fifu_is_elementor_active() {
    return is_plugin_active('elementor/elementor.php') || is_plugin_active('elementor-pro/elementor-pro.php');
}

function fifu_is_elementor_editor() {
    if (!fifu_is_elementor_active())
        return false;
    return \Elementor\Plugin::$instance->editor->is_edit_mode() || \Elementor\Plugin::$instance->preview->is_preview_mode();
}

// active themes

function fifu_is_avada_active() {
    return 'avada' == strtolower(get_option('template'));
}

