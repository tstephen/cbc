</div><!-- /.container -->

<div class="no-print container-fluid" role="complimentary">
  <div class="row">
    <div class="col-sm-6 col-xs-12" id="left-col" role="navigation">
      <?php get_template_part('includes/sidebar1'); ?>
    </div>
    <div class="col-sm-6 col-xs-12" id="right-col" role="navigation">
      <?php get_template_part('includes/sidebar2'); ?>
    </div>
  </div><!-- /.row -->
</div>

<nav class="no-print navbar navbar-default navbar-static-bottom">
    <footer class="container-fluid site-footer">
      <div class="row">
        <?php dynamic_sidebar('footer-widget-area'); ?>
      </div>
      <div class="row" style="padding-top:1em">
        <div class="col-lg-12 site-sub-footer">
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sub-footer-widget-area') ) : endif; ?>
        </div>
      </div>
    </footer>
</nav>

<?php wp_footer(); ?>
<!-- Global Site Tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-40400507-2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments)};
  gtag('js', new Date());

  gtag('config', 'UA-40400507-2');
</script>
</body>
</html>
