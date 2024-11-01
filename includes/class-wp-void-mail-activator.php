<?php 

/***
Fired during plugin activation

***/

Class WP_Void_Mail_Activator
{
	/**
     * Creating Databse
     *
     * Create Database table when the plugin is activated and also add plugin DB version to option so that we can upgrade the DB later easily .
     *
     * @since    1.0
     */
    public static function activate() 
    {
        // wordpres global variable to interact wit DB
        global $wpdb;       
        $void_mail_db = $wpdb;       
        $table_name = VOID_MAIL_DB_TABLE;
        $charset_collate = $void_mail_db->get_charset_collate();

        $query = "CREATE TABLE $table_name (
                  id int NOT NULL AUTO_INCREMENT,
                  emails TEXT,
                  verified boolean DEFAULT 0 NOT NULL,
                  PRIMARY KEY  (id)
                ) $charset_collate;";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        //create table
        dbDelta( $query );

        //add option to option db
        add_option( 'void_mail_db_version', VOID_MAIL_DB_VERSION );
        //add quickmail_verifier API status
        add_option( 'wpvms_quick_mail_verifier_status', 0 );
        $get_installation_time = strtotime("now");
        add_option('wpvms_activation_time', $get_installation_time );
    }
}

