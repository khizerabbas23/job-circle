<?php
function jobcircle_company_styles()
{
    vc_map(
        array(
            'name' => __('Company'),
            'base' => 'jobcircle_company_styles',
            'category' => __('Job Circle'),
            'params' => array(
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
            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_company_styles');
// popular category frontend
function jobcircle_company_styles_frontend($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'orderby' => '',
            'numofpost' => '',
        ),
        $atts,
        'jobcircle_company_styles'
    );
    $orderby  = isset($atts['orderby']) ? $atts['orderby'] : '';
    $numofpost  = isset($atts['numofpost']) ? $atts['numofpost'] : '';
    ob_start(); ?>
    <!-- Featured Jobs Section -->
    <section class="section section-categories section-theme-1 pt-35 pt-md-50 pt-lg-75 pt-xl-95 pb-35 pb-md-50 pb-xl-75">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Page subheader -->
                    <header class="page-subheader mb-30 mb-md-40 d-lg-flex align-items-center justify-content-between">
                        <?php
						$posts = get_posts([
							'post_type' => 'employer',
							'post_status' => 'publish',
							'numberposts' => -1
						]);
						$job_count = count($posts);
						?>
                        <h3 class="h6 mb-25 mb-lg-0"><?php esc_html_e('All ', 'jobcircle-frame'); ?> <?php echo esc_html($job_count); ?> <?php esc_html_e('jobs found', 'jobcircle-frame'); ?></h3>
                        <div class="subhead-filters">
                            <div class="subhead-filters-item">
                                <label><?php esc_html_e('Sort By', 'jobcircle-frame') ?></label>
                                <div class="form-group d-lg-flex align-items-center">
                                    <select class="select2" name="state" data-placeholder="<?php esc_html_e('Sort by', 'jobcircle-frame') ?>">
                                        <option label="Sort by"></option>
                                        <option><?php esc_html_e('Newest Jobs', 'jobcircle-frame') ?></option>
                                        <option><?php esc_html_e('Old Jobs', 'jobcircle-frame') ?></option>
                                        <option><?php esc_html_e('Sort by Date', 'jobcircle-frame'); ?></option>
                                        <option><?php esc_html_e('Sort by Name', 'jobcircle-frame'); ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-buttons">
                                <button class="btn btn-list" type="button">
                                    <img src="images/list-icon.svg" width="20" height="20" alt="List">
                                </button>
                                <button class="btn btn-grid active" type="button">
                                    <img src="images/grid-icon.svg" width="22" height="22" alt="Grid">
                                </button>
                            </div>
                        </div>
                    </header>
                    <div class="row justify-content-center">
                        <?php
                        $args = array(
                            'post_type' => 'employer',
                            'post_status' => 'publish',
                            'posts_per_page' => $numofpost,
                            'order' => 'DESC',
                            'orderby' => $orderby,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'employer_cat',
                                    'field'    => 'slug',
                                    'terms'    => 'grid-company',
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
                                $post_id =  get_the_id();
                                $post_author = get_post_field('post_author', $post_id);
                                $title = get_the_title($post_id);
                                $permalinkget = get_the_permalink($post_id);
                                $image = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'single-post-thumbnail');
                                $location = get_post_meta($post_id, 'location', true);
                        ?>
                                <div class="col-12 col-md-6 col-lg-4 mb-15 mb-md-30">
                                    <!-- Featured Category Box -->
                                    <a href="<?php echo get_the_permalink($post_id); ?>" class="featured-category-box alt2">
                                        <div class="wrap">
                                            <div class="img-holder">
                                                <?php if (!empty($image)) { ?>
                                                    <img src="<?php echo esc_url_raw($image[0]); ?>" alt="<?php echo esc_attr($title); ?>">
                                                <?php } ?>
                                            </div>
                                            <div class="textbox">
                                                <?php if (!empty($title)) { ?>
                                                    <strong class="h6"><?php echo esc_html($title); ?></strong>
                                                <?php } ?>
                                                <?php if (!empty($location)) { ?>
                                                    <address class="location"><i class="jobcircle-icon-map-pin icon"></i><span class="text"><?php echo esc_html($location); ?></span></address>
                                                <?php } ?>
                                                <div class="tag-wrap">
                                                    <span class="tag"><?php esc_html_e('Open Job - 2', 'jobcircle-frame'); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                        <?php
                            }
                        }
                        // Restore original post data.
                        if ($total_posts > $numofpost) {
                            echo jobcircle_pagination($query, true);
                        }
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
    echo $output = ob_get_clean();
    return $output;
}
add_shortcode('jobcircle_company_styles', 'jobcircle_company_styles_frontend');
?>