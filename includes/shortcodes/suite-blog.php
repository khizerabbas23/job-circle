<?php
   function jobcircle_suite_blog() {  
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
             'name' => __( 'Suite Blog' ),
             'base' => 'jobcircle_suite_blog',
             'category' => __( 'Job Circle' ),
             'params' => array(
                array(
                'type' => 'textfield',
                'holder' => 'div',
                'class' => '',
                'heading' => __('Post Title FontSize'),
                'param_name' => 'font_size',
                ),
                 array(
                'type' => 'dropdown',
                'holder' => 'div',
                'class' => '',
                'heading' => __('Blog Page Style', 'jobcircle-frame'),
                'param_name' => 'blog_page_style',
                'description' => __('Select Blog Page Style', 'jobcircle-frame'),
                'value' => array(
                    'Select Style' => '',
                    'White Background' => 'white_background',
                    'Sky Container' => 'sky_background',
                ),
              ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __( 'Title' ),
                    'param_name' => 'title',
                   ),
                   array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Background Image'),
                    'param_name' => 'bg_img',
                ),
                     array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __( 'Description' ),
                    'param_name' => 'desc',
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
add_action( 'vc_before_init', 'jobcircle_suite_blog' );

// popular category frontend
function jobcircle_suite_blog_frontend( $atts, $content ) {
 
    $atts = shortcode_atts(
    array(
        'title' => '', 
        'desc' => '',
        'bg_img' => '',
        'blog_page_style' => '',
        'font_size' => '',
        
        'orderby' => '',
		'numofpost' => '',
        'checkbox_param' => '',

    ), $atts, 'jobcircle_suite_blog');
 $title = isset($atts['title']) ? $atts['title'] : '';
 $desc  = isset($atts['desc']) ? $atts['desc'] : '';
 $bg_img  = isset($atts['bg_img']) ? $atts['bg_img'] : '';
 $blog_page_style  = isset($atts['blog_page_style']) ? $atts['blog_page_style'] : '';
 $checkbox_param = isset($atts['checkbox_param']) ? $atts['checkbox_param'] : '';
 $job_type_arr = !empty($checkbox_param) ? explode(',', $checkbox_param) : '';
 $font_size = isset($atts['font_size']) ? $atts['font_size'] : '';
 
 
ob_start();

 if ($atts['blog_page_style'] == 'sky_background') {
     $bg_color='bg-light-sky';
 }elseif ($atts['blog_page_style'] == 'white_background'){
     $bg_color='';
 }else{
     $bg_color='';
 }
?>
			<?php
if(!empty($bg_img)){
        ?>
        <section class="section section-theme-5 news-block <?php echo $bg_color ?> pt-35 pt-md-50 pt-lg-75 pt-xxl-120 pb-35 pb-md-50 pb-lg-65 pb-xxl-100 mb-50" style="background-image: url('<?php echo esc_url_raw($bg_img) ?>');">
           <?php } ?>
				<div class="container">
					<!-- Section header -->
					<header class="section-header d-flex flex-column text-center mb-20 mb-lg-40">
                        <?php 
                        if(!empty($title)) { ?>
						<h2 class="order-2"><?php echo esc_html($title);?></h2>
                        <?php } ?>
                        <?php 
                        if(!empty($desc)) { ?>
						<p class="order-1"><?php echo esc_html($desc);?></p>
                        <?php } ?>
						
					</header>
					<div class="row">
                    <div class="col-12">
                       <div class="news-carousel">

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
                       $post =  get_the_id();
                       $author = get_the_author();
                       $comments_number = get_comments_number($post);
                       $title = get_the_title($post);
                       $content = get_the_content();
                       $excerpt = get_the_excerpt($post);
       
                       $permalinkget = get_the_permalink($post);
                       $posted = get_the_time('U');
                       $minut =  human_time_diff($posted,current_time( 'U' )). "";
                       $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post ), 'single-post-thumbnail' );
                       $read_more = get_post_meta($post, 'jobcircle_field_read_more', true);
                       $read_more_url = get_post_meta($post, 'jobcircle_field_read_more_url', true);
                       $date = date('F j, Y');
                       ?>
                       <div class="news-post-box">
									<div class="image-holder">
									    <?php if(!empty($permalinkget && $image)){
									        ?>
									<a href="<?php echo jobcircle_esc_the_html($permalinkget)?>"><img src="<?php echo esc_url_raw($image[0])?>" alt="image"></a>
									<?php 
									    }
									    ?>
									</div>
									<div class="news-info">
										<div class="title-bar">
										    <?php
                                        $terms = get_terms(array(
                                            'taxonomy' => 'job_category',
                                            'post_type' => 'jobs',
                                            'hide_empty' => false,
                                            'parent' => 0,
                                        ));

                                        $counter = 0;
                                        foreach ($terms as $term) {
                                            $term_link = get_term_link($term);
                                            if ($counter <= 0) {
                                                // Query to get the post count for each term
                                                $args = array(
                                                    'post_type' => 'jobs',
                                                    'tax_query' => array(
                                                        array(
                                                            'taxonomy' => 'job_category',
                                                            'field' => 'term_id',
                                                            'terms' => $term->term_id,
                                                        ),
                                                    ),
                                                );
                                                
                                                ?>
											<span class="sub-title"><a class="text-dark" href="<?php echo esc_url($term_link); ?>"><?php echo esc_html($term->name)?></a></span>
											
											
											<?php 
											$counter++;
											
                                        }else{
                                            break;
                                        }
                                        }
                                            if(!empty($title) && !empty($permalinkget)){?>
											<h3 style="font-size:<?php echo $font_size ?>px;"><a href="<?php echo jobcircle_esc_the_html($permalinkget)?>"><?php echo esc_html($title)?></a></h3>
											<?php } ?>
										</div>
										<ul class="list-inline meta-links m-0">
											<li class="list-inline-item">
											    <?php if(!empty($date)){
										        ?>
												<time class="date" datetime="2024-12-31"><?php echo esc_html($date)?></time>
												<?php } ?>
											</li>
											<li class="list-inline-item">
											  
												<a href="<?php echo esc_html($permalinkget)?>"> <?php echo esc_html($comments_number)?> <?php esc_html_e('Comments', 'jobcircle-frame') ?></a>
											
											</li>
										</ul>
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
add_shortcode( 'jobcircle_suite_blog', 'jobcircle_suite_blog_frontend' );