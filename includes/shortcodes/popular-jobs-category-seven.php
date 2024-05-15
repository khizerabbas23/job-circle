<?php
function jobcircle_popular_job_ategories() {
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
			'name' => __( 'Popular Job Categories' ),
			'base' => 'popular_job_ategories',
			'category' => __( 'job Circle' ),
			'params' => array(
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
                'heading' => __( 'heading' ),
                'param_name' => 'heading',
            ),                
            	 
			array(
                'type' => 'jobcircle_browse_img',
                'holder' => 'div',
                'class' => '',
                'heading' => __( 'Background Image' ),
                'param_name' => 'bg_img',
            ),
        	array(
					'type' => 'checkbox',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Checkbox Options'),
					'param_name' => 'checkbox_param',
					'value' => $job_types,
				),
			)	
		)
	);
 }
 add_action( 'vc_before_init', 'jobcircle_popular_job_ategories' ); 
 // Frontend Coding  
 function jobcircle_popular_job_ategories_front( $atts, $content ) { 
	$atts = shortcode_atts(
	array(		
		'title' => '',
		'heading' => '',        
		'bg_img' => '',        
        'checkbox_param' => '',
        'jobcircle_page' => '',        


	), $atts, 'jobcircle_popular_job_ategories'
 );
 
 $title = isset($atts['title']) ? $atts['title'] : '';
 $heading = isset($atts['heading']) ? $atts['heading'] : '';
 $bg_img = isset($atts['bg_img']) ? $atts['bg_img'] : '';
 $checkbox_param = isset($atts['checkbox_param']) ? $atts['checkbox_param'] : '';
 $job_type_arr = !empty($checkbox_param) ? explode(',', $checkbox_param) : '';
 $jobcircle_page = isset($atts['jobcircle_page']) ? $atts['jobcircle_page'] : '';


 ob_start();
 ?>             
<section class="job_categories section-theme-7" style="background-image: url(<?php echo esc_url_raw($bg_img) ?>);">
	<div class="container">
		<header class="section-header d-flex flex-column text-center mb-30 mb-md-45 mb-xl-25">
        <?php if(!empty($title)) { ?>
			<p><?php echo esc_html($title) ?></p>
            <?php } ?>
            <?php if(!empty($heading)) { ?>
			<h2><?php echo esc_html($heading) ?></h2>
            <?php } ?>
		</header>
		<ul class="trending-list">

        <?php
    $include_category_ids = $job_type_arr;
    $counter = 1;
    // Fetch the terms for the custom taxonomy 'job_featured'
    $terms = get_terms( array(
        'taxonomy' => 'job_category',
        'post_type' => 'jobs',
        'hide_empty' => false,
        'parent' => 0,
        'include' => $include_category_ids,
    ) 
);
    foreach ( $terms as $term ) {

        if ($counter <= 8) {
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
        $query = new WP_Query( $args );
        $post_count = $query->found_posts;

        $term_id = $term->term_id;
		$term_meta = get_term_meta($term_id, 'job_category_custom_fields', true);

		$cat_icon = isset($term_meta['icon']) ? $term_meta['icon'] : '';
        $cat_image = isset($term_meta['image']) ? $term_meta['image'] : '';
        $category_link = get_category_link($term_id);

        $jobcircle_page_id = jobcircle_get_page_id_from_name($jobcircle_page);

    $jobcircle_page_url = home_url('/');
    if ($jobcircle_page_id > 0) {
        $jobcircle_page_url = get_permalink($jobcircle_page_id);
    }
    ?>
	<li class="jc-icun">
				<a href="<?php echo esc_url($jobcircle_page_url);?>?job_category=<?php echo jobcircle_esc_the_html($term->slug) ?>" class="trending-box">
					<div class="icon">
                    <img src="<?php echo esc_url($cat_image); ?>" alt="<?php echo esc_attr($term->name); ?>">
					</div>
					<div class="text-holder">
						<strong class="h6"><?php echo esc_attr($term->name); ?></strong>
						<span class="subtitle"><?php echo esc_html($post_count); ?> <?php echo esc_html_e('open positions', 'jobcircle-frame') ?></span>
					</div>
				</a>
			</li>
<?php
    }else{
        break;
    }
    $counter++ ;
}
?>

</ul>
	</div>
</section>
<?php
 
	return ob_get_clean();
 }
 add_shortcode( 'popular_job_ategories', 'jobcircle_popular_job_ategories_front');