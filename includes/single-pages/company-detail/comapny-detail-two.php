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
	$phone_number = get_post_meta($post->ID, 'jobcircle_field_user_phone', true);
	    $facebook_url = get_post_meta($post->ID, 'jobcircle_field_facebook_url', true);
        $twitter_url = get_post_meta($post->ID, 'jobcircle_field_twitter_url', true);
        $linkedin_url = get_post_meta($post->ID, 'jobcircle_field_linkedin_url', true);
	$email = get_post_meta($post->ID,'email', true);
	$loc_address = get_post_meta($post->ID, 'jobcircle_field_loc_address', true);
	$visit_site = get_post_meta($post->ID,'visit_site', true);
	$dob = get_post_meta($post->ID, 'jobcircle_field_founded_date', true);
	$technology = get_post_meta($post->ID, 'technology', true);
	$employee = get_post_meta($post->ID, 'team_size', true);
	$date = date('d M Y');
	$current_user = wp_get_current_user();
	?>
	<div class="subvisual-block subvisual-theme-1 bg-dark-green d-flex pt-60 pt-md-90 pt-lg-150 pb-30 text-white">
			<div class="pattern-image"><img src="images/visual-pattern-1.png" width="1920" height="570" alt="Pattern"></div>
			<div class="container position-relative text-center">
				<div class="row">
					<div class="col-12">
						<div class="subvisual-textbox">
							<h1><?php jobcircle_post_page_title() ?></h1>
							<p><?php esc_html_e('Company information including open jobs.', 'jobcircle-frame') ?></p>
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
			<!-- conpany Details Section -->
			<section class="section section-company-details section-theme-1 pt-35 pt-md-50 pt-lg-75 pt-xl-100 pb-35 pb-md-50 pb-xl-100">
				<div class="container">
					<div class="row">
						<div class="col-12 col-md-7 col-xl-8">
							<?php echo the_content();?>
							</div>
							<div class="col-12 col-md-5 col-xl-4 pt-35 pt-md-0">
							<div class="company-info-box">
								<div class="company-info-head">
									<div class="company-logo">
										<img src=" <?php echo esc_html($image[0]);?>" width="108" height="108" alt="Develpersoft">
									</div>
									<div class="textbox">
										<h4> <?php echo esc_html($title);?></h4>
									<?php 
                                        $counter = 0;
                                        // Ensure that 'employer_category' is replaced with the actual taxonomy name associated with your 'employer' post type
                                        $terms = get_terms(array(
                                            'taxonomy' => 'employer_cat',  // This should be the taxonomy related to 'employer'
                                            'hide_empty' => false,
                                            'parent' => 0,
                                            'number' => 2,  // This is optional, limits the number of terms fetched
                                        ));
                                        
                                        // Check if terms were retrieved successfully
                                        if (is_array($terms) && !empty($terms)) {
                                            echo '<p class="techno">';
                                            foreach ($terms as $term) {
                                                if ($counter < 2) {
                                                    echo esc_html($term->name);
                                                    if ($counter == 0 && count($terms) > 1) {  // Check if it's the first term and not the only term
                                                        echo ', ';
                                                    }
                                                    $counter++;
                                                } else {
                                                    break;
                                                }
                                            }
                                            echo '</p>';
                                        } else {
                                            echo '<p>No categories found.</p>';  // Handle the case where no terms are found or there's an error
                                        }
                                        ?>

										<p> <?php esc_html_e('Employee','jobcircle-frame');?>:  <?php echo esc_html($employee);?></p>
										<p> <?php esc_html_e('Founded:','jobcircle-frame');?>  <?php echo $date ?></p>
										<div class="btn-wrap pt-15 pb-25">
						<a href="#" class="btn btn-green btn-sm"><span class="btn-text"><?php esc_html_e('Message:','jobcircle-frame');?></span></a>
										</div>
										<p><a href="https://jobcircle.miraclesoftsolutions.com/"> <?php echo esc_html($visit_site);?></a></p>
									</div>
								</div>
								<div class="company-contact-info">
									<ul class="company-contact-list">
										<li>
											<i class="jobcircle-icon-phone ico"></i>
											<div class="textinfo">
												<strong class="title"> <?php esc_html_e('Phone No:','jobcircle-frame');?> </strong>
												<span class="text"><a href="tel:<?php echo esc_html($phone_number)?>"><?php echo esc_html($phone_number);?></a></span>
											</div>
										</li>
										<li>
											<i class="jobcircle-icon-mail ico"></i>
											<div class="textinfo">
												<strong class="title"> <?php esc_html_e('Email Address:','jobcircle-frame');?>: </strong>
												<span class="text"><a href="mailto:<?php echo $current_user->user_email  ?>"><?php echo $current_user->user_email  ?></a></span>
											</div>
										</li>
										<li>
											<i class="jobcircle-icon-map-pin ico"></i>
											<div class="textinfo">
												<strong class="title"> <?php esc_html_e('Location:','jobcircle-frame');?> </strong>
												<address class="text"> <?php echo esc_html($loc_address);?> </address>
											</div>
										</li>
										<li>
											<div class="textinfo">
								<strong class="title"> <?php esc_html_e('Social Media Profiles:','jobcircle-frame');?></strong>
								<ul class="social-networks d-flex flex-wrap">
								<li><a href="<?php echo esc_html($facebook_url);?>"><i class="jobcircle-icon-facebook"></i></a></li>
								<li><a href="<?php echo esc_html($linkedin_url);?>"><i class="fa fa-linkedin"></i></a></li>
								<li><a href="<?php echo esc_html($twitter_url);?>"><i class="jobcircle-icon-twitter"></i></a></li>
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
get_footer();
