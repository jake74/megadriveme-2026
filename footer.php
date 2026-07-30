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
  
	<footer class="site-footer" role="contentinfo">
		<div class="footer-content">
			<div class="logo">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_attr_e( 'Return to the homepage', 'dekiru' ); ?>" class="logo">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/megadriveme.svg' ); ?>"
						width="120" height="120" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"
						class="logo-image" loading="lazy"
					>
				</a>
			</div>

			<div class="copy">
				<p>©2011—<?php echo esc_html( date_i18n( 'Y' ) ); ?> MegaDrive.me. All trademarks are copyright of their respective owners. The MegaDrive.Me site is not affiliated with Sega.</p>
			</div>

			<div class="credits">
				<p>Site designed and built by <a href="https://bsky.app/profile/jake74.bsky.social">@jake74</a> at <a href="https://dekiru.gg" title="DEKIRU. Website design and build for indie games studios."><span class="dekiru">DEKIRU</span></a>. Contributors &amp; credits.</p>
			</div>
		</div>
	</footer>

</div>

<?php wp_footer(); ?>

</body>
</html>
