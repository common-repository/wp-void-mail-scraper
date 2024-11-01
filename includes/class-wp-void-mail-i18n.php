<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://wpemailscraper.com
 * @since      1.0.
 *
 * @package    wp-void-mail-scraper
 * @subpackage wp-void-mail-scraper/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0
 * @package    wp-void-mail-scraper
 * @subpackage wp-void-mail-scraper/includes
 * @author     VoidCoders <admin@voidcoders.com>
 */
class Wp_Void_Mail_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			VOID_MAIL_TEXT_DOMAIN,
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
