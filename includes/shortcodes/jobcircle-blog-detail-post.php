<?php
function jobcircle_detail_page_post()
{
    vc_map(
        array(
            'name' => __('Latest From Detail Post'),
            'base' => 'detail_page_post',
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
add_action('vc_before_init', 'jobcircle_detail_page_post');
// popular category frontend
function jobcircle_detail_page_post_frontend($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'title' => '',
            'orderby' => '',
            'numofpost' => '',
        ),
        $atts,
        'jobcircle_detail_page_post'
    );
    $title  = isset($atts['title']) ? $atts['title'] : '';
    ob_start()
?>
    <?php if (!empty($title)) { ?>
        <h4><?php echo esc_html($title) ?></h4>
    <?php
    } ?>
    <div class="gallery-slider post-styles">
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
                $posted = get_the_time('U');
                $minut =  human_time_diff($posted, current_time('U')) . "";
                $admin =  get_the_author();
                $image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');
        ?>
                <div class="slick-slide">
                    <article class="news-post">
                        <div class="image-holder">
                            <?php if (!empty($permalinkget) || !empty($image)) { ?>
                                <a href="<?php echo esc_html($permalinkget) ?>"><img src="<?php echo esc_url_raw($image[0]) ?>" width="470" height="315" alt="Image Description"></a>
                            <?php } ?>
                        </div>
                        <div class="textbox">
                            <?php if (!empty($permalinkget) || !empty($title)) { ?>
                                <h4 class="h5"><a href="<?php echo esc_html($permalinkget) ?>"><?php echo esc_html($title) ?></a></h4>
                            <?php } ?>
                            <?php if (!empty($excerpt)) { ?>
                                <p><?php echo esc_html($excerpt) ?></p>
                            <?php } ?>
                        </div>
                        <footer class="post-footer">
                            <ul class="post-meta">
                                <?php if (!empty($minut) || !empty($comment)) { ?>
                                    <li><i class="icon icon-calendar2"></i> <time class="text" datetime="2023-03-20"><?php echo esc_html($minut) ?></time></li>
                                    <li><i class="icon icon-message"></i> <span class="text"><?php echo esc_html($comment) ?> <?php esc_html_e('Comments', 'jobcircle_frame') ?></span></li>
                                <?php } ?>
                            </ul>
                        </footer>
                    </article>
                </div>
        <?php
            }
        }
        wp_reset_postdata();
        ?>
    </div>
<?php
    return ob_get_clean();
}
add_shortcode('detail_page_post', 'jobcircle_detail_page_post_frontend');
