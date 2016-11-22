<?php
/**
 * 
 */
namespace Verb;

use \Verb\Cleanup;
use \Verb\Social_Media;

class Theme
{
	
	/*
	 * Save an instance of the class, in the class itself, to save having to use globals
	 */
	protected static $_instance = null;

	/*
	 * Check if the class has been set already, if not set instance as
	 */
	public static function instance() {
		if ( is_null( static::$_instance ) ) {
			static::$_instance = new static();
		}
		return static::$_instance;
	}

	/**
	 * Array to store inline scripts
	 * @var array
	 */
	public static $inline_scripts;

	/**
	 * Array of general site settings
	 * @var array
	 */
	public $settings = array(
		'version'               => '0.0',
		'text-domain'           => 'verbbrands',
		'options-page-slug'     => 'theme-settings',
		'template-parts-folder' => 'template-parts',
		'inline-scripts'        => array()
	);

	function __construct()
	{
		// Perform Wordpress cleanup
		new Cleanup();

		// Define Theme Support
		add_action( 'after_setup_theme', [$this, 'theme_support'] );

		// Give class to custom post type parent in wp navigation
		add_action( 'nav_menu_css_class', [$this, 'nav_custom_post_types'], 10, 2);

		// Define Sidebar Widget Areas
		add_action( 'widgets_init', [$this, 'sidebar_widgets'] );

		// Add inline scripts
		add_action( 'after_body_tag', [$this, 'add_inline_script'] );

	}

	/**
	 * Site Settings
	 * =============
	 */
	public function theme_support() {
		// Add post formats - http://codex.wordpress.org/Post_Formats
		add_theme_support('post-formats', ['aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio']);

		// Switch default core markup for search form, comment form, and comments to output valid HTML5
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Add post thumbnails - http://codex.wordpress.org/Post_Thumbnails
		add_theme_support('post-thumbnails');

		// Enable plugins to manage the document title - http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
		add_theme_support('title-tag');

		// Add menu support
		add_theme_support( 'menus' );

		// RSS thingy
		add_theme_support( 'automatic-feed-links' );

		// Declare WooCommerce support per http://docs.woothemes.com/document/third-party-custom-theme-compatibility/
		add_theme_support( 'woocommerce' );
	}

	/*
	 *  Give class to custom post type parent in wp navigation
	 *  (https://gist.github.com/gerbenvandijk/5253921)
	 */
	public function nav_custom_post_types($classes, $item) {
		global $post;

		// If not post, return null
		$id = ( isset( $post->ID ) ? get_the_ID() : NULL );

			if (isset( $id )) {
			$current_post_type = get_post_type_object(get_post_type($post->ID));
			$current_post_type_slug = $current_post_type->rewrite['slug'];

			$menu_slug = strtolower(trim($item->url));

			// If the menu item URL contains the current post types slug add the current-menu-item class
			if (strpos($menu_slug, $current_post_type_slug) !== false) {
				$classes[] = 'current-menu-item';
			}
		}
		return $classes;
	}

	/**
	 * Widget Areas
	 */
	public function sidebar_widgets() {
		register_sidebar(array(
			'id' => 'sidebar-widgets',
			'name' => __( 'Sidebar widgets', $this->settings['text-domain'] ),
			'description' => __( 'Drag widgets to this sidebar container.', $this->settings['text-domain'] ),
			'before_widget' => '<article id="%1$s" class="widget %2$s">',
			'after_widget' => '</article>',
			'before_title' => '<h6>',
			'after_title' => '</h6>',
		));

		register_sidebar(array(
			'id' => 'footer-widgets',
			'name' => __( 'Footer widgets', $this->settings['text-domain'] ),
			'description' => __( 'Drag widgets to this footer container', $this->settings['text-domain'] ),
			'before_widget' => '<article id="%1$s" class="large-4 columns widget %2$s">',
			'after_widget' => '</article>',
			'before_title' => '<h6>',
			'after_title' => '</h6>',
		));
	}

	/**
	 * =========
	 * Utilities
	 * =========
	 */
	
	/**
	 * Display Entry Meta
	 */
	static public function entry_meta() {
		echo '<time class="updated" datetime="' . get_the_time( 'c' ) . '">' . sprintf( __( 'Posted on %s at %s.', $this->settings['text-domain'] ), get_the_date(), get_the_time() ) . '</time>';
		echo '<p class="byline author">' . __( 'Written by', $this->settings['text-domain'] ) . ' <a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '" rel="author" class="fn">' . get_the_author() . '</a></p>';
	}

	/**
	 * Pagination
	 */
	static public function pagination() {
		global $wp_query;

		$big = 999999999; // This needs to be an unlikely integer

		// For more options and info view the docs for paginate_links()
		// http://codex.wordpress.org/Function_Reference/paginate_links
		$paginate_links = paginate_links( array(
			'base' => str_replace( $big, '%#%', html_entity_decode( get_pagenum_link( $big ) ) ),
			'current' => max( 1, get_query_var( 'paged' ) ),
			'total' => $wp_query->max_num_pages,
			'mid_size' => 5,
			'prev_next' => true,
				'prev_text' => __( '&laquo;', $this->settings['text-domain'] ),
				'next_text' => __( '&raquo;', $this->settings['text-domain'] ),
			'type' => 'list',
		) );

		$paginate_links = str_replace( "<ul class='page-numbers'>", "<ul class='pagination'>", $paginate_links );
		$paginate_links = str_replace( '<li><span class="page-numbers dots">', "<li><a href='#'>", $paginate_links );
		$paginate_links = str_replace( "<li><span class='page-numbers current'>", "<li class='current'><a href='#'>", $paginate_links );
		$paginate_links = str_replace( '</span>', '</a>', $paginate_links );
		$paginate_links = str_replace( "<li><a href='#'>&hellip;</a></li>", "<li><span class='dots'>&hellip;</span></li>", $paginate_links );
		$paginate_links = preg_replace( '/\s*page-numbers/', '', $paginate_links );

		// Display the pagination if more than one page is found.
		if ( $paginate_links ) {
			echo '<div class="pagination-centered">';
			echo $paginate_links;
			echo '</div><!--// end .pagination -->';
		}
	}

	/**
	 * A fallback when no navigation is selected by default.
	 */
	static public function menu_fallback() {
		echo '<div class="alert-box secondary">';
		// Translators 1: Link to Menus, 2: Link to Customize.
			printf( __( 'Please assign a menu to the primary menu location under %1$s or %2$s the design.', $this->settings['text-domain'] ),
				sprintf(  __( '<a href="%s">Menus</a>', $this->settings['text-domain'] ),
					get_admin_url( get_current_blog_id(), 'nav-menus.php' )
				),
				sprintf(  __( '<a href="%s">Customize</a>', $this->settings['text-domain'] ),
					get_admin_url( get_current_blog_id(), 'customize.php' )
				)
			);
			echo '</div>';
	}

	static function excerpt($limit) {
		$excerpt = explode(' ', get_the_excerpt(), $limit);
		if (count($excerpt)>=$limit) {
			array_pop($excerpt);
			$excerpt = implode(" ",$excerpt).'&hellip;';
		} else {
			$excerpt = implode(" ",$excerpt);
		} 
		$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
		return $excerpt;
	}

	static function get_template_part( $slug, $name ) {
		get_template_part( "{$this->settings['template-parts-folder']}/$slug", $name );
	}

	/**
	 * If there are any inline scripts registered, echo them echo them
	 */
	public function add_inline_script() {
		if ( ! empty( self::$inline_scripts ) && !is_admin() ) {
			echo '<script type="text/javascript">';
			foreach ( self::$inline_scripts as $script ) {
				echo $script;
			}
			echo '</script>';
		}
	}

	/**
	 * Add script to $inline_scripts array
	 * @param  string $script The Javascript code to be added to the inline script
	 */
	public function register_inline_script( $script ) {
		if ( ! is_array( self::$inline_scripts ) ) {
			self::$inline_scripts = array();
		}
		array_push( self::$inline_scripts, strip_tags( $script ) );
	}

}

?>