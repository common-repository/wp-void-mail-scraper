<?php
/* parses pdf */
class Wp_Void_Mail_Pdfparser
{
	public function parsepdf()
	{
		//initate the parser
		$parser = new PDF2Text();
		//pass the pdf 
		$parser->setFilename( $_FILES["file"]["tmp_name"] );
	    $parser->decodePDF();
	    $text= $parser->output();
		
		$extract = new Wp_Void_Mail_Extractor( $text, 'PDF' );	
		//return immediately to script so that response is not garbaged
		wp_die();
		
	}
}