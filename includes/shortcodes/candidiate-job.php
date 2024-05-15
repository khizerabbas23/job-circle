<?php
function candidate_job() {   
    vc_map(       
       array(
             'name' => __( 'Candidate Jobe' ),
             'base' => 'candidate_job',
             'category' => __( 'Job Circle' ),
             'params' => array(       
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __( 'Post Type' ),
                            'param_name' => 'posttypename',
                        ),
                       array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __( 'Taxonomy' ),
                            'param_name' => 'taxonomy',
                       ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __( 'Order By' ),
                            'param_name' => 'orderby',
                        ),
                         array(   
                            'type' => 'textarea',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __( 'Number Of Post' ),
                            'param_name' => 'numofpost',
                        ), 
                         array(   
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __( 'catagory Slug' ),
                            'param_name' => 'catagory_slug',
                       ), 
                  )
              )   
          );
 }
add_action( 'vc_before_init', 'candidate_job' );

// popular category frontend
function candidate_job_frontend( $atts, $content ) {
 
    $atts = shortcode_atts(
    array(
        'posttypename' => '',
        'taxonomy' => '',
        'orderby' => '',
		'numofpost' => '',
        'catagory_slug' =>'',

    ), $atts, 'candidate_job');

 $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
 $output ='';

 ob_start();
        ?>	<section class="section section-candidate candidate-addition pt-0 pb-35 pb-xl-75">
        <div class="container">
            <div class="row justify-content-center">
 <?php
        $numofpost  = isset($atts['numofpost']) ? $atts['numofpost'] : '';
        $taxonomy  = isset($atts['taxonomy']) ? $atts['taxonomy'] : '';
        $orderby  = isset($atts['orderby']) ? $atts['orderby'] : '';
        $posttypename  = isset($atts['posttypename']) ? $atts['posttypename'] : '';
        $catagory_slug  = isset($atts['catagory_slug']) ? $atts['catagory_slug'] : '';

        $args = array(
           'post_type' => 'candidate',
            'post_status' => 'publish',                                                                                                                                                                                             
             'posts_per_page' => $numofpost, 
             'order' => 'DESC',                     
             'orderby' =>  $orderby, 
                 );         
        // Custom query.
        $query = new WP_Query( $args );
        $total_posts = $query->found_posts;

        // Check that we have query results.
        if ( $query->have_posts() ) {
        
            // Start looping over the query results.
            while ( $query->have_posts() ) {
                $query->the_post();
                global $post;
                $post =  get_the_id();
                $title = get_the_title($post);
                $permalinkget = get_the_permalink($post);
                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post ), 'single-post-thumbnail' );
                $facebook_url = get_post_meta($post, 'jobcircle_field_facebook_url', true);
                $twiter_url= get_post_meta($post, 'jobcircle_field_twiter_url', true);
                $linkdin_url= get_post_meta($post, 'jobcircle_field_linkdin_url', true);
                $job_category= get_post_meta($post, 'jobcircle_field_job_category', true);
                $resume= get_post_meta($post, 'jobcircle_field_resume', true);             
             ?>	
             <div class="col-12 col-md-6 col-lg-4 mb-15 mb-md-30">
             <article class="candidate-box">
                 <div class="textbox">
                     <a href="<?php jobcircle_esc_the_html($permalinkget) ?>" class="pin-job"><i class="icon icon-bookmark"></i></a>
                     <div class="icon-box">
                     <?php     
                if(!empty($image)){
                    ?>
                    <img src="<?php echo esc_url_raw($image[0]) ?>" width="102" height="102" alt="Alex Carey">
                  <?php  
                }
                ?>
                     </div>
                     <?php     
                if(!empty($title)){
                    ?>
                     <h2 class="h5"><a href="<?php jobcircle_esc_the_html($permalinkget) ?>"><?php jobcircle_esc_the_html($title) ?></a></h2>
                  <?php  
                }
                ?>
                     <strong class="subtitle"><?php jobcircle_esc_the_html($job_category) ?></strong>
                     <ul class="social-links">
                         <li><a href="<?php jobcircle_esc_the_html($facebook_url) ?>"><i class="icon-facebook"></i></a></li>
                         <li><a href="<?php jobcircle_esc_the_html($twiter_url) ?>"><i class="icon-twitter"></i></a></li>
                         <li><a href="<?php jobcircle_esc_the_html($linkdin_url) ?>"><i class="icon-linkedin"></i></a></li>
                     </ul>
                     <a href="<?php jobcircle_esc_the_html($resume) ?>" class="btn btn-primary btn-sm"><span class="btn-text"><?php esc_html_e('View Resume', 'jobcircle-frame') ?></span></a>
                 </div>
             </article>
         </div>
                <?php
            }
        }
        // Restore original post data.
        if ($total_posts > $numofpost) {

            $output .= jobcircle_pagination($query, true);
        }
        wp_reset_postdata();
        ?>
                </div>
				</div>
			</section>
        <?php
    return ob_get_clean();
}
add_shortcode( 'candidate_job', 'candidate_job_frontend' );