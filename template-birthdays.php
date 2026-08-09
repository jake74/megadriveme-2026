<?php
/**
 * Template Name: Birthdays
 *
 * @package dekiru
 */

get_header();

// Change this to 3, 4, 6, or 12 to control how far ahead future birthdays are shown.
$months_ahead_limit = 3;
$allowed_month_limits = array( 3, 4, 6, 12 );
if ( ! in_array( $months_ahead_limit, $allowed_month_limits, true ) ) {
	$months_ahead_limit = 6;
}
?>
<main id="main" class="site-main">
	<div class="cabinet-content birthdays-content">
		<h1 class="section-title">🎂 Upcoming Birthdays 🎂</h1>
		<div class="js-birthdays-root" data-months-ahead="<?php echo esc_attr( $months_ahead_limit ); ?>">
			<p>Loading birthdays...</p>
		</div>

		<noscript>
			<?php
			$fallback_days = 30;
			$fallback_end_timestamp = strtotime( '+' . $fallback_days . ' days', current_time( 'timestamp' ) );
			$fallback_data = dekiru_build_birthdays_data( 12 );
			$fallback_items = array();

			if ( isset( $fallback_data['today']['items'] ) && is_array( $fallback_data['today']['items'] ) ) {
				$fallback_items = array_merge( $fallback_items, $fallback_data['today']['items'] );
			}

			if ( isset( $fallback_data['future']['items'] ) && is_array( $fallback_data['future']['items'] ) ) {
				$fallback_items = array_merge( $fallback_items, $fallback_data['future']['items'] );
			}

			$fallback_items = array_values(
				array_filter(
					$fallback_items,
					static function ( $item ) use ( $fallback_end_timestamp ) {
						if ( ! isset( $item['occurrence_timestamp'] ) ) {
							return false;
						}

						return (int) $item['occurrence_timestamp'] <= $fallback_end_timestamp;
					}
				)
			);
			?>

			<?php if ( ! empty( $fallback_items ) ) : ?>
				<div class="birthdays-fallback">
					<h2 class="birthdays-today-title">Next 30 Days</h2>
					<ul>
						<?php foreach ( $fallback_items as $item ) : ?>
							<li>
								<?php echo esc_html( wp_date( 'j F', (int) $item['occurrence_timestamp'] ) ); ?>:
								<a href="<?php echo esc_url( $item['permalink'] ); ?>"><?php echo esc_html( $item['title'] ); ?></a>
								(<?php echo esc_html( $item['post_type_label'] ); ?>)
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php else : ?>
				<p>No birthdays found in the next 30 days.</p>
			<?php endif; ?>
		</noscript>
	</div>
</main>

<?php get_template_part( 'template-parts/showcase' ); ?>

<?php
get_footer();