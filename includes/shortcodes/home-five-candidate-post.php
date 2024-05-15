<?php
function jobcirlce_features_candidates()
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
        'name' => __('Featured Candidates'),
        'base' => 'jc_features_candidates',
        'category' => __('Job Circle'),
        'params' => array(
            array(
                'type' => 'textfield',
                'holder' => 'div',
                'class' => '',
                'heading' => __('Heading'),
                'param_name' => 'heading',
            ),
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
                'heading' => __('Point One'),
                'param_name' => 'point_one',
            ),
            array(
                'type' => 'textfield',
                'holder' => 'div',
                'class' => '',
                'heading' => __('Point Two'),
                'param_name' => 'point_two',
            ),
            array(
                'type' => 'textfield',
                'holder' => 'div',
                'class' => '',
                'heading' => __('Point Three'),
                'param_name' => 'point_three',
            ),
            array(
                'type' => 'textfield',
                'holder' => 'div',
                'class' => '',
                'heading' => __('Users Heading'),
                'param_name' => 'user_heading',
            ),
            array(
                'type' => 'jobcircle_browse_img',
                'holder' => 'div',
                'class' => '',
                'heading' => __('Users Image'),
                'param_name' => 'image_one',
            ),
            array(
                'type' => 'jobcircle_browse_img',
                'holder' => 'div',
                'class' => '',
                'heading' => __('Users Image'),
                'param_name' => 'image_two',
            ),
            array(
                'type' => 'jobcircle_browse_img',
                'holder' => 'div',
                'class' => '',
                'heading' => __('Users Image'),
                'param_name' => 'image_three',
            ),
            array(
                'type' => 'jobcircle_browse_img',
                'holder' => 'div',
                'class' => '',
                'heading' => __('Users Image'),
                'param_name' => 'image_four',
            ),
          
            array(
                'type' => 'textfield',
                'holder' => 'div',
                'class' => '',
                'heading' => __('NumofPost'),
                'param_name' => 'numofpost',
            ),
            array(
                'type' => 'textfield',
                'holder' => 'div',
                'class' => '',
                'heading' => __('OrderBy'),
                'param_name' => 'orderby',
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
add_action('vc_before_init', 'jobcirlce_features_candidates');
// Frontend Coding 
function jobcirlce_features_candidates_frontend($atts, $content)
{
    $atts = shortcode_atts(
    array(
        'heading' => '',
        'title' => '',
        'point_one' => '',
        'point_two' => '',
        'point_three' => '',
        'user_heading' => '',
        'image_one' => '',
        'image_two' => '',
        'image_three' => '',
        'image_four' => '',
        'numofpost' => '',
        'orderby' => '',
        'dropdown_param' => '',
    ),
    $atts,
        'jobcirlce_features_candidates'
    );

    $heading = isset($atts['heading']) ? $atts['heading'] : '';
    $title = isset($atts['title']) ? $atts['title'] : '';
    $point_one = isset($atts['point_one']) ? $atts['point_one'] : '';
    $point_two = isset($atts['point_two']) ? $atts['point_two'] : '';
    $point_three = isset($atts['point_three']) ? $atts['point_three'] : '';
    $user_heading = isset($atts['user_heading']) ? $atts['user_heading'] : '';
    $image_one = isset($atts['image_one']) ? $atts['image_one'] : '';
    $image_two = isset($atts['image_two']) ? $atts['image_two'] : '';
    $image_three = isset($atts['image_three']) ? $atts['image_three'] : '';
    $image_four = isset($atts['image_four']) ? $atts['image_four'] : '';
    $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
    $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
 $dropdown_param = isset($atts['dropdown_param']) ? $atts['dropdown_param'] : '';
        $job_type_arr = !empty($dropdown_param) ? explode(',', $dropdown_param) : '';
    ob_start();
    ?>
<section
    class="section section-theme-5 featured-candidates-block pt-30 pt-md-50 pt-lg-140 pb-15 pb-md-30 pb-lg-65 pb-xxl-100">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-12 col-md-4">
                <?php if(!empty($heading)){ ?>
                <p><?php echo esc_html($heading)?></p>
                <?php } ?>
                <?php if(!empty($title)){ ?>
                <h2><?php echo esc_html($title) ?></h2>
                <?php } ?>
                <ul class="list-unstyled features-list">
                    <?php if(!empty($point_one)){ ?>
                    <li><?php echo esc_html($point_one) ?></li>
                    <?php } ?>
                    <?php if(!empty($point_two)){ ?>
                    <li><?php echo esc_html($point_two) ?></li>
                    <?php } ?>
                    <?php if(!empty($point_three)){ ?>
                    <li><?php echo esc_html($point_three) ?></li>
                    <?php } ?>
                </ul>
                <div class="users-box">
                    <?php if(!empty($user_heading)){ ?>
                    <strong class="title"><?php echo esc_html($user_heading) ?></strong>
                    <?php } ?>
                    <ul class="users-list">
                        <?php if(!empty($image_one)){ ?>
                        <li><img src="<?php echo esc_url_raw($image_one) ?>" width="60" height="60" alt="User"></li>
                        <?php } ?>
                        <?php if(!empty($image_two)){ ?>
                        <li><img src="<?php echo esc_url_raw($image_two) ?>" width="60" height="60" alt="User"></li>
                        <?php } ?>
                        <?php if(!empty($image_three)){ ?>
                        <li><img src="<?php echo esc_url_raw($image_three) ?>" width="60" height="60" alt="User"></li>
                        <?php } ?>
                        <?php if(!empty($image_four)){ ?>
                        <li><img src="<?php echo esc_url_raw($image_four) ?>" width="60" height="60" alt="User"></li>
                        <li><i class="jobcircle-icon-plus"></i></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="col-12 col-md-8 col-lg-7">
                <div class="candidates-block">
                    <?php
                    $include_category_ids = $job_type_arr;
        $args = array(
        'post_type' => 'candidates',
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
    $query = new WP_Query($args);
    $total_posts = $query->found_posts;
    // Check that we have query results.
    if ($query->have_posts()) {
        $counter = 0;
        // Start looping over the query results.
        while ($query->have_posts()) {
            global $post;
            $query->the_post();
            $post =  get_the_id();
            $title = get_the_title($post);
            $permalinkget = get_the_permalink($post);
            $posted = get_the_time('U');
            $minut =  human_time_diff($posted,current_time( 'U' )). "";
            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post ), 'single-post-thumbnail' );
            $country = get_post_meta($post, 'jobcircle_field_loc_country', true);
            $job_title = get_post_meta($post, 'jobcircle_field_job_title', true);
            $loc_city = jobcircle_post_location_str($post);
            ?>
                    <div class="candidate-frame">
                        <?php if(!empty($permalinkget)){
                    ?>
                        <a href="<?php echo jobcircle_esc_the_html($permalinkget)?>">
                            <?php } ?>
                            <div class="frame">
                                <div class="image-holder">
                                    <?php if(!empty($image)){
                    ?>
                                    <img src="<?php echo esc_url_raw($image[0]) ?>" alt="Image Description">
                                    <?php } ?>
                                </div>
                                <?php if(!empty($title)){
                    ?>
                                <strong class="title"><?php echo esc_html($title) ?></strong>
                                <?php } ?>
                                <?php if(!empty($job_title)){ ?>
                                <span class="designation"><?php echo esc_html($job_title ) ?></span>
                                <?php } ?>
                                <?php if(!empty($loc_city)){ ?>
                                <p class="location-txt"><i
                                        class="jobcircle-icon-map-pin"></i><?php echo esc_html($loc_city) ?></p>
                                <?php } ?>
                            </div>
                        </a>
                        <?php if(!empty($permalinkget)){
                    ?>
                        <a href="<?php echo  ($permalinkget) ?>"
                            class="view-profile"><?php esc_html_e('View Profile', 'jobcircle-frame')?></a>
                        <?php } ?>
                    </div>
                    <?php 
}
    }
?>
                </div>
</section>
<?php
    return ob_get_clean();
}
add_shortcode('jc_features_candidates', 'jobcirlce_features_candidates_frontend');