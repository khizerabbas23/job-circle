<?php
function jobcircle_how_it_work()
{
    vc_map(
        array(
            'name' => __('How Its Work'),
            'base' => 'jc_how_it_work',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                    'type' => 'dropdown',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Jobcircle Style', 'jobcircle-frame'),
                    'param_name' => 'jobcircle_style',
                    'description' => __('Select Jobcircle Style', 'jobcircle-frame'),
                    'value' => array(
                        'Select Style' => '',
                        'Home Two Style' => 'jobcircle_style_two',
                        'Home Three Style' => 'jobcircle_style_three',
                    ),
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title'),
                    'param_name' => 'title',
                    'dependency' => array(
                        'element' => 'jobcircle_style',  //selection param name
                        'value' => array('jobcircle_style_two') // depend on selection 
                    ),
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Sub Title'),
                    'param_name' => 'sub_title',
                    'dependency' => array(
                        'element' => 'jobcircle_style',  //selection param name
                        'value' => array('jobcircle_style_two') // depend on selection 
                    ),
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Image'),
                    'param_name' => 'img',
                    'dependency' => array(
                        'element' => 'jobcircle_style',  //selection param name
                        'value' => array('jobcircle_style_two') // depend on selection 
                    ),
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title'),
                    'param_name' => 'img_title',
                    'dependency' => array(
                        'element' => 'jobcircle_style',  //selection param name
                        'value' => array('jobcircle_style_two') // depend on selection 
                    ),
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Span Title'),
                    'param_name' => 'img_span_title',
                    'dependency' => array(
                        'element' => 'jobcircle_style',  //selection param name
                        'value' => array('jobcircle_style_two') // depend on selection 
                    ),
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Heading'),
                    'param_name' => 'img_heading',
                    'dependency' => array(
                        'element' => 'jobcircle_style',  //selection param name
                        'value' => array('jobcircle_style_two') // depend on selection 
                    ),
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Button'),
                    'param_name' => 'button',
                    'dependency' => array(
                        'element' => 'jobcircle_style',  //selection param name
                        'value' => array('jobcircle_style_two') // depend on selection 
                    ),
                ),
                //group
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'review',
                    'dependency' => array(
                        'element' => 'jobcircle_style',  //selection param name
                        'value' => array('jobcircle_style_two') // depend on selection 
                    ),
                    'params' => array(
                        array(
                            'type' => 'jobcircle_browse_img',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Image'),
                            'param_name' => 'mul_img',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Numbers'),
                            'param_name' => 'multi_nums',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Title'),
                            'param_name' => 'multi_title',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Heading'),
                            'param_name' => 'multi_head',
                        ),
                    ),
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('H2 Heading'),
                    'param_name' => 'h_two_head',
                    'dependency' => array(
                        'element' => 'jobcircle_style',  //selection param name
                        'value' => array('jobcircle_style_three') // depend on selection 
                    ),
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('H2 color Heading'),
                    'param_name' => 'color_head',
                    'dependency' => array(
                        'element' => 'jobcircle_style',  //selection param name
                        'value' => array('jobcircle_style_three') // depend on selection 
                    ),
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Discription'),
                    'param_name' => 'disc',
                    'dependency' => array(
                        'element' => 'jobcircle_style',  //selection param name
                        'value' => array('jobcircle_style_three') // depend on selection 
                    ),
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Image'),
                    'param_name' => 'image_work',
                    'dependency' => array(
                        'element' => 'jobcircle_style',  //selection param name
                        'value' => array('jobcircle_style_three') // depend on selection 
                    ),
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Image'),
                    'param_name' => 'img_search',
                    'dependency' => array(
                        'element' => 'jobcircle_style',  //selection param name
                        'value' => array('jobcircle_style_three') // depend on selection 
                    ),
                ),
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'service',
                    'dependency' => array(
                        'element' => 'jobcircle_style',  //selection param name
                        'value' => array('jobcircle_style_three') // depend on selection 
                    ),
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Number'),
                            'param_name' => 'numb',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Strong H5 Heading'),
                            'param_name' => 'strong_head',
                        ),
                        array(
                            'type' => 'textarea',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Explaination'),
                            'param_name' => 'expl',

                        ),
                    )
                )
            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_how_it_work');

// Frontend Coding 

function jobcircle_how_it_work_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(
            'title' => '',
            'sub_title' => '',
            'img' => '',
            'img_title' => '',
            'img_span_title' => '',
            'img_heading' => '',
            'button' => '',
            'review' => '',
            'h_two_head' => '',
            'color_head' => '',
            'disc' => '',
            'image_work' => '',
            'img_search' => '',
            'service' => '',
            'jobcircle_style' => '',
        ),
        $atts,
        'jobcircle_how_it_work'
    );

    $title = isset($atts['title']) ? $atts['title'] : '';
    $sub_title = isset($atts['sub_title']) ? $atts['sub_title'] : '';
    $img = wp_get_attachment_image_src($atts["img"], 'full');
    $img_title = isset($atts['img_title']) ? $atts['img_title'] : '';
    $img_span_title = isset($atts['img_span_title']) ? $atts['img_span_title'] : '';
    $img_heading = isset($atts['img_heading']) ? $atts['img_heading'] : '';
    $button = isset($atts['button']) ? $atts['button'] : '';
    $h_two_head = isset($atts['h_two_head']) ? $atts['h_two_head'] : '';
    $color_head = isset($atts['color_head']) ? $atts['color_head'] : '';
    $disc = isset($atts['disc']) ? $atts['disc'] : '';
    $image_work = isset($atts['image_work']) ? $atts['image_work'] : '';
    $img_search = isset($atts['img_search']) ? $atts['img_search'] : '';
    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';

    if ($atts['jobcircle_style'] == 'jobcircle_style_one') {
        ob_start();
        ?>
        <section
            class="section section-theme-2 section-how-works pt-45 pt-md-50 pt-lg-65 pt-xl-85 pt-xxl-110 pb-60 pb-md-80 pb-xl-85 pb-xxl-110 pb-xxxl-150">
            <div class="container">
                <!-- Section header -->
                <header class="section-header text-center mb-30 mb-md-45 mb-xl-60">
                    <div class="seprator"></div>
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
                <div class="row mb-35 mb-lg-60 mb-xl-90">
                    <?php

                    $lm_team_list = vc_param_group_parse_atts($atts['review']);

                    foreach ($lm_team_list as $key => $value) {

                        $mul_img = wp_get_attachment_image_src($value["mul_img"], 'full');
                        $multi_nums = isset($value["multi_nums"]) ? $value["multi_nums"] : '';
                        $multi_title = isset($value["multi_title"]) ? $value["multi_title"] : '';
                        $multi_head = isset($value["multi_head"]) ? $value["multi_head"] : '';

                        ?>
                        <div class="col-12 col-md-4 text-center mb-30 mb-md-0">
                            <div class="how-work-box">
                                <div class="icon">
                                    <?php
                                    if (!empty($mul_img)) {
                                        ?>
                                        <img src="<?php echo esc_url_raw($mul_img); ?>" alt="Image Description">
                                        <?php
                                    }
                                    ?>
                                </div>
                                <?php
                                if (!empty($multi_nums)) {
                                    ?>
                                    <strong class="num">
                                        <?php echo esc_html($multi_nums); ?>
                                    </strong>
                                    <?php
                                }
                                ?>
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
                                </div>
                            </div>
                            <?php
                                }
                                ?>
                        <?php
                    }
                    ?>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="matched-jobs-block">
                            <div class="section-header">
                                <?php
                                if (!empty($img_title) || !empty($img_span_title)) {
                                    ?>
                                    <h2>
                                        <?php echo esc_html($img_title); ?> <span class="text-outlined">
                                            <?php echo esc_html($img_span_title); ?>
                                        </span>.
                                    </h2>
                                    <?php
                                }
                                ?>
                                <?php
                                if (!empty($img_heading)) {
                                    ?>
                                    <p>
                                        <?php echo esc_textarea($img_heading); ?>
                                    </p>
                                    <?php
                                }
                                ?>
                                <?php
                                if (!empty($button)) {
                                    ?>
                                    <a href="#" class="btn btn-green btn-sm"><span class="btn-text"><i
                                                class="icon-upload-cloud"></i>
                                            <?php echo esc_html($button); ?>
                                        </span></a>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="image-holder">
                                <?php
                                if (!empty($img)) {
                                    ?>
                                    <img src="<?php echo esc_url_raw($img); ?>" alt="Image Description">
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
    } elseif ($atts['jobcircle_style'] == 'jobcircle_style_two') {
        ob_start();
        ?>
        <section
            class="section section-theme-3 how-work-block pt-35 pt-md-50 pt-lg-75 pt-xl-110 pb-35 pb-md-50 pb-lg-75 pb-xl-110">
            <div class="container">
                <!-- Section header -->
                <header class="section-header text-center mb-30 mb-md-45 mb-xl-60">
                    <?php
                    if (!empty($h_two_head) || !empty($color_head)) {
                        ?>
                        <h2>
                            <?php echo esc_html($h_two_head) ?><span class="text-outlined">
                                <?php echo esc_html($color_head) ?>
                            </span>
                        </h2>
                        <?php
                    } ?>
                    <?php
                    if (!empty($disc)) {
                        ?>
                        <p>
                            <?php echo esc_html($disc) ?>
                        </p>
                        <?php
                    } ?>
                </header>
                <div class="row">
                    <div class="col-12 col-lg-6 col-xxl-5 mb-15 mb-md-30 mb-lg-0">
                        <ul class="how-work-list">';
                            <?php
                            $lm_team_list = vc_param_group_parse_atts($atts['service']);

                            foreach ($lm_team_list as $key => $value) {

                                $numb = isset($value["numb"]) ? $value["numb"] : '';
                                $strong_head = isset($value["strong_head"]) ? $value["strong_head"] : '';
                                $expl = isset($value["expl"]) ? $value["expl"] : '';

                                ?>
                                <li>
                                    <div class="num-box">
                                        <?php
                                        if (!empty($numb)) {
                                            ?>
                                            <span class="number">
                                                <?php echo esc_html($numb) ?>
                                            </span>
                                            <?php
                                        } ?>
                                    </div>
                                    <div class="textbox">
                                        <?php
                                        if (!empty($strong_head)) {
                                            ?>
                                            <strong class="h5">
                                                <?php echo esc_html($strong_head) ?>
                                            </strong>
                                            <?php
                                        } ?>
                                        <?php
                                        if (!empty($expl)) {
                                            ?>
                                            <p>
                                                <?php echo esc_html($expl) ?>
                                            </p>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="col-12 col-lg-6 col-xxl-7">
                        <div class="work-img-box">
                            <?php
                            if (!empty($image_work)) {
                                ?>
                                <img src="<?php echo jobcircle_esc_the_html($image_work) ?>" alt="How It Works?">
                                <?php
                            }
                            ?>
                            <div class="img-search">
                                <?php
                                if (!empty($img_search)) {
                                    ?>
                                    <img src="<?php echo jobcircle_esc_the_html($img_search) ?>" alt="Search">
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
    }
    return ob_get_clean();
}
add_shortcode('jc_how_it_work', 'jobcircle_how_it_work_frontend');