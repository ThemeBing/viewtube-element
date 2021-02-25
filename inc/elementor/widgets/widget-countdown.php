<?php 
namespace Elementor;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Title
class viewtube_Widget_Countdown extends Widget_Base {
 
   public function get_name() {
      return 'countdown';
   }
 
   public function get_title() {
      return esc_html__( 'Countdown', 'viewtube' );
   }
 
   public function get_icon() { 
        return 'eicon-countdown';
   }
 
   public function get_categories() {
      return [ 'viewtube-elements' ];
   }

   protected function _register_controls() {

      $this->start_controls_section(
         'countdown_section',
         [
            'label' => esc_html__( 'Countdown', 'viewtube' ),
            'type' => Controls_Manager::SECTION,
         ]
      );
      
      $this->add_control(
         'date',
         [
            'label' => __( 'Date', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::DATE_TIME
         ]
      );
      
      $this->end_controls_section();

   }

   protected function render( $instance = [] ) {
 
      // get our input from the widget settings.
      $settings = $this->get_settings_for_display(); ?>
      <div id="countdown-date<?php echo(rand(1,10)) ?>" data-date="<?php echo date_format( date_create($settings['date']) ,"M d,Y H:i:s" ) ?>"></div>

      <?php
   }
 
}

Plugin::instance()->widgets_manager->register_widget_type( new viewtube_Widget_Countdown );