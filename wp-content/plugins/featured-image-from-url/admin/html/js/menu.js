jQuery(document).ready(function () {
    jQuery('link[href*="jquery-ui.css"]').attr("disabled", "true");
    jQuery('div.wrap div.header-box div.notice').hide();
    jQuery('div.wrap div.header-box div#message').hide();
    jQuery('div.wrap div.header-box div.updated').remove();
    window.scrollTo(0, 0);
    jQuery('.wrap').css('opacity', 1);
});

var restUrl = fifu_get_rest_url();

function invert(id) {
    if (jQuery("#fifu_toggle_" + id).attr("class") == "toggleon") {
        jQuery("#fifu_toggle_" + id).attr("class", "toggleoff");
        jQuery("#fifu_input_" + id).val('off');
    } else {
        jQuery("#fifu_toggle_" + id).attr("class", "toggleon");
        jQuery("#fifu_input_" + id).val('on');
    }
}

jQuery(function () {
    var url = window.location.href;

    //forms with id started by...
    jQuery("form[id^=fifu_form]").each(function (i, el) {
        //onsubmit
        jQuery(this).submit(function () {
            save(this);
        });
    });

    jQuery("#tabs-flickr").tabs();
    jQuery("#tabs").tabs();
    jQuery("#tabs-top").tabs();
    jQuery("#fifu_input_spinner_cron_metadata").spinner({min: 1, step: 1});
    jQuery("#fifu_input_spinner_db").spinner({min: 100, step: 100});
    jQuery("#fifu_input_spinner_nth").spinner({min: 1});
    jQuery("#fifu_input_spinner_image").spinner({min: 0});
    jQuery("#fifu_input_spinner_video").spinner({min: 0});
    jQuery("#fifu_input_spinner_slider").spinner({min: 0});
    jQuery("#fifu_input_slider_speed").spinner({min: 0});
    jQuery("#fifu_input_slider_pause").spinner({min: 0});
    jQuery("#tabsApi").tabs();
    jQuery("#tabsCrop").tabs();
    jQuery("#tabsPremium").tabs();
    jQuery("#tabsWooImport").tabs();
    jQuery("#tabsWpAllImport").tabs();
});

function save(formName, url) {
    var frm = jQuery(formName);
    jQuery.ajax({
        type: frm.attr('method'),
        url: url,
        data: frm.serialize(),
        success: function (data) {
            //alert('saved');
        }
    });
}

function fifu_default_js() {
    jQuery('#tabs-top').block({message: 'Please wait some seconds...', css: {backgroundColor: 'none', border: 'none', color: 'white'}});

    toggle = jQuery("#fifu_toggle_enable_default_url").attr('class');
    switch (toggle) {
        case "toggleoff":
            option = "disable_default_api";
            break;
        default:
            url = jQuery("#fifu_input_default_url").val();
            option = url ? "none_default_api" : "disable_default_api";
    }
    jQuery.ajax({
        method: "POST",
        url: restUrl + 'featured-image-from-url/v2/' + option + '/',
        async: true,
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-WP-Nonce', fifuScriptVars.nonce);
        },
        success: function (data) {
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
        },
        complete: function () {
            setTimeout(function () {
                jQuery('#tabs-top').unblock();
            }, 1000);
        },
        timeout: 0
    });
}

function fifu_fake_js() {
    jQuery('#tabs-top').block({message: 'Please wait some seconds...', css: {backgroundColor: 'none', border: 'none', color: 'white'}});

    toggle = jQuery("#fifu_toggle_fake").attr('class');
    switch (toggle) {
        case "toggleon":
            option = "enable_fake_api";
            break;
        case "toggleoff":
            option = "disable_fake_api";
            break;
        default:
            option = "none_fake_api";
    }
    jQuery.ajax({
        method: "POST",
        url: restUrl + 'featured-image-from-url/v2/' + option + '/',
        async: true,
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-WP-Nonce', fifuScriptVars.nonce);
        },
        success: function (data) {
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
        },
        complete: function () {
            setTimeout(function () {
                jQuery('#tabs-top').unblock();
            }, 1000);
        },
        timeout: 0
    });
}

function fifu_clean_js() {
    if (jQuery("#fifu_toggle_data_clean").attr('class') != 'toggleon')
        return;

    fifu_run_clean_js();
}

function fifu_run_clean_js() {
    jQuery('#tabs-top').block({message: 'Please wait some seconds...', css: {backgroundColor: 'none', border: 'none', color: 'white'}});

    jQuery.ajax({
        method: "POST",
        url: restUrl + 'featured-image-from-url/v2/data_clean_api/',
        async: true,
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-WP-Nonce', fifuScriptVars.nonce);
        },
        success: function (data) {
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
        },
        complete: function () {
            setTimeout(function () {
                jQuery("#fifu_toggle_data_clean").attr('class', 'toggleoff');
                jQuery("#fifu_toggle_fake").attr('class', 'toggleoff');
                jQuery('#tabs-top').unblock();
            }, 1000);
        }
    });
}

function fifu_run_delete_all_js() {
    if (jQuery("#fifu_toggle_run_delete_all").attr('class') != 'toggleon' || jQuery("#fifu_toggle_confirm_delete_all").attr('class') != 'toggleon')
        return;

    fifu_run_clean_js();
    fifu_run_clean_dimensions_all_js();

    jQuery('#tabs-top').block({message: 'Please wait some seconds...', css: {backgroundColor: 'none', border: 'none', color: 'white'}});

    jQuery.ajax({
        method: "POST",
        url: restUrl + 'fifu-premium/v2/run_delete_all_api/',
        async: true,
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-WP-Nonce', fifuScriptVars.nonce);
        },
        success: function (data) {
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
        },
        complete: function () {
            setTimeout(function () {
                jQuery("#fifu_toggle_run_delete_all").attr('class', 'toggleoff');
                jQuery('#tabs-top').unblock();
            }, 1000);
        }
    });
}

function fifu_save_dimensions_all_js() {
    if (jQuery("#fifu_toggle_save_dimensions_all").attr('class') != 'toggleon')
        return;

    jQuery('#tabs-top').block({message: 'Please wait. It can take several minutes...', css: {backgroundColor: 'none', border: 'none', color: 'white'}});

    interval = setInterval(function () {
        jQuery("#countdown").load(location.href + " #countdown");
    }, 3000);

    jQuery.ajax({
        method: "POST",
        url: restUrl + 'featured-image-from-url/v2/save_dimensions_all_api/',
        async: true,
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-WP-Nonce', fifuScriptVars.nonce);
        },
        success: function (data) {
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
        },
        complete: function () {
            setTimeout(function () {
                jQuery("#fifu_toggle_save_dimensions_all").attr('class', 'toggleoff');
                jQuery('#tabs-top').unblock();
            }, 1000);
            jQuery("#countdown").load(location.href + " #countdown");
            clearInterval(interval);
        }
    });
}

function fifu_clean_dimensions_all_js() {
    if (jQuery("#fifu_toggle_clean_dimensions_all").attr('class') != 'toggleon')
        return;

    fifu_run_clean_dimensions_all_js();
}

function fifu_run_clean_dimensions_all_js() {
    jQuery('#tabs-top').block({message: 'Please wait some seconds...', css: {backgroundColor: 'none', border: 'none', color: 'white'}});

    jQuery.ajax({
        method: "POST",
        url: restUrl + 'featured-image-from-url/v2/clean_dimensions_all_api/',
        async: true,
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-WP-Nonce', fifuScriptVars.nonce);
        },
        success: function (data) {
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
        },
        complete: function () {
            setTimeout(function () {
                jQuery("#fifu_toggle_clean_dimensions_all").attr('class', 'toggleoff');
                jQuery('#tabs-top').unblock();
            }, 1000);
            jQuery("#countdown").load(location.href + " #countdown");
        }
    });
}
