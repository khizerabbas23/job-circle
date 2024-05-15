<?php
function jobcircle_jobs_grid_ten_all_grid_3_theme_1_left_filter_top()
{
	vc_map(
		array(
			'name' => __('Job Grid 90'),
			'base' => 'jobcircle_jobs_grid_ten_all_grid_3_theme_1_left_filter_top',
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
				array(
					'type' => 'dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Page View'),
					'param_name' => 'page_view',
					'value' => array(
						'Select Style' => '',
						'Full Page View' => 'full_page_view',
						'Default Page View' => 'default_page_view',
					),
				),
				array(
					'type' => 'dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Map Embed Selection'),
					'param_name' => 'map_embed_selection',
					'value' => array(
						'Select Style' => '',
						'Top Map' => 'top_map',
						'Top Map With Filter' => 'top_map_with_filter',
					),
				),
			)
		)
	);
}
add_action('vc_before_init', 'jobcircle_jobs_grid_ten_all_grid_3_theme_1_left_filter_top');
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
function jobcircle_jobs_grid_ten_all_grid_3_theme_1_left_filter_top_frontend($atts, $content)
{
	$atts = shortcode_atts(
		array(
			'orderby' => '',
			'numofpost' => '',
			'filter_sidebar_alignment' => '',
			'page_view' => '',
			'map_embed_selection' => '',
		),
		$atts,
		'jobcircle_jobs_grid_ten_all_grid_3_theme_1_left_filter_top'
	);
	$orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
	$numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
	$atts['listin_ajax_action'] = 'jobcircle_jobs_grid_ten_theme_1_left_filter';
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
	if ($atts['map_embed_selection'] !== '') {
		$mapfilter = '';
		if ($atts['map_embed_selection'] == 'top_map_with_filter') {
			$mapfilter = 'subvisual-theme-1';
		}
	?>
		<div class="visual-map <?php echo jobcircle_esc_the_html($mapfilter); ?>">
			<div id="map"></div>
			<?php
			if ($atts['map_embed_selection'] == 'top_map_with_filter') {
			?>
				<div class="visual-map-filters">
					<div class="container">
						<form class="form-search form-inline" action="#">
							<div class="fields-holder bg-white text-black d-flex flex-wrap flex-md-nowrap">
								<div class="form-group">
									<label for="rel01"><?php esc_html_e('What are you looking for?', 'jobcircle-frame'); ?></label>
									<div class="form-input">
										<select id="rel01" class="select2" name="state" data-placeholder="<?php esc_html_e('What are you looking for?', 'jobcircle-frame'); ?>">
											<option label="Placeholder"></option>
											<option><?php esc_html_e('Web Developer', 'jobcircle-frame'); ?></option>
											<option><?php esc_html_e('Web Developer', 'jobcircle-frame'); ?></option>
											<option><?php esc_html_e('Web Developer', 'jobcircle-frame'); ?></option>
											<option><?php esc_html_e('Web Developer', 'jobcircle-frame'); ?></option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="rel02"><?php esc_html_e('Category', 'jobcircle-frame'); ?></label>
									<div class="form-input">
										<select id="rel02" class="select2" name="state" data-placeholder="<?php esc_html_e('Category', 'jobcircle-frame'); ?>">
											<option label="Placeholder"></option>
											<?php
											$cat_terms = get_terms(
												array(
													'taxonomy' => 'job_category',
												)
											);
											if (!empty($cat_terms)) {
												foreach ($cat_terms as $cat_term) {
											?>
													<option><?php echo esc_attr($cat_term->name); ?></option>
											<?php
												}
											}
											?>
										</select>
									</div>
								</div>
							</div>
							<button class="btn btn-green btn-sm" type="submit"><span class="btn-text"><?php esc_html_e('Find Job', 'jobcircle-frame'); ?></span></button>
						</form>
					</div>
				</div>
			<?php } ?>
		</div>
	<?php
	}  ?>
	<section class="section section-categories section-theme-1 pt-35 pt-md-50 pt-lg-75 pt-xl-95 pb-35 pb-md-50 pb-xl-75">
		<?php
		$pageview = '';
		if ($atts['page_view'] == 'full_page_view') {
			$pageview = '-fluid';
		} elseif ($atts['page_view'] == 'default_page_view') {
			$pageview = '';
		}
		?>
		<div class="container<?php echo esc_html($pageview); ?>">
			<div class="jobcircle-all-listing-con">
				<?php
				$sidebaralign = '';
				if ($atts['filter_sidebar_alignment'] == 'filter_left') {
					$sidebaralign = '';
				} elseif ($atts['filter_sidebar_alignment'] == 'filter_right') {
					$sidebaralign = 'flex-md-row-reverse';
				}
				?>
				<div class="row <?php echo esc_html($sidebaralign); ?>">
					<div class="col-12 col-lg-4 col-xxl-3">
						<div class="d-flex align-items-center justify-content-between d-lg-none mb-25 filters-head">
							<h2 class="h5"><?php esc_html_e('Filters', 'jobcircle-frame'); ?></h2>
							<a href="#" class="filters-opener"><span></span></a>
						</div>
						<!-- Filters Sidebar -->
						<?php jobcircle_job_listing_filters_sidebar($atts) ?>
					</div>
					<div class="col-12 col-lg-8 col-xxl-9">
						<?php
						$posts = get_posts([
							'post_type' => 'jobs',
							'post_status' => 'publish',
							'numberposts' => -1
						]);
						$job_count = count($posts);
						?>
						<header class="page-subheader mb-30 mb-md-40 d-lg-flex align-items-center justify-content-between">
							<?php if (!empty($job_count)) { ?>
								<h3 class="h6 mb-25 mb-lg-0"><?php esc_html_e('All', 'jobcircle-frame'); ?> <?php echo esc_html($job_count); ?> <?php esc_html_e('jobs found', 'jobcircle-frame'); ?></h3>
							<?php }  ?>
							<div class="subhead-filters">
								<div class="subhead-filters-item">
									<label><?php esc_html_e('Sort By', 'jobcircle-frame'); ?></label>
									<form id="jobForm" class="form-group d-lg-flex align-items-center" method="get">
										<select class="select2" name="sortby" data-placeholder="<?php esc_html_e('Sort By', 'jobcircle-frame'); ?>" onchange="submitForm()">
											<option value="recent"><?php esc_html_e('Recent Jobs', 'jobcircle-frame'); ?></option>
											<option value="asc" <?php echo isset($_GET['sortby']) && $_GET['sortby'] == 'asc' ? 'selected' : ''; ?>> <?php esc_html_e('Sort by Name', 'jobcircle-frame'); ?></option>
										</select>
										</from>
								</div>
								<div class="grid-buttons">
									<?php
									$listactive = 'btn-list';
									$gridactive = 'btn-grid active';
									if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list') {
										$listactive = 'btn-list active';
										$gridactive = 'btn-grid';
									}
									if (!empty($gridactive)) {  ?>
										<a href="?view=grid"><button class="btn <?php echo esc_html($gridactive); ?>" type="button">
												<img src="<?php echo Jobcircle_Plugin::root_url() ?>/images/grid-icon.svg" width="22" height="22" alt="Grid">
											</button></a>
									<?php }
									if (!empty($listactive)) {  ?>
										<a href="?view=list"><button class="btn <?php echo esc_html($listactive); ?>" type="button">
												<img src="<?php echo Jobcircle_Plugin::root_url() ?>/images/list-icon.svg" width="20" height="20" alt="List">
											</button></a>
									<?php } ?>
								</div>
							</div>
						</header>
						<div class="row justify-content-center  jobcircle-alljobs-list">
							<?php echo jobcircle_jobs_grid_ten_theme90($atts); ?>
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
add_shortcode('jobcircle_jobs_grid_ten_all_grid_3_theme_1_left_filter_top', 'jobcircle_jobs_grid_ten_all_grid_3_theme_1_left_filter_top_frontend');
function jobcircle_jobs_grid_ten_theme90($atts)
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
	$args = jobcircle_listing_jobs_query_args($atts);
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
				$post_author_url = get_the_permalink($post_employer_id);
			} else {
				$author_user_obj = get_user_by('id', $post_author);
				$post_author_name = $author_user_obj->display_name;
			}
			$author_id = get_the_author_meta('url');
			$author_profile_link = get_author_posts_url($author_id);
			$title = get_the_title($post);
			$permalinkget = get_the_permalink($post);
			$posted = get_the_time('U');
			$minut =  human_time_diff($posted, current_time('U')) . " ago";
			$author_profile_link = get_author_posts_url($author_id);
			$latitue = get_post_meta($post, 'jobcircle_field_loc_latitude', true);
			$longitude = get_post_meta($post, 'jobcircle_field_loc_longitude', true);
			$job_salary = jobcircle_job_salary_str($post);
			$job_img_url = jobcircle_job_thumbnail_url($post);
			$job_location = jobcircle_post_location_str($post);
			$job_type = get_post_meta($post, 'jobcircle_field_job_type', true);
			$job_type_str = jobcircle_job_type_ret_str($job_type);
			$categories = get_the_terms($post, 'job_category');
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
				<div class="col-12 col-xxl-6 mb-15 mb-xl-30">
					<div class="jobs_info_holder">
						<?php
						if (!empty($categories)) {
							    $counter= 1;
							foreach ($categories as $category) {  
							if($counter ==1){?>
									<span class="note"><?php echo esc_attr($category->name); ?></span>
							<?php }else{
							    break;
							}
							$counter++;
							}
								}  ?>
						<div class="wrap_holder">
							<?php if (!empty($permalinkget) && !empty($job_img_url)) { ?>
								<div class="icon_holder">
									<a href="<?php echo esc_html($permalinkget); ?>"><img src="<?php echo esc_url_raw($job_img_url) ?>" alt="image"></a>
								</div>
							<?php } ?>
							<div class="info_holder">
								<?php if (!empty($job_type_str)) { ?>
									<p><?php echo esc_html($job_type_str['title']); ?></p>
								<?php  }
								if (!empty($permalinkget) && !empty($title)) { ?>
									<strong class="h5"><a href="<?php echo esc_html($permalinkget); ?>"><?php echo esc_html($title) ?></a></strong>
								<?php } ?>
								<ul class="location_info">
									<?php if (!empty($post_author_name) && !empty($post_author_url)) { ?>
										<li>
											<span class="text"><?php esc_html_e('By', 'jobcircle-frame') ?><a href="<?php echo esc_html($post_author_url); ?>"> <?php echo esc_html($post_author_name); ?></a></span>
										</li>
									<?php }
									if (!empty($job_location)) { ?>
										<li>
											<i class="jobcircle-icon-map-pin icon"></i>
											<span class="text"><?php echo esc_html($job_location) ?></span>
										</li>
									<?php } ?>
								</ul>
								<?php if (!empty($job_salary)) { ?>
									<span class="amount"><strong><?php echo esc_html($job_salary) ?></strong></span>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			<?php } else {  ?>
				<div class="col-12 col-sm-6 col-xxl-4 mb-15 mb-md-30">
					<!-- Featured Category Box -->
					<article class="featured-category-box">
						<?php
					if (!empty($categories)) {
							    $counter= 1;
							foreach ($categories as $category) {  
							if($counter ==1){?>
									<span class="tag"><?php echo esc_attr($category->name); ?></span>
							<?php }else{
							    break;
							}
							$counter++;
							}
								}  
						if (!empty($permalinkget) && !empty($job_img_url)) { ?>
							<div class="img-holder">
								<a href="<?php echo esc_html($permalinkget); ?>">
									<img src="<?php echo esc_url_raw($job_img_url); ?>" width="78" height="78" alt="Financial Analyst">
								</a>
							</div>
						<?php } ?>
						<div class="textbox">
							<?php if (!empty($permalinkget) && !empty($title)) { ?>
								<a href="<?php echo esc_html($permalinkget); ?>">
									<strong class="h6"><?php echo esc_html($title) ?></strong>
								</a>
							<?php }
							if (!empty($post_author_url) && !empty($post_author_name)) { ?>
								<span class="subtitle"><?php esc_html_e('By', 'jobcircle-frame') ?> <a href="<?php echo jobcircle_esc_the_html($post_author_url) ?>"><?php echo esc_html($post_author_name) ?></a></span>
							<?php }
							if (!empty($job_location)) { ?>
								<address class="location"><i class="jobcircle-icon-map-pin icon"></i><span class="text"><?php echo esc_html($job_location) ?></span></address>
							<?php } ?>
							<div class="job-info">
								<?php if (!empty($minut)) { ?>
									<span class="subtext"><?php echo esc_html($minut) ?></span>
								<?php }
								if (!empty($job_salary)) { ?>
									<span class="amount"><strong><?php echo esc_html($job_salary) ?></strong></span>
								<?php } ?>
							</div>
							<a href="<?php echo $permalinkget ?>" class="jobcircle-det-applybtn jobdet-applybtn-act btn btn-dark-yellow btn-sm jobcircle-aplybtn-con">
								<span class="btn-text"><span class="text"><?php echo esc_html('Apply Now', 'jobcircle-frame') ?></span><i class="jobcircle-icon-chevron-right icon"></i></span></a>
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
	?>
	<script>
		jQuery(document).on('click', '.jobcircle-follower-btn', function() {
			var _this = jQuery(this);
			if (_this.hasClass('no-user-follower-btn')) {
				jobcircle_submit_msg_alert('<?php esc_html_e('Only logged-in user can save this.', 'jobcircle-frame') ?>', 'jobcircle-alert-warning');
				return false;
			}
			if (_this.hasClass('no-member-follower-btn')) {
				jobcircle_submit_msg_alert('<?php esc_html_e('Only a Employee member can save this.', 'jobcircle-frame') ?>', 'jobcircle-alert-warning');
				return false;
			}
			var this_icon = _this.find('i');
			var post_id = _this.data('id');
			this_icon.attr('class', 'fa fa-star-shake');
			jQuery.ajax({
				type: "POST",
				dataType: "json",
				url: jobcircle_cscript_vars.ajax_url,
				data: {
					post_id: post_id,
					action: 'jobcircle_jobs_grid_ten_theme_1_left_filter'
				},
				success: function(data) {
					var totalFavorites = data.total_favorites;
					_this.removeClass('jobcircle-follower-btn');
					_this.addClass('jobcircle-alrdy-favjab');
					_this.addClass('fa fa-star');
				},
				error: function() {
					this_icon.attr('class', 'profile-btn position-absolute');
				}
			});
		});
	</script>
	<?php
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
add_action('wp_ajax_jobcircle_jobs_grid_ten_theme_1_left_filter', 'jobcircle_jobs_grid_ten_theme_1_left_filter');
add_action('wp_ajax_nopriv_jobcircle_jobs_grid_ten_theme_1_left_filter', 'jobcircle_jobs_grid_ten_theme_1_left_filter');
function jobcircle_jobs_grid_ten_theme_1_left_filter()
{
	$atts = array(
		'numofpost' => $_POST['numposts'],
		'orderby' => $_POST['orderby']
	);
	$html = jobcircle_jobs_grid_ten_theme90($atts);
	wp_send_json(array('html' => $html));
}
