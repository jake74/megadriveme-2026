<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package dekiru
 */

$body_class = '';
$game_title = '';
$publisher = '';
$platform = get_post_type();
$post_type = get_post_type();

if ( $post_type === 'mega-drive' || $post_type === 'mega-cd' || $post_type === '32x' ) {
	$game_title = strtolower( get_the_title() );
	$publisher = strtolower( get_field('publisher') );
	$body_class = 'platform-' . sanitize_title( $platform ) . ' game-' . sanitize_title( $game_title ) . ' publisher-' . sanitize_title( $publisher );
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class( $body_class ); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'dekiru' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="header-content">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_attr_e( 'Return to the homepage', 'dekiru' ); ?>" class="logo">
				<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/megadriveme.svg' ); ?>" width="132" height="86" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="logo-image" loading="lazy">
			</a>

			<div class="search">
				<?php
					$args = array(
						'post_type' => array( 'post', 'page' ),
						'echo'      => true,
					);
					
					// Add custom post types to search
					$post_types = get_post_types( array( 'public' => true, '_builtin' => false ), 'names' );
					$args['post_type'] = array_merge( $args['post_type'], $post_types );
					
					get_search_form( $args['echo'] );
				?>
			</div>

			<nav id="site-navigation" class="main-navigation">

				<?php
					wp_nav_menu( array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'primary-menu',
					) );

					// get_template_part( 'template-parts/partial', 'social' );
				?>
			
			</nav>
		</div>
	</header>
