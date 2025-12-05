<?php $link = get_post_meta( $post->ID, '_zilla_link_url', true ); ?>

<div class="post-media">
	<?php if( is_single() ) { ?>

		<h1 class="entry-title"><a href="<?php echo esc_url($link); ?>" target="_blank"><?php the_title(); ?></a></h1>

	<?php } else { ?>

		<h2 class="entry-title"><a href="<?php echo esc_url($link); ?>" target="_blank"><?php the_title(); ?></a></h2>

	<?php } ?>

	<p class="link-source">
		<?php echo $link; ?>
		<?php if( !is_single() ) { ?>
			<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'zilla' ), the_title_attribute( 'echo=0' ) ) ); ?>">#</a>
		<?php } ?>
	</p>
</div>