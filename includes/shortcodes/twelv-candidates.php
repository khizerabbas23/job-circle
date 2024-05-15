<?php
function get_candidate_post() {
     $categories = get_terms(array(
        'taxonomy' => 'candidate_cat',
        'hide_empty' => false,
    ));

    $category_options = array();

    if ($categories && !is_wp_error($categories)) {
        foreach ($categories as $category) {
            $category_options[wp_specialchars_decode($category->name)] = $category->slug;
        }
    }

    return $category_options;
}
function jobcircle_htwlv_candidates(){
    $terms = get_terms(
		array(
			'taxonomy' => 'category',
			'hide_empty' => true,
		)
	);
	$job_types = array();
	foreach ($terms as $term) {
		$job_types[$term->name] = $term->term_id;
	}
  vc_map(
    array(
      'name' => __('Candidates Posts Twelve'),
      'base' => 'htwlv_candidates',
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
          'heading' => __('Heading'),
          'param_name' => 'heading',
        ),
       array(
			'type' => 'dropdown',
			'holder' => 'div',
			'class' => '',
			'heading' => __('Select Category For Post'),
			'param_name' => 'category_selector',
			'value' => array_merge(
				array('Select Category' => ''),
				get_candidate_post()
			),
		),
		array(
		  'type' => 'checkbox',
		  'holder' => 'div',
		  'class' => '',
		  'heading' => __('Checkbox Options'),
		  'param_name' => 'checkbox_param',
		  'value' => $job_types,
		),
        array(
          'type' => 'textfield',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Order BY'),
          'param_name' => 'orderby',
        ),
        array(
          'type' => 'textarea',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Number Of Post'),
          'param_name' => 'numofpost',
        ),
      ),
      )
    );
}
add_action('vc_before_init', 'jobcircle_htwlv_candidates');

// popular category frontend
function jobcircle_htwlv_candidates_frontend($atts, $content){

  $atts = shortcode_atts(
    array(

    'title' => '',
    'heading' => '',
    'orderby' => '',
    'numofpost' => '',
	'checkbox_param' => '',
    'category_selector' => '',
    ),
    $atts,
    'jobcircle_htwlv_candidates'
  );

    $title = isset($atts['title']) ? $atts['title'] : '';
    $heading = isset($atts['heading']) ? $atts['heading'] : '';
    $checkbox_param = isset($atts['checkbox_param']) ? $atts['checkbox_param'] : '';
    $job_type_arr = !empty($checkbox_param) ? explode(',', $checkbox_param) : '';
    $selectedcategory = isset($atts['category_selector']) ? $atts['category_selector'] : '';
  
  $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';

  ob_start();
?>
  <section class="section section-theme-11 companies-block pt-35 pt-md-50 pt-lg-65 pt-xl-85 pt-xxl-120 pb-35 pb-md-50 pb-lg-60 pb-xl-60 pb-xxl-60">
    <div class="container">
      <div class="row justify-content-between mb-25 mb-lg-30">
        <div class="col-12 col-lg-8">
          <!-- Section header -->
          <header class="section-header text-center text-lg-start mb-0">
            <?php
            if (!empty($title)){ ?>
              <p><?php echo esc_html($title) ?></p>
            <?php
            }
            if (!empty($heading)) {
            ?>
              <h2 class="help_question_heading"><?php echo esc_html($heading) ?></h2>
            <?php
            }
            ?>
          </header>
        </div>
      </div>
      <div class="expert-slider">
        <?php
        
        $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
        $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
        $selectedcategory = isset($atts['category_selector']) ? $atts['category_selector'] : '';
        
         $args = array(
                        'post_type' => 'candidates',
                        'tax_query' => array(
                         array(
    						'taxonomy' => 'candidate_cat',
    						'field' => 'slug',
    						'terms' => $selectedcategory,
				        ),
                    ),
                );
      
      // Custom query.
        $query = new WP_Query($args);
        // Check that we have query results.
        if ($query->have_posts()) {

          // Start looping over the query results.
          while ($query->have_posts()) {
            $query->the_post(); 
            $post = get_post();            
            $postid = $post->ID;
            $title = get_the_title($postid);
            $permalinkget = get_the_permalink($postid);
            $image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');
            $designation = get_post_meta($postid, 'designation', true);
	        $maxsalary = get_post_meta($postid, 'jobcircle_field_max_salary', true);
            $salary_unit = get_post_meta($postid, 'jobcircle_field_salary_unit', true);
            
        ?>

            <div class="slick-slide">
              <article class="featured-category-box">
                <div class="img-frame">
                  <?php if (!empty($permalinkget)) { ?>
                    <a href="<?php echo esc_html($permalinkget) ?>">
                    <?php }
                  if (!empty($image)) { ?>
                      <img src="<?php echo esc_url_raw($image[0]) ?>" alt="Expert Image">
                    <?php } ?>
                    </a>
                    <div class="flash-icon">
                      <span class="fa fa-solid fa-bolt"></span>
                    </div>
                </div>
                <div class="textbox">
                  <?php if (!empty($permalinkget)) { ?>
                    <a href="<?php echo esc_html($permalinkget) ?>">
                    <?php }
                  if (!empty($title)) { ?>
                      <strong class="h6"><?php echo esc_html($title) ?></strong>
                    <?php } ?>
                    </a>
                    	<?php
                           $include_category_ids = $job_type_arr;
                            $terms = get_terms(
                                array(
                                    'taxonomy' => 'category',
                                    'post_type' => 'post',
                                    'hide_empty' => false,
                                    'parent' => 0,
                                    'include' => $include_category_ids,
                                )
                            );

                            $counter = 0;
                           foreach ($terms as $term) {
                            if ($counter < 2 && !empty($term)) {
                                $term_link = get_term_link($term);
                                if (!is_wp_error($term_link)) {
                                    ?>
                      <a class="roll" href="<?php echo esc_url($term_link); ?>"><?php echo esc_html($term->name)?></a>
                    <?php 
                    }
                    $counter++;
                } else {
                    break;
                    }
                }
                ?>
                    <span><strong>$<?php echo jobcircle_esc_the_html($maxsalary) ?></strong> / <?php echo jobcircle_esc_the_html($salary_unit) ?></span>
                    <?php if (!empty($permalinkget)) { ?>
                      <a href="<?php echo esc_html($permalinkget) ?>" class="view-profile">
                      <?php } ?>
                      <?php echo esc_html_e('View Profile', 'jobcircle-frame') ?>
                      <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                        <path d="M438.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L338.8 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l306.7 0L233.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160z" />
                      </svg></a>
                </div>
              </article>
            </div>
        <?php
          }
        }
        // Restore original post data.
        wp_reset_postdata();
        ?>
      </div>
  </section>
<?php
  return ob_get_clean();
}
add_shortcode('htwlv_candidates', 'jobcircle_htwlv_candidates_frontend');
