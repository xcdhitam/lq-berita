<?php
/**
 * The template for displaying page index
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package LQ Berita
 */

get_header();
?>
<div class="wrapper">
    
    <aside id="primary" class="aside aside-2" role="complementary">
		
		<div class="sidebar-indexpage">
			<?php
				echo '<ul class="index-page-numbers">';
				$arg = array(
					'post_type' => array( 'post' ),
				);

				$categories = get_categories( $arg );
				echo '<li><a href="' . esc_url( get_permalink() ) . '" class="heading-text" title="' . esc_html__( 'All News', 'lq-berita' ) . '">' . esc_html__( 'All News', 'lq-berita' ) . ' <span class="pull-right"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="18" height="18" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 20 20"><g fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M10.293 3.293a1 1 0 0 1 1.414 0l6 6a1 1 0 0 1 0 1.414l-6 6a1 1 0 0 1-1.414-1.414L14.586 11H3a1 1 0 1 1 0-2h11.586l-4.293-4.293a1 1 0 0 1 0-1.414z" fill="currentColor"/></g><rect x="0" y="0" width="20" height="20" fill="rgba(0, 0, 0, 0)" /></svg></span></a></li>';
				foreach ( $categories as $cats ) {
					$catid     = absint( $cats->term_id );
					$permalink = esc_url( get_permalink() );
					echo '<li><a href="' . esc_url( add_query_arg( 'id', $catid, $permalink ) ) . '" class="heading-text" title="' . esc_html( $cats->name ) . '">' . esc_html( $cats->name ) . ' (' . absint( $cats->category_count ) . ')</a></li>';
				}
				echo '</ul>';
				$default_posts_per_page = get_option( 'posts_per_page' );
				if ( isset( $_GET['id'] ) && ! empty( $_GET['id'] ) ) { /* phpcs:ignore */
					$cat = absint( $_GET['id'] ); /* phpcs:ignore */
				} else {
					$cat = 0; /* phpcs:ignore */
				}
				$query_args = array(
					'post_type'      => 'post',
					'posts_per_page' => absint( $default_posts_per_page ),
					'cat'            => absint( $cat ),
					'post_status'    => 'publish',
					'paged'          => absint( $paged ),
					'orderby'        => 'date',
				);
				/* Get date query */
				if ( isset( $_GET['dy'] ) && ! empty( $_GET['dy'] ) && isset( $_GET['mt'] ) && ! empty( $_GET['mt'] ) && isset( $_GET['yr'] ) && ! empty( $_GET['yr'] ) ) { /* phpcs:ignore */
					if ( isset( $_GET['dy'] ) && ! empty( $_GET['dy'] ) ) { /* phpcs:ignore */
						$qday = absint( $_GET['dy'] ); /* phpcs:ignore */
					} else {
						$qday = absint( date_i18n( 'd' ) );
					}
					if ( isset( $_GET['mt'] ) && ! empty( $_GET['mt'] ) ) { /* phpcs:ignore */
						$qmonth = absint( $_GET['mt'] ); /* phpcs:ignore */
					} else {
						$qmonth = absint( date_i18n( 'n' ) );
					}
					if ( isset( $_GET['yr'] ) && ! empty( $_GET['yr'] ) ) { /* phpcs:ignore */
						$qyear = absint( $_GET['yr'] ); /* phpcs:ignore */
					} else {
						$qyear = absint( date_i18n( 'Y' ) );
					}
					$query_args['date_query'] = array(
						array(
							'day'   => absint( $qday ),
							'month' => absint( $qmonth ),
							'year'  => absint( $qyear ),
						),
					);
				}
				$rp = new WP_Query( apply_filters( 'pageindex_posts_args', $query_args ) );
			?>
		</div>
	</aside><!-- #secondary -->
	<main id="primary" class="site-main">
		<div class="lqb-filter-index clearfix">
			<?php echo '<h3 class="text-filter heading-text">' . esc_html__( 'View Archive By Date', 'lq-berita' ) . '</h3>'; ?>
				<form method="get" class="lqb-filter-index" action="<?php the_permalink(); ?>">
					<select id="dy" name="dy" required>
						<?php
						foreach ( range( 1, 31 ) as $number ) {
							echo '<option value="' . absint( $number ) . '">' . absint( $number ) . '</option>';
						}
						?>
					</select>
					<select id="mt" name="mt" required>
						<?php
						$months = array(
							1  => esc_html__( 'Jan', 'lq-berita' ),
							2  => esc_html__( 'Feb', 'lq-berita' ),
							3  => esc_html__( 'Mar', 'lq-berita' ),
							4  => esc_html__( 'Apr', 'lq-berita' ),
							5  => esc_html__( 'May', 'lq-berita' ),
							6  => esc_html__( 'Jun', 'lq-berita' ),
							7  => esc_html__( 'Jul', 'lq-berita' ),
							8  => esc_html__( 'Aug', 'lq-berita' ),
							9  => esc_html__( 'Sep', 'lq-berita' ),
							10 => esc_html__( 'Oct', 'lq-berita' ),
							11 => esc_html__( 'Nov', 'lq-berita' ),
							12 => esc_html__( 'Dec', 'lq-berita' ),
						);
						foreach ( $months as $num => $name ) {
							printf( '<option value="%u">%s</option>', absint( $num ), esc_html( $name ) );
						}
						?>
					</select>
					<input type="number" id="yr" name="yr" min="1000" max="9999" placeholder="<?php echo absint( date_i18n( 'Y' ) ); ?>" required />
					<input type="submit" value="<?php echo esc_attr__( 'Filter', 'lq-berita' ); ?>" />
				</form>
		</div>
		<?php
			global $wp_query;
			// Put default query object in a temp variable.
			$tmp_query = $wp_query;
			// Now wipe it out completely.
			$wp_query = null; /* phpcs:ignore */
			// Re-populate the global with our custom query.
			$wp_query = $rp; /* phpcs:ignore */
			if ( $rp->have_posts() ) {
				/* Start the Loop */
				while ( $rp->have_posts() ) :
					$rp->the_post();
						/*
						 * Include the Post-Type-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
						 */
						get_template_part( 'template-parts/content', get_post_format() );

					endwhile;
					berita_paging_nav();
					wp_reset_postdata();
				}
				$wp_query = null; /* phpcs:ignore */
				$wp_query = $tmp_query; /* phpcs:ignore */
		?>

	</main><!-- #main -->
    
</div>

<?php

get_footer();
