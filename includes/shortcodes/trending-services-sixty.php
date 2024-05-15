<?php
function get_customs_posst_catagori()
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

function jobcircle_trending_services()
{
  vc_map(
    array(
      'name' => __('Trending Services'),
      'base' => 'jobcircle_trending_services',
      'category' => __('Job Circle'),
      'params' => array(
        array(
          'type' => 'textfield',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Outline'),
          'param_name' => 'outline',
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
          'heading' => __('Order BY'),
          'param_name' => 'orderby',
        ),
        array(
					'type' => 'dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Select Category For Post'),
					'param_name' => 'category_selector',
					'value' => array_merge(
						array('Select Category' => ''),
						get_customs_posst_catagori()
					),
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
add_action('vc_before_init', 'jobcircle_trending_services');
// popular category frontend
function jobcircle_trending_services_frontend($atts, $content)
{
  $atts = shortcode_atts(
    array(
      'outline' => '',
      'title' => '',
      'orderby' => '',
      'numofpost' => '',
      'category_selector' => '',

    ),
    $atts,
    'jobcircle_trending_services'
  );
  $outline = isset($atts['outline']) ? $atts['outline'] : '';
  $title = isset($atts['title']) ? $atts['title'] : '';
  $selectedcategory  = isset($atts['category_selector']) ? $atts['category_selector'] : '';

  ob_start(); ?>
  <section
    class="section section-theme-12 companies-block pt-35 pt-md-50 pt-lg-65 pt-xl-85 pt-xxl-120 pb-35 pb-md-50 pb-lg-60 pb-xl-60 pb-xxl-60">
    <div class="container">
      <div class="row justify-content-between mb-25 mb-lg-30">
        <div class="col-12 col-lg-8">
          <!-- Section header -->
          <header class="section-header text-center text-lg-start mb-0">
            <?php
            if (!empty($outline)) {
              ?>
              <p>
                <?php echo esc_html($outline); ?>
              </p>
              <?php
            }
            if (!empty($title)) {
              ?>
              <h2 class="showhead">
                <?php echo esc_html($title); ?>
              </h2>
            <?php } ?>
          </header>
        </div>
      </div>
      <div class="trending-slider">
        <?php
        $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
        $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
        $page_numbr = get_query_var('paged');
        $args = array(
          'post_type' => 'employer',
          'post_status' => 'publish',
          'posts_per_page' => $numofpost,
          'order' => 'DESC',
          'paged' => $page_numbr,
          'orderby' => $orderby, 
          'tax_query'=> array(
             	array(
			'taxonomy' => 'employer_cat',
			'field'=> 'slug',
			'hide_empty' => false,
            'terms' => $selectedcategory,
                  ),
              )
        
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
            $title = get_the_title($post);
            $permalinkget = get_the_permalink($postid);
            $image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');
            $price = get_post_meta($postid, 'jobcircle_field_user_pric', true);
            $admin = get_the_author();
            
                 $job_post = get_post($post);
        		 $post_author = $job_post->post_author;
        		 $post_employer_id = jobcircle_user_employer_id($post_author);
        		 if ($post_employer_id > 0 && get_post_type($post_employer_id) == 'employer') {
        		     $post_author_name = get_the_title($post_employer_id);
        		     $post_author_link = get_permalink($post_employer_id);
        		 } else {
        		     $author_user_obj = get_user_by('id', $post_author);
        		     $post_author_name = $author_user_obj->display_name;
        		     $post_author_link = get_author_posts_url($post_author);
        		 }
            
            $author_id = get_the_author_meta('ID');
            $author_avatar = get_avatar($author_id, 96);
            ?>
            <div class="slick-slide">
              <article class="featured-category-box">
                <div class="img-frame">
                  <?php if (!empty($image)) { ?>
                    <a href="<?php echo esc_html($permalinkget); ?>"><img src="<?php echo esc_url_raw($image[0]); ?>"
                        alt=" Image"></a>
                  <?php }
                  // if (!empty()) { ?>
                  <div class="small-img avtar-igm">
                    <?php echo jobcircle_esc_the_html($author_avatar) ?>
                  </div>
                  <!-- <?php ?> -->
                </div>
                <div class="textbox">
                  
                    <a href="<?php echo jobcircle_esc_the_html($post_author_link) ?>" class="h6" tabindex="0"><?php echo jobcircle_esc_the_html($post_author_name) ?></a>
					<strong class="h3"><?php echo jobcircle_esc_the_html($title) ?></strong>
                  
                  
                  <div class="rating-holder">
                    <span>
                      <?php echo esc_html_e('STARTING AT', 'jobcircle-frame'); ?>
                    </span>

                    <div class="bottom-holder">
                      <?php if (!empty($price)) { ?>
                        <strong>
                          <?php echo esc_html($price); ?>
                        </strong>
                      <?php } ?>
                      <ul class="star-ratings">
                        <li><i class="jobcircle-icon-star filled"></i></li>
                        <li><i class="jobcircle-icon-star filled"></i></li>
                        <li><i class="jobcircle-icon-star filled"></i></li>
                        <li><i class="jobcircle-icon-star filled"></i></li>
                        <li><i class="jobcircle-icon-star filled"></i></li>
                        <li>
                          <?php esc_html_e('(4.9)', 'jobcircle-frame'); ?>
                        </li>
                      </ul>
                    </div>
                  </div>
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
    </div>
  </section>
  <?php
  return ob_get_clean();
}
add_shortcode('jobcircle_trending_services', 'jobcircle_trending_services_frontend');
