<?php
function get_custom_postc_categories() {
    $categories = get_terms(array(
        'taxonomy' => 'candidate_cat',
        'hide_empty' => false,
    ));

    $category_options = array();

    if ($categories && !is_wp_error($categories)) {
        foreach ($categories as $category) {
            $category_options[wp_specialchars_decode($category->name)] = $category->slug;
        }
    }

    return $category_options;
}
function jobcircle_jobs_column_candidate()
{
	vc_map(
		array(
			'name' => __('Candidate Column Style'),
			'base' => 'jobcircle_jobs_column_candidate',
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
					'heading' => __('Candidate Column Style'),
					'param_name' => 'candidate_column_style',
					'value' => array(
						'Select Style' => '',
						'3 Column Style' => 'column_style_three',
						'4 Column Style' => 'column_style_four',
					),
				),
			  array(
					'type' => 'dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Select Category For Post'),
					'param_name' => 'category_selector',
					'value' => array_merge(
						array('Select Category' => ''),
						get_custom_postc_categories()
					),
				),
			)
		)
	);
}
add_action('vc_before_init', 'jobcircle_jobs_column_candidate');
add_action('wp_head', function () {
});
// popular category frontend
function jobcircle_jobs_column_candidate_frontend($atts, $content)
{
	$atts = shortcode_atts(
		array(
			'orderby' => '',
			'numofpost' => '',
			'candidate_column_style' => '',
			'category_selector' => '',
			
		),
		$atts,
		'jobcircle_jobs_column_candidate'
	);
	$orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
	$numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
    $selectedcategory  = isset($atts['category_selector']) ? $atts['category_selector'] : '';
  

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

	$output = '';

	ob_start();
	?>
	<section class="section section-categories section-theme-1 pt-35 pt-md-50 pt-lg-75 pt-xl-95 pb-35 pb-md-50 pb-xl-75 theme_sevenb">
		<div class="container">
			<div class="jobcircle-all-listing-con row justify-content-center">
					<div class="col-12 <?php echo jobcircle_esc_the_html($col) ?> col-xxl-9">
						<?php
						$posts = get_posts([
							'post_type' => 'candidates',
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
							<h1 class="h5 mb-25 mb-lg-0"><?php esc_html_e('Showing 1 -', 'jobcircle-frame') ?> <?php echo jobcircle_esc_the_html($numofpost); ?> <?php echo esc_html_e('of' , 'jobcircle-frame')?> <?php echo jobcircle_esc_the_html($job_count); ?></h1>
							<div class="subhead-filters">
								<div class="subhead-filters-item">
									<label><?php echo esc_html_e('Sort By' , 'jobcircle-frame')?></label>
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
									<a href="?view=grid"><button class="btn <?php echo jobcircle_esc_the_html($gridactive) ?>" type="button">
											<img src="<?php echo Jobcircle_Plugin::root_url() ?>/images/grid-icon.svg" width="22" height="22" alt="Grid">
										</button></a>
									<?php
									if (!empty($listactive)) {
									?>
										<a href="?view=list"><button class="btn <?php echo jobcircle_esc_the_html($listactive) ?>" type="button">
											<?php
										}
											?>
											<img src="<?php echo Jobcircle_Plugin::root_url() ?>/images/list-icon.svg" width="20" height="20" alt="List">
											</button></a>
								</div>
							</div>
						</header>
						<div class="row justify-content-center  jobcircle-allemployer-list">
							<?php

							echo jobcircle_candidate_column_page_style($atts);  ?>
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
					
					
						add_shortcode('jobcircle_jobs_column_candidate', 'jobcircle_jobs_column_candidate_frontend');

						function jobcircle_candidate_column_page_style($atts)
						{
	
    $selectedcategory  = isset($atts['category_selector']) ? $atts['category_selector'] : '';
    
							ob_start();
							global $job_map_items;
							$numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
							$orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
							$candidate_column_style = isset($atts['candidate_column_style']) ? $atts['candidate_column_style'] : '';


                   			$page_numbr = get_query_var('paged');
							$order = 'DESC';
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
								'post_type' => 'candidates', //enter post type name static
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
							if (isset($_REQUEST['candidate_cat']) && $_REQUEST['candidate_cat'] != '') {
                              $selectedcategory = $_REQUEST['candidate_cat'];
                                }
                                if($selectedcategory != ''){
                                    
								$tax_query = array(
								    array(
									'taxonomy' => 'candidate_cat',
									'field' => 'slug',
									'terms' => $selectedcategory,
								    ),
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
							
							$current_date = date('Y-m-d H:i:s');
							$meta_query[] = array('relation' => 'OR',
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
                                            );
							
							$meta_query = apply_filters('jobcircle_listing_filters_meta_query', $meta_query, 'employer');

							if (!empty($tax_query)) {
								$args['tax_query'] = $tax_query;
							}

							if (!empty($meta_query)) {
								$args['meta_query'] = $meta_query;
							}
							
					$col_style = 'col-lg-3';
                    if($atts['candidate_column_style'] == 'column_style_three') {
                        $col_style = 'col-lg-3';
                    }elseif($atts['candidate_column_style'] == 'column_style_four') {
                        $col_style = 'col-lg-4';
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
                                	     $post_author_link = get_permalink($post_employer_id);
                                	 } else {
                                	     $author_user_obj = get_user_by('id', $post_author);
                                	     $post_author_name = $author_user_obj->display_name;
                                	     $post_author_link = get_author_posts_url($post_author);
                                	 }
									$title = get_the_title($post);
									$permalinkget = get_the_permalink($post);
									$posted = get_the_time('U');
									$minut =  human_time_diff($posted, current_time('U')) . " ago";
									$content = get_the_content();
									$admin = get_the_author();
									$author_id = get_the_author_meta('url');
									$author_profile_link = get_author_posts_url($author_id);
									$experince = get_post_meta($post, 'experince', true);
									$latitue = get_post_meta($post, 'jobcircle_field_loc_latitude', true);
									$longitude = get_post_meta($post, 'jobcircle_field_loc_longitude', true);
                                    $facebook_url = get_post_meta($post, 'jobcircle_field_facebook_url', true);
                                    $twitter_url = get_post_meta($post, 'jobcircle_field_twitter_url', true);
                                    $linkedin_url = get_post_meta($post, 'jobcircle_field_linkedin_url', true);
									$job_salary = jobcircle_job_salary_str($post);
									$job_img_url = jobcircle_job_thumbnail_url($post);
									$job_location = jobcircle_post_location_str($post);
									$skills = wp_get_post_terms($post, 'job_skill');
                                	$job_type = get_post_meta($post, 'jobcircle_field_job_type', true);
                        			$job_type_str = jobcircle_job_type_ret_str($job_type);
                        			$position = get_post_meta($post, 'jobcircle_field_job_title', true);
                        			
									global $current_user;
									$user_id = $current_user->ID;
								
									$fav_jobs = get_user_meta($user_id, 'fav_follower_list', true);
									$fav_jobs = !empty($fav_jobs) ? $fav_jobs : array();
									$like_btn_class = 'jobcircle-follower-btn';
									if(!is_user_logged_in(  )){
										$like_btn_class = 'jobcircle-follower-btn no-user-follower-btn';
									}else{
										if(!jobcircle_user_candidate_id($user_id)){
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
									if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'grid') {

							?>
										<div class="col-12 col-sm-6 <?php echo jobcircle_esc_the_html($col_style) ?> col-xxl-4 mb-15 mb-md-30">
											<!-- Featured Category Box -->
											<article class="featured-category-box">
														<span class="tag"><?php echo jobcircle_esc_the_html($job_type_str['title']); ?></span>
														<?php
												if(!empty($job_img_url)){
													?>

												<div class="img-holder">
													<a href="<?php echo jobcircle_esc_the_html($permalinkget); ?>">
														<img src="<?php echo esc_url_raw($job_img_url); ?>" width="78" height="78" alt="Financial Analyst">
													</a>
												</div>
												<?php } ?>
												<div class="textbox">
													<?php if (!empty($permalinkget)) { ?>
														<a href="<?php echo jobcircle_esc_the_html($permalinkget); ?>">
														<?php } ?>
														<?php if (!empty($title)) { ?>
															<strong class="h6"><?php echo jobcircle_esc_the_html($title) ?></strong>
														<?php } ?>
														</a>
														<?php if (!empty($post_author_name)) { ?>
															<a class="" href="<?php echo jobcircle_esc_the_html($post_author_link) ?>"><span class="subtitle"><?php esc_html_e('By', 'jobcircle-frame') ?> <?php echo jobcircle_esc_the_html($post_author_name) ?></span></a>
														<?php } ?>
														<?php if (!empty($job_location)) { ?>
															<address class="location"><i class="jobcircle-icon-map-pin icon"></i><span class="text"><?php echo jobcircle_esc_the_html($job_location) ?></span></address>
														<?php } ?>
														<div class="job-info">
															<?php if (!empty($minut)) { ?>
																<span class="subtext"><?php echo jobcircle_esc_the_html($minut) ?></span>
															<?php } ?>
															<?php if (!empty($job_salary)) { ?>
																<span class="amount"><strong><?php echo jobcircle_esc_the_html($job_salary) ?></strong></span>
															<?php } ?>
														</div>
														<?php if (!empty($permalinkget)) { ?>
															<a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>" class="btn btn-dark-yellow btn-sm"><span class="btn-text"><span class="text"><?php echo jobcircle_esc_the_html('Apply Now', 'jobcircle-frame') ?></span><i class="jobcircle-icon-chevron-right"></i></span></a>
														<?php } ?>
												</div>
											</article>
										</div>
									<?php } else {  ?>
										<div class="col-12 col-md-6 col-sm-6 <?php echo jobcircle_esc_the_html($col_style) ?> mb-15 mb-md-30 pb-0">
											<!-- Candidate Box -->

											<article class="candidate-box">
												<div class="textbox">
													<a href="" class="pin-job <?php echo jobcircle_esc_the_html($like_btn_class); ?> " data-id="<?php echo jobcircle_esc_the_html($post); ?>"><i class=" <?php echo jobcircle_esc_the_html($fav_icon_class); ?> position-absolute <?php echo jobcircle_esc_the_html($follow); ?>"></i></a>	
													<div class="icon-box p-0">
														<?php if (!empty($permalinkget)) { ?>
															<a href="<?php echo jobcircle_esc_the_html($permalinkget); ?>">
															<?php } ?>
															<?php if (!empty($job_img_url)) { ?>
																<img src="<?php echo esc_url_raw($job_img_url); ?>" width="102" height="102" alt="Alex Carey">
															<?php } ?>
															</a>
													</div>
													<?php if (!empty($permalinkget) || !empty($title)) { ?>
														<h2 class="h5"><a href="<?php  echo  esc_html($permalinkget) ?>"><?php echo jobcircle_esc_the_html($title); ?></a>
														<?php } ?>
														</h2>
														<strong class="subtitle">
																	<?php echo jobcircle_esc_the_html($position); ?>
														</strong>
														<ul class="social-links">
															<?php if(!empty($facebook_url)) { ?>
																<li><a href="<?php echo jobcircle_esc_the_html($facebook_url); ?>"><i class="jobcircle-icon-facebook"></i></a></li>
															<?php } ?>
															<?php if(!empty($twitter_url)) { ?>
																<li><a href="<?php echo jobcircle_esc_the_html($twitter_url); ?>"><i class="jobcircle-icon-twitter"></i></a></li>
															<?php } ?>
															<?php if(!empty($linkedin_url)) { ?>
																<li><a href="<?php echo jobcircle_esc_the_html($linkedin_url); ?>"><i class="jobcircle-icon-linkedin"></i></a></li>
															<?php } ?>
														</ul>
														<?php if(!empty($permalinkget)) { ?>
															<a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>" class="btn btn-primary btn-sm"><span class="btn-text">
																<?php } ?>
																<?php esc_html_e('View Resume', 'jobcircle-frame'); ?>
																</span></a>
												</div>
											</article>

										</div>
								<?php
									}
								}
							} else {       ?>
								<p><?php esc_html_e('No job found.', 'jobcircle-frame'); ?></p>
							<?php
							}
							
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
							action: 'jobcircle_candidates_column_page_style'
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
						type: "POST",int 
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
		add_action( 'wp_footer', function() {
            ?>
            <script>
        
        jQuery(document).on ('click', '.jobcircle-follower-btn', function() {
        
                            
        var _this = jQuery(this);
        if (_this.hasClass('no-user-follower-btn')){
        jobcircle_submit_msg_alert('<?php esc_html_e('Only logged-in user can save this.' , 'jobcircle-frame') ?>', 'jobcircle-alert-warning');
        return false ; 
        }
        if (_this.hasClass('no-member-follower-btn')){
        jobcircle_submit_msg_alert('<?php esc_html_e('Only a candidate member can save this.' , 'jobcircle-frame') ?>', 'jobcircle-alert-warning');
        return false ; 
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
            action: 'jobcircle_candidate_fav_job_candidates_column_cond'
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
        action: 'jobcircle_candidate_remove_jobi_list_candidate_column_cond'
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
        
        } );

							}
							wp_reset_postdata(); ?>

<?php
							$output = ob_get_clean();
							return $output;
						}

						add_action('wp_ajax_jobcircle_candidates_column_page_style', 'jobcircle_candidates_column_page_style');
						add_action('wp_ajax_nopriv_wp_ajax_jobcircle_candidates_column_page_style', 'jobcircle_candidates_column_page_style');

						function jobcircle_candidates_column_page_style()
						{

							$atts = array(
								'numofpost' => $_POST['numposts'],
								'orderby' => $_POST['orderby']
							);

							$html = jobcircle_candidate_column_page_style($atts);

							wp_send_json(array('html' => $html));
						}


						              
// for favourite button
add_action('wp_ajax_jobcircle_candidate_fav_job_candidates_column_cond', 'jobcircle_candidate_fav_job_candidates_column_cond');
add_action('wp_ajax_nopriv_jobcircle_candidate_fav_job_candidates_column_cond', 'jobcircle_candidate_fav_job_candidates_column_cond');
function jobcircle_candidate_fav_job_candidates_column_cond() {
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


add_action('wp_ajax_jobcircle_candidate_remove_jobi_list_candidate_column_cond', 'jobcircle_candidate_remove_jobi_list_candidate_column_cond');
add_action('wp_ajax_nopriv_jobcircle_candidate_remove_jobi_list_candidate_column_cond', 'jobcircle_candidate_remove_jobi_list_candidate_column_cond');
function jobcircle_candidate_remove_jobi_list_candidate_column_cond() {
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
