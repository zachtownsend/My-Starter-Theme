<?php
namespace Verb;
/**
* Integrate Social Media options
*/
class Social_Media extends Theme
{

	protected $defaults = array(
		'static-template' => 'social-media-links',
		'shareable-template' => 'social-media-shareable'
	);

	function __construct( $args = array() )
	{
		// Define Settings
		$this->settings = array_merge($this->settings, $args, $this->defaults);
		
		// Add Facebook API options
		$this->add_facebook_API_options();

		// Add options for the sites social media
		$this->add_site_options();
		
		// Add options for the sites social media share links
		$this->add_shareable_options();

		// Add Facebook script into header
		$this->register_facebook_script();

		// Enqueue Social Media related scripts and styles
		add_action('wp_enqueue', [$this, 'enqueue_scripts']);

	}

	public function enqueue_scripts() {
		// Enqueue SS Social - ### Don't forget to include the js file somewhere ###
		wp_enqueue_style( 'ss-social', get_template_directory_uri() . '/assets/fonts/ss-social/ss-social-regular.css', array(), '1.0.0', 'all' );
	}

	/**
	 * Add Social Media options to options page
	 * for static social media
	 */
	protected function add_site_options() {
		if( function_exists('acf_add_local_field_group') ) {

			acf_add_local_field_group(array (
				'key' => 'group_55fbe634caee2',
				'title' => 'Social Media',
				'fields' => array (
					array (
						'key' => 'field_55fbe63c18106',
						'label' => 'Social Media Icons',
						'name' => 'social-media-icons',
						'type' => 'repeater',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'min' => '',
						'max' => '',
						'layout' => 'table',
						'button_label' => 'Add Social Media',
						'sub_fields' => array (
							array (
								'key' => 'field_55fbe67418107',
								'label' => 'Social Network',
								'name' => 'network',
								'type' => 'select',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array (
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'choices' => array (
									'facebook' => 'Facebook',
									'twitter' => 'Twitter',
									'linkedin' => 'Linkedin',
									'instagram' => 'Instagram',
									'youtube' => 'YouTube',
									'googleplus' => 'Google+',
									'pinterest' => 'Pinterest',
									'tumblr' => 'Tumblr',
									'quora' => 'Quora',
									'blogger' => 'Blogger',
									'reddit' => 'Reddit',
									'wordpress' => 'Wordpress',
									'vimeo' => 'Vimeo',
									'vine' => 'Vine',
									'flickr' => 'Flickr',
									'skype' => 'Skype',
									'behance' => 'Behance',
									'paypal' => 'Paypal',
									'rdio' => 'Rdio',
									'spotify' => 'Spotify',
									'soundcloud' => 'Soundcloud',
									'phone' => 'Phone',
									'mail' => 'Email',
								),
								'default_value' => array (
								),
								'allow_null' => 0,
								'multiple' => 0,
								'ui' => 0,
								'ajax' => 0,
								'placeholder' => '',
								'disabled' => 0,
								'readonly' => 0,
							),
							array (
								'key' => 'field_55fbe67c18108',
								'label' => 'URL',
								'name' => 'url',
								'type' => 'text',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array (
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'default_value' => '',
								'placeholder' => 'http://',
								'prepend' => '',
								'append' => '',
								'maxlength' => '',
								'readonly' => 0,
								'disabled' => 0,
							),

						),
					),
				),
				'location' => array (
					array (
						array (
							'param' => 'options_page',
							'operator' => '==',
							'value' => $this->settings['options-page-slug'],
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'seamless',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => 1,
				'description' => '',
			));

		}
	}

	/**
	 * Add shareable social media options
	 */
	protected function add_shareable_options() {
		if( function_exists('acf_add_local_field_group') ):

		acf_add_local_field_group(array (
			'key' => 'group_57ac6d7891835',
			'title' => 'Shareable Social Media',
			'fields' => array (
				array (
					'key' => 'field_57ac6da68a10c',
					'label' => 'Shareable Social Media',
					'name' => 'shareable_social_media',
					'type' => 'repeater',
					'instructions' => 'Select the social media outlets you would like to be able to share to',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'collapsed' => '',
					'min' => '',
					'max' => '',
					'layout' => 'table',
					'button_label' => 'Add Social Media Vendor',
					'sub_fields' => array (
						array (
							'key' => 'field_57ac6db78a10d',
							'label' => 'Vendor',
							'name' => 'vendor',
							'type' => 'select',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'choices' => array (
								'facebook' => 'Facebook',
								'twitter' => 'Twitter',
								'linkedin' => 'Linkedin',
								'instagram' => 'Instagram',
								'youtube' => 'YouTube',
								'googleplus' => 'Google+',
								'pinterest' => 'Pinterest',
								'tumblr' => 'Tumblr',
								'quora' => 'Quora',
								'blogger' => 'Blogger',
								'reddit' => 'Reddit',
								'wordpress' => 'Wordpress',
								'vimeo' => 'Vimeo',
								'vine' => 'Vine',
								'flickr' => 'Flickr',
								'skype' => 'Skype',
								'behance' => 'Behance',
								'paypal' => 'Paypal',
								'rdio' => 'Rdio',
								'spotify' => 'Spotify',
								'soundcloud' => 'Soundcloud',
								'phone' => 'Phone',
								'mail' => 'Email',
							),
							'default_value' => array (
							),
							'allow_null' => 0,
							'multiple' => 0,
							'ui' => 0,
							'ajax' => 0,
							'placeholder' => '',
							'disabled' => 0,
							'readonly' => 0,
							'return_format' => 'value',
						),
					),
				),
			),
			'location' => array (
				array (
					array (
						'param' => 'options_page',
						'operator' => '==',
						'value' => $this->settings['options-page-slug'],
					),
				),
			),
			'menu_order' => 1,
			'position' => 'normal',
			'style' => 'default',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => '',
			'active' => 1,
			'description' => '',
		));

		endif;
	}

	/**
	 * Add Facebook API options
	 */
	protected function add_facebook_API_options() {
		if( function_exists('acf_add_local_field_group') ):

		acf_add_local_field_group(array (
			'key' => 'group_57d01fb76cc35',
			'title' => 'Facebook App ID',
			'fields' => array (
				array (
					'key' => 'field_57d01fc1d6593',
					'label' => 'Facebook App ID',
					'name' => 'facebook_app_id',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
			),
			'location' => array (
				array (
					array (
						'param' => 'options_page',
						'operator' => '==',
						'value' => $this->settings['options-page-slug'],
					),
				),
			),
			'menu_order' => 0,
			'position' => 'normal',
			'style' => 'default',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => '',
			'active' => 1,
			'description' => '',
		));

		endif;
	}

	/**
	 * Get site's social media links template
	 */
	public function links() {
		$this->get_template_part( $this->settings['static-template'] );
	}

	/**
	 * Get social media share links
	 */
	public function share_links() {
		$this->get_template_part( $this->settings['shareable-template'] );
	}

	/**
	 * Add Facebook API script to $inline_script array
	 */
	public function register_facebook_script() {
		if ( $fb_app_id = get_field( 'facebook_app_id', 'options' ) ) :
		ob_start();
		?>
		<script>
			window.fbAsyncInit = function() {
				FB.init({
					appId      : '<?php echo $fb_app_id; ?>',
					xfbml      : true,
					version    : 'v2.6'
				});
				};
			
			 (function(d, s, id){
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) {return;}
				js = d.createElement(s); js.id = id;
				js.src = "//connect.facebook.net/en_US/sdk.js";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		</script>
		<?php
		$script = ob_get_clean();
		$this->register_inline_script( $script );
		endif;
	}
}