<?php
/**
 * dekiru Academy functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package dekiru
 */

if ( ! function_exists( 'dekiru_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function dekiru_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on dekiru Academy, use a find and replace
		 * to change 'dekiru' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'dekiru', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'dekiru' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		// add_theme_support( 'html5', array(
		// 	'search-form',
		// 	'comment-form',
		// 	'comment-list',
		// 	'gallery',
		// 	'caption',
		// ) );

		// Set up the WordPress core custom background feature.
		// add_theme_support( 'custom-background', apply_filters( 'dekiru_custom_background_args', array(
		// 	'default-color' => 'ffffff',
		// 	'default-image' => '',
		// ) ) );

		// Add theme support for selective refresh for widgets.
		// add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		// add_theme_support( 'custom-logo', array(
		// 	'height'      => 250,
		// 	'width'       => 250,
		// 	'flex-width'  => true,
		// 	'flex-height' => true,
		// ) );
	}
endif;
add_action( 'after_setup_theme', 'dekiru_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function dekiru_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'dekiru_content_width', 960 );
}
add_action( 'after_setup_theme', 'dekiru_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
// function dekiru_widgets_init() {
// 	register_sidebar( array(
// 		'name'          => esc_html__( 'Sidebar', 'dekiru' ),
// 		'id'            => 'sidebar-1',
// 		'description'   => esc_html__( 'Add widgets here.', 'dekiru' ),
// 		'before_widget' => '<section id="%1$s" class="widget %2$s">',
// 		'after_widget'  => '</section>',
// 		'before_title'  => '<h2 class="widget-title">',
// 		'after_title'   => '</h2>',
// 	) );
// }
// add_action( 'widgets_init', 'dekiru_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function dekiru_scripts() {

	wp_deregister_script('jquery');
	wp_enqueue_script('jquery', get_template_directory_uri() . '/js/vendor/jquery-4.0.0.min.js', array(), null, true);

	wp_enqueue_script('color-thief-script', get_template_directory_uri() . '/js/vendor/color-thief.global.js', array(), null, true);

	wp_enqueue_script('swiper-script', get_template_directory_uri() . '/js/vendor/swiper-bundle.min.js', array(), null, true);
	wp_enqueue_style( 'swiper-style', get_template_directory_uri() . '/js/vendor/swiper-bundle.min.css' );
	/* 
		wp_enqueue_script( 'magnifique-scripts', get_template_directory_uri() . '/js/vendor/jquery.magnific-popup-edit.js', array(), null, true );
	*/

	wp_enqueue_script( 'dekiru-scripts', get_template_directory_uri() . '/js/min/scripts.min.js', array(), null, true );

	if ( is_page_template( 'template-home.php' ) ) {
		wp_enqueue_script( 'dekiru-home-random', get_template_directory_uri() . '/js/home-random.js', array(), null, true );
		wp_localize_script(
			'dekiru-home-random',
			'dekiruHomeRandom',
			array(
				'endpoint' => esc_url_raw( rest_url( 'mdme/v1/random-games' ) ),
			)
		);
	}

	if ( is_page_template( 'template-birthdays.php' ) ) {
		wp_enqueue_script( 'dekiru-birthdays', get_template_directory_uri() . '/js/birthdays.js', array(), null, true );
		wp_localize_script(
			'dekiru-birthdays',
			'dekiruBirthdays',
			array(
				'endpoint' => esc_url_raw( rest_url( 'mdme/v1/birthdays' ) ),
			)
		);
	}

	wp_enqueue_style( 'dekiru-style', get_stylesheet_uri() );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'dekiru_scripts' );

/**
 * Registers public REST endpoint for random home page game cards.
 */
function dekiru_register_random_games_route() {
	register_rest_route(
		'mdme/v1',
		'/random-games',
		array(
			'methods'             => 'GET',
			'callback'            => 'dekiru_get_random_games',
			'permission_callback' => '__return_true',
		)
	);
}
add_action( 'rest_api_init', 'dekiru_register_random_games_route' );

/**
 * Registers public REST endpoint for birthdays JSON.
 */
function dekiru_register_birthdays_route() {
	register_rest_route(
		'mdme/v1',
		'/birthdays',
		array(
			'methods'             => 'GET',
			'callback'            => 'dekiru_get_birthdays_json',
			'permission_callback' => '__return_true',
		)
	);
}
add_action( 'rest_api_init', 'dekiru_register_birthdays_route' );

/**
 * Build a REST response for random games with cache headers.
 *
 * @param array $data     Response data.
 * @param int   $status   HTTP status code.
 * @param bool  $cacheable Whether response should be cacheable.
 *
 * @return WP_REST_Response
 */
function dekiru_random_games_response( array $data, $status = 200, $cacheable = true ) {
	$response = new WP_REST_Response( $data, $status );

	if ( $cacheable ) {
		$response->header( 'Cache-Control', 'public, max-age=900, s-maxage=900, stale-while-revalidate=60' );
	} else {
		$response->header( 'Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0' );
	}

	return $response;
}

/**
 * Build a REST response for birthdays JSON with cache headers.
 *
 * @param array $data      Response data.
 * @param int   $status    HTTP status code.
 * @param bool  $cacheable Whether response should be cacheable.
 *
 * @return WP_REST_Response
 */
function dekiru_birthdays_response( array $data, $status = 200, $cacheable = true ) {
	$response = new WP_REST_Response( $data, $status );

	if ( $cacheable ) {
		$response->header( 'Cache-Control', 'public, max-age=900, s-maxage=900, stale-while-revalidate=60' );
	} else {
		$response->header( 'Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0' );
	}

	return $response;
}

/**
 * Builds birthdays data for the configured months-ahead window.
 *
 * @param int $months_ahead_limit Months ahead to include.
 *
 * @return array
 */
function dekiru_build_birthdays_data( $months_ahead_limit ) {
	$today_timestamp = current_time( 'timestamp' );
	$today_mmdd = (int) wp_date( 'md', $today_timestamp );
	$current_year = (int) wp_date( 'Y', $today_timestamp );
	$today_date_key = wp_date( 'Y-m-d', $today_timestamp );
	$range_end_timestamp = strtotime( '+' . $months_ahead_limit . ' months', $today_timestamp );

	$post_type_labels = array(
		'mega-drive' => 'Mega Drive',
		'mega-cd'    => 'Mega CD',
		'32x'        => '32X',
	);

	$query = new WP_Query(
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

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();

			$post_id = get_the_ID();
			$post_type = get_post_type( $post_id );
			$original_timestamp = get_post_time( 'U', false, $post_id );

			$month = (int) wp_date( 'n', $original_timestamp );
			$day = (int) wp_date( 'j', $original_timestamp );
			$birthday_year = (int) wp_date( 'Y', $original_timestamp );
			$mmdd = (int) wp_date( 'md', $original_timestamp );

			$occurrence_year = ( $mmdd >= $today_mmdd ) ? $current_year : $current_year + 1;
			$occurrence_timestamp = strtotime( sprintf( '%04d-%02d-%02d', $occurrence_year, $month, $day ) );

			$thumbnail_id = get_post_thumbnail_id( $post_id );

			$upcoming_birthdays[] = array(
				'post_id'               => $post_id,
				'title'                 => get_the_title( $post_id ),
				'permalink'             => get_permalink( $post_id ),
				'post_type'             => $post_type,
				'post_type_label'       => isset( $post_type_labels[ $post_type ] ) ? $post_type_labels[ $post_type ] : $post_type,
				'birthday_year'         => $birthday_year,
				'sort_key'              => ( $mmdd >= $today_mmdd ) ? $mmdd : ( $mmdd + 1231 ),
				'occurrence_timestamp'  => $occurrence_timestamp,
				'month_separator_label' => wp_date( 'F', $occurrence_timestamp ),
				'has_thumbnail'         => ! empty( $thumbnail_id ),
				'thumbnail_archive_url' => $thumbnail_id ? wp_get_attachment_image_url( $thumbnail_id, 'md_cover_archive' ) : '',
				'thumbnail_future_url'  => $thumbnail_id ? wp_get_attachment_image_url( $thumbnail_id, 'md_cover' ) : '',
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

	$todays_birthdays = array();
	$future_birthdays = array();
	$last_month = '';
	$last_date_key = '';

	foreach ( $upcoming_birthdays as $birthday ) {
		$current_date_key = wp_date( 'Y-m-d', $birthday['occurrence_timestamp'] );

		if ( $current_date_key === $today_date_key ) {
			$todays_birthdays[] = $birthday;
			continue;
		}

		if ( $birthday['occurrence_timestamp'] > $range_end_timestamp ) {
			continue;
		}

		$entry = $birthday;
		$entry['show_month_separator'] = $entry['month_separator_label'] !== $last_month;
		$entry['show_date'] = $current_date_key !== $last_date_key;
		$entry['day_month_label'] = wp_date( 'j F', $entry['occurrence_timestamp'] );

		$last_month = $entry['month_separator_label'];
		$last_date_key = $current_date_key;

		$future_birthdays[] = $entry;
	}

	return array(
		'today' => array(
			'date_label' => wp_date( 'j F', $today_timestamp ),
			'items'      => $todays_birthdays,
		),
		'future' => array(
			'items' => $future_birthdays,
		),
	);
}

/**
 * Returns birthdays JSON for client-side rendering.
 *
 * @param WP_REST_Request $request REST request.
 *
 * @return WP_REST_Response
 */
function dekiru_get_birthdays_json( WP_REST_Request $request ) {
	$months_ahead_limit = absint( $request->get_param( 'months_ahead' ) );
	$allowed_month_limits = array( 3, 4, 6, 12 );

	if ( ! in_array( $months_ahead_limit, $allowed_month_limits, true ) ) {
		$months_ahead_limit = 6;
	}

	$today_key = wp_date( 'Ymd', current_time( 'timestamp' ) );
	$cache_key = 'dekiru_birthdays_json_' . $today_key . '_' . $months_ahead_limit;
	$cached = get_transient( $cache_key );

	if ( false !== $cached ) {
		return dekiru_birthdays_response( $cached );
	}

	$data = array(
		'months_ahead' => $months_ahead_limit,
		'data'         => dekiru_build_birthdays_data( $months_ahead_limit ),
	);

	set_transient( $cache_key, $data, 15 * MINUTE_IN_SECONDS );

	return dekiru_birthdays_response( $data );
}

/**
 * Purges all random game transients used by the home REST endpoint.
 */
function dekiru_purge_random_games_cache() {
	$post_types = array( 'mega-drive', 'mega-cd', '32x' );

	foreach ( $post_types as $post_type ) {
		for ( $posts_per_page = 1; $posts_per_page <= 24; $posts_per_page++ ) {
			delete_transient( 'dekiru_random_' . $post_type . '_' . $posts_per_page );
		}
	}

	$allowed_month_limits = array( 3, 4, 6, 12 );
	$today_key = wp_date( 'Ymd', current_time( 'timestamp' ) );
	$yesterday_key = wp_date( 'Ymd', strtotime( '-1 day', current_time( 'timestamp' ) ) );

	foreach ( $allowed_month_limits as $months_ahead_limit ) {
		delete_transient( 'dekiru_birthdays_json_' . $today_key . '_' . $months_ahead_limit );
		delete_transient( 'dekiru_birthdays_json_' . $yesterday_key . '_' . $months_ahead_limit );
	}
}

/**
 * Adds cache management widget to WP Dashboard.
 */
function dekiru_register_cache_dashboard_widget() {
	if ( current_user_can( 'manage_options' ) ) {
		wp_add_dashboard_widget(
			'dekiru_cache_bust_widget',
			'Home And Birthdays Cache',
			'dekiru_render_cache_dashboard_widget'
		);
	}
}
add_action( 'wp_dashboard_setup', 'dekiru_register_cache_dashboard_widget' );

/**
 * Renders the cache bust action button on the dashboard.
 */
function dekiru_render_cache_dashboard_widget() {
	if ( isset( $_GET['dekiru_cache_purged'] ) && '1' === $_GET['dekiru_cache_purged'] ) {
		echo '<p><strong>Home random and birthdays cache cleared.</strong></p>';
	}
	?>
	<p>Clear cached home random game blocks and birthdays JSON endpoint data.</p>
	<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<input type="hidden" name="action" value="dekiru_purge_random_games_cache" />
		<?php wp_nonce_field( 'dekiru_purge_random_games_cache_action', 'dekiru_purge_random_games_cache_nonce' ); ?>
		<?php submit_button( 'Bust Random Cache', 'secondary', 'submit', false ); ?>
	</form>
	<?php
}

/**
 * Handles dashboard cache bust action.
 */
function dekiru_handle_purge_random_games_cache() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'You are not allowed to do this.' );
	}

	check_admin_referer( 'dekiru_purge_random_games_cache_action', 'dekiru_purge_random_games_cache_nonce' );

	dekiru_purge_random_games_cache();

	wp_safe_redirect( add_query_arg( 'dekiru_cache_purged', '1', admin_url( 'index.php' ) ) );
	exit;
}
add_action( 'admin_post_dekiru_purge_random_games_cache', 'dekiru_handle_purge_random_games_cache' );

/**
 * Returns HTML cards for a random set of games by post type.
 *
 * @param WP_REST_Request $request REST request.
 *
 * @return WP_REST_Response
 */
function dekiru_get_random_games( WP_REST_Request $request ) {
	$allowed_post_types = array( 'mega-drive', 'mega-cd', '32x' );
	$post_type = sanitize_key( (string) $request->get_param( 'post_type' ) );
	$posts_per_page = absint( $request->get_param( 'posts_per_page' ) );

	if ( ! in_array( $post_type, $allowed_post_types, true ) ) {
		return dekiru_random_games_response(
			array(
				'html'    => '',
				'message' => 'Invalid post type.',
			),
			400,
			false
		);
	}

	if ( $posts_per_page < 1 || $posts_per_page > 24 ) {
		$posts_per_page = 6;
	}

	$cache_key = 'dekiru_random_' . $post_type . '_' . $posts_per_page;
	$cached = get_transient( $cache_key );

	if ( false !== $cached ) {
		return dekiru_random_games_response(
			array(
				'html'    => $cached,
				'message' => '',
			)
		);
	}

	$query = new WP_Query(
		array(
			'post_type'      => $post_type,
			'post_status'    => 'publish',
			'orderby'        => 'rand',
			'posts_per_page' => $posts_per_page,
			'no_found_rows'  => true,
			'meta_query'     => array(
				array(
					'key' => '_thumbnail_id',
				),
			),
		)
	);

	ob_start();

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();

			$type = get_post_type();
			$type_object = get_post_type_object( $type );
			$type_label = $type_object && isset( $type_object->labels->menu_name ) ? $type_object->labels->menu_name : $type;
			$cover_class = 'cover-md';
			$thumb_size = 'showcase';

			if ( 'mega-cd' === $type ) {
				$cover_class = 'cover-mega-cd';
				$thumb_size = 'showcase_cd';
			} elseif ( '32x' === $type ) {
				$cover_class = 'cover-32x';
			}
			?>
			<a href="<?php the_permalink(); ?>" class="<?php echo esc_attr( $cover_class ); ?> game-cover" data-post-type="<?php echo esc_attr( $type_label ); ?>">
				<?php the_post_thumbnail( $thumb_size, array( 'alt' => the_title_attribute( array( 'echo' => false ) ) ) ); ?>
				<div class="entry-header">
					<?php the_title( '<p class="entry-title">', '</p>' ); ?>
				</div>
			</a>
			<?php
		}
	} else {
		echo '<p>No games found.</p>';
	}

	wp_reset_postdata();

	$html = trim( ob_get_clean() );
	set_transient( $cache_key, $html, 15 * MINUTE_IN_SECONDS );

	return dekiru_random_games_response(
		array(
			'html'    => $html,
			'message' => '',
		)
	);
}

/**
 * Implement the Custom Header feature.
 */
// require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
// require get_template_directory() . '/inc/customizer.php';

/**
 * Custom image sizes.
 */
require get_template_directory() . '/inc/custom-image-sizes.php';

/**
 * Custom post types.
 */
require get_template_directory() . '/inc/custom-post-types.php';

/**
 * ACF local JSON admin tools.
 */
require get_template_directory() . '/inc/acf-tools.php';
