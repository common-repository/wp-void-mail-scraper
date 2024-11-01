<?php 
/* This class process form submission of submitted text
*/

class Wp_Void_Mail_Form_Process
{

	public function inserted_text()
	{
		//check if actually there were any inputed text or not 
		if( isset( $_POST['text'] ) && !empty( $_POST['text'] ) ){
			// pass text to extractor
			$extract = new Wp_Void_Mail_Extractor( $_POST['text'], 'textarea' );	
			//return immediately to script so that response is not garbaged
			wp_die();
		}
	}

}