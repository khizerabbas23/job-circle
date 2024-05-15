<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 */

get_header();

$post = get_post();
$postid = $job_id = $post->ID;
global $jobcircle_framework_options;

	$image = wp_get_attachment_image_src(get_post_thumbnail_id($post), 'single-post-thumbnail');
	$title = get_the_title($postid);
	$content = get_the_content($postid);	
		$content = apply_filters('the_content', $content);
	$job_img = get_post_meta($post->ID, 'image', true);
	$copmany = get_post_meta($post->ID, 'copmany', true);
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
	 $job_salary = jobcircle_job_salary_str($post->ID, 'k');
	$expertiess = get_post_meta($postid, 'jobcircle_field_expertiexs', true);
    $job_location = jobcircle_post_location_str($post->ID);
	$facebook_url = isset($jobcircle_framework_options['jobcircle-footer-facebook-url']) ? $jobcircle_framework_options['jobcircle-footer-facebook-url'] : '';
    $instagram_url = isset($jobcircle_framework_options['jobcircle-footer-instagram-url']) ? $jobcircle_framework_options['jobcircle-footer-instagram-url'] : '';
    $twitter_url = isset($jobcircle_framework_options['jobcircle-footer-twitter-url']) ? $jobcircle_framework_options['jobcircle-footer-twitter-url'] : '';
    $linkdin_url = isset($jobcircle_framework_options['jobcircle-footer-linkdin-url']) ? $jobcircle_framework_options['jobcircle-footer-linkdin-url'] : '';
	$experience = get_post_meta($post->ID, 'experince', true);
	$job_type = get_post_meta($post, 'jobcircle_field_job_type', true);
    $job_type_str = jobcircle_job_type_ret_str($job_type);
	$experiance = get_post_meta($post->ID, 'jobcircle_field_experiance', true);
	global $current_user;
	$user_id = $current_user->ID;

	$fav_jobs = get_user_meta($user_id, 'fav_jobs_list', true);
	$fav_jobs = !empty($fav_jobs) ? $fav_jobs : array();
	$like_btn_class = 'jobcircle-favjab-btn';
	if(!is_user_logged_in(  )){
		$like_btn_class = 'jobcircle-favjab-btn no-user-follower-btn';
	}else{
		if(!jobcircle_user_candidate_id($user_id)){
		$like_btn_class = 'jobcircle-favjab-btn no-member-follower-btn';
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
<div class="subvisual-block subvisual-theme-1 bg-dark-green d-flex pt-60 pt-md-90 pt-lg-150 pb-30 text-white det-cls-two">
			<div class="pattern-image"><img src="<?php echo Jobcircle_Plugin::root_url()?>/images/visual-pattern-1.png" width="1920" height="570" alt="Pattern"></div>
			<div class="container position-relative text-center">
				<div class="row">
					<div class="col-12">
						<div class="subvisual-textbox">
							<h1><?php jobcircle_post_page_title() ?></h1>
							<p><?php esc_html_e('job duties, job responsibilities, and skills required', 'jobcircle-frame') ?></p>
						</div>
						<nav class="breadcrumb-nav text-white d-flex justify-content-center mt-20 mt-lg-40">
							<ul class="breadcrumb mb-0">
								<li class="breadcrumb-item"><a href="<?php echo esc_url(home_url()); ?>"><?php esc_html_e('Home', 'jobcircle-frame') ?></a></li>
								<li class="breadcrumb-item"><?php jobcircle_post_page_title() ?></li>
								
							</ul>
						</nav>
					</div>
				</div>
			</div>
		</div>
<main class="main">
<section class="section section-job-details add-styles section-theme-1 pt-35 pt-md-50 pt-lg-75 pt-xl-100 pb-35 pb-md-50 pb-xl-100 sectipedng">
				<div class="container">
					<header class="job-details-header mb-30 mb-md-45 mb-lg-60">
						<ul class="post-meta">
							<li> <?php esc_html_e('By&nbsp;', 'jobcircle-frame');?>  <a class="text-black" href="<?php echo $post_author_link ?>"> <?php echo $post_author_name ?> </a></li>
							<li><i class="jobcircle-icon-map-pin icon"></i><span class="text"> <?php echo esc_html($job_location);?></span></li>
						</ul>
						<h2> <?php echo esc_html($title);?></h2>
						<div class="social-info">
							<strong class="title"> <?php esc_html_e('Social Sharing:','jobcircle-frame');?></strong>
							<ul class="social-networks">
								<li><a href="<?php echo esc_html($facebook_url);?>"><i class="jobcircle-icon-facebook"></i></a></li>
								<li><a href="<?php echo esc_html($linkdin_url);?>"><i class="jobcircle-icon-linkedin"></i></a></li>
								<li><a href="<?php echo esc_html($twitter_url);?>"><i class="jobcircle-icon-twitter"></i></a></li>
								<li><a href="<?php echo esc_html($instagram_url);?>"><i class="jobcircle-icon-instagram"></i></a></li>
							</ul>
						</div>
						<div class="utility-buttons">
						<a href="javascript:void(0);" class="btn-tag <?php echo $like_btn_class  ?> " data-id="<?php echo $postid ?>"><i class=" <?php echo $fav_icon_class ?> position-absolute <?php echo $follow ?>"></i></a>
							
						</div>
						<div class="company-info-job">
							<ul class="job-info-list">
								<li>
									<span class="text"> <?php esc_html_e('Salary:','jobcircle-frame');?></span>
									<span class="text"> <?php echo $job_salary ;?></span>
								</li>
								<li>
									<span class="text"> <?php esc_html_e('Expertise:','jobcircle-frame');?></span>
									<span class="text"> <?php echo esc_html($expertiess);?> </span>
								</li>
								<li>
									<span class="text"> <?php esc_html_e('Job Type:','jobcircle-frame');?></span>
									<span class="text"> <?php echo esc_html($job_type_str['title']); ?></span>
								</li>
								<li>
									<span class="text"> <?php esc_html_e('Experience:','jobcircle-frame');?></span>
									<span class="text"> <?php echo esc_html($experiance);?></span>
								</li>
							</ul>
<?php

global $jobcircle_framework_options;
    global $wpdb;
    global $current_user;
    $user_id = get_current_user_id();
    $employer_id = jobcircle_user_employer_id($user_id);  
    
    if (jobcircle_user_account_type($user_id) != 'employer') {
        
    ?>
    <a href="javascript:;" class="jobcircle-det-applybtn jobdet-applybtn-act btn-green btn btn-primary btn-sm" data-id="<?php echo esc_attr($job_id); ?>" data-bs-toggle="modal" data-bs-target="#jobcircle-apply-job-popup">
        <span class="btn-text"><?php esc_html_e('Apply Job', 'jobcircle-frame'); ?></span>
    </a>
    <?php
} 
?>

						</div>
					</header>
					<div class="row">
						<div class="col-12">
		
					<?php echo $content ?>

                    </div>
					</div>
				</div>
				
			</section>
			<?php echo jobcircle_related_job_frontend() ?>
		</main>

	<?php
get_footer();
