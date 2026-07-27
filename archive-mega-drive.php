<?php
/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Twenty Fourteen
 * already has tag.php for Tag archives, category.php for Category archives,
 * and author.php for Author archives.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package dekiru
 */

get_header(); ?>

	<main id="primary" class="site-main">

		<?php get_template_part( 'template-parts/showcase' ); ?>

		<div class="">

			<?php
			
			if ( have_posts() ) : ?>

				<header class="page-header">
					<?php
					the_archive_title( '<h1 class="page-title screen-reader-text">', '</h1>' );
					// the_archive_description( '<div class="archive-description">', '</div>' );
					?>
					<h1 class="page-title">Mega Drive<br/>
					メガ ドライブ</h1>
				</header>

				<?php the_posts_navigation(); ?>

				<div class="display-grid format-mega-drive">
				<?php
				/* Start the Loop */
				while ( have_posts() ) :
					the_post();

					/*
					* Include the Post-Type-specific template for the content.
					* If you want to override this in a child theme, then include a file
					* called content-___.php (where ___ is the Post Type name) and that will be used instead.
					*/
					get_template_part( 'template-parts/content', 'mega-drive' );

				endwhile;
				?>
				</div>
			
				<?php

			endif;

			?>

		</div>
	</main>
<?php
get_footer();
