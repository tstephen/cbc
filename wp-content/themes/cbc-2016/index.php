<?php get_template_part('includes/header'); ?>

<div class="container">
  <div class="row">
    
    <div class="col-xs-12">
      <div id="content" role="main">
        <?php get_template_part('includes/loops/content', get_post_format()); ?>
      </div><!-- /#content -->
    </div>
    
  </div><!-- /.row -->
</div><!-- /.container -->

<?php get_template_part('includes/footer'); ?>
