<?php
function jobcircle_explore_jobs()
{
    vc_map(
        array(
            'name' => __('Home Six Explore Jobs'),
            'base' => 'jc_explore_jobs',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('TITLE'),
                    'param_name' => 'title',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('SUB TITLE'),
                    'param_name' => 'sub_title',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Image'),
                    'param_name' => 'img',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Shape Image'),
                    'param_name' => 'shape_img',
                ),
                //group
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'multi_review',
                    'params' => array(
                        array(
                            'type' => 'jobcircle_browse_img',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Multi Image'),
                            'param_name' => 'mul_img',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Multi Title'),
                            'param_name' => 'multi_title',
                        ),
                        array(
                            'type' => 'textarea',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Multi Heading'),
                            'param_name' => 'multi_head',
                        ),
                    ),
                )
            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_explore_jobs');

// Frontend Coding 

function jobcircle_explore_jobs_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(
            'title' => '',
            'sub_title' => '',
            'img' => '',
            'shape_img' => '',
            'multi_review' => '',

        ),
        $atts,
        'jobcircle_explore_jobs'
    );

    $title = isset($atts['title']) ? $atts['title'] : '';
    $sub_title = isset($atts['sub_title']) ? $atts['sub_title'] : '';
    $img = isset($atts['img']) ? $atts['img'] : '';
    $shape_img = isset($atts['shape_img']) ? $atts['shape_img'] : '';
    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
   
    ob_start();
    ?>
    <section
        class="section section-theme-3 explore-jobs-block pt-45 pt-md-50 pt-lg-75 pt-xl-100 pt-xxl-135  pb-35 pb-md-50 pb-lg-65 pb-xl-80">
        <div class="container">
            <div class="row flex-md-row-reverse align-items-center">
                <div class="col-12 col-lg-6 col-xxl-7 mb-15 mb-md-30 mb-lg-0">
                    <!-- Section header -->
                    <header class="section-header text-center text-lg-start ms-0 me-0 mb-40 mb-md-45">
                        <?php
                        if (!empty($title)) {
                            ?>
                            <h2>
                                <?php echo esc_html($title); ?>
                            </h2>
                            <?php
                        }
                        ?>
                        <?php
                        if (!empty($sub_title)) {
                            ?>
                            <p>
                                <?php echo esc_html($sub_title); ?>
                            </p>
                            <?php
                        }
                        ?>
                    </header>
                    <ul class="explore-list">
                        <?php

                        $lm_team_list = vc_param_group_parse_atts($atts['multi_review']);

                        foreach ($lm_team_list as $key => $value) {
   
                            $mul_img = isset($value["mul_img"]) ? $value["mul_img"] : '';
                            $multi_title = isset($value["multi_title"]) ? $value["multi_title"] : '';
                            $multi_head = isset($value["multi_head"]) ? $value["multi_head"] : '';

                            ?>

                            <li>
                                <div class="box">
                                    <div class="icon-box">
                                        <?php
                                        if (!empty($mul_img)) {
                                            ?>
                                            <img src="<?php echo esc_url_raw($mul_img); ?>" width="29" height="33"
                                                alt="Get Notified">
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="textbox">
                                        <?php
                                        if (!empty($multi_title)) {
                                            ?>
                                            <strong class="h5">
                                                <?php echo esc_html($multi_title); ?>
                                            </strong>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if (!empty($multi_head)) {
                                            ?>
                                            <p>
                                                <?php echo esc_textarea($multi_head); ?>
                                            </p>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
                <div class="col-12 col-lg-6 col-xxl-5 mb-15 mb-md-30 mb-lg-0">
                    <div class="image-holder">
                        <div class="image-pattern">
                            <?php
                            if (!empty($img)) {
                                ?>
                                <img src="<?php echo esc_url_raw($img); ?>" width="550" height="510" alt="Image Description">
                                <?php
                            }
                            ?>
                        </div>
                        <div class="image-wrap">
                            <?php
                            if (!empty($shape_img)) {
                                ?>
                                <img src="<?php echo esc_url_raw($shape_img); ?> " width="562" height="636"
                                    alt="Image Description">
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('jc_explore_jobs', 'jobcircle_explore_jobs_frontend');
