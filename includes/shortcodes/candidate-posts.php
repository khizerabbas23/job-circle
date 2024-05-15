<?php
function jobcircle_candidate_posts()
{
	vc_map(
		array(
			'name' => __('Candidates Post'),
			'base' => 'jc_candidate_posts',
			'category' => __('Job Circle'),
			'params' => array(
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Order BY'),
					'param_name' => 'orderby',
				),
				array(
					'type' => 'textarea',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Number Of Post'),
					'param_name' => 'numofpost',
				),
			)
		)

	);
}
add_action('vc_before_init', 'jobcircle_candidate_posts');

// popular category frontend
function jobcircle_candidate_posts_frontend($atts, $content)
{
	$atts = shortcode_atts(
		array(
			'orderby' => '',
			'numofpost' => '',
		),
		$atts,
		'jobcircle_candidate_posts'
	);
	$orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
	$numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
	$custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';

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
	<header class="page-subheader pt-35 pt-md-50 pt-lg-75 mb-20 mb-md-30 mb-lg-45 mb-xl-60 ">
		<div class="container">
			<div class="row">
			<?php
						$posts = get_posts([
							'post_type' => 'candidates',
							'post_status' => 'publish',
							'numberposts' => -1
						]);
						$job_count = count($posts);
						$numofpost  = isset($atts['numofpost']) ? $atts['numofpost'] : '';		

				// Retrieve the values for each field
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
					if ($ad_placement === 'candidate' && $ad_location === 'top_content') {
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

				?>
				<div class="col-12 d-lg-flex align-items-center justify-content-between">
					<?php if (!empty($job_count)) { ?>
						<h1 class="h5 mb-25 mb-lg-0"><?php esc_html_e('Showing 1–', 'jobcircle-frame') ?><?php jobcircle_esc_the_html($numofpost); ?><?php esc_html_e(' of ', 'jobcircle-frame') ?><?php jobcircle_esc_the_html($job_count); ?>
						<?php } ?>
						<?php esc_html_e('Candidates', 'jobcircle-frame') ?></h1>
						<div class="subhead-filters">
							<div class="form-group d-lg-flex align-items-center">
								<label class="d-block mb-5 mb-md-0" for="created"><?php esc_html_e('Sort By:', 'jobcircle-frame') ?></label>
								<form id="jobForm" method="get">
									<select id="created" class="select2 small select2-hidden-accessible" name="sortby" data-placeholder="Created by" data-select2-id="select2-data-created" tabindex="-1" aria-hidden="true" onchange="submitForm()">
										<option value="recent"><?php esc_html_e('Recent Jobs', 'jobcircle-frame') ?></option>
										<option value="asc" <?php echo isset($_GET['sortby']) && $_GET['sortby'] == 'asc' ? 'selected' : ''; ?>>
											<?php esc_html_e('Sort by Name', 'jobcircle-frame') ?></option>
									</select>
								</form>
							</div>
						</div>
				</div>
			</div>
	</header>
	<section class="section section-candidate candidate-addition pt-0 pb-35 pb-xl-75 candidate-pb">
		<div class="container">
			<div class="row justify-content-center">
				<?php
				$numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
				$orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
				$page_numbr = get_query_var('paged');
				$order = "DESC";
				$current_date = date('Y-m-d H:i:s');
				if (isset($_GET['sortby']) && $_GET['sortby'] == 'asc') {
					$orderby = 'title';
					$order = 'ASC';
				}else{
                    $orderby = array(
                                    'meta_value' => 'DESC',
                                    'post_date'  => 'DESC',
                                );
                }

				$args = array(
					'post_type' => 'candidates',
					'post_status' => 'publish',
					'posts_per_page' => $numofpost,
					'order' => $order,
					'paged' => $page_numbr,
					'orderby' =>  $orderby,
					'meta_query' => array(
                                    'relation' => 'OR',
                                    array(
                                        'key'     => 'candidate_promotion_pkg_start_date',
                                        'compare' => '<=',
                                        'value'   => $current_date,
                                        'type'    => 'DATE',
                                    ),
                                    array(
                                        'key'     => 'candidate_promotion_pkg_end_date',
                                        'compare' => '>=',
                                        'value'   => $current_date,
                                        'type'    => 'DATE',
                                    ),
                                array(
                                    'relation' => 'AND',
                                    array(
                                        'key'     => 'candidate_promotion_pkg_start_date',
                                        'compare' => 'NOT EXISTS',
                                    ),
                                    array(
                                        'key'     => 'candidate_promotion_pkg_end_date',
                                        'compare' => 'NOT EXISTS',
                                    ),
                                ),
                            )
				);

				// Custom query.
				$query = new WP_Query($args);
				$total_posts = $query->found_posts;

				// Check that we have query results.
				if ($query->have_posts()) {

					// Start looping over the query results.
					while ($query->have_posts()) {

						$query->the_post();
						$id = get_the_id();
						$post = get_post();
						$postid = $post->ID;
						$title = get_the_title($postid);
						$permalinkget = get_the_permalink($postid);
						$excerpt = get_the_excerpt($postid);
						$image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');
						$facebook_url = get_post_meta($id, 'jobcircle_field_facebook_url', true);
						$twitter_url = get_post_meta($id, 'jobcircle_field_twitter_url', true);
						$linkedin_url = get_post_meta($id, 'jobcircle_field_linkedin_url', true);
						$button_text = get_post_meta($id, 'jobcircle_field_button_text', true);
						global $current_user;
						$user_id = $current_user->ID;

						$fav_jobs = get_user_meta($user_id, 'fav_follower_list', true);
						$fav_jobs = !empty($fav_jobs) ? $fav_jobs : array();
						$like_btn_class = 'jobcircle-follower-btn';
						if (!is_user_logged_in()) {
							$like_btn_class = 'jobcircle-follower-btn no-user-follower-btn';
						} else {
							if (!jobcircle_user_candidate_id($user_id)) {
								$like_btn_class = 'jobcircle-follower-btn no-member-follower-btn';
							}
						}
						$fav_icon_class = 'profile-btn';
						$follow = 'fa fa-heart-o';

						if (in_array($postid, $fav_jobs)) {
							$like_btn_class = 'jobcircle-alrdy-favjab';
							$fav_icon_class = 'profile-btn';
							$follow = 'fa fa-heart';
						}

						$categories = get_the_terms($post, 'candidate_cat');
				?>

						<div class="col-12 col-md-6 col-lg-4 mb-15 mb-md-30 pb-70">
							<!-- Candidate Box -->

							<article class="candidate-box">
								<div class="textbox">
									<?php if (!empty($like_btn_class) || !empty($postid) || !empty($fav_icon_class) || !empty($follow)) { ?>
										<a href="" class="pin-job <?php echo jobcircle_esc_the_html($like_btn_class)  ?> " data-id="<?php echo jobcircle_esc_the_html($postid) ?>"><i class=" <?php echo jobcircle_esc_the_html($fav_icon_class) ?> position-absolute <?php echo jobcircle_esc_the_html($follow) ?>"></i></a>
									<?php	} ?>
									<div class="icon-box">
										<?php if (!empty($permalinkget) || !empty($image)) { ?>
											<a href="<?php jobcircle_esc_the_html($permalinkget); ?>">
												<img src="<?php echo esc_url_raw($image[0]); ?>" width="102" height="102" alt="Alex Carey">
											</a>
										<?php } ?>
									</div>
									<?php if (!empty($permalinkget) || !empty($title)) { ?>
										<h2 class="h5"><a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>"><?php jobcircle_esc_the_html($title); ?></a>
										</h2>
									<?php } ?>
									<strong class="subtitle">
										<?php
										if (!empty($categories)) {
											foreach ($categories as $category) {   ?>
												<?php jobcircle_esc_the_html($category->name); ?>
										<?php 	}
										}  ?>
									</strong>
									<ul class="social-links">
										<?php if (!empty($facebook_url)) { ?>
											<li><a href="<?php jobcircle_esc_the_html($facebook_url); ?>"><i class="jobcircle-icon-facebook"></i></a></li>
										<?php } ?>
										<?php if (!empty($twitter_url)) { ?>
											<li><a href="<?php jobcircle_esc_the_html($twitter_url); ?>"><i class="jobcircle-icon-twitter"></i></a></li>
										<?php } ?>
										<?php if (!empty($linkedin_url)) { ?>
											<li><a href="<?php jobcircle_esc_the_html($linkedin_url); ?>"><i class="jobcircle-icon-linkedin"></i></a></li>
										<?php } ?>
									</ul>
									<?php if (!empty($permalinkget)) { ?>
										<a href="<?php jobcircle_esc_the_html($permalinkget) ?>" class="btn btn-primary btn-sm"><span class="btn-text">
											<?php } ?>
											<?php esc_html_e('View Resume', 'jobcircle-frame'); ?>
											</span></a>
								</div>
							</article>
						</div>
				<?php
					}
				}
				?>
			</div>

			<?php
			if ($total_posts > $numofpost) {
			?>
				<?php echo jobcircle_pagination($query, true);

				add_action('wp_footer', function () {
				?>
					<script>
						jQuery(document).on('click', '.jobcircle-follower-btn', function() {


							var _this = jQuery(this);
							if (_this.hasClass('no-user-follower-btn')) {
								jobcircle_submit_msg_alert('<?php esc_html_e('Only logged-in user can save this.', 'jobcircle-frame') ?>', 'jobcircle-alert-warning');
								return false;
							}
							if (_this.hasClass('no-member-follower-btn')) {
								jobcircle_submit_msg_alert('<?php esc_html_e('Only a candidate member can save this.', 'jobcircle-frame') ?>', 'jobcircle-alert-warning');
								return false;
							}

							var this_icon = _this.find('i');
							var post_id = _this.data('id');
							this_icon.attr('class', 'fa fa-heart-shake');

							jQuery.ajax({
								type: "POST",
								dataType: "json",
								url: jobcircle_cscript_vars.ajax_url,
								data: {
									post_id: post_id,
									action: 'jobcircle_candidate_fav_job_list_candidated_list_theme'
								},
								success: function(data) {
									var totalFavorites = data.total_favorites;
									_this.removeClass('jobcircle-follower-btn');
									_this.addClass('jobcircle-alrdy-favjab');
									_this.addClass('fa fa-heart');
								},
								error: function() {
									this_icon.attr('class', 'profile-btn position-absolute');
								}
							});
						});

						jQuery(document).on('click', '.jobcircle-alrdy-favjab', function() {

							var _this = jQuery(this);
							var this_icon = _this.find('i');
							var post_id = _this.data('id');

							jQuery.ajax({
								type: "POST",
								dataType: "json",
								url: jobcircle_cscript_vars.ajax_url,
								data: {
									post_id: post_id,
									action: 'jobcircle_candidate_fav_job_listcandidates_list_com'
								},
								success: function(data) {
									var totalFavorites = data.total_favorites;
									_this.removeClass('jobcircle-alrdy-favjab');
									_this.addClass('jobcircle-follower-btn');
									_this.addClass('fa fa-heart-o');
								},
								error: function() {
									this_icon.attr('class', 'profile-btn position-absolute');
								}
							});
						});
					</script>

				<?php

				});
				?>
			<?php
			}
			wp_reset_postdata();
			?>

			<?php
			// Loop through the items and display based on conditions
			foreach ($ad_type_select_values as $index => $ad_type_select) {
				$ad_code = isset($ad_code_values[$index]) ? $ad_code_values[$index] : '';
				$ad_placement = isset($ad_placement_values[$index]) ? $ad_placement_values[$index] : '';
				$ad_image = isset($ad_image_values[$index]) ? $ad_image_values[$index] : '';
				$ad_location = isset($ad_location_values[$index]) ? $ad_location_values[$index] : '';

				// Check if the user has selected "Ad Placement" = 'job' and "AD Location" = 'top_sidebar'
				if ($ad_placement === 'candidate' && $ad_location === 'bottom_content') {
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

			?>
		</div>
	</section>
<?php
	return ob_get_clean();
}
add_shortcode('jc_candidate_posts', 'jobcircle_candidate_posts_frontend');

// for favourite button
add_action('wp_ajax_jobcircle_candidate_fav_job_list_candidated_list_theme', 'jobcircle_candidate_fav_job_list_candidated_list_theme');
add_action('wp_ajax_nopriv_jobcircle_candidate_fav_job_list_candidated_list_theme', 'jobcircle_candidate_fav_job_list_candidated_list_theme');
function jobcircle_candidate_fav_job_list_candidated_list_theme()
{
	global $current_user;
	$user_id = $current_user->ID;
	$post_id = $_POST['post_id'];

	$faver_jobs = get_user_meta($user_id, 'fav_follower_list', true);
	$faver_jobs = !empty($faver_jobs) ? $faver_jobs : array();
	if (!in_array($post_id, $faver_jobs)) {
		$faver_jobs[] = $post_id;
	}
	update_user_meta($user_id, 'fav_follower_list', $faver_jobs);

	$data = array(
		'success' => '1',
		'total_favorites' => count($faver_jobs)
	);

	wp_send_json_success($data);
	wp_die();
}
add_action('wp_ajax_jobcircle_candidate_fav_job_listcandidates_list_com', 'jobcircle_candidate_fav_job_listcandidates_list_com');
add_action('wp_ajax_nopriv_jobcircle_candidate_fav_job_listcandidates_list_com', 'jobcircle_candidate_fav_job_listcandidates_list_com');
function jobcircle_candidate_fav_job_listcandidates_list_com()
{
	global $current_user;
	$user_id = $current_user->ID;
	$post_id = $_POST['post_id'];

	$faver_jobs = get_user_meta($user_id, 'fav_follower_list', true);
	$faver_jobs = !empty($faver_jobs) ? $faver_jobs : array();
	if (in_array($post_id, $faver_jobs)) {
		$new_post_array = array_diff($faver_jobs, array($post_id));

		update_user_meta($user_id, 'fav_follower_list', $new_post_array);
	}
	$data = array(
		'success' => '1',
		'total_favorites' => count($faver_jobs)
	);
	wp_send_json_success($data);
	wp_die();
};
