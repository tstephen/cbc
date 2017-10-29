<?php get_template_part('includes/header'); ?>

<?php if ( has_post_thumbnail() ) { ?>
  <div class="featured-image">
    <?php the_post_thumbnail('full');?>
  </div>
<?php } ?>
<div class="container">
  <div class="row">

    <div class="col-xs-12 col-sm-12">
      <div id="content" role="main">
        <?php get_template_part('includes/loops/content', 'page'); ?>
      </div><!-- /#content -->
    </div>
    
  </div><!-- /.row -->
</div><!-- /.container -->

<div class="container">
  <div class="row">
    <h2>Latest posts</h2>
    <?php 
      $cat = array_values(get_post_custom_values("category", $post->ID))[0];
      echo do_shortcode('[catlist name="'.$cat.'" date="yes" excerpt="yes" excerpt_size="30" numberposts="5" thumbnail="yes" thumbnail_force="yes" thumbnail_size="150,150" thumbnail_class="img-responsive"]') ?>
  </div><!-- /.row -->
</div>

<?php get_template_part('includes/footer'); ?>
