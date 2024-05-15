<?php
function get_custom_post_categories() {
    $categories = get_terms(array(
        'taxonomy' => 'candidate_cat',
        'hide_empty' => false,
    ));

    $category_options = array();

    if ($categories && !is_wp_error($categories)) {
        foreach ($categories as $category) {
            $category_options[$category->name] = $category->slug;
        }
    }

    return $category_options;
}


function jobcircle_popular_candidates_dview() {
	vc_map(	   
		array(
			'name' => __( 'Candidate D-View' ),
			'base' => 'jobcircle_popular_candidates_dview',
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
                'type' => 'jobcircle_browse_img',
                'holder' => 'div',
                'class' => '',
                'heading' => __( 'Upload Image' ),
                'param_name' => 'image',
            ),  
            array(
                'type' => 'jobcircle_browse_img',
                'holder' => 'div',
                'class' => '',
                'heading' => __( 'Upload Background Image' ),
                'param_name' => 'bgimage',
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
            	array(
                'type' => 'dropdown',
                'holder' => 'div',
                'class' => '',
                'heading' => __('Select Category For Post'),
                'param_name' => 'category_selector',
                'value' => get_custom_post_categories(),
              ),
			)	
		)
	);
 }
 add_action( 'vc_before_init', 'jobcircle_popular_candidates_dview' ); 
 // Frontend Coding  
 function jobcircle_popular_candidates_dview_front( $atts, $content ) { 
	$atts = shortcode_atts(
	array(		
		'title' => '',
		'disc' => '',        
		'image' => '',
		'bgimage' => '',
        'orderby' => '',
		'numofpost' => '',
		'category_selector' => '',

	), $atts, 'jobcircle_popular_candidates_dview'
 );
 
 $title = isset($atts['title']) ? $atts['title'] : '';
 $disc = isset($atts['disc']) ? $atts['disc'] : '';

 $image = isset($atts['image']) ? $atts['image'] : '';
 $bgimage = isset($atts['bgimage']) ? $atts['bgimage'] : '';

 ob_start();
 ?> 

 	<section class="section section-theme-4 candidate-block bg-light-gray pt-35 pt-md-50 pt-lg-75 pt-xxl-120 pb-80 pb-md-100 pb-lg-150 pb-xxl-160" style="background-image: url('<?php echo esc_url_raw($bgimage) ?>');">
 
		<div class="container">
     <!-- Section header -->
     <header class="section-header d-flex flex-column text-center mb-50 mb-lg-70">
        <?php
        if(!empty($title)){ ?>
         <h2><?php jobcircle_esc_the_html($title) ?></h2>
         <?php } ?>
         <?php
         if(!empty($disc)){ ?>
         <p><?php jobcircle_esc_the_html($disc) ?></p>
         <?php } ?>
         <?php
         if(!empty($image)){ ?>
         <img src="<?php echo esc_url_raw($image) ?>" width="26" alt="icon">
         <?php } ?>
     </header>
     <div class="candidate-carousel">
     <?php
     
        $numofpost  = isset($atts['numofpost']) ? $atts['numofpost'] : '';
        $orderby  = isset($atts['orderby']) ? $atts['orderby'] : '';
        $selectedcategory  = isset($atts['category_selector']) ? $atts['category_selector'] : '';
        $args = array(
             'post_type' => 'candidates',
             'post_status' => 'publish',                                                                                                                                                                                             
             'posts_per_page' => $numofpost, 
             'order' => 'DESC',  
             'orderby' =>  $orderby,   
             'tax_query' => array(
             array(
                 'taxonomy' => 'candidate_cat',
                 'field'    => 'slug',
                 'terms'    => $selectedcategory,
             ),
         ),   
             
             
      );         
    
        // Custom query.
        $query = new WP_Query($args);
        $total_posts = $query->found_posts;
    
        // Check that we have query results.
        if ($query->have_posts()) {
    
            // Start looping over the query results.
            while ($query->have_posts()) {
    
                $query->the_post();
                $id = get_the_id();
                $post = get_post();
                $postid = $post->ID;
                $title = get_the_title($postid);
                $permalinkget = get_the_permalink($postid);
               // $excerpt = get_the_excerpt($postid);
                $image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');
                $job_title = get_post_meta($postid, 'jobcircle_field_job_title', true);
                $salary_unit = get_post_meta($postid, 'jobcircle_field_salary_unit', true);
                $salary = get_post_meta($postid, 'jobcircle_field_salary', true);
         
             ?>
                        <div class="candidate-post mt-35" style="" aria-hidden="true" role="tabpanel" id="slick-slide00">
                            <?php if(!empty($permalinkget)){
                                ?>
							<a href="<?php jobcircle_esc_the_html($permalinkget) ?>" tabindex="-1">
							    <?php 
                            }?>
								<div class="image-wrap">
									<div class="image-holder">
									     <?php if(!empty($image)){
                                ?>
										<img src="<?php jobcircle_esc_the_html($image[0]) ?>" alt="image">
										<?php 
                                         }?>
									</div>
									
								</div>
								<div class="text-info">
									<div class="title-bar">
									    <?php if(!empty($title)){
									        ?>
										<h3><?php jobcircle_esc_the_html($title) ?></h3>
										<?php } ?>
                                        <?php if(!empty($job_title)) { ?>
										<p><?php jobcircle_esc_the_html($job_title) ?> </p>
                                        <?php } ?>
									</div>
                                    <!-- &amp; Graphic Design -->
                                   
									<strong class="price"><?php jobcircle_esc_the_html($salary) ?><sub>/ <?php jobcircle_esc_the_html($salary_unit) ?></sub></strong>
                                  
								</div>
							</a>
						</div>
                    <?php
                 }
                }
            wp_reset_postdata();
            ?>
            </div>
<div class="row">
                    <?php if(!empty($btn_url) || !empty($btn)) { ?>
						<div class="col-12 d-flex justify-content-center pt-lg-20">
                <a href="<?php jobcircle_esc_the_html($btn_url) ?>"><button class="btn btn-purple"><span><?php jobcircle_esc_the_html($btn) ?></span>
            </button></a>
            <?php } ?>
							
						</div>
					</div>
                    </div>
			</section>
            <?php
    if ($total_posts > $numofpost) {
        ?>
        <?php echo jobcircle_pagination($query, true); 
    }
	return ob_get_clean();
 }
 add_shortcode( 'jobcircle_popular_candidates_dview', 'jobcircle_popular_candidates_dview_front');