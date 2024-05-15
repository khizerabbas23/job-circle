<?php
function jobcircle_job_talent_job()
{
         $terms = get_terms(
		array(
			'taxonomy' => 'job_category',
			'hide_empty' => true,
		)
	);
	$job_types = array();
	foreach ($terms as $term) {
		$job_types[$term->name] = $term->term_id;
	}
	;
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
			'name' => __('Talent Job'),
			'base' => 'jc_job_talent_job',
			'category' => __('Job Circle'),
			'params' => array(
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
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Last Date'),
                    'param_name' => 'last_date',
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
add_action('vc_before_init', 'jobcircle_job_talent_job');
// popular category frontend
function jobcircle_job_talent_job_frontend($atts, $content)
{
	$atts = shortcode_atts(
		array(
			'orderby' => '',
			'numofpost' => '',
			'filter_sidebar_alignment' => '',
			'page_view' => '',
			'last_date' => '',
			'jobcircle_page' => '',
		),
		$atts,
		'jobcircle_job_talent_job'
	);
	$orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
	$numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
    $last_date = isset($atts['last_date']) ? $atts['last_date'] : '';
    $jobcircle_page = isset($atts['jobcircle_page']) ? $atts['jobcircle_page'] : '';
	$jobcircle_style  = isset($atts['jobcircle_style']) ? $atts['jobcircle_style'] : '';	

	$atts['listin_ajax_action'] = 'jobcircle_jobs_simple_talent_job_one';
	wp_enqueue_script('jobcircle-jobfunctions');
	$output = '';
	ob_start();
	?>
	<section class="section section-categories section-theme-1 pt-35 pt-md-50 pt-lg-75 pt-xl-95 pb-35 pb-md-50 pb-xl-75 theme_sevenb">
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
							<?php
							echo jobcircle_jobs_simple_talent_job($atts);  ?>
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
add_shortcode('jc_job_talent_job', 'jobcircle_job_talent_job_frontend');
function jobcircle_jobs_simple_talent_job($atts)
{
	ob_start();
	$jobcircle_page = isset($atts['jobcircle_page']) ? $atts['jobcircle_page'] : '';
	$numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
	$orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
    $last_date = isset($atts['last_date']) ? $atts['last_date'] : '';

	$page_numbr = get_query_var('paged');
	$order = 'DESC';
	if (isset($_GET['sortby']) && $_GET['sortby'] == 'asc') {
		$orderby = 'title';
		$order = 'ASC';
	}
	$targetDate = $last_date;
    $currentDate = date('Y-m-d');
    $remainingDays = intval((strtotime($targetDate) - strtotime($currentDate)) / (60 * 60 * 24));
    
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
			$date = get_the_date('M d, Y');
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
				$like_btn_class = 'fav_jobs_list';
				$fav_icon_class = 'profile-btn';
				$follow = 'fa fa-heart';
			}
			if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list') {  
			if($countr == 0){ ?>
 <section class="section section-theme-14 pt-0">
					<div class="jobs_info_wrap">
					    <?php } ?>
				<div class="col-12 col-lg-12 mb-15 mb-xl-35">
                            <div class="jobs_info_holder">
                                <span class="star-icon  <?php echo jobcircle_esc_the_html($like_btn_class) ?> " data-id="<?php echo jobcircle_esc_the_html($post )?>"><i
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
                                        if (!empty($post_author_url) || !empty($post_author_name)) { ?>
                                            <span class="by">
                                                <?php esc_html_e('By', 'jobcircle-frame') ?> <a
                                                    href="<?php echo esc_html($post_author_url) ?>">
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

		<?php
			} else {  
			if($countr == 0){ ?>
                   <section class="section section-theme-13 mb-20 pt-30 pt-lg-40 pt-xl-0 pt-xxl-0 pb-35 pb-md-50 pb-lg-100 pb-xxl-120 theme_sevenb">
					<div class="featured-jobs-carousel-end row">
					    <?php } ?>

			   <div class="slick-box talentbox col-md-6 mb-30">
                            <div class="slide slidbor">
                                <a href="<?php echo ($permalinkget) ?>">
                                    <?php
                                    if (!empty($job_img_url)) {
                                        ?>
                                        <div class="icon"><img src="<?php echo esc_url_raw($job_img_url); ?>" alt="icon"></div>
                                        <?php
                                    } ?>
                                </a>
                                <?php
                                if (!empty($post_author_link) && !empty($post_author_name)) {
                                    ?>
                                    <strong class="posted-by">
                                        <?php esc_html_e('By', 'jobcircle-frame'); ?> <a
                                            href="<?php echo esc_html($post_author_link) ?>">
                                            <?php echo esc_html($post_author_name); ?>
                                        </a>
                                    </strong>
                                    <?php
                                } ?>
                                <a href="<?php echo esc_html($permalinkget) ?>">
                                    <?php
                                    if (!empty($title)) {
                                        ?>
                                        <h3>
                                            <?php echo esc_html($title); ?>
                                        </h3>
                                        <?php
                                    } ?>
                                </a>
                                <ul class="list-inline tags-items">
                                    <?php
                                    if (!empty($job_location)) {
                                        ?>
                                        <li>
                                            <i class="jobcircle-icon-map-pin">
                                                <?php echo esc_html($job_location); ?>
                                            </i>
                                        </li>
                                        <?php
                                    } ?>
                                    <?php
                                    if (!empty($minut)) {
                                        ?>
                                        <li>
                                            <time class="date" datetime="2021-06-20">
                                                <span class="jobcircle far fa-clock"> </span>
                                                <?php echo esc_html($minut); ?>
                                            </time>
                                        </li>
                                        <?php
                                    } ?>
                                </ul>
                                <?php
                                if (!empty($salary_unit) || !empty($job_salary)) { ?>
                                    <strong class="price">
                                        <?php echo ($job_salary); ?><sub></sub>
                                    </strong>
                                    <?php
                                } ?>
                                <ul class="tags-list">
                                <?php                               
								if (!empty($skills)) {
                                    $counter = 0;
									foreach ($skills as $skill) {  
                                        if($counter <= 1){ ?>
									<li><span class="tag"><?php echo esc_html($skill->name) ?></span></li>
							    <?php }else{
                                    break;
                                } 
                                $counter++;                               
                            }
						    	}  ?>                                    
                                </ul>
                                <span class="left-time">
                                    <?php
                                    if (!empty($output)) {
                                        esc_html_e('Time limit is over', 'jobcircle-frame');
                                    } else {
                                        echo esc_html($remainingDays); ?>
                                        <?php esc_html_e('days left to apply', 'jobcircle-frame');
                                    } ?>
                                </span>
                               <a href="<?php echo ($permalinkget)?>"> <button class="btn btn-apply"><span>
                                        <?php esc_html_e('Apply Now', 'jobcircle-frame') ?>
                                    </span></button></a>
                            </div>
                        </div>


		<?php
			}
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
	$jobcirlce_days_left = esc_html__('Days To left', 'jobcircle-frame');
	$jobcirlce_app_perion_end = esc_html__('Application period has ended', 'jobcircle-frame');
	$jobcirlce_inline_script = "
	jQuery(document).ready(function($) {		
		var daysRemaining = ".intval($remainingDays).";		
			function updateCountdown() {
				if (daysRemaining >= 0) {
					var countdownElements = document.querySelectorAll('.text-note strong');
					countdownElements.forEach(function(element) {
						element.textContent = daysRemaining + '$jobcirlce_days_left';
					});
					daysRemaining--;
				} else {
					var countdownElements = document.querySelectorAll('.text-note strong');
					countdownElements.forEach(function(element) {
						element.textContent = '$jobcirlce_app_perion_end'
					});
				}
			}		
			updateCountdown();		
			setInterval(updateCountdown, 24 * 60 * 60 * 1000);
	});";
	wp_add_inline_script('jobcircle-jobfunctions', $jobcirlce_inline_script, 'after');	
	$output = ob_get_clean();
	return $output;
}
add_action('wp_ajax_jobcircle_jobs_simple_talent_job_one', 'jobcircle_jobs_simple_talent_job_one');
add_action('wp_ajax_nopriv_jobcircle_jobs_simple_talent_job_one', 'jobcircle_jobs_simple_talent_job_one');
function jobcircle_jobs_simple_talent_job_one()
{
	$atts = array(
		'numofpost' => $_POST['numposts'],
		'orderby' => $_POST['orderby']
	);
	$html = jobcircle_jobs_simple_talent_job($atts);
	wp_send_json(array('html' => $html));
}
