<?php

define("FIFU_URL", "/localhost/fifu/");

add_filter('get_attached_file', 'fifu_replace_attached_file', 10, 2);

function fifu_replace_attached_file($att_url, $att_id) {
    if (fifu_is_off('fifu_data_generation')) {
        if ($att_url) {
            $url = explode(";", $att_url);
            if (sizeof($url) > 1)
                return strpos($url[1], fifu_get_internal_image_path()) !== false ? get_post($att_id)->guid : $url[1];
        }
    }
    return $att_url;
}

add_filter('wp_get_attachment_url', 'fifu_replace_attachment_url', 10, 2);

function fifu_replace_attachment_url($att_url, $att_id) {
    if (fifu_is_off('fifu_data_generation')) {
        if ($att_url) {
            $url = explode(";", $att_url);
            if (sizeof($url) > 1)
                return strpos($url[1], fifu_get_internal_image_path()) !== false ? get_post($att_id)->guid : $url[1];
            else {
                // external wordpress images
                if (sizeof($url) > 0 && strpos($url[0], fifu_get_internal_image_path()) !== false) {
                    if (get_post($att_id)) {
                        $url = get_post($att_id)->guid;
                        if ($url)
                            return $url;
                    }
                }
            }
        }
    }

    if (fifu_show_internal_instead_of_external(get_the_ID()))
        return $att_url;

    if ($att_id == get_post_thumbnail_id(get_the_ID())) {
        $url = fifu_main_image_url(get_the_ID());
        if ($url)
            $att_url = $url;
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

    if (fifu_is_off('fifu_data_generation')) {
        if (fifu_should_hide())
            return null;
        $image_size = fifu_get_image_size($size);
        if (fifu_is_on('fifu_original')) {
            return array(
                strpos($image[0], fifu_get_internal_image_path()) !== false ? get_post($att_id)->guid : $image[0],
                null,
                null,
                null,
            );
        }
        $dimension = $post ? get_post_meta($post, 'fifu_image_dimension') : null;
        $arrFIFU = fifu_get_width_height($dimension);
        return array(
            strpos($image[0], fifu_get_internal_image_path()) !== false ? get_post($att_id)->guid : $image[0],
            !$dimension && isset($image_size['width']) && $image_size['width'] < $arrFIFU['width'] ? $image_size['width'] : $arrFIFU['width'],
            !$dimension && isset($image_size['height']) && $image_size['height'] < $arrFIFU['height'] ? $image_size['height'] : $arrFIFU['height'],
            isset($image_size['crop']) ? $image_size['crop'] : '',
        );
    }

    if (fifu_show_internal_instead_of_external(get_the_ID()))
        return $image;

    if ($att_id == get_post_thumbnail_id(get_the_ID())) {
        $url = fifu_main_image_url(get_the_ID());
        if ($url) {
            return array(
                $url,
                0,
                0,
                false
            );
        }
    }
    return $image;
}

function fifu_is_internal_image($image) {
    return $image && $image[1] > 1 && $image[2] > 1;
}

function fifu_get_internal_image_path() {
    return $_SERVER['SERVER_NAME'] . "/wp-content/uploads/";
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
    }
    return array('width' => $width, 'height' => $height);
}

// accelerated-mobile-pages plugin

function fifu_amp_url($url, $width, $height) {
    $size = get_post_meta(get_the_ID(), 'fifu_image_dimension');
    if (!empty($size)) {
        $size = explode(';', $size[0]);
        $width = $size[0];
        $height = $size[1];
    }
    return array(0 => $url, 1 => $width, 2 => $height);
}

