<?php
function jobcircle_latest_from(){
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
            'name' => __('Blog'),
            'base' => 'latest_from',
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
                'heading' => __('Post Title FontSize'),
                'param_name' => 'font_size',
            ),
            array(
                'type' => 'textfield',
                'holder' => 'div',
                'class' => '',
                'heading' => __('Title'),
                'param_name' => 'head',
            ),
            
            array(
                'type' => 'textfield',
                'holder' => 'div',
                'class' => '',
                'heading' => __('Span Title'),
                'param_name' => 'sb_head',
            ),
            array(
                'type' => 'textarea',
                'holder' => 'div',
                'class' => '',
                'heading' => __('Description'),
                'param_name' => 'disc',
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
add_action('vc_before_init', 'jobcircle_latest_from');
// popular category frontend
function jobcircle_latest_from_frontend($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'head' => '',
            'sb_head' => '',
            'disc' => '',
            'jobcircle_style' => '',
            'blog_page_style' => '',
            'checkbox_param' => '',
            'font_size' => '',
            'orderby' => '',
            'numofpost' => '',
        ),
        $atts,
        'jobcircle_latest_from'
    );
    $head  = isset($atts['head']) ? $atts['head'] : '';
    $sb_head  = isset($atts['sb_head']) ? $atts['sb_head'] : '';
    $disc  = isset($atts['disc']) ? $atts['disc'] : '';
    $jobcircle_style  = isset($atts['jobcircle_style']) ? $atts['jobcircle_style'] : '';
    $blog_page_style  = isset($atts['blog_page_style']) ? $atts['blog_page_style'] : '';
    $font_size = isset($atts['font_size']) ? $atts['font_size'] : '';
    $checkbox_param = isset($atts['checkbox_param']) ? $atts['checkbox_param'] : '';
    $job_type_arr = !empty($checkbox_param) ? explode(',', $checkbox_param) : '';
    ob_start();
    
    if ($atts['blog_page_style'] == 'blog_full_width') {
         $container ='container-fluid';
     }else{
         $container ='container';
     }
    
?>
    <section class="section section-news my-style pt-35 pb-10 pt-md-50 pb-md-0 pt-lg-70 pb-lg-30 pb-xl-60">
        <div class="<?php echo $container ?>">
            <header class="section-header text-center mb-30 mb-md-45 mb-lg-50">
                <?php if (!empty($head) || !empty($sb_head)) { ?>
                    <h2><?php echo esc_html($head); ?> <span class="text-primary"> <?php echo esc_html($sb_head); ?> </span></h2>
               
                <div class="seprator"></div>
                <?php
                }
                if (!empty($disc)) {
                ?>
                    <p><?php echo esc_textarea($disc); ?></p>
                <?php
                } ?>
            </header>
            <div class="row">
                <?php
                $numofpost  = isset($atts['numofpost']) ? $atts['numofpost'] : '';
                $orderby  = isset($atts['orderby']) ? $atts['orderby'] : '';
                //this one
                $page_numbr = get_query_var('paged');
            
              $include_category_ids = $job_type_arr;

               $args = array(
                        'post_type' => 'post',
                        'posts_per_page' => $numofpost,
                        'orderby' =>  $orderby,
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
                        $author_id = get_the_author_meta('ID');
                        $author_profile_link = get_author_posts_url($author_id);
                        $image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');
                        $date = get_the_date('d F Y');
                        
                         if ($atts['jobcircle_style'] == 'blog_column_2') {
                             $columns='col-12 col-md-6 mb-35 mb-md-55';
                         }elseif ($atts['jobcircle_style'] == 'blog_column_3') {
                             $columns='col-12 col-md-4 mb-35 mb-md-55';
                         }elseif ($atts['jobcircle_style'] == 'blog_column_4') {
                             $columns='col-12 col-md-3 mb-35 mb-md-55';
                         }else{
                             $columns='col-12 col-md-4 mb-35 mb-md-55';
                         }
                ?>
                        <div class="<?php echo $columns ?>">
                            <!-- News Post -->
                            <article class="news-post">
                                <div class="image-holder">
                                    <?php if (!empty($permalinkget) || !empty($image)) { ?>
                                        <a href="<?php echo esc_html($permalinkget); ?>"><img src="<?php echo esc_url_raw($image[0]); ?>" width="482" height="315" alt="Image Description"></a>
                                    <?php } ?>
                                </div>
                                <div class="textbox">
                                    <?php if (!empty($permalinkget) || !empty($title)) { ?>
                                        <h3 class="h4" style="font-size:<?php echo $font_size ?>px;"><a href="<?php echo esc_html($permalinkget); ?>"><?php echo esc_html($title); ?></a></h3>
                                    <?php } ?>
                                    <ul class="post-meta">
                                        <?php if (!empty($date) || !empty($comment)) { ?>
                                            <li><i class="jobcircle-icon-calendar1 icon"></i> <time class="text" datetime="2023-03-20"><?php echo esc_html($date); ?></time></li>
                                            <li><i class="jobcircle-icon-comments icon"></i> <span class="text"><?php echo esc_html($comment); ?> <?php esc_html_e(' Comments ', 'jobcircle-frame'); ?></span></li>
                                        <?php } ?>
                                    </ul>
                                    <?php if (!empty($excerpt)) { ?>
                                        <p><?php echo esc_html($excerpt); ?></p>
                                    <?php } ?>
                                </div>
                                <footer class="post-footer">
                                    <?php if (!empty($permalinkget)) { ?>
                                        <a href="<?php echo esc_html($permalinkget) ?>" class="read-more"><?php echo esc_html_e('Read More', 'jobcircle-frame'); ?><i class="jobcircle-icon-arrow-right1 icon"></i></a>
                                    <?php } ?>
                                    <?php if (!empty($author_profile_link) || !empty($admin)) { ?>
                                        <a href="<?php echo esc_html($author_profile_link) ?>">
                                            <span class="post-author"><?php echo esc_html_e('By:', 'jobcircle-frame'); ?> <?php echo esc_html($admin); ?></span>
                                        </a>
                                    <?php } ?>
                                </footer>
                            </article>
                        </div>
                <?php
                    }
                }
                //also this one         
                ?>
            </div>
            <?php
            if ($total_posts > $numofpost) {
            ?>
                <?php echo jobcircle_pagination($query, true); ?>
            <?php
            }
            wp_reset_postdata();
            ?>
        </div>
        
    </section>
<?php
    return ob_get_clean();
}
add_shortcode('latest_from', 'jobcircle_latest_from_frontend');
