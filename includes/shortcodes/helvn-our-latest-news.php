<?php
function jobcircle_helvn_recent_news()
{
    vc_map(
        array(
            'name' => __('H-Eleven Our Latest News'),
            'base' => 'jc_helvn_recent_news',
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
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Tagline'),
                    'param_name' => 'tagline',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Order BY'),
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
        ),

    );
}
add_action('vc_before_init', 'jobcircle_helvn_recent_news');
// popular category frontend
function jobcircle_helvn_recent_news_frontend($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'title' => '',
            'tagline' => '',
            'orderby' => '',
            'numofpost' => '',
        ),
        $atts,
        'jobcircle_helvn_recent_news'
    );

    $title = isset($atts['title']) ? $atts['title'] : '';
    $tagline = isset($atts['tagline']) ? $atts['tagline'] : '';

    ob_start();
    ?>
    <section class="section section-theme-6 latest-news-block pt-30 pt-md-50 pt-lg-80 pb-15 pb-md-10">
        <div class="container">
            <!-- Section header -->
            <header class="section-header d-flex flex-column text-center mb-30 mb-lg-45">
                <?php if (!empty($title)) { ?>
                    <h2>
                        <?php echo esc_html($title) ?>
                    </h2>
                <?php } ?>
                <?php if (!empty($tagline)) { ?>
                    <p>
                        <?php echo jobcircle_esc_the_html($tagline) ?>
                    </p>
                <?php } ?>
            </header>
            <div class="row">
                <?php

                $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
                $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';

                $args = array(
                    'post_type' => 'post',
                    'post_status' => 'publish',
                    'posts_per_page' => $numofpost,
                    'order' => 'DESC',
                    'orderby' => $orderby,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'category',
                            'field' => 'slug',
                            'terms' => 'our-latest-news',
                        ),
                    )
                );

                // Custom query.
                $query = new WP_Query($args);
                // Check that we have query results.
                if ($query->have_posts()) {

                    // Start looping over the query results.
                    while ($query->have_posts()) {

                        $query->the_post();
                        $post = get_post();
                        $postid = $post->ID;
                        $title = get_the_title($postid);
                        $author = get_the_author();
                        $permalinkget = get_permalink($postid);
                        $content = get_the_content();
                        $image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');
                        $date = get_the_date();
                        $job_post = get_post($postid);
                             $post_author = $job_post->post_author;
                             $post_employer_id = jobcircle_user_employer_id($post_author);
                             if ($post_employer_id > 0 && get_post_type($post_employer_id) == 'employer') {
                    	     $post_author_name = get_the_title($post_employer_id);
                    	     $post_author_link = get_permalink($post_employer_id);
                    	 } else {
                    	     $author_user_obj = get_user_by('id', $post_author);
                    	     $post_author_name = $author_user_obj->display_name;
                    	     $post_author_link = get_author_posts_url($post_author);
                    	 }
                        $author_id = get_the_author_meta('url');
                        $author_profile_link = get_author_posts_url($author_id);
                        ?>
                        <div class="col-12 col-sm-6 col-lg-3">
                            <div class="news-post">
                               
                                        <?php if (!empty($image)){
                                            ?>
                                            <div class="image-holder">
                                                <a href="<?php echo esc_html($permalinkget) ?>"><img src="<?php echo esc_url_raw($image[0]) ?>" alt="image"></a>
                                            </div>
                                        <?php }
                                        if (!empty($date)){ ?>
                                            <time class="date" datetime="2023-12-02">
                                                <?php echo esc_html($date) ?>
                                            </time>
                                        <?php }
                                        if (!empty($title)){ ?>
                                            <h3><a href="<?php echo esc_html($permalinkget) ?>">
                                                <?php echo esc_html($title) ?>
                                                </a>
                                            </h3>
                                        <?php }
                                        if (!empty($post_author_name)){ ?>
                                            <span class="post-by">
                                                <?php echo esc_html_e('By', 'jobcircle-frame') ?> <strong><a href="<?php echo jobcircle_esc_the_html($post_author_link) ?>" class="jobcircle-auth"><?php echo esc_html($post_author_name) ?>
                                                    </a>
                                                </strong>
                                            </span>
                                        <?php } ?>
                                </div>
                        </div>
                        <?php
                    }
                    // Restore original post data.
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
        </section>

        <?php
        return ob_get_clean();
                }
}
add_shortcode('jc_helvn_recent_news', 'jobcircle_helvn_recent_news_frontend');