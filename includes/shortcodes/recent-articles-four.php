<?php
function jobcircle_recent_article_home4()
{
    vc_map(
        array(
            'name' => __('Recent Articles 4'),
            'base' => 'recent_article_home4',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title'),
                    'param_name' => 'head',
                ),

                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Description'),
                    'param_name' => 'disc',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Image'),
                    'param_name' => 'mn_img',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Button'),
                    'param_name' => 'btn',
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
add_action('vc_before_init', 'jobcircle_recent_article_home4');

// popular category frontend
function jobcircle_recent_article_home4_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(
            'head' => '',
            'mn_img' => '',
            'disc' => '',
            'btn_url' => '',
            'btn' => '',
            'orderby' => '',
            'numofpost' => '',

        ),
        $atts,
        'jobcircle_recent_article_home4'
    );
    $head  = isset($atts['head']) ? $atts['head'] : '';
    $disc  = isset($atts['disc']) ? $atts['disc'] : '';
    $btn  = isset($atts['btn']) ? $atts['btn'] : '';
    $btn_url  = isset($atts['btn_url']) ? $atts['btn_url'] : '';

    $mn_img = isset($atts['mn_img']) ? $atts['mn_img'] : '';


    ob_start()
?>
     <section class="section pedings section-theme-4 recent-articles-block bg-white pt-0 pt-md-30 pt-lg-50 pb-35 pb-md-50 pb-lg-80 pb-xxl-120">
        <div class="container">
            <header class="section-header d-flex flex-column text-center mb-30 mb-lg-58">
                <?php
                if (!empty($head)) { ?>
                    <h2><?php echo esc_html($head) ?></h2>
                <?php } ?>
                <?php
                if (!empty($disc)) { ?>
                    <p><?php echo jobcircle_esc_the_html($disc) ?></p>
                <?php } ?>
                <?php
                if (!empty($mn_img)) { ?>
                    <img src="<?php echo esc_url_raw($mn_img) ?>" width="26" alt="icon">
                <?php } ?>
            </header>
            <div class="acticles-carousel">

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
                        $date = get_the_date('M,Y');
                        $tdate = get_the_date('d');
                        $author_id = get_the_author_meta('ID');
                        $author_avatar = get_avatar($author_id, 96); // 96 is the size of the avatar in pixels
                        $author_profile_link = get_author_posts_url($author_id);

                ?>

                        <div class="article-slide">
                            <div class="acticle">
                                <div class="image-holder">
                                    <?php if (!empty($permalinkget || $image)) {
                                    ?>
                                        <a href="<?php echo esc_html($permalinkget) ?>"><img src="<?php echo esc_url_raw($image[0]) ?>" alt="image"></a>
                                    <?php } ?>

                                </div>
                                <div class="text-frm">
                                    <div class="exp-counter">
                                        <div class="text">
                                            <?php
                                            if (!empty($tdate) || !empty($date)) { ?>
                                                <strong><?php echo esc_html($tdate) ?></strong><?php echo esc_html($date) ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php
                                    if (!empty($permalinkget) || !empty($title)) { ?>
                                        <h3><a href="<?php echo esc_html($permalinkget) ?>"><?php echo esc_html($title) ?></a></h3>
                                    <?php } ?>
                                    <?php
                                    if (!empty($excerpt)) { ?>
                                        <p><?php echo jobcircle_esc_the_html($excerpt) ?></p>
                                    <?php } ?>
                                    <ul class="list-inline meta-list m-0">
                                        <li>
                                            <?php
                                            if (!empty($author_profile_link)) { ?>
                                                <a href="<?php echo esc_html($author_profile_link) ?>">
                                                <?php } ?>

                                                <?php if (!empty($author_avatar)) {
                                                ?>
                                                    <div class="icon">
                                                        <?php echo ($author_avatar) ?>
                                                    </div>
                                                <?php } ?>

                                                <?php
                                                if (!empty($admin)) { ?>
                                                <?php echo esc_html('By' , 'jobcircle-frame') ?> <?php echo esc_html($admin) ?>
                                                <?php } ?>
                                                </a>
                                        </li>
                                        <li>
                                            <?php if (!empty($permalinkget)) {
                                            ?>
                                                <a href="<?php echo esc_html($permalinkget) ?>">
                                                    <i class="jobcircle-icon-comments"></i>
                                                    <?php echo esc_html($comment) ?> <?php esc_html_e('Comments', 'jobcircle-frame') ?>
                                                </a>
                                            <?php } ?>
                                        </li>
                                    </ul>
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
            <div class="row">
                <div class="col-12 d-flex justify-content-center pt-lg-60">
                    <?php if (!empty($btn_url || $btn)) {
                    ?>
                        <a href="<?php echo esc_html($btn_url) ?>"><button class="btn btn-purple"><span><?php echo esc_html($btn) ?></span></button></a>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
<?php

    return ob_get_clean();
}
add_shortcode('recent_article_home4', 'jobcircle_recent_article_home4_frontend');
