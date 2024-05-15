<?php
function get_customs_posts_categori()
{
	$categories = get_terms(
		array(
			'taxonomy' => 'job_category',
			'hide_empty' => false,
		)
	);

	$category_options = array();

	if ($categories && !is_wp_error($categories)) {
		foreach ($categories as $category) {
			$category_options[wp_specialchars_decode($category->name)] = $category->slug;
		}
	}

	return $category_options;
}

function jobcircle_latest_jobs_ten()
{
    vc_map(
        array(
            'name' => __('Latest Jobs Ten'),
            'base' => 'jc_latest_jobs_ten',
            'category' => __('Job Circle'),
            'params' => array(
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
                    'heading' => __('Live Title'),
                    'param_name' => 'live_title',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Sub Title'),
                    'param_name' => 'sub_title',
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
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Target Date'),
                    'param_name' => 'target_date',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('View Job Url'),
                    'param_name' => 'job_url',
                ),
               array(
					'type' => 'dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Select Category For Post'),
					'param_name' => 'category_selector',
					'value' => array_merge(
						array('Select Category' => ''),
						get_customs_posts_categori()
					),
				),
            )
        )

    );
}
add_action('vc_before_init', 'jobcircle_latest_jobs_ten');

// popular category frontend
function jobcircle_latest_jobs_ten_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(

            'title' => '',
            'sub_title' => '',
            'orderby' => '',
            'numofpost' => '',
            'job_url' => '',
            'live_title' => '',
            'target_date' => '',
            'category_selector' => '',

        ),
        $atts,
        'jobcircle_latest_jobs_ten'
    );

    $title  = isset($atts['title']) ? $atts['title'] : '';
   $sub_title  = isset($atts['sub_title']) ? $atts['sub_title'] : '';
   $job_url  = isset($atts['job_url']) ? $atts['job_url'] : '';
   $live_title  = isset($atts['live_title']) ? $atts['live_title'] : '';
   $target_date  = isset($atts['target_date']) ? $atts['target_date'] : '';
   $selectedcategory  = isset($atts['category_selector']) ? $atts['category_selector'] : '';

    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';

ob_start();
?>

<?php
$targetDate = $target_date;
$currentyear = date('Y');
$currentDate = date('Y-m-d');
$remainingDays = intval((strtotime($targetDate) - strtotime($currentDate)) / (60 * 60 * 24));
if($remainingDays < 0){
 $output = "Time limit is over";
}

                  	  $posts = get_posts([
                      'post_type' => 'jobs',
                      'post_status' => 'publish',
                      'numberposts' => -1
                    ]);
                    
                    $job_count = count($posts);
				
?>
    <section class="section section-theme-10 bg-white pt-0 pt-md-10 pb-35 pb-md-50 pb-lg-65 pb-xxl-100">
				<div class="container">
					<!-- Section header -->
					<header class="section-header d-flex flex-column-reverse text-center mb-30 mb-lg-42">

                    <?php 
                        if(!empty($title)){
                            ?>
                         <h2> <?php echo esc_html($title);?></h2>
                     <?php 
                        }
                        ?>

                       <?php 
                        if(!empty($sub_title || $currentyear || $job_count || $live_title)){
                            ?>
                        <p><?php echo esc_html($currentyear); ?> <?php echo jobcircle_esc_the_html($live_title) ?> - <?php echo jobcircle_esc_the_html($job_count) ?> <?php echo esc_html($sub_title); ?></p>
                     <?php 
                        }
                        ?>
	
					</header>
					<div class="jobs-frame">
<?php  
    $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
    $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';

    $page_numbr = get_query_var('paged');

    $args = array(
        'post_type' => 'jobs',
        'post_status' => 'publish',                                                                                                                                                                                             
        'posts_per_page' => $numofpost, 
        'order' => 'DESC',  
        'paged' => $page_numbr,                   
        'orderby' =>  $orderby, 
        );         
     if($selectedcategory != ''){
         $tax_query = array(
            array(
             'taxonomy' => 'job_category',
			 'field' => 'slug',
			 'terms' => $selectedcategory,
              
                ),
            );
     }
     if(!empty($tax_query)){
         $args['tax_query'] = $tax_query ;
     }
      
    // Custom query.
    $query = new WP_Query($args);
    $total_posts = $query->found_posts;

    // Check that we have query results.
    if ($query->have_posts()) {

        // Start looping over the query results.
        while ($query->have_posts()) {

            $query->the_post();
$id = get_the_id();
            $post = get_post();
            $postid = $post->ID;
            $title = get_the_title($postid);
            $permalinkget = get_the_permalink($postid);
            $excerpt = get_the_excerpt($postid);
            $image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');
            $admin = get_the_author();  
            $authorlink = get_author_posts_url( get_the_author_meta( 'ID' ));
             $job_type = get_post_meta($postid, 'jobcircle_field_job_type', true);
        	 $job_salary = jobcircle_job_salary_str($postid, '', 'sub');
        	 $job_img_url = jobcircle_job_thumbnail_url($postid);
        	 $job_location = jobcircle_post_location_str($postid);
        	 $categories = get_the_terms( $postid, 'job_category' );
        	 $skills = wp_get_post_terms( $postid, 'job_skill' );
    		 $job_type_str = jobcircle_job_type_ret_str($job_type);
    		 
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
              

                     <div class="jobs-card">							
							<div class="icons">
								<div class="fav-icon fav">
									<span class="jiji">
									     <?php if(!empty($like_btn_class) && !empty($fav_icon_class)){ ?>
                                    <a href="" class="fav-tag <?php echo jobcircle_esc_the_html($like_btn_class)  ?> " data-id="<?php echo jobcircle_esc_the_html($postid) ?>"><i class=" <?php echo jobcircle_esc_the_html($fav_icon_class) ?> position-absolute <?php echo jobcircle_esc_the_html($follow) ?>"></i></a>
                                    <?php } ?>
                                    </span>
								</div>
								<div class="flash-icon">
									<span class="fa fa-solid fa-bolt"></span>
								</div>
							</div>
							<div class="row">
								<div class="job-content">
									<div class="icon-box">
									    <?php 
									    if(!empty($job_img_url) && !empty($permalinkget)){
									        ?>
                                        <a href="<?php echo ($permalinkget) ?>"><img src="<?php echo esc_url_raw($job_img_url);?>" alt="image"></a>
                                        <?php }?>
									</div>
									<div class="myflex">
									<p class="me-5"><?php esc_html_e('in', 'jobcircle-frame')?></p> 
									<p>
                        				<?php 
                                        $counter = 0;
                                        foreach ($categories as $category) { 
                                          if ($counter < 2 && !empty($categories)) {
                                            $category_link = esc_url(get_term_link($category)); ?>
                                            
                                                <a class="text-decoration-none text-dark" href="<?php echo jobcircle_esc_the_html($category_link); ?>">
                                                    <?php echo esc_html($category->name); ?>
                                                   
                                                </a>
                                        <?php $counter++; }else{
                                        break;
                                    }
                                    }
                                    ?></p>
            						</div>
            						 <?php 
									    if(!empty($title)){
									        ?>
                                    <a class="ltsyled" href="<?php echo ($permalinkget) ?>"><h3><?php echo esc_html($title);?></h3></a>
                                   <?php }?>
									<?php if(!empty($post_author_name) && !empty($post_author_link)) { ?>
						<span class="meta"> <?php esc_html_e('By','jobcircle-frame'); ?> <a href="<?php echo jobcircle_esc_the_html($post_author_link) ?>"><?php echo esc_html($post_author_name); ?></a></span>
                        <?php } ?>
								</div>
							</div>
							<div class="row align-items-md-end align-items-lg-center">
								<div class="col-12 col-md-8 col-lg-7 d-flex flex-column flex-sm-row align-items-center justify-content-sm-center justify-content-lg-start pl-xl-left">
								    <span><strong><sub></sub></strong></span>
                                    <?php 
									    if(!empty($job_salary)){
									        ?>
									<strong class="price"><?php echo jobcircle_esc_the_html($job_salary) ?></strong>
									<?php } ?>
									<ul class="tags-list">
									    <?php 
									    if(!empty($job_type_str['title'])){
									        ?>
										<li><span class="tag"> <?php echo esc_html($job_type_str['title']); ?></span></li>
										<?php } ?>
                                        </ul>
									<strong class="location-txt">
										<i class="jobcircle-icon-map-pin icon"></i>
                                        <?php if(!empty($job_location)) { ?>
										<span> <?php echo esc_html($job_location); ?></span>
                                        <?php } ?>
									</strong>
								</div>
								<div class="col-12 col-md-4 col-lg-5 d-flex flex-column flex-lg-row align-items-center align-items-md-end align-items-lg-center justify-content-lg-end">
					<span class="txt">
                    <?php if(!empty($output)){
                        esc_html_e('Time limit is over','jobcircle-frame');
                    }else{
                        echo esc_html($remainingDays); ?> <?php esc_html_e('Days left to','jobcircle-frame');
                     } ?>
                    </span><a href="javascript:;" class="jobcircle-det-applybtn jobdet-applybtn-act btn btn-orange" data-id="<?php echo ($postid) ?>" data-bs-toggle="modal"
							data-bs-target="#jobcircle-apply-job-popup"><?php esc_html_e('Apply Job','jobcircle-frame');?></a>
							</span>
                                  
								</div>
							</div>
						</div>

            <?php
        }

    }

    // Restore original post data.
    wp_reset_postdata();
    ?>
    </div>
					<div class="row">
						<div class="col-12 d-flex justify-content-center pt-lg-20">
                        <a href="<?php echo jobcircle_esc_the_html($job_url) ?>"><button class="btn btn-orange-outline"><span><?php esc_html_e('View All Jobs','jobcircle-frame');?></span></button></a>
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
        action: 'jobcircle_candidate_fav_favourite_ajax_ten'
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
action: 'jobcircle_candidate_remove_favourite_ajax_ten'
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
    return ob_get_clean();

}
add_shortcode('jc_latest_jobs_ten', 'jobcircle_latest_jobs_ten_frontend');


// for favourite button
add_action('wp_ajax_jobcircle_candidate_fav_favourite_ajax_ten', 'jobcircle_candidate_fav_favourite_ajax_ten');
add_action('wp_ajax_nopriv_jobcircle_candidate_fav_favourite_ajax_ten', 'jobcircle_candidate_fav_favourite_ajax_ten');
function jobcircle_candidate_fav_favourite_ajax_ten() {
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


add_action('wp_ajax_jobcircle_candidate_remove_favourite_ajax_ten', 'jobcircle_candidate_remove_favourite_ajax_ten');
add_action('wp_ajax_nopriv_jobcircle_candidate_remove_favourite_ajax_ten', 'jobcircle_candidate_remove_favourite_ajax_ten');
function jobcircle_candidate_remove_favourite_ajax_ten() {
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
