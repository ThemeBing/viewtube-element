<?php 
namespace Elementor;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Accordion
class viewtube_Widget_Accordion extends Widget_Base {
 
   public function get_name() {
      return 'accordion';
   }
 
   public function get_title() {
      return esc_html__( 'Accordion', 'viewtube' );
   }
 
   public function get_icon() { 
        return 'eicon-accordion';
   }
 
   public function get_categories() {
      return [ 'viewtube-elements' ];
   }

   protected function _register_controls() {

      $this->start_controls_section(
         'accordion_section',
         [
            'label' => esc_html__( 'Accordion', 'viewtube' ),
            'type' => Controls_Manager::SECTION,
         ]
      );

      $this->add_control(
         'collapsed_icon',
         [
            'label' => __( 'Collapsed Icon', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::ICONS
         ]
      );

      $this->add_control(
         'expanded_icon',
         [
            'label' => __( 'Expanded Icon', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::ICONS
         ]
      );

      $accordion = new \Elementor\Repeater();

      $accordion->add_control(
         'title', [
            'label' => __( 'Title', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'label_block' => true,
         ]
      );
      $accordion->add_control(
         'text', [
            'label' => __( 'Text', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::WYSIWYG,
            'label_block' => true,
         ]
      );

      $this->add_control(
         'accordion_list',
         [
            'label' => __( 'Accordion list', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $accordion->get_controls(),
            'default' => [
               [
                  'title' => __( 'How can i get help by viewtube?', 'viewtube' ),
                  'text' => __( 'Lorem ipsum dolor sit amet, vix an natum labitur eleifd, mel am laoreet menandri. Ei justo complectitur duo. Ei mundi solet utos soletu possit quo. Sea cu justo laudem.', 'viewtube' )
               ],
               [
                  'title' => __( 'What about loan programs & after bank loan advantage?', 'viewtube' ),
                  'text' => __( 'Lorem ipsum dolor sit amet, vix an natum labitur eleifd, mel am laoreet menandri. Ei justo complectitur duo. Ei mundi solet utos soletu possit quo. Sea cu justo laudem.', 'viewtube' )
               ],
               [
                  'title' => __( 'How can i opent new account?', 'viewtube' ),
                  'text' => __( 'Lorem ipsum dolor sit amet, vix an natum labitur eleifd, mel am laoreet menandri. Ei justo complectitur duo. Ei mundi solet utos soletu possit quo. Sea cu justo laudem.', 'viewtube' )
               ]
            ],
            'title_field' => '{{{ title }}}',
         ]
      );

      $this->end_controls_section();

   }

   protected function render( $instance = [] ) {
 
      // get our input from the widget settings.

      $randID = wp_rand();

      $settings = $this->get_settings_for_display(); ?>
      <div id="accordion<?php echo $randID ?>" class="viewtube-accordion <?php echo esc_attr( $settings['accordion_style'] ) ?>">
        <?php if ( $settings['accordion_list'] ) { 
          foreach (  $settings['accordion_list'] as $key => $accordion ) { ?>
          <div class="viewtube-accordion-item">
            <h5 data-toggle="collapse" data-target="#collapse-<?php echo $key.$randID ?>" aria-expanded="false" aria-controls="collapse-<?php echo $key.$randID ?>">
                <?php echo esc_html( $accordion['title'] ); ?>
                <span><?php \Elementor\Icons_Manager::render_icon( $settings['collapsed_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
                <span><?php \Elementor\Icons_Manager::render_icon( $settings['expanded_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
            </h5>

            <div id="collapse-<?php echo $key.$randID ?>" class="collapse" data-parent="#accordion<?php echo $randID ?>">
              <?php echo wp_kses( $accordion['text'] , array(
                  'a'       => array(
                     'href'    => array(),
                     'title'   => array()
                  ),
                  'br'      => array(),
                  'em'      => array(),
                  'strong'  => array(),
                  'img'     => array(
                     'src' => array(),
                     'alt' => array()
                  ),
               )); ?>
            </div>
          </div>
          <?php } 
      } ?>
      </div>

      

      <?php
   }

}

Plugin::instance()->widgets_manager->register_widget_type( new viewtube_Widget_Accordion );