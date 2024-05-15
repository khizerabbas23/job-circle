<?php
function how_its_works_aboutus()
{
    vc_map(
        array(
            'name' => __('How its work?'),
            'base' => 'how_it_work_page_about_us',
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
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Tag Line'),
                    'param_name' => 'tg_line',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Job Heading'),
                    'param_name' => 'job_heading',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Job Span Heading'),
                    'param_name' => 'job_span_heading',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Job Description'),
                    'param_name' => 'job_description',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Button Heading'),
                    'param_name' => 'button_heading',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Button Url'),
                    'param_name' => 'button_url',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Image'),
                    'param_name' => 'imagezcdz',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Aero Image'),
                    'param_name' => 'aero_image',
                ),

                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Background Image'),
                    'param_name' => 'bg_img',
                ),
                //Group
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'recent_news_multi_about_us',
                    'params' => array(
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
                            'heading' => __('Counting'),
                            'param_name' => 'counting',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Heading'),
                            'param_name' => 'head',
                        ),
                        array(
                            'type' => 'textarea',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Description'),
                            'param_name' => 'desc',
                        ),

                    ),
                ),
            ),
        )
    );
}
add_action('vc_before_init', 'how_its_works_aboutus');

// Frontend Coding 
function how_its_works_aboutus_front($atts, $content)
{

    $atts = shortcode_atts(
        array(

            'titl' => '',
            'tg_line' => '',
            'job_heading' => '',
            'job_span_heading' => '',
            'job_description' => '',
            'button_heading' => '',
            'button_url' => '',
            'imagezcdz' => '',
            'aero_image' => '',
            'bg_img' => '',


            'recent_news_multi_about_us' => '',

        ), $atts, 'how_its_works_aboutus'
    );

    $titl = isset($atts['titl']) ? $atts['titl'] : '';
    $tg_line = isset($atts['tg_line']) ? $atts['tg_line'] : '';
    $job_heading = isset($atts['job_heading']) ? $atts['job_heading'] : '';
    $job_span_heading = isset($atts['job_span_heading']) ? $atts['job_span_heading'] : '';
    $job_description = isset($atts['job_description']) ? $atts['job_description'] : '';
    $button_heading = isset($atts['button_heading']) ? $atts['button_heading'] : '';
    $button_url = isset($atts['button_url']) ? $atts['button_url'] : '';
    $imagezcdz = isset($atts['imagezcdz']) ? $atts['imagezcdz'] : '';
    $aero_image = isset($atts['aero_image']) ? $atts['aero_image'] : '';
    $bg_img = isset($atts['bg_img']) ? $atts['bg_img'] : '';

    ob_start();
    ?>
    <style>
        .how-work-box:before {
            position: absolute;
            left: 100%;
            top: 45px;
            width: 150px;
            height: 5px;
            content: "";
            transform: translateX(-45%);
            background: url(<?php echo jobcircle_esc_the_html($aero_image) ?>) no-repeat;
            background-size: 100% 100%;
            display: none;
        }
    </style>

    <style>
        .section-theme-1 .matched-jobs-block {
            background-image: url(<?php echo jobcircle_esc_the_html($bg_img) ?>);
        }
    </style>
    <section
        class="section section-theme-1 section-how-works pt-45 pt-md-50 pt-lg-65 pt-xl-85 pt-xxl-110 pb-60 pb-md-80 pb-xl-85 pb-xxl-110 pb-xxxl-150">
        <div class="container">
            <!-- Section header -->
            <header class="section-header text-center mb-30 mb-md-45 mb-xl-60">
                <?php if (!empty($titl)) {
                    ?>
                    <h2>
                        <?php echo esc_html($titl) ?>
                    </h2>
                <?php }
                if (!empty($tg_line)) { ?>
                    <p>
                        <?php echo esc_html($tg_line) ?>
                    </p>
                <?php } ?>
            </header>
            <div class="row mb-35 mb-lg-60 mb-xl-90">
                <?php

                $lm_team_list = vc_param_group_parse_atts($atts['recent_news_multi_about_us']);

                foreach ($lm_team_list as $key => $value) {

                    $image = isset($value["image"]) ? $value["image"] : '';
                    $head = isset($value["head"]) ? $value["head"] : '';
                    $counting = isset($value["counting"]) ? $value["counting"] : '';
                    $desc = isset($value["desc"]) ? $value["desc"] : '';

                    ?>
                    <div class="col-12 col-md-4 text-center mb-30 mb-md-0">
                        <div class="how-work-box">
                            <?php if (!empty($image)) {
                                ?>
                                <div class="icon">
                                    <img src="<?php echo esc_html($image) ?>" alt="Image Description">
                                </div>
                            <?php }
                            if (!empty($counting)) { ?>
                                <strong class="num">
                                    <?php echo esc_html($counting) ?>
                                </strong>
                            <?php }
                            if (!empty($head)) { ?>
                                <strong class="h5">
                                    <?php echo esc_html($head) ?>
                                </strong>
                            <?php
                            }
                            if (!empty($desc)) { ?>
                                <p>
                                    <?php echo esc_html($desc); ?>
                                </p>
                            <?php } ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="matched-jobs-block">
                        <div class="section-header">
                            <?php if (!empty($job_heading) || !empty($job_span_heading)) {
                                ?>
                                <h2>
                                    <?php echo esc_html($job_heading) ?> <span class="text-outlined">
                                        <?php echo esc_html($job_span_heading) ?>
                                    </span>.
                                </h2>
                            <?php }
                            if (!empty($job_description)) { ?>
                                <p>
                                    <?php echo esc_html($job_description) ?>
                                </p>
                            <?php }
                            if (!empty($button_url) && !empty($button_heading)) { ?>
                                <a href="<?php echo esc_html($button_url) ?>" class="btn btn-green btn-sm"><span
                                        class="btn-text"><i class="jobcircle-icon-upload-cloud"></i>
                                        <?php echo esc_html($button_heading) ?>
                                    </span></a>
                            <?php } ?>
                        </div>
                        <div class="image-holder">
                            <?php if (!empty($imagezcdz)) {
                                ?>
                                <img src="<?php echo jobcircle_esc_the_html($imagezcdz) ?>" width="462" height="436" alt="Image Description">
                            <?php }
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
add_shortcode('how_it_work_page_about_us', 'how_its_works_aboutus_front');