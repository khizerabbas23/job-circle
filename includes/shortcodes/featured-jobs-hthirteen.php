<?php
function jobcircle_featured_job_hthirteen()
{
         $terms = get_terms(
		array(
			'taxonomy' => 'job_category',
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
            'name' => __('Featured Jobs HThirteen'),
            'base' => 'jobcircle_featured_job_hthirteen',
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
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Tag Line'),
                    'param_name' => 'tg_line',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Background Image'),
                    'param_name' => 'bg_img',
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
                    'heading' => __('Last Date'),
                    'param_name' => 'last_date',
                ),
                array(
        		  'type' => 'dropdown',
        		  'holder' => 'div',
        		  'class' => '',
        		  'heading' => __('Select Category For Post'),
        		  'param_name' => 'dropdown_param',
        		  'value' => $job_types,
        		),
            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_featured_job_hthirteen');

// popular category frontend
function jobcircle_featured_job_hthirteen_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(

            'title' => '',
            'tg_line' => '',
            'bg_img' => '',
            'orderby' => '',
            'numofpost' => '',
            'last_date' => '',
            'dropdown_param' => '',
        ),
        $atts,
        'jobcircle_featured_job_hthirteen'
    );

    $title = isset($atts['title']) ? $atts['title'] : '';
    $tg_line = isset($atts['tg_line']) ? $atts['tg_line'] : '';
    $bg_img = isset($atts['bg_img']) ? $atts['bg_img'] : '';
    $last_date = isset($atts['last_date']) ? $atts['last_date'] : '';
    $dropdown_param = isset($atts['dropdown_param']) ? $atts['dropdown_param'] : '';
    $job_type_arr = !empty($dropdown_param) ? explode(',', $dropdown_param) : '';
    ob_start();
    ?>
    <?php
    $targetDate = $last_date;
    $currentDate = date('Y-m-d');
    $remainingDays = intval((strtotime($targetDate) - strtotime($currentDate)) / (60 * 60 * 24));
    if ($remainingDays < 0) {
        $output = "Time limit is over";
    }
    ?>
    <?php if (!empty($bg_img)) { ?>
        <section class="section section-theme-13 featured-jobs-block pt-30 pt-lg-40 pt-xl-60 pt-xxl-100 pb-35 pb-md-50 pb-lg-100 pb-xxl-120"
            style="background-image: url('<?php echo esc_url_raw($bg_img); ?>');">
        <?php } ?>
        <div class="container">
            <!-- Section header -->
            <header class="section-header d-flex flex-column-reverse text-center">
                <?php
                if (!empty($title)) { ?>
                    <h2>
                        <?php echo esc_html($title); ?>
                    </h2>
                    <?php
                }
                if (!empty($tg_line)) { ?>
                    <p>
                        <?php echo esc_html($tg_line); ?>
                    </p>
                    <?php
                } ?>
            </header>
            <div class="featured-jobs-carousel">
                <?php
                $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
                $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
                $page_numbr = get_query_var('paged');
                $include_category_ids = $job_type_arr;
                $args = array(
                    'post_type' => 'jobs',
                    'post_status' => 'publish',
                    'posts_per_page' => $numofpost,
                    'order' => 'DESC',
                    'paged' => $page_numbr,
                    'orderby' => $orderby,
                     'tax_query' => array(
                  array(
                      'taxonomy' => 'job_category',
                      'field' => 'term_id', // Use term_id instead of slug
                      'terms' => $include_category_ids,
                      'include_children' => false, // Set to true if you want to include posts from child categories
              ),
           ),
                );
                // Custom query.
                $query = new WP_Query($args);
                $total_posts = $query->found_posts;
                // Check that we have query results.
                if ($query->have_posts()) {
                    // Start looping over the query results.
                    while ($query->have_posts()) {
                        $query->the_post();
                        $post = get_post();
                        $postid = $post->ID;
                        $title = get_the_title($postid);
                        $permalinkget = get_the_permalink($postid);
                        $image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');
                        $job_salary = jobcircle_job_salary_str($postid, '', 'sub');
                        $country = get_post_meta($postid, 'jobcircle_field_loc_country', true);
                        $salary_unit = get_post_meta($post->ID, 'salary_unit', true);
                        $post_date = get_post_field('post_date', $postid);
                        $minut = date("M j, Y", strtotime($post_date));
                        $skills = wp_get_post_terms($postid, 'job_skill');
                        $job_type = get_post_meta($postid, 'jobcircle_field_job_type', true);
                    	$job_location = get_post_meta($postid, 'jobcircle_field_loc_country', true);
                	    $job_img_url = jobcircle_job_thumbnail_url($postid);
                        $job_type_str = jobcircle_job_type_ret_str($job_type);
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
                        ?>
                        <div class="slick-box">
                            <div class="slide">
                                <a href="<?php echo ($permalinkget) ?>">
                                    <?php
                                    if (!empty($job_img_url)) {
                                        ?>
                                        <div class="icon"><img src="<?php echo esc_url_raw($job_img_url); ?>" alt="icon"></div>
                                        <?php
                                    } ?>
                                </a>
                                <?php
                                if (!empty($post_author_link) && !empty($post_author_name)) {
                                    ?>
                                    <strong class="posted-by">
                                        <?php esc_html_e('By', 'jobcircle-frame'); ?> <a
                                            href="<?php echo esc_html($post_author_link) ?>">
                                            <?php echo esc_html($post_author_name); ?>
                                        </a>
                                    </strong>
                                    <?php
                                } ?>
                                <a href="<?php echo esc_html($permalinkget) ?>">
                                    <?php
                                    if (!empty($title)) {
                                        ?>
                                        <h3>
                                            <?php echo esc_html($title); ?>
                                        </h3>
                                        <?php
                                    } ?>
                                </a>
                                <ul class="list-inline tags-items">
                                    <?php
                                    if (!empty($job_location)) {
                                        ?>
                                        <li>
                                            <i class="jobcircle-icon-map-pin">
                                                <?php echo esc_html($job_location); ?>
                                            </i>
                                        </li>
                                        <?php
                                    } ?>
                                    <?php
                                    if (!empty($minut)) {
                                        ?>
                                        <li>
                                            <time class="date" datetime="2021-06-20">
                                                <span class="jobcircle far fa-clock"> </span>
                                                <?php echo esc_html($minut); ?>
                                            </time>
                                        </li>
                                        <?php
                                    } ?>
                                </ul>
                                <?php
                                if (!empty($salary_unit) || !empty($job_salary)) { ?>
                                    <strong class="price">
                                        <?php echo ($job_salary); ?><sub></sub>
                                    </strong>
                                    <?php
                                } ?>
                                <ul class="tags-list">
                                <?php                               
								if (!empty($skills)) {
                                    $counter = 0;
									foreach ($skills as $skill) {  
                                        if($counter <= 1){ ?>
									<li><span class="tag"><?php echo esc_html($skill->name) ?></span></li>
							    <?php }else{
                                    break;
                                } 
                                $counter++;                               
                            }
						    	}  ?>                                    
                                </ul>
                                <span class="left-time">
                                    <?php
                                    if (!empty($output)) {
                                        esc_html_e('Time limit is over', 'jobcircle-frame');
                                    } else {
                                        echo esc_html($remainingDays); ?>
                                        <?php esc_html_e('days left to apply', 'jobcircle-frame');
                                    } ?>
                                </span>
                               <a href="<?php echo ($permalinkget)?>" class="btn btn-apply"><span>
                                        <?php esc_html_e('Apply Now', 'jobcircle-frame') ?>
                                    </span></a>
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
    </section>
    <script>
        var daysRemaining = <?php echo jobcircle_esc_the_html($remainingDays); ?>;
        function updateCountdown() {
            if (daysRemaining >= 0) {
                var countdownElements = document.querySelectorAll('.text-note strong');
                countdownElements.forEach(function (element) {
                    element.textContent = daysRemaining + " Days To left";
                });
                daysRemaining--;
            } else {
                var countdownElements = document.querySelectorAll('.text-note strong');
                countdownElements.forEach(function (element) {
                    element.textContent = "Application period has ended";
                });
            }
        }
        updateCountdown();
        setInterval(updateCountdown, 24 * 60 * 60 * 1000);
    </script>
    <?php
    return ob_get_clean();

}
add_shortcode('jobcircle_featured_job_hthirteen', 'jobcircle_featured_job_hthirteen_frontend');