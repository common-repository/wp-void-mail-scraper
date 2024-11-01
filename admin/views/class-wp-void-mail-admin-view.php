<?php 
/* Class for admin view of WP Void mail scraper */

class Wp_Void_Mail_Admin_View
{
	protected $info;

	public function __construct()
	{
		$this->info = new Wp_Void_Mail_Info();
		
	}
	public function view()
	{ 
		$flag = true;
		$newsletters = [];		
		if( $this->info->mailpoet2_status() ){
			array_push( $newsletters, 'mailpoet 2');
			$flag = false;
		}
		if( $this->info->mailpoet3_status() ){
			array_push( $newsletters, 'mailpoet 3' );
			$flag = false; 
		}
		if( $flag ){
			array_push( $newsletters, 'Not installed or activated ' );		   		
		}	    
		?>
		<div class="container wpvms_stats">
			<h3><?php echo esc_html__( 'Stats', VOID_MAIL_TEXT_DOMAIN ); ?></h3>
			<div class="row justify-content-center">
				<div class="col alert alert-info">					
					<div class="wpvms_verifiers">
						<h5><?php echo esc_html__( 'Verifier stats', VOID_MAIL_TEXT_DOMAIN ); ?></h5>
	  					<?php 
	  						if( get_option( 'wpvms_quick_mail_verifier_status' ) ){
	  							echo 'Connected to : quickmail verifier';
	  						}else{
	  							echo 'Not connected to: quickmail verifier';
	  						}
	  					?>
					</div>
				</div>
				<div class="col alert alert-info">					
					<div class="wpvms_newsletters">
						<h5><?php echo esc_html__( 'Newsletters stats', VOID_MAIL_TEXT_DOMAIN ); ?></h5>
	  					<?php 
	  						foreach( $newsletters as $newsletter ){
	  							echo '<p>Active: ' . $newsletter . '</p>';
	  						}	  						
	  					?>
					</div>
				</div>
			</div>
			<div class="row justify-content-center">				
				<div class="col alert alert-info">
					<div class="alert">
						<h5><?php echo esc_html__( 'Email stats', VOID_MAIL_TEXT_DOMAIN ); ?></h5>
						<p>emails in DB: <?php echo $this->info->count_emails(); ?></p>
						<p> Verfied emails: <?php echo $this->info->count_verified_email(); ?></p>
						<p> Unverified emails: <?php echo $this->info->count_emails() - $this->info->count_verified_email() ; ?></p>
					</div>
				</div>
			</div>
		</div>
	
	<?php 
	
	}
} 
?>