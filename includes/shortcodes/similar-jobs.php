<?php
function jobcircle_smiilar() {   
    vc_map(       
       array(
             'name' => __( 'Similar Jobs' ),
             'base' => 'jobcircle_smiilar',
             'category' => __( 'jobcircle' ),
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
				'heading' => __( 'Discription' ),
				'param_name' => 'dis',
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
add_action( 'vc_before_init', 'jobcircle_smiilar' );
// popular category frontend
	function jobcircle_smiilar_frontend( $atts, $content ) {
		$atts = shortcode_atts(
		array(
			'orderby' => '',
			'numofpost' => '',
			'dis' =>'',
			'title' =>'',
			), 
		$atts, 'jobcircle_smiilar');
	$custom_plan_price = isset($atts['title']) && !empty($atts['title']) ? $atts['title'] : '';

	 $title  = isset($atts['title']) ? $atts['title'] : '';
	 $dis  = isset($atts['dis']) ? $atts['dis'] : '';
 ob_start();
 ?>	
			<section class="section section-theme-1 section-categories related-categories bg-light-sky pt-35 pt-md-50 pt-lg-65 pt-xl-80 pt-xxl-110 pb-35 pb-md-50 pb-lg-65 pb-xl-80 pb-xxl-110">
				<div class="container">
					<div class="row justify-content-between mb-35 mb-lg-40">
						<div class="col-12 col-lg-8 col-xl-5">
							<!-- Section header -->
							<header class="section-header text-center text-lg-start mb-10 m-lg-0">
								<?php
								if(!empty($title)){  ?>
								<h2><?php echo esc_html($title) ?></h2>
								<?php }
								if(!empty($dis)){ ?>
								<p><?php echo esc_html($dis,'jobcircle-frame') ?></p>
								<?php } ?>
							</header>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<div class="jobs-listing-slider">
 <?php
        $numofpost  = isset($atts['numofpost']) ? $atts['numofpost'] : '';
        $orderby  = isset($atts['orderby']) ? $atts['orderby'] : '';
        $args = array(
           'post_type' => 'jobs', //enter post type name static
            'post_status' => 'publish',                                                                                                                                     
             'posts_per_page' => $numofpost, 
             'order' => 'DESC',                     
             'orderby' =>  $orderby, 

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
                $permalinkget = get_the_permalink($post);
                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post ), 'single-post-thumbnail' );
                $job_type = get_post_meta($post, 'jobcircle_field_job_type', true);
                $country = get_post_meta($post, 'jobcircle_field_loc_country', true);
               $posted = get_the_time('U');
				$minut =  human_time_diff($posted,current_time( 'U' )). "";
                $max_salary = get_post_meta($post, 'jobcircle_field_max_salary', true);
                $salary_unit = get_post_meta($post, 'jobcircle_field_salary_unit', true);
                $admin = get_the_author();
             ?>	
             	<div class="slick-slide">
									<!-- Featured Category Box -->
									<article class="featured-category-box">
									    <?php if(!empty($job_type)) { ?>
										<span class="tag"><?php echo esc_html($job_type) ?></span>
									<?php } ?>
										<div class="img-holder">
										    <?php if(!empty($image)){ ?>
											<img src="<?php echo esc_url_raw($image[0]) ?>" width="78" height="78" alt="Financial Analyst"> <?php } ?>
										</div>
										<div class="textbox">
										    <?php if(!empty($title) || !empty ($admin) || !empty($country)) { ?>
											<strong class="h6"><?php echo esc_html($title) ?></strong>
											<span class="subtitle"><?php esc_html_e('By','jobcircle-frame')?> <?php echo esc_html($admin) ?></span>
											<address class="location"><i class="jobcircle-icon-map-pin icon"></i><span class="text"><?php echo esc_html($country) ?></span></address>
											<?php } ?> 
											<div class="job-info">
											    <?php if(!empty($minut) || !empty($max_salary) || !empty($salary_unit)) { ?>
												<span class="subtext"><?php echo esc_html($minut) ?></span>
										<span class="amount"><strong><?php echo esc_html($max_salary) ?></strong>/<?php echo esc_html($salary_unit) ?></span>
											<?php } ?>
											</div>
											<?php if(!empty($permalinkget)){ ?>
											<a href="<?php echo esc_html($permalinkget) ?>" class="btn btn-dark-yellow btn-sm"><span class="btn-text"><span class="text"><?php esc_html_e('Apple Now','jobcircle-frame')?></span><i class="icon-chevron-right"></i></span></a>
										<?php } ?> 
										</div>
									</article>
								</div>
								<?php
							}
						}
						wp_reset_postdata();?>
							  </div>
						</div>
					</div>
				</div>
			</section>
						<?php return ob_get_clean();
				}
				add_shortcode( 'jobcircle_smiilar', 'jobcircle_smiilar_frontend' );