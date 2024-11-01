<?php

/**
 * Fired when the plugin is uninstalled. 
 *
 * @link       http://wpemailscraper.com
 * @since      1.0
 *
 * @package    WP Void Mail Scraper
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

//all option names
$option_names = [ 'void_mail_db_version', 'wpvms_quickmail_verifier_key', 'wpvms_quick_mail_verifier_status','wpvms_activation_time'];

//delete each option name
foreach( $option_names as $index => $option_name ){
	delete_option( $option_name );
}


global $wpdb;

$db_table = $wpdb->prefix . 'void_mail_scraper';
$wpdb->query( "DROP TABLE IF EXISTS $db_table" );
