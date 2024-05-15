<?php
function jobcircle_job_grow_job()
{
	vc_map(
		array(
			'name' => __('Grow Job'),
			'base' => 'jc_job_grow_job',
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
add_action('vc_before_init', 'jobcircle_job_grow_job');
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
.page-id-8762 .jobs_info_holder{
    height:100% !important;
}
.page-id-8762 .section-theme-16 .jobs_info_holder .amount strong{
    font-size:13px !important;
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
function jobcircle_job_grow_job_frontend($atts, $content)
{
	$atts = shortcode_atts(
		array(
			'orderby' => '',
			'numofpost' => '',
			'filter_sidebar_alignment' => '',
			'page_view' => '',
		),
		$atts,
		'jobcircle_job_grow_job'
	);
	$orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
	$numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
	wp_enqueue_script('jobcircle-jobfunctions');	
	$atts['listin_ajax_action'] = 'jobcircle_candidate_fav_job_grow_job_all';
	$output = '';
	ob_start();
	?>
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
						</header><?php 			if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'grid') {  ?>

	<div class="row justify-content-center  jobcircle-alljobs-list">

						<section class="section section-theme-16  ">
					<div class="jobs_info_wrap row">


							<?php
							echo jobcircle_jobs_simple_grow_job($atts);  ?>
						</div></div>
					</div>
				</div>
			</div>
		</div>
	</section>

<?php } else {?> 
						<div class="row justify-content-center  jobcircle-alljobs-list">
							<?php
							echo jobcircle_jobs_simple_grow_job($atts);  ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section> <?php } ?>
	<section class="section section-categories pt-35 pb-35 pb-md-50 pb-xl-75 pb-xxl-105">
         <div class="container">
		 <div class="row">
	<?php
	$output = ob_get_clean();
	return $output;
}
add_shortcode('jc_job_grow_job', 'jobcircle_job_grow_job_frontend');
function jobcircle_jobs_simple_grow_job($atts)
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
			$companies_name = get_post_meta($post, 'jobcircle_field_companies_name', true);

			if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'grid') {  ?>
		

				<div class="col-12 col-md-6 col-xl-6 mb-15 mb-xl-40">
								<div class="jobs_info_holder">
								    <?php if(!empty($like_btn_class) || !empty($postid) || !empty($fav_icon_class) || !empty($follow)){
								        ?>
                                <span class="star-icon  <?php echo jobcircle_esc_the_html($like_btn_class ) ?> " data-id="<?php echo jobcircle_esc_the_html($post) ?>"><i class=" <?php echo jobcircle_esc_the_html($fav_icon_class) ?> position-absolute <?php echo jobcircle_esc_the_html($follow )?>"></i></span>
                                <?php } ?>
									<div class="info_holder">
										<div class="icon-wrap">
											<div class="icon_holder">
											    <?php if(!empty($permalinkget || $job_img_url)){
											        ?>
                                                <a href="<?php echo jobcircle_esc_the_html($permalinkget )?>">
												<img src="<?php echo jobcircle_esc_the_html($job_img_url)?>" alt="img">
                                                </a>
                                                <?php } ?>
											</div>
										</div>
										<?php if(!empty($post_author_url ) || !empty($post_author_name)){
											        ?>
										<span class="by"><?php echo esc_html_e('By' , 'jobcircle-frame')?> <a href="<?php echo esc_html($post_author_url) ?>"><?php echo esc_html($post_author_name) ?></a></span>
										<?php } ?>
										<?php if(!empty($permalinkget) || !empty($title)){
										    ?>
										<strong class="h6"><a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>"><?php echo esc_html($title)?></a></strong>
										<?php } ?>
										<ul class="location_info">
											<li>
												<i class="jobcircle-icon-map-pin icon"></i>
												<span class="text"><?php echo esc_html($job_location) ?></span>
											</li>
										</ul>
										<div class="wrap">
										    <?php if(!empty($job_salary)){
										        ?>
											<span class="amount subclass"><strong class="showhead"><?php echo ($job_salary); ?></strong></span>
											<?php }
											if(!empty($job_type_str)){?>
											<span class="note"><?php echo jobcircle_esc_the_html($job_type_str['title']); ?></span>
											<?php } ?>
										</div>
										<?php if(!empty($remainingDays)){
										    ?>
										<span class="title-apply"><?php echo jobcircle_esc_the_html($remainingDays) ?><?php echo esc_html_e(' days left to apply' , 'jobcircle-frame') ?></span>
										<?php } ?>
									</div>
									<div class="title-job">
									<span class="icon"><img src="<?php echo Jobcircle_Plugin::root_url()?>/images/icon_tag.svg" alt="img"></span>
										
										<?php
                           // $include_category_ids = array(72, 103);

                            // Fetch the terms for the custom taxonomy 'job_featured'
                            $terms = get_terms(
                                array(
                                    'taxonomy' => 'job_category',
                                    'post_type' => 'jobs',
                                    'hide_empty' => false,
                                    'parent' => 0,
                                    //'include' => $include_category_ids,
                                )
                            );

                            $counter = 0;
                           foreach ($terms as $term) {
    if ($counter < 2 && !empty($term)) {
        $term_link = get_term_link($term);
        if (!is_wp_error($term_link)) {
            ?>
            <a href="<?php echo esc_url($term_link); ?>">
                <span class="text"><?php echo esc_html($term->name); 
                echo ($counter == 1) ? "" : ', ';
                ?>
                </span>
            </a>
            <?php
        }
        $counter++;
    } else {
        break;
    }
}
                           
							?>
									</div>
								</div>
							</div>


		<?php
			} else {  ?>
				<div class="col-12 col-md-10 mb-15 mb-md-30">
                
				<article class="featured-box">
					<a href="javascript:void(0)" class="pin-job <?php echo esc_html($like_btn_class); ?> " data-id="<?php echo esc_html($post); ?>"><i class=" <?php echo esc_html($fav_icon_class); ?> position-absolute <?php echo esc_html($follow); ?>"></i></a>	
					<div class="icon-box">
						<?php if (!empty($permalinkget) && !empty($job_img_url)) { ?>
						<a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>">
							<img src="<?php echo esc_url_raw($job_img_url) ?>" width="77" height="85" alt="Metronic Media Solution">
						</a>
					 <?php } ?>
					</div>
					<div class="textbox">
						 <?php if (!empty($permalinkget) && !empty($title)) { ?>
							<h3 class="h4"><a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>"><?php echo esc_html($title) ?></a></h3>
						 <?php } ?>
						  <?php if (!empty($companies_name)) { ?>
							<?php
if (!empty($categories)) {
    $counter = 0; // Initialize a counter
    foreach ($categories as $category) { 
        ?>
        <strong class="subtitle">
            <a href="<?php echo esc_url(get_term_link($category)); ?>">
                <span class="txt"><?php echo esc_html($category->name); ?></span>
            </a>
        </strong>
        <?php
        $counter++; // Increment the counter
        if ($counter >= 1) {
            break; // Break out of the loop after the first iteration
        }
    }
}
?>

						<?php } ?>
						<ul class="stats-list">
							<?php if (!empty($job_location)) { ?>
								<li>
									<i class="jobcircle-icon-map-pin icon"></i>
									<span class="text"><?php echo esc_html($job_location) ?></span>
								</li>
								 <?php
							} ?>
							<li>
								<i class="jobcircle-icon-clock icon"></i>
								 <?php if (!empty($minut)) { ?>
									<span class="text"><?php echo esc_html($minut) ?></span>
								<?php } ?>
							</li>
							<li>
								<i class="jobcircle-icon-bookmark icon"></i>
								<?php if (!empty($vacancies)) {
									?>
									<span class="text"><?php echo esc_html($vacancies); ?></span>
									<?php
								} ?>
							</li>
						</ul>
						<ul class="tags-list">
					   <?php
					   $skills = wp_get_post_terms($post, 'job_skill');
					   if (!empty($skills)) {
						   foreach ($skills as $skill) { ?>
										<li><span class="tag">
											<?php echo esc_html($skill->name) ?>
										</span></li>
								<?php }
					   } ?>
						</ul>
					</div>
				</article>
			</div>
		<?php
			}
		}
	} else {       
		?>
		<p><?php esc_html_e('No job found.', 'jobcircle-frame') ?></p>
		<?php
	}
	if ($total_posts > $numofpost) {
		echo jobcircle_pagination($query, true);
	}
	wp_reset_postdata();
	 ?>
	  </div>
	  </div>
                    </section>
<?php
	$output = ob_get_clean();
	return $output;
}
add_action('wp_ajax_jobcircle_candidate_fav_job_grow_job_all', 'jobcircle_candidate_fav_job_grow_job_all');
add_action('wp_ajax_nopriv_jobcircle_candidate_fav_job_grow_job_all', 'jobcircle_candidate_fav_job_grow_job_all');
function jobcircle_candidate_fav_job_grow_job_all()
{
	$atts = array(
		'numofpost' => $_POST['numposts'],
		'orderby' => $_POST['orderby']
	);
	$html = jobcircle_jobs_simple_grow_job($atts);
	wp_send_json(array('html' => $html));
}
