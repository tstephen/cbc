<?php

add_filter('wp_insert_post_data', 'fifu_remove_first_image_ext', 10, 2);

function fifu_remove_first_image_ext($data, $postarr) {
    /* invalid or internal or ignore */
    if (!$_POST || isset($_POST['fifu_input_url']) || isset($_POST['fifu_ignore_auto_set']))
        return $data;

    $content = $postarr['post_content'];
    if (!$content)
        return $data;

    $contentClean = fifu_show_all_images($content);
    $data = str_replace($content, $contentClean, $data);

    $img = fifu_first_img_in_content($contentClean);
    if (!$img)
        return $data;

    if (fifu_is_off('fifu_pop_first'))
        return str_replace($img, fifu_show_media($img), $data);

    return str_replace($img, fifu_hide_media($img), $data);
}

add_action('save_post', 'fifu_save_properties_ext');

function fifu_save_properties_ext($post_id) {
    if (isset($_POST['fifu_input_url']))
        return;

    $url = fifu_first_url_in_content($post_id);

    if ($url && fifu_is_on('fifu_get_first')) {
        update_post_meta($post_id, 'fifu_image_url', fifu_convert($url));
        fifu_update_fake_attach_id($post_id);
    }
}

function fifu_first_img_in_content($content) {
    $matches = array();
    preg_match_all('/<img[^>]*>/', $content, $matches);
    return $matches && $matches[0] ? $matches[0][0] : null;
}

function fifu_show_all_images($content) {
    $matches = array();
    preg_match_all('/<img[^>]*display:[ ]*none[^>]*>/', $content, $matches);
    foreach ($matches[0] as $img) {
        $content = str_replace($img, fifu_show_media($img), $content);
    }
    return $content;
}

function fifu_hide_media($img) {
    if (strpos($img, 'style="') !== false)
        return preg_replace('/style=.[^"]*["]/', 'style="display:none"', $img);
    return preg_replace('/[\/]*>/', ' style="display:none">', $img);
}

function fifu_show_media($img) {
    return preg_replace('/style=[\\\]*.display:[ ]*none[\\\]*./', '', $img);
}

function fifu_first_url_in_content($post_id) {
    $content = get_post_field('post_content', $post_id);
    if (!$content)
        return;
    $matches = array();
    preg_match_all('/<img[^>]*>/', $content, $matches);
    if (!$matches[0])
        return;

    $tag = null;
    foreach ($matches[0] as $tag) {
        if ($tag && strpos($tag, 'data:image/jpeg') !== false)
            continue;
        break;
    }

    if (!$tag)
        return;

    $aux2 = null;

    //double quotes
    $aux1 = explode('src="', $tag);
    if ($aux1 && count($aux1) > 1) {
        $aux2 = explode('"', $aux1[1]);
    }

    //single quotes
    if (!$aux2 || !$aux2[0]) {
        $aux1 = explode("src='", $tag);
        if ($aux1 && count($aux1) > 1)
            $aux2 = explode("'", $aux1[1]);
    }

    //query strings
    if (fifu_is_on('fifu_query_strings'))
        return $tag ? preg_replace('/\?.*/', '', $aux2[0]) : null;

    return $tag ? $aux2[0] : null;
}

function fifu_update_fake_attach_id($post_id) {
    fifu_db_update_fake_attach_id($post_id);
}

