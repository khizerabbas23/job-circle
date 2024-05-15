<?php

/**
 * Template Name: Post New Job Regular
 */
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (is_user_logged_in()) {
	$user_id = get_current_user_id();
	$employer_id = jobcircle_user_employer_id($user_id);

	if (!$employer_id) {
		wp_redirect(home_url('/'));
		die;
	}
}

wp_enqueue_style('jobcircle-dashboard-main');
get_header();

?>
<div class="jobcircle-site-wrapper">
	<div class="space-top-footer"></div>
	<div class="space-top-footer"></div>
	<div class="container">
		
		<?php jobcircle_employer_job_form() ?>

	</div>

</div>

<?php get_footer() ?>