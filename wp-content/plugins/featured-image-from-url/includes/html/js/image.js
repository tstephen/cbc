jQuery(document).ready(function ($) {
    setTimeout(function () {
        jQuery('div.flex-viewport').each(function (index) {
            jQuery(this).css('height', '');
        });
    }, 500);
});
