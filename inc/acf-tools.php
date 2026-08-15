<?php
/**
 * Admin tools for working with ACF local JSON field groups.
 *
 * @package dekiru
 */

/**
 * Adds a "Flush ACF Cache" dashboard widget for logged-in admins.
 */
function dekiru_acf_flush_dashboard_widget() {
	if ( ! current_user_can( 'manage_options' ) || ! function_exists( 'acf_get_local_json_files' ) ) {
		return;
	}

	wp_add_dashboard_widget(
		'dekiru-flush-acf-cache',
		'ACF Cache',
		'dekiru_render_acf_flush_dashboard_widget'
	);
}
add_action( 'wp_dashboard_setup', 'dekiru_acf_flush_dashboard_widget' );

/**
 * Renders the dashboard widget's button.
 */
function dekiru_render_acf_flush_dashboard_widget() {
	$url = wp_nonce_url( admin_url( 'admin-post.php?action=dekiru_flush_acf_cache' ), 'dekiru_flush_acf_cache' );
	?>
	<p><?php esc_html_e( 'Clears the ACF object cache so admin screens reflect the latest local JSON field settings.', 'dekiru' ); ?></p>
	<a href="<?php echo esc_url( $url ); ?>" class="button button-secondary"><?php esc_html_e( 'Flush ACF Cache', 'dekiru' ); ?></a>
	<p>
		<?php
		printf(
			/* translators: %s: link to the ACF Field Groups admin page. */
			esc_html__( 'If fields are still out of date after flushing, use the "Sync available" list on the %s page — do not import field groups programmatically, it can wipe field data.', 'dekiru' ),
			'<a href="' . esc_url( admin_url( 'edit.php?post_type=acf-field-group' ) ) . '">' . esc_html__( 'Field Groups', 'dekiru' ) . '</a>'
		);
		?>
	</p>
	<?php
}

/**
 * Handles the admin-post request: only clears ACF's runtime object cache.
 *
 * Deliberately does NOT call acf_import_field_group() here — doing so with an
 * incomplete field group array (acf_get_field_group() omits fields by default)
 * previously wiped every field from the database and local JSON. Use ACF's own
 * "Sync available" UI on the Field Groups admin page to import JSON changes.
 */
function dekiru_handle_flush_acf_cache() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You do not have permission to do this.', 'dekiru' ) );
	}

	check_admin_referer( 'dekiru_flush_acf_cache' );

	if ( function_exists( 'wp_cache_flush_group' ) ) {
		wp_cache_flush_group( 'acf' );
	} else {
		wp_cache_flush();
	}

	wp_safe_redirect( add_query_arg( 'acf_cache_flushed', 1, wp_get_referer() ? wp_get_referer() : admin_url() ) );
	exit;
}
add_action( 'admin_post_dekiru_flush_acf_cache', 'dekiru_handle_flush_acf_cache' );

/**
 * Shows a confirmation notice after the ACF cache has been flushed.
 */
function dekiru_acf_flush_admin_notice() {
	if ( ! isset( $_GET['acf_cache_flushed'] ) ) {
		return;
	}
	?>
	<div class="notice notice-success is-dismissible">
		<p><?php esc_html_e( 'ACF cache flushed and local JSON field groups re-synced.', 'dekiru' ); ?></p>
	</div>
	<?php
}
add_action( 'admin_notices', 'dekiru_acf_flush_admin_notice' );
