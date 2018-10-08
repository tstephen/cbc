<?php get_header(); ?>

  <div class="row">
    
    <div class="col-xs-12">
      <div id="content" role="main">
        <?php $title = single_cat_title("", false); ?>
        <?php if (!is_user_logged_in() && $title=='Members') { ?>
          <h1>Members Area</h1>
          <p>This is the members area of the CBC site, please login to view.</p>
          <?php echo preg_replace('[\[/?wpmem_txt\]]','',do_shortcode('[wpmem_form login]')); ?>
        <?php } else { ?>
        <h1>Category: <?php echo single_cat_title(); ?></h1>
        <?php get_template_part('includes/loops/content', get_post_format()); ?>
        <?php } ?>
      </div><!-- /#content -->
    </div>
    
  </div><!-- /.row -->

<?php get_footer(); ?>
