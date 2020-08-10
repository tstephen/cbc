(function () {
    window.lazySizesConfig = window.lazySizesConfig || {};
    window.lazySizesConfig.loadMode = 1;
    window.lazySizesConfig.expand = 1;
    window.lazySizesConfig.expFactor = 0.1;
    window.lazySizesConfig.hFac = 0.1;
    window.lazySizesConfig.throttleDelay = 0;
})();

const FIFU_PLACEHOLDER = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';

function fifu_lazy() {
    jQuery('img').each(function (index) {
        fifu_add_placeholder(this);

        // dont touch on slider
        if (!jQuery(this).hasClass('fifu'))
            fifu_add_lazyload(this);
    });
}

function fifu_add_lazyload($) {
    jQuery($).addClass('lazyload');
}

function fifu_add_placeholder($) {
    clazz = jQuery($).attr('class');
    src = jQuery($).attr('src');
    datasrc = jQuery($).attr('data-src');
    if (!src && datasrc)
        jQuery($).attr('src', FIFU_PLACEHOLDER);
}

document.addEventListener('lazybeforeunveil', function (e) {
    // background-image    
    var url = jQuery(e.target).attr('data-bg');
    if (url) {
        delimiter = fifu_get_delimiter(jQuery(e.target), 'data-bg');
        jQuery(e.target).css('background-image', 'url(' + fifu_get_delimited_url(url, delimiter) + ')');
    }

    // width & height
    jQuery(e.target).attr('fifu-width', e.srcElement.clientWidth);
    jQuery(e.target).attr('fifu-height', e.srcElement.clientHeight);
});

document.addEventListener('lazyunveilread', function (e) {
});

function fifu_get_delimiter($, attr) {
    return $[0].outerHTML.split(attr + '=')[1][0];
}

function fifu_get_delimited_url(url, delimiter) {
    return delimiter + url + delimiter;
}
