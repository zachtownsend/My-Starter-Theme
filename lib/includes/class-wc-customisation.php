<?php
namespace Verb;

/**
* Theme Woocommerce Customisation
*/
class WC_Customisation
{
	
	public $text_domain = 'woocommerce';

	function __construct()
	{	

		// Custom Taxonomies
		add_action('init', [$this, 'custom_taxonomies']);

		// Remove Short Description box from product page
		add_action('init', [$this, 'init_remove_support'], 100);
		add_action('add_meta_boxes', [$this, 'remove_short_description'], 100);
	}

	public function remove_short_description() {
		remove_meta_box( 'postexcerpt', 'product', 'normal');
	}

	public function init_remove_support() {
		remove_post_type_support( 'product', 'editor');
	}

	/**
	 * Replace WC Scrips
	 * @param  string  $handle    Use the enqueue handle given by WC
	 * @param  string $src        The location of the script you want to replace it with
	 * @param  array   $deps      Script dependencies
	 * @param  boolean $ver       Version number
	 * @param  boolean $in_footer Whether or not the script appears in the footer
	 *
	 * This function takes the arguments of wp_enqueue_scripts and is designed to replace WC scripts with
	 * you own custom ones.
	 */
	public function replace_script( $handle, $src = false, $deps = array(), $ver = false, $in_footer = false ) {
		wp_deregister_script( $handle );
		wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer );
	}

}