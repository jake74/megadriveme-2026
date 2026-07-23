<?php
/**
 * Template Name: Home
 *
 * @package dekiru
 */

get_header();

$game_birthday = false;

?>

<main id="main" class="site-main">
	
	<?php get_template_part( 'template-parts/showcase' ); ?>
		
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

		if ( $today_posts->have_posts() ) : ?>
			<p>Today in Mega Drive History</p>
			<div class="display-grid mega-drive">
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

		<div class="random-mega-drive">
			<p>Random Mega Drive Game</p>
			<p><a href="<?php echo get_post_type_archive_link( 'mega-drive' ); ?>">View all Mega Drive games</a></p>
			<?php
			$random_game = new WP_Query( array(
				'post_type' => 'mega-drive',
				'orderby' => 'rand',
				'posts_per_page' => 8,
			) );

			if ( $random_game->have_posts() ) :
				while ( $random_game->have_posts() ) : $random_game->the_post(); ?>
					<p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
				<?php endwhile;
				wp_reset_postdata();
			else :
				echo '<p>No Mega Drive games found.</p>';
			endif;
			?>
		</div>

		<div class="random-mega-cd">
			<p>Random Mega CD Game</p>
			<p><a href="<?php echo get_post_type_archive_link( 'mega-cd' ); ?>">View all Mega CD games</a></p>
			<?php
			$random_game = new WP_Query( array(
				'post_type' => 'mega-cd',
				'orderby' => 'rand',
				'posts_per_page' => 8,
			) );

			if ( $random_game->have_posts() ) :
				while ( $random_game->have_posts() ) : $random_game->the_post(); ?>
					<p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
				<?php endwhile;
				wp_reset_postdata();
			else :
				echo '<p>No Mega CD games found.</p>';
			endif;
			?>
		</div>

		<div class="random-32x">
			<p>Random 32X Game</p>
			<p><a href="<?php echo get_post_type_archive_link( '32x' ); ?>">View all 32X games</a></p>
			<?php
			$random_game = new WP_Query( array(
				'post_type' => '32x',
				'orderby' => 'rand',
				'posts_per_page' => 8,
			) );

			if ( $random_game->have_posts() ) :
				while ( $random_game->have_posts() ) : $random_game->the_post(); ?>
					<p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
				<?php endwhile;
				wp_reset_postdata();
			else :
				echo '<p>No 32X games found.</p>';
			endif;
			?>
		</div>

	</main>

<?php
get_footer();