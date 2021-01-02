<?php 
namespace Elementor;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Button
class viewtube_Widget_Button extends Widget_Base {
 
   public function get_name() {
      return 'button';
   }
 
   public function get_title() {
      return esc_html__( 'Button', 'viewtube' );
   }
 
   public function get_icon() { 
        return 'eicon-button';
   }
 
   public function get_categories() {
      return [ 'viewtube-elements' ];
   }

   protected function _register_controls() {

      $this->start_controls_section(
         'button_section',
         [
            'label' => esc_html__( 'Button', 'viewtube' ),
            'type' => Controls_Manager::SECTION,
         ]
      );

      $this->add_control(
         'button_text', [
            'label' => __( 'Button Text', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('Learn More','viewtube')
         ]
      );

      $this->add_control(
         'button_url', [
            'label' => __( 'Button URL', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => '#'
         ]
      );
      
      $this->add_control(
         'align',
         [
            'label' => __( 'Align', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'left',
            'options' => [
               'center'  => __( 'Center', 'viewtube' ),
               'left' => __( 'Left', 'viewtube' ),
               'right' => __( 'Right', 'viewtube' )
            ],
         ]
      );

      $this->add_control(
         'border',
         [
            'label' => __( 'border', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __( 'On', 'viewtube' ),
            'label_off' => __( 'Off', 'viewtube' ),
            'return_value' => 'bordered',
            'default' => 'no',
         ]
      );

      $this->add_control(
         'white-border',
         [
            'label' => __( 'White border', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __( 'On', 'viewtube' ),
            'label_off' => __( 'Off', 'viewtube' ),
            'return_value' => 'white-bordered',
            'default' => 'no',
         ]
      );

      $this->end_controls_section();

   }

   protected function render( $instance = [] ) {
 
      // get our input from the widget settings.
       
      $settings = $this->get_settings_for_display(); ?>

      <div style="text-align: <?php echo esc_attr($settings['align']) ?>">
         <a class="viewtube-btn <?php echo esc_attr($settings['border']) ?> <?php echo esc_attr($settings['white-border']) ?>" href="<?php echo esc_url( $settings['button_url'] ); ?>">
            <?php echo esc_html( $settings['button_text'] ); ?></a>
      </div>
      <?php
   }
 
}

Plugin::instance()->widgets_manager->register_widget_type( new viewtube_Widget_Button );