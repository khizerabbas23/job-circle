<?php
function home_twlve_explore()
{
    vc_map(
        array(
            'name' => __('Explore Faster Easier'),
            'base' => 'home_twlve_explore',
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
                    'heading' => __('Heading'),
                    'param_name' => 'heading',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Paragraph'),
                    'param_name' => 'paragraph',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('BackGround Image'),
                    'param_name' => 'bg_image',
                ),
                //group
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'home_twlve_explore_multi',
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Points'),
                            'param_name' => 'points',
                        ),
                    )
                ),
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'home_twlve_explore_sec_multi',
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Count Number'),
                            'param_name' => 'count_num',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Count Heading'),
                            'param_name' => 'count_heading',
                        ),
                    )
                ),
            ),
        )
    );
}
add_action('vc_before_init', 'home_twlve_explore');
//welcome Massage frontend
function home_twlve_explore_frontend($atts, $content)
{
    $atts = shortcode_atts(
        array(

            'title' => '',
            'heading' => '',
            'paragraph' => '',
            'bg_image' => '',
            'home_twlve_explore_multi' => '',
            'home_twlve_explore_sec_multi' => '',

        ), $atts, 'home_twlve_explore'
    );

    $title = isset($atts['title']) ? $atts['title'] : '';
    $heading = isset($atts['heading']) ? $atts['heading'] : '';
    $paragraph = isset($atts['paragraph']) ? $atts['paragraph'] : '';
    $bg_image = isset($atts['bg_image']) ? $atts['bg_image'] : '';

    ob_start();
    ?>
    <section
        class="section section-theme-11 how-we-help-block pt-35 pt-md-50 pt-lg-75 pt-xxl-120 pb-35 pb-md-50 pb-lg-80 pb-xxl-100">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-6 img-col">
                    <?php
                    if (!empty($bg_image)) {
                        ?>
                        <img src="<?php echo esc_url_raw($bg_image) ?>" alt="image" class="img-1">
                        <?php
                    }
                    ?>
                </div>
                <div class="col-12 col-md-6 col-lg-6 txt-col">
                    <?php
                    if (!empty($title)) {
                        ?>
                        <p class="mb-5 mb-lg-10">
                            <?php echo esc_html($title) ?>
                        </p>
                        <?php
                    }
                    if (!empty($heading)) {
                        ?>
                        <h2 class="help_question_heading">
                            <?php echo esc_html($heading) ?>
                        </h2>
                        <?php
                    }
                    if (!empty($paragraph)) {
                        ?>
                        <p>
                            <?php echo esc_html($paragraph) ?>
                        </p>
                        <?php
                    } ?>
                    <ul class="list-unstyled help-list">
                        <?php
                        $lm_team_list = vc_param_group_parse_atts($atts['home_twlve_explore_multi']);
                        foreach ($lm_team_list as $key => $value) {

                            $points = isset($value['points']) ? $value['points'] : '';
                            if (!empty($points)) {
                                ?>
                                <li>
                                    <?php echo esc_html($points) ?>
                                </li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="counters-block">
                <div class="container">
                    <div class="row justify-content-center justify-content-md-between">
                        <?php
                        $lm_team_list = vc_param_group_parse_atts($atts['home_twlve_explore_sec_multi']);
                        foreach ($lm_team_list as $key => $value) {

                            $count_num = isset($value['count_num']) ? $value['count_num'] : '';
                            $count_heading = isset($value['count_heading']) ? $value['count_heading'] : '';

                            ?>
                            <div class="counter-box">
                                <div class="counter-stats">
                                    <strong class="numbers h2">
                                        <?php
                                        if (!empty($count_num)) {
                                            ?>
                                            <span data-purecounter-duration="1" data-purecounter-start="0"
                                                data-purecounter-end="<?php echo esc_html($count_num) ?>"
                                                data-purecounter-once="true" data-purecounter-currency=" "
                                                class="purecounter"><?php esc_html_e('0', 'jobcircle-frame') ?></span>
                                            <?php
                                        }
                                        ?>
                                    </strong>
                                    <?php
                                    if (!empty($count_heading)) {
                                        ?>
                                        <span class="subtext">
                                            <?php echo esc_html($count_heading) ?>
                                        </span>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
    return ob_get_clean();
}
add_shortcode('home_twlve_explore', 'home_twlve_explore_frontend');