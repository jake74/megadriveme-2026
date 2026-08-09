<?php
/**
 * Template Name: Birthdays
 *
 * @package dekiru
 */

get_header();

$today_timestamp = current_time( 'timestamp' );
$today_mmdd = (int) wp_date( 'md', $today_timestamp );
$current_year = (int) wp_date( 'Y', $today_timestamp );

$post_type_labels = array(
	'mega-drive' => 'Mega Drive',
	'mega-cd'    => 'Mega CD',
	'32x'        => '32X',
);

$birthday_posts = new WP_Query(
	array(
		'post_type'      => array( 'mega-drive', 'mega-cd', '32x' ),
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'date',
		'order'          => 'ASC',
		'no_found_rows'  => true,
	)
);

$upcoming_birthdays = array();

if ( $birthday_posts->have_posts() ) {
	while ( $birthday_posts->have_posts() ) {
		$birthday_posts->the_post();

		$post_id = get_the_ID();
		$post_type = get_post_type( $post_id );
		$original_timestamp = get_post_time( 'U', false, $post_id );

		$month = (int) wp_date( 'n', $original_timestamp );
		$day = (int) wp_date( 'j', $original_timestamp );
		$birthday_year = (int) wp_date( 'Y', $original_timestamp );
		$mmdd = (int) wp_date( 'md', $original_timestamp );

		$occurrence_year = ( $mmdd >= $today_mmdd ) ? $current_year : $current_year + 1;
		$occurrence_timestamp = strtotime( sprintf( '%04d-%02d-%02d', $occurrence_year, $month, $day ) );

		$upcoming_birthdays[] = array(
			'post_id'               => $post_id,
			'title'                 => get_the_title( $post_id ),
			'permalink'             => get_permalink( $post_id ),
			'post_type'             => $post_type,
			'post_type_label'       => isset( $post_type_labels[ $post_type ] ) ? $post_type_labels[ $post_type ] : $post_type,
			'month'                 => $month,
			'day'                   => $day,
			'sort_key'              => ( $mmdd >= $today_mmdd ) ? $mmdd : ( $mmdd + 1231 ),
			'occurrence_timestamp'  => $occurrence_timestamp,
			'month_separator_label' => wp_date( 'F', $occurrence_timestamp ),
		);
	}

	wp_reset_postdata();
}

usort(
	$upcoming_birthdays,
	static function ( $a, $b ) {
		if ( $a['sort_key'] === $b['sort_key'] ) {
			return strcmp( $a['title'], $b['title'] );
		}

		return $a['sort_key'] <=> $b['sort_key'];
	}
);

$today_date_key = wp_date( 'Y-m-d', $today_timestamp );
$todays_birthdays = array();
$future_birthdays = array();

foreach ( $upcoming_birthdays as $birthday ) {
	$birthday_date_key = wp_date( 'Y-m-d', $birthday['occurrence_timestamp'] );

	if ( $birthday_date_key === $today_date_key ) {
		$todays_birthdays[] = $birthday;
	} else {
		$future_birthdays[] = $birthday;
	}
}


?>
<main id="main" class="site-main">
	<div class="cabinet-content birthdays-content">
		<h1 class="section-title">🎂 Upcoming Birthdays 🎂</h1>

		<?php if ( ! empty( $todays_birthdays ) ) : ?>
			<div class="todays-birthdays">
				<h2 class="birthdays-today-title">Today's Birthdays <span class="birthdays-today-date"><?php echo esc_html( wp_date( 'j F', $today_timestamp ) ); ?></span></h2>
				<?php foreach ( $todays_birthdays as $birthday ) : ?>
					<article class="birthday-item birthday-item-today <?php echo esc_attr( $birthday['post_type'] ); ?>">
						<?php if (get_post_thumbnail_id( $birthday['post_id'] )) : ?>
							<div class="birthday-thumbnail">
								<a href="<?php echo esc_url( $birthday['permalink'] ); ?>">
									<?php echo get_the_post_thumbnail( $birthday['post_id'], 'md_cover_archive' ); ?>
								</a>
							</div>
						<?php endif; ?>
						<div class="birthday-title">
							<a href="<?php echo esc_url( $birthday['permalink'] ); ?>"><?php echo esc_html( $birthday['title'] ); ?></a>
							<span class="birthday-post-type"><?php echo esc_html( $birthday['post_type_label'] ); ?></span>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $future_birthdays ) ) : ?>
			<div class="birthdays-list">
				<?php
				$last_month = '';
				$last_date_key = '';

				foreach ( $future_birthdays as $birthday ) :
					$current_date_key = wp_date( 'Y-m-d', $birthday['occurrence_timestamp'] );
					$show_date = $current_date_key !== $last_date_key;
					$last_date_key = $current_date_key;

					if ( $birthday['month_separator_label'] !== $last_month ) :
						$last_month = $birthday['month_separator_label'];
						?>
						<h2 class="birthdays-month-separator"><?php echo esc_html( $last_month ); ?></h2>
					<?php endif; ?>

					<article class="birthday-item <?php echo esc_attr( $birthday['post_type'] ); ?>">
						<?php if ( $show_date ) : ?>
							<div class="birthday-date">
								<span class="birthday-day-month"><?php echo esc_html( wp_date( 'j F', $birthday['occurrence_timestamp'] ) ); ?></span>
							</div>
						<?php endif; ?>
						<div class="birthday-thumbnail game-cover" data-post-type="<?php echo esc_attr( $birthday['post_type'] ); ?>">
							<?php if (get_post_thumbnail_id( $birthday['post_id'] )) : ?>
								<a href="<?php echo esc_url( $birthday['permalink'] ); ?>">
									<?php echo get_the_post_thumbnail( $birthday['post_id'], 'md_cover' ); ?>
								</a>
							<?php endif; ?>
						</div>
						<div class="birthday-title">
							<a href="<?php echo esc_url( $birthday['permalink'] ); ?>"><?php echo esc_html( $birthday['title'] ); ?> (<?php echo esc_html( $birthday_year ); ?>)</a>
							<span class="birthday-post-type"><?php echo esc_html( $birthday['post_type_label'] ); ?></span>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		<?php elseif ( empty( $todays_birthdays ) ) : ?>
			<p>No birthdays found for Mega Drive, Mega CD, or 32X.</p>
		<?php endif; ?>
	</div>
</main>

<?php get_template_part( 'template-parts/showcase' ); ?>

<?php
get_footer();