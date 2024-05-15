<?php
function jobcircle_jobs_comapny_list_style()
{
	vc_map(
		array(
			'name' => __('Company list Styles'),
			'base' => 'jobcircle_jobs_comapny_list_style',
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
					'heading' => __('Filter sidebar Alignment'),
					'param_name' => 'filter_sidebar_alignment',
					'value' => array(
						'Select Style' => '',
						'Filter Left' => 'filter_left',
						'Filter Right' => 'filter_right',
					),
				),
			)
		)
	);
}
add_action('vc_before_init', 'jobcircle_jobs_comapny_list_style');
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
function jobcircle_jobs_comapny_list_style_frontend($atts, $content)
{
	$atts = shortcode_atts(
		array(
			'orderby' => '',
			'numofpost' => '',
			'filter_sidebar_alignment' => '',
			'map_embed_selection' => '',
		),
		$atts,
		'jobcircle_jobs_comapny_list_style'
	);
	$orderby = isset($atts['orderby']) && !empty($atts['orderby']) ? $atts['orderby'] : '';
	$numofpost = isset($atts['numofpost']) && !empty($atts['numofpost']) ? $atts['numofpost'] : '';
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
							this_form.removeClass('ajax-processing'); //
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
	$output = '';
	ob_start();
	?>
	<section class="section section-categories section-theme-1 pt-35 pt-md-50 pt-lg-75 pt-xl-95 pb-35 pb-md-50 pb-xl-75">
		<div class="container">
			<div class="jobcircle-all-listing-con">
				<?php
				$sidebaralign = '';
				if ($atts['filter_sidebar_alignment'] == 'filter_left') {
					$sidebaralign = '';
				} elseif ($atts['filter_sidebar_alignment'] == 'filter_right') {
					$sidebaralign = 'flex-md-row-reverse';
				}
				?>
				<div class="row <?php echo jobcircle_esc_the_html($sidebaralign); ?>">
					<div class="col-12 col-lg-4 col-xxl-3">
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
										<input class="form-control" name="keyword" placeholder="<?php esc_html_e('Search with keyword', 'jobcircle-frame') ?>" type="text">
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
															'taxonomy' => 'employer_cat',															
														)
													);
													if (!empty($cat_terms)) {
														foreach ($cat_terms as $cat_term) {
													?>
															<li>
																<label class="custom-checkbox">
																	<input id="cat-<?php echo jobcircle_esc_the_html($cat_term->term_id); ?>" name="employer_cat" value="<?php echo jobcircle_esc_the_html($cat_term->slug); ?>" type="checkbox">
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
												<a href="#" class="btn btn-primary btn-sm buttonShowMore">
													<span class="btn-text"><?php esc_html_e('Show', 'jobcircle-frame') ?>
														<span class="show"><?php esc_html_e('More', 'jobcircle-frame') ?></span>
														<span class="hide"><?php esc_html_e('Less', 'jobcircle-frame') ?></span>
													</span>
												</a>
											</div>
										</div>
									</div>
								</div>
								
								<!-- Filter Buttons -->
								<div class="filter-buttons">
									<input type="hidden" name="numposts" value="<?php echo jobcircle_esc_the_html($numofpost); ?>">
									<input type="hidden" name="orderby" value="<?php echo jobcircle_esc_the_html($orderby); ?>">
									<input type="hidden" name="action" value="jobcircle_company_list_styleone">
									<button type="submit" class="btn btn-green btn-sm"><span class="btn-text submit-filters-button"><?php echo esc_html_e('Apply Filter', 'jobcircle-frame') ?></span></button>
								</div>
							</form>
						</aside>
					</div>
					<div class="col-12 col-lg-8 col-xxl-9">
						<?php
						$posts = get_posts([
							'post_type' => 'employer',
							'post_status' => 'publish',
							'numberposts' => -1
						]);

						$job_count = count($posts);
						// Search keyword
						if (isset($_REQUEST['keyword'])) {
							$keyword = $_REQUEST['keyword'];
							$posts['s'] = esc_html($keyword);
						}
						?>
						<header class="page-subheader mb-30 mb-md-40 d-lg-flex align-items-center justify-content-between">
							<h3 class="h6 mb-25 mb-lg-0"><?php esc_html_e('All', 'jobcircle-frame') ?> <?php echo esc_html($job_count); ?> <?php esc_html_e('jobs found', 'jobcircle-frame') ?></h3>
							<div class="subhead-filters">
								<div class="subhead-filters-item">
									<label><?php esc_html_e('Sort By', 'jobcircle-frame') ?></label>
									<form id="jobForm" class="form-group d-lg-flex align-items-center" method="get">
										<select class="select2" name="sortby" data-placeholder="Sort by" onchange="submitForm()">
											<option value="recent"><?php esc_html_e('Recent Jobs', 'jobcircle-frame') ?></option>
											<option value="asc" <?php echo isset($_GET['sortby']) && $_GET['sortby'] == 'asc' ? 'selected' : ''; ?>><?php esc_html_e('Sort by Name', 'jobcircle-frame') ?></option>
										</select>
										</from>
								</div>
								<div class="grid-buttons">
									<?php
									$listactive = 'btn-list active';
									$gridactive = 'btn-grid';
									if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'grid') {
										$listactive = 'btn-list';
										$gridactive = 'btn-grid active';
									}
									?>
									<a href="?view=grid"><button class="btn <?php echo esc_html($gridactive) ?>" type="button">
											<img src="<?php echo Jobcircle_Plugin::root_url() ?>/images/grid-icon.svg" width="22" height="22" alt="Grid">
										</button></a>
									<?php
									if (!empty($listactive)) {
									?>
										<a href="?view=list"><button class="btn <?php echo esc_html($listactive) ?>" type="button">
											
											<img src="<?php echo Jobcircle_Plugin::root_url() ?>/images/list-icon.svg" width="20" height="20" alt="List">
											</button></a>
											<?php
										}
											?>
								</div>
							</div>
						</header>
						<div class="row justify-content-center  jobcircle-allemployer-list">
							<?php
							echo jobcircle_company_list_style($atts);
							$output = ob_get_clean();
							return $output;
						}
						add_shortcode('jobcircle_jobs_comapny_list_style', 'jobcircle_jobs_comapny_list_style_frontend');
						function jobcircle_company_list_style($atts)
						{
							ob_start();
							global $job_map_items;
							$numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
							$orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
							$page_numbr = get_query_var('paged');
							$order = 'DESC';
							if (isset($_GET['sortby']) && $_GET['sortby'] == 'asc') {
								$orderby = 'title';
								$order = 'ASC';
							}
							$args = array(
								'post_type' => 'employer', //enter post type name static
								'post_status' => 'publish',
								'posts_per_page' => $numofpost,
								'order' => $order,
								'paged' => $page_numbr,
								'orderby' =>  $orderby,
							);
							if (isset($_REQUEST['keyword'])) {
								$keyword = $_REQUEST['keyword'];
								$args['s'] = esc_html($keyword);
							}
							// tax query
							$tax_query = array();
							if (isset($_REQUEST['employer_cat'])) {
								$employer_cat = $_REQUEST['employer_cat'];
								$tax_query[] = array(
									'taxonomy' => 'employer_cat',
									'field' => 'slug',
									'terms' => $employer_cat,
								);
							}
							
							$meta_query = array();
		if (isset($_REQUEST['location']) && $_REQUEST['location'] != '') {
			$location = $_REQUEST['location'];
			$meta_query[] = array(
					'key' => 'jobcircle_field_loc_city',
					'value' => esc_html($location),
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
									global $post;
									$post =  get_the_id();
									$job_post = get_post($post);
									$post_author = $job_post->post_author;
									$post_employer_id = jobcircle_user_employer_id($post_author);
									if ($post_employer_id > 0 && get_post_type($post_employer_id) == 'employer') {
										$post_author_name = get_the_title($post_employer_id);
									} else {
										$author_user_obj = get_user_by('id', $post_author);
										$post_author_name = $author_user_obj->display_name;
									}
									$title = get_the_title($post);
									$permalinkget = get_the_permalink($post);
									$posted = get_the_time('U');
									$minut =  human_time_diff($posted, current_time('U')) . "";
									$content = get_the_content();
									$admin = get_the_author();
									$author_id = get_the_author_meta('url');
									$author_profile_link = get_author_posts_url($author_id);
									$experince = get_post_meta($post, 'experince', true);
									$latitue = get_post_meta($post, 'jobcircle_field_loc_latitude', true);
									$longitude = get_post_meta($post, 'jobcircle_field_loc_longitude', true);
									$job_salary = jobcircle_job_salary_str($post);
									$job_img_url = jobcircle_job_thumbnail_url($post);
									$job_location = jobcircle_post_location_str($post);
									$categories = get_the_terms($post, 'employer_cat');
									$skills = wp_get_post_terms($post, 'job_skill');
									$job_salary = jobcircle_job_salary_str($post);
									$job_img_url = jobcircle_job_thumbnail_url($post);
									$job_location = jobcircle_post_location_str($post);
									$categories = get_the_terms($post, 'employer_cat');
									$skills = wp_get_post_terms($post, 'job_skill');
									$job_type = get_post_meta($post, 'jobcircle_field_job_type', true);
									$job_type_str = jobcircle_job_type_ret_str($job_type);
									if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'grid') {
							?>
										<div class="col-12 col-sm-6 col-xxl-4 mb-15 mb-md-30">
											<!-- Featured Category Box -->
											<article class="featured-category-box">
												<?php
												if (!empty($categories)) {
													foreach ($categories as $category) {   ?>
														<span class="tag"><?php echo esc_html($category->name); ?></span>
												<?php 	}
												}  ?>
												<div class="img-holder">
													<?php
													if (!empty($permalinkget)) {
													?>
														<a href="<?php echo esc_html($permalinkget); ?>">
														<?php
													} ?>
														<?php
														if (!empty($job_img_url)) {
														?>
															<img src="<?php echo esc_url_raw($job_img_url); ?>" width="78" height="78" alt="Financial Analyst">
														<?php
														} ?>
														</a>
												</div>
												<div class="textbox">
													<?php
													if (!empty($permalinkget)) {
													?>
														<a href="<?php echo esc_html($permalinkget); ?>">
														<?php
													} ?>
														<?php
														if (!empty($title)) {
														?>
															<strong class="h6"><?php echo esc_html($title) ?></strong>
														<?php
														} ?>
														</a>
														<?php
														if (!empty($post_author_name)) {
														?>
															<span class="subtitle"><?php esc_html_e('By', 'jobcircle-frame') ?> <?php echo esc_html($post_author_name) ?></span>
														<?php
														} ?>
														<?php
														if (!empty($job_location)) {
														?>
															<address class="location"><i class="jobcircle-icon-map-pin icon"></i><span class="text"><?php echo esc_html($job_location) ?></span></address>
														<?php
														} ?>
														<div class="job-info">
															<?php
															if (!empty($minut)) {
															?>
																<span class="subtext"><?php echo esc_html($minut) ?></span>
															<?php
															}  ?>
															<?php
															if (!empty($job_salary)) {
															?>
																<span class="amount"><strong><?php echo esc_html($job_salary) ?></strong></span>
															<?php
															} ?>
														</div>
														<?php
														if (!empty($permalinkget)) {
														?>
															<a href="<?php echo esc_html($permalinkget) ?>" class="btn btn-dark-yellow btn-sm"><span class="btn-text"><span class="text"><?php echo esc_html('Apply Now', 'jobcircle-frame') ?></span><i class="jobcircle-icon-chevron-right"></i></span></a>
														<?php
														} ?>
												</div>
											</article>
										</div>
									<?php } else {  ?>
										<div class="col-12 col-md-6 col-lg-6 mb-15 mb-md-30">
											<!-- Candidate Box -->
											<article class="candidate-box">
												<div class="textbox">
													<?php
													if (!empty($permalinkget)) {
													?>
														<a href="<?php echo esc_html($permalinkget) ?>" class="pin-job"><i <?php
																														} ?> class="jobcircle-icon-bookmark"></i></a>
														<div class="icon-box">
															<?php
															if (!empty($permalinkget)) {
															?>
																<a href="<?php echo esc_html($permalinkget); ?>">
																<?php
															}  ?>
																<?php
																if (!empty($job_img_url)) {
																?>
																	<img src="<?php echo esc_url_raw($job_img_url) ?>" width="68" height="66" <?php
																																			}  ?> alt="Jerry Media">
																</a>
														</div>
														<h2 class="h5"><a <?php
																			if (!empty($permalinkget)) {
																			?> href="<?php echo esc_html($permalinkget) ?>"><?php echo esc_html($title) ?></a></h2>
													<?php
																			} ?>
													<?php
													if (!empty($job_location)) {
													?>
														<strong class="subtitle"><?php echo esc_html($job_location) ?></strong>
													<?php
													}  ?>
													<a href="#" class="btn btn-primary btn-sm"><span class="btn-text"><?php esc_html_e('Follow us', 'jobcircle-frame') ?></span></a>
													<!-- Star Ratings -->
													<ul class="star-ratings large">
														<li><i class="jobcircle-icon-star filled"></i></li>
														<li><i class="jobcircle-icon-star filled"></i></li>
														<li><i class="jobcircle-icon-star filled"></i></li>
														<li><i class="jobcircle-icon-star filled"></i></li>
														<li><i class="jobcircle-icon-star"></i></li>
													</ul>
												</div>
												<ul class="stats-list">
													<li>
														<?php
														if (!empty($skills)) {
															foreach ($skills as $skill) {   ?>
																<span class="text">
																	<?php echo esc_html($skill->name) ?>
																</span>
														<?php 	}
														}  ?>
													</li>
													<li>
														<?php
														if (!empty($vacancies)) {
														?>
															<span class="text compnay_listf"><?php echo esc_html($vacancies) ?></span>
														<?php
														}
														?>
													</li>
												</ul>
											</article>
										</div>
								<?php
									}
								}
							} else {       ?>
								<p><?php esc_html('No job found.', 'jobcircle-frame') ?></p>
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
							add_action('wp_footer', function () use ($job_map_items) {
								if ($job_map_items != '') {
	?>
			<script>
				var daysRemaining = <?php echo jobcircle_esc_the_html($remainingDays); ?>;

				function updateCountdown() {
					if (daysRemaining >= 0) {
						var countdownElements = document.querySelectorAll('.text-note strong');
						countdownElements.forEach(function(element) {
							element.textContent = daysRemaining + " Days To left";
						});
						daysRemaining--;
					} else {
						var countdownElements = document.querySelectorAll('.text-note strong');
						countdownElements.forEach(function(element) {
							element.textContent = "Application period has ended";
						});
					}
				}
				updateCountdown();
				setInterval(updateCountdown, 24 * 60 * 60 * 1000);
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
							action: 'jobcircle_company_list_styleone'
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
							action: 'jobcircle_candidate_remove_favourite_ajax_index'
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
			<script>
				function initMap() {
					// Define an array to hold your dynamic location data (e.g., from JSON)
					var locations = [
						<?php echo ($job_map_items) ?>
					];
					var map = new google.maps.Map(document.getElementById("map"), {
						zoom: 5,
						center: {
							lat: 37.0902,
							lng: -95.7129
						}, // United States coordinates
					});
					var infowindow = new google.maps.InfoWindow();
					// Create custom markers and info windows for your dynamic location data
					for (var i = 0; i < locations.length; i++) {
						(function(i) {
							var marker = new google.maps.Marker({
								position: {
									lat: locations[i].lat,
									lng: locations[i].lng
								},
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
							google.maps.event.addListener(marker, "click", function() {
								var geocoder = new google.maps.Geocoder();
								var latlng = {
									lat: locations[i].lat,
									lng: locations[i].lng
								};
								geocoder.geocode({
									location: latlng
								}, function(results, status) {
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
							if ($total_posts > $numofpost) {
		?>
		<?php echo jobcircle_pagination($query, true);
		?>
	<?php
							}
							wp_reset_postdata(); ?>
<?php
							$output = ob_get_clean();
							return $output;
						}
						add_action('wp_ajax_jobcircle_company_list_styleone', 'jobcircle_company_list_styleone');
						add_action('wp_ajax_nopriv_wp_ajax_jobcircle_company_list_styleone', 'jobcircle_company_list_styleone');
						function jobcircle_company_list_styleone()
						{
							$atts = array(
								'numofpost' => $_POST['numposts'],
								'orderby' => $_POST['orderby']
							);
							$html = jobcircle_company_list_style($atts);
							wp_send_json(array('html' => $html));
						}
