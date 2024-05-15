<?php
function jobcircle_grid_list()
{
	vc_map(
		array(
			'name' => __('Grid Job'),
			'base' => 'jobcircle_grid_list',
			'category' => __('Job Circle'),
			'params' => array(
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Order By'),
					'param_name' => 'orderby',
				),
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Number Of Post'),
					'param_name' => 'numofpost',
				),
			),
		)
	);
}
add_action('vc_before_init', 'jobcircle_grid_list');
add_action('wp_head', function () {
?>
	<style>
		.jobcircle-loder-con {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background-color: #ffffffc4;
			z-index: 15;
		}

		.jobcircle-loder-con.jobcircle-frm-ploadr {
			position: fixed;
		}

		.jobcircle-loder-iner {
			display: flex;
			width: 60px;
			height: 100%;
			margin: 0 auto;
			align-items: center;
		}

		.jobcircle-loader {
			border: 10px solid #f3f3f3;
			border-radius: 50%;
			border-top: 10px solid #17b67c;
			width: 60px;
			height: 60px;
			-webkit-animation: spin 1s linear infinite;
			/* Safari */
			animation: spin 1s linear infinite;
		}

		/* Safari */
		@-webkit-keyframes spin {
			0% {
				-webkit-transform: rotate(0deg);
			}

			100% {
				-webkit-transform: rotate(360deg);
			}
		}

		@keyframes spin {
			0% {
				transform: rotate(0deg);
			}

			100% {
				transform: rotate(360deg);
			}
		}
	</style>
	<?php
});
// popular category frontend
function jobcircle_grid_list_frontend($atts, $content)
{
	$atts = shortcode_atts(
		array(
			'orderby' => '',
			'numofpost' => '',
		),
		$atts,
		'jobcircle_grid_list'
	);
	$orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
	$numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
	wp_enqueue_script('jobcircle-jobfunctions');
	?>
	<!-- Featured Jobs Section -->
	<main class="main">
		<!-- Featured Jobs Section -->
		<section class="section section-categories pt-35 pt-md-50 pt-lg-75 pt-xl-95 pb-35 pb-md-50 pb-xl-75">
			<div class="container">
				<div class="jobcircle-all-listing-con">
					<div class="row">
						<div class="col-12 col-lg-4">
							<div class="d-flex align-items-center justify-content-between d-lg-none mb-25 filters-head">
								<h2 class="h5"><?php esc_html_e('Filters', 'jobcircle-frame') ?></h2>
								<a href="#" class="filters-opener"><span></span></a>
							</div>
							<!-- Filters Sidebar -->
							<aside class="filters-sidebar bg-light-gray">
								<?php
								$user = wp_get_current_user();
								$disabled = '';
								$email = '';
								if ($user->ID > 0) {
									$email = $user->user_email;
									$disabled = ' disabled="disabled"';
								}
								?>
								<div class="filter-box">
									<h2 class="h5"><?php esc_html_e('Email me new jobs', 'jobcircle-frame') ?></h2>
									<div class="form-group search-field">
										<input class="form-control" name="alerts_name" placeholder="<?php esc_html_e('Job alert name...', 'jobcircle-frame') ?>" type="text">
									</div>
									<div class="form-group">
										<input class="form-control" name="alerts_email" placeholder="example@email.com" type="email" value="<?php echo esc_html($email); ?>" <?php echo esc_html($disabled); ?>>
									</div>
									<div class="form-group">
										<div class="checkbox-limit">
											<ul class="checkbox-list">
												<?php
												$frequencies = array(
													'frequency_daily' => 'Daily',
													'frequency_weekly' => 'Weekly',
													'frequency_fortnightly' => 'Fortnightly',
													'frequency_monthly' => 'Monthly',
													'frequency_biannually' => 'Biannually',
													'frequency_annually' => 'Annually',
													'frequency_never' => 'Never',
												);
												$rand_id = rand(10000000, 99999999);
												foreach ($frequencies as $frequency => $label) { ?>
													<li>
														<label class="custom-checkbox">
															<input id="cat-<?php echo esc_html($rand_id); ?>" name="job_frequency" value="<?php echo esc_html($frequency); ?>" type="checkbox" <?php echo esc_html($frequency) == 'frequency_hourly' ? "checked" : "" ?>>
															<span class="fake-checkbox"></span>
															<span class="label-text"><?php echo esc_html($label); ?></span>
														</label>
													</li>
												<?php } ?>
											</ul>
											<a class="btn btn-primary btn-sm buttonShowMore jobcircle-alertfilter-btn">
												<span class="btn-text"><?php esc_html_e('Create Alert', 'jobcircle-frame') ?></span>
											</a>
										</div>
									</div>
								</div>
								<form method="post" class="jobcircle-jobfilter-form">
									<!-- Filter Box -->
									<div class="filter-box">
										<h2 class="h5"><?php esc_html_e('Search', 'jobcircle-frame') ?></h2>
										<div class="form-group search-field">
											<input class="form-control" name="keyword" placeholder="<?php esc_html_e('Search with keyword', 'jobcircle-frame') ?>" type="text">
											<button class="button-search"><i class="jobcircle-icon-search icon"></i></button>
										</div>
									</div>
									<div class="filter-box">
										<h2 class="h5"><?php esc_html_e('Location', 'jobcircle-frame') ?></h2>
										<div class="form-group search-field">
											<input class="form-control jobcircle-location-input-field" name="location" placeholder="<?php esc_html_e('Enter any location', 'jobcircle-frame') ?>" type="text">
										</div>
									</div>
									<!-- Filter Box -->
									<div class="filter-box">
										<h2 class="h5"><?php esc_html_e('Categories', 'jobcircle-frame') ?></h2>
										<div class="form-group">
											<div class="checkbox-limit">
												<ul class="checkbox-list">
													<?php
													$cat_terms = get_terms(
														array(
															'taxonomy' => 'job_category',
														)
													);
													if (!empty($cat_terms)) {
														foreach ($cat_terms as $cat_term) {
													?>
															<li>
																<label class="custom-checkbox">
																	<input id="cat-<?php echo esc_html($cat_term->term_id) ?>" name="job_category" value="<?php echo esc_html($cat_term->slug) ?>" type="checkbox">
																	<span class="fake-checkbox"></span>
																	<span class="label-text">
																		<?php echo esc_attr($cat_term->name) ?>
																	</span>
																</label>
															</li>
														<?php
														}
														?>
												</ul>
												<a href="#" class="btn btn-primary btn-sm buttonShowMore">
													<span class="btn-text"><?php esc_html_e('Show', 'jobcircle-frame') ?>
														<span class="show"><?php esc_html_e('More', 'jobcircle-frame') ?></span>
														<span class="hide"><?php esc_html_e('Show', 'jobcircle-frame') ?></span>
													</span>
												</a>
											</div>
										</div>
									</div>
									<div class="filter-box">
										<a class="filter-box-head" data-bs-toggle="collapse" href="#collapseType">
											<h2 class="h5"><?php esc_html_e('Job Type', 'jobcircle-frame') ?></h2>
											<span class="collapse-icon"></span>
										</a>
										<div class="collapse show" id="collapseType">
											<div class="form-group">
												<div class="checkbox-limit">
													<ul class="checkbox-list">
														<?php
														$job_types_lists = jobcircle_job_types_list();
														if (!empty($job_types_lists)) {
															foreach ($job_types_lists as $job_type_key => $job_types_list) {
														?>
																<li>
																	<label class="custom-checkbox">
																		<input type="checkbox" name="job_type" value="<?php echo esc_html($job_type_key); ?>">
																		<span class="fake-checkbox"></span>
																		<span class="label-text"><?php echo esc_html($job_types_list['title']); ?></span>
																	</label>
																</li>
														<?php
															};
														} ?>
													</ul>
												</div>
											</div>
										</div>
									</div>
									<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
									<script>
										$(document).ready(function() {
											$('.buttonToggle').on('click', function(e) {
												e.preventDefault();
												var $hiddenCategories = $('.checkbox-list li.hidden');
												$hiddenCategories.toggleClass('hidden');
												var buttonText = $(this).find('.btn-text');
												buttonText.find('.show, .hide').toggle();
											});
										});
									</script>
									<!-- Filter Box -->
									<div class="filter-box">
										<h2 class="h5"><?php esc_html_e('Price Range', 'jobcircle-frame') ?></h2>
										<div class="price-inputs">
											<input type="text" id="amount-start" name="min_salary" class="form-control" readonly placeholder="Form" value="">
											<input type="text" id="amount-end" name="max_salary" class="form-control" readonly placeholder="To" value="">
										</div>
										<div class="range-box">
											<div id="slider-range"></div>
										</div>
									</div>
									<?php
														$view = isset($_REQUEST['view']) ? $_REQUEST['view'] : '';   ?>

									<div class="filter-buttons">
										<input type="hidden" name="numposts" value="<?php echo esc_html($numofpost); ?>">
										<input type="hidden" name="orderby" value="<?php echo esc_html($orderby); ?>">
										<input type="hidden" name="view" value="<?php echo esc_html($view); ?>">
										<input type="hidden" name="action" value="jobcircle_simple_job_filters_submit_call_grid"><button type="submit" class="btn btn-primary btn-sm"><span class="btn-text submit-filters-button"><?php esc_html_e('Filter', 'jobcircle-frame') ?></span></button>
										<a href="#" class="btn btn-text btn-sm"><?php esc_html_e('Reset all filters', 'jobcircle-frame') ?></a>
									</div>
								</form>
							</aside>
						</div>
						<div class="col-12 col-lg-8">
							<?php
														$posts = get_posts([
															'post_type' => 'jobs',
															'post_status' => 'publish',
															'numberposts' => -1
														]);
														$job_count = count($posts);
														$numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
							?>
							<header class="page-subheader mb-30 mb-md-40 d-lg-flex align-items-center justify-content-between">
								<?php if (!empty($job_count)) {  ?>
									<h1 class="h4 mb-25 mb-lg-0"><?php esc_html_e('Showing 1 to', 'jobcircle-frame') ?>
										<?php echo esc_html($numofpost); ?> <?php esc_html_e('of', 'jobcircle-frame') ?>
										<?php echo esc_html($job_count); ?> <?php esc_html_e('jobs', 'jobcircle-frame') ?>
									</h1>
								<?php }  ?>
								<div class="subhead-filters">
									<form id="jobForm" class="form-group d-lg-flex align-items-center" method="get">
										<select class="select2" name="sortby" data-placeholder="<?php esc_html_e('Sort by', 'jobcircle-frame') ?>" onchange="submitForm()">
											<option value="recent"><?php esc_html_e('Recent Jobs', 'jobcircle-frame') ?></option>
											<option value="asc" <?php echo isset($_GET['sortby']) && $_GET['sortby'] == 'asc' ? 'selected' : ''; ?>><?php esc_html_e('Sort by Name', 'jobcircle-frame') ?></option>
										</select>
									</form>
								</div>
							</header>
							<div class="row justify-content-center jobcircle-alljobs-list">
								<?php echo jobcircle_jobs_simple_grid($atts);	?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php
		$output = ob_get_clean();
		return $output;
	}
}
add_shortcode('jobcircle_grid_list', 'jobcircle_grid_list_frontend');
function jobcircle_jobs_simple_grid($atts)
{
	ob_start();
	$numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
	$orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
	$page_numbr = get_query_var('paged');
	$order = "DESC";
	if (isset($_GET['sortby']) && $_GET['sortby'] == 'asc') {
		$orderby = 'title';
		$order = 'ASC';
	}
	$args = jobcircle_listing_jobs_query_args($atts);
	// meta query
	// Custom query.// also this one 
	$query = new WP_Query($args);
	$total_posts = $query->found_posts;
	// Check that we have query results.
	if ($query->have_posts()) {
		// Start looping over the query results.
		while ($query->have_posts()) {
			$query->the_post();
			global $post;
			$postid = $post->ID;
			$posted = get_the_time('U');
			$minut = human_time_diff($posted, current_time('U')) . " ago";
			$title = get_the_title($postid);
			$permalinkget = get_the_permalink($postid);
			$social_media = get_post_meta($postid, 'social_media', true);
			$content = get_the_content();
			$excerpt = get_the_excerpt($postid);
			$vacancies = get_post_meta($postid, 'vacancies', true);
			$job_salary = jobcircle_job_salary_str($postid);
			$job_img_url = jobcircle_job_thumbnail_url($postid);
			$job_location = jobcircle_post_location_str($postid);
			$categories = get_the_terms($postid, 'job_category');
			$skills = wp_get_post_terms($postid, 'job_skill');
			global $current_user;
			$user_id = $current_user->ID;
			$fav_jobs = get_user_meta($user_id, 'fav_jobs_list', true);
			$fav_jobs = !empty($fav_jobs) ? $fav_jobs : array();
			$like_btn_class = 'jobcircle-favjab-btn';
			if (!is_user_logged_in()) {
				$like_btn_class = 'jobcircle-favjab-btn no-user-follower-btn';
			} else {
				if (!jobcircle_user_candidate_id($user_id)) {
					$like_btn_class = 'jobcircle-favjab-btn no-member-follower-btn';
				}
			}
			$fav_icon_class = 'profile-btn';
			$follow = 'fa fa-heart-o';
			if (in_array($post, $fav_jobs)) {
				$like_btn_class = 'jobcircle-alrdy-favjab';
				$fav_icon_class = 'profile-btn';
				$follow = 'fa fa-heart';
			}
			?>
			<div class="col-12 mb-15 mb-md-30">
				<!-- Featured Box -->
				<article class="featured-box">
					<a href="" class="pin-job <?php echo esc_html($like_btn_class); ?> " data-id="<?php echo esc_html($postid); ?>"><i class=" <?php echo esc_html($fav_icon_class); ?> position-absolute <?php echo esc_html($follow); ?>"></i></a>
					<div class="textbox">
						<?php if (!empty($permalinkget) && !empty($title)) { ?>
							<h3 class="h4"><a href="<?php echo esc_html($permalinkget); ?>"><?php echo esc_html($title); ?></a></h3>
						<?php } ?>
						<strong class="subtitle">
							<?php if (!empty($permalinkget) && !empty($job_img_url)) { ?>
								<span class="icon">
									<a href="<?php echo esc_html($permalinkget); ?>"><img src="<?php echo esc_url_raw($job_img_url); ?>" width="50" height="49" alt="Ever Media Studio"></a>
								</span>
								<?php }
															if (!empty($categories)) {
																$counter = 1;
																foreach ($categories as $category) {
																	if ($counter == 1) { ?>
										<span class="txt"><?php echo esc_attr($category->name); ?></span>
							<?php } else {
																		break;
																	}
																	$counter++;
																}
															}  ?>
						</strong>
						<ul class="stats-list">
							<?php if (!empty($social_media)) { ?>
								<li>
									<i class="jobcircle-icon-briefcase1 icon"></i>
									<span class="text"><?php echo esc_html($social_media); ?></span>
								</li>
							<?php }
															if (!empty($job_location)) { ?>
								<li>
									<i class="jobcircle-icon-map-pin icon"></i>
									<span class="text"><?php echo esc_html($job_location); ?></span>
								</li>
							<?php }
															if (!empty($minut)) { ?>
								<li>
									<i class="jobcircle-icon-clock icon"></i>
									<span class="text"><?php echo esc_html($minut); ?></span>
								</li>
							<?php }
															if (!empty($vacancies)) { ?>
								<li>
									<i class="jobcircle-icon-work_outline icon"></i>
									<span class="text"><?php echo esc_html($vacancies); ?></span>
								</li>
							<?php } ?>
						</ul>
						<ul class="tags-list">
							<?php
															if (!empty($skills)) {
																foreach ($skills as $skill) {   ?>
									<li><span class="tag"><?php echo esc_html($skill->name) ?></span></li>
							<?php 	}
															}  ?>
						</ul>
						<?php if (!empty($excerpt)) {  ?>
							<p><?php echo esc_html($excerpt); ?></p>
						<?php  } ?>
						<a href="javascript:;" class="jobcircle-det-applybtn jobdet-applybtn-act btn btn-primary jobcircle-aplybtn-con" data-id="<?php echo esc_html($job_id); ?>" data-bs-toggle="modal" data-bs-target="#jobcircle-apply-job-popup">
							<span class="btn-text"><?php echo esc_html_e('Apply Now'); ?></span></a>
					</div>
				</article>
			</div>
			<?php
		}

		if ($total_posts > $numofpost) {
			echo jobcircle_pagination($query, true);
		}

		echo jobcircle_pagination($query, true);
	} else {
		?>
		<p><?php esc_html(' No job found.', 'jobcircle-frame') ?></p>
		<?php
	}
	wp_reset_postdata();
	$output = ob_get_clean();
	return $output;
}
add_action('wp_ajax_jobcircle_simple_job_filters_submit_call_grid', 'jobcircle_simple_job_filters_submit_call_grid');
add_action('wp_ajax_nopriv_jobcircle_simple_job_filters_submit_call_grid', 'jobcircle_simple_job_filters_submit_call_grid');
function jobcircle_simple_job_filters_submit_call_grid()
{
	$atts = array(
		'numofpost' => $_POST['numposts'],
		'orderby' => $_POST['orderby']
	);
	$html = jobcircle_jobs_simple_grid($atts);
	wp_send_json(array('html' => $html));
}
