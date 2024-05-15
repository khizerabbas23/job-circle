<?php
function jobcircle_banner_home()
{
    $terms = get_terms(
        array(
            'taxonomy' => 'job_category',
            'hide_empty' => true,
        )
    );
    $job_types = array();
    foreach ($terms as $term) {
        $job_types[$term->name] = $term->term_id;
    }
    ;

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
            'name' => __('Banner 15'),
            'base' => 'jc_banner_home',
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
                    'param_name' => 'bg_image',
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
                    'heading' => __('Discription'),
                    'param_name' => 'disc',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Main Image'),
                    'param_name' => 'main_image',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Candidates'),
                    'param_name' => 'candidates',
                ),
                array(
                    'type' => 'checkbox',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Checkbox Options'),
                    'param_name' => 'checkbox_param',
                    'value' => $job_types,
                ),

                //Group
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'multi_sec',
                    'params' => array(

                        array(
                            'type' => 'jobcircle_browse_img',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Image'),
                            'param_name' => 'img',
                        ),
                    ),
                ),
            )
        )
    );

}
add_action('vc_before_init', 'jobcircle_banner_home');

//welcome Massage frontend
function jobcircle_banner_home_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(

            'heading' => '',
            'disc' => '',
            'main_image' => '',
            'bg_image' => '',
            'candidates' => '',
            'checkbox_param' => '',
            'multi_sec' => '',
            'jobcircle_page' => '',
            
        ), $atts, 'jobcircle_banner_home'
    );
    global $jobcircle_framework_options;

    $heading = isset($atts['heading']) ? $atts['heading'] : '';
    $disc = isset($atts['disc']) ? $atts['disc'] : '';
    $main_image = isset($atts['main_image']) ? $atts['main_image'] : '';
    $bg_image = isset($atts['bg_image']) ? $atts['bg_image'] : '';
    $candidates = isset($atts['candidates']) ? $atts['candidates'] : '';
    $checkbox_param = isset($atts['checkbox_param']) ? $atts['checkbox_param'] : '';
    $job_type_arr = !empty($checkbox_param) ? explode(',', $checkbox_param) : '';
    $jobcircle_page = isset($atts['jobcircle_page']) ? $atts['jobcircle_page'] : '';
    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
    ob_start()
        ?>
    <div class="visual-block visual-theme-15 pt-100 pt-md-140 pt-xl-160 pb-37"
        style="background-image: url('<?php echo esc_url_raw($bg_image) ?>');">
        <div class="container position-relative">
            <div class="row justify-content-between align-items-center">
                <div class="col-12 col-lg-7 col-xl-9 pb-30 mb-lg-0">
                    <!-- visual textbox -->
                    <div class="visual-textbox text-black">
                        <?php if (!empty($heading)) {
                            ?>
                            <h1>
                                <?php echo esc_html($heading) ?>
                            </h1>
                        <?php }
                        if (!empty($disc)) { ?>
                            <p>
                                <?php echo esc_html($disc) ?>
                            </p>
                        <?php } 
                    	$job_select_page = isset($jobcircle_framework_options['job_select_page']) ? $jobcircle_framework_options['job_select_page'] : '';
						$job_select_page_id = jobcircle_get_page_id_from_name($job_select_page);
						$job_select_page_url = get_permalink($job_select_page_id);?>
                        <!-- search form -->
                        <form class="form-search d-flex flex-column flex-lg-row justify-content-between" action="<?php echo esc_url($job_select_page_url); ?>" method="get">
                            <div class="fields-holder bg-white text-black d-flex flex-wrap flex-md-nowrap">
                                <div class="form-group flex-column align-items-start">
                                    <label for="location">
                                        <?php echo esc_html_e('Search', 'jobcircle-frame') ?>
                                    </label>
                                    <input id="location" class="form-control" name="keyword" type="search" placeholder="<?php echo esc_html_e('Enter Search', 'jobcircle-frame') ?>">
                                </div>
                                <div class="form-group flex-column align-items-start">
                                    <label for="type">
                                        <?php echo esc_html_e('Job Category', 'jobcircle-frame') ?>
                                    </label>
                                   
                                   <select class="select2" name="job_category"
										data-placeholder="<?php esc_html_e('Choose Category', 'jobcircle-frame') ?>">
										<option label="Placeholder"></option>
										<?php
										$cat_terms = get_terms(
											array(
												'taxonomy' => 'job_category',
											)
										);
										if (!empty($cat_terms)) {
											foreach ($cat_terms as $cat_term) {
												?>
												<option value="<?php echo esc_html($cat_term->slug) ?>"
													id="cat-<?php echo esc_html($cat_term->term_id) ?>">
													<?php echo esc_attr($cat_term->name) ?>
												</option>
												<?php
											}
											;
										}
										?>
									</select>
                                </div>
                            </div>
                            <button class="btn btn-sm" type="submit">
                                <i class="jobcircle-icon-search"></i>
                                <span class="btn-text">
                                    <?php echo esc_html_e('Search', 'jobcircle-frame') ?>
                                </span>
                            </button>
                        </form>
                        <div class="searches-bar">
                            <strong class="searches-title">
                                <?php echo esc_html_e('Searches :', 'jobcircle-frame') ?>
                            </strong>
                            <p class="m-0">
<?php
// Fetch the terms for the custom taxonomy 'job_featured'
$terms = get_terms(
    array(
        'taxonomy' => 'job_category',
        'post_type' => 'jobs',
        'hide_empty' => false,
        'parent' => 0,
        'include' => $job_type_arr,
    )
);
$counter = 0;
foreach ($terms as $key => $term) {
    // Check if it's not the last category
    if ($counter <3) {
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
        $jobcircle_page_url = home_url('/');
        if ($jobcircle_page_id > 0) {
            $jobcircle_page_url = get_permalink($jobcircle_page_id);
        }
        if (!empty($jobcircle_page_url) || !empty($term)) {
            ?>
            <a href="<?php echo esc_url($jobcircle_page_url); ?>?job_category=<?php echo esc_html($term->slug); ?>">
                <?php
                echo esc_html($term->name);
                // If it's not the last category, add a comma after the category name
                echo ($counter < 2) ? ', ' : '';
                ?>
            </a>
            <?php
        }
    }

    // Increment the counter
    $counter++;
}
?>


                            </p>
                        </div>
                        <div class="users-box">
                            <?php if (!empty($candidates)) {
                                ?>
                                <strong class="title">
                                    <?php echo esc_html($candidates) ?>
                                </strong>
                            <?php } ?>
                            <ul class="users-list">
                                <?php
                                $lm_team_list = vc_param_group_parse_atts($atts['multi_sec']);
                                foreach ($lm_team_list as $key => $value) {
                                    $img = isset($value["img"]) ? $value["img"] : '';
                                    if (!empty($img)) {
                                        ?>
                                        <li><img src="<?php echo esc_url_raw($img) ?>" width="60" height="60" alt="User"></li>
                                        <?php
                                    }
                                }
                                ?>
                                <li><i class="jobcircle-icon-plus"></i></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if (!empty($main_image)) {
            ?>
            <div class="image-holder"><img src="<?php echo esc_url_raw($main_image) ?>" alt="image"></div>
        <?php } ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('jc_banner_home', 'jobcircle_banner_home_frontend');