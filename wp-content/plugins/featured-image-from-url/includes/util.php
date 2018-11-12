<?php

function fifu_get_img_width_from_html($html) {
    $aux = explode('img width=', $html)[1];
    return explode('"', $aux)[1];
}

function fifu_get_src_from_html($html) {
    $aux = explode('src=', $html)[1];
    return explode('"', $aux)[1];
}

function fifu_get_data_large_from_html($html) {
    $aux = explode('data-large_image=', $html);
    $aux = $aux && count($aux) > 1 ? $aux[1] : null;
    $url = $aux ? explode('"', $aux)[1] : null;
    return $url;
}

function fifu_is_on($option) {
    return get_option($option) == 'toggleon';
}

function fifu_is_off($option) {
    return get_option($option) == 'toggleoff';
}

