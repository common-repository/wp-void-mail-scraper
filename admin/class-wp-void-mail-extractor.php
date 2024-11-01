<?php
/* This class extracts email from texts */
class Wp_Void_Mail_Extractor
{
	/**
	* @param $text Texts from where email will be scrapped from
	* @access protected
	* @since version 1.0
	**/

	protected $text;
	/**
	* @param $from From where the instance was created
	* @access protected
	* @since version 1.0
	**/

	protected $from;
	/**
	* @param $json_flug to use json_encode 
	* @access protected
	* @since version 1.0
	**/

	protected $json_flug;

	public function __construct( $text, $from , $json_flug = true )
	{
		$this->text = $text;
		$this->from = $from;
		$this->json_flug = $json_flug;
		// call function to extract mail
		$this->extract_mail();
	}

	public function extract_mail()
	{
		//pattern to find matches 
		$pattern	=	"/[a-z0-9]+[_a-z0-9\.-]*[a-z0-9]+@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,20})/i";
		$text = $this->text;		
		//$matches where the returned matched elements are saved
		$matched = preg_match_all($pattern, $text, $matches);

		if( $matched ) {
			
    		// add bracket and put ' ' on every email that is saved in $matches[0] so that we can insert multiple valuse in DB with a single query
			array_walk($matches[0], function( &$value, &$index ){				
				$value = "('" . strtolower( $value ) . "')";

			});
			// array to string 
			$mails = implode(',', $matches[0]);			
			//get defined table name
			$table_name = VOID_MAIL_DB_TABLE;			
			//handle to run WP query
			global $wpdb;
			//query	
			$query = "INSERT INTO $table_name (emails) VALUES $mails";
			//run query
			$wpdb->query( $query );
			//send data to js 
			$return = '<li>' . 'Scraping: <span class="wpvms-from">' . $this->from . '</span> mails found: <span class="wpvms-mail">' . $mails . '</span></li>';						
			if( $this->from == 'textarea' ){
				echo ( json_encode( $return ) );
			}elseif( $this->json_flug == true ){
				sleep(1);
				echo ( json_encode($return ) );
				ob_flush();
				flush();
			}else{
				sleep(1);
				echo ( $return );
				ob_flush();
				flush();							
			}			
		}else{
			$return = '<li>' . 'Scraping: <span class="wpvms-from">' . $this->from . '</span> No mail found.'  . '</li>';
			if( $this->from == 'textarea' ){
				echo ( json_encode( $return ) );
			}elseif( $this->json_flug == true ){
				sleep(1);
				echo ( json_encode($return ) );
				ob_flush();
				flush();
			}else{
				sleep(1);
				echo ( $return );
				ob_flush();
				flush();							
			}						
		}    	
	}
}