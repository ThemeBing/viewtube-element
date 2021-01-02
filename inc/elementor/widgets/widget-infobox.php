<?php 
namespace Elementor;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
// InfoBox item
class viewtube_Widget_InfoBox extends Widget_Base {
 
   public function get_name() {
      return 'InfoBox_item';
   }
 
   public function get_title() {
      return esc_html__( 'Info Box', 'viewtube' );
   }
 
   public function get_icon() { 
        return 'eicon-facebook-comments';
   }
 
   public function get_categories() {
      return [ 'viewtube-elements' ];
   }
   protected function _register_controls() {
      $this->start_controls_section(
         'InfoBox_section',
         [
            'label' => esc_html__( 'Info Box', 'viewtube' ),
            'type' => Controls_Manager::SECTION,
         ]
      );  

      $this->add_group_control(
         Group_Control_Background::get_type(),
         [
            'name' => 'background',
            'label' => __( 'Icon Background', 'viewtube' ),
            'types' => [ 'gradient' ],
            'selector' => '{{WRAPPER}} .infobox-item i,{{WRAPPER}} .second-circle',
         ]
      );

      $this->add_group_control(
         Group_Control_Box_Shadow::get_type(),
         [
            'name' => 'box_shadow',
            'label' => __( 'Box Shadow', 'viewtube' ),
            'selector' => '{{WRAPPER}} .infobox-item i',
         ]
      );
      
      $this->add_control(
         'icon',
         [
            'label' => __( 'Icon', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::ICONS,
            'default' => [
               'value' => 'fas fa-star',
               'library' => 'solid',
            ]
         ]     
      );

      $this->add_control(
         'color',
         [
            'label' => __( 'Icon Color', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#fff',
         ]     
      );


      $this->add_control(
         'title',
         [
            'label' => __( 'Title', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('Best Apps and Games','viewtube'),
         ]
      );

      $this->add_control(
         'text',
         [
            'label' => __( 'Text', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => __('Discover the best of viewtube. A rotating selection of delightful apps','viewtube'),
         ]
      );

      $this->add_control(
         'url',
         [
            'label' => __( 'URL', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => '#',
         ]
      );

      $this->add_control(
         'button',
         [
            'label' => __( 'Button', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('Learn More','viewtube'),
         ]
      );

      $this->add_control(
         'dropshadow',
         [
            'label' => __( 'Drop shadow', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __( 'On', 'viewtube' ),
            'label_off' => __( 'Off', 'viewtube' ),
            'return_value' => 'on',
            'default' => 'off',
         ]
      );
      
      $this->end_controls_section();
   }
   protected function render( $instance = [] ) {
 
      // get our input from the widget settings.
       
      $settings = $this->get_settings_for_display(); ?>

         <div class="infobox-item <?php if($settings['dropshadow'] == true){echo 'dropshadow'; } ?>">
            <?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ,'style' => 'color:'.$settings['color'].''] ); ?>
            <div class="second-circle"></div>
            <h3><?php echo esc_html($settings['title']); ?></h3>
            <p><?php echo wp_kses( $settings['text'] , array( 'br' =>  array() )); ?></p>
            <a href="<?php echo esc_url($settings['url']); ?>"><?php echo esc_html($settings['button']); ?><span class="fal fa-angle-double-right"></span></a>
         </div>

      <?php
   }
 
}
Plugin::instance()->widgets_manager->register_widget_type( new viewtube_Widget_InfoBox );