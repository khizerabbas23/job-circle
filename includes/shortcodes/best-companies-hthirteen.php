<?php
function jobcircle_companies_hthirteen() {   
             $terms = get_terms(
		array(
			'taxonomy' => 'employer_cat',
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
			'name' => __( 'Companies HThirteen' ),
			'base' => 'jobcircle_companies_hthirteen',
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
                        'type' => 'textarea',
                        'holder' => 'div',
                        'class' => '',
                        'heading' => __( 'Description' ),
                        'param_name' => 'disc',
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
        		  'type' => 'dropdown',
        		  'holder' => 'div',
        		  'class' => '',
        		  'heading' => __('Select Category For Post'),
        		  'param_name' => 'dropdown_param',
        		  'value' => $job_types,
        		),
			 )	
		 )
	 );
 }
 add_action( 'vc_before_init', 'jobcircle_companies_hthirteen' ); 
 
 // Frontend Coding 
 
 function jobcircle_companies_hthirteen_frontend( $atts, $content ) {
 
	$atts = shortcode_atts(
	array(
		
		'title' => '',
		'disc' => '',
        'orderby' => '',
        'numofpost' => '',
		  'dropdown_param' => '',
	), $atts, 'jobcircle_companies_hthirteen'
 );
 
 $title = isset($atts['title']) ? $atts['title'] : '';
 $disc = isset($atts['disc']) ? $atts['disc'] : '';
 $dropdown_param = isset($atts['dropdown_param']) ? $atts['dropdown_param'] : '';
 $job_type_arr = !empty($dropdown_param) ? explode(',', $dropdown_param) : '';
ob_start();
 ?>
						<section class="section section-theme-13 companies-remote-block bg-white pt-35 pt-md-50 pt-lg-75 pt-xxl-120 pb-50 pb-lg-80">
				<div class="container">
					<header class="section-header d-flex flex-column mb-0">
						<div class="row justify-content-between align-items-center">
							<div class="col-12 col-md-8 col-lg-5">
                            <?php if(!empty($disc)){
                                    ?>
								<p><?php echo esc_textarea($disc) ?></p>
                                <?php
                                }
                                ?>
                                <?php if(!empty($title)){
                                    ?>
								<h2><?php echo jobcircle_esc_the_html($title) ?></h2>
                                <?php
                                }
                                ?>
							</div>
						</div>
					</header>
					<div class="companies-remote-carousel">
    
                    <?php 
                    $numofpost  = isset($atts['numofpost']) ? $atts['numofpost'] : '';
                    $orderby  = isset($atts['orderby']) ? $atts['orderby'] : '';
                    
                     $include_category_ids = $job_type_arr;
                    $args = array(
                        'post_type' => 'employer',
                         'post_status' => 'publish',                                                                                                                                                                                             
                          'posts_per_page' => $numofpost, 
                          'order' => 'DESC',                     
                          'orderby' =>  $orderby, 
                     'tax_query' => array(
                  array(
                      'taxonomy' => 'employer_cat',
                      'field' => 'term_id', // Use term_id instead of slug
                      'terms' => $include_category_ids,
                      'include_children' => false, // Set to true if you want to include posts from child categories
              ),
           )
                              );         
                     // Custom query.
                     $query = new WP_Query( $args );
                                
                     // Check that we have query results.
                     if ( $query->have_posts() ) {
                     
                         // Start looping over the query results.
                         while ( $query->have_posts() ) {
                             $query->the_post();

                             $post =  get_the_id();
                            //  $post_author = $post->post_author;
                             $titl = get_the_title($post);
                             $permalinkget = get_the_permalink($post);
                             $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post ), 'single-post-thumbnail' );
                             $member = get_post_meta($post,'team_size', true);
                            //  $loc = get_post_meta($post,'location', true);
    			            $job_location = jobcircle_post_location_str($post);
                            $icon_image = get_post_meta($post, 'jobcircle_field_user_icon_image', true);

                            //  $icon_image = get_post_meta($post,'icon_image', true);
                            //  $imageurll = get_post_meta($post, 'imageurll', true);
                             $imag = get_post_meta($post,'image', true);
                             $imageurll = get_post_meta($post, 'jobcircle_field_user_image_url', true);




                             $args = array(
                                // 'author' => $post_author,
                                'post_type' => 'post',
                                'post_status' => 'publish',
                                'posts_per_page' => -1
                            );
                            
                            $author_query = new WP_Query($args);
                            $author_post_count = $author_query->post_count;
                            ?>
   					<div class="slide-box">
							<a href="<?php echo $permalinkget ?>" class="box">
							    <?php
							    if(!empty($image[0])){
							        ?>
								<img src="<?php echo esc_url_raw($image[0])?>" alt="icon" class="tag-icon brdr">
								<?php
							    }
							    ?>
							    <?php
							    if(!empty($imageurll)){
							        ?>
								<div class="image-holder"><img src="<?php echo esc_url_raw($imageurll)?>" alt="image"></div>
								<?php
							    }
							    ?>
								<div class="text-info-box">
								    <?php
								    if(!empty($titl) || !empty($icon_image)){
								        ?>
									<strong class="title"><?php echo jobcircle_esc_the_html($titl); ?> <img src="<?php echo esc_url_raw($icon_image)?>" alt="tick"></strong>
									<?php
								    }
								    ?>
									<ul class="list-inline tags-items">
										<li>
											<i class="jobcircle-icon-map-pin icon"></i>
											<?php
											if(!empty($job_location)){
											    ?>
											<?php echo jobcircle_esc_the_html($job_location) ?>
											<?php
											}
											?>
										</li>
										<li>
										    <?php
										    if(!empty($member)){
										        ?>
											<i class="jobcircle-icon-users icon"></i><?php echo jobcircle_esc_the_html($member); ?>
											<?php  
										    }
										    ?>
										</li>
									</ul>
									<div class="card-footer">
										<span class="txt"><?php echo jobcircle_esc_the_html($author_post_count); ?> <?php echo esc_html_e('jobs available','jobciecle-frame');?></span>
										<span class="rating"><i class="jobcircle-icon-star icon"></i><?php echo esc_html_e('5.0','jobciecle-frame');?></span>
									</div>
								</div>
							</a>
						</div>
    <?php 
    }
}
    ?>
   </div>
				</div>
			</section>
 <?php
	return ob_get_clean();
 }
 add_shortcode( 'jobcircle_companies_hthirteen', 'jobcircle_companies_hthirteen_frontend');