<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://wpemailscraper.com
 * @since      1.0
 *
 * @package    WP Void Mail Scraper
 * @subpackage wp-void-mail-scraper/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0
 * @package    WP Void Mail Scraper
 * @subpackage wp-void-mail-scraper/includes
 * @author     VoidCoders <admin@voidcoders.com>

*/

class WP_Void_Mail_Scraper
{
	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0
	 * @access   protected
	 * @var      array   $loader    Maintains and registers all hooks for the plugin.
	*/

	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0
	 * @access   protected
	 * @var      string     WP_Void_Mail    The string used to uniquely identify this plugin.
	 */
	protected $wp_void_mail_scraper;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;
	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0
	*/

	public function __construct()
	{
		if( defined('VOID_MAIL_VERSION') ){
			$this->version = VOID_MAIL_VERSION;
		}else{
			$this->version = '1.0';
		}

		$this->wp_void_mail_scraper = 'wp-void-mail-scraper';
		$this->load_dependencies();
		$this->set_locale(); 
		$this->define_admin_hooks();		
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wp_Void_Mail_Loader. Orchestrates the hooks of the plugin.
	 * - Plugin_Name_i18n. Defines internationalization functionality.
	 * - Plugin_Name_Admin. Defines all hooks for the admin area.
	 * - Plugin_Name_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0
	 * @access   private
	*/

	private function load_dependencies()
	{
		require_once VOID_MAIL_DIR . 'includes/class-wp-void-mail-loader.php';
		require_once VOID_MAIL_DIR . 'includes/class-wp-void-mail-i18n.php';
		require_once VOID_MAIL_DIR . 'admin/class-wp-void-mail-info.php';
		require_once VOID_MAIL_DIR . 'admin/class-wp-void-mail-admin.php';
		require_once VOID_MAIL_DIR . 'admin/views/class-wp-void-mail-admin-view.php';
		require_once VOID_MAIL_DIR . 'admin/class-wp-void-mail-admin-menu.php';
		require_once VOID_MAIL_DIR . 'admin/vendor/PDF2Text.php';
		require_once VOID_MAIL_DIR . 'admin/views/class-wp-void-mail-text-files.php';
 		require_once VOID_MAIL_DIR . 'admin/views/class-wp-void-mail-api-view.php';	
		require_once VOID_MAIL_DIR . 'admin/views/class-wp-void-mail-list.php';
		require_once VOID_MAIL_DIR . 'admin/views/class-wp-void-mail-mailpoet.php';
		require_once VOID_MAIL_DIR . 'admin/views/class-wp-void-mail-crawler.php';				
		require_once VOID_MAIL_DIR . 'admin/class-wp-void-mail-sub-menu-items.php';
		require_once VOID_MAIL_DIR . 'admin/class-wp-void-mail-extractor.php';	
		require_once VOID_MAIL_DIR . 'admin/class-wp-void-mail-form-process.php';	
		require_once VOID_MAIL_DIR . 'admin/class-wp-void-mail-file-upload.php';		
		require_once VOID_MAIL_DIR . 'admin/class-wp-void-mail-pdfparser.php';
		require_once VOID_MAIL_DIR . 'admin/class-wp-void-mail-api-set.php';
		require_once VOID_MAIL_DIR . 'admin/class-wp-void-mail-verifier.php';
		require_once VOID_MAIL_DIR . 'admin/class-wp-void-mail-list-process.php';
		require_once VOID_MAIL_DIR . 'admin/class-wp-void-mail-select2.php';
		require_once VOID_MAIL_DIR . 'admin/class-wp-void-mail-main-scraper.php';		

 
		$this->loader = new WP_Void_Mail_Loader();
	}
	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wp_Void_Mail_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0
	 * @access   private
	 */
	private function set_locale() {

		$wp_void_mail_i18n = new Wp_Void_Mail_i18n();

		$this->loader->add_action( 'plugins_loaded', $wp_void_mail_i18n, 'load_plugin_textdomain' );

	}
	private function define_admin_hooks()
	{
		// object that does the all script and styles enqueueing
		$wp_void_mail_admin = new Wp_Void_Mail_Admin( $this->wp_void_mail_scraper, $this->version );
		//enqueue styles
		/**
		* @param  action name
		* @param  instance of Object that holds the function that we will run on action name
		* @param  function name
		* @since 1.0
		**/		
		$this->loader->add_action( 'admin_enqueue_scripts', $wp_void_mail_admin, 'enqueue_styles' );
		/**
		* @param  action name
		* @param  instance of Object that holds the function that we will run on action name
		* @param  function name
		* @since 1.0
		**/
		//enqueue scripts
		$this->loader->add_action( 'admin_enqueue_scripts', $wp_void_mail_admin, 'enqueue_scripts' );

		//WP Void Mail Scraper Menu

		// admin main menu page view instance
		$admin_menu_page = new Wp_Void_Mail_Admin_View();
		//get the public function that holds the html
		$handle = array( $admin_menu_page, 'view' );
		//pass what will be the menu name  , slug will be generated from it
		$menu_name = 'WPVMS mail Scraper';
		//call the constructor to set the values
		$admin_menu = new Wp_Void_Mail_Admin_Menu( $menu_name, $handle , 'dashicons-email-alt', 6 );
		/**
		* @param  action name
		* @param  instance of Object that holds the function that we will run on action name
		* @param  function name
		* @since 1.0
		**/
		$this->loader->add_action( 'admin_menu', $admin_menu, 'add_admin_menu' );

		//Texts/Files Menu
		//instance of view
		$txt_file_veiw = new Wp_Void_Mail_Text_Files();
		// get the public function that holds the html
		$txt_file_view_handle = array( $txt_file_veiw, 'view' );
		//pass what will be the menu name  , slug will be generated from it
		$submenu_text_files = 'WPVMS Text/Files';		
		$text_files_menu = new Wp_Void_Mail_Sub_Menu_Items( $menu_name, $submenu_text_files, $txt_file_view_handle );
		/**
		* @param  action name
		* @param  instance of Object that holds the function that we will run on action name
		* @param  function name
		* @since 1.0
		**/
		$this->loader->add_action( 'admin_menu', $text_files_menu, 'add_submenu' );

		//API Menu
		$admin_api_view = new Wp_Void_Mail_Api_View();
		$admin_api_view_handle = array( $admin_api_view, 'view' );
 		$submenu_api = 'WPVMS Verifier';
 		$submenu = new Wp_Void_Mail_Sub_Menu_Items( $menu_name, $submenu_api, $admin_api_view_handle );
 		/**
		* @param  action name
		* @param  instance of Object that holds the function that we will run on action name
		* @param  function name
		* @since 1.0
		**/
 		$this->loader->add_action( 'admin_menu', $submenu, 'add_submenu' );

 		//(list) menu item
 		//create instance of view
 		$list_view = new Wp_Void_Mail_List();
 		//method of view instance
 		$list_view_handle = array( $list_view, 'list_view' );
 		//submenu name , slug will be generated from it 
 		$submenu_list = 'WPVMS List';
 		//create instance of submenu
 		$list_menu = new Wp_Void_Mail_Sub_Menu_items( $menu_name , $submenu_list, $list_view_handle ); 	
 		/**
		* @param  action name
		* @param  instance of Object that holds the function that we will run on action name
		* @param  function name
		* @since 1.0
		**/
 		$this->loader->add_action( 'admin_menu', $list_menu, 'add_submenu' );

 		// Form Processor for inputed text
 		$input_form = new Wp_Void_Mail_Form_Process();
 		/**
		* @param  action name
		* @param  instance of Object that holds the function that we will run on action name
		* @param  function name
		* @since 1.0
		**/
 		$this->loader->add_action('wp_ajax_inserted_text', $input_form, 'inserted_text' );

 		$file_upload = new Wp_Void_Mail_File_Upload() ;
 		$this->loader->add_action('wp_ajax_file_upload', $file_upload, 'file_upload');
 		// when .pdf file is uploaded , it's necessary to conver it to .txt
 		$pdf_parse = new Wp_Void_Mail_Pdfparser();
 		$this->loader->add_action('wp_ajax_pdf_parser', $pdf_parse, 'parsepdf');
 		//setting api options
 		$api_set = new Wp_Void_Mail_Api_Set();
 		$this->loader->add_action( 'wp_ajax_set_api', $api_set, 'set_api' );

 		//verifier 
 		$verifier = new Wp_Void_Mail_Verifier('wpvms_quickmail_verifier_key');

 		//list process
 		$list_process = new Wp_Void_Mail_List_Process();
 		$this->loader->add_action( 'wp_ajax_delete_selected', $list_process, 'delete' );
 		$this->loader->add_action( 'wp_ajax_delete_duplicate', $list_process, 'delete_duplicate' );		

 		//mailpoet 		
 		$mailpoet_view = new Wp_Void_Mail_Mailpoet();
 		//method of view instance 
 		$mailpoet_view_handle = array( $mailpoet_view, 'mailpoet_view' );
 		//submenu name , slug will be generated from it 
 		$submenu_mailpoet = 'WPVMS Mailpoet';
 		//create instance of submenu
 		$mailpoet_menu = new Wp_Void_Mail_Sub_Menu_items( $menu_name , $submenu_mailpoet, $mailpoet_view_handle );
 		/**
		* @param  action name
		* @param  instance of Object that holds the function that we will run on action name
		* @param  function name
		* @since 1.0
		**/
 		$this->loader->add_action( 'admin_menu', $mailpoet_menu, 'add_submenu' );

 		$select2_process = new Wp_Void_Mail_Select2();
 		$this->loader->add_action( 'wp_ajax_wysija_list_process', $select2_process, 'wysija_list_process');
 		$this->loader->add_action( 'wp_ajax_mailpoet_list_process', $select2_process, 'mailpoet_list_process');

 		//Crawler
 		$crawler_view = new Wp_Void_Mail_Crawler();
 		$crawler_view_handle = array( $crawler_view, 'crawler_view' );
 		$submenu_crawler = 'WPVMS Crawler';
 		$crawler_submenu = new Wp_Void_Mail_Sub_Menu_Items( $menu_name, $submenu_crawler, $crawler_view_handle );

 		$this->loader->add_action( 'admin_menu', $crawler_submenu, 'add_submenu' );

 		$scraper_main = new Wp_Void_Mail_Main_Scraper();
 		$this->loader->add_action( 'wp_ajax_website_crawl', $scraper_main, 'website_crawl' );
	}

	public function run()
	{
		$this->loader->loader_run();		
	}	

	
}