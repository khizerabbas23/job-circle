<?php

class JobCircle_Notifications_init
{
    private $notification_tablename;

    function __construct() {
        global $wpdb;
        $this->notification_tablename = $wpdb->prefix.'jobcircle_notifications';
        add_action( 'init', [ $this, 'init' ] );
    }

    function init() {
        include( JOBCIRCLE_Notifications_DIR.'/includes/db_tables.php');
        add_action('save_post', array($this, 'jobcircle_save_notification'),10,3);
        add_action('after_delete_post', array($this, 'jobcircle_save_delete_job_notification'), 10, 2);       

        do_action( 'JobCircle_Notifications_init' );
    }
    
    function jobcircle_save_notification($post_id,$post,$update){

        if (!$post) {
            return;
        }

        if($post->post_type !== "jobs" && $post->post_type !== "job_applic"){
            return;
        }

        if($post->post_type === "jobs"){
            $this->save_employer_notification($post_id,$post,$update);

        }elseif($post->post_type === "job_applic"){
            if(isset($_REQUEST['apply_job_id']) && ($_REQUEST['apply_job_id'] > 0)){
                $post_id = $_REQUEST['apply_job_id'];
            }
            $this->save_candidate_notification($post_id,$post,$update);
        }        
    }

    function save_employer_notification($post_id,$post,$update){
        $post = get_post($post_id);

        global $wpdb;
        global $current_user;
        $user_id = $current_user->ID;
        $employer_id = jobcircle_user_employer_id($user_id);
        $job_id = $post->ID;
        $job_title = $post->post_title;

        if($update){
            $notification_type = esc_html__('Update Job', 'jobcircle-frame');
            $notification =  esc_html__('Your job updated for <span style="color: #41ae5e;"><u>'.$job_title.'</u></span>.', 'jobcircle-frame');
        }else{
            $notification_type = esc_html__('New Job', 'jobcircle-frame');
           
        }

        $wpdb->insert($this->notification_tablename, array(
                      'user_id' => $employer_id,
                      'job_id' => $job_id,
                      'notification_type' => $notification_type, 
                      'notification' => $notification,
                      'notification_status' => 'New'
                    ));
    }

    function save_candidate_notification($post_id,$post,$update){
        $post = get_post($post_id);

        global $wpdb;
        global $current_user;
        $user_id = $current_user->ID;
        $candidate_id = jobcircle_user_candidate_id($user_id);
        $user_info = get_userdata($candidate_id);
        $job_id = $post->ID;
        $job_title = $post->post_title;        
        
        $notification_type = esc_html__('Apply Job', 'jobcircle-frame');
        $notification =  esc_html__(''.$user_info->display_name.' applied your job for <span style="color: #41ae5e;"><u>'.$job_title.'</u></span> .', 'jobcircle-frame');

        $wpdb->insert($this->notification_tablename, array(
                      'user_id' => $candidate_id,
                      'job_id' => $job_id,
                      'notification_type' => $notification_type, 
                      'notification' => $notification,
                      'notification_status' => 'New'
                    ));
    }

    function jobcircle_save_delete_job_notification($post_id,$post){

        if($post->post_type !== "jobs"){
            return;
        }

        global $wpdb;
        global $current_user;
        $user_id = $current_user->ID;
        $employer_id = jobcircle_user_employer_id($user_id);
        $job_id = $post->ID;
        $job_title = $post->post_title;

        $wpdb->insert($this->notification_tablename, array(
                      'user_id' => $employer_id,
                      'job_id' => $job_id,
                      'notification_type' => esc_html__('Delete Job', 'jobcircle-frame'), 
                      'notification' => __("Your job for <span class='post-title'>".$job_title."</span> has been Deleted", 'jobcircle-frame'),
                      'notification_status' => 'New'
                    ));

    }
    
}

new JobCircle_Notifications_init();