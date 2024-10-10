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
							$custom_logo_id = get_theme_mod( 'custom_logo' );
							$logo           = wp_get_attachment_image_src( $custom_logo_id, 'full' );
							$desc           = get_bloginfo( 'name', 'display' );
							if($custom_logo_id == NULL){
						?>
							<div class="footer-nologo">
								<?php $heading_tag = ( is_home() || is_front_page() ) ? 'h3' : 'div'; ?>
								<<?php echo $heading_tag; ?> class="footer-title">
									<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
								</<?php echo $heading_tag; ?>>
								<div class="footer-description"><?php bloginfo( 'description' ); ?></div>
							</div>
							<?php
							}else{ 
								echo '<a class="custom-logo-link" href="' . esc_url( get_home_url() ) . '" title="' . esc_html( $desc ) . '" rel="home">';
								echo '<img class="custom-logo" src="' . esc_url( $logo[0] ) . '" width="' . (int) $logo[1] . '" height="' . (int) $logo[2] . '" alt="' . esc_html( $desc ) . '" loading="lazy" title="'. esc_attr( get_bloginfo( 'name', 'display' ) ) .'"/>';
								echo '</a>';
							?>
								<div class="footer-nologo">
									<div class="footer-description"><?php bloginfo( 'description' ); ?></div>
								</div>
							<?php	
							}
						?>
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
