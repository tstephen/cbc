<nav class="navbar navbar-default navbar-static-bottom">
  <div class="container-fluid">
    <footer class="container site-footer">
      <div class="row">
        <?php dynamic_sidebar('footer-widget-area'); ?>
      </div>
      <div class="row" style="padding-top:1em">
        <div class="col-lg-12 site-sub-footer">
          <p>Registered charity number 1148492. &copy; <?php echo date('Y'); ?> <a href="<?php echo home_url('/'); ?>"><?php bloginfo('name'); ?></a></p>
        </div>
      </div>
    </footer>
  </div>
</nav>

<?php wp_footer(); ?>
</body>
</html>
