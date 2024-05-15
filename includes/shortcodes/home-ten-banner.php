<?php
function jobcircle_banner_ten()
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
            'name' => __('Home Ten banner'),
            'base' => 'jc_banner_ten',
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
                    'param_name' => 'bgrd_img',
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
                    'heading' => __('Sub Title'),
                    'param_name' => 'sub_title',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Button Text'),
                    'param_name' => 'btn_text',
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
add_action('vc_before_init', 'jobcircle_banner_ten');
function jobcircle_banner_ten_frontend($atts, $content)
{
    global $jobcircle_framework_options;
    $atts = shortcode_atts(
        array(

            'bgrd_img' => '',
            'titl' => '',
            'sub_title' => '',
            'btn_text' => '',
            'upld_img' => '',
            'jobcircle_page' => '',
            'checkbox_param' => '',

        ),
        $atts,
        'jobcircle_banner_ten'
    );

    $bgrd_img = isset($atts['bgrd_img']) ? $atts['bgrd_img'] : '';
    $titl = isset($atts['titl']) ? $atts['titl'] : '';
    $sub_title = isset($atts['sub_title']) ? $atts['sub_title'] : '';
    $btn_text = isset($atts['btn_text']) ? $atts['btn_text'] : '';
    $upld_img = isset($atts['upld_img']) ? $atts['upld_img'] : '';
    $jobcircle_page = isset($atts['jobcircle_page']) ? $atts['jobcircle_page'] : '';
    $checkbox_param = isset($atts['checkbox_param']) ? $atts['checkbox_param'] : '';
    $job_type_arr = !empty($checkbox_param) ? explode(',', $checkbox_param) : '';

    ob_start();
    ?>
    <?php
    if (!empty($bgrd_img)) {
        ?>
        <div class="visual-block visal-theme-10 pt-100 pt-md-140 pt-xl-160 pb-45 pb-md-59"
            style="background-image: url('<?php echo esc_url_raw($bgrd_img); ?>');">
            <?php
    }
    ?>
        <div class="container position-relative">
            <div class="row justify-content-between align-items-center">
                <div class="col-12 col-lg-7 col-xl-6 pb-30 mb-lg-0">
                    <!-- visual textbox -->
                    <div class="visual-textbox text-black">
                        <?php
                        if (!empty($titl)) {
                            ?>
                            <h1>
                                <?php echo esc_html($titl) ?>
                            </h1>
                            <?php
                        }
                        ?>
                        <?php
                        if (!empty($sub_title)) {
                            ?>
                            <p>
                                <?php echo esc_textarea($sub_title); ?>
                            </p>
                            <?php
                        }
                        $job_select_page = isset($jobcircle_framework_options['job_select_page']) ? $jobcircle_framework_options['job_select_page'] : '';
                        $job_select_page_id = jobcircle_get_page_id_from_name($job_select_page);
                        $job_select_page_url = get_permalink($job_select_page_id);
                        ?>
                        <!-- search form -->
                        <form class="form-search d-flex flex-column flex-lg-row justify-content-between"
                            action="<?php echo esc_url($job_select_page_url); ?>" method="get">
                            <div class="fields-holder bg-white text-black d-flex flex-wrap flex-md-nowrap">
                                <div class="form-group flex-column align-items-start">
                                <label for="location"><?php esc_html_e('Title', 'jobcircle-frame') ?></label>
                                    <input class="form-control" type="search" name="keyword"
                                        placeholder="<?php esc_html_e('Search Job Title', 'jobcircle-frame') ?>">
                                </div>
                                <div class="form-group flex-column align-items-start">
                                <label for="type"><?php esc_html_e('Category', 'jobcircle-frame') ?></label>
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
                                <i class="jobcircle-icon-search home-10"></i>
                                <?php
                                if (!empty($btn_text)) {
                                    ?>
                                    <span class="btn-text">
                                        <?php echo esc_html($btn_text) ?>
                                    </span>
                                    <?php
                                }
                                ?>
                            </button>
                        </form>
                        <ul class="list-inline tags-list">
                            <?php
                            $include_category_ids = $job_type_arr;
                            $counter = 0;
                            $terms = get_terms(array(
                                'taxonomy' => 'job_category',
                                'post_type' => 'jobs',
                                'hide_empty' => false,
                                'parent' => 0,
                                'include' => $include_category_ids,
                            )
                            );
                            foreach ($terms as $term) {

                                if ($counter < 4) {
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
                                    if (!empty($jobcircle_page_url) || !empty($term)) {
                                        ?>
                                        <li><a
                                                href="<?php echo esc_url($jobcircle_page_url); ?>?job_category=<?php echo jobcircle_esc_the_html($term->slug) ?>">
                                                <?php echo ($term->name); ?>
                                            </a></li>
                                        <?php
                                    }
                                    $counter++;
                                } else {
                                    break;
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-lg-5 col-xl-6">
                    <?php
                    if (!empty($upld_img)) {
                        ?>
                        <div class="image-holder"><img src="<?php echo esc_url_raw($upld_img); ?>" alt="image"></div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="circle-image"></div>
    </div>

    <?php
    return ob_get_clean();
}
add_shortcode('jc_banner_ten', 'jobcircle_banner_ten_frontend');