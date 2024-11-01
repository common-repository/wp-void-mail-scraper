<?php 

class Wp_Void_Mail_Api_View
{
	public function view()
	{ 
		global $allowedposttags;
		$status = get_option( 'wpvms_quick_mail_verifier_status' );
		$key = get_option( 'wpvms_quickmail_verifier_key' );
		if( $key ){
			$key = '*******' . substr( $key, -4 );
		}else{
			$key = 'Insert your API key here';
		}
		$quickmail_url = 'https://quickemailverification.com/apisettings';
	?>
		<div class="void_mail_input_text">
			<form method="POST" >
				<h2> <?php echo esc_html__( 'Quick email verification API', VOID_MAIL_TEXT_DOMAIN ); ?> </h2>
				<div class="wpvms_status">
					<?php if( $status == 1) : ?>
						<div class="wpvms_status_success"><span class="wpvms_sign_success">&#10004;</span><?php echo esc_html__( 'Connected', VOID_MAIL_TEXT_DOMAIN ); ?></div>
					<?php else : ?>
						<div class="wpvms_status_error"><span class="wpvms_sign_error">&#10005;</span> <?php echo esc_html__( 'Not Connected', VOID_MAIL_TEXT_DOMAIN ); ?></div>
					<?php endif; ?>
				</div><!-- wpvms_status -->
				<div>
					<input type="text" name="wpvms_quickmail_verifier_key" placeholder="<?php echo esc_html( $key );?>"  class="void_mail_api_key">			
					<input type="submit" value="<?php echo esc_html__( 'Submit', VOID_MAIL_TEXT_DOMAIN ); ?>" class="button button-primary void_mail_api_btn">
				</div>
			</form>
			<div class="wpvms_api"> <?php echo wp_kses( sprintf( __( 'You can get your API key form <a href="%s">here</a>', VOID_MAIL_TEXT_DOMAIN ), $quickmail_url ), $allowedposttags ); ?> </div>
			<div class="wpvms_verifier">
				<form method="POST" >
					<h2><?php echo esc_html__( 'Verify Your Unverified mail', VOID_MAIL_TEXT_DOMAIN ); ?> </h2>
					<input type="submit" value="<?php echo esc_html__( 'Verify', VOID_MAIL_TEXT_DOMAIN ); ?>" name="all" class="button button-primary void_mail_verifier">
				</form>
				<ol class="wpvms_verifier_output"></ol>
			</div><!-- wpvms_verifier -->
		</div>	
	<?php }
}
?>
