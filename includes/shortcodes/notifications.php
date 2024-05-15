<?php
function jobcirlce_notifications_list($atts, $content)
{
    ob_start();

    $notifications_output = '';

    $job_ids = array();

    global $wpdb;
    $notifications_tablename = $wpdb->prefix.'jobcircle_notifications';

    $user_id = get_current_user_id();
    $employer_id = jobcircle_user_employer_id($user_id);
    $candidate_id = jobcircle_user_candidate_id($user_id);

    $user_ids = array();
    if(($employer_id) && ($employer_id > 0)){
        $user_ids[] = $employer_id;
    }
    if(($candidate_id) && ($candidate_id > 0)){
        $user_ids[] = $candidate_id;
    }

    $implode_user_ids = implode(",",$user_ids);

    $get_user_jobs = $wpdb->get_results("SELECT Distinct job_id FROM {$notifications_tablename} WHERE `user_id` IN ($implode_user_ids) ORDER  BY `created_at` ASC", ARRAY_A);

    if($get_user_jobs){
        foreach($get_user_jobs as $user_job){
            $job_ids[] = $user_job['job_id'];
        }
        $implode_job_ids = implode(",",$job_ids);       
    
        $notifications = $wpdb->get_results("SELECT * FROM {$notifications_tablename} WHERE `job_id` IN ($implode_job_ids) ORDER  BY `created_at` DESC Limit 20", ARRAY_A);
    }
    

    // $notifications = $wpdb->get_results("SELECT * FROM {$notifications_tablename} WHERE `user_id` = $employer_id ORDER  BY `created_at` DESC Limit 20", ARRAY_A);

    if(!empty($notifications)){
        $notifications_output .= '<ul>';

        if(($employer_id) && ($employer_id > 0)){
            $notifications_output .= jobcirlce_employer_notifications_list($notifications);

        }elseif(($candidate_id) && ($candidate_id > 0)){
            $notifications_output .= jobcirlce_candidate_notifications_list($notifications);
        }            

        $notifications_output .= '</ul>';
    }

    echo jobcircle_esc_the_html($notifications_output);

    return ob_get_clean();
}

function jobcirlce_employer_notifications_list($notifications_list){

    $notifications = '';

    foreach($notifications_list as $notification){
        $notifications .= '<li>';

        $notifications .= '';

        $notification_type = $notification['notification_type'];

        $job_id = $notification['job_id'];
        $job = get_post($job_id);
        $user_id = $notification['user_id'];

        $employer_id = jobcircle_employer_user_id($user_id);
        $candidate_id = jobcircle_candidate_user_id($user_id);

        if(($employer_id) && ($employer_id > 0)){
            $user_info = get_userdata($employer_id);

        }elseif(($candidate_id) && ($candidate_id > 0)){
            $user_info = get_userdata($candidate_id);
        }

        if($notification_type == "New Job"){
            if($job){
                $notifications .= '<div class="ico-holder" style="background-color: #eaf6ed;">
                                    <img src="'.JOBCIRCLE_Notifications_URL.'/assets/images/developer.png" alt="">
                                   </div>
                                   <div class="text">'.html_entity_decode($notification['notification']).'</div>';
            }                    

        }elseif($notification_type == "Update Job"){
            if($job){
                $notifications .= '<div class="ico-holder" style="background-color: #eaf6ed;">
                                    <img src="'.JOBCIRCLE_Notifications_URL.'/assets/images/developer.png" alt="">
                                   </div>
                                   <div class="text">'.html_entity_decode($notification['notification']).'</div>';
            }                    

        }elseif($notification_type == "Delete Job"){
            $notifications .= '<div class="ico-holder" style="background-color: #eaf6ed;">
                                    <img src="'.JOBCIRCLE_Notifications_URL.'/assets/images/developer.png" alt="">
                                   </div>
                                   <div class="text">'.html_entity_decode($notification['notification']).'.</div>';

        }elseif($notification_type == "Apply Job"){
            $notifications .= '<div class="ico-holder" style="background-color: #eaf6ed;">
                                    <img src="'.JOBCIRCLE_Notifications_URL.'/assets/images/developer.png" alt="">
                                   </div>
                                   <div class="text">'.html_entity_decode($notification['notification']).'</div>';

        }elseif($notification_type == "Leave Review"){
            $notifications .= '<div class="ico-holder" style="background-color: #eaf6ed;">
                                <img src="'.JOBCIRCLE_Notifications_URL.'/assets/images/star-green.png" alt="">
                               </div>
                                <div class="text">'.html_entity_decode($notification['notification']).'</div>';
        }else{
            $notifications .= '<div class="ico-holder" style="background-color: #eaf6ed;">
                                <img src="'.JOBCIRCLE_Notifications_URL.'/assets/images/developer.png" alt="">
                               </div>
                               <div class="text">'.html_entity_decode($notification['notification']).'</div>';
        }

        $notifications .= '</li>';
    }

    return $notifications;
}

function jobcirlce_candidate_notifications_list($notifications_list){

    $notifications = '';

    foreach($notifications_list as $notification){
        $notifications .= '<li>';

        $notifications .= '';

        $notification_type = $notification['notification_type'];

        $job_id = $notification['job_id'];
        $job = get_post($job_id);
        $user_id = $notification['user_id'];
        $user_info = get_userdata($user_id);

        if($notification_type == "Update Job"){
            if($job){
                $notifications .= '<div class="ico-holder" style="background-color: #eaf6ed;">
                                    <img src="'.JOBCIRCLE_Notifications_URL.'/assets/images/plan-blue.png" alt="">
                                   </div>
                                   <div class="text"><span style="color: #41ae5e;"><u>'.$job->post_title.'</u></span>.</div>';
            }

        }elseif($notification_type == "Delete Job"){
            $notifications .= '<div class="ico-holder" style="background-color: #eaf6ed;">
                                <img src="'.JOBCIRCLE_Notifications_URL.'/assets/images/plan-red.png" alt="">
                               </div>
                                    <div class="text">'.$notification['notification'].'.</div>';

        }elseif($notification_type == "Apply Job"){
            $notifications .= '<div class="ico-holder" style="background-color: #eaf6ed;">
                                <img src="'.JOBCIRCLE_Notifications_URL.'/assets/images/developer.png" alt="">
                               </div>
                               <div class="text">'. esc_html_e('Your job for', 'jobcircle-frame') .' <span style="color: #41ae5e;"><u>'.$job->post_title.'</u></span> '. esc_html_e('has been applied successfully!.', 'jobcircle-frame') .'</div>';

        }elseif($notification_type == "Leave Review"){
            $notifications .= '<div class="ico-holder" style="background-color: #eaf6ed;">
                                <img src="'.JOBCIRCLE_Notifications_URL.'/assets/images/star-green.png" alt="">
                               </div>
                                <div class="text">'.$user_info->display_name.' '. esc_html_e('left a', 'jobcircle-frame') .' <span style="color: #41ae5e;"><u>'.$notification['notification'].'</u></span> '. esc_html_e('review for', 'jobcircle-frame') .' '.$job->post_title.'.</div>';
        }else{
            $notifications .= '<div class="ico-holder" style="background-color: #eaf6ed;">
                                <img src="'.JOBCIRCLE_Notifications_URL.'/assets/images/developer.png" alt="">
                               </div>
                               <div class="text">'.$notification['notification'].'</div>';
        }

        $notifications .= '</li>';
    }

    return $notifications;
}


add_shortcode('job_cirlce_notifications', 'jobcirlce_notifications_list');