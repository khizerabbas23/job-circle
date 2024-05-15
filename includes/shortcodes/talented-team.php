<?php
function jobcircle_talented_teams() {   
    vc_map(       
       array(
             'name' => __( 'Talented Team' ),
             'base' => 'talented_teams',
             'category' => __( 'Job Circle' ),
             'params' => array(
                array(
                    'type' => 'dropdown',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Talented Team', 'jobcircle-frame'),
                    'param_name' => 'talented',
                    'description' => __('Select Talented Team', 'jobcircle-frame'),
                    'value' => array(
                        'Select Style' => '',
                        'View Style 1' => 'team_style_one',
                        'View Style 2' => 'team_style_two',
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
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __( 'Span Title' ),
                    'param_name' => 'span_title',
                   ),
                       array(
                            'type' => 'textarea',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __( 'Description' ),
                            'param_name' => 'description',
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
add_action( 'vc_before_init', 'jobcircle_talented_teams' );

// popular category frontend
function jobcircle_talented_teams_frontend( $atts, $content ) {
 
    $atts = shortcode_atts(
    array(
       
        'title' => '',
        'span_title' => '',
        'description' => '',

        'orderby' => '',
		'numofpost' => '',
        
        'talented' =>'',

    ), $atts, 'jobcircle_talented_teams'
);

$title  = isset($atts['title']) ? $atts['title'] : '';
$span_title  = isset($atts['span_title']) ? $atts['span_title'] : '';
$description  = isset($atts['description']) ? $atts['description'] : '';


 ob_start();
 if ($atts['talented'] == 'team_style_one') {
     ?>
      <section class="section section-team pt-25 pb-20 pb-md-35 pb-lg-40">
				<div class="container">
					<!-- Section header -->
					<header class="section-header text-center mb-30 mb-md-45 mb-lg-50">
                        <?php
                    if (!empty($title) && !empty($span_title)) {
                        ?>
						<h2><?php echo esc_html($title,'jobcircle-frame');?><span class="text-primary"> <?php echo esc_html($span_title,'jobcircle-frame');?></span></h2>

                        <?php
                      }
                      ?>
						<div class="seprator"></div>

                        <?php
                         if (!empty($description)){
                            ?>
						<p><?php echo esc_textarea($description,'jobcircle-frame');?></p>
                            <?php
                         }
                         ?>

					</header>
					<div class="row">

 <?php
        $numofpost  = isset($atts['numofpost']) ? $atts['numofpost'] : '';
        $orderby  = isset($atts['orderby']) ? $atts['orderby'] : '';

        $args = array(
           'post_type' => 'talented_team',
            'post_status' => 'publish',                                                                                                                                                                                             
             'posts_per_page' => $numofpost, 
             'order' => 'DESC',                     
             'orderby' =>  $orderby, 
                'tax_query' => array(
                            'tax_query' => array(
                            array(
                                'taxonomy' => 'our_team',
                                'field'    => 'slug',
                                'terms'    => 'our-team',
                            ),
                        ),        
                     ),
                 );         
        // Custom query.
        $query = new WP_Query( $args );
        $total_posts = $query->found_posts;

        // Check that we have query results.
        if ( $query->have_posts() ) {
        
            // Start looping over the query results.
            while ( $query->have_posts() ) {
                $query->the_post();

                global $jobcircle_framework_options, $post;

                $post =  get_the_id();
                $permalinkget = get_the_permalink($post);
                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post ), 'single-post-thumbnail' );
               // $excerpt = get_the_excerpt($post);
                $title = get_the_title($post);
                $skill = get_post_meta($post, 'jobcircle_field_apply_skill', true);
                $view_profile = get_post_meta($post, 'jobcircle_field_apply_view_profile', true);
                
             ?>
                <div class="col-12 col-sm-6 col-lg-3 mb-30">
							<!-- Team Member Box -->
							<article class="team-box">
								<div class="image-holder">
                                    <?php
                                if(!empty($image)){
                                        ?>
                            <img src="<?php echo esc_url_raw($image[0]);?>" width="352" height="386" alt="Alex Johnson">
                                <?php
                                }
                                ?>
									
									<div class="button-overplay">
                                   <?php 
                                  if (!empty($permalinkget) || !empty($view_profile)) {
                                    ?>
                                <a href="<?php echo esc_html($permalinkget);?>" class="btn btn-primary"><span class="btn-text"><?php echo esc_html($view_profile);?></span></a>
                                    <?php
                                   }
                                   ?>
					
									</div>
								</div>
								<div class="textbox">

                                  <?php 
                                 if (!empty($permalinkget) && !empty($title)) {
                                    ?>
                                     <h3 class="h4"><a href="<?php echo esc_html($permalinkget)?>"><?php echo esc_html($title);?></a></h3>
                                     <?php 
                                  }
                                  ?>

                                  <?php 
                                  if(!empty($skill)){
                                    ?>
                                     <span class="subtext"><?php echo esc_html($skill)?></span>
                                  <?php
                                  }
                                  ?>
                              </div>
							</article>
						</div>
										
                <?php
            }
        }
        // Restore original post data
        wp_reset_postdata();
        ?>
	    </div>
			</div>
			</section>
        <?php
 }elseif ($atts['talented'] == 'team_style_two') {
    ?>
     <section class="section section-team featured-team bg-light-gray pt-35 pt-md-50 pt-lg-65 pb-20 pb-md-35 pb-lg-50">
               <div class="container">
                   <!-- Section header -->
                   <header class="section-header text-center mb-30 mb-md-45 mb-lg-50">
                       <?php
                   if (!empty($title) || !empty ($span_title)) {
                       ?>
                       <h2><?php echo esc_html($title);?><span class="text-primary"> <?php echo esc_html($span_title);?></span></h2>

                       <?php
                     }
                     ?>
                       <div class="seprator"></div>

                       <?php
                        if (!empty($description)){
                           ?>
                       <p><?php echo esc_textarea($description);?></p>
                           <?php
                        }
                        ?>
                   </header>
                   <div class="row">

<?php
       $numofpost  = isset($atts['numofpost']) ? $atts['numofpost'] : '';
       $orderby  = isset($atts['orderby']) ? $atts['orderby'] : '';

       $args = array(
          'post_type' => 'talented_team',
           'post_status' => 'publish',                                                                                                                                                                                             
            'posts_per_page' => $numofpost, 
            'order' => 'DESC',                     
            'orderby' =>  $orderby, 
               'tax_query' => array(
                           'tax_query' => array(
                           array(
                               'taxonomy' => 'our_team',
                               'field'    => 'slug',
                               'terms'    => 'featured-team	',
                           ),
                       ),        
                    ),
                );         
       // Custom query.
       $query = new WP_Query( $args );
       $total_posts = $query->found_posts;

       // Check that we have query results.
       if ( $query->have_posts() ) {
       
           // Start looping over the query results.
           while ( $query->have_posts() ) {
               $query->the_post();

               global $jobcircle_framework_options, $post;

               $post =  get_the_id();
               $permalinkget = get_the_permalink($post);
               $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post ), 'single-post-thumbnail' );
              // $excerpt = get_the_excerpt($post);
               $title = get_the_title($post);

               $skill = get_post_meta($post, 'jobcircle_field_apply_skill', true);
               $view_profile = get_post_meta($post, 'jobcircle_field_apply_view_profile', true);
               $view_profile_url = get_post_meta($post, 'jobcircle_field_apply_view_profile_url', true);

               $facebook_url = get_post_meta($post, 'jobcircle_field_apply_fb_url', true);
               $twitter_url = get_post_meta($post, 'jobcircle_field_apply_tw_url', true);
               $instagram_url = get_post_meta($post, 'jobcircle_field_apply_in_url', true);
            ?>
               <div class="col-12 col-sm-6 col-lg-3 mb-20 mb-md-30">
							<!-- Team Member Box -->
							<article class="team-box">
								<div class="image-holder">
                                <?php
                        if (!empty($image)){
                           ?>
                       <img src="<?php echo esc_url_raw($image[0]) ?>" width="352" height="386" alt="Alex Johnson">
                           <?php
                        }
                        ?>
									
									<div class="button-overplay">
                                    <?php
                   if (!empty($view_profile_url)) {
                       ?>
                       <a href="<?php echo esc_html($permalinkget) ?>" class="btn btn-primary"><span class="btn-text"><?php echo esc_html($view_profile) ?></span></a>

                       <?php
                     }
                     ?>
										
									</div>
								</div>
								<div class="textbox">
                                    <?php if(!empty($title)){
                                        ?>                
                       <h3 class="h4"><a href="<?php echo esc_html($permalinkget) ?>"><?php echo esc_html($title) ?></a></h3>
                        <?php
                         }
                         ?>
						<?php if(!empty($skill)){?>
                       <span class="subtext"><?php echo esc_html($skill) ?></span>
                        <?php } ?>
									
									<ul class="social-networks">
                                    <?php
                        if (!empty($facebook_url)){
                           ?>
                       <li><a href="<?php echo esc_html($facebook_url) ?>"><i class="fa fa-facebook"></i></a></li>
                           <?php
                        }
                        if (!empty($twitter_url)){
                           ?>
                       <li><a href="<?php echo esc_html($twitter_url) ?>"><i class="fa fa-twitter"></i></a></li>
                           <?php
                        }
                        if (!empty($instagram_url)){
                           ?>
                       <li><a href="<?php echo esc_html($instagram_url) ?>"><i class="fa fa-instagram"></i></a></li>
                           <?php
                        }
                        ?>				
										
									</ul>
								</div>
							</article>
						</div>         
               <?php
           }
       }
       // Restore original post data
       wp_reset_postdata();
       ?>
             </div>
			</div>
			</section>
       <?php
}
    return ob_get_clean();
}
add_shortcode( 'talented_teams', 'jobcircle_talented_teams_frontend' );
