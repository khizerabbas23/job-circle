<?php
function recent_article_news_nnn()
{
    vc_map(
        array(
            'name' => __('Recent News Articles'),
            'base' => 'recent_article_news_nnn',
            'category' => __('job Circle'),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('TItle'),
                    'param_name' => 'title',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Sub Title'),
                    'param_name' => 'sub_title',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Icon Hold  Image'),
                    'param_name' => 'ihm_img',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Button Name'),
                    'param_name' => 'btn_name',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Button Url'),
                    'param_name' => 'btn_url',
                ),
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
add_action('vc_before_init', 'recent_article_news_nnn');
// popular category frontend
function recent_article_news_nnn_frontend($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'title' => '',
            'sub_title' => '',
            'btn_name' => '',
            'ihm_img' => '',
            'btn_url' => '',
            'orderby' => '',
            'numofpost' => '',
        ),
        $atts,
        'recent_article_news_nnn'
    );
    $title  = isset($atts['title']) ? $atts['title'] : '';
    $sub_title  = isset($atts['sub_title']) ? $atts['sub_title'] : '';
    $btn_name  = isset($atts['btn_name']) ? $atts['btn_name'] : '';
    $btn_url  = isset($atts['btn_url']) ? $atts['btn_url'] : '';
    $ihm_img  = isset($atts['ihm_img']) ? $atts['ihm_img'] : '';
    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
    $output = '';
    ob_start();
?>
    
        <section class="section section-theme-14 jobs_waiting recent_atical-pt" style="background-image: url('<?php echo esc_html($ihm_img) ?>');">
      <div class="container">
        <div class="recent_articles">
            <!-- Section header -->
            <header class="section-header d-flex flex-column text-center mb-15 mb-md-30 mb-xl-40">
                <?php if (!empty($sub_title)) { ?>
                    <p><?php echo esc_html($sub_title); ?></p>
                <?php } ?>
                <?php if (!empty($title)) { ?>
                    <h2><span class="text-outlined"><?php echo esc_html($title); ?></span></h2>
                <?php } ?>
            </header>
            <?php
            $numofpost  = isset($atts['numofpost']) ? $atts['numofpost'] : '';
            $orderby  = isset($atts['orderby']) ? $atts['orderby'] : '';
            $args = array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => $numofpost,
                'order' => 'DESC',
                'orderby' =>  $orderby,
                'tax_query' => array(
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'category',
                            'field'    => 'slug',
                            'terms'    => 'blog-post',
                        ),
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
                    global $post;
                    $post =  get_the_id();
                    $comments_number = get_comments_number($post);
                    $title = get_the_title($post);
                    $excerpt = get_the_excerpt($post);
                    $permalinkget = get_the_permalink($post);
                    $posted = get_the_time('U');
                    $minut =  human_time_diff($posted, current_time('U')) . "";
                    $image = wp_get_attachment_image_src(get_post_thumbnail_id($post), 'single-post-thumbnail');
                    $job_post = get_post($post);
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
                    $day = date("d");
                    $month = date("M");
                    $year = date("Y");
            ?>
                    <div class="article_info_row">
                        <div class="article_holder">
                            <div class="article_info">
                                <?php if (!empty($permalinkget)) { ?>
                                    <a class="forward" href="<?php echo esc_html($permalinkget); ?>"><i class="jobcircle-icon-chevron-right icon"></i></a>
                                <?php } ?>
                                <div class="image-holder">
                                    <div class="date-holder">
                                        <?php if (!empty($day) || !empty($month) ||  !empty($year)) { ?>
                                            <span class="date">
                                                <span class="day"><?php echo jobcircle_esc_the_html($day); ?></span>
                                                <span class="month"><?php echo jobcircle_esc_the_html($month); ?>, <?php echo jobcircle_esc_the_html($year); ?></span>
                                            </span>
                                        <?php } ?>
                                    </div>
                                    <?php if (!empty($image)) { ?>
                                        <a class="" href="<?php echo esc_html($permalinkget) ?>">
                                            <img src="<?php echo esc_url_raw($image[0]); ?>" alt="img">
                                        </a>
                                    <?php } ?>
                                </div>
                                <div class="text-holder">
                                    <?php if (!empty($title)) { ?>
                                        <a class="" href="<?php echo esc_html($permalinkget) ?>">
                                            <strong class="title"><?php echo esc_html($title); ?></strong>
                                        </a>
                                    <?php } ?>
                                    <?php if (!empty($excerpt)) { ?>
                                        <p><?php echo esc_html($excerpt); ?></p>
                                    <?php } ?>
                                    <div class="d-md-flex align-items-center">
                                        <?php if (!empty($post_author_link) || !empty($post_author_name)) { ?>
                                            <strong class="by"><?php echo esc_html_e('By', 'jobcircle-frame') ?> <a href="<?php echo esc_html($post_author_link); ?>"><?php echo esc_html($post_author_name); ?></a></strong>
                                        <?php } ?>
                                        <strong class="comments"><?php echo esc_html($comments_number); ?> <?php esc_html_e('Comments', 'jobcircle-frame'); ?></strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            // Restore original post data.      
            wp_reset_postdata();
            ?>
            <div class="d-flex justify-content-center">
                <?php if (!empty($btn_url) && !empty($btn_name)) { ?>
                    <a class="btn btn-green btn-sm" href="<?php echo esc_html($btn_url); ?>"><span class="btn-text"><?php echo esc_html($btn_name); ?></span></a>
                <?php } ?>
            </div>
        </div>
        </div>
        </section>
    <?php
    return ob_get_clean();
}
add_shortcode('recent_article_news_nnn', 'recent_article_news_nnn_frontend');
