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

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'dekiru' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="header-content">
			<a href="<?php echo home_url(); ?>" title="Return to the homepage" class="logo">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.svg"
					width="120" height="120" alt="<?php echo get_bloginfo('name'); ?>"
					class="logo-image"
				>
			</a>

			<nav id="site-navigation" class="main-navigation">
				<button name="menu" class="hamburger menu-toggle hamburger--squeeze" type="button" aria-controls="primary-menu" aria-expanded="false" title="Menu">
					<span class="hamburger-box">
						<span class="hamburger-inner"><strong>Menu</strong></span>
					</span>
				</button>

				<?php
					wp_nav_menu( array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'primary-menu',
					) );

					get_template_part( 'template-parts/partial', 'social' );
				?>
			
			</nav>
		</div>
	</header>

	<div id="content" class="site-content">
