<?php 
namespace Elementor;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
// Video
class viewtube_Widget_Video extends Widget_Base {
 
   public function get_name() {
      return 'video';
   }
 
   public function get_title() {
      return esc_html__( 'Video', 'viewtube' );
   }
 
   public function get_icon() { 
        return 'eicon-youtube';
   }
 
   public function get_categories() {
      return [ 'viewtube-elements' ];
   }
   protected function _register_controls() {

      $this->start_controls_section(
         'video_section',
         [
            'label' => esc_html__( 'Video', 'viewtube' ),
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
         'slide',
         [
            'label' => __( 'Slide', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __( 'On', 'viewtube' ),
            'label_off' => __( 'Off', 'viewtube' ),
            'return_value' => 'true',
            'default' => true,
         ]
      );

      $this->add_control(
         'slidestoshow',
         [
            'label' => __('Slides To Show', 'viewtube' ),
            'type' => Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 100,
            'step' => 1,
            'default' => 4,
            'condition' => [
               'slide' => 'true'
            ]
         ]
      );

      $this->add_control(
         'slidestoscroll',
         [
            'label' => __( 'Slides To Scroll', 'viewtube' ),
            'type' => Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 10,
            'step' => 1,
            'default' => 4,
            'condition' => [
               'slide' => 'true'
            ]
         ]
      );

      $this->add_control(
         'category',
         [
            'label' => esc_html__( 'Category', 'viewtube' ),
            'type' => Controls_Manager::SELECT, 
            'title' => esc_html__( 'Select a category', 'viewtube' ),
            'multiple' => true,
            'options' => viewtube_get_terms_dropdown_array([
               'taxonomy' => 'video_category',
               'hide_empty' => false,
               'parent' => 0
            ]),
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

      <div class="row justify-content-center <?php if($settings['slide']){echo'video-items';} ?>" data-slick='{"slidesToShow": <?php echo esc_attr( $settings['slidestoshow'] ) ?>, "slidesToScroll": <?php echo esc_attr( $settings['slidestoscroll'] ) ?>}'>
         <?php

         $video = new \WP_Query( array( 
            'post_type' => 'video',
            'posts_per_page' => $settings['ppp']['size'],
            'ignore_sticky_posts' => true,
            'order' => $settings['order'],
            'tax_query' => array(
               array(
                  'taxonomy'  => 'video_category',
                  'field'     => 'id', 
                  'terms'     =>  $settings['category']
               )
            )
         ));
         /* Start the Loop */
         while ( $video->have_posts() ) : $video->the_post();
         ?>
         <!-- video -->
         <div class="<?php echo esc_attr($settings['columns']) ?> col-md-6">
            <div class="video-item-card">
               <?php if (has_post_thumbnail()): ?>
               <div class="video-thumb">
                  <?php do_action( 'video_player','viewtube-player' ); ?>
               </div>
               <?php endif ?> 
               <div class="video-content">
                  <div class="d-flex">
                     <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>" class="avatar">
                        <img src="<?php echo esc_url( get_avatar_url( get_the_author_meta( 'ID' ) ) ); ?>" alt="<?php the_author(); ?>">
                     </a>
                     <div>
                        <a href="<?php the_permalink() ?>">
                           <h5><?php echo mb_strimwidth( get_the_title(), 0, 60, '..' );?></h5>
                        </a>
                        <a class="author" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>">
                           <?php the_author(); ?>
                        </a>
                        <?php $categories = get_the_category();
                        if ( ! empty( $categories ) ) {
                            echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
                        }?>

                        <div class="d-flex video-meta-bottom">     
                           <?php echo esc_html(viewtube_get_post_views(get_the_ID())); ?>
                           <i class="fas fa-circle ml-2 mr-2"></i>
                           <?php echo esc_html( human_time_diff( get_the_time('U'), current_time('timestamp') ) ) . ' ago'; ?>
                        </div>
                     </div>
                  </div>
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
Plugin::instance()->widgets_manager->register_widget_type( new viewtube_Widget_Video );