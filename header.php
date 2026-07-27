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

$platform = get_post_type();
$game_title = strtolower( get_the_title() );
$publisher = strtolower( get_field('publisher') );

$body_class = 'platform-' . sanitize_title( $platform ) . ' game-' . sanitize_title( $game_title ) . ' publisher-' . sanitize_title( $publisher );

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
			<a href="<?php echo home_url(); ?>" title="Return to the homepage" class="logo">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/images/megadriveme.svg"
					width="120" height="120" alt="<?php echo get_bloginfo('name'); ?>"
					class="logo-image"
				>
			</a>

			<div class="search">
				<?php get_search_form(); ?>
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
