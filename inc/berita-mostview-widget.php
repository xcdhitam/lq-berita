<<<<<<< HEAD
<?php
/**
 * Widget API: berita mostview widget class
 *
 * Author: xfebrian
 *
 * @package LQ Berita
 * @subpackage Widgets
 * @since 2.0.4
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class berita_mostview_widget extends WP_Widget {
	/**
	 * Sets up a Most view Posts widget instance.
	 *
	 * @since 2.0.4
	 * @access public
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'   => 'berita-mostview',
			'description' => __( 'Most view posts with thumbnails widget.', 'lq-berita' ),
		);
		parent::__construct( 'berita-mostview', __( 'Popular Post (LQBerita)', 'lq-berita' ), $widget_ops );
	}

	/**
	 * Outputs the content for most view widget.
	 *
	 * @since 2.0.4
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for most view widget.
	 */
	public function widget( $args, $instance ) {
		global $post;

		/* Base Id Widget */
		$widget_id = $this->id_base . '-' . $this->number;

		/* Category ID */
		$category_ids = ( ! empty( $instance['category_ids'] ) ) ? array_map( 'absint', $instance['category_ids'] ) : array( 0 );

		/* Excerpt Length */
		$number_posts = ( ! empty( $instance['number_posts'] ) ) ? absint( $instance['number_posts'] ) : absint( 5 );

		/* Title Length */
		$title_length = ( ! empty( $instance['title_length'] ) ) ? absint( $instance['title_length'] ) : absint( 40 );

		/* Style */
		$layout_style = ( ! empty( $instance['layout_style'] ) ) ? wp_strip_all_tags( $instance['layout_style'] ) : wp_strip_all_tags( 'style_1' );

		// Link Title.
		$link_title = ( ! empty( $instance['link_title'] ) ) ? esc_url( $instance['link_title'] ) : '';

		/* Popular by date */
		$popular_date = ( isset( $instance['popular_date'] ) ) ? esc_attr( $instance['popular_date'] ) : esc_attr( 'alltime' );

		/* Hide current post */
		$hide_current_post = ( isset( $instance['hide_current_post'] ) ) ? (bool) $instance['hide_current_post'] : false;
		$show_thumb = ( isset( $instance['show_thumb'] ) ) ? (bool) $instance['show_thumb'] : false;

		
		/* Title */
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		
		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		if ( $title ) {
			if ( ! empty( $link_title ) ) {
				echo $args['before_title']; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */
				echo '<a href="' . esc_url( $link_title ) . '" title="' . esc_html__( '', 'lq-berita' ) . esc_html( $title ) . '">';
					echo $title; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */
				echo '</a>';
				echo $args['after_title']; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */
			} else {
				echo $args['before_title'] . $title . $args['after_title']; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */
			}
		}

		/* if 'all categories' was selected ignore other selections of categories */
		if ( in_array( 0, $category_ids, true ) ) {
			$category_ids = array( 0 );
		}

		/* filter the arguments for the Most view widget: */

		/* standard params */
		$query_args = array(
			'posts_per_page'         => $number_posts,
			'no_found_rows'          => true,
			'post_status'            => 'publish',
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
		);

		$query_args['ignore_sticky_posts'] = true;
		$query_args['orderby']  = 'meta_value_num';
		$query_args['meta_key'] = 'views';
		$query_args['order']    = 'DESC';
		

		if ( 'weekly' === $popular_date ) {
			/* Get posts last week */
			$query_args['date_query'] = array(
				array(
					'after' => '1 week ago',
				),
			);
		} elseif ( 'mountly' === $popular_date ) {
			/* Get posts last mount */
			$query_args['date_query'] = array(
				array(
					'after' => '1 month ago',
				),
			);
		} elseif ( 'secondmountly' === $popular_date ) {
			/* Get posts last mount */
			$query_args['date_query'] = array(
				array(
					'after' => '2 months ago',
				),
			);
		} elseif ( 'yearly' === $popular_date ) {
			/* Get posts last mount */
			$query_args['date_query'] = array(
				array(
					'after' => '1 year ago',
				),
			);
		}

		/* add categories param only if 'all categories' was not selected */
		if ( ! in_array( 0, $category_ids, true ) ) {
			$query_args['category__in'] = $category_ids;
		}

		/* exclude current displayed post */
		if ( $hide_current_post ) {
			if ( isset( $post->ID ) && is_singular() ) {
				$query_args['post__not_in'] = array( $post->ID );
			}
		}

		/* run the query: get the latest posts */
		$qlqb = new WP_Query( apply_filters( 'berita_mostview_Widget_posts_args', $query_args ) );
		?>
			<div class="lqb-recentposts-widget">
				<ul>
					<?php
					
					while ( $qlqb->have_posts() ) :
						$qlqb->the_post();
					?>
						
						<li class="listpost clearfix">
							<div class="lqb-list-item clearfix">
								<div class="lqb-list-row">
									<div class="lqb-list-cell">
										
											<div class="lqb-metacontent">
												<?php
												/* translators: used between list items, there is a space after the comma */
												$time_string = '<time class="meta-date-post published updated" ' . berita_itemprop_schema( 'dateModified' ) . ' datetime="%1$s">Published %2$s</time>';
												if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
													$time_string = '<time class="updated" datetime="%3$s">Published %4$s</time>';
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
										
										<div class="lqb-widget-link">
											<?php
											echo '<a href="' . esc_url( get_permalink() ) . '" itemprop="url" title="';
											the_title_attribute(
												array(
													'before' => __( '', 'lq-berita' ),
													'after'  => '',
												)
											);
											echo '">';
											if ( $post_title = $this->get_the_trimmed_post_title( $title_length ) ) {
												echo esc_html( $post_title );
											} else {
												the_title();
											}
											echo '</a>';
											?>
										</div>
									</div>
									<?php
									if ( $show_thumb ) :
										if ( has_post_thumbnail() ) :
										$urlx = wp_get_attachment_url( get_post_thumbnail_id($post->ID), 'thumbnail' );										
											?>
											<div class="table-cell lqb-post-thumb thumb-radius">
												<?php
												echo '<a href="' . esc_url( get_permalink() ) . '" itemprop="url" title="';
												the_title_attribute(
													array(
														'before' => __( '', 'lq-berita' ),
														'after'  => '',
													)
												);
												echo '">';
												$tag_alt = strip_tags(get_the_tag_list('',' , ',''));
												if ( !empty(get_the_post_thumbnail()) ) {
													the_post_thumbnail( 'medium_large', array( 'alt' => $tag_alt ));
												} else {
													echo '<img src="'. get_template_directory_uri() .'/no-image.png" alt="'. $tag_alt .'"/>';
												}												
												echo '</a>';
												?>
											</div>
											<?php
										endif;
									endif;
									?>
								</div>
							</div>
						</li>
					
						<?php
				endwhile;
					wp_reset_postdata();
					?>
				</ul>
			</div>
		<?php
		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Handles updating settings for the current most view widget instance.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            berita_Mostview::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance     = $old_instance;
		$new_instance = wp_parse_args(
			(array) $new_instance,
			array(
				'title'             => '',
				'link_title'        => '',
				'category_ids'      => array( 0 ),
				'number_posts'      => 5,
				'title_length'      => 40,
				'hide_current_post' => false,
				'popular_date'      => 'alltime',
				'show_view'         => false,
				'show_thumb'        => false,
			)
		);
		/* Title */
		$instance['title'] = sanitize_text_field( $new_instance['title'] );

		// Link Title.
		$instance['link_title'] = esc_url( $new_instance['link_title'] );

		/* Category IDs */
		$instance['category_ids'] = array_map( 'absint', $new_instance['category_ids'] );

		/* Number posts */
		$instance['number_posts'] = absint( $new_instance['number_posts'] );

		/* Title Length */
		$instance['title_length'] = absint( $new_instance['title_length'] );

		/* Hide current post */
		$instance['hide_current_post'] = (bool) $new_instance['hide_current_post'];

		/* Popular range */
		$instance['popular_date'] = esc_attr( $new_instance['popular_date'] );


		/* if 'all categories' was selected ignore other selections of categories */
		if ( in_array( 0, $instance['category_ids'], true ) ) {
			$instance['category_ids'] = array( 0 );
		}
		return $instance;
	}

	/**
	 * Outputs the settings form for the most view widget.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$instance = wp_parse_args(
			(array) $instance,
			array(
				'title'             => __( 'Most View', 'lq-berita' ),
				'link_title'        => '',
				'category_ids'      => array( 0 ),
				'number_posts'      => 5,
				'title_length'      => 40,
				'hide_current_post' => false,
				'popular_date'      => 'alltime',
				'show_view'         => true,
			)
		);
		/* Title */
		$title = sanitize_text_field( $instance['title'] );

		// Link Title.
		$link_title = esc_url( $instance['link_title'] );

		/* Category ID */
		$category_ids = array_map( 'absint', $instance['category_ids'] );

		/* Number posts */
		$number_posts = absint( $instance['number_posts'] );

		/* Title Length */
		$title_length = absint( $instance['title_length'] );

		/* Hide current post */
		$hide_current_post = (bool) $instance['hide_current_post'];

		/* Popular range */
		$popular_date = esc_attr( $instance['popular_date'] );

		
		/* get categories */
		$categories     = get_categories(
			array(
				'hide_empty'   => 0,
				'hierarchical' => 1,
			)
		);
		$number_of_cats = count( $categories );

		/* get size (number of rows to display) of selection box: not more than 10 */
		$number_of_rows = ( 10 > $number_of_cats ) ? $number_of_cats + 1 : 10;

		/* if 'all categories' was selected ignore other selections of categories */
		if ( in_array( 0, $category_ids, true ) ) {
			$category_ids = array( 0 );
		}

		/* start selection box */
		$selection_category  = sprintf(
			'<select name="%s[]" id="%s" class="cat-select widefat" multiple size="%d">',
			$this->get_field_name( 'category_ids' ),
			$this->get_field_id( 'category_ids' ),
			$number_of_rows
		);
		$selection_category .= "\n";

		/* make selection box entries */
		$cat_list = array();
		if ( 0 < $number_of_cats ) {

			/* make a hierarchical list of categories */
			while ( $categories ) {
				/* if there is no parent */
				if ( 0 === $categories[0]->parent ) {
					/* get and remove it from the categories list */
					$current_entry = array_shift( $categories );
					/* append the current entry to the new list */
					$cat_list[] = array(
						'id'    => absint( $current_entry->term_id ),
						'name'  => esc_html( $current_entry->name ),
						'depth' => 0,
					);
					/* go on looping */
					continue;
				}
				/**
				 * If there is a parent:
				 * try to find parent in new list and get its array index
				 */
				$parent_index = $this->get_cat_parent_index( $cat_list, $categories[0]->parent );
				/* if parent is not yet in the new list: try to find the parent later in the loop */
				if ( false === $parent_index ) {
					/* get and remove current entry from the categories list */
					$current_entry = array_shift( $categories );
					/* append it at the end of the categories list */
					$categories[] = $current_entry;
					/* go on looping */
					continue;
				}
				/**
				 * If there is a parent and parent is in new list:
				 * set depth of current item: +1 of parent's depth
				 */
				$depth = $cat_list[ $parent_index ]['depth'] + 1;
				/* set new index as next to parent index */
				$new_index = $parent_index + 1;
				/* find the correct index where to insert the current item */
				foreach ( $cat_list as $entry ) {
					/* if there are items with same or higher depth than current item */
					if ( $depth <= $entry['depth'] ) {
						/* increase new index */
						$new_index = $new_index++;
						/* go on looping in foreach() */
						continue;
					}
					/**
					 * If the correct index is found:
					 * get current entry and remove it from the categories list
					 */
					$current_entry = array_shift( $categories );

					/* insert current item into the new list at correct index */
					$end_array  = array_splice( $cat_list, $new_index ); /* $cat_list is changed, too */
					$cat_list[] = array(
						'id'    => absint( $current_entry->term_id ),
						'name'  => esc_html( $current_entry->name ),
						'depth' => $depth,
					);
					$cat_list   = array_merge( $cat_list, $end_array );
					/* quit foreach(), go on while-looping */
					break;
				} /* End foreach( cat_list ) */
			} /* End while( categories ) */

			/* make HTML of selection box */
			$selected            = ( in_array( 0, $category_ids, true ) ) ? ' selected="selected"' : '';
			$selection_category .= "\t";
			$selection_category .= '<option value="0"' . $selected . '>' . __( 'All Categories', 'lq-berita' ) . '</option>';
			$selection_category .= "\n";

			foreach ( $cat_list as $category ) {
				$cat_name            = apply_filters( 'lqb_list_cats', $category['name'], $category );
				$pad                 = ( 0 < $category['depth'] ) ? str_repeat( '&ndash;&nbsp;', $category['depth'] ) : '';
				$selection_category .= "\t";
				$selection_category .= '<option value="' . $category['id'] . '"';
				$selection_category .= ( in_array( $category['id'], $category_ids, true ) ) ? ' selected="selected"' : '';
				$selection_category .= '>' . $pad . $cat_name . '</option>';
				$selection_category .= "\n";
			}
		}

		/* close selection box */
		$selection_category .= "</select>\n";
		?>

		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'lq-berita' ); ?></label>
			<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'link_title' ) ); ?>"><?php esc_html_e( 'Link Title:', 'lq-berita' ); ?></label>
			<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'link_title' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'link_title' ) ); ?>" type="url" placeholder="<?php echo get_site_url(); ?>" value="<?php echo esc_attr( $link_title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'category_ids' ) ); ?>"><?php esc_html_e( 'Selected categories', 'lq-berita' ); ?></label>
			<?php echo $selection_category;   /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'number_posts' ) ); ?>"><?php esc_html_e( 'Number post', 'lq-berita' ); ?></label>
			<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'number_posts' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'number_posts' ) ); ?>" type="number" value="<?php echo esc_attr( $number_posts ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'popular_date' ) ); ?>"><?php esc_html_e( 'Popular range:', 'lq-berita' ); ?></label>
			<select class="widefat" id="<?php echo esc_html( $this->get_field_id( 'popular_date', 'lq-berita' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'popular_date' ) ); ?>">
				<option value="alltime" <?php selected( $instance['popular_date'], 'alltime' ); ?>><?php esc_html_e( 'Alltime', 'lq-berita' ); ?></option>
				<option value="yearly" <?php selected( $instance['popular_date'], 'yearly' ); ?>><?php esc_html_e( '1 Year', 'lq-berita' ); ?></option>
				<option value="secondmountly" <?php selected( $instance['popular_date'], 'secondmountly' ); ?>><?php esc_html_e( '2 Mounts', 'lq-berita' ); ?></option>
				<option value="mountly" <?php selected( $instance['popular_date'], 'mountly' ); ?>><?php esc_html_e( '1 Mount', 'lq-berita' ); ?></option>
				<option value="weekly" <?php selected( $instance['popular_date'], 'weekly' ); ?>><?php esc_html_e( '7 Days', 'lq-berita' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'title_length' ) ); ?>"><?php esc_html_e( 'Maximum length of title', 'lq-berita' ); ?></label>
			<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'title_length' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'title_length' ) ); ?>" type="number" value="<?php echo esc_attr( $title_length ); ?>" />
		</p>
		
		<?php
	}

	/**
	 * Return the array index of a given ID
	 *
	 * @since 1.0.0
	 * @param array $arr Array.
	 * @param int   $id Post ID.
	 * @access private
	 */
	private function get_cat_parent_index( $arr, $id ) {
		$len = count( $arr );
		if ( 0 === $len ) {
			return false;
		}
		$id = absint( $id );
		for ( $i = 0; $i < $len; $i++ ) {
			if ( $id === $arr[ $i ]['id'] ) {
				return $i;
			}
		}
		return false;
	}

	/**
	 * Returns the shortened post title, must use in a loop.
	 *
	 * @since 1.0.0
	 * @param int    $len Number text to display.
	 * @param string $more Text Button.
	 * @return string.
	 */
	private function get_the_trimmed_post_title( $len = 40, $more = '&hellip;' ) {

		/* get current post's post_title */
		$post_title = get_the_title();

		/* if post_title is longer than desired */
		if ( mb_strlen( $post_title ) > $len ) {
			/* get post_title in desired length */
			$post_title = mb_substr( $post_title, 0, $len );
			/* append ellipses */
			$post_title .= $more;
		}
		/* return text */
		return $post_title;
	}

}

add_action(
	'widgets_init',
	function() {
		register_widget( 'berita_mostview_widget' );
	}
);
=======
<?php
/**
 * Widget API: berita mostview widget class
 *
 * Author: xfebrian
 *
 * @package LQ Berita
 * @subpackage Widgets
 * @since 2.0.4
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class berita_mostview_widget extends WP_Widget {
	/**
	 * Sets up a Most view Posts widget instance.
	 *
	 * @since 2.0.4
	 * @access public
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'   => 'berita-mostview',
			'description' => __( 'Most view posts with thumbnails widget.', 'lq-berita' ),
		);
		parent::__construct( 'berita-mostview', __( 'Popular Post (LQBerita)', 'lq-berita' ), $widget_ops );
	}

	/**
	 * Outputs the content for most view widget.
	 *
	 * @since 2.0.4
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for most view widget.
	 */
	public function widget( $args, $instance ) {
		global $post;

		/* Base Id Widget */
		$widget_id = $this->id_base . '-' . $this->number;

		/* Category ID */
		$category_ids = ( ! empty( $instance['category_ids'] ) ) ? array_map( 'absint', $instance['category_ids'] ) : array( 0 );

		/* Excerpt Length */
		$number_posts = ( ! empty( $instance['number_posts'] ) ) ? absint( $instance['number_posts'] ) : absint( 5 );

		/* Title Length */
		$title_length = ( ! empty( $instance['title_length'] ) ) ? absint( $instance['title_length'] ) : absint( 40 );

		/* Style */
		$layout_style = ( ! empty( $instance['layout_style'] ) ) ? wp_strip_all_tags( $instance['layout_style'] ) : wp_strip_all_tags( 'style_1' );

		// Link Title.
		$link_title = ( ! empty( $instance['link_title'] ) ) ? esc_url( $instance['link_title'] ) : '';

		/* Popular by date */
		$popular_date = ( isset( $instance['popular_date'] ) ) ? esc_attr( $instance['popular_date'] ) : esc_attr( 'alltime' );

		/* Hide current post */
		$hide_current_post = ( isset( $instance['hide_current_post'] ) ) ? (bool) $instance['hide_current_post'] : false;
		$show_thumb = ( isset( $instance['show_thumb'] ) ) ? (bool) $instance['show_thumb'] : false;

		
		/* Title */
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		
		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		if ( $title ) {
			if ( ! empty( $link_title ) ) {
				echo $args['before_title']; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */
				echo '<a href="' . esc_url( $link_title ) . '" title="' . esc_html__( '', 'lq-berita' ) . esc_html( $title ) . '">';
					echo $title; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */
				echo '</a>';
				echo $args['after_title']; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */
			} else {
				echo $args['before_title'] . $title . $args['after_title']; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */
			}
		}

		/* if 'all categories' was selected ignore other selections of categories */
		if ( in_array( 0, $category_ids, true ) ) {
			$category_ids = array( 0 );
		}

		/* filter the arguments for the Most view widget: */

		/* standard params */
		$query_args = array(
			'posts_per_page'         => $number_posts,
			'no_found_rows'          => true,
			'post_status'            => 'publish',
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
		);

		$query_args['ignore_sticky_posts'] = true;
		$query_args['orderby']  = 'meta_value_num';
		$query_args['meta_key'] = 'views';
		$query_args['order']    = 'DESC';
		

		if ( 'weekly' === $popular_date ) {
			/* Get posts last week */
			$query_args['date_query'] = array(
				array(
					'after' => '1 week ago',
				),
			);
		} elseif ( 'mountly' === $popular_date ) {
			/* Get posts last mount */
			$query_args['date_query'] = array(
				array(
					'after' => '1 month ago',
				),
			);
		} elseif ( 'secondmountly' === $popular_date ) {
			/* Get posts last mount */
			$query_args['date_query'] = array(
				array(
					'after' => '2 months ago',
				),
			);
		} elseif ( 'yearly' === $popular_date ) {
			/* Get posts last mount */
			$query_args['date_query'] = array(
				array(
					'after' => '1 year ago',
				),
			);
		}

		/* add categories param only if 'all categories' was not selected */
		if ( ! in_array( 0, $category_ids, true ) ) {
			$query_args['category__in'] = $category_ids;
		}

		/* exclude current displayed post */
		if ( $hide_current_post ) {
			if ( isset( $post->ID ) && is_singular() ) {
				$query_args['post__not_in'] = array( $post->ID );
			}
		}

		/* run the query: get the latest posts */
		$qlqb = new WP_Query( apply_filters( 'berita_mostview_Widget_posts_args', $query_args ) );
		?>
			<div class="lqb-recentposts-widget">
				<ul>
					<?php
					
					while ( $qlqb->have_posts() ) :
						$qlqb->the_post();
					?>
						
						<li class="listpost clearfix">
							<div class="lqb-list-item clearfix">
								<div class="lqb-list-row">
									<div class="lqb-list-cell">
										
											<div class="lqb-metacontent">
												<?php
												/* translators: used between list items, there is a space after the comma */
												$time_string = '<time class="meta-date-post published updated" ' . berita_itemprop_schema( 'dateModified' ) . ' datetime="%1$s">Published %2$s</time>';
												if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
													$time_string = '<time class="updated" datetime="%3$s">Published %4$s</time>';
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
										
										<div class="lqb-widget-link">
											<?php
											echo '<a href="' . esc_url( get_permalink() ) . '" itemprop="url" title="';
											the_title_attribute(
												array(
													'before' => __( '', 'lq-berita' ),
													'after'  => '',
												)
											);
											echo '">';
											if ( $post_title = $this->get_the_trimmed_post_title( $title_length ) ) {
												echo esc_html( $post_title );
											} else {
												the_title();
											}
											echo '</a>';
											?>
										</div>
									</div>
									<?php
									
										if ( has_post_thumbnail() ) :
										$urlx = wp_get_attachment_url( get_post_thumbnail_id($post->ID), 'thumbnail' );										
											?>
											<div class="table-cell lqb-post-thumb thumb-radius">
												<?php
												echo '<a href="' . esc_url( get_permalink() ) . '" itemprop="url" title="';
												the_title_attribute(
													array(
														'before' => __( '', 'lq-berita' ),
														'after'  => '',
													)
												);
												echo '">';
												$tag_alt = strip_tags(get_the_tag_list('',' , ',''));
												if ( !empty(get_the_post_thumbnail()) ) {
													the_post_thumbnail( 'medium_large', array( 'alt' => $tag_alt ));
												} else {
													echo '<img src="'. get_template_directory_uri() .'/no-image.png" alt="'. $tag_alt .'"/>';
												}												
												echo '</a>';
												?>
											</div>
											<?php
										endif;
									
									?>
								</div>
							</div>
						</li>
					
						<?php
				endwhile;
					wp_reset_postdata();
					?>
				</ul>
			</div>
		<?php
		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Handles updating settings for the current most view widget instance.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            berita_Mostview::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance     = $old_instance;
		$new_instance = wp_parse_args(
			(array) $new_instance,
			array(
				'title'             => '',
				'link_title'        => '',
				'category_ids'      => array( 0 ),
				'number_posts'      => 5,
				'title_length'      => 40,
				'hide_current_post' => false,
				'popular_date'      => 'alltime',
				'show_view'         => true,
				'show_thumb'        => true,
			)
		);
		/* Title */
		$instance['title'] = sanitize_text_field( $new_instance['title'] );

		// Link Title.
		$instance['link_title'] = esc_url( $new_instance['link_title'] );

		/* Category IDs */
		$instance['category_ids'] = array_map( 'absint', $new_instance['category_ids'] );

		/* Number posts */
		$instance['number_posts'] = absint( $new_instance['number_posts'] );

		/* Title Length */
		$instance['title_length'] = absint( $new_instance['title_length'] );

		/* Hide current post */
		$instance['hide_current_post'] = (bool) $new_instance['hide_current_post'];

		/* Popular range */
		$instance['popular_date'] = esc_attr( $new_instance['popular_date'] );


		/* if 'all categories' was selected ignore other selections of categories */
		if ( in_array( 0, $instance['category_ids'], true ) ) {
			$instance['category_ids'] = array( 0 );
		}
		return $instance;
	}

	/**
	 * Outputs the settings form for the most view widget.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$instance = wp_parse_args(
			(array) $instance,
			array(
				'title'             => __( 'Most View', 'lq-berita' ),
				'link_title'        => '',
				'category_ids'      => array( 0 ),
				'number_posts'      => 5,
				'title_length'      => 40,
				'hide_current_post' => false,
				'popular_date'      => 'alltime',
				'show_view'         => true,
			)
		);
		/* Title */
		$title = sanitize_text_field( $instance['title'] );

		// Link Title.
		$link_title = esc_url( $instance['link_title'] );

		/* Category ID */
		$category_ids = array_map( 'absint', $instance['category_ids'] );

		/* Number posts */
		$number_posts = absint( $instance['number_posts'] );

		/* Title Length */
		$title_length = absint( $instance['title_length'] );

		/* Hide current post */
		$hide_current_post = (bool) $instance['hide_current_post'];

		/* Popular range */
		$popular_date = esc_attr( $instance['popular_date'] );

		
		/* get categories */
		$categories     = get_categories(
			array(
				'hide_empty'   => 0,
				'hierarchical' => 1,
			)
		);
		$number_of_cats = count( $categories );

		/* get size (number of rows to display) of selection box: not more than 10 */
		$number_of_rows = ( 10 > $number_of_cats ) ? $number_of_cats + 1 : 10;

		/* if 'all categories' was selected ignore other selections of categories */
		if ( in_array( 0, $category_ids, true ) ) {
			$category_ids = array( 0 );
		}

		/* start selection box */
		$selection_category  = sprintf(
			'<select name="%s[]" id="%s" class="cat-select widefat" multiple size="%d">',
			$this->get_field_name( 'category_ids' ),
			$this->get_field_id( 'category_ids' ),
			$number_of_rows
		);
		$selection_category .= "\n";

		/* make selection box entries */
		$cat_list = array();
		if ( 0 < $number_of_cats ) {

			/* make a hierarchical list of categories */
			while ( $categories ) {
				/* if there is no parent */
				if ( 0 === $categories[0]->parent ) {
					/* get and remove it from the categories list */
					$current_entry = array_shift( $categories );
					/* append the current entry to the new list */
					$cat_list[] = array(
						'id'    => absint( $current_entry->term_id ),
						'name'  => esc_html( $current_entry->name ),
						'depth' => 0,
					);
					/* go on looping */
					continue;
				}
				/**
				 * If there is a parent:
				 * try to find parent in new list and get its array index
				 */
				$parent_index = $this->get_cat_parent_index( $cat_list, $categories[0]->parent );
				/* if parent is not yet in the new list: try to find the parent later in the loop */
				if ( false === $parent_index ) {
					/* get and remove current entry from the categories list */
					$current_entry = array_shift( $categories );
					/* append it at the end of the categories list */
					$categories[] = $current_entry;
					/* go on looping */
					continue;
				}
				/**
				 * If there is a parent and parent is in new list:
				 * set depth of current item: +1 of parent's depth
				 */
				$depth = $cat_list[ $parent_index ]['depth'] + 1;
				/* set new index as next to parent index */
				$new_index = $parent_index + 1;
				/* find the correct index where to insert the current item */
				foreach ( $cat_list as $entry ) {
					/* if there are items with same or higher depth than current item */
					if ( $depth <= $entry['depth'] ) {
						/* increase new index */
						$new_index = $new_index++;
						/* go on looping in foreach() */
						continue;
					}
					/**
					 * If the correct index is found:
					 * get current entry and remove it from the categories list
					 */
					$current_entry = array_shift( $categories );

					/* insert current item into the new list at correct index */
					$end_array  = array_splice( $cat_list, $new_index ); /* $cat_list is changed, too */
					$cat_list[] = array(
						'id'    => absint( $current_entry->term_id ),
						'name'  => esc_html( $current_entry->name ),
						'depth' => $depth,
					);
					$cat_list   = array_merge( $cat_list, $end_array );
					/* quit foreach(), go on while-looping */
					break;
				} /* End foreach( cat_list ) */
			} /* End while( categories ) */

			/* make HTML of selection box */
			$selected            = ( in_array( 0, $category_ids, true ) ) ? ' selected="selected"' : '';
			$selection_category .= "\t";
			$selection_category .= '<option value="0"' . $selected . '>' . __( 'All Categories', 'lq-berita' ) . '</option>';
			$selection_category .= "\n";

			foreach ( $cat_list as $category ) {
				$cat_name            = apply_filters( 'lqb_list_cats', $category['name'], $category );
				$pad                 = ( 0 < $category['depth'] ) ? str_repeat( '&ndash;&nbsp;', $category['depth'] ) : '';
				$selection_category .= "\t";
				$selection_category .= '<option value="' . $category['id'] . '"';
				$selection_category .= ( in_array( $category['id'], $category_ids, true ) ) ? ' selected="selected"' : '';
				$selection_category .= '>' . $pad . $cat_name . '</option>';
				$selection_category .= "\n";
			}
		}

		/* close selection box */
		$selection_category .= "</select>\n";
		?>

		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'lq-berita' ); ?></label>
			<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'link_title' ) ); ?>"><?php esc_html_e( 'Link Title:', 'lq-berita' ); ?></label>
			<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'link_title' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'link_title' ) ); ?>" type="url" placeholder="<?php echo get_site_url(); ?>" value="<?php echo esc_attr( $link_title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'category_ids' ) ); ?>"><?php esc_html_e( 'Selected categories', 'lq-berita' ); ?></label>
			<?php echo $selection_category;   /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'number_posts' ) ); ?>"><?php esc_html_e( 'Number post', 'lq-berita' ); ?></label>
			<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'number_posts' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'number_posts' ) ); ?>" type="number" value="<?php echo esc_attr( $number_posts ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'popular_date' ) ); ?>"><?php esc_html_e( 'Popular range:', 'lq-berita' ); ?></label>
			<select class="widefat" id="<?php echo esc_html( $this->get_field_id( 'popular_date', 'lq-berita' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'popular_date' ) ); ?>">
				<option value="alltime" <?php selected( $instance['popular_date'], 'alltime' ); ?>><?php esc_html_e( 'Alltime', 'lq-berita' ); ?></option>
				<option value="yearly" <?php selected( $instance['popular_date'], 'yearly' ); ?>><?php esc_html_e( '1 Year', 'lq-berita' ); ?></option>
				<option value="secondmountly" <?php selected( $instance['popular_date'], 'secondmountly' ); ?>><?php esc_html_e( '2 Mounts', 'lq-berita' ); ?></option>
				<option value="mountly" <?php selected( $instance['popular_date'], 'mountly' ); ?>><?php esc_html_e( '1 Mount', 'lq-berita' ); ?></option>
				<option value="weekly" <?php selected( $instance['popular_date'], 'weekly' ); ?>><?php esc_html_e( '7 Days', 'lq-berita' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'title_length' ) ); ?>"><?php esc_html_e( 'Maximum length of title', 'lq-berita' ); ?></label>
			<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'title_length' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'title_length' ) ); ?>" type="number" value="<?php echo esc_attr( $title_length ); ?>" />
		</p>
		
		<?php
	}

	/**
	 * Return the array index of a given ID
	 *
	 * @since 1.0.0
	 * @param array $arr Array.
	 * @param int   $id Post ID.
	 * @access private
	 */
	private function get_cat_parent_index( $arr, $id ) {
		$len = count( $arr );
		if ( 0 === $len ) {
			return false;
		}
		$id = absint( $id );
		for ( $i = 0; $i < $len; $i++ ) {
			if ( $id === $arr[ $i ]['id'] ) {
				return $i;
			}
		}
		return false;
	}

	/**
	 * Returns the shortened post title, must use in a loop.
	 *
	 * @since 1.0.0
	 * @param int    $len Number text to display.
	 * @param string $more Text Button.
	 * @return string.
	 */
	private function get_the_trimmed_post_title( $len = 40, $more = '&hellip;' ) {

		/* get current post's post_title */
		$post_title = get_the_title();

		/* if post_title is longer than desired */
		if ( mb_strlen( $post_title ) > $len ) {
			/* get post_title in desired length */
			$post_title = mb_substr( $post_title, 0, $len );
			/* append ellipses */
			$post_title .= $more;
		}
		/* return text */
		return $post_title;
	}

}

add_action(
	'widgets_init',
	function() {
		register_widget( 'berita_mostview_widget' );
	}
);
>>>>>>> b9cdf76 (initial commit)
