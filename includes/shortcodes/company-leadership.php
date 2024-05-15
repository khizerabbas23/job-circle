<?php
function company_leadership()
{
     $terms = get_terms(
		array(
			'taxonomy' => 'employer_cat',
			'hide_empty' => true,
		)
	);
	$job_types = array();
	foreach ($terms as $term) {
		$job_types[$term->name] = $term->term_id;
	}
	;
    vc_map(
        array(
            'name' => __('Company Leadership'),
            'base' => 'company_leadership',
            'category' => __('Job Circle'),
            'params' => array(
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
                    'heading' => __('Description'),
                    'param_name' => 'description',
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
        		  'heading' => __('Checkbox Options'),
        		  'param_name' => 'checkbox_param',
        		  'value' => $job_types,
        		),
            )
        )
    );
}
add_action('vc_before_init', 'company_leadership');
// popular category frontend
function company_leadership_frontend($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'orderby' => '',
            'numofpost' => '',
            'heading' => '',
            'description' => '',
            'checkbox_param' => '',
        ),
        $atts,
        'company_leadership'
    );
    $heading = isset($atts['heading']) && !empty($atts['heading']) ? $atts['heading'] : '';
    $description = isset($atts['description']) && !empty($atts['description']) ? $atts['description'] : '';
    $orderby = isset($atts['orderby']) && !empty($atts['orderby']) ? $atts['orderby'] : '';
    $numofpost = isset($atts['numofpost']) && !empty($atts['numofpost']) ? $atts['numofpost'] : '';
    $checkbox_param = isset($atts['checkbox_param']) ? $atts['checkbox_param'] : '';
    $job_type_arr = !empty($checkbox_param) ? explode(',', $checkbox_param) : '';
    $output = '';
    ob_start();
?>
    <section class="section section-theme-1 section-leadership bg-light-sky pt-45 pt-md-50 pt-lg-65 pt-xl-85 pt-xxl-110 pb-30 pb-md-50 pb-xl-60" style="background-image: url('<?php echo Jobcircle_Plugin::root_url()?>/images/bg-leaders.jpg');">
        <div class="container">
            <!-- Section header -->
            <header class="section-header text-center mb-30 mb-md-45 mb-xl-60">
                <?php if (!empty($heading)) { ?>
                    <h2><?php echo esc_html($heading) ?></h2>
                <?php } ?>
                <?php if (!empty($description)) { ?>
                    <p><?php echo esc_html($description) ?></p>
                <?php } ?>
            </header>
            <div class="row">
                <?php
                 $include_category_ids = $job_type_arr;
                $numofpost  = isset($atts['numofpost']) ? $atts['numofpost'] : '';
                $orderby  = isset($atts['orderby']) ? $atts['orderby'] : '';
                $page_numbr = get_query_var('paged');
                
               $args = array(
                    'post_type' => 'employer',
                    'post_status' => 'publish', 
                    'paged' => $page_numbr,
                    'posts_per_page' => $numofpost,
                    'order' => 'DESC',
                    'orderby' =>  $orderby,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'employer_cat',
                                'field' => 'term_id', // Use term_id instead of slug
                                'terms' => $include_category_ids,
                                'include_children' => false, // Set to true if you want to include posts from child categories
                            ),
                        ),
                    );
               
                $query = new WP_Query($args);
                $total_posts = $query->found_posts;

                // Check that we have query results.
                if ($query->have_posts()) {

                    // Start looping over the query results.
                    while ($query->have_posts()) {
                        $query->the_post();
                        $post_id =  get_the_id();
                        $post_author = get_post_field('post_author', $post_id);;
                        $title = get_the_title($post_id);
                        $permalinkget = get_the_permalink($post_id);
                        $image = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'single-post-thumbnail');
                        $phone_number = get_post_meta($post_id, 'jobcircle_field_user_phone', true);
                        $facebook_url = get_post_meta($post_id, 'jobcircle_field_facebook_url', true);
                        $twitter_url = get_post_meta($post_id, 'jobcircle_field_twitter_url', true);
                        $linkedin_url = get_post_meta($post_id, 'jobcircle_field_linkedin_url', true);
                        $Designation = get_post_meta($post_id, 'jobcircle_field_Designation', true);
                        $argss = array(
                            'author' => $post_author,
                            'post_type' => 'employer',
                            'post_status' => 'publish',
                            'posts_per_page' => -1
                        );
                        $author_query = new WP_Query($argss);
                        $author_post_count = $author_query->post_count;
                ?>
                        <div class="col-12 col-md-6 mb-15 mb-md-30 mb-xl-80">
                            <div class="leadership-box">
                                <div class="image-holder">
                                    <?php if (!empty($image) || !empty($permalinkget)) { ?>
                                        <a href="<?php echo esc_html($permalinkget)?>">
                                        <img src="<?php echo esc_html($image[0]) ?>" width="260" height="340" alt="Julian Wan">
                                        </a>
                                    <?php } ?>
                                </div>
                                <div class="textbox">
                                    <?php if (!empty($title) || !empty($permalinkget)) { ?>
                                        <a href="<?php echo esc_html($permalinkget)?>">
                                        <h3 class="h4"><?php echo esc_html($title) ?></h3>
                                        </a>
                                    <?php } ?>
                                    <?php if (!empty($Designation)) { ?>
                                        <span class="subtitle"><?php echo esc_html($Designation) ?></span>
                                    <?php } ?>
                                    <?php if (!empty($phone_number)) { ?>
                                        <span class="number"><i class="jobcircle-icon-phone"></i> <a href="tel:<?php echo esc_html($phone_number) ?>"><?php echo esc_html($phone_number) ?></a></span>
                                    <?php } ?>
                                    <ul class="social-networks d-flex flex-wrap">
                                        <?php if (!empty($facebook_url)) { ?>
                                            <li><a href="<?php echo esc_html($facebook_url) ?>"><i class="jobcircle-icon-facebook"></i></a></li>
                                        <?php }
                                        if (!empty($linkedin_url)) { ?>
                                            <li><a href="<?php echo esc_html($linkedin_url) ?>"><i class="jobcircle-icon-linkedin"></i></a></li>
                                        <?php }
                                        if (!empty($twitter_url)) { ?>
                                            <li><a href="<?php echo esc_html($twitter_url) ?>"><i class="jobcircle-icon-twitter"></i></a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    </section>
<?php
    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode('company_leadership', 'company_leadership_frontend');
