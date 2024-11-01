<?php 
/* main scraper class */
class Wp_Void_Mail_Main_Scraper
{
	protected $links =array();
	protected $current_link = 0;	
	protected $res = array();
	protected $base_url ;
	protected $host;
	public function website_crawl()
	{
		if( !empty($_POST[ 'url' ] ) ){
			$url = $_POST[ 'url' ];
		}
		if( !empty( $_POST['abort']) && $_POST['abort'] == 1){
			wp_die();
		}		
		if( filter_var( $url, FILTER_VALIDATE_URL ) ){
			//echo $url;
			if( $_POST['flag'] == 0 ){
				$parse_data = wp_parse_url( $url );
				$scheme = $parse_data[ 'scheme' ];
				$this->host = $parse_data[ 'host' ];
				$this->base_url = $scheme . '://' . $this->host . '/';
				array_push( $this->links, $url );
			}
			 
			$response = wp_remote_get( $url, array( 'sslverify' => false ) ); 
			$content = wp_remote_retrieve_body( $response );			
			$extractor = new Wp_Void_Mail_Extractor( $content, $url, false );			
			$dom = new DOMDocument();
			@$dom->loadHTML( $content );
			$xpath = new DOMXpath( $dom );
			$hrefs = $xpath->evaluate("//a");			
			for( $count = 0; $count < $hrefs->length; $count++ ){
				$href = $hrefs->item( $count );
				$temp = $href->getAttribute( 'href' );
				$temp = trim( $temp );
				$pattern = '/' . $temp . '/';
				if( empty( $temp ) ){					
					continue;
				}			
				
				else if( strpos( $temp, '#' ) !== FALSE ){
					continue;
				}				
				else if( strpos( $temp, '//' ) ){
					$url = rtrim( $temp, '/' );
					$url = filter_var( $url, FILTER_VALIDATE_URL );					
					array_push( $this->links, $url );		
				}				
				else{					
					$temp = ltrim( $temp, '/' );
					$url = $this->base_url . $temp;
					$url = filter_var( $url, FILTER_VALIDATE_URL );
					array_push( $this->links, $url );					
				}
				$current_url_parse = wp_parse_url( $url );				
				$current_url_host = $current_url_parse[ 'host' ];
				$pattern = '/' . $this->host . '/';						
				if( strpos( $current_url_host, $this->host ) === FALSE ){					
					array_pop( $this->links );					
				}								
			}
			$this->res = array_values( array_unique( $this->links ) );			
			if( $_POST['flag'] == 0 ){
				$_POST['flag'] = 1;
				$this->loop();
			}
		}else{
			echo '<div class="wpvms_error">URL not Valid , Please check if you added htttp or https </div>';			
			wp_die();
		}
		
	}
	public function loop()
	{
			$length = count( $this->res );
			for( $count = 0 ; $count < $length ; $count++ ){
				$_POST[ 'url' ] = $this->res[ $count ];
				if( $_POST[ 'url' ] . '/' == $this->base_url ){					
					continue;
				}
				$this->website_crawl();
				$length = count( $this->res );
			}			
			echo '<div class="wpvms_done">Successfully Scrapped</div>';
			wp_die();
		
	}	
}