<?php 
namespace Elementor;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Banner 2
class viewtube_Widget_Banner_2 extends Widget_Base {
 
   public function get_name() {
      return 'banner2';
   }
 
   public function get_title() {
      return esc_html__( 'Banner 2', 'viewtube' );
   }
 
   public function get_icon() { 
        return 'eicon-banner';
   }
 
   public function get_categories() {
      return [ 'viewtube-elements' ];
   }

   protected function _register_controls() {

      $this->start_controls_section(
         'banner2_section',
         [
            'label' => esc_html__( 'Banner 2', 'viewtube' ),
            'type' => Controls_Manager::SECTION,
         ]
      );

      $this->add_control(
         'title',
         [
            'label' => __( 'Title', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => __('Discover the best Apps and Games','viewtube' )
         ]
      );

      $this->add_control(
         'description',
         [
            'label' => __( 'Description', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => __('Discover the best of viewtube. A rotating selection of delightful apps and exciting games, handpicked by the viewtube editors.','viewtube' )
         ]
      );

      $this->add_control(
        'text_color',
        [
          'label' => __( 'Text Color', 'viewtube' ),
          'type' => \Elementor\Controls_Manager::COLOR,
          'scheme' => [
            'type' => \Elementor\Scheme_Color::get_type(),
            'value' => \Elementor\Scheme_Color::COLOR_1,
          ],
        ]
      );

      $this->add_control(
         'button_url',
         [
            'label' => __( 'Button url', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => '#'
         ]
      );

      $this->add_control(
         'button_text',
         [
            'label' => __( 'Button text', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('Discover Apps','viewtube' )
         ]
      );
            
      $this->end_controls_section();

   }

  protected function render( $instance = [] ) {
 
      // get our input from the widget settings.
       
      $settings = $this->get_settings_for_display(); ?>
      
      <section class="banner-2">
        <div class="container">
          <div class="row">
            <div class="col-lg-6 col-md-12 my-auto">
              <div class="banner-content">
                <h1 style="color: <?php echo esc_attr( $settings['text_color']) ?> ">
                  <?php echo esc_html( $settings['title'] ); ?>
                </h1>
                <p style="color: <?php echo esc_attr( $settings['text_color']) ?> "><?php echo esc_html($settings['description']); ?></p>
                <a class="viewtube-btn mt-50" href="<?php echo esc_url( $settings['button_url'] ); ?>"><?php echo esc_html( $settings['button_text'] ); ?></a>
              </div>
            </div>

            <div class="col-lg-5 col-md-12 mt-md-5 offset-lg-1 my-auto">
              <div class="banner-icons-2">
                <?php 
                $products = new \WP_Query( array( 
                  'post_type' => 'product',
                  'posts_per_page' => 9
                ));

                /* Start the Loop */
                while ( $products->have_posts() ) : $products->the_post(); ?>
                  <div class="banner-icon-2">
                    <?php if ( has_post_thumbnail() ){ ?>
                      <a href="<?php the_permalink() ?>">
                        <?php the_post_thumbnail('viewtube-400-400'); ?>
                      </a>
                    <?php } else { ?>
                      <a href="<?php the_permalink() ?>"><img src="<?php echo get_template_directory_uri().'/assets/images/placeholder.png' ?>" alt="<?php the_title_attribute() ?>"></a>
                    <?php } ?>
                  </div>
                <?php endwhile; wp_reset_postdata(); ?>
              </div>
            </div>
          </div>
        </div>
      </section>

      <?php
   }
 
}

Plugin::instance()->widgets_manager->register_widget_type( new viewtube_Widget_Banner_2 );