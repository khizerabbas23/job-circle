<?php
function jobcircle_recent_news_post()
{
         $terms = get_terms(
		array(
			'taxonomy' => 'category',
			'hide_empty' => false,
		)
	);
	$job_types = array();
	foreach ($terms as $term) {
		$job_types[$term->name] = $term->term_id;
	}
	;
    vc_map(
        array(
            'name' => __('Recent News Eigth'),
            'base' => 'jc_recent_news_post',
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
                    'param_name' => 'spn_title',
                ),

                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Description'),
                    'param_name' => 'desc',
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
                    'heading' => __('Button Text'),
                    'param_name' => 'btn_txt',
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
                                array(
        		  'type' => 'dropdown',
        		  'holder' => 'div',
        		  'class' => '',
        		  'heading' => __('Post Selector'),
        		  'param_name' => 'dropdown_param',
        		  'value' => $job_types,
        		),
            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_recent_news_post');

// popular category frontend
function jobcircle_recent_news_post_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(

            'title' => '',
            'spn_title' => '',
            'desc' => '',
            'btn_url' => '',
            'btn_txt' => '',
            'orderby' => '',
            'numofpost' => '',
 'dropdown_param' => '',
        ),
        $atts,
        'jobcircle_recent_news_post'
    );
    $title = isset($atts['title']) ? $atts['title'] : '';
    $spn_title = isset($atts['spn_title']) ? $atts['spn_title'] : '';
    $desc = isset($atts['desc']) ? $atts['desc'] : '';
    $btn_url = isset($atts['btn_url']) ? $atts['btn_url'] : '';
    $btn_txt = isset($atts['btn_txt']) ? $atts['btn_txt'] : '';
        $dropdown_param = isset($atts['dropdown_param']) ? $atts['dropdown_param'] : '';
        $job_type_arr = !empty($dropdown_param) ? explode(',', $dropdown_param) : '';
    ob_start();
    ?>
    <section
        class="section section-theme-8 recent-news-block pt-35 pt-md-50 pt-lg-75 pt-xxl-120 pb-35 pb-md-50 pb-lg-65 pb-xxl-120">
        <div class="container">
            <!-- Section header -->
            <header class="section-header text-center mb-30 mb-md-45 mb-xl-60">
                <?php if (!empty($title) && !empty($spn_title)) {
                    ?>
                    <h2>
                        <?php echo esc_html($title); ?> <span class="text-outlined">
                            <?php echo esc_html($spn_title); ?>
                        </span>
                    </h2>
                    <?php
                } ?>
                <?php if (!empty($desc)) {
                    ?>
                    <p>
                        <?php echo esc_textarea($desc); ?>
                    </p>
                    <?php
                } ?>
            </header>
            <div class="row">
                <?php

                $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
                $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';

$include_category_ids = $job_type_arr;
                $args = array(
                    'post_type' => 'post',
                    'post_status' => 'publish',
                    'posts_per_page' => $numofpost,
                    'order' => 'DESC',
                    'orderby' => $orderby,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'category',
                                'field' => 'term_id', // Use term_id instead of slug
                                'terms' => $include_category_ids,
                                'include_children' => false, // Set to true if you want to include posts from child categories
                            ),
                        ),

                );

                // Custom query.
                $query = new WP_Query($args);

                $counter = 0;


                // Check that we have query results.
                if ($query->have_posts()) {

                    // Start looping over the query results.
                    while ($query->have_posts()) {

                        $query->the_post();

                        $post = get_post();
                        $postid = $post->ID;
                        $date = get_the_date('M d Y');
                        $title = get_the_title($postid);
                        $permalinkget = get_the_permalink($postid);
                        $content = get_the_content();
                        $image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');
                        $excerpt = get_the_excerpt($postid);

                        if ($counter == 0) {
                            $col = '<div class="col-12 col-lg-6">';
                            $class = 'large';
                            $div = '</div>';
                        } elseif ($counter == 1) {
                            $col = '<div class="col-12 col-lg-6">';
                            $class = '';
                            $div = '';
                        } elseif ($counter == 2) {
                            $col = '';
                            $class = '';
                            $div = '</div>';
                        }

                        ?>


                        <?php echo jobcircle_esc_the_html($col); ?> 
                        <?php if(!empty ($permalinkget) || !empty($class)){ ?>
                        <a href="<?php echo esc_html($permalinkget) ?>" class="news-article <?php echo jobcircle_esc_the_html($class); ?>">
                            <?php } ?>
                            <div class="image-holder">
                                <?php if (!empty($image)) {
                                    ?>
                                    <img src="<?php echo esc_url_raw($image[0]) ?>" href="<?php echo esc_html($permalinkget) ?>" alt="Looking For A Highly Motivated 
                                    Producer To Build">
                                <?php
                                } ?>
                            </div>
                            <div class="textbox">
                                <?php if (!empty($date)) {
                                    ?>
                                    <time class="date" datetime="2023-12-23">
                                        <?php echo esc_html($date); ?>
                                    </time>
                                    <?php } if (!empty($permalinkget) && !empty($title)) {
                                        ?>
                                        <h3 class="h5" href="<?php echo esc_html($permalinkget) ?>">
                                            <?php echo esc_html($title); ?>
                                        </h3>
                                    <?php
                                    } ?>
                                    <?php if (!empty($excerpt)) {
                                        ?>
                                        <p>
                                            <?php echo ($excerpt) ?>
                                        </p>
                                    <?php
                                    } ?>
                                </div>
                            </a>
                            <?php echo jobcircle_esc_the_html($div); ?>

                            <?php
                            $counter++;
                              

                    }

                    // Restore original post data.
                    wp_reset_postdata();

                    ?>
                </div>
                <div class="row pt-25 pt-md-50 pt-xl-70">
                    <!-- Featured Category Button Block -->
                    <div class="col-12 text-center btn-block">
                        <?php if (!empty($btn_url) && !empty($btn_txt)) {
                            ?>
                            <a href="<?php echo jobcircle_esc_the_html($btn_url )?>" class="btn btn-orange btn-sm"><span class="btn-text">
                                    <?php echo esc_html($btn_txt) ?>
                                </span></a>
                        <?php
                        } ?>
                    </div>
                </div>
            </div>
        </section>

        <?php

        return ob_get_clean();

                }
}
add_shortcode('jc_recent_news_post', 'jobcircle_recent_news_post_frontend');