<?php

defined('ABSPATH') || exit;

class Jobcircle_Login_Register_Markup
{

    public function __construct() {
        add_action('wp_footer', array($this, 'signin_popup_form'), 10);
    }

    public function signin_popup_form() {
        if (!is_user_logged_in()) {
            global $jobcircle_framework_options;
            ?>
            <div class="modal jobcircle-userlogin-popup fade" id="login" tabindex="-1" role="dialog" aria-labelledby="loginmodal" aria-hidden="true">
				<div class="modal-dialog login-pop-form" role="document">
					<div class="modal-content" id="loginmodal">
						<div class="modal-headers">
							<a href="javascript:;" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></a>
						</div>
					
						<div class="modal-body p-5 account-box popup-loginsec-con">
							<div class="text-center mb-4">
								<h4 class="m-0 ft-regular"><?php esc_html_e('Login', 'jobcircle-frame');?></h4>
							</div>
							
							<form method="post" class="jobcircle-user-form">				
								<div class="form-group">
									<label><?php esc_html_e('Username/Email', 'jobcircle-frame');?></label>
									<input type="text" name="user_email" class="form-control" placeholder="<?php esc_attr_e('Username/Email*', 'jobcircle-frame');?>" required>
								</div>
								
								<div class="form-group">
									<label><?php esc_html_e('Password', 'jobcircle-frame');?></label>
									<input type="password" name="user_pass" class="form-control jobcircle-passwordfield" placeholder="<?php esc_attr_e('Password*', 'jobcircle-frame');?>" required>
                                    <span class="jobcirlce-pass-show jobcircle-togglePassword"><i class="fa fa-eye" aria-hidden="true"></i></span>                                    
								</div>
								
								<div class="form-group">
									<div class="d-flex align-items-center justify-content-between">
										<div class="flex-1">
											<input id="remember_me" class="checkbox-custom" name="remember_me" type="checkbox">
											<label for="remember_me" class="checkbox-custom-label"><?php esc_html_e('Remember Me', 'jobcircle-frame');?></label>
										</div>	
										<div class="eltio_k2">
											<a href="javascript:;" class="theme-cl jobcircle-frgtpass-btn"><?php esc_html_e('Lost Your Password?', 'jobcircle-frame');?></a>
										</div>	
									</div>
								</div>
								
								<div class="form-group text-center">
                                    <div class="form-security-fields" style="display: none;"></div>
                                    <input type="hidden" name="action" value="jobcircle_user_login_action">
									<button type="submit" class="jobcircle-formsubmit-btn"><?php esc_html_e('Login', 'jobcircle-frame');?></button>
								</div>
								
								<div class="form-group text-center mb-0">
									<p class="extra"><?php esc_html_e('Not a member?', 'jobcircle-frame');?> <a href="#" class="text-dark login-to-regconv"> <?php esc_html_e('Register', 'jobcircle-frame');?></a></p>
								</div>
                                <?php
                                $facebook_social_login_link = apply_filters('jobcircle_login_social_facebook_btn', '');
                                $google_social_login_link = apply_filters('jobcircle_login_social_google_btn', '');
                                if ($facebook_social_login_link != '') {
                                    ?>
                                    <div class="social-login">
                                        <strong class="title"><?php esc_html_e('Login with Social Network', 'jobcircle-frame');?></strong>
                                        <ul class="social-networks">
                                            <?php
                                            if ($facebook_social_login_link != '') {
                                                ?>
                                                <li>
                                                    <?php echo ($facebook_social_login_link) ?>
                                                </li>
                                                <?php
                                            }
                                            if ($google_social_login_link != '') {
                                                ?>
                                                <li>
                                                    <?php echo ($google_social_login_link) ?>
                                                </li>
                                                <?php
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                    <?php
                                }
                                ?>
							</form>
						</div>
					
                        <div class="modal-body p-5 account-box popup-signupsec-con" style="display: none;">
                            <div class="text-center mb-4">
                                <h4 class="m-0 ft-regular"><?php esc_html_e('Register', 'jobcircle-frame');?></h4>
                            </div>
                            
                            <form method="post" class="jobcircle-user-form">	
                                <div class="form-fields-group">
                                    <div class="form-group">
                                        <label><?php esc_html_e('First Name', 'jobcircle-frame');?></label>
                                        <input type="text" name="first_name" class="form-control" placeholder="<?php esc_attr_e('First Name*', 'jobcircle-frame');?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label><?php esc_html_e('Last Name', 'jobcircle-frame');?></label>
                                        <input type="text" name="last_name" class="form-control" placeholder="<?php esc_attr_e('Last Name*', 'jobcircle-frame');?>" required>
                                    </div>
                                </div>
                                <div class="form-fields-group">
                                    <div class="form-group">
                                        <label><?php esc_html_e('Username', 'jobcircle-frame');?></label>
                                        <input type="text" name="username" class="form-control" placeholder="<?php esc_attr_e('Username*', 'jobcircle-frame');?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label><?php esc_html_e('Email', 'jobcircle-frame');?></label>
                                        <input type="text" name="user_email" class="form-control" placeholder="<?php esc_attr_e('Email*', 'jobcircle-frame');?>" required>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label><?php esc_html_e('Password', 'jobcircle-frame');?></label>
                                    <input type="password" name="user_pass" class="form-control jobcircle-passwordfield" placeholder="<?php esc_attr_e('Password*', 'jobcircle-frame');?>" required>
                                    <span class="jobcirlce-pass-show jobcircle-togglePassword"><i class="fa fa-eye" aria-hidden="true"></i></span>
                                </div>
                                <div class="form-group">
                                    <label><?php esc_html_e('Confirm Password', 'jobcircle-frame');?></label>
                                    <input type="password" name="confirm_pass" class="form-control jobcircle-passwordfield" placeholder="<?php esc_attr_e('Password*', 'jobcircle-frame');?>" required>
                                    <span class="jobcirlce-pass-show jobcircle-togglePassword"><i class="fa fa-eye" aria-hidden="true"></i></span>
                                </div>
                                <?php
                                $captcha_switch = isset($jobcircle_framework_options['captcha_switch']) ? $jobcircle_framework_options['captcha_switch'] : '';
                                $captcha_sitekey = isset($jobcircle_framework_options['captcha_sitekey']) ? $jobcircle_framework_options['captcha_sitekey'] : '';
                                $captcha_secretkey = isset($jobcircle_framework_options['captcha_secretkey']) ? $jobcircle_framework_options['captcha_secretkey'] : '';

                                if ($captcha_switch == 'on' && $captcha_sitekey != '' && $captcha_secretkey != '') {
                                    $recaptcha_id = 'recaptcha_' . rand(10000, 99999);
                                    ?>
                                    <div class="jobcircle-recaptcha-holdrcon" id="<?php echo ($recaptcha_id) ?>_div">
                                        <?php
                                        echo jobcircle_recaptcha($recaptcha_id);
                                        ?>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="form-group text-center">
                                    <div class="form-security-fields" style="display: none;"></div>
                                    <input type="hidden" name="action" value="jobcircle_user_register_action">
                                    <button type="submit" class="jobcircle-formsubmit-btn"><?php esc_html_e('Register', 'jobcircle-frame');?></button>
                                </div>
                                
                                <div class="form-group text-center mb-0">
                                    <p class="extra"><?php esc_html_e('Already have an account?', 'jobcircle-frame');?> <a href="#" class="text-dark reg-to-loginconv"> <?php esc_html_e('Login', 'jobcircle-frame');?></a></p>
                                </div>
                                <?php
                                $facebook_social_login_link = apply_filters('jobcircle_login_social_facebook_btn', '');
                                $google_social_login_link = apply_filters('jobcircle_login_social_google_btn', '');
                                if ($facebook_social_login_link != '') {
                                    ?>
                                    <div class="social-login">
                                        <strong class="title"><?php esc_html_e('Login with Social Network', 'jobcircle-frame');?></strong>
                                        <ul class="social-networks">
                                            <?php
                                            if ($facebook_social_login_link != '') {
                                                ?>
                                                <li>
                                                    <?php echo ($facebook_social_login_link) ?>
                                                </li>
                                                <?php
                                            }
                                            if ($google_social_login_link != '') {
                                                ?>
                                                <li>
                                                    <?php echo ($google_social_login_link) ?>
                                                </li>
                                                <?php
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                    <?php
                                }
                                ?>
                            </form>
                        </div>
                        
                        <div class="modal-body p-5 popup-frgt-pass" style="display: none;">
                            <div class="text-center mb-4">
                                <h4 class="m-0 ft-regular"><?php esc_html_e('Lost Your Password', 'jobcircle-frame');?></h4>
                            </div>                            
                            <form method="POST" class="jobcircle-user-form">				
                                <div class="form-group">
                                    <label><?php esc_html_e('Email', 'jobcircle-frame');?></label>
                                    <input type="email" name="email" class="form-control" placeholder="<?php esc_attr_e('Email*', 'jobcircle-frame');?>" required>
                                </div>
								<div class="form-group text-center">
                                    <div class="form-security-fields" style="display: none;"></div>
                                    <input type="hidden" name="action" value="jobcircle_user_forget_password_action">
									<button type="submit" class="jobcircle-formsubmit-btn" name="submit"><?php esc_html_e('Submit', 'jobcircle-frame');?></button>
								</div>
                                <div class="form-group text-center mb-0">
                                    <p class="extra"><a href="#" class="text-dark reg-to-loginconv"> <?php esc_html_e('Login Account?', 'jobcircle-frame');?></a></p>
                                </div>
                            </form>
                        </div>

                        <?php
                        if(!empty($_GET['jobcircle_user_action']) && 
                        !empty($_GET['key']) && 
                        !empty($_GET['login']) && 
                        $_GET['jobcircle_user_action'] == 'reset_password'){
                            $jobcircle_user_login   = !empty($_GET['login']) ? sanitize_text_field($_GET['login']) : '';
                            $jobcircle_reset_pass_transient = get_transient( 'jobcircle_reset_pass_transient_'.$jobcircle_user_login );
                            //$jobcircle_user_login =!empty($jobcircle_reset_pass_transient['user_login']) ? $jobcircle_reset_pass_transient['user_login'] : ''; 
                            ?>                            
                            <div class="modal-body p-5 popup-pass-reset-form" style="display: none;">
                                <div class="text-center mb-4">
                                    <h4 class="m-0 ft-regular"><?php esc_html_e('Reset Password', 'jobcircle-frame');?></h4>
                                </div>
                                <form method="POST" class="jobcircle-user-form">
                                    <?php 
                                    if($jobcircle_user_login && !empty($jobcircle_reset_pass_transient['status']) && $jobcircle_reset_pass_transient['status'] == 'success'){
                                        ?>
                                        <div class="form-group">
                                            <label><?php esc_html_e('Password', 'jobcircle-frame');?></label>
                                            <input type="password" name="user_pass" class="form-control jobcircle-passwordfield" placeholder="<?php esc_attr_e('Password*', 'jobcircle-frame');?>" required>
                                            <span class="jobcirlce-pass-show jobcircle-togglePassword"><i class="fa fa-eye" aria-hidden="true"></i></span>
                                        </div>
                                        <div class="form-group">
                                            <label><?php esc_html_e('Confirm Password', 'jobcircle-frame');?></label>
                                            <input type="password" name="confirm_pass" class="form-control jobcircle-passwordfield" placeholder="<?php esc_attr_e('Password*', 'jobcircle-frame');?>" required>
                                            <span class="jobcirlce-pass-show jobcircle-togglePassword"><i class="fa fa-eye" aria-hidden="true"></i></span>
                                        </div>
                                        <div class="form-group text-center">
                                            <div class="form-security-fields" style="display: none;"></div>
                                            <input type="hidden" name="action" value="jobcircle_user_reset_password_action">
                                            <input type="hidden" name="user_login" value="<?php echo esc_attr($jobcircle_user_login);?>">
                                            <button type="submit" class="jobcircle-formsubmit-btn" name="submit"><?php esc_html_e('Submit', 'jobcircle-frame');?></button>
                                        </div>
                                        <?php 
                                    } else {
                                        $jobcircle_msg =!empty($jobcircle_reset_pass_transient['msg']) ? !empty($jobcircle_reset_pass_transient['msg']) : '';
                                        ?>
                                        <div class="form-group">
                                            <label><?php echo esc_html($jobcircle_msg);?></label>
                                        </div>
                                        <div class="form-group text-center mb-0">
                                            <p class="extra"><a href="#" class="text-dark jobcircle-frgtpass-btn"> <?php esc_html_e('Lost Your Password?', 'jobcircle-frame');?></a></p>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </form>
                            </div>
                            <?php 
                            $jobcircle_inline_script = "
                            jQuery(document).ready(function () {
                                if(jQuery('.popup-pass-reset-form').length > 0) {
                                    var reg_con_holder = jQuery('.popup-signupsec-con');
                                    var log_con_holder = jQuery('.popup-loginsec-con');
                                    var frgtpass_con_holder = jQuery('.popup-frgt-pass');
                                    var resetpass_con_holder = jQuery('.popup-pass-reset-form');
                                    reg_con_holder.hide();
                                    frgtpass_con_holder.hide();
                                    log_con_holder.hide();
                                    resetpass_con_holder.slideDown();
                                    jQuery('#login').modal('show');
                                }
                            });
                            ";                            
                            wp_add_inline_script( 'jobcircle-custom-scripts', $jobcircle_inline_script, 'after' );
                        }?>
					</div>
				</div>
			</div>
            <?php           
        }
    }
}

new Jobcircle_Login_Register_Markup;