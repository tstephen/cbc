<?php

function fifu_convert($url) {
    if (fifu_from_google_drive($url))
        return fifu_google_drive_url($url);

    return $url;
}

//Google Drive

function fifu_from_google_drive($url) {
    return strpos($url, 'drive.google.com') !== false;
}

function fifu_google_drive_id($url) {
    preg_match("/[-\w]{25,}/", $url, $matches);
    return $matches[0];
}

function fifu_google_drive_url($url) {
    return 'https://drive.google.com/uc?id=' . fifu_google_drive_id($url);
}

