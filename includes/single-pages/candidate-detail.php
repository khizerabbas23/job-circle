<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Jobcircle
 */

get_header();
$post = get_post();
$postid = $job_id = $post->ID;
global $jobcircle_framework_options;
$default_job_view = isset($jobcircle_framework_options['job_select_detail_view']) ? $jobcircle_framework_options['job_select_detail_view'] : '';
$candidate_style_view = get_post_meta($post->ID, 'jobcircle_field_candidate_detail_view', true);
if ($candidate_style_view != '') {
	$job_slected_style = $candidate_style_view;
} else {
	$job_slected_style = $default_job_view;
}
 if ($job_slected_style == 'style2') {
	include 'candidate_detail/candidate-detail-two.php';
} else {
?>

<div class="subvisual-block bg-dark-green d-flex align-items-center pt-100 pt-md-140 pt-xl-180 pt-xxl-230 pb-60 pb-md-100 pb-xl-125 pb-xxl-145 text-white">
			<span class="shape top"><img src="<?php echo Jobcircle_Plugin::root_url()?>/images/banner-shape-top.webp" width="93" height="241" alt="Banner Shape Top"></span>
			<span class="shape bottom"><img src="<?php echo Jobcircle_Plugin::root_url()?>/images/banner-inner-bottom.png" width="979" height="249" alt="Banner Shape Bottom"></span>
			<div class="icons-image"><img src="<?php echo Jobcircle_Plugin::root_url()?>/images/icons-inner.png" width="1187" height="274" alt="Icons"></div>
			<div class="container position-relative text-center">
				<div class="row">
					<div class="col-12">
						<h1>Candidate Detail</h1>
						<nav class="breadcrumb-nav bg-primary text-white d-inline-flex">
							<ul class="breadcrumb mb-0">
								<li class="breadcrumb-item"><a href="<?php echo esc_url(home_url()); ?>"><?php esc_html_e('Home', 'jobcircle-frame') ?></a></li>
								<li class="breadcrumb-item active"><?php jobcircle_post_page_title() ?></li>
							</ul>
						</nav>
					</div>
				</div>
			</div>
		</div>
<main class="main">
	<div class="container">
		<section class=" visual-banner bg-light-gray pt-0 pb-0 mt-35 mt-md-50 mt-lg-75 mt-xl-105">
			<?php 
		while (have_posts()) :
			the_post();
			$post = get_post();
			$postid = $post->ID;

			$terms = get_the_terms($postid, 'candidate_skill'); 
			If (empty($terms)) {
			   $terms = array();
		   }
					$total_lenght = count($terms);
			
		
 $candidate = get_the_id();
 $image = wp_get_attachment_image_src( get_post_thumbnail_id($post), 'single-post-thumbnail' ); 
 $time_tag = get_post_meta($post->ID, 'jobcircle_field_time_tag', true);
 $title = get_the_title();
 $content = get_the_content();
 $job_title = get_post_meta($postid, 'jobcircle_field_job_title', true);
 $banner = get_post_meta($postid, 'banner', true);
 $Play_image = get_post_meta($candidate, 'jobcircle_field_Play_image', true);
 $banner_img = get_post_meta($postid, 'jobcircle_field_banner_img', true);
 $current_user = wp_get_current_user();
 $phone_number = get_post_meta($postid, 'jobcircle_field_user_phone', true);
 $email = get_post_meta($postid, 'jobcircle_field_user_email', true);
 $address = get_post_meta($postid, 'jobcircle_field_loc_address', true);
 $date = date('Y-d-m');
 $qualification = get_post_meta($postid, 'academic_level', true);
 $experience = get_post_meta($postid, 'experience', true);
 $candidate_contact = get_post_meta($candidate, 'jobcircle_field_candidate_contact', true);
 $capcha_image = get_post_meta($candidate, 'jobcircle_field_capcha_image', true);
        $facebook_url = get_post_meta($postid, 'jobcircle_field_facebook_url', true);
        $twitter_url = get_post_meta($postid, 'jobcircle_field_twitter_url', true);
        $linkedin_url = get_post_meta($postid, 'jobcircle_field_linkedin_url', true);
        $google_url = get_post_meta($postid, 'jobcircle_field_google_url', true);

	global $jobcircle_framework_options;
	//
	$jobcircle_framework_options = get_option('jobcircle_framework_options');

	$jobcircle_framework_options = get_option('jobcircle_framework_options');

	$ad_type_select = isset($jobcircle_framework_options['ad_type_select']) ? $jobcircle_framework_options['ad_type_select'] : '';
	$ad_code = isset($jobcircle_framework_options['ad_code']) ? $jobcircle_framework_options['ad_code'] : '';
	$ad_image = isset($jobcircle_framework_options['ad_image']) ? $jobcircle_framework_options['ad_image'] : '';
	$ad_placement = isset($jobcircle_framework_options['ad_placement']) ? $jobcircle_framework_options['ad_placement'] : '';
	$ad_location = isset($jobcircle_framework_options['ad_location']) ? $jobcircle_framework_options['ad_location'] : '';

 ?>




			<div class="image-holder"> 
			<?php if(!empty($banner_img)) { ?>
				<img src="<?php echo $banner_img ?>" width="1500" height="600" alt="Infinity Solutions">
				<?php }else { ?>
				<img src="<?php echo Jobcircle_Plugin::root_url()?>/images/image-candidatej.jpg" width="1500" height="600" alt="Infinity Solutions">
				<?php
				} ?>
			</div>
			<!-- Details Block -->
			<div class="details-block candidate-info">
				<div class="icon-box">
					<img src="<?php echo $image[0]?>" width="140" height="140" alt="Infinity Solutions">
				</div>
				<div class="textbox">
					<h2 class="h4"><?php echo $title?> </h2>
					<span class="subtitle h5"><?php echo esc_html($job_title) ?></span>
				</div>
				<div class="button-box">
					<a href="#" class="btn btn-primary"><span
							class="btn-text"><?php echo esc_html_e('Download Cv','jobcircle-frame')?></span></a>
				</div>
			</div>
		</section>
		<!-- Column Wrapper -->
		<div class="row column-wrapper pt-35 pt-lg-45 pt-35 pb-35 pb-lg-75 pb-xl-125 comdetil">
			<div class="col-12 col-lg-8 mb-35 mb-lg-0">
				<!-- Details Wrapper -->
				<div class="details-column">
					<!-- Candidate Video Intro -->

					<?php
					
					// Retrieve the values for each field
					$ad_type_select_values = isset($jobcircle_framework_options['ad_type_select']) ? $jobcircle_framework_options['ad_type_select'] : array();
					$ad_code_values = isset($jobcircle_framework_options['ad_code']) ? $jobcircle_framework_options['ad_code'] : array();
					$ad_placement_values = isset($jobcircle_framework_options['ad_placement']) ? $jobcircle_framework_options['ad_placement'] : array();
					$ad_image_values = isset($jobcircle_framework_options['jobcircle-sixteen-ad-image']) ? $jobcircle_framework_options['jobcircle-sixteen-ad-image'] : array();
					$ad_location_values = isset($jobcircle_framework_options['ad_location']) ? $jobcircle_framework_options['ad_location'] : array();

					// Loop through the items and display based on conditions
					foreach ($ad_type_select_values as $index => $ad_type_select) {
						$ad_code = isset($ad_code_values[$index]) ? $ad_code_values[$index] : '';
						$ad_placement = isset($ad_placement_values[$index]) ? $ad_placement_values[$index] : '';
						$ad_image = isset($ad_image_values[$index]) ? $ad_image_values[$index] : '';
						$ad_location = isset($ad_location_values[$index]) ? $ad_location_values[$index] : '';
						
						// Check if the user has selected "Ad Placement" = 'job' and "AD Location" = 'top_sidebar'
						if ($ad_placement === 'candidate_details' && $ad_location === 'top_content') {
							if ($ad_type_select === 'code') {
								// Display the code
								echo "$ad_code" ."<br/>";
							} elseif ($ad_type_select === 'image') {
								// Display the image (if it exists)
								if (!empty($ad_image['url'])) {
									echo "<div class='filters-sidebar-ad-image'><img src='{$ad_image['url']}' alt='Ad Image'></div>";
								}
							}
						}
					}

					?>
					<?php echo do_shortcode($content);?>

					<?php 
					do_action('jobcircle_user_reviews', $post->ID, $post->post_type);
					// Loop through the items and display based on conditions
					foreach ($ad_type_select_values as $index => $ad_type_select) {
						$ad_code = isset($ad_code_values[$index]) ? $ad_code_values[$index] : '';
						$ad_placement = isset($ad_placement_values[$index]) ? $ad_placement_values[$index] : '';
						$ad_image = isset($ad_image_values[$index]) ? $ad_image_values[$index] : '';
						$ad_location = isset($ad_location_values[$index]) ? $ad_location_values[$index] : '';
						
						// Check if the user has selected "Ad Placement" = 'job' and "AD Location" = 'top_sidebar'
						if ($ad_placement === 'candidate_details' && $ad_location === 'bottom_content') {
							if ($ad_type_select === 'code') {
								// Display the code
								echo "$ad_code" ."<br/>";
							} elseif ($ad_type_select === 'image') {
								// Display the image (if it exists)
								if (!empty($ad_image['url'])) {
									echo "<div class='filters-sidebar-ad-image'><img src='{$ad_image['url']}' alt='Ad Image'></div>";
								}
							}
						}
					}
					?>
				</div>
			</div>

			<div class="col-12 col-lg-4">
				<?php 
					// Loop through the items and display based on conditions
					foreach ($ad_type_select_values as $index => $ad_type_select) {
						$ad_code = isset($ad_code_values[$index]) ? $ad_code_values[$index] : '';
						$ad_placement = isset($ad_placement_values[$index]) ? $ad_placement_values[$index] : '';
						$ad_image = isset($ad_image_values[$index]) ? $ad_image_values[$index] : '';
						$ad_location = isset($ad_location_values[$index]) ? $ad_location_values[$index] : '';
						
						// Check if the user has selected "Ad Placement" = 'job' and "AD Location" = 'top_sidebar'
						if ($ad_placement === 'candidate_details' && $ad_location === 'top_sidebar') {
							if ($ad_type_select === 'code') {
								// Display the code
								echo "$ad_code" ."<br/>";
							} elseif ($ad_type_select === 'image') {
								// Display the image (if it exists)
								if (!empty($ad_image['url'])) {
									echo "<div class='filters-sidebar-ad-image'><img src='{$ad_image['url']}' alt='Ad Image'></div>";
								}
							}
						}
					}
					?>
				<aside class="sidebar">
					<!-- Aside Box -->
					<div class="aside-box bg-light-gray mb-20 mb-md-30">
						<!-- About List -->
						<ul class="about-list">
							<li>
								<span class="icon"><i class="jobcircle-icon-envelope"></i></span>
								<div class="textbox">
									<strong class="subtitle h5"><?php esc_html_e('Email','jobcircle-frame')?></strong>
									<span class="subtext"><a
											href="mailto:<?php echo $email ?>"><?php echo $email ?></a></span>
								</div>
							</li>
							<li>
								<span class="icon"><i class="jobcircle-icon-phone"></i></span>
								<div class="textbox">
									<strong
										class="subtitle h5"><?php esc_html_e('Phone Number','jobcircle-frame')?></strong>
									<span class="subtext"><a
											href="tel:<?php echo esc_html($phone_number)?>"><?php echo esc_html($phone_number)?></a></span>
								</div>
							</li>
							<li>
								<span class="icon"><i class="jobcircle-icon-map-pin"></i></span>
								<div class="textbox">
									<strong class="subtitle h5"><?php esc_html_e('Address','jobcircle-frame')?></strong>
									<span class="subtext"><?php echo esc_html($address)?></span>
								</div>
							</li>
							<li>
								<span class="icon"><i class="jobcircle-icon-calendar"></i></span>
								<div class="textbox">
									<strong
										class="subtitle h5"><?php esc_html_e('Member Since','jobcircle-frame')?></strong>
									<time class="subtext"
										datetime="2023-12-08"><?php echo $date ?></time>
								</div>
							</li>
							<li>
								<span class="icon"><i class="jobcircle-icon-document-certificate"></i></span>
								<div class="textbox">
									<strong
										class="subtitle h5"><?php esc_html_e('Qualification','jobcircle-frame')?></strong>
									<span class="subtext"><?php echo esc_html($qualification,'jobcircle-frame')?></span>
								</div>
							</li>
							<li>
								<span class="icon"><i class="jobcircle-icon-work_outline"></i></span>
								<div class="textbox">
									<strong
										class="subtitle h5"><?php esc_html_e('Experience','jobcircle-frame')?></strong>
									<span class="subtext"><?php echo esc_html($experience) ?></span>
								</div>
							</li>
						</ul>
						<!-- Social Networks -->
						<ul class="social-networks large">
							<li><a href="<?php echo esc_html($facebook_url)?>"><i
										class="jobcircle-icon-facebook"></i></a></li>
							<li><a href="<?php echo esc_html($linkedin_url)?>"><i
										class="fa fa-linkedin"></i></a></li>
							<li><a href="<?php echo esc_html($twitter_url)?>"><i
										class="jobcircle-icon-twitter"></i></a></li>
							<li><a href="<?php echo esc_html($google_url)?>"><i
										class="jobcircle-icon-google-plus"></i></a></li>
						</ul>
					</div>
					<!-- Aside Box -->
					<div class="aside-box bg-light-gray mb-20 mb-md-30 form-styles">
						<h4 class="h5"><?php esc_html_e('Candidate Contact','jobcircle-frame')?></h4>
						 <script>
                          jQuery(function () {
                            jQuery('.mailform').on('submit', function (e) {
                              e.preventDefault();
                              	var this_form = jQuery(this);
                				var from_element = this_form[0];
                				var form_data = new FormData(from_element);
                              jQuery.ajax({
                            	type: "POST",
                        		processData: false,
                    			contentType: false,
                    			dataType: "json",
                    			url: '<?php echo admin_url('admin-ajax.php'); ?>',
                                data: form_data,
                                success: function (data) {
                                if(data.error == '1'){
                                jobcircle_submit_msg_alert(data.msg ,'jobcircle-alert-warning');
                                }else{
                                     jobcircle_submit_msg_alert(data.msg ,'jobcircle-alert-success');
                                }
                                }
                              });
                    
                            });
                    
                          });
                        </script>
						<!-- Contact Form -->
						<form class="contac-form mailform" action="#" method="post">
									<div class="row">
										<div class="col-12 mb-15 mb-md-20">
											<input class="form-control form-control-sm" name="fname" type="text" placeholder="<?php esc_attr_e('First Name', 'jobcircle-frame');?>">
										</div>
										
										<div class="col-12 mb-15 mb-md-20">
											<input class="form-control form-control-sm" name="lstname" type="text" placeholder="<?php esc_attr_e('Last Name', 'jobcircle-frame');?>">
										</div>
										<div class="col-12 mb-15 mb-md-20">
											<input class="form-control form-control-sm" name="subject" type="text" placeholder="<?php esc_attr_e('Subject', 'jobcircle-frame');?>">
										</div>
										<div class="col-12 mb-15 mb-md-20">
											<textarea class="form-control form-control-sm" cols="30" rows="10" name="comment" placeholder="<?php esc_attr_e('Comment', 'jobcircle-frame');?>"></textarea>
										</div>
										<div class="col-12 mb-15 mb-md-20 captcha-box">
											<span class="captcha-text"><?php echo esc_html_e('Please tick the box to continue:' , 'jobcircle-frame')?></span>
            											 <?php
                                            $captcha_switch = isset($jobcircle_framework_options['captcha_switch']) ? $jobcircle_framework_options['captcha_switch'] : '';
                                            $captcha_sitekey = isset($jobcircle_framework_options['captcha_sitekey']) ? $jobcircle_framework_options['captcha_sitekey'] : '';
                                            $captcha_secretkey = isset($jobcircle_framework_options['captcha_secretkey']) ? $jobcircle_framework_options['captcha_secretkey'] : '';
            
                                            if ($captcha_switch == 'on' && $captcha_sitekey != '' && $captcha_secretkey != '') {
                                                $recaptcha_id = 'recaptcha_' . rand(10000, 99999);
                                                ?>
                                                <div class="captcha-holder">
                                                <div class="jobcircle-recaptcha-holdrcon" id="<?php echo ($recaptcha_id) ?>_div">
                                                    <?php
                                                    echo jobcircle_recaptcha($recaptcha_id);
                                                    ?>
                                                </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
										</div>
										<div class="col-12">
											<input type="hidden" name="action" value="jobcircle_email_form"><button class="btn btn-primary btn-sm w-100" type="submit"><span class="btn-text submit-button"><?php esc_html_e('Send Message', 'jobcircle-frame');?></span></button>
										</div>
									</div>
								</form>

					<?php 
					// Loop through the items and display based on conditions
					foreach ($ad_type_select_values as $index => $ad_type_select) {
						$ad_code = isset($ad_code_values[$index]) ? $ad_code_values[$index] : '';
						$ad_placement = isset($ad_placement_values[$index]) ? $ad_placement_values[$index] : '';
						$ad_image = isset($ad_image_values[$index]) ? $ad_image_values[$index] : '';
						$ad_location = isset($ad_location_values[$index]) ? $ad_location_values[$index] : '';
						
						// Check if the user has selected "Ad Placement" = 'job' and "AD Location" = 'top_sidebar'
						if ($ad_placement === 'candidate_details' && $ad_location === 'bottom_sidebar') {
							if ($ad_type_select === 'code') {
								// Display the code
								echo "$ad_code" ."<br/>";
							} elseif ($ad_type_select === 'image') {
								// Display the image (if it exists)
								if (!empty($ad_image['url'])) {
									echo "<div class='filters-sidebar-ad-image'><img src='{$ad_image['url']}' alt='".esc_attr__('Ad Image', 'jobcircle-frame')."'></div>";
								}
							}
						}
					}
					
    	?>
			</div>
			</aside>
			<?php
					endwhile; // End of the loop.
					?>
		</div>
</main>
</section>
<?php
}
get_footer();
