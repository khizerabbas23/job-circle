<?php
function jobcircle_trending_service_eleven()
{
  vc_map(
    array(
      'name' => __('Trending Service'),
      'base' => 'jc_trending_service_eleven',
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
          'type' => 'textarea',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Description'),
          'param_name' => 'desc',
        ),
        //group
        array(
          'type' => 'param_group',
          'value' => '',
          'param_name' => 'multi',
          'params' => array(

            array(
              'type' => 'jobcircle_browse_img',
              'holder' => 'div',
              'class' => '',
              'heading' => __('Upload Image'),
              'param_name' => 'upld_img',
            ),
            array(
              'type' => 'textfield',
              'holder' => 'div',
              'class' => '',
              'heading' => __('Title'),
              'param_name' => 'titl',
            ),
            array(
              'type' => 'textfield',
              'holder' => 'div',
              'class' => '',
              'heading' => __('Skill'),
              'param_name' => 'skill',
            ),
            array(
              'type' => 'textfield',
              'holder' => 'div',
              'class' => '',
              'heading' => __('Admin Name'),
              'param_name' => 'ad_name',
            ),
            array(
              'type' => 'textfield',
              'holder' => 'div',
              'class' => '',
              'heading' => __('Amount'),
              'param_name' => 'amount',
            ),
            array(
              'type' => 'jobcircle_browse_img',
              'holder' => 'div',
              'class' => '',
              'heading' => __('Avatar Image'),
              'param_name' => 'avatr_img',
            ),
            array(
              'type' => 'textfield',
              'holder' => 'div',
              'class' => '',
              'heading' => __('Url'),
              'param_name' => 'sec_ulr',
            ),
          ),
        )
      )
    )
  );
}
add_action('vc_before_init', 'jobcircle_trending_service_eleven');


// Frontend Coding 

function jobcircle_trending_service_eleven_front($atts, $content)
{

  $atts = shortcode_atts(
    array(

      'title' => '',
      'desc' => '',
      'multi' => '',

    ),
    $atts,
    'jobcircle_trending_service_eleven'
  );

  $title = isset($atts['title']) ? $atts['title'] : '';
  $desc = isset($atts['desc']) ? $atts['desc'] : '';
  ob_start();
?>
  <section class="section section-theme-6 bg-white pt-20 pt-md-50 pt-lg-75 pt-xxl-120 pb-35 pb-md-50 pb-lg-65 pb-xxl-100">
    <div class="container">
      <!-- Section header -->
      <header class="section-header d-flex flex-column text-center mb-30 mb-lg-45">
        <?php if (!empty($title)) { ?>
          <h2><?php echo esc_html($title) ?></h2>
        <?php } ?>
        <?php if (!empty($desc)) { ?>
          <p><?php echo esc_textarea($desc) ?></p>
        <?php } ?>
      </header>
      <div class="services-carousel">

        <?php
        $lm_team_list = vc_param_group_parse_atts($atts['multi']);
        foreach ($lm_team_list as $key => $value) {

          $upld_img = isset($value['upld_img']) ? $value['upld_img'] : '';
          $titl = isset($value['titl']) ? $value['titl'] : '';
          $skill = isset($value['skill']) ? $value['skill'] : '';
          $ad_name = isset($value['ad_name']) ? $value['ad_name'] : '';
          $amount = isset($value['amount']) ? $value['amount'] : '';
          $avatr_img = isset($value['avatr_img']) ? $value['avatr_img'] : '';
          $sec_ulr = isset($value['sec_ulr']) ? $value['sec_ulr'] : '';
        ?>
          <div class="service-slide">
            <div class="inner-frame">
              <a href="<?php echo esc_html($sec_ulr) ?>">
                <div class="image-holder">
                  <?php if (!empty($upld_img)) { ?>
                    <img src="<?php echo esc_url_raw($upld_img) ?>" alt="image">
                  <?php } ?>
                </div>
                <div class="service-info-box">
                  <?php if (!empty($skill)) { ?>
                    <strong class="sub-heading"><?php echo esc_html($skill) ?></strong>
                  <?php } ?>
                  <?php if (!empty($titl)) { ?>
                    <h2><?php echo esc_html($titl) ?></h2>
                  <?php } ?>
                  <div class="service-footer">
                    <div class="img">
                      <?php if (!empty($avatr_img)) { ?>
                        <img src="<?php echo esc_url_raw($avatr_img) ?>" alt="image">
                      <?php } ?>
                    </div>
                    <div class="text">
                      <?php if (!empty($ad_name)) { ?>
                        <strong class="title"><?php echo esc_html($ad_name) ?></strong>
                      <?php } ?>
                      <p class="m-0 price"><?php esc_html_e('Starting at', 'jobcircle-frame') ?>
                        <?php if (!empty($amount)) { ?>
                          <strong><?php echo esc_html($amount) ?></strong>
                        <?php } ?>
                      </p>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
        <?php } ?>
        </ul>
      </div>
    </div>
  </section>
<?php
  return ob_get_clean();
}
add_shortcode('jc_trending_service_eleven', 'jobcircle_trending_service_eleven_front');
