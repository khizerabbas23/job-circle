<?php
function jobcircle_Best_marketplace()
{
  vc_map(
    array(
      'name' => __('World Best Marketplace S'),
      'base' => 'jobcircle_Best_marketplace',
      'category' => __('Job Circle'),
      'params' => array(
        array(
          'type' => 'jobcircle_browse_img',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Upload Image'),
          'param_name' => 'upload_img',
        ),

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
          'type' => 'textarea',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Description'),
          'param_name' => 'descrip',
        ),

        array(
          'type' => 'textfield',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Rating'),
          'param_name' => 'rating',
        ),

        array(
          'type' => 'textfield',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Rating Line'),
          'param_name' => 'rating_line',
        ),

        array(
          'type' => 'textfield',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Awards'),
          'param_name' => 'awards',
        ),

        array(
          'type' => 'textfield',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Award Line'),
          'param_name' => 'award_line',
        ),

        array(
          'type' => 'textarea',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Short Description'),
          'param_name' => 'short_description',
        ),

        array(
          'type' => 'jobcircle_browse_img',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Background Image'),
          'param_name' => 'bg_img',
        ),

        //group
        array(
          'type' => 'param_group',
          'value' => '',
          'param_name' => 'consultant_multi',
          'params' => array(

            array(
              'type' => 'jobcircle_browse_img',
              'holder' => 'div',
              'class' => '',
              'heading' => __('Add Image'),
              'param_name' => 'add_img',
            ),

            array(
              'type' => 'textfield',
              'holder' => 'div',
              'class' => '',
              'heading' => __('Url'),
              'param_name' => 'url',
            ),

          ),
        )
      )
    )
  );
}
add_action('vc_before_init', 'jobcircle_Best_marketplace');


// Frontend Coding 

function jobcircle_Best_marketplace_front($atts, $content)
{

  $atts = shortcode_atts(
    array(

      'upload_img' => '',
      'outline' => '',
      'title' => '',
      'descrip' => '',
      'rating' => '',
      'rating_line' => '',
      'awards' => '',
      'award_line' => '',
      'short_description' => '',
      'bg_img' => '',


      'consultant_multi' => '',

    ),
    $atts,
    'jobcircle_Best_marketplace'
  );

  $upload_img = isset($atts['upload_img']) ? $atts['upload_img'] : '';
  $bg_img = isset($atts['bg_img']) ? $atts['bg_img'] : '';
  $outline = isset($atts['outline']) ? $atts['outline'] : '';
  $title = isset($atts['title']) ? $atts['title'] : '';
  $descrip = isset($atts['descrip']) ? $atts['descrip'] : '';
  $rating = isset($atts['rating']) ? $atts['rating'] : '';
  $rating_line = isset($atts['rating_line']) ? $atts['rating_line'] : '';
  $awards = isset($atts['awards']) ? $atts['awards'] : '';
  $award_line = isset($atts['award_line']) ? $atts['award_line'] : '';
  $short_description = isset($atts['short_description']) ? $atts['short_description'] : '';



  $custom_plan_price = isset($atts['nb_heeratitle']) && !empty($atts['nb_heeratitle']) ? $atts['nb_heeratitle'] : '';
  ob_start();
?>
  <section class="section section-theme-12 recruiters-block pt-30 pt-md-50 pt-lg-80 pt-xxl-90 pb-0">
    <div class="container">
      <div class="row pb-60">
        <div class="col-12 col-md-6 col-lg-6 img-col">

          <?php
          if (!empty($upload_img)) {
          ?>
            <img src="<?php echo esc_url_raw($upload_img); ?>" alt="image" class="img-1">
          <?php
          } ?>

        </div>
        <div class="col-12 col-md-6 col-lg-6 txt-col">
          <?php
          if (!empty($outline)) {
          ?>
            <p class="mb-5 mb-lg-10"> <?php echo esc_html($outline); ?> </p>
          <?php
          } ?>
          <?php
          if (!empty($title)) {
          ?>
            <h2 class="showhead"><?php echo esc_html($title); ?></h2>
          <?php
          } ?>
          <?php
          if (!empty($descrip)) {
          ?>
            <p><?php echo esc_textarea($descrip); ?></p>
          <?php
          } ?>
          <ul class="rating-box">
            <li>
              <?php
              if (!empty($rating)) {
              ?>
                <strong><?php echo esc_html($rating); ?></strong>
              <?php
              } ?>
              <?php
              if (!empty($rating_line)) {
              ?>
                <span><?php echo esc_html($rating_line); ?></span>
              <?php
              } ?>
            </li>
            <li>
              <?php
              if (!empty($awards)) {
              ?>
                <strong><?php echo esc_html($awards); ?></strong>
              <?php
              } ?>

              <?php
              if (!empty($award_line)) {
              ?>
                <span><?php echo esc_html($award_line); ?></span>
              <?php
              } ?>
            </li>
          </ul>
        </div>
      </div>
      <!-- Section header -->
      <header class="section-header d-flex flex-column-reverse text-center mb-0 mb-md-20">
        <?php
        if (!empty($short_description)) {
        ?>
          <h2 class="showhead"><?php echo esc_html($short_description); ?></h2>
        <?php
        } ?>
      </header>
      <ul class="brands-list pb-60">
        <?php
        $lm_team_list = vc_param_group_parse_atts($atts['consultant_multi']);

        foreach ($lm_team_list as $key => $value) {

          $add_img = isset($value['add_img']) ? $value['add_img'] : '';
          $url = isset($value['url']) ? $value['url'] : '';

          if (!empty($add_img)) {
        ?>
            <li><a href="<?php echo esc_html($url); ?>"><img src="<?php echo esc_url_raw($add_img); ?>" alt="logo"></a></li>
        <?php
          }
        }
        ?>
      </ul>
    </div>
    <?php if (!empty($bg_img)) { ?>
      <div class="section-bg" style="background-image: url('<?php echo esc_url_raw($bg_img); ?>');"></div>
    <?php } ?>
  </section>
<?php
  return ob_get_clean();
}
add_shortcode('jobcircle_Best_marketplace', 'jobcircle_Best_marketplace_front');
