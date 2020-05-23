function removeImage() {
    jQuery("#fifu_input_alt").hide();
    jQuery("#fifu_image").hide();
    jQuery("#fifu_link").hide();
    jQuery("#fifu_next").hide();

    jQuery("#fifu_input_alt").val("");
    jQuery("#fifu_input_url").val("");
    jQuery("#fifu_keywords").val("");

    jQuery("#fifu_button").show();
    jQuery("#fifu_help").show();

    if (fifuMetaBoxVars.is_sirv_active)
        jQuery("#fifu_sirv_button").show();
}

function previewImage() {
    var $url = jQuery("#fifu_input_url").val();

    if (jQuery("#fifu_input_url").val() && jQuery("#fifu_keywords").val())
        $message = 'Please wait some seconds...';
    else
        $message = '';

    if (!$url.startsWith("http")) {
        jQuery("#fifu_keywords").val($url);
        jQuery('#fifu_button').parent().parent().block({message: $message, css: {backgroundColor: 'none', border: 'none', color: 'white'}});
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function (e) {
            if (xhr.status == 200 && xhr.readyState == 4) {
                if ($url != xhr.responseURL) {
                    $url = xhr.responseURL;
                    jQuery("#fifu_input_url").val($url);
                    runPreview($url);
                }
                setTimeout(function () {
                    jQuery("#fifu_next").show();
                    jQuery('#fifu_button').parent().parent().unblock();
                }, 2000);
            }
        }
        xhr.open("GET", 'https://source.unsplash.com/featured/?' + $url, true);
        xhr.send();
        if (!$url)
            jQuery("#fifu_keywords").val(' ');
    } else {
        jQuery("#fifu_next").hide();
        runPreview($url);
    }
}

function runPreview($url) {
    $url = fifu_convert($url);

    jQuery("#fifu_lightbox").attr('href', $url);

    if ($url) {
        jQuery("#fifu_button").hide();
        jQuery("#fifu_help").hide();

        jQuery("#fifu_image").css('background-image', "url('" + $url + "')");

        jQuery("#fifu_input_alt").show();
        jQuery("#fifu_image").show();
        jQuery("#fifu_link").show();

        if (fifuMetaBoxVars.is_sirv_active)
            jQuery("#fifu_sirv_button").hide();
    }
}

function getMeta(url) {
    jQuery("<img/>", {
        load: function () {
            jQuery("#fifu_input_image_width").val(this.width);
            jQuery("#fifu_input_image_height").val(this.height);
        },
        src: url
    });
}

jQuery(document).ready(function () {
    jQuery("#fifu_next").on('click', function (evt) {
        evt.stopImmediatePropagation();
        if (jQuery("#fifu_keywords").val()) {
            jQuery("#fifu_input_url").val(jQuery("#fifu_keywords").val());
            previewImage();
        }
    });
    jQuery("#fifu_image").on('click', function (evt) {
        evt.stopImmediatePropagation();
        jQuery.fancybox.open('<img src="' + jQuery("#fifu_input_url").val() + '" style="max-height:600px">');
    });
});
