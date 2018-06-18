jQuery(document).ready(function() {
  try {
    document.querySelector('section>figure').remove(); // remove excerpt
  } catch {}
  if (document.querySelector('section>div[data-shortcode="caption"] img[data-orig-file]').getAttribute('data-orig-file').length>0) {
    jQuery('.author').empty().append('<span><img class="img-rounded" src="'+document.querySelector('section>div[data-shortcode="caption"] img[data-orig-file]').getAttribute('data-orig-file')+'" height="48" width="48"/> '+document.querySelector('section>div[data-shortcode="caption"]>p[class="wp-caption-text"]').innerText+',</span>');
    document.querySelector('section>div[data-shortcode="caption"]').remove();
  }
});
