<?php
function jobcircle_categories_foirteen() {
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
			'name' => __( 'Popular Job Categories 14' ),
			'base' => '_categories_foirteen',
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
                'type' => 'textfield',
                'holder' => 'div',
                'class' => '',
                'heading' => __( 'Button Title' ),
                'param_name' => 'b_title',
                ),  
                array(
                'type' => 'textfield',
                'holder' => 'div',
                'class' => '',
                'heading' => __( 'Button Url' ),
                'param_name' => 'b_url',
                ),        	 
			)	
		)
	);
 }
 add_action( 'vc_before_init', 'jobcircle_categories_foirteen' ); 
 // Frontend Coding  
 function jobcircle_categories_foirteen_front( $atts, $content ) { 
	$atts = shortcode_atts(
	array(		
		'title' => '',
		'disc' => '',        
		'image' => '',
		'b_title' => '',
		'b_url' => '',

		'jobcircle_page' => '',        

	), $atts, 'jobcircle_categories_foirteen'
 );
 
 $title = isset($atts['title']) ? $atts['title'] : '';
 $disc = isset($atts['disc']) ? $atts['disc'] : '';
 $b_title = isset($atts['b_title']) ? $atts['b_title'] : '';
 $b_url = isset($atts['b_url']) ? $atts['b_url'] : '';

 $jobcircle_page = isset($atts['jobcircle_page']) ? $atts['jobcircle_page'] : '';

 $image = isset($atts['image']) ? $atts['image'] : '';

 ob_start();
 ?>     
 <?php if(!empty( $image)){ ?>        
<section class="section section-theme-14 popular_jobs_cat" style="background-image: url('<?php echo esc_url_raw($image) ?>');">
<?php } ?>
	<div class="container">
		<!-- Section header -->
		<header class="section-header d-flex flex-column text-center mb-15 mb-md-30 mb-xl-45">
        <?php if(!empty( $disc)){ ?>      
			<p><?php echo esc_html($disc)  ?></p>
            <?php } ?>
        <?php if(!empty( $title)){ ?>      

			<h2><span class="text-outlined"><?php echo esc_html($title)  ?></span></h2>
            <?php } ?>
		</header>
		<div class="row mb-25">
        <?php
$terms = get_terms(array(
    'taxonomy' => 'job_category',
    'post_type' => 'jobs',
    'hide_empty' => false,
    'parent' => 0,
));

$counter = 0;
foreach ($terms as $term) {
    if ($counter < 12) {
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

        $jobcircle_page_id = jobcircle_get_page_id_from_name($jobcircle_page);

        $jobcircle_page_url = home_url('/');
        if ($jobcircle_page_id > 0) {
            $jobcircle_page_url = get_permalink($jobcircle_page_id);
        }
?>
        <div class="col-12 col-md-6 col-lg-4 mb-25">
            <a class="job_cat" href="<?php echo esc_url($jobcircle_page_url);?>?job_category=<?php echo jobcircle_esc_the_html($term->slug) ?>">
                <div class="wrap">
                    <strong class="title"><?php echo esc_attr($term->name); ?></strong>
                    <span class="title-pos">( <?php echo jobcircle_esc_the_html($term->count); ?> <?php esc_html_e('Posts Available', 'jobcircle-frame') ?> )</span>
                </div>
            </a>
        </div>
<?php
        $counter++;
    } else {
        break; // Break the loop after 12 categories
    }
}
?>


</div>
		<div class="d-flex justify-content-center">
        <?php if(!empty( $b_url)  || !empty($b_title)){ ?>      

			<a href="<?php echo esc_html($b_url) ?>" class="view_all"><?php echo esc_html($b_title) ?></a>
            <?php } ?>
		</div>
	</div>
</section>
<?php
 
	return ob_get_clean();
 }
 add_shortcode( '_categories_foirteen', 'jobcircle_categories_foirteen_front');