<?php 
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://wpemailscraper.com
 * @since      1.0
 *
 * @package    WP Void Mail Scraper
 * @subpackage wp-void-mail-scraper/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WP Void Mail Scraper
 * @subpackage wp-void-mail-scraper/admin
 * @author     VoidCoders <admin@voidcoders.com>
 */

class Wp_Void_Mail_Admin{
	private $wp_void_mail_scraper;
	private $version;
	private $page_now;
	private $flag;
	public function __construct( $wp_void_mail_scraper, $version )
	{

		$this->wp_void_mail_scraper = $wp_void_mail_scraper;
		$this->version = $version;
		if( isset( $_GET['page'] ) ){
			$this->page_now = $_GET[ 'page' ];			
		}else{
			$this->flag = false;
		}
		if( strpos( $this->page_now, 'wpvms') === 0 ){
			$this->flag = true;
		}else{
			$this->flag = false;
		}		
	}

	public function enqueue_styles()
	{
		if( $this->flag ){
		//bootstrap
		wp_enqueue_style( 'bootstrap', VOID_MAIL_ADMIN . 'css/bootstrap.css', array(), $this->version, 'all' );		
		//enqueue datatable css
		wp_enqueue_style( 'datatable', VOID_MAIL_ADMIN . 'css/datatables.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'select2', VOID_MAIL_ADMIN . 'css/select2.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->wp_void_mail_scraper, VOID_MAIL_ADMIN . 'css/wp-void-mail-scraper.css', array(), $this->version, 'all' );
		}
	}

	public function enqueue_scripts()
	{	
		if( $this->flag ){	
			//enqueue datatable js
			wp_enqueue_script( 'datatable', VOID_MAIL_ADMIN . 'js/datatables.js', array('jquery'), $this->version, true );
			wp_enqueue_script( 'select2', VOID_MAIL_ADMIN . 'js/select2.js', array('jquery'), $this->version, true );
			wp_enqueue_script( $this->wp_void_mail_scraper, VOID_MAIL_ADMIN . 'js/void-mail-admin.js' , array('jquery'), $this->version, true );
			//localize mailpoet version	
			if( is_plugin_active('mailpoet/mailpoet.php' ) ){
				$mailpoet = array( 'ver' => 3 );
				wp_localize_script( $this->wp_void_mail_scraper, 'void_mail_mailpoet_ver', $mailpoet );
			}
			else if( is_plugin_active( 'wysija-newsletters/index.php') ){
				$mailpoet = array( 'ver' => 2 );
				wp_localize_script( $this->wp_void_mail_scraper, 'void_mail_mailpoet_ver', $mailpoet );
			}
		}					
	}
}