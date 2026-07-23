<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package dekiru
 */

get_header();

$news_count = "0";

?>

	<div id="primary" class="content-area news-content">

		<main id="main" class="site-main">
			<h1 class="section-title"><span>Latest</span> news</h1>
		<?php
		if ( have_posts() ) : ?>

			<div class="news-cards">
				<?php /* Start the Loop */
				while ( have_posts() ) : the_post();
					$news_count++;
				?>

					<article id="post-<?php the_ID(); ?>" <?php post_class('news-card',$news_count); ?>>

						<div class="post-thumbnail">
							<a href="<?php echo the_permalink(); ?>">
								<?php 
								if ($news_count == "1") {
									the_post_thumbnail('news-card-large');
								} elseif ( ($news_count == "2") || ($news_count == "3") ) {
									the_post_thumbnail('news-card-medium');
								} else {
									the_post_thumbnail('news-card-small');
								} 
								
								if(get_the_post_thumbnail() == null) : ?>
									<img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.png" alt="">
								<?php endif; 
								
								?>
							</a>
						</div>
						
						<div class="post-details">
							<header class="entry-header">
								<div class="entry-meta">
									<?php $post_date = get_the_date('d.m.y'); 
										echo $post_date;
									?>
								</div>
								<h2 class="entry-title">
									<a href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a>
								</h2>
							</header>

							<div class="entry-content">
								<?php
								the_excerpt();

								wp_link_pages( array(
									'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'dekiru' ),
									'after'  => '</div>',
								) );
								?>
							</div>

							<footer class="entry-footer">
								<a href="<?php echo the_permalink(); ?>" class="cpg-button__block">
									Read more <span> about <?php the_title(); ?></span>
								</a>
							</footer>
						</div>
					</article>

				<?php endwhile; ?>
			</div>

			<?php the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

		</main>
	</div>

<?php
get_footer();
