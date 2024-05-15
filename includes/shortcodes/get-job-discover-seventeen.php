<?php
function jobcircle_get_the_job()
{
    vc_map(
        array(
            'name' => __('Get The Job Discover 17'),
            'base' => 'jobcircle_get_the_job',
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
                //Group
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'first_multi',
                    'params' => array(

                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Numbers'),
                            'param_name' => 'numbrs',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Heading'),
                            'param_name' => 'heading',
                        ),

                    ),
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Main Image'),
                    'param_name' => 'mn_img',
                ),

                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'sec_multi',
                    'params' => array(

                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Counter number'),
                            'param_name' => 'count_num',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Counter Heading'),
                            'param_name' => 'count_heading',
                        ),
                    ),
                )
            ),
        )
    );
}
add_action('vc_before_init', 'jobcircle_get_the_job');

// Frontend Coding 

function jobcircle_get_the_job_front($atts, $content)
{
    $atts = shortcode_atts(
        array(

            'head' => '',
            'title' => '',
            'desc' => '',
            'lst_one' => '',
            'lst_two' => '',
            'lst_three' => '',
            'mn_img' => '',

            'first_multi' => '',
            'sec_multi' => '',

        ), $atts, 'jobcircle_get_the_job'
    );

    $head = isset($atts['head']) ? $atts['head'] : '';
    $title = isset($atts['title']) ? $atts['title'] : '';
    $desc = isset($atts['desc']) ? $atts['desc'] : '';
    $lst_one = isset($atts['lst_one']) ? $atts['lst_one'] : '';
    $lst_two = isset($atts['lst_two']) ? $atts['lst_two'] : '';
    $lst_three = isset($atts['lst_three']) ? $atts['lst_three'] : '';
    $mn_img = isset($atts['mn_img']) ? $atts['mn_img'] : '';

    ob_start();
    ?>
    <section class="section section-theme-17 featured_Jobs_Block discover-company">
        <div class="container">
            <div class="discover_info_holder">
                <div class="row">
                    <div class="col-12 col-lg-5 mb-50 mb-lg-0">
                        <div class="text_wrap">
                            <?php if (!empty($head)) { ?>
                                <p>
                                    <?php echo esc_html($head) ?>
                                </p>
                            <?php } ?>
                            <?php if (!empty($title)) { ?>
                                <h2 class="h2">
                                    <?php echo esc_html($title) ?>
                                </h2>
                            <?php } ?>
                            <?php if (!empty($desc)) { ?>
                                <p>
                                    <?php echo esc_html($desc) ?>
                                </p>
                            <?php } ?>
                            <ul class="list">
                                <li>
                                    <i class="jobcircle-icon-tick1 icon"></i>
                                    <?php if (!empty($lst_one)) { ?>
                                        <span class="text">
                                            <?php echo esc_html($lst_one) ?>
                                        </span>
                                    <?php } ?>
                                </li>
                                <li>
                                    <i class="jobcircle-icon-tick1 icon"></i>
                                    <?php if (!empty($lst_two)) { ?>
                                        <span class="text">
                                            <?php echo esc_html($lst_two) ?>
                                        </span>
                                    <?php } ?>
                                </li>
                                <li>
                                    <i class="jobcircle-icon-tick1 icon"></i>
                                    <?php if (!empty($lst_three)) { ?>
                                        <span class="text">
                                            <?php echo esc_html($lst_three) ?>
                                        </span>
                                    <?php } ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 col-lg-7">
                        <div class="img_wrap">
                            <?php

                            $lm_team_list = vc_param_group_parse_atts($atts['first_multi']);
                            $counter = 1;
                            foreach ($lm_team_list as $key => $value) {

                                $numbrs = isset($value["numbrs"]) ? $value["numbrs"] : '';
                                $heading = isset($value["heading"]) ? $value["heading"] : '';

                                if ($counter == 1) {
                                    $color = 'pink';
                                } elseif ($counter == 2) {
                                    $color = 'light-purple';
                                }
                                ?>
                                <div class="counter-round-box <?php echo jobcircle_esc_the_html($color) ?>">
                                    <div class="counter-stats">
                                        <strong class="numbers h2">
                                            <span data-purecounter-duration="1" data-purecounter-start="0"
                                                data-purecounter-end="<?php echo jobcircle_esc_the_html($numbrs) ?>" data-purecounter-once="true"
                                                class="purecounter"><?php esc_html_e('0', 'jobcircle-frame') ?></span><?php echo esc_html_e('k+', 'jobcircle-frame') ?>
                                        </strong>
                                        <?php if (!empty($heading)) { ?>
                                            <span class="subtext">
                                                <?php echo esc_html($heading) ?>
                                            </span>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php
                                $counter++;
                            }
                            ?>
                            <?php if (!empty($heading)) { ?>
                                <img src="<?php echo esc_url_raw($mn_img) ?>" alt="img">
                            <?php } ?>
                            <?php
                            $lm_team_list = vc_param_group_parse_atts($atts['sec_multi']);

                            $count = 1;
                            foreach ($lm_team_list as $key => $value) {

                                $count_num = isset($value["count_num"]) ? $value["count_num"] : '';
                                $count_heading = isset($value["count_heading"]) ? $value["count_heading"] : '';

                                if ($count == 1) {
                                    $color = 'light-green';
                                } elseif ($count == 2) {
                                    $color = 'light-yellow';
                                }
                                ?>
                                <div class="counter-round-box <?php echo jobcircle_esc_the_html($color) ?>">
                                    <div class="counter-stats">
                                        <strong class="numbers h2">
                    <span data-purecounter-duration="1" data-purecounter-start="0" data-purecounter-end="<?php echo jobcircle_esc_the_html($count_num) ?>" data-purecounter-once="true" class="purecounter"><?php esc_html_e('0', 'jobcircle-frame') ?></span><?php echo esc_html_e('k+', 'jobcircle-frame') ?>
                                        </strong>
                                        <?php if (!empty($count_heading)) { ?>
                                            <span class="subtext">
                                                <?php echo esc_html($count_heading) ?>
                                            </span>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php
                                $count++;
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
    $html = ob_get_clean();
    return $html;
}
add_shortcode('jobcircle_get_the_job', 'jobcircle_get_the_job_front');