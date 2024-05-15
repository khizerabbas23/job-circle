<?php
function jobcircle_featured_blog()
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
            'name' => __('Featured Blog'),
            'base' => 'jobcircle_featured_blog',
            'category' => __('job Circle'),
            'params' => array(
                array(
                'type' => 'textfield',
                'holder' => 'div',
                'class' => '',
                'heading' => __('Post Title FontSize'),
                'param_name' => 'font_size',
                ),
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
                array(
        		  'type' => 'dropdown',
        		  'holder' => 'div',
        		  'class' => '',
        		  'heading' => __('Checkbox Options'),
        		  'param_name' => 'checkbox_param',
        		  'value' => $job_types,
        		),
            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_featured_blog');
// popular category frontend
function jobcircle_featured_blog_frontend($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'title' => '',
            'sub_title' => '',
            'ihm_img' => '',
            'font_size' => '', 
            'checkbox_param' => '',
            'orderby' => '',
            'numofpost' => '',
        ),
        $atts,
        'jobcircle_featured_blog'
    );
    $title  = isset($atts['title']) ? $atts['title'] : '';
    $sub_title  = isset($atts['sub_title']) ? $atts['sub_title'] : '';
    $ihm_img  = isset($atts['ihm_img']) ? $atts['ihm_img'] : '';
    $checkbox_param = isset($atts['checkbox_param']) ? $atts['checkbox_param'] : '';
    $font_size = isset($atts['font_size']) ? $atts['font_size'] : '';
    $job_type_arr = !empty($checkbox_param) ? explode(',', $checkbox_param) : '';
    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
    $output = '';
    ob_start();
    
    
?>
        <section class="section section-theme-14 jobs_waiting recent_atical-pt" 
        <?php if(!empty($ihm_img)){?>
        style="background-image: url('<?php echo esc_html($ihm_img) ?>');" <?php } ?>>
            
      <div class="container">
        <div class="recent_articles feartic-blog">
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
                $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
                $page_numbr = get_query_var('paged');
                $include_category_ids = $job_type_arr;

               $query_args = array(
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
            // Custom query.
            $query = new WP_Query($query_args);
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
                  $date = get_the_date('d');
                  $mnth = get_the_date('M');
                  $year = get_the_date('Y');
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
                   
            ?>
                    <div class="article_info_row">
                        <div class="article_holder">
                            <div class="article_info">
                                <?php if (!empty($permalinkget)) { ?>
                                    <a class="forward" href="<?php echo esc_html($permalinkget); ?>"><i class="jobcircle-icon-chevron-right icon"></i></a>
                                <?php } ?>
                                <div class="image-holder">
                                    <div class="date-holder">
                                       
                                            <span class="date">
                                                <span class="day"><?php echo jobcircle_esc_the_html($date); ?></span>
                                                <span class="month"><?php echo jobcircle_esc_the_html($mnth); ?>, <?php echo jobcircle_esc_the_html($year); ?></span>
                                            </span>
                                      
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
                                            <strong class="title" style="font-size:<?php echo $font_size ?>px;"><?php echo esc_html($title); ?></strong>
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
add_shortcode('jobcircle_featured_blog', 'jobcircle_featured_blog_frontend');
