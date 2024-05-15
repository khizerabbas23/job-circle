<?php
function jobcircle_job_grid()
{
	vc_map(
		array(
			'name' => __('Job Grid Four'),
			'base' => 'jobcircle_job_grid',
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
				array(
					'type' => 'dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __( 'Map Embed Selection' ),
					'param_name' => 'map_embed_selection',
					'value' => array(
                    'Select Style' => '',
                    'Map Left' => 'map_left',
                    'Map right' => 'map_right',
                ),
				),				
			)
		)
	);
}
add_action('vc_before_init', 'jobcircle_job_grid');
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
function jobcircle_job_grid_frontend($atts, $content)
{
	$atts = shortcode_atts(
		array(
			'orderby' => '',
			'numofpost' => '',
			'category_slug' => '',
			'map_embed_selection' => '',
		),
		$atts,
		'jobcircle_job_grid'
	);

	$orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
	$numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
	$map_embed_selection = isset($atts['map_embed_selection']) ? $atts['map_embed_selection'] : '';
	add_action('wp_footer', function () {
		?>
		<script>
			jQuery('.submit-filters-button').on('click', function () {
				jQuery(this).parents('form').submit();
			});
			jQuery('.jobcircle-jobfilter-form').find('input[type="checkbox"]').on('change', function () {
				jQuery(this).parents('form').submit();
			});
			jQuery('.jobcircle-jobfilter-form').on('submit', function (ev) {
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
						success: function (data) {
							this_par.find('.jobcircle-alljobs-list').html(data.html);
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
						error: function () {
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
	?>
	<main class="main">
		<!-- Featured Jobs Section -->
		<section class="section section-categories section-theme-1 pb-35 pb-lg-0 pt-0">
			<div class="container-fluid">
				<div class="jobcircle-all-listing-con">
					<?php
					$mapalign = '';
					if ($atts['map_embed_selection'] == 'map_left') {
						$mapalign = 'flex-lg-row-reverse';
					} elseif ($atts['map_embed_selection'] == 'map_right') {
						$mapalign = '';
					}
					?>
					<div class="row <?php echo esc_html($mapalign); ?>">
						<div class="col-12 col-lg-7 pt-35 pt-md-50 pt-lg-75 pb-35 pb-md-50 pb-xl-75">
							<!-- Page subheader -->
							<?php
							$posts = get_posts([
								'post_type' => 'jobs',
								'post_status' => 'publish',
								'numberposts' => -1
							]);
							$post_count = count($posts);
							$numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
							?>
							<header
								class="page-subheader mb-30 mb-md-40 d-xxl-flex align-items-center justify-content-between">
								<?php if (!empty($post_count)) { ?>
									<h3 class="h6 mb-25 mb-xxl-0">
										<?php esc_html_e('All', 'jobcircle-frame') ?>
										<?php echo esc_html($post_count); ?>
										<?php esc_html_e('jobs found', 'jobcircle-frame') ?>
									</h3>
								<?php } ?>
								<div class="subhead-filters d-xxl-flex align-items-center justify-content-between">
									<div class="subhead-filters-item">
										<label>
											<?php esc_html_e('Sort By', 'jobcircle-frame') ?>
										</label>
										<form id="jobForm" class="form-group d-lg-flex align-items-center" method="get">
											<select class="select2" name="sortby" data-placeholder="Sort by"
												onchange="submitForm()">
												<option value="recent">
													<?php esc_html_e('Recent Jobs', 'jobcircle-frame') ?>
												</option>
												<option value="asc" <?php echo isset($_GET['sortby']) && $_GET['sortby'] == 'asc' ? 'selected' : ''; ?>>
													<?php esc_html_e('Sort by Name', 'jobcircle-frame') ?>
												</option>
											</select>
										</form>
									</div>
									<div class="grid-buttons">
										<?php
										$listactive = 'btn-grid active';
										$gridactive = 'btn-list';
										if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list') {
											$listactive = 'btn-grid';
											$gridactive = 'btn-list active';
										}
										if (!empty($listactive)) { ?>
											<a href="?view=grid"><button class="btn <?php echo esc_html($listactive); ?>"
													type="button">
													<img src="<?php echo Jobcircle_Plugin::root_url() ?>/images/grid-icon.svg"
														width="20" height="20" alt="Grid">
												</button></a>
										<?php }
										if (!empty($gridactive)) { ?>
											<a href="?view=list"><button class="btn <?php echo esc_html($gridactive); ?>"
													type="button">
													<img src="<?php echo Jobcircle_Plugin::root_url() ?>/images/list-icon.svg"
														width="22" height="22" alt="List">
												</button></a>
										<?php } ?>
										<button class="btn btn-filters filters-opener" type="button">
											<span></span>
										</button>
									</div>
								</div>
							</header>
							<!-- Filters Sidebar -->
							<aside class="filters-sidebar custom-filters">
								<button class="btn btn-filters filters-opener" type="button">
									<span></span>
								</button>
								<form method="post" class="jobcircle-jobfilter-form">
									<div class="filter-box">
										<h2 class="h5">
											<?php esc_html_e('Search', 'jobcircle-frame') ?>
										</h2>
										<div class="form-group search-field">
											<input class="form-control" name="keyword"
												placeholder="<?php esc_html_e('Search with keyword', 'jobcircle-frame') ?>"
												type="text">
											<button class="button-search"><i
													class="jobcircle-icon-search icon"></i></button>
										</div>
									</div>
									<div class="filter-box">
										<h2 class="h5">
											<?php esc_html_e('Location', 'jobcircle-frame') ?>
										</h2>
										<div class="form-group search-field">
											<input class="form-control jobcircle-location-input-field" name="location"
												placeholder="<?php esc_html_e('Enter any location', 'jobcircle-frame') ?>"
												type="text">
										</div>
									</div>
									<!-- Filter Box -->
									<div class="filter-box">
										<a class="filter-box-head" data-bs-toggle="collapse" href="#collapseCategory">
											<h2 class="h5">
												<?php esc_html_e('Category', 'jobcircle-frame') ?>
											</h2>
											<span class="collapse-icon"></span>
										</a>
										<div class="collapse show" id="collapseCategory">
											<div class="form-group">
												<div class="checkbox-limit">
													<ul class="checkbox-list">

														<?php
														$cat_terms = get_terms(array(
															'taxonomy' => 'job_category',
														));
														if (!empty($cat_terms)) {
															foreach ($cat_terms as $cat_term) {
																?>
																<li>
																	<label class="custom-checkbox">
																		<input id="cat-<?php echo esc_html($cat_term->term_id) ?>"
																			name="job_category"
																			value="<?php echo esc_html($cat_term->slug) ?>"
																			type="checkbox">
																		<span class="fake-checkbox"></span>
																		<span class="label-text">
																			<?php echo esc_attr($cat_term->name) ?>
																		</span>
																	</label>
																</li>
															<?php }
														} ?>
													</ul>
													<a href="#" class="btn btn-primary btn-sm buttonShowMore">
														<span class="btn-text">
															<?php esc_html_e('Show', 'jobcircle-frame') ?>
															<span class="show">
																<?php esc_html_e('More', 'jobcircle-frame') ?>
															</span>
															<span class="hide">
																<?php esc_html_e('Less', 'jobcircle-frame') ?>
															</span>
														</span>
													</a>
												</div>
											</div>
										</div>
									</div>
									<!-- Filter Box -->
									<div class="filter-box">
										<a class="filter-box-head" data-bs-toggle="collapse" href="#collapseType">
											<h2 class="h5">
												<?php esc_html_e('Job Type', 'jobcircle-frame') ?>
											</h2>
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
																		<input type="checkbox" name="job_type"
																			value="<?php echo esc_html($job_type_key) ?>">
																		<span class="fake-checkbox"></span>
																		<span class="label-text">
																			<?php echo esc_html($job_types_list['title']); ?>
																		</span>
																	</label>
																</li>
															<?php
															}
															;
														} ?>
													</ul>
												</div>
											</div>
										</div>
									</div>
									<div class="filter-box">
										<a class="filter-box-head" data-bs-toggle="collapse" href="#collapseSalary">
											<h2 class="h5">
												<?php esc_html_e('Salary', 'jobcircle-frame') ?>
											</h2>
											<span class="collapse-icon"></span>
										</a>
										<div class="collapse show" id="collapseSalary">
											<div class="form-group">
												<div class="price-inputs">
													<input type="text" id="amount-start" name="min_salary"
														class="form-control" readonly placeholder="Form" value="">
													<input type="text" id="amount-end" name="max_salary"
														class="form-control" readonly placeholder="To" value="">
												</div>
												<div class="range-box">
													<div id="slider-range"></div>
												</div>
											</div>
										</div>
									</div>
									<?php
									$view = isset($_REQUEST['view']) ? $_REQUEST['view'] : ''; ?>
									<div class="filter-buttons">
										<input type="hidden" name="numposts" value="<?php echo esc_html($numofpost); ?>">
										<input type="hidden" name="orderby" value="<?php echo esc_html($orderby); ?>">
										<input type="hidden" name="view" value="<?php echo esc_html($view); ?>">
										<input type="hidden" name="action"
											value="jobcircle_simple_job_filters_new_submit_call_four"><button type="submit"
											class="btn btn-green btn-sm"><span class="btn-text">
												<?php esc_html_e('Reset all filters', 'jobcircle-frame') ?>
											</span></button>
										<a href="#" class="btn btn-text btn-sm">
											<?php esc_html_e('Reset all filters', 'jobcircle-frame') ?>
										</a>
									</div>
								</form>
							</aside>
							<div class="row justify-content-center jobcircle-alljobs-list">
								<?php echo jobcircle_jobs_simple_new_grid_four($atts); ?>
							</div>
						</div>
						<div class="col-12 col-lg-5">
							<div class="aside-map">
								<div id="map"></div>
							</div>
						</div>
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
add_shortcode('jobcircle_job_grid', 'jobcircle_job_grid_frontend');
function jobcircle_jobs_simple_new_grid_four($atts)
{
	ob_start();
	global $job_map_items;
	$numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
	$orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
	$page_numbr = get_query_var('paged');
	$order = "DESC";
	if (isset($_GET['sortby']) && $_GET['sortby'] == 'asc') {
		$orderby = 'title';
		$order = 'ASC';
	}
	$args = jobcircle_listing_jobs_query_args($atts);
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
			$permalinkget = get_the_permalink($post);
			$image = wp_get_attachment_image_src(get_post_thumbnail_id($post), 'single-post-thumbnail');
			$min_salary = get_post_meta($post, 'jobcircle_field_min_salary', true);
			$max_salary = get_post_meta($post, 'jobcircle_field_max_salary', true);
			$latitue = get_post_meta($post, 'jobcircle_field_loc_latitude', true);
			$longitude = get_post_meta($post, 'jobcircle_field_loc_longitude', true);
			$job_salary = jobcircle_job_salary_str($post);
			$job_type = get_post_meta($post, 'jobcircle_field_job_type', true);
			$job_img_url = jobcircle_job_thumbnail_url($post);
			$job_location = jobcircle_post_location_str($post);
			$categories = get_the_terms($post, 'job_category');
			$skills = wp_get_post_terms($post, 'job_skill');
			$job_type_str = jobcircle_job_type_ret_str($job_type);
			$job_post = get_post($post);
			$post_author = $job_post->post_author;
			$post_employer_id = jobcircle_user_employer_id($post_author);
			if ($post_employer_id > 0 && get_post_type($post_employer_id) == 'employer') {
				$post_author_name = get_the_title($post_employer_id);
				$post_author_url = get_the_permalink($post_employer_id);
			} else {
				$author_user_obj = get_user_by('id', $post_author);
				$post_author_name = $author_user_obj->display_name;
			}
			$author_id = get_the_author_meta('url');
			$author_profile_link = get_author_posts_url($author_id);
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
			if (in_array($post, $fav_jobs)) {
				$like_btn_class = 'jobcircle-alrdy-favjab';
				$fav_icon_class = 'profile-btn';
				$follow = 'fa fa-heart';
			}
			if (!empty($latitue) && !empty($longitude)) {
				
			ob_start();
			?>
			{
				lat: <?php echo jobcircle_esc_the_html($latitue); ?>,
				lng: <?php echo jobcircle_esc_the_html($longitude); ?>,
				imageSrc: '<?php echo jobcircle_esc_the_html($job_img_url); ?>',
				title: "<?php echo jobcircle_esc_the_html($title); ?>",
				// description: "This is a description text.",
				// phone: "+1 212 456 7890",
				// siteLink: "<a href='<?php echo get_permalink(); ?>' target='_blank'>Site Link</a>",
			},
			<?php
			$job_map_items .= ob_get_clean();
            }
			if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list') {
				?>
				<div class="col-12 mb-15 mb-md-20">
					<!-- Popular Jobs Box -->
					<article class="popular-jobs-box">
						<div class="box-holder">
							<div class="job-info">
								<?php if (!empty($permalinkget) && !empty($job_img_url)) { ?>
									<div class="img-holder">
										<a href="<?php echo esc_html($permalinkget); ?>">
											<img src="<?php echo esc_url_raw($job_img_url) ?>" width="78" height="78"
												alt="Image Description">
										</a>
									</div>
								<?php } ?>
								<div class="textbox">
									<a href="" class="btn-bookmark <?php echo esc_html($like_btn_class); ?> "
										data-id="<?php echo esc_html($post); ?>"><i
											class=" <?php echo esc_html($fav_icon_class); ?> position-absolute <?php echo esc_html($follow); ?>"></i></a>
									<?php if (!empty($permalinkget) && !empty($title)) { ?>
										<a href="<?php echo esc_html($permalinkget); ?>">
											<h3 class="h5">
												<?php echo esc_html($title); ?>
											</h3>
										</a>
									<?php } ?>
									<ul class="meta-list">
										<?php if (!empty($post_author_url) && !empty($post_author_name)) { ?>
											<li>
												<span class="text">
													<?php echo esc_html_e('By', 'jobcircle-frame') ?>
													<a href="<?php echo esc_html($post_author_url); ?>" class="myclass">
														<?php echo esc_html($post_author_name); ?>
													</a>
												</span>
											</li>
										<?php }
										if (!empty($job_location)) { ?>
											<li><i class="jobcircle-icon-map-pin"></i><span class="text">
													<?php echo esc_html($job_location); ?>
												</span></li>
										<?php } ?>
									</ul>
									<ul class="tags-list">
										<?php
										if (!empty($skills)) {
											foreach ($skills as $skill) { ?>
												<li><span class="tag">
														<?php echo esc_html($skill->name) ?>
													</span></li>
											<?php }
										} ?>
									</ul>
								</div>
							</div>
							<footer class="jobs-foot">
								<?php if (!empty($job_salary)) { ?>
									<strong class="amount">
										<?php echo esc_html($job_salary); ?>
									</strong>
								<?php } ?>
								<a href="javascript:;"
									class="jobcircle-det-applybtn jobdet-applybtn-act btn btn-green btn-sm jobcircle-aplybtn-con"
									data-id="<?php echo esc_html($post) ?>" data-bs-toggle="modal"
									data-bs-target="#jobcircle-apply-job-popup">
									<span class="btn-text">
										<?php echo esc_html_e('Apply Now', 'jobcircle-frame') ?>
									</span></a>
							</footer>
						</div>
					</article>
				</div>
			<?php } else { ?>
				<div class="col-12 col-md-6 col-xxxl-4 mb-15 mb-md-20">
					<!-- Job Card -->
					<div class="job-card alt">
						<div class="inner-box">
							<?php if (!empty($job_type_str)) { ?>
								<span class="job-type">
									<img src="<?php echo Jobcircle_Plugin::root_url() ?>/images/clock-icon.svg" width="20" height="22"
										alt="Duration">
									<?php echo esc_html($job_type_str['title']); ?>
								</span>
							<?php }
							if (!empty($permalinkget) && !empty($title)) { ?>
								<a href="<?php echo esc_html($permalinkget); ?>">
									<h3>
										<?php echo esc_html($title); ?>
									</h3>
								</a>
							<?php }
							if (!empty($job_salary)) { ?>
								<strong class="salary-range">
									<?php echo esc_html($job_salary) ?>
								</strong>
							<?php } ?>
						</div>
						<div class="card-footer">
							<?php if (!empty($permalinkget) && !empty($job_img_url)) { ?>
								<div class="img"><a href="<?php echo esc_html($permalinkget); ?>"><img
											src="<?php echo esc_url_raw($job_img_url); ?>" width="68" height="68" alt="image"></a></div>
							<?php } ?>
							<div class="bottom-box">
								<div class="info-row">
									<?php
									if (!empty($categories)) {
									    $counter=1;
										foreach ($categories as $category) { 
										if($counter==1){?>
											<strong>
												<?php echo esc_html($category->name); ?>
											</strong>
										<?php }else{
										    break;
										}
									$counter++ ;
									}
									}
									if (!empty($job_location)) { ?>
										<p><i class="jobcircle-icon-map-pin"></i>
											<?php echo esc_html($job_location); ?>
										</p>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php
			}
		}
	} else {
		?>
		<p>
			<?php echo esc_html_e('No job found.', 'jobcircle-frame') ?>
		</p>
		<?php
	}
	add_action('wp_footer', function () use ($job_map_items) {
		if ($job_map_items != '') {
			?>
			<script>
				function initMap() {
					// Define an array to hold your dynamic location data (e.g., from JSON)
					var locations = [
						<?php echo ($job_map_items) ?>
					];
					var map = new google.maps.Map(document.getElementById("map"), {
						zoom: 5,
						center: { lat: 37.0902, lng: -95.7129 }, // United States coordinates
					});
					var infowindow = new google.maps.InfoWindow();
					// Create custom markers and info windows for your dynamic location data
					for (var i = 0; i < locations.length; i++) {
						(function (i) {
							var marker = new google.maps.Marker({
								position: { lat: locations[i].lat, lng: locations[i].lng },
								map: map,
								title: locations[i].name,
								icon: {
									url: "<?php echo Jobcircle_Plugin::root_url() ?>/images/map-ping.png", // Custom pin image URL
									scaledSize: new google.maps.Size(30, 42), // Set the width and height
								},
							});
							// Create a content string for the info window
							var contentString =
								"<div class='map-tooltip'>" +
								"</div>";
							google.maps.event.addListener(marker, "click", function () {
								var geocoder = new google.maps.Geocoder();
								var latlng = { lat: locations[i].lat, lng: locations[i].lng };
								geocoder.geocode({ location: latlng }, function (results, status) {
									if (status === "OK") {
										if (results[0]) {
											// Find the city name in address components
											var cityName = "";
											for (var j = 0; j < results[0].address_components.length; j++) {
												for (var k = 0; k < results[0].address_components[j].types.length; k++) {
													if (results[0].address_components[j].types[k] === "locality") {
														cityName = results[0].address_components[j].long_name;
														break;
													}
												}
											}
											// Concatenate location name, image, and address from geocoding results
											var locationInfo =
												"<div class='map-tooltip'>" +
												"<div class='tooltip-image'>" +
												"<img src='" + locations[i].imageSrc + "' alt='Image Description'>" +
												"</div>" +
												"<strong class='tooltip-title'>" + locations[i].title + "</strong>" +
												"<p class='location-address'><span class='fa-solid fa-location-dot address-pin'></span> " + "<span class='address-text'>" + results[0].formatted_address + "</span></p>"
											"</div>";
											// Create a new contentString for each click
											var newContentString = contentString + locationInfo;
											infowindow.setContent(newContentString);
											infowindow.open(map, marker);
										} else {
											console.error("No results found");
										}
									} else {
										console.error("Geocoder failed due to: " + status);
									}
								});
							});
						})(i);
					}
				}
			</script>
			<?php
		}
	}, 1);
	//also this one
	if ($total_posts > $numofpost) {
		?>
		<?php echo jobcircle_pagination($query, true);
		add_action('wp_footer', function () {
			?>
			<script>
				jQuery(document).on('click', '.jobcircle-follower-btn', function () {
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
							action: 'jobcircle_candidate_fav_job_jobcircle_job_grid'
						},
						success: function (data) {
							var totalFavorites = data.total_favorites;
							_this.removeClass('jobcircle-follower-btn');
							_this.addClass('jobcircle-alrdy-favjab');
							_this.addClass('fa fa-heart');
						},
						error: function () {
							this_icon.attr('class', 'profile-btn position-absolute');
						}
					});
				});
				jQuery(document).on('click', '.jobcircle-alrdy-favjab', function () {
					var _this = jQuery(this);
					var this_icon = _this.find('i');
					var post_id = _this.data('id');
					jQuery.ajax({
						type: "POST",
						dataType: "json",
						url: jobcircle_cscript_vars.ajax_url,
						data: {
							post_id: post_id,
							action: 'jobcircle_candidate_remove_jobcircle_job_grid'
						},
						success: function (data) {
							var totalFavorites = data.total_favorites;
							_this.removeClass('jobcircle-alrdy-favjab');
							_this.addClass('jobcircle-follower-btn');
							_this.addClass('fa fa-heart-o');
						},
						error: function () {
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
	// Restore original post data.
	wp_reset_postdata();
	?>
	<?php
	$output = ob_get_clean();
	return $output;
}
add_action('wp_ajax_jobcircle_simple_job_filters_new_submit_call_four', 'jobcircle_simple_job_filters_new_submit_call_four');
add_action('wp_ajax_nopriv_jobcircle_simple_job_filters_new_submit_call_four', 'jobcircle_simple_job_filters_new_submit_call_four');
function jobcircle_simple_job_filters_new_submit_call_four()
{
	$atts = array(
		'numofpost' => $_POST['numposts'],
		'orderby' => $_POST['orderby']
	);
	$html = jobcircle_jobs_simple_new_grid_four($atts);
	wp_send_json(array('html' => $html));
}
// for favourite button
add_action('wp_ajax_jobcircle_candidate_fav_job_jobcircle_job_grid', 'jobcircle_candidate_fav_job_jobcircle_job_grid');
add_action('wp_ajax_nopriv_jobcircle_candidate_fav_job_jobcircle_job_grid', 'jobcircle_candidate_fav_job_jobcircle_job_grid');
function jobcircle_candidate_fav_job_jobcircle_job_grid()
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
add_action('wp_ajax_jobcircle_candidate_remove_jobcircle_job_grid', 'jobcircle_candidate_remove_jobcircle_job_grid');
add_action('wp_ajax_nopriv_jobcircle_candidate_remove_jobcircle_job_grid', 'jobcircle_candidate_remove_jobcircle_job_grid');
function jobcircle_candidate_remove_jobcircle_job_grid()
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
}
;
