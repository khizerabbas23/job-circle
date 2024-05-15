<?php
function jobcircle_app_avail_now()
{
    vc_map(
        array(
            'name' => __('APP AVAILABLE NOW'),
            'base' => 'jc_app_avail_now',
            'category' => __('Job Circle'),
            'params' => array(


                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Heading'),
                    'param_name' => 'head',
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
                    'param_name' => 'desc',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('List One'),
                    'param_name' => 'lst_one',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('List Two'),
                    'param_name' => 'lst_two',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('List Three'),
                    'param_name' => 'lst_three',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Main Image'),
                    'param_name' => 'mn_img',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Rtae'),
                    'param_name' => 'rate',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Rate Title'),
                    'param_name' => 'rat_title',
                ),

                //Group
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'multi_sec',
                    'params' => array(

                        array(
                            'type' => 'jobcircle_browse_img',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Image'),
                            'param_name' => 'img',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('URL'),
                            'param_name' => 'url',
                        ),

                    ),
                ),
            ),
        )
    );
}
add_action('vc_before_init', 'jobcircle_app_avail_now');


// Frontend Coding 

function jobcircle_app_avail_now_front($atts, $content){

    $atts = shortcode_atts(
        array(

            'head' => '',
            'title' => '',
            'desc' => '',
            'lst_one' => '',
            'lst_two' => '',
            'lst_three' => '',
            'mn_img' => '',
            'rate' => '',
            'rat_title' => '',
            'multi_sec' => '',
        ),
        $atts,
        'jobcircle_app_avail_now'
    );

    $head = isset($atts['head']) ? $atts['head'] : '';
    $title = isset($atts['title']) ? $atts['title'] : '';
    $desc = isset($atts['desc']) ? $atts['desc'] : '';
    $lst_one = isset($atts['lst_one']) ? $atts['lst_one'] : '';
    $lst_two = isset($atts['lst_two']) ? $atts['lst_two'] : '';
    $lst_three = isset($atts['lst_three']) ? $atts['lst_three'] : '';
    $mn_img = isset($atts['mn_img']) ? $atts['mn_img'] : '';
    $rate = isset($atts['rate']) ? $atts['rate'] : '';
    $rat_title = isset($atts['rat_title']) ? $atts['rat_title'] : '';

    ob_start();?>
    <section class="section section-theme-4 apps-block bg-white pt-0 pt-md-50 pt-lg-75 pt-xxl-120 pb-35 pb-md-50 pb-lg-65 pb-xxl-100">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-md-6">
                    <div class="text">
                        <?php if (!empty($head)) {
                        ?>
                            <strong class="sub-heading"><?php echo esc_html($head); ?></strong>
                        <?php } ?>
                        <?php if (!empty($title)) {
                        ?>
                            <h2><?php echo esc_html($title); ?></h2>
                        <?php } ?>
                        <?php if (!empty($desc)) {
                        ?>
                            <p><?php echo esc_textarea($desc); ?></p>
                        <?php } ?>
                        <ul class="list-unstyled list">
                            <?php if (!empty($lst_one)) {
                            ?>
                                <li><?php echo esc_html($lst_one); ?></li>
                            <?php } ?>
                            <?php if (!empty($lst_two)) {
                            ?>
                                <li><?php echo esc_html($lst_two); ?></li>
                            <?php } ?>
                            <?php if (!empty($lst_three)) {
                            ?>
                                <li><?php echo esc_html($lst_three); ?></li>
                            <?php } ?>
                        </ul>
                        <div class="download-btns">
                            <?php

                            $lm_team_list = vc_param_group_parse_atts($atts['multi_sec']);

                            foreach ($lm_team_list as $key => $value) {

                                $img = isset($value["img"]) ? $value["img"] : '';
                                $url = isset($value["url"]) ? $value["url"] : '';

                            ?>
                                <?php if (!empty($url) || !empty($img)) {
                                ?>
                                    <a href="<?php echo esc_html($url); ?>"><img src="<?php echo esc_url_raw($img); ?>" alt="google"></a>
                                <?php } ?>

                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="image-holder">
                        <div class="exp-counter">
                            <div class="text">
                                <?php if (!empty($rate) || !empty($rat_title)) {
                                ?>
                                    <strong><?php echo esc_html($rate); ?></strong><?php echo esc_html($rat_title); ?>
                                <?php } ?>
                            </div>
                        </div>
                        <?php if (!empty($mn_img)) {
                        ?>
                            <img src="<?php echo esc_url_raw($mn_img); ?>" alt="image">
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>


<?php
    $html =  ob_get_clean();
    return $html;
}
add_shortcode('jc_app_avail_now', 'jobcircle_app_avail_now_front');
