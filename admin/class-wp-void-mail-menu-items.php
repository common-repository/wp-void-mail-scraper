<?php 
/* Class to add menu and submenu items to admin dashboard and also calls for page object
*/
//classes needed to create object


class Menu_items 
{
	public $parent_slug;
	private $menu_page;

	public function __construct( $menu_slug, $textdomain, $capability )
	{
		$this->parent_slug = $menu_slug;
		$this->textdomain = $textdomain;
		$this->capability = $capability;
    
		//creating page object for view
		$this->menu_page = new Sub_menu_page();
	}
	public function init_funcs()
	{
		add_action( 'admin_menu', array( $this,add_menu_options( 'WordPress Email Scraper', 'WP Email Scraper',  'void_email_page', 'dashicons-email-alt', 6 )) );
	}
	// setting parent menu
	public function add_menu_options( $page_title, $menu_title, $func, $icon, $position)
	{	
		add_menu_page(
		  sprintf( esc_html__( '%s', $this->textdomain ), $page_title ),
		  sprintf( esc_html__( '%s', $this->textdomain ), $menu_title ),		  
		  $this->capability,
		  $this->parent_slug,
		  array( $this->menu_page, $func ),
		  $icon,
		  $position			
		);
	}

	//setting sub menu
	public function add_submenu_options( $page_title, $menu_title, $menu_slug, $func)
	{
		add_submenu_page(
			$this->parent_slug, 
			sprintf( esc_html__ ( '%s', $this->textdomain ), $page_title ), 
			sprintf( esc_html__( '%s', $this->textdomain ), $menu_title ) , 
			$this->capability,
			$menu_slug,
			array( $this->menu_page, $func )
		);
	}	
}