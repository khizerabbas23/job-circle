<?php
function jobcircle_top_company_registered()
{
  vc_map(
    array(
      'name' => __('Top Company Registered'),
      'base' => 'top_company_registered',
      'category' => __('job Circle'),
      'params' => array(
        array(
          'type' => 'textfield',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Company Heading'),
          'param_name' => 'c_heding',
        ),
        array(
          'type' => 'textarea',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Company Discription'),
          'param_name' => 'c_disc',
        ),
        array(
          'type' => 'textfield',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Order By'),
          'param_name' => 'orderby',
        ),
        array(
          'type' => 'textfield',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Number Of Post'),
          'param_name' => 'numofpost',
        ),
      ),
    )
  );
}
add_action('vc_before_init', 'jobcircle_top_company_registered');
// Frontend Coding 
function jobcircle_top_company_registered_front($atts, $content)
{

  $atts = shortcode_atts(
    array(
      'c_heding' => '',
      'c_disc' => '',
      'orderby' => '',
      'numofpost' => '',
    ),
    $atts,
    'jobcircle_top_company_registered'
  );
  $c_heding = isset($atts['c_heding']) ? $atts['c_heding'] : '';
  $c_disc = isset($atts['c_disc']) ? $atts['c_disc'] : '';
  $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
  $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';

  ob_start();

?>
  <section class="top_companies_block section-theme-7 theme_seven_sec .theme_seven_sec">
    <div class="container">

      <div class="top_companies_holder">
        <header class="section-header d-flex flex-column text-center mb-30 mb-md-45 mb-xl-40">
          <?php if (!empty($c_disc)) { ?>
            <p><?php echo esc_html($c_disc) ?></p>
          <?php } ?>
          <?php if (!empty($c_heding)) { ?>
            <h2><?php echo esc_html($c_heding) ?></h2>
          <?php } ?>
        </header>
        <div class="companies-slider">
          <?php
          $numofpost  = isset($atts['numofpost']) ? $atts['numofpost'] : '';
          $orderby  = isset($atts['orderby']) ? $atts['orderby'] : '';

          $args = array(
            'post_type' => 'employer', //enter post type name static
            'post_status' => 'publish',
            'posts_per_page' => $numofpost,
            'order' => 'DESC',
            'orderby' =>  $orderby,
            //   'tax_query' => array(
            //     array(
            //       'taxonomy' => 'employer_cat', //enter taxonomy name static
            //       'field'    => 'slug',
            //       'terms'    => 'companies',
            //     ),
            //   ),
            
          );
          // Custom query.
          $query = new WP_Query($args);
          $total_posts = $query->found_posts;

          // Check that we have query results.
          if ($query->have_posts()) {
            // Start looping over the query results.
            while ($query->have_posts()) {
              $query->the_post();
              global $jobcircle_framework_options, $post;

              $post =  get_the_id();
              $title = get_the_title($post);
              $permalinkget = get_the_permalink($post);
              $image = wp_get_attachment_image_src(get_post_thumbnail_id($post), 'single-post-thumbnail');
              $location = get_post_meta($post, 'location', true);
              $job_location = jobcircle_post_location_str($post);
              $open_job = get_post_meta($post, 'jobcircle_field_user_open_job', true);

              // $open_job = get_post_meta($post, 'open_job', true);
          ?>
              <div class="slick-slide">
                <article class="featured-category-box">
                  <div class="wrap">
                    <div class="img-holder">
                         <?php if(!empty($permalinkget || $image)) { ?>
                      <a href="<?php echo esc_html($permalinkget); ?>"><img src="<?php echo  esc_url_raw($image[0]) ?>" alt="Jobcircle"></a>
                      <?php } ?>
                    </div>
                    <div class="textbox">      
                         <?php
                          if(!empty($title)) { ?>
                      <a href="<?php echo esc_html($permalinkget); ?>"><strong class="h6"><?php echo esc_html($title) ?></strong></a>
                      <?php } ?>
                      <?php
                       if(!empty($job_location)) { ?>
                      <p><i class="jobcircle-icon-map-pin icon"></i><?php echo esc_html($job_location); ?></p>
                      <?php } ?>
                      <div class="tag-wrap">
                        <?php  if(!empty($open_job)) { ?>
                        <span class="tag"><?php echo esc_html($open_job) ?></span> 
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                </article>
              </div>
            <?php
            }
          }

          wp_reset_postdata();
          ?>
        </div>
      </div>
    </div>
  </section>
<?php
  return ob_get_clean();
}
add_shortcode('top_company_registered', 'jobcircle_top_company_registered_front');
