<?php 
namespace Elementor;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Ad Banner
class viewtube_Widget_ad_banner extends Widget_Base {
 
   public function get_name() {
      return 'ad_banner';
   }
 
   public function get_title() {
      return esc_html__( 'Ad Banner', 'viewtube' );
   }
 
   public function get_icon() { 
        return 'eicon-call-to-action';
   }
 
   public function get_categories() {
      return [ 'viewtube-elements' ];
   }

   protected function _register_controls() {

      $this->start_controls_section(
         'ad_banner_section',
         [
            'label' => esc_html__( 'Ad Banner', 'viewtube' ),
            'type' => Controls_Manager::SECTION,
         ]
      );
      
      $this->add_control(
         'layout',
         [
            'label' => __( 'Layout', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'horizontal',
            'options' => [
               'horizontal'  => __( 'Horizontal', 'viewtube' ),
               'vertical' => __( 'Vertical', 'viewtube' )
            ],
         ]
      );

      $this->add_control(
         'align',
         [
            'label' => __( 'Alignment', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
               'left' => [
                  'title' => __( 'Left', 'viewtube' ),
                  'icon' => 'fa fa-align-left',
               ],
               'center' => [
                  'title' => __( 'Center', 'viewtube' ),
                  'icon' => 'fa fa-align-center',
               ],
               'right' => [
                  'title' => __( 'Right', 'viewtube' ),
                  'icon' => 'fa fa-align-right',
               ],
            ],
            'default' => 'left',
            'toggle' => true
         ]
      );

      $this->add_responsive_control(
      'title_padding',
        [
          'label' => __( 'Padding', 'viewtube' ),
          'type' => \Elementor\Controls_Manager::DIMENSIONS,
          'size_units' => [ 'px', 'em', '%' ],
          'selectors' => [
            '{{WRAPPER}} .ad-banner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
          ],
        ]
      );

      $this->add_control(
        'image',
        [
          'label' => __( 'Choose Image', 'viewtube' ),
          'type' => \Elementor\Controls_Manager::MEDIA,
          'default' => [
            'url' => \Elementor\Utils::get_placeholder_image_src(),
          ],
        ]
      );

      $this->add_control(
         'title',
         [
            'label' => __( 'Title', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __( 'Award show', 'viewtube' )
         ]
      );

      $this->add_control(
         'description',
         [
            'label' => __( 'Description', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => __( 'Watch in premium', 'viewtube' )
         ]
      );

      $links = new \Elementor\Repeater();

      $links->add_control(
         'link_text', [
            'label' => __( 'Link Text', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __( 'Accessories', 'viewtube' )
         ]
      );

      $links->add_control(
         'link_url', [
            'label' => __( 'Link URL', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => '#',
         ]
      );

      $this->add_control(
         'links',
         [
            'label' => __( 'Links', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $links->get_controls(),
            'title_field' => 'link Item',
            'condition' => [
               'layout' => ['vertical']
            ],
            'default' => [
               [
                  'link_text' => __( 'Accessories', 'viewtube' ),
                  'link_url' => '#'
               ],
               [
                  'link_text' => __( 'Timing Belts', 'viewtube' ),
                  'link_url' => '#'
               ],
               [
                  'link_text' => __( 'Engine Mounts', 'viewtube' ),
                  'link_url' => '#'
               ]
            ],
            'title_field' => '{{{ link_text }}}',
         ]
      );

      $this->add_control(
         'btn_text',
         [
            'label' => __( 'Button', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __( 'Watch Now', 'viewtube' )
         ]
      );

      $this->add_control(
         'btn_url',
         [
            'label' => __( 'Button URL', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => '#'
         ]
      );
      
      $this->end_controls_section();

   }

   protected function render( $instance = [] ) {
 
      // get our input from the widget settings.
       
      $settings = $this->get_settings_for_display(); ?>

      <?php if ($settings['layout'] == 'horizontal') { ?>
        
      <section class="ad-banner horizontal" style="background-image: url(<?php echo esc_url($settings['image']['url']); ?>);">
        <div class="container">
          <div class="row justify-content-between">
            <div class="col-md-12 text-<?php echo esc_attr( $settings['align'] ); ?>">
              <p><?php echo esc_html($settings['description']); ?></p>
              <h2 class="mb-5"><?php echo esc_html($settings['title']); ?></h2>
              <a class="viewtube-btn" href="<?php echo esc_url($settings['btn_url']); ?>"><?php echo esc_html($settings['btn_text']); ?></a>
            </div>
          </div>
        </div>        
      </section>

      <?php } elseif($settings['layout'] == 'vertical') { ?>

      <section class="ad-banner vertical" style="background-image: url(<?php echo esc_url($settings['image']['url']); ?>);">
        <div class="container">
          <div class="row justify-content-between">
            <div class="text-<?php echo esc_attr( $settings['align'] ); ?>">
              <h3><?php echo esc_html($settings['title']); ?></h3>
              <p class="mb-4"><?php echo esc_html($settings['description']); ?></p>
              <?php if ($settings['links']): ?>
                <ul class="list-unstyled mb-4">
                  <?php foreach ($settings['links'] as $key => $link): ?>
                    <li><a href="<?php echo esc_url($link['link_url']); ?>"><?php echo esc_html($link['link_text']); ?></a></li>
                  <?php endforeach ?>
                </ul>
              <?php endif ?>
              
              <a class="viewtube-btn" href="<?php echo esc_url($settings['btn_url']); ?>"><?php echo esc_html($settings['btn_text']); ?></a>
            </div>
          </div>
        </div>        
      </section>

      <?php } ?>
      
      <?php
   }
 
}

Plugin::instance()->widgets_manager->register_widget_type( new viewtube_Widget_ad_banner );