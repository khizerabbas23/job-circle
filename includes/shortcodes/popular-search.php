<?php
function jobcircle_populer_search() {
         $terms = get_terms(
		array(
			'taxonomy' => 'job_category',
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
			'name' => __( 'Popular Search' ),
			'base' => 'jc_populer_search',
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
    		       'type' => 'checkbox',
    		       'holder' => 'div',
    		       'class' => '',
    		       'heading' => __('Category Selector'),
    		       'param_name' => 'checkbox_param',
    		       'value' => $job_types,
	         	),
			)	
		)
	);
 }
 add_action( 'vc_before_init', 'jobcircle_populer_search' ); 
 // Frontend Coding  
 function jobcircle_populer_search_frontend( $atts, $content ) { 
	$atts = shortcode_atts(
	array(		
		'title' => '',
'checkbox_param' => '',
	), $atts, 'jobcircle_populer_search'
 );
 
 $title = isset($atts['title']) ? $atts['title'] : '';
         $checkbox_param = isset($atts['checkbox_param']) ? $atts['checkbox_param'] : '';
        $job_type_arry = !empty($checkbox_param) ? explode(',', $checkbox_param) : ''; 
 $custom_plan_price = isset($atts['nb_Circletitle']) && !empty($atts['nb_Circletitle']) ? $atts['nb_Circletitle'] : '';
 
 ob_start();
 ?>             
    <section class="section section-theme-5 popular-searches-block pt-30 pt-md-50 pt-lg-75 pt-xxl-120 pb-35 pb-md-50 pb-lg-65 pb-xxl-100">
				<div class="container">
					<!-- Section header -->
					<header class="section-header d-flex flex-column mb-0 mb-md-20">
                        <?php 
                        if(!empty($title)){ ?>
						<h2><?php echo esc_html($title); ?></h2>
                        <?php } ?>
					</header>
					<ul class="list-inline searches-list m-0">
                    <?php
    
$include_category_ids = $job_type_arry;
// Fetch the terms for the custom taxonomy 'job_featured'
$terms = get_terms(array(
    'taxonomy' => 'job_category',
    'post_type' => 'jobs',
    'hide_empty' => true,
    'parent' => 0,
    'include' => $include_category_ids,
));

$counter = 0;
foreach ($terms as $term) {
    if ($counter < 12) {
        $active = ($counter == 2) ? 'active' : ''; // Assign 'active' to the 6th item

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

        $term_id = $term->term_id;
        $category_link = get_category_link($term_id);
            
        // Category name ko space ke hisab se split karein
        $category_name_parts = explode(' ', $term->name);
        
        // Pehla word ko extract karein
        $first_word = $category_name_parts[0];
        
        if (!empty($category_link || $first_word)) {
            ?>
            <li class="list-inline-item <?php echo jobcircle_esc_the_html($active); ?>">
                <a href="<?php echo esc_url($category_link); ?>"><?php echo esc_html($first_word); ?></a>
            </li>
            <?php
        }
        $counter++;
    } else {
        break;
    }
}
?>

					</ul>
				</div>
			</section>
<?php
	return ob_get_clean();
 }
 add_shortcode( 'jc_populer_search', 'jobcircle_populer_search_frontend');