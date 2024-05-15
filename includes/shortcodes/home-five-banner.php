<?php
function jobcircle_banner_f()
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
            'name' => __('Home Five Banner'),
            'base' => 'jc_banner_f',
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
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title'),
                    'param_name' => 'title',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __(' Sub Title'),
                    'param_name' => 'sb_title',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Sub Title'),
                    'param_name' => 'sbb_title',
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
                    'heading' => __('Button Text'),
                    'param_name' => 'btn_txt',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Searches'),
                    'param_name' => 'design',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Searches'),
                    'param_name' => 'business',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Searches'),
                    'param_name' => 'video',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Banner Image'),
                    'param_name' => 'ban_img',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Upload Image'),
                    'param_name' => 'upld_img',
                ),
            ),
        )
    );
}
add_action('vc_before_init', 'jobcircle_banner_f');
function jobcircle_banner_f_frontend($atts, $content)
{
	global $jobcircle_framework_options;
    $atts = shortcode_atts(
        array(

            'title' => '',
            'sb_title' => '',
            'sbb_title' => '',
            'desc' => '',
            'btn_txt' => '',
            'design' => '',
            'business' => '',
            'video' => '',
            'ban_img' => '',
            'upld_img' => '',
            'jobcircle_page' => '',

        ),
        $atts,
        'jobcircle_banner_f'
    );

    $title = isset($atts['title']) ? $atts['title'] : '';
    $desc = isset($atts['desc']) ? $atts['desc'] : '';
    $btn_txt = isset($atts['btn_txt']) ? $atts['btn_txt'] : '';
    $design = isset($atts['design']) ? $atts['design'] : '';
    $business = isset($atts['business']) ? $atts['business'] : '';
    $video = isset($atts['video']) ? $atts['video'] : '';
    $ban_img = isset($atts['ban_img']) ? $atts['ban_img'] : '';
    $upld_img = isset($atts['upld_img']) ? $atts['upld_img'] : '';
    $sb_title = isset($atts['sb_title']) ? $atts['sb_title'] : '';
    $sbb_title = isset($atts['sbb_title']) ? $atts['sbb_title'] : '';
    $jobcircle_page = isset($atts['jobcircle_page']) ? $atts['jobcircle_page'] : '';

    ob_start();
    ?>
    <style>
        .bg-light-sky {
            --bs-bg-opacity: 1;
            background-color: rgba(239, 246, 243, var(--bs-bg-opacity)) !important;
        }
    </style>
    <div class="visual-block visual-theme-5 bg-light-sky text-black pt-100 pt-md-140 pt-xl-180 pb-45 pb-md-80 pb-lg-60">
        <div class="container position-relative">
            <div class="row justify-content-between">
                <div class="col-12 col-lg-9 col-xl-8 position-relative">
                    <!-- visual textbox -->
                    <div class="visual-textbox">
                        <?php
                        if (!empty($title) || !empty($sb_title) || !empty($sbb_title)) { ?>
                            <h1>
                                <?php echo esc_html($title); ?><br>
                                <?php echo esc_html($sb_title); ?><br>
                                <?php echo esc_html($sbb_title); ?>
                            </h1>
                        <?php } ?>
                        <?php
                        if (!empty($desc)) { ?>
                            <p>
                                <?php echo esc_textarea($desc); ?>
                            </p>
                        <?php } 
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
										placeholder="<?php esc_html_e('Search Job Title', 'jobcircle-frame') ?>">
								</div>
                                <div class="form-group">
									<span class="icon mt-10"><img src="<?php echo Jobcircle_Plugin::root_url()?>/images/bars.png" width = "20" alt ="category icon"></span>
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
                            <button class="btn btn-green btn-sm" type="submit">
                                <?php
                                if (!empty($btn_txt)) { ?>
                                    <span class="btn-text">
                                        <?php echo esc_html($btn_txt) ?>
                                    </span>
                                <?php } ?>
                            </button>
                        </form>
                        <!-- Popular Searches -->
                        <div class="popular-searches">
                            <strong class="subtitle">
                                <?php esc_html_e('Popular Searches:', 'jobcircle-frame') ?>
                            </strong>
                            <ul>
                                <?php
                                $terms = get_terms(array(
                                    'taxonomy' => 'job_category',
                                    'post_type' => 'jobs',
                                    'hide_empty' => false,
                                )
                                );
                                $counter = 0;
                                foreach ($terms as $term) {
                                    if ($counter < 3) {
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
                                        $category_link = get_category_link($term_id);
                                        $jobcircle_page_id = jobcircle_get_page_id_from_name($jobcircle_page);
                                        $jobcircle_page_url = home_url('/');
                                        if ($jobcircle_page_id > 0) {
                                            $jobcircle_page_url = get_permalink($jobcircle_page_id);
                                        }
                                        if (!empty($jobcircle_page_url || $term)) {
                                            ?>
                                            <li><a
                                                    href="<?php echo esc_url($jobcircle_page_url); ?>?job_category=<?php echo jobcircle_esc_the_html($term->slug) ?>">
                                                    <?php echo esc_html($term->name); ?>
                                                </a></li>
                                        <?php
                                        }
                                        $counter++;
                                    } else {
                                        break;
                                    }
                                } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="illustration">
            <?php
            if (!empty($ban_img)) { ?>
                <img src="<?php echo esc_url_raw($ban_img) ?>" alt="image">
            <?php } ?>
        </div>
        <div class="circle-image">
            <?php
            if (!empty($upld_img)) { ?>
                <img src="<?php echo esc_url_raw($upld_img) ?>" alt="circle">
            <?php } ?>
        </div>
    </div>

    <?php
    $html = ob_get_clean();
    return $html;
}
add_shortcode('jc_banner_f', 'jobcircle_banner_f_frontend');