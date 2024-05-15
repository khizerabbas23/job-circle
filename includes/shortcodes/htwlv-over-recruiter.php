<?php
function home_twlve_over_recurite()
{
    vc_map(
        array(
            'name' => __('Over 1M Recruiters'),
            'base' => 'home_twlve_over_recurite',
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
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Background Image'),
                    'param_name' => 'bg_image',
                ),
                //group
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'home_twlve_over_recurite_multi',
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
                            'heading' => __('Url'),
                            'param_name' => 'url',
                        ),
                    )
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Image'),
                    'param_name' => 'image',
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
            ),
        )
    );
}
add_action('vc_before_init', 'home_twlve_over_recurite');
//welcome Massage frontend
function home_twlve_over_recurite_frontend($atts, $content)
{
    $atts = shortcode_atts(
        array(

            'title' => '',
            'heading' => '',
            'paragraph' => '',
            'bg_image' => '',
            'image' => '',
            'home_twlve_over_recurite_multi' => '',

        ), $atts, 'home_twlve_over_recurite'
    );

    $title = isset($atts['title']) ? $atts['title'] : '';
    $heading = isset($atts['heading']) ? $atts['heading'] : '';
    $paragraph = isset($atts['paragraph']) ? $atts['paragraph'] : '';
    $bg_image = isset($atts['bg_image']) ? $atts['bg_image'] : '';
    $image = isset($atts['image']) ? $atts['image'] : '';
    $im_app_services = vc_param_group_parse_atts($atts['title']);
    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';

    ob_start();
    ?>
    <section class="section section-theme-11 recruiters-block pt-30 pt-md-50 pt-lg-80 pt-xxl-90 pb-0">
        <div class="container">
            <!-- Section header -->
            <header class="section-header d-flex flex-column-reverse text-center mb-0 mb-md-20">
                <?php if (!empty($title)) {
                    ?>
                    <h2 class="help_question_heading">
                        <?php echo esc_textarea($title) ?>
                    </h2>
                    <?php
                }
                ?>
            </header>
            <ul class="brands-list">
                <?php
                $lm_team_list = vc_param_group_parse_atts($atts['home_twlve_over_recurite_multi']);

                foreach ($lm_team_list as $key => $value) {

                    $img = isset($value['img']) ? $value['img'] : '';
                    $url = isset($value['url']) ? $value['url'] : '';

                    if (!empty($url) && !empty($img)) {
                        ?>
                        <li><a href="<?php echo esc_html($url) ?>"><img src="<?php echo esc_url_raw($img) ?>" alt="logo"></a></li>
                        <?php
                    }
                }
                ?>
            </ul>
            <?php
            if (!empty($image)) {
                ?>
                <div class="info-frame"
                    style="background-image: url(<?php echo esc_url_raw($image) ?>); background-size: cover;">
                    <?php
            }
            if (!empty($heading)) {
                ?>
                    <h2 class="help_question_heading">
                        <?php echo ($heading) ?>
                    </h2>
                    <?php
            }
            if (!empty($paragraph)) {
                ?>
                    <p>
                        <?php echo ($paragraph) ?>
                    </p>
                    <?php
            }
            ?>
                <a class="btn_upload" href="https://modern.miraclesoftsolutions.com/dashboard/?account_tab=my-resume">
                    <i class="jobcircle-icon-upload-cloud icon"></i>
                    <span class="text">
                        <?php echo esc_html_e('Upload Your CV', 'jobcircle-frame') ?>
                    </span>
                </a>
            </div>
        </div>
        <?php
        if (!empty($bg_image)) {
            ?>
            <div class="section-bg" style="background-image: url('<?php echo esc_url_raw($bg_image) ?>');"></div>
            <?php
        }
        ?>
    </section>

    <?php
    return ob_get_clean();
}
add_shortcode('home_twlve_over_recurite', 'home_twlve_over_recurite_frontend');