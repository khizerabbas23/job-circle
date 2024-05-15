<?php

add_action('jobcircle_listing_filters_meta_query', 'jobcircle_listing_custom_fields_meta_query', 10, 2);

function jobcircle_listing_custom_fields_meta_query($meta_query, $post_type = 'jobs')
{
    global $wpdb;
    $query = "SELECT ID FROM {$wpdb->posts} AS posts";
    $query .= " LEFT JOIN {$wpdb->postmeta} AS postmeta ON posts.ID=postmeta.post_id";
    $query .= " WHERE post_type = 'cstmfield'";
    $query .= " AND postmeta.meta_key='cstmfield_rules' AND postmeta.meta_value LIKE '%\"$post_type\"%'";
    $query .= " group by posts.ID limit 1";

    $results = $wpdb->get_row($query);

    if (!empty($results) && isset($results->ID)) {
        $fields_id = $results->ID;
        $custom_fields = get_post_meta($fields_id, 'cstmfield_fields', true);
        if (!empty($custom_fields)) {
            foreach ($custom_fields as $custom_field) {
                $field_type = isset($custom_field['type']) ? $custom_field['type'] : '';
                if (isset($custom_field['name']) && $custom_field['name'] != '' && isset($_REQUEST[$custom_field['name']])) {
                    $field_name = $custom_field['name'];
                    if ($field_type == 'select') {
                        $comapre = isset($custom_field['options']['multiple']) && $custom_field['options']['multiple'] == '1' ? 'LIKE' : '=';
                        $meta_query[] = array(
                            'key' => $field_name,
                            'value' => $_REQUEST[$custom_field['name']],
                            'compare' => $comapre,
                        );
                    }
                }
            }
        }
    }

    return $meta_query;
}

add_action('jobcircle_job_listing_filters_bfr_subtn', 'jobcircle_job_listing_filters_custom_fileds', 10, 2);

function jobcircle_job_listing_filters_custom_fileds($html, $view = 'view1')
{
    global $wpdb;
    $query = "SELECT ID FROM {$wpdb->posts} AS posts";
    $query .= " LEFT JOIN {$wpdb->postmeta} AS postmeta ON posts.ID=postmeta.post_id";
    $query .= " WHERE post_type = 'cstmfield'";
    $query .= " AND postmeta.meta_key='cstmfield_rules' AND postmeta.meta_value LIKE '%\"jobs\"%'";
    $query .= " group by posts.ID limit 1";

    $results = $wpdb->get_row($query);

    if (!empty($results) && isset($results->ID)) {
        ob_start();
        $fields_id = $results->ID;
        $custom_fields = get_post_meta($fields_id, 'cstmfield_fields', true);
        if (!empty($custom_fields)) {
            foreach ($custom_fields as $custom_field) {
                //var_dump($custom_field);
                $field_type = isset($custom_field['type']) ? $custom_field['type'] : '';
                if ($field_type == 'select' && isset($custom_field['options']['choices']) && !empty($custom_field['options']['choices'])) {
                    $options_list = $custom_field['options']['choices'];
                    $field_name = $custom_field['name'];
                    $selected_val = isset($_REQUEST[$field_name]) ? $_REQUEST[$field_name] : '';
?>
                    <div class="filter-box">
                        <h2 class="h5"><?php echo ($custom_field['label']) ?></h2>
                        <div class="form-group">
                            <div class="checkbox-limit">
                                <ul class="checkbox-list">
                                    <?php
                                    foreach ($options_list as $choice_key => $choice_val) {
                                        $rand_num = rand(1000000, 9999999);
                                        if ($choice_key == '' || $choice_key == '0') {
                                            continue;
                                        }
                                    ?>
                                        <li>
                                            <label for="itm-<?php echo ($rand_num) ?>" class="custom-checkbox">
                                                <input id="itm-<?php echo ($rand_num) ?>" name="<?php echo ($field_name) ?>" value="<?php echo ($choice_val) ?>" type="radio" <?php echo ($selected_val == $choice_val ? ' checked' : '') ?>>
                                                <span class="fake-checkbox"></span>
                                                <span class="label-text">
                                                    <?php echo ($choice_val) ?>
                                                </span>
                                            </label>
                                        </li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
    <?php
                }
            }
        }
        $html .= ob_get_clean();
    }

    return $html;
}

function jobcircle_listing_jobs_query_args($atts)
{
    $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
    $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
    $page_numbr = get_query_var('paged');
    $order = 'DESC';
    if (isset($_GET['sortby']) && $_GET['sortby'] == 'asc') {
        $orderby = 'title';
        $order = 'ASC';
    }
    $args = array(
        'post_type' => 'jobs', //enter post type name static
        'post_status' => 'publish',
        'posts_per_page' => $numofpost,
        'order' => $order,
        'paged' => $page_numbr,
        'orderby' =>  $orderby,
    );
    if (isset($_REQUEST['keyword'])) {
        $keyword = $_REQUEST['keyword'];
        $args['s'] = esc_html($keyword);
    }
    // tax query
    $tax_query = array();
    if (isset($_REQUEST['job_category'])) {
        $job_category = $_REQUEST['job_category'];
        $tax_query[] = array(
            'taxonomy' => 'job_category',
            'field' => 'slug',
            'terms' => $job_category,
        );
    }
    $min_salary = isset($_REQUEST['min_salary']) ? preg_replace("/[^0-9]/", '', $_REQUEST['min_salary']) : '';
    $max_salary = isset($_REQUEST['max_salary']) ? preg_replace("/[^0-9]/", '', $_REQUEST['max_salary']) : '';
    $meta_query = array();
    if (isset($_REQUEST['location']) && $_REQUEST['location'] != '') {
        $location = $_REQUEST['location'];
        $meta_query[] = array(
            'relation' => 'OR',
            array(
                'key' => 'jobcircle_field_loc_city',
                'value' => esc_html($location),
            ),
            array(
                'key' => 'jobcircle_field_loc_country',
                'value' => esc_html($location),
            ),
            array(
                'key' => 'jobcircle_field_loc_address',
                'value' => esc_html($location),
                'compare' => 'LIKE'
            ),
        );
    }
    if (isset($_REQUEST['job_type']) && $_REQUEST['job_type'] != '') {
        $job_type = $_REQUEST['job_type'];
        $meta_query[] = array(
            'key' => 'jobcircle_field_job_type',
            'value' => esc_html($job_type),
        );
    }
    if ($min_salary >= 0 && $max_salary > 0) {
        $meta_query[] = array(
            'key' => 'jobcircle_field_min_salary',
            'value' => array($min_salary, $max_salary),
            'type' => 'numeric',
            'compare' => 'BETWEEN',
        );
    }
    $meta_query = apply_filters('jobcircle_listing_filters_meta_query', $meta_query, 'jobs');
    if (!empty($tax_query)) {
        $args['tax_query'] = $tax_query;
    }
    if (!empty($meta_query)) {
        $args['meta_query'] = $meta_query;
    }

    return $args;
}

function jobcircle_job_listing_filters_sidebar($atts, $view = 'view1')
{
    $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
    $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
    ?>
    <aside class="filters-sidebar">
        <div class="filters-sidebar-Head">
            <strong class="title"><?php esc_html_e('Filter By', 'jobcircle-frame') ?></strong>
            <a href="#" class="btn-clear"><i class="jobcircle-icon-plus"></i></a>
        </div>
        <form method="post" class="jobcircle-jobfilter-form">
            <!-- Filter Box -->
            <div class="filter-box">
                <h2 class="h5"><?php esc_html_e('Search', 'jobcircle-frame') ?></h2>
                <div class="form-group search-field">
                    <input class="form-control" name="keyword" placeholder="<?php esc_html_e('Search with keyword', 'jobcircle-frame') ?>" type="text">
                    <button class="button-search"><i class="jobcircle-icon-search icon"></i></button>
                </div>
            </div>
            <div class="filter-box">
                <h2 class="h5"><?php esc_html_e('Location', 'jobcircle-frame') ?></h2>
                <div class="form-group search-field">
                    <input class="form-control jobcircle-location-input-field" name="location" placeholder="<?php esc_html_e('Enter any location', 'jobcircle-frame') ?>" type="text">
                </div>
            </div>
            <div class="filter-box">
                <a class="filter-box-head" data-bs-toggle="collapse" href="#collapseCategory">
                    <h2 class="h5"><?php esc_html_e('Category', 'jobcircle-frame') ?></h2>
                    <span class="collapse-icon"></span>
                </a>
                <div class="collapse show" id="collapseCategory">
                    <div class="form-group">
                        <div class="checkbox-limit">
                            <ul class="checkbox-list">
                                <?php
                                $cat_terms = get_terms(
                                    array(
                                        'taxonomy' => 'job_category',
                                    )
                                );
                                if (!empty($cat_terms)) {
                                    foreach ($cat_terms as $cat_term) {
                                    ?>
                                        <li>
                                            <label class="custom-checkbox">
                                                <input id="cat-<?php echo esc_html($cat_term->term_id) ?>" name="job_category" value="<?php echo esc_html($cat_term->slug) ?>" type="checkbox">
                                                <span class="fake-checkbox"></span>
                                                <span class="label-text">
                                                    <?php echo esc_attr($cat_term->name) ?>
                                                </span>
                                            </label>
                                        </li>
                                <?php
                                    };
                                }
                                ?>
                            </ul>
                            <a href="#" class="btn btn-sm buttonShowMore">
                                <span class="btn-text"><?php esc_html_e('Show', 'jobcircle-frame') ?>
                                    <span class="show"><?php esc_html_e('More', 'jobcircle-frame') ?></span>
                                    <span class="hide"><?php esc_html_e('Less', 'jobcircle-frame') ?></span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="filter-box">
                <a class="filter-box-head" data-bs-toggle="collapse" href="#collapseType">
                    <h2 class="h5"><?php esc_html_e('Job Type', 'jobcircle-frame') ?></h2>
                    <span class="collapse-icon"></span>
                </a>
                <div class="collapse show" id="collapseType">
                    <div class="form-group">
                        <div class="checkbox-limit">
                            <ul class="checkbox-list">
                                <?php
                                $job_types_lists = jobcircle_job_types_list();
                                if (!empty($job_types_lists)) {
                                    foreach ($job_types_lists as $job_type_key => $job_types_list) {
                                ?>
                                        <li>
                                            <label class="custom-checkbox">
                                                <input type="checkbox" name="job_type" value="<?php echo esc_html($job_type_key); ?>">
                                                <span class="fake-checkbox"></span>
                                                <span class="label-text"><?php echo esc_html($job_types_list['title']); ?></span>
                                            </label>
                                        </li>
                                <?php
                                    };
                                } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Filter Box -->
            <div class="filter-box">
                <a class="filter-box-head" data-bs-toggle="collapse" href="#collapseSalary">
                    <h2 class="h5"><?php esc_html_e('Salary', 'jobcircle-frame') ?></h2>
                    <span class="collapse-icon"></span>
                </a>
                <div class="collapse show" id="collapseSalary">
                    <div class="form-group">
                        <div class="price-inputs">
                            <input type="text" id="amount-start" name="min_salary" class="form-control" readonly placeholder="Form" value="">
                            -
                            <input type="text" id="amount-end" name="max_salary" class="form-control" readonly placeholder="To" value="">
                        </div>
                        <div class="range-box">
                            <div id="slider-range"></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $view = isset($_REQUEST['view']) ? $_REQUEST['view'] : '';   ?>
            <!-- Filter Buttons -->
            <div class="filter-buttons">
                <input type="hidden" name="numposts" value="<?php echo esc_html($numofpost); ?>">
                <input type="hidden" name="orderby" value="<?php echo esc_html($orderby); ?>">
                <input type="hidden" name="view" value="<?php echo esc_html($view); ?>">
                <input type="hidden" name="action" value="<?php echo esc_html($atts['listin_ajax_action']) ?>"><button type="submit" class="btn btn-green btn-sm"><span class="btn-text submit-filters-button"><?php esc_html_e('Apply Filter', 'jobcircle-frame') ?></span></button>
            </div>
        </form>
    </aside>
<?php
}
