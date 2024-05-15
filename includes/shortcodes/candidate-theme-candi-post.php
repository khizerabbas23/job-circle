<?php

function get_customs_post_categories() {
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
function jobcircle_candi_theme_post(){
	vc_map(
		array(
			'name' => __('Candidates Post Theme'),
			'base' => 'jobcircle_candi_theme_post',
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
					'heading' => __('Select Category For Post'),
					'param_name' => 'category_selector',
					'value' => array_merge(
						array('Select Category' => ''),
						get_customs_post_categories()
					),
				),
			)
		)
	);
}
add_action('vc_before_init', 'jobcircle_candi_theme_post');

// popular category frontend
function jobcircle_candi_theme_post_frontend($atts, $content){
	$atts = shortcode_atts(
		array(
			'orderby' => '',
			'numofpost' => '',
			'filter_switch' => '',
			'category_selector' => '',
		),
		$atts,
		'jobcircle_candi_theme_post'
	);
	$orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
	$numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
    $selectedcategory  = isset($atts['category_selector']) ? $atts['category_selector'] : '';

	$custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
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
	ob_start();
	?>
	<main class="main">
		<!-- Featured Jobs Section -->
		<section class="section section-categories pt-35 pt-md-50 pt-lg-75 pt-xl-95 pb-35 pb-md-50 pb-xl-75 theme_sevenb">
			<div class="container">
				<div class="jobcircle-all-listing-con">
					<!-- Page subheader -->
					<header class="page-subheader mb-30 mb-md-40 d-lg-flex align-items-center justify-content-between">
						<?php
						$posts = get_posts([
							'post_type' => 'candidates',
							'post_status' => 'publish',
							'numberposts' => -1
						]);
						$job_count = count($posts);
						if (!empty($job_count)) {  ?>
						<h3 class="h6 mb-25 mb-lg-0"><?php echo esc_html_e('All' , 'jobcircle-frame') ?> <?php echo jobcircle_esc_the_html($job_count); ?> <?php esc_html_e('jobs found', 'jobcircle-frame') ?></h3>
						<?php  } ?>
						<div class="subhead-filters">
							<div class="subhead-filters-item">
								<form id="jobForm" class="form-group d-lg-flex align-items-center" method="get">
									<select class="select2" name="sortby" data-placeholder="<?php esc_html_e('Sort by', 'jobcircle-frame') ?>" onchange="submitForm()">
										<option value="recent"><?php esc_html_e('Recent Jobs', 'jobcircle-frame') ?></option>
										<option value="asc" <?php echo isset($_GET['sortby']) && $_GET['sortby'] == 'asc' ? 'selected' : ''; ?>><?php esc_html_e('Sort by Name', 'jobcircle-frame') ?></option>
									</select>
								</form>
							</div>
							<div class="grid-buttons">
								<?php
								$listactive = 'btn-list active';
								$gridactive = 'btn-grid ';
								if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'grid') {
									$listactive = 'btn-list ';
									$gridactive = 'btn-grid active';
								}
								if (!empty($listactive)) {  ?>
									<a href="?view=list">
										<button class="btn <?php echo jobcircle_esc_the_html($listactive); ?>" type="button">
											<img src="<?php echo Jobcircle_Plugin::root_url() ?>/images/list-icon.svg" width="20" height="20" alt="List">
										</button>
									</a>
								<?php }
								if (!empty($gridactive)) {  ?>
									<a href="?view=grid"><button class="btn <?php echo jobcircle_esc_the_html($gridactive); ?>" type="button">
											<img src="<?php echo Jobcircle_Plugin::root_url() ?>/images/grid-icon.svg" width="22" height="22" alt="Grid">
										</button>
									</a>
								<?php } 
								if($atts['filter_switch'] == 'filter_on') { ?>
								<button class="btn btn-filters filters-opener" type="button">
									<span></span>
								</button>
							<?php }  ?>	
							</div>
						</div>
					</header>
					<!-- Filters Sidebar -->
					<aside class="filters-sidebar custom-filters">
					<button class="btn btn-filters filters-opener opener-active" type="button">
						<span></span>
					</button>
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
												
												$cat_terms = get_terms(array(
													'taxonomy' => 'candidate_cat',
												));
												if (!empty($cat_terms)) {
													foreach ($cat_terms as $cat_term) {
													   
												?>
														<li>
															<label class="custom-checkbox">
																<input id="cat-<?php echo jobcircle_esc_the_html($cat_term->term_id); ?>" name="job_category" value="<?php echo jobcircle_esc_the_html($cat_term->slug); ?>" type="checkbox" <?php echo ($selectedcategory == $cat_term->slug )? 'checked' : "" ;?>>
																<span class="fake-checkbox"></span>
																<span class="label-text"><?php echo esc_attr($cat_term->name); ?></span>
															</label>
														</li>
												<?php }
												} ?>
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
							<?php
							$view = isset($_REQUEST['view']) ? $_REQUEST['view'] : '';   ?>
							<div class="filter-buttons">
								<input type="hidden" name="numposts" value="<?php echo jobcircle_esc_the_html($numofpost); ?>">
								<input type="hidden" name="orderby" value="<?php echo jobcircle_esc_the_html($orderby); ?>">
								<input type="hidden" name="view" value="<?php echo jobcircle_esc_the_html($view); ?>">
								<input type="hidden" name="action" value="candidate__theme_one_candi_ajax"><button type="submit" class="btn btn-primary btn-sm"><span class="btn-text submit-filters-button"><?php esc_html_e('Apply Filter', 'jobcircle-frame') ?></span></button>
								<a href="#" class="btn btn-text btn-sm"><?php esc_html_e('Reset all filters', 'jobcircle-frame') ?></a>
							</div>
						</form>
					</aside>
					<div class="row jobcircle-alljobs-list">
						<?php echo candidate__theme_one_candi($atts); ?>
					</div>
				</div>
			</div>
		</section>
		<?php
		$output = ob_get_clean();
		return $output;
	}
	add_shortcode('jobcircle_candi_theme_post', 'jobcircle_candi_theme_post_frontend');
	function candidate__theme_one_candi($atts){
	    
	    $selectedcategory  = isset($atts['category_selector']) ? $atts['category_selector'] : '';
	    
		ob_start();
		$numofpost  = isset($atts['numofpost']) ? $atts['numofpost'] : '';
		$orderby  = isset($atts['orderby']) ? $atts['orderby'] : '';
		$page_numbr = get_query_var('paged');
		$order = "DESC";
		if (isset($_GET['sortby']) && $_GET['sortby'] == 'asc') {
			$orderby = 'title';
			$order = 'ASC';
		}else{
		    $orderby = array(
		                    'meta_value' => 'DESC',
                            'post_date'  => 'DESC',
                       );
		}
		if(isset($_REQUEST['view']) && $_REQUEST['view'] == 'grid' ){
		    $numofpost += 1;
		}
		
		$args = array(
			'post_type' => 'candidates',
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
		if (isset($_REQUEST['job_category']) && $_REQUEST['job_category'] != '') {
			$selectedcategory = $_REQUEST['job_category'];
		}
		
		if ($selectedcategory != '') {
    		$tax_query = array(
    		    array(
    			'taxonomy' => 'candidate_cat',
    			'field' => 'slug',
    			'terms' => $selectedcategory,
    		        ),
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
                                            
		$meta_query = apply_filters('jobcircle_listing_filters_meta_query', $meta_query, 'candidates');
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
			global $jobcircle_framework_options, $post;
			// Start looping over the query results.
			while ($query->have_posts()) {
				$query->the_post();
				$post = get_post();
				$postid = $post->ID;
				$job_post = get_post($postid);
				$post_author = $job_post->post_author;
				$post_employer_id = jobcircle_user_employer_id($post_author);
				if ($post_employer_id > 0 && get_post_type($post_employer_id) == 'employer') {
					$post_author_name = get_the_title($post_employer_id);
					$post_author_url = get_the_permalink($post_employer_id);
				} else {
					$author_user_obj = get_user_by('id', $post_author);
					$post_author_name = $author_user_obj->display_name;
				}
				$posted = get_the_time('U');
				$minut =  human_time_diff($posted, current_time('U')) . "";
				$title = get_the_title($postid);
				$permalinkget = get_the_permalink($postid);
				$content = get_the_content();
				$vacancies = get_post_meta($post->ID, 'jobcircle_field_vacancies', true);
				$job_type = get_post_meta($postid, 'jobcircle_field_job_type', true);
				$job_type_str = jobcircle_job_type_ret_str($job_type);
				$job_salary = jobcircle_candidate_salary_str($postid, '', 'sub');
				$job_img_url = jobcircle_job_thumbnail_url($postid);
				$job_location = jobcircle_post_location_str($postid);
				$skills = wp_get_post_terms($postid, 'job_skill');
				
				$position = get_post_meta($postid, 'jobcircle_field_job_title', true);

                $candidate_id = $post->ID;
				$maxsalary = get_post_meta($candidate_id, 'jobcircle_field_max_salary', true);
                $salary_unit = get_post_meta($candidate_id, 'jobcircle_field_salary_unit', true);
                
				global $current_user;
				$user_id = $current_user->ID;
				$fav_jobs = get_user_meta($user_id, 'fav_follower_list', true);
				$fav_jobs = !empty($fav_jobs) ? $fav_jobs : array();
				$like_btn_class = 'jobcircle-resume-bookmark-btn';
				if (!is_user_logged_in()) {
					$like_btn_class = 'jobcircle-resume-bookmark-btn no-user-follower-btn';
				} else {
					if (!jobcircle_user_employer_id($user_id)) {
						$like_btn_class = 'jobcircle-resume-bookmark-btn no-member-follower-btn';
					} 
				}
			
				
			
				$fav_icon_class = 'profile-btn';
				$follow = 'fa fa-heart-o';
				if (in_array($postid, $fav_jobs)) {
					$like_btn_class = 'jobcircle-alrdy-favjab';
					$fav_icon_class = 'profile-btn';
					$follow = 'fa fa-heart';
				}
				if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'grid') {
		?>
<div class="col-12 col-md-6 col-lg-4 mb-20 mb-lg-60 area-top">
								<!-- Candidate Post -->
							<div class="candidate-post">
										<a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>">
											<div class="image-wrap">
												<?php if(!empty($job_img_url)){
													?>
												<div class="image-holder">
													<img src="<?php echo esc_url_raw($job_img_url); ?>" alt="image">
												</div>
												<?php } ?>
												<div class="ratings-info">
													<i class="jobcircle-icon-star"></i>
													<span><?php echo esc_html_e('4.9' , 'jobcircle-frame')?></span>
												</div>
											</div>
											<div class="text-info">
												<div class="title-bar">
													<?php if(!empty($title)){
														?>
													<h3><?php echo jobcircle_esc_the_html($title) ?></h3>
													<?php
													}
												?>
														<p><?php echo jobcircle_esc_the_html($position); ?></p>
											
												</div>
										
												<strong class="price sub"><?php esc_html_e('$', 'jobcircle-frame'); ?><?php echo jobcircle_esc_the_html($maxsalary) ?><?php esc_html_e('/', 'jobcircle-frame'); ?><sub><?php echo jobcircle_esc_the_html($salary_unit) ?></sub></strong>
											
											
											</div>
										</a>
									</div>
								</div>

				<?php } else { ?>
					<div class="col-12 col-md-6 col-lg-6 mb-20 mb-lg-30">
						<!-- Candidate Post -->
						<div class="candidate-post alt">
							<div class="candidate-post-holder">
							
									<a href class="ratings-info <?php echo jobcircle_esc_the_html($like_btn_class); ?>" data-id="<?php echo jobcircle_esc_the_html($postid) ?>">
									
									
										<i class="<?php echo jobcircle_esc_the_html($fav_icon_class); ?> position-absolute <?php echo jobcircle_esc_the_html($follow); ?>"></i>
									
									</a>

									<div class="image-holder">
										<?php if (!empty($job_img_url)) { ?>
											<img src="<?php echo esc_url_raw($job_img_url) ?>" alt="image">
										<?php } ?>
									</div>

									<div class="text-info">
										<div class="title-bar">
											<h3>
												<?php if (!empty($title)) { ?>
													<?php echo jobcircle_esc_the_html($title) ?>
												<?php } ?>
											</h3>
										<p><?php echo jobcircle_esc_the_html($position); ?></p>
									</div>
									<address class="location"><i class="jobcircle-icon-map-pin icon"></i><span class="text"><?php echo jobcircle_esc_the_html($job_location) ?></span></address>
								
										<strong class="price sub"><?php esc_html_e('$', 'jobcircle-frame'); ?><?php echo jobcircle_esc_the_html($maxsalary) ?><?php esc_html_e('/', 'jobcircle-frame'); ?><sub><?php echo jobcircle_esc_the_html($salary_unit) ?></sub></strong>
								
									</div>
							</div>
							<div class="candidate-post-foot">
								<ul class="tags-list">
									<?php
									$post_tags = get_tags();
									$counter = 0;
									foreach ($post_tags as $post_tag) {
										if ($counter < 3) {
											echo '<li><span class="tag">' . $post_tag->name . '</span></li>';
											$counter++;
										} else {
											break; // Break the loop after three tags
										}
									}
									?>
								</ul>
								<?php if (!empty($permalinkget)) { ?>
									<a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>" class="btn btn-green btn-sm buttonpe"><span class="btn-text">
										<?php } ?>
										<?php esc_html_e('View Profile', 'jobcircle-frame') ?>
										</span></a>
									</div>
								</div>
							</div>
			<?php
				}
			}
		} else {
			?>
			<p><?php esc_html_e('No job found.', 'jobcircle-frame') ?></p>
		<?php    }
		if ($total_posts > $numofpost) {
		
			echo jobcircle_pagination($query, true);
			add_action('wp_footer', function () {
			?>
				<script>
					jQuery(document).on('click', '.jobcircle-resume-bookmark-btn', function(ev) {
					    ev.preventDefault();
						var _this = jQuery(this);
						if (_this.hasClass('no-user-follower-btn')) {
							jobcircle_submit_msg_alert('<?php esc_html_e('Only logged-in user can save this.', 'jobcircle-frame') ?>', 'jobcircle-alert-warning');
							return false;
						}
						if (_this.hasClass('no-member-follower-btn')) {
							jobcircle_submit_msg_alert('<?php esc_html_e('Only a Employer member can save this.', 'jobcircle-frame') ?>', 'jobcircle-alert-warning');
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
								action: 'jobcircle_candidate_bookmark_saveion'
							},
							success: function(data) {
								var totalFavorites = data.total_favorites;
								_this.removeClass('jobcircle-resume-bookmark-btn');
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
								action: 'jobcircle_candidate_bookmark_saveion'
							},
							success: function(data) {
								var totalFavorites = data.total_favorites;
								_this.removeClass('jobcircle-alrdy-favjab');
								_this.addClass('jobcircle-resume-bookmark-btn');
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
		// Restore original post data.
		wp_reset_postdata();
		$output = ob_get_clean();
		return $output;
	}
	add_action('wp_ajax_candidate__theme_one_candi_ajax', 'candidate__theme_one_candi_ajax');
	add_action('wp_ajax_nopriv_candidate__theme_one_candi_ajax', 'candidate__theme_one_candi_ajax');
	function candidate__theme_one_candi_ajax()
	{
		$atts = array(
			'numofpost' => $_POST['numposts'],
			'orderby' => $_POST['orderby']
		);
		$html = candidate__theme_one_candi($atts);
		wp_send_json(array('html' => $html));
	}
	// for favourite button
	add_action('wp_ajax_jobcircle_candidate_favourite', 'jobcircle_candidate_favourite');
	add_action('wp_ajax_nopriv_jobcircle_candidate_favourite', 'jobcircle_candidate_favourite');
	function jobcircle_candidate_favourite()
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
	add_action('wp_ajax_jobcircle_candidate_bookmark_saveion', 'jobcircle_candidate_bookmark_saveion');
	add_action('wp_ajax_nopriv_jobcircle_candidate_bookmark_saveion', 'jobcircle_candidate_bookmark_saveion');
	function jobcircle_candidate_bookmark_saveion()
	{
		global $current_user;
		$user_id = $current_user->ID;
		$post_id = $_POST['post_id'];
		$faver_jobs = get_user_meta($user_id, 'fav_follower_list', true);
		$faver_jobs = !empty($faver_jobs) ? $faver_jobs : array();
		if (!in_array($post_id, $faver_jobs)) {
		    $faver_jobs[] = $post_id;
			update_user_meta($user_id, 'fav_follower_list', $faver_jobs);
	    }
		$data = array(
			'success' => '1',
			'total_favorites' => count($faver_jobs)
		);
		wp_send_json_success($data);
		wp_die();
	};
