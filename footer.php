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
					<img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.svg"
						width="120" height="120" alt="<?php echo get_bloginfo('name'); ?>"
						class="logo-image" loading="lazy"
					>
				</a>
			</div>

			<div class="copy">
				&copy;<?php echo date('Y'); ?>  CLIENT NAME. All rights reserved.<br>
				<span class="credits">Site design and build by <a href="https://dekiru.gg" title="Dekiru. Website design and build for indie games studios.">Dekiru</a></span>
			</div>

			<?php get_template_part( 'template-parts/partial', 'social' ); ?>
		</div>
	</footer>

</div>

<?php wp_footer(); ?>

</body>
</html>
