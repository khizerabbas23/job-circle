<?php
function jobcircle_how_its_work_nine()
{

    vc_map(

        array(
            'name' => __('How Its Work Nine'),
            'base' => 'how_its_work_nine',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title'),
                    'param_name' => 'heading',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Heading'),
                    'param_name' => 'sub_heading',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Image'),
                    'param_name' => 'image',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('End To End Heading'),
                    'param_name' => 'end_to_heading',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Description'),
                    'param_name' => 'desc',
                ),
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'how_its_work_nine_multi',
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Title'),
                            'param_name' => 'multi_title',
                        ),
                        array(
                            'type' => 'jobcircle_browse_img',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Image'),
                            'param_name' => 'multi_image',
                        ),
                        array(
                            'type' => 'textarea',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Description'),
                            'param_name' => 'multi_para',
                        ),
                    )
                ),
                // Second Multi
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'end_to_end_hiring_multi',
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Title'),
                            'param_name' => 'title',
                        ),
                    )
                ),
                // Third Multi
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'end_to_end_hiring2_multi',
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
                            'heading' => __('Counter'),
                            'param_name' => 'counter',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Counter Title'),
                            'param_name' => 'counter_title',
                        ),
                    )
                )
                // End Second Multi

            ),


        )
    );
}
add_action('vc_before_init', 'jobcircle_how_its_work_nine');

//welcome Massage frontend
function jobcircle_how_its_work_nine_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(

            'heading' => '',
            'sub_heading' => '',
            'end_to_heading' => '',
            'desc' => '',
            'image' => '',


            'end_to_end_hiring_multi' => '',
            'end_to_end_hiring2_multi' => '',
            'how_its_work_nine_multi' => '',

        ), $atts, 'jobcircle_how_its_work_nine'
    );

    $heading = isset($atts['heading']) ? $atts['heading'] : '';
    $sub_heading = isset($atts['sub_heading']) ? $atts['sub_heading'] : '';
    $end_to_heading = isset($atts['end_to_heading']) ? $atts['end_to_heading'] : '';
    $desc = isset($atts['desc']) ? $atts['desc'] : '';
    $image = isset($atts['image']) ? $atts['image'] : '';

    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
    ob_start();
    ?>
<section class="section section-theme-9 works_area">
    <div class="container">
        <div class="section-header text-center mb-40 mb-md-60">
            <?php
                if (!empty($heading)) {
                    ?>
            <p>
                <?php echo esc_html($heading) ?>
            </p>
            <?php
                }
                if (!empty($sub_heading)) {
                    ?>
            <h2><span class="text-outlined">
                    <?php echo esc_html($sub_heading) ?>
                </span></h2>
            <?php
                }
                ?>
        </div>
        <div class="row mb-50 mb-lg-100 mb-xl-135">
            <?php
                $lm_team_list = vc_param_group_parse_atts($atts['how_its_work_nine_multi']);
                foreach ($lm_team_list as $key => $value) {

                    $multi_title = isset($value['multi_title']) ? $value['multi_title'] : '';
                    $multi_para = isset($value['multi_para']) ? $value['multi_para'] : '';
                    $multi_image = isset($value['multi_image']) ? $value['multi_image'] : '';

                    ?>
            <div class="col-12 mb-30 mb-lg-0 col-lg-4 d-flex">
                <div class="works_info_column">
                    <div class="wrap">
                        <?php if (!empty($multi_title)) { ?>
                        <strong class="title">
                            <?php echo esc_html($multi_title) ?>
                        </strong>
                        <?php } ?>
                        <div class="img_holder">
                            <?php if (!empty($multi_image)) { ?>
                            <img src="<?php echo esc_url_raw($multi_image) ?>" alt="img">
                            <?php } ?>
                        </div>
                        <?php
                                if (!empty($multi_para)) {
                                    ?>
                        <p>
                            <?php echo esc_html($multi_para) ?>
                        </p>
                        <?php
                                }
                                ?>
                    </div>
                </div>
            </div>
            <?php
                }
                ?>
        </div>
        <div class="row">
            <div class="col-12 mb-50 mb-lg-0 col-lg-6">
                <div class="img_wrap">
                    <?php
                        if (!empty($image)) {
                            ?>
                    <img src="<?php echo esc_url_raw($image) ?>" alt="img">
                    <?php
                        }
                        ?>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="text_wrap">
                    <?php
                        if (!empty($end_to_heading)) {
                            ?>
                    <strong class="h2">
                        <?php echo esc_html($end_to_heading) ?>
                    </strong>
                    <?php
                        }
                        if (!empty($desc)) {
                            ?>
                    <p>
                        <?php echo esc_html($desc) ?>
                    </p>
                    <?php
                        }
                        ?>
                    <ul class="list">
                        <?php
                            $lm_team_list = vc_param_group_parse_atts($atts['end_to_end_hiring_multi']);
                            foreach ($lm_team_list as $key => $value) {

                                $title = isset($value['title']) ? $value['title'] : '';
                                ?>
                        <li>
                            <i class="jobcircle-icon-tick1 icon"></i>
                            <?php
                                    if (!empty($title)) {
                                        ?>
                            <span class="text">
                                <?php echo esc_html($title) ?>
                            </span>
                            <?php
                                    }
                                    ?>
                        </li>
                        <?php
                            }
                            ?>
                    </ul>
                    <div class="row counters-block">
                        <?php
                            $counters = 1;
                            $lm_team_list = vc_param_group_parse_atts($atts['end_to_end_hiring2_multi']);
                            foreach ($lm_team_list as $key => $value) {

                                $img = isset($value['img']) ? $value['img'] : '';
                                $counter = isset($value['counter']) ? $value['counter'] : '';
                                $counter_title = isset($value['counter_title']) ? $value['counter_title'] : '';

                                if ($counters == 1) {
                                    $purcounter = 'k';
                                } elseif ($counters == 2) {
                                    $purcounter = 'm';
                                }
                                ?>
                        <div class="col-12 col-sm-6">
                            <div class="counter-box">
                                <div class="icon">
                                    <?php if (!empty($img)) { ?>
                                    <img src="<?php echo esc_url_raw($img) ?>" alt="img">
                                    <?php } ?>
                                </div>
                                <div class="counter-stats">
                                    <strong class="numbers h2">
                                        <span data-purecounter-duration="1"data-purecounter-start="0"<?php if(!empty($counter)){ ?>data-purecounter-end="<?php echo esc_html($counter) ?>"<?php } ?>data-purecounter-once="true"class="purecounter"><?php esc_html('0', 'jobcircle-frame') ?>
                                        </span><?php echo jobcircle_esc_the_html($purcounter) ?></strong>
                                    <?php if(!empty($counter_title)) { ?>
                                    <span class="subtext"> <?php echo esc_html($counter_title) ?> </span>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <?php
                                $counters++;
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
add_shortcode('how_its_work_nine', 'jobcircle_how_its_work_nine_frontend');