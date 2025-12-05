<?php $quote = get_post_meta( $post->ID, '_zilla_quote_quote', true ); ?>

<div class="post-media">
	<?php if( is_single() ) { ?>

		<h1 class="entry-title">&#8220;<?php echo stripslashes( esc_html($quote) ); ?>&#8221;</h1>

	<?php } else { ?>

		<h2 class="entry-title">&#8220;<?php echo stripslashes( esc_html($quote) ); ?>&#8221;</h2>

	<?php } ?>

	<p class="quote-source">
		<?php the_title(); ?>
		<?php if( !is_single() ) { ?>
			<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'zilla' ), the_title_attribute( 'echo=0' ) ) ); ?>">#</a>
		<?php } ?>
	</p>
</div>