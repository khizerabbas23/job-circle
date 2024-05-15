<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 */
        get_header();       
        $post = get_post();
        $postid = $job_id = $post->ID;
        $user_id = get_current_user_id();
        global $jobcircle_framework_options;
        global $job_map_items;      
       $employer_id = jobcircle_user_employer_id($user_id);    
        $default_job_view = isset($jobcircle_framework_options['job_select_detail_view']) ? $jobcircle_framework_options['job_select_detail_view'] : '';       
        $job_style_view = get_post_meta($post->ID, 'jobcircle_field_job_detail_view', true);
        if ($job_style_view != '') {
        	$job_slected_style = $job_style_view;
        } else {
        	$job_slected_style = $default_job_view;
        }
         if ($job_slected_style == 'style3') {
        	include 'job-detail/job-detail-two.php';
        } else if ($job_slected_style == 'style2') {
        	include 'job-detail/job-detail-one.php';
        } else {
	//print_r($job_slected_style);
	$image = wp_get_attachment_image_src(get_post_thumbnail_id($post), 'single-post-thumbnail');
	$title = get_the_title($postid);
	$job_location = jobcircle_post_location_str($postid);
	$full_time = get_post_meta($post->ID, 'jobcircle_field_full_time', true);	
  	  $job_type = get_post_meta($post, 'jobcircle_field_job_type', true);
  	  $job_type_str = jobcircle_job_type_ret_str($job_type);
	$Site = get_post_meta($postid, 'jobcircle_field_visit_site', true);
	$siteurl = get_post_meta($postid, 'jobcircle_field_visit_site_url', true);
	$apply = get_post_meta($postid, 'jobcircle_field_applynow', true);
   	$date = date('M-Y-d');
	$posted_date = get_post_meta($postid, 'jobcircle_field_posted_date', true);
	$employee = get_post_meta($employer_id, 'team_size', true);
	$current_user = wp_get_current_user();
	$phone_number = get_post_meta($employer_id, 'jobcircle_field_user_phone', true);
	$email = get_post_meta($employer_id, 'jobcircle_field_user_email', true);
	$facebook_url = get_post_meta($employer_id, 'jobcircle_field_facebook_url', true);
    $twitter_url = get_post_meta($employer_id, 'jobcircle_field_twitter_url', true);
    $linkedin_url = get_post_meta($employer_id, 'jobcircle_field_linkedin_url', true);
    $google_url = get_post_meta($employer_id, 'jobcircle_field_google_url', true);
    $latitue = get_post_meta($postid, 'jobcircle_field_loc_latitude', true);
    $longitude = get_post_meta($postid, 'jobcircle_field_loc_longitude', true);
    $banner_img = get_post_meta($postid, 'jobcircle_field_banner_img', true);
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
                        $follow = 'Follow';

                        if (in_array($postid, $fav_jobs)) {
                            $like_btn_class = 'jobcircle-alrdy-favjab';
                            $fav_icon_class = 'profile-btn';
                            $follow = 'Un Follow';
                        }	
	if(!empty($latitue) && !empty($longitude)){
			ob_start();
			?>
			{
				lat: <?php echo $latitue; ?>,
				lng: <?php echo $longitude; ?>,
				// description: "This is a description text.",

				// phone: "+1 212 456 7890",

				// siteLink: "<a href='<?php echo get_permalink(); ?>' target='_blank'>Site Link</a>",

			},
			<?php
			$job_map_items .= ob_get_clean();
            }
		add_action('wp_footer', function() use($job_map_items) {   
	if ($job_map_items != '') {
		?>
		<script>
			function initMap() {
  // Define an array to hold your dynamic location data (e.g., from JSON)
  var locations = [
    <?php echo ($job_map_items) ?>
  ];
  var map = new google.maps.Map(document.getElementById("map"), {
    zoom: 5,
    center: { lat: 37.0902, lng: -95.7129 }, // United States coordinates
  });
  var infowindow = new google.maps.InfoWindow();
  // Create custom markers and info windows for your dynamic location data
  for (var i = 0; i < locations.length; i++) {
  (function (i) {
    var marker = new google.maps.Marker({
      position: { lat: locations[i].lat, lng: locations[i].lng },
      map: map,
      title: locations[i].name,
      icon: {
        url: "<?php echo Jobcircle_Plugin::root_url()?>/images/map-ping.png", // Custom pin image URL
        scaledSize: new google.maps.Size(30, 42), // Set the width and height
      },
    });
    // Create a content string for the info window
    var contentString =
      "<div class='map-tooltip'>" +
      "</div>";
      google.maps.event.addListener(marker, "click", function () {
        var geocoder = new google.maps.Geocoder();
        var latlng = { lat: locations[i].lat, lng: locations[i].lng };     
        geocoder.geocode({ location: latlng }, function (results, status) {
          if (status === "OK") {
            if (results[0]) {
              // Find the city name in address components
              var cityName = "";
              for (var j = 0; j < results[0].address_components.length; j++) {
                for (var k = 0; k < results[0].address_components[j].types.length; k++) {
                  if (results[0].address_components[j].types[k] === "locality") {
                    cityName = results[0].address_components[j].long_name;
                    break;
                  }
                }
              }     
              // Concatenate location name, image, and address from geocoding results
              var locationInfo =
                "<div class='map-tooltip'>" +
                "<div class='tooltip-image'>" +
                "<img src='" + locations[i].imageSrc + "' alt='Image Description'>" +
                "</div>" +
                "<strong class='tooltip-title'>" + locations[i].title + "</strong>" +
                "<p class='location-address'><span class='fa-solid fa-location-dot address-pin'></span> " + "<span class='address-text'>" + results[0].formatted_address + "</span></p>"
                "</div>";    
              // Create a new contentString for each click
              var newContentString = contentString + locationInfo;
              infowindow.setContent(newContentString);
              infowindow.open(map, marker);
            } else {
              console.error("No results found");
            }
          } else {
            console.error("Geocoder failed due to: " + status);
          }
        });
      });    
    })(i);
  }
}
		</script>
		<?php
	}
}, 1);
	?>
		<div class="subvisual-block bg-dark-green d-flex align-items-center pt-100 pt-md-140 pt-xl-180 pt-xxl-230 pb-60 pb-md-100 pb-xl-125 pb-xxl-145 text-white">
			<span class="shape top"><img src="<?php echo Jobcircle_Plugin::root_url()?>/images/banner-shape-top.webp" width="93" height="241" alt="Banner Shape Top"></span>
			<span class="shape bottom"><img src="<?php echo Jobcircle_Plugin::root_url()?>/images/banner-inner-bottom.png" width="979" height="249" alt="Banner Shape Bottom"></span>
			<div class="icons-image"><img src="<?php echo Jobcircle_Plugin::root_url()?>/images/icons-inner.png" width="1187" height="274" alt="Icons"></div>
			<div class="container position-relative text-center">
				<div class="row">
					<div class="col-12">
						<h1>Job Detail</h1>
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
		<!-- Visual Banner -->
		<section class="visual-banner bg-light-gray pt-0 pb-0 mt-35 mt-md-50 mt-lg-75 mt-xl-105">
		    
			<div class="image-holder"> 
			<?php if(!empty($banner_img)) { ?>
				<img src="<?php echo $banner_img ?>" width="1500" height="600" alt="Infinity Solutions">
				<?php }else { ?>
				<img src="<?php echo Jobcircle_Plugin::root_url()?>/images/image-company.jpg" width="1500" height="600" alt="Infinity Solutions">
				<?php
				} ?>
			</div>

			<!-- Details Block -->

			<div class="details-block">

				<div class="icon-box">

					<?php if(!empty($image[0])){?>
						<img src="<?php echo esc_url_raw($image[0]) ?>" width="83" height="45" alt="Infinity Solutions">					
					<?php }?>

				</div>

				<div class="textbox">

					<!-- Heading Row -->

					<div class="heading-row">

						<h2 class="h4"><?php echo esc_html($title) ?></h2>

					</div>

					<div >

						

					</div>

					<?php 

							$apply_btns_html = apply_filters('jobcircle_job_single_social_apply_btns', '', $job_id, 'view-1');

							if (!empty($apply_btns_html)) {

							    echo '<div class="jobcircle-applybtns-holder">' . $apply_btns_html . '</div>';

							}

							?>

					<!-- Meta Items -->

					<ul class="meta-items">

						<li>

							<span class="icon"><i class="jobcircle-icon-briefcase1"></i></span>
						<?php
                            $categories = wp_get_post_terms($postid, 'job_category');
                            if (!empty($categories) && !is_wp_error($categories)) {
                                $category_name = esc_html($categories[0]->name);
                                echo '<strong class="subtitle">' . $category_name . '</strong>';
                            }
                            ?>
                            
						</li>

						<li>

							<span class="icon"><i class="jobcircle-icon-map-pin"></i></span>
							<strong class="subtitle"><?php echo esc_html($job_location) ?></strong>

						</li>

					</ul>

					<!-- Buttons List -->

					<ul class="buttons-list">

						<li class="btn-follow"><a href="javascript:void(0);" class="btn btn-primary btn-sm <?php echo $like_btn_class ?>" data-id="<?php echo $postid ?>"><span class="btn-text  <?php echo $fav_icon_class ?>"><?php echo $follow ?></span></a></li>

						<?php
						if ($Site != '') {
							?>
							<li><a class="btn btn-primary btn-sm" href="<?php echo 	esc_html($siteurl) ?>"><span
										class="btn-text"><?php echo esc_html($Site) ?></span></a></li>
							<?php
						}
						?>
						<li><a class="btn btn-primary btn-sm"><span class="btn-text"><?php echo $job_type_str['title']; ?></span></a></li>
						<li class="jobcircle-aplybtn-con"><a href="javascript:;" class="jobcircle-det-applybtn jobdet-applybtn-act btn btn-primary btn-sm" data-id="<?php echo ($job_id) ?>" data-bs-toggle="modal"

							data-bs-target="#jobcircle-apply-job-popup"><span class="btn-text"><?php esc_html_e('Apply Job','jobcircle-frame');?></span></a></li>

					</ul>

				</div>



			</div>

		</section>

		<!-- Column Wrapper -->

		<div class="row column-wrapper pt-35 pt-md-50 pt-lg-45 pt-35 pb-md-50 pb-lg-65">



			<div class="col-12 col-lg-8 mb-35 mb-lg-0">

				<!-- Details Wrapper -->

				<?php



				global $jobcircle_framework_options;

				//

				$jobcircle_framework_options = get_option('jobcircle_framework_options');



				$jobcircle_framework_options = get_option('jobcircle_framework_options');



				$ad_type_select = isset($jobcircle_framework_options['ad_type_select']) ? $jobcircle_framework_options['ad_type_select'] : '';

				$ad_code = isset($jobcircle_framework_options['ad_code']) ? $jobcircle_framework_options['ad_code'] : '';

				$ad_image = isset($jobcircle_framework_options['ad_image']) ? $jobcircle_framework_options['ad_image'] : '';

				$ad_placement = isset($jobcircle_framework_options['ad_placement']) ? $jobcircle_framework_options['ad_placement'] : '';

				$ad_location = isset($jobcircle_framework_options['ad_location']) ? $jobcircle_framework_options['ad_location'] : '';



				

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

						if ($ad_placement === 'job_details' && $ad_location === 'top_content') {

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



				<?php echo the_content(); ?>



				<?php

				

					// Loop through the items and display based on conditions

					foreach ($ad_type_select_values as $index => $ad_type_select) {

						$ad_code = isset($ad_code_values[$index]) ? $ad_code_values[$index] : '';

						$ad_placement = isset($ad_placement_values[$index]) ? $ad_placement_values[$index] : '';

						$ad_image = isset($ad_image_values[$index]) ? $ad_image_values[$index] : '';

						$ad_location = isset($ad_location_values[$index]) ? $ad_location_values[$index] : '';



						// Check if the user has selected "Ad Placement" = 'job' and "AD Location" = 'top_sidebar'

						if ($ad_placement === 'job_details' && $ad_location === 'bottom_content') {

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

				<?php

						echo apply_filters('jobcircle_job_single_after_the_content', '', $job_id, 'view-1');

						?>

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

						if ($ad_placement === 'job_details' && $ad_location === 'top_sidebar') {

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

				<!-- Sidebar -->

				<aside class="sidebar">

					<!-- Aside Box -->

					<div class="aside-box bg-light-gray mb-20 mb-md-30">

						<!-- About List -->

						<ul class="about-list">

							<li>

								<span class="icon"><i class="jobcircle-icon-calendar"></i></span>

								<div class="textbox">

									<strong class="subtitle h5">

										<?php esc_html_e('Date posted','jobcircle-frame');?></strong>

									<time class="subtext"

										datetime="2023-12-08"><?php echo esc_html($date) ?></time>

								</div>

							</li>
							<?php 
                               $current_user = wp_get_current_user();
                             if ( $current_user instanceof WP_User ) {
                                    $email = $current_user->user_email;
                                }   
                                if(!empty($email)){ ?> 
							<li>
								<span class="icon"><i class="jobcircle-icon-mail1"></i></span>
								<div class="textbox">
									<strong class="subtitle h5"><?php esc_html_e('Email','jobcircle-frame');?></strong>
									<span class="subtext"><a href="mailto:<?php echo $email ?>"><?php echo $email ?></a></span>
								</div>
							</li>
							<?php
                                }
								$current_user = wp_get_current_user();
                                $user_id = $current_user->ID;
                                $employer_id = jobcircle_user_employer_id($user_id);
                                $candidate_id = jobcircle_user_candidate_id($user_id);
                                
                                if(!empty($employer_id)){
                                    $phoneid = $employer_id;
                                }elseif(!empty($candidate_id)){
                                    $phoneid = $candidate_id;
                                }
                                
                                $phone_number = get_post_meta($phoneid, 'jobcircle_field_user_phone', true);
							       if(!empty($phone_number)){    ?>

							<li>
								<span class="icon"><i class="jobcircle-icon-phone"></i></span>
								<div class="textbox">
									<strong	class="subtitle h5"><?php esc_html_e('Phone Number','jobcircle-frame');?></strong>
									<span class="subtext"><a><?php echo $phone_number; ?></a></span>
								</div>
							</li>
							<?php } ?>

							<li>

								<span class="icon"><i class="jobcircle-icon-map-pin"></i></span>

								<div class="textbox">

									<strong

										class="subtitle h5"><?php esc_html_e('Location','jobcircle-frame');?></strong>

									<span class="subtext"><?php echo esc_html($job_location) ?></span>

								</div>

							</li>

							<li>

								<span class="icon"><i class="jobcircle-icon-group-outline"></i></span>

								<div class="textbox">

									<strong class="subtitle h5">

										<?php esc_html_e('Company Size','jobcircle-frame');?></strong>

									<span class="subtext"><?php echo esc_html($employee) ?> <?php esc_html_e('Emmployes', 'jobcircle-frame') ?></span>

								</div>

							</li>

						</ul>

						<!-- Social Networks -->

						<ul class="social-networks large">

							<li><a href="<?php echo $facebook_url ?>"><i

										class="jobcircle-icon-facebook"></i></a></li>

							<li><a href="<?php echo $google_url ?>"><i

										class="jobcircle-icon-google-plus"></i></a></li>

							<li><a href="<?php echo $twitter_url ?>"><i

										class="jobcircle-icon-twitter"></i></a></li>

							<li><a href="<?php echo $linkedin_url ?>"><i

										class="fa fa-linkedin"></i></a></li>

						</ul>

					</div>

					<!-- Aside Box -->

					<div id="mapstyel" class="aside-box bg-light-gray mb-30 mb-md-30">

						<div id="map" class="map-holder">

                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3023.228235889099!2d-73.99838752347539!3d40.735003136206416!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c2599799c5d041%3A0x555f998519eaa4ce!2s26%20W%2012th%20St%2C%20New%20York%2C%20NY%2010011%2C%20USA!5e0!3m2!1sen!2s!4v1685637946572!5m2!1sen!2s" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

						</div>

					</div>

				</aside>

				<?php

					// Loop through the items and display based on conditions

					foreach ($ad_type_select_values as $index => $ad_type_select) {

						$ad_code = isset($ad_code_values[$index]) ? $ad_code_values[$index] : '';

						$ad_placement = isset($ad_placement_values[$index]) ? $ad_placement_values[$index] : '';

						$ad_image = isset($ad_image_values[$index]) ? $ad_image_values[$index] : '';

						$ad_location = isset($ad_location_values[$index]) ? $ad_location_values[$index] : '';



						// Check if the user has selected "Ad Placement" = 'job' and "AD Location" = 'top_sidebar'

						if ($ad_placement === 'job_details' && $ad_location === 'bottom_sidebar') {

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

			

			</div>

<?php echo jobcircle_similar_jobs_frontend() ?>


</main>


<?php
 
		
	}

get_footer();
