<?php
function jobcircle_account_page()
{
	vc_map(
		array(
			'name' => __('Account Page'),
			'base' => 'jobcircle_account_page',
			'category' => __('Job Circle'),
			'params' => array(

				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Title'),
					'param_name' => 'title',
				),
				//group
				array(
					'type' => 'param_group',
					'value' => '',
					'param_name' => 'candidate_multi',
					'params' => array(

						array(
							'type' => 'jobcircle_browse_img',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Upload Image'),
							'param_name' => 'upld_img',
						),

					),
				),
			),
		)
	);
}
add_action('vc_before_init', 'jobcircle_account_page');
function jobcircle_account_page_frontend($atts, $content)
{

	$atts = shortcode_atts(
		array(

			'title' => '',

			'candidate_multi' => '',
		),
		$atts,
		'jobcircle_account_page'
	);

	$title = isset($atts['title']) ? $atts['title'] : '';

	$custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';

	ob_start();
?>

	<section class="section section-accounts section-theme-1 pt-35 pt-md-50 pt-lg-75 pt-xl-100 pt-xxl-120 pb-35 pb-md-50 pb-lg-75 pb-xl-100 pb-xxl-120">
		<div class="container">
			<div class="row">
				<div class="col-12 col-md-6">
					<div class="account-box">
						<span class="icon">
							<img src="<?php echo Jobcircle_Plugin::root_url() ?>/images/user-icon.svg" alt="user">
						</span>
						<div class="account-box-frame">
							<div class="form-head">
								<h2><?php esc_html_e('Hi, Welcome Back!', 'jobcircle-frame') ?></h2>
								<p><?php esc_html_e('Enter username and password to log in:', 'jobcircle-frame') ?></p>
							</div>
							<form class="contac-form" action="#">
								<div class="row">
									<div class="col-12 mb-15 mb-md-20">
										<input class="form-control" type="email" placeholder="Email Address">
									</div>
									<div class="col-12 mb-15 mb-md-20 ">
										<input class="form-control jobcircle-passwordfield" name="password" type="password" placeholder="Password">
										<i  class="fa-solid fa-eye eyeicon jobcircle-togglePassword" ></i>
									</div>
									<div class="col-12 col-lg-6 mb-25">
										<label class="custom-checkbox mt-5 ms-10">
											<input type="checkbox">
											<span class="fake-checkbox"></span>
											<span class="label-text"><?php esc_html_e('Remember me', 'jobcircle-frame') ?></span>
										</label>
									</div>
									<div class="col-12 col-lg-6 mb-15 mb-md-20 mb-lg-25 text-center text-lg-end">
										<a href="#" class="link mx-10"><?php esc_html_e('Lost Your Password?', 'jobcircle-frame') ?></a>
									</div>
									<div class="col-12">
										<button class="btn btn-green btn-sm"><span class="btn-text"><?php esc_html_e('Login', 'jobcircle-frame') ?></span></button>
									</div>
								</div>
							</form>
							<div class="social-login">
								<strong class="title"><?php esc_html_e('Login with Social Network', 'jobcircle-frame') ?></strong>
								<ul class="social-networks">
									<li><a class="facebook login-social-btn socialogin-with-facebook" href="javascript:;"><img src="<?php echo Jobcircle_Plugin::root_url() ?>/images/facebook-icon.svg" alt="Facebook"></a></li>
									<li><a class="google login-social-btn socialogin-with-google" href="javascript:;"><img src="<?php echo Jobcircle_Plugin::root_url() ?>/images/google-icon.svg" alt="Google"></a></li>
								</ul>
							</div>
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
								<h2><?php esc_html_e('Create Account', 'jobcircle-frame') ?></h2>
								<p><?php esc_html_e('Start posting or hiring talents', 'jobcircle-frame') ?></p>
							</div>
							<ul class="nav form-tabs mb-15 mb-md-20">
								<li>
									<button class="nav-link active" data-bs-toggle="tab" data-bs-target="#nav-tab01" type="button"><?php esc_html_e('Candidates', 'jobcircle-frame') ?></button>
								</li>
								<li>
									<button class="nav-link" data-bs-toggle="tab" data-bs-target="#nav-tab02" type="button"><?php esc_html_e('Employer', 'jobcircle-frame') ?></button>
								</li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane fade show active" id="nav-tab01">
									<form class="contac-form" action="#">
										<div class="row">
											<div class="col-12 mb-15 mb-md-20">
												<input class="form-control" type="text" placeholder="Complete Name">
											</div>
											<div class="col-12 mb-15 mb-md-20">
												<input class="form-control" type="email" placeholder="Email Address">
											</div>
											<div class="col-12 mb-15 mb-md-20">
												<input class="form-control jobcircle-passwordfield" name="password" type="password" placeholder="Password">
												<i  class="fa-solid fa-eye eyeicon jobcircle-togglePassword" ></i>
											</div>
											<div class="col-12 mb-15 mb-md-20">
												<label class="custom-checkbox terms mt-5 ms-10">
													<input type="checkbox">
													<span class="fake-checkbox"></span>
													<span class="label-text"><?php esc_html_e('By hitting the "Register" button, you agree to the ', 'jobcircle-frame') ?>
														<a class="link" href="#"><?php esc_html_e('Terms conditions', 'jobcircle-frame') ?></a><?php esc_html_e(' & ', 'jobcircle-frame') ?><a class="link" href="#"><?php esc_html_e('Privacy Policy', 'jobcircle-frame') ?></a></span>
												</label>
											</div>
											<div class="col-12">
												<button class="btn btn-green btn-sm"><span class="btn-text"><?php esc_html_e('Register', 'jobcircle-frame') ?></span></button>
											</div>
										</div>
									</form>
								</div>
								<div class="tab-pane fade" id="nav-tab02">
									<form class="contac-form" action="#">
										<div class="row">
											<div class="col-12 mb-15 mb-md-20">
												<input class="form-control" type="text" placeholder="Complete Name">
											</div>
											<div class="col-12 mb-15 mb-md-20">
												<input class="form-control" type="email" placeholder="Email Address">
											</div>
											<div class="col-12 mb-15 mb-md-20">
												<input class="form-control jobcircle-passwordfield" name="password"  type="password" placeholder="Password">
												<i  class="fa-solid fa-eye eyeicon jobcircle-togglePassword " ></i>
											</div>
											<div class="col-12 mb-15 mb-md-20">
												<label class="custom-checkbox terms mt-5 ms-10">
													<input type="checkbox">
													<span class="fake-checkbox"></span>
													<span class="label-text"><?php esc_html_e('By hitting the "Register" button, you agree to the', 'jobcircle-frame') ?>
														<a class="link" href="#"><?php esc_html_e('Terms conditions', 'jobcircle-frame') ?></a><?php esc_html_e(' & ', 'jobcircle-frame') ?><a class="link" href="#"><?php esc_html_e('Privacy Policy', 'jobcircle-frame') ?></a></span>
												</label>
											</div>
											<div class="col-12">
												<button class="btn btn-green btn-sm"><span class="btn-text"><?php esc_html_e('Register', 'jobcircle-frame') ?></span></button>
											</div>
										</div>
									</form>
								</div>
							</div>
							<div class="social-login">
								<strong class="title"><?php esc_html_e('Login with Social Network', 'jobcircle-frame') ?></strong>
								<ul class="social-networks">
									<li><a class="facebook" href="#"><img src="<?php echo Jobcircle_Plugin::root_url() ?>/images/facebook-icon.svg" alt="Facebook"></a></li>
									<li><a class="google" href="#"><img src="<?php echo Jobcircle_Plugin::root_url() ?>/images/google-icon.svg" alt="Google"></a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php
	return ob_get_clean();
}
add_shortcode('jobcircle_account_page', 'jobcircle_account_page_frontend');
