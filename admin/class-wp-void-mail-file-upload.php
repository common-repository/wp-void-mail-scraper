<?php
/* class that handles file uploading */

class Wp_Void_Mail_File_Upload
{
	public function file_upload()
	{
		// get temp dir path
		$temp_location =  $_FILES['file']['tmp_name'];
		//get uploaded file name 
		$file_name = $_FILES['file']['name'];
		// fetch the content of file
		$content = file_get_contents(  $temp_location );
		// extract mails
		$text = new Wp_Void_Mail_Extractor( $content, $file_name );
		//exit 
		wp_die();
	}
}