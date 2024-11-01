<?php 
/* process select2 */
class Wp_Void_Mail_Select2
{
    //mailpoet 2
	public function wysija_list_process()
	{
		if( isset($_POST['list']) && !empty( $_POST['list'] ) ){
			//get selected list ids
			$list_ids = explode(',', $_POST['list']);
			//wpdb handle
			global $wpdb;
			$table_name = VOID_MAIL_DB_TABLE;
			$wpsija_user = $wpdb->prefix . 'wysija_user';
			$wpsija_user_list = $wpdb->prefix . 'wysija_user_list';
			$query = "SELECT emails FROM $table_name WHERE verified = 1";
			//fetch result
			$results =  $wpdb->get_results( $query ) ;			
			//format results to be used in query
			foreach ( $results as $index => $result ){
				//email,status in wysija_user DB
				$results[ $index ]= "('". $result->emails . "',1)";
				//emails
				$emails[ $index ] = "'" . $result->emails ."'";
			}
			//array to string
			$emails = implode(',', $emails );			
			//array to string
			$results = implode(',', $results );

			/**	First insert email into wysija_user DB so that we can refer the ID in 	       wysija_user_list DB 
			**/
			$query = "INSERT INTO $wpsija_user (email, status ) VALUES $results ON DUPLICATE KEY UPDATE status = 1";			
			$wpdb->query( $query );

			/** The same email can be in various newsletter list so we run a loop for every email   
			**/
			foreach ( $list_ids as $list_id ){
				// ON duplicate we just update the list
				$query = "INSERT INTO $wpsija_user_list ( list_id, user_id ) SELECT $list_id,user_id FROM $wpsija_user WHERE email IN ($emails) ON DUPLICATE KEY UPDATE list_id = $list_id";
				$wpdb->query( $query );					
			}
			echo '<div class="wpvms_done">Successfully added to mailpoet 2 subscription list</div>';			
			wp_die();
		}		
	}
    //mailpoet 3
	public function mailpoet_list_process()
	{
		if( isset($_POST['list']) && !empty( $_POST['list'] ) ){
		    global $wpdb;
			//get selected list ids
			$list_ids = $_POST['list'];
			$list_ids = explode(',', $list_ids );
			$options = array(
			  'send_confirmation_email' => false, // default: true
			  'schedule_welcome_email' => false // default: true
			);	
			global $wpdb;
			$table_name = VOID_MAIL_DB_TABLE;
			
			$query = "SELECT emails FROM $table_name WHERE verified = 1";
			//fetch result
			$results =  $wpdb->get_results( $query ) ;			
			//format results to be used in query
			foreach ( $results as $index => $result ){
				//email
				$emails[ $index ]=  $result->emails;				
				
			}
			foreach( $emails as $email ){
				$subscriber_data = array( 'email' => $email );
			        try{
					$subscriber = \MailPoet\API\API::MP('v1')->addSubscriber($subscriber_data, $list_ids, $options);
					$where_to = array( 'email' => $email );
					$update = array( 'status' => 'subscribed' );
					$table_name = $wpdb->prefix . 'mailpoet_subscribers';
					$wpdb->update( $table_name, $update, $where_to );
					usleep( 500000 );
					echo '<li><em>' . $email . '</em> added to mailpoet 3 subscription list</li>';
					ob_flush();
					flush();
				} catch( Exception $Exception ){
					$where_to = array( 'email' => $email );
					$update = array( 'status' => 'subscribed' );
					$table_name = $wpdb->prefix . 'mailpoet_subscribers';
					$wpdb->update( $table_name, $update, $where_to );
					usleep( 500000 );
					echo '<li><em>' . $email . '</em> already in mailpoet 3 subscription list, status updated to subscribed</li>';
					ob_flush();
					flush();
					continue;
				}
			}
			
			wp_die();
		}else{
			echo 'Please Select one/multiple list';
			wp_die();
		}
	}
}