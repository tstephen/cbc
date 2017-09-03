<?php
/*
The Single Posts Loop
=====================
*/
?>

<?php if(have_posts()): while(have_posts()): the_post(); ?>
    <article role="article" id="post_<?php the_ID()?>" <?php post_class()?>>
        <header>
            <h1><?php the_title()?></h1>
            <h5>
                <em>
                    <span class="text-muted author">
                      <img class="img-rounded" src="<?php echo 'https://www.gravatar.com/avatar/'.md5( strtolower( get_the_author_meta('email') ) ).'?d='.urlencode( $default ).'&s=48'; ?>">
                      <?php the_author() ?>,</span>
                    <time  class="text-muted" datetime="<?php the_time('d-m-Y')?>"><?php the_time('jS F Y') ?></time>
                </em>
            </h5>
            <p class="text-muted" style="margin-bottom: 30px;">
                <i class="glyphicon glyphicon-folder-open"></i>&nbsp; <?php _e('Filed under', 'bst'); ?>: <?php the_category(', ') ?><br/>
                <?php if (comments_open()) { ?>
                  <i class="glyphicon glyphicon-comment"></i>&nbsp; <?php _e('Comments', 'bst'); ?>: <?php comments_popup_link(__('None', 'bst'), '1', '%'); ?>
                <?php } ?>
            </p>
        </header>
        <section>
            <figure>
                <?php the_post_thumbnail( 'full', array( 'class' => 'img-responsive')); ?>
                <figcaption><?php echo get_post(get_post_thumbnail_id())->post_excerpt; ?></figcaption>
            </figure>
            <?php the_content()?>
            <?php wp_link_pages(); ?>
        </section>
    </article>
<?php comments_template('/includes/loops/comments.php'); ?>
<?php endwhile; ?>
<?php else: get_template_part('includes/loops/content', 'none'); ?>
<?php endif; ?>
