<?php
// popular category frontend
function jobcircle_similar_jobs_frontend() {
ob_start()
?>
<div class="container">
				<div class="row similar-section pt-0 pb-35 pb-md-50 pb-lg-75 pb-xl-110">
					<h3><?php esc_html_e('Similar Jobs','jobcircle-frame')?></h3>
					<!-- Similar Jobs Slider -->
					<div class="similar-slider">

<?php
        $numofpost  = 4;
//this one
        $page_numbr = get_query_var('paged');
        $args = array(
           'post_type' => 'jobs',
            'post_status' => 'publish',                                                                                                                                                                                             
             'posts_per_page' => $numofpost, 
             'order' => 'DESC',  
             'tax_query' => array(                           
                array(
                    'taxonomy' => 'job_category',
                    'field'    => 'slug',
                    'terms'    => 'acounting',
                ),  
            ),  
        );
               
        // Custom query.// also this one 
        $query = new WP_Query( $args );
        $total_posts = $query->found_posts;
         
        // Check that we have query results.
        if ( $query->have_posts() ) {
        
            // Start looping over the query results.
            while ( $query->have_posts() ) {
                $query->the_post();
                global $post;
                $post =  get_post();   
                $postid =  $post->ID;       
                $title = get_the_title($postid);
                $permalinkget = get_permalink($postid);
                $posted = get_the_time('U');
				$minut =  human_time_diff($posted,current_time( 'U' )). "";
                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $postid ), 'single-post-thumbnail' );
                $categories = get_the_terms( $post, 'job_category' );
                //$country = get_post_meta($postid, 'country', true);
               // $country = jobcircle_post_location_str($postid);
                $country = get_post_meta($postid, 'jobcircle_field_loc_country', true);
                $social_media = get_post_meta($postid, 'social_media', true);
                $vacancies = get_post_meta($postid, 'vacancies', true);
                $experience = get_post_meta($postid, 'jobcircle_field_experience', true);
                $developer = get_post_meta($postid, 'jobcircle_field_developer', true);
                $full_time = get_post_meta($postid, 'jobcircle_field_full_time', true);
                $skills = wp_get_post_terms($postid, 'job_skill');

				global $current_user;
				$user_id = $current_user->ID;
				$fav_jobs = get_user_meta($user_id, 'fav_follower_list', true);
				$fav_jobs = !empty($fav_jobs) ? $fav_jobs : array();
				$like_btn_class = 'jobcircle-follower-btn';
				if (!is_user_logged_in()) {
					$like_btn_class = 'jobcircle-follower-btn no-user-follower-btn';
				} else {
					if (!jobcircle_user_candidate_id($user_id)) {
						$like_btn_class = 'jobcircle-follower-btn no-member-follower-btn';
					}
				}
				$fav_icon_class = 'profile-btn';
				$follow = 'fa fa-heart-o';
				if (in_array($postid, $fav_jobs)) {
					$like_btn_class = 'jobcircle-alrdy-favjab';
					$fav_icon_class = 'profile-btn';
					$follow = 'fa fa-heart';
				}
                ?>

                <div class="slick-slide">
							<!-- Featured Box -->
							<div class="featured-box">
							<a href="" class="pin-job <?php echo esc_html($like_btn_class)  ?> " data-id="<?php echo esc_html($postid) ?>"><i class=" <?php echo esc_html($fav_icon_class) ?> position-absolute <?php echo esc_html($follow) ?>"></i></a>
								<div class="textbox">
								    <?php if(!empty($permalinkget) && !empty($title)) { ?>
								    <a href="<?php echo esc_html($permalinkget) ?>">
									<h3 class="h4 simtitle"><?php echo esc_html($title) ?></h3>
									</a> 
									<?php } ?>
									<strong class="subtitle">
										<span class="icon">
										     <?php if(!empty($permalinkget) && !empty($image)) { ?>
										     <a href="<?php echo esc_html($permalinkget) ?>">
										    <img src="<?php echo esc_url_raw($image[0]) ?>" width="37" height="42" alt="<?php echo esc_html($title) ?>">
										    </a>
										    <?php } ?>
										    </span>
									<?php 
									$counter = 1;
                						if(!empty($categories)){
                							foreach ($categories as $category){ 
                							if($counter == 1){
                							?>
                							    	<span class="tag"><?php echo esc_html($category->name); ?></span>         
                						<?php 	}else{
                						    break;
                						}
                						$counter++;
                							    
                							}
                						}  ?>
									</strong>
									<ul class="stats-list">
										<li>
										     <?php if(!empty($social_media)) { ?>
											<i class="jobcircle-icon-briefcase1 icon"></i>
											<span class="text"><?php echo esc_html($social_media) ?></span>
											<?php } ?>
										</li>
										<li>
										    <?php if(!empty($country)) { ?>
											<i class="jobcircle-icon-map-pin icon"></i>
											<span class="text"><?php echo esc_html($country) ?></span>
											<?php } ?>
										</li>
										<li>
										     <?php if(!empty($minut)) { ?>
											<i class="jobcircle-icon-clock icon"></i>
											<span class="text"><?php echo esc_html($minut) ?></span>
											<?php } ?>
										</li>
										<li>
										    <?php if(!empty($vacancies)) { ?>
											<i class="jobcircle-icon-work_outline icon"></i>
											<span class="text"><?php echo esc_html($vacancies) ?></span>
											<?php } ?>
										</li>
									</ul>
                                    <ul class="tags-list">
                                        <?php 
                                        $counter = 0; // Initialize the counter
                                        if (!empty($skills)) {
                                            foreach ($skills as $skill) {
                                                if ($counter < 2) { // Display only the first 2 skills
                                                    ?>
                                                    <li><span class="tag">
                                                            <?php echo esc_html($skill->name) ?>
                                                        </span></li>
                                                    <?php
                                                    $counter++; // Increment the counter
                                                } else {
                                                    break; // Exit the loop after displaying 2 skills
                                                }
                                            }
                                        } else {
                                            echo '<li><span class="tag">No skills found</span></li>'; // Debug statement for no skills
                                        }
                                        ?>
                                    </ul>
								</div>
							</div>
						</div>
<?php
            }
        }      
       
       wp_reset_postdata();
        ?>
</div>
</div></div>
		
    <?php 
   
    return ob_get_clean();
}

// related job section start

function jobcircle_related_job_frontend() {

 ob_start();?>	
			<section class="section section-theme-1 section-categories related-categories bg-light-sky pt-35 pt-md-50 pt-lg-65 pt-xl-80 pt-xxl-110 pb-35 pb-md-50 pb-lg-65 pb-xl-80 pb-xxl-110">
				<div class="container">
					<div class="row justify-content-between mb-35 mb-lg-40">
						<div class="col-12 col-lg-8 col-xl-5">
							<!-- Section header -->
							<header class="section-header text-center text-lg-start mb-10 m-lg-0">
								<h2><?php esc_html_e('Related Jobs','jobcircle-frame') ?></h2>
								<p><?php esc_html_e('Most viewed and all-time top-selling services','jobcircle-frame') ?></p>
							</header>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<div class="jobs-listing-slider">
 <?php
        $numofpost  = 5;
        $args = array(
           'post_type' => 'jobs', //enter post type name static
            'post_status' => 'publish',                                                                                                                                     
             'posts_per_page' => $numofpost, 
             'order' => 'DESC',                     
                 );         
        // Custom query.
        $query = new WP_Query( $args );
        // Check that we have query results.
        if ( $query->have_posts() ) {        
            // Start looping over the query results.
            while ( $query->have_posts() ) {
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
				$minut =  human_time_diff($posted,current_time( 'U' )). "";
    		 	$job_salary = jobcircle_job_salary_str($post);
    			$job_img_url = jobcircle_job_thumbnail_url($post);
    			$job_location = jobcircle_post_location_str($post);
    			
    			$job_type = get_post_meta($post, 'jobcircle_field_job_type', true);
    			$job_type_str = jobcircle_job_type_ret_str($job_type);
			
             ?>	
             	<div class="slick-slide">
									<!-- Featured Category Box -->
									<article class="featured-category-box">
									    <?php if(!empty($job_type_str)) { ?>
										<span class="tag"><?php echo esc_html($job_type_str['title']); ?></span>
										<?php } ?>
										<div class="img-holder">
										     <?php if(!empty($permalinkget) && !empty($job_img_url)) { ?>
										    	<a href="<?php echo esc_html($permalinkget) ?>">
											<img src="<?php echo esc_url_raw($job_img_url); ?>" width="78" height="78" alt="<?php echo esc_html($title) ?>">
											</a>
											<?php } ?>
										</div>
										<div class="textbox">
										    <?php if(!empty($permalinkget) && !empty($title)) { ?>
										    <a href="<?php echo esc_html($permalinkget) ?>">
											<strong class="h6"><?php echo jobcircle_esc_the_html($title); ?></strong>
											</a>
											<?php } ?>
											<span class="subtitle"><?php esc_html_e('By','jobcircle-frame')?> <a href="<?php echo esc_html($post_author_link) ?>"><?php echo esc_html($post_author_name); ?></a></span>
											<address class="location"><i class="jobcircle-icon-map-pin icon"></i><span class="text"><?php echo esc_html($job_location); ?></span></address>
											<div class="job-info">
											    <?php if(!empty($minut)) { ?>
												<span class="subtext"><?php echo esc_html($minut) ?></span>
												<?php } ?>
												<?php if(!empty($job_salary)) { ?>
										<span class="amount"><strong><?php echo esc_html($job_salary) ?></strong></span>
										<?php } ?>
											</div>
											<?php if(!empty($permalinkget)) { ?>
											<a href="<?php echo esc_html($permalinkget) ?>" class="btn btn-dark-yellow btn-sm"><span class="btn-text"><span class="text aplbitn"><?php esc_html_e('Apply Now','jobcircle-frame')?></span><i class="jobcircle-icon-chevron-right"></i></span></a>
											<?php } ?>
										</div>
									</article>
								</div>
                <?php
            }
        }
        wp_reset_postdata();?>
             </div>
						</div>
					</div>
				</div>
			</section>
        <?php return ob_get_clean();
}

//candidates service start

function jobcircle_candidates_job_frontend() {

 ob_start();?>	
 <section class="conserve section section-theme-6 related-services related-categories bg-light-sky pt-35 pt-md-50 pt-lg-65 pt-xl-80 pt-xxl-110 pb-35 pb-md-50 pb-lg-65 pb-xl-80 pb-xxl-110">
				<div class="container">
					<div class="row justify-content-between mb-25 mb-lg-40">
						<div class="col-12 col-lg-8 col-xl-5">
							<!-- Section header -->
							<header class="section-header text-center text-lg-start mb-10 m-lg-0">
								<h2><?php esc_html_e('Candidate Services', 'jobcircle-frame')?></h2>
								<p><?php esc_html_e('Most viewed and all-time top-selling services', 'jobcircle-frame')?></p>
							</header>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<div class="services-carousel">
        <?php
        $numofpost  = 5;
        $args = array(
           'post_type' => 'candidates', //enter post type name static
            'post_status' => 'publish',                                                                                                                                     
             'posts_per_page' => $numofpost, 
             'order' => 'DESC', 
             'tax_query' => array(                           
                array(
                    'taxonomy' => 'candidate_cat',
                    'field'    => 'slug',
                    'terms'    => 'Finance',
                ),  
            ),                    
                 );         
        // Custom query.
        $query = new WP_Query( $args );
        // Check that we have query results.
        if ( $query->have_posts() ) {        
            // Start looping over the query results.
            while ( $query->have_posts() ) {
                $query->the_post();
                global $post;
                $post =  get_the_id();
                $title = get_the_title($post);
                $permalinkget = get_the_permalink($post);
                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post ), 'single-post-thumbnail' );   
                $admin = get_the_author();
				$job_salary = get_post_meta($post, 'jobcircle_field_salary', true);
				$designation = get_post_meta($post, 'designation', true);
                $author_id = get_the_author_meta('ID');
                $author_avatar = get_avatar($author_id, 96);
                $author_profile_link = get_author_posts_url($author_id);
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
                 ?>	
             	<div class="service-slide">
									<div class="inner-frame">
											<div class="image-holder">
											    <?php if(!empty($permalinkget) && !empty($image)) { ?>
											    	<a href="<?php echo esc_html($permalinkget) ?>">
												<img src="<?php echo esc_html($image[0]) ?>" alt="<?php echo esc_html($title) ?>">
												</a>
												<?php } ?>
											</div>
											<div class="service-info-box">
											    <?php if(!empty($designation)) { ?>
												<strong class="sub-heading"><?php echo esc_html($designation) ?></strong>
												<?php } ?>
												<?php if(!empty($permalinkget) && !empty($title)) { ?>
												<a href="<?php echo esc_html($permalinkget) ?>">
												<h2><?php echo esc_html($title) ?></h2>
												</a>
												<?php } ?>
												<div class="service-footer">
													<div class="img"><a href="<?php echo esc_html($author_profile_link) ?>"> <?php echo ($author_avatar) ?></a></div>
													<div class="text">
														<strong class="title"><a class="text-black" href="<?php echo esc_html($post_author_link) ?>"><?php echo esc_html($post_author_name) ?></a></strong>
														<p class="m-0 price"><?php esc_html_e('Starting at', 'jobcircle-frame')?>  <strong>$<?php echo esc_html($job_salary) ?></strong></p>
													</div>
												</div>
											</div>
									</div>
								</div>
                <?php
            }
        }
        wp_reset_postdata();?>
            </div>
						</div>
					</div>
				</div>
			</section>
        <?php return ob_get_clean();
}

//blog related post
function jobcircle_blog_from_frontend() {

ob_start()
?>
							<h4><?php esc_html_e('Related posts','jobcricle-frame') ?></h4>
							<div class="blogbtm gallery-slider post-styles">
        <?php
        $numofpost  = 3;
        $page_numbr = get_query_var('paged');
        $args = array(
           'post_type' => 'post',
            'post_status' => 'publish',    
             'posts_per_page' => $numofpost, 
             'tax_query' => array(                           
                array(
                    'taxonomy' => 'category',
                    'field'    => 'slug',
                    'terms'    => 'news-articles',
                ),  
            ),
        );
               
        // Custom query.// also this one 
        $query = new WP_Query( $args );
        $total_posts = $query->found_posts;
        // Check that we have query results.
        if ( $query->have_posts() ) {
            // Start looping over the query results.
            while ( $query->have_posts() ) {
                $query->the_post();
                global $post;
                $post =  get_post();   
                $postid =  $post->ID;       
                $title = get_the_title($postid);
                $excerpt = get_the_excerpt($postid);
                $comment = get_comments_number($postid);
                $permalinkget = get_permalink($postid);
                $date = date('M d Y');
                $admin =  get_the_author();
                $author_id = get_the_author_meta('ID');
                $author_profile_link = get_author_posts_url($author_id);
                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $postid ), 'single-post-thumbnail' );
                ?>
                <div class="slick-slide">
									<!-- News Post -->
									<article class="news-post">
										<div class="image-holder">
										    <?php if(!empty($permalinkget) && !empty($image)) { ?>
											<a href="<?php echo esc_html($permalinkget); ?>"><img src="<?php  echo esc_url_raw($image[0]);?>" width="470" height="315" alt="Image Description"></a>
									<?php } ?>
										</div>
										<div class="textbox">
										    <?php if(!empty($permalinkget) && !empty($title)) { ?>
											<h4 class="h5"><a href="<?php echo esc_html($permalinkget); ?>"><?php echo esc_html($title);?></a></h4>
											<?php } ?>
											<?php if(!empty($excerpt)) { ?>
											<p><?php echo esc_html($excerpt);?></p>
											<?php } ?>
										</div>
										<footer class="post-footer">
											<ul class="post-meta">
												<li><i class="icon icon-calendar2"></i> <time class="text" datetime="2023-03-20"><?php echo jobcircle_esc_the_html($date); ?></time></li>
												<li><i class="icon icon-message"></i> <span class="text"><?php echo esc_html( $comment);?> <?php esc_html_e( ' Comments ' , 'jobcircle-frame'); ?></span></li>
											</ul>
										</footer>
									</article>
								</div>
                                <?php
                }
            }       
    		add_action('wp_footer', function () {
			?>
				<script>
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
								action: 'jobcircle_candidate_fav_job_similar_job'
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
								action: 'jobcircle_candidate_remove_job_list_similar_jobs'
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
			});
			?>
		</div>
       <?php 
       
       wp_reset_postdata();
    return ob_get_clean();
}

// for favourite button
add_action('wp_ajax_jobcircle_candidate_fav_job_similar_job', 'jobcircle_candidate_fav_job_similar_job');
add_action('wp_ajax_nopriv_jobcircle_candidate_fav_job_similar_job', 'jobcircle_candidate_fav_job_similar_job');
function jobcircle_candidate_fav_job_similar_job()
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
add_action('wp_ajax_jobcircle_candidate_remove_job_list_similar_jobs', 'jobcircle_candidate_remove_job_list_similar_jobs');
add_action('wp_ajax_nopriv_jobcircle_candidate_remove_job_list_similar_jobs', 'jobcircle_candidate_remove_job_list_similar_jobs');
function jobcircle_candidate_remove_job_list_similar_jobs()
{
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
