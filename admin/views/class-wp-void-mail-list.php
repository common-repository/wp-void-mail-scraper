<?php
/* page to show emails */

class Wp_Void_Mail_List{
	protected $results;

	public function db_query()
	{			
		$table_name = VOID_MAIL_DB_TABLE;
		global $wpdb;			
		$query_email = "SELECT * FROM $table_name";				
		$this->results = $wpdb->get_results( $query_email );
				
	}
	public function list_view()
	{ 
		// call db query method
		$this->db_query(); ?>
		<table id="wpvms_list" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
	                <thead>
	                  <tr>
	                    <th>ID</th>                    
	                    <th class="wpvms_email_list">Email</th>
	                    <th>Verified</th> 
	                    <th>Edit</th>                   
	                  </tr>
	                </thead>
	               
	                <tbody>
	                    <?php foreach ( $this->results as $result ) : ?>
	                      <tr>                      	
		                        <td class="void-mail-id"><?php echo $result->id; ?></td>
		                        <td class="wpvms_email"><?php echo $result->emails; ?></td>
		                        <td>
		                        	<?php 
				                        if( $result->verified == 1) {
				                        	echo 'Yes';
				                        }else{
				                        	echo 'No';
				                        }
		                        	?>		                        	
		                        </td>
		                        
		                        <td>                      
		                        <a class="btn btn-xs btn-danger void-mail-delete"><span class="glyphicon glyphicon-trash"></span>Delete</a>  
		                        </td>
	                      </tr>
	                    <?php endforeach; ?>
	                  
	                </tbody>
	              </table>
		<!-- Datatables -->
   

	<?php }
}
?>