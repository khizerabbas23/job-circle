<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Jobcircle
 */
get_header();
?>
<section class="comdetil section section-company-details section-theme-1 pt-35 pt-md-50 pt-lg-75 pt-xl-100 pb-35 pb-md-50 pb-xl-100">
<?php 
		while (have_posts()) :
			the_post();
			$post = get_post();
			$postid = $post->ID;

			$terms = get_the_terms($postid, 'candidate_cat');
			If (empty($terms)) {
			   $terms = array();
		   }
					$total_lenght = count($terms);
			
		
 $candidate = get_the_id( $postid ,'candidates' , true);
 $image = wp_get_attachment_image_src( get_post_thumbnail_id($post), 'single-post-thumbnail' ); 
 $time_tag = get_post_meta($post->ID, 'jobcircle_field_time_tag', true);
 $title = get_the_title();
 $content = get_the_content();
 $current_user = wp_get_current_user();
 $phone_number = get_post_meta($postid, 'jobcircle_field_user_phone', true);
 $address = get_post_meta($postid, 'jobcircle_field_loc_address', true);
 $download_cv = get_post_meta($postid, 'download_cv', true);
 $salary = get_post_meta($postid, 'salary', true);
 $employ = get_post_meta($postid, 'team_size', true);
 $job_title = get_post_meta($postid, 'jobcircle_field_job_title', true);
 $facebook_url = get_post_meta($postid, 'jobcircle_field_facebook_url', true);
 $twitter_url = get_post_meta($postid, 'jobcircle_field_twitter_url', true);
 $linkedin_url = get_post_meta($postid, 'jobcircle_field_linkedin_url', true);
 $job_salary = jobcircle_candidate_salary_str($postid, 'k');
 ?> 
 <div class="subvisual-block subvisual-theme-1 bg-dark-green d-flex pt-60 pt-md-90 pt-lg-150 pb-30 text-white">
 <div class="pattern-image"><img src="<?php echo Jobcircle_Plugin::root_url()?>/images/visual-pattern-1.png" width="1920" height="570" alt="Pattern"></div>
 <div class="container position-relative text-center">
	 <div class="row">
		 <div class="col-12">
			 <div class="subvisual-textbox">
				 <h1><?php jobcircle_post_page_title() ?></h1>
				 <p><?php esc_html_e('Your profile contains your basic personal information', 'jobcircle-frame') ?></p>
			 </div>
			 <nav class="breadcrumb-nav text-white d-flex justify-content-center mt-20 mt-lg-40">
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
<section class="section section-company-details section-theme-1 pt-35 pt-md-50 pt-lg-75 pt-xl-100 pb-35 pb-md-50 pb-xl-100 theme_sevenb">	
				<div class="container">
					<div class="row">
						<div class="col-12 col-md-7 col-xl-8">

						<?php echo $content?>

							<div class="block-holder form-condidates">
								<div class="subhead">
									<h4><?php esc_html_e('Email to Candidate','jobcircle-frame')?></h4>
									<p><?php esc_html_e('Your email address & profile will be shown to the recipient.','jobcircle-frame')?></p>
								</div>
								<!-- Contact Form -->
								<?php
                         echo do_shortcode('[contact-form-7 id="3854" title="form-detail"]');
                         ?>
							</div>
							
						</div>


						<div class="col-12 col-md-5 col-xl-4 pt-35 pt-md-0">
							<div class="company-info-box">
								<div class="company-info-head">
									<div class="company-logo">
										<img src="<?php echo esc_url_raw($image[0])?>" width="108" height="108" alt="Develpersoft">
									</div>
									<div class="textbox">
										<h4><?php echo esc_html($title)?></h4>
										<p><?php echo esc_html($job_title)?></p>
										<p><?php esc_html_e('Employee:','jobcircle-frame')?>  <?php echo esc_html($employ)?></p>
										<p><?php esc_html_e('Expected Salary:','jobcircle-frame')?><br>
										<?php echo $job_salary ?></p>
										<div class="btn-wrap pt-15 pb-25">
											<a href="#" class="btn btn-green btn-sm"><span class="btn-text"><?php esc_html_e('Download CV','jobcircle-frame')?></span></a>
										</div>
									</div>
								</div>
								<div class="company-contact-info">
									<ul class="company-contact-list">
										<li>
											<i class="jobcircle-icon-phone ico"></i>
											<div class="textinfo">
												<strong class="title"><?php esc_html_e('Phone No:','jobcircle-frame')?></strong>
												<span class="text"><a href="tell:<?php echo esc_html($phone_number)?>"><?php echo esc_html($phone_number)?></a></span>
											</div>
										</li>
										<li>
											<i class="jobcircle-icon-mail ico"></i>
											<div class="textinfo">
												<strong class="title"><?php esc_html_e('Email Address:','jobcircle-frame')?></strong>
												<span class="text"><a href="mailto:<?php echo $current_user->user_email?>"><?php echo $current_user->user_email?></a></span>
											</div>
										</li>
										<li>
											<i class="jobcircle-icon-map-pin ico"></i>
											<div class="textinfo">
												<strong class="title"><?php esc_html_e('Location:','jobcircle-frame')?></strong>
												<address class="text"><?php echo esc_html($address)?></address>
											</div>
										</li>
										<li>
											<div class="textinfo">
												<strong class="title"><?php esc_html_e('Social Media Profiles:','jobcircle-frame')?></strong>
												<ul class="social-networks d-flex flex-wrap">
													<li><a href="<?php echo esc_html($facebook_url)?>"><i class="jobcircle-icon-facebook"></i></a></li>
													<li><a href="<?php echo esc_html($linkedin_url)?>"><i class="fa fa-linkedin"></i></a></li>
													<li><a href="<?php echo esc_html($twitter_url)?>"><i class="jobcircle-icon-twitter"></i></a></li>
												</ul>
											</div>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
		</section>
				</main>
						<?php
					endwhile; // End of the loop.
					?>
					</section>
					<?php echo jobcircle_candidates_job_frontend() ?>
 <?php
get_footer();