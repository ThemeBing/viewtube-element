<?php 
namespace Elementor;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// MegaMenu
class viewtube_Widget_MegaMenu extends Widget_Base {
 
   public function get_name() {
      return 'megamenu';
   }
 
   public function get_title() {
      return esc_html__( 'MegaMenu', 'viewtube' );
   }
 
   public function get_icon() { 
        return 'eicon-nav-menu';
   }
 
   public function get_categories() {
      return [ 'viewtube-elements' ];
   }

   protected function _register_controls() {

      $this->start_controls_section(
         'megamenu_section',
         [
            'label' => esc_html__( 'Mega Menu', 'viewtube' ),
            'type' => Controls_Manager::SECTION,
         ]
      );

      $megamenu = new \Elementor\Repeater();
        
      $megamenu->add_control(
          'title',
          [
            'label' => __( 'Title', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __( 'About me', 'viewtube' ),
            
          ]
      );

      $megamenu->add_control(
          'icon',
          [
            'label' => __( 'Icon', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::ICONS
            
          ]
      );

      $megamenu->add_control(
        'template',
        [
            'label'       => __( 'Template', 'viewtube' ),
            'type'        => Controls_Manager::SELECT,
            'default'     => '0',
            'options'     => viewtube_get_elementor_template()
        ]
      );

      $this->add_control(
         'megamenu_list',
         [
            'label' => __( 'Mega Menu List', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $megamenu->get_controls(),
            'title_field' => '{{title}}',
         ]
      );

      
      $this->end_controls_section();

   }

   protected function render( $instance = [] ) {
 
      // get our input from the widget settings.
       
      $settings = $this->get_settings_for_display(); ?>
      
      <div class="viewtube-megamenu">
        <div class="row no-gutters">
          <div class="col-2">
            <div class="nav flex-column" role="tablist">
              <?php foreach (  $settings['megamenu_list'] as $key => $megamenu_single ){ ?>
                <a class="nav-item nav-link <?php if($key == 0){echo'active';} ?>" id="<?php echo esc_attr( $key ) ?>-tab" data-toggle="tab" href="#tab-<?php echo esc_attr( $key ) ?>" role="tab" aria-controls="<?php echo esc_attr( $key ) ?>" aria-selected="<?php if($key == 0){echo'true';} ?>"><?php \Elementor\Icons_Manager::render_icon( $megamenu_single['icon'], [ 'aria-hidden' => 'true' ] ); ?><?php echo esc_html( $megamenu_single['title'] ) ?></a>
              <?php } ?>
            </div>
        </div>

        <div class="col-10">
          <div class="tab-content">
            <?php foreach (  $settings['megamenu_list'] as $key => $megamenu_single ){ ?>
              <div class="tab-pane fade show <?php if($key == 0){echo'active';} ?>" id="tab-<?php echo esc_attr( $key ) ?>" role="tabpanel" aria-labelledby="<?php echo esc_attr( $key ) ?>-tab">
                <?php echo Plugin::instance()->frontend->get_builder_content_for_display( $megamenu_single['template'] ); ?>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>

      <?php
   }
}

Plugin::instance()->widgets_manager->register_widget_type( new viewtube_Widget_MegaMenu );