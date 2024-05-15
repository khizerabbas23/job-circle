<?php
   function jobcircle_grow_blog() {  
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
             'name' => __( 'Grow Blog' ),
             'base' => 'jobcircle_grow_blog',
             'category' => __( 'Job Circle' ),
             'params' => array(
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __( 'Title' ),
                    'param_name' => 'title',
                   ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __( 'Sub Title' ),
                    'param_name' => 'sub_title',
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
add_action( 'vc_before_init', 'jobcircle_grow_blog' );

// popular category frontend
function jobcircle_grow_blog_frontend( $atts, $content ) {
 
    $atts = shortcode_atts(
    array(
        'title' => '', 
        'sub_title' => '',
        'desc' => '',
        
        'orderby' => '',
		'numofpost' => '',
        'checkbox_param' => '',

    ), $atts, 'jobcircle_grow_blog');
 $title  = isset($atts['title']) ? $atts['title'] : '';
 $sub_title  = isset($atts['sub_title']) ? $atts['sub_title'] : '';
 $desc  = isset($atts['desc']) ? $atts['desc'] : '';
 $checkbox_param = isset($atts['checkbox_param']) ? $atts['checkbox_param'] : '';
 $job_type_arr = !empty($checkbox_param) ? explode(',', $checkbox_param) : '';
 
 
ob_start()
?>
		<section class="section section-news pt-35 pb-10 pt-md-50 pb-md-0 pt-lg-70 pb-lg-30 pb-xl-60">
           <div class="container">
               <!-- Section header -->
               <header class="section-header text-center mb-30 mb-md-45 mb-lg-50">
                   <?php 
                   if (!empty($title) || !empty($sub_title)) {
                   ?>
                   <h2><?php echo esc_html($title);?> <span class="text-primary"><?php echo esc_html($sub_title);?></span></h2>
       
                   <?php
                   }
                   ?>
                   <div class="seprator"></div>
                   <?php 
                   if (!empty($desc)){
                   ?>
                   <p> <?php echo esc_textarea($desc) ;?> </p>
                   <?php
                   }
                   ?>
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
                       $post =  get_the_id();
                       $author = get_the_author();
                       $comments_number = get_comments_number($post);
                       $title = get_the_title($post);
                       $content = get_the_content();
                       $excerpt = get_the_excerpt($post);
                       $date = get_the_date();       
                       $formatted_date = date('j F Y', strtotime($date));
                       $permalinkget = get_the_permalink($post);
                       $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post ), 'single-post-thumbnail' );
                       $read_more = get_post_meta($post, 'jobcircle_field_read_more', true);
                       $read_more_url = get_post_meta($post, 'jobcircle_field_read_more_url', true);  
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
                       <div class="col-12 col-md-4 mb-35 mb-md-55">
                           <!-- News Post -->
                           <article class="news-post">
                               <div class="image-holder">
                                <?php 
                   
                                if(!empty($permalinkget && $image[0])){
                                ?>
                                   <a href="<?php echo esc_html($permalinkget);?>">
                                       <img src="<?php echo esc_url_raw($image[0]);?>" width="482" height="315" alt="Image Description">
                                   </a>
                                   <?php  }?>
                               </div>
                               <div class="textbox">
                               <?php 
                                if(!empty($permalinkget && $title)){
                                ?>
                                   <h3 class="h4"> <a href="<?php echo esc_html($permalinkget);?>"><?php echo esc_html($title);?></a></h3>
                                   <?php 
                                }
                                ?>
                                   <ul class="post-meta">
                                       <li><i class="jobcircle-icon-calendar1 icon"></i>
                                       <?php 
                                         if(!empty($formatted_date)){
                                        ?>

                                           <time class="text" datetime="2023-03-20">&nbsp;&nbsp;<?php echo esc_html($formatted_date);?></time>
                                           <?php 
                                           }?>
                                       </li>
                                       <?php 
                                         if(!empty($comments_number)){
                                        ?>
                                       <li><i class="jobcircle-icon-comments icon"></i> <span class="text">&nbsp;&nbsp;<?php echo esc_html($comments_number)?> <?php esc_html_e(' Comments', 'jobcircle_frame') ?></span></li>
                                       <?php }
                                       ?>
                                   </ul>
                                   <p>
                                   <?php 
                                        if(!empty($excerpt)){
                                    ?>
                                    <?php echo esc_html($excerpt)?></p>
                                    <?php 
                                        }
                                        ?>
                               </div>
                               <footer class="post-footer">
                                <?php if(!empty($permalinkget)){ ?>
                            <a href="<?php echo esc_html($permalinkget)?>" class="read-more"><?php echo esc_html_e('Read More','jobcircle-frame');?><i class="jobcircle-icon-arrow-right1 icon"></i></a>
                           <?php 
                                        }
                                        ?>
                                 <?php if(!empty($post_author_link) && !empty($post_author_name)){ ?>
                            <span class="post-author"><?php echo esc_html_e('By:' ,'jobcirlcle-frame');?><a href="<?php echo esc_html($post_author_link) ?>"> <?php echo esc_html($post_author_name);?></a></span>
                                                      <?php 
                                        }
                                        ?>
                        </footer>
                           </article>
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
add_shortcode( 'jobcircle_grow_blog', 'jobcircle_grow_blog_frontend' );