<?php

// used as archive/index list
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('game-cover'); ?>>

	<a class="post-thumbnail md-cover game-cover" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
		
		<?php if ( has_post_thumbnail() ) :
			the_post_thumbnail( 'md_cover', array( 'alt' => the_title_attribute( array( 'echo' => false, ) ), ) );
		else :
			get_template_part( 'template-parts/showcase' );
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
