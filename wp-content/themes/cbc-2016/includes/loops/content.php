<?php
/*
The Default Loop (used by index.php and category.php)
=====================================================

If you require only post excerpts to be shown in index and category pages, then use the [---more---] line within blog posts.

If you require different templates for different post types, then simply duplicate this template, save the copy as, e.g. "content-aside.php", and modify it the way you like it. (The function-call "get_post_format()" within index.php, category.php and single.php will redirect WordPress to use your custom content template.)

Alternatively, notice that index.php, category.php and single.php have a post_class() function-call that inserts different classes for different post types into the section tag (e.g. <section id="" class="format-aside">). Therefore you can simply use e.g. .format-aside {your styles} in css/bst.css style the different formats in different ways.
*/
?>

<?php if(have_posts()): while(have_posts()): the_post();?>
    <article role="article" id="post_<?php the_ID()?>" class="type-<?php echo get_post_type( get_the_ID() ) ?>">
        <header>
            <h1><a href="<?php the_permalink(); ?>"><?php the_title()?></a></h1>
            <?php if ( get_post_type( get_the_ID() ) != 'wpfc_sermon' ) { ?>
            <h5>
              <em>
                <span class="text-muted author">
                  <img class="img-rounded" src="<?php echo 'https://www.gravatar.com/avatar/'.md5( strtolower( get_the_author_meta('email') ) ).'?d='.urlencode( $default ).'&s=48'; ?>">
                  <?php the_author() ?>,</span>
                <time  class="text-muted" datetime="<?php the_time('d-m-Y')?>"><?php the_time('jS F Y') ?></time>
              </em>
            </h5>
            <?php } ?>
        </header>
        <section>
            <?php
              the_post_thumbnail( 'full', array( 'class' => 'img-responsive'));
            ?>
            <?php the_content( __( '&hellip; ' . __('Continue reading', 'bst' ) . ' <i class="glyphicon glyphicon-arrow-right"></i>', 'bst' ) ); ?>
        </section>
        <footer>
            <p class="text-muted" style="margin-bottom: 20px;">
              <?php if (has_category(get_post())) { ?>
                <i class="glyphicon glyphicon-folder-open"></i>&nbsp; <?php _e('Category', 'bst'); ?>: <?php the_category(', ') ?><br/>
              <?php } ?>
              <?php if (have_comments() && get_comments_number( $post->ID )>0) { ?>
                <i class="glyphicon glyphicon-comment"></i>&nbsp; <?php _e('Comments', 'bst'); ?>: <?php comments_popup_link(__('None', 'bst'), '1', '%'); ?>
              <?php } ?>
            </p>
        </footer>
    </article>
<?php endwhile; ?>

<?php if ( function_exists('bst_pagination') ) { bst_pagination(); } else if ( is_paged() ) { ?>
  <ul class="pagination">
    <li class="older"><?php next_posts_link('<i class="glyphicon glyphicon-arrow-left"></i> ' . __('Previous', 'bst')) ?></li>
    <li class="newer"><?php previous_posts_link(__('Next', 'bst') . ' <i class="glyphicon glyphicon-arrow-right"></i>') ?></li>
  </ul>
<?php } ?>

<?php else: get_template_part('includes/loops/content', 'none'); endif; ?>
