<?php
function htwlv_recent_articles()
{
    vc_map(
        array(
            'name' => __('Recent Articles 12'),
            'base' => 'htwlv_recent_articles',
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
                    'heading' => __('Heading'),
                    'param_name' => 'heading',
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
add_action('vc_before_init', 'htwlv_recent_articles');

// popular category frontend
function htwlv_recent_articles_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(
            'title' => '',
            'heading' => '',
            'btn_url' => '',

            'orderby' => '',
            'numofpost' => '',

        ), $atts, 'htwlv_recent_articles');

    $title = isset($atts['title']) ? $atts['title'] : '';
    $heading = isset($atts['heading']) ? $atts['heading'] : '';
    $btn_url = isset($atts['btn_url']) ? $atts['btn_url'] : '';


    ob_start()
        ?>
    <section class="recent_articles_block section-theme-11">
        <div class="container">
            <header class="section-header d-flex flex-column text-center mb-30 mb-md-45 mb-xl-25">
                <?php
                if (!empty($title)) {
                    ?>

                    <p>
                        <?php echo esc_html($title) ?>
                    </p>
                    <?php
                }
                if (!empty($heading)) {
                    ?>
                    <h2 class="help_question_heading">
                        <?php echo esc_html($heading) ?>
                    </h2>
                    <?php
                }
                ?>
            </header>
            <div class="row mb-50">

                <?php
                $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
                $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
                //this one
                $page_numbr = get_query_var('paged');
                $args = array(
                    'post_type' => 'post',
                    'post_status' => 'publish',
                    'posts_per_page' => $numofpost,
                    'order' => 'DESC',
                    'paged' => $page_numbr,

                    'orderby' => $orderby,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'category',
                            'field' => 'slug',
                            'terms' => 'blog-post',
                        ),
                    ),
                );

                // Custom query.// also this one 
                $query = new WP_Query($args);
                $total_posts = $query->found_posts;

                // Check that we have query results.
                if ($query->have_posts()) {

                    // Start looping over the query results.
                    while ($query->have_posts()) {
                        $query->the_post();
                        global $post;
                        $post = get_post();
                        $postid = $post->ID;
                        $title = get_the_title($postid);
                        $excerpt = get_the_excerpt($postid);
                        $permalinkget = get_permalink($postid);
                        $image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');
                        $date = get_the_date('M,d, Y');
                        $comment = get_comments_number($postid);

                        ?>
                        <div class="col-12 col-md-6 col-lg-4 mb-30 mb-lg-0">
                            <div class="recent_article">
                                <div class="img_holder">
                                    <?php if (!empty($permalinkget) && !empty($image)) {
                                        ?>
                                        <a href="<?php echo esc_html($permalinkget) ?>">
                                            <img src="<?php echo esc_url_raw($image[0]) ?>" alt="img">
                                        </a>
                                    <?php } ?>
                                </div>
                                <div class="text_holder">
                                    <ul class="list-inline tags-items">
                                        <li>
                                            <time class="date" datetime="2024-12-25">
                                                <span class="fa fa-calendar"></span>
                                                <?php if (!empty($date)) {
                                                    ?>
                                                    <?php echo esc_html($date) ?>
                                                <?php } ?>
                                            </time>
                                        </li>
                                        <li>
                                            <a href=" <?php echo esc_html($permalinkget) ?>" class="commints">
                                                <span class="fa fa-comment-dots"></span>
                                                <?php if (!empty($comment)) {
                                                    ?>
                                                    <?php echo esc_html($comment) ?>
                                                <?php } ?>
                                            </a>
                                        </li>
                                    </ul>
                                    <?php if (!empty($permalinkget) || !empty($title)) {
                                        ?>
                                        <a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>">
                                            <strong class="h5 help_question_heading">
                                                <?php echo esc_html($title) ?>
                                            </strong>
                                        </a>
                                    <?php }
                                    if (!empty($excerpt)) {
                                        ?>
                                        <p>
                                            <?php echo esc_html($excerpt) ?>
                                        </p>
                                    <?php }
                                    if (!empty($permalinkget)) { ?>
                                        <a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>" class="read-more">
                                            <?php echo esc_html_e('Read More', 'jobcircle-frame') ?> <svg
                                                xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                                                <path
                                                    d="M438.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L338.8 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l306.7 0L233.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160z" />
                                            </svg>
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                //also this one         
                wp_reset_postdata();
                ?>
            </div>
            <div class="btn_wrap d-flex justify-content-center">
                <?php if (!empty($btn_url)) {
                    ?>
                    <a href="<?php echo esc_html($btn_url) ?>" class="btn btn-dark-yellow btn-sm"><span class="btn-text">
                            <?php echo esc_html_e('View All News', 'jobcircle-frame') ?>
                        </span></a>
                <?php } ?>
            </div>
        </div>
    </section>
    
    <?php
    return ob_get_clean();
}
add_shortcode('htwlv_recent_articles', 'htwlv_recent_articles_frontend');