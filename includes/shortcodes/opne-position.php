<?php
function jobcircle_open_position() {   
    vc_map(       
       array(
             'name' => __( 'Opne Position' ),
             'base' => 'jobcircle_open_position',
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

                  )
              )   
          );
 }
add_action( 'vc_before_init', 'jobcircle_open_position' );
// popular category frontend
function jobcircle_open_position_frontend( $atts, $content ) {
    $atts = shortcode_atts(
    array(

        'title' => '',
        'orderby' => '',
		'numofpost' => '',

        ), 
    $atts, 'jobcircle_open_position');
 $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';

 $title  = isset($atts['title']) ? $atts['title'] : '';

 ob_start();?>	


							<div class="block-holder">
								<h4><?php echo  $title ?></h4>
								<div class="row">
 <?php
        $numofpost  = isset($atts['numofpost']) ? $atts['numofpost'] : '';
        $orderby  = isset($atts['orderby']) ? $atts['orderby'] : '';
		$page_numbr = get_query_var('paged');
        $order = "DESC";

        $args = array(
           'post_type' => 'jobs', //enter post type name static
            'post_status' => 'publish',                                                                                                                                     
             'posts_per_page' => $numofpost, 
             'order' => $order,      
			 'paged' => $page_numbr,               
             'orderby' =>  $orderby, 

                 );         
        // Custom query.
        $query = new WP_Query( $args );
		$total_posts=$query->found_posts;
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
                $post =  get_the_id();
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
                $job_location = jobcircle_post_location_str($post);
                $remote = get_post_meta($post, 'remote', true);
                $job_img_url = jobcircle_job_thumbnail_url($post);
               	$job_type = get_post_meta($post, 'jobcircle_field_job_type', true);
    			$job_type_str = jobcircle_job_type_ret_str($job_type);
    			
                $part_time = get_post_meta($post, 'part_time', true);
                $max_salary = jobcircle_job_salary_str($post, '', 'sub');
             ?>	
                  <div class="col-12 mb-15 mb-md-20">
										<article class="popular-jobs-box">
											<div class="box-holder">
												<div class="job-info">
													<div class="img-holder">
													     <?php if(!empty($permalinkget) && !empty($job_img_url)){ ?>
													    <a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>">
														<img src="<?php echo jobcircle_esc_the_html($job_img_url) ?>" width="78" height="78" alt="Image Description">
														</a>
														<?php } ?>
													</div>
													<div class="textbox">
													     <?php if(!empty($permalinkget) && !empty($title)){ ?>
													    <a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>">
														<h3 class="h5"><?php echo jobcircle_esc_the_html($title) ?></h3>
														</a>
															<?php } ?>
														<ul class="meta-list">
														    <?php if(!empty($post_author_name)){ ?>
															<li><span class="text"><?php esc_html_e('By', 'jobcircle-frame') ?> <a href="<?php echo jobcircle_esc_the_html($post_author_link) ?>"><?php echo jobcircle_esc_the_html($post_author_name) ?> </a></span></li>
															<?php } ?>
															<?php if(!empty($job_location)){ ?>
															<li><i class="jobcircle-icon-map-pin"></i><span class="text"><?php echo jobcircle_esc_the_html($job_location) ?></span></li>
															<?php } ?>
														</ul>
														<ul class="tags-list">
														    <?php if(!empty($remote)){ ?>
															<li><span class="tag"><?php echo jobcircle_esc_the_html($remote) ?></span></li>
															<?php } ?>
															<?php if(!empty($job_type_str)){ ?>
															<li><span class="tag"><?php echo jobcircle_esc_the_html($job_type_str['title']); ?></span></li>
															<?php } ?>
															<?php if(!empty($part_time)){ ?>
															<li><span class="tag"><?php echo jobcircle_esc_the_html($part_time) ?></span></li>
															<?php } ?>
														</ul>
													</div>
												</div>
												<footer class="jobs-foot">
												    <?php if(!empty($max_salary)){ ?>
													<strong class="amount sub"><?php echo jobcircle_esc_the_html($max_salary) ?></strong>
													<?php } ?>
													<?php if(!empty($permalinkget)){ ?>
													<a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>" class="btn btn-green btn-sm"><span class="btn-text"><?php esc_html_e('Apply Now', 'jobcircle-frame') ?></span></a>
													<?php } ?>
												</footer>
											</div>
										</article>
    									</div>
                                    <?php 
                                    }
                                    }
                                    ?>
                                     </div>
				                	</div>
            <?php

        wp_reset_postdata();?>
           
        <?php return ob_get_clean();
}
add_shortcode( 'jobcircle_open_position', 'jobcircle_open_position_frontend' );

