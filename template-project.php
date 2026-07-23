<?php
/**
 * Template Name: Flexible Content
 * The template for the long form flexible content pages
 *
 * @package dekiru
 */

get_header();

?>

	<div class="content-area">
		<main id="main" class="site-main">

    <?php if( have_rows('flexible_content') ): 
			while ( have_rows('flexible_content') ) : the_row();

				if( get_row_layout() == 'intro'):
          get_template_part( 'template-parts/flexible', 'intro' );

				elseif( get_row_layout() == 'copy_block'):
					get_template_part( 'template-parts/flexible', 'copy_block' );

				elseif( get_row_layout() == 'wide_image'):
					get_template_part( 'template-parts/flexible', 'wide_image' );

				endif;
			endwhile;
		endif; ?>

		</main>
	</div>

<?php
get_footer();