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
         'rating',
         [
            'label' => __( 'Rating', 'appnova' ),
            'type' => Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%' ],
              'range' => [
                '%' => [
                  'min' => 1,
                  'max' => 5,
                  'step' => 1,
                ]
              ],
              'default' => [
                'unit' => '%',
                'size' => 5,
              ],
         ]
      );

      $banner->add_control(
         'video_resolution',
         [
            'label' => __( 'Video resolution', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [
              'HD'  => __( 'HD', 'plugin-domain' ),
              '4K' => __( '4K', 'plugin-domain' ),
              '8K' => __( '8K', 'plugin-domain' )
            ],
            'default' => 'HD',
         ]
      );

      $banner->add_control(
         'year',
         [
            'label' => __( 'Year', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('2021','viewtube' )
         ]
      );
      
      $banner->add_control(
         'duration',
         [
            'label' => __( 'Duration', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('2 h 20 min','viewtube' )
         ]
      );
      
      $banner->add_control(
         'category',
         [
            'label' => __( 'Category', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('Action','viewtube' )
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
                    <ul class="list-inline rating">
                     <?php for ($i=0; $i < $banner['rating']['size']; $i++) { ?>
                       <li class="list-inline-item"><i class="fa fa-star"></i></li>
                     <?php } ?>
                    </ul>
                    <ul class="list-inline meta">
                      <li class="list-inline-item"><?php echo esc_html( $banner['category'] ); ?></li>
                      <li class="list-inline-item"><?php echo esc_html( $banner['year'] ); ?></li>
                      <li class="list-inline-item"><?php echo esc_html( $banner['duration'] ); ?></li>
                      <li class="list-inline-item"><span><?php echo esc_html( $banner['video_resolution'] ); ?></span></li>
                    </ul>
                    <p style="color: <?php echo esc_attr( $settings['text_color']) ?> "><?php echo esc_html($banner['description']); ?></p>
                    <a class="viewtube-btn mt-50" href="<?php echo esc_url( $banner['button_url'] ); ?>"><?php echo esc_html( $banner['button_text'] ); ?></a>
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