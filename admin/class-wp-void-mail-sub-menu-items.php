<?php

class Wp_Void_Mail_Sub_Menu_Items
{
	/** 
	*  @since 1.0
	*  @access private
	*  @var string 		$parent_slug	 The slug name for the parent menu (or the file name of a standard WordPress admin page).
	**/

	private $parent_slug;

	/** 
	*  @since 1.0
	*  @access private
	*  @var string 		$page_title	 The text to be displayed in the title tags of the page when the menu is selected.
	**/
	private $page_title;

	/** 
	*  @since 1.0
	*  @access private
	*  @var string 		$menu_title	 The text to be displayed in the title tags of the page when the menu is selected.
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

	public function __construct( $parent_slug, $page_title, $function )
	{
		/*  Sanitizee the $parent_slug so that we can use it as slug
			Sanitizes title, replacing whitespace with dashes.
		*/
		$this->parent_slug = sanitize_title_with_dashes( $parent_slug );
		$this->page_title = $page_title;
		$this->menu_title = $page_title;
		$this->capability = 'manage_options';
		$this->menu_slug = sanitize_title_with_dashes( $page_title );
		$this->function = $function;
	}
	public function add_submenu()
	{
		add_submenu_page(
			$this->parent_slug,
			sprintf( esc_html__( '%s', VOID_MAIL_TEXT_DOMAIN ), $this->page_title ), 
			sprintf( esc_html__( '%s', VOID_MAIL_TEXT_DOMAIN), $this->menu_title ),
			$this->capability,
			$this->menu_slug,
			$this->function
		);
	}
}