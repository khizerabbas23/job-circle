<?php
   function jobcircle_freelance_blog() {  
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
             'name' => __( 'Freelance Blog' ),
             'base' => 'jobcircle_freelance_blog',
             'category' => __( 'Job Circle' ),
             'params' => array(
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __( 'Title' ),
                    'param_name' => 'head',
                   ),
                     array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __( 'Heading' ),
                    'param_name' => 'sb_head',
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
                   'heading' => __( 'Order By' ),
                   'param_name' => 'orderby',
                ),
                array(   
                   'type' => 'textfield',
                   'holder' => 'div',
                   'class' => '',
                   'heading' => __( 'Number Of Post' ),
                   'param_name' => 'numofpost',
                ),   
                            
          )
         )
        
      );
}
add_action( 'vc_before_init', 'jobcircle_freelance_blog' );

// popular category frontend
function jobcircle_freelance_blog_frontend( $atts, $content ) {
 
    $atts = shortcode_atts(
    array(
        'head' => '', 
        'sb_head' => '',
        
        'orderby' => '',
		'numofpost' => '',
        'checkbox_param' => '',

    ), $atts, 'jobcircle_freelance_blog');
 $head  = isset($atts['head']) ? $atts['head'] : '';
 $sb_head  = isset($atts['sb_head']) ? $atts['sb_head'] : '';
 $checkbox_param = isset($atts['checkbox_param']) ? $atts['checkbox_param'] : '';
 $job_type_arr = !empty($checkbox_param) ? explode(',', $checkbox_param) : '';
 
 
ob_start()
?>
			<section class="section section-news section-theme-12 pt-35 pb-25 pt-md-50 pb-md-30 pt-lg-65 pb-lg-70">
				<div class="container">
					<!-- Section header -->
					<header class="section-header text-center mb-30 mb-md-45 mb-lg-50">
                        <?php if(!empty($head)){ ?>
						<p><?php echo esc_html($head) ?></p>
                        <?php } ?>
                        <?php if(!empty($sb_head)){ ?>
						<h2 class="showhead"><?php echo esc_html($sb_head) ?></h2>
                        <?php } ?>
					</header>
					<div class="row">

<?php
        $numofpost  = isset($atts['numofpost']) ? $atts['numofpost'] : '';
        $orderby  = isset($atts['orderby']) ? $atts['orderby'] : '';

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
        $query = new WP_Query( $args );
        $total_posts = $query->found_posts;
         
        // Check that we have query results.
        if ( $query->have_posts() ) {
        
            // Start looping over the query results.
            while ( $query->have_posts() ) {
                $query->the_post();
                global $post;
                $post =  get_post(); 
                $author_id = get_the_author_meta( 'url' );
                $postid =  $post->ID;       
                $title = get_the_title($postid);
                $excerpt = get_the_excerpt($postid);
                $comment = get_comments_number($postid);
                $permalinkget = get_permalink($postid);
                $posted_date = get_the_date('F j, Y');
                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $postid ), 'single-post-thumbnail' );
                $author_avatar = get_avatar($author_id, 96); // 96 is the size of the avatar in pixels
               $job_post = get_post($post->ID);
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

<div class="col-12 col-md-4 mb-35 mb-md-30">
							<!-- News Post -->
							<article class="news-post">
								<div class="image-holder">
                                <?php if(!empty($image) || !empty($permalinkget)){ ?>
									<a href="<?php echo esc_html($permalinkget); ?>"><img src="<?php  echo esc_url_raw($image[0]);?>" width="470" height="315" alt="Image Description"></a>
                                    
									<a href="<?php echo esc_html($permalinkget); ?>" class="read-more"><i class="jobcircle-icon-arrow-right1 icon"></i></a>
								<?php } ?>
								</div>
								<div class="textbox">
									<ul class="post-meta">
									    <li><span class="fa-regular fa-calendar-days"></span> <time class="text" datetime="2023-03-20"><?php echo esc_html($posted_date)?></time></li>
										<li><span class="fa fa-comment-dots"></span> <span class="text"><?php echo esc_html($comment);?> <?php esc_html_e( ' Comments ' , 'jobcircle-frame'); ?></span></li>
									</ul>
									<?php if(!empty($permalinkget) || !empty($title)){ ?>
									<h3 class="h4 showhead"><a href="<?php echo esc_html($permalinkget); ?>"><?php echo esc_html($title);?></a></h3>
							<?php } ?>
								</div>
								<footer class="post-footer">
								    <?php if(!empty($post_author_link) || !empty($post_author_name)){ ?> 
									<span class="post-author"><?php echo esc_html_e('By ','jobcircle-frame');?><a href="<?php echo esc_html($post_author_link); ?>"><?php echo esc_html($post_author_name); ?></a></span>
								<?php } ?>
								</footer>
							</article>
						</div>

<?php
            }
        }
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
add_shortcode( 'jobcircle_freelance_blog', 'jobcircle_freelance_blog_frontend' );