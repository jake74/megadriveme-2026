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

		<div class="archive-list">

			<?php

			$game_covers = new WP_Query( array(
				'post_type' => 'mega-drive',
				'posts_per_page' => -1,
				'meta_query' => array(
					array(
						'key' => '_thumbnail_id',
					),
				),
			) );
			wp_reset_postdata();

			$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			$args = array(
					'post_type' => 'mega-drive',
					'orderby'   => 'date',
					'order'     => 'ASC', // Change to DESC to reverse
					'paged'     => $paged,
					// 'posts_per_page' => 12,
			);

			$total_posts = wp_count_posts( 'mega-drive' )->publish;

			$library = new WP_Query( $args );
			
			if ( $library->have_posts() ) : ?>

				<header class="page-header">
					<?php
					the_archive_title( '<h1 class="page-title screen-reader-text">', '</h1>' );
					// the_archive_description( '<div class="archive-description">', '</div>' );
					?>
					<h1 class="page-title" lang="ja">メガ ドライブ</h1>
					<h2 class="page-subtitle">Mega Drive</h2>

				</header>
				
				<?php echo '<div class="total-posts"><p>In collection: ' . $game_covers->found_posts . ' of ' . $total_posts . '</p></div>'; ?>
				<?php the_posts_navigation( array( 'total' => $library->max_num_pages ) ); ?>

				<div class="display-grid format-mega-drive">
					<?php
					/* Start the Loop */
					while ( $library->have_posts() ) :
						$library->the_post();

						/*
						* Include the Post-Type-specific template for the content.
						* If you want to override this in a child theme, then include a file
						* called content-___.php (where ___ is the Post Type name) and that will be used instead.
						*/
						get_template_part( 'template-parts/content', 'game' );

					endwhile; ?>
				</div>


				<?php the_posts_navigation( array( 'total' => $library->max_num_pages ) ); ?>
			
				<?php endif; ?>

		</div>
	</main>
<?php
get_footer();
