<?php
function jobcircle_job_feature_job()
{
     $all_page = array( __('Select Page', 'jobcircle-frame'), '');
    $args = array(
        'sort_order' => 'asc',
        'sort_column' => 'post_title',
        'hierarchical' => 1,
        'exclude' => '',
        'include' => '',
        'meta_key' => '',
        'meta_value' => '',
        'authors' => '',
        'child_of' => 0,
        'parent' => -1,
        'exclude_tree' => '',
        'number' => '',
        'offset' => 0,
        'post_type' => 'page',
        'post_status' => 'publish'
    );
    $pages = get_pages($args);
    if (!empty($pages)) {
        foreach ($pages as $page) {
            $all_page[$page->post_title] = $page->post_name;
        }
    }
	vc_map(
		array(
			'name' => __('Feature Job'),
			'base' => 'jc_job_feature_job',
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
                'heading' => __('Jobcircle Page', 'jobcircle-frame'),
                'param_name' => 'jobcircle_page',
                'description' => __('Select Jobcircle Page', 'jobcircle-frame'),
                'value' =>  $all_page,
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
add_action('vc_before_init', 'jobcircle_job_feature_job');
// popular category frontend
function jobcircle_job_feature_job_frontend($atts, $content)
{
	$atts = shortcode_atts(
		array(
			'orderby' => '',
			'numofpost' => '',
			'filter_sidebar_alignment' => '',
			'jobcircle_page' => '',   
			'page_view' => '',
		),
		$atts,
		'jobcircle_job_feature_job'
	);
	$orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
	$numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
	$jobcircle_page = isset($atts['jobcircle_page']) ? $atts['jobcircle_page'] : '';
	$atts['listin_ajax_action'] = 'jobcircle_jobs_simple_feature_job_one';
	wp_enqueue_script('jobcircle-jobfunctions');
	$output = '';
	ob_start();
	?>
	<section class="section section-categories section-theme-1 pt-35 pt-md-50 pt-lg-75 pt-xl-95">
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
					<div class="col-12 col-lg-4 col-xxl-4">
						<div class="d-flex align-items-center justify-content-between d-lg-none mb-25 filters-head">
							<h2 class="h5"><?php esc_html_e('Filters', 'jobcircle-frame') ?></h2>
							<a href="#" class="filters-opener"><span></span></a>
						</div>
						<!-- Filters Sidebar -->
						<?php jobcircle_job_listing_filters_sidebar($atts) ?>
					</div>
					<div class="col-12 col-lg-8 col-xxl-8">
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
									$listactive = 'btn-list active';
									$gridactive = 'btn-grid';
									if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'grid') {
										$listactive = 'btn-list';
										$gridactive = 'btn-grid active';
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
						 
							<?php
							echo jobcircle_jobs_simple_feature_job($atts);  ?>
						</div></div>
					</div>
					</div>
				</div>
				<?php	if (isset($_REQUEST['view']) && $_REQUEST['view'] !== 'grid') {?>
			</div>
			<?php } ?>
		</div>
	</section>
	<?php
	$output = ob_get_clean();
	return $output;
}
add_shortcode('jc_job_feature_job', 'jobcircle_job_feature_job_frontend');
function jobcircle_jobs_simple_feature_job($atts)
{
	ob_start();
	$jobcircle_page = isset($atts['jobcircle_page']) ? $atts['jobcircle_page'] : '';
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
			$job_salary = jobcircle_job_salary_str($post,'','sub');
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
				$post_author_link = get_permalink($post_employer_id);
			} else {
				$author_user_obj = get_user_by('id', $post_author);
				$post_author_name = $author_user_obj->display_name;
				$post_author_link = get_author_posts_url($post_author);
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
			$date = get_the_date('M,d, Y');
			$country = get_post_meta($post, 'jobcircle_field_loc_country', true);

			if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'grid') { 
		
   if($countr == 0){       ?>
			<section class="section section-theme-11 bg-white pt-0 pt-md-0 pb-0 pb-xxl-50">
						<div class="tab-content">
                    <div class="jobs-frame">
			<?php } ?>
				<div class="jobs-card open-job-card openjobs col-md-6">
					
					<?php
					  if (!empty($id_post)) {
                                    ?>
									<div class="jobs-card cat-<?php echo jobcircle_esc_the_html($id_post) ?> job-ids-forcat">
                                    <?php } ?>
                                    <div class="row">
                                        <div class="job-content">
                                            <div class="icon-box" style="border-radius: 30% !important;">
                                                <?php if (!empty($permalinkget) || !empty($job_img_url)) {
                                                    ?>
                                                    <a href="<?php echo esc_html($permalinkget) ?>">
                                                        <img src="<?php echo esc_url_raw($job_img_url) ?>" alt="image">
                                                    </a>
                                                <?php } ?>
                                            </div>
											<?php
if (!empty($categories)) {
    $category_limit = 1; // Set the desired limit of categories to display
    $counter = 0; // Initialize the counter

    foreach ($categories as $cate) {
        $counter++;
        ?>
        <p>
            <a class="text-decoration-none small" href="<?php echo esc_url(get_term_link($cate)); ?>">
                <?php echo esc_html($cate->name); ?>
            </a>
        </p>
        <?php

        // Check if the counter has reached the limit
        if ($counter >= $category_limit) {
            break; // Break out of the loop if the limit is reached
        }
    }
}
?>

                                            <?php
                                            if (!empty($permalinkget) && !empty($title)) {
                                                ?>
                                                <h3 class="text-decoration-none"><a class="text-decoration-none"
                                                        href="<?php echo esc_html($permalinkget) ?>">
                                                        <?php echo esc_html($title) ?>
                                                    </a></h3>
                                            <?php }
                                            if (!empty($post_author_link) || !empty($post_author_name)) { ?>
                                                <span class="meta">
                                                    <?php echo esc_html_e('By', 'jobcircle-frame') ?> <a
                                                        href="<?php echo esc_html($post_author_link) ?>">
                                                        <?php echo esc_html($post_author_name) ?>
                                                    </a>
                                                </span>
                                            <?php } ?>

                                            <div class="location-holder">
                                                <strong class="location-txt">
                                                    <i class="jobcircle-icon-map-pin icon"></i>
                                                    <?php if (!empty($country)) {
                                                        ?>
                                                        <span>
                                                            <?php echo esc_html($country); ?>
                                                        </span>
                                                        <?php
                                                    } ?>
                                                </strong>
                                                <strong class="location-txt">
                                                    <i class="jobcircle-icon-clock icon"></i>
                                                    <?php if (!empty($date)) {
                                                        ?>
                                                        <span>
                                                            <?php echo esc_html($date) ?>
                                                        </span>
                                                    <?php } ?>
                                                </strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="align-items-md-end align-items-lg-center bottom-holder">
                                        <div class="col-12 d-flex pl-xl-left">
                                            <?php
                                            if (!empty($job_salary)) {
                                                ?>
                                                <strong class="price fontsz">
                                                    <?php echo jobcircle_esc_the_html($job_salary); ?><sub></sub>
                                                </strong>
                                            <?php } ?>
                                            <ul class="tags-list">
                                                <?php if (!empty($job_type_str)) {
                                                    ?>
                                                    <li><span class="tag">
                                                            <?php echo esc_html($job_type_str['title']) ?>
                                                        </span></li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>


		<?php
			} else {
	       if($countr == 0){       ?>
		<section class="section section-theme-14 theme_sevenb pt-0">
					<div class="jobs_info_wrap">
			<?php } ?>
				<div class="col-12 col-lg-12 mb-15 mb-xl-35">
                            <div class="jobs_info_holder">
                                <span class="star-icon  <?php echo jobcircle_esc_the_html($like_btn_class) ?> " data-id="<?php echo jobcircle_esc_the_html($post) ?>"><i
                                        class=" <?php echo jobcircle_esc_the_html($fav_icon_class) ?> position-absolute <?php echo jobcircle_esc_the_html($follow) ?>"></i></span>
                                <div class="info_holder">
                                    <?php
                                    $include_category_ids = array(72, 103, 74);
                                    $terms = get_terms(
                                        array(
                                            'taxonomy' => 'job_category',
                                            'post_type' => 'jobs',
                                            'hide_empty' => false,
                                            'include' => $include_category_ids,
                                        )
                                    );
                                    $category_count = 0;
                                    foreach ($terms as $term) {
                                        if (!empty($term->name)) {
                                            $term_link = get_term_link($term); // Get the term link                                            
                                             $jobcircle_page_id = jobcircle_get_page_id_from_name($jobcircle_page);
											$jobcircle_page_url = home_url('/');
											if ($jobcircle_page_id > 0) {
												$jobcircle_page_url = get_permalink($jobcircle_page_id);
											}
                                            ?>
                                            <a class="text-decoration-none" href="<?php echo esc_url($jobcircle_page_url);?>?job_category=<?php echo jobcircle_esc_the_html($term->slug) ?>">
                                                <span class="job-title">
                                                    <?php echo esc_html($term->name); ?>
                                                </span>
                                            </a>
                                            <?php
                                            $category_count++;
                                            if ($category_count >= 2) {
                                                break; // Stop after displaying 2 categories
                                            }
                                        }
                                    }
                                    ?>
                                    <div class="title-hold">
                                        <?php
                                        if (!empty($title)) { ?>
                                            <strong class="h6"><a href="<?php echo esc_html($permalinkget) ?>">
                                                <?php echo esc_html($title) ?></a>
                                            </strong>
                                        <?php } ?>
                                        <i class="jobcircle-icon-checkmark1 icon"></i>
                                    </div>
                                    <ul class="location_info">
                                        <?php
                                        if (!empty($job_location)) { ?>
                                            <li>
                                                <i class="jobcircle-icon-map-pin icon"></i>
                                                <span class="text">
                                                    <?php echo esc_html($job_location) ?>
                                                </span>
                                            </li>
                                        <?php } ?>
                                        <?php
                                        if (!empty($date)) { ?>
                                            <li>
                                                <i class="jobcircle-icon-clock icon"></i>
                                                <span class="text">
                                                    <?php echo esc_html($date) ?>
                                                </span>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <div class="wrap_holder">
                                    <div class="icon_holder">
                                        <?php
                                        if (!empty($job_img_url)) { ?>
                            <img src="<?php echo esc_url_raw($job_img_url) ?>" alt="img">
                                        <?php } ?>
                                    </div>
                                    <div class="text_hold">
                                        <?php
                                        if (!empty($post_author_link) || !empty($post_author_name)) { ?>
                                            <span class="by">
                                                <?php esc_html_e('By', 'jobcircle-frame') ?> <a
                                                    href="<?php echo esc_html($post_author_link) ?>">
                                                    <?php echo esc_html($post_author_name) ?>
                                                </a>
                                            </span>
                                        <?php } ?>
                                        <div class="wrap">
                                            <?php
                                            if (!empty($job_salary)) { ?>
                                                <span class="amount subclass">
                                                  <strong><?php echo ($job_salary) ?></strong>
                                                </span>
                                            <?php } ?>
                                            <?php
                                            if (!empty($job_type_str)) { ?>
                                                <span class="note pt-5">
                                                    <?php echo esc_attr($job_type_str['title']); ?>
                                                </span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
			<?php }
		
		    $countr++;
		}
	} else {       ?>
		<p><?php esc_html_e('No job found.', 'jobcircle-frame') ?></p>
		<?php
	}

	if ($total_posts > $numofpost) {
		echo jobcircle_pagination($query, true);		
	}
	wp_reset_postdata();
	$output = ob_get_clean();
	return $output;
}
add_action('wp_ajax_jobcircle_jobs_simple_feature_job_one', 'jobcircle_jobs_simple_feature_job_one');
add_action('wp_ajax_nopriv_jobcircle_jobs_simple_feature_job_one', 'jobcircle_jobs_simple_feature_job_one');
function jobcircle_jobs_simple_feature_job_one()
{
	$atts = array(
		'numofpost' => $_POST['numposts'],
		'orderby' => $_POST['orderby']
	);
	$html = jobcircle_jobs_simple_feature_job($atts);
	wp_send_json(array('html' => $html));
}