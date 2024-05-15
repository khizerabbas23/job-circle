<?php

defined('ABSPATH') || exit;

class JOBCIRCLE_Plugin_Activator {

    public function __construct() {
        
    }

    public static function activate() {
        $jobalertsCronEvent = wp_next_scheduled('jobcircle_job_alerts_schedule');
        if (!$jobalertsCronEvent) {
            wp_schedule_event(time(), 'daily', 'jobcircle_job_alerts_schedule');
        }
    }
}