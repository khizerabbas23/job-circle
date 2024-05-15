<?php
function jobcircle_what_customer_say()
{
  vc_map(
    array(
      'name' => __('What our customers says'),
      'base' => 'jc_what_customer_say',
      'category' => __('job Circle'),
      'params' => array(
        array(
          'type' => 'jobcircle_browse_img',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Background Image'),
          'param_name' => 'bg_img',
        ),
        array(
          'type' => 'textarea',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Sub Title'),
          'param_name' => 'sub_title',
        ),
        array(
          'type' => 'textfield',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Title'),
          'param_name' => 'titl',
        ),
        array(
          'type' => 'jobcircle_browse_img',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Image'),
          'param_name' => 'img_1',
        ),
        array(
          'type' => 'jobcircle_browse_img',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Image'),
          'param_name' => 'img_2',
        ),

        //group
        array(
          'type' => 'param_group',
          'value' => '',
          'param_name' => 'customer_multi',
          'params' => array(
            array(
              'type' => 'textfield',
              'holder' => 'div',
              'class' => '',
              'heading' => __('Title'),
              'param_name' => 'mlti_title',
            ),
            array(
              'type' => 'textarea',
              'holder' => 'div',
              'class' => '',
              'heading' => __('Description'),
              'param_name' => 'multi_desc',
            ),
            array(
              'type' => 'jobcircle_browse_img',
              'holder' => 'div',
              'class' => '',
              'heading' => __('Author Image'),
              'param_name' => 'authr_img',
            ),
            array(
              'type' => 'textfield',
              'holder' => 'div',
              'class' => '',
              'heading' => __('Author Name'),
              'param_name' => 'authr_name',
            ),
            array(
              'type' => 'textarea',
              'holder' => 'div',
              'class' => '',
              'heading' => __('Author Skill'),
              'param_name' => 'authr_skill',
            ),
          ),
        )
      )
    )
  );
}
add_action('vc_before_init', 'jobcircle_what_customer_say');

// Frontend Coding 
function jobcircle_what_customer_say_front($atts, $content)
{

  $atts = shortcode_atts(
    array(

      'bg_img' => '',
      'sub_title' => '',
      'titl' => '',
      'img_1' => '',
      'img_2' => '',

      'customer_multi' => '',
    ),
    $atts,
    'jobcircle_what_customer_say'
  );

  $bg_img = isset($atts['bg_img']) ? $atts['bg_img'] : '';
  $sub_title = isset($atts['sub_title']) ? $atts['sub_title'] : '';
  $titl = isset($atts['titl']) ? $atts['titl'] : '';
  $img_1 = isset($atts['img_1']) ? $atts['img_1'] : '';
  $img_2 = isset($atts['img_2']) ? $atts['img_2'] : '';
  ob_start()
?>
  <section class="customer_reviews_block section-theme-7" style="background-image: url(
            <?php if (!empty($bg_img)) {
            ?>
            <?php echo esc_url_raw($bg_img) ?>
            <?php
            } ?>);">
    <div class="container">
      <header class="section-header">
        <?php if (!empty($sub_title)) {
        ?>
          <p>
            <?php echo esc_textarea($sub_title) ?>
          </p>
        <?php
        } ?>
        <?php if (!empty($titl)) {
        ?>
          <h2>
            <?php echo esc_html($titl) ?>
          </h2>
        <?php
        } ?>
      </header>
      <div class="holder">
        <div class="imgs_holder">
          <div class="img_box">
            <?php if (!empty($img_1)) {
            ?>
              <img src="<?php echo esc_url_raw($img_1) ?>" alt="img">
            <?php
            } ?>
          </div>
          <div class="img_box">
            <?php if (!empty($img_2)) {
            ?>
              <img src="<?php echo esc_url_raw($img_2) ?>" alt="img">
            <?php
            } ?>
          </div>
        </div>
        <div class="reviews_holder">
          <div class="reviews-slider tweets-slider">
            <?php
            $lm_team_list = vc_param_group_parse_atts($atts['customer_multi']);
            foreach ($lm_team_list as $key => $value) {

              $mlti_title = isset($value["mlti_title"]) ? $value["mlti_title"] : '';
              $multi_desc = isset($value["multi_desc"]) ? $value["multi_desc"] : '';
              $authr_img = isset($value["authr_img"]) ? $value["authr_img"] : '';
              $authr_name = isset($value["authr_name"]) ? $value["authr_name"] : '';
              $authr_skill = isset($value["authr_skill"]) ? $value["authr_skill"] : '';
            ?>
              <div>
                <strong class="h5">
                  <?php if (!empty($mlti_title)) {
                  ?>
                    <?php echo esc_html($mlti_title) ?>
                  <?php
                  } ?>
                </strong>
                <p>
                  <?php if (!empty($multi_desc)) {
                  ?>
                    <?php echo esc_textarea($multi_desc) ?>
                  <?php
                  } ?>
                </p>
                <div class="customer_info">
                  <div class="customer_img">
                    <?php if (!empty($authr_img)) {
                    ?>
                      <img src="<?php echo esc_url_raw($authr_img) ?>" alt="img">
                    <?php
                    } ?>
                  </div>
                  <div class="bio_info">
                    <strong class="h6">
                      <?php if (!empty($authr_name)) {
                      ?>
                        <?php echo esc_html($authr_name) ?>
                      <?php
                      } ?>
                    </strong>
                    <p>
                      <?php if (!empty($authr_skill)) {
                      ?>
                        <?php echo esc_html($authr_skill) ?>
                      <?php } ?>
                    </p>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php
  return ob_get_clean();
}
add_shortcode('jc_what_customer_say', 'jobcircle_what_customer_say_front');
