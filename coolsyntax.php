<?php
/**
 * The WordPress Plugin Boilerplate.
 *
 * A foundation off of which to build well-documented WordPress plugins that
 * also follow WordPress Coding Standards and PHP best practices.
 *
 * @package   CoolSyntax
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Your Name or Company Name
 *
 * @wordpress-plugin
 * Plugin Name:       CoolSyntax
 * Plugin URI:        http://themeavenue.net
 * Description:       Sometimes you don't need a milion of fancy options when highlighting your code, and you don't want a heavy plugin that might break your site. CoolSyntax is a lightweight syntax highlighter with only the options you need.
 * Version:           1.0.0
 * Author:            ThemeAvenue
 * Author URI:        http://themeavenue.net
 * Text Domain:       coolsyntax
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/* Define all the plugin constants */
define( 'CSY_URL', plugin_dir_url( __FILE__ ) );
define( 'CSY_PATH', plugin_dir_path( __FILE__ ) );
define( 'CSY_BASENAME', plugin_basename(__FILE__) );

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

/*
 * @TODO:
 *
 * - replace `class-plugin-name.php` with the name of the plugin's class file
 *
 */
require_once( plugin_dir_path( __FILE__ ) . 'public/class-coolsyntax.php' );

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 *
 * @TODO:
 *
 * - replace Plugin_Name with the name of the class defined in
 *   `class-plugin-name.php`
 */
register_activation_hook( __FILE__, array( 'Cool_Syntax', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Cool_Syntax', 'deactivate' ) );

/*
 * @TODO:
 *
 * - replace Plugin_Name with the name of the class defined in
 *   `class-plugin-name.php`
 */
add_action( 'plugins_loaded', array( 'Cool_Syntax', 'get_instance' ) );

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

/**
 * The code below is intended to to give the lightest footprint possible.
 */
if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	/* Call the plugin settings page */
	require_once( CSY_PATH . 'admin/includes/settings.php' );

	/* Call the plugin functions */
	require_once( CSY_PATH . 'admin/includes/rendering.php' );

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-coolsyntax-admin.php' );
	add_action( 'plugins_loaded', array( 'Cool_Syntax_Admin', 'get_instance' ) );

}