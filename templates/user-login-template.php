<?php

/**
 * Template Name: User Login
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

get_header();
?>
<div class="gray py-3">
	<div class="container">
		<div class="row">
			<div class="colxl-12 col-lg-12 col-md-12">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?php echo home_url('/') ?>"><?php esc_html_e('Home', 'jobcircle-frame');?></a></li>
						<li class="breadcrumb-item"><a><?php esc_html_e('Pages', 'jobcircle-frame');?></a></li>
						<li class="breadcrumb-item active" aria-current="page"><?php esc_html_e('Login', 'jobcircle-frame');?></li>
					</ol>
				</nav>
			</div>
		</div>
	</div>
</div>
<?php
global $jobcircle_framework_options;
?>
<section class="middle section section-accounts section-theme-1 pt-35 pt-md-50 pt-lg-75 pt-xl-100 pt-xxl-120 pb-35 pb-md-50 pb-lg-75 pb-xl-100 pb-xxl-120">
	<div class="container">
		<div class="row align-items-start justify-content-center">
			<div class="col-12 col-md-6">
				<div class="account-box">


					<span class="icon">
						<img src="<?php echo Jobcircle_Plugin::root_url() ?>/images/user-icon.svg" alt="user">
					</span>


					<div class="account-box-frame">
						<div class="form-head">
							<h2><?php esc_html_e('Hi, Welcome Back!', 'jobcircle-frame');?></h2>
							<p><?php esc_html_e('Enter username and password to log in:', 'jobcircle-frame');?></p>
						</div>
						<form class="p-3 rounded jobcircle-user-form contac-form" method="post">
							<div class="form-group row">
								<div class="col-12 mb-15 mb-md-20">
									<input type="text" name="user_email" class="form-control" placeholder="<?php esc_attr_e('Username/Email*', 'jobcircle-frame');?>" required>
								</div>
								<div class="col-12 mb-15 mb-md-20 form-group jc-mrgn">
									<input type="password" name="user_pass" class="form-control jobcircle-passwordfield" placeholder="<?php esc_attr_e('Password*', 'jobcircle-frame');?>" required>
									<span class="jobcirlce-pass-show jobcircle-togglePassword"><i class="fa fa-eye" aria-hidden="true"></i></span>  
								</div>
								<div class="col-12 col-lg-6 mb-25 form-group">
									<div class="d-flex align-items-center justify-content-between">
										<label class="custom-checkbox mt-5 ms-10">
											<input id="remember_me" class="checkbox-custom" name="remember_me" type="checkbox">
											<span class="fake-checkbox"></span>
											<label for="remember_me" class="checkbox-custom-label"><?php esc_html_e('Remember Me', 'jobcircle-frame');?></label>
										</label>
									</div>
								</div>
								<div class="form-group">
									<div class="form-security-fields" style="display: none;"></div>
									<input type="hidden" name="action" value="jobcircle_user_login_action">
									<div class="col-12">
										<button type="submit" class="btn btn-md full-width theme-bg text-light fs-md ft-medium btn btn-green btn-sm">
											<span class="btn-text"><?php esc_html_e('Login', 'jobcircle-frame');?> </span></button>
									</div>
								</div>
							</div>
						</form>
						<?php
						$facebook_social_login_link = apply_filters('jobcircle_login_social_facebook_btn', '');
						$google_social_login_link = apply_filters('jobcircle_login_social_google_btn', '');
						if ($facebook_social_login_link != '') {
							?>
							<div class="social-login">
								<strong class="title">Login with Social Network</strong>
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
					</div>
				</div>
			</div>

			<div class="col-12 col-md-6">
				<div class="account-box">
					<span class="icon">
						<img src="<?php echo Jobcircle_Plugin::root_url() ?>/images/user-icon.svg" alt="user">
					</span>
					<div class="account-box-frame">
						<div class="form-head">
							<h2><?php esc_html_e('Create Account', 'jobcircle-frame');?></h2>
							<p><?php esc_html_e('Start posting or hiring talents', 'jobcircle-frame');?></p>
						</div>
						<div class="tab-content">
							<div class="tab-pane fade show active" id="nav-tab01">
								<form method="post" class="contac-form jobcircle-user-form">
									<div class="form-fields-group mb-15 mb-md-20">
										<div class="form-group">
											<input type="text" name="first_name" class="form-control" placeholder="<?php esc_attr_e('First Name*', 'jobcircle-frame');?>" required>
										</div>
										<div class="form-group">
											<input type="text" name="last_name" class="form-control" placeholder="<?php esc_attr_e('Last Name*', 'jobcircle-frame');?>" required>
										</div>
									</div>
									<div class="form-fields-group mb-15 mb-md-20">
										<div class="form-group">
											<input type="text" name="username" class="form-control" placeholder="<?php esc_attr_e('Username*', 'jobcircle-frame');?>" required>
										</div>
										<div class="form-group">
											<input type="text" name="user_email" class="form-control" placeholder="<?php esc_attr_e('Email*', 'jobcircle-frame');?>" required>
										</div>
									</div>
									
									<div class="form-group mb-15 mb-md-20 jc-mrgn">
										<input type="password" name="user_pass" class="form-control jobcircle-passwordfield" placeholder="<?php esc_attr_e('Password', 'jobcircle-frame');?>" required>
										<span class="jobcirlce-pass-show jobcircle-togglePassword"><i class="fa fa-eye" aria-hidden="true"></i></span>  
									</div>
									<div class="form-group mb-15 mb-md-20 jc-mrgn">
										<input type="password" name="confirm_pass" class="form-control jobcircle-passwordfield" placeholder="<?php esc_attr_e('Confirm Password', 'jobcircle-frame');?>" required>
										<span class="jobcirlce-pass-show jobcircle-togglePassword"><i class="fa fa-eye" aria-hidden="true"></i></span>  
									</div>

									<?php
									$captcha_switch = isset($jobcircle_framework_options['captcha_switch']) ? $jobcircle_framework_options['captcha_switch'] : '';
									$captcha_sitekey = isset($jobcircle_framework_options['captcha_sitekey']) ? $jobcircle_framework_options['captcha_sitekey'] : '';
									$captcha_secretkey = isset($jobcircle_framework_options['captcha_secretkey']) ? $jobcircle_framework_options['captcha_secretkey'] : '';

									if ($captcha_switch == 'on' && $captcha_sitekey != '' && $captcha_secretkey != '') {
										$recaptcha_id = 'recaptcha_' . rand(10000, 99999);
										?>
										<div class="jobcircle-recaptcha-holdrcon mb-15 mb-md-20" id="<?php echo ($recaptcha_id) ?>_div">
											<?php
											echo jobcircle_recaptcha($recaptcha_id);
											?>
										</div>
										<?php
									}
									?>
									
									<div class="form-group mb-15 mb-md-20">
										<label class="custom-checkbox terms mt-5 ms-10">
											<input type="checkbox" class="jobcircle-terms-checkbox">
											<span class="fake-checkbox"></span>
											<?php jobcircle_terms_and_con_link_txt() ?>
										</label>
									</div>

									<div class="form-group">
										<div class="form-security-fields" style="display: none;"></div>
										<input type="hidden" name="action" value="jobcircle_user_register_action">
										<button type="submit" class="btn btn-green btn-sm"><?php esc_html_e('Register', 'jobcircle-frame');?></button>
									</div>
									
								</form>
							</div>
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
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
get_footer();
