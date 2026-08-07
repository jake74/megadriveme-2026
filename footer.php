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

$notice = get_field('notice', 'options');
$credits = get_field('credits', 'options');

?>
  
	<footer class="site-footer" role="contentinfo">
		<div class="footer-content">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_attr_e( 'Return to the homepage', 'dekiru' ); ?>" class="footer-logo">
				<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/megadriveme.svg' ); ?>" width="120" height="120" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="logo-image" loading="lazy">
			</a>

			<div class="copy">
				<p>©2011—<?php echo esc_html( date_i18n( 'Y' ) ); ?> MegaDrive.me.</p>
				<?php if ($notice) : echo $notice; endif; ?>
			</div>

			<div class="credits">
				<?php /*<p>Site designed and built by <a href="https://bsky.app/profile/jake74.bsky.social" rel="nofollow">@jake74</a> at <a href="https://dekiru.gg" title="DEKIRU. Website design and build for indie games studios."><span class="dekiru">DEKIRU</span></a>. Scans by Jake. Photography by <a href="https://bsky.app/profile/damienmcferran.bsky.social" rel="nofollow">Damien McFerran</a>.</p> */ ?>
				<?php if ($credits) : echo $credits; endif; ?>
			</div>
		</div>
	</footer>

</div>

<?php wp_footer(); ?>

</body>
</html>
