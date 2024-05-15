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
global $job_map_items;
$default_job_view = isset($jobcircle_framework_options['job_select_detail_view']) ? $jobcircle_framework_options['job_select_detail_view'] : '';
$company_style_view = get_post_meta($post->ID, 'jobcircle_field_company_detail_view', true);
if ($company_style_view != '') {
	$job_slected_style = $company_style_view;
} else {
	$job_slected_style = $default_job_view;
}
 if ($job_slected_style == 'style2') {
	include 'company-detail/comapny-detail-two.php';
} else {

    	$image = wp_get_attachment_image_src(get_post_thumbnail_id($post), 'single-post-thumbnail');
    	$title = get_the_title($postid);
    	$phone_number = get_post_meta($post->ID, 'jobcircle_field_user_phone', true);
    	$date = get_the_date('M-Y-d');
        $facebook_url = get_post_meta($post->ID, 'jobcircle_field_facebook_url', true);
        $twitter_url = get_post_meta($post->ID, 'jobcircle_field_twitter_url', true);
        $linkedin_url = get_post_meta($post->ID, 'jobcircle_field_linkedin_url', true);
        $google_url = get_post_meta($post->ID, 'jobcircle_field_google_url', true);
        $banner_img = get_post_meta($post->ID, 'jobcircle_field_banner_img', true);
        $current_user = wp_get_current_user();
    	$job_location = jobcircle_post_location_str($postid);
	    $latitue = get_post_meta($postid, 'jobcircle_field_loc_latitude', true);
    	$longitude = get_post_meta($postid, 'jobcircle_field_loc_longitude', true);
    	$employee = get_post_meta($postid, 'team_size', true);
    	$email = get_post_meta($postid, 'jobcircle_field_user_email', true);
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
                        $follow = 'Followed';

                        if (in_array($postid, $fav_jobs)) {
                            $like_btn_class = 'jobcircle-alrdy-favjab';
                            $fav_icon_class = 'profile-btn';
                            $follow = 'Unfollow';
                        }	
		global $jobcircle_framework_options;
	//
	$jobcircle_framework_options = get_option('jobcircle_framework_options');

	$jobcircle_framework_options = get_option('jobcircle_framework_options');
	 $banner_img = get_post_meta($postid, 'jobcircle_field_banner_img', true);
	$ad_type_select = isset($jobcircle_framework_options['ad_type_select']) ? $jobcircle_framework_options['ad_type_select'] : '';
	$ad_code = isset($jobcircle_framework_options['ad_code']) ? $jobcircle_framework_options['ad_code'] : '';
	$ad_image = isset($jobcircle_framework_options['ad_image']) ? $jobcircle_framework_options['ad_image'] : '';
	$ad_placement = isset($jobcircle_framework_options['ad_placement']) ? $jobcircle_framework_options['ad_placement'] : '';
	$ad_location = isset($jobcircle_framework_options['ad_location']) ? $jobcircle_framework_options['ad_location'] : '';
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
						<h1><?php jobcircle_post_page_title() ?></h1>
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
					<img src="<?php echo esc_url_raw($image[0]);?>" width="83" height="45" alt="Infinity Solutions">
				</div>
				<div class="textbox">
					<!-- Heading Row -->
					<div class="heading-row" style="display:block;">
						<h2 class="h4"><?php echo esc_html($title) ?></h2>
						<div class="reviews-box" style="padding: 20px 0px 0px 0px;">
							<ul class="star-ratings">
								<li><i class="jobcircle-icon-star filled"></i></li>
								<li><i class="jobcircle-icon-star filled"></i></li>
								<li><i class="jobcircle-icon-star filled"></i></li>
								<li><i class="jobcircle-icon-star filled"></i></li>
								<li><i class="jobcircle-icon-star"></i></li>
							</ul>
							<strong class="review-stats"><?php esc_html_e('(115 Reviews)','jobcircle-frame');?></strong>
						</div>
					</div>
					<!-- Meta Items -->
					<ul class="meta-items">
						<li>
							<span class="icon"><i class="jobcircle-icon-briefcase1"></i></span>
                          <strong class="subtitle"><?php echo esc_html($follow)?></strong>

						</li>
						<li>
							<span class="icon"><i class="jobcircle-icon-map-pin"></i></span>
							<strong class="subtitle"> <?php echo esc_html($job_location);?></strong>
						</li>
					</ul>
					<!-- Buttons List -->
					<ul class="buttons-list">
						<li class="btn-follow"><a href="" class="btn btn-primary btn-sm <?php echo $like_btn_class ?>" data-id="<?php echo $postid ?>"><span class="btn-text  <?php echo $fav_icon_class ?>"><?php echo $follow ?></span></a></li>
									
                    <?php
                    $counter = 0;
                    $terms = get_terms(array(
                        'post_type' => 'employer',
                        'hide_empty' => false,
                        'parent' => 0,
                    ));
                    
                    foreach ($terms as $term) {
                        if ($counter < 3) {
                            $args = array(
                                'post_type' => 'employer',
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'employer_cat', // Replace with the actual taxonomy name
                                        'field' => 'term_taxonomy_id',
                                        'terms' => $term->term_id,
                                    ),
                                ),
                            );
                            $term_id = $term->term_id;
                            $term_meta = get_term_meta($term_id, 'job_category_custom_fields', true);
                            ?>
                            <li><a class="btn btn-primary btn-sm" href="<?php echo get_term_link($term); ?>"><span
                                        class="btn-text"><?php echo $term->name; ?></span></a></li>
                            <?php
                            $counter++;
                        } else {
                            break;
                        }
                    }
                    ?>
					</ul>
				</div>
			</div>
		</section>
		<!-- Column Wrapper -->
		<div class="row column-wrapper pt-35 pt-md-50 pt-lg-45 pt-35 pb-md-50 pb-lg-75 pb-xl-125">
			<div class="col-12 col-lg-8 mb-35 mb-lg-0">


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
						if ($ad_placement === 'employer_details' && $ad_location === 'top_content') {
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
				<!-- Details Wrapper -->
				<?php echo the_content(); ?>

				<?php 
					do_action('jobcircle_user_reviews', $post->ID, $post->post_type);
				
					// Loop through the items and display based on conditions
					foreach ($ad_type_select_values as $index => $ad_type_select) {
						$ad_code = isset($ad_code_values[$index]) ? $ad_code_values[$index] : '';
						$ad_placement = isset($ad_placement_values[$index]) ? $ad_placement_values[$index] : '';
						$ad_image = isset($ad_image_values[$index]) ? $ad_image_values[$index] : '';
						$ad_location = isset($ad_location_values[$index]) ? $ad_location_values[$index] : '';
						
						// Check if the user has selected "Ad Placement" = 'job' and "AD Location" = 'top_sidebar'
						if ($ad_placement === 'employer_details' && $ad_location === 'bottom_content') {
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

			<div class="col-12 col-lg-4">
				<?php 
				
					// Loop through the items and display based on conditions
					foreach ($ad_type_select_values as $index => $ad_type_select) {
						$ad_code = isset($ad_code_values[$index]) ? $ad_code_values[$index] : '';
						$ad_placement = isset($ad_placement_values[$index]) ? $ad_placement_values[$index] : '';
						$ad_image = isset($ad_image_values[$index]) ? $ad_image_values[$index] : '';
						$ad_location = isset($ad_location_values[$index]) ? $ad_location_values[$index] : '';
						
						// Check if the user has selected "Ad Placement" = 'job' and "AD Location" = 'top_sidebar'
						if ($ad_placement === 'employer_details' && $ad_location === 'top_sidebar') {
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
									<time class="subtext" datetime="2023-12-08"><?php echo esc_html($date);?></time>
								</div>
							</li>
							<li>
								<span class="icon"><i class="jobcircle-icon-mail1"></i></span>
								<div class="textbox">
									<strong class="subtitle h5"> <?php esc_html_e('Email','jobcircle-frame');?></strong>
									<span class="subtext"><a href="mailto:<?php echo $email ?>">
											<?php echo $email ?></a></span>
								</div>
							</li>
							<li>
								<span class="icon"><i class="jobcircle-icon-phone"></i></span>
								<div class="textbox">
									<strong
										class="subtitle h5"><?php esc_html_e('Phone Number','jobcircle-frame');?></strong>
									<span class="subtext"><a href="tel:<?php echo esc_html($phone_number);?>">
											<?php echo esc_html($phone_number);?></a></span>
								</div>
							</li>
							<li>
								<span class="icon"><i class="jobcircle-icon-map-pin"></i></span>
								<div class="textbox">
									<strong
										class="subtitle h5"><?php esc_html_e('Location','jobcircle-frame');?></strong>
									<span class="subtext"> <?php echo esc_html($job_location);?></span>
								</div>
							</li>
							<li>
								<span class="icon"><i class="jobcircle-icon-group-outline"></i></span>
								<div class="textbox">
									<strong
										class="subtitle h5"><?php esc_html_e('Company Size','jobcircle-frame');?></strong>
									<span class="subtext"><?php echo esc_html($employee);?></span>
								</div>
							</li>
						</ul>
						<!-- Social Networks -->
						<ul class="social-networks large">
							<li><a href="<?php echo esc_html($facebook_url);?>"><i
										class="jobcircle-icon-facebook"></i></a></li>
							<li><a href="<?php echo esc_html($google_url);?>"><i
										class="jobcircle-icon-google-plus"></i></a></li>
							<li><a href="<?php echo esc_html($twitter_url);?>"><i
										class="jobcircle-icon-twitter"></i></a></li>
							<li><a href="<?php echo esc_html($linkedin_url);?>"><i
										class="fa fa-linkedin"></i></a></li>
						</ul>
					</div>
					<!-- Aside Box -->
					<div class="aside-box bg-light-gray mb-20 mb-md-30 form-styles">
						<h4 class="h5"><?php esc_html_e('Contact','jobcircle-frame');?></h4>
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
					</div>
					<!-- Aside Box -->
					<div id="mapstyel" class="aside-box bg-light-gray mb-30 mb-md-30">
						<div id="map" class="map-holder ">
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
						if ($ad_placement === 'employer_details' && $ad_location === 'bottom_sidebar') {
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
		</div>
	</div>
</main>
<?php
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
                            action: 'jobcircle_candidate_fav_comapny_listalamsaen'
                        },
                        success: function(data) {
                            var totalFavorites = data.total_favorites;
                            _this.removeClass('jobcircle-follower-btn');
                            _this.addClass('jobcircle-alrdy-favjab');
                            _this.addHtml('Follow');
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
                            action: 'jobcircle_candidate_remove_company_listindetail'
                        },
                        success: function(data) {
                            var totalFavorites = data.total_favorites;
                            _this.removeClass('jobcircle-alrdy-favjab');
                            _this.addClass('jobcircle-follower-btn');
                            _this.addHtml('Unfollow');
                        },
                        error: function() {
                            this_icon.attr('class', 'profile-btn position-absolute');
                        }
                    });
                });
            </script>
        <?php
        });

}
get_footer();



add_action('wp_ajax_jobcircle_candidate_fav_comapny_listalamsaen', 'jobcircle_candidate_fav_comapny_listalamsaen');
add_action('wp_ajax_nopriv_jobcircle_candidate_fav_comapny_listalamsaen', 'jobcircle_candidate_fav_comapny_listalamsaen');
function jobcircle_candidate_fav_comapny_listalamsaen()
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
add_action('wp_ajax_jobcircle_candidate_remove_company_listindetail', 'jobcircle_candidate_remove_company_listindetail');
add_action('wp_ajax_nopriv_jobcircle_candidate_remove_company_listindetail', 'jobcircle_candidate_remove_company_listindetail');
function jobcircle_candidate_remove_company_listindetail()
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
