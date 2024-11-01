<?php
/* Everything related to mailpoet */

class Wp_Void_Mail_Mailpoet
{

	protected $db_handle;

	protected $table_name;

	protected $mailpoet_status;
	
	public function __construct()
	{
		global $wpdb;	
		$this->db_handle = $wpdb;
		$this->table_name = VOID_MAIL_DB_TABLE;
		$this->mailpoet_status = new Wp_Void_Mail_Info();

	}
	public function mailpoet_view()
	{ 
		$flag = true;
        //making sure if DB has verified emails
        $query = "SELECT COUNT(*) FROM $this->table_name WHERE verified = '1'";
        $email_count = $this->db_handle->get_var($query);
        if( $email_count == 0 ){ ?>
            <h2>You do not have any verified email to insert into mailpoet list.</h2>
        <?php 
           wp_die();
        }
		?>
		<div class="wpvms-mailpoet">
			<h3> <?php echo esc_html__( 'Insert emails to your selected mailpoet list', VOID_MAIL_TEXT_DOMAIN ); ?></h3>
		</div>
		<?php //check if mailpoet 2 is active		
			if( $this->mailpoet_status->mailpoet2_status() ){ 
				$flag = false;
				?>
				<div class="wpvms-mailpoet">
					<h6>
						<?php 
							echo esc_html__( 'You are using mailpoet 2', VOID_MAIL_TEXT_DOMAIN );
						?>					
					</h6>
				</div>
				
				<?php 
					$query = "SELECT list_id, name FROM " . $this->db_handle->prefix. "wysija_list";
					$wysija_lists = $this->db_handle->get_results( $query ); 
				?>
				<label for="lists[]">Select list</label>
				<select class="wpvms_mailpoet_list" name="lists[]" multiple="multiple">
					<?php foreach ( $wysija_lists as $list ) : ?>
						<option value="<?php echo $list->list_id; ?>"><?php echo esc_html__( $list->name, VOID_MAIL_TEXT_DOMAIN ); ?></option>
					<?php endforeach; ?>
				</select>
				<input type="submit" class="btn btn-primary mailpoet_list_insert" value="<?php echo esc_html__( 'Insert', VOID_MAIL_TEXT_DOMAIN ); ?>">
				<ol class="wpvms_mailpoet_output"></ol>
		<?php }
	
		if( $this->mailpoet_status->mailpoet3_status() ){ 
			$flag = false;
			?>
			<div class="wpvms-mailpoet">
				<h6 class="label label-info">
					<?php 
						echo esc_html__( 'You are using mailpoet 3', VOID_MAIL_TEXT_DOMAIN );
					?>					
				</h6>
			</div>
			
			<?php
				$mailpoet_lists = \MailPoet\API\API::MP('v1')->getLists();
			?>
			<label for="lists[]">Select list</label>
			<select class="wpvms_mailpoet_list" name="lists[]" multiple="multiple">
			<?php foreach ( $mailpoet_lists as $index => $list ) : ?>
					<option value="<?php echo $list['id']; ?>"><?php echo esc_html__( $list[ 'name' ], VOID_MAIL_TEXT_DOMAIN ); ?></option>
				<?php endforeach; ?>
			</select>			
			<button class="btn btn-primary mailpoet_list_insert"><?php echo esc_html__( 'Insert', VOID_MAIL_TEXT_DOMAIN ); ?></button>
			<ol class="wpvms_mailpoet_output"></ol>
		<?php }
		
		if( $flag ){
			echo esc_html__( 'mailpoet plugin is not installed or activated', VOID_MAIL_TEXT_DOMAIN );
		}
	}
}
?>