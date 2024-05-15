<?php
function jobcircle_blog_styleone()
{
    vc_map(
        array(
            'name' => __('Blog Style 1'),
            'base' => 'jobcircle_blog_styleone',
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
add_action('vc_before_init', 'jobcircle_blog_styleone');
// popular category frontend
function jobcircle_blog_styleone_frontend($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'orderby' => '',
            'numofpost' => '',
        ),
        $atts,
        'jobcircle_blog_styleone'
    );
    $head  = isset($atts['head']) ? $atts['head'] : '';
    $sb_head  = isset($atts['sb_head']) ? $atts['sb_head'] : '';
    $disc  = isset($atts['disc']) ? $atts['disc'] : '';
    ob_start()
?>
    <section class="section latest-news-block section-theme-1 pt-35 pt-md-50 pt-lg-75 pt-xl-100 pt-xxl-120 pb-35">
        <div class="container">
            <div class="row">
                <?php
                $numofpost  = isset($atts['numofpost']) ? $atts['numofpost'] : '';
                $orderby  = isset($atts['orderby']) ? $atts['orderby'] : '';
                //this one
                $page_numbr = get_query_var('paged');
                $args = array(
                    'post_type' => 'post',
                    'post_status' => 'publish',
                    'posts_per_page' => $numofpost,
                    'order' => 'DESC',
                    'paged' => $page_numbr,
                    'orderby' =>  $orderby,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'category',
                            'field'    => 'slug',
                            'terms'    => 'blog-post',
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
                        $post =  get_post();
                        $postid =  $post->ID;
                        $title = get_the_title($postid);
                        $excerpt = get_the_excerpt($postid);
                        $comment = get_comments_number($postid);
                        $permalinkget = get_permalink($postid);
                        $posted = get_the_date();
                        $admin =  get_the_author();
                        $author_id = get_the_author_meta('ID');
                        $author_avatar = get_avatar($author_id, 96);
                        $image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');
                ?>
                        <div class="col-12 col-md-6 col-lg-4 mb-35 mb-md-55">
                            <!-- News Post -->
                            <div class="news-post">
                                <a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>">
                                    <div class="image-holder">
                                        <?php if (!empty($image)) { ?>
                                            <img src="<?php echo esc_url_raw($image[0]) ?>" alt="image">
                                        <?php } ?>
                                    </div>
                                    <div class="textbox">
                                        <?php if (!empty($excerpt)) { ?>
                                            <strong class="subtitle"><?php echo esc_html($excerpt) ?></strong>
                                        <?php } ?>
                                        <?php if (!empty($title)) { ?>
                                            <h3><?php echo jobcircle_esc_the_html($title) ?></h3>
                                        <?php } ?>
                                        <ul class="post-meta">
                                            <?php if (!empty($posted) || !empty($comment)) { ?>
                                                <li><?php echo esc_html($posted) ?></li>
                                                <li><?php echo esc_html($comment) ?><?php esc_html_e(' Comments', 'jobcircle-frame') ?></li>
                                            <?php } ?>
                                        </ul>
                                        <div class="post-author">
                                            <?php if (!empty($author_avatar)) { ?>
                                                <span class="author-image"><?php echo esc_url_raw($author_avatar); ?></span>
                                            <?php } ?>
                                            <?php if (!empty($admin)) { ?>
                                                <span class="post-by"><?php esc_html_e('By  ', 'jobcircle-frame') ?> <strong><?php echo esc_html($admin) ?></strong></span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php
                    }
                }
                //also this one        
                if ($total_posts > $numofpost) {
                    ?>
                    <?php echo jobcircle_pagination($query, true); ?>
                <?php
                }
                wp_reset_postdata();
                ?>
            </div>
        </div>
    </section>
<?php
    return ob_get_clean();
}
add_shortcode('jobcircle_blog_styleone', 'jobcircle_blog_styleone_frontend');
