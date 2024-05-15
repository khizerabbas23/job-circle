<?php
function home_banner_thirteen()
{
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
            'name' => __('Home Banner Thirteen'),
            'base' => 'home_banner_thirteen',
            'category' => __('Job Circle'),
            'params' => array(
                array(
					'type' => 'dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Jobcircle Page', 'jobcircle-frame'),
					'param_name' => 'jobcircle_page',
					'description' => __('Select Jobcircle Page', 'jobcircle-frame'),
					'value' => $all_page,
				),

                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Background Image'),
                    'param_name' => 'background_image',
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
                    'heading' => __('Title'),
                    'param_name' => 'spn_title',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Highlight Title'),
                    'param_name' => 'hig_title',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Description'),
                    'param_name' => 'description',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title'),
                    'param_name' => 'min_title',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Avatar Image'),
                    'param_name' => 'avt_img_1',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Avatar Image'),
                    'param_name' => 'avt_img_2',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Avatar Image'),
                    'param_name' => 'avt_img_3',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Background Image'),
                    'param_name' => 'bg_image',
                ),


            ),
        )
    );
}
add_action('vc_before_init', 'home_banner_thirteen');
function home_banner_thirteen_frontend($atts, $content)
{
global $jobcircle_framework_options;
    $atts = shortcode_atts(
        array(

            'background_image' => '',
            'titl' => '',
            'spn_title' => '',
            'hig_title' => '',
            'description' => '',
            'min_title' => '',
            'avt_img_1' => '',
            'avt_img_2' => '',
            'avt_img_3' => '',
            'bg_image' => '',
            'jobcircle_page' => '',

        ),
        $atts,
        'home_banner_thirteen'
    );


    $background_image = isset($atts['background_image']) ? $atts['background_image'] : '';
    $titl = isset($atts['titl']) ? $atts['titl'] : '';
    $spn_title = isset($atts['spn_title']) ? $atts['spn_title'] : '';
    $hig_title = isset($atts['hig_title']) ? $atts['hig_title'] : '';
    $description = isset($atts['description']) ? $atts['description'] : '';
    $min_title = isset($atts['min_title']) ? $atts['min_title'] : '';
    $avt_img_1 = isset($atts['avt_img_1']) ? $atts['avt_img_1'] : '';
    $avt_img_2 = isset($atts['avt_img_2']) ? $atts['avt_img_2'] : '';
    $avt_img_3 = isset($atts['avt_img_3']) ? $atts['avt_img_3'] : '';
    $bg_image = isset($atts['bg_image']) ? $atts['bg_image'] : '';
    $jobcircle_page = isset($atts['jobcircle_page']) ? $atts['jobcircle_page'] : '';




    ob_start();
    ?>

    <div class="visual-block visal-theme-13 pt-100 pt-md-140 pt-xl-160 pb-45 pb-md-59"
        style="background-image: url('<?php echo esc_url_raw($background_image) ?>');">
        <div class="container position-relative">
            <div class="row justify-content-between align-items-center">
                <div class="col-12 col-lg-7 col-xl-6 pb-30 mb-lg-0">
                    <!-- visual textbox -->
                    <div class="visual-textbox text-black">
                        <?php if (!empty($titl) || !empty($spn_title) || !empty($hig_title)) {
                            ?>
                            <h1>
                                <?php echo esc_html($titl) ?> <br>
                                <?php echo esc_html($spn_title) ?><span>
                                    <?php echo esc_html($hig_title) ?>
                                </span>
                            </h1>
                            <?php
                        } ?>
                        <?php if (!empty($description)) {
                            ?>
                            <p>
                                <?php echo esc_textarea($description) ?>
                            </p>
                            <?php
                        } 
                    	$job_select_page = isset($jobcircle_framework_options['job_select_page']) ? $jobcircle_framework_options['job_select_page'] : '';
						$job_select_page_id = jobcircle_get_page_id_from_name($job_select_page);
						$job_select_page_url = get_permalink($job_select_page_id);
						?>
                        <!-- search form -->
                        <form class="form-search d-flex flex-column flex-lg-row justify-content-between" action="<?php echo esc_url($job_select_page_url); ?>" method="get">
                            <div class="fields-holder bg-white text-black d-flex flex-wrap flex-md-nowrap">
                            <div class="form-group">
									<i class="jobcircle-icon-search icon"></i>
									<input class="form-control" type="search" name="keyword"
										placeholder="<?php esc_html_e('Job Title...', 'jobcircle-frame') ?>">
								</div>
                                <div class="form-group">
									<i class="jobcircle-icon-map-pin icon"></i>
									<input class="form-control" type="search" name="location"
										placeholder="<?php esc_html_e('Enter Location', 'jobcircle-frame') ?>">
								</div>  
                            </div>
                            <button class="btn btn-sm" type="submit">
                                <span class="btn-text">
                                    <?php esc_html_e('Search', 'jobcircle-frame') ?>
                                </span>
                            </button>
                        </form>
                        <div class="searches-bar">
                            <strong class="searches-title">
                                <?php esc_html_e('Searches :', 'jobcircle-frame') ?>
                            </strong>
                            <?php
                           // $include_category_ids = array(72, 103, 270, 74);

                            // Fetch the terms for the custom taxonomy 'job_featured'
                            $terms = get_terms(
                                array(
                                    'taxonomy' => 'job_category',
                                    'post_type' => 'jobs',
                                    'hide_empty' => false,
                                    'parent' => 0,
                                    //'include' => $include_category_ids,
                                )
                            );
                            $counter = 0;
                            foreach ($terms as $term) {
                                if ($counter < 3) {
                                    // Query to get the post count for each term
                                    $args = array(
                                        'post_type' => 'jobs',
                                        'tax_query' => array(
                                            array(
                                                'taxonomy' => 'job_category',
                                                'terms' => $term->term_id,
                                            ),
                                        ),
                                    );
                                    $jobcircle_page_id = jobcircle_get_page_id_from_name($jobcircle_page);

                                    $jobcircle_page_url = home_url('/');
                                    if ($jobcircle_page_id > 0) {
                                        $jobcircle_page_url = get_permalink($jobcircle_page_id);
                                    }
                                    if (!empty($jobcircle_page_url) || !empty($term)) {
                                    ?>
                                    <p class="m-0"> <a href="<?php echo esc_url($jobcircle_page_url); ?>?job_category=<?php echo jobcircle_esc_the_html($term->slug) ?>">
                                        <?php echo jobcircle_esc_the_html($term->name); 
                                          echo ($counter < 2) ? ', ' : '';
                                            ?>
                                        </a>
                                    </p>
                                    <?php
                                    }
                                   
                                } else {
                                    break; // Break the loop after 9 categories
                                }
                                 $counter++;
                            }
                            ?>
                        </div>
                        <div class="users-box centerr">

                            <?php if (!empty($min_title)) {
                                ?>
                                <strong class="title">
                                    <?php echo esc_html($min_title) ?>
                                </strong>
                                <?php
                            }
                            if (!empty($avt_img_1) || !empty($avt_img_2) || !empty($avt_img_3)) {
                                ?>
                                <ul class="users-list">
                                    <?php if (!empty($avt_img_1)) { ?>
                                        <li><img src="<?php echo esc_url_raw($avt_img_1) ?>" width="60" height="60" alt="User"></li>
                                    <?php }
                                    if (!empty($avt_img_2)) { ?>
                                        <li><img src="<?php echo esc_url_raw($avt_img_2) ?>" width="60" height="60" alt="User"></li>
                                    <?php }
                                    if (!empty($avt_img_3)) { ?>
                                        <li><img src="<?php echo esc_url_raw($avt_img_3) ?>" width="60" height="60" alt="User"></li>
                                    <?php } ?>
                                    <li><i class="jobcircle-icon-plus"></i></li>
                                </ul>
                                <?php
                            } ?>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-5 col-xl-6">
                    <?php if (!empty($bg_image)) {
                        ?>
                        <div class="image-holder"><img src="<?php echo esc_url_raw($bg_image) ?>" alt="image"></div>
                        <?php
                    } ?>
                </div>
            </div>
        </div>
    </div>
    <?php

    ?>

    <?php
    return ob_get_clean();
}
add_shortcode('home_banner_thirteen', 'home_banner_thirteen_frontend');