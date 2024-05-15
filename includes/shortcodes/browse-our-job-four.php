<?php
function jobcircle_browse_our_job()
{
    $job_types = jobcircle_job_types_list();
    $job_new_types = array();
    foreach ($job_types as $job_type_slug => $job_type) {
        $job_new_types[$job_type['title']] = $job_type_slug;
    };
    vc_map(
        array(
            'name' => __('Browse Our Job4'),
            'base' => 'browse_our_job',
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
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Discription'),
                    'param_name' => 'disc',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Image'),
                    'param_name' => 'image',
                ),
                array(
                    'type' => 'checkbox',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Checkbox Options'),
                    'param_name' => 'checkbox_param',
                    'value' => $job_new_types,
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Button'),
                    'param_name' => 'btn',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Button Url'),
                    'param_name' => 'btn_url',
                ),
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
                    'heading' => __('Pagination'),
                    'param_name' => 'pagination',
                    'value' => array(
                        __('Yes', 'your_text_domain') => 'yes',
                        __('No', 'your_text_domain') => 'no',
                    ),
                ),
                array(
                    'type' => 'dropdown',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('View All Button'),
                    'param_name' => 'view_all_button',
                    'value' => array(
                        __('Yes', 'your_text_domain') => 'yes',
                        __('No', 'your_text_domain') => 'no',
                    ),
                ),
                
            )
        )
    
    );
    }
add_action('vc_before_init', 'jobcircle_browse_our_job');
// Frontend Coding  
           global $numofpost;
           global $orderby;
function jobcircle_browse_our_job_front($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'title' => '',
            'disc' => '',
            'image' => '',
            'orderby' => '',
            'numofpost' => '',
            'btn' => '',
            'btn_url' => '',
            'pagination' => '',
            'view_all_button' => '',
            'checkbox_param' => '',

        ),
        $atts,
        'jobcircle_browse_our_job'
    );

    $title = isset($atts['title']) ? $atts['title'] : '';
    $disc = isset($atts['disc']) ? $atts['disc'] : '';
    $btn = isset($atts['btn']) ? $atts['btn'] : '';
    $btn_url = isset($atts['btn_url']) ? $atts['btn_url'] : '';
    $checkbox_param = isset($atts['checkbox_param']) ? $atts['checkbox_param'] : '';
    $pagination  = isset($atts['pagination']) ? $atts['pagination'] : '';
    $view_all_button  = isset($atts['view_all_button']) ? $atts['view_all_button'] : '';
 
    $job_type_arr = !empty($checkbox_param) ? explode(',', $checkbox_param) : '';
    $image = isset($atts['image']) ? $atts['image'] : '';
    $job_types = jobcircle_job_types_list();

    ob_start();

?>
    <section class="section section-theme-4 browse-jobs-block bg-light-gray pt-35 pt-md-50 pt-lg-75 pt-xxl-120 pb-35 pb-md-50 pb-lg-65 pb-xxl-100">
        <div class="container ">
            <!-- Section header -->
            <header class="section-header d-flex flex-column text-center mb-30 mb-lg-42">
                <?php if(!empty($title)){
                    ?>
                <h2><?php echo jobcircle_esc_the_html($title) ?></h2>
                <?php 
                }
                if(!empty($disc)){
                ?>
                <p><?php echo jobcircle_esc_the_html($disc) ?></p>
                <?php } 
                if(!empty($image)){?>
                <img src="<?php echo esc_url_raw($image) ?>" width="26" alt="icon">
                <?php 
                }?>
            </header>
            <nav class="tabs-bar">
            <ul class="list-inline m-0 mb-20 mb-lg-30 mb-xl-30" id="jobTypeList">
    <li class="active"><a href=""><?php echo esc_html_e('Recent Jobs' , 'jobcircle-frame')?></a></li>
    <?php
    if (!empty($job_type_arr)) {
        foreach ($job_type_arr as $job_type_slug) {
    ?>
            <li><a href="javascript:;" data-fval="<?php echo jobcircle_esc_the_html($job_type_slug); ?>"><?php echo ($job_types[$job_type_slug]['title']) ?></a></li>
    <?php
        }
    }
    ?>
</ul>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var jobTypeList = document.getElementById('jobTypeList');
    
    jobTypeList.addEventListener('click', function(event) {
        var clickedElement = event.target;

        // Remove "active" class from all list items
        var listItems = jobTypeList.getElementsByTagName('li');
        for (var i = 0; i < listItems.length; i++) {
            listItems[i].classList.remove('active');
        }

        // Add "active" class to the clicked list item
        if (clickedElement.tagName === 'A') {
            clickedElement.parentNode.classList.add('active');
        }
        if (clickedElement.textContent === 'Recent Jobs') {
             event.preventDefault();
            jQuery.ajax({
                type: "POST",
                dataType: "json",
                url: '<?php echo admin_url('admin-ajax.php') ?>',
                data: {
                    action: 'browsejob_ajax_action_filter_jobcircle',
                    fval: 'all' // Empty value for Recent Jobs
                },
                success: function(data) {
                    console.log(data);
                    jQuery('.browse-job-container').html(data.html);
                    // Handle the response data here
                },
                error: function() {
                    console.error('AJAX error');
                }
            });
        }
    });
});
</script>

                
                    <script>
                        jQuery(document).on('click', 'li a[data-fval]', function() {
                            var fval = jQuery(this).data('fval');
                            // Define your meta query here
                            jQuery.ajax({
                                type: "POST",
                                dataType: "json",
                                url: '<?php echo admin_url('admin-ajax.php') ?>',
                                data: {
                                    action: 'browsejob_ajax_action_filter_jobcircle',
                                    fval: fval // Include the meta query in the AJAX request
                                },
                                success: function(data) {
                                    console.log(data);
                                    jQuery('.browse-job-container').html(data.html);
                                    // Handle the response data here
                                },
                                error: function() {
                                    console.error('AJAX error');
                                }
                            });
                        });
                    </script>
            </nav>
            <div class="jobs-frame browse-job-container">


                <?php
                global $numofpost;
                global $orderby;
                $numofpost  = isset($atts['numofpost']) ? $atts['numofpost'] : '';
                $orderby  = isset($atts['orderby']) ? $atts['orderby'] : '';

                $args = array(
                    'post_type' => 'jobs',
                    'post_status' => 'publish',
                    'posts_per_page' => $numofpost,
                    'order' => 'DESC',
                    'orderby' =>  $orderby,
                    
                );
                // Custom query.
                $query = new WP_Query($args);
                $total_posts = $query->found_posts;

                // Check that we have query results.
                if ($query->have_posts()) {

                    // Start looping over the query results.
                    while ($query->have_posts()) {
                        $query->the_post();

                        global $jobcircle_framework_options, $post;

                        $get_id =  get_the_id();
                      
                        $permalinkget = get_permalink($get_id);
                        $image = wp_get_attachment_image_src(get_post_thumbnail_id($get_id), 'single-post-thumbnail');
                        
                        $title = get_the_title($get_id);
                        
                        $view_profile = get_post_meta($get_id, 'jobcircle_field_apply_view_profile', true);
                        
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

                        $place = get_post_meta($post->ID, 'jobcircle_field_place', true);

                        $experience = get_post_meta($post->ID, 'jobcircle_field_experiance', true);
                        $full_time = get_post_meta($post->ID, 'full_time', true);
                        $part_time = get_post_meta($post->ID, 'part_time', true);
                        $remote = get_post_meta($post->ID, 'remote', true);
                        
                         $job_type = get_post_meta($get_id, 'jobcircle_field_job_type', true);
                    	 $job_salary = jobcircle_job_salary_str($get_id , '' ,'sub');
                    	 $job_img_url = jobcircle_job_thumbnail_url($get_id);
                    	 $job_location = jobcircle_post_location_str($get_id);
                    	 $categories = get_the_terms( $get_id, 'job_category' );
                    	 $skills = wp_get_post_terms( $get_id, 'job_skill' );
                    	 $job_type_str = jobcircle_job_type_ret_str($job_type);
                    		
                ?>
                      <div class="jobs-card">
							<div class="job-content-left">
							    <?php if(!empty($permalinkget || $image)){
                                        ?>
								<div class="icon-box">
								    
									<img src="<?php echo esc_url_raw($image[0]) ?>" alt="image">
								</div>
								<?php }
                                  if(!empty($permalinkget || $title)){
                                  ?>
								<a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>"> <h3><?php echo jobcircle_esc_the_html($title) ?></h3></a>
								<?php } ?>
                                <?php if(!empty($post_author_name)){
                                    ?>
                                <span class="meta"><a href="<?php echo jobcircle_esc_the_html($post_author_link) ?>"><?php echo esc_html_e('By' , 'jobcircle-frame')?> <?php echo jobcircle_esc_the_html($post_author_name) ?></a></span>
								<?php
                                }
                                if(!empty($job_location)){
                                ?>
                                <strong class="location-txt"><i class="jobcircle-icon-map-pin icon "></i> <?php echo jobcircle_esc_the_html($job_location) ?></strong>
                                <?php } ?>
								<ul class="tags-list">
									<?php 
    						if(!empty($skills)){
    							foreach ($skills as $skill){   ?>
							    	<li><span class="tag">
											<?php echo jobcircle_esc_the_html($skill->name) ?>
										</span></li>
    						<?php 	}
        						}  ?>
								</ul>
							</div>
							<div class="job-content-right">
								<div class="price-box">
								 <?php if(!empty($job_salary)){
                                    ?>
                                    <strong class="price"><?php echo ($job_salary) ?></strong>
                                    <?php
                                }
                                ?>
									<?php if(!empty($experience)){
                                    ?>
                                    <span class="txt"><?php echo esc_html_e('Experience :', 'jobcircle-frame') ?> <?php echo jobcircle_esc_the_html($experience) ?></span>
                                
                                <?php
                                }
                                ?>
                                </div>
								<a href="javascript:;" class="jobcircle-det-applybtn jobdet-applybtn-act btn btn-purple" data-id="<?php echo jobcircle_esc_the_html($job_id) ?>"
                                data-bs-toggle="modal" data-bs-target="#jobcircle-apply-job-popup">
                                <span><?php echo esc_html_e('Apply Now', 'jobcircle-frame') ?> </span></a>
							</div>
						</div>
                    <?php
                    }
                    if ($total_posts > $numofpost && $pagination != 'no') {
                        ?>
                        <div class="pagination-container">
                            <?php echo jobcircle_pagination($query, true); ?>
                        </div>
                        <?php
                    }
                    wp_reset_postdata();
                    ?>
            </div>
            <div class="row">
                <div class="col-12 d-flex justify-content-center pt-lg-20">
                <?php if(!empty($btn_url) || !empty($btn)){
                                    ?>
                    <a href="<?php echo jobcircle_esc_the_html($btn_url); ?>"><button class="btn btn-purple"><span><?php echo jobcircle_esc_the_html($btn); ?></span></button></a>
                    <?php
                                }
                                ?>
                </div>
            </div>
        </div>
    </section>
    <?php
                }
                return ob_get_clean();
 
            }
            add_shortcode('browse_our_job', 'jobcircle_browse_our_job_front');

            add_action('wp_ajax_browsejob_ajax_action_filter_jobcircle', 'browsejob_ajax_action_filter_jobcircle');
            add_action('wp_ajax_nopriv_browsejob_ajax_action_filter_jobcircle', 'browsejob_ajax_action_filter_jobcircle');

            function browsejob_ajax_action_filter_jobcircle()
            {
                // Retrieve the meta query from the AJAX request
                $fval = isset($_POST['fval']) ? $_POST['fval'] : "";
                 global $numofpost;
                global $orderby;
                
             ob_start();
                if ($fval === 'all') {
         $args = array(
                    'post_type' => 'jobs',
                    'post_status' => 'publish',
                    'posts_per_page' => $numofpost,
                    'order' => 'DESC',
                    'orderby' =>  $orderby,
                    
                );
    }else{
                $args = array(
                    'post_type' => 'jobs',
                    'meta_query' => array(
                        array(
                            'key' => 'jobcircle_field_job_type',
                            'value' => esc_html($fval),
                        )
                    ),
                );
    }

                $query = new WP_Query($args);

                // Process and prepare your response data here
                $response_data = array();

                $query = new WP_Query($args);
                $total_posts = $query->found_posts;

                // Check that we have query results.
                if ($query->have_posts()) {

                    // Start looping over the query results.
                    while ($query->have_posts()) {
                        $query->the_post();

                        global $jobcircle_framework_options, $post;

                        $get_id =  get_the_id();
                        // var_dump($get_id);
                        // continue;
                        $permalinkget = get_permalink($get_id);
                        $image = wp_get_attachment_image_src(get_post_thumbnail_id($get_id), 'single-post-thumbnail');
                        $title = get_the_title($get_id);
                        // $skill = get_post_meta($get_id, 'jobcircle_field_apply_skill', true);
                        $view_profile = get_post_meta($get_id, 'jobcircle_field_apply_view_profile', true);
                        $companies_name = get_post_meta($post->ID, 'jobcircle_field_company_name' , true);

                        $place = get_post_meta($post->ID, 'jobcircle_field_place', true);

                        $experience = get_post_meta($post->ID, 'jobcircle_field_experience', true);
                        
                        
                        
                         $job_type = get_post_meta($get_id, 'jobcircle_field_job_type', true);
                    	 $job_salary = jobcircle_job_salary_str($get_id , '' , 'sub');
                    	 $job_img_url = jobcircle_job_thumbnail_url($get_id);
                    	 $job_location = jobcircle_post_location_str($get_id);
                    	 $categories = get_the_terms( $get_id, 'job_category' );
                    	 $skills = wp_get_post_terms( $get_id, 'job_skill' );
                    	 $job_type_str = jobcircle_job_type_ret_str($job_type);

    ?>

        <div class="jobs-card ">
            <div class="job-content-left">
                <div class="icon-box">
                    <?php if(!empty($permalinkget) || !empty($image)) { ?>
                <a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>">  <img src="<?php echo esc_url_raw($image[0]) ?>" alt="image"></a>
                <?php } ?>
                </div>
                <?php if(!empty($permalinkget) || !empty($title)){ ?>
                <a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>">  <h3><?php echo jobcircle_esc_the_html($title) ?></h3></a>
                <?php } ?>
                <?php if(!empty($companies_name)){ ?>
                <span class="meta"><a href="#"><?php echo jobcircle_esc_the_html($companies_name) ?></a></span>
                <?php } ?>
                <?php if(!empty($job_location)) { ?>
                <strong class="location-txt"><i class="jobcircle-icon-map-pin"></i> <?php echo  esc_html($job_location) ?></strong>
                <?php } ?>
                <ul class="tags-list">
                    <?php 
                    if(!empty($job_type_str)){
                        ?>
                    <li><span class="tag"><?php echo jobcircle_esc_the_html($job_type_str['title'])?></span></li>
                    <?php 
                    }
                    ?>
                </ul>
            </div>
            <div class="job-content-right">
                <div class="price-box">
                    <?php 
                    if(!empty($job_salary)){
                    ?>
                    <strong class="price"><?php echo ($job_salary) ?></strong>
                    <?php
                    }
                     if(!empty($experience)){?>
                    <span class="txt"><?php echo esc_html_e('Experience :','jobcircle-frame') ?> <?php echo jobcircle_esc_the_html($experience) ?></span>
                    <?php 
                     }?>
                </div>
               <a href="javascript:;" class="jobcircle-det-applybtn jobdet-applybtn-act btn btn-purple" data-id="<?php echo jobcircle_esc_the_html($job_id) ?>"
                    data-bs-toggle="modal" data-bs-target="#jobcircle-apply-job-popup">
                    <span> <?php echo esc_html_e(' Apply Now','jobcircle-frame') ?> </span></a>
            </div>
        </div>

<?php
                    }
                } else {
                    echo "No Job Found";
                }

                wp_reset_postdata();
                $html = ob_get_clean();
                wp_send_json(
                    array(
                        'html' =>  $html
                    )
                ); // Send JSON response
                wp_die();
            }
