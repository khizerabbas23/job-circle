<?php
function jobcircle_populer_cat() {
    $terms = get_terms(
		array(
			'taxonomy' => 'job_category',
			'hide_empty' => true,
		)
	);
	$job_types = array();
	foreach ($terms as $term) {
		$job_types[$term->name] = $term->term_id;
	}
	;
    $all_page = array( __('Select Page', 'jobcircle-frame'), '');
    $args = array(
        'sort_order' => 'asc',
        'sort_column' => 'post_title',
        'hierarchical' => 1,
        'exclude' => '',
        'include' => '',
        'meta_key' => '',
        'meta_value' => '',
        'authors' => '',
        'child_of' => 0,
        'parent' => -1,
        'exclude_tree' => '',
        'number' => '',
        'offset' => 0,
        'post_type' => 'page',
        'post_status' => 'publish'
    );
    $pages = get_pages($args);
    if (!empty($pages)) {
        foreach ($pages as $page) {
            $all_page[$page->post_title] = $page->post_name;
        }
    }
	vc_map(	   
		array(
			'name' => __( 'Categories Section' ),
			'base' => 'populer_cat',
			'category' => __( 'Job Circle' ),
			'params' => array(
            array(
                'type' => 'dropdown',
                'holder' => 'div',
                'class' => '',
                'heading' => __('Jobcircle Style', 'jobcircle-frame'),
                'param_name' => 'jobcircle_style',
                'description' => __('Select Jobcircle Style', 'jobcircle-frame'),
                'value' => array(
                    'Select Style' => '',
                    'Home Category One' => 'jobcircle_style_one',
                    'Home Category Two' => 'jobcircle_style_two',
                    'Home Category Three' => 'jobcircle_style_three',
                    'Home Category Five' => 'jobcircle_style_five',
                    'Home Category Six' => 'jobcircle_style_six',
                    'Home Category Nine' => 'jobcircle_style_seven',
                ),
              ),
              array(
                'type' => 'dropdown',
                'holder' => 'div',
                'class' => '',
                'heading' => __('Jobcircle Page', 'jobcircle-frame'),
                'param_name' => 'jobcircle_page',
                'description' => __('Select Jobcircle Page', 'jobcircle-frame'),
                'value' =>  $all_page,
              ),
              array(
                'type' => 'jobcircle_browse_img',
                'holder' => 'div',
                'class' => '',
                'heading' => __( 'Background Image' ),
                'param_name' => 'bg_image',
                'dependency' => array(
                    'element' => 'jobcircle_style',  //selection param name
                    'value' => array('jobcircle_style_seven','jobcircle_style_three') // depend on selection 
                ),
            ), 
            array(
                'type' => 'jobcircle_browse_img',
                'holder' => 'div',
                'class' => '',
                'heading' => __( 'Background Image' ),
                'param_name' => 'bg_image2',
                'dependency' => array(
                    'element' => 'jobcircle_style',  //selection param name
                    'value' => array('jobcircle_style_seven') // depend on selection 
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
                'heading' => __( 'Heading' ),
                'param_name' => 'heading',
                'dependency' => array(
                    'element' => 'jobcircle_style',  //selection param name
                    'value' => array('jobcircle_style_seven') // depend on selection 
                ),
            ),
            array(
                'type' => 'textfield',
                'holder' => 'div',
                'class' => '',
                'heading' => __( 'Matched Jobs Title' ),
                'param_name' => 'matched_jobs_title',
                'dependency' => array(
                    'element' => 'jobcircle_style',  //selection param name
                    'value' => array('jobcircle_style_seven') // depend on selection 
                ),
            ),
            array(
                'type' => 'textfield',
                'holder' => 'div',
                'class' => '',
                'heading' => __( 'Matched Jobs Discription' ),
                'param_name' => 'matched_jobs_discri',
                'dependency' => array(
                    'element' => 'jobcircle_style',  //selection param name
                    'value' => array('jobcircle_style_seven') // depend on selection 
                ),
            ),
          
             array(
                'type' => 'textfield',
                'holder' => 'div',
                'class' => '',
                'heading' => __( 'Span Title' ),
                'param_name' => 'span_tit',
                'dependency' => array(
                    'element' => 'jobcircle_style',  //selection param name
                    'value' => array('jobcircle_style_one', 'jobcircle_style_three') // depend on selection 
                ),
            ),
             array(
                'type' => 'textarea',
                'holder' => 'div',
                'class' => '',
                'heading' => __( 'Description' ),
                'param_name' => 'disc',
            ),
            array(
		  'type' => 'checkbox',
		  'holder' => 'div',
		  'class' => '',
		  'heading' => __('Checkbox Options'),
		  'param_name' => 'checkbox_param',
		  'value' => $job_types,
          'dependency' => array(
            'element' => 'jobcircle_style',  //selection param name
            'value' => array('jobcircle_style_two' , 'jobcircle_style_three') // depend on selection 
        ),
		),
            array(
                'type' => 'textfield',
                'holder' => 'div',
                'class' => '',
                'heading' => __( 'Find More Url' ),
                'param_name' => 'find_more_url',
                'dependency' => array(
                    'element' => 'jobcircle_style',  //selection param name
                    'value' => array('jobcircle_style_six') // depend on selection 
                ),
            ),                       	 
			)	
		)
	);
 }
 add_action( 'vc_before_init', 'jobcircle_populer_cat' ); 
 // Frontend Coding  
 function span_titimony_front( $atts, $content ) { 
	$atts = shortcode_atts(
	array(		
		'title' => '',
		'heading' => '',
		'bg_image' => '',
		'bg_image2' => '',
		'matched_jobs_title' => '',
		'matched_jobs_discri' => '',
		'span_tit' => '',
		'disc' => '',        
		'find_more_url' => '',   
		'checkbox_param' => '',
        
		'jobcircle_page' => '',        
        
		'jobcircle_style' => '',

	), $atts, 'jobcircle_populer_cat'
 );
 
 $title = isset($atts['title']) ? $atts['title'] : '';
 $heading = isset($atts['heading']) ? $atts['heading'] : '';
 $bg_image = isset($atts['bg_image']) ? $atts['bg_image'] : '';
 $bg_image2 = isset($atts['bg_image2']) ? $atts['bg_image2'] : '';
 $matched_jobs_title = isset($atts['matched_jobs_title']) ? $atts['matched_jobs_title'] : '';
 $matched_jobs_discri = isset($atts['matched_jobs_discri']) ? $atts['matched_jobs_discri'] : '';
 $span_tit = isset($atts['span_tit']) ? $atts['span_tit'] : '';
 $disc = isset($atts['disc']) ? $atts['disc'] : '';
 $find_more_url = isset($atts['find_more_url']) ? $atts['find_more_url'] : '';
 $checkbox_param = isset($atts['checkbox_param']) ? $atts['checkbox_param'] : '';
  $job_type_arr = !empty($checkbox_param) ? explode(',', $checkbox_param) : '';
  
 $jobcircle_page = isset($atts['jobcircle_page']) ? $atts['jobcircle_page'] : '';

 $custom_plan_price = isset($atts['nb_Circletitle']) && !empty($atts['nb_Circletitle']) ? $atts['nb_Circletitle'] : '';
 
 if ($atts['jobcircle_style'] == 'jobcircle_style_one') {
 ob_start();
 ?>             
    <section class="section section-categories pt-35 pt-md-50 pt-lg-65 pb-0">
				<div class="container">
					<!-- Section header -->
					<header class="section-header text-center mb-30 mb-md-45 mb-xl-60">
                    <?php if(!empty( $title) || !empty($span_tit)){ ?>      
						<h2><?php echo esc_html($title) ?> <span class="text-primary"><?php echo esc_html($span_tit) ?></span></h2>
                        <?php } ?>
						<div class="seprator editr"></div>
                        <?php if(!empty( $disc)){ ?>      

						<p><?php echo esc_textarea($disc) ?></p>
                        <?php } ?>
					</header>
					<div class="row">
    <?php
    $exclude_category_ids = array(84,92,96);

    
    // Fetch the terms for the custom taxonomy 'job_featured'
    $terms = get_terms( array(
        'taxonomy' => 'job_category',
        'post_type' => 'jobs',
        'hide_empty' => false,
        'parent' => 0,
        'exclude' => $exclude_category_ids,
    ) 
);
$counter = 1;
foreach ($terms as $term) {
    if ($counter <= 6) {
    
        $args = array(
            'post_type' => 'jobs',
            'tax_query' => array(
                array(
                    'taxonomy' => 'job_category',
                    'field'    => 'term_id',
                    'terms'    => $term->term_id,
                ),
            ),
        );
        $query = new WP_Query( $args );
        $post_count = $query->found_posts;

        $term_id = $term->term_id;
		$term_meta = get_term_meta($term_id, 'job_category_custom_fields', true);

		$cat_icon = isset($term_meta['icon']) ? $term_meta['icon'] : '';
        $category_link = get_category_link($term_id);

        $jobcircle_page_id = jobcircle_get_page_id_from_name($jobcircle_page);
    $jobcircle_page_url = home_url('/');
    if ($jobcircle_page_id > 0) {
        $jobcircle_page_url = get_permalink($jobcircle_page_id);
    }
    ?>
        <div class="col-12 col-md-6 col-xl-4 mb-15 mb-md-30">
            <!-- Category Box -->
            <?php if(!empty($jobcircle_page_url || $term)){
                ?>
            <a href="<?php echo esc_url($jobcircle_page_url);?>?job_category=<?php echo jobcircle_esc_the_html($term->slug )?>" class="category-box">
                <?php 
            }?>
                <div class="textbox">
                    <div class="icon">
                         <?php if(!empty($cat_icon)){
                ?>
                        <i class="<?php echo esc_html($cat_icon) ?>"></i>
                        <?php 
                         }?>
                    </div>
                      <?php if(!empty($term)){
                     ?>
                    <h3 class="h5"><?php echo nl2br($term->name); ?></h3>
                    <?php 
                     }
                     if(!empty($term)){
                     ?>
                    <p><?php echo jobcircle_esc_the_html($term->description); ?></p>
                    <?php 
                     }
                     ?>
                </div>
                <footer class="post-footer">
                    <?php 
                    if(!empty($post_count)){
                        ?>
                    <strong class="num-jobs"><?php echo esc_html($post_count); ?><?php esc_html_e('+ Jobs', 'jobcircle-frame') ?></strong>
                    <?php 
                    }
                    ?>
                    <div class="icon">
                        <?php 
                    if(!empty($cat_icon)){
                        ?>
                        <i class="<?php echo esc_html($cat_icon) ?>"></i>
                         <?php 
                    }
                    ?>
                    </div>
                </footer>
            </a>
        </div>
    <?php 
    $counter++;
    }else{
        break;
    }
}
    ?>
</div>

				</div>
			</section>
 <?php
}
elseif ($atts['jobcircle_style'] == 'jobcircle_style_two') {
    ob_start();
    ?>

<section class="section section-theme-1 section-trending-categories pt-35 pt-md-50 pt-lg-65 pb-35px pb-md-50 pb-lg-65">
				<div class="container">
					<!-- Section header -->
					<header class="section-header text-center mb-30 mb-md-45 mb-xl-60">
						<div class="seprator"></div>
                        <?php
                        if(!empty($title)){
                            ?>
						<h2><?php echo esc_html($title) ?></h2>
                        <?php
                        }
                        if(!empty($disc)){
                            ?>
						<p><?php echo esc_html($disc) ?></p>
                        <?php
                        }
                        ?>
					</header>
					<div class="trending-categories-slider">
                    <?php
                    $argss = array(
                        'taxonomy' => 'job_category',
                        'post_type' => 'jobs',
                        'hide_empty' => true,
                        'parent' => 0,
                        'orderby' => 'term_id',
                    );
                    if(isset($job_type_arr) && !empty($job_type_arr)){
                        $argss['include'] = $job_type_arr ;
                    }
                    $terms = get_terms($argss);
    
                    $counter = 0;
                    foreach ($terms as $term) {
                        if ($counter < 6 || !empty($job_type_arr)) {
                        // Query to get the post count for each term
                        $args = array(
                            'post_type' => 'jobs',
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'job_category',
                                    'field'    => 'term_id',
                                    'terms'    => $term->term_id,
                                ),
                            ),
                        );
                        $query = new WP_Query($args);
                        $post_count = $query->found_posts;     

                        $term_id = $term->term_id;
                        $term_meta = get_term_meta($term_id, 'job_category_custom_fields', true);
                        $cat_image = isset($term_meta['image']) ? $term_meta['image'] : '';
                        $category_link = get_category_link($term_id);
                        

                        $jobcircle_page_id = jobcircle_get_page_id_from_name($jobcircle_page);

                        $jobcircle_page_url = home_url('/');
                        if ($jobcircle_page_id > 0) {
                            $jobcircle_page_url = get_permalink($jobcircle_page_id);
                        }

                    ?>
						<div class="slick-slide">
						    <?php if(!empty($jobcircle_page_url || $term)){
						        ?>
							<a href="<?php echo esc_url($jobcircle_page_url);?>?job_category=<?php echo jobcircle_esc_the_html($term->slug) ?>" class="trending-categories-box">
							    <?php 
						    }?>
								<div class="icon">
								    <?php if(!empty($cat_image)){
						        ?>
									<img src="<?php echo esc_url_raw($cat_image); ?>" width="49" height="49" alt="UI/UX Design">
									<?php 
					                }?>
								</div>
								<div class="textbox">
								    <?php if(!empty($term)){
						        ?>
									<strong class="h6"><?php echo jobcircle_esc_the_html($term->name);?></strong>
									<?php }
									if(!empty($post_count)){?>
									<span class="subtext"><?php echo jobcircle_esc_the_html($post_count);?><?php esc_html_e('+ Jobs','jobcircle') ?></span>
									<?php 
									}
									?>
								</div>
							</a>
						</div>
                        <?php
                        $counter++;
                    } else {
                        break; // Break the loop after 9 categories
                    }
                }
                    ?>
						
					</div>
				</div>
			</section>
            
            <?php 
}elseif ($atts['jobcircle_style'] == 'jobcircle_style_three') {
    ob_start();
    ?>

<section class="section section-theme-2 trending-block bg-light-gray pt-35 pt-md-50 pt-lg-75 pt-xxl-120 pb-35 pb-md-50 pb-lg-65 pb-xxl-100" style="background-image: url(<?php echo esc_url_raw($bg_image) ?>);">
				<div class="container">
					<!-- Section header -->
					<header class="section-header text-center mb-30 mb-md-45 mb-xl-60">
<?php if(!empty($title && $span_tit)){ ?>
						<h2><?php echo esc_html($title); ?> <span class="text-outlined"><?php echo esc_html($span_tit); ?></span></h2>
                        <?php   } ?>
                        <?php if(!empty($disc)){ ?>
						<p><?php echo esc_html($disc); ?></p>
                        <?php } ?>
					</header>
					<div class="row">
                        <?php 

                    $include_category_ids = $job_type_arr;
                    $terms = get_terms(array(
                        'taxonomy' => 'job_category',
                        'post_type' => 'jobs',
                        'hide_empty' => true,
                        'parent' => 0,
                        'include' => $include_category_ids,

                    ));
    
                        $counter = 0;

                        $chunked_terms = array_chunk($terms, 3); // Chunk categories into groups of 3

                        foreach ($chunked_terms as $term_group) {
                            if($counter < 4){
                            if($counter == 0){
                                $colclss = 'pt-xl-40';
                            }elseif($counter == 1){
                                $colclss = '';
                            }elseif($counter== 2){
                                $colclss = 'pt-xl-40';
                            }elseif($counter == 3){
                                $colclss = '';
                            }
                            ?>
                            <div class="col-12 col-md-6 col-xl-3 <?php echo jobcircle_esc_the_html($colclss); ?>">
                                  <?php        

                       

                        foreach ($term_group as $term) {

                        $term_id = $term->term_id;
                        $category_link = get_category_link($term_id);
                        
                        $args = array(
                            'post_type' => 'jobs',
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'job_category',
                                    'field'    => 'term_id',
                                    'terms'    => $term->term_id,
                                ),
                            ),
                        );
                        $query = new WP_Query($args);
                        $post_count = $query->found_posts;  

                        $jobcircle_page_id = jobcircle_get_page_id_from_name($jobcircle_page);

                        $jobcircle_page_url = home_url('/');
                        if ($jobcircle_page_id > 0) {
                            $jobcircle_page_url = get_permalink($jobcircle_page_id);
                        }
                           ?>	
                           		<div class="trending-box mb-15 mb-xl-20 mb-xxl-30">
								<div class="text-holder">
                                <a href="<?php echo esc_url($jobcircle_page_url);?>?job_category=<?php echo jobcircle_esc_the_html($term->slug) ?>">
									<strong class="h6"><?php echo jobcircle_esc_the_html($term->name);?></strong>
                           </a>

									<span class="subtitle"><?php echo esc_html($post_count); ?> <?php echo esc_html__('open positions', 'jobcircle-frame'); ?></span>
								</div>
								<a href="<?php echo esc_url($jobcircle_page_url);?>?job_category=<?php echo jobcircle_esc_the_html($term->slug) ?>" class="btn btn-dark-yellow btn-sm"><span class="btn-text"><i class="jobcircle-icon-chevron-right"></i></span></a>
							</div>
                            <?php
                                                  
                         } 
                         $counter++;
                        }else{
                         break;
                        }
                     ?>

                     </div>
                <?php  } ?>
              
					</div>
				</div>
			</section>
<?php
}elseif ($atts['jobcircle_style'] == 'jobcircle_style_five') {
ob_start();
?>
<section class="section section-theme-5 trending-block bg-white pt-35 pt-md-50 pt-lg-75 pt-xxl-120 pb-35 pb-md-50 pb-lg-65 pb-xxl-100">
				<div class="container">
					<!-- Section header -->
					<header class="section-header d-flex flex-column text-center mb-30 mb-md-45 mb-xl-60">
                        <?php
                        if(!empty($title)){ ?>
                        <h2 class="order-2"><?php echo esc_html($title); ?></h2>
                        <?php } 
                        if(!empty($disc)){ ?>
						<p class="order-1"><?php echo esc_html($disc); ?></p> 
                        <?php } ?>
					</header>
					<div class="cats-block">
<?php
                   $exclude_category_ids = array(84,92,96,44);

                    $terms = get_terms(array(
                        'taxonomy' => 'job_category',
                        'post_type' => 'jobs',
                        'hide_empty' => false,
                        'parent' => 0,
                        'exclude' => $exclude_category_ids,
                    ));
    
                    $counter = 0;
                    foreach ($terms as $term) {
                        if ($counter < 9) {
                        // Query to get the post count for each term
                        $args = array(
                            'post_type' => 'jobs',
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'job_category',
                                    'field'    => 'term_id',
                                    'terms'    => $term->term_id,
                                ),
                            ),
                        );
                        $query = new WP_Query($args);
                        $post_count = $query->found_posts;  

                        $term_id = $term->term_id;
                        $category_link = get_category_link($term_id);
                        $term_meta = get_term_meta($term_id, 'job_category_custom_fields', true);
                        $cat_image = isset($term_meta['image']) ? $term_meta['image'] : '';
                    
                        $jobcircle_page_id = jobcircle_get_page_id_from_name($jobcircle_page);

                        $jobcircle_page_url = home_url('/');
                        if ($jobcircle_page_id > 0) {
                            $jobcircle_page_url = get_permalink($jobcircle_page_id);
                        }

                        ?>
						<div class="cat-box">
						    <?php if(!empty($jobcircle_page_url || $term)){
						        ?>
							<a href="<?php echo esc_url($jobcircle_page_url);?>?job_category=<?php echo jobcircle_esc_the_html($term->slug) ?>">
							    <?php }
							    if(!empty($cat_image)){?>
								<div class="icon-box"><img src="<?php echo jobcircle_esc_the_html($cat_image); ?>" alt="icon"></div>
								<?php } ?>
								<div class="cat-text">
								    <?php if(!empty($term)){
								        ?>
								        <strong class="title"><?php echo esc_html($term->name) ;?></strong>
								        <?php }
								        if(!empty($post_count)){?>
									<p><?php echo esc_html($post_count); ?><?php esc_html_e(' open positions','jobcircle') ?> </p>
									<?php } ?>
								</div>
							</a>
						</div>
                        <?php
                        $counter++;
                    } else {
                        break; // Break the loop after 9 categories
                    }
                }
                    ?>	
					</div>
				</div>
			</section>
            <?php
}elseif ($atts['jobcircle_style'] == 'jobcircle_style_six') {
    ob_start();
    ?>
  			<section class="section section-theme-3 trending-block bg-light-yellow pt-35 pt-md-50 pt-lg-75 pt-xxl-120 pb-35 pb-md-50 pb-lg-65 pb-xxl-100">
				<div class="container">
					<!-- Section header -->
					<header class="section-header mw-100 text-center text-lg-start mb-30 mb-md-45 mb-xl-60 ms-0 me-0">
                    <?php
						if(!empty($title)){ ?>
						<h2><?php echo esc_html($title) ?></h2>
                        <?php } ?>
                        <?php
                        if(!empty($disc)){ ?>
						<p><?php echo esc_textarea($disc) ?></p>
                        <?php } ?>
					</header>
					<ul class="trending-list">
                    <?php

$exclude_category_ids = array(99,98,96,44);
                    // Fetch the terms for the custom taxonomy 'job_featured'
                    $terms = get_terms(array(
                        'taxonomy' => 'job_category',
                        'post_type' => 'jobs',
                        'hide_empty' => false,
                        'parent' => 0,
                        'exclude' => $exclude_category_ids,
                    ));
    
                    $counter = 0;
                    foreach ($terms as $term) {
                        if ($counter < 9) {
                        // Query to get the post count for each term
                        $args = array(
                            'post_type' => 'jobs',
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'job_category',
                                    'field'    => 'term_id',
                                    'terms'    => $term->term_id,
                                ),
                            ),
                        );
                        $query = new WP_Query($args);
                        $post_count = $query->found_posts;     

                        $term_id = $term->term_id;
                        $term_meta = get_term_meta($term_id, 'job_category_custom_fields', true);
                        $cat_image = isset($term_meta['image']) ? $term_meta['image'] : '';
                        $category_link = get_category_link($term_id);

                        $jobcircle_page_id = jobcircle_get_page_id_from_name($jobcircle_page);

                        $jobcircle_page_url = home_url('/');
                        if ($jobcircle_page_id > 0) {
                            $jobcircle_page_url = get_permalink($jobcircle_page_id);
                        }

                    ?>
                        <li>
							<div class="trending-box cat-style">
								<div class="icon">
                                <?php
						if(!empty($cat_image) || !empty($jobcircle_page_url) || !empty($term)){ ?>
							      <a href="<?php echo esc_url($jobcircle_page_url);?>?job_category=<?php echo jobcircle_esc_the_html($term->slug) ?>"><img src="<?php echo jobcircle_esc_the_html($cat_image); ?>" alt="Accountancy"></a>
                                    <?php } ?>
								</div>
								<div class="text-holder">
								    <?php if(!empty($jobcircle_page_url || $term)){
								        ?>
                                <a href="<?php echo esc_url($jobcircle_page_url);?>?job_category=<?php echo jobcircle_esc_the_html($term->slug) ?>">
									<strong class="h6"><?php echo jobcircle_esc_the_html($term->name);?></strong>
                                </a>
            						 <?php } 
            						 if(!empty($post_count)){
            						 ?>
									<span class="subtitle"><?php echo esc_html($post_count);?> <?php esc_html_e(' open positions','jobcircle') ?></span>
									<?php } ?>
								</div>
                                <?php 
                                if(!empty($jobcircle_page_url || $term)){
                                    ?>
								<a href="<?php echo esc_url($jobcircle_page_url);?>?job_category=<?php echo jobcircle_esc_the_html($term->slug) ?>" class="btn btn-brown btn-sm"><span class="btn-text"><i class="jobcircle-icon-chevron-right"></i></span></a>
                               <?php } ?>
							</div>
						</li>
                        <?php
                        $counter++;
                    } else {
                        break; // Break the loop after 12 categories
                    }
                }
                    ?>
					<li>
							<div class="trending-box more-box">
                            <?php 
                                if(!empty($find_more_url)){
                                    ?>
								<a href="<?php echo esc_html($find_more_url) ?>" class="btn btn-brown btn-sm"><span class="btn-text"><i class="jobcircle-icon-chevron-right"></i></span></a>
                              <?php  } ?>
								<strong class="subtitle"><?php esc_html_e(' Find More','jobcircle') ?></strong>
							</div>
						</li>
					</ul>
				</div>
			</section>
                <?php
    }

    elseif ($atts['jobcircle_style'] == 'jobcircle_style_seven') {
        ob_start();
        ?>
			<section class="section section-theme-9 browse_categories" style="background-image: url(<?php echo esc_url_raw($bg_image) ?>);">
				<div class="container">
					<div class="section-header text-center mb-40 mb-md-45">
                    <?php if(!empty( $title)){ ?>      

						<p><?php echo esc_html($title) ?></p>
                        <?php } ?>
                        <?php if(!empty( $heading)){ ?>  
						<h2><span class="text-outlined"><?php echo esc_html($heading) ?></span></h2>
                        <?php } ?>
					</div>
					<div class="row mb-md-30 mb-xl-55">
						
                        <?php
    
    $exclude_category_ids = array(99,98,96,44);
                        // Fetch the terms for the custom taxonomy 'job_featured'
                        $terms = get_terms(array(
                            'taxonomy' => 'job_category',
                            'post_type' => 'jobs',
                            'hide_empty' => false,
                            'parent' => 0,
                            'exclude' => $exclude_category_ids,
                        ));
        
                        $counter = 0;
                        foreach ($terms as $term) {
                            if ($counter < 6) {
                            // Query to get the post count for each term
                            $args = array(
                                'post_type' => 'jobs',
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'job_category',
                                        'field'    => 'term_id',
                                        'terms'    => $term->term_id,
                                    ),
                                ),
                            );
                            $query = new WP_Query($args);
                            $post_count = $query->found_posts;     
    
                            $term_id = $term->term_id;
                            $term_meta = get_term_meta($term_id, 'job_category_custom_fields', true);
                            $cat_image = isset($term_meta['image']) ? $term_meta['image'] : '';
                            $category_link = get_category_link($term_id);

                            $jobcircle_page_id = jobcircle_get_page_id_from_name($jobcircle_page);

                            $jobcircle_page_url = home_url('/');
                            if ($jobcircle_page_id > 0) {
                                $jobcircle_page_url = get_permalink($jobcircle_page_id);
                            }
    
                        ?>
                           <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-30 mb-md-50">
							<div class="info_box">
								<div class="wrap_info">
									<div class="icon_wrap wrape-style">
                                    <a href="<?php echo esc_url($jobcircle_page_url);?>?job_category=<?php echo jobcircle_esc_the_html($term->slug) ?>"><img class="onvover-white-img" src="<?php echo esc_url_raw($cat_image) ?>" alt="img"></a>
									</div>
									<div class="text_wrap">
                                    <a href="<?php echo esc_url($jobcircle_page_url);?>?job_category=<?php echo jobcircle_esc_the_html($term->slug) ?>"><strong class="title"><?php echo esc_html($term->name) ;?></strong></a>
										<p><?php echo esc_html($post_count); ?> <?php echo esc_html_e('Jobs available', 'jobcircle-frame') ?></p>
									</div>
								</div>
							</div>
						</div>
                            <?php
                            $counter++;
                        } else {
                            break; // Break the loop after 12 categories
                        }
                    }
                        ?>
                       <div class="col-12 col-xl-6 mb-50">
                           <?php if (!empty($bg_image2)) {
                                ?>
							<div class="get_matched" style="background-image: url(<?php echo esc_url_raw($bg_image2) ?>);">
							       <?php
                                } ?>
								<div class="wrap">
									<div class="text-holder">
									    <?php if (!empty($matched_jobs_title)) {
                                ?>
										<strong class="title"><?php echo esc_html($matched_jobs_title) ?></strong>
										<?php
                                } ?>
                                	    <?php if (!empty($matched_jobs_discri)) {
                                ?>
										<p><?php echo esc_html($matched_jobs_discri) ?></p>
											<?php
                                } ?>
									</div>
									<div class="icon-holder">
										<i class="jobcircle-icon-upload-cloud icon"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					
			<!--	</div>-->
			<!--</section>-->

                    <?php
        }
	return ob_get_clean();
 }
 add_shortcode( 'populer_cat', 'span_titimony_front');