<?php
function get_customs_pots_categori()
{
	$categories = get_terms(
		array(
			'taxonomy' => 'employer_cat',
			'hide_empty' => false,
		)
	);
	$category_options = array();

	if ($categories && !is_wp_error($categories)) {
		foreach ($categories as $category) {
			$category_options[wp_specialchars_decode($category->name)] = $category->slug;
		}
	}
	return $category_options;
}
   function jobcircle_hfifteen_top_expert() {  

    vc_map( 

       array(
             'name' => __( 'Top Expert Home 15' ),
             'base' => 'jobcircle_hfifteen_top_expert',
             'category' => __( 'Job Circle' ),
             'params' => array(
                     array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __( 'Sub title' ),
                    'param_name' => 'sub_title',
                   ),
                   array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __( 'Title' ),
                    'param_name' => 'titl',
                   ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __( 'Discription' ),
                    'param_name' => 'disc',
                   ),
                   array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __( 'Colour review' ),
                    'param_name' => 'colour_review',
                   ),
                   array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __( 'out Of review' ),
                    'param_name' => 'out_of_review',
                   ),
                   array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __( 'Satisfied customer' ),
                    'param_name' => 'satifised_customer',
                   ),
                   array(
					'type' => 'dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Select Category For Post'),
					'param_name' => 'category_selector',
					'value' => array_merge(
						array('Select Category' => ''),
						get_customs_pots_categori()
					),
				),  
                   array(
                    'type' => 'attach_image',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __( 'Star image' ),
                    'param_name' => 'star_img',
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
add_action( 'vc_before_init', 'jobcircle_hfifteen_top_expert' );
// popular category frontend
function jobcircle_hfifteen_top_expert_frontend( $atts, $content ) {
    $atts = shortcode_atts(
    array(
        'sub_title' => '', 
        'titl' => '',
        'disc' => '',
        'colour_review' => '',
        'out_of_review' => '',
        'satifised_customer' => '',
        'star_img' => '',
        'orderby' => '',
		'numofpost' => '',
        'category_selector' => '',
    ), $atts, 'jobcircle_hfifteen_top_expert');
 $sub_title  = isset($atts['sub_title']) ? $atts['sub_title'] : '';
  $titl  = isset($atts['titl']) ? $atts['titl'] : '';
  $disc  = isset($atts['disc']) ? $atts['disc'] : '';
  $colour_review  = isset($atts['colour_review']) ? $atts['colour_review'] : '';
  $out_of_review  = isset($atts['out_of_review']) ? $atts['out_of_review'] : '';
  $satifised_customer  = isset($atts['satifised_customer']) ? $atts['satifised_customer'] : '';
  $star_img = wp_get_attachment_image_src($atts["star_img"],'full');
  $selectedcategory  = isset($atts['category_selector']) ? $atts['category_selector'] : '';
ob_start()
?>
<section class="section section-theme-15 top-experts-block pt-0 pt-lg-30 pt-xl-60 pt-xxl-90 pb-0">
				<div class="container">
					<div class="row">
						<div class="col-12 col-md-4">
							<div class="text-frame">
                                <?php
                                if(!empty($sub_title) && !empty($titl) && !empty($disc)){
                                    ?>
								<span class="text"><?php echo esc_html($sub_title) ?></span>
								<h2><?php echo esc_html($titl) ?></h2>
								<p><?php echo esc_textarea($disc) ?></p>
                                <?php
                                }
                                ?>
							</div>
							<div class="experts-reviews">
                            <?php
                                if(!empty($colour_review) && !empty($out_of_review) && !empty($satifised_customer) && !empty($star_img)){
                                    ?>
								<strong class="reviews-score"><span><?php echo esc_html($colour_review) ?></span><?php echo esc_html($out_of_review) ?></strong>
								<p><?php echo esc_html($satifised_customer) ?></p>
								<img src="<?php echo esc_url_raw($star_img[0]) ?>" alt="stars">
                                <?php
                                }
                                ?>
							</div>
						</div>
						<div class="col-12 col-md-8">
							<div class="experts-frame">
<?php
        $numofpost  = isset($atts['numofpost']) ? $atts['numofpost'] : '';
        $orderby  = isset($atts['orderby']) ? $atts['orderby'] : '';
//this one
        $page_numbr = get_query_var('paged');
        $args = array(
           'post_type' => 'employer',
            'post_status' => 'publish',                                                                                                                                                                                             
             'posts_per_page' => $numofpost, 
             'order' => 'DESC',            
             'paged' => $page_numbr, 
             'orderby' =>  $orderby,  
             'tax_query' => array(                           
                array(
                    'taxonomy' => 'employer_cat',
                    'field'    => 'slug',
                    'terms'    => $selectedcategory,
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
                $post =  get_post();   
                $postid =  $post->ID;       
                $title = get_the_title($postid);
                $Designation = get_post_meta($postid, 'jobcircle_field_Designation', true);
                $permalinkget = get_permalink($postid);
                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $postid ), 'single-post-thumbnail' );
                $date = get_the_date('M, d, Y');
?>
                        <div class="expert-box">
									<a href="<?php echo esc_html($permalinkget) ?>">
										<div class="expert-info">
                                            <?php
                                            if(!empty($title)){
                                                ?>
											<h3><?php echo esc_html($title) ?></h3>
                                            <?php
                                            }
                                            ?>
                                            <?php
                                            if(!empty($Designation)){
                                                ?>
											<strong class="designation"><?php echo esc_html($Designation) ?></strong>
											<?php
                                            }
                                            ?>
										</div>
                                        <?php
                                            if(!empty($image)){
                                                ?>
										<img src="<?php echo esc_url_raw($image[0]) ?>" alt="image">
                                        <?php
                                            }
                                            ?>
									</a>
								</div>
<?php
            }
        }
       //also this one         
       wp_reset_postdata();
        ?>
                            </div>
						</div>
					</div>
				</div>
			</section>
    <?php 
    return ob_get_clean();
}
add_shortcode( 'jobcircle_hfifteen_top_expert', 'jobcircle_hfifteen_top_expert_frontend' );