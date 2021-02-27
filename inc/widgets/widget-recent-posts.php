<?php
/**
 * Adds Recent post Widget.
 * @package viewtube
 */
if( !class_exists('viewtube_Recent_Post') ){
	class viewtube_Recent_Post extends WP_Widget{
		/**
		 * Register widget with WordPress.
		 */
		function __construct(){

			$widget_options = array(
				'description' 					=> esc_html__('ViewTube Blog Recent Post Here', 'viewtube'), 
				'customize_selective_refresh' 	=> true,
			);

			parent:: __construct('viewtube_Recent_Post', esc_html__( 'ViewTube : Recent Post', 'viewtube'), $widget_options );

		}
		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 *
		 * @param array $args     Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		public function widget($args, $instance){

			if ( ! isset( $args['widget_id'] ) ) {

			$args['widget_id'] = $this->id;

		}
		
		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Recent Posts','viewtube' );
		
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$style = ( ! empty( $instance['style'] ) ) ? absint( $instance['style'] ) : true;
		$show_item = ( ! empty( $instance['show_item'] ) ) ? absint( $instance['show_item'] ) : 3;
		$title_length = ( ! empty( $instance['title_length'] ) ) ? absint( $instance['title_length'] ) : 75;


			echo $args['before_widget']; 
			if ( $title ): 
		    echo $args['before_title'];  
			echo esc_attr( $title );  
		 	echo $args['after_title']; 
			endif;

				$posts = new WP_Query(array(
					'post_type'      => 'post',
					'posts_per_page' => $show_item,
					'ignore_sticky_posts' => true,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'post_format',
                            'field' => 'slug',
                            'terms' => array('post-format-aside', 'post-format-gallery', 'post-format-link', 'post-format-image', 'post-format-quote', 'post-format-status', 'post-format-audio', 'post-format-chat', 'post-format-video'),
                                'operator' => 'NOT IN'
                            )
                        )
				));

				?>
				<?php if ($style == 0) { ?>
					<div class="row no-gutters sidebar-recent-post-grid">
						<?php while($posts->have_posts()) : $posts->the_post();  ?>
							<div class="col-4">
								<a href="<?php the_permalink() ?>">
						        	<?php the_post_thumbnail( 'viewtube-200x160' ); ?>
						        </a>
							</div>
						<?php endwhile; ?>
					</div>
				<?php } else { ?>
				<ul class="sidebar-recent-post">
					<?php while($posts->have_posts()) : $posts->the_post();  ?>
					<li>
						<?php if (has_post_thumbnail( )): ?>
						<div class="recent-post-thumb">
					        <a href="<?php the_permalink() ?>">
					        	<?php the_post_thumbnail( 'viewtube-200x160' ); ?>
					        </a>
					    </div>
						<?php endif ?>
					    <div class="recent-post-content">
					        <p>
					        	<a href="<?php the_permalink() ?>"><?php echo mb_strimwidth( get_the_title(), 0, $title_length, '...' ); ?></a>
					        </p>
					        <span><?php echo get_the_date() ?></span>
					    </div>
					</li>
					<?php endwhile; ?>
				</ul>	
				<?php } ?>

				


			<?php echo $args['after_widget']; ?>
			
			<?php wp_reset_postdata();
		}
		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @see WP_Widget::update()
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 *
		 * @return array Updated safe values to be saved.
		 */
		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = sanitize_text_field( $new_instance['title'] );
			$instance['style'] = $new_instance['style'];
			$instance['show_item'] = (int) $new_instance['show_item'];
			$instance['title_length'] = (int) $new_instance['title_length'];
			return $instance;
		}

	 	/**
		 * Back-end widget form.
		 *
		 * @see WP_Widget::form()
		 *
		 * @param array $instance Previously saved values from database.
		 */

		public function form( $instance ) {

		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$show_item    = isset( $instance['show_item'] ) ? absint( $instance['show_item'] ) : 5;
		$title_length    = isset( $instance['title_length'] ) ? absint( $instance['title_length'] ) : 75; ?>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php echo esc_html__( 'Title:','viewtube' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" size="75"/></p>		
		
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance[ 'style' ], 'on' ); ?> id="<?php echo $this->get_field_id( 'style' ); ?>" name="<?php echo $this->get_field_name( 'style' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'style' ); ?>"><?php _e( 'Grid Style' ); ?></label>

		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title_length' )); ?>"><?php echo esc_html__( 'Title length:','viewtube' ); ?></label>
			<input class="tiny-text" id="<?php echo esc_attr(esc_attr($this->get_field_id( 'title_length' ))); ?>" name="<?php echo esc_attr($this->get_field_name( 'title_length' )); ?>" type="number" step="1" min="1" value="<?php echo esc_attr($title_length); ?>" size="75" />
		</p>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'show_item' )); ?>"><?php echo esc_html__( 'No. of Item of posts to show:','viewtube' ); ?></label>
			<input class="tiny-text" id="<?php echo esc_attr(esc_attr($this->get_field_id( 'show_item' ))); ?>" name="<?php echo esc_attr($this->get_field_name( 'show_item' )); ?>" type="number" step="1" min="1" value="<?php echo esc_attr($show_item); ?>" size="3" />
		</p>

	<?php
		}
	}
}



// register Contact  Widget widget
function viewtube_Recent_Post(){
	register_widget('viewtube_Recent_Post');
}
add_action('widgets_init','viewtube_Recent_Post');
