<?php

function fifu_debug_jetpack() {
    return defined('FIFU_DEV_DEBUG') && !defined('IS_WPCOM') && FIFU_DEV_DEBUG && fifu_is_local() && !fifu_is_in_editor();
}

function fifu_jetpack_blocked($url) {
    $blocklist = array('amazon-adsystem.com', 'sapo.io');
    foreach ($blocklist as $domain) {
        if (strpos($url, $domain) !== false)
            return true;
    }
    return false;
}

