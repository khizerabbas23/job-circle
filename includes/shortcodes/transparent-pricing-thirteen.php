<?php
function jobcircle_transparent_Pricing(){
  vc_map(
    array(
      'name' => __('Transparent Pricing Thirteen'),
      'base' => 'jobcircle_transparent_Pricing',
      'category' => __('Job Circle'),
      'params' => array(
        array(
          'type' => 'textfield',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Title'),
          'param_name' => 'titl',
        ),
        array(
          'type' => 'textarea',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Description'),
          'param_name' => 'desc',
        ),
        array(
          'type' => 'textarea',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Pricing Question'),
          'param_name' => 'pric_quest',
        ),
        array(
          'type' => 'textarea',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Pricing Faq'),
          'param_name' => 'pric_faq',
        ),
        array(
          'type' => 'textarea',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Pricing Faq Url'),
          'param_name' => 'pric_faq_url',
        ),
        //group
        array(
          'type' => 'param_group',
          'value' => '',
          'param_name' => 'section_multi',
          'params' => array(
            array(
              'type' => 'textfield',
              'holder' => 'div',
              'class' => '',
              'heading' => __('Title'),
              'param_name' => 'mlti_title',
            ),
            array(
              'type' => 'textfield',
              'holder' => 'div',
              'class' => '',
              'heading' => __('Dollar Sign'),
              'param_name' => 'dlr_sign',
            ),
            array(
              'type' => 'textfield',
              'holder' => 'div',
              'class' => '',
              'heading' => __('Price'),
              'param_name' => 'price',
            ),
            array(
              'type' => 'textarea',
              'holder' => 'div',
              'class' => '',
              'heading' => __('Tag Line'),
              'param_name' => 'tg_line',
            ),
            array(
              'type' => 'textfield',
              'holder' => 'div',
              'class' => '',
              'heading' => __('Plan List'),
              'param_name' => 'pln_lst_one',
            ),
            array(
              'type' => 'textfield',
              'holder' => 'div',
              'class' => '',
              'heading' => __('Plan List'),
              'param_name' => 'pln_lst_two',
            ),
            array(
              'type' => 'textfield',
              'holder' => 'div',
              'class' => '',
              'heading' => __('Plan List'),
              'param_name' => 'pln_lst_three',
            ),
            array(
              'type' => 'textfield',
              'holder' => 'div',
              'class' => '',
              'heading' => __('Plan List'),
              'param_name' => 'pln_lst_four',
            ),
            array(
              'type' => 'textfield',
              'holder' => 'div',
              'class' => '',
              'heading' => __('Button Text'),
              'param_name' => 'btn_txt',
            ),
           array(
              'type' => 'textfield',
              'holder' => 'div',
              'class' => '',
              'heading' => __('Product ID'),
              'param_name' => 'product_id',
            ),

          ),
        )
      )
    )
  );
}
add_action('vc_before_init', 'jobcircle_transparent_Pricing');
// Frontend Coding 

function jobcircle_transparent_Pricing_front($atts, $content)
{
  $atts = shortcode_atts(
    array(

      'titl' => '',
      'desc' => '',
      'pric_quest' => '',
      'pric_faq' => '',
      'pric_faq_url' => '',

      'section_multi' => '',

    ),
    $atts,
    'jobcircle_transparent_Pricing'
  );

  $titl = isset($atts['titl']) ? $atts['titl'] : '';
  $desc = isset($atts['desc']) ? $atts['desc'] : '';
  $pric_quest = isset($atts['pric_quest']) ? $atts['pric_quest'] : '';
  $pric_faq = isset($atts['pric_faq']) ? $atts['pric_faq'] : '';
  $pric_faq_url = isset($atts['pric_faq_url']) ? $atts['pric_faq_url'] : '';

  ob_start()
?>
  <section class="section section-theme-13 trending-price-block pt-30 pt-md-50 pt-lg-100 pb-30 pb-md-50 pb-lg-100 pb-xl-120">
    <div class="container">
      <header class="section-header d-flex flex-column-reverse text-center mb-10 mb-md-30 mb-lg-40">
        <?php if (!empty($titl)) {  ?>
          <h2>
            <?php echo esc_html($titl) ?>
          </h2>
        <?php } ?>
        <?php if (!empty($desc)) { ?>
          <p>
            <?php echo esc_textarea($desc) ?>
          </p>
        <?php } ?>
      </header>
      <div class="price-plans-holder">
        <?php
        $lm_team_list = vc_param_group_parse_atts($atts['section_multi']);
        foreach ($lm_team_list as $key => $value) {

          $mlti_title = isset($value["mlti_title"]) ? $value["mlti_title"] : '';
          $dlr_sign = isset($value["dlr_sign"]) ? $value["dlr_sign"] : '';
          $price = isset($value["price"]) ? $value["price"] : '';
          $tg_line = isset($value["tg_line"]) ? $value["tg_line"] : '';
          $pln_lst_one = isset($value["pln_lst_one"]) ? $value["pln_lst_one"] : '';
          $pln_lst_two = isset($value["pln_lst_two"]) ? $value["pln_lst_two"] : '';
          $pln_lst_three = isset($value["pln_lst_three"]) ? $value["pln_lst_three"] : '';
          $pln_lst_four = isset($value["pln_lst_four"]) ? $value["pln_lst_four"] : '';
          $btn_txt = isset($value["btn_txt"]) ? $value["btn_txt"] : '';
          $product_id = isset($value["product_id"]) ? $value["product_id"] : '';
        ?>
          <div class="price-box">
            <div class="left-col">
              <?php if (!empty($mlti_title)) {
              ?>
                <span class="title">
                  <?php echo esc_html($mlti_title) ?>
                </span>
              <?php
              } ?>
              <?php if (!empty($dlr_sign) || !empty($price)) {
              ?>
                <strong class="price"><strong>
                    <?php echo esc_html($dlr_sign) ?></strong><?php echo esc_html($price) ?><sub><?php esc_html_e('.00', 'jobcircle-frame') ?>
                  </sub>
                </strong>
              <?php
              } ?>
              <?php if (!empty($tg_line)) { ?>
                <p>
                  <?php echo esc_textarea($tg_line) ?>
                </p>
              <?php } ?>
            </div>
            <div class="right-col">
              <ul class="list">
                <?php if (!empty($pln_lst_one) || !empty($pln_lst_two) || !empty($pln_lst_three) || !empty($pln_lst_four)) {
                ?>
                  <li>
                    <?php echo esc_html($pln_lst_one) ?>
                  </li>
                  <li>
                    <?php echo esc_html($pln_lst_two) ?>
                  </li>
                  <li>
                    <?php echo esc_html($pln_lst_three) ?>
                  </li>
                  <li>
                    <?php echo esc_html($pln_lst_four) ?>
                  </li>
                <?php } ?>
              </ul>
              <?php if (!empty($btn_txt)) { ?>
              <div class="pricing_wrap">
               <a class="jobcircle-user-pkg-buybtn" data-id="<?php echo $product_id; ?>"><button class="btn btn-get-start">
                  <?php echo esc_html($btn_txt) ?>
                </button></a>
                </div>
              <?php } ?>
            </div>
          </div>
        <?php } ?>
      </div>
      <div class="row mt-30 mt-lg-40">
        <col-12 class="d-flex justify-content-center">
          <?php if (!empty($pric_quest) || !empty($pric_faq_url) || !empty($pln_lst_three) || !empty($pric_faq)) { ?>
            <p class="lead"><span class="jobcircle fa fa-question-circle"></span>
              <?php echo esc_textarea($pric_quest) ?> <a href="<?php echo esc_textarea($pric_faq_url) ?>">
                <?php echo esc_textarea($pric_faq) ?>
              </a>
            </p>
          <?php } ?>
        </col-12>
      </div>
    </div>
  </section>
<?php
  return ob_get_clean();
}
add_shortcode('jobcircle_transparent_Pricing', 'jobcircle_transparent_Pricing_front');
