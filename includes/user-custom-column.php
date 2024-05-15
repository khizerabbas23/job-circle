<?php
class JobCircle_Users_Listing_Custom_Column {

    public function __construct() {
        add_action('admin_footer', [$this, 'jobcircle_confirmation_box']);
        add_action('wp_ajax_jobcircle_user_verify_request', [$this, 'jobcircle_user_verify_request']);
        add_filter( 'manage_users_columns', array( $this, 'jobcircle_add_custom_column' ) );
        add_action( 'manage_users_custom_column', array( $this, 'jobcircle_display_custom_column_content' ), 10, 3 );
    }

    public function jobcircle_user_verify_request(){
        if ( ! isset( $_POST['jobcircle_admin_nonce'] ) || ! wp_verify_nonce( $_POST['jobcircle_admin_nonce'], 'jobcircle_ajax_nonce' ) ) {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Invalid request', 'jobcircle-frame'));
            wp_send_json($ret_data);
        }
        $jobcircle_user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : '';
        $jobcircle_verify_type = isset($_POST['verify_type']) ? sanitize_text_field($_POST['verify_type']) : '';

        if(!empty($jobcircle_user_id)){

            $jobcircle_user_verified    = get_user_meta( $jobcircle_user_id, 'jobcircle_user_verified', true );
            $jobcircle_user_obj = get_user_by('id', $jobcircle_user_id);
            $jobcircle_args = array(
                'jobcircle_user' => $jobcircle_user_obj,
            );

            if($jobcircle_verify_type   == 'reject' && ($jobcircle_user_verified == 'yes' || empty($jobcircle_user_verified))){
                update_user_meta( $jobcircle_user_id, 'jobcircle_user_verified', 'no' );
                do_action('jobcircle_user_account_admin_rejected_email', $jobcircle_args);
                $ret_data = array('error' => '0', 'status' => esc_html__('Rejected', 'jobcircle-frame'), 'veify_title' => esc_html__('Click Here to Verify', 'jobcircle-frame'), 'msg' => esc_html__('User status rejected.', 'jobcircle-frame'));
                wp_send_json($ret_data);
            } 

            if($jobcircle_verify_type   == 'verify' && ($jobcircle_user_verified == 'no' || empty($jobcircle_user_verified))){
                do_action('jobcircle_user_account_admin_approval_email', $jobcircle_args);
                update_user_meta( $jobcircle_user_id, 'jobcircle_user_verified', 'yes' );
                $ret_data = array('error' => '0', 'status' => esc_html__('Verified', 'jobcircle-frame'), 'reject_title' => esc_html__('Click Here to Reject', 'jobcircle-frame'), 'msg' => esc_html__('User status approved succussfully.', 'jobcircle-frame'));
                wp_send_json($ret_data);
            }   
            
        }
        $ret_data = array('error' => '1', 'msg' => esc_html__('Something went wrong! Please try again after page refresh.', 'jobcircle-frame'));
        wp_send_json($ret_data);
    }

    // Add custom column
    public function jobcircle_add_custom_column( $columns ) {
        // Add your custom column
        $columns['verify'] = esc_html__('Approved', 'jobcircle-frame');
        return $columns;
    }

    // Populate custom column
    public function jobcircle_display_custom_column_content( $value, $column_name, $user_id ) {
        if ( 'verify' === $column_name ) {
            $jobcircle_user_verified    = get_user_meta( $user_id, 'jobcircle_user_verified', true );
            $jobcircle_verify_class = ' jobcircle-user-verify';
            $jobcircle_reject_class = ' jobcircle-user-verify';
            $jobcircle_user_verified_title = esc_html__('Click here to Verify', 'jobcircle-frame');
            $jobcircle_user_rejecte_title = esc_html__('Click here to Reject', 'jobcircle-frame');
            $jobcircle_user_verified_text = esc_html__('Click here to Verify', 'jobcircle-frame');
            $jobcircle_user_rejected_text = esc_html__('Click here to Reject', 'jobcircle-frame');

            if($jobcircle_user_verified == 'yes'){
                $jobcircle_verify_class = '';
                $jobcircle_user_verified_text = esc_html__('Verified', 'jobcircle-frame');
                $jobcircle_user_verified_title = esc_html__('Click here to Reject', 'jobcircle-frame');
            } elseif($jobcircle_user_verified == 'no'){
                $jobcircle_reject_class = '';
                $jobcircle_user_rejected_text = esc_html__('Rejected', 'jobcircle-frame');
                $jobcircle_user_rejecte_title = esc_html__('Rejected', 'jobcircle-frame');
            }
            //$jobcircle_user_verified_text = ($jobcircle_user_verified == 'yes') ? esc_html__('Verified', 'jobcircle-frame') : esc_html__('Unverified', 'jobcircle-frame');            
            // Output the link
            $value = '<a href="javascript:void(0)" class="jobcirlce-link jobcirlce-verified-link'.esc_attr($jobcircle_verify_class).' jobcircle-useritem-'.intval($user_id).'-verify" data-user_id="'.intval($user_id).'" data-verify_type="verify" title="'.esc_attr($jobcircle_user_verified_title).'">'.$jobcircle_user_verified_text.'</a>';
            $value .= ' | <a href="javascript:void(0)" class="jobcirlce-link jobcirlce-rejected-link'.esc_attr($jobcircle_reject_class).' jobcircle-useritem-'.intval($user_id).'-reject" data-user_id="'.intval($user_id).'" data-verify_type="reject" title="'.esc_attr($jobcircle_user_rejecte_title).'">'.$jobcircle_user_rejected_text.'</a>';
        }
        return $value;
    }

    public function jobcircle_confirmation_box(){
        ob_start();
        ?>
        <style>            
            .jobcircle-alert-msg{position:fixed;padding:.75rem 1.25rem;top:40px;right:40px;min-width:250px;max-width:350px;color:#155724;font-size:16px;background-color:#d4edda;border:1px solid #c3e6cb;border-radius:.25rem;z-index:99999}
            .jobcircle-alert-msg.jobcircle-alert-danger{color:#721c24;background-color:#f8d7da;border-color:#f5c6cb}
            .jobcircle-alert-msg.jobcircle-alert-info{color:#0c5460;background-color:#d1ecf1;border-color:#bee5eb}
            .jobcircle-alert-msg.jobcircle-alert-warning{color:#856404;background-color:#fff3cd;border-color:#ffeeba}
            .jobcircle-modal {
                display: none;
                position: fixed;
                z-index: 9999;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                background-color: rgba(0,0,0,0.4);
            }
            .jobcircle-modal-content {
                background-color: #fefefe;
                margin: 15% auto;
                padding: 20px;
                border: 1px solid #888;
                width: 80%;
                text-align: center;
            }

            .jobcircle-modal-buttons button {
                margin: 0 10px;
            }
        </style>
        <div id="jobcircle-confirmation-modal" class="jobcircle-modal">
            <div class="jobcircle-modal-content">
                <p><?php esc_html_e('Are you sure you want to do this?', 'jobcircle-frame');?></p>
                <div class="jobcircle-modal-buttons">
                    <button id="jobcircle-confirm-yes"><?php esc_html_e('Yes', 'jobcircle-frame');?></button>
                    <button id="jobcircle-confirm-no"><?php esc_html_e('No', 'jobcircle-frame');?></button>
                </div>
            </div>
        </div>
        <?php
        $jobcirlce_html = ob_get_clean();
        echo apply_filters('jobcircle_confirmation_box_html', $jobcirlce_html);
    }
}
// Instantiate the class
new JobCircle_Users_Listing_Custom_Column();
