<?php
function get_custs_post_cate() {
    $categories = get_terms(array(
        'taxonomy' => 'candidate_cat',
        'hide_empty' => false,
    ));

    $category_options = array();

    if ($categories && !is_wp_error($categories)) {
        foreach ($categories as $category) {
            $category_options[$category->name] = $category->slug;
        }
    }

    return $category_options;
}
function jobcircle_candidate_openview(){
  vc_map(
    array(
      'name' => __('Candidates Open View'),
      'base' => 'jobcircle_candidate_openview',
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
          'heading' => __('Number Of Post'),
          'param_name' => 'numofpost',
        ),
        array(
            'type' => 'dropdown',
            'holder' => 'div',
            'class' => '',
            'heading' => __('Select Category For Post'),
            'param_name' => 'category_selector',
            'value' => get_custs_post_cate(),
          ),
      ),
      )
    );
}
add_action('vc_before_init', 'jobcircle_candidate_openview');

// popular category frontend
function jobcircle_candidate_openview_frontend($atts, $content){

  $atts = shortcode_atts(
    array(

      'title' => '',
      'heading' => '',
      'orderby' => '',
      'numofpost' => '',
      'sortby' => '',
      'category_selector' => '',
    ),
    $atts,
    'jobcircle_candidate_openview'
  );

  $title = isset($atts['title']) ? $atts['title'] : '';
  $heading = isset($atts['heading']) ? $atts['heading'] : '';
  $sortby = isset($atts['sortby']) ? $atts['sortby'] : '';
  $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';

  ob_start();
?>
  <section class="section section-theme-11 companies-block pt-35 pt-md-50 pt-lg-65 pt-xl-85 pt-xxl-60 pb-35 pb-md-50 pb-lg-60 pb-xl-60 pb-xxl-60">
    <div class="container">
      <div class="row justify-content-between mb-25 mb-lg-30">
        <div class="col-12 col-lg-8">
          <!-- Section header -->
          <header class="section-header text-center text-lg-start mb-0">
            <?php
            if (!empty($title)){ ?>
              <p><?php echo jobcircle_esc_the_html($title) ?></p>
            <?php
            }
            if (!empty($heading)) {
            ?>
              <h2 class="help_question_heading"><?php echo jobcircle_esc_the_html($heading) ?></h2>
            <?php
            }
            ?>
          </header>
        </div>
      </div>
      <div class="expert-slider" id="open-view-slider">
        <?php
        $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
        $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
        $selectedcategory  = isset($atts['category_selector']) ? $atts['category_selector'] : '';
        $args = array(
          'post_type' => 'candidates',
          'post_status' => 'publish',
          'posts_per_page' => $numofpost,
          'order' =>  $sortby,
          'orderby' =>  $orderby,          
            'tax_query' => array(
              array(
                'taxonomy' => 'candidate_cat',
                'field'    => 'slug',
                'terms'    => $selectedcategory,
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
            $permalinkget = get_the_permalink($postid);
            $image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');
            $designation = get_post_meta($postid, 'designation', true);
            $salary = get_post_meta($postid, 'jobcircle_field_salary', true);
            $salary_unit = get_post_meta($postid, 'jobcircle_field_salary_unit', true);

        ?>

            <div class="slick-slide">
              <article class="featured-category-box">
                <div class="img-frame">
                  <?php if (!empty($permalinkget)) { ?>
                    <a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>">
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
                    <a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>">
                    <?php }
                  if (!empty($title)) { ?>
                      <strong class="h6"><?php echo jobcircle_esc_the_html($title) ?></strong>
                    <?php } ?>
                    </a>
                    <?php if (!empty($permalinkget) || !empty($designation)) { ?>
                      <a class="roll" href="<?php echo jobcircle_esc_the_html($permalinkget) ?>"><?php echo jobcircle_esc_the_html($designation) ?></a>
                    <?php } ?>
                    <span>
                      <?php if (!empty($salary) || !empty($salary_unit)) { ?>
                        <strong><?php echo jobcircle_esc_the_html($salary) ?></strong> <?php esc_html_e('/', 'jobcircle-frame') ?> <?php echo jobcircle_esc_the_html($salary_unit)?>
                      <?php } ?>
                    </span>
                    <?php if (!empty($permalinkget)) { ?>
                      <a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>" class="view-profile">
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
  if ($total_posts > $numofpost) {        ?>
        <?php echo jobcircle_pagination($query, true);
    }
    ?>
    <script>
jQuery(document).ready(function($) {
    $('#open-view-slider').slick({
        slidesToShow: 4, 
        slidesToScroll: 4, 
        rows: Math.ceil($('#open-view-slider .slick-slide').length / 4), 
        arrows: true,
        dots: true,
        infinite: false, 
        autoplay: false,
        responsive: [{
            breakpoint: 992,
            settings: {
                slidesToShow: 1, 
                slidesToScroll: 1,
                rows: Math.ceil($('#open-view-slider .slick-slide').length), 
            },
        }],
    });
});
</script>
    
<?php 
  return ob_get_clean();
}
add_shortcode('jobcircle_candidate_openview', 'jobcircle_candidate_openview_frontend');
