<?php

/**
 * Template Name: User Dashboard
 */

wp_enqueue_style('jobcircle-bootstrap');
wp_enqueue_style('jobcircle-bootstrap-modal');
wp_enqueue_style('jobcircle-datetimepicker');
wp_enqueue_style('jobcircle-dashboard-gfont');
wp_enqueue_style('jobcircle-dashboard-bootstrap');
wp_enqueue_style('jobcircle-bootstrap-modal');
wp_enqueue_style('jobcircle-dashboard-fontawesome');
wp_enqueue_style('jobcircle-dashboard-flatpickr');
wp_enqueue_style('jobcircle-dashboard-mainstyle');
wp_enqueue_style('jobcircle-dashboard-common');
wp_enqueue_style('jobcircle-dashboard-custom');

get_header();

wp_enqueue_script('jobcircle-bootstrap.min');
wp_enqueue_script('jobcircle-datetimepicker-full');
wp_enqueue_script('jobcircle-dashboard-jqueryui');
wp_enqueue_script('jobcircle-dashboard-mainscript');
wp_enqueue_script('jobcircle-custom-scripts');
wp_enqueue_script('jobcircle-dashboard-common');



global $jobcircle_framework_options, $current_user;

$jobcircle_user_switch_account = isset($jobcircle_framework_options['user_switch_account']) ? $jobcircle_framework_options['user_switch_account'] : '';
$footer_text = isset($jobcircle_framework_options['jobcircle-footer-copyright-text']) ? $jobcircle_framework_options['jobcircle-footer-copyright-text'] : '';

$account_page_name = isset($jobcircle_framework_options['user_dashboard_page']) ? $jobcircle_framework_options['user_dashboard_page'] : '';

$account_page_id = jobcircle_get_page_id_from_name($account_page_name);

$account_page_url = home_url('/');
if ($account_page_id > 0) {
	$account_page_url = get_permalink($account_page_id);
}

$user_id = get_current_user_id();
$display_name = $current_user->display_name;

$post_type_ext = '';

$candidate_id = jobcircle_user_candidate_id($user_id);
$employer_id = jobcircle_user_employer_id($user_id);
if ($candidate_id) {
	$display_name = get_the_title($candidate_id);
	$account_tabs = jobcircle_candidate_account_menu_items();
	$post_type_ext = 'candidate_';
} else if ($employer_id) {
	$display_name = get_the_title($employer_id);
	$account_tabs = jobcircle_employer_account_menu_items();
	$post_type_ext = 'employer_';
}

$default_tab = 'profile';

$general_tabs = jobcircle_general_account_menu_items();
$overall_tabs = $general_tabs;
if ($candidate_id || $employer_id) {
	$overall_tabs += $account_tabs;
	$default_tab = 'dashboard';
}
// echo '<pre>';
// var_dump($overall_tabs);
// echo '</pre>';

$current_tab = isset($_GET['account_tab']) && $_GET['account_tab'] != '' && isset($overall_tabs[$_GET['account_tab']]) ? $_GET['account_tab'] : $default_tab;
?>
<div class="main-content">

	<div class="sidebar-wrapper">
		<div id="sidebar" class="sidebar sidebar-collapse">
			<div class="sidebar__menu-group">
				<?php
				if ($candidate_id || $employer_id) {
				?>
					<ul class="sidebar_nav">
						<?php foreach ($account_tabs as $acc_tab_key => $acc_tab) { ?>
							<?php if (isset($acc_tab['status']) && ($acc_tab['status'] == 'enabled')) : ?>
								<li <?php echo ($current_tab == $acc_tab_key) ? ' class="tab-active"' : '' ?>>
									<a href="<?php echo add_query_arg(array('account_tab' => $acc_tab_key), $account_page_url) ?>">
										<span class="nav-icon"><i class="<?php echo ($acc_tab['icon']) ?>"></i></span>
										<span class="menu-text"><?php echo ($acc_tab['title']) ?></span>
									</a>
								</li>
							<?php else : ?>
								<li class="disabled">
									<a>
										<span class="nav-icon"><i class="fa fa-lock<?php //echo ($acc_tab['icon']) 
																					?>"></i></span>
										<span class="menu-text"><?php echo ($acc_tab['title']) ?></span>
									</a>
								</li>
							<?php endif; ?>
						<?php } ?>
					</ul>
				<?php
				}
				?>
				<ul class="sidebar_nav profile-menu">
					<?php
					foreach ($general_tabs as $acc_tab_key => $acc_tab) {
					?>
						<li<?php echo ($current_tab == $acc_tab_key) ? ' class="tab-active"' : '' ?>><a href="<?php echo add_query_arg(array('account_tab' => $acc_tab_key), $account_page_url) ?>"><span class="nav-icon"><i class="<?php echo ($acc_tab['icon']) ?>"></i></span> <span class="menu-text"><?php echo ($acc_tab['title']) ?></span></a></li>
						<?php
					}

					if($jobcircle_user_switch_account == 'on'){
						$jobcircle_user_account_type	= jobcircle_user_account_type($user_id);
						if(!empty($jobcircle_user_account_type)){
							if (jobcircle_user_account_type($user_id) == 'candidate') {
								$jobcircle_switch_title	= esc_html__('Switch To  Employer', "jobcircle");
							} else {
								$jobcircle_switch_title	= esc_html__('Switch To  Candidate', "jobcircle");
							}
							?>
							<li><a href="javascript:void(0);" class="jobcircle-user-switchaccount" title="<?php echo esc_attr($jobcircle_switch_title);?>"><span class="nav-icon"><i class="fa fa-power-off"></i></span> <span class="menu-text"><?php echo esc_html($jobcircle_switch_title);?></span></a></li>
							<?php
						}
					}
					?>
					<li><a href="javascript:void(0);" class="jobcircle-user-delaccount"><span class="nav-icon"><i class="fa fa-trash-o"></i></span> <span class="menu-text"><?php esc_html_e('Delete Account', 'jobcircle-frame');?></span></a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="contents">
		<div class="content-container">
			<div class="subvisual-block">
				<div class="visual-content">
					<div class="textbox">
						<ul class="breadcrumbs">
							<li><a href="<?php echo home_url('/') ?>"><?php esc_html_e('Home', 'jobcircle-frame');?></a></li>
							<span>|</span>
							<?php
							if (($candidate_id || $employer_id) && $current_tab != 'dashboard') {
							?>
								<li><a href="<?php echo ($account_page_url) ?>"><?php esc_html_e('Dashboard', 'jobcircle-frame');?></a></li>
								<span>|</span>
							<?php
							}
							?>
							<li class="active"><?php echo ($overall_tabs[$current_tab]['title']) ?></li>
						</ul>
						<h5 class="breadcrumbs-heading">
							<?php printf(esc_html__('Hello, %s', 'jobcircle-frame'), $display_name) ?></h5>
					</div>
				</div>
			</div>

			<?php
			if ($candidate_id) {
				$tab_html = jobcircle_dashb_candidate_dashboard();
			} else if ($employer_id) {
				$tab_html = jobcircle_dashb_employer_dashboard();
			} else {
				$tab_html = jobcircle_dashb_general_profile();
			}
			$tab_hook_name = str_replace(array('-'), array('_'), $current_tab);
			echo apply_filters("jobcircle_dashboard_{$post_type_ext}{$tab_hook_name}_html", $tab_html, $overall_tabs);
			?>
		</div>

		<footer class="footer-wrapper expanded">
			<div class="footer-wrapper__inside">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">
							<div class="footer-copyright">
								<p><?php echo ($footer_text) ?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</footer>

	</div>
</div>
</div>
<?php wp_footer() ?>
</body>

</html>