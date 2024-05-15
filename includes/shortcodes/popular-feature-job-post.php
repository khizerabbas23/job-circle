<?php
function get_cust_cate_for_post() {
    $categories = get_terms(array(
        'taxonomy' => 'job_category',
        'hide_empty' => false,
    ));

    $category_options = array();

    if ($categories && !is_wp_error($categories)) {
        foreach ($categories as $category) {
            $category_options[wp_specialchars_decode($category->name)] = $category->slug;
        }
    }

    return $category_options;
}
function jobcircle_five_jobs()
{
    $terms = get_terms(
        array(
            'taxonomy' => 'job_category',
            'hide_empty' => true,
        )
    );
    $feature_job_types = array();
    foreach ($terms as $term) {
        $feature_job_types[$term->name] = $term->slug;
    }
    ;
    return $feature_job_types;
}

function jobcircle_job_post()
{
    $job_types = jobcircle_five_jobs();

    $all_page = array(__('Select Page', 'jobcircle-frame'), '');

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
            'name' => __('Job Post'),
            'base' => 'jc_job_post',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                    'type' => 'dropdown',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Job Post style', 'jobcircle-frame'),
                    'param_name' => 'featured_job',
                    'description' => __('Select featured Job Post', 'jobcircle-frame'),
                    'value' => array(
                        'Select Style' => '',
                        'Featured Job Style 1' => 'featured_job_style_one',
                        'Featured Job Style 2' => 'featured_job_style_two',
                        'Featured Job Style 3' => 'featured_job_style_three',
                        'Featured Job Style 4' => 'featured_job_style_four',
                        'Featured Job Style 5' => 'featured_job_style_five',
                        'Featured Job Style 6' => 'featured_job_style_six',
                    ),
                ),
                array(
                    'type' => 'dropdown',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Jobcircle Page', 'jobcircle-frame'),
                    'param_name' => 'jobcircle_page',
                    'description' => __('Select Jobcircle Page', 'jobcircle-frame'),
                    'value' => $all_page,
                    'dependency' => array(
                        'element' => 'featured_job',  //selection param name
                        'value' => array('featured_job_style_five') // depend on selection 
                    ),
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title'),
                    'param_name' => 'titl',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Span Title'),
                    'param_name' => 'spn_title',
                    'dependency' => array(
                        'element' => 'featured_job',  //selection param name
                        'value' => array('featured_job_style_one', 'featured_job_style_three', 'featured_job_style_four') // depend on selection 
                    ),
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Description'),
                    'param_name' => 'desc',
                    'dependency' => array(
                        'element' => 'featured_job',  //selection param name
                        'value' => array('featured_job_style_one', 'featured_job_style_two', 'featured_job_style_three', 'featured_job_style_five', 'featured_job_style_six') // depend on selection 
                    ),
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Job Button'),
                    'param_name' => 'ftrd_job_btn',
                    'dependency' => array(
                        'element' => 'featured_job',  //selection param name
                        'value' => array('featured_job_style_three') // depend on selection 
                    ),
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Job Button Url'),
                    'param_name' => 'ftrd_job_btn_url',
                    'dependency' => array(
                        'element' => 'featured_job',  //selection param name
                        'value' => array('featured_job_style_two', 'featured_job_style_three') // depend on selection 
                    ),
                ),
                array(
                    'type' => 'checkbox',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Checkbox Options'),
                    'param_name' => 'checkbox_param',
                    'value' => $job_types,
                    'dependency' => array(
                        'element' => 'featured_job',  //selection param name
                        'value' => array('featured_job_style_five') // depend on selection 
                    ),
                ),
                array(
					'type' => 'dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Select Category For Post'),
					'param_name' => 'category_selector',
					'value' => array_merge(
						array('Select Category' => ''),
						get_cust_cate_for_post()
					),
					'dependency' => array(
                        'element' => 'featured_job',  //selection param name
                        'value' => array('featured_job_style_two' , 'featured_job_style_four') // depend on selection 
                    ),
				),
               
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Order BY'),
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
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Target Date'),
                    'param_name' => 'tar_date',
                        'dependency' => array(
                        'element' => 'featured_job',  //selection param name
                        'value' => array('featured_job_style_four') // depend on selection 
                    ),
                ),

            )
            
        )

    );
}
add_action('vc_before_init', 'jobcircle_job_post');

// popular category frontend
function jobcircle_job_post_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(

            'titl' => '',
            'spn_title' => '',
            'desc' => '',
            'ftrd_job_btn' => '',
            'ftrd_job_btn_url' => '',

            'featured_job' => '',

            'jobcircle_page' => '',

            'checkbox_param' => '',
            'category_selector' => '',

            'orderby' => '',
            'numofpost' => '',
             'tar_date' => '',


        ), $atts, 'jobcircle_job_post'
    );
    $titl = isset($atts['titl']) ? $atts['titl'] : '';
    $spn_title = isset($atts['spn_title']) ? $atts['spn_title'] : '';
    $desc = isset($atts['desc']) ? $atts['desc'] : '';
    $ftrd_job_btn = isset($atts['ftrd_job_btn']) ? $atts['ftrd_job_btn'] : '';
    $ftrd_job_btn_url = isset($atts['ftrd_job_btn_url']) ? $atts['ftrd_job_btn_url'] : '';
    $tar_date = isset($atts['tar_date']) ? $atts['tar_date'] : '';
    $jobcircle_page = isset($atts['jobcircle_page']) ? $atts['jobcircle_page'] : '';
    $category_selector = isset($atts['category_selector']) ? $atts['category_selector'] : '';

    //For  Home 3
    if ($atts['featured_job'] == 'featured_job_style_three') {
        ob_start();
        ?>
        <main class="main">
                    <section class="section section-theme-2 featured-categories pt-35 pt-md-50 pt-lg-65 pb-35 pb-md-50 pb-lg-100">
                        <div class="container">
                            <header class="section-header text-center mb-30 mb-md-45 mb-xl-60">
          <?php if (!empty($titl) || (!empty($spn_title))) {
              ?>
                    <h2><?php echo esc_html($titl); ?> <span class="text-outlined"> <?php echo esc_html($spn_title); ?></span></h2>
            <?php } ?>

        <?php if (!empty($desc)) {
            ?>
                                    <p><?php echo esc_html($desc); ?></p>
        <?php } ?>
                            </header>
                            <div class="row justify-content-center">
                <?php

                $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
                $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';

                $args = array(
                    'post_type' => 'jobs',
                    'post_status' => 'publish',
                    'posts_per_page' => $numofpost,
                    'order' => 'DESC',
                    'orderby' => $orderby,
                );
                // Custom query.
                $query = new WP_Query($args);

                // Check that we have query results.
                if ($query->have_posts()) {

                    global $jobcircle_framework_options, $post;

                    // Start looping over the query results.
                    while ($query->have_posts()) {

                        $query->the_post();
                        $post = get_post();
                        $postid = $post->ID;
                        $posted = get_the_time('U');
                        $minut = human_time_diff($posted, current_time('U')) . "";
                        $title = get_the_title($postid);
                        $permalinkget = get_the_permalink($postid);
                        $content = get_the_content();
                        //$excerpt = get_the_excerpt($postid);
                        $admin = get_the_author();
                        $image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');

                        $apply = get_post_meta($post->ID, 'jobcircle_field_apply_apply', true);

                        // $media = get_post_meta($post->ID, 'jobcircle_field_media', true);
                        $vacancies = get_post_meta($post->ID, 'jobcircle_field_vacancies', true);
                        $experience = get_post_meta($post->ID, 'jobcircle_field_experience', true);
                        $developer = get_post_meta($post->ID, 'jobcircle_field_developer', true);
                        $time = get_post_meta($post->ID, 'time', true);
                        $job_img_url = jobcircle_job_thumbnail_url($post->ID);
                        $job_salary = jobcircle_job_salary_str($post->ID , '' , 'sub');
                        $job_location = jobcircle_post_location_str($postid);
                        $job_type = get_post_meta($postid, 'jobcircle_field_job_type', true);

                        $job_type_str = jobcircle_job_type_ret_str($job_type);
                        
                          $job_post = get_post($postid);
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
                             $author_id = get_the_author_meta('url');
                             $author_profile_link = get_author_posts_url($author_id);


                        ?>  
                                <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mb-15 mb-md-30">
                                            <!-- Featured Category Box -->
                                            <article class="featured-category-box">
                                                <?php if (!empty($job_type_str)) { ?>
                                                    <span class="tag"><?php echo esc_html($job_type_str['title']) ?></span> 
                                                <?php } ?>
                                                <div class="img-holder">
                                                     <?php if (!empty($permalinkget) && !empty($image)) { ?>
                                                    <a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>"><img src="<?php echo esc_url_raw($image[0]) ?>" alt="Financial Analyst"></a>
                                                <?php } ?>
                                                </div>
                                                <div class="textbox">
                                                    <?php if (!empty($permalinkget) && !empty($title)) { ?>
                                                    <a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>"><strong class="h6"><?php echo esc_html($title); ?></strong></a>
                                                <?php } ?>
                                                 <?php if (!empty($post_author_name)) { ?>
                                                        <span class="subtitle"><?php echo esc_html_e('By' , 'jobcircle-frame')?> <a href="<?php echo esc_html($post_author_link)?>"><?php echo esc_html($post_author_name); ?></a></span>
                                                    <?php } ?>
                                                     <?php if (!empty($job_location)) { ?>
                                                        <address class="location"><i class="jobcircle-icon-map-pin icon"></i><span class="text"><?php echo esc_html($job_location); ?></span></address>
                                                    <?php } ?>
                                                    <div class="job-info">
                                                          <?php if (!empty($minut)) { ?>
                                                            <span class="subtext"><?php echo esc_html($minut); ?>                     <?php esc_html_e('ago', 'jobcircle-frame'); ?></span>
                                                        <?php } ?>
                                                        <?php if (!empty($job_salary)) { ?>
                                                            <span class="amount subclass"><strong><?php echo ($job_salary); ?></strong></span>
                                                            <?php } ?>
                                                    </div>
                                                    <?php if (!empty($permalinkget)) { ?>
                                                        <a href="<?php echo esc_html($permalinkget); ?>" class="btn btn-dark-yellow btn-sm"><span class="btn-text"><span class="text"><?php esc_html_e('Apply Now') ?></span><i class="jobcircle-icon-chevron-right"></i></span></a>
                                                    <?php } ?>
                                                </div>
                                            </article>
                                        </div>

                        
                       <?php
                    }
                }
                // Restore original post data.
                wp_reset_postdata();
                ?>
        

               
        </div>
        <div class="row pt-20">
                                <!-- Featured Category Button Block -->
                                <div class="col-12 text-center btn-block">
          <?php if (!empty($ftrd_job_btn) || !empty($ftrd_job_btn_url)) {
              ?>
                                        <a href="<?php echo esc_html($ftrd_job_btn_url); ?>" class="btn btn-dark-yellow btn-sm"><span class="btn-text"><?php echo esc_html($ftrd_job_btn); ?></span></a>
         <?php } ?>
                                </div>
                            </div>
                        </div>
                    </section>
        
        <?php
    }
    //for Home 1
    elseif ($atts['featured_job'] == 'featured_job_style_one') {
        ob_start();
        ?>

         <section class="section section-categories pt-35 pb-35 pb-md-50 pb-xl-75 pb-xxl-105">
         <div class="container">
             <!-- Section header -->
             <header class="section-header text-center mb-30 mb-md-45 mb-xl-55">
                <?php
                if (!empty($titl) || (!empty($spn_title))) {
                    ?>
                     <h2><?php echo esc_html($titl); ?><span class="text-primary"> <?php echo esc_html($spn_title); ?></span></h2>
                     <?php
                } ?>
                 <div class="seprator"></div>
                 <?php if (!empty($desc)) {
                     ?>
                     <p><?php echo esc_html($desc) ?></p>
                 <?php } ?>
             </header>
             <div class="row">
           
                 <?php
                 $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
                 $categoryslug = isset($atts['categoryslug']) ? $atts['categoryslug'] : '';
                 $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';

                 $args = array(
                     'post_type' => 'jobs',
                     'post_status' => 'publish',
                     'posts_per_page' => $numofpost,
                     'order' => 'DESC',
                     'orderby' => $orderby,
                     //   'tax_query' => array(
                     //     array(
                     //         'taxonomy' => 'job_category',
                     //         'field'    => 'slug',
                     //         'terms'    => 'featured-job',
                     //     ),
                     //     )
         
                 );

                 // Custom query.
                 $query = new WP_Query($args);

                 // Check that we have query results.
                 if ($query->have_posts()) {

                     // Start looping over the query results.
                     while ($query->have_posts()) {

                         global $jobcircle_framework_options, $post;

                         $query->the_post();
                         $post = get_post();
                         $postid = $post->ID;
                         $posted = get_the_time('U');
                         $minut = human_time_diff($posted, current_time('U')) . "";
                         $title = get_the_title($postid);
                         $permalinkget = get_the_permalink($postid);
                         $content = get_the_content();
                         $excerpt = get_the_excerpt($postid);
                         $admin = get_the_author();
                         $image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');

                         $companies_name = get_post_meta($post->ID, 'jobcircle_field_companies_name', true);


                         $place = get_post_meta($post->ID, 'jobcircle_field_place', true);
                         // $media = get_post_meta($post->ID, 'jobcircle_field_media', true);
                         $vacancies = get_post_meta($post->ID, 'jobcircle_field_vacancies', true);
                         $experience = get_post_meta($post->ID, 'jobcircle_field_experience', true);
                         $developer = get_post_meta($post->ID, 'jobcircle_field_developer', true);
                         $full_time = get_post_meta($post->ID, 'jobcircle_field_full_time', true);
                         $selection = get_post_meta($post->ID, 'jobcircle_field_apply_selection', true);
                         $categories = get_the_terms($post, 'job_category');
                         $job_location = jobcircle_post_location_str($post->ID);
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
               
                                <div class="col-12 col-md-6 mb-15 mb-md-30">
                
                                <article class="featured-box">
                                    <a href="" class="pin-job <?php echo esc_html($like_btn_class); ?> " data-id="<?php echo esc_html($postid); ?>"><i class=" <?php echo esc_html($fav_icon_class); ?> position-absolute <?php echo esc_html($follow); ?>"></i></a>	
                                    <div class="icon-box">
                                        <?php if (!empty($permalinkget) && !empty($image)) { ?>
                                        <a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>">
                                            <img src="<?php echo esc_url_raw($image[0]) ?>" width="77" height="85" alt="Metronic Media Solution">
                                        </a>
                                     <?php } ?>
                                    </div>
                                    <div class="textbox">
                                         <?php if (!empty($permalinkget) && !empty($title)) { ?>
                                            <h3 class="h4"><a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>"><?php echo esc_html($title) ?></a></h3>
                                         <?php } ?>
                                          <?php if (!empty($companies_name)) { ?>
                                            <?php
                                            if (!empty($categories)) {
                                                foreach ($categories as $category) { ?>
                                                    <strong class="subtitle">
                                                        <a href="<?php echo esc_url(get_term_link($category)); ?>">
                                                            <span class="txt"><?php echo esc_html($category->name); ?></span>
                                                        </a>
                                                    </strong>
                                                <?php }
                                            }
                                            ?>
                                        <?php } ?>
                                        <ul class="stats-list">
                                            <?php if (!empty($job_location)) { ?>
                                                <li>
                                                    <i class="jobcircle-icon-map-pin icon"></i>
                                                    <span class="text"><?php echo esc_html($job_location) ?></span>
                                                </li>
                                                 <?php
                                            } ?>
                                            <li>
                                                <i class="jobcircle-icon-clock icon"></i>
                                                 <?php if (!empty($minut)) { ?>
                                                    <span class="text"><?php echo esc_html($minut) ?></span>
                                                <?php } ?>
                                            </li>
                                            <li>
                                                <i class="jobcircle-icon-bookmark icon"></i>
                                                <?php if (!empty($vacancies)) {
                                                    ?>
                                                    <span class="text"><?php echo esc_html($vacancies); ?></span>
                                                    <?php
                                                } ?>
                                            </li>
                                        </ul>
                                        <ul class="tags-list">
                                       <?php
                                       $skills = wp_get_post_terms($post->ID, 'job_skill');
                                       if (!empty($skills)) {
                                           foreach ($skills as $skill) { ?>
                                                        <li><span class="tag">
                                                            <?php echo esc_html($skill->name) ?>
                                                        </span></li>
                                                <?php }
                                       } ?>
                                        </ul>
                                    </div>
                                </article>
                            </div>
                
                    <?php
                     }

                 }
                 // Restore original post data.
                 wp_reset_postdata();
                 ?>
         </div>
         </div>
         </section>
         <?php
         add_action('wp_footer', function () {
            ?>
               <script>
    
           jQuery(document).on ('click', '.jobcircle-follower-btn', function() {
    
                   
           var _this = jQuery(this);
           if (_this.hasClass('no-user-follower-btn')){
           jobcircle_submit_msg_alert('<?php esc_html_e('Only logged-in user can save this.', 'jobcircle-frame') ?>', 'jobcircle-alert-warning');
           return false ; 
           }
           if (_this.hasClass('no-member-follower-btn')){
           jobcircle_submit_msg_alert('<?php esc_html_e('Only a candidate member can save this.', 'jobcircle-frame') ?>', 'jobcircle-alert-warning');
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
               action: 'jobcircle_candidate_fav_job_liest_eatieen'
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
           action: 'jobcircle_candidate_remove_jobi_list_eaghteen'
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
    }
    
    // For Home 2
    elseif ($atts['featured_job'] == 'featured_job_style_two') {
        ob_start();
        ?>

        <section class="section section-theme-2 section-popular-jobs pt-35 pt-md-50 pt-lg-65 pb-35px pb-md-50 pb-lg-65">
                        <div class="container">
                            <!-- Section header -->
                            <header class="section-header text-center mb-30 mb-md-45 mb-xl-60">
                                <div class="seprator"></div>
                                <?php
                                if (!empty($titl)) {
                                    ?>
                                    <h2><?php echo esc_html($titl);?></h2>
                                <?php } ?>
                                <?php if (!empty($desc)) {
                                    ?>
                                    <p><?php echo esc_html($desc) ?></p>
                                 <?php } ?>
                            </header>
                            <div class="row">
                     <?php
                     $defaultcate = get_cust_cate_for_post();
                     if (isset($defaultcate['Development'])) {
                         $default = $defaultcate['Development'];
                     }
                     $selectedcategory = isset($atts['category_selector']) && !empty($atts['category_selector']) ? $atts['category_selector'] : $default;
                     
                     $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
                     $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
                     
                     $args = array(
                         'post_type' => 'jobs',
                         'post_status' => 'publish',
                         'posts_per_page' => $numofpost,
                         'orderby' => $orderby,
                         'tax_query' => array(
                                    array(
                                        'taxonomy' => 'job_category',
                                        'field'    => 'slug',
                                        'terms'    => $selectedcategory,
                                    ),
                                ) 
                       
                     );

                     // Custom query.
                     $query = new WP_Query($args);

                     // Check that we have query results.
                     if ($query->have_posts()) {

                         // Start looping over the query results.
                         while ($query->have_posts()) {

                             global $jobcircle_framework_options, $post;

                             $query->the_post();
                             $post = get_post();
                             $postid = $post->ID;
                             $posted = get_the_time('U');
                             $minut = human_time_diff($posted, current_time('U')) . "";
                             $title = get_the_title($postid);
                             $permalinkget = get_the_permalink($postid);
                             $content = get_the_content();
                             $excerpt = get_the_excerpt($postid);
                             $admin = get_the_author();
                             $image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');



                             $company = get_post_meta($post->ID, 'company', true);

                             $job_type = get_post_meta($postid, 'jobcircle_field_job_type', true);
                             $job_salary = jobcircle_job_salary_str($postid , '' ,'sub');
                             $job_img_url = jobcircle_job_thumbnail_url($postid);
                             $job_location = jobcircle_post_location_str($postid);
                             $categories = get_the_terms($postid, 'job_category');
                             $skills = wp_get_post_terms($postid, 'job_skill');
                             $job_type_str = jobcircle_job_type_ret_str($job_type);

                             $job_post = get_post($postid);
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
                             $author_id = get_the_author_meta('url');
                             $author_profile_link = get_author_posts_url($author_id);


                             ?>
               
                               <div class="col-12 col-lg-6 mb-15 mb-md-25 mb-lg-35">
                                            <article class="popular-jobs-box">
                                                <div class="box-holder">
                                                    <div class="job-info">
                                                        <div class="img-holder">
                                                            <?php if (!empty($image)) {
                                                                ?>
                                                                <img src="<?php echo esc_url_raw($image[0]) ?>" alt="Image Description">
                                                            <?php
                                                            } ?>
                                                        </div>
                                                        <div class="textbox">
                                                            <?php if (!empty($permalinkget || $title)) {
                                                                ?>
                                                            <a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>" class="title-color">
                                                           <h3 class="h5"><?php echo esc_html($title) ?></h3>
                                                       <?php } ?>
                                                        </a>
                                                            <ul class="meta-list">
                                                                <?php if (!empty($post_author_name)) {
                                                                    ?>
                                                                    <li><span class="text"><?php esc_html_e('By ', 'jobcircle-frame') ?><a href="<?php echo jobcircle_esc_the_html($post_author_link) ?>" class="title-color"><?php echo esc_html($post_author_name) ?></a></span></li>
                                                                <?php }
                                                                if (!empty($job_location)) {
                                                                    ?>
                                                                    <li><i class="jobcircle-icon-map-pin"></i><span class="text"><?php echo esc_html($job_location) ?></span></li>
                                                                <?php } ?>
                                                            </ul>
                                                            <ul class="tags-list">
                                                           <?php
                                                           if (!empty($skills)) {
                                                               foreach ($skills as $skill) { ?>
                                                                        <li><span class="tag">
                                                                                <?php echo esc_html($skill->name) ?>
                                                                            </span></li>
                                                                <?php }
                                                           } ?>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <footer class="jobs-foot">
                                                        <?php
                                                        if (!empty($job_salary)) {
                                                            ?>
                                                            <strong class="amount subclass"><?php echo ($job_salary) ?></strong>
                                                        <?php } ?>
                                                        <?php
                                                        if (!empty($permalinkget)) {
                                                            ?>
                                                            <a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>" class="btn btn-green btn-sm"><span class="btn-text"><?php esc_html_e('Apply Now', 'jobcircle-frame') ?></span></a>
                                                        <?php } ?>
                                                    </footer>
                                                </div>
                                            </article>
                                        </div>  
                    <?php
                         }

                     }
                     // Restore original post data.
                     wp_reset_postdata();
                     ?>    
                        </div>
                            <div class="row">
                                <div class="col-12 text-center pt-15 pt-md-25">
                                <?php if (!empty($ftrd_job_btn_url)) {
                                    ?>
                                        <a href="<?php echo esc_html($ftrd_job_btn_url); ?>" class="btn btn-green btn-sm"><span class="btn-text"><?php esc_html_e('View All Jobs', 'jobcircle-frame'); ?></span></a>
         <?php } ?>
                                </div>
                            </div>
                        </div>
                    </section>
     <?php
    } elseif ($atts['featured_job'] == 'featured_job_style_four') {
        ob_start();
        ?>
            <?php
            $targetDate = $tar_date;
            $currentDate = date('Y-m-d');
            $remainingDays = intval((strtotime($targetDate) - strtotime($currentDate)) / (60 * 60 * 24));
            ?>

        <section class="section section-theme-8 featured-job-listing pt-45 pt-md-50 pt-lg-80 pt-xl-110 pb-35 pb-md-50 pb-lg-65">
                        <div class="container">
                            <!-- Section header -->
                    
                            <header class="section-header text-center mb-30 mb-md-45 mb-xl-50">
                            <?php if (!empty($spn_title) || !empty($titl)) {
                                ?>
                                    <h2><?php echo esc_html($titl); ?> <span class="text-outlined"> <?php echo esc_html($spn_title); ?></span></h2>
                                    <?php
                            } ?>
                            </header>
                            <div class="jobs-listing-slider">
                 <?php
                 $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
                 $categoryslug = isset($atts['categoryslug']) ? $atts['categoryslug'] : '';
                 $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
                 
                 $selectedcategory = isset($atts['category_selector']) ? $atts['category_selector'] : '';

                 $args = array(
                     'post_type' => 'jobs',
                     'posts_per_page' => $numofpost,
                     'order' => 'DESC',
                     'orderby' => $orderby,
                     'tax_query' => array(
                            array(
                                'taxonomy' => 'job_category',
                                'field'    => 'slug',
                                'terms'    => $selectedcategory,
                            ),
                        ) 

                 );

                 // Custom query.
                 $query = new WP_Query($args);

                 // Check that we have query results.
                 if ($query->have_posts()) {

                     // Start looping over the query results.
                     while ($query->have_posts()) {

                         global $jobcircle_framework_options, $post;

                         $query->the_post();
                         $post = get_post();
                         $postid = $post->ID;
                         $title = get_the_title($postid);
                         $permalinkget = get_the_permalink($postid);


                         $author_id = get_post_field('post_author', $postid);
                         $author_name = get_the_author_meta('display_name', $author_id);
                         $image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');
                        

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

                         $job_type = get_post_meta($postid, 'jobcircle_field_job_type', true);
                         $job_salary = jobcircle_job_salary_str($postid, '', 'sub');
                         $job_img_url = jobcircle_job_thumbnail_url($postid);
                         $job_location = jobcircle_post_location_str($postid);
                         $categories = get_the_terms($postid, 'job_category');
                         $skills = wp_get_post_terms($postid, 'job_skill');
                         $job_type_str = jobcircle_job_type_ret_str($job_type);

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

                         if (in_array($post->ID, $fav_jobs)) {
                             $like_btn_class = 'jobcircle-alrdy-favjab';
                             $fav_icon_class = 'profile-btn';
                             $follow = 'fa fa-heart';
                         }

                         ?>
               
                               <div class="slick-slide">
                                            <!-- Featured Category Box -->
                                            <article class="featured-category-box">
                                                <a href="" class="tag-bookmark ?1? <?php echo esc_html($like_btn_class); ?> " data-id="<?php echo esc_html($post->ID); ?>"><i class=" <?php echo esc_html($fav_icon_class); ?> position-absolute <?php echo esc_html($follow); ?>"></i></a>	
                                                <div class="img-holder">
                                                    <?php if (!empty($permalinkget) && !empty($job_img_url)) { ?>
                                                    <a href="<?php echo esc_html($permalinkget); ?>"><img src="<?php echo esc_url_raw($job_img_url); ?>" alt="Backend Developer"></a>
                                                    <?php } ?>
                                                </div>
                                                <div class="textbox">
                                                     <?php if (!empty($permalinkget) && !empty($title)) { ?>
                                                    <a href="<?php echo esc_html($permalinkget); ?>">
                                                        <strong class="h6"><?php echo esc_html($title); ?></strong>
                                                    </a>
                                                    <?php } ?>
                                                     <?php if (!empty($post_author_name)) { ?>
                                                        <span class="subtitle"><?php esc_html_e('By', 'jobcircle-frame') ?> 
                                                         <a href="<?php echo esc_html($post_author_link); ?>"><?php echo esc_html($post_author_name); ?></a></span>
                                                    <?php }
                                                     if (!empty($job_location)) { ?>
                                                        <address class="location"><i class="jobcircle-icon-map-pin icon"></i><span class="text"><?php echo esc_html($job_location); ?></span></address>
                                                    <?php } ?>
                                                    <div class="job-info">
                                                    <?php if (!empty($job_salary)) {
                                                        ?>
                                                            <span class="amount subclass"><strong><?php echo ($job_salary); ?></strong></span>
                                                            <?php
                                                    } ?>
                                                        <ul class="tags-list">
                                                        <?php if (!empty($job_type_str)) {
                                                            ?>
                                                                <li><span class="tag"><?php echo esc_html($job_type_str['title']); ?></span></li>
                                                                <?php
                                                        } ?>
                                
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="box-footer">
                                                     <?php if (!empty($remainingDays)) {
                                                         ?>
                    <span class="text-note"><strong> <?php echo esc_html($remainingDays) ?></strong> <?php esc_html_e(' Left to Apply', 'jobcircle-frame') ?></span>
                          <?php
                                                     } ?>
                                            <a href="javascript:;" class="jobcircle-aplybtn-con jobcircle-det-applybtn jobdet-applybtn-act btn btn-orange btn-sm" data-id="<?php echo ($postid) ?>"
                data-bs-toggle="modal" data-bs-target="#jobcircle-apply-job-popup">
                                            <span class="btn-text"><?php esc_html_e('Apply Now', 'jobcircle-frame') ?></span></a>
                              
                                                </div>
                                            </article>
                                        </div>
                        <?php
                     }

                 } 
               
                 // Restore original post data.
                 wp_reset_postdata();
                 ?>    
                        </div>
                        </div>
                    </section>
                    <script>
            var daysRemaining = <?php echo jobcircle_esc_the_html($remainingDays); ?>;
    
            function updateCountdown() {
                if (daysRemaining >= 0) {
                    var countdownElements = document.querySelectorAll('.text-note strong');
                    countdownElements.forEach(function(element) {
                        element.textContent = daysRemaining + " Days";
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
       add_action('wp_footer', function () {
        ?>
           <script>

       jQuery(document).on ('click', '.jobcircle-follower-btn', function() {

               
       var _this = jQuery(this);
       if (_this.hasClass('no-user-follower-btn')){
       jobcircle_submit_msg_alert('<?php esc_html_e('Only logged-in user can save this.', 'jobcircle-frame') ?>', 'jobcircle-alert-warning');
       return false ; 
       }
       if (_this.hasClass('no-member-follower-btn')){
       jobcircle_submit_msg_alert('<?php esc_html_e('Only a candidate member can save this.', 'jobcircle-frame') ?>', 'jobcircle-alert-warning');
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
           action: 'jobcircle_candidate_fav_job_liest_eatieen'
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
       action: 'jobcircle_candidate_remove_jobi_list_eaghteen'
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
    } elseif ($atts['featured_job'] == 'featured_job_style_five') {
        ob_start();
        ?>
        <section class="section jobs-block bg-white pt-0 pt-md-20 pt-xl-50 pt-xxl-100 pb-35 pb-md-50 pb-lg-65 pb-xxl-100">
            <div class="container">
                <!-- Section header -->
                <header class="section-header d-flex flex-column mb-30 mb-md-45 mb-xl-60">
                    <div class="row">
                        <div class="col-12 col-md-6 d-flex flex-column">
                            <?php
                            if (!empty($titl)) { ?>
                                <h2 class="order-2 m-0"><?php echo esc_html($titl); ?></h2>
                            <?php }
                            if (!empty($desc)) { ?>
                                <p class="order-1"><?php echo esc_html($desc); ?></p>
                            <?php } ?>
                        </div>
                        <div class="col-4 col-md-6 d-none d-md-flex align-items-end justify-content-end">
                            <button type="button" class="slick-prev slick-arrow">
                                <i class="jobcircle-icon-chevron-left"></i>
                            </button>
                            <button type="button" class="slick-next slick-arrow">
                                <i class="jobcircle-icon-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </header>
                <div class="jobs-content">
                                <div class="row">
                                    <div class="col-12 col-md-3">
                                        <ul class="jobs-list">
                                        <?php
                                        $terms = get_terms(array(
                                            'taxonomy' => 'job_category',
                                            'post_type' => 'jobs',
                                            'hide_empty' => false,
                                            'parent' => 0,
                                        ));

                                        $counter = 0;
                                        foreach ($terms as $term) {
                                            if ($counter < 5) {
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

                                                if ($counter == 2) {
                                                    $class = 'active';
                                                } else {
                                                    $class = '';
                                                }
                                                $jobcircle_page_url = home_url('/');
                                                if ($jobcircle_page_id > 0) {
                                                    $jobcircle_page_url = get_permalink($jobcircle_page_id);
                                                }
                                                if (!empty($jobcircle_page_url || $term)) {
                                                    ?>
                    <li class="<?php echo jobcircle_esc_the_html($class) ?>"><a href="<?php echo esc_url($jobcircle_page_url); ?>?job_category=<?php echo jobcircle_esc_the_html($term->slug) ?>"><?php echo jobcircle_esc_the_html($term->name) ?><span class="count"><?php echo jobcircle_esc_the_html($term->count) ?></span></a></li>
                                                        <?php
                                                }
                                                $counter++;
                                            } else {
                                                break; // Break the loop after 12 categories
                                            }
                                        }
                                        ?>
                                        </ul>
                                    </div>
                        <div class="col-12 col-md-9">
                            <div class="jobs-carousel " id="jobs-carousel">
                                <?php

                                $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
                                $categoryslug = isset($atts['categoryslug']) ? $atts['categoryslug'] : '';
                                $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';

                                $args = array(
                                    'post_type' => 'jobs',
                                    'post_status' => 'publish',
                                    'posts_per_page' => $numofpost,
                                    'order' => 'DESC',
                                    'orderby' => $orderby,
                                );

                                // Custom query.
                                $query = new WP_Query($args);

                                // Check that we have query results.
                                if ($query->have_posts()) {
                                    // Start looping over the query results.
                                    while ($query->have_posts()) {
                                        global $jobcircle_framework_options, $post;
                                        $query->the_post();
                                        $post = get_post();
                                        $postid = $post->ID;
                                        $posted = get_the_time('U');
                                        $minut = human_time_diff($posted, current_time('U')) . "";
                                        $title = get_the_title($postid);
                                        $permalinkget = get_the_permalink($postid);
                                        $content = get_the_content();
                                        $excerpt = get_the_excerpt($postid);
                                        $admin = get_the_author();
                                        $image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');
                                        $full_time = get_post_meta($post->ID, 'jobcircle_field_full_time', true);
                                       
                                        $place = get_post_meta($post->ID, 'jobcircle_field_place', true);
                                        $companies_name = get_post_meta($post->ID, 'jobcircle_field_companies_name', true);

                                        $job_type = get_post_meta($postid, 'jobcircle_field_job_type', true);
                                        $job_salary = jobcircle_job_salary_str($postid,'' , 'sub');
                                        $job_img_url = jobcircle_job_thumbnail_url($postid);
                                        $job_location = jobcircle_post_location_str($postid);
                                        $categories = get_the_terms($postid, 'job_category');
                                        $skills = wp_get_post_terms($postid, 'job_skill');
                                        $job_type_str = jobcircle_job_type_ret_str($job_type);

                                        ?>
                                            <div class="job-card">
                                                <div class="inner-box">
                                                     <?php if (!empty($minut)) {
                                                         ?>
                                                        <span class="date"><?php echo esc_html($minut . '  ago'); ?></span>
                                                          <?php
                                                     } ?>
                                                 <?php if (!empty($permalinkget) && !empty($title)) {
                                                     ?>
                                                        <a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>"> <h3><?php echo jobcircle_esc_the_html($title); ?></h3></a>
                                                           <?php
                                                 } ?>
                                                    <ul class="tags-list">
                                                        <?php
                                                       
                                                        if (!empty($skills)) {
                                                             $counter_jobcate = 0 ;
                                                            foreach ($skills as $skill) {
                                                            if($counter_jobcate <= 1){ ?>
                                                            <li><span class="tag">
                                                                    <?php echo esc_html($skill->name) ?>
                                                                </span></li>
                                                <?php 
                                                $counter_jobcate++;
                                                            }else{
                                                                break;
                                                            }
                                                        }
                                                        } ?>
                                                    </ul>
                                                <?php
                                                if (!empty($job_salary)) {
                                                    ?>
                                                        <strong class="salary-range subclass"><?php echo ($job_salary); ?></strong>
                                                    <?php }
                                                ?>
                                                </div>
                                                <div class="card-footer">
                                                    <a href="javascript:;" class="jobcircle-det-applybtn jobdet-applybtn-act btn btn-primary" data-id="<?php echo ($job_id) ?>"
                                                        data-bs-toggle="modal" data-bs-target="#jobcircle-apply-job-popup">
                                                        <span class="btn-text"><?php echo esc_html_e('Apply Now', 'jobcircle-frame') ?></span>
                                                    </a>
                                                    <div class="bottom-box">
                                                        <?php if (!empty($permalinkget || $job_img_url)) {
                                                            ?>
                                                        <a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>"><img src="<?php echo esc_url_raw($job_img_url); ?>" alt="image"></a>
                                                    <?php } ?>
                                                        <div class="info-row">
                                                            <?php if (!empty($companies_name)) {
                                                                ?>
                                                                <strong><?php echo esc_html($companies_name); ?></strong>
                                                                   <?php
                                                            } ?>
                                                            <?php if (!empty($job_location)) {
                                                                ?>
                                                                <p><?php echo esc_html($job_location); ?></p>
                                                                <?php
                                                            } ?>
                                                </div>
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
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php
    } elseif ($atts['featured_job'] == 'featured_job_style_six') {
        ob_start();
        ?>
                    <section class="section section-theme-3 popular-jobs-block pt-35 pt-md-50 pt-lg-65 pb-35 pb-md-50 pb-lg-100">
                        <div class="container">
                            <!-- Section header -->
                            <header class="section-header text-center mb-30 mb-md-45 mb-xl-60">
                                        <?php
                                        if (!empty($titl)) { ?>
                                    <h2><?php echo esc_html($titl) ?></h2>
                                <?php } ?>
                                <?php
                                if (!empty($desc)) { ?>
                                    <p><?php echo esc_html($desc) ?></p>
                                <?php } ?>
                            </header>
                            <div class="jobs-listing-slider">
                 <?php
                 $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
                 $categoryslug = isset($atts['categoryslug']) ? $atts['categoryslug'] : '';
                 $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';



                 $args = array(
                     'post_type' => 'jobs',
                     'posts_per_page' => $numofpost,
                     'order' => 'DESC',
                     'orderby' => $orderby,
                 );

                 // Custom query.
                 $query = new WP_Query($args);

                 // Check that we have query results.
                 if ($query->have_posts()) {

                     // Start looping over the query results.
                     while ($query->have_posts()) {

                         global $jobcircle_framework_options, $post;

                         $query->the_post();
                         $post = get_post();
                         $postid = $post->ID;
                         $title = get_the_title($postid);
                         $permalinkget = get_the_permalink($postid);

                         $job_post = get_post($postid);
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
                         $author_id = get_the_author_meta('url');
                         $author_profile_link = get_author_posts_url($author_id);

                         $job_type = get_post_meta($postid, 'jobcircle_field_job_type', true);
                         $job_salary = jobcircle_job_salary_str($postid, '', 'sub');
                         $job_img_url = jobcircle_job_thumbnail_url($postid);
                         $job_location = jobcircle_post_location_str($postid);
                         $categories = get_the_terms($postid, 'job_category');
                         $skills = wp_get_post_terms($postid, 'job_skill');
                         $job_type_str = jobcircle_job_type_ret_str($job_type);
                         ?>
                                        <div class="slick-slide">
                                   
                                            <div class="job-card">
                            
                                                <div class="inner-box">
                                                    <span class="job-type">
                                                    <i class="jobcircle-icon-clock kege"></i>
                                                   <?php if (!empty($job_type_str)) {
                                                       ?>
                                                            <?php echo esc_html($job_type_str['title']) ?>
                                                        <?php } ?>
                                                    </span>
                                                    <?php if (!empty($title)) {
                                                        ?>
                                                        
                                                        <h3><a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>"><?php echo esc_html($title) ?></a></h3>
                                                        <?php
                                                    }
                                                    if (!empty($job_salary)) { ?>
                                                    <strong class="salary-range"><?php echo jobcircle_esc_the_html($job_salary) ?></strong>
                                                <?php } ?>
                                                </div>
                                                <div class="card-footer">
                                                <?php
                                                if (!empty($job_img_url)) { ?>
                                                        <div class="img"><a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>"><img src="<?php echo esc_url_raw($job_img_url) ?>" width="68" height="68" alt="image"></a></div>
                                                    <?php } ?>
                                                    <div class="bottom-box">
                                                        <div class="info-row">
                                                        <?php
                                                        if (!empty($post_author_name)) { ?>
                                                                <strong><?php echo esc_html_e('By', 'jobcircle-frame') ?> <a href="<?php echo jobcircle_esc_the_html($post_author_link) ?>"><?php echo esc_html($post_author_name) ?></a></strong>
                                                            <?php } ?>
                                                            <?php
                                                            if (!empty($job_location)) { ?>
                                                                <p><i class="jobcircle-icon-map-pin"></i> <?php echo esc_html($job_location) ?></p>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
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
                        </div>
                    </section>
     <?php
    }

    return ob_get_clean();
}
add_shortcode('jc_job_post', 'jobcircle_job_post_frontend');


// for favourite button
add_action('wp_ajax_jobcircle_candidate_fav_job_liest_eatieen', 'jobcircle_candidate_fav_job_liest_eatieen');
add_action('wp_ajax_nopriv_jobcircle_candidate_fav_job_liest_eatieen', 'jobcircle_candidate_fav_job_liest_eatieen');
function jobcircle_candidate_fav_job_liest_eatieen()
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


add_action('wp_ajax_jobcircle_candidate_remove_jobi_list_eaghteen', 'jobcircle_candidate_remove_jobi_list_eaghteen');
add_action('wp_ajax_nopriv_jobcircle_candidate_remove_jobi_list_eaghteen', 'jobcircle_candidate_remove_jobi_list_eaghteen');
function jobcircle_candidate_remove_jobi_list_eaghteen()
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
}
;
