<?php if ( have_rows( 'social-media-icons', 'options' ) ): ?>
	<h6><?php _e( 'Social', 'footer' ) ?></h6>
	<ul class="social-media">
	<?php while ( have_rows( 'social-media-icons', 'options' ) ) : the_row(); ?>
		<?php
		$slug = get_sub_field( 'network' );
		$url = get_sub_field( 'url' )
		?>
		<li><a href="<?php echo $url; ?>"><i class="ss-social ss-<?php echo $slug; ?>"></i></a></li>
	<?php endwhile; ?>
	</ul>
<?php endif ?>