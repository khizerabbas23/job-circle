<?php
function jobcircle_job_clean_job()
{
	vc_map(
		array(
			'name' => __('Clean Job'),
			'base' => 'jc_job_clean_job',
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
			)
		)
	);
}
add_action('vc_before_init', 'jobcircle_job_clean_job');

// popular category frontend
function jobcircle_job_clean_job_frontend($atts, $content)
{
	$atts = shortcode_atts(
		array(
			'orderby' => '',
			'numofpost' => '',
			'filter_sidebar_alignment' => '',
			'page_view' => '',
		),
		$atts,
		'jobcircle_job_clean_job'
	);
	$orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
	$numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
	wp_enqueue_script('jobcircle-jobfunctions');

	$atts['listin_ajax_action'] = 'jobcircle_jobs_simple_clean_job_one';
	
	$output = '';
	ob_start();
	?>
	<section class="section section-categories section-theme-1 pt-35 pt-md-50 pt-lg-75 pt-xl-95 pb-0 pb-md-0 pb-xxl-0">
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
							<h2 class="h5"><?php esc_html_e('Filters', 'jobcircle-frame') ?></h2>
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
					<?php if(!empty($job_count)){  ?>		
							<h3 class="h6 mb-25 mb-lg-0"><?php esc_html_e('All', 'jobcircle-frame') ?> <?php echo esc_html($job_count); ?> <?php esc_html_e('jobs found', 'jobcircle-frame') ?></h3>
					<?php  }  ?>		
							<div class="subhead-filters">
								<div class="subhead-filters-item">
									<label><?php esc_html_e('Sort By', 'jobcircle-frame') ?></label>
									<form id="jobForm" class="form-group d-lg-flex align-items-center" method="get">
										<select class="select2" name="sortby" data-placeholder="<?php esc_html_e('Sort By', 'jobcircle-frame') ?>" onchange="submitForm()">
											<option label="Sort by"></option>
											<option value="recent"><?php esc_html_e('Recent Jobs', 'jobcircle-frame') ?></option>
											<option value="asc" <?php echo isset($_GET['sortby']) && $_GET['sortby'] == 'asc' ? 'selected' : ''; ?>><?php esc_html_e('Sort by Name', 'jobcircle-frame') ?></option>
										</select>
									</form>
								</div>
								<div class="grid-buttons">
									<?php
									$listactive = 'btn-list';
									$gridactive = 'btn-grid active';
									if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list') {
										$listactive = 'btn-list active';
										$gridactive = 'btn-grid';
									}
									if(!empty($gridactive)){  ?>
									<a href="?view=grid"><button class="btn <?php echo esc_html($gridactive); ?>" type="button">
											<img src="<?php echo Jobcircle_Plugin::root_url() ?>/images/grid-icon.svg" width="22" height="22" alt="Grid">
										</button></a>
									<?php }	
									if(!empty($listactive)){  ?>
									<a href="?view=list"><button class="btn <?php echo esc_html($listactive); ?>" type="button">
											<img src="<?php echo Jobcircle_Plugin::root_url() ?>/images/list-icon.svg" width="20" height="20" alt="List">
										</button></a>	
									<?php } ?>									
								</div>
							</div>
						</header>
						<div class="row justify-content-center  jobcircle-alljobs-list">
							
							<?php	echo jobcircle_jobs_simple_clean_job($atts);  ?>
						
						</div></div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php
	$output = ob_get_clean();
	return $output;
}
add_shortcode('jc_job_clean_job', 'jobcircle_job_clean_job_frontend');
function jobcircle_jobs_simple_clean_job($atts)
{
	ob_start();
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
	$countr = 0;
	// Check that we have query results.
	if ($query->have_posts()) {
		// Start looping over the query results.
		while ($query->have_posts()) {
			$query->the_post();
			global $post;
			$post =  get_the_id();
			$title = get_the_title($post);
			$permalinkget = get_the_permalink($post);
			$posted = get_the_time('U');
			$minut = human_time_diff($posted, current_time('U')) . " ago";
			$excerpt = get_the_excerpt($post);
			$content = get_the_content();
			$vacancies = get_post_meta($post, 'jobcircle_field_vacancies', true);
			$social_media = get_post_meta($post, 'social_media', true);
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
			$time = get_post_meta($post, 'time', true);
			$companies_name = get_post_meta($post, 'company', true);                
			$amount = get_post_meta($post, 'amount', true);
			$location = get_post_meta($post, 'location', true);
			$companies_name = get_post_meta($post, 'jobcircle_field_companies_name', true);


			if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list') {
			    if($countr == 0){?>
	<section class="section section-theme-12 featured_Jobs_Block pt-0 pb-0 bg-white">
					<div class="jobs_info_wrap">
					    <?php } ?>
					<div class="col-12 col-lg-12 mb-15 mb-xl-30">
							<div class="jobs_info_holder">
								<div class="wrap_holder">
									<div class="icon_holder">
									    <?php if(!empty($permalinkget) && !empty($job_img_url)){ ?>
                                        <a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>">
										<img src=" <?php echo esc_url_raw($job_img_url);?>" alt="img">
                                        </a>
                                        <?php } ?>
									</div>
									<div class="info_holder">
									    <?php if(!empty($post_author_name) && !empty($post_author_url)){ ?>
										<p> <?php esc_html_e('By','jobcircle-frame')?> <a href="<?php echo  $post_author_url ?>"> <?php echo esc_html($post_author_name);?> </a></p>
										<?php } ?>
										<?php if(!empty($permalinkget) && !empty($title)){ ?>
                                        <a class="text-decoration-none" href="<?php echo jobcircle_esc_the_html($permalinkget) ?>">
                                            <?php if(!empty($title)){ ?>
										<strong class="h6 showhead"> <?php echo esc_html($title);?> </strong>
										<?php } ?>
                                        </a>
                                        <?php } ?>
										<ul class="location_info">
											<li>
											    <?php if(!empty($minut)){ ?>
												<span class="text"> <?php echo esc_html($minut);?> </span>
												<?php } ?>
											</li>
											<li>
											    <?php if(!empty($job_location)){ ?>
												<span class="text"> <?php echo esc_html($job_location);?> </span>
												<?php } ?>
											</li>
										</ul>
									</div>
								</div>
								<div class="apply_bar">
								    <?php if(!empty($job_salary)){ ?>
							<span class="amount subclass"><strong> <?php echo jobcircle_esc_the_html($job_salary) ;?></strong></span>
							<?php } ?>
									<div class="apply_bar-links">
									    <?php if(!empty($remote)){ ?>
										<a class="remote"> <?php echo esc_html($remote);?> </a>
										<?php } ?>
										<a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>" class="btn btn-green btn-sm"> <?php esc_html_e('Apply Now','jobcircle-frame')?></a>
									</div>
								</div>
							</div>
						</div>
			<?php } else {  
		
 if($countr == 0){?>
		<section class="section section-theme-2 featured-categories pt-0 pt-md-0 pt-xxl-0 pb-0 pb-md-0 pb-xxl-0">
						<div class="row justify-content-center row">
					    <?php } ?>
				<div class="col-12 col-md-6 mb-15 mb-md-30">
							<!-- Featured Category Box -->
							<article class="featured-category-box">
								
								<div class="img-holder">
								<a href="<?php echo jobcircle_esc_the_html($permalinkget)?>"><img src="<?php echo esc_url_raw($job_img_url)?>" alt="Financial Analyst"></a>
								</div>
								<div class="textbox">
                                <a href="<?php echo jobcircle_esc_the_html($permalinkget)?>"><strong class="h6"><?php echo esc_html($title);?></strong></a>
                                    <span class="subtitle"><?php echo esc_html('By','jobcircle-frame')?> <a href="<?php echo  $post_author_url ?>"> <?php echo esc_html($post_author_name);?> </a></span>
                                    <address class="location"><i class="jobcircle-icon-map-pin icon"></i><span class="text"><?php echo esc_html($job_location);?></span></address>
									<div class="job-info">
										<span class="subtext"><?php echo esc_html($minut);?></span>
									<?php if(!empty($job_salary)){ ?>
							<span class="amount subclass"><strong> <?php echo jobcircle_esc_the_html($job_salary) ;?></strong></span>
							<?php } ?>
									</div>
									<a href="<?php echo esc_html($permalinkget); ?>" class="btn btn-dark-yellow btn-sm"><span class="btn-text"><span class="text"><?php esc_html_e('Apply Now')?></span><i class="jobcircle-icon-chevron-right"></i></span></a>
								</div>
							</article>
						</div>


		<?php
			}
		$countr++;
		}
	} else {
		?>
		<p><?php esc_html_e('No job found.', 'jobcircle-frame') ?></p>
		<?php
	}

	if ($total_posts > $numofpost) {
		echo jobcircle_pagination($query, true);
	}
	wp_reset_postdata(); ?>
<?php
	$output = ob_get_clean();
	return $output;
}
add_action('wp_ajax_jobcircle_jobs_simple_clean_job_one', 'jobcircle_jobs_simple_clean_job_one');
add_action('wp_ajax_nopriv_jobcircle_jobs_simple_clean_job_one', 'jobcircle_jobs_simple_clean_job_one');
function jobcircle_jobs_simple_clean_job_one()
{
	$atts = array(
		'numofpost' => $_POST['numposts'],
		'orderby' => $_POST['orderby']
	);
	$html = jobcircle_jobs_simple_clean_job($atts);
	wp_send_json(array('html' => $html));
}
