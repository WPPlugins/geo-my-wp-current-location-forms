<?php
/*
 Plugin Name: GMW Add-on - Current Location Forms
 Plugin URI: http://www.geomywp.com
 Description: Choose custom forms to be displayed instead of the deafult "Curren Location" form.
 Author: Eyal Fitoussi
 Version: 1.0
 Author URI: http://www.geomywp.com
 Text Domain: GMW-CLF
 Domain Path: /languages/
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) )
	exit;

/**
 * GMW_CL_Forms class.
 */
class GMW_CL_Forms {

	/**
	 * __Construct
	 *
	 * @since 1.1
	 */
	public function __construct() {

		$this->settings = get_option( 'gmw_options' );
		
		//if Current Location features is not enabled there is no need for this plugin
		if ( !isset( $this->settings['features']['current_location_shortcode'] ) )
			return;
		
		define( 'GMW_CLF_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
		define( 'GMW_CLF_URL', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );

		add_filter( 'gmw_admin_settings', array( $this, 'settings_init' ), 25 );
		add_filter( 'gmw_current_location_form', array( $this, 'load_form' ) );
	
	}
	
	/**
	 * Admin Settings
	 *
	 * @access public
	 * @return $settings
	 */
	public function settings_init( $settings ) {

		$settings['general_settings'][1]['cl_forms'] = array(
				'name'       => 'cl_form',
				'std'        => '',
				'label'      => __( 'Current Location Forms', 'GMW-PS' ),
				'desc'       => __( 'Choose the form to be used with the Current Location widget/shortcode.', 'GMW-PS' ),
				'type'       => 'select',
				'options'	 => self::get_forms()
		);
		
		return $settings;
	
	}
		
	/**
	 * Forms drop-dwon selext box in admin
	 * @return string
	 */
	public function get_forms() {
	
		$themes = array();
		
		$forms[''] = __( 'None', 'GMW_CLF' );
		foreach ( glob( GMW_CLF_PATH .'/forms/*', GLOB_ONLYDIR ) as $dir ) {
			$forms[basename($dir)] = basename($dir);
		}
		
		foreach ( glob( STYLESHEETPATH . '/geo-my-wp/gmw-current-location-forms/*', GLOB_ONLYDIR ) as $dir ) {
			$forms['custom_'.basename($dir)] = 'custom: '.basename($dir);
		}
	
		return $forms;
	}
	
	/**
	 * Load Curren location form in front end
	 * 
	 * @param $template
	 * @return $template
	 */
	public function load_form( $template ) {
		
		$options = get_option( 'gmw_options' );
		
		if ( isset( $options['general_settings']['cl_form'] ) && !empty( $options['general_settings']['cl_form'] ) ) {
			
			ob_start();
			
			$template = $options['general_settings']['cl_form'];
			
			//get custom stylesheet and results template from child/theme
			if ( strpos( $template, 'custom_' ) !== false ) {
					
				$template = str_replace( 'custom_', '', $template );
					
				if ( !wp_style_is( 'gmw-cl-custom-style-'.$template , 'enqueued' ) )
					wp_enqueue_style( 'gmw-cl-custom-style-'.$template, get_stylesheet_directory_uri() . '/geo-my-wp/gmw-current-location-forms/'.$template.'/css/style.css' );
					
				include( STYLESHEETPATH . '/geo-my-wp/gmw-current-location-forms/'.$template.'/form.php');
			
			//get stylesheet and results template from plugin's folder
			} else {
					
				if ( !wp_style_is( 'gmw-cl-style-'.$template, 'enqueued' ) )
					wp_enqueue_style( 'gmw-cl-style-'.$template, GMW_CLF_URL . '/forms/'.$template.'/css/style.css' );
					
				include( GMW_CLF_PATH. '/forms/'.$template.'/form.php' );
					
			}
			
			$template = ob_get_clean();
			
		}
		
		return $template;
	}
}
new GMW_CL_Forms();