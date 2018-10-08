<?php get_header(); ?>
</div>

<?php echo do_shortcode('[cycloneslider id="home-slider"]'); ?>

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

<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sub-footer-widget-area') ) : endif; ?>

<?php get_footer(); ?>
