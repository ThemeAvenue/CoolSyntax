<?php
/**
 * Cool Syntax.
 *
 * @package   Cool_Syntax
 * @author    ThemeAvenue <web@themeavenue.net>
 * @license   GPL-2.0+
 * @link      http://themeavenue.net
 * @copyright 2014 ThemeAvenue
 */

/**
 * Plugin class. This class should ideally be used to work with the
 * public-facing side of the WordPress site.
 */
class Cool_Syntax {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	const VERSION = '1.0.0';

	/**
	 * Unique identifier for your plugin.
	 *
	 *
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'coolsyntax';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Activate plugin when new blog is added
		add_action( 'wpmu_new_blog', array( $this, 'activate_new_site' ) );

		// Load public-facing style sheet and JavaScript.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

	}

	/**
	 * Return the plugin slug.
	 *
	 * @since    1.0.0
	 *
	 * @return    Plugin slug variable.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
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
	 * Fired when the plugin is activated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Activate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       activated on an individual blog.
	 */
	public static function activate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide  ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_activate();
				}

				restore_current_blog();

			} else {
				self::single_activate();
			}

		} else {
			self::single_activate();
		}

	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Deactivate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_deactivate();

				}

				restore_current_blog();

			} else {
				self::single_deactivate();
			}

		} else {
			self::single_deactivate();
		}

	}

	/**
	 * Fired when a new site is activated with a WPMU environment.
	 *
	 * @since    1.0.0
	 *
	 * @param    int    $blog_id    ID of the new blog.
	 */
	public function activate_new_site( $blog_id ) {

		if ( 1 !== did_action( 'wpmu_new_blog' ) ) {
			return;
		}

		switch_to_blog( $blog_id );
		self::single_activate();
		restore_current_blog();

	}

	/**
	 * Get all blog ids of blogs in the current network that are:
	 * - not archived
	 * - not spam
	 * - not deleted
	 *
	 * @since    1.0.0
	 *
	 * @return   array|false    The blog ids, false if no matches.
	 */
	private static function get_blog_ids() {

		global $wpdb;

		// get an array of blog ids
		$sql = "SELECT blog_id FROM $wpdb->blogs
			WHERE archived = '0' AND spam = '0'
			AND deleted = '0'";

		return $wpdb->get_col( $sql );

	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @since    1.0.0
	 */
	private static function single_activate() {
		// @TODO: Define activation functionality here
	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 */
	private static function single_deactivate() {
		// @TODO: Define deactivation functionality here
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, basename( plugin_dir_path( dirname( __FILE__ ) ) ) . '/languages/' );

	}

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		$theme   = coolsyntax_get_option( 'theme', 'prism' );
		$file    = ( 'prism' == $theme ) ? 'prism.css' : "prism-$theme.css";
		$plugins = coolsyntax_get_option( 'plugins', array() );

		/* Load the style, if needed, for ever Prism plugin enabled */
		foreach( $plugins as $key => $plugin ) {
			$this->load_prism_plugin_resource( $plugin, 'style' );
		}

		wp_enqueue_style( $this->plugin_slug . '-coolsyntax', CSY_URL . 'public/assets/css/coolsyntax.css', array(), self::VERSION );
		wp_enqueue_style( $this->plugin_slug . '-prism', CSY_URL . "public/assets/bower_components/prism/themes/$file", array(), self::VERSION );
	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		$plugins = coolsyntax_get_option( 'plugins', array() );

		wp_enqueue_script( $this->plugin_slug . '-coolsyntax', CSY_URL . 'public/assets/js/coolsyntax.min.js', array( 'jquery' ), self::VERSION, true );

		/* Load the script, if needed, for ever Prism plugin enabled */
		foreach( $plugins as $key => $plugin ) {
			$this->load_prism_plugin_resource( $plugin, 'script' );
		}

	}

	/**
	 * Load required resources for a prism plugin.
	 * 
	 * @param  string $plugin   Plugin that need to be loaded
	 * @param  string $resource Type of resource that's needed (style or script)
	 * @since  1.0.0
	 */
	protected function load_prism_plugin_resource( $plugin, $resource ) {

		$deps = $this->get_prism_plugin_dependency( $plugin );

		if( false === $deps )
			return;

		if( !isset( $deps[$resource] ) )
			return;

		$src    = isset( $deps['path'] ) ? $deps['path'] : false;
		$script = isset( $deps['script'] ) ? $deps['script'] : false;
		$style  = isset( $deps['style'] ) ? $deps['style'] : false;

		if( 'script' == $resource && false !== $script )
			wp_enqueue_script( "$this->plugin_slug-prism-$plugin", CSY_URL . "$src/$script", array(), self::VERSION, true );

		elseif( 'style' == $resource && false !== $style )
			wp_enqueue_style( "$this->plugin_slug-prism-$plugin", CSY_URL . "$src/$style", array(), self::VERSION, 'all' );

	}

	/**
	 * Get Prism plugin dependencies.
	 *
	 * Get the script, style and path of a specific
	 * Prism plugin.
	 * 
	 * @param  string $plugin Plugin which dependencies are required
	 * @return [type]         [description]
	 */
	protected function get_prism_plugin_dependency( $plugin ) {

		$plugins = array(
			'line_highlight' => array(
				'path'   => 'public/assets/bower_components/prism/plugins/line-highlight',
				'style'  => 'prism-line-highlight.css',
				'script' => 'prism-line-highlight.min.js'
			),
			'line_numbers' => array(
				'path'   => 'public/assets/bower_components/prism/plugins/line-numbers',
				'style'  => 'prism-line-numbers.css',
				'script' => 'prism-line-numbers.min.js'
			),
			'show_invisibles' => array(
				'path'   => 'public/assets/bower_components/prism/plugins/show-invisibles',
				'style'  => 'prism-show-invisibles.css',
				'script' => 'prism-show-invisibles.min.js'
			),
			'autolinker' => array(
				'path'   => 'public/assets/bower_components/prism/plugins/autolinker',
				'style'  => 'prism-autolinker.css',
				'script' => 'prism-autolinker.min.js'
			),
			'webplateform_docs' => array(
				'path'   => 'public/assets/bower_components/prism/plugins/wpd',
				'style'  => 'prism-wpd.css',
				'script' => 'prism-wpd.min.js'
			),
			'file_highlight' => array(
				'path'   => 'public/assets/bower_components/prism/plugins/file-highlight',
				'script' => 'prism-file-highlight.min.js'
			),
		);

		$deps = isset( $plugins[$plugin] ) ? $plugins[$plugin] : false;
		
		return apply_filters( 'coolsyntax_prism_plugins_deps', $deps );

	}

}

/**
 * Get plugin option
 * 
 * @param  string $option  Option to retrieve
 * @param  string $default Default option to return if no value is found
 * @return mixed           Option value
 * @since  1.0.0
 */
function coolsyntax_get_option( $option, $default = '' ) {

	/*
	 * Call $plugin_slug from public plugin class.
	 */
	$plugin = Cool_Syntax::get_instance();
	$plugin_slug = $plugin->get_plugin_slug();

	$key     = $plugin_slug . '_options';
	$options = get_option( $key, $default );

	return isset( $options[$option] ) ? $options[$option] : $default;

}