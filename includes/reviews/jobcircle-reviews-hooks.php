<?php 
class JobCircle_Reviews_Hooks{
    public $jobcircle_comments_per_page;
    public function __construct() {
       
        $this->jobcircle_comments_per_page = get_option('posts_per_page');
        add_action('wp_ajax_jobcircle_load_more_comments', array($this, 'jobcircle_load_more_comments'), 10);
        add_action('wp_ajax_nopriv_jobcircle_load_more_comments', array($this, 'jobcircle_load_more_comments'), 10);
        add_action('wp_ajax_jobcircle_user_submit_review', array($this, 'jobcircle_submit_review'), 10);
        add_action('wp_ajax_nopriv_jobcircle_user_submit_review', array($this, 'jobcircle_submit_review'), 10);
        add_action('wp_ajax_jobcircle_user_update_review', array($this, 'jobcircle_user_update_review'), 10);
        add_action('wp_ajax_nopriv_jobcircle_user_update_review', array($this, 'jobcircle_user_update_review'), 10);
        add_action('wp_ajax_jobcircle_user_submit_review_reply', array($this, 'jobcircle_user_submit_review_reply'), 10);
        add_action('wp_ajax_nopriv_jobcircle_user_submit_review_reply', array($this, 'jobcircle_user_submit_review_reply'), 10);
        add_action('jobcircle_user_reviews', array($this, 'jobcircle_user_reviews'), 10, 2);
        add_action('jobcircle_reviews_listing', array($this, 'jobcircle_reviews_listing'), 10, 2);
        add_action('jobcircle_reviews_list_item', array($this, 'jobcircle_reviews_list_item'), 10);
        add_action('jobcircle_reivew_reply_item', array($this, 'jobcircle_reply_item'), 10);
        add_action('jobcircle_review_reply_form', array($this, 'jobcircle_review_reply_form'), 10);
        add_action('jobcircle_reviews_form', array($this, 'jobcircle_reviews_form'), 10, 2);
        add_action('jobcircle_update_post_rating', array($this, 'jobcircle_update_post_rating'), 10);
        add_action('transition_comment_status', array($this, 'jobcircle_comment_status_update'), 10, 3);
    }

    public function jobcircle_load_more_comments(){
        if ( ! isset( $_POST['reviews_security'] ) || ! wp_verify_nonce( $_POST['reviews_security'], 'jobcircle-loadcomments-nonce' ) ) {
            $jobcircle_response = array(
                'status'    => 'error',
                'msg'   => esc_html__('Invalid Review Request', 'jobcircle-iframe'),
            );
            wp_send_json( $jobcircle_response );
        }
        $jobcircle_post_id  = !empty($_POST['post_id']) ? intval( $_POST['post_id'] ) : '';
        $jobcircle_page_number  = !empty($_POST['page_number']) ? intval( $_POST['page_number'] ) : '';
        $jobcircle_total_pages  = !empty($_POST['total_pages']) ? intval( $_POST['total_pages'] ) : '';
        $jobcircle_screen_type    = !empty($_POST['screen_type']) ? sanitize_text_field( $_POST['screen_type'] ) : '';

        if(empty($jobcircle_post_id)){
            $jobcircle_response = array(
                'status'    => 'error',
                'msg'    => esc_html__('Something went wrong. Please try again after page refresh.', 'jobcircle-iframe'),
            );
            wp_send_json( $jobcircle_response );
        }
        $jobcircle_post_author_id = get_post_field('post_author', $jobcircle_post_id);
        $jobcircle_post_type    = get_post_type($jobcircle_post_id);
        $jobcircle_offset = ($jobcircle_page_number - 1) * $this->jobcircle_comments_per_page;

        if($jobcircle_screen_type == 'dashboard'){
            $jobcircle_args = array(
                'post_id' => $jobcircle_post_id,
                'status' => array('approve', 'hold'),
                'parent' => 0,
                'number' => $this->jobcircle_comments_per_page,
                'offset' => $jobcircle_offset,
                'orderby' => 'comment_date',
                'order' => 'DESC',
            );
            $jobcircle_parent_comments = get_comments($jobcircle_args);
        } else {            
            $jobcircle_args = array(
                'post_id' => $jobcircle_post_id,
                'status' => 'approve',
                'parent' => 0,
                'number' => $this->jobcircle_comments_per_page,
                'offset' => $jobcircle_offset,
                'orderby' => 'comment_date',
                'order' => 'DESC',
            );
            $jobcircle_parent_comments = get_comments($jobcircle_args);
        }
        $jobcircle_hide_loader = false;

        if($jobcircle_page_number >=  $jobcircle_total_pages){
            $jobcircle_hide_loader = true;
        }
        $jobcircle_args = array(
            'jobcircle_post_id'  => $jobcircle_post_id,
            'jobcircle_post_type'  => $jobcircle_post_type,
            'jobcircle_post_author_id'  => $jobcircle_post_author_id,
        );

        if(empty($jobcircle_parent_comments)){
            $jobcircle_msg  = esc_html__('No more comments.', 'jobcircle-iframe');
            $jobcircle_hide_loader = true;
            $jobcircle_response = array(
                'status'    => 'error',
                'hide_loader'    => $jobcircle_hide_loader,
                'html'    => '',
                'msg'    => $jobcircle_msg,
            );
            wp_send_json( $jobcircle_response );
        }

        $jobcircle_msg  = '';
        ob_start();
        if($jobcircle_parent_comments){
            foreach ($jobcircle_parent_comments as $jobcircle_comment) {
                $jobcircle_args['jobcircle_comment']    = $jobcircle_comment;
                do_action('jobcircle_reviews_list_item', $jobcircle_args);
            }
        } else {
            $jobcircle_hide_loader = true;           
        }      
        $jobcircle_html = ob_get_clean();
        $jobcircle_response = array(
            'status'    => 'success',
            'hide_loader'    => $jobcircle_hide_loader,
            'html'    => $jobcircle_html,
            'msg'    => '',
        );
        wp_send_json( $jobcircle_response );
    }

    public function jobcircle_comment_status_update($jobcircle_new_status, $jobcircle_old_status, $jobcircle_comment) {
        if ($jobcircle_new_status == $jobcircle_old_status){
            return;
        }
        if(!empty($jobcircle_comment->comment_post_ID)){
            do_action('jobcircle_update_post_rating', $jobcircle_comment->comment_post_ID);
        }
    }

    public function jobcircle_update_post_rating($jobcircle_post_id){
        $jobcircle_args = array(
            'post_id' => $jobcircle_post_id,
            'status' => array('approve', 'hold'),
            'parent' => 0,
        );
        $jobcircle_parent_comments = get_comments($jobcircle_args);
        if($jobcircle_parent_comments){
            $jobcircle_reviews_rating_total = 0;
            $jobcircle_reviews_rating_count = 0;
            foreach ($jobcircle_parent_comments as $jobcircle_comment) {
                $jobcircle_comment_id   = $jobcircle_comment->comment_ID;
                $jobcirlce_reviews_avg_rating   = get_comment_meta($jobcircle_comment_id, 'jobcirlce_reviews_avg_rating', true); 
                $jobcircle_reviews_rating_total +=$jobcirlce_reviews_avg_rating;
                $jobcircle_reviews_rating_count++;
            }

            $jobcirlce_profile_avg_rating   = $jobcircle_reviews_rating_total/$jobcircle_reviews_rating_count;

            update_post_meta($jobcircle_post_id, 'jobcirlce_profile_avg_rating', $jobcirlce_profile_avg_rating);
            update_post_meta($jobcircle_post_id, 'jobcirlce_profile_rating_count', $jobcircle_reviews_rating_count);            
        }
    }

    public function jobcircle_user_submit_review_reply(){
        global $jobcircle_framework_options;
        if ( ! isset( $_POST['comment_nonce'] ) || ! wp_verify_nonce( $_POST['comment_nonce'], 'jobcircle_submit_reply_comment_nonce' ) ) {
            $jobcircle_response = array(
                'status'    => 'error',
                'msg'   => esc_html__('Invalid Review Submit Request', 'jobcircle-iframe'),
            );
            wp_send_json( $jobcircle_response );
        }
        $jobcircle_review_text_length = isset($jobcircle_framework_options['jobcircle_review_text_length']) ? $jobcircle_framework_options['jobcircle_review_text_length'] : '';
        
        $jobcircle_user_id  = get_current_user_id();

        if(empty($jobcircle_user_id)){
            $jobcircle_response = array(
                'status'    => 'error',
                'msg'    => esc_html__('You must be logged in to submit review.', 'jobcircle-iframe'),
            );
            wp_send_json( $jobcircle_response );
        }
        $jobcircle_post_id  = !empty($_POST['jobcircle_post_id']) ? intval( $_POST['jobcircle_post_id'] ) : '';
        $jobcircle_comment_id  = !empty($_POST['jobcircle_comment_id']) ? intval( $_POST['jobcircle_comment_id'] ) : '';
        $jobcircle_reply_comment_id  = !empty($_POST['jobcircle_reply_comment_id']) ? intval( $_POST['jobcircle_reply_comment_id'] ) : '';
        $jobcircle_post_type    = !empty($_POST['jobcircle_post_type']) ? sanitize_text_field( $_POST['jobcircle_post_type'] ) : '';
        $jobcircle_review   = !empty($_POST['reply_content']) ? wp_filter_post_kses( $_POST['reply_content'] ) : '';

        if(empty($jobcircle_post_id) || empty($jobcircle_post_type) || empty($jobcircle_comment_id)){
            $jobcircle_response = array(
                'status'    => 'error',
                'msg'    => esc_html__('Something went wrong. Please try again after page refresh.', 'jobcircle-iframe'),
            );
            wp_send_json( $jobcircle_response );
        }
        $jobcircle_post_author_id = get_post_field('post_author', $jobcircle_post_id);
        if(empty($jobcircle_post_author_id) || ((int)$jobcircle_post_author_id !== (int)$jobcircle_user_id)){
            $jobcircle_response = array(
                'status'    => 'error',
                'jobcircle_post_author_id'    => $jobcircle_post_author_id,
                'jobcircle_user_id'    => $jobcircle_user_id,
                'msg'    => esc_html__('You are not allowed to reply.', 'jobcircle-iframe'),
            );
            wp_send_json( $jobcircle_response );
        }

        $jobcircle_comment = get_comment($jobcircle_comment_id);
        if (is_wp_error($jobcircle_comment)) {
            $jobcircle_response = array(
                'status'    => 'error',
                'msg'    => esc_html__('This comment not exist anymore.', 'jobcircle-iframe'),
            );
            wp_send_json( $jobcircle_response );
        }
        
        if(empty($jobcircle_review)){
            $jobcircle_response = array(
                'status'    => 'error',
                'msg'    => esc_html__('Please enter review content', 'jobcircle-iframe'),
            );
            wp_send_json( $jobcircle_response );
        }

        if(strlen($jobcircle_review) > $jobcircle_review_text_length){
            $jobcircle_response = array(
                'status'    => 'error',
                'msg'    => wp_sprintf(esc_html__('Please enter review content with max length %d', 'jobcircle-iframe'), $jobcircle_review_text_length),
            );
            wp_send_json( $jobcircle_response );
        }
        $jobcircle_user = get_user_by('id', $jobcircle_user_id);
        if ($jobcircle_user) {
            $jobcircle_name = $jobcircle_user->display_name;
            $jobcircle_email = $jobcircle_user->user_email;
        } else {
            $jobcircle_response = array(
                'status'    => 'error',
                'msg'    => esc_html__('You must be logged in to submit review.', 'jobcircle-iframe'),
            );
            wp_send_json( $jobcircle_response );
        }

        if(!empty($jobcircle_reply_comment_id)){
            $jobcircle_comment_data = array(
                'comment_ID'        => $jobcircle_reply_comment_id,
                'comment_content'   => $jobcircle_review,
                'comment_approved'  => 1,
                'user_id'           => $jobcircle_user_id,
            );
            // Insert the comment into the database
            $jobcircle_result = wp_update_comment($jobcircle_comment_data);    

            if (is_wp_error($jobcircle_result)) {
                $jobcircle_response = array(
                    'status'    => 'error',
                    'msg'    => esc_html__('There is error while reveiw submission.', 'jobcircle-iframe'),
                );
                wp_send_json( $jobcircle_response );
            }
            
        } else {
            $jobcircle_comment_data = array(
                'comment_post_ID'      => $jobcircle_post_id,
                'comment_content'      => $jobcircle_review,
                'comment_author'       => $jobcircle_name,
                'comment_author_email' => $jobcircle_email,
                'comment_author_url'   => '',
                'comment_approved'     => 1,
                'user_id'              => $jobcircle_user_id,
                'comment_parent'       => $jobcircle_comment_id, // Set the parent comment ID here
            );        
            // Insert the comment into the database
            $jobcircle_reply_comment_id = wp_insert_comment($jobcircle_comment_data);
        }

        if (!is_wp_error($jobcircle_reply_comment_id)) {            
            //$jobcircle_comment = get_comment($jobcircle_reply_comment_id);
            $jobcircle_args = array(
                'jobcircle_post_id'  => $jobcircle_post_id,
                'jobcircle_post_type'  => $jobcircle_post_type,
                'jobcircle_post_author_id'  => $jobcircle_post_author_id,
                'jobcircle_user_id'  => $jobcircle_user_id,
                'jobcircle_comment'  => $jobcircle_comment,
            );
            ob_start();            
            do_action('jobcircle_reivew_reply_item', $jobcircle_args);
            $jobcircle_html = ob_get_clean();
            $jobcircle_response = array(
                'status'    => 'success',
                'html'    => $jobcircle_html,
                'jobcircle_reply_comment_id'    => $jobcircle_reply_comment_id,
                'msg'    => esc_html__('Review reply submitted successfully', 'jobcircle-iframe'),
            );
            wp_send_json( $jobcircle_response );
        }
        $jobcircle_response = array(
            'status'    => 'error',
            'msg'    => esc_html__('There is error while reveiw submission.', 'jobcircle-iframe'),
        );
        wp_send_json( $jobcircle_response );
        
    }

    public function jobcircle_user_update_review(){
        global $jobcircle_framework_options;
        if ( ! isset( $_POST['comment_nonce'] ) || ! wp_verify_nonce( $_POST['comment_nonce'], 'jobcircle_update_comment_nonce' ) ) {
            $jobcircle_response = array(
                'status'    => 'error',
                'msg'   => esc_html__('Invalid Review Submit Request', 'jobcircle-iframe'),
            );
            wp_send_json( $jobcircle_response );
        }
        $jobcircle_user_id  = get_current_user_id();

        if(empty($jobcircle_user_id)){
            $jobcircle_response = array(
                'status'    => 'error',
                'msg'    => esc_html__('You must be logged in to submit review.', 'jobcircle-iframe'),
            );
            wp_send_json( $jobcircle_response );
        }
        $jobcircle_review_text_length = isset($jobcircle_framework_options['jobcircle_review_text_length']) ? $jobcircle_framework_options['jobcircle_review_text_length'] : '';
		$jobcricle_guest_reviews_enable = isset($jobcircle_framework_options['jobcricle_guest_reviews_enable']) ? $jobcircle_framework_options['jobcricle_guest_reviews_enable'] : '';
		$jobcricle_reviews_approval = isset($jobcircle_framework_options['jobcricle_reviews_approval']) ? $jobcircle_framework_options['jobcricle_reviews_approval'] : '';
        $jobcircle_rating   = !empty($_POST['rating']) ? intval( $_POST['rating'] ) : '';
        $jobcircle_post_id  = !empty($_POST['jobcircle_post_id']) ? intval( $_POST['jobcircle_post_id'] ) : '';
        $jobcircle_comment_id  = !empty($_POST['jobcircle_comment_id']) ? intval( $_POST['jobcircle_comment_id'] ) : '';
        $jobcircle_post_type    = !empty($_POST['jobcircle_post_type']) ? sanitize_text_field( $_POST['jobcircle_post_type'] ) : '';
        $jobcircle_review   = !empty($_POST['review']) ? wp_filter_post_kses( $_POST['review'] ) : '';
        
        if(empty($jobcircle_post_id) || empty($jobcircle_post_type) || empty($jobcircle_comment_id)){
            $jobcircle_response = array(
                'status'    => 'error',
                'msg'    => esc_html__('Something went wrong. Please try again after page refresh.', 'jobcircle-iframe'),
            );
            wp_send_json( $jobcircle_response );
        }
        $jobcircle_post_author_id   = get_post_field('post_author', $jobcircle_post_id);
        $jobcircle_post_type        = get_post_type($jobcircle_post_id);
        $jobcircle_user_type        = jobcircle_user_account_type($jobcircle_user_id);

        if(empty($jobcircle_user_type) || ($jobcircle_post_type == $jobcircle_user_type) || ((int)$jobcircle_post_author_id == (int)$jobcircle_user_id)) {
            $jobcircle_response = array(
                'status'    => 'error',
                'msg'    => esc_html__('You are not allowed to submit review.', 'jobcircle-iframe'),
            );
            wp_send_json( $jobcircle_response );
        }
        $jobcircle_comment = get_comment($jobcircle_comment_id);
        if (is_wp_error($jobcircle_comment)) {
            $jobcircle_response = array(
                'status'    => 'error',
                'msg'    => esc_html__('This comment not exist anymore.', 'jobcircle-iframe'),
            );
            wp_send_json( $jobcircle_response );
        }
        
        if(empty($jobcircle_review)){
            $jobcircle_response = array(
                'status'    => 'error',
                'msg'    => esc_html__('Please enter review content', 'jobcircle-iframe'),
            );
            wp_send_json( $jobcircle_response );
        }

        if(strlen($jobcircle_review) > $jobcircle_review_text_length){
            $jobcircle_response = array(
                'status'    => 'error',
                'msg'    => wp_sprintf(esc_html__('Please enter review content with max length %d', 'jobcircle-iframe'), $jobcircle_review_text_length),
            );
            wp_send_json( $jobcircle_response );
        }

        if(empty($jobcircle_rating)){
            $jobcircle_response = array(
                'status'    => 'error',
                'msg'    => esc_html__('Please select star rating', 'jobcircle-iframe'),
            );
            wp_send_json( $jobcircle_response );
        }

        $jobcricle_reviews_approved = 0;
        if($jobcricle_reviews_approval == 'auto_apporval'){
            $jobcricle_reviews_approved = 1;
        }
        $jobcircle_comment_data = array(
            'comment_ID'        => $jobcircle_comment_id,
            'comment_content'   => $jobcircle_review,
            'comment_approved'  => $jobcricle_reviews_approved,
            'user_id'           => $jobcircle_user_id,
        );
        // Insert the comment into the database
        $jobcircle_result = wp_update_comment($jobcircle_comment_data);

        if (!is_wp_error($jobcircle_result)) {
            //delete_comment_meta($jobcircle_comment_id, 'jobcirlce_reviews_avg_rating');
            update_comment_meta($jobcircle_comment_id, 'jobcirlce_reviews_avg_rating', $jobcircle_rating); 

            do_action('jobcircle_update_post_rating', $jobcircle_post_id);            
            $jobcircle_comment = get_comment($jobcircle_comment_id);
            $jobcircle_args = array(
                'jobcircle_post_id'  => $jobcircle_post_id,
                'jobcircle_post_type'  => $jobcircle_post_type,
                'jobcircle_post_author_id'  => $jobcircle_post_author_id,
                'jobcircle_user_id'  => $jobcircle_user_id,
                'jobcircle_comment'  => $jobcircle_comment,
            );
            ob_start();            
            do_action('jobcircle_reviews_list_item', $jobcircle_args);
            $jobcircle_html = ob_get_clean();
            $jobcircle_response = array(
                'status'    => 'success',
                'html'    => $jobcircle_html,
                'msg'    => esc_html__('Review updated successfully', 'jobcircle-iframe'),
            );
            wp_send_json( $jobcircle_response );
        }
        $jobcircle_response = array(
            'status'    => 'error',
            'msg'    => esc_html__('There is error while reveiw submission.', 'jobcircle-iframe'),
        );
        wp_send_json( $jobcircle_response );
    }

    public function jobcircle_submit_review(){
        global $jobcircle_framework_options;
        if ( ! isset( $_POST['comment_nonce'] ) || ! wp_verify_nonce( $_POST['comment_nonce'], 'jobcircle_submit_comment_nonce' ) ) {
            $jobcircle_response = array(
                'status'    => 'error',
                'msg'   => esc_html__('Invalid Review Submit Request', 'jobcircle-iframe'),
            );
            wp_send_json( $jobcircle_response );
        }
        $jobcircle_review_text_length = isset($jobcircle_framework_options['jobcircle_review_text_length']) ? $jobcircle_framework_options['jobcircle_review_text_length'] : '';
		$jobcricle_guest_reviews_enable = isset($jobcircle_framework_options['jobcricle_guest_reviews_enable']) ? $jobcircle_framework_options['jobcricle_guest_reviews_enable'] : '';
		$jobcricle_reviews_approval = isset($jobcircle_framework_options['jobcricle_reviews_approval']) ? $jobcircle_framework_options['jobcricle_reviews_approval'] : '';
        $jobcircle_rating   = !empty($_POST['rating']) ? intval( $_POST['rating'] ) : '';
        $jobcircle_post_id  = !empty($_POST['jobcircle_post_id']) ? intval( $_POST['jobcircle_post_id'] ) : '';
        $jobcircle_post_type    = !empty($_POST['jobcircle_post_type']) ? sanitize_text_field( $_POST['jobcircle_post_type'] ) : '';
        $jobcircle_review   = !empty($_POST['review']) ? wp_filter_post_kses( $_POST['review'] ) : '';
        
        if(empty($jobcircle_post_id) || empty($jobcircle_post_type)){
            $jobcircle_response = array(
                'status'    => 'error',
                'msg'    => esc_html__('Something went wrong. Please try again after page refresh.', 'jobcircle-iframe'),
            );
            wp_send_json( $jobcircle_response );
        }
        
        if(empty($jobcircle_review)){
            $jobcircle_response = array(
                'status'    => 'error',
                'msg'    => esc_html__('Please enter review content', 'jobcircle-iframe'),
            );
            wp_send_json( $jobcircle_response );
        }

        if(strlen($jobcircle_review) > $jobcircle_review_text_length){
            $jobcircle_response = array(
                'status'    => 'error',
                'msg'    => wp_sprintf(esc_html__('Please enter review content with max length %d', 'jobcircle-iframe'), $jobcircle_review_text_length),
            );
            wp_send_json( $jobcircle_response );
        }

        if(empty($jobcircle_rating)){
            $jobcircle_response = array(
                'status'    => 'error',
                'msg'    => esc_html__('Please select star rating', 'jobcircle-iframe'),
            );
            wp_send_json( $jobcircle_response );
        }

        $jobcircle_user_id  = 0;

        if(!is_user_logged_in() && $jobcricle_guest_reviews_enable == 'on'){
            $jobcircle_name = !empty($_POST['name']) ? sanitize_text_field( $_POST['name'] ) : '';
            $jobcircle_email = !empty($_POST['email']) ? sanitize_email( $_POST['email'] ) : '';

            if(empty($jobcircle_name)){
                $jobcircle_response = array(
                    'status'    => 'error',
                    'msg'    => esc_html__('Please enter your name', 'jobcircle-iframe'),
                );
                wp_send_json( $jobcircle_response );
            }

            if(empty($jobcircle_email) || !is_email($jobcircle_email)){
                $jobcircle_response = array(
                    'status'    => 'error',
                    'msg'    => esc_html__('Please enter your email', 'jobcircle-iframe'),
                );
                wp_send_json( $jobcircle_response );
            }

            $jobcircle_args = array(
                'post_id' => $jobcircle_post_id, // Filter by post ID
                'author_email' => $jobcircle_email, // Filter by user email
                'number' => 1, // Limit to 1 comment
                'status' => array('hold', 'approved'),
            );
            $jobcircle_comments = get_comments($jobcircle_args);

            if($jobcircle_comments) {
                $jobcircle_response = array(
                    'status'    => 'error',
                    'msg'    => esc_html__('You have submitted review. You can not submit review again.', 'jobcircle-iframe'),
                );
                wp_send_json( $jobcircle_response );
            }
            $jobcircle_user = get_user_by('email', $jobcircle_email);

            if ($jobcircle_user) {
                $jobcircle_user_id = $jobcircle_user->ID;
            }
        } else {
            $jobcircle_user_id  = get_current_user_id();

            if(empty($jobcircle_user_id)){
                $jobcircle_response = array(
                    'status'    => 'error',
                    'msg'    => esc_html__('You must be logged in to submit review.', 'jobcircle-iframe'),
                );
                wp_send_json( $jobcircle_response );
            }

            $jobcircle_post_author_id   = get_post_field('post_author', $jobcircle_post_id);
            $jobcircle_post_type        = get_post_type($jobcircle_post_id);
            $jobcircle_user_type        = jobcircle_user_account_type($jobcircle_user_id);

            if(empty($jobcircle_user_type) || ($jobcircle_post_type == $jobcircle_user_type) || ((int)$jobcircle_post_author_id == (int)$jobcircle_user_id)) {
                $jobcircle_response = array(
                    'status'    => 'error',
                    'msg'    => esc_html__('You are not allowed to submit review.', 'jobcircle-iframe'),
                );
                wp_send_json( $jobcircle_response );
            }           
            $jobcircle_user = get_user_by('id', $jobcircle_user_id);
            if ($jobcircle_user) {
                $jobcircle_name = $jobcircle_user->display_name;
                $jobcircle_email = $jobcircle_user->user_email;
            } else {
                $jobcircle_response = array(
                    'status'    => 'error',
                    'msg'    => esc_html__('You must be logged in to submit review.', 'jobcircle-iframe'),
                );
                wp_send_json( $jobcircle_response );
            }
            $jobcircle_args = array(
                'post_id' => $jobcircle_post_id,
                'user_id' => $jobcircle_user_id,
                'number' => 1, // Limit to 1 comment
                'status' => array('hold', 'approved'),
            );
            $jobcircle_comments = get_comments($jobcircle_args);
            if($jobcircle_comments) {
                $jobcircle_response = array(
                    'status'    => 'error',
                    'msg'    => esc_html__('You have submitted review. You can not submit review again.', 'jobcircle-iframe'),
                );
                wp_send_json( $jobcircle_response );
            }
        }
        $jobcircle_args = array(
            'post_id' => $jobcircle_post_id, // Filter by post ID
            'author_email' => $jobcircle_email, // Filter by user email
            'number' => 1, // Limit to 1 comment
            'status' => array('hold', 'approved'),
        );
        $jobcircle_comments = get_comments($jobcircle_args);

        if($jobcircle_comments) {
            $jobcircle_response = array(
                'status'    => 'error',
                'msg'    => esc_html__('You have submitted review. You can not submit review again.', 'jobcircle-iframe'),
            );
            wp_send_json( $jobcircle_response );
        }
        $jobcricle_reviews_approved = 0;
        if($jobcricle_reviews_approval == 'auto_apporval'){
            $jobcricle_reviews_approved = 1;
        }
        $jobcircle_comment_data = array(
            'comment_post_ID'      => $jobcircle_post_id,
            'comment_content'      => $jobcircle_review,
            'comment_author'       => $jobcircle_name,
            'comment_author_email' => $jobcircle_email,
            'comment_author_url'   => '',
            'comment_approved'     => $jobcricle_reviews_approved,
            'user_id'              => $jobcircle_user_id,
        );        
        // Insert the comment into the database
        $jobcircle_comment_id = wp_insert_comment($jobcircle_comment_data);

        if (!is_wp_error($jobcircle_comment_id)) {
            add_comment_meta($jobcircle_comment_id, 'jobcirlce_reviews_avg_rating', $jobcircle_rating);
            
            if($jobcricle_guest_reviews_enable == 'on'){
                add_comment_meta($jobcircle_comment_id, 'jobcirlce_guest_rating', 1);
            }
            do_action('jobcircle_update_post_rating', $jobcircle_post_id);

            $jobcircle_post_author_id = get_post_field('post_author', $jobcircle_post_id);
            $jobcircle_comment = get_comment($jobcircle_comment_id);
            $jobcircle_args = array(
                'jobcircle_post_id'  => $jobcircle_post_id,
                'jobcircle_post_type'  => $jobcircle_post_type,
                'jobcircle_post_author_id'  => $jobcircle_post_author_id,
                'jobcircle_user_id'  => $jobcircle_user_id,
                'jobcircle_comment'  => $jobcircle_comment,
            );
            ob_start();            
            do_action('jobcircle_reviews_list_item', $jobcircle_args);
            $jobcircle_html = ob_get_clean();
            $jobcircle_response = array(
                'status'    => 'success',
                'html'    => $jobcircle_html,
                'msg'    => esc_html__('Review submitted successfully', 'jobcircle-iframe'),
            );
            wp_send_json( $jobcircle_response );
        }
        $jobcircle_response = array(
            'status'    => 'error',
            'msg'    => esc_html__('There is error while reveiw submission.', 'jobcircle-iframe'),
        );
        wp_send_json( $jobcircle_response );
    }

    public function jobcircle_user_reviews($jobcircle_post_id, $jobcircle_post_type){
        global $jobcircle_framework_options;
		$jobcricle_reviews_enable = isset($jobcircle_framework_options['jobcricle_reviews_enable']) ? $jobcircle_framework_options['jobcricle_reviews_enable'] : '';
        
        if($jobcricle_reviews_enable !== 'on'){
            return false;
        }
        wp_enqueue_style('jobcircle-reviews');
        wp_enqueue_script('jobcircle-reviews');
        $jobcircle_review_title = isset($jobcircle_framework_options['jobcircle_review_title']) ? $jobcircle_framework_options['jobcircle_review_title'] : '';
        ob_start();
        ?>
        <div class="jobcircle-reviews-section">
            <div class="jobcircle-reviews-title">
                <h2><?php echo esc_html($jobcircle_review_title);?></h2>
            </div>
            <?php do_action('jobcircle_reviews_listing', $jobcircle_post_id, $jobcircle_post_type);?>
            <?php do_action('jobcircle_reviews_form', $jobcircle_post_id, $jobcircle_post_type);?>
        </div>
        <?php
        $jobcircle_html = ob_get_clean();
        echo apply_filters('jobcircle_user_reviews_filter', $jobcircle_html, $jobcircle_post_id, $jobcircle_post_type);
    }

    public function jobcircle_review_reply_form($jobcircle_args){
        global $jobcircle_framework_options;
        $jobcircle_review_text_length = isset($jobcircle_framework_options['jobcircle_review_text_length']) ? $jobcircle_framework_options['jobcircle_review_text_length'] : '';
        
        extract($jobcircle_args);
        $jobcircle_comment_nonce = wp_create_nonce('jobcircle_submit_reply_comment_nonce');
        ob_start();
        ?>
        <div class="review-reply-form" style="display: none;">
            <form id="jobcircle-review-reply-form" name="jobcircle-review-replyform" class="mt-3">                
                <div class="mb-3">
                    <label for="reply-content" class="form-label"><?php esc_html_e('Your Reply', 'jobcircle-iframe');?></label>
                    <textarea id="reply-content" name="reply_content"  maxlength="<?php echo intval($jobcircle_review_text_length);?>" class="form-control" rows="4" required></textarea>
                </div>
                <input type="hidden" name="comment_nonce" value="<?php echo esc_attr($jobcircle_comment_nonce); ?>">
                <input type="hidden" name="jobcircle_post_id" value="<?php echo intval($jobcircle_post_id);?>" />
                <input type="hidden" name="jobcircle_comment_id" value="" />
                <input type="hidden" name="jobcircle_reply_comment_id" value="" />
                <input type="hidden" name="jobcircle_post_type" value="<?php echo esc_attr($jobcircle_post_type);?>" />
                <input type="hidden" name="action" value="jobcircle_user_submit_review_reply">
                <button type="submit" class="btn btn-primary jobcircle-submitreply-btn btn-sm"><?php esc_html_e('Submit Reply', 'jobcircle-iframe');?></button>
                <a href="javascript:void(0)" class="btn btn-secondary btn-sm jobcircle-review-reply-cancel-btn"><?php esc_html_e('Cancel', 'jobcircle-iframe');?></a>
            </form>
        </div>
        <?php
        $jobcircle_html = ob_get_clean();
        echo apply_filters('jobcircle_review_reply_form_filter', $jobcircle_html, $jobcircle_args);
    }

    public function jobcircle_reviews_listing($jobcircle_post_id, $jobcircle_post_type){
        global $jobcircle_framework_options;
        $jobcircle_user_id  = get_current_user_id();
        $jobcircle_post_author_id = get_post_field('post_author', $jobcircle_post_id);
        $jobcircle_current_page = max(1, get_query_var('paged'));
        $jobcircle_offset = ($jobcircle_current_page - 1) * $this->jobcircle_comments_per_page;
        $jobcircle_comment_query_args = array(
            'post_id' => $jobcircle_post_id,
            'status' => 'approve',
            'parent' => 0,
            'count' => true,            
        );        
        // Create the comment query
        $jobcircle_comment_query = new WP_Comment_Query;
        $jobcircle_total_approved_comments = $jobcircle_comment_query->query($jobcircle_comment_query_args);
        $jobcircle_total_pages = ceil($jobcircle_total_approved_comments / $this->jobcircle_comments_per_page);
        $jobcircle_args = array(
            'post_id' => $jobcircle_post_id,
            'status' => 'approve',
            'parent' => 0,
            'number' => $this->jobcircle_comments_per_page,
            'offset' => $jobcircle_offset,
            'orderby' => 'comment_date', // Order by comment date
            'order' => 'DESC', // Order direction
        );       
        $jobcircle_parent_comments = get_comments($jobcircle_args);
        ob_start();
        ?>
        <div class="jobcircle-reviews-listing">
            <div class="row">
                <?php
                $jobcircle_args = array(
                    'jobcircle_post_id'  => $jobcircle_post_id,
                    'jobcircle_post_type'  => $jobcircle_post_type,
                    'jobcircle_post_author_id'  => $jobcircle_post_author_id,
                    'jobcircle_user_id'  => $jobcircle_user_id,
                );

                if($jobcircle_parent_comments){
                    foreach ($jobcircle_parent_comments as $jobcircle_comment) {
                        $jobcircle_args['jobcircle_comment']    = $jobcircle_comment;
                        do_action('jobcircle_reviews_list_item', $jobcircle_args);
                    }
                }
                ?>
            </div>
        </div>
        <?php
        if ($jobcircle_total_pages > 1) {
            echo '<div class="jobcircle-loaremore-pagination">';
            echo '<a href="javascript:void(0)" class="btn btn-secondary btn-sm jobcircle-load-more-comments" data-screen_type="page" data-page_number="2" data-total_pages="'.intval($jobcircle_total_pages).'" data-post_id="'.intval($jobcircle_post_id).'">'.esc_html__('Load More Reviews', 'jobcircle-iframe').'</a>';
            echo '</div>';
        }
        do_action('jobcircle_review_reply_form', $jobcircle_args);
        $jobcircle_html = ob_get_clean();
        echo apply_filters('jobcircle_reviews_listing_filter', $jobcircle_html, $jobcircle_post_id, $jobcircle_post_type);
    }

    public function jobcircle_reviews_list_item($jobcircle_args){
        global $jobcircle_framework_options;
        $jobcircle_review_text_length = isset($jobcircle_framework_options['jobcircle_review_text_length']) ? $jobcircle_framework_options['jobcircle_review_text_length'] : '';
        extract($jobcircle_args);
        $jobcircle_comment_id   = $jobcircle_comment->comment_ID;
        $jobcircle_comment_author   = $jobcircle_comment->comment_author;
        $jobcircle_comment_content   = $jobcircle_comment->comment_content;
        $jobcircle_comment_date   = $jobcircle_comment->comment_date;
        $jobcircle_comment_user_id   = $jobcircle_comment->user_id;
        $jobcirlce_reviews_avg_rating   = get_comment_meta($jobcircle_comment_id, 'jobcirlce_reviews_avg_rating', true);  

        if (jobcircle_user_account_type($jobcircle_comment_user_id) == 'employer') {
            $jobcircle_user_post_id = jobcircle_user_employer_id($jobcircle_user_id);
        } else {
            $jobcircle_user_post_id = jobcircle_user_candidate_id($jobcircle_user_id);
        }        
        $jobcirlce_featured_img_url = get_the_post_thumbnail_url($jobcircle_user_post_id,'thumbnail');
        if(empty($featured_img_url)){
            $featured_img_url = get_avatar_url($jobcircle_comment_user_id);
        }
        $jobcircle_comment_id   = $jobcircle_comment->comment_ID;
        $jobcircle_reply_args = array(
            'parent' => $jobcircle_comment_id,            
        );
        $jobcircle_replies = get_comments($jobcircle_reply_args);
        ob_start();
        ?>
        <!-- Review Item -->
        <div class="col-md-12 mb-4 jobcircle-review-item-<?php echo intval($jobcircle_comment_id);?>">
            <div class="card">
                <div class="card-body">
                    <div class="jobcircle-review-content-box d-flex">
                        <div class="author-thumbnail">
                            <img src="<?php echo esc_url($jobcirlce_featured_img_url);?>" alt="<?php echo esc_attr($jobcircle_comment_author);?>" />
                        </div>
                        <div class="jobcircle-review-info text-center">
                            <div class="review-flex"><h5 class="card-title"><?php echo esc_html($jobcircle_comment_author);?></h5>
                            <span><?php echo date_i18n(get_option('date_format'), strtotime($jobcircle_comment_date));?></span></div>
                            <div class="reivew-feedback"><p class="card-text"><?php echo do_shortcode($jobcircle_comment_content);?></p></div>
                            <div class="d-flex justify-content-between align-items-center">
                            <div class="star-rating">
                                    <div class="stars" style="--rating: <?php echo intval($jobcirlce_reviews_avg_rating*20);?>%;">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <span class="rating-percentage"><?php echo number_format_i18n($jobcirlce_reviews_avg_rating, 1);?></span>
                                </div>
                                <div class="btn-group" role="group" aria-label="Review actions">
                                    <?php 
                                    if($jobcircle_comment_user_id == $jobcircle_user_id){
                                        ?>
                                        <button type="button" class="btn btn-primary btn-sm jobcricle-edit-review"><?php esc_html_e('Edit', 'jobcircle-iframe');?></button>
                                        <?php
                                    }

                                    if(empty($jobcircle_replies) && $jobcircle_post_author_id == $jobcircle_user_id){
                                        ?>
                                        <button type="button" class="btn btn-secondary btn-sm jobcricle-reply-btn jobcricle-review-reply-btn" data-review_reply_id="" data-review_id="<?php echo intval($jobcircle_comment_id);?>"><?php esc_html_e('Reply', 'jobcircle-iframe');?></button>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php do_action('jobcircle_reivew_reply_item', $jobcircle_args);?>                    
                </div>
            </div>
            <?php 
            if($jobcircle_comment_user_id == $jobcircle_user_id){
                $jobcircle_comment_nonce = wp_create_nonce('jobcircle_update_comment_nonce');
                ?>
                <div class="jobcircle-reviews-update" style="display: none;">
                    <h5 class="card-title">
                        <?php esc_html_e('Update Review', 'jobcircle-iframe');?>
                    </h5>
                    <form name="jobcircle-review-update" id="jobcircle-reviewupdate-form" method="post">                       
                        <div class="mb-3">
                            <label for="rating" class="form-label"><?php esc_html_e('Rating:', 'jobcircle-iframe');?></label>

                            <div class="jobcircle-star-rating">
                                <div class="rating">
                                    <i class="far fa-star" data-rating="1"></i>
                                    <i class="far fa-star" data-rating="2"></i>
                                    <i class="far fa-star" data-rating="3"></i>
                                    <i class="far fa-star" data-rating="4"></i>
                                    <i class="far fa-star" data-rating="5"></i>
                                </div>
                                <input type="hidden" name="rating" value="<?php echo intval($jobcirlce_reviews_avg_rating);?>">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="review" class="form-label"><?php esc_html_e('Review:', 'jobcircle-iframe');?></label>
                            <textarea id="review" name="review" maxlength="<?php echo intval($jobcircle_review_text_length);?>" class="form-control" rows="4" required><?php echo do_shortcode($jobcircle_comment_content);?></textarea>
                        </div>
                        <div class="mb-3">
                            <input type="hidden" name="comment_nonce" value="<?php echo esc_attr($jobcircle_comment_nonce); ?>">
                            <input type="hidden" name="jobcircle_post_id" value="<?php echo intval($jobcircle_post_id);?>" />
                            <input type="hidden" name="jobcircle_comment_id" value="<?php echo intval($jobcircle_comment_id);?>" />
                            <input type="hidden" name="jobcircle_post_type" value="<?php echo esc_attr($jobcircle_post_type);?>" />
                            <input type="hidden" name="action" value="jobcircle_user_update_review">
                            <button type="submit" class="btn btn-primary btn-sm jobcircle-review-update-btn"><?php esc_html_e('Update Review', 'jobcircle-iframe');?></button>
                            <a href="javascript:void(0)" class="btn btn-secondary btn-sm jobcircle-review-update-cancel-btn"><?php esc_html_e('Cancel', 'jobcircle-iframe');?></a>
                        </div>
                    </form>
                </div>
                <?php
                }
                ?>
            </div>
            <!-- End Review Item -->
        <?php
        $jobcircle_html = ob_get_clean();
        echo apply_filters('jobcircle_reviews_list_item_filter', $jobcircle_html, $jobcircle_args);
    }

    public function jobcircle_reply_item($jobcircle_args){
        extract($jobcircle_args);
        $jobcircle_comment_id   = $jobcircle_comment->comment_ID;
        $jobcircle_post_author_id = get_post_field('post_author', $jobcircle_post_id);
        $jobcirlce_featured_img_url = get_the_post_thumbnail_url($jobcircle_post_id,'thumbnail');
        if(empty($jobcirlce_featured_img_url)){
            $jobcirlce_featured_img_url = get_avatar_url($jobcircle_post_author_id);
        }
        $jobcircle_args = array(
            'parent' => $jobcircle_comment_id, // Filter by parent comment ID
        );
        $jobcircle_comments = get_comments($jobcircle_args);
        ob_start();
        foreach ($jobcircle_comments as $jobcircle_comment) {
            $jobcircle_comment_author   = $jobcircle_comment->comment_author;
            $jobcircle_comment_reply_id   = $jobcircle_comment->comment_ID;
            $jobcircle_comment_date   = $jobcircle_comment->comment_date;
            $jobcircle_comment_content   = $jobcircle_comment->comment_content;
            ?>  
            <!-- Reply Comment -->
            <div class="jobcircle-reply-comment jobcircle-reply-comment-<?php echo intval($jobcircle_comment_reply_id);?> reply-comment mt-3 d-flex">       
                <div class="jobcircle-author-thumbnail">
                    <img src="<?php echo esc_url($jobcirlce_featured_img_url);?>" alt="<?php echo esc_attr($jobcircle_comment_author);?>" />
                </div>
                <div class="jobcircle-review-info text-center">         
                    <div class="reply-review"><h5 class="card-title"><?php echo esc_html($jobcircle_comment_author);?></h5>
                    <span><?php echo date_i18n(get_option('date_format'), strtotime($jobcircle_comment_date));?></span></div>
                    <div class="reply-review-feedback"><p class="card-text"><?php echo do_shortcode($jobcircle_comment_content);?></p></div>
                    <button type="button" class="btn btn-secondary btn-sm jobcricle-reply-edit-btn jobcricle-review-reply-btn" data-reply_content="<?php echo esc_attr($jobcircle_comment_content);?>" data-review_reply_id="<?php echo intval($jobcircle_comment_reply_id);?>" data-review_id="<?php echo intval($jobcircle_comment_id);?>"><?php esc_html_e('Edit Reply', 'jobcircle-iframe');?></button>
                </div>
            </div>
            <!-- End Reply Comment -->
            <?php
            break;
        }
        $jobcircle_html = ob_get_clean();
        echo apply_filters('jobcircle_reply_item_filter', $jobcircle_html, $jobcircle_args);
    }

    public function jobcircle_reviews_form($jobcircle_post_id, $jobcircle_post_type){
        global $jobcircle_framework_options;
        $jobcircle_comment_nonce = wp_create_nonce('jobcircle_submit_comment_nonce');
		$jobcricle_guest_reviews_enable = isset($jobcircle_framework_options['jobcricle_guest_reviews_enable']) ? $jobcircle_framework_options['jobcricle_guest_reviews_enable'] : '';
		$jobcircle_review_text_length = isset($jobcircle_framework_options['jobcircle_review_text_length']) ? $jobcircle_framework_options['jobcircle_review_text_length'] : '';
        ob_start();
        ?>
        <div class="jobcircle-reviews-form">
            <h3><?php esc_html_e('Leave Your Review', 'jobcircle-iframe');?></h3>
            <form name="jobcircle-review" id="jobcircle-review-form" method="post">
                <?php 
                if($jobcricle_guest_reviews_enable == 'on' && !is_user_logged_in()){
                    ?>
                    <div class="col-12 mb-15 mb-md-20">
                        <label for="name" class="form-label"><?php esc_html_e('Name:', 'jobcircle-iframe');?></label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>
                    <div class="col-12 mb-15 mb-md-20">
                        <label for="email" class="form-label"><?php esc_html_e('Email:', 'jobcircle-iframe');?></label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <?php
                }
                ?>
                <div class="col-12 mb-15 mb-md-20">
                    <label for="rating" class="form-label"><?php esc_html_e('Rating:', 'jobcircle-iframe');?></label>

                    <div class="jobcircle-star-rating">
                        <div class="rating">
                            <i class="far fa-star" data-rating="1"></i>
                            <i class="far fa-star" data-rating="2"></i>
                            <i class="far fa-star" data-rating="3"></i>
                            <i class="far fa-star" data-rating="4"></i>
                            <i class="far fa-star" data-rating="5"></i>
                        </div>
                        <input type="hidden" name="rating" value="0">
                    </div>
                </div>
                <div class="col-12 mb-15 mb-md-20">
                    <label for="review" class="form-label"><?php esc_html_e('Review:', 'jobcircle-iframe');?>:</label>
                    <textarea id="review" name="review" maxlength="<?php echo intval($jobcircle_review_text_length);?>" class="form-control" rows="4" required></textarea>
                </div>
                <div class="col-12 mb-15 mb-md-20">
                    <input type="hidden" name="comment_nonce" value="<?php echo esc_attr($jobcircle_comment_nonce); ?>">
                    <input type="hidden" name="jobcircle_post_id" value="<?php echo intval($jobcircle_post_id);?>" />
                    <input type="hidden" name="jobcircle_post_type" value="<?php echo esc_attr($jobcircle_post_type);?>" />
                    <input type="hidden" name="action" value="jobcircle_user_submit_review">
                    <button type="submit" class="btn btn-primary btn-sm jobcircle-review-submit-btn"><?php esc_html_e('Submit Review', 'jobcircle-iframe');?></button>
                </div>
            </form>
        </div>
        <?php
        $jobcircle_html = ob_get_clean();
        echo apply_filters('jobcircle_reviews_form_filter', $jobcircle_html, $jobcircle_post_id, $jobcircle_post_type);
    }
}
new JobCircle_Reviews_Hooks();