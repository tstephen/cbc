<?php

function fifu_get_attribute($attribute, $html) {
    $attribute = $attribute . '=';
    if (strpos($html, $attribute) === false)
        return null;

    $aux = explode($attribute, $html);
    if ($aux)
        $aux = $aux[1];

    $quote = $aux[0];

    if ($quote == '&') {
        preg_match('/^&[^;]+;/', $aux, $matches);
        if ($matches)
            $quote = $matches[0];
    }

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

function fifu_get_tags($post_id) {
    $tags = get_the_tags($post_id);
    if (!$tags)
        return null;

    $names = null;
    foreach ($tags as $tag)
        $names .= $tag->name . ' ';
    return $names ? rtrim($names) : null;
}

function fifu_check_instagram_thumb($url, $att_id, $post_id) {
    if (!fifu_is_old_instagram_url($url))
        return $url;

    if (!fifu_is_in_editor()) {
        $db_url = get_post_meta($post_id, 'fifu_image_url', true);
        if ($db_url == $url) {
            $new_url = fifu_api_get_instagram_thumb($url);
            if ($new_url) {
                update_post_meta($post_id, 'fifu_image_url', $new_url);
                update_post_meta($att_id, '_wp_attached_file', $new_url);
                global $wpdb;
                $wpdb->update($wpdb->posts, ['guid' => $new_url], ['ID' => $att_id]);
                return $new_url;
            }
        } else
            return $db_url;
    }
    return $url;
}

function fifu_get_home_url() {
    return explode('//', get_home_url())[1];
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
    fifu_update_or_delete($post_id, 'fifu_image_url', esc_url_raw(rtrim($image_url)));
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

function fifu_is_jetpack_active() {
    if (!is_plugin_active('jetpack/jetpack.php'))
        return false;

    if (defined('FIFU_DEV_DEBUG') && FIFU_DEV_DEBUG)
        return true;

    return function_exists('jetpack_photon_url') && class_exists('Jetpack') && method_exists('Jetpack', 'get_active_modules') && in_array('photon', Jetpack::get_active_modules());
}

// active themes

function fifu_is_flatsome_active() {
    return 'flatsome' == get_option('template');
}

function fifu_is_avada_active() {
    return 'avada' == strtolower(get_option('template'));
}

// plugin: accelerated-mobile-pages

function fifu_amp_url($url, $width, $height) {
    return array(0 => $url, 1 => $width, 2 => $height);
}

