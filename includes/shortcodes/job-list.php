<?php
function jobcircle_listed_jobs()
{
	vc_map(
		array(
			'name' => __('Listed Job'),
			'base' => 'job_circle_listed_jobs',
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
			)
		)
	);
}
add_action('vc_before_init', 'jobcircle_listed_jobs');
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
function jobcircle_listed_jobs_frontend($atts, $content)
{
	$atts = shortcode_atts(
		array(
			'orderby' => '',
			'numofpost' => '',
			'category_slug' => '',
		),
		$atts,
		'jobcircle_listed_jobs'
	);
	$orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
	$numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
	wp_enqueue_script('jobcircle-jobfunctions');
	ob_start();
	global $jobcircle_framework_options;
	//
	$jobcircle_framework_options = get_option('jobcircle_framework_options');
	$jobcircle_framework_options = get_option('jobcircle_framework_options');
	$ad_type_select = isset($jobcircle_framework_options['ad_type_select']) ? $jobcircle_framework_options['ad_type_select'] : '';
	$ad_code = isset($jobcircle_framework_options['ad_code']) ? $jobcircle_framework_options['ad_code'] : '';
	$ad_image = isset($jobcircle_framework_options['ad_image']) ? $jobcircle_framework_options['ad_image'] : '';
	$ad_placement = isset($jobcircle_framework_options['ad_placement']) ? $jobcircle_framework_options['ad_placement'] : '';
	$ad_location = isset($jobcircle_framework_options['ad_location']) ? $jobcircle_framework_options['ad_location'] : '';
?>
	<!-- Featured Jobs Section -->
	<main class="main">
		<!-- Featured Jobs Section -->
		<section class="section section-categories pt-35 pt-md-50 pt-lg-75 pt-xl-95 pb-0 pb-xxl-25">
			<div class="jobcircle-all-listing-con">
				<div class="row">
					<div class="col-12 col-lg-4">
						<div class="d-flex align-items-center justify-content-between d-lg-none mb-25 filters-head">
							<h2 class="h5"><?php echo esc_html_e('Filters', 'jobcircle_frame') ?></h2>
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
							<?php
							$ad_type_select_values = isset($jobcircle_framework_options['ad_type_select']) ? $jobcircle_framework_options['ad_type_select'] : array();
							$ad_code_values = isset($jobcircle_framework_options['ad_code']) ? $jobcircle_framework_options['ad_code'] : array();
							$ad_placement_values = isset($jobcircle_framework_options['ad_placement']) ? $jobcircle_framework_options['ad_placement'] : array();
							$ad_image_values = isset($jobcircle_framework_options['jobcircle-sixteen-ad-image']) ? $jobcircle_framework_options['jobcircle-sixteen-ad-image'] : array();
							$ad_location_values = isset($jobcircle_framework_options['ad_location']) ? $jobcircle_framework_options['ad_location'] : array();
							// Loop through the items and display based on conditions
							foreach ($ad_type_select_values as $index => $ad_type_select) {
								$ad_code = isset($ad_code_values[$index]) ? $ad_code_values[$index] : '';
								$ad_placement = isset($ad_placement_values[$index]) ? $ad_placement_values[$index] : '';
								$ad_image = isset($ad_image_values[$index]) ? $ad_image_values[$index] : '';
								$ad_location = isset($ad_location_values[$index]) ? $ad_location_values[$index] : '';
								// Check if the user has selected "Ad Placement" = 'job' and "AD Location" = 'top_sidebar'
								if ($ad_placement === 'job' && $ad_location === 'top_sidebar') {
									if ($ad_type_select === 'code') {
										// Display the code
										echo "$ad_code" . "<br/>";
									} elseif ($ad_type_select === 'image') {
										// Display the image (if it exists)
										if (!empty($ad_image['url'])) {
											echo "<div class='filters-sidebar-ad-image'><img src='{$ad_image['url']}' alt='Ad Image'></div>";
										}
									}
								}
							}
							?> <!-- Filter Box -->
							<div class="filter-box">
								<h2 class="h5"><?php echo esc_html_e('Email me new jobs', 'jobcircle-frame') ?></h2>
								<div class="form-group search-field">
									<input class="form-control" name="alerts_name" placeholder="<?php echo esc_html_e('Job alert name...', 'jobcircle-frame') ?>" type="text">
								</div>
								<div class="form-group">
									<input class="form-control" name="alerts_email" placeholder="<?php echo esc_html_e('example@email.com', 'jobcircle-frame') ?>" type="email" value="<?php echo ($email) ?>" <?php echo ($disabled) ?>>
								</div>
								<div class="form-group">
									<div class="checkbox-limi checkbox-creat-alert">
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
														<input id="cat-<?php echo esc_html($rand_id); ?>" name="job_frequency" value="<?php echo esc_html($frequency); ?>" type="checkbox" <?php echo esc_html($frequency) == 'frequency_daily' ? "checked" : "" ?>>
														<span class="fake-checkbox"></span>
														<span class="label-text"><?php echo esc_html($label); ?></span>
													</label>
												</li>
											<?php } ?>
										</ul>
										<a class="btn btn-primary btn-sm creatalert  mt-20 jobcircle-alertfilter-btn">
											<span class="btn-text"><?php echo esc_html_e('Create Alert', 'jobcircle-frame') ?></span>
										</a>
									</div>
								</div>
							</div>
							<form method="post" class="jobcircle-jobfilter-form">
								<!-- Filter Box -->
								<div class="filter-box">
									<h2 class="h5"><?php echo esc_html_e('Search', 'jobcircle-frame') ?></h2>
									<div class="form-group search-field">
										<input class="form-control" name="keyword" placeholder="<?php echo esc_html_e('Search with keyword', 'jobcircle-frame') ?>" type="text">
										<button class="button-search"><i class="jobcircle-icon-search icon"></i></button>
									</div>
								</div>
								<div class="filter-box">
									<h2 class="h5"><?php echo esc_html_e('Location', 'jobcircle-frame') ?></h2>
									<div class="form-group search-field">
										<input class="form-control jobcircle-location-input-field" name="location" placeholder="<?php echo esc_html_e('Enter any location', 'jobcircle-frame') ?>" type="text">
									</div>
								</div>
								<!-- Filter Box -->
								<div class="filter-box">
									<h2 class="h5"><?php echo esc_html_e('Categories', 'jobcircle-frame') ?></h2>
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
																<input id="cat-<?php echo esc_html($cat_term->term_id); ?>" name="job_category" value="<?php echo esc_html($cat_term->slug); ?>" type="checkbox">
																<span class="fake-checkbox"></span>
																<span class="label-text">
																	<?php echo esc_attr($cat_term->name); ?>
																</span>
															</label>
														</li>
													<?php
													}
													?>
											</ul>
											<a href="#" class="btn btn-primary btn-sm buttonShowMore">
												<span class="btn-text"><?php echo esc_html_e('Show', 'jobcircle-frame') ?>
													<span class="show"><?php echo esc_html_e('More', 'jobcircle-frame') ?></span>
													<span class="hide"><?php echo esc_html_e('Less', 'jobcircle-frame') ?></span>
												</span>
											</a>
										</div>
									</div>
								</div>
								<div class="filter-box">
									<a class="filter-box-head" data-bs-toggle="collapse" href="#collapseType">
										<h2 class="h5"><?php echo esc_html_e('Job Type', 'jobcircle-frame') ?></h2>
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
								<script>
									jQuery(document).ready(function() {
										jQuery('.buttonToggle').on('click', function(e) {
											e.preventDefault();
											var $hiddenCategories = jQuery('.checkbox-list li.hidden');
											$hiddenCategories.toggleClass('hidden');
											var buttonText = jQuery(this).find('.btn-text');
											buttonText.find('.show, .hide').toggle();
										});
									});
								</script>
								<!-- Filter Box -->
								<div class="filter-box">
									<h2 class="h5"><?php echo esc_html_e('Salary', 'jobcircle-frame') ?></h2>
									<div class="price-inputs">
										<input type="text" id="amount-start" name="min_salary" class="form-control" readonly placeholder="Form" value="">
										<input type="text" id="amount-end" class="form-control" name="max_salary" readonly placeholder="To" value="">
									</div>
									<div class="range-box">
										<div id="slider-range"></div>
									</div>
								</div>
								<!-- Filter Box -->
								<?php
													$view = isset($_REQUEST['view']) ? $_REQUEST['view'] : '';   ?>
								<div class="filter-buttons">
									<input type="hidden" name="numposts" value="<?php echo esc_html($numofpost); ?>">
									<input type="hidden" name="orderby" value="<?php echo esc_html($orderby); ?>">
									<input type="hidden" name="view" value="<?php echo esc_html($view); ?>">
									<input type="hidden" name="action" value="jobcircle_simple_job_filters_submit_call_one"><button type="submit" class="btn btn-primary btn-sm">
										<span class="btn-text submit-filters-button"><?php echo esc_html_e('Filter', 'jobcircle-frame') ?></span></button>
									<a href="#" class="btn btn-text btn-sm"><?php echo esc_html_e('Reset all filters', 'jobcircle-frame') ?></a>
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
							<h1 class="h4 mb-25 mb-lg-0"><?php echo esc_html_e('Showing 1 to ', 'jobcircle-frame') ?><?php echo esc_html($numofpost); ?> <?php echo esc_html_e('of', 'jobcircle-frame') ?>
								<?php echo esc_html($job_count); ?> <?php echo esc_html_e('jobs', 'jobcircle-frame') ?></h1>
							<div class="subhead-filters">
								<form id="jobForm" class="form-group d-lg-flex align-items-center" method="get">
									<select class="select2" name="sortby" data-placeholder="<?php echo esc_html_e('Sort by', 'jobcircle-frame') ?>" onchange="submitForm()">
										<option value="recent"><?php echo esc_html_e('Recent Jobs', 'jobcircle-frame') ?></option>
										<option value="asc" <?php echo isset($_GET['sortby']) && $_GET['sortby'] == 'asc' ? 'selected' : ''; ?>><?php echo esc_html_e('Sort by Name', 'jobcircle-frame') ?></option>
									</select>
								</form>
							</div>
							<div class="grid-buttons mt-30">
								<?php
													$listactive = 'btn-list active';
													$gridactive = 'btn-grid';
													if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'grid') {
														$listactive = 'btn-list';
														$gridactive = 'btn-grid active';
													}
													if (!empty($listactive)) { ?>
									<a href="?view=list"><button class="btn <?php echo esc_html($listactive); ?>" type="button">
											<img src="<?php echo Jobcircle_Plugin::root_url() ?>/images/list-icon.svg" width="20" height="20" alt="List">
										</button></a>
								<?php }
													if (!empty($gridactive)) { ?>
									<a href="?view=grid"><button class="btn <?php echo esc_html($gridactive); ?>" type="button">
											<img src="<?php echo Jobcircle_Plugin::root_url() ?>/images/grid-icon.svg" width="22" height="22" alt="Grid">
										</button></a>
								<?php } ?>
							</div>
						</header>
						<div class="row justify-content-center jobcircle-alljobs-list">
							<?php
													echo jobcircle_jobs_simple_list_one($atts);
							?>
						</div>
					</div>
				</div>
			</div>
		</section>
	</main>
	<?php
													$output = ob_get_clean();
													return $output;
												}
											}
											add_shortcode('job_circle_listed_jobs', 'jobcircle_listed_jobs_frontend');
											function jobcircle_jobs_simple_list_one($atts)
											{
												ob_start();
												$numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
												$orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
												$category_slug = isset($atts['category_slug']) ? $atts['category_slug'] : '';
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
												global $jobcircle_framework_options, $post;
												// Check that we have query results.
												if ($query->have_posts()) {
													// Start looping over the query results.
													while ($query->have_posts()) {
														$query->the_post();
														global $post;
														$post = get_the_id();
														$title = get_the_title($post);
														$excerpt = get_the_excerpt();
														$permalinkget = get_the_permalink($post);
														$posted = get_the_time('U');
														$minut = human_time_diff($posted, current_time('U')) . " Ago";
														$social_media = get_post_meta($post, 'social_media', true);
														$vacancies = get_post_meta($post, 'vacancies', true);
														$job_img_url = jobcircle_job_thumbnail_url($post);
														$job_location = jobcircle_post_location_str($post);
														$categories = get_the_terms($post, 'job_category');
														$skills = wp_get_post_terms($post, 'job_skill');
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
														if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'grid') {
	?>
			<div class="col-12 col-md-6 mb-15 mb-md-30">
				<!-- Featured Box -->
				<article class="featured-box">
					<a href="" class="pin-job <?php echo esc_html($like_btn_class); ?> " data-id="<?php echo esc_html($post); ?>"><i class=" <?php echo esc_html($fav_icon_class); ?> position-absolute <?php echo esc_html($follow); ?>"></i></a>
					<div class="textbox">
						<?php if (!empty($permalinkget) && !empty($title)) { ?>
							<h3 class="h4"><a href="<?php echo esc_html($permalinkget); ?>"><?php echo esc_html($title); ?></a>
							</h3>
						<?php } ?>
						<strong class="subtitle">
							<?php if (!empty($permalinkget) && !empty($job_img_url)) { ?>
								<span class="icon"><a href="<?php echo esc_html($permalinkget); ?>">
										<img src="<?php echo esc_url_raw($job_img_url); ?>" width="50" height="49" alt="Ever Media Studio"></a></span>
								<?php }
															if (!empty($categories)) {
																$count_category = 0;
																foreach ($categories as $category) {
																	if ($count_category == 0) { ?>
										<span class="txt"><?php echo esc_html($category->name); ?></span>
							<?php
																	} else {
																		break;
																	}
																	$count_category++;
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
							<?php  }
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
									<li><span class="tag">
											<?php echo esc_html($skill->name) ?>
										</span></li>
							<?php 	}
															}  ?>
						</ul>
						<?php if (!empty($excerpt)) {  ?>
							<p><?php echo esc_html($excerpt); ?></p>
						<?php }  ?>
						<a href="<?php echo $permalinkget ?>" class="jobcircle-det-applybtn jobdet-applybtn-act btn btn-primary jobcircle-aplybtn-con" >
							<span class="btn-text"><?php echo esc_html('Apply Now', 'jobcircle-frame') ?></span></a>
					</div>
				</article>
			</div>
		<?php } else { ?>

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
									<a href="<?php echo esc_html($permalinkget); ?>"><img src="<?php echo esc_url_raw($job_img_url); ?>" width="50" height="49" alt="Ever Media Studio"></a></span>
								<?php }
															if (!empty($categories)) {
																$count_category = 0;
																foreach ($categories as $category) {
																	if ($count_category == 0) { ?>
										<span class="txt"><?php echo esc_attr($category->name); ?></span>
							<?php
																	} else {
																		break;
																	}
																	$count_category++;
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
						<?php }  ?>
						<a href="<?php echo $permalinkget ?>" class="jobcircle-det-applybtn jobdet-applybtn-act btn btn-primary jobcircle-aplybtn-con">
							<span class="btn-text"><?php echo esc_html_e('Apply Now'); ?></span></a>
					</div>
				</article>
			</div>

	<?php
														}
													}
												} else {
	?>
	<p><?php echo esc_html('No job found.', 'jobcircle-frame') ?></p>
<?php
												}
												//also this one
												if ($total_posts > $numofpost) {
													echo jobcircle_pagination($query, true);
												}
												wp_reset_postdata();
												$output = ob_get_clean();
												return $output;
											}
											add_action('wp_ajax_jobcircle_simple_job_filters_submit_call_one', 'jobcircle_simple_job_filters_submit_call_one');
											add_action('wp_ajax_nopriv_jobcircle_simple_job_filters_submit_call_one', 'jobcircle_simple_job_filters_submit_call_one');
											function jobcircle_simple_job_filters_submit_call_one()
											{
												$atts = array(
													'numofpost' => $_POST['numposts'],
													'orderby' => $_POST['orderby']
												);
												$html = jobcircle_jobs_simple_list_one($atts);
												wp_send_json(array('html' => $html));
											}
											add_action('wp_ajax_jobcircle_create_job_alert', 'create_job_alert_callback');
											add_action('wp_ajax_nopriv_jobcircle_create_job_alert', 'create_job_alert_callback');
											function create_job_alert_callback()
											{
												$alerts_name = isset($_POST['alerts_name']) ? $_POST['alerts_name'] : '';
												$alerts_email = isset($_POST['alerts_email']) ? $_POST['alerts_email'] : '';
												$alert_frequency = isset($_POST['alert_frequency']) ? $_POST['alert_frequency'] : '';
												$alert_location = isset($_POST['alert_location']) ? $_POST['alert_location'] : '';
												$search_title = isset($_POST['search_title']) ? $_POST['search_title'] : '';
												$jobcircle_field_job_type = isset($_POST['jobcircle_field_job_type']) ? $_POST['jobcircle_field_job_type'] : '';
												$job_category = isset($_POST['job_category']) ? $_POST['job_category'] : '';
												$job_skills = isset($_POST['job_skills']) ? $_POST['job_skills'] : '';
												if (is_user_logged_in()) {
													$user_id = get_current_user_id();
													$is_employer = jobcircle_user_employer_id($user_id);
													if ($is_employer) {
														$return = array('success' => false, "message" => esc_html__("You cannot create a job alert. Only candidate can", 'jobcircle-frame'));
														echo json_encode($return);
														wp_die();
													}
												}
												
												if (empty($alerts_name) || empty($alerts_email)  || empty($alert_frequency)) {
													$return = array('success' => false, "message" => esc_html__("Provided data is not completed.", 'jobcircle-frame'));
												} else {
													$meta_query = array(
														array(
															'key' => '`_alert_email',
															'value' => $alerts_name,
															'compare' => '=',
														),
														array(
															'key' => 'jobcircle_field_' . $alert_frequency,
															'value' => 'on',
															'compare' => '=',
														),
													);
													$args = array(
														'post_type' => 'job-alert',
														'meta_query' => $meta_query,
													);
													$obj_query = new WP_Query($args);
													$count = $obj_query->post_count;
													if ($count > 0) {
														$return = array('success' => false, "message" => esc_html__("Alert already exists with this criteria", 'jobcircle-frame'));
													} else {
														// Insert Job Alert as a post.
														$job_alert_data = array(
															'post_title' => $alerts_name,
															'post_status' => 'publish',
															'post_type' => 'job-alert',
															'comment_status' => 'closed',
															'post_author' => get_current_user_id(),
														);
														$job_alert_id = wp_insert_post($job_alert_data);
														// Update email.
														update_post_meta($job_alert_id, 'jobcircle_field_alert_email', $alerts_email);
														// Update name.
														update_post_meta($job_alert_id, 'jobcircle_field_alert_name', $alerts_name);
														// Update frequencies.
														update_post_meta($job_alert_id, 'jobcircle_field_' . $alert_frequency, 'on');
														// Update search title.
														update_post_meta($job_alert_id, 'jobcircle_field_search_title', $search_title);
														// Update location.
														update_post_meta($job_alert_id, 'jobcircle_field_location', $alert_location);
														// Update job type.
														update_post_meta($job_alert_id, 'jobcircle_field_job_type', $jobcircle_field_job_type);
														// Update category.
														update_post_meta($job_alert_id, 'jobcircle_field_job_category', $job_category);
														// Update category.
														update_post_meta($job_alert_id, 'jobcircle_field_job_skills', $job_skills);
														// Last time email sent.
														update_post_meta($job_alert_id, 'last_time_email_sent', 0);
														$return = array('success' => true, "message" => esc_html__("Job alert successfully added.", 'jobcircle-frame'));
													}
												}
												echo json_encode($return);
												wp_die();
											}
											add_action('wp_ajax_create_job_alert', 'create_job_alert_submit_call');
											add_action('wp_ajax_nopriv_create_job_alert', 'create_job_alert_submit_call');
											function create_job_alert_submit_call()
											{
												$alertsName = isset($_POST['alerts_name']) ? $_POST['alerts_name'] : '';
												$alertsEmail = isset($_POST['alerts_email']) ? $_POST['alerts_email'] : '';
												$alertsFrequency = isset($_POST['alerts_frequency']) ? $_POST['alerts_frequency'] : '';
												$frequencies = array(
													'frequency_daily' => 'Daily',
													'frequency_weekly' => 'Weekly',
													'frequency_fortnightly' => 'Fortnightly',
													'frequency_monthly' => 'Monthly',
													'frequency_biannually' => 'Biannually',
													'frequency_annually' => 'Annually',
													'frequency_never' => 'Never',
												);
												ob_start(); ?>
<?php
												$targetDate = '2023-11-15';
												$currentDate = date('Y-m-d');
												$remainingDays = intval((strtotime($targetDate) - strtotime($currentDate)) / (60 * 60 * 24));
												if ($remainingDays < 0) {
													$output = "Time limit is over";
												}
?>
<form id="jobcircle-job-alerts-form" method="post">
	<input type="hidden" name="action" value="jobcircle_create_job_alert">
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="job-alert-label" class="form-label"><?php echo esc_html_e('Job Alert Label', 'jobcircle-frame') ?></label>
				<input type="text" class="form-control" name="alerts_name" id="job-alert-label" value="<?php echo ($alertsName) ?>">

				<input type="hidden" class="form-control" name="alerts_email" value="<?php echo ($alertsEmail) ?>">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="job-frequency" class="form-label"><?php echo esc_html_e('Select Frequency', 'jobcircle-frame') ?></label>
				<select class="form-control" name="alert_frequency">
					<option value="0">Select Frequency</option>
					<?php foreach ($frequencies as $frequency => $label) { ?>
						<option value="<?php echo ($frequency) ?>" <?php echo ($frequency == $alertsFrequency ? "selected" : "") ?>><?php echo ($label); ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="job-alert-keyword" class="form-label"><?php echo esc_html_e('Keyword', 'jobcircle-frame') ?></label>
				<input type="text" class="form-control" name="search_title" id="job-alert-keyword">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="job-alert-location" class="form-label"><?php echo esc_html_e('Location', 'jobcircle-frame') ?></label>
				<input type="text" class="form-control" name="alert_location" id="job-alert-location" placeholder="<?php echo esc_html_e('City, State or ZIP', 'jobcircle-frame') ?>">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<?php $job_types_list = jobcircle_job_types_list(); ?>
				<label for="job-type" class="form-label"><?php echo esc_html_e('Job Type', 'jobcircle-frame') ?></label>
				<select name="jobcircle_field_job_type[]" multiple="" class="form-control rounded">
					<?php foreach ($job_types_list as $job_type_key => $job_type_ar) { ?>
						<option value="<?php echo ($job_type_key) ?>"><?php echo ($job_type_ar['title']) ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="col-md-6">
			<?php $cat_terms = get_terms(array(
													'taxonomy' => 'job_category',
													'hide_empty' => false,
												));
												if ($cat_terms != '') { ?>
				<div class="form-group">
					<label for="job-type" class="form-label"><?php esc_html_e('Job Categories', 'jobcircle-frame') ?></label>
					<select name="job_category[]" multiple="" class="form-control" placeholder="Select Job Categories">
						<?php foreach ($cat_terms as $job_catitem) { ?>
							<option value="<?php echo ($job_catitem->term_id) ?>"><?php echo ($job_catitem->name) ?></option>
						<?php } ?>
					</select>
				</div>
			<?php } ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<?php $all_skills = get_terms(array(
													'taxonomy' => 'job_skill',
													'hide_empty' => false,
												)); ?>
			<div class="form-group">
				<label><?php esc_html_e('Skills', 'jobcircle-frame') ?></label>
				<select name="job_skills[]" class="form-control" multiple="" placeholder="Select Skills">
					<?php foreach ($all_skills as $job_skillitem) { ?>
						<option value="<?php echo ($job_skillitem->name) ?>"><?php echo ($job_skillitem->name) ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
	</div>
</form>
<?php
												$html = ob_get_clean();
												wp_send_json(array('html' => $html));
												wp_die();
											}
