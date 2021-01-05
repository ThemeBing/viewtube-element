<?php 
namespace Elementor;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Banner
class viewtube_Widget_Banner extends Widget_Base {
 
   public function get_name() {
      return 'banner';
   }
 
   public function get_title() {
      return esc_html__( 'Banner', 'viewtube' );
   }
 
   public function get_icon() { 
        return 'eicon-banner';
   }
 
   public function get_categories() {
      return [ 'viewtube-elements' ];
   }

   protected function _register_controls() {

      $this->start_controls_section(
         'banner_section',
         [
            'label' => esc_html__( 'Banner', 'viewtube' ),
            'type' => Controls_Manager::SECTION,
         ]
      );

      $banner = new \Elementor\Repeater();

      $banner->add_control(
        'image',
        [
          'label' => __( 'Choose Image', 'viewtube' ),
          'type' => \Elementor\Controls_Manager::MEDIA,
          'default' => [
            'url' => \Elementor\Utils::get_placeholder_image_src(),
          ],
        ]
      );

      $banner->add_control(
         'title',
         [
            'label' => __( 'Title', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => __('Watch the ViewTube Streamy Awards Show','viewtube' )
         ]
      );


      $banner->add_control(
         'description',
         [
            'label' => __( 'Description', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => __('Discover the best of viewtube. A rotating selection of delightful apps and exciting games, handpicked by the viewtube editors.','viewtube' )
         ]
      );

      $banner->add_control(
         'button_url',
         [
            'label' => __( 'Button url', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => '#'
         ]
      );

      $banner->add_control(
         'button_text',
         [
            'label' => __( 'Button text', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('Watch Video','viewtube' )
         ]
      );

      $this->add_control(
         'banners',
         [
            'label' => __( 'Banners', 'medicament' ),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $banner->get_controls(),
            'title_field' => 'Banner item',
            'title_field' => '{{{ title }}}',
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

      $this->end_controls_section();

   }

  protected function render( $instance = [] ) {
 
      // get our input from the widget settings.
       
      $settings = $this->get_settings_for_display(); ?>

      <div class="banners">
        <?php foreach (  $settings['banners'] as $banner ) { ?>
          <section class="banner" style="background: url(<?php echo esc_url( $banner['image']['url'] ) ?>);">
            <div class="container">
              <div class="row">
                <div class="col-lg-6 my-auto">
                  <div class="banner-content">
                    <h1 style="color: <?php echo esc_attr( $settings['text_color']) ?> ">
                      <?php echo esc_html( $banner['title'] ); ?>
                    </h1>
                    <p style="color: <?php echo esc_attr( $settings['text_color']) ?> "><?php echo esc_html($banner['description']); ?></p>
                    <a class="viewtube-btn mt-50" href="<?php echo esc_url( $banner['button_url'] ); ?>"><?php echo esc_html( $banner['button_text'] ); ?></a>
                  </div>
                </div>

                <div class="col-lg-6 my-auto">
                  <div class="banner-icons">
                    <?php 
                    $products = new \WP_Query( array( 
                      'post_type' => 'product',
                      'posts_per_page' => 20
                    ));

                    /* Start the Loop */
                    while ( $products->have_posts() ) : $products->the_post(); ?>
                      <div class="banner-icon">
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
        <?php } ?>
      </div>
      

      <?php
   }
 
}

Plugin::instance()->widgets_manager->register_widget_type( new viewtube_Widget_Banner );