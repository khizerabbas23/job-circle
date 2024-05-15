<?php

class Jobcircle_Plugin_Packages_Funcs {
    
    public function __construct() {
        add_action('jobcircle_employer_packages', array($this, 'jobcircle_employer_packages'), 10);
        add_action('jobcircle_employer_job_packages', array($this, 'jobcircle_employer_job_packages'), 10);
        add_action('jobcircle_employer_profile_packages', array($this, 'jobcircle_employer_profile_packages'), 10);
        add_action('jobcircle_candidate_packages', array($this, 'jobcircle_candidate_profile_packages'), 10);
        add_action('jobcircle_all_packages', array($this, 'jobcircle_all_packages'), 10);
        add_action('save_post', array($this, 'save_meta_fields'), 5);
        add_action('add_meta_boxes', array($this, 'wc_prod_metaboxes'));

        add_action('wp_ajax_jobcircle_member_pckgbuy_call', array($this, 'member_pckgbuy_call'));
        add_action('wp_ajax_nopriv_jobcircle_member_pckgbuy_call', array($this, 'member_pckgbuy_call'));

        add_action('woocommerce_new_order', array($this, 'woocommerce_after_checkout_process'), 10, 1);
        add_action('woocommerce_order_status_completed', array($this, 'woocommerce_order_status_complete'), 10, 1);
        add_action('woocommerce_before_order_itemmeta', array($this,'jobcircle_woocommerce_before_order_itemmeta'),10,3);
    }

    public function jobcircle_candidate_profile_packages($jobcircle_packages){
        return array('cand_applics' => esc_html__('Candidate (Job Applications)', 'jobcircle-frame'), 'cand_profile' => esc_html__('Candidate (Profile Package)', 'jobcircle-frame'));
    }
    public function jobcircle_employer_profile_packages($jobcircle_packages){
        return array('emp_profile' => esc_html__('Employer (Profile Package)', 'jobcircle-frame'));
    }
    public function jobcircle_employer_job_packages($jobcircle_packages){
        return array('emp_jobs' => esc_html__('Employer Jobs', 'jobcircle-frame'), 'emp_featured_jobs' => esc_html__('Employer Featured Jobs', 'jobcircle-frame'));
    }
    public function jobcircle_employer_packages($jobcircle_packages){
        $jobcircle_job_packages = apply_filters('jobcircle_employer_job_packages', array());
        $jobcircle_profile_packages = apply_filters('jobcircle_employer_profile_packages', array());
        $jobcircle_packages = array_merge($jobcircle_job_packages, $jobcircle_profile_packages);
        return $jobcircle_packages;
    }
    public function jobcircle_all_packages($jobcircle_packages){
        $jobcircle_employer_packages = apply_filters('jobcircle_employer_packages', array());
        $jobcircle_candidate_profile_packages = apply_filters('jobcircle_candidate_packages', array());
        $jobcircle_packages = array_merge($jobcircle_employer_packages, $jobcircle_candidate_profile_packages);
        return $jobcircle_packages;
    }

    public function wc_prod_metaboxes() {
        add_meta_box('jobcircle-product-attachment', esc_html__('Package Settings', 'jobcircle-frame'), array($this, 'prod_package_meta'), 'product', 'normal', 'high');
    }

    public function prod_package_meta() {
        global $post;
        $prod_with_pkg = get_post_meta($post->ID, 'jobcircle_field_prod_attachwith_pkg', true);
        $prod_pkg_type = get_post_meta($post->ID, 'jobcircle_field_prod_pkgtype', true);
        $num_of_jobs = get_post_meta($post->ID, 'jobcircle_field_numof_jobs', true);
        $num_of_featured_jobs = get_post_meta($post->ID, 'jobcircle_field_numof_featured_jobs', true);
        $num_of_applics = get_post_meta($post->ID, 'jobcircle_field_numof_applics', true);
        
        $candidate_my_resume = get_post_meta($post->ID, 'jobcircle_field_can_my_resume', true);
        $candidate_cv_manager = get_post_meta($post->ID, 'jobcircle_field_can_cv_manager', true);
        $candidate_applied_jobs = get_post_meta($post->ID, 'jobcircle_field_can_applied_jobs', true);
        $candidate_bookmark_jobs = get_post_meta($post->ID, 'jobcircle_field_can_bookmark_jobs', true);
        $candidate_job_alerts = get_post_meta($post->ID, 'jobcircle_field_can_job_alerts', true);
        $candidate_packages = get_post_meta($post->ID, 'jobcircle_field_can_packages', true);

        $employer_post_new_job = get_post_meta($post->ID, 'jobcircle_field_emp_post_new_job', true);
        $employer_manage_jobs = get_post_meta($post->ID, 'jobcircle_field_emp_manage_jobs', true);
        $employer_manage_applicants = get_post_meta($post->ID, 'jobcircle_field_emp_manage_applicants', true);
        $employer_bookmark_resumes = get_post_meta($post->ID, 'jobcircle_field_emp_bookmark_resumes', true);
        $employer_packages = get_post_meta($post->ID, 'jobcircle_field_emp_packages', true);

        $jobcircle_packages_array    = apply_filters('jobcircle_all_packages', array());
        ?>
        <div class="jobcircle-post-layout">
            <div class="jobcircle-element-field">
                <div class="elem-label">
                    <label><?php esc_html_e('Attach Product with Package?', 'jobcircle-frame') ?></label>
                </div>
                <div class="elem-field">
                    <select name="jobcircle_field_prod_attachwith_pkg">
                        <option value="no"<?php echo ($prod_with_pkg == 'no' ? ' selected' : '') ?>><?php esc_html_e('No', 'jobcircle-frame') ?></option>
                        <option value="yes"<?php echo ($prod_with_pkg == 'yes' ? ' selected' : '') ?>><?php esc_html_e('Yes', 'jobcircle-frame') ?></option>
                    </select>
                </div>
            </div>
            <div class="jobcircle-element-field">
                <div class="elem-label">
                    <label><?php esc_html_e('Package Type', 'jobcircle-frame') ?></label>
                </div>
                <div class="elem-field">
                    <select name="jobcircle_field_prod_pkgtype">
                        <?php foreach($jobcircle_packages_array as $package_key => $package_name){?>
                            <option value="<?php echo esc_attr($package_key);?>"<?php echo ($prod_pkg_type == $package_key ? ' selected' : '') ?>><?php echo esc_html($package_name) ?></option>
                        <?php }?>
                    </select>
                </div>
            </div>
            <div class="pkg-elementry-fields pkg-emp_jobs-field"<?php echo ((empty($prod_pkg_type) || $prod_pkg_type == 'emp_jobs') ? '' : ' style="display: none;"') ?>>
                <div class="jobcircle-element-field">
                    <div class="elem-label">
                        <label><?php esc_html_e('Number of Jobs', 'jobcircle-frame') ?></label>
                    </div>
                    <div class="elem-field">
                        <input type="number" name="jobcircle_field_numof_jobs" min="1" value="<?php echo ($num_of_jobs) ?>">
                    </div>
                </div>
            </div>
            <div class="pkg-elementry-fields pkg-emp_featured_jobs-field"<?php echo ($prod_pkg_type == 'emp_featured_jobs' ? '' : ' style="display: none;"') ?>>
                <div class="jobcircle-element-field">
                    <div class="elem-label">
                        <label><?php esc_html_e('Number of Featured Jobs', 'jobcircle-frame') ?></label>
                    </div>
                    <div class="elem-field">
                        <input type="number" name="jobcircle_field_numof_featured_jobs" min="1" value="<?php echo ($num_of_featured_jobs) ?>">
                    </div>
                </div>
            </div>
            <div class="pkg-elementry-fields pkg-cand_applics-field"<?php echo ($prod_pkg_type == 'cand_applics' ? '' : ' style="display: none;"') ?>>
                <div class="jobcircle-element-field">
                    <div class="elem-label">
                        <label><?php esc_html_e('Number of Applications', 'jobcircle-frame') ?></label>
                    </div>
                    <div class="elem-field">
                        <input type="number" name="jobcircle_field_numof_applics" min="1" value="<?php echo ($num_of_applics) ?>">
                    </div>
                </div>
            </div>
            
            <div class="pkg-elementry-fields pkg-cand_profile-field"<?php echo ($prod_pkg_type == 'cand_profile' ? '' : ' style="display: none;"') ?>>
                <div class="jobcircle-element-field">
                    <div class="elem-label">
                        <label><?php esc_html_e('Profile Package Includes', 'jobcircle-frame') ?></label>
                    </div>

                    <div class="elem-field checkbox-field">
                        <input type="checkbox" name="jobcircle_field_can_my_resume" <?php if(($candidate_my_resume === 1) || ($candidate_my_resume == "on")): echo 'checked="checked"'; endif; ?>>
                        <label><?php esc_html_e('My Resume', 'jobcircle-frame') ?></label>
                    </div>   
                    <div class="elem-field checkbox-field">
                        <input type="checkbox" name="jobcircle_field_can_cv_manager" <?php if(($candidate_cv_manager === 1) || ($candidate_cv_manager == "on")): echo 'checked="checked"'; endif; ?>>
                        <label><?php esc_html_e('CV Manager', 'jobcircle-frame') ?></label>
                    </div>  
                    <div class="elem-field checkbox-field">
                        <input type="checkbox" name="jobcircle_field_can_applied_jobs" <?php if(($candidate_applied_jobs === 1) || ($candidate_applied_jobs == "on")): echo 'checked="checked"'; endif; ?>>
                        <label><?php esc_html_e('Applied Jobs', 'jobcircle-frame') ?></label>                        
                    </div>  
                    <div class="elem-field checkbox-field">
                        <input type="checkbox" name="jobcircle_field_can_bookmark_jobs" <?php if(($candidate_bookmark_jobs === 1) || ($candidate_bookmark_jobs == "on")): echo 'checked="checked"'; endif; ?>>
                        <label><?php esc_html_e('Bookmark Jobs', 'jobcircle-frame') ?></label>
                    </div> 
                    <div class="elem-field checkbox-field">
                        <input type="checkbox" name="jobcircle_field_can_job_alerts" <?php if(($candidate_job_alerts === 1) || ($candidate_job_alerts == "on")): echo 'checked="checked"'; endif; ?>>
                        <label><?php esc_html_e('Job Alerts', 'jobcircle-frame') ?></label>
                    </div>   
                    <div class="elem-field checkbox-field">
                        <input type="checkbox" name="jobcircle_field_can_packages" <?php if(($candidate_packages === 1) || ($candidate_packages == "on")): echo 'checked="checked"'; endif; ?>>
                        <label><?php esc_html_e('Packages', 'jobcircle-frame') ?></label>
                    </div>
                </div>
            </div>
            
            <div class="pkg-elementry-fields pkg-emp_profile-field"<?php echo ($prod_pkg_type == 'emp_profile' ? '' : ' style="display: none;"') ?>>
                <div class="jobcircle-element-field">
                    <div class="elem-label">
                        <label><?php esc_html_e('Profile Package Includes', 'jobcircle-frame') ?></label>
                    </div>

                    <div class="elem-field checkbox-field">
                        <input type="checkbox" name="jobcircle_field_emp_post_new_job" <?php if(($employer_post_new_job === 1) || ($employer_post_new_job == "on")): echo 'checked="checked"'; endif; ?>>
                        <label><?php esc_html_e('Post New Job', 'jobcircle-frame') ?></label>
                    </div>   
                    <div class="elem-field checkbox-field">
                        <input type="checkbox" name="jobcircle_field_emp_manage_jobs" <?php if(($employer_manage_jobs === 1) || ($employer_manage_jobs == "on")): echo 'checked="checked"'; endif; ?>>
                        <label><?php esc_html_e('Manage Jobs', 'jobcircle-frame') ?></label>
                    </div>  
                    <div class="elem-field checkbox-field">
                        <input type="checkbox" name="jobcircle_field_emp_manage_applicants" <?php if(($employer_manage_applicants === 1) || ($employer_manage_applicants == "on")): echo 'checked="checked"'; endif; ?>>
                        <label><?php esc_html_e('Manage Applicants', 'jobcircle-frame') ?></label>                        
                    </div>  
                    <div class="elem-field checkbox-field">
                        <input type="checkbox" name="jobcircle_field_emp_bookmark_resumes" <?php if(($employer_bookmark_resumes === 1) || ($employer_bookmark_resumes == "on")): echo 'checked="checked"'; endif; ?>>
                        <label><?php esc_html_e('Bookmark Resumes', 'jobcircle-frame') ?></label>
                    </div> 
                    <div class="elem-field checkbox-field">
                        <input type="checkbox" name="jobcircle_field_emp_packages" <?php if(($employer_packages === 1) || ($employer_packages == "on")): echo 'checked="checked"'; endif; ?>>
                        <label><?php esc_html_e('Packages', 'jobcircle-frame') ?></label>
                    </div>
                </div>
            </div>

            <?php do_action('jobcircle_packages_meta_fields_data', $post);?>            
        </div>
        <?php
        add_action('admin_footer', function() {
            ?>
            <script>
                jQuery('select[name="jobcircle_field_prod_pkgtype"]').on('change', function() {
                    var this_f = jQuery(this);
                    var this_val = this_f.val();
                    jQuery('.pkg-elementry-fields').hide();
                    jQuery('.pkg-' + this_val + '-field').removeAttr('style');
                });
            </script>
            <?php
        }, 35);
    }

    public function save_meta_fields($post_id) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        if (get_post_type($post_id) == 'product') {
            if (isset($_POST['jobcircle_field_prod_attachwith_pkg']) && $_POST['jobcircle_field_prod_attachwith_pkg'] == 'yes') {
                $_product = wc_get_product($post_id);
                if ($_product) {
                    update_post_meta($post_id, '_manage_stock', 'no');
                    update_post_meta($post_id, '_virtual', 'yes');
                    update_post_meta($post_id, '_downloadable', 'no');
                    
                    $product_id = $_product->get_id();
                    if(isset($_POST['jobcircle_field_prod_pkgtype']) && ($_POST['jobcircle_field_prod_pkgtype'] == "cand_profile")){

                        if(isset($_POST['jobcircle_field_can_my_resume'])){
                            update_post_meta($product_id, 'jobcircle_field_can_my_resume', 1);
                        }else{
                            update_post_meta($product_id, 'jobcircle_field_can_my_resume', 0);
                        }

                        if(isset($_POST['jobcircle_field_can_cv_manager'])){
                            update_post_meta($product_id, 'jobcircle_field_can_cv_manager', 1);
                        }else{
                            update_post_meta($product_id, 'jobcircle_field_can_cv_manager', 0);
                        }

                        if(isset($_POST['jobcircle_field_can_applied_jobs'])){
                            update_post_meta($product_id, 'jobcircle_field_can_applied_jobs', 1);
                        }else{
                            update_post_meta($product_id, 'jobcircle_field_can_applied_jobs', 0);
                        }

                        if(isset($_POST['jobcircle_field_can_bookmark_jobs'])){
                            update_post_meta($product_id, 'jobcircle_field_can_bookmark_jobs', 1);
                        }else{
                            update_post_meta($product_id, 'jobcircle_field_can_bookmark_jobs', 0);
                        }

                        if(isset($_POST['jobcircle_field_can_job_alerts'])){
                            update_post_meta($product_id, 'jobcircle_field_can_job_alerts', 1);
                        }else{
                            update_post_meta($product_id, 'jobcircle_field_can_job_alerts', 0);
                        }

                        if(isset($_POST['jobcircle_field_can_packages'])){
                            update_post_meta($product_id, 'jobcircle_field_can_packages', 1);
                        }else{
                            update_post_meta($product_id, 'jobcircle_field_can_packages', 0);
                        }
                    }

                    if(isset($_POST['jobcircle_field_prod_pkgtype']) && ($_POST['jobcircle_field_prod_pkgtype'] == "emp_profile")){

                        if(isset($_POST['jobcircle_field_emp_post_new_job'])){
                            update_post_meta($product_id, 'jobcircle_field_emp_post_new_job', 1);
                        }else{
                            update_post_meta($product_id, 'jobcircle_field_emp_post_new_job', 0);
                        }

                        if(isset($_POST['jobcircle_field_emp_manage_jobs'])){
                            update_post_meta($product_id, 'jobcircle_field_emp_manage_jobs', 1);
                        }else{
                            update_post_meta($product_id, 'jobcircle_field_emp_manage_jobs', 0);
                        }

                        if(isset($_POST['jobcircle_field_emp_manage_applicants'])){
                            update_post_meta($product_id, 'jobcircle_field_emp_manage_applicants', 1);
                        }else{
                            update_post_meta($product_id, 'jobcircle_field_emp_manage_applicants', 0);
                        }

                        if(isset($_POST['jobcircle_field_emp_bookmark_resumes'])){
                            update_post_meta($product_id, 'jobcircle_field_emp_bookmark_resumes', 1);
                        }else{
                            update_post_meta($product_id, 'jobcircle_field_emp_bookmark_resumes', 0);
                        }

                        if(isset($_POST['jobcircle_field_emp_packages'])){
                            update_post_meta($product_id, 'jobcircle_field_emp_packages', 1);
                        }else{
                            update_post_meta($product_id, 'jobcircle_field_emp_packages', 0);
                        }
                    }

                    //
                    $_product->set_catalog_visibility('hidden');
                    $_product->save();
                }
            }
        }
    }

    public function member_pckgbuy_call() {
        global $current_user;

        if (is_user_logged_in()) {

            if (!class_exists('WooCommerce')) {
                $ret_data = array('error' => '1', 'msg' => esc_html__('WooCommerce Plugin not installed/activate.', 'jobcircle-frame'));
                wp_send_json($ret_data);
            }

            $product_id = $_POST['pkg_id'];
            if (get_post_type($product_id) != 'product') {
                $ret_data = array('error' => '2', 'msg' => esc_html__('No product found for this package.', 'jobcircle-frame'));
                wp_send_json($ret_data);
            }
            $prod_with_pkg = get_post_meta($product_id, 'jobcircle_field_prod_attachwith_pkg', true);
            $prod_pkg_type = get_post_meta($product_id, 'jobcircle_field_prod_pkgtype', true);
            if ($prod_with_pkg != 'yes') {
                $ret_data = array('error' => '2', 'msg' => esc_html__('No product found for this package.', 'jobcircle-frame'));
                wp_send_json($ret_data);
            }

            $user_id = $current_user->ID;
            $candidate_id = jobcircle_user_candidate_id($user_id);
            $employer_id = jobcircle_user_employer_id($user_id);

            if ($prod_pkg_type == 'cand_applics' || $prod_pkg_type == 'cand_profile') {
                if (!$candidate_id) {
                    $ret_data = array('error' => '2', 'msg' => esc_html__('Only a candidate member can buy this package.', 'jobcircle-frame'));
                    wp_send_json($ret_data);
                }
            } else {
                if (!$employer_id) {
                    $ret_data = array('error' => '2', 'msg' => esc_html__('Only an employer member can buy this package.', 'jobcircle-frame'));
                    wp_send_json($ret_data);
                }
            }

            $checkout_url = self::prod_payment_checkout($product_id, 'checkout_url');
            $ret_data = array('error' => '0', 'msg' => esc_html__('Package added to cart successfully.', 'jobcircle-frame'), 'redirect' => $checkout_url);
            wp_send_json($ret_data);

        } else {
            $ret_data = array('error' => '2', 'msg' => esc_html__('Only a logged in member can buy this package.', 'jobcircle-frame'));
            wp_send_json($ret_data);
        }
    }

    public static function prod_payment_checkout($product_id, $return_type = 'redirect', $all_clear = true) {

        global $woocommerce;

        //
        if (WC()->cart->get_cart_contents_count() > 0 && $all_clear !== false) {
            WC()->cart->empty_cart();
        }
        $woocommerce->cart->add_to_cart($product_id);
        if ($return_type != 'no_where') {
            if ($return_type == 'checkout_url') {
                return wc_get_checkout_url();
            } else {
                wp_safe_redirect(wc_get_checkout_url());
                exit();
            }
        }
    }

    public function woocommerce_after_checkout_process($order_id) {
        
        if (is_user_logged_in()) {
            $user_id = get_current_user_id();
            
            $jobcircle_order = wc_get_order($order_id);


            if (is_a($jobcircle_order, 'WC_Order')) {

                foreach (WC()->cart->get_cart() as $cart_item) {
                    //var_dump($cart_item);
                    $product_id = isset($cart_item['product_id']) ? $cart_item['product_id'] : '';

                    $prod_with_pkg = get_post_meta($product_id, 'jobcircle_field_prod_attachwith_pkg', true);

                    if ($prod_with_pkg == 'yes') {

                        $prod_pkg_name = get_the_title($product_id);
                        $prod_pkg_type = get_post_meta($product_id, 'jobcircle_field_prod_pkgtype', true);
                        $jobcircle_order->update_meta_data('order_attach_with_pkg', 'yes');
                        $jobcircle_order->update_meta_data('order_pkg_type', $prod_pkg_type);
                        $jobcircle_order->update_meta_data('order_pkg_name', $prod_pkg_name);
                        $jobcircle_order->update_meta_data('order_user_id', $user_id);

                        // job pakage fields
                        if ($prod_pkg_type == 'emp_jobs') {
                            $total_num_jobs = get_post_meta($product_id, 'jobcircle_field_numof_jobs', true);
                            $jobcircle_order->update_meta_data('order_numof_jobs', $total_num_jobs);
                        }

                        if ($prod_pkg_type == 'emp_featured_jobs') {
                            $total_num_featured_jobs = get_post_meta($product_id, 'jobcircle_field_numof_featured_jobs', true);
                            $jobcircle_order->update_meta_data('order_numof_featured_jobs', $total_num_featured_jobs);
                        }

                        // candidate pakage fields
                        if ($prod_pkg_type == 'cand_applics') {
                            $total_num_applics = get_post_meta($product_id, 'jobcircle_field_numof_applics', true);
                            $jobcircle_order->update_meta_data('order_numof_applics', $total_num_applics);
                        }
                        
                        // candidate profile pakage fields
                        if ($prod_pkg_type == 'cand_profile') {
                            $candidate_profile_my_resume = get_post_meta($product_id, 'jobcircle_field_can_my_resume', true);
                            $candidate_profile_cv_manager = get_post_meta($product_id, 'jobcircle_field_can_cv_manager', true);
                            $candidate_profile_applied_jobs = get_post_meta($product_id, 'jobcircle_field_can_applied_jobs', true);
                            $candidate_profile_bookmark_jobs = get_post_meta($product_id, 'jobcircle_field_can_bookmark_jobs', true);
                            $candidate_profile_job_alerts = get_post_meta($product_id, 'jobcircle_field_can_job_alerts', true);
                            $candidate_profile_packages = get_post_meta($product_id, 'jobcircle_field_can_packages', true);

                            $jobcircle_order->update_meta_data('order_cand_my_resume', $candidate_profile_my_resume);
                            $jobcircle_order->update_meta_data('order_cand_cv_manager', $candidate_profile_cv_manager);
                            $jobcircle_order->update_meta_data('order_cand_applied_jobs', $candidate_profile_applied_jobs);
                            $jobcircle_order->update_meta_data('order_cand_bookmark_jobs', $candidate_profile_bookmark_jobs);
                            $jobcircle_order->update_meta_data('order_cand_bookmark_jobs', $candidate_profile_job_alerts);
                            $jobcircle_order->update_meta_data('order_cand_job_alerts', $candidate_profile_job_alerts);
                            $jobcircle_order->update_meta_data('order_cand_packages', $candidate_profile_packages);
                        }

                        // employer profile pakage fields
                        if ($prod_pkg_type == 'emp_profile') {
                            $employer_post_new_job = get_post_meta($product_id, 'jobcircle_field_emp_post_new_job', true);
                            $employer_manage_jobs = get_post_meta($product_id, 'jobcircle_field_emp_manage_jobs', true);
                            $employer_manage_applicants = get_post_meta($product_id, 'jobcircle_field_emp_manage_applicants', true);
                            $employer_bookmark_resumes = get_post_meta($product_id, 'jobcircle_field_emp_bookmark_resumes', true);
                            $employer_packages = get_post_meta($product_id, 'jobcircle_field_emp_packages', true);

                            $jobcircle_order->update_meta_data('order_emp_post_new_job', $employer_post_new_job);
                            $jobcircle_order->update_meta_data('order_emp_manage_jobs', $employer_manage_jobs);
                            $jobcircle_order->update_meta_data('order_emp_manage_applicants', $employer_manage_applicants);
                            $jobcircle_order->update_meta_data('order_emp_bookmark_resumes', $employer_bookmark_resumes);
                            $jobcircle_order->update_meta_data('order_emp_packages', $employer_packages);
                        }                       
                        $jobcircle_order->save();
                    }
                }
            }
        } else {
            error_log('user not logged in ');
        }
    }

    public function woocommerce_order_status_complete($order_id) {
        $jobcircle_order = wc_get_order($order_id);

        if (is_a($jobcircle_order, 'WC_Order')) {
            $order_attach_with_pkg = $jobcircle_order->get_meta('order_attach_with_pkg');

            if($order_attach_with_pkg == 'yes'){
                $order_type = $jobcircle_order->get_meta('order_pkg_type');
                $order_user_id = $jobcircle_order->get_meta('order_user_id');
    
                if($order_type == 'cand_profile'){
                    $candidate_user_id = jobcircle_user_candidate_id($order_user_id);
                    
                    $candidate_buyed_packages = get_post_meta($candidate_user_id, 'candidate_purchased_packages', true);
                    if($candidate_buyed_packages){
                        $candidate_purchased_packages = $candidate_buyed_packages.','.$order_id;
                    }else{
                        $candidate_purchased_packages = $order_id;
                    }
    
                    update_post_meta($candidate_user_id,'candidate_purchased_packages', $candidate_purchased_packages);
    
                } elseif ($order_type == 'emp_profile'){
                    $employer_user_id = jobcircle_user_employer_id($order_user_id);
    
                    $employer_buyed_packages = get_post_meta($employer_user_id, 'employer_purchased_packages', true);
                    if($employer_buyed_packages){
                        $employer_purchased_packages = $employer_buyed_packages.','.$order_id;
                    }else{
                        $employer_purchased_packages = $order_id;
                    }    
                    update_post_meta($employer_user_id,'employer_purchased_packages', $employer_purchased_packages);    
                }elseif ($order_type == 'cand_applics') {
                    $jobcircle_order->update_meta_data('order_cand_application_ids', '');
                } else {
                    $jobcircle_order->update_meta_data('order_employer_job_ids', '');
                }
                $jobcircle_order->save();
            }

        }
    }
    
    function jobcircle_woocommerce_before_order_itemmeta($item_id,$item,$product){
        if(isset($item['order_id'])){            
            $item_order_id = $item['order_id'];

            if($item_order_id > 0){
                $order_type = get_post_meta($item_order_id,'order_pkg_type', true);

                if($order_type == 'cand_profile'){
                    $order_cand_my_resume = get_post_meta($item_order_id,'order_cand_my_resume', true);
                    $order_cand_cv_manager = get_post_meta($item_order_id,'order_cand_cv_manager', true);
                    $order_cand_applied_jobs = get_post_meta($item_order_id,'order_cand_applied_jobs', true);
                    $order_cand_bookmark_jobs = get_post_meta($item_order_id,'order_cand_bookmark_jobs', true);
                    $order_cand_job_alerts = get_post_meta($item_order_id,'order_cand_job_alerts', true);
                    $order_cand_packages = get_post_meta($item_order_id,'order_cand_packages', true);

                    echo '<div class="order-jobcirlce-package-details">';

                    if(($order_cand_my_resume === 1) || ($order_cand_my_resume == "on")){
                        echo '<div class="form-check">
                               <input class="form-check-input" type="checkbox" checked disabled>
                               <label class="form-check-label">My Resume</label>
                              </div>';
                    }
                    
                    if(($order_cand_cv_manager === 1) || ($order_cand_cv_manager == "on")){
                        echo '<div class="form-check">
                               <input class="form-check-input" type="checkbox" checked disabled>
                               <label class="form-check-label">CV Manager</label>
                              </div>';
                    }

                    if(($order_cand_applied_jobs === 1) || ($order_cand_applied_jobs == "on")){
                        echo '<div class="form-check">
                               <input class="form-check-input" type="checkbox" checked disabled>
                               <label class="form-check-label">Applied Jobs</label>
                              </div>';
                    }

                    if(($order_cand_bookmark_jobs === 1) || ($order_cand_bookmark_jobs == "on")){
                        echo '<div class="form-check">
                               <input class="form-check-input" type="checkbox" checked disabled>
                               <label class="form-check-label">Bookmark Jobs</label>
                              </div>';
                    }

                    if(($order_cand_job_alerts === 1) || ($order_cand_job_alerts == "on")){
                        echo '<div class="form-check">
                               <input class="form-check-input" type="checkbox" checked disabled>
                               <label class="form-check-label">Job Alerts</label>
                              </div>';
                    }                    

                    if(($order_cand_packages === 1) || ($order_cand_packages == "on")){
                        echo '<div class="form-check">
                               <input class="form-check-input" type="checkbox" checked disabled>
                               <label class="form-check-label">Packages</label>
                              </div>'; 
                    }                                       

                    echo '</div>';

                }elseif($order_type == 'emp_profile'){

                    $order_emp_post_new_job = get_post_meta($item_order_id,'order_emp_post_new_job', true);
                    $order_emp_manage_jobs = get_post_meta($item_order_id,'order_emp_manage_jobs', true);
                    $order_emp_manage_applicants = get_post_meta($item_order_id,'order_emp_manage_applicants', true);
                    $order_emp_bookmark_resumes = get_post_meta($item_order_id,'order_emp_bookmark_resumes', true);
                    $order_emp_packages = get_post_meta($item_order_id,'order_emp_packages', true);

                    echo '<div class="order-jobcirlce-package-details">';

                    if(($order_emp_post_new_job === 1) || ($order_emp_post_new_job == "on")){
                        echo '<div class="form-check">
                               <input class="form-check-input" type="checkbox" checked disabled>
                               <label class="form-check-label">Post New Job</label>
                              </div>';
                    }
                    
                    if(($order_emp_manage_jobs === 1) || ($order_emp_manage_jobs == "on")){
                        echo '<div class="form-check">
                               <input class="form-check-input" type="checkbox" checked disabled>
                               <label class="form-check-label">Manage Jobs</label>
                              </div>';
                    }

                    if(($order_emp_manage_applicants === 1) || ($order_emp_manage_applicants == "on")){
                        echo '<div class="form-check">
                               <input class="form-check-input" type="checkbox" checked disabled>
                               <label class="form-check-label">Manage Applicants</label>
                              </div>';
                    }

                    if(($order_emp_bookmark_resumes === 1) || ($order_emp_bookmark_resumes == "on")){
                        echo '<div class="form-check">
                               <input class="form-check-input" type="checkbox" checked disabled>
                               <label class="form-check-label">Bookmark Resumes</label>
                              </div>';
                    }

                    if(($order_emp_packages === 1) || ($order_emp_packages == "on")){
                        echo '<div class="form-check">
                               <input class="form-check-input" type="checkbox" checked disabled>
                               <label class="form-check-label">Packages</label>
                              </div>';
                    }                                      

                    echo '</div>';
                }
            }
        }
    }
}

new Jobcircle_Plugin_Packages_Funcs;

// job package functions

function jobcircle_employer_jobs_pkg_used_credits($order_id) {
    $used_credits_num = 0;
    $jobcircle_order = wc_get_order($order_id);

    if (is_a($jobcircle_order, 'WC_Order')) {
        $used_credits = $jobcircle_order->get_meta('order_employer_job_ids');

        if (!empty($used_credits)) {
            $used_credits_arr = explode(',', $used_credits);
            $used_credits_num = !empty($used_credits_arr) ? sizeof($used_credits_arr) : 0;
        }
    }

    return absint($used_credits_num);
}

function jobcircle_employer_jobs_pkg_remainin_credits($order_id) {
    $jobcircle_order = wc_get_order($order_id);
    if (is_a($jobcircle_order, 'WC_Order')) {
        $order_type = $jobcircle_order->get_meta('order_pkg_type');
        if($order_type == 'emp_featured_jobs'){
            $total_credits = (int)$jobcircle_order->get_meta('order_numof_featured_jobs');
        } else {
            $total_credits = (int)$jobcircle_order->get_meta('order_numof_jobs');
        }
        $used_credits = jobcircle_employer_jobs_pkg_used_credits($order_id);

        $remaining_credits = 0;
        if ($total_credits > $used_credits) {
            $remaining_credits = $total_credits - $used_credits;
        }
    }

    return absint($remaining_credits);
}

function jobcircle_employer_jobs_pkg_expired($order_id) {
    $remainin_credits = jobcircle_employer_jobs_pkg_remainin_credits($order_id);
    if ($remainin_credits <= 0) {
        return true;
    }
}

function jobcircle_employer_jobs_pkg_consume($order_id, $job_id) {
    $jobcircle_order = wc_get_order($order_id);
    if (is_a($jobcircle_order, 'WC_Order')) {
        $used_credits = $jobcircle_order->get_meta('order_employer_job_ids');

        $order_type = $jobcircle_order->get_meta('order_pkg_type');
        if($order_type == 'emp_featured_jobs'){
            update_post_meta($job_id, 'jobcircle_field_featured_job', 'featured');
        } else {
            update_post_meta($job_id, 'jobcircle_field_featured_job', 'normal');
        }

        if (!empty($used_credits)) {
            $used_credits_arr = explode(',', $used_credits);
            $used_credits_arr[] = $job_id;
        } else {
            $used_credits_arr = array($job_id);
        }
        $used_credits_str = implode(',', $used_credits_arr);
        $jobcircle_order->update_meta_data('order_employer_job_ids', $used_credits_str); 
        $jobcircle_order->save();       
    }
}

// candidate applications package functions

function jobcircle_candidate_applics_pkg_used_credits($order_id) {
    $used_credits_num = 0;
    $jobcircle_order = wc_get_order($order_id);
    if (is_a($jobcircle_order, 'WC_Order')) {
        $used_credits = $jobcircle_order->get_meta('order_cand_application_ids');
        if (!empty($used_credits)) {
            $used_credits_arr = explode(',', $used_credits);
            $used_credits_num = !empty($used_credits_arr) ? sizeof($used_credits_arr) : 0;
        }
    }

    return absint($used_credits_num);
}

function jobcircle_candidate_applics_pkg_remainin_credits($order_id) {
    $jobcircle_order = wc_get_order($order_id);
    if (is_a($jobcircle_order, 'WC_Order')) {
        $total_credits = $jobcircle_order->get_meta('order_numof_applics');
        $used_credits = jobcircle_candidate_applics_pkg_used_credits($order_id);

        $remaining_credits = 0;
        if ($total_credits > $used_credits) {
            $remaining_credits = $total_credits - $used_credits;
        }
    }

    return absint($remaining_credits);
}

function jobcircle_candidate_applics_pkg_expired($order_id) {
    $remainin_credits = jobcircle_candidate_applics_pkg_remainin_credits($order_id);
    if ($remainin_credits <= 0) {
        return true;
    }
}