<?php
function jobcircle_candidate_talentview() {

    vc_map(

        array(
            'name' => __('Candidate Talent View'),
            'base' => 'jobcircle_candidate_talentview',
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
                
            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_candidate_talentview');

// popular category frontend
function jobcircle_candidate_talentview_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(

            'title' => '',
            'tg_line' => '',
            'orderby' => '',
            'numofpost' => '',
            'sortby' => '',
           
        ),
        $atts,
        'jobcircle_candidate_talentview'
    );

    $title  = isset($atts['title']) ? $atts['title'] : '';
    $sortby  = isset($atts['sortby']) ? $atts['sortby'] : '';
   $tg_line  = isset($atts['tg_line']) ? $atts['tg_line'] : '';


ob_start();
?>
<section class="section section-theme-10 latest-candidates-block bg-white pt-30 pt-md-40 pt-lg-80 pt-xxl-90 pb-30 pb-md-50 pb-lg-100 pb-xxl-120">
				<div class="container">
					<div class="row mb-50 mb-md-60 align-items-md-end">
						<div class="col-12 col-md-8 d-flex flex-column-reverse">
                        <?php if(!empty($title)){ ?>
							<h2><?php jobcircle_esc_the_html($title) ?></h2>
                            <?php } ?>
                            <?php if(!empty($tg_line)){ ?>
							<p><?php jobcircle_esc_the_html($tg_line) ?></p>
                            <?php } ?>
						</div>
					
					</div>
					<div class="latest-candidates-holder">
						
<?php  
    $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
    $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
   
    $page_numbr = get_query_var('paged');

    $args = array(
        'post_type' => 'candidates',
         'post_status' => 'publish',                                                                                                                                                                                             
          'posts_per_page' => $numofpost, 
          'order' => 'DESC',  
          'paged' => $page_numbr,                   
          'orderby' =>  $orderby, 
           
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
							<h3><?php jobcircle_esc_the_html($title) ?></h3>
                            </a>
                            <?php } ?>
                            <?php if(!empty($job_location)){ ?>
							<p><?php jobcircle_esc_the_html($job_location) ?></p>
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
    if ($total_posts > $numofpost) {
        ?>
        <?php echo jobcircle_pagination($query, true);
      
    }
    return ob_get_clean();

}
add_shortcode('jobcircle_candidate_talentview', 'jobcircle_candidate_talentview_frontend');