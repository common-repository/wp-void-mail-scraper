<?php

/**
 * Register all actions and filters for the plugin
 *
 * @link       http://wpemailscraper.com
 * @since      1.0
 *
 * @package    WP Void Mail Scraper
 * @subpackage wp-void-mail-scraper/includes
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    WP Void Mail Scraper
 * @subpackage wp-void-mail-scraper/includes
 * @author     VoidCoders <admin@voidcoders.com>
 */
Class Wp_Void_Mail_loader
{
	protected $actions;
	protected $filters;

	public function __construct(){
		$this->actions = array();
		$this->filters = array();
	} 
	/**
	 * Add a new action to the collection to be registered with WordPress.
	 *
	 * @since    1.0
	 * @param    string               $hook             The name of the WordPress action that is being registered.
	 * @param    object               $component        A reference to the instance of the object on which the action is defined.
	 * @param    string               $callback         The name of the function definition on the $component.
	 * @param    int                  $priority         Optional. The priority at which the function should be fired. Default is 10.
	 * @param    int                  $args    Optional. The number of arguments that should be passed to the $callback. Default is 1.
	 */
	public function add_action( $hook, $component, $callback, $priority = 10, $args = 1)
	{
		$this->actions = $this->add( $this->actions, $hook, $component, $callback, $priority, $args );
	}
	/**
	 * Add a new action to the collection to be registered with WordPress.
	 *
	 * @since    1.0
	 * @param    string               $hook             The name of the WordPress action that is being registered.
	 * @param    object               $component        A reference to the instance of the object on which the action is defined.
	 * @param    string               $callback         The name of the function definition on the $component.
	 * @param    int                  $priority         Optional. The priority at which the function should be fired. Default is 10.
	 * @param    int                  $args    Optional. The number of arguments that should be passed to the $callback. Default is 1.
	 */
	public function add_filter( $hook, $component, $callback, $priority = 10, $args = 1 )
	{
		$this->filters = $this->add( $this->filters, $hook, $component, $callback, $priority, $args );
	}

	/**
	 * A utility function that is used to register the actions and hooks into a single
	 * collection.
	 *
	 * @since    1.0
	 * @access   private
	 * @param    array                $hooks            The collection of hooks that is being registered (that is, actions or filters).
	 * @param    string               $hook             The name of the WordPress filter that is being registered.
	 * @param    object               $component        A reference to the instance of the object on which the filter is defined.
	 * @param    string               $callback         The name of the function definition on the $component.
	 * @param    int                  $priority         The priority at which the function should be fired.
	 * @param    int                  $args    The number of arguments that should be passed to the $callback.
	 * @return   array                                  The collection of actions and filters registered with WordPress.
	 */
    private function add( $hooks, $hook, $component, $callback, $priority, $args )
    {
    	$hooks[] = array(
    		'hook'		=> $hook,
    		'component'	=> $component,
    		'callback'	=> $callback,
    		'priority'	=> $priority,
    		'args'		=> $args
     	);

     	return $hooks;
    }
    /**
	 * Register the filters and actions with WordPress.
	 *
	 * @since    1.0
	 */
	public function loader_run()
	{
		// for every add filter call , here component is a reference to the instance of the object on which the action is defined.
		foreach( $this->filters as $hook ){
			add_filter( $hook[ 'hook' ], array( $hook['component'], $hook['callback']), $hook['priority'], $hook['args'] );
		}
		// for every add action call , here component is a reference to the instance of the object on which the action is defined.
		foreach( $this->actions as $hook ){
			add_action( $hook[ 'hook' ], array( $hook[ 'component'] , $hook[ 'callback' ] ), $hook[ 'priority' ], $hook[ 'args'] ); 
		}
	}
}
