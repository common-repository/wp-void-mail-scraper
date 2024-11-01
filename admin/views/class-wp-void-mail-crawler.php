<?php
/* crawler view 
*/
class Wp_Void_Mail_Crawler
{
	public function crawler_view()
	{ ?>
		<div class="wpvms-table">
			<div class="wpvms-table-cell wpvms_crawler">
				<h1><?php echo esc_html__('Enter the website URL you want to crawl', VOID_MAIL_TEXT_DOMAIN ); ?></h1>	
				<form>
					<input type="text" class="wp_void_mail_website" placeholder="http://example.com">
					<input type="submit" value="<?php echo esc_html__('Crawl', VOID_MAIL_TEXT_DOMAIN); ?>" class="button button-primary wp_void_crawl">
				</form>
				<ol class="void_mail_found"></ol>				
			</div>
		</div>
	<?php }
}
?>