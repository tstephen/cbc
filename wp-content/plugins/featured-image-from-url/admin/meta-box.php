<?php

add_action('add_meta_boxes', 'fifu_insert_meta_box');

function fifu_insert_meta_box() {
    $post_types = fifu_get_post_types();

    foreach ($post_types as $post_type) {
        if ($post_type == 'product') {
            add_meta_box('urlMetaBox', '<span class="dashicons dashicons-camera" style="font-size:20px"></span> Product Image from URL', 'fifu_show_elements', $post_type, 'side', 'low');
            add_meta_box('wooCommerceGalleryMetaBox', '<span class="dashicons dashicons-format-gallery" style="font-size:20px"></span> Image Gallery from URL', 'fifu_wc_show_elements', $post_type, 'side', 'low');
            add_meta_box('videoUrlMetaBox', '<span class="dashicons dashicons-video-alt3" style="font-size:20px"></span> Featured Video from URL', 'fifu_video_show_elements', $post_type, 'side', 'low');
            add_meta_box('wooCommerceVideoGalleryMetaBox', '<span class="dashicons dashicons-format-video" style="font-size:20px"></span> Video Gallery from URL', 'fifu_video_wc_show_elements', $post_type, 'side', 'low');
            add_meta_box('sliderImageUrlMetaBox', '<span class="dashicons dashicons-images-alt2" style="font-size:20px"></span> Featured Slider from URL', 'fifu_slider_show_elements', $post_type, 'side', 'low');
            add_meta_box('shortCodeMetaBox', '<span class="dashicons dashicons-editor-code" style="font-size:20px"></span> Featured Shortcode', 'fifu_shortcode_show_elements', $post_type, 'side', 'low');
        } else if ($post_type) {
            add_meta_box('imageUrlMetaBox', '<span class="dashicons dashicons-camera" style="font-size:20px"></span> Featured Image from URL', 'fifu_show_elements', $post_type, 'side', 'low');
            add_meta_box('videoUrlMetaBox', '<span class="dashicons dashicons-video-alt3" style="font-size:20px"></span> Featured Video from URL', 'fifu_video_show_elements', $post_type, 'side', 'low');
            add_meta_box('sliderImageUrlMetaBox', '<span class="dashicons dashicons-images-alt2" style="font-size:20px"></span> Featured Slider from URL', 'fifu_slider_show_elements', $post_type, 'side', 'low');
            add_meta_box('shortCodeMetaBox', '<span class="dashicons dashicons-editor-code" style="font-size:20px"></span> Featured Shortcode', 'fifu_shortcode_show_elements', $post_type, 'side', 'low');
        }
    }
    fifu_register_meta_box_script();
}

function fifu_register_meta_box_script() {
    wp_enqueue_script('jquery-block-ui', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js');
    wp_enqueue_style('fancy-box-css', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.css');
    wp_enqueue_script('fancy-box-js', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js');

    wp_enqueue_script('fifu-meta-box-js', plugins_url('/html/js/meta-box.js', __FILE__));
    wp_enqueue_script('fifu-convert-url-js', plugins_url('/html/js/convert-url.js', __FILE__));

    if (fifu_is_sirv_active())
        wp_enqueue_script('fifu-sirv-js', 'https://scripts.sirv.com/sirv.js');

    wp_localize_script('fifu-meta-box-js', 'fifuMetaBoxVars', [
        'get_the_ID' => get_the_ID(),
        'is_sirv_active' => fifu_is_sirv_active(),
    ]);
}

add_action('add_meta_boxes', 'fifu_add_css');

function fifu_add_css() {
    wp_register_style('featured-image-from-url', plugins_url('/html/css/editor.css', __FILE__));
    wp_enqueue_style('featured-image-from-url');
}

function fifu_show_elements($post) {
    $margin = 'margin-top:5px;';
    $width = 'width:100%;';
    $height = 'height:200px;';
    $align = 'text-align:left;';

    $url = get_post_meta($post->ID, 'fifu_image_url', true);
    $alt = get_post_meta($post->ID, 'fifu_image_alt', true);

    if ($url) {
        $show_button = 'display:none;';
        $show_alt = $show_image = $show_link = '';
    } else {
        $show_alt = $show_image = $show_link = 'display:none;';
        $show_button = '';
    }

    $show_ignore = fifu_is_on('fifu_get_first') || fifu_is_on('fifu_pop_first') || fifu_is_on('fifu_ovw_first') ? '' : 'display:none;';

    include 'html/meta-box.html';
}

function fifu_shortcode_show_elements($post) {
    $width = 'width:100%;';
    $align = 'text-align:left;';
    include 'html/meta-box-shortcode.html';
}

function fifu_video_show_elements($post) {
    $margin = 'margin-top:10px;';
    $width = 'width:100%;';
    $height = 'height:150px;';
    $align = 'text-align:left;';
    include 'html/meta-box-video.html';
}

function fifu_wc_show_elements($post) {
    $margin = 'margin-top:1px;';
    $width = 'width:100%;';
    $height = 'height:150px;';
    $align = 'text-align:left;';
    for ($i = 0; $i < 3; $i ++)
        include 'html/woo-meta-box.html';
}

function fifu_video_wc_show_elements($post) {
    $margin = 'margin-top:1px;';
    $width = 'width:100%;';
    $height = 'height:150px;';
    $align = 'text-align:left;';
    for ($i = 0; $i < 3; $i ++)
        include 'html/woo-meta-box-video.html';
}

function fifu_slider_show_elements($post) {
    $margin = 'margin-top:1px;';
    $width = 'width:100%;';
    $height = 'height:150px;';
    $align = 'text-align:left;';
    for ($i = 0; $i < 3; $i ++)
        include 'html/meta-box-slider.html';
}

add_filter('wp_insert_post_data', 'fifu_remove_first_image', 10, 2);

function fifu_remove_first_image($data, $postarr) {
    /* invalid or external or ignore */
    if (!$_POST || !isset($_POST['fifu_input_url']) || isset($_POST['fifu_ignore_auto_set']))
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

add_action('save_post', 'fifu_save_properties');

function fifu_save_properties($post_id) {
    if (!$_POST || get_post_type($post_id) == 'nav_menu_item' || get_post_type($post_id) == 'revision')
        return;

    $ignore = false;
    if (isset($_POST['fifu_ignore_auto_set']))
        $ignore = $_POST['fifu_ignore_auto_set'] == 'on';

    /* image url */
    $url = null;
    if (isset($_POST['fifu_input_url'])) {
        $url = esc_url_raw($_POST['fifu_input_url']);
        if (!$ignore) {
            $first = fifu_first_url_in_content($post_id);
            if ($first && fifu_is_on('fifu_get_first') && (!$url || fifu_is_on('fifu_ovw_first')))
                $url = $first;
        }
        fifu_update_or_delete($post_id, 'fifu_image_url', $url);
    }

    /* image url from wcfm */
    if (!$url && fifu_is_wcfm_active() && isset($_POST['wcfm_products_manage_form'])) {
        $url = esc_url_raw(fifu_get_wcfm_url($_POST['wcfm_products_manage_form']));
        if ($url)
            fifu_update_or_delete($post_id, 'fifu_image_url', $url);
    }

    /* image url from toolset forms */
    if (fifu_is_toolset_active() && isset($_POST['wpcf-fifu_image_url'])) {
        $url = esc_url_raw($_POST['wpcf-fifu_image_url']);
        if ($url)
            fifu_update_or_delete($post_id, 'fifu_image_url', $url);
    }

    /* image url from aliplugin */
    if (fifu_is_aliplugin_active() && isset($_POST['imageUrl'])) {
        $url = esc_url_raw($_POST['imageUrl']);
        if ($url)
            fifu_update_or_delete($post_id, 'fifu_image_url', $url);
    }

    /* alt */
    if (isset($_POST['fifu_input_alt'])) {
        $alt = wp_strip_all_tags($_POST['fifu_input_alt']);
        $alt = !$alt && $url && fifu_is_on('fifu_auto_alt') ? get_the_title() : $alt;
        fifu_update_or_delete_value($post_id, 'fifu_image_alt', $alt);
    }

    fifu_save($post_id);
}

function fifu_save($post_id) {
    fifu_update_fake_attach_id($post_id);
}

function fifu_update_or_delete($post_id, $field, $url) {
    if ($url) {
        update_post_meta($post_id, $field, fifu_convert($url));
    } else
        delete_post_meta($post_id, $field, $url);
}

function fifu_update_or_delete_value($post_id, $field, $value) {
    if ($value)
        update_post_meta($post_id, $field, $value);
    else
        delete_post_meta($post_id, $field, $value);
}

function fifu_wai_save($post_id) {
    $url = get_post_meta($post_id, 'fifu_image_url', true);
    fifu_update_or_delete($post_id, 'fifu_image_url', $url);
}

add_action('before_delete_post', 'fifu_db_before_delete_post');

/* regular woocommerce import */

add_action('woocommerce_product_import_inserted_product_object', 'fifu_woocommerce_import');

function fifu_woocommerce_import($object) {
    $post_id = $object->get_id();
    fifu_wai_save($post_id);
    fifu_update_fake_attach_id($post_id);
}

/* plugin: wcfm */

function fifu_is_wcfm_active() {
    return is_plugin_active('wc-frontend-manager/wc_frontend_manager.php');
}

function fifu_get_wcfm_url($content) {
    $url = explode('fifu_image_url=', $content)[1];
    return $url ? urldecode(explode('&', $url)[0]) : null;
}

/* plugin: toolset forms */

function fifu_is_toolset_active() {
    return is_plugin_active('cred-frontend-editor/plugin.php');
}

/* plugin: aliplugin */

function fifu_is_aliplugin_active() {
    return is_plugin_active('aliplugin/aliplugin.php');
}

/* plugin: sirv */

function fifu_is_sirv_active() {
    return is_plugin_active('sirv/sirv.php');
}

/* woocommerce variation elements */

add_action('woocommerce_product_after_variable_attributes', 'fifu_variation_settings_fields', 10, 3);

function fifu_variation_settings_fields($loop, $variation_data, $variation) {
    // variation
    woocommerce_wp_text_input(
            array(
                'id' => "fifu_image_url{$loop}",
                'name' => "fifu_image_url[{$loop}]",
                'value' => get_post_meta($variation->ID, 'fifu_image_url', true),
                'label' => __('<span class="dashicons dashicons-camera" style="font-size:20px"></span> Product Image from URL', 'woocommerce'),
                'desc_tip' => true,
                'description' => __('Powered by Featured Image from URL plugin', 'woocommerce'),
                'placeholder' => 'Image URL (Premium)',
                'wrapper_class' => 'form-row form-row-full',
            )
    );
    // variation gallery
    for ($i = 0; $i < 3; $i ++) {
        woocommerce_wp_text_input(
                array(
                    'id' => "fifu_image_url_" . $i . "{$loop}",
                    'name' => "fifu_image_url_" . $i . "[{$loop}]",
                    'value' => get_post_meta($variation->ID, 'fifu_image_url_' . $i, true),
                    'label' => __('<span class="dashicons dashicons-format-gallery" style="font-size:20px"></span> Image Gallery from URL #' . ($i + 1), 'woocommerce'),
                    'desc_tip' => true,
                    'description' => __('Requires "WooCommerce Additional Variation Images" plugin', 'woocommerce'),
                    'placeholder' => 'Image URL (Premium)',
                    'wrapper_class' => 'form-row form-row-full',
                )
        );
    }
}

/* plugin: wordpress importer */

add_action('import_end', 'fifu_import_end', 10, 0);

function fifu_import_end() {
    if ($_POST['action'] == "woocommerce_csv_import_request" && !isset($_POST['mapping']))
        return;
    fifu_db_delete_thumbnail_id_without_attachment();
    fifu_db_insert_attachment();
    fifu_db_insert_attachment_category();
}

