<?php 
/* class to add main admin menu item */
class Wp_Void_Mail_Admin_Menu
{
	/**
    * @since 1.0
    * @access private 
	* @var string 		$page_title 	The text to be displayed in the title tags of the page when the menu is selected.
	**/
	private $page_title;

	/**
    * @since 1.0
    * @access private 
	* @var string 		$menu_title    The text to be used for the menu.
	**/
	private $menu_title;

	/**
    * @since 1.0
    * @access private 
	* @var string 		$capability 	The capability required for this menu to be displayed to the user.
	**/
	private $capability;

	/**
    * @since 1.0
    * @access private 
	* @var string 		$menu_slug		The capability required for this menu to be displayed to the user.
	**/
	private $menu_slug;

	/**
    * @since 1.0
    * @access private 
	* @var string	$function		The function to be called to output the content for this page.
	**/
	private $function;

	/**
    * @since 1.0
    * @access private 
	* @var string 		$function		The URL to the icon to be used for this menu. 
	**/
	private $icon_url;

	/**
    * @since 1.0
    * @access private 
	* @var int 		$function		The position in the menu order this one should appear. 
	**/
	private $position;

	public function __construct( $page_title, $function, $icon_url, $position )
	{

		$this->page_title = $page_title;
		$this->menu_title = $page_title;
		$this->capability = 'manage_options';
		/*  Sanitizee the $page_title so that we can use it as slug
			Sanitizes title, replacing whitespace with dashes.
		*/
		$this->menu_slug  = sanitize_title_with_dashes( $page_title );
		$this->function   = $function;
		$this->icon_url	  = $icon_url;
		$this->position   = $position;

	}

	public function add_admin_menu()
	{
		add_menu_page( 
			sprintf( esc_html__('%s', VOID_MAIL_TEXT_DOMAIN ), $this->page_title ),
			sprintf( esc_html__('%s', VOID_MAIL_TEXT_DOMAIN ), $this->menu_title ),
			$this->capability,
			$this->menu_slug,
			$this->function,
			$this->icon_url,			
			$this->position
		);
	}
}