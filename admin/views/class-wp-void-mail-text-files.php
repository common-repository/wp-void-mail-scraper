<?php 
/* Class for admin view of Text/ Files Page */

class Wp_Void_Mail_Text_Files
{
	public function view()
	{ ?>
		<div class="void-overlay">
			<div class="void-loader">
				<img src="<?php echo esc_attr( VOID_MAIL_ASSETS . 'img/ajax-loader.gif' ); ?>" alt="loader">
			</div><!-- void-loader -->
		</div><!-- .void-overlay -->
		<div id="void_mail" class="void_mail_input_text">
			<h3><?php echo esc_html__( 'Copy/Paste or type anything to scrap mail from', VOID_MAIL_TEXT_DOMAIN ); ?></h3>
			<form  method="POST" >
				<textarea name="void_input" id="inserted_text" placeholder="<?php echo esc_attr__( 'Fill me up', VOID_MAIL_TEXT_DOMAIN ); ?>"></textarea>
				<input type="submit" value="<?php echo esc_attr__( 'Boom!', VOID_MAIL_TEXT_DOMAIN ); ?>" id="text_submit" class="button button-primary void_mail_btn">			
			</form>
			<p class="void_mail_number"></p>
			<div class="wpvms-file-section">
				<h3><?php echo esc_html__( 'Select Single/Multiple Files you want scrap from', VOID_MAIL_TEXT_DOMAIN); ?></h3>
				<h6>Supported file types: .txt,.rtf,.pdf,.html,.csv</h6>
				<form method="POST" enctype="multipart/form-data">
					<input type="file" name="void_mail_file" class="void_mail_upload" accept="" multiple="multiple">
					<input type="submit" value="<?php echo esc_attr__( 'Boom!', VOID_MAIL_TEXT_DOMAIN ); ?>"  class="button button-primary void_mail_upload_btn">		
				</form>
				<ol class="wpvms_file_output"></ol>
			</div>
		</div>
	<?php }
} 
?>