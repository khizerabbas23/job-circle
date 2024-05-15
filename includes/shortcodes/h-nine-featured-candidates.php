<?php
function jobcircle_featur_candidate_hnine() {   
         $terms = get_terms(
		array(
			'taxonomy' => 'candidate_cat', 
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
             'name' => __( 'Featured Candidate' ),
             'base' => 'jc_featur_candidate_hnine',
             'category' => __( 'Job Circle' ),
             'params' => array(
                        array(
                            'type' => 'jobcircle_browse_img',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __( 'Background Image'),
                            'param_name' => 'bg_image',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __( 'Title'),
                            'param_name' => 'title',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __( 'Heading' ),
                            'param_name' => 'heading',
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
add_action( 'vc_before_init', 'jobcircle_featur_candidate_hnine' );
// popular category frontend
function jobcircle_featur_candidate_hnine_frontend( $atts, $content ) {
    $atts = shortcode_atts(
    array(
        'title' => '',
        'heading' => '',
        'bg_image' => '',
        'orderby' => '',
		'numofpost' => '',
		   'dropdown_param' => '',
        ), 
    $atts, 'jobcircle_featur_candidate_hnine');
    $title  = isset($atts['title']) ? $atts['title'] : '';
    $heading  = isset($atts['heading']) ? $atts['heading'] : '';
    $bg_image  = isset($atts['bg_image']) ? $atts['bg_image'] : '';
    $dropdown_param = isset($atts['dropdown_param']) ? $atts['dropdown_param'] : '';
        $job_type_arr = !empty($dropdown_param) ? explode(',', $dropdown_param) : '';
 $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
 $output ='';
 ob_start();?>	
 <?php 
 if(!empty($bg_image)){
     ?>
		<section class="section section-theme-9 featured_candidates" style="background-image: url(<?php echo esc_url_raw($bg_image) ?>;);">
		    <?php } ?>
				<div class="container">
					<!-- Section header -->
					<header class="section-header d-flex flex-column text-center mb-15 mb-md-30 mb-xl-50">
					    <?php if(!empty($title)){
					        ?>
						<p><?php echo esc_html($title ) ?></p>
						<?php } 
						if(!empty($heading)){?>
						<h2><span class="text-outlined"><?php echo esc_html($heading ) ?></span></h2>
						<?php } ?>
					</header>
					<div class="featured_candidate_slider">
 <?php
        $numofpost  = isset($atts['numofpost']) ? $atts['numofpost'] : '';
        $orderby  = isset($atts['orderby']) ? $atts['orderby'] : '';
        $include_category_ids = $job_type_arr;
        $args = array(
           'post_type' => 'candidates', //enter post type name static
            'post_status' => 'publish',                                                                                                                                     
             'posts_per_page' => $numofpost, 
             'order' => 'DESC',                     
             'orderby' =>  $orderby, 
             'tax_query' => array(
                  array(
                      'taxonomy' => 'candidate_cat',
                      'field' => 'term_id', // Use term_id instead of slug
                      'terms' => $include_category_ids,
                      'include_children' => false, // Set to true if you want to include posts from child 
                      
              ),
           ),   
                 );         
        // Custom query.
       $query = new WP_Query( $args );
// Check that we have query results.
if ( $query->have_posts() ) {        
    // Start looping over the query results.
    while ( $query->have_posts() ) {
        $query->the_post();
        global $post;
        $post =  get_the_id();
        $title = get_the_title($post);
        $categories = get_the_terms( $post, 'candidate_cat' );
        $permalinkget = get_the_permalink($post);
        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post ), 'single-post-thumbnail' );
    	$job_salary = jobcircle_candidate_salary_str($post, '', 'sub');
        $country = jobcircle_post_location_str($post);
        $experienc = get_post_meta($post, 'jobcircle_field_experience', true); 
        $categories = get_the_terms( $post, 'candidate_cat' );
?>
             <div>
							<div class="candidate_info">
								<div class="icon_wrap">
                                    <img src="<?php echo Jobcircle_Plugin::root_url()?>/images/icon_flash.svg" alt="img">								
								</div>
								<div class="candidate_img">
								    <?php if(!empty($permalinkget) && !empty($image)){
								        ?>
                                    <a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>">
									<img src=" <?php echo esc_url_raw($image[0]) ?>" alt="img">
                                    </a>
                                    <?php } ?>
								</div>
								<div class="info_holder">
								    <?php if(!empty($permalinkget) || !empty($title)){
								        ?>
                                    <a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>">
									<strong class="h6" ><?php echo esc_html($title) ?></strong>
                                    </a>
                                    
<?php 
$counter = 1;
if (!empty($categories)) {
    foreach ($categories as $category) { 
        if ($counter == 1){
            $category_link = esc_url(get_term_link($category)); ?>
            <p>
                <a href="<?php echo jobcircle_esc_the_html($category_link); ?>">
                    <?php echo esc_html($category->name); ?>
                </a>
            </p>         
        <?php 
            $counter++; // Increment counter inside the loop
        } else {
            break;
        }
    }
}
?>


                                        
									<ul class="location_info">
										<li>
											<i class="jobcircle-icon-map-pin icon"></i>
                                            <?php if(!empty($country)){ ?>
											<span class="text"><?php echo esc_html($country) ?></span>
                                            <?php } ?>
										</li>
										<li>
											<i class="jobcircle-icon-briefcase3 icon"></i>
                                            <?php if(!empty($experienc)){ ?>
											<span class="text"><?php echo esc_html($experienc) ?></span>
                                            <?php } ?>
										</li>
									</ul>
									<div class="view_profile">
                                    <?php if(!empty($job_salary)){ ?>
										<span class="amount subclass"><strong><?php echo jobcircle_esc_the_html($job_salary) ?></strong></span>
                                        <?php } 
                                        if(!empty($permalinkget)){
                                        ?>
										<a href="<?php echo esc_html($permalinkget) ?>" class="btn btn-white btn-sm newp" style ="padding: 16px 37px 14px;"><?php esc_html_e('View Profile', 'jobecircle-frame') ?></a>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
               <?php
    }
}
wp_reset_postdata();
?>
            </div>
				</div>
			</section>
        <?php return ob_get_clean();
}
}
add_shortcode( 'jc_featur_candidate_hnine', 'jobcircle_featur_candidate_hnine_frontend' );