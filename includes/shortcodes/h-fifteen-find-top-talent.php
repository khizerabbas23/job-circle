<?php
function jobcircle_find_top_talent()
{
    vc_map(
        array(
            'name' => __('Find Top Talent'),
            'base' => 'jc_find_top_talent',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Background Image'),
                    'param_name' => 'bg_img',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Left Image'),
                    'param_name' => 'left_img',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Heading'),
                    'param_name' => 'heading',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Paragraph'),
                    'param_name' => 'paragraph',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Right Image'),
                    'param_name' => 'right_img',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Learn More Url'),
                    'param_name' => 'learn_more_url',
                ),
                //group
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'jobcircle_find_top_talent_multi',
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Point'),
                            'param_name' => 'point',
                        ),
                    )
                ),
            ),
        )
    );
}
add_action('vc_before_init', 'jobcircle_find_top_talent');

//welcome Massage frontend
function jobcircle_find_top_talent_frontend($atts, $content)
{
    $atts = shortcode_atts(
        array(

            'bg_img' => '',
            'left_img' => '',
            'heading' => '',
            'paragraph' => '',
            'right_img' => '',
            'learn_more_url' => '',

            'jobcircle_find_top_talent_multi' => '',

        ), $atts, 'jobcircle_find_top_talent'
    );

    $bg_img = isset($atts['bg_img']) ? $atts['bg_img'] : '';
    $left_img = isset($atts['left_img']) ? $atts['left_img'] : '';
    $heading = isset($atts['heading']) ? $atts['heading'] : '';
    $paragraph = isset($atts['paragraph']) ? $atts['paragraph'] : '';
    $right_img = isset($atts['right_img']) ? $atts['right_img'] : '';
    $learn_more_url = isset($atts['learn_more_url']) ? $atts['learn_more_url'] : '';
    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';

    ob_start();
    ?>
    <section class="section section-theme-15 find-talent-block pt-35 pt-md-50 pt-xl-90 pb-35 pb-md-50 pb-lg-100 pb-xxl-120"
        style="background-image: url('<?php echo esc_url_raw($bg_img) ?>')">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    <?php
                    if (!empty($left_img)) {
                        ?>
                        <div class="image-holder"><img src="<?php echo esc_url_raw($left_img) ?>" alt="image"></div>
                    <?php } ?>
                </div>
                <div class="col-12 col-md-6">
                    <div class="text-info-box">
                        <?php
                        if (!empty($heading)) {
                            ?>
                            <h2>
                                <?php echo esc_html($heading) ?>
                            </h2>
                        <?php }
                        if (!empty($paragraph)) { ?>
                            <p>
                                <?php echo esc_html($paragraph) ?>
                            </p>
                        <?php } ?>
                        <div class="inner-box">
                            <ul class="list-unstyled">
                                <?php

                                $lm_team_list = vc_param_group_parse_atts($atts['jobcircle_find_top_talent_multi']);

                                foreach ($lm_team_list as $key => $value) {
                                    $point = isset($value['point']) ? $value['point'] : '';
                                    ?>
                                    <li>
                                        <?php echo esc_html($point) ?>
                                    </li>

                                    <?php

                                }
                                ?>
                            </ul>
                            <div class="img-frame">
                                <?php if (!empty($right_img)) {
                                    ?>
                                    <div class="image-holder"><img src="<?php echo esc_url_raw($right_img) ?>" alt="images">
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                        if (!empty($learn_more_url)) {
                            ?>
                            <button class="btn btn-primary"><a class="text-white"
                                    href="<?php echo esc_html($learn_more_url) ?>"><span>
                                        <?php echo esc_html_e('Learn More', 'jobcircle-frame') ?>
                                    </span></a></button>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="illustration"></div>
    </section>

    <?php
    return ob_get_clean();
}
add_shortcode('jc_find_top_talent', 'jobcircle_find_top_talent_frontend');