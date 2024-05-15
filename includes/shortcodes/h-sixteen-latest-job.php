<?php

function jobcircle_latest_job()
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
            'name' => __('Latest Job H16'),
            'base' => 'jobcircle_latest_job',
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
                    'heading' => __('Title'),
                    'param_name' => 'title',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Heading'),
                    'param_name' => 'heading',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Background Image'),
                    'param_name' => 'bg_img',
                ),
			    array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('View All Url'),
                    'param_name' => 'view_all_url',
                ),
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
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Target Date'),
                    'param_name' => 'target_date',
                    'default' => __( "Y_D_M", "jobcircle-frame" )
                ),
                
                array(
            		  'type' => 'checkbox',
            		  'holder' => 'div',
            		  'class' => '',
            		  'heading' => __('Checkbox Options'),
            		  'param_name' => 'checkbox_param',
            		  'value' => $job_types,
            		),
            		array(
            		  'type' => 'dropdown',
            		  'holder' => 'div',
            		  'class' => '',
            		  'heading' => __('Post Selection'),
            		  'param_name' => 'post_selector',
            		  'value' => $job_types,
            		),
            )
        )

    );
}
add_action('vc_before_init', 'jobcircle_latest_job');

// popular category frontend
function jobcircle_latest_job_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(

            'title' => '',
            'heading' => '',
            'bg_img' => '',
            'view_all_url' => '',
            'orderby' => '',
            'numofpost' => '',
            'target_date' => '',
            'checkbox_param' => '',
            'post_selector' => '',
        	'jobcircle_page' => '',     
        ),
        $atts,
        'jobcircle_latest_job'
    );

	$title  = isset($atts['title']) ? $atts['title'] : '';
	$heading  = isset($atts['heading']) ? $atts['heading'] : '';
	$bg_img  = isset($atts['bg_img']) ? $atts['bg_img'] : '';
	$view_all_url  = isset($atts['view_all_url']) ? $atts['view_all_url'] : '';
	//$current_date  = isset($atts['current_date']) ? $atts['current_date'] : '';
	$target_date  = isset($atts['target_date']) ? $atts['target_date'] : '';
	$checkbox_param = isset($atts['checkbox_param']) ? $atts['checkbox_param'] : '';
    $job_type_arr = !empty($checkbox_param) ? explode(',', $checkbox_param) : '';
    $jobcircle_page = isset($atts['jobcircle_page']) ? $atts['jobcircle_page'] : '';
    $post_selector = isset($atts['post_selector']) ? $atts['post_selector'] : '';
    $job_type_arrys = !empty($post_selector) ? explode(',', $post_selector) : '';

ob_start();
?>

<?php
$targetDate = $target_date;
$currentDate = date('Y-m-d');
$remainingDays = intval((strtotime($targetDate) - strtotime($currentDate)) / (60 * 60 * 24));
?>
<?php if(!empty($bg_img)){ ?>
	<section class="section section-theme-16 featured_Jobs_Block" style="background-image: url('<?php echo esc_url_raw($bg_img)?>');">
<?php }
?>
				<div class="container">
					<div class="jobs_info_wrap">
						<!-- Section header -->
						<header class="section-header d-flex flex-column text-center mb-15 mb-md-30 mb-xl-35">
							<?php 
							if(!empty($title)){
							?>
							<p><?php echo esc_html($title)?></p>
							<?php 
							}
							if(!empty($heading)){
							?>
							<h2><span class="text-outlined"><?php echo esc_html($heading)?></span></h2>
							<?php 
							}
							?>
						</header>
						<div class="row">
<?php  
    $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
    $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
    $page_numbr = get_query_var('paged');
    $include_category_ids = $job_type_arrys;
    $args = array(
                        'post_type' => 'jobs',
                        'posts_per_page' => $numofpost,
                        'order' => 'DESC',
                        'paged' => $page_numbr,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'job_category',
                                'field' => 'term_id', // Use term_id instead of slug
                                'terms' => $include_category_ids,
                                'include_children' => false, // Set to true if you want to include posts from child categories
                            ),
                        ),
                    );
           

    // Custom query.
    $query = new WP_Query($args);
    $total_posts = $query->found_posts;

    // Check that we have query results.
    if ($query->have_posts()) {

        // Start looping over the query results.
        while ($query->have_posts()) {

            $query->the_post();
            $post = get_post();
            $postid = $post->ID;
            $title = get_the_title($postid);
            $permalinkget = get_the_permalink($postid);
            $image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');


            $admin = get_the_author();  
            $job_type = get_post_meta($post->ID, 'jobcircle_field_job_type', true);
    		$job_type_str = jobcircle_job_type_ret_str($job_type);
            $salary = get_post_meta($post->ID, 'salary', true);
            $job_location = jobcircle_post_location_str($post->ID);
            $salary_unit = get_post_meta($post->ID, 'salary_unit', true);
            $posted = get_the_time('U');
            $minut =  human_time_diff($posted,current_time( 'U' )). "";
            $selection = get_post_meta($post->ID, 'jobcircle_field_apply_selection', true);
            $job_salary = jobcircle_job_salary_str($post->ID, 'k' ,'sub');
            $star_image = get_post_meta($post->ID, 'star_image', true);
            $company = get_post_meta($post->ID, 'company', true);
            $color = get_post_meta($post->ID, 'jobcircle_field_color', true);
            $job_post = get_post($post->ID);
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

            ?>
<div class="col-12 col-md-6 col-xl-4 mb-15 mb-xl-40">
								<div class="jobs_info_holder">
								    <?php if(!empty($like_btn_class) || !empty($postid) || !empty($fav_icon_class) || !empty($follow)){
								        ?>
                                <span class="star-icon  <?php echo jobcircle_esc_the_html($like_btn_class)  ?> " data-id="<?php echo jobcircle_esc_the_html($postid) ?>"><i class=" <?php echo jobcircle_esc_the_html($fav_icon_class) ?> position-absolute <?php echo jobcircle_esc_the_html($follow )?>"></i></span>
                                <?php } ?>
									<div class="info_holder">
										<div class="icon-wrap">
											<div class="icon_holder <?php echo jobcircle_esc_the_html($color) ?>">
											    <?php if(!empty($permalinkget || $image)){
											        ?>
                                                <a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>">
												<img src="<?php echo jobcircle_esc_the_html($image[0]) ?>" alt="img">
                                                </a>
                                                <?php } ?>
											</div>
										</div>
										<?php if(!empty($post_author_link ) || !empty($post_author_name)){
											        ?>
										<span class="by"><?php echo esc_html_e('By' , 'jobcircle-frame')?> <a href="<?php echo esc_html($post_author_link) ?>"><?php echo esc_html($post_author_name) ?></a></span>
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
                           $include_category_ids = $job_type_arr;
                            // Fetch the terms for the custom taxonomy 'job_featured'
                            $terms = get_terms(
                                array(
                                    'taxonomy' => 'job_category',
                                    'post_type' => 'jobs',
                                    'hide_empty' => false,
                                    'parent' => 0,
                                   'include' => $include_category_ids,
                                )
                            );

                            $counter = 0;
                            foreach ($terms as $term) {
                                if ($counter < 2) {
                                    // Query to get the post count for each term
                                    $args = array(
                                        'post_type' => 'jobs',
                                        'tax_query' => array(
                                            array(
                                                'taxonomy' => 'job_category',
                                                'field' => 'term_id',
                                                'terms' => $term->term_id,
                                            ),
                                        ),
                                    );
                                    $jobcircle_page_id = jobcircle_get_page_id_from_name($jobcircle_page);
                                    $jobcircle_page_url = home_url('/');
                                    if ($jobcircle_page_id > 0) {
                                        $jobcircle_page_url = get_permalink($jobcircle_page_id);
                                    }
                                    if (!empty($jobcircle_page_url) || !empty($term)) {
                                        ?>
                                        <a href="<?php echo esc_url($jobcircle_page_url);?>?job_category=<?php echo jobcircle_esc_the_html($term->slug) ?>">
                                            <span class="text"><?php echo esc_html($term->name); 
                                            echo ($counter == 1) ? "" : ', ';
                                            ?>
                                            </span>
                                        </a>
                                        <?php
                                    }
                                    $counter++;
                                } else {
                                    break; // Break the loop after 9 categories
                                }
                           }
                           
							?>
									</div>
								</div>
							</div>
            <?php
        }

    }

    // Restore original post data.
    wp_reset_postdata();
    ?>
      <script>
                jQuery(document).on ('click', '.jobcircle-follower-btn', function() {

                        
                    var _this = jQuery(this);
                if (_this.hasClass('no-user-follower-btn')){
                    jobcircle_submit_msg_alert('<?php esc_html_e('Only logged-in user can save this.' , 'jobcircle-frame') ?>', 'jobcircle-alert-warning');
                return false ; 
                }
                if (_this.hasClass('no-member-follower-btn')){
                    jobcircle_submit_msg_alert('<?php esc_html_e('Only a candidate member    can save this.' , 'jobcircle-frame') ?>', 'jobcircle-alert-warning');
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
                            action: 'jobcircle_candidate_fav_favourite_ajax_sixteen'
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
            action: 'jobcircle_candidate_remove_favourite_ajax_sixteen'
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
   
    </div>
	</div>
						<div class="d-flex justify-content-center">
							<a class="view" href="<?php echo esc_html($view_all_url) ?>"><?php echo esc_html_e('View All  Jobs' , 'jobcircle-frame')?></a>
						</div>
					</div>
				</div>
			</section>

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
</script>

    <?php
    return ob_get_clean();

}
add_shortcode('jobcircle_latest_job', 'jobcircle_latest_job_frontend');

// for favourite button
add_action('wp_ajax_jobcircle_candidate_fav_favourite_ajax_sixteen', 'jobcircle_candidate_fav_favourite_ajax_sixteen');
add_action('wp_ajax_nopriv_jobcircle_candidate_fav_favourite_ajax_sixteen', 'jobcircle_candidate_fav_favourite_ajax_sixteen');
function jobcircle_candidate_fav_favourite_ajax_sixteen() {
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

add_action('wp_ajax_jobcircle_candidate_remove_favourite_ajax_sixteen', 'jobcircle_candidate_remove_favourite_ajax_sixteen');
add_action('wp_ajax_nopriv_jobcircle_candidate_remove_favourite_ajax_sixteen', 'jobcircle_candidate_remove_favourite_ajax_sixteen');
function jobcircle_candidate_remove_favourite_ajax_sixteen() {
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
