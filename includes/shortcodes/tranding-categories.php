<?php
function jobcircle_trending_categories()
{
  $all_page = array(__('Select Page', 'jobcircle-frame'), '');
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
      'name' => __('Trending Categories'),
      'base' => 'trending_categories',
      'category' => __('Job Circle'),
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
          'heading' => __('Title'),
          'param_name' => 'title',
        ),
        array(
          'type' => 'textarea',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Discription'),
          'param_name' => 'disc',
        ),
        array(
          'type' => 'jobcircle_browse_img',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Image'),
          'param_name' => 'image',
        ),
      )
    )
  );
}
add_action('vc_before_init', 'jobcircle_trending_categories');
// Frontend Coding  
function jobcircle_trending_categories_front($atts, $content)
{
  $atts = shortcode_atts(
    array(
      'title' => '',
      'disc' => '',
      'image' => '',

      'jobcircle_page' => '',

    ),
    $atts,
    'jobcircle_trending_categories'
  );

  $title = isset($atts['title']) ? $atts['title'] : '';
  $disc = isset($atts['disc']) ? $atts['disc'] : '';

  $image = isset($atts['image']) ? $atts['image'] : '';

  $jobcircle_page = isset($atts['jobcircle_page']) ? $atts['jobcircle_page'] : '';

  ob_start();
?>
  <section class="section section-theme-4 bg-white pt-35 pt-md-50 pt-lg-75 pt-xxl-120 pb-35 pb-md-50 pb-lg-65 pb-xxl-100">
    <div class="container">
      <!-- Section header -->
      <header class="section-header d-flex flex-column text-center mb-30 mb-lg-65 mb-xl-100">
        <?php if (!empty($title)) { ?>
          <h2><?php echo esc_html($title) ?></h2>
        <?php } ?>
        <?php if (!empty($disc)) { ?>
          <p><?php echo esc_html($disc) ?></p>
        <?php } ?>
        <?php if (!empty($image)) { ?>
          <img src="<?php echo esc_url_raw($image) ?>" width="26" alt="icon">
        <?php } ?>
      </header>
      <div class="cats-block">
        <?php
        $exclude_category_ids = array(99, 98, 96, 44);
        // Fetch the terms for the custom taxonomy 'job_featured'
        $terms = get_terms(array(
          'taxonomy' => 'job_category',
          'post_type' => 'jobs',
          'hide_empty' => false,
          'parent' => 0,
          'exclude' => $exclude_category_ids,
        ));

        $counter = 0;
        foreach ($terms as $term) {
          if ($counter < 6) {
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
            $query = new WP_Query($args);
            $post_count = $query->found_posts;

            $term_id = $term->term_id;
            $term_meta = get_term_meta($term_id, 'job_category_custom_fields', true);
            $cat_image = isset($term_meta['image']) ? $term_meta['image'] : '';
            // $category_link = get_category_link($term_id);

            $jobcircle_page_id = jobcircle_get_page_id_from_name($jobcircle_page);

            $jobcircle_page_url = home_url('/');
            if ($jobcircle_page_id > 0) {
              $jobcircle_page_url = get_permalink($jobcircle_page_id);
            }
        ?>
            <div class="cat-box">
              <?php if (!empty($jobcircle_page_url) || !empty($term)) {
              ?>
                <a href="<?php echo esc_url($jobcircle_page_url); ?>?job_category=<?php echo esc_html($term->slug) ?>">
                <?php
              }
                ?>
                <div class="icon-box dream">
                  <?php if (!empty($cat_image)) {
                  ?>
                    <img src="<?php echo esc_url($cat_image); ?>" alt="<?php echo esc_attr($term->name); ?>">
                  <?php } ?>
                </div>
                <div class="cat-text">
                  <?php
                  if (!empty($term)) {
                  ?>
                    <strong class="title"><?php echo esc_html($term->name); ?></strong>
                  <?php } ?>
                  <?php
                  if (!empty($term)) {
                  ?>
                    <p><?php echo esc_html($term->count) ?> <?php esc_html_e('Posts Available', 'jobcircle-frame') ?></p>
                  <?php } ?>
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
    </div>
  </section>
<?php
  return ob_get_clean();
}
add_shortcode('trending_categories', 'jobcircle_trending_categories_front');
