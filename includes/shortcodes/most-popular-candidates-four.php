<?php
function get_cust_cate_for_populor_cstmo() {
    $categories = get_terms(array(
        'taxonomy' => 'job_category',
        'hide_empty' => false,
    ));

    $category_options = array();

    if ($categories && !is_wp_error($categories)) {
        foreach ($categories as $category) {
            $category_options[wp_specialchars_decode($category->name)] = $category->slug;
        }
    }

    return $category_options;
}
function jobcircle_most_popular_candidates() {
	vc_map(	   
		array(
			'name' => __( 'Most Popular Candidate4' ),
			'base' => 'most_popular_candidates',
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
                'heading' => __( 'Discription' ),
                'param_name' => 'disc',
            ),                
            array(
                'type' => 'jobcircle_browse_img',
                'holder' => 'div',
                'class' => '',
                'heading' => __( 'Image' ),
                'param_name' => 'image',
            ),  
            array(
                'type' => 'jobcircle_browse_img',
                'holder' => 'div',
                'class' => '',
                'heading' => __( 'Background Image' ),
                'param_name' => 'bgimage',
            ),
            array(
                'type' => 'textfield',
                'holder' => 'div',
                'class' => '',
                'heading' => __( 'Buttan' ),
                'param_name' => 'btn',
            ), 
            array(
                'type' => 'textfield',
                'holder' => 'div',
                'class' => '',
                'heading' => __( 'Buttan Url' ),
                'param_name' => 'btn_url',
            ),              	
            array(
                'type' => 'textfield',
                'holder' => 'div',
                'class' => '',
                'heading' => __( 'Order By' ),
                'param_name' => 'orderby',
            ),
            array(
					'type' => 'dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Select Category For Post'),
					'param_name' => 'category_selector',
					'value' => array_merge(
						array('Select Category' => ''),
						get_cust_cate_for_populor_cstmo()
					),
				
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
 add_action( 'vc_before_init', 'jobcircle_most_popular_candidates' ); 
 // Frontend Coding  
 function jobcircle_most_popular_candidates_front( $atts, $content ) { 
	$atts = shortcode_atts(
	array(		
		'title' => '',
		'disc' => '',        
		'image' => '',
		'bgimage' => '',
		'btn_url' => '',
		'btn' => '',
        'orderby' => '',
		'numofpost' => '',
		'category_selector' => '',

	), $atts, 'jobcircle_most_popular_candidates'
 );
 
 $title = isset($atts['title']) ? $atts['title'] : '';
 $disc = isset($atts['disc']) ? $atts['disc'] : '';
 $btn = isset($atts['btn']) ? $atts['btn'] : '';
 $btn_url = isset($atts['btn_url']) ? $atts['btn_url'] : '';
$category_selector = isset($atts['category_selector']) ? $atts['category_selector'] : '';
 $image = isset($atts['image']) ? $atts['image'] : '';
 $bgimage = isset($atts['bgimage']) ? $atts['bgimage'] : '';

 ob_start();
 ?> 
 <?php if(!empty($bgimage)){ ?>
 	<section class="section section-theme-4 candidate-block bg-light-gray pt-35 pt-md-50 pt-lg-75 pt-xxl-120 pb-80 pb-md-100 pb-lg-150 pb-xxl-160" style="background-image: url('<?php echo esc_url_raw($bgimage) ?>');">
    <?php  }   ?>
		<div class="container">
     <!-- Section header -->
     <header class="section-header d-flex flex-column text-center mb-50 mb-lg-70">
        <?php
        if(!empty($title)){ ?>
         <h2><?php echo esc_html($title) ?></h2>
         <?php } ?>
         <?php
         if(!empty($disc)){ ?>
         <p><?php echo esc_html($disc) ?></p>
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
  $selectedcategory = isset($atts['category_selector']) ? $atts['category_selector'] : '';
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
               
    	        $job_salary = jobcircle_candidate_salary_str($postid , '' , 'sub');
                    	

             ?>
                        <div class="candidate-post" style="" aria-hidden="true" role="tabpanel" id="slick-slide00">
                            <?php if(!empty($permalinkget)){
                                ?>
							<a href="<?php echo esc_html($permalinkget) ?>" tabindex="-1">
							    <?php 
                            }?>
								<div class="image-wrap">
									<div class="image-holder">
									     <?php if(!empty($image)){
                                ?>
										<img src="<?php echo esc_html($image[0]) ?>" alt="image">
										<?php 
                                         }?>
									</div>
									
								</div>
								<div class="text-info">
									<div class="title-bar">
									    <?php if(!empty($title)){
									        ?>
										<h3><?php echo esc_html($title) ?></h3>
										<?php } ?>
                                        <?php if(!empty($job_title)) { ?>
										<p><?php echo esc_html($job_title) ?> </p>
                                        <?php } ?>
									</div>
                                    <!-- &amp; Graphic Design -->
                                    <?php if(!empty($job_salary)) { ?>
									<strong class="price"><?php echo ($job_salary) ?></strong>
                                    <?php } ?>
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
                <a href="<?php echo esc_html($btn_url) ?>"><button class="btn btn-purple"><span><?php echo esc_html($btn) ?></span>
            </button></a>
            <?php } ?>
							
						</div>
					</div>
                    </div>
			</section>
            <?php
        
	return ob_get_clean();
 }
 add_shortcode( 'most_popular_candidates', 'jobcircle_most_popular_candidates_front');