<?php get_header(); ?>

  <div class="row">
    
    <div class="col-xs-12">
      <div id="content" role="main">
        <?php get_template_part('includes/loops/content', get_post_format()); ?>
      </div><!-- /#content -->
    </div>
    
  </div><!-- /.row -->

<?php get_footer(); ?>
