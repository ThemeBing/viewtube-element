<?php 
namespace Elementor;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
// blog
class viewtube_Widget_Blog extends Widget_Base {
 
   public function get_name() {
      return 'blog';
   }
 
   public function get_title() {
      return esc_html__( 'Latest Blog', 'viewtube' );
   }
 
   public function get_icon() { 
        return 'eicon-posts-carousel';
   }
 
   public function get_categories() {
      return [ 'viewtube-elements' ];
   }
   protected function _register_controls() {

      $this->start_controls_section(
         'blog_section',
         [
            'label' => esc_html__( 'Blog', 'viewtube' ),
            'type' => Controls_Manager::SECTION,
         ]
      );

      $this->add_control(
         'columns',
         [
            'label' => __( 'Columns', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'col-xl-4',
            'options' => [
               'col-xl-12'  => __( 'Column 1', 'viewtube' ),
               'col-xl-6' => __( 'Column 2', 'viewtube' ),
               'col-xl-4 col-md-6' => __( 'Column 3', 'viewtube' ),
               'col-xl-3 col-lg-4 col-md-6' => __( 'Column 4', 'viewtube' ),
               'col-xl-2' => __( 'Column 6', 'viewtube' ),
               'col-xl-1' => __( 'Column 12', 'viewtube' ),
            ],
         ]
      );

      $this->add_control(
         'ppp',
         [
            'label' => __( 'Number of Items', 'viewtube' ),
            'type' => Controls_Manager::SLIDER,
            'range' => [
               'no' => [
                  'min' => 0,
                  'max' => 100,
                  'step' => 1,
               ],
            ],
            'default' => [
               'size' => 3,
            ]
         ]
      );

      $this->add_control(
         'order',
         [
            'label' => __( 'Order', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'DESC',
            'options' => [
               'ASC'  => __( 'Ascending', 'viewtube' ),
               'DESC' => __( 'Descending', 'viewtube' )
            ],
         ]
      );

      $this->end_controls_section();
   }

   protected function render( $instance = [] ) {
 
      // get our input from the widget settings.
       
      $settings = $this->get_settings_for_display();
      
      //Inline Editing
      $this->add_inline_editing_attributes( 'ppp', 'basic' );
      ?>

      <div class="row">
         <?php
         $blog = new \WP_Query( array( 
            'post_type' => 'post',
            'posts_per_page' => $settings['ppp']['size'],
            'ignore_sticky_posts' => true,
            'order' => $settings['order'],
         ));
         /* Start the Loop */
         while ( $blog->have_posts() ) : $blog->the_post();
         ?>
         <!-- blog -->
         <div class="<?php echo esc_attr($settings['columns']) ?> col-md-6">
            <div class="blog-item">
               <?php if (has_post_thumbnail()): ?>
               <div class="blog-thumb">
                  <a href="<?php the_permalink() ?>">
                     <?php the_post_thumbnail( 'viewtube-600x399' ) ?>
                  </a>
               </div>
               <?php endif ?> 
               <div class="blog-content">
                  <div class="blog-meta">
                     <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>">
                     <img src="<?php echo esc_url( get_avatar_url( get_the_author_meta( 'ID' ) ) ); ?>" alt="<?php the_author(); ?>"></a>
                     <span class="pr-10"> <?php the_author(); ?></span>
                     |
                     <span class="pl-10">
                        <?php $categories = get_the_category();
                        if ( ! empty( $categories ) ) {
                            echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
                        }?>
                     </span>
                  </div>
                  <h4><a href="<?php the_permalink() ?>"><?php echo mb_strimwidth( get_the_title(), 0, 50, ' ..' );?></a></h4>
                  <p><?php echo wp_trim_words( get_the_content(), 12, '...' );?></p>
               </div>
            </div>
         </div>
         <?php 
         endwhile; 
         wp_reset_postdata();
         ?>
      </div>
      <?php
   }
 
}
Plugin::instance()->widgets_manager->register_widget_type( new viewtube_Widget_Blog );