<?php 
/* class that processes all info from DB */
class Wp_Void_Mail_Info
{
	protected $db_handle;
	protected $table_name;
	public function __construct()
	{
		global $wpdb;
		$this->db_handle = $wpdb;
		$this->table_name = VOID_MAIL_DB_TABLE;
	}
	public function count_emails()
	{
		$query = "SELECT COUNT(*) FROM $this->table_name";
		$number = $this->db_handle->get_var( $query );

		return $number;
	}
	public function count_verified_email()
	{
		$query = "SELECT COUNT(verified) FROM $this->table_name WHERE verified = 1";
		$number = $this->db_handle->get_var( $query );

		return $number;
	}
	public function mailpoet2_status()
	{
		if( is_plugin_active( 'wysija-newsletters/index.php' ) ){
			return true;
		}else{
			return false;
		}
	}
	public function mailpoet3_status()
	{
		if( is_plugin_active( 'mailpoet/mailpoet.php' ) ){
			return true;
		}else{
			return false;
		}
	}
}