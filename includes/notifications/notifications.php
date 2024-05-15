<?php
class JobCircle_Notifications
{
    private static $instance;

    function __construct() {
        // setup variables
        define( 'JOBCIRCLE_Notifications_VERSION', '1.2' );
        define( 'JOBCIRCLE_Notifications_DIR', dirname( __FILE__ ) );
        define( 'JOBCIRCLE_Notifications_URL', plugins_url( '', __FILE__ ) );

        include(JOBCIRCLE_Notifications_DIR .'/includes/init.php' );
    }
    /**
     * Singleton
     */
    public static function instance() {
        if (!isset( self::$instance ) ) {
            self::$instance = new self;
        }
        return self::$instance;
    }
}

function JOBCIRCLE_Custom_Notifications() {
    return JobCircle_Notifications::instance();
}

$jc_notifications = JOBCIRCLE_Custom_Notifications();