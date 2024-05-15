<?php
function jobcircle_company_evviroment()
{
  vc_map(
    array(
      'name' => __('Company Detail Enviroment'),
      'base' => 'jobcircle_company_evviroment',
      'category' => __('Job Circle'),
      'params' => array(
        array(
          'type' => 'textfield',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Title'),
          'param_name' => 'title',
        ),
        //group
        array(
          'type' => 'param_group',
          'value' => '',
          'param_name' => 'explore_multi',
          'params' => array(
            array(
              'type' => 'jobcircle_browse_img',
              'holder' => 'div',
              'class' => '',
              'heading' => __('Upload Image'),
              'param_name' => 'upload_img',
            ),

          ),
        )
      )
    )
  );
}
add_action('vc_before_init', 'jobcircle_company_evviroment');
// Frontend Coding
function jobcircle_company_evviroment_front($atts, $content)
{
  $atts = shortcode_atts(
    array(
      'title' => '',
      'explore_multi' => '',
    ),
    $atts,
    'jobcircle_company_evviroment'
  );
  $title = isset($atts['title']) ? $atts['title'] : '';
  $custom_plan_price = isset($atts['nb_heeratitle']) && !empty($atts['nb_heeratitle']) ? $atts['nb_heeratitle'] : '';
  ob_start();
?>
  <div class="block-holder">
    <?php
    if (!empty($title)) {
    ?>
      <h4> <?php echo esc_html($title); ?> </h4>
    <?php
    } ?>
    <ul class="images-gallery">
      <?php
      $lm_team_list = vc_param_group_parse_atts($atts['explore_multi']);
      foreach ($lm_team_list as $key => $value) {
        $upload_img = isset($value['upload_img']) ? $value['upload_img'] : '';
      ?>
        <li>
             <?php
            if (!empty($upload_img)) {
            ?>
          <a class="image-box" data-fancybox="gallery" href="<?php echo esc_url_raw($upload_img); ?>">
            <?php }
            if (!empty($upload_img)) {
            ?>
              <img src="<?php echo esc_url_raw($upload_img); ?>" width="270" height="190" alt="">
            <?php
            } ?>
          </a>
        </li>
      <?php
      }
      ?>
    </ul>
  </div>
<?php
  return ob_get_clean();
}
add_shortcode('jobcircle_company_evviroment', 'jobcircle_company_evviroment_front');
