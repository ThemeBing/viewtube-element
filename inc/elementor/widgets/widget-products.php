<?php 
namespace Elementor;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Products
class viewtube_Widget_products extends Widget_Base {
 
   public function get_name() {
      return 'Products';
   }
 
   public function get_title() {
      return esc_html__( 'Products', 'viewtube' );
   }
 
   public function get_icon() { 
        return 'eicon-form-vertical';
   }
 
   public function get_categories() {
      return [ 'viewtube-elements' ];
   }

   protected function _register_controls() {

      $this->start_controls_section(
         'products_section',
         [
            'label' => esc_html__( 'Products', 'viewtube' ),
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
               'style-2' => __( 'Style 2', 'viewtube' ),
               'style-3' => __( 'Style 3', 'viewtube' ),
               'style-4' => __( 'Style 4', 'viewtube' )
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
         'title_switch',
         [
            'label' => __( 'Title Switch', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __( 'On', 'viewtube' ),
            'label_off' => __( 'Off', 'viewtube' ),
            'default' => true,
         ]
      );

      $this->add_control(
         'section_title',
         [
            'label' => __( 'Section Title', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('Just updated','viewtube' )
         ]
      );

      $this->add_control(
         'readmore_switch',
         [
            'label' => __( 'Readmore Switch', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __( 'On', 'viewtube' ),
            'label_off' => __( 'Off', 'viewtube' ),
            'default' => false,
         ]
      );

      $this->add_control(
         'readmore_text',
         [
            'label' => __( 'Read more Text', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('Read more','viewtube' )
         ]
      );

      $this->add_control(
         'readmore_url',
         [
            'label' => __( 'Read more URL', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => '#'
         ]
      );

      $this->add_control(
         'product_by',
         [
            'label' => __( 'Product By', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [
               'top-rated'  => __( 'Top Rated', 'viewtube' ),
               'on-sale' => __( 'On Sale', 'viewtube' ),
               'best-selling' => __( 'Best Selling', 'viewtube' ),
               'featured' => __( 'Featured', 'viewtube' )
            ],
         ]
      );

      $this->add_control(
         'columns',
         [
            'label' => __( 'Columns', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'col-xl-2 col-lg-3 col-sm-6',
            'options' => [
               'col-xl-12'  => __( 'Column 1', 'viewtube' ),
               'col-xl-6' => __( 'Column 2', 'viewtube' ),
               'col-xl-4 col-md-6' => __( 'Column 3', 'viewtube' ),
               'col-xl-3 col-lg-4 col-md-6' => __( 'Column 4', 'viewtube' ),
               'col-xl-2 col-lg-3 col-sm-6' => __( 'Column 6', 'viewtube' ),
               'col-xl-1' => __( 'Column 12', 'viewtube' ),
            ],
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
               'taxonomy' => 'product_cat',
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
               'size' => 6,
            ]
         ]
      );

      $this->add_control(
         'order',
         [
            'label' => __( 'order', 'viewtube' ),
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
       
      $settings = $this->get_settings_for_display(); ?>

      <div class="container">

      <?php if ($settings['title_switch'] == true){ ?>
         <div class="row section-title-bar">
            <div class="col-6">
               <?php if ($settings['title_switch'] == true){ ?>
                  <h2><?php echo esc_html( $settings['section_title'] ) ?></h2>
               <?php } ?>
            </div>
            <div class="col-6">
               <?php if ($settings['readmore_switch'] == true){ ?>
                  <a href="<?php echo esc_url( $settings['readmore_url'] ) ?>"><?php echo esc_html( $settings['readmore_text'] ) ?></a>
               <?php } ?>
            </div>
         </div>
      <?php } ?>
      

      <div class="row justify-content-center <?php if($settings['slide']){echo'product-items';} ?>" data-slick='{"slidesToShow": <?php echo esc_attr( $settings['slidestoshow'] ) ?>, "slidesToScroll": <?php echo esc_attr( $settings['slidestoscroll'] ) ?>}'>
         <?php

         $category = !empty( $settings['category'] ) ? $settings['category'] : 'All';
         
         // meta_key condition
         if ( $settings['product_by'] == 'best-selling' ) {
            $product_by = 'total_sales';
         } elseif ( $settings['product_by'] == 'top-rated' ) {
            $product_by = '_wc_average_rating';
         } else {
            $product_by = '';
         }

         if ( $settings['product_by'] == 'on-sale' ) {
            $meta_query[] = array(
               'relation' => 'OR',
                  array( // Simple products type
                     'key'           => '_sale_price',
                     'value'         => 0,
                     'compare'       => '>',
                     'type'          => 'numeric'
                  ),
                  array( // Variable products type
                     'key'           => '_min_variation_sale_price',
                     'value'         => 0,
                     'compare'       => '>',
                     'type'          => 'numeric'
                  ),
            );
         }

         if ( $settings['product_by'] == 'featured' ) {
            $tax_query[] = array(
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => 'featured',
                'operator' => 'IN', // or 'NOT IN' to exclude feature products
            );
         } else {
            $tax_query[] = array(
               array(
                  'taxonomy'  => 'product_cat',
                  'field'     => 'id', 
                  'terms'     => $category
               )
            );
         }


         $products = new \WP_Query( array( 
            'post_type' => 'product',
            'meta_key' => $product_by,
            'orderby' => $settings['product_by'] == 'best-selling' || $settings['product_by'] == 'top-rated' ? 'meta_value_num' : "",
            'posts_per_page' => $settings['ppp']['size'],
            'order' => $settings['order'],
            'tax_query' => $tax_query,
            'meta_query' => $meta_query
         ));


         /* Start the Loop */
         while ( $products->have_posts() ) : $products->the_post();

         global $product;
         global $viewtube_opt; 
         $product_title_length = isset( $viewtube_opt['product_title_length'] ) ? $viewtube_opt['product_title_length'] : 25;
         $image_id = $product->get_gallery_image_ids()[0]; ?>
            <!-- Item -->
            <div class="<?php echo esc_attr($settings['columns']) ?>">
               <?php if ($settings['style'] == 'style-1') { ?>
                  <?php do_action( 'get_viewtube_product_item' ) ?>
               <?php } elseif($settings['style'] == 'style-2') { ?>
                  <?php do_action( 'get_viewtube_product_item_left_image' ) ?>
               <?php } elseif($settings['style'] == 'style-3') { ?>
                  <?php do_action( 'get_viewtube_product_item_3' ) ?>
               <?php } elseif($settings['style'] == 'style-4') { ?>
                  <?php do_action( 'get_viewtube_product_item_4' ) ?>
               <?php } ?>
            </div>

         <?php 
         endwhile; 
         wp_reset_postdata();
         ?>
         </div>
      </div>
   <?php
   }
 
}

Plugin::instance()->widgets_manager->register_widget_type( new viewtube_Widget_products );