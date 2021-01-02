<?php 
namespace Elementor;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
// team
class viewtube_Widget_Team extends Widget_Base {
 
   public function get_name() {
      return 'team';
   }
 
   public function get_title() {
      return esc_html__( 'Team', 'viewtube' );
   }
 
   public function get_icon() { 
        return 'eicon-person';
   }
 
   public function get_categories() {
      return [ 'viewtube-elements' ];
   }
   protected function _register_controls() {
      $this->start_controls_section(
         'team_section',
         [
            'label' => esc_html__( 'team', 'viewtube' ),
            'type' => Controls_Manager::SECTION
         ]
      );
      
      $this->add_control(
         'image',
         [
            'label' => __( 'Choose photo', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::MEDIA,
            'default' => [
               'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
         ]
      );
      
      $this->add_control(
         'name',
         [
            'label' => __( 'Name', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __( 'John Doe', 'viewtube' ),
         ]
      );
      $this->add_control(
         'designation',
         [
            'label' => __( 'Designation', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __( 'App Developer', 'viewtube' ),
         ]
      );
      
      $social = new \Elementor\Repeater();

      $social->add_control(
         'social_icon', [
            'label' => __( 'Social Icon', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::ICONS
         ]
      );

      $social->add_control(
         'social_url', [
            'label' => __( 'Socia URL', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => '#',
         ]
      );

      $this->add_control(
         'social_media',
         [
            'label' => __( 'social profile', 'viewtube' ),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $social->get_controls(),
            'title_field' => 'Social Item',
            'default' => [
               [
                  'social_icon' => 'fa fa-facebook',
                  'social_url' => '#'
               ],
               [
                  'social_icon' => 'fa fa-twitter',
                  'social_url' => '#'
               ],
               [
                  'social_icon' => 'fa fa-linkedin',
                  'social_url' => '#'
               ]
            ],
            'title_field' => '{{{ social_icon }}}',
         ]
      );
      
      $this->end_controls_section();
   }
   protected function render( $instance = [] ) {
 
      // get our input from the widget settings.
       
      $settings = $this->get_settings_for_display(); ?>

      <div class="viewtube-team">
         <div class="viewtube-team-image">
            <?php echo wp_get_attachment_image( $settings['image']['id'], 'viewtube-400x400' ); ?>
            <ul class="viewtube-team-social">
               <?php 
               foreach (  $settings['social_media'] as $single_social ) { ?>
                  <li class="list-inline-item">
                     <a href="<?php echo esc_attr( $single_social['social_url'] ) ?>">
                     <?php \Elementor\Icons_Manager::render_icon( $single_social['social_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                     </a>
                  </li>
               <?php 
               } ?>
            </ul>
         </div>
         
         <div class="viewtube-team-content">
            <h4><?php echo esc_html($settings['name']); ?></h4>
            <span><?php echo esc_html($settings['designation']); ?></span>
         </div>
      </div>
      <?php
   }
 
}
Plugin::instance()->widgets_manager->register_widget_type( new viewtube_Widget_Team );