<?php get_header(); ?>
</div>

<?php if ( has_post_thumbnail() ) { ?>
  <div class="featured-image">
    <?php the_post_thumbnail('full');?>
  </div>
<?php } ?>
<div class="container-fluid">
  <div class="row">

    <div class="col-xs-12">
      <div id="content" role="main">
        <?php get_template_part('includes/loops/content', 'page'); ?>
      </div><!-- /#content -->
    </div>
    
  </div><!-- /.row -->
</div><!-- /.container -->

<?php get_footer(); ?>
