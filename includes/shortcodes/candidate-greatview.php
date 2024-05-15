<?php
function get_cust_post_cate() {
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

function jobcircle_candidate_greatview() {   
    vc_map(       
       array(
             'name' => __( 'Candidate Great View' ),
             'base' => 'jobcircle_candidate_greatview',
             'category' => __( 'Job Circle' ),
             'params' => array(
                        array(
                            'type' => 'dropdown',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Select Pagination', 'jobcircle-frame'),
                            'param_name' => 'select_pagination',
                            'description' => __('Select Pagination', 'jobcircle-frame'),
                            'value' => array(
                                'Select Style' => '',
                                'On' => 'pagination_on',
                                'Off' => 'pagination_off',
                            ),
                          ),
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
                            'type' => 'dropdown',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __( 'Sort By' ),
                            'param_name' => 'sortby',
                            'value' => array(
                                'Select Style' => '',
                                'Ascending' => 'ASC',
                                'Descending' => 'DESC',
                            ),
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
                            'value' => get_cust_post_cate(),
                          ),
                  )
              )   
          );
 }
add_action( 'vc_before_init', 'jobcircle_candidate_greatview' );
// popular category frontend
function jobcircle_candidate_greatview_frontend( $atts, $content ) {
    $atts = shortcode_atts(
    array(
        'title' => '',
        'heading' => '',
        'bg_image' => '',
        'select_pagination' => '',
        'orderby' => '',
        'sortby' => '',
		'numofpost' => '',

		'category_selector' => '',
        ), 
    $atts, 'jobcircle_candidate_greatview');
    $title  = isset($atts['title']) ? $atts['title'] : '';
    $select_pagination  = isset($atts['select_pagination']) ? $atts['select_pagination'] : '';
    $sortby  = isset($atts['sortby']) ? $atts['sortby'] : '';
    $heading  = isset($atts['heading']) ? $atts['heading'] : '';
    $bg_image  = isset($atts['bg_image']) ? $atts['bg_image'] : '';
 $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
 $output ='';
 ob_start();?>	
 <?php 
 if(!empty($bg_image)){
     ?>
		<section class="section section-theme-9 featured_candidates candidate-great-view-section" style="background-image: url(<?php echo esc_url_raw($bg_image) ?>;);">
		    <?php } ?>
				<div class="container">
					<!-- Section header -->
					<header class="section-header d-flex flex-column text-center mb-15 mb-md-30 mb-xl-50">
					    <?php if(!empty($title)){
					        ?>
						<p><?php echo jobcircle_esc_the_html($title ) ?></p>
						<?php } 
						if(!empty($heading)){?>
						<h2><span class="text-outlined"><?php echo jobcircle_esc_the_html($heading ) ?></span></h2>
						<?php } ?>
					</header>
					<div class="featured_candidate_slider" id="featured-slide-show">
 <?php
        $numofpost = isset($atts['numofpost']) ? intval($atts['numofpost']) : -1;
        $orderby  = isset($atts['orderby']) ? $atts['orderby'] : '';
        $selectedcategory  = isset($atts['category_selector']) ? $atts['category_selector'] : '';

        $args = array(
           'post_type' => 'candidates', //enter post type name static
            'post_status' => 'publish',                                                                                                                                     
            'posts_per_page' => $numofpost, 
            'order' => $sortby,                     
            'orderby' =>  $orderby, 
            'tax_query' => array(
            array(
                'taxonomy' => 'candidate_cat', //enter taxonomy name static
                'field'    => 'slug',
                'terms'    => $selectedcategory,
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
             <div class="featured-slide-margin">
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
									<strong class="h6" ><?php echo jobcircle_esc_the_html($title) ?></strong>
                                    </a>
                                    
									<?php 
                                        if (!empty($categories)) {
                                            $cate_count = 0;
                                            foreach ($categories as $category) { 
                                                if($cate_count == 0){
                                                $category_link = esc_url(get_term_link($category)); ?>
                                                <p>
                                                    <a href="<?php echo jobcircle_esc_the_html($category_link); ?>">
                                                        <?php echo jobcircle_esc_the_html($category->name); ?>
                                                    </a>
                                                </p>         
                                            <?php }else{
                                                break;
                                            }
                                            $cate_count++;
                                            
                                        }
                                        }
                                        ?>
                                        
									<ul class="location_info">
										<li>
											<i class="jobcircle-icon-map-pin icon"></i>
                                            <?php if(!empty($country)){ ?>
											<span class="text"><?php echo jobcircle_esc_the_html($country) ?></span>
                                            <?php } ?>
										</li>
										<li>
											<i class="jobcircle-icon-briefcase3 icon"></i>
                                            <?php if(!empty($experienc)){ ?>
											<span class="text"><?php echo jobcircle_esc_the_html($experienc) ?></span>
                                            <?php } ?>
										</li>
									</ul>
									<div class="view_profile">
                                    <?php if(!empty($job_salary)){ ?>
										<span class="amount subclass"><strong><?php echo jobcircle_esc_the_html($job_salary) ?></strong></span>
                                        <?php } 
                                        if(!empty($permalinkget)){
                                        ?>
										<a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>" class="btn btn-white btn-sm newp" ><?php esc_html_e('View Profile', 'jobecircle-frame') ?></a>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
               <?php
    }
}
wp_reset_postdata();   ?>
            </div>
				</div>
			</section>
			<?php 
			if ($atts['select_pagination'] == 'pagination_on') {
			if ($total_posts > $numofpost) {
			?>
				<?php echo jobcircle_pagination($query, true);
			}
}?>
	<script>
   jQuery(document).ready(function($) {
    // Replace 'your-slider-id' with the ID of your slider element
    $('#featured-slide-show').slick({
        slidesToShow: 2, // Ek row mein sirf 2 posts
        slidesToScroll: 2, // Har baar 2 posts scroll karein
        rows: Math.ceil($('#featured-slide-show .featured-slide-margin').length / 2), // Rows count dynamic set karein
        arrows: true,
        dots: true,
        infinite: false, // Looping rokne ke liye infinite ko false set karein
        autoplay: false,
        responsive: [{
            breakpoint: 992,
            settings: {
                slidesToShow: 1, // Chhote screens par sirf 1 post dikhayein
                slidesToScroll: 1,
                rows: Math.ceil($('#featured-slide-show .featured-slide-margin').length), // Rows count dynamic set karein chhote screens par
            },
        }],
    });
});
</script>
        <?php
        return ob_get_clean();
}
}
add_shortcode( 'jobcircle_candidate_greatview', 'jobcircle_candidate_greatview_frontend' );