<?php
function jobcircle_home_banner_seven()
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
            'name' => __('Home Banner Seven'),
            'base' => 'home_banner_seven',
            'category' => __('job Circle'),
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
                    'param_name' => 'bg_img',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Image'),
                    'param_name' => 'icn_img',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title'),
                    'param_name' => 'titl',
                ),
                array(
                      'type' => 'checkbox',
                      'holder'=> 'div',
                      'class' => '',
                      'heading' =>__('CheckBox Option For categories'),
                      'param_name' => 'checkbox_param',
                      'value' => $job_types,
                    ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Description'),
                    'param_name' => 'desc',
                ),

            ),
        )
    );
}
add_action('vc_before_init', 'jobcircle_home_banner_seven');
function jobcircle_home_banner_seven_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(
            'bg_img' => '',
            'icn_img' => '',
            'titl' => '',
            'desc' => '',
            'checkbox_param' => '',

            'jobcircle_page' => '',

        ),
        $atts,
        'jobcircle_home_banner_seven'
    );

global $jobcircle_framework_options;

    $bg_img = isset($atts['bg_img']) ? $atts['bg_img'] : '';
    $icn_img = isset($atts['icn_img']) ? $atts['icn_img'] : '';
    $titl = isset($atts['titl']) ? $atts['titl'] : '';
    $desc = isset($atts['desc']) ? $atts['desc'] : '';
    $checkbox_param = isset($atts['checkbox_param']) ? $atts['checkbox_param'] : '';
  $job_type_arr = !empty($checkbox_param) ? explode(',', $checkbox_param) : '';


    $jobcircle_page = isset($atts['jobcircle_page']) ? $atts['jobcircle_page'] : '';

    ob_start();
    ?>

    <div class="visual-block visual-theme-7 text-white pt-100 pt-md-140 pt-xl-180 pb-100 pb-md-150 pb-lg-190"
        style="background-image: url(<?php echo esc_url_raw($bg_img); ?> );">
        <div class="container position-relative">
            <span class="pattern">
                <?php if (!empty($icn_img)) {
                    ?>
                    <img src="<?php echo esc_url_raw($icn_img) ?>" alt="">
                    <?php
                } ?>
            </span>
            <div class="row justify-content-between">
                <div class="col-12 col-md-10 col-xl-8 offset-md-1 offset-xl-2 position-relative">
                    <!-- visual textbox -->
                    <div class="visual-textbox">
                        <?php if (!empty($titl)) {
                            ?>
                            <h1>
                                <?php echo jobcircle_esc_the_html($titl) ?>
                            </h1>
                            <?php
                        } ?>
                        <?php if (!empty($desc)) {
                            ?>
                            <p>
                                <?php echo esc_textarea($desc) ?>
                            </p>
                            <?php
                        } 
                        $job_select_page = isset($jobcircle_framework_options['job_select_page']) ? $jobcircle_framework_options['job_select_page'] : '';
						$job_select_page_id = jobcircle_get_page_id_from_name($job_select_page);
						$job_select_page_url = get_permalink($job_select_page_id);
						?>
                        <!-- search form -->
                        <form class="form-search d-flex flex-column flex-lg-row justify-content-between" action="<?php echo esc_url($job_select_page_url); ?>">
                            <div class="fields-holder bg-white text-black d-flex flex-wrap flex-md-nowrap">
                                <div class="form-group">
                                    <i class="jobcircle-icon-search icon"></i>
                                    <input class="form-control" name="keyword" type="search"
                                        placeholder="<?php echo esc_html_e('Search Job Title', 'jobcircle-frame') ?>">
                                </div>
                                <div class="form-group bar-icon">
                                    <div class="icon pb-0"> <i class="forms-jin"><img src="<?php echo Jobcircle_Plugin::root_url()?>/images/bars.png" width="20" alt="Category icon"></i></div>
                                    <select class="select2" name="job_category" data-placeholder="Select Category">
                                        <option>
                                            <?php esc_html_e('All Categories', 'jobcircle-frame') ?>
                                        </option>
                                        	<?php
										$cat_terms = get_terms(
											array(
												'taxonomy' => 'job_category',
											)
										);
										if (!empty($cat_terms)) {
											foreach ($cat_terms as $cat_term) {
												?>
												<option value="<?php echo jobcircle_esc_the_html($cat_term->slug) ?>"
													id="cat-<?php echo jobcircle_esc_the_html($cat_term->term_id) ?>">
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
                            <button class="btn btn-green btn-sm" type="submit">
                                <span class="btn-text">
                                    <?php echo esc_html_e('Find Job', 'jobcircle-frame') ?>
                                </span>
                            </button>
                        </form>
                        <div class="popular-searches">
                            <strong class="subtitle">
                                <?php echo esc_html_e('Popular Searches:', 'jobcircle-frame') ?>
                            </strong>
                            <ul>

                                <?php
                                $counter = 0;
                                $include_categories_ids = $job_type_arr;
                                $terms = get_terms(array(
                                    'taxonomy' => 'job_category',
                                    'post_type' => 'jobs',
                                    'hide_empty' => false,
                                    'parent' => 0,
                                    'include'=> $include_categories_ids, 
                                )
                                );
                                foreach ($terms as $term) {

                                    if ($counter <= 4) {
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
                                        $term_id = $term->term_id;
                                        $term_meta = get_term_meta($term_id, 'job_category_custom_fields', true);
                                        $category_link = get_category_link($term_id);
                                        $jobcircle_page_id = jobcircle_get_page_id_from_name($jobcircle_page);
                                        $jobcircle_page_url = home_url('/');
                                        if ($jobcircle_page_id > 0) {
                                            $jobcircle_page_url = get_permalink($jobcircle_page_id);
                                        }
                                        ?>
                                        <!-- Popular Searches -->
                                        <li><a
                                                href="<?php echo esc_url($jobcircle_page_url); ?>?job_category=<?php echo $term->slug ?>">
                                                <?php echo ($term->name); ?>
                                            </a></li>
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
                </div>
            </div>
        </div>
    </div>
    <?php
    ?>

    <?php

    return ob_get_clean();
}

add_shortcode('home_banner_seven', 'jobcircle_home_banner_seven_frontend');