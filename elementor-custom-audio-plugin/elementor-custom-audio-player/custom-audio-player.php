
<?php
/**
 * Plugin Name: Elementor Custom Audio Player Widget
 * Description: Auto embed any embbedable content from external URLs into Elementor.
 * Plugin URI:  
 * Version:     1.0.0
 * Author:      Christina Poghosyan
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register Custom Audio Player Widget.
 *
 * Include widget file and register widget class.
 *
 * @since 1.0.0
 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
 * @return void
 */
function register_custom_audio_player_widget( $widgets_manager ) {

	require_once( __DIR__ . '/widgets/custom-audio-player.php' );

	$widgets_manager->register( new \Elementor_Custom_Audio_Player_Widget() );

}
add_action( 'elementor/widgets/register', 'register_custom_audio_player_widget' );
