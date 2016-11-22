<?php
namespace Verb;

use \Verb\Social_Media;
use \Verb\WC_Customisation;
/**
* Well Fed class
*/
class Well_Fed extends Theme
{
	
	function __construct()
	{
		// Define theme-specific settings
		$this->settings['version'] = '0.1';
		$this->settings['text-domain'] = 'well-fed';

		// Enqueue styles and scrtips
		add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);

		// Add ACF Options page(s)
		$this->add_options_page();

		// Get access to Social Media class
		$this->social = new Social_Media( $this->settings );

		$this->wc = new WC_Customisation();

		
		/**
		 * Hooks
		 */
		
		// Add image sizes
		add_action( 'after_setup_theme', [$this, 'add_image_sizes'] );

		// Construct Theme class
		parent::__construct();
	}

	public function enqueue_scripts() {
		wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=Open+Sans|Roboto+Slab:400,700' );
	}

	/*
	 * Advanced custom fields
	 */
	private function add_options_page() {
		if ( function_exists('acf_add_options_page' ) ) {
			
			// Main Theme Settings
			acf_add_options_page(array(
				'page_title'	=> 'Theme Settings',
				'menu_title'	=> 'Theme Settings',
				'menu_slug'		=> 'theme-settings'
			));
		}
	}

	/**
	 * =====
	 * Hooks
	 * =====
	 */

	/**
	 * Add custom image sizes
	 */
	public function add_image_sizes() {

		// Product
		add_image_size( 'product-thumbnail', 380, 300, true );
	}


}