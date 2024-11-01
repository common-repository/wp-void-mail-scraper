<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://wpemailscraper.com
 * @since             1.0
 * @package           WP Void Mail Scraper
 *
 * @wordpress-plugin
 * Plugin Name:       WP Void Mail Scraper
 * Plugin URI:        http://wpemailscraper.com/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0
 * Author:            VoidCoders
 * Author URI:        https://voidcoders.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp_void_mail
 * Domain Path:       /languages
 */

if( !defined( 'ABSPATH' ) ){
	exit;
}
global $wpdb;

// dir C://example/example
define( 'VOID_MAIL_DIR', plugin_dir_path(__FILE__) );
//admin URL C://example/examplea/admmin
define( 'VOID_MAIL_ADMIN', plugin_dir_url( __FILE__) . 'admin/' );
//assets URL
define( 'VOID_MAIL_ASSETS', plugins_url('assets/', __FILE__ ) );
// DB version
define( 'VOID_MAIL_DB_VERSION', '1.0' );
//Plugin Version
define( 'VOID_MAIL_VERSION', '1.0' );
// DB Table Name
define( 'VOID_MAIL_DB_TABLE', $wpdb->prefix . 'void_mail_scraper' );

define( 'VOID_MAIL_TEXT_DOMAIN', 'wp_void_mail');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-void-mail-activator.php
 */
function void_mail_activate_plugin(){
	require_once VOID_MAIL_DIR . 'includes/class-wp-void-mail-activator.php';
	// call activate static function 
	WP_Void_Mail_Activator::activate();
}

function void_mail_deactivate_plugin(){
	require_once VOID_MAIL_DIR . 'includes/class-wp-void-mail-deactivator.php';
	// class deactivate static function
	WP_Void_Mail_Deactivator::deactivate();
}

// register hooks for activation and deactivation here __FILE__ points to directory where wp-void-mail-scraper.php is located
register_activation_hook(  __FILE__ , 'void_mail_activate_plugin' );
register_deactivation_hook( __FILE__, 'void_mail_deactivate_plugin' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require VOID_MAIL_DIR . 'includes/class-wp-void-mail-scraper.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0
 */

function wp_void_mail_scraper_run(){
 	$wp_void_mail_scraper = new Wp_Void_Mail_Scraper();
 	$wp_void_mail_scraper->run();
}

wp_void_mail_scraper_run();

