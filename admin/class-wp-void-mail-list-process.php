<?php 
/* process query on list page */

class Wp_Void_Mail_List_Process{
	public function delete(){
		
		$where = $_POST['ids'];
		global $wpdb;
		$table_name = VOID_MAIL_DB_TABLE;
		$query = "DELETE FROM $table_name WHERE id IN ($where) ";
		$wpdb->query( $query );
		echo $_POST['ids'];
		wp_die();
	}
	public function delete_duplicate(){
		global $wpdb;
		$table_name = VOID_MAIL_DB_TABLE;
		$query = "DELETE FROM $table_name WHERE id NOT IN ( SELECT * FROM ( SELECT DISTINCT id FROM $table_name GROUP BY emails ) as temp )";		
		$wpdb->query( $query );
		wp_die();
	}
}