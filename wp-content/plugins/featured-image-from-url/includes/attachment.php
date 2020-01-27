<?php

add_filter('get_attached_file', 'fifu_replace_attached_file', 10, 2);

function fifu_replace_attached_file($att_url, $att_id) {
    if ($att_url) {
        $url = explode(";", $att_url);
        if (sizeof($url) > 1)
            return fifu_has_internal_image_path($url[1]) ? get_post($att_id)->guid : $url[1];
    }
    return $att_url;
}

add_filter('wp_get_attachment_url', 'fifu_replace_attachment_url', 10, 2);

function fifu_replace_attachment_url($att_url, $att_id) {
    if ($att_url) {
        $url = explode(";", $att_url);
        if (sizeof($url) > 1)
            return fifu_has_internal_image_path($url[1]) ? get_post($att_id)->guid : $url[1];
        else {
            if (get_post($att_id)) {
                $url = get_post($att_id)->guid;
                if ($url && strpos($url, 'http') === 0 && !fifu_is_mpd_active())
                    return $url;
            }
        }
    }
    return $att_url;
}

add_filter('posts_where', 'fifu_query_attachments');

function fifu_query_attachments($where) {
    if (isset($_POST['action']) && ($_POST['action'] == 'query-attachments') && fifu_is_off('fifu_media_library')) {
        global $wpdb;
        $where .= ' AND ' . $wpdb->prefix . 'posts.post_author <> 77777 ';
    }
    return $where;
}

add_filter('posts_where', function ( $where, \WP_Query $q ) {
    if (is_admin() && $q->is_main_query() && fifu_is_off('fifu_media_library')) {
        global $wpdb;
        $where .= ' AND ' . $wpdb->prefix . 'posts.post_author <> 77777 ';
    }
    return $where;
}, 10, 2);

add_filter('wp_get_attachment_image_src', 'fifu_replace_attachment_image_src', 10, 3);

function fifu_replace_attachment_image_src($image, $att_id, $size) {
    if (fifu_is_internal_image($image))
        return $image;

    if (!$att_id)
        return $image;

    $post = get_post($att_id);

    if (fifu_should_hide())
        return null;
    $image_size = fifu_get_image_size($size);
    if (fifu_is_on('fifu_original')) {
        return array(
            fifu_has_internal_image_path($image[0]) ? get_post($att_id)->guid : $image[0],
            null,
            null,
            null,
        );
    }
    $dimension = $post ? get_post_meta($post, 'fifu_image_dimension') : null;
    $arrFIFU = fifu_get_width_height($dimension);
    return array(
        fifu_has_internal_image_path($image[0]) ? get_post($att_id)->guid : $image[0],
        !$dimension && isset($image_size['width']) && $image_size['width'] < $arrFIFU['width'] ? $image_size['width'] : $arrFIFU['width'],
        !$dimension && isset($image_size['height']) && $image_size['height'] < $arrFIFU['height'] ? $image_size['height'] : $arrFIFU['height'],
        isset($image_size['crop']) ? $image_size['crop'] : '',
    );
}

function fifu_is_internal_image($image) {
    return $image && $image[1] > 1 && $image[2] > 1;
}

function fifu_get_internal_image_path() {
    return explode("//", get_home_url())[1] . "/wp-content/uploads/";
}

function fifu_get_internal_image_path2() {
    return get_bloginfo() . ".files.wordpress.com";
}

function fifu_get_internal_image_path3() {
    return explode('.', explode("//", get_home_url())[1])[0] . ".files.wordpress.com";
}

function fifu_has_internal_image_path($url) {
    return strpos($url, fifu_get_internal_image_path()) !== false || strpos($url, fifu_get_internal_image_path2()) !== false || strpos($url, fifu_get_internal_image_path3()) !== false;
}

add_filter('wp_get_attachment_metadata', 'fifu_filter_wp_get_attachment_metadata', 10, 2);

function fifu_filter_wp_get_attachment_metadata($data, $post_id) {
    if (!$data || !is_array($data)) {
        $dimension = get_post_meta($post_id, 'fifu_image_dimension');
        return fifu_get_width_height($dimension);
    }
    return $data;
}

function fifu_get_width_height($dimension) {
    if ($dimension && fifu_is_on('fifu_save_dimensions')) {
        $dimension = $dimension[0];
        $width = explode(';', $dimension)[0];
        $height = explode(';', $dimension)[1];
    } else {
        $dimension = null;
        $width = fifu_maximum('width');
        $height = fifu_maximum('height');

        // a value is required, otherwise the zoom doesn't work
        if (!$width)
            $width = 1000;
    }
    return array('width' => $width, 'height' => $height);
}

// plugin: accelerated-mobile-pages

function fifu_amp_url($url, $width, $height) {
    $size = get_post_meta(get_the_ID(), 'fifu_image_dimension');
    if (!empty($size)) {
        $size = explode(';', $size[0]);
        $width = $size[0];
        $height = $size[1];
    }
    return array(0 => $url, 1 => $width, 2 => $height);
}

// plugin: multisite-post-duplicator

function fifu_is_mpd_active() {
    return is_plugin_active('multisite-post-duplicator/mpd.php');
}

