jQuery(document).ready(function ($) {
    // lazy load
    if (fifuImageVars.fifu_lazy) {
        setTimeout(function () {
            fifu_lazy();
        }, 1);
    }

    // woocommerce lightbox/zoom
    disableClick($);
    disableLink($);

    // zoomImg
    setTimeout(function () {
        jQuery('img.zoomImg').css('z-index', '');
    }, 1000);

    jQuery('img[height=1]').each(function (index) {
        if (jQuery(this).attr('width') != 1)
            jQuery(this).css('position', 'relative');
    });
});

jQuery(window).on('ajaxComplete', function () {
    if (fifuImageVars.fifu_lazy)
        fifu_lazy();
});

// fix space between product image and gallery caused by lazy load
if (fifuImageVars.fifu_is_product) {
    jQuery('img[fifu-featured="1"]').on('load', function () {
        mainImage = jQuery('.flex-viewport').find('img[fifu-featured="1"]')[0];
        if (mainImage)
            jQuery('.flex-viewport').css('height', mainImage.clientHeight + 'px');
    });
}

function disableClick($) {
    if (!fifuImageVars.fifu_woo_lbox_enabled) {
        firstParentClass = '';
        parentClass = '';
        jQuery('figure.woocommerce-product-gallery__wrapper').find('div.woocommerce-product-gallery__image').each(function (index) {
            parentClass = jQuery(this).parent().attr('class').split(' ')[0];
            if (!firstParentClass)
                firstParentClass = parentClass;

            if (parentClass != firstParentClass)
                return false;

            jQuery(this).children().click(function () {
                return false;
            });
            jQuery(this).children().children().css("cursor", "default");
        });
    }
}

function disableLink($) {
    if (!fifuImageVars.fifu_woo_lbox_enabled) {
        firstParentClass = '';
        parentClass = '';
        jQuery('figure.woocommerce-product-gallery__wrapper').find('div.woocommerce-product-gallery__image').each(function (index) {
            parentClass = jQuery(this).parent().attr('class').split(' ')[0];
            if (!firstParentClass)
                firstParentClass = parentClass;

            if (parentClass != firstParentClass)
                return false;

            jQuery(this).children().attr("href", "");
        });
    }
}
