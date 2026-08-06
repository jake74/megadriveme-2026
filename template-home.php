<?php
/**
 * Template Name: Home
 *
 * @package dekiru
 */

get_header();

$game_birthday = false;

$posts_per_page = 6;

?>

<main id="main" class="site-main">
	
	<div class="cabinet-content">
		<?php
		$today_posts = new WP_Query( array(
			'post_type' => array( 'mega-drive', '32x', 'mega-cd', 'hardware' ),
			'date_query' => array(
				array(
					'month' => date( 'n', current_time( 'timestamp' ) ),
					'day'   => date( 'j', current_time( 'timestamp' ) ),
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
			<h1 class="section-title">Today in Mega Drive History</h1>
			<div class="display-grid mega-drive today <?php echo $today_count; ?>">
				<?php while ( $today_posts->have_posts() ) : $today_posts->the_post(); 
					$game_birthday = true;	
				?>
					<?php 
						get_template_part( 'template-parts/card', 'game-cover' );
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
			<div class="display-grid format-mega-drive">
				<?php
				$random_game = new WP_Query( array(
					'post_type' => 'mega-drive',
					'orderby' => 'rand',
					'posts_per_page' => $posts_per_page,
				) );

				if ( $random_game->have_posts() ) :
					while ( $random_game->have_posts() ) : $random_game->the_post(); 
						get_template_part( 'template-parts/card', 'game-cover' );
					endwhile;
					wp_reset_postdata();
				else :
					echo '<p>No Mega Drive games found.</p>';
				endif;
				?>
			</div>
		</div>

		<div class="random-mega-cd">
			<div class="section-header">
				<h2 class="section-title">Mega CD games</h2>
				<a href="<?php echo get_post_type_archive_link( 'mega-cd' ); ?>" class="view-all"><span>All&nbsp;</span>Mega CD</a>
			</div>
			<div class="display-grid format-mega-drive">
				<?php
				$random_game = new WP_Query( array(
					'post_type' => 'mega-cd',
					'orderby' => 'rand',
					'posts_per_page' => $posts_per_page,
				) );

				if ( $random_game->have_posts() ) :
					while ( $random_game->have_posts() ) : $random_game->the_post(); 
						get_template_part( 'template-parts/card', 'game-cover', array( 'post_type' => 'mega-cd' ) );
					endwhile;
					wp_reset_postdata();
				else :
					echo '<p>No Mega CD games found.</p>';
				endif;
				?>
			</div>
		</div>

		<div class="random-32x">
			<div class="section-header">
				<h2 class="section-title">32X games</h2>
				<a href="<?php echo get_post_type_archive_link( '32x' ); ?>" class="view-all"><span>All&nbsp;</span>32X</a>
			</div>
			<div class="display-grid format-mega-drive">
				<?php
				$random_game = new WP_Query( array(
					'post_type' => '32x',
					'orderby' => 'rand',
					'posts_per_page' => $posts_per_page,
				) );

				if ( $random_game->have_posts() ) :
					while ( $random_game->have_posts() ) : $random_game->the_post(); 
						get_template_part( 'template-parts/card', 'game-cover' );
					endwhile;
					wp_reset_postdata();
				else :
					echo '<p>No 32X games found.</p>';
				endif;
				?>
			</div>
		</div>
	</div>

</main>


<?php get_template_part( 'template-parts/showcase' ); ?>

<?php
get_footer();