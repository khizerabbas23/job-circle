<?php
function jobcircle_looking_for_a_carrier()
{
    vc_map(
        array(
            'name' => __('LOOKING FOR A CAREER'),
            'base' => 'jc_looking_for_a_carrier',
            'category' => __('Job Circle'),
            'params' => array(
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
                    'heading' => __('Experience Counting'),
                    'param_name' => 'exp_cunt',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Experience Year'),
                    'param_name' => 'exp_yr',
                ),
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
                            'heading' => __('Icon Image'),
                            'param_name' => 'icn_img',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Counting'),
                            'param_name' => 'count',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Heading'),
                            'param_name' => 'head',
                        ),
                    ),
                ),
            ),
        )
    );
}
add_action('vc_before_init', 'jobcircle_looking_for_a_carrier');
// Frontend Coding 
function jobcircle_looking_for_a_carrier_front($atts, $content)
{
    $atts = shortcode_atts(
        array(

            'mn_img' => '',
            'exp_cunt' => '',
            'exp_yr' => '',
            'head' => '',
            'title' => '',
            'desc' => '',
            'multi_sec' => '',
        ), $atts, 'jobcircle_looking_for_a_carrier'
    );

    $mn_img = isset($atts['mn_img']) ? $atts['mn_img'] : '';
    $exp_cunt = isset($atts['exp_cunt']) ? $atts['exp_cunt'] : '';
    $exp_yr = isset($atts['exp_yr']) ? $atts['exp_yr'] : '';
    $head = isset($atts['head']) ? $atts['head'] : '';
    $title = isset($atts['title']) ? $atts['title'] : '';
    $desc = isset($atts['desc']) ? $atts['desc'] : '';

    ob_start();
    ?>

    <div class="container">
        <div class="row career-block">
            <div class="col-12 col-md-6 order-2 order-md-1">
                <div class="image-holder">
                    <div class="exp-counter">
                        <div class="text">
                            <?php if (!empty($exp_cunt) || !empty($exp_yr)) {
                                ?>
                                <strong>
                                    <?php echo esc_html($exp_cunt); ?>
                                </strong>
                                <?php echo esc_html($exp_yr); ?>
                            <?php } ?>
                        </div>
                    </div>
                    <?php if (!empty($mn_img)) {
                        ?>
                        <img src="<?php echo esc_url_raw($mn_img); ?>" alt="image">
                    <?php } ?>
                </div>
            </div>
            <div class="col-12 col-md-6 order-1 order-md-2 pt-md-30 pt-lg-50">
                <div class="text-box">
                    <?php if (!empty($head)) {
                        ?>
                        <strong class="sub-heading">
                            <?php echo esc_html($head); ?>
                        </strong>
                    <?php } ?>
                    <?php if (!empty($title)) {
                        ?>
                        <h2>
                            <?php echo esc_html($title); ?>
                        </h2>
                    <?php } ?>
                    <?php if (!empty($desc)) {
                        ?>
                        <p>
                            <?php echo esc_html($desc); ?>
                        </p>
                    <?php } ?>
                </div>
                <div class="info-count-boxes">
                    <?php

                    $lm_team_list = vc_param_group_parse_atts($atts['multi_sec']);

                    foreach ($lm_team_list as $key => $value) {

                        $icn_img = isset($value["icn_img"]) ? $value["icn_img"] : '';
                        $count = isset($value["count"]) ? $value["count"] : '';
                        $head = isset($value["head"]) ? $value["head"] : '';
                        ?>
                        <div class="count-box">
                            <?php if (!empty($icn_img)) {
                                ?>
                                <div class="icon"><img src="<?php echo esc_url_raw($icn_img); ?>" alt="icon"></div>
                            <?php } ?>
                            <?php if (!empty($count || $head)) {
                                ?>
                                <p><strong>
                                        <?php echo esc_html($count) ?>
                                    </strong>
                                    <?php echo esc_html($head); ?>
                                </p>
                            <?php } ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    $html = ob_get_clean();
    return $html;
}
add_shortcode('jc_looking_for_a_carrier', 'jobcircle_looking_for_a_carrier_front');