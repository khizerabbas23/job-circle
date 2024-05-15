<?php
function jobcircle_feature_jobs()
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
function featured_job_four()
{
    $job_types = jobcircle_feature_jobs();
    
    $all_page = array( __('Select Page', 'jobcircle-frame'), '');
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
            'name' => __('Feature Job 7'),
            'base' => 'featured_job_four',
            'category' => __('job Circle'),
            'params' => array(
             array(
                'type' => 'dropdown',
                'holder' => 'div',
                'class' => '',
                'heading' => __('Jobcircle Page', 'jobcircle-frame'),
                'param_name' => 'jobcircle_page',
                'description' => __('Select Jobcircle Page', 'jobcircle-frame'),
                'value' =>  $all_page,
              ),
            array(
                'type' => 'textfield',
                'holder' => 'div',
                'class' => '',
                'heading' => __('Title'),
                'param_name' => 'title',
            ),
            array(
                'type' => 'checkbox',
                'holder' => 'div',
                'class' => '',
                'heading' => __('Checkbox Options'),
                'param_name' => 'checkbox_param',
                'value' => $job_types,
            ),
            array(
                'type' => 'textfield',
                'holder' => 'div',
                'class' => '',
                'heading' => __('Heading'),
                'param_name' => 'heading',
            ),

            array(
                'type' => 'textfield',
                'holder' => 'div',
                'class' => '',
                'heading' => __('Order By'),
                'param_name' => 'orderby',
            ),
            array(
                'type' => 'textarea',
                'holder' => 'div',
                'class' => '',
                'heading' => __('Post Per Category'),
                'param_name' => 'numofpost',
            ),
        )
    )
);
}
add_action('vc_before_init', 'featured_job_four');
// popular category frontend
function featured_job_four_frontend($atts, $content)
{
    $atts = shortcode_atts(
        array(

            'title' => '',
            'heading' => '',
            'checkbox_param' => '',
            'orderby' => '',
            'numofpost' => '',
        	'jobcircle_page' => '', 
        	
        ), $atts, 'featured_job_four');

    $title = isset($atts['title']) ? $atts['title'] : '';
    $heading = isset($atts['heading']) ? $atts['heading'] : '';
    $checkbox_param = isset($atts['checkbox_param']) ? $atts['checkbox_param'] : '';
    $job_type_arr = !empty($checkbox_param) ? explode(',', $checkbox_param) : '';
    
    $jobcircle_page = isset($atts['jobcircle_page']) ? $atts['jobcircle_page'] : '';
    
    $output = '';
    ob_start();
    ?>
    <section class="featured_Jobs_Block section-theme-7 theme_sevenb">
        <div class="container">
            <div class="jobs_info_wrap">
                <!-- Section header -->
                <header class="section-header d-flex flex-column text-center mb-15 mb-md-30 mb-xl-25">
                    <?php
                    if (!empty($title)) {
                        ?>
                        <p>
                            <?php echo esc_html($title) ?>
                        </p>
                        <?php
                    }
                    if (!empty($heading)) {
                        ?>
                        <h2>
                            <?php echo esc_html($heading) ?>
                        </h2>
                    <?php
                    }
                    ?>
                    <ul class="nav nav-tabs">
                        <li><button class="nav-link  nav-for-all-cat active" type="button" data-bs-toggle="tab"
                                aria-selected="true">
                                <?php echo esc_html('All', 'jobcircle-frame') ?>
                            </button></li>
                        <?php
                        if (!empty($job_type_arr)) {
                            foreach ($job_type_arr as $job_type_arrays) {
                                $cat = get_term_by('slug', $job_type_arrays, 'job_category');
                                $job_arrays = $cat->name;
                                echo '<li><button class="nav-link  nav-for-filter-job" data-id="' . $cat->term_id . '" type="button" data-bs-toggle="tab" aria-selected="true" >' . $job_arrays . '</button></li>';
                            }
                        }
                        ?>
                    </ul>
                </header>
                <div class="tab-content feature-job-container">
                    <div class="row">
                        <?php
                        $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
                        $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
foreach ($job_type_arr as $job_type_arrays) {
                        $args = array(
                            'post_type' => 'jobs',
                            'post_status' => 'publish',
                            'posts_per_page' => $numofpost,
                            'order' => 'DESC',
                            'orderby' => $orderby,
                            'tax_query'=>array(
                                array(
                                    'taxonomy' => 'job_category',
                                    'field' => 'slug',
                                    'terms' => $job_type_arrays,
                                ),
                            )
                        );
                        // Custom query.
                        $query = new WP_Query($args);
                        // Check that we have query results.
                        if ($query->have_posts()) {
                            // Start looping over the query results.
                            while ($query->have_posts()) {
                                $query->the_post();
                                global $post;
                                $post = get_the_id();
                                $title = get_the_title($post);
                                $permalinkget = get_the_permalink($post);
                            
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
                              
                           
                              
                                $post_terms = wp_get_post_terms($post, 'job_category', array('fields' => 'ids'));
                               $id_post = isset($post_terms[0]) ? implode(' cat-', $post_terms) : '';
                                $job_type = get_post_meta($post, 'jobcircle_field_job_type', true);
                                $job_salary = jobcircle_job_salary_str($post, '', 'sub');
                                $job_img_url = jobcircle_job_thumbnail_url($post);
                                $job_location = jobcircle_post_location_str($post);
                                $categories = get_the_terms($post, 'job_category');
                                $skills = wp_get_post_terms($post, 'job_skill');
                                $job_type_str = jobcircle_job_type_ret_str($job_type);
                                ?>
                                <div class="col-12 col-lg-6 mb-15 mb-xl-30 cat-<?php echo jobcircle_esc_the_html($id_post) ?> job-ids-forcat">
                                    <?php
                                    if (!empty($permalinkget)) {
                                        ?>
                                        <div class="jobs_info_holder">
                                            <?php
                                    }
                                    if (!empty($job_type_str)) {
                                        ?>
                                            <span class="note">
                                                <?php echo esc_html($job_type_str['title']) ?>
                                            </span>
                                            <?php
                                    } ?>
                                        <div class="wrap_holder">
                                            <?php
                                            if (!empty($job_img_url)) {
                                                ?>
                                                <div class="icon_holder">
                                                   <a href="<?php echo esc_html($permalinkget) ?>"><img src="<?php echo esc_url_raw($job_img_url) ?>" alt="img"></a>
                                                </div>
                                            <?php } ?>
                                            <div class="info_holder">
                                                <p>
                                                <?php
                                       $categores = get_terms(
                                                      array(
                                                      'taxonomy' => 'job_category',
                                                      'hide_empty' => true,
                                                  )
                                                 );
                                                $counter = 0;
                                                    foreach ($categores as $category) { 
                                                if (!empty($categores) && $counter < 2 ) {
                                                      $jobcircle_page_id = jobcircle_get_page_id_from_name($jobcircle_page);
                                                        $jobcircle_page_url = home_url('/');
                                                        if ($jobcircle_page_id > 0) {
                                                        $jobcircle_page_url = get_permalink($jobcircle_page_id);
                                                        }
                                                        ?>
                                                        
                                                            <a href="<?php echo esc_url($jobcircle_page_url);?>?job_category=<?php echo jobcircle_esc_the_html($category->slug) ?>">
                                                                <?php echo esc_html($category->name); echo ($counter == 0) ? ',' : ''; ?>
                                                            </a>
                                                       
                                                    <?php  }else{ break; }  $counter++;
                                                }?>
                                                 </p>
                                                <?php
                                                if (!empty($title)) {
                                                    ?>
                                                    <strong class="h5">
                                                       <a href="<?php echo esc_html($permalinkget) ?>"><?php echo esc_html($title) ?></a>
                                                    </strong>
                                                <?php
                                                } ?>
                                                <ul class="location_info">
                                                    <li>
                                                        <?php if(!empty($post_author_name)){?>
                                                        <span class="text">
                                                            <?php esc_html_e('By', 'jobcircle-frame'); ?> <a href="<?php echo esc_html($post_author_link)?>"><?php echo esc_html($post_author_name) ?></a>
                                                        </span>
                                                        <?php } ?>
                                                    </li>
                                                    <?php
                                                    if (!empty($job_location)) {
                                                        ?>
                                                        <li>
                                                            <i class="jobcircle-icon-map-pin icon"></i>
                                                            <span class="text">
                                                                <?php echo esc_html($job_location) ?>
                                                            </span>
                                                        </li>
                                                    <?php
                                                    } ?>
                                                </ul>
                                                <?php
                                                if (!empty($job_salary)) {
                                                    ?>
                                                    <span class="amount subclass"><strong>
                                                            <?php echo ($job_salary) ?>
                                                        </strong></span>
                                                    <?php
                                                } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        // Restore original post data
                        wp_reset_postdata();
}
                        ?>
                        <script>
                            jQuery(document).on('click', '.nav-for-all-cat', function () {

                                var this_val = jQuery(this).attr('data-id');
                                var this_parent = jQuery(this).parents('.featured_Jobs_Block');

                                this_parent.find('.job-ids-forcat').show();
                                this_parent.find('.cat-' + this_val).removeAttr('style');
                            });
                            jQuery(document).on('click', '.nav-for-filter-job', function () {

                                var this_val = jQuery(this).attr('data-id');
                                var this_parent = jQuery(this).parents('.featured_Jobs_Block');

                                this_parent.find('.job-ids-forcat').hide();
                                this_parent.find('.cat-' + this_val).removeAttr('style');
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
        <!--</div>-->
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('featured_job_four', 'featured_job_four_frontend');