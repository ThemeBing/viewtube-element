<?php 
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
// Product categories
class viewtube_Widget_Product_Cat extends Widget_Base {
 
   public function get_name() {
      return 'product_cat';
   }
 
   public function get_title() {
      return esc_html__( 'Product categories', 'viewtube' );
   }
 
   public function get_icon() { 
        return 'eicon-posts-carousel';
   }
 
   public function get_categories() {
      return [ 'viewtube-elements' ];
   }
   protected function _register_controls() {

      $this->start_controls_section(
         'product_cat_section',
         [
            'label' => esc_html__( 'Product categories', 'viewtube' ),
            'type' => Controls_Manager::SECTION,
         ]
      );


      $this->add_control(
         'style',
         [
            'label' => __( 'Style', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'style-1',
            'options' => [
               'style-1'  => __( 'Style 1', 'viewtube' ),
               'style-2' => __( 'Style 2', 'viewtube' )
            ],
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
               'taxonomy' => 'product_cat',
               'hide_empty' => false,
               'parent' => 0
            ]),
         ]
      );
      
      $this->end_controls_section();
   }

  protected function render( $instance = [] ) {

    // get our input from the widget settings.     
    $settings = $this->get_settings_for_display();

      $terms = get_terms( array (
        'taxonomy' => 'product_cat', 
        'orderby' => 'name',
        'hide_empty' => true,
        'include' => $settings['category']
      ));

      if ( $terms ) {

        foreach ( $terms as $term ) { ?>

         <?php if ($settings['style'] == 'style-1') { ?>

            <a class="category-item text-center" href="<?php echo esc_url( get_term_link( $term ) ); ?>">
              <span class="category-item-img">
                <?php
                $image = wp_get_attachment_url( get_term_meta( $term->term_id, 'thumbnail_id', true ));
                if ( $image ) { ?>
                <img src="<?php echo esc_attr( $image ) ?>" alt="<?php echo esc_attr( $term->name ) ?>">
                <?php } ?>
               </span>
               <h5><?php echo esc_html( $term->name ) ?></h5>
            </a>

         <?php } elseif($settings['style'] == 'style-2') { ?>

            <div class="category-item-2">
              <a href="<?php echo esc_url( get_term_link( $term ) ); ?>">
               <?php
               $image = wp_get_attachment_url( get_term_meta( $term->term_id, 'thumbnail_id', true ));
               if ( $image ) { ?>
                <img src="<?php echo esc_attr( $image ) ?>" alt="<?php echo esc_attr( $term->name ) ?>">
               <?php } ?>
                <span><?php echo esc_html( $term->name ) ?></span>
              </a>
            </div>
            
        <?php }
      }
    }
  }
 
}

Plugin::instance()->widgets_manager->register_widget_type( new viewtube_Widget_Product_Cat );