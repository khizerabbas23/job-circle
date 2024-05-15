<?php
function jobcircle_company_list()
{
       $terms = get_terms(
		array(
			'taxonomy' => 'employer_cat',
			'hide_empty' => false,
		)
	);
	$job_types = array();
	foreach ($terms as $term) {
		$job_types[$term->name] = $term->term_id;
	}
	;
    vc_map(
        array(
            'name' => __('Company List'),
            'base' => 'jc_company_list',
            'category' => __('Job Circle'),
            'params' => array(
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
        		  'heading' => __('Select Category For Post'),
        		  'param_name' => 'dropdown_param',
        		  'value' => $job_types,
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
                    'heading' => __('Alphabet'),
                    'param_name' => 'alphabet',
                ),
            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_company_list');
// popular category frontend
function jobcircle_company_list_frontend($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'orderby' => '',
            'numofpost' => '',
        	'checkbox_param' => '',
        	'dropdown_param' => '',
            'alphabet' => '',  // Added parameter for the selected alphabet
        ),
        $atts,
        'jobcircle_company_list'
    );
    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
    $numofpost  = isset($atts['numofpost']) ? $atts['numofpost'] : '';
    $dropdown_param = isset($atts['dropdown_param']) ? $atts['dropdown_param'] : '';
    $job_type_arr = !empty($dropdown_param) ? explode(',', $dropdown_param) : '';
     $checkbox_param = isset($atts['checkbox_param']) ? $atts['checkbox_param'] : '';
        $job_type_arry = !empty($checkbox_param) ? explode(',', $checkbox_param) : '';
    ob_start();
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
?>
    <header class="page-subheader pt-35 pt-md-50 pt-lg-75 mb-20 mb-md-30 mb-lg-45 mb-xl-60">
        <div class="container">
            <div class="row">
                <?php
                $args = array(
                    'post_type' => 'employer',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'employer_cat',
                            'field' => 'slug',
                            'terms' => 'grid-company',
                        ),
                    ),
                    'posts_per_page' => -1,
                );
                $posts = get_posts($args);
                $post_count = count($posts);
                ?>
                <?php
                // Loop through the items and display based on conditions
                foreach ($ad_type_select_values as $index => $ad_type_select) {
                    $ad_code = isset($ad_code_values[$index]) ? $ad_code_values[$index] : '';
                    $ad_placement = isset($ad_placement_values[$index]) ? $ad_placement_values[$index] : '';
                    $ad_image = isset($ad_image_values[$index]) ? $ad_image_values[$index] : '';
                    $ad_location = isset($ad_location_values[$index]) ? $ad_location_values[$index] : '';
                    // Check if the user has selected "Ad Placement" = 'job' and "AD Location" = 'top_sidebar'
                    if ($ad_placement === 'employer' && $ad_location === 'top_content') {
                        if ($ad_type_select === 'code') {
                            // Display the code
                            echo "$ad_code" . "<br/>";
                        } elseif ($ad_type_select === 'image') {
                            // Display the image (if it exists)
                            if (!empty($ad_image['url'])) {
                                echo "<div class='filters-sidebar-ad-image'><img src='{$ad_image['url']}' alt='Ad Image'></div>";
                            }
                        }
                    }
                }
                $selected_alphabet = isset($atts['alphabet']) ? $atts['alphabet'] : '';
                $alphabet_query = array();
                if (!empty($selected_alphabet)) {
                    $alphabet_query = array(
                        array(
                            'taxonomy' => 'employer_cat',
                            'field' => 'slug',
                            'terms' => $selected_alphabet,
                        ),
                    );
                }
                $args = array(
                    'post_type' => 'employer',
                    'tax_query' => $alphabet_query,  // Add alphabet filter to tax_query
                    'posts_per_page' => -1,
                );
                $posts = get_posts($args);
                $post_count = count($posts);
                ?>
                <div class="col-12 d-lg-flex align-items-center justify-content-between">
                    <h1 class="h5 mb-25 mb-lg-0">Showing 1–<?php echo jobcircle_esc_the_html($numofpost); ?> of <?php echo jobcircle_esc_the_html($post_count); ?>
                        <?php echo esc_html_e(' Candidates', 'jobcircle-frame') ?></h1>
                    <div class="subhead-filters">
                        <div class="form-group d-lg-flex align-items-center">
                            <label class="d-block mb-5 mb-md-0"><?php echo esc_html_e('Sort&nbsp;by:', 'jobcircle-frame') ?></label>
                            <form id="jobForm" method="get">
                                <select class="select2 small" name="sortby" data-placeholder="Sort by" onchange="submitForm()">
                                    <option value="recent"><?php echo esc_html_e('Recent Jobs', 'jobcircle-frame') ?></option>
                                    <option value="asc" <?php echo isset($_GET['sortby']) && $_GET['sortby'] == 'asc' ? 'selected' : ''; ?>>
                                        <?php echo esc_html_e(' Sort by Name', 'jobcircle-frame') ?></option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <section class="section section-categories pt-0 pb-35 pb-xl-0">
        <div class="container">
            <div class="row justify-content-center">
                <?php
                 $include_category_ids = $job_type_arr;
                $numofpost  = isset($atts['numofpost']) ? $atts['numofpost'] : '';
                $orderby  = isset($atts['orderby']) ? $atts['orderby'] : '';
                $page_numbr = get_query_var('paged');
                $order = "DESC";
                $current_date = date('Y-m-d H:i:s');
                
                if (isset($_GET['sortby']) && $_GET['sortby'] == 'asc') {
                    $orderby = 'title';
                    $order = 'ASC';
                }else{
        	        $orderby = array(
        		                    'meta_value' => 'DESC',
                                    'post_date'  => 'DESC',
                               );
        	    }
                
                 $args = array(
                       'post_type' => 'employer',
                       'post_status' => 'publish',
                       'posts_per_page' => $numofpost,
                       'paged' => $page_numbr,
                       'order' => $order,
                       'orderby' =>  $orderby,
                       'tax_query' => array(
                                          array(
                                            'taxonomy' => 'employer_cat',
                                            'field' => 'term_id', // Use term_id instead of slug
                                            'terms' => $include_category_ids,
                                            'include_children' => false, // Set to true if you want to include posts from child categories
                                          ),
                                      ),
                       'meta_query' => array(
                                        'relation' => 'OR',
                                        array(
                                            'key'     => 'employer_promotion_pkg_start_date',
                                            'compare' => '<=',
                                            'value'   => $current_date,
                                            'type'    => 'DATE',
                                        ),
                                        array(
                                            'key'     => 'employer_promotion_pkg_end_date',
                                            'compare' => '>=',
                                            'value'   => $current_date,
                                            'type'    => 'DATE',
                                        ),
        
                                    array(
                                        'relation' => 'AND',
                                        array(
                                            'key'     => 'employer_promotion_pkg_start_date',
                                            'compare' => 'NOT EXISTS',
                                        ),
                                        array(
                                            'key'     => 'employer_promotion_pkg_end_date',
                                            'compare' => 'NOT EXISTS',
                                        ),
                                    ),
                        )
                    );
              
                $query = new WP_Query($args);
                $total_posts = $query->found_posts;
                // Check that we have query results.
                if ($query->have_posts()) {
                    // Start looping over the query results.
                    while ($query->have_posts()) {
                        $query->the_post();
                        global $post;
                        $post =  get_the_id();
                        $title = get_the_title($post);
                        $permalinkget = get_the_permalink($post);
                        $image = wp_get_attachment_image_src(get_post_thumbnail_id($post), 'single-post-thumbnail');
                        $location = get_post_meta($post, 'location', true);
                        $vacancies = get_post_meta($post, 'jobcircle_field_vacancies', true);
                        $job_type = get_post_meta($post, 'jobcircle_field_job_type', true);
                        $job_type_str = jobcircle_job_type_ret_str($job_type);
                        $job_salary = jobcircle_job_salary_str($post);
                        $job_img_url = jobcircle_job_thumbnail_url($post);
                        $job_location = jobcircle_post_location_str($post);
                        $categories = wp_get_post_terms($post, 'employer_cat');
                        $skills = wp_get_post_terms($post, 'job_skill');
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
                        $follow = 'Follow';

                        if (in_array($post, $fav_jobs)) {
                            $like_btn_class = 'jobcircle-alrdy-favjab';
                            $fav_icon_class = 'profile-btn';
                            $follow = 'Unfollow';
                        }
                ?>
                        <div class="col-12 col-md-6 col-lg-4 mb-15 mb-md-30">
                            <!-- Candidate Box -->
                            <article class="candidate-box">
                                <div class="textbox">
                                    <div class="icon-box">
                                        <?php
                                        if (!empty($permalinkget) || !empty($image)) {
                                        ?>
                                            <a href="<?php echo esc_html($permalinkget); ?>">
                                                <img src="<?php echo esc_url_raw($image[0]) ?>" width="68" height="66" alt="Jerry Media">
                                            </a>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <?php
                                    if (!empty($permalinkget) || !empty($title)) {
                                    ?>
                                        <h2 class="h5"><a href="<?php echo esc_html($permalinkget) ?>"><?php echo esc_html($title) ?></a></h2>
                                    <?php
                                    }
                                    if (!empty($job_location)) {
                                    ?>
                                        <strong class="subtitle"><?php echo esc_html($job_location) ?></strong>
                                    <?php
                                    }
                                    ?>
                                    <a href="" class="btn btn-primary btn-sm <?php echo jobcircle_esc_the_html($like_btn_class) ?>" data-id="<?php echo jobcircle_esc_the_html($post) ?>"><span class="btn-text  <?php echo jobcircle_esc_the_html($fav_icon_class) ?>"><?php echo jobcircle_esc_the_html($follow) ?></span></a>
                                    <!-- Star Ratings -->
                                   
                                </div>
                                <ul class="stats-list">
                                    <li>
                                        <?php
                                         $include_category_ids = $job_type_arry;
                                   $terms = get_terms(
                                                array(
                                                    'taxonomy' => 'employer_cat',
                                                    'post_type' => 'employer',
                                                    'hide_empty' => false,
                                                    'parent' => 0,
                                                    'include' => $include_category_ids,
                                                )
                                            );
                                    
                                              foreach ($terms as $term){?>
                                                <span class="text">
                                                     <?php echo esc_html($term->name); ?>
                                                </span>
                                        <?php     }?>
                                    
                                    </li>
                                    <li>
                                        <?php
                                        if (!empty($vacancies)) {
                                        ?>
                                            <span class="text compnay_listf"><?php echo esc_html($vacancies) ?></span>
                                        <?php
                                        }
                                        ?>
                                    </li>
                                </ul>
                            </article>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    </section>
    <?php
    if ($total_posts > $numofpost) {
    ?>
        <?php echo jobcircle_pagination($query, true);
        ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var alphabetLinks = document.querySelectorAll('.sorting-list a[data-alphabet]');
                var candidateBoxes = document.querySelectorAll('.candidate-box');
                alphabetLinks.forEach(function(link) {
                    link.addEventListener('click', function(event) {
                        event.preventDefault();
                        // Get the selected alphabet
                        var selectedAlphabet = this.getAttribute('data-alphabet');
                        // Loop through candidate boxes
                        candidateBoxes.forEach(function(box) {
                            // Get the first letter of the candidate's name
                            var firstLetter = box.querySelector('.textbox h2 a').innerText.trim().charAt(0).toLowerCase();
                            // Show/hide based on the selected alphabet
                            if (selectedAlphabet === 'all' || firstLetter === selectedAlphabet) {
                                box.style.display = 'block';
                            } else {
                                box.style.display = 'none';
                            }
                        });
                    });
                });
            });
        </script>
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
                            action: 'jobcircle_candidate_fav_comapny _listasdf'
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
                            action: 'jobcircle_candidate_remove_company_list_lin'
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
        ?>
<?php
    }
    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode('jc_company_list', 'jobcircle_company_list_frontend');
add_action('wp_ajax_jobcircle_candidate_fav_comapny _listasdf', 'jobcircle_candidate_fav_comapny _listasdf');
add_action('wp_ajax_nopriv_jobcircle_candidate_fav_comapny _listasdf', 'jobcircle_candidate_fav_comapny _listasdf');
function jobcircle_candidate_fav_comapny_listasdf()
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
add_action('wp_ajax_jobcircle_candidate_remove_company_list_lin', 'jobcircle_candidate_remove_company_list_lin');
add_action('wp_ajax_nopriv_jobcircle_candidate_remove_company_list_lin', 'jobcircle_candidate_remove_company_list_lin');
function jobcircle_candidate_remove_company_list_lin()
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
