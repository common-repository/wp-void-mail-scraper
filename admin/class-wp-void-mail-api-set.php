<?php
/* sets api key as wordpress option */

class Wp_Void_Mail_Api_Set{		

	public function set_api()
	{
		$option_name = $_POST[ 'opt_name' ];
		$api_key = $_POST[ 'api_key' ];
		if( $option_name == 'wpvms_quickmail_verifier_key' ){
			$this->quick_mail_api_check( $api_key );
		}		
		if( get_option( $option_name ) !== false ){
			update_option( $option_name, $api_key );
		}else{			
			add_option( $option_name, $api_key );
		}
		wp_die();
	}
	protected function quick_mail_api_check( $api_key, $email = 'dummy@mail.com' )
	{		

		// get response from the api, set sslverify argument as false as API does not use ssl otherwise it will return error
		$response =   wp_remote_get( 'http://api.quickemailverification.com/v1/verify?email='.$email.'&apikey='.$api_key.'', array( 'sslverify' => false, 'timeout' => 0 ) ); 

		if( is_wp_error( $response ) ) {
			echo 'Time out response from API'; 
			return;
		} 		
		
		//retrieve the body of the response
		$body = wp_remote_retrieve_body( $response );
		//Decode JSON response
		$decoded = json_decode( $body );
		//check for valid api key
		if( $decoded->success == 'true' ){
			update_option( 'wpvms_quick_mail_verifier_status', 1 );
			echo 'true';	
		}else{
			update_option( 'wpvms_quick_mail_verifier_status', 0 );
			echo 'false';
		}
	}
}