<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package dekiru
 */

?>

	</div>

	<footer class="site-footer" role="contentinfo">
		<div class="footer-content">
			<div class="logo">
				<a href="<?php echo home_url(); ?>" title="Return to the homepage" class="logo">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/images/megadriveme.svg"
						width="120" height="120" alt="<?php echo get_bloginfo('name'); ?>"
						class="logo-image" loading="lazy"
					>
				</a>
			</div>

			<div class="copy">
				<p>©2011—<?php echo date('Y'); ?> MegaDrive.me. All trademarks are copyright of their respective owners. The MegaDrive.Me site is not affiliated with Sega.</p>
				<p>Site by <a href="https://bsky.app/profile/jake74.bsky.social">@jake74</a>. Contributors &amp; credits.</p>
			</div>

			<?php get_template_part( 'template-parts/partial', 'social' ); ?>
		</div>
	</footer>

</div>

<?php wp_footer(); ?>

</body>
</html>
