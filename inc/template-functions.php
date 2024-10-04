<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package LQ Berita
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function berita_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'berita_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function berita_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'berita_pingback_header' );

if ( ! function_exists( 'berita_home_post' ) ) {
	
	
	function berita_home_post() {
		global $post;
		$args = array(
			'post_type'              => 'post',
			'showposts'              => 3,
			'post_status'            => 'publish',
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
			'no_found_rows'          => true,
			'ignore_sticky_posts'    => true,
			'post__in'            	 => get_option( 'sticky_posts' ),
		);
		
		
		$recent = get_posts( $args );
		if ( $recent ) :
			?>
			
			<?php
			$count = 1;
			foreach ( $recent as $post ) :
				setup_postdata( $post );
				
				if ( $count == 1 ) {
				$tag_module = strip_tags(get_the_tag_list('',' , ',''));
				$post_title = isset( $post->post_title ) ? $post->post_title : '';
				?>
				
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'block-post-headline' ); ?> itemscope itemtype="https://schema.org/NewsArticle">
					<div class="body-post-headline">
						<?php the_post_thumbnail( 'medium_large', array( 'alt' => $tag_module )); ?>
						<div class="details-post-headline">
							<header class="data-post-headline">	
								<?php the_title( '<h2 class="judul-headline" itemprop="headline" rel="bookmark"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" title="'. $post_title .'">', '</a></h2>' );  ?>
							</header>
							<?php
							$time_string = '<time class="media-date published updated" ' . berita_itemprop_schema( 'dateModified' ) . ' datetime="%1$s">Published %2$s</time>';
							if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
								$time_string = '<time class="media-date published" ' . berita_itemprop_schema( 'datePublished' ) . ' datetime="%1$s">Published %2$s</time>';
							}

							$time_string = sprintf(
								$time_string,
								esc_attr( get_the_date( 'c' ) ),
								esc_html( get_the_date() ),
								esc_attr( get_the_modified_date( 'c' ) ),
								esc_html( get_the_modified_date() )
							);

							$posted_on = sprintf( '%s', $time_string );
							
							echo $posted_on; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							?>
						</div>
					</div>
				</article>
				<?php }else{ ?>
						<div class="headline-terkait">
						<?php if($count == 2){ ?>
						
							<div class="headline-terkait-title">Berita Terkait</div>
							<article class="list-content__item">
								<?php the_title( '<h3 class="list-content__title" itemprop="headline" rel="bookmark"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" title="'. $post_title .'">', '</a></h3>' );  ?>
							</article>
						
						<?php }else{ ?>
							<article class="list-content__item">
								<?php the_title( '<h3 class="list-content__title" itemprop="headline" rel="bookmark"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" title="'. $post_title .'">', '</a></h3>' );  ?>
							</article>
						<?php } ?>
						</div>
				<?php } ?>
			<?php 
			$count++;
			endforeach;
			
			wp_reset_postdata();
			
		endif;
	}
		
} /* endif berita_related_post */
add_filter( 'berita_home_post', 'berita_home_post', 7 );

if ( ! function_exists( 'berita_related_post' ) ) {
	
	
	function berita_related_post() {
		global $post;
		$cat = wp_get_post_categories( $post->ID, 'taxonomy' );
		$post_id = $post->ID;
		$args = array(
			'post_type'              => 'post',
			'cat'                    => $cat,
			'orderby'                => 'meta_value_num',
			'order'                  => 'desc',
			'showposts'              => 6,
			'post_status'            => 'publish',
			'ignore_sticky_posts'    => 1,
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
			'no_found_rows'          => true,
		);
		
		$recent = get_posts( $args );
		if ( $recent ) {
			?>
			
			<?php
			foreach ( $recent as $post ) :
				setup_postdata( $post );
				$the_id = get_the_id();
				if($the_id != $post_id):
				$post_title = get_the_title();
				$post_title = mb_substr( $post_title, 0, 84 );
				$tag_alt = strip_tags(get_the_tag_list('',' , ',''));
				?>
				
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-content-list' ); ?> itemscope itemtype="https://schema.org/NewsArticle">
					
					<header class="content-list-text">
						<h2 class="content-list-title" itemprop="headline"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark"><?php echo $post_title; ?>...</a></h2>						
						<?php berita_content_header(); ?>
					</header><!-- .entry-header -->
					
					
					<?php berita_post_thumbnail( 'medium_large', array( 'alt' => $tag_alt )); ?>
					
				</article><!-- #post-<?php the_ID(); ?> -->
				
				<?php
				endif;
				
			
			endforeach;
			
			wp_reset_postdata();
			
		}
	}
		
} /* endif berita_related_post */
add_filter( 'berita_related_post', 'berita_related_post', 8 );

/* ads */
if ( ! function_exists( 'berita_undermenu' ) ) {
	/**
	 * 
	 * @since 1.0
	 * 
	 */
	function berita_undermenu() {
		$banner    = get_theme_mod( 'lqb_undermenu' );

		if ( isset( $banner ) && ! empty( $banner ) ) {
			echo '
						<div class="widget_block">
							<figure class="banner-image size-large">';
								echo do_shortcode( $banner );
			echo '			</figure>
						</div>
					';
		}else{
			echo '
						<div class="widget_block">
							<figure class="banner-image size-large">';
			echo '<img decoding="async" loading="lazy" src="https://lamanqu.com/wp-content/uploads/2024/09/banner-ads.jpg" alt="banner" class="wp-image-7010" sizes="(max-width: 1024px) 100vw, 1024px" width="1024" height="168">';
			echo '			</figure>
						</div>
					';
		}
	}
}
add_action( 'berita_undermenu', 'berita_undermenu', 10 );

if ( ! function_exists( 'berita_underpost' ) ) {
	/**
	 * 
	 * @since 1.0
	 * 
	 */
	function berita_underpost() {
		$banner    = get_theme_mod( 'lqb_underpost' );

		if ( isset( $banner ) && ! empty( $banner ) ) {
			echo '
						<div class="banner-image">
							<figure class="widget_block size-large">';
								echo do_shortcode( $banner );
			echo '			</figure>
						</div>
					';
		}else{
			echo '
						<div class="widget_block">
							<figure class="banner-image size-large">';
			echo '<img decoding="async" loading="lazy" src="https://lamanqu.com/wp-content/uploads/2024/09/banner-ads.jpg" alt="banner" class="wp-image-7010" sizes="(max-width: 1024px) 100vw, 1024px" width="1024" height="168">';
			echo '			</figure>
						</div>
					';
		}
	}
}
add_action( 'berita_underpost', 'berita_underpost', 10 );

/**
	 * Social Icon.
	 *
	 * @since 1.0.0
	 * @return void
*/

if ( ! function_exists( 'berita_list_social' ) ) :
	
	function berita_list_social() {
		$fb_url = get_theme_mod( 'lqb_fb_url_icon' );
		if ( $fb_url ) :
			echo '<li><a href="' . esc_url( $fb_url ) . '" title="' . esc_html__( 'Facebook', 'lq-berita' ) . '" class="facebook notrename" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M13 9h4.5l-.5 2h-4v9h-2v-9H7V9h4V7.128c0-1.783.186-2.43.534-3.082a3.635 3.635 0 0 1 1.512-1.512C13.698 2.186 14.345 2 16.128 2c.522 0 .98.05 1.372.15V4h-1.372c-1.324 0-1.727.078-2.138.298c-.304.162-.53.388-.692.692c-.22.411-.298.814-.298 2.138V9z" fill="#888888"/><rect x="0" y="0" width="24" height="24" fill="rgba(0, 0, 0, 0)" /></svg></a></li>';
		endif;

		$twitter_url = get_theme_mod( 'lqb_twitter_url_icon' );
		if ( $twitter_url ) :
			echo '<li><a href="' . esc_url( $twitter_url ) . '" title="' . esc_html__( 'X', 'lq-berita' ) . '" class="twitter notrename" target="_blank" rel="nofollow"><svg fill="#DC7633" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="1em"
  zoomAndPan="magnify" viewBox="0 0 375 374.9999" height="1em" version="1.0">
  <defs>
    <path
      d="M 11.972656 11.972656 L 359.222656 11.972656 L 359.222656 359.222656 L 11.972656 359.222656 Z M 11.972656 11.972656 "
      fill="#000000"></path>
  </defs>
  <g>
    <path
      d="M 185.597656 359.222656 C 89.675781 359.222656 11.972656 280.984375 11.972656 185.597656 C 11.972656 90.210938 89.675781 11.972656 185.597656 11.972656 C 281.519531 11.972656 359.222656 89.675781 359.222656 185.597656 C 359.222656 281.519531 280.984375 359.222656 185.597656 359.222656 Z M 185.597656 22.691406 C 95.570312 22.691406 22.691406 95.570312 22.691406 185.597656 C 22.691406 275.625 95.570312 348.503906 185.597656 348.503906 C 275.625 348.503906 348.503906 275.625 348.503906 185.597656 C 348.503906 95.570312 275.089844 22.691406 185.597656 22.691406 Z M 185.597656 22.691406 "
      fill-opacity="1" fill-rule="nonzero" fill="#000000"></path>
  </g>
  <g transform="translate(85, 75)"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" version="1.1"
      height="205" width="205">
      <path
        d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"
        fill="#000000"></path>
    </svg> </g>
</svg></a></li>';
		endif;

		$pinterest_url = get_theme_mod( 'lqb_pinterest_url_icon' );
		if ( $pinterest_url ) :
			echo '<li><a href="' . esc_url( $pinterest_url ) . '" title="' . esc_html__( 'Pinterest', 'lq-berita' ) . '" class="pinterest notrename" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 32 32"><path d="M16.094 4C11.017 4 6 7.383 6 12.861c0 3.483 1.958 5.463 3.146 5.463c.49 0 .774-1.366.774-1.752c0-.46-1.174-1.44-1.174-3.355c0-3.978 3.028-6.797 6.947-6.797c3.37 0 5.864 1.914 5.864 5.432c0 2.627-1.055 7.554-4.47 7.554c-1.231 0-2.284-.89-2.284-2.166c0-1.87 1.197-3.681 1.197-5.611c0-3.276-4.537-2.682-4.537 1.277c0 .831.104 1.751.475 2.508C11.255 18.354 10 23.037 10 26.066c0 .935.134 1.855.223 2.791c.168.188.084.169.341.075c2.494-3.414 2.263-4.388 3.391-8.856c.61 1.158 2.183 1.781 3.43 1.781c5.255 0 7.615-5.12 7.615-9.738C25 7.206 20.755 4 16.094 4z" fill="#888888"/><rect x="0" y="0" width="32" height="32" fill="rgba(0, 0, 0, 0)" /></svg></a></li>';
		endif;

		$wordpress_url = get_theme_mod( 'lqb_wordpress_url_icon' );
		if ( $wordpress_url ) :
			echo '<li><a href="' . esc_url( $wordpress_url ) . '" title="' . esc_html__( 'WordPress', 'lq-berita' ) . '" class="wp notrename" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 32 32"><path d="M16 3C8.828 3 3 8.828 3 16s5.828 13 13 13s13-5.828 13-13S23.172 3 16 3zm0 2.168c2.825 0 5.382 1.079 7.307 2.838c-.042-.001-.083-.012-.135-.012c-1.062 0-1.754.93-1.754 1.928c0 .899.453 1.648 1.006 2.547c.41.715.889 1.646.889 2.978c0 .932-.348 2.004-.825 3.51l-1.07 3.607l-4.066-12.527a23.51 23.51 0 0 0 1.234-.098c.585-.065.52-.931-.065-.898c0 0-1.754.14-2.892.14c-1.061 0-2.85-.14-2.85-.14c-.585-.033-.65.866-.064.898c0 0 .552.065 1.137.098l1.824 5.508l-2.364 7.107L9.215 10.04a23.408 23.408 0 0 0 1.246-.098c.585-.065.51-.931-.065-.898c0 0-1.681.133-2.82.139A10.795 10.795 0 0 1 16 5.168zm9.512 5.633A10.815 10.815 0 0 1 26.832 16a10.796 10.796 0 0 1-5.383 9.36l3.305-9.565c.617-1.538.822-2.774.822-3.879c0-.401-.02-.76-.062-1.105c-.002-.003-.001-.007-.002-.01zm-19.309.584l5.063 14.355A10.797 10.797 0 0 1 5.168 16c0-1.655.377-3.215 1.035-4.615zm9.98 5.558l3.338 9.131a.595.595 0 0 0 .075.139c-1.126.394-2.332.619-3.596.619c-1.067 0-2.094-.159-3.066-.443l3.25-9.446zm-4.787 8.86a10.74 10.74 0 0 1 0 0zm9.02.09zm-7.855.378a10.713 10.713 0 0 1 0 0z" fill="#888888"/><rect x="0" y="0" width="32" height="32" fill="rgba(0, 0, 0, 0)" /></svg></a></li>';
		endif;

		$instagram_url = get_theme_mod( 'lqb_instagram_url_icon' );
		if ( $instagram_url ) :
			echo '<li><a href="' . esc_url( $instagram_url ) . '" title="' . esc_html__( 'Instagram', 'lq-berita' ) . '" class="instagram notrename" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 256"><path d="M128 80a48 48 0 1 0 48 48a48.054 48.054 0 0 0-48-48zm0 80a32 32 0 1 1 32-32a32.036 32.036 0 0 1-32 32zm44-132H84a56.064 56.064 0 0 0-56 56v88a56.064 56.064 0 0 0 56 56h88a56.064 56.064 0 0 0 56-56V84a56.064 56.064 0 0 0-56-56zm40 144a40.045 40.045 0 0 1-40 40H84a40.045 40.045 0 0 1-40-40V84a40.045 40.045 0 0 1 40-40h88a40.045 40.045 0 0 1 40 40zm-20-96a12 12 0 1 1-12-12a12 12 0 0 1 12 12z" fill="#888888"/><rect x="0" y="0" width="256" height="256" fill="rgba(0, 0, 0, 0)" /></svg></a></li>';
		endif;

		$reddit_url = get_theme_mod( 'lqb_reddit_url_icon' );
		if ( $reddit_url ) :
			echo '<li><a href="' . esc_url( $reddit_url ) . '" title="' . esc_html__( 'Reddit', 'lq-berita' ) . '" class="reddit notrename" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 32 32"><path d="M18.656 4C16.56 4 15 5.707 15 7.656v3.375c-2.758.145-5.258.875-7.281 2.031C6.945 12.316 5.914 12 4.906 12c-1.09 0-2.199.355-2.968 1.219v.031l-.032.031c-.738.922-1.039 2.153-.843 3.375a4.444 4.444 0 0 0 1.968 3C3.023 19.77 3 19.883 3 20c0 2.605 1.574 4.887 3.938 6.469C9.3 28.05 12.488 29 16 29c3.512 0 6.7-.95 9.063-2.531C27.425 24.887 29 22.605 29 20c0-.117-.023-.23-.031-.344a4.444 4.444 0 0 0 1.968-3c.196-1.222-.105-2.453-.843-3.375l-.032-.031c-.769-.863-1.878-1.25-2.968-1.25c-1.008 0-2.04.316-2.813 1.063c-2.023-1.157-4.523-1.887-7.281-2.032V7.656C17 6.676 17.559 6 18.656 6c.52 0 1.164.246 2.157.594c.843.297 1.937.625 3.343.718C24.496 8.29 25.414 9 26.5 9C27.875 9 29 7.875 29 6.5S27.875 4 26.5 4c-.945 0-1.762.535-2.188 1.313c-1.199-.07-2.066-.32-2.843-.594C20.566 4.402 19.734 4 18.656 4zM16 13c3.152 0 5.965.867 7.938 2.188C25.91 16.508 27 18.203 27 20c0 1.797-1.09 3.492-3.063 4.813C21.965 26.133 19.152 27 16 27s-5.965-.867-7.938-2.188C6.09 23.492 5 21.797 5 20c0-1.797 1.09-3.492 3.063-4.813C10.034 13.867 12.848 13 16 13zM4.906 14c.38 0 .754.094 1.063.25c-1.086.91-1.93 1.992-2.438 3.188a2.356 2.356 0 0 1-.469-1.094c-.109-.672.086-1.367.407-1.782c.004-.007-.004-.023 0-.03c.304-.321.844-.532 1.437-.532zm22.188 0c.593 0 1.133.21 1.437.531c.004.004-.004.028 0 .031c.32.415.516 1.11.407 1.782c-.063.39-.215.773-.47 1.093c-.507-1.195-1.35-2.277-2.437-3.187c.309-.156.684-.25 1.063-.25zM11 16a1.999 1.999 0 1 0 0 4a1.999 1.999 0 1 0 0-4zm10 0a1.999 1.999 0 1 0 0 4a1.999 1.999 0 1 0 0-4zm.25 5.531c-1.148 1.067-3.078 1.75-5.25 1.75s-4.102-.691-5.25-1.625C11.39 23.391 13.445 25 16 25s4.61-1.602 5.25-3.469z" fill="#888888"/><rect x="0" y="0" width="32" height="32" fill="rgba(0, 0, 0, 0)" /></svg></a></li>';
		endif;

		$linkedin_url = get_theme_mod( 'lqb_linkedin_url_icon' );
		if ( $linkedin_url ) :
			echo '<li><a href="' . esc_url( $linkedin_url ) . '" title="' . esc_html__( 'Linkedin', 'lq-berita' ) . '" class="linkedin notrename" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M12 9.55C12.917 8.613 14.111 8 15.5 8a5.5 5.5 0 0 1 5.5 5.5V21h-2v-7.5a3.5 3.5 0 0 0-7 0V21h-2V8.5h2v1.05zM5 6.5a1.5 1.5 0 1 1 0-3a1.5 1.5 0 0 1 0 3zm-1 2h2V21H4V8.5z" fill="#888888"/><rect x="0" y="0" width="24" height="24" fill="rgba(0, 0, 0, 0)" /></svg></a></li>';
		endif;

		$youtube_url = get_theme_mod( 'lqb_youtube_url_icon' );
		if ( $youtube_url ) :
			echo '<li><a href="' . esc_url( $youtube_url ) . '" title="' . esc_html__( 'Youtube', 'lq-berita' ) . '" class="youtube notrename" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M19.606 6.995c-.076-.298-.292-.523-.539-.592C18.63 6.28 16.5 6 12 6s-6.628.28-7.069.403c-.244.068-.46.293-.537.592C4.285 7.419 4 9.196 4 12s.285 4.58.394 5.006c.076.297.292.522.538.59C5.372 17.72 7.5 18 12 18s6.629-.28 7.069-.403c.244-.068.46-.293.537-.592C19.715 16.581 20 14.8 20 12s-.285-4.58-.394-5.005zm1.937-.497C22 8.28 22 12 22 12s0 3.72-.457 5.502c-.254.985-.997 1.76-1.938 2.022C17.896 20 12 20 12 20s-5.893 0-7.605-.476c-.945-.266-1.687-1.04-1.938-2.022C2 15.72 2 12 2 12s0-3.72.457-5.502c.254-.985.997-1.76 1.938-2.022C6.107 4 12 4 12 4s5.896 0 7.605.476c.945.266 1.687 1.04 1.938 2.022zM10 15.5v-7l6 3.5l-6 3.5z" fill="#888888"/><rect x="0" y="0" width="24" height="24" fill="rgba(0, 0, 0, 0)" /></svg></a></li>';
		endif;

		$twitch_url = get_theme_mod( 'lqb_twitch_url_icon' );
		if ( $twitch_url ) :
			echo '<li><a href="' . esc_url( $twitch_url ) . '" title="' . esc_html__( 'Twitch', 'lq-berita' ) . '" class="twitch notrename" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M4.3 3H21v11.7l-4.7 4.7h-3.9l-2.5 2.4H7v-2.4H3V6.2L4.3 3zM5 17.4h4v2.4h.095l2.5-2.4h3.877L19 13.872V5H5v12.4zM15 8h2v4.7h-2V8zm0 0h2v4.7h-2V8zm-5 0h2v4.7h-2V8z" fill="#888888"/><rect x="0" y="0" width="24" height="24" fill="rgba(0, 0, 0, 0)" /></svg></a></li>';
		endif;

		$spotify_url = get_theme_mod( 'lqb_spotify_url_icon' );
		if ( $spotify_url ) :
			echo '<li><a href="' . esc_url( $spotify_url ) . '" title="' . esc_html__( 'Spotify', 'lq-berita' ) . '" class="spotify notrename" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="vertical-align: -0.062em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path d="M418 311q123 3 214 20.5T802 389q15 7 26 15.5t15 18.5t2 26.5t-10 21.5q-5 4-12.5 6.5t-15 4t-15 .5t-13.5-3q-156-81-360-73q-53 2-151 21q-56 11-68-31q-5-16 .5-29t17-19.5T245 338q18-4 173-27zm23 152q87 6 164 25.5T750 547q4 2 9 6t9 9t7.5 10.5t5.5 11t2 10.5q2 22-19 28.5t-48-7.5q-176-93-390-57q-3 0-20 5.5t-25 3.5q-3-1-6.5-2t-6.5-2.5l-6-3l-6-3.5l-6.5-4l-6-3.5l-6-3.5l-6.5-3q3-5 9-17.5t11.5-20T263 496q26-7 54-12t68.5-11.5T441 463zm-21 153q170 3 278 64q10 5 15.5 9.5t11.5 11t5 14.5t-8 16q-5 8-24 9t-29-5q-131-70-317-47q-7 1-17.5 3.5T315 696t-17 1t-15.5-4t-18-8.5T250 677q2-4 6-9t6.5-9.5t6-9t7.5-7.5t7-4q24-5 49.5-9.5t54.5-8t33-4.5zm604-104q0 212-150 362t-362 150t-362-150T0 512t150-362q25-25 51.5-46t55-37.5t59-29t62-21T443 4t69-4q212 0 362 150t150 362zm-64 0q0-186-131-317T512 64T195 195T64 512t131 318t317 132t317-132t131-318z" fill="#888888"/><rect x="0" y="0" width="1024" height="1024" fill="rgba(0, 0, 0, 0)" /></svg></a></li>';
		endif;

		$whatsapp_url = get_theme_mod( 'lqb_whatsapp_url_icon' );
		if ( $whatsapp_url ) :
			echo '<li><a href="' . esc_url( $whatsapp_url ) . '" title="' . esc_html__( 'WhatsApp', 'lq-berita' ) . '" class="whatsapp notrename" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 512 512"><path d="M414.73 97.1A222.14 222.14 0 0 0 256.94 32C134 32 33.92 131.58 33.87 254a220.61 220.61 0 0 0 29.78 111L32 480l118.25-30.87a223.63 223.63 0 0 0 106.6 27h.09c122.93 0 223-99.59 223.06-222A220.18 220.18 0 0 0 414.73 97.1zM256.94 438.66h-.08a185.75 185.75 0 0 1-94.36-25.72l-6.77-4l-70.17 18.32l18.73-68.09l-4.41-7A183.46 183.46 0 0 1 71.53 254c0-101.73 83.21-184.5 185.48-184.5a185 185 0 0 1 185.33 184.64c-.04 101.74-83.21 184.52-185.4 184.52zm101.69-138.19c-5.57-2.78-33-16.2-38.08-18.05s-8.83-2.78-12.54 2.78s-14.4 18-17.65 21.75s-6.5 4.16-12.07 1.38s-23.54-8.63-44.83-27.53c-16.57-14.71-27.75-32.87-31-38.42s-.35-8.56 2.44-11.32c2.51-2.49 5.57-6.48 8.36-9.72s3.72-5.56 5.57-9.26s.93-6.94-.46-9.71s-12.54-30.08-17.18-41.19c-4.53-10.82-9.12-9.35-12.54-9.52c-3.25-.16-7-.2-10.69-.2a20.53 20.53 0 0 0-14.86 6.94c-5.11 5.56-19.51 19-19.51 46.28s20 53.68 22.76 57.38s39.3 59.73 95.21 83.76a323.11 323.11 0 0 0 31.78 11.68c13.35 4.22 25.5 3.63 35.1 2.2c10.71-1.59 33-13.42 37.63-26.38s4.64-24.06 3.25-26.37s-5.11-3.71-10.69-6.48z" fill-rule="evenodd" fill="#888888"/><rect x="0" y="0" width="512" height="512" fill="rgba(0, 0, 0, 0)" /></svg></a></li>';
		endif;

		$tiktok_url = get_theme_mod( 'lqb_tiktok_url_icon' );
		if ( $tiktok_url ) :
			echo '<li><a href="' . esc_url( $tiktok_url ) . '" title="' . esc_html__( 'TikTok', 'lq-berita' ) . '" class="tiktok notrename" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M16.6 5.82s.51.5 0 0A4.278 4.278 0 0 1 15.54 3h-3.09v12.4a2.592 2.592 0 0 1-2.59 2.5c-1.42 0-2.6-1.16-2.6-2.6c0-1.72 1.66-3.01 3.37-2.48V9.66c-3.45-.46-6.47 2.22-6.47 5.64c0 3.33 2.76 5.7 5.69 5.7c3.14 0 5.69-2.55 5.69-5.7V9.01a7.35 7.35 0 0 0 4.3 1.38V7.3s-1.88.09-3.24-1.48z" fill="currentColor"/></svg></a></li>';
		endif;

		$telegram_url = get_theme_mod( 'lqb_telegram_url_icon' );
		if ( $telegram_url ) :
			echo '<li><a href="' . esc_url( $telegram_url ) . '" title="' . esc_html__( 'Telegram', 'lq-berita' ) . '" class="telegram notrename" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 256"><path d="M231.256 31.736a15.964 15.964 0 0 0-16.29-2.767L30.409 101.474a16 16 0 0 0 2.712 30.58L80 141.432v58.553a15.994 15.994 0 0 0 27.313 11.314l25.944-25.943l39.376 34.65a15.869 15.869 0 0 0 10.517 4.004a16.154 16.154 0 0 0 4.963-.787a15.865 15.865 0 0 0 10.685-11.654l37.614-164.132a15.96 15.96 0 0 0-5.156-15.7zm-145.11 94.607l-49.885-9.977L175.942 61.49zM96 199.977v-47.408l25.22 22.193zm87.202 8.017l-82.392-72.506l118.645-85.687z" fill="currentColor"/></svg></a></li>';
		endif;

		$soundcloud_url = get_theme_mod( 'lqb_soundcloud_url_icon' );
		if ( $soundcloud_url ) :
			echo '<li><a href="' . esc_url( $soundcloud_url ) . '" title="' . esc_html__( 'Soundcloud', 'lq-berita' ) . '" class="soundcloud notrename" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1.15em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 896"><path d="M1022 514q0 66-47 112.5T862 673h-63q-14 0-23-9t-9-23q0-3 .5-5.5t1.5-5t2.5-5t3-4.5t3.5-4t4.5-3l5-2l5.5-1.5l6-.5h63q26 0 48-13t35-35t13-48q0-16-5-30.5t-13.5-26T919 437t-26.5-14t-30.5-5q-20 0-38.5-8T792 388t-20-33v-1q-13-34-37-62t-57.5-44.5T606 228q-9 0-15.5 4.5T580 244t-4 15v382q0 7-2.5 12.5t-7 10t-10.5 7t-12 2.5q-13 0-22.5-9.5T512 641V259q0-15 5-29.5t13.5-26t20-20.5t26-14t30.5-5q77 4 138 50.5T831 332l1 1q7 22 30 22h7q64 2 108.5 48.5T1022 514zM416.5 673q-13.5 0-22.5-9t-9-23V291q0-13 9-22.5t22.5-9.5t22.5 9.5t9 22.5v350q0 13-9 22.5t-22.5 9.5zM289 673q-13 0-22.5-9t-9.5-23V275q0-13 9.5-22.5T289 243q8 0 15.5 4t12 11.5T321 275v366q0 13-9.5 22.5T289 673zm-128 0q-5 0-10-1.5t-8.5-4.5t-6.5-7t-4.5-8.5T130 641V386q0-4 1-8t3-7.5t5-6.5t6.5-5t7.5-3t8-1q14 0 23 9t9 22v255q0 13-9 22.5t-23 9.5zM34 609q-13 0-22.5-9T2 578V450q0-13 9.5-22.5T34 418q9 0 16 4.5t11.5 12T66 450v128q0 13-9.5 22T34 609zm637 0q13 0 22.5 9.5T703 641t-9.5 22.5T671 673q-8 0-15.5-4.5t-12-11.5t-4.5-15.5t4.5-16t12-12T671 609z" fill="currentColor"/></svg></a></li>';
		endif;

		$dailymotion_url = get_theme_mod( 'lqb_dailymotion_url_icon' );
		if ( $dailymotion_url ) :
			echo '<li><a href="' . esc_url( $dailymotion_url ) . '" title="' . esc_html__( 'Dailymotion', 'lq-berita' ) . '" class="dailymotion notrename" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="currentColor" d="M14.068 11.313h-.023a3.1 3.1 0 1 0 .183 6.195h-.024a2.969 2.969 0 0 0 2.926-2.968l-.001-.076v.004l.002-.103a3.054 3.054 0 0 0-3.054-3.054h-.01h.001z"/><path fill="currentColor" d="M0 0v24h24V0zm20.693 20.807h-3.576V19.4a4.837 4.837 0 0 1-3.727 1.47h.011l-.104.001a5.646 5.646 0 0 1-3.83-1.49l.004.004A6.357 6.357 0 0 1 7.27 14.57l.001-.127v-.03a6.34 6.34 0 0 1 2.007-4.635l.003-.003a5.815 5.815 0 0 1 4.147-1.73h.041h-.002a4.186 4.186 0 0 1 3.526 1.578l.007.009V4.157l3.693-.765z"/></svg></a></li>';
		endif;

		// Disable rss icon via customizer.
		$rssicon = get_theme_mod( 'lqb_active-rssicon', 0 );
		if ( 0 === $rssicon ) :
			echo '<li><a href="' . esc_url( get_bloginfo( 'rss2_url' ) ) . '" title="' . esc_html__( 'RSS', 'lq-berita' ) . '" class="rss notrename" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M5.996 19.97a1.996 1.996 0 1 1 0-3.992a1.996 1.996 0 0 1 0 3.992zm-.876-7.993a.998.998 0 0 1-.247-1.98a8.103 8.103 0 0 1 9.108 8.04v.935a.998.998 0 1 1-1.996 0v-.934a6.108 6.108 0 0 0-6.865-6.06zM4 5.065a.998.998 0 0 1 .93-1.063c7.787-.519 14.518 5.372 15.037 13.158c.042.626.042 1.254 0 1.88a.998.998 0 1 1-1.992-.133c.036-.538.036-1.077 0-1.614c-.445-6.686-6.225-11.745-12.91-11.299A.998.998 0 0 1 4 5.064z" fill="#888888"/><rect x="0" y="0" width="24" height="24" fill="rgba(0, 0, 0, 0)" /></svg></a></li>';
		endif;
	}
endif; /* endif berita_list_social */
add_action( 'social_icon', 'berita_list_social', 5 );