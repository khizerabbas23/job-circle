<?php
function jobcircle_dream_job()
{
  vc_map(
    array(
      'name' => __('Your Dream Job Here'),
      'base' => 'jc_dream_job',
      'category' => __('Job Circle'),
      'params' => array(

        array(
          'type' => 'jobcircle_browse_img',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Image'),
          'param_name' => 'upper_left',
        ),
        array(
          'type' => 'jobcircle_browse_img',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Image'),
          'param_name' => 'upper_right',
        ),
        array(
          'type' => 'jobcircle_browse_img',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Image'),
          'param_name' => 'lower_left',
        ),
        array(
          'type' => 'jobcircle_browse_img',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Image'),
          'param_name' => 'lower_right',
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
          'heading' => __('Underline Title'),
          'param_name' => 'span_title',
        ),
        array(
          'type' => 'textfield',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Span Title'),
          'param_name' => 'sub_title',
        ),
        array(
          'type' => 'textarea',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Tag Line'),
          'param_name' => 'heading',
        ),
        array(
          'type' => 'textfield',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Search Job Url'),
          'param_name' => 'search_url',
        ),
        array(
          'type' => 'textfield',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Apply Job Url'),
          'param_name' => 'apply_url',
        ),
      )


    )
  );
}
add_action('vc_before_init', 'jobcircle_dream_job');


// Frontend Coding 

function jobcircle_dream_job_frontend($atts, $content)
{

  $atts = shortcode_atts(
    array(
      'upper_left' => '',
      'upper_right' => '',
      'lower_left' => '',
      'lower_right' => '',
      'title' => '',
      'sub_title' => '',
      'span_title' => '',
      'heading' => '',
      'search_url' => '',
      'apply_url' => '',

    ),
    $atts,
    'jobcircle_dream_job'
  );

  $upper_left = isset($atts['upper_left']) ? $atts['upper_left'] : '';
  $upper_right = isset($atts['upper_right']) ? $atts['upper_right'] : '';
  $lower_left = isset($atts['lower_left']) ? $atts['lower_left'] : '';
  $lower_right = isset($atts['lower_right']) ? $atts['lower_right'] : '';
  $title = isset($atts['title']) ? $atts['title'] : '';
  $sub_title = isset($atts['sub_title']) ? $atts['sub_title'] : '';
  $span_title = isset($atts['span_title']) ? $atts['span_title'] : '';
  $heading = isset($atts['heading']) ? $atts['heading'] : '';
  $search_url = isset($atts['search_url']) ? $atts['search_url'] : '';
  $apply_url = isset($atts['apply_url']) ? $atts['apply_url'] : '';

  ob_start();
?>
  <section class="section section-theme-2 dream-visual-block pt-35 pb-35 pb-md-50 pb-lg-55 pb-xl-60">
    <div class="container">
      <div class="dream-visual-box bg-dark-blue">
        <div class="cicle-image large left">
          <?php
          if (!empty($upper_left)) {
          ?>
            <img src="<?php echo esc_url_raw($upper_left, 'jobcircle-frame'); ?>" alt="Image Desciption">
          <?php
          }
          ?>
        </div>
        <div class="cicle-image small right">
          <?php
          if (!empty($upper_right)) {
          ?>
            <img src="<?php echo esc_url_raw($upper_right, 'jobcircle-frame'); ?>" alt="Image Desciption">
          <?php
          }
          ?>
        </div>
        <div class="cicle-image small left">
          <?php
          if (!empty($lower_left)) {
          ?>
            <img src="<?php echo esc_url_raw($lower_left, 'jobcircle-frame'); ?>" alt="Image Desciption">
          <?php
          }
          ?>
        </div>
        <div class="cicle-image large right">
          <?php
          if (!empty($lower_right)) {
          ?>
            <img src="<?php echo esc_url_raw($lower_right, 'jobcircle-frame'); ?>" alt="Image Desciption">
          <?php
          }
          ?>
        </div>
        <header class="section-header text-center mb-30 mb-md-45 mb-xl-60">
          <?php
          if (!empty($title) || !empty($span_title) || ($sub_title)) {
          ?>
            <h2>
              <?php echo esc_html($title, 'jobcircle-frame'); ?> <span class="text-outlined">
                <?php echo esc_html($span_title, 'jobcircle-frame') ?>
              </span>
              <?php echo esc_html($sub_title, 'jobcircle-frame'); ?>
            </h2>
          <?php
          }
          ?>
          <?php
          if (!empty($heading)) {
          ?>
            <p>
              <?php echo esc_textarea($heading); ?>
            </p>
          <?php
          }
          ?>
        </header>
        <div class="buttons-block">

          <a href="<?php echo esc_html($search_url) ?>" class="btn btn-white btn-sm"><span class="btn-text">
              <?php esc_html_e('Search Job', 'jobcircle-frame'); ?>
            </span></a>
          <a href="<?php echo esc_html($apply_url) ?>" class="btn btn-dark-yellow btn-sm"><span class="btn-text">
              <?php esc_html_e('Apply For Job', 'jobcircle-frame'); ?>
            </span></a>
        </div>
      </div>
    </div>
  </section>
<?php
  return ob_get_clean();
}
add_shortcode('jc_dream_job', 'jobcircle_dream_job_frontend');
