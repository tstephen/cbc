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
            <?php if ( get_post_type( get_the_ID() ) != 'wpfc_sermon' ) { ?>
              <?php get_template_part('includes/loops/content', 'author'); ?>
            <?php } ?>
            <p class="no-print text-muted" style="margin-bottom: 30px;">
              <?php if (has_category(get_post())) { ?>
                <i class="glyphicon glyphicon-folder-open"></i>&nbsp; <?php _e('Filed under', 'bst'); ?>: <?php the_category(', ') ?><br/>
              <?php } ?>
              <?php if (comments_open()) { ?>
                <i class="no-print glyphicon glyphicon-comment"></i>&nbsp; <?php _e('Comments', 'bst'); ?>: <?php comments_popup_link(__('None', 'bst'), '1', '%'); ?>
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
