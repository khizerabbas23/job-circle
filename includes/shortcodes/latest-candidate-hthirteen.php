<?php
function jobcircle_latest_candidate_hthirteen()
{
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
            'name' => __('Latest Candidate HThirteen'),
            'base' => 'jobcircle_latest_candidate_hthirteen',
            'category' => __('Job Circle'),
            'params' => array(

                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title'),
                    'param_name' => 'title',
                ),

                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Tag Line'),
                    'param_name' => 'tg_line',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('View All Companies'),
                    'param_name' => 'all_companies',
                ),

                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Order BY'),
                    'param_name' => 'orderby',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Number Of Post'),
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
add_action('vc_before_init', 'jobcircle_latest_candidate_hthirteen');

// popular category frontend
function jobcircle_latest_candidate_hthirteen_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(

            'title' => '',
            'tg_line' => '',
            'orderby' => '',
            'numofpost' => '',
            'all_companies' => '',
    'dropdown_param' => '',
        ),
        $atts,
        'jobcircle_latest_candidate_hthirteen'
    );

    $title  = isset($atts['title']) ? $atts['title'] : '';
   $tg_line  = isset($atts['tg_line']) ? $atts['tg_line'] : '';
   $all_companies  = isset($atts['all_companies']) ? $atts['all_companies'] : '';
$dropdown_param = isset($atts['dropdown_param']) ? $atts['dropdown_param'] : '';
        $job_type_arr = !empty($dropdown_param) ? explode(',', $dropdown_param) : '';
ob_start();
?>
<section class="section section-theme-10 latest-candidates-block bg-white pt-30 pt-md-40 pt-lg-80 pt-xxl-90 pb-30 pb-md-50 pb-lg-100 pb-xxl-120">
				<div class="container">
					<div class="row mb-50 mb-md-60 align-items-md-end">
						<div class="col-12 col-md-8 d-flex flex-column-reverse">
                        <?php if(!empty($title)){ ?>
							<h2><?php echo esc_html($title) ?></h2>
                            <?php } ?>
                            <?php if(!empty($tg_line)){ ?>
							<p><?php echo esc_html($tg_line) ?></p>
                            <?php } ?>
						</div>
						<div class="col-12 col-md-4 d-flex justify-content-md-end align-items-start">
						    <?php if(!empty($all_companies)){ ?>
							<a href="<?php echo jobcircle_esc_the_html($all_companies); ?>" class="view-all"><?php echo esc_html_e('View all companies','jobciecle-frame');?></a>
							<?php } ?>
						</div>
					</div>
					<div class="latest-candidates-holder">
						
<?php  
    $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
    $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';

    $page_numbr = get_query_var('paged');
 $include_category_ids = $job_type_arr;
    $args = array(
        'post_type' => 'candidates',
         'post_status' => 'publish',                                                                                                                                                                                             
          'posts_per_page' => $numofpost, 
          'order' => 'DESC',  
          'paged' => $page_numbr,                   
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
    $query = new WP_Query($args);
    $total_posts = $query->found_posts;

    // Check that we have query results.
    if ($query->have_posts()) {

        // Start looping over the query results.
        while ($query->have_posts()) {

            $query->the_post();
            $post = get_post();
            $postid = $post->ID;
            $title = get_the_title($postid);
            $permalinkget = get_the_permalink($post);
            $image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');
            $job_location = jobcircle_post_location_str($postid);


            ?>
                        <div class="candidate-frame">
                             <?php if(!empty($permalinkget) && !empty($image)){ ?>
                            <a href="<?php echo jobcircle_esc_the_html($permalinkget)?>">
							<div class="image-holder"><img src="<?php echo jobcircle_esc_the_html($image[0]) ?>" alt="image"></div>
                            </a>
                            <?php } ?>
                            <?php if(!empty($permalinkget) && !empty($title)){ ?>
                            <a href="<?php echo jobcircle_esc_the_html($permalinkget)?>">
							<h3><?php echo esc_html($title) ?></h3>
                            </a>
                            <?php } ?>
                            <?php if(!empty($job_location)){ ?>
							<p><?php echo esc_html($job_location) ?></p>
							<?php } ?>
						</div>
            <?php
        }

    }

    // Restore original post data.
    wp_reset_postdata();
    ?>
   </div>
	</div>
</section>
    <?php
    return ob_get_clean();

}
add_shortcode('jobcircle_latest_candidate_hthirteen', 'jobcircle_latest_candidate_hthirteen_frontend');