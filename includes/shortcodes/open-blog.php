<?php
function jobcircle_open_blog()
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
            'name' => __('Open Blog'),
            'base' => 'jobcircle_open_blog',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                'type' => 'dropdown',
                'holder' => 'div',
                'class' => '',
                'heading' => __('Blog Page Style', 'jobcircle-frame'),
                'param_name' => 'blog_page_style',
                'description' => __('Select Blog Page Style', 'jobcircle-frame'),
                'value' => array(
                    'Select Style' => '',
                    'Blog Full Width' => 'blog_full_width',
                    'Blog Container' => 'blog_containier',
                ),
            ),
            array(
            'type' => 'dropdown',
            'holder' => 'div',
            'class' => '',
            'heading' => __('Blog Columns Style', 'jobcircle-frame'),
            'param_name' => 'jobcircle_style',
            'description' => __('Select Jobcircle Style', 'jobcircle-frame'),
            'value' => array(
                'Select Style' => '',
                'Blog Full Width' => 'blog_full_width',
                'Blog Columns 2' => 'blog_column_2',
                'Blog Columns 3' => 'blog_column_3',
                'Blog Columns 4' => 'blog_column_4',
                ),
              ),
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
add_action('vc_before_init', 'jobcircle_open_blog');

// popular category frontend
function jobcircle_open_blog_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(
            'title' => '',
            'heading' => '',
        	'checkbox_param' => '',

            'orderby' => '',
            'numofpost' => '',
            
             'jobcircle_style' => '',
            'blog_page_style' => '',

        ), $atts, 'jobcircle_open_blog');

    $title = isset($atts['title']) ? $atts['title'] : '';
    $heading = isset($atts['heading']) ? $atts['heading'] : '';
    $checkbox_param = isset($atts['checkbox_param']) ? $atts['checkbox_param'] : '';
    $job_type_arr = !empty($checkbox_param) ? explode(',', $checkbox_param) : '';
    
    $jobcircle_style  = isset($atts['jobcircle_style']) ? $atts['jobcircle_style'] : '';
    $blog_page_style  = isset($atts['blog_page_style']) ? $atts['blog_page_style'] : '';

    ob_start();
    
    if ($atts['blog_page_style'] == 'blog_full_width') {
         $container ='container-fluid';
     }else{
         $container ='container';
     }
        ?>
    <section class="recent_articles_block section-theme-11 theme_sevenb">
        <div class="<?php echo $container ?>">
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
            <div class="row mb-0">

                <?php
                $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
                $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
                //this one
                
                $include_category_ids = $job_type_arr;
                $page_numbr = get_query_var('paged');
                $args = array(
                        'post_type' => 'post',
                        'posts_per_page' => $numofpost,
                        'order' => 'DESC',
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
                        $post = get_post();
                        $postid = $post->ID;
                        $title = get_the_title($postid);
                        $excerpt = get_the_excerpt($postid);
                        $permalinkget = get_permalink($postid);
                        $image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');
                        $date = get_the_date('M,d, Y');
                        $comment = get_comments_number($postid);
                        
                         if ($atts['jobcircle_style'] == 'blog_column_2') {
                             $columns='col-12 col-md-6 col-lg-6 mb-30 mb-lg-70';
                         }elseif ($atts['jobcircle_style'] == 'blog_column_3') {
                             $columns='col-12 col-md-6 col-lg-4 mb-30 mb-lg-70';
                         }elseif ($atts['jobcircle_style'] == 'blog_column_4') {
                             $columns='col-12 col-md-6 col-lg-3 mb-30 mb-lg-70';
                         }else{
                             $columns='col-12 col-md-6 col-lg-4 mb-30 mb-lg-70';
                         }

                        ?>
                        <div class="<?php echo $columns ?>">
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
add_shortcode('jobcircle_open_blog', 'jobcircle_open_blog_frontend');