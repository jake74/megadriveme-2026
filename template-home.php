<?php
/**
 * Template Name: Home
 *
 * @package dekiru
 */

get_header();

$game_birthday = false;

?>

	<div class="content-area">
		<main id="main" class="site-main">
			
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
		) );

		if ( $today_posts->have_posts() ) : ?>
		<h1>Today in Gaming History</h1>
		<?php while ( $today_posts->have_posts() ) : $today_posts->the_post(); 
			$game_birthday = true;	
		?>
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<div class="entry-summary">
					<?php the_excerpt(); ?>
				</div>

			<?php endwhile;
			wp_reset_postdata();
		else :
				echo '<p>No posts found for today.</p>';
		endif;
		?>

		<div class="random-mega-drive">
			<h2>Random Mega Drive Game</h2>
			<?php
			$random_game = new WP_Query( array(
				'post_type' => 'mega-drive',
				'orderby' => 'rand',
				'posts_per_page' => 8,
			) );

			if ( $random_game->have_posts() ) :
				while ( $random_game->have_posts() ) : $random_game->the_post(); ?>
					<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<div class="entry-summary">
						<?php the_excerpt(); ?>
					</div>
				<?php endwhile;
				wp_reset_postdata();
			else :
				echo '<p>No Mega Drive games found.</p>';
			endif;
			?>
		</div>

		<div class="random-mega-cd">
			<h2>Random Mega CD Game</h2>
			<?php
			$random_game = new WP_Query( array(
				'post_type' => 'mega-cd',
				'orderby' => 'rand',
				'posts_per_page' => 8,
			) );

			if ( $random_game->have_posts() ) :
				while ( $random_game->have_posts() ) : $random_game->the_post(); ?>
					<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<div class="entry-summary">
						<?php the_excerpt(); ?>
					</div>
				<?php endwhile;
				wp_reset_postdata();
			else :
				echo '<p>No Mega CD games found.</p>';
			endif;
			?>
		</div>

		<div class="random-32x">
			<h2>Random 32X Game</h2>
			<?php
			$random_game = new WP_Query( array(
				'post_type' => '32x',
				'orderby' => 'rand',
				'posts_per_page' => 4,
			) );

			if ( $random_game->have_posts() ) :
				while ( $random_game->have_posts() ) : $random_game->the_post(); ?>
					<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<div class="entry-summary">
						<?php the_excerpt(); ?>
					</div>
				<?php endwhile;
				wp_reset_postdata();
			else :
				echo '<p>No 32X games found.</p>';
			endif;
			?>

		</main>
	</div>

<?php
get_footer();