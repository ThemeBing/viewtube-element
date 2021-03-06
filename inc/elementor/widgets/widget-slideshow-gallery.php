<?php 
namespace Elementor;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Slideshow Gallery
class viewtube_Widget_Slideshow_Gallery extends Widget_Base {
 
   public function get_name() {
      return 'slideshow_gallery';
   }
 
   public function get_title() {
      return esc_html__( 'Slideshow Gallery', 'viewtube' );
   }
 
   public function get_icon() { 
      return 'eicon-gallery-group';
   }
 
   public function get_categories() {
      return [ 'viewtube-elements' ];
   }

   protected function _register_controls() {

      $this->start_controls_section(
         'slideshow_gallery_section',
         [
            'label' => esc_html__( 'Slideshow Gallery', 'viewtube' ),
            'type' => Controls_Manager::SECTION,
         ]
      );

      $this->add_control(
         'layout', 
         [
            'label' => esc_html__('Choose Layout', 'viewtube'),
            'type' => Controls_Manager::SELECT,
            'default' => 'layout-1',
            'options' => [
               'layout-1'  => __( 'Layout 1', 'viewtube' ),
               'layout-2' => __( 'Layout 2', 'viewtube' )
            ]
         ]
      );

      $this->add_control(
         'category',
         [
            'label' => esc_html__( 'Category', 'viewtube' ),
            'type' => Controls_Manager::SELECT2, 
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
               'size' => 7,
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

  public function render( $instance = [] ) {
 
   // get our input from the widget settings.
   $settings = $this->get_settings_for_display(); 
   if ( $settings['layout'] == 'layout-1' ) { ?>
    <div class="slideshow-gallery">
     <div class="slider-for">
        <?php
        $post_block = new \WP_Query( array( 
           'post_type' => 'video',
           'cat' => $settings['category'],
           'posts_per_page' => $settings['ppp']['size'],
           'ignore_sticky_posts' => true,
           'order' => $settings['order'],
        ));
        /* Start the Loop */
        while ( $post_block->have_posts() ) : $post_block->the_post(); ?>

        <div class="slideshow-gallery-item">
          <div class="gallery-block-item style-1" style="background-image: url(<?php echo get_the_post_thumbnail_url(get_the_ID(),'full')?>);">
            <a href="<?php echo get_video_url(); ?>" class="popup-video"><i class="fa fa-play"></i></a>
             <div class="gallery-block-content">
                <h2>
                   <a href="<?php the_permalink() ?>">
                      <?php the_title(); ?>
                   </a>
                </h2>
                <ul class="list-inline mb-0">
                   <li class="list-inline-item">
                      <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>">
                        <img class="d-inline avatar rounded-circle" src="<?php echo esc_url( get_avatar_url( get_the_author_meta( 'ID' ),['size' => '32'] ) ); ?>" alt="<?php the_title_attribute() ?>">
                      </a>
                      <span class="ml-2"><?php the_author(); ?></span>
                   </li>
                   <li class="list-inline-item">
                      <i class="fas fa-tag"></i>
                      <?php $categories = get_the_terms( get_the_ID(), 'video_category' );
                      if ( ! empty( $categories ) ) {
                          echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
                      }?>
                   </li>
                   <li class="list-inline-item">
                      <i class="fas fa-burn"></i>
                      <span><?php echo esc_html(viewtube_get_post_views(get_the_ID())); ?></span>
                   </li>
                </ul>
             </div>
          </div>
        </div>
        
        <?php endwhile; 
        wp_reset_postdata(); ?>
     </div>
     <div class="slider-nav">
        <?php
        $post_block = new \WP_Query( array( 
           'post_type' => 'video',
           'cat' => $settings['category'],
           'posts_per_page' => $settings['ppp']['size'],
           'ignore_sticky_posts' => true,
           'order' => $settings['order'],
        ));
        /* Start the Loop */
        while ( $post_block->have_posts() ) : $post_block->the_post(); ?>

        <div class="slideshow-gallery-item pl-2 pr-2">
          <div class="gallery-block-item style-1" style="background-image: url(<?php echo get_the_post_thumbnail_url(get_the_ID(),'viewtube-260x146')?>);">
             <div class="gallery-block-content">
                <h5><?php echo mb_strimwidth( get_the_title(), 0, 40, '..' );?></h5>
             </div>
          </div>
        </div>
        
        <?php endwhile; 
        wp_reset_postdata(); ?>
     </div>
    </div>
    <?php } elseif( $settings['layout'] == 'layout-2' ) { ?>
    <div class="slideshow-gallery">
      <div class="row">
        <div class="col-md-9">
          <div class="slider-for-vertical">
              <?php
              $post_block = new \WP_Query( array( 
                 'post_type' => 'video',
                 'cat' => $settings['category'],
                 'posts_per_page' => $settings['ppp']['size'],
                 'ignore_sticky_posts' => true,
                 'order' => $settings['order'],
              ));
              /* Start the Loop */
              while ( $post_block->have_posts() ) : $post_block->the_post(); ?>

              <div class="slideshow-gallery-item">
                <div class="gallery-block-item style-1" style="background-image: url(<?php echo get_the_post_thumbnail_url(get_the_ID(),'full')?>);">
                  <a href="<?php echo get_video_url(); ?>" class="popup-video"><i class="fa fa-play"></i></a>
                   <div class="gallery-block-content">
                      <h2>
                         <a href="<?php the_permalink() ?>">
                            <?php the_title(); ?>
                         </a>
                      </h2>
                      <ul class="list-inline mb-0">
                         <li class="list-inline-item">
                            <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>">
                              <img class="d-inline avatar rounded-circle" src="<?php echo esc_url( get_avatar_url( get_the_author_meta( 'ID' ),['size' => '32'] ) ); ?>" alt="<?php the_title_attribute() ?>">
                            </a>
                            <span class="ml-2"><?php the_author(); ?></span>
                         </li>
                         <li class="list-inline-item">
                            <i class="fas fa-tag"></i>
                            <?php $categories = get_the_terms( get_the_ID(), 'video_category' );
                            if ( ! empty( $categories ) ) {
                                echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
                            }?>
                         </li>
                         <li class="list-inline-item">
                            <i class="fas fa-burn"></i>
                            <span><?php echo esc_html(viewtube_get_post_views(get_the_ID())); ?></span>
                         </li>
                      </ul>
                   </div>
                </div>
              </div>
              <?php endwhile; 
              wp_reset_postdata(); ?>
          </div>
        </div>
        <div class="col-md-3 d-none d-md-block">
          <div class="slider-nav-vertical">
            <?php
            $post_block = new \WP_Query( array( 
               'post_type' => 'video',
               'cat' => $settings['category'],
               'posts_per_page' => $settings['ppp']['size'],
               'ignore_sticky_posts' => true,
               'order' => $settings['order'],
            ));
            /* Start the Loop */
            while ( $post_block->have_posts() ) : $post_block->the_post(); ?>

            <div class="slideshow-gallery-item pl-2 pr-2">
              <div class="gallery-block-item style-1" style="background-image: url(<?php echo get_the_post_thumbnail_url(get_the_ID(),'viewtube-260x146')?>);">
                 <div class="gallery-block-content">
                    <h5><?php echo mb_strimwidth( get_the_title(), 0, 40, '..' );?></h5>
                 </div>
              </div>
            </div>
            
            <?php endwhile; 
            wp_reset_postdata(); ?>
         </div>
        </div>
      </div>
    </div>
    <?php }
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new viewtube_Widget_Slideshow_Gallery );