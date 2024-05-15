<?php
function jobcircle_dream_blog_sidebar()
{
    $terms = get_terms(
		array(
			'taxonomy' => 'category',
			'hide_empty' => true,
		)
	);
	$job_types = array();
	foreach ($terms as $term) {
		$job_types[$term->name] = $term->term_id;
	}
	;
    vc_map(
        array(
            'name' => __('Dream BLog Sidebar'),
            'base' => 'jobcircle_dream_blog_sidebar',
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
        		  'type' => 'dropdown',
        		  'holder' => 'div',
        		  'class' => '',
        		  'heading' => __('Checkbox Options'),
        		  'param_name' => 'checkbox_param',
        		  'value' => $job_types,
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
add_action('vc_before_init', 'jobcircle_dream_blog_sidebar');

// popular category frontend
function jobcircle_dream_blog_sidebar_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(
            'head' => '',
            'mn_img' => '',
            'disc' => '',
            'checkbox_param' => '',
            'orderby' => '',
            'numofpost' => '',

        ),
        $atts,
        'jobcircle_dream_blog_sidebar'
    );
    $head  = isset($atts['head']) ? $atts['head'] : '';
    $disc  = isset($atts['disc']) ? $atts['disc'] : '';
    $mn_img = isset($atts['mn_img']) ? $atts['mn_img'] : '';
    $checkbox_param = isset($atts['checkbox_param']) ? $atts['checkbox_param'] : '';
    $job_type_arr = !empty($checkbox_param) ? explode(',', $checkbox_param) : '';


    ob_start()
?>
     <section class="section pedings section-theme-4 recent-articles-block bg-white mt-30 pt-md-30 pt-lg-50 pb-35 pb-md-50 pb-lg-80 pb-xxl-120">
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
            <div class="acticles-carousel my-post">
                <?php
                $numofpost  = isset($atts['numofpost']) ? $atts['numofpost'] : '';
                $orderby  = isset($atts['orderby']) ? $atts['orderby'] : '';
                //this one
                 $include_category_ids = $job_type_arr;
                $page_numbr = get_query_var('paged');
                 $args = array(
                        'post_type' => 'post',
                        'posts_per_page' => $numofpost,
                        'paged' => $page_numbr,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'category',
                                'field' => 'term_id', // Use term_id instead of slug
                                'terms' => $include_category_ids,
                                'include_children' => false, // Set to true if you want to include posts from child categories
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
             
        </div>
    </section>
    <?php
    if ($total_posts > $numofpost) {
        ?>
        <?php echo jobcircle_pagination($query, true); ?>
        <?php
    }
    return ob_get_clean();
}
add_shortcode('jobcircle_dream_blog_sidebar', 'jobcircle_dream_blog_sidebar_frontend');
