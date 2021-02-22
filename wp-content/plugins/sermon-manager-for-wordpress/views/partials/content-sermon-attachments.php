<?php
/**
 * To edit this file, please copy the contents of this file to one of these locations:
 * - `/wp-content/themes/<your_theme>/partials/content-sermon-attachments.php`
 * - `/wp-content/themes/<your_theme>/template-parts/content-sermon-attachments.php`
 * - `/wp-content/themes/<your_theme>/content-sermon-attachments.php`
 *
 * That will ensure that your changes are not deleted on plugin update.
 *
 * Sometimes, we need to edit this file to add new features or to fix some bugs, and when we do so, we will modify the
 * changelog in this header comment.
 *
 * @package SermonManager\Views\Partials
 *
 * @since   2.13.0 - added
 */

global $post;
?>
<div id="wpfc-attachments" class="cf">
	<p>
		<strong><?php echo __( 'Download Files', 'sermon-manager-for-wordpress' ); ?></strong>
		<?php 
		if(get_wpfc_sermon_meta( 'sermon_notes' )){
		$notes = get_wpfc_sermon_meta( 'sermon_notes' );	
		if(is_array($notes)){
			if(count($notes) > 0):
			foreach ($notes as $key => $value) {?>
			<a href="<?php echo $value; ?>"
				class="sermon-attachments"
				download="<?php echo basename( $value ); ?>">
				<span class="dashicons dashicons-media-document"></span>
				<?php echo __( 'Notes', 'sermon-manager-for-wordpress' ); ?>
			</a>				
			<?php } endif;
		}else{ ?>
			<a href="<?php echo $notes; ?>"
				class="sermon-attachments"
				download="<?php echo basename( $notes ); ?>">
				<span class="dashicons dashicons-media-document"></span>
				<?php echo __( 'Notes', 'sermon-manager-for-wordpress' ); ?>
			</a>	
		<?php }	
		
		}
				if(get_wpfc_sermon_meta( 'sermon_bulletin' )){
			$sermon_bulletin =get_wpfc_sermon_meta( 'sermon_bulletin' );
			if(is_array($sermon_bulletin)){
				if( count($sermon_bulletin)>0):
				foreach ($sermon_bulletin as $k => $v) {?>
				<a href="<?php echo $v; ?>"
					class="sermon-attachments"
					download="<?php echo basename( $v ); ?>">
					<span class="dashicons dashicons-media-document"></span>
					<?php echo __( 'Bulletin', 'sermon-manager-for-wordpress' ); ?>
				</a>				
				<?php } endif;	
			}else{?>
				<a href="<?php echo $sermon_bulletin; ?>"
					class="sermon-attachments"
					download="<?php echo basename( $sermon_bulletin ); ?>">
					<span class="dashicons dashicons-media-document"></span>
					<?php echo __( 'Bulletin', 'sermon-manager-for-wordpress' ); ?>
				</a>	
			<?php }
					
		}
		 ?>
	</p>
</div>