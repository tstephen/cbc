<?php

define('FIFU_QUERY_ADDRESS', 'https://query.featuredimagefromurl.com');
define('FIFU_INSTAGRAM_ADDRESS', 'https://urls.featuredimagefromurl.com/instagram/');

function fifu_get_ip() {
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                $ip = trim($ip);
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false)
                    return $ip;
            }
        }
    }
    return $_SERVER['REMOTE_ADDR'];
}

function fifu_is_local() {
    $query = 'http://localhost';
    return substr(get_home_url(), 0, strlen($query)) === $query;
}

function fifu_remote_post($endpoint, $array) {
    return fifu_is_local() ? wp_remote_post($endpoint, $array) : wp_safe_remote_post($endpoint, $array);
}

function fifu_api_query($dataset) {
    $requests = array();

    $version = fifu_version_number();
    $site = fifu_get_home_url();

    foreach ($dataset as $data) {
        $post_id = $data[0];

        if (get_post_meta($post_id, 'fifu_dataset', true) == 2)
            continue;

        $old_url = $data[1];
        $new_url = $data[2];
        $title = $data[3];
        $permalink = $data[4];

        $time = time();
        $encoded_permalink = base64_encode($permalink);
        $permalink_sign = substr($encoded_permalink, -15);
        $signature = hash_hmac('sha256', $permalink_sign . $time, $new_url);

        array_push($requests,
                array(
                    'old_url' => base64_encode($old_url),
                    'new_url' => base64_encode($new_url),
                    'title' => base64_encode($title),
                    'permalink' => $encoded_permalink,
                    'time' => $time,
                    'signature' => $signature,
                    'version' => $version,
                    'site' => $site,
                    'premium' => false,
                )
        );
    }

    $array = array(
        'headers' => array('Content-Type' => 'application/json; charset=utf-8'),
        'body' => json_encode($requests),
        'method' => 'POST',
        'data_format' => 'body',
        'blocking' => true,
        'timeout' => 10,
    );
    $response = fifu_remote_post(FIFU_QUERY_ADDRESS, $array);
    if (is_wp_error($response))
        return null;

    $json = json_decode($response['http_response']->get_response_object()->body);
    if (isset($json->code) && in_array($json->code, array(200, 403))) {
        foreach ($dataset as $data) {
            $post_id = $data[0];
            update_post_meta($post_id, 'fifu_dataset', 2);
        }
    }
}

function fifu_api_get_instagram_thumb($url) {
    $site = fifu_get_home_url();
    $ip = fifu_get_ip();
    $time = time();
    $encoded_url = base64_encode($url);
    $url_sign = substr($encoded_url, -25);
    $signature = hash_hmac('sha256', $url_sign . $time, $site);
    $array = array(
        'headers' => array('Content-Type' => 'application/json; charset=utf-8'),
        'body' => json_encode(
                array(
                    'site' => $site,
                    'signature' => $signature,
                    'time' => $time,
                    'ip' => $ip,
                    'url' => $encoded_url,
                    'version' => fifu_version_number(),
                )
        ),
        'method' => 'POST',
        'data_format' => 'body',
        'blocking' => true,
        'timeout' => 10,
    );
    $response = fifu_remote_post(FIFU_INSTAGRAM_ADDRESS, $array);
    if (is_wp_error($response))
        return null;

    $json = json_decode($response['http_response']->get_response_object()->body);
    if ($json && isset($json->url) && $json->url)
        return $json->url;

    return null;
}

function fifu_enable_fake_api(WP_REST_Request $request) {
    update_option('fifu_fake_stop', false, 'no');
    fifu_enable_fake();
    update_option('fifu_image_metadata_counter', fifu_db_count_urls_without_metadata(), 'no');
    return json_encode(array());
}

function fifu_disable_fake_api(WP_REST_Request $request) {
    update_option('fifu_fake_created', false, 'no');
    update_option('fifu_fake_stop', true, 'no');
    update_option('fifu_image_metadata_counter', fifu_db_count_urls_without_metadata(), 'no');
    return json_encode(array());
}

function fifu_data_clean_api(WP_REST_Request $request) {
    fifu_db_enable_clean();
    update_option('fifu_data_clean', 'toggleoff', 'no');
    update_option('fifu_image_metadata_counter', fifu_db_count_urls_without_metadata(), 'no');
    return json_encode(array());
}

function fifu_run_delete_all_api(WP_REST_Request $request) {
    fifu_db_delete_all();
    update_option('fifu_run_delete_all', 'toggleoff', 'no');
    return json_encode(array());
}

function fifu_disable_default_api(WP_REST_Request $request) {
    fifu_db_delete_default_url();
    return json_encode(array());
}

function fifu_none_default_api(WP_REST_Request $request) {
    return json_encode(array());
}

function fifu_rest_url(WP_REST_Request $request) {
    return get_rest_url();
}

function fifu_save_sizes_api(WP_REST_Request $request) {
    $json = json_encode(array());

    $att_id = $request['att_id'];
    if (filter_var($att_id, FILTER_VALIDATE_INT) === false)
        return $json;

    $width = $request['width'];
    if (filter_var($width, FILTER_VALIDATE_INT) === false)
        return $json;

    $height = $request['height'];
    if (filter_var($height, FILTER_VALIDATE_INT) === false)
        return $json;

    $url = $request['url'];
    if (filter_var($url, FILTER_SANITIZE_URL) === false)
        return $json;

    $att_id = filter_var($att_id, FILTER_SANITIZE_SPECIAL_CHARS);

    if (!$att_id || !$width || !$height || !$url)
        return $json;

    $guid = get_the_guid($att_id);

    if ($url != $guid)
        return $json;

    if (get_post_field('post_author', $att_id) != FIFU_AUTHOR)
        return;

    // save
    $metadata = get_post_meta($att_id, '_wp_attachment_metadata', true);
    if (!$metadata || !$metadata['width'] || !$metadata['height']) {
        $metadata = null;
        $metadata['width'] = filter_var($width, FILTER_SANITIZE_SPECIAL_CHARS);
        $metadata['height'] = filter_var($height, FILTER_SANITIZE_SPECIAL_CHARS);
        wp_update_attachment_metadata($att_id, $metadata);
    }

    return $json;
}

function fifu_api_list_all_without_dimensions(WP_REST_Request $request) {
    return fifu_db_get_all_without_dimensions();
}

function fifu_api_convert_instagram_url(WP_REST_Request $request) {
    $url = $request['url'];
    $new_url = fifu_api_get_instagram_thumb($url);
    return $new_url ? $new_url : $url;
}

function fifu_test_execution_time() {
    for ($i = 0; $i <= 120; $i++) {
        error_log($i);
        sleep(1);
    }
    return json_encode(array());
}

add_action('rest_api_init', function () {
    register_rest_route('featured-image-from-url/v2', '/enable_fake_api/', array(
        'methods' => 'POST',
        'callback' => 'fifu_enable_fake_api',
        'permission_callback' => 'fifu_get_private_data_permissions_check',
    ));
    register_rest_route('featured-image-from-url/v2', '/disable_fake_api/', array(
        'methods' => 'POST',
        'callback' => 'fifu_disable_fake_api',
        'permission_callback' => 'fifu_get_private_data_permissions_check',
    ));
    register_rest_route('featured-image-from-url/v2', '/data_clean_api/', array(
        'methods' => 'POST',
        'callback' => 'fifu_data_clean_api',
        'permission_callback' => 'fifu_get_private_data_permissions_check',
    ));
    register_rest_route('featured-image-from-url/v2', '/run_delete_all_api/', array(
        'methods' => 'POST',
        'callback' => 'fifu_run_delete_all_api',
        'permission_callback' => 'fifu_get_private_data_permissions_check',
    ));
    register_rest_route('featured-image-from-url/v2', '/disable_default_api/', array(
        'methods' => 'POST',
        'callback' => 'fifu_disable_default_api',
        'permission_callback' => 'fifu_get_private_data_permissions_check',
    ));
    register_rest_route('featured-image-from-url/v2', '/none_default_api/', array(
        'methods' => 'POST',
        'callback' => 'fifu_none_default_api',
        'permission_callback' => 'fifu_get_private_data_permissions_check',
    ));
    register_rest_route('featured-image-from-url/v2', '/save_sizes_api/', array(
        'methods' => 'POST',
        'callback' => 'fifu_save_sizes_api',
        'permission_callback' => 'fifu_get_private_data_permissions_check',
    ));
    register_rest_route('featured-image-from-url/v2', '/list_all_without_dimensions/', array(
        'methods' => 'POST',
        'callback' => 'fifu_api_list_all_without_dimensions',
        'permission_callback' => 'fifu_get_private_data_permissions_check',
    ));
    register_rest_route('featured-image-from-url/v2', '/convert_instagram_url/', array(
        'methods' => 'POST',
        'callback' => 'fifu_api_convert_instagram_url',
        'permission_callback' => 'fifu_get_private_data_permissions_check',
    ));
    register_rest_route('featured-image-from-url/v2', '/rest_url_api/', array(
        'methods' => ['GET', 'POST'],
        'callback' => 'fifu_rest_url',
        'permission_callback' => 'fifu_public_permission',
    ));
});

function fifu_get_private_data_permissions_check() {
    if (!current_user_can('edit_posts')) {
        return new WP_Error('rest_forbidden', __('Private'), array('status' => 401));
    }
    return true;
}

function fifu_public_permission() {
    return true;
}

