<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package LQ Berita
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'lq-berita' ); ?></a>
	<div id="page" class="flex-container"> <!-- #flex container -->
    	<div class="container">
		<?php if ( wp_is_mobile() ) { ?>
        <header id="masthead" class="site-header-mobile">
			<div class="column-auto item-mobile-left">
				<div class="site-branding-mobile">
					<?php
						$custom_logo_id = get_theme_mod( 'custom_logo' );
						$logo           = wp_get_attachment_image_src( $custom_logo_id, 'full' );
						$desc           = get_bloginfo( 'name', 'display' );
						if($custom_logo_id == NULL){
					?>
						<div class="site-nologo-mobile">
							<?php $heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div'; ?>
							<<?php echo $heading_tag; ?> class="site-title">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
							</<?php echo $heading_tag; ?>>
							<div class="site-description"><?php bloginfo( 'description' ); ?></div>
						</div>
						<?php
						}else{ 
							echo '<a class="custom-logo-link" href="' . esc_url( get_home_url() ) . '" title="' . esc_html( $desc ) . '" rel="home">';
							echo '<img class="custom-logo" src="' . esc_url( $logo[0] ) . '" width="' . (int) $logo[1] . '" height="' . (int) $logo[2] . '" alt="' . esc_html( $desc ) . '" loading="lazy" title="'. esc_attr( get_bloginfo( 'name', 'display' ) ) .'"/>';
							echo '</a>';
						}
					?>
					
				</div>
           </div>
		   <div class="header-search">
					<?php 
						echo '<form method="get" class="search-form" action="' . esc_url( home_url( '/' ) ) . '">
							<input class="search-field" type="text" name="s" id="s" placeholder="' . esc_html__( 'Search for news', 'lq-berita' ) . '" />
							<button type="submit" class="search-submit"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></g></svg></button>
						</form>';
					?>
				</div>
		   <div class="column-auto item-mobile-right">
		   		<div id="mySidenav" class="sidenav">
					<div class="sidenav-mobile-branding">
						<?php
							$custom_logo_id = get_theme_mod( 'custom_logo' );
							$logo           = wp_get_attachment_image_src( $custom_logo_id, 'full' );
							$desc           = get_bloginfo( 'name', 'display' );
							if($custom_logo_id == NULL){
						?>	
							<div class="sidenav-nologo-mobile">
								<?php $heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div'; ?>
								<<?php echo $heading_tag; ?> class="sidenav-title">
									<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
								</<?php echo $heading_tag; ?>>
								<div class="site-description"><?php bloginfo( 'description' ); ?></div>
							</div>
							<?php
							}else{
								echo '<a class="custom-logo-link" href="' . esc_url( get_home_url() ) . '" title="' . esc_html( $desc ) . '" rel="home">';
								echo '<img class="custom-logo" src="' . esc_url( $logo[0] ) . '" width="' . (int) $logo[1] . '" height="' . (int) $logo[2] . '" alt="' . esc_html( $desc ) . '" loading="lazy" title="'. esc_attr( get_bloginfo( 'name', 'display' ) ) .'"/>';
								echo '</a>';
								
							}
						?>
					</div>
					<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
					<?php
						wp_nav_menu(
							array(
								'theme_location' 	=> 'mobile',
								'menu_id'        	=> '',
								'container_class'   => '',
								'container'         => '',
							)
						);
					?>
				</div>
				<div class="lqb-topnavresponsive-menu">
					<a href="#" onclick="openNav()">
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z" fill="currentColor"/></svg>
					</a>
				</div>
			</div>
		</header>
		<nav class="mobile-medium" role="navigation" aria-label="Navigation Menu" <?php echo berita_itemtype_schema( 'SiteNavigationElement' ); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>>
					<?php
						wp_nav_menu(
							array(
								'theme_location' 	=> 'primary',
								'menu_id'        	=> '',
								'container_class'   => '',
								'container'         => '',
								'menu_class'        => 'navigation-medium',
								'menu_id'        	=> '',
								'link_before'    => '<span itemprop="name">',
								'link_after'     => '</span>',
							)
						);
					?>
		</nav>
		
		<?php }else{ ?>
			<header id="masthead" class="site-header">
				<div class="site-logo">
					<div class="column-auto-menu item-menu-left">
						<div class="site-branding">
							<?php
								$custom_logo_id = get_theme_mod( 'custom_logo' );
								$logo           = wp_get_attachment_image_src( $custom_logo_id, 'full' );
								$desc           = get_bloginfo( 'name', 'display' );
								if($custom_logo_id == NULL){
							?>
								<div class="site-nologo">
									<?php $heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div'; ?>
									<<?php echo $heading_tag; ?> class="site-title">
										<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
									</<?php echo $heading_tag; ?>>
									<div class="site-description"><?php bloginfo( 'description' ); ?></div>
								</div>
								<?php
								}else{
									echo '<a class="custom-logo-link" href="' . esc_url( get_home_url() ) . '" title="' . esc_html( $desc ) . '" rel="home">';
									echo '<img class="custom-logo" src="' . esc_url( $logo[0] ) . '" width="' . (int) $logo[1] . '" height="' . (int) $logo[2] . '" alt="' . esc_html( $desc ) . '" loading="lazy" title="'. esc_attr( get_bloginfo( 'name', 'display' ) ) .'"/>';
									echo '</a>';
								}
							?>
							
						</div><!-- .site-branding -->
					</div>
					<div class="column-auto-menu item-menu-right">
						
						<nav id="site-navigation-web" role="navigation" aria-label="Navigation Menu" class="menu-navigation" <?php echo berita_itemtype_schema( 'SiteNavigationElement' ); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>>
						<?php
							wp_nav_menu(
								array(
									'theme_location' => 'primary',
									'menu_id'        => '',
									'menu_class'        => 'primary-menu',
									'link_before'    => '<span itemprop="name">',
									'link_after'     => '</span>',
								)
							);
						?>				
						</nav><!-- #site-navigation -->

					</div>
				</div>
				
			</header><!-- #masthead -->
		<?php } ?>
		<div class="widget_block">
			<figure class="banner-image size-large">
				<?php the_header_image_tag( array( 'width' => '1024', 'flex-width'  => true, ) ); ?>
			</figure>
		</div>
		<?php do_action( 'berita_undermenu' ); ?>