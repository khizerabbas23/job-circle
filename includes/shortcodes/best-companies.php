<?php
function jobcircle_best_companies()
{
    vc_map(
        array(
            'name' => __('Best Companies'),
            'base' => 'jc_best_companies',
            'category' => __('Job Circle'),
            'params' => array(
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
                    'heading' => __('Span Title'),
                    'param_name' => 'span_tit',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Description'),
                    'param_name' => 'disc',
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
            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_best_companies');
// Frontend Coding 
function jobcircle_best_companies_frontend($atts, $content)
{
    $atts = shortcode_atts(
        array(

            'title' => '',
            'span_tit' => '',
            'disc' => '',
            'orderby' => '',
            'numofpost' => '',

        ), $atts, 'jobcircle_best_companies'
    );
    $title = isset($atts['title']) ? $atts['title'] : '';
    $span_tit = isset($atts['span_tit']) ? $atts['span_tit'] : '';
    $disc = isset($atts['disc']) ? $atts['disc'] : '';
    $custom_plan_price = isset($atts['nb_Circletitle']) && !empty($atts['nb_Circletitle']) ? $atts['nb_Circletitle'] : '';
    ob_start();
    ?>
    <section class="section section-theme-2 companies-block pt-35 pt-md-50 pt-lg-65 pt-xl-85 pt-xxl-120 pb-35 pb-md-50 pb-lg-65 pb-xl-105 pb-xxl-150">
        <div class="container">
            <div class="row justify-content-between mb-25 mb-lg-30">
                <div class="col-12 col-lg-8">
                    <!-- Section header -->
                    <header class="section-header text-center text-lg-start mb-0">
                        <?php if (!empty($title || $span_tit)) {
                            ?>
                            <h2>
                                <?php echo jobcircle_esc_the_html($title) ?><span class="text-outlined">
                                    <?php echo jobcircle_esc_the_html($span_tit) ?>
                                </span>
                            </h2>
                            <?php
                        }
                        ?>
                        <?php if (!empty($disc)) {
                            ?>
                            <p>
                                <?php echo esc_textarea($disc) ?>
                            </p>
                            <?php
                        }
                        ?>
                    </header>
                </div>
            </div>
            <div class="companies-slider">

                <?php
                $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
                $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';


                $args = array(
                    'post_type' => 'employer',
                    'post_status' => 'publish',
                    'posts_per_page' => $numofpost,
                    'order' => 'DESC',
                    'orderby' => $orderby,

                );
                // Custom query.
                $query = new WP_Query($args);

                // Check that we have query results.
                if ($query->have_posts()) {

                    // Start looping over the query results.
                    while ($query->have_posts()) {
                        $query->the_post();
                        global $post;
                        $post_author = $post->post_author;
                        $post = get_the_id();
                        $title = get_the_title($post);
                        $excerpt = get_the_excerpt();
                        $permalinkget = get_the_permalink($post);
                        $image = wp_get_attachment_image_src(get_post_thumbnail_id($post), 'single-post-thumbnail');

                        $args = array(
                            'author' => $post_author,
                            'post_type' => 'employer',
                            'post_status' => 'publish',
                            'posts_per_page' => -1
                        );

                        $author_query = new WP_Query($args);
                        $author_post_count = $author_query->post_count;
                        ?>
                        <div class="slick-slide">
                            <article class="featured-category-box">
                                <?php
                                if (!empty($author_post_count)) {
                                    ?>
                                    <span class="tag">
                                        <?php echo jobcircle_esc_the_html($author_post_count) ?>
                                        <?php echo esc_html_e('Jobs', 'jobcircle-frame') ?>
                                    </span>
                                    <?php
                                }
                                ?>
                                <div class="img-holder">
                                    <?php
                                    if (!empty($permalinkget) || !empty($image[0])) {
                                        ?>
                                        <a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>"><img src="<?php echo esc_url_raw($image[0]) ?>" alt="Javascript Developer"></a>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="textbox">
                                    <?php if (!empty($permalinkget) || !empty($title)) {
                                        ?>
                                        <a href="<?php echo jobcircle_esc_the_html($permalinkget); ?>"><strong class="h6">
                                                <?php echo jobcircle_esc_the_html($title); ?>
                                            </strong></a>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if (!empty($excerpt)) {
                                        ?>
                                        <p>
                                            <?php echo jobcircle_esc_the_html($excerpt); ?>
                                        </p>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </article>
                        </div>
                    <?php
                    }
                }
                ?>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('jc_best_companies', 'jobcircle_best_companies_frontend');