<?php 
/* defines mail verifier using api */
class Wp_Void_Mail_Verifier
{

	protected $api_key;

	protected $emails;

	protected $db_handle;

	protected $table_name;

	public function __construct( $option_name  )
	{
		// get the api key from options
		global $wpdb;
		$this->db_handle = $wpdb;
		$this->table_name = VOID_MAIL_DB_TABLE;
		$this->api_key = get_option( $option_name );
		//$this->emails = $emails;
		add_action('wp_ajax_void_verifier', array( $this, 'void_verifier'));
		
	}
	public function void_verifier()
	{
		
		$value = $_POST['number'];

		if( $value == 'all' ){
			$query = "SELECT emails FROM $this->table_name WHERE verified = 0 ";
			$this->emails = $this->db_handle->get_col( $query );			
		}
		if( $this->emails ){
			foreach ( $this->emails as $index => $email ){
				$this->quickmail_verifier( $this->api_key, $email );
			}
			wp_die();	
		}else{
			echo 'all verified';
			wp_die();
		}				
	}
	protected function quickmail_verifier( $api_key, $email )
	{	

		
		// get response from the api, set sslverify argument as false as API does not use ssl otherwise it will return error		
		$response =   wp_remote_get( 'http://api.quickemailverification.com/v1/verify?email='.$email.'&apikey='.$api_key.'', array( 'sslverify' => false, 'timeout' => 0 ) );  

		if( is_wp_error( $response ) ) {
			echo 'Time out response from API'; 
			wp_die();
		} 		
		
		//retrieve the body of the response
		$body = wp_remote_retrieve_body( $response );
		//Decode JSON response
		$decoded = json_decode( $body );
		//check if the limit is exceeded
		if( $decoded->success == 'false' ){
			echo $decoded->message;
			//exit script
			wp_die();
		}
		$return = '<li>' . '<span class="wpvms-from">' . $email . '</span> Status: <span class="wpvms-mail">' . $decoded->result . '</span></li>';
		sleep(1);
		echo ( $return );
		ob_flush();
		flush();
		// Access and use your preferred validation result objects
		if( $decoded->result == 'valid' ){
			//set verfied to 1 from 0
			$set = array( 'verified' => 1 );
			//selectors
			$where = array( 'emails' => $email );
			//update verified column
			$this->db_handle->update( $this->table_name, $set, $where );
			$return = '<li>' . '<span class="wpvms-from">' . $email . '</span><span class="wpvms-mail">' . ' verified status changed to true ' . '</span></li>';
			usleep( 20000 );
			echo ( $return );
			ob_flush();
			flush();
		}else{
			$where = array( 'emails' => $email );
			//delete invalid mail
			$this->db_handle->delete( $this->table_name, $where );
			$return = '<li>' . '<span class="wpvms-from">' . $email . '</span><span class="wpvms-mail">' . ' deleted ' . '</span></li>';
			usleep( 20000 );
			echo ( $return );
			ob_flush();
			flush();
		}
	}
}