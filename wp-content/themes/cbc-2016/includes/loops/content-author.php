<h5 class="no-print">
	<em>
		<span class="text-muted author">
			<img class="img-rounded" src="<?php echo 'https://www.gravatar.com/avatar/'.md5( strtolower( get_the_author_meta('email') ) ).'?d=blank&e='.urlencode( $default ).'&s=48'; ?>">
			<?php the_author_posts_link(); ?>
			<time class="text-muted" datetime="<?php the_time('d-m-Y')?>"><?php the_time('jS F Y') ?></time>
		</span>
	</em>
</h5>

