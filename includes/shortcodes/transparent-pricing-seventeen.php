<?php
function transpriting_price_home_seventeen()
{
  vc_map(
    array(
      'name' => __('Transparent Pricing 17'),
      'base' => 'transpriting_price_home_seventeen',
      'category' => __('Job Circle'),
      'params' => array(
        array(
          'type' => 'attach_image',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Background Image'),
          'param_name' => 'bg_image',
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
          'heading' => __('Paragraph'),
          'param_name' => 'para',
        ),
        array(
          'type' => 'textfield',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Question'),
          'param_name' => 'question',
        ),
        array(
          'type' => 'textfield',
          'holder' => 'div',
          'class' => '',
          'heading' => __('FAQ'),
          'param_name' => 'faq',
        ),
        array(
          'type' => 'textfield',
          'holder' => 'div',
          'class' => '',
          'heading' => __('FAQ Link'),
          'param_name' => 'faq_link',
        ),
        //group
        array(
          'type' => 'param_group',
          'value' => '',
          'param_name' => 'transpriting_price_home_seventeen_multi',
          'params' => array(

            array(
              'type' => 'textfield',
              'holder' => 'div',
              'class' => '',
              'heading' => __('Package'),
              'param_name' => 'package',
            ),
            array(
              'type' => 'textfield',
              'holder' => 'div',
              'class' => '',
              'heading' => __('Doller Sign'),
              'param_name' => 'doller_sign',
            ),
            array(
              'type' => 'textfield',
              'holder' => 'div',
              'class' => '',
              'heading' => __('Amount'),
              'param_name' => 'amount',
            ),
            array(
              'type' => 'textfield',
              'holder' => 'div',
              'class' => '',
              'heading' => __('Month'),
              'param_name' => 'month',
            ),
            array(
              'type' => 'textfield',
              'holder' => 'div',
              'class' => '',
              'heading' => __('List one'),
              'param_name' => 'list_one',
            ),
            array(
              'type' => 'textfield',
              'holder' => 'div',
              'class' => '',
              'heading' => __('List Two'),
              'param_name' => 'list_two',
            ),
            array(
              'type' => 'textfield',
              'holder' => 'div',
              'class' => '',
              'heading' => __('List Three'),
              'param_name' => 'list_three',
            ),
            array(
              'type' => 'textfield',
              'holder' => 'div',
              'class' => '',
              'heading' => __('list Four'),
              'param_name' => 'list_four',
            ),
            array(
              'type' => 'textfield',
              'holder' => 'div',
              'class' => '',
              'heading' => __('Bussiness package'),
              'param_name' => 'pkg',
            ),
             array(
              'type' => 'textfield',
              'holder' => 'div',
              'class' => '',
              'heading' => __('Product ID'),
              'param_name' => 'product_id',
            ),
          )
        )
      ),
    )
  );
}
add_action('vc_before_init', 'transpriting_price_home_seventeen');

//welcome Massage frontend
function transpriting_price_home_seventeen_frontend($atts, $content)
{

  $atts = shortcode_atts(
    array(
      'bg_image' => '',
      'title' => '',
      'para' => '',
      'question' => '',
      'faq' => '',
      'faq_link' => '',
      'transpriting_price_home_seventeen_multi' => '',

    ),
    $atts,
    'transpriting_price_home_seventeen'
  );

  $bg_image = wp_get_attachment_image_src($atts["bg_image"], 'full');
  $title  = isset($atts['title']) ? $atts['title'] : '';
  $para  = isset($atts['para']) ? $atts['para'] : '';
  $question  = isset($atts['question']) ? $atts['question'] : '';
  $faq  = isset($atts['faq']) ? $atts['faq'] : '';
  $faq_link  = isset($atts['faq_link']) ? $atts['faq_link'] : '';

  $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
  ob_start();
?>
  <section class="section section-theme-17 pricing-plan-block pt-30 pt-md-40 pt-lg-80 pt-xxl-150 pb-30 pb-md-50 pb-lg-100 pb-xxl-120" style="background-image: url(<?php echo esc_url_raw($bg_image[0]) ?>);">
    <div class="container">
      <!-- Section header -->
      <header class="section-header d-flex flex-column-reverse text-center mb-10 mb-md-30 mb-lg-45">
        <?php
        if (!empty($title) || !empty($para)) {
        ?>
          <h2><?php echo esc_html($title) ?></h2>
          <p><?php echo esc_textarea($para) ?></p>
        <?php
        }
        ?>
      </header>
      <div class="row justify-content-center">
        <?php
        $lm_team_list = vc_param_group_parse_atts($atts['transpriting_price_home_seventeen_multi']);
        $counter = 1;
        if (!empty($lm_team_list)) {
          foreach ($lm_team_list as $key => $value) {

            $package  = isset($value["package"]) ? $value["package"] : '';
            $doller_sign  = isset($value["doller_sign"]) ? $value["doller_sign"] : '';
            $amount  = isset($value["amount"]) ? $value["amount"] : '';
            $month  = isset($value["month"]) ? $value["month"] : '';
            $list_one  = isset($value["list_one"]) ? $value["list_one"] : '';
            $list_two  = isset($value["list_two"]) ? $value["list_two"] : '';
            $list_three  = isset($value["list_three"]) ? $value["list_three"] : '';
            $list_four  = isset($value["list_four"]) ? $value["list_four"] : '';
            $pkg  = isset($value["pkg"]) ? $value["pkg"] : '';
            $product_id  = isset($value['product_id']) ? $value['product_id'] : '';

            if ($counter == 1) {
              $plan = 'column-left';
              $plans = 'pricing-plan';
              $btn = 'btn light-yellow';
            } elseif ($counter == 2) {
              $plan = 'column-center';
              $plans = 'pricing-plan recommended';
              $tag = 'tag';
              $btn = 'btn';
            } elseif ($counter == 3) {
              $plan = 'column-right';
              $plans = 'pricing-plan';
              $tag = '';
              $btn = 'btn light-yellow';
            }

        ?>
            <div class="col-12 col-md-6 col-lg-4 <?php echo jobcircle_esc_the_html($plan )?>">
              <div class="<?php echo jobcircle_esc_the_html($plans) ?>">
                <div class="card-head">
                  <span class="<?php echo jobcircle_esc_the_html($tag) ?>"><?php echo jobcircle_esc_the_html($pkg )?></span>
                  <?php
                  if (!empty($package) || !empty($doller_sign) || !empty($amount) || !empty($month)) {
                  ?>
                    <span class="title"><?php echo esc_html($package) ?></span>
                    <strong class="price"><sup><?php echo esc_html($doller_sign) ?></sup><?php echo esc_html($amount) ?><sub><?php echo esc_html($month) ?></sub></strong>
                  <?php
                  }
                  ?>
                </div>
                <ul class="feature-list">
                  <?php
                  if (!empty($list_one) || !empty($list_two) || !empty($list_three) || !empty($list_four)) {
                  ?>
                    <li><?php echo esc_html($list_one) ?></li>
                    <li><?php echo esc_html($list_two) ?></li>
                    <li><?php echo esc_html($list_three) ?></li>
                    <li><?php echo esc_html($list_four) ?></li>
                  <?php
                  }
                  ?>
                </ul>
                <div class="pricing_wrap">
                <button class="<?php echo jobcircle_esc_the_html($btn) ?> jobcircle-user-pkg-buybtn" data-id="<?php echo $product_id; ?>"><span><?php esc_html_e('Get Started', 'jobcircle-frame') ?></span></button>
                </div>
              </div>
            </div>
          <?php
            $counter++;
          }
          ?>
      </div>
      <div class="row">
        <col-12 class="d-flex justify-content-center">
          <?php
          if (!empty($question) || !empty($faq)) {
          ?>
            <p class="lead"><span class="fa-solid fa-circle-question"></span><?php echo esc_html($question) ?><a href="<?php echo esc_html($faq_link) ?>"> <?php echo esc_html($faq) ?></a></p>
          <?php } ?>
        </col-12>
      </div>
    </div>
  </section>
<?php
          return ob_get_clean();
        }
      }
      add_shortcode('transpriting_price_home_seventeen', 'transpriting_price_home_seventeen_frontend');
