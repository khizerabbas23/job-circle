<?php

/**
 * Template Name: Post New Job
 */
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

get_header();
global $jobcircle_framework_options, $current_user;

$footer_text = isset($jobcircle_framework_options['jobcircle-footer-copyright-text']) ? $jobcircle_framework_options['jobcircle-footer-copyright-text'] : '';
?>
<div class="jobcircle-section-tbpading bg-light">

	<div class="container">
		<div class="dashboard-tlbar d-block mb-5">
			<div class="row">
				<div class="colxl-12 col-lg-12 col-md-12">
					<h1 class="ft-medium"><?php esc_html_e('Post A New Job', 'jobcircle-frame');?></h1>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item text-muted"><a href="<?php echo home_url('/') ?>"><?php esc_html_e('Home', 'jobcircle-frame');?></a></li>
							<li class="breadcrumb-item"><a class="theme-cl"><?php esc_html_e('Post Job', 'jobcircle-frame');?></a></li>
						</ol>
					</nav>
				</div>
			</div>
		</div>

		<?php jobcircle_employer_job_form() ?>

		<!-- footer -->
		<div class="row">
			<div class="col-md-12">
				<div class="py-3"><?php echo ($footer_text) ?></div>
			</div>
		</div>

	</div>

</div>

</div>
<?php wp_footer() ?>
</body>

</html>