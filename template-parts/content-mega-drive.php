<?php

// used as archive/index list
$post_type = get_post_type();

if ( $post_type === 'mega-cd' ) {
	$cover_size = 'mcd_cover_archive';
} else {
	$cover_size = 'md_cover_archive';
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('game-cover ' . $post_type); ?>>

	<a class="post-thumbnail <?php echo $post_type; ?> game-cover" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
		
		<?php if ( has_post_thumbnail() ) :
			the_post_thumbnail( $cover_size, array( 'alt' => the_title_attribute( array( 'echo' => false, ) ), ) );
		else :
			// Display a default image if no featured image is set
			$default_image_id = get_field( 'default_cover_image', 'options' );
			if ( $default_image_id ) :
				echo wp_get_attachment_image( $default_image_id, $cover_size, false, array( 'alt' => 'Default cover image', ) );
			endif;
		endif; ?>

		<header class="entry-header">
			<?php
			if ( is_singular() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h2 class="entry-title">', '</h2>' );
			endif;

			if ( 'post' === get_post_type() ) :
				?>
				<div class="entry-meta">
					<?php
					mdme_2026_posted_on();
					mdme_2026_posted_by();
					?>
				</div>
			<?php endif; ?>
		</header>
	</a>

</article>
