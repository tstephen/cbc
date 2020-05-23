<?php

function fifu_enable_fake_api(WP_REST_Request $request) {
    fifu_enable_fake();
}

function fifu_disable_fake_api(WP_REST_Request $request) {
    fifu_disable_fake();
    delete_option('fifu_fake_attach_id');
}

function fifu_none_fake_api(WP_REST_Request $request) {
    update_option('fifu_fake_created', null, 'no');
}

function fifu_data_clean_api(WP_REST_Request $request) {
    fifu_db_enable_clean();
    update_option('fifu_data_clean', 'toggleoff', 'no');
}

function fifu_run_delete_all_api(WP_REST_Request $request) {
    fifu_db_delete_all();
    update_option('fifu_run_delete_all', 'toggleoff', 'no');
}

function fifu_save_dimensions_all_api(WP_REST_Request $request) {
    update_option('fifu_save_dimensions_all', 'toggleoff', 'no');

    if (fifu_is_off('fifu_save_dimensions'))
        return;

    fifu_db_save_dimensions_all();
}

function fifu_clean_dimensions_all_api(WP_REST_Request $request) {
    update_option('fifu_clean_dimensions_all', 'toggleoff', 'no');

    if (fifu_is_off('fifu_clean_dimensions'))
        return;

    fifu_db_clean_dimensions_all();
}

function fifu_disable_default_api(WP_REST_Request $request) {
    fifu_db_delete_default_url();
}

function fifu_none_default_api(WP_REST_Request $request) {
    
}

function fifu_rest_url(WP_REST_Request $request) {
    return get_rest_url();
}

function fifu_test_execution_time() {
    for ($i = 0; $i <= 120; $i++) {
        error_log($i);
        sleep(1);
    }
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
    register_rest_route('featured-image-from-url/v2', '/none_fake_api/', array(
        'methods' => 'POST',
        'callback' => 'fifu_none_fake_api',
        'permission_callback' => 'fifu_get_private_data_permissions_check',
    ));
    register_rest_route('featured-image-from-url/v2', '/data_clean_api/', array(
        'methods' => 'POST',
        'callback' => 'fifu_data_clean_api',
        'permission_callback' => 'fifu_get_private_data_permissions_check',
    ));
    register_rest_route('fifu-premium/v2', '/run_delete_all_api/', array(
        'methods' => 'POST',
        'callback' => 'fifu_run_delete_all_api',
        'permission_callback' => 'fifu_get_private_data_permissions_check',
    ));
    register_rest_route('featured-image-from-url/v2', '/save_dimensions_all_api/', array(
        'methods' => 'POST',
        'callback' => 'fifu_save_dimensions_all_api',
        'permission_callback' => 'fifu_get_private_data_permissions_check',
    ));
    register_rest_route('featured-image-from-url/v2', '/clean_dimensions_all_api/', array(
        'methods' => 'POST',
        'callback' => 'fifu_clean_dimensions_all_api',
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
    register_rest_route('featured-image-from-url/v2', '/rest_url_api/', array(
        'methods' => ['GET', 'POST'],
        'callback' => 'fifu_rest_url'
    ));
});

function fifu_get_private_data_permissions_check() {
    if (!current_user_can('edit_posts')) {
        return new WP_Error('rest_forbidden', esc_html__('You can not access private data.', 'featured-image-from-url'), array('status' => 401));
    }
    return true;
}

