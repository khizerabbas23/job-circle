<?php
function jobcircle_candiddate_filter_page()
{
         $terms = get_terms(
		array(
			'taxonomy' => 'candidate_cat',
			'hide_empty' => false,
		)
	);
	$job_types = array();
	foreach ($terms as $term) {
		$job_types[$term->name] = $term->term_id;
	}
	;
	vc_map(
		array(
			'name' => __('Candidates Filter Page'),
			'base' => 'jobcircle_candiddate_filter_page',
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
				array(
					'type' => 'dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Filter Switch'),
					'param_name' => 'filter_switch',
					'value' => array(
						'Select Style' => '',
						'Filter On' => 'filter_on',
						'Filter Off' => 'filter_off',
					),
				),
				array(
					'type' => 'dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Filter sidebar Alignment'),
					'param_name' => 'filter_sidebar_alignment',
					'value' => array(
						'Select Style' => '',
						'Filter Left' => 'filter_left',
						'Filter Right' => 'filter_right',
					),
				),
				                array(
        		  'type' => 'dropdown',
        		  'holder' => 'div',
        		  'class' => '',
        		  'heading' => __('Select Category For Post'),
        		  'param_name' => 'dropdown_param',
        		  'value' => $job_types,
        		),
			)
		)

	);
}
add_action('vc_before_init', 'jobcircle_candiddate_filter_page');
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
function jobcircle_candiddate_filter_page_frontend($atts, $content)
{
	$atts = shortcode_atts(
		array(
			'orderby' => '',
			'numofpost' => '',
			'filter_sidebar_alignment' => '',
			'filter_switch' => '',
			'dropdown_param' => '',

		),
		$atts,
		'jobcircle_candiddate_filter_page'
	);
	$orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
	$numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
	 $dropdown_param = isset($atts['dropdown_param']) ? $atts['dropdown_param'] : '';
        $job_type_arr = !empty($dropdown_param) ? explode(',', $dropdown_param) : '';
	add_action('wp_footer', function () {
		?>
			<script>
				jQuery('.submit-filters-button').on('click', function() {
					jQuery(this).parents('form').submit();
				});
				jQuery('.jobcircle-jobfilter-form').find('input[type="checkbox"]').on('change', function() {
					jQuery(this).parents('form').submit();
				});
				jQuery('.jobcircle-jobfilter-form').on('submit', function(ev) {
	
					ev.preventDefault();
	
					var this_form = jQuery(this);
					var this_par = this_form.parents('.jobcircle-all-listing-con');
					var from_element = this_form[0];
					var form_data = new FormData(from_element);
	
					if (!this_form.hasClass('ajax-processing')) {
	
						this_par.append(
							'<div class="jobcircle-loder-con"><div class="jobcircle-loder-iner"><div class="jobcircle-loader"></div></div></div>'
						);
						jQuery.ajax({
							type: "POST",
							dataType: "json",
							url: '<?php echo admin_url('admin-ajax.php'); ?>',
							processData: false,
							contentType: false,
							data: form_data,
							success: function(data) {
	
								this_par.find('.jobcircle-allemployer-list').html(data.html);
	
								this_par.find('.jobcircle-loder-con').remove();
								this_form.removeClass('ajax-processing');
								//
								var data_query = jQuery(this_form[0].elements).not(
										':input[name="action"],:input[name="numposts"],:input[name="orderby"]')
									.serialize();
								var current_url = location.protocol + "//" + location.host + location.pathname +
									"?" + data_query; //window.location.href;
								window.history.pushState(null, null, decodeURIComponent(current_url));
							},
							error: function() {
								this_par.find('.jobcircle-loder-con').remove();
								this_form.removeClass('ajax-processing');
							}
						});
					}
	
					this_form.addClass('ajax-processing');
				});
			</script>
		<?php
		}, 30);
	
	
	ob_start();
	
				$posts = get_posts([
					'post_type' => 'candidates',
					'post_status' => 'publish',
					'numberposts' => -1
				]);
				$job_count = count($posts);
			?>
			<header class="page-subheader pt-35 pt-md-50 pt-lg-75 mb-30 mb-md-40 d-lg-flex align-items-center justify-content-between">
					<h3 class="h6 mb-25 mb-lg-0"><?php esc_html_e('All', 'jobcircle-frame') ?> <?php echo jobcircle_esc_the_html($job_count); ?> <?php esc_html_e('jobs found', 'jobcircle-frame') ?></h3>
					<div class="subhead-filters">
						<div class="subhead-filters-item">
							<label><?php echo esc_html_e('Sort By' , 'jobcircle-frame')?></label>
							<form id="jobForm" class="form-group d-lg-flex align-items-center" method="get">
								<select class="select2" name="sortby" data-placeholder="<?php echo esc_html_e('Sort By' , 'jobcircle-frame')?>" onchange="submitForm()">
									<option value="recent"><?php esc_html_e('Recent Jobs', 'jobcircle-frame') ?></option>
									<option value="asc" <?php echo isset($_GET['sortby']) && $_GET['sortby'] == 'asc' ? 'selected' : ''; ?>><?php esc_html_e('Sort by Name', 'jobcircle-frame') ?></option>
								</select>
								</from>
						</div>								
					</div>
				</header>
	
		<div class="jobcircle-all-listing-con ">
				<?php
				$col = 'col-lg-12';
				if ($atts['filter_switch'] == 'filter_on') {
					$col = 'col-lg-8';

					$sidebaralign = '';
					if ($atts['filter_sidebar_alignment'] == 'filter_left') {
						$sidebaralign = '';
					} elseif ($atts['filter_sidebar_alignment'] == 'filter_right') {
						$sidebaralign = 'flex-md-row-reverse';
					}
				?>
					<div class="row <?php echo jobcircle_esc_the_html($sidebaralign); ?>">
						<div class="col-12 col-lg-4 col-xxl-3 section-theme-1">
							<div class="d-flex align-items-center justify-content-between d-lg-none mb-25 filters-head">
								<h2 class="h5"><?php esc_html_e('Filters', 'jobcircle-frame') ?></h2>
								<a href="#" class="filters-opener"><span></span></a>
							</div>
							<!-- Filters Sidebar -->
							<aside class="filters-sidebar">
								<div class="filters-sidebar-Head">
									<strong class="title"><?php esc_html_e('Filter By', 'jobcircle-frame') ?></strong>
									<a href="#" class="btn-clear"><i class="jobcircle-icon-plus"></i></a>
								</div>
								<form method="post" class="jobcircle-jobfilter-form">
									<!-- Filter Box -->
									<div class="filter-box">
										<h2 class="h5"><?php esc_html_e('Search', 'jobcircle-frame') ?></h2>
										<div class="form-group search-field">
											<input class="form-control" name="keyword" placeholder="Search with keyword" type="text">
											<button class="button-search"><i class="jobcircle-icon-search icon"></i></button>
										</div>
									</div>

									<!-- Filter Box -->
									<div class="filter-box">
										<a class="filter-box-head" data-bs-toggle="collapse" href="#collapseCategory">
											<h2 class="h5"><?php esc_html_e('Category', 'jobcircle-frame') ?></h2>
											<span class="collapse-icon"></span>
										</a>
										<div class="collapse show" id="collapseCategory">
											<div class="form-group">
												<div class="checkbox-limit">
													<ul class="checkbox-list">
														<?php
														$cat_terms = get_terms(
															array(
																'taxonomy' => 'candidate_cat',
																'hide_empty' => false,
															)
														);
														if (!empty($cat_terms)) {
															foreach ($cat_terms as $cat_term) {
														?>
																<li>
																	<label class="custom-checkbox">
																		<input id="cat-<?php echo jobcircle_esc_the_html($cat_term->term_id); ?>" name="candidate_cat" value="<?php echo jobcircle_esc_the_html($cat_term->slug); ?>" type="checkbox">
																		<span class="fake-checkbox"></span>
																		<span class="label-text">
																			<?php echo jobcircle_esc_the_html($cat_term->name); ?>
																		</span>
																	</label>
																</li>
														<?php
															};
														}
														?>

													</ul>
													<a href="#" class="btn btn-sm buttonShowMore">
														<span class="btn-text"><?php esc_html_e('Show', 'jobcircle-frame') ?>
															<span class="show"><?php esc_html_e('More', 'jobcircle-frame') ?></span>
															<span class="hide"><?php esc_html_e('Less', 'jobcircle-frame') ?></span>
														</span>
													</a>
												</div>
											</div>
										</div>
									</div>
									<div class="filter-box">
										<a class="filter-box-head" data-bs-toggle="collapse" href="#collapseSalary">
											<h2 class="h5"><?php esc_html_e('Salary', 'jobcircle-frame') ?></h2>
											<span class="collapse-icon"></span>
										</a>
										<div class="collapse show" id="collapseSalary">
											<div class="form-group">
												<div class="price-inputs">
													<input type="text" id="amount-start" name="min_salary" class="form-control" readonly placeholder="Form" value="">													
													<input type="text" id="amount-end" name="max_salary" class="form-control" readonly placeholder="To" value="">
												</div>
												<div class="range-box">
													<div id="slider-range"></div>
												</div>
											</div>
										</div>
									</div>
									<!-- Filter Buttons -->
									<div class="filter-buttons">
										<input type="hidden" name="numposts" value="<?php echo jobcircle_esc_the_html($numofpost); ?>">
										<input type="hidden" name="orderby" value="<?php echo jobcircle_esc_the_html($orderby); ?>">
										<input type="hidden" name="action" value="jobcircle_candidates_filter_page_style_func">
										<button type="submit" class="btn btn-green btn-sm"><span class="btn-text submit-filters-button"><?php esc_html_e('Apply Filter', 'jobcircle-frame') ?></span></button>
									</div>
								</form>
							</aside>
						</div>
						
						
					<?php } ?>


	<div class="col-12 <?php echo jobcircle_esc_the_html($col) ?> col-xxl-9">
	<section class="section section-candidate candidate-addition pt-0 pb-35 pb-xl-75 candidate-pb">
		<div class="container">
			<div class="row justify-content-center jobcircle-allemployer-list">

			<?php

			echo jobcircle_candidate_filter_page_style($atts);

			$output = ob_get_clean();
			return $output;
			}


add_shortcode('jobcircle_candiddate_filter_page', 'jobcircle_candiddate_filter_page_frontend');


function jobcircle_candidate_filter_page_style($atts){
		ob_start();
		global $job_map_items;
		$numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
		$orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
		$dropdown_param = isset($atts['dropdown_param']) ? $atts['dropdown_param'] : '';
        $job_type_arr = !empty($dropdown_param) ? explode(',', $dropdown_param) : '';

		$page_numbr = get_query_var('paged');
		$order = 'DESC';
		if (isset($_GET['sortby']) && $_GET['sortby'] == 'asc') {
			$orderby = 'title';
			$order = 'ASC';
		}
		 $include_category_ids = $job_type_arr;
		$args = array(
			'post_type' => 'candidates', //enter post type name static
			'post_status' => 'publish',
			'posts_per_page' => $numofpost,
			'order' => $order,
			'paged' => $page_numbr,
			'orderby' =>  $orderby,
			             'tax_query' => array(
                  array(
                      'taxonomy' => 'candidate_cat',
                      'field' => 'term_id', // Use term_id instead of slug
                      'terms' => $include_category_ids,
                      'include_children' => false, // Set to true if you want to include posts from child 
                      
              ),
           ),
		);

		if (isset($_REQUEST['keyword'])) {
			$keyword = $_REQUEST['keyword'];
			$args['s'] = esc_html($keyword);
		}

		// tax query
		$tax_query = array();
		if (isset($_REQUEST['candidate_cat'])) {
			$candidate_cat = $_REQUEST['candidate_cat'];
			$tax_query[] = array(
				'taxonomy' => 'candidate_cat',
				'field' => 'slug',
				'terms' => $candidate_cat,
			);
		}

		$min_salary = isset($_REQUEST['min_salary']) ? preg_replace("/[^0-9]/", '', $_REQUEST['min_salary']) : '';
		$max_salary = isset($_REQUEST['max_salary']) ? preg_replace("/[^0-9]/", '', $_REQUEST['max_salary']) : '';

		$meta_query = array();
		if ($min_salary >= 0 && $max_salary > 0) {

			$meta_query[] = array(
				'key' => 'jobcircle_field_min_salary',
				'value' => array($min_salary, $max_salary),
				'type' => 'numeric',
				'compare' => 'BETWEEN',
			);
		}
		$meta_query = apply_filters('jobcircle_listing_filters_meta_query', $meta_query, 'employer');

		if (!empty($tax_query)) {
			$args['tax_query'] = $tax_query;
		}

		if (!empty($meta_query)) {
			$args['meta_query'] = $meta_query;
		}


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
						$job_img_url = jobcircle_job_thumbnail_url($post);
						$facebook_url = get_post_meta($id, 'jobcircle_field_facebook_url', true);
						$twitter_url = get_post_meta($id, 'jobcircle_field_twitter_url', true);
						$linkedin_url = get_post_meta($id, 'jobcircle_field_linkedin_url', true);
						$button_text = get_post_meta($id, 'jobcircle_field_button_text', true);
						$position = get_post_meta($postid, 'jobcircle_field_job_title', true);
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

						<div class="col-12 col-md-6 col-lg-6 mb-15 mb-md-30 pb-0">
							<!-- Candidate Box -->

							<article class="candidate-box">
								<div class="textbox">
									
										<a href="" class="pin-job <?php echo jobcircle_esc_the_html($like_btn_class)  ?> " data-id="<?php echo jobcircle_esc_the_html($postid) ?>"><i class=" <?php echo jobcircle_esc_the_html($fav_icon_class) ?> position-absolute <?php echo jobcircle_esc_the_html($follow) ?>"></i></a>
									
									<div class="icon-box">
										<?php if(!empty($permalinkget) && !empty($job_img_url)) { ?>
											<a href="<?php echo jobcircle_esc_the_html($permalinkget); ?>">
												<img src="<?php echo esc_url_raw($job_img_url); ?>" width="102" height="102" alt="Alex Carey">
											</a>
										<?php } ?>
									</div>
									<?php if(!empty($permalinkget) && !empty($title)) { ?>
										<h2 class="h5"><a href="<?php echo jobcircle_esc_the_html($permalinkget); ?>"><?php echo jobcircle_esc_the_html($title); ?></a>
										</h2>
									<?php } ?>
									<strong class="subtitle">
												<?php echo jobcircle_esc_the_html($position); ?>
									</strong>
									<ul class="social-links">
										<?php if (!empty($facebook_url)) { ?>
											<li><a href="<?php echo jobcircle_esc_the_html($facebook_url); ?>"><i class="jobcircle-icon-facebook"></i></a></li>
										<?php } ?>
										<?php if (!empty($twitter_url)) { ?>
											<li><a href="<?php echo jobcircle_esc_the_html($twitter_url); ?>"><i class="jobcircle-icon-twitter"></i></a></li>
										<?php } ?>
										<?php if (!empty($linkedin_url)) { ?>
											<li><a href="<?php echo jobcircle_esc_the_html($linkedin_url); ?>"><i class="jobcircle-icon-linkedin"></i></a></li>
										<?php } ?>
									</ul>
									<?php if (!empty($permalinkget)) { ?>
										<a href="<?php echo jobcircle_esc_the_html($permalinkget); ?>" class="btn btn-primary btn-sm"><span class="btn-text">
											<?php } ?>
											<?php esc_html_e('View Resume', 'jobcircle-frame'); ?>
											</span></a>
								</div>
							</article>
						</div>
				<?php
					}
				}else {       ?>
					<p><?php esc_html_e('No job found.', 'jobcircle-frame'); ?></p>
				<?php
				}
				?>
			</div>
			<?php
			if ($total_posts > $numofpost) {
			?>
				<?php echo jobcircle_pagination($query, true);							
			}
			wp_reset_postdata();
			?>
		</div>
		</div>
		</div>
		</div>
	</section>
<?php
	return ob_get_clean();
}
	

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
									action: 'jobcircle_candidates_filter_page_style_func'
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
									action: 'jc_candidate_fav_job_listcandidates_list_com'
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

	add_action('wp_ajax_jobcircle_candidates_filter_page_style_func', 'jobcircle_candidates_filter_page_style_func');
	add_action('wp_ajax_nopriv_wp_ajax_jobcircle_candidates_filter_page_style_func', 'jobcircle_candidates_filter_page_style_func');

	function jobcircle_candidates_filter_page_style_func(){

		$atts = array(
			'numofpost' => $_POST['numposts'],
			'orderby' => $_POST['orderby']
		);

		$html = jobcircle_candidate_filter_page_style($atts);

		wp_send_json(array('html' => $html));
	}

				
// for favourite button
add_action('wp_ajax_jc_candidate_fav_job_list_candidated_list_theme', 'jc_candidate_fav_job_list_candidated_list_theme');
add_action('wp_ajax_nopriv_jc_candidate_fav_job_list_candidated_list_theme', 'jc_candidate_fav_job_list_candidated_list_theme');
function jc_candidate_fav_job_list_candidated_list_theme()
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
add_action('wp_ajax_jc_candidate_fav_job_listcandidates_list_com', 'jc_candidate_fav_job_listcandidates_list_com');
add_action('wp_ajax_nopriv_jc_candidate_fav_job_listcandidates_list_com', 'jc_candidate_fav_job_listcandidates_list_com');
function jc_candidate_fav_job_listcandidates_list_com()
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
