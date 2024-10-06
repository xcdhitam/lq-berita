<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package LQ Berita
 */

 if ( ! function_exists( 'berita_post_header' ) ) :

	function berita_post_header() {
		echo '<div class="meta-row">';
			echo '<div class="meta-cell meta-gravatar">';
				echo get_avatar( get_the_author_meta( 'ID' ), '64', '', '', array( 'class' => 'img-cicle', 'default' => 'mystery' ) );
			echo '</div>';
			echo '<div class="meta-cell">';
			
				$posted_by = sprintf(
					'%s',
					'<span class="by-post vcard" ' . berita_itemprop_schema( 'author' ) . ' ' . berita_itemtype_schema( 'person' ) . '>Author <a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . __( '', 'lq-berita' ) . esc_html( get_the_author() ) . '" ' . berita_itemprop_schema( 'url' ) . '><span ' . berita_itemprop_schema( 'name' ) . '>' . esc_html( get_the_author() ) . '</span></a></span>'
				);
				
				echo $posted_by; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				
				$time_string = '<time class="by-date published updated" ' . berita_itemprop_schema( 'dateModified' ) . ' datetime="%1$s">Published %2$s</time>';
				if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
					$time_string = '<time class="by-date published" ' . berita_itemprop_schema( 'datePublished' ) . ' datetime="%1$s">Published %2$s</time>';
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
				
				$categories_list = get_the_category_list( esc_html__( ', ', 'lq-berita' ) );
				if ( $categories_list ) {
					/* translators: 1: list of categories. */
					printf( '<span class="by-cat" itemprop="articleSection">' . esc_html__( '%1$s', 'lq-berita' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
		
			echo '</div>';
			
			echo '<div class="meta-cell">';
			
				echo '<ul class="by-socialicon-share">';
				echo '<li class="facebook">';
					echo '<a href="https://www.facebook.com/sharer/sharer.php?u=' . rawurlencode( esc_url( get_the_permalink() ) ) . '" target="_blank" rel="nofollow" title="' . __( 'Share to facebook', 'lq-berita' ) . '">';
						echo '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><g fill="none"><path d="M9.198 21.5h4v-8.01h3.604l.396-3.98h-4V7.5a1 1 0 0 1 1-1h3v-4h-3a5 5 0 0 0-5 5v2.01h-2l-.396 3.98h2.396v8.01z" fill="currentColor"/></g></svg>';
					echo '</a>';
				echo '</li>';
				echo '<li class="whatsapp">';
							echo '<a href="https://api.whatsapp.com/send?text=' . rawurlencode( wp_strip_all_tags( get_the_title() ) ) . ' ' . rawurlencode( esc_url( get_permalink() ) ) . '" target="_blank" rel="nofollow" title="' . esc_html__( 'Send To WhatsApp', 'lq-berita' ) . '">';
								echo '<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 32 32"><path fill="#25d366" d="M23.328 19.177c-.401-.203-2.354-1.156-2.719-1.292c-.365-.13-.63-.198-.896.203c-.26.391-1.026 1.286-1.26 1.547s-.464.281-.859.104c-.401-.203-1.682-.62-3.203-1.984c-1.188-1.057-1.979-2.359-2.214-2.76c-.234-.396-.026-.62.172-.818c.182-.182.401-.458.604-.698c.193-.24.255-.401.396-.661c.13-.281.063-.5-.036-.698s-.896-2.161-1.229-2.943c-.318-.776-.651-.677-.896-.677c-.229-.021-.495-.021-.76-.021s-.698.099-1.063.479c-.365.401-1.396 1.359-1.396 3.297c0 1.943 1.427 3.823 1.625 4.104c.203.26 2.807 4.26 6.802 5.979c.953.401 1.693.641 2.271.839c.953.302 1.823.26 2.51.161c.76-.125 2.354-.964 2.688-1.901c.339-.943.339-1.724.24-1.901c-.099-.182-.359-.281-.76-.458zM16.083 29h-.021c-2.365 0-4.703-.641-6.745-1.839l-.479-.286l-5 1.302l1.344-4.865l-.323-.5a13.166 13.166 0 0 1-2.021-7.01c0-7.26 5.943-13.182 13.255-13.182c3.542 0 6.865 1.38 9.365 3.88a13.058 13.058 0 0 1 3.88 9.323C29.328 23.078 23.39 29 16.088 29zM27.359 4.599C24.317 1.661 20.317 0 16.062 0C7.286 0 .14 7.115.135 15.859c0 2.792.729 5.516 2.125 7.927L0 32l8.448-2.203a16.13 16.13 0 0 0 7.615 1.932h.005c8.781 0 15.927-7.115 15.932-15.865c0-4.234-1.651-8.219-4.661-11.214z"/></svg>';
							echo '</a>';
						echo '</li>';
					echo '</ul>';
				
				
			echo '</div>';
		echo '</div>';
		
	}

endif;

if ( ! function_exists( 'berita_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function berita_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'lq-berita' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'berita_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function berita_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'lq-berita' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'berita_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function berita_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ' ', 'list item separator', 'lq-berita' ) );
			$tags_meta = get_the_tags();
			if ( $tags_list && $tags_meta) {
				/* translators: 1: list of tags. */
				printf( '<meta itemprop="keywords" content="' );
					foreach( $tags_meta as $tag ) {
						print( $tag->name . ', ' );// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					}
				printf( '">' );
				printf( '<span class="links-tags">' . esc_html__( '%1$s', 'lq-berita' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}
		
		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'lq-berita' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'lq-berita' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'berita_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function berita_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}
		$tag_alt = strip_tags(get_the_tag_list('',' , ',''));
		$title_img = get_the_title();
		if ( is_singular() ) :
			?>

			<div class="content-single-images content-single-image">
				<?php the_post_thumbnail( 'medium_large', array( 'alt' => $tag_alt, 'itemprop' => 'image' )); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>
			<div class="content-list-images content-list-image">
			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
					the_post_thumbnail(
						'medium',
						array(
							'alt' => $tag_alt,
							'title' => $title_img
						)
					);					
				?>
			</a>
			</div>
			<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'berita_content_header' ) ) :

	function berita_content_header() {
		$time_string = '<time class="content-list-time published updated" ' . berita_itemprop_schema( 'dateModified' ) . ' datetime="%1$s">Published %2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="content-list-time published" ' . berita_itemprop_schema( 'datePublished' ) . ' datetime="%1$s">Published %2$s</time>';
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
		
	}
endif;

/* itemtype schema */
if ( ! function_exists( 'berita_itemtype_schema' ) ) :
	
	function berita_itemtype_schema( $type = 'NewsArticle' ) {
		$schema = 'http://schema.org/';

		/* Get the itemtype */
		$itemtype = apply_filters( 'berita_article_itemtype', $type );

		/* Print the results */
		$scope = 'itemscope="itemscope" itemtype="' . $schema . $itemtype . '"';
		return $scope;
	}
endif;

if ( ! function_exists( 'berita_itemprop_schema' ) ) :
	
	function berita_itemprop_schema( $type = 'headline' ) {
		/* Get the itemprop */
		$itemprop = apply_filters( 'berita_itemprop_filter', $type );

		/* Print the results */
		$scope = 'itemprop="' . $itemprop . '"';
		return $scope;
	}
endif;

if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12563
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
endif;

if ( ! function_exists( 'berita_paging_nav' ) ) :
	/**
	 * Display navigation to next/previous set of posts when applicable.
	 *
	 * @since 1.0
	 *
	 */
	function berita_paging_nav() {
		global $wp_query, $wp_rewrite;

		// Don't print empty markup if there's only one page.
		if ( $wp_query->max_num_pages < 2 ) {
			return;
		}

		$paged        = get_query_var( 'paged' ) ? (int) get_query_var( 'paged' ) : 1;
		$pagenum_link = html_entity_decode( get_pagenum_link() );
		$query_args   = array();
		$url_parts    = explode( '?', $pagenum_link );

		if ( isset( $url_parts[1] ) ) {
			wp_parse_str( $url_parts[1], $query_args );
		}

		$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
		$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

		$format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
		$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

		// Set up paginated links.
		$links = paginate_links(
			array(
				'base'      => $pagenum_link,
				'format'    => $format,
				'total'     => $wp_query->max_num_pages,
				'current'   => $paged,
				'mid_size'  => 1,
				'add_args'  => array_map( 'urlencode', $query_args ),
				'prev_text' => __( '&larr; Previous', 'lq-berita' ),
				'next_text' => __( 'Next &rarr;', 'lq-berita' ),
			)
		);

		if ( $links ) :

			?>
		<nav class="navigation paging-navigation">
		<h3 class="screen-reader-text">
			<?php
			/* translators: Hidden accessibility text. */
			_e( 'Posts Navigation', 'lq-berita' );
			?>
		</h3>
		<div class="pagination loop-pagination">
			<?php echo $links; ?>
		</div><!-- .pagination -->
	</nav><!-- .navigation -->
			<?php
	endif;
	}
endif;

