<?php 
namespace Elementor;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Title
class viewtube_Widget_Title extends Widget_Base {
 
   public function get_name() {
      return 'title';
   }
 
   public function get_title() {
      return esc_html__( 'Title', 'viewtube' );
   }
 
   public function get_icon() { 
        return 'eicon-site-title';
   }
 
   public function get_categories() {
      return [ 'viewtube-elements' ];
   }

   protected function _register_controls() {

      $this->start_controls_section(
         'title_section',
         [
            'label' => esc_html__( 'Title', 'viewtube' ),
            'type' => Controls_Manager::SECTION,
         ]
      );
      
      $this->add_control(
         'title',
         [
            'label' => __( 'Title', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('Latest portfolio','viewtube')
         ]
      );


      $this->add_control(
         'sub-title',
         [
            'label' => __( 'Sub Title', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => __('Nemo enim ipsam voluptatem quia voluptas aspernatur','viewtube')
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
      
      $this->end_controls_section();

   }

   protected function render( $instance = [] ) {
 
      // get our input from the widget settings.
       
      $settings = $this->get_settings_for_display();
      
      //Inline Editing
      $this->add_inline_editing_attributes( 'title', 'basic' );
      $this->add_inline_editing_attributes( 'sub-title', 'basic' );
      $this->add_inline_editing_attributes( 'align', 'basic' );
      
      ?>
      <div class="section-title text-<?php echo esc_attr( $settings['align'] ); ?>">
           <h1 <?php echo esc_attr( $this->get_render_attribute_string( 'title' ) ); ?>><?php echo esc_html($settings['title']); ?></h1>
           <?php if ( $settings['sub-title'] ): ?>
              <p <?php echo esc_attr( $this->get_render_attribute_string( 'sub-title' ) ); ?>><?php echo esc_html( $settings['sub-title'] ); ?></p>
           <?php endif ?>           
      </div>
      <?php
   }
 
}

Plugin::instance()->widgets_manager->register_widget_type( new viewtube_Widget_Title );