<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package LQ Berita
 */

?>

			<footer id="colophon" class="site-footer">
				<div class="site-info">
					<div class="footer-widget">
						<div class="footerone">
							<?php 
								do_action( 'berita_footer_one' );								
							?>
						</div>
						<div class="footertwo">
							<?php 
								do_action( 'berita_footer_two' );								
							?>
						</div>
						<div class="webinfo">
							<?php
								echo '<div class="by-follow">';
									echo '<ul class="social-icon">';
										do_action( 'social_icon' );
									echo '</ul>';
								echo '</div>';
							?>
						</div>
					</div>
				</div>
				<div class="by-copyright">
					<div class="menufooter">
						<nav class="menu-footer-container" role="navigation" aria-label="footer" <?php echo berita_itemtype_schema( 'SiteNavigationElement' ); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>>    
							<?php
									wp_nav_menu(
										array(
											'theme_location' => 'footer',
											'menu_class'     => 'by-menu',
											'link_before'    => '<span itemprop="name">',
											'link_after'     => '</span>',
										)
									);
							?>
						</nav>
					</div>
					<div class="copyright">
						<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'lq-berita' ) ); ?>">
							<?php
							/* translators: %s: CMS name, i.e. WordPress. */
							printf( esc_html__( 'Proudly powered by %s', 'lq-berita' ), 'WordPress' );
							?>
						</a>
					</div>
				</div><!-- .by-copyright -->
			</footer><!-- #colophon -->
		</div>
	</diV>
</div><!-- #page -->


<?php wp_footer(); ?>

</body>
</html>
