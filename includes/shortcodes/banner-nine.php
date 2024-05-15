<?php
function jobcircle_home_banner_nine()
{
    $all_page = array(__('Select Page', 'jobcircle-frame'), '');
    $args = array(
        'sort_order' => 'asc',
        'sort_column' => 'post_title',
        'hierarchical' => 1,
        'exclude' => '',
        'include' => '',
        'orderby' => '',
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
            'name' => __('Home Banner Nine'),
            'base' => 'home_banner_nine',
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
                    'param_name' => 'line_imag',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title'),
                    'param_name' => 'titl',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Description'),
                    'param_name' => 'desc',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Skills'),
                    'param_name' => 'skills',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Icon Image'),
                    'param_name' => 'icn_img',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Advise Title'),
                    'param_name' => 'sub_title',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Advise Description'),
                    'param_name' => 'adv_desc',
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
                    'heading' => __('Candidate Title'),
                    'param_name' => 'cndi_title',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Find Job'),
                    'param_name' => 'find_job',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Find Job URL'),
                    'param_name' => 'find_job_url',
                ),
                  array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Upload cv text'),
                    'param_name' => 'upload_text',
                ),
                  array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Upload URL'),
                    'param_name' => 'upload_url',
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
            ),
        )
    );
}
add_action('vc_before_init', 'jobcircle_home_banner_nine');
function jobcircle_home_banner_nine_frontend($atts, $content)
{
global $jobcircle_framework_options;
    $atts = shortcode_atts(
        array(

            'line_imag' => '',
            'titl' => '',
            'desc' => '',
            'skills' => '',
            'icn_img' => '',
            'sub_title' => '',
            'find_job_url' => '',
            'find_job' => '',
            'adv_desc' => '',
            'bg_img' => '',
            'cndi_title' => '',
            'avt_img_1' => '',
            'avt_img_2' => '',
            'avt_img_3' => '',
            'upload_text' => '',
            'upload_url' => '',

            'jobcircle_page' => '',


        ),
        $atts,
        'jobcircle_home_banner_nine'
    );

    $line_imag = isset($atts['line_imag']) ? $atts['line_imag'] : '';
    $titl = isset($atts['titl']) ? $atts['titl'] : '';
    $desc = isset($atts['desc']) ? $atts['desc'] : '';
    $skills = isset($atts['skills']) ? $atts['skills'] : '';
    $icn_img = isset($atts['icn_img']) ? $atts['icn_img'] : '';
    $sub_title = isset($atts['sub_title']) ? $atts['sub_title'] : '';
    $find_job = isset($atts['find_job']) ? $atts['find_job'] : '';
    $find_job_url = isset($atts['find_job_url']) ? $atts['find_job_url'] : '';
    $upload_text = isset($atts['upload_text']) ? $atts['upload_text'] : '';
    $upload_url = isset($atts['upload_url']) ? $atts['upload_url'] : '';
    $adv_desc = isset($atts['adv_desc']) ? $atts['adv_desc'] : '';
    $bg_img = isset($atts['bg_img']) ? $atts['bg_img'] : '';
    $cndi_title = isset($atts['cndi_title']) ? $atts['cndi_title'] : '';
    $avt_img_1 = isset($atts['avt_img_1']) ? $atts['avt_img_1'] : '';
    $avt_img_2 = isset($atts['avt_img_2']) ? $atts['avt_img_2'] : '';
    $avt_img_3 = isset($atts['avt_img_3']) ? $atts['avt_img_3'] : '';

    $jobcircle_page = isset($atts['jobcircle_page']) ? $atts['jobcircle_page'] : '';


    ob_start();
    ?>

    <div class="visual-block visual-theme-9 bg-dark-blue pt-100 pt-md-140 pt-xl-180 pb-30 pb-md-80 pb-lg-40 text-white"
        <?php if (!empty($line_imag)) { ?> style="background-image: url(<?php echo esc_url_raw($line_imag) ?>);">
        <?php } ?>
        <div class="container position-relative">
            <div class="row justify-content-between">
                <div class="col-12 col-lg-7 col-xl-6 position-relative">
                    <!-- visual textbox -->
                    <div class="visual-textbox">
                        <h1>
                            <?php if (!empty($titl)) {
                                ?>
                                <?php echo jobcircle_esc_the_html($titl) ?>
                                <?php
                            } ?>
                        </h1>
                        <p>
                            <?php if (!empty($desc)) {
                                ?>
                                <?php echo esc_textarea($desc) ?>
                                <?php
                            } 
                    	$job_select_page = isset($jobcircle_framework_options['job_select_page']) ? $jobcircle_framework_options['job_select_page'] : '';
						$job_select_page_id = jobcircle_get_page_id_from_name($job_select_page);
						$job_select_page_url = get_permalink($job_select_page_id);
						?>
                        </p>
                        <!-- search form -->
                        <form class="form-search" action="<?php echo esc_url($job_select_page_url); ?>" method="get">
                            <div class="fields-holder bg-white text-black d-flex flex-wrap flex-md-nowrap">
                                <div class="form-group">
									<i class="jobcircle-icon-search icon"></i>
									<input class="form-control" type="search" name="keyword"
										placeholder="<?php echo esc_html_e('Search Job Title', 'jobcircle-frame') ?>">
								</div>
                                <div class="form-group">
									<span class="icon mt-10"><img src="<?php echo Jobcircle_Plugin::root_url()?>/images/bars.png" width = "20" alt ="category icon"></span>
                                    <select class="select2" name="job_category"
										data-placeholder="<?php echo esc_html_e('Choose Category', 'jobcircle-frame') ?>">
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
												<option value="<?php echo jobcircle_esc_the_html($cat_term->slug) ?>"
													id="cat-<?php echo jobcircle_esc_the_html($cat_term->term_id) ?>">
													<?php echo esc_attr($cat_term->name) ?>
												</option>
												<?php
											}
											
										}
										?>
									</select>
                                </div>
                            </div>
                            <?php if (!empty($find_job)) { ?>
                                <button class="btn btn-blue btn-sm" type="submit"><a class="text-white"
                                        href="<?php echo jobcircle_esc_the_html($find_job_url) ?>"><span class="btn-text">
                                            <?php echo jobcircle_esc_the_html($find_job) ?>
                                        </span></a> </button>
                            <?php } ?>
                        </form>
                        <div class="searches_holder">
                          <span class="search_result pding">
                            <strong>
                                <?php echo esc_html_e('Searches:', 'jobcircle-frame') ?>
                            </strong>
                           <?php
                            $include_category_ids = array(72, 103, 270, 74);

                            // Fetch the terms for the custom taxonomy 'job_featured'
                            $terms = get_terms(
                                array(
                                    'taxonomy' => 'job_category',
                                    'post_type' => 'jobs',
                                    'hide_empty' => false,
                                    'parent' => 0,
                                    'include' => $include_category_ids,
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
                                    ?>
                                   <a href="<?php echo esc_url($jobcircle_page_url); ?>?job_category=<?php echo $term->slug ?>">
                                            <?php echo $term->name ?><?php if($counter<1){ echo ',' ; }?>
                                        </a>
                                    
                                    <?php
                                   
                                } else {
                                    break; // Break the loop after 9 categories
                                }
                                 $counter++;
                            }
                            ?>
                             </span>
                            <a class="btn_upload cloud-icon" href="<?php echo jobcircle_esc_the_html($upload_url); ?>">
                                <i class="jobcircle-icon-upload-cloud icon"></i>
                                <span class="text">
                                    <?php echo jobcircle_esc_the_html($upload_text); ?>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-5 col-xl-6 d-flex justify-content-center justify-content-center">
                    <!-- visual Image -->
                    <div class="visual-image position-relative">
                        <div class="advise_bar">
                            <?php if (!empty($icn_img)) {
                                ?>
                                <i class="icon"><img src="<?php echo esc_url_raw($icn_img) ?>" alt=""></i>
                                <?php
                            } ?>
                            <div class="text-hold">
                                <strong class="title">
                                    <?php if (!empty($sub_title)) {
                                        ?>
                                        <?php echo jobcircle_esc_the_html($sub_title) ?>
                                        <?php
                                    } ?>
                                </strong>
                                <p>
                                    <?php if (!empty($adv_desc)) {
                                        ?>
                                        <?php echo esc_textarea($adv_desc) ?>
                                        <?php
                                    } ?>
                                </p>
                            </div>
                        </div>
                        <?php if (!empty($bg_img)) {
                            ?>
                            <img src="<?php echo esc_url_raw($bg_img) ?>" alt="img">
                            <?php
                        } ?>
                        <div class="users-box">
                            <strong class="title">
                                <?php if (!empty($cndi_title)) {
                                    ?>
                                    <?php echo jobcircle_esc_the_html($cndi_title) ?>
                                    <?php
                                } ?>
                            </strong>
                            <ul class="users-list">
                                <?php if (!empty($avt_img_1)) {
                                    ?>
                                    <li><img src="<?php echo esc_url_raw($avt_img_1) ?>" width="60" height="60" alt="User"></li>
                                <?php }
                                if (!empty(!empty($avt_img_2))) { ?>
                                    <li><img src="<?php echo esc_url_raw($avt_img_2) ?>" width="60" height="60" alt="User"></li>
                                <?php }
                                if (!empty($avt_img_3)) { ?>
                                    <li><img src="<?php echo esc_url_raw($avt_img_3) ?>" width="60" height="60" alt="User"></li>
                                    <?php
                                } ?>
                                <li><i class="jobcircle-icon-plus"></i></li>
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

add_shortcode('home_banner_nine', 'jobcircle_home_banner_nine_frontend');