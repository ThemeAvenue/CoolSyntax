<?php
/**
 * CoolSyntax.
 *
 * @package   Cool_Syntax_Admin
 * @author    Julien Liabeuf <julien@liabeuf.fr>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 ThemeAvenue
 */

/**
 * Plugin class. This class should ideally be used to work with the
 * administrative side of the WordPress site.
 *
 * @package Cool_Syntax
 * @author  Julien Liabeuf <julien@liabeuf.fr>
 */
class Cool_Syntax_Admin {

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		/*
		 * Call $plugin_slug from public plugin class.
		 */
		$plugin = Cool_Syntax::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();

		// Add the options page and menu item.
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );
		add_action( 'admin_init', array( $this, 'register_plugin_settings' ) );

		// Load admin style sheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		/**
		 * Resources to load when the user can use rich editing
		 */
		if( ( current_user_can( 'edit_posts' ) || current_user_can( 'edit_pages' ) ) && 'true' == get_user_option( 'rich_editing' ) ) {

    		add_action( 'admin_footer', array( $this, 'plugin_dialog' ) );
			add_filter( 'mce_external_plugins', array( $this, 'register_tinymce_plugin' ) );
			add_filter( 'mce_buttons', array( $this, 'register_tinymce_button' ) );
			add_filter( 'mce_css', array( $this, 'add_tinymce_stylesheet' ) );

		}

	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @since     1.0.0
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_styles() {

		wp_enqueue_style( $this->plugin_slug .'-admin-styles', plugins_url( 'assets/css/admin.css', __FILE__ ), array(), Cool_Syntax::VERSION );

	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 * 
	 * @since     1.0.0
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {

		/**
		 * @todo see if I can detect if TinyMCE is on
		 */
		wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'assets/js/admin.js', __FILE__ ), array( 'jquery' ), Cool_Syntax::VERSION );
		wp_enqueue_script( $this->plugin_slug . '-admin-autosize', CSY_URL . 'public/assets/js/jquery.autosize.min.js', array( 'jquery' ), Cool_Syntax::VERSION );

	}	

	/**
	 * Load TinyMCE plugin
	 *
	 * @param  (array) $mce_plugins
	 * @return (array) $mce_plugins
	 * @since  1.0.0
	 */
	function register_tinymce_plugin( $mce_plugins ) {
		$mce_plugins[ 'coolsyntax' ] = CSY_URL . 'admin/assets/js/editor_plugin.js';
		return $mce_plugins;
	}

	/**
	 * Register the TinyMCE custom button
	 *
	 * @param  (array) $buttons
	 * @return (array) $buttons
	 * @since  1.0.0
	 */
	function register_tinymce_button( $buttons ) {
		array_push( $buttons, '|', 'coolsyntax_button' );
		return $buttons;
	}

	/**
	 * Load the dialog content
	 *
	 * @since 1.0.0
	 */
	function plugin_dialog() {
		
		include( CSY_PATH . 'admin/views/dialog.php' );

	}

	/**
	 * Custom style in TinyMCE
	 *
	 * @since 1.0.0
	 */
	public function add_tinymce_stylesheet( $wp ) {

		$wp .= ',' . CSY_URL . 'admin/assets/css/editor_style.css';
		return $wp;

	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

		$icon = ( version_compare( get_bloginfo( 'version' ), '3.8', '>=' ) ) ? 'dashicons-format-gallery' : WPBP_URL . 'admin/assets/images/be-badge-small.png';

		$settings 	= add_submenu_page( 'options-general.php', __( 'CoolSyntax Settings', 'coolsyntax' ), __( 'CoolSyntax', 'coolsyntax' ), 'manage_options', 'coolsyntax', array( $this, 'display_plugin_admin_page' ) );

	}

	public function display_plugin_admin_page() {

		include( CSY_PATH . 'admin/views/admin.php' );

	}

	/**
	 * Register plugin settings
	 *
	 * This function dynamically registers plugin
	 * settings based on the options provided in
	 * includes/settings.php
	 */
	public function register_plugin_settings() {

		$settings = coolsyntax_get_plugin_options();

		register_setting( $this->plugin_slug . '_options', $this->plugin_slug . '_options' );

		foreach( $settings as $key => $section ) {
			/* We add the sections and then loop through the corresponding options */
			add_settings_section( $section['id'], $section['title'], false, $this->plugin_slug . '_options' );

			/* Get the options now */
			foreach( $section['options'] as $k => $option ) {

				if( !isset($option['desc']) ) $option['desc'] = '';
				if( !isset($option['opts']) ) $option['opts'] = array();
				$field_args = array(
					'name' 		=> $option['id'],
					'title' 	=> $option['title'],
					'type' 		=> $option['type'],
					'desc' 		=> $option['desc'],
					'options' 	=> $option['opts'],
					'group' 	=> $this->plugin_slug . '_options'
				);

				add_settings_field( $option['id'], $option['title'], array( $this, 'outputSettingsFields' ), $this->plugin_slug . '_options', $section['id'], $field_args );
			}
		}
	}

	/**
	 * Calls field output function
	 * 
	 * @param (array) $args Arguments list for this setting
	 */
	public function outputSettingsFields( $args ) {
		coolsyntax_output_option( $args );
	}

}
