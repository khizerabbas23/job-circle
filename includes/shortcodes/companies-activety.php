<?php
function get_customs_posts_categoriies()
{
	$categories = get_terms(
		array(
			'taxonomy' => 'employer_cat',
			'hide_empty' => false,
		)
	);

	$category_options = array();

	if ($categories && !is_wp_error($categories)) {
		foreach ($categories as $category) {
			$category_options[wp_specialchars_decode($category->name)] = $category->slug;
		}
	}

	return $category_options;
}


function jobcircle_companies_activety()
{
    vc_map(
        array(
            'name' => __('Companies activety'),
            'base' => 'jc_companies_activety',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Url'),
                    'param_name' => 'viewjob_url',
                ),
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
                    'heading' => __('Number Of Post'),
                    'param_name' => 'numofpost',
                ),
                 array(
					'type' => 'dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Select Category For Post'),
					'param_name' => 'category_selector',
					'value' => array_merge(
						array('Select Category' => ''),
						get_customs_posts_categoriies()
					),
				),
            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_companies_activety');
// popular category frontend
function jobcircle_companies_activety_frontend($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'title' => '',
            'heading' => '',
            'viewjob_url' => '',
            'orderby' => '',
            'numofpost' => '',
            'category_selector' => '',
        ),
        $atts,
        'jobcircle_companies_activety'
    );
    $title  = isset($atts['title']) ? $atts['title'] : '';
    $heading  = isset($atts['heading']) ? $atts['heading'] : '';
    $viewjob_url  = isset($atts['viewjob_url']) ? $atts['viewjob_url'] : '';
    $selectedcategory  = isset($atts['category_selector']) ? $atts['category_selector'] : '';
    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
    $output = '';
    ob_start(); ?>
    <section class="section section-theme-10 companies-hiring-block bg-white pt-30 pt-md-40 pt-lg-80 pt-xxl-90 pb-30 pb-md-50 pb-lg-100 pb-xxl-120">
        <div class="container">
            <div class="row mb-10 mb-lg-30 align-items-md-end">
                <div class="col-12 col-md-8 d-flex flex-column-reverse">
                    <?php
                    if (!empty($title)) {
                    ?>
                        <h2><?php echo esc_html($title) ?></h2>
                    <?php
                    } ?>
                    <?php
                    if (!empty($heading)) {
                    ?>
                        <p><?php echo esc_html($heading) ?></p>
                    <?php
                    } ?>
                </div>
                <div class="col-12 col-md-4 d-flex justify-content-md-end align-items-start">
                    <?php
                    if (!empty($viewjob_url)) {
                    ?>
                        <a href="<?php echo esc_html($viewjob_url) ?>" class="view-all"><?php echo esc_html_e('View all companies', 'jobcircle-frame') ?></a>
                    <?php
                    } ?>
                </div>
            </div>
            <div class="companies-carousel">
                <?php
                $numofpost  = isset($atts['numofpost']) ? $atts['numofpost'] : '';
                $orderby  = isset($atts['orderby']) ? $atts['orderby'] : '';

                $args = array(
                    'post_type' => 'employer', //enter post type name static
                    'post_status' => 'publish',
                    'posts_per_page' => $numofpost,
                    'order' => 'DESC',
                    'orderby' =>  $orderby,
                );
                if($selectedcategory != ''){
                    $tax_query = array(
                            array(
                                'taxonomy' => 'employer_cat', //enter taxonomy name static
                                'field'    => 'slug',
                                'terms'    => $selectedcategory,
                            ),
                        );
                    
                }
                if(!empty($tax_query)){
                    $args['tax_query'] = $tax_query;
                }
                // Custom query.
                $query = new WP_Query($args);
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
                        $job_img_url = jobcircle_job_thumbnail_url($post);
                        $excerpt = get_the_excerpt($post);
                        // $location = jobcircle_post_location_str($post);
                        $country = get_post_meta($post, 'jobcircle_field_loc_country', true);
                        $open_job = get_post_meta($post, 'jobcircle_field_user_open_job', true);
                        $availiablejobs = get_post_meta($post, 'jobcircle_field_available_job_for_users', true);
                        $users = get_post_meta($post, 'team_size', true);
                        $icon_image = get_post_meta($post, 'jobcircle_field_user_icon_image', true);

                ?>
                        <div class="slide">
                            <div class="companies-carousel-box">
                                <a href="<?php echo esc_html($permalinkget) ?>">
                                    <div class="icon-box bordre-radius">
                                        <img class="tick" src="<?php echo Jobcircle_Plugin::root_url() ?>/images/tick-circle.svg" alt="tick">
                                        <img src="<?php echo jobcircle_esc_the_html($image[0]); ?>" alt="icon">
                                    </div>
                                </a>
                                <div class="text-frm">
                                    <?php
                                    if (!empty($title)) {
                                    ?>
                                        <a href="<?php echo esc_html($permalinkget) ?>">
                                            <h3><?php echo esc_html($title) ?></h3>
                                        </a>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    if (!empty($availiablejobs)) {
                                    ?>
                                        <strong class="sub-title"><?php echo esc_html($availiablejobs) ?> </strong>
                                    <?php
                                    } ?>
                                    <?php
                                    if (!empty($excerpt)) {
                                    ?>
                                        <p><?php echo esc_html($excerpt) ?></p>
                                    <?php
                                    } ?>
                                </div>
                                <ul class="list-inline tags-items m-0">
                                    <li>
                                        <?php
                                        if (!empty($country)) {
                                        ?>
                                            <span><i class="jobcircle-icon-map-pin icon"></i><?php echo esc_html($country) ?></span>
                                        <?php
                                        } ?>
                                    </li>
                                    <li>
                                            <span><i class="jobcircle-icon-users icon"></i><?php echo esc_html($users) ?></span>
                                    </li>
                                    <li>
                                        <span class="rating"><i class="jobcircle-icon-star icon"></i><?php echo esc_html_e('5.0', 'jobcircle-frame') ?></span>
                                    </li>

                                </ul>
                            </div>
                        </div>
                <?php
                    }
                }
                wp_reset_postdata(); ?>
            </div>
        </div>
    </section>
<?php return ob_get_clean();
}
add_shortcode('jc_companies_activety', 'jobcircle_companies_activety_frontend');
