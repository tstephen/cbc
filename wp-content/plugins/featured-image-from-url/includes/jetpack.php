<?php

function fifu_debug_jetpack() {
    return defined('FIFU_DEV_DEBUG') && !defined('IS_WPCOM') && FIFU_DEV_DEBUG && fifu_is_local() && !fifu_is_in_editor();
}

