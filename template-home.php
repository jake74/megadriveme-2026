<?php
/**
 * Template Name: Home
 *
 * @package dekiru
 */

get_header();

$game_birthday = false;

$posts_per_page = 6;

$today_timestamp = current_time( 'timestamp' );
$today_month = (int) wp_date( 'n', $today_timestamp );
$today_day = (int) wp_date( 'j', $today_timestamp );



?>

<main id="main" class="site-main">
	
	<div class="cabinet-content">
		<?php
		$today_posts = new WP_Query( array(
			'post_type' => array( 'mega-drive', '32x', 'mega-cd', 'hardware' ),
			'date_query' => array(
				array(
					'month' => $today_month,
					'day'   => $today_day,
				),
			),
			'posts_per_page' => -1, // Set to a specific number or -1 to show all
			'orderby' => 'date',
			'order' => 'ASC', // Ascending order
		) );

		$today_total = $today_posts->found_posts;
		$today_count = 'count-' . $today_total;
		if ( $today_total > 3 ) {
			$today_count = 'more-than-three count-' . $today_total;
		}

		if ( $today_posts->have_posts() ) : ?>

			<div class="section-header">
				<h1 class="section-title">Today in Mega Drive History</h1>
				<a href="/birthdays" class="view-all">All <i>🎂</i><span> Birthdays</span></a>
			</div>
			<div class="display-grid mega-drive today <?php echo $today_count; ?>">
				<?php while ( $today_posts->have_posts() ) : $today_posts->the_post(); 
					$game_birthday = true;	
				?>
					<?php 
					$args = array(
						'section' => 'today',
					);
					get_template_part( 'template-parts/card', 'game-cover', $args );
					?>
				<?php endwhile; ?>
			</div>
			<?php
			wp_reset_postdata();
		endif;
		?>

	<?php if ( get_the_content() ) : ?>
		<div class="intro">
			<div class="intro-content">
				<?php the_content(); ?>
			</div>
		</div>
	<?php endif; ?>

		<div class="random-mega-drive">
			<div class="section-header">
				<h2 class="section-title">Mega Drive games</h2>
				<a href="<?php echo get_post_type_archive_link( 'mega-drive' ); ?>" class="view-all"><span>All&nbsp;</span>Mega Drive</a>
			</div>
			<div class="display-grid format-mega-drive js-random-games" data-post-type="mega-drive" data-posts-per-page="<?php echo esc_attr( $posts_per_page ); ?>" data-empty-message="No Mega Drive games found.">
				<p class="loading-message">Loading...</p>
			</div>
		</div>

		<div class="random-mega-cd">
			<div class="section-header">
				<h2 class="section-title">Mega CD games</h2>
				<a href="<?php echo get_post_type_archive_link( 'mega-cd' ); ?>" class="view-all"><span>All&nbsp;</span>Mega CD</a>
			</div>
			<div class="display-grid format-mega-drive js-random-games" data-post-type="mega-cd" data-posts-per-page="<?php echo esc_attr( $posts_per_page ); ?>" data-empty-message="No Mega CD games found.">
				<p class="loading-message">Loading...</p>
			</div>
		</div>

		<div class="random-32x">
			<div class="section-header">
				<h2 class="section-title">Super 32X games</h2>
				<a href="<?php echo get_post_type_archive_link( '32x' ); ?>" class="view-all"><span>All&nbsp;</span>Super 32X</a>
			</div>
			<div class="display-grid format-mega-drive js-random-games" data-post-type="32x" data-posts-per-page="<?php echo esc_attr( $posts_per_page ); ?>" data-empty-message="No 32X games found.">
				<p class="loading-message">Loading...</p>
			</div>
		</div>
	</div>

</main>


<?php get_template_part( 'template-parts/showcase' ); ?>

<?php
get_footer();