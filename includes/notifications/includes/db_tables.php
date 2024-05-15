<?php
class JobCircle_Notifications_Table
{
    public $version;
    public $last_version;

    public function __construct() {
        $this->version = JOBCIRCLE_Notifications_VERSION;
        $this->last_version = get_option('jobcircle_notifications_version');
        
        if(!($this->last_version) || (version_compare( $this->last_version, $this->version, '<' ))) {
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            $this->clean_install(); 
            update_option( 'jobcircle_notifications_version', $this->version );           
        }
    }

    private function clean_install() {
        global $wpdb;
        $sql = "
        CREATE TABLE {$wpdb->prefix}jobcircle_notifications (
            id INT unsigned NOT NULL AUTO_INCREMENT,
            user_id INT unsigned NOT NULL,
            job_id INT unsigned NOT NULL,
            notification_type VARCHAR(255) NULL,
            notification TEXT NOT NULL,
            notification_status VARCHAR(255) NULL,
            created_at datetime NOT NULL DEFAULT current_timestamp(),
            PRIMARY KEY (id),
            INDEX user_id_idx (user_id),
            INDEX job_id_idx (job_id)
        ) DEFAULT CHARSET=utf8";

        dbDelta( $sql );
    }
}

new JobCircle_Notifications_Table();