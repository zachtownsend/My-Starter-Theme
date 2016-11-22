<?php if ( have_rows( 'shareable_social_media', 'advice_settings' ) ): ?>
<ul class="social-media shareable">
	<?php while ( have_rows( 'shareable_social_media', 'advice_settings' ) ): the_row(); ?>
		<?php $vendor = get_sub_field( 'vendor' ); ?>
		<?php if ( 'facebook' === $vendor ): ?>
			<?php $thumbnail_image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_id() ), 'social-share-'.$vendor )[0]; ?>
			<li class="facebook">
				<a class="fb-share sssocial" data-description="<?php echo get_the_excerpt(); ?>" data-link="<?php echo esc_attr(get_the_permalink()); ?>" data-name="<?php echo esc_attr(get_the_title()); ?>" data-picture="<?php echo $thumbnail_image; ?>" href="">
					<span class="ss-facebook"></span>
				</a>
			</li>
		<?php elseif( 'twitter' === $vendor ) : ?>
			<?php $thumbnail_image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_id() ), 'social-share-'.$vendor )[0]; ?>
			<li class="twitter">
				<a href="https://twitter.com/intent/tweet?via=<?php echo $twitter_handle; ?>&text=<?php echo urlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8')); ?>+%7C&url=<?php echo urlencode(get_permalink()); ?>" target="_blank">
					<span class="ss-twitter"></span>
				</a>
			</li>
		<?php elseif( 'linkedin' === $vendor ) : ?>
			<?php $thumbnail_image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_id() ), 'social-share-'.$vendor )[0]; ?>

		<?php elseif( 'instagram' === $vendor ) : ?>
			<?php $thumbnail_image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_id() ), 'social-share-'.$vendor )[0]; ?>

		<?php elseif( 'youtube' === $vendor ) : ?>

		<?php elseif( 'googleplus' === $vendor ) : ?>
			<?php $thumbnail_image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_id() ), 'social-share-'.$vendor )[0]; ?>
			<li class="googleplus">
				<a href="https://plus.google.com/share?url=<?php echo urlencode(get_permalink()); ?>" target="_blank">
					<span class="ss-googleplus"></span>
				</a>
			</li>
		<?php elseif( 'pinterest' === $vendor ) : ?>
			<?php $thumbnail_image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_id() ), 'social-share-'.$vendor )[0]; ?>
			<li class="pinterest">
				<a href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink()); ?>&media=<?php echo $thumbnail_image; ?>&description=<?php echo get_the_title(); ?>" target="_blank">
					<span class="ss-pinterest"></span>
				</a>
			</li>
		<?php elseif( 'tumblr' === $vendor ) : ?>

		<?php elseif( 'quora' === $vendor ) : ?>

		<?php elseif( 'blogger' === $vendor ) : ?>

		<?php elseif( 'reddit' === $vendor ) : ?>

		<?php elseif( 'wordpress' === $vendor ) : ?>

		<?php elseif( 'vimeo' === $vendor ) : ?>

		<?php elseif( 'vine' === $vendor ) : ?>

		<?php elseif( 'flickr' === $vendor ) : ?>

		<?php elseif( 'skype' === $vendor ) : ?>

		<?php elseif( 'behance' === $vendor ) : ?>

		<?php elseif( 'paypal' === $vendor ) : ?>

		<?php elseif( 'rdio' === $vendor ) : ?>

		<?php elseif( 'spotify' === $vendor ) : ?>

		<?php elseif( 'soundcloud' === $vendor ) : ?>

		<?php elseif( 'phone' === $vendor ) : ?>

		<?php elseif( 'mail' === $vendor ) : ?>
			<li class="mail">
				<a href="mailto:?subject=<?php the_title(); ?>&body=Check out this article <?php the_permalink(); ?>" title="Share by email" target="_blank">
					<span class="ss-mail"></span>
				</a>
			</li>
		<?php else: ?>
			
		<?php endif ?>

	<?php endwhile; ?>
</ul>	
<?php endif ?>