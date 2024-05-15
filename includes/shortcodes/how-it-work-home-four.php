<?php
function jobcircle_how_it_work_page_4()
{
    vc_map(
        array(
            'name' => __('How It Work 4'),
            'base' => 'how_it_work_page_4',
            'category' => __('Job Circle'),
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
                //Group
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'recent_news_multi',
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
add_action('vc_before_init', 'jobcircle_how_it_work_page_4');


// Frontend Coding 

function jobcircle_how_it_work_page_4_front($atts, $content)
{

    $atts = shortcode_atts(
        array(

            'titl' => '',
            'tg_line' => '',
            'img' => '',

            'recent_news_multi' => '',

        ), $atts, 'jobcircle_how_it_work_page_4'
    );

    $titl = isset($atts['titl']) ? $atts['titl'] : '';
    $tg_line = isset($atts['tg_line']) ? $atts['tg_line'] : '';
    $img = isset($atts['img']) ? $atts['img'] : '';

    ob_start();
    ?>
    <section class="section section-theme-4 bg-white pt-35 pt-md-50 pt-lg-75 pt-xxl-120 pb-35 pb-md-50 pb-lg-65 pb-xxl-100">
        <div class="container">
            <!-- Section header -->
            <header class="section-header d-flex flex-column text-center mb-30 mb-lg-58">
                <?php if (!empty($titl)) {
                    ?>
                    <h2>
                        <?php echo esc_html($titl) ?>
                    </h2>
                <?php } ?>
                <?php if (!empty($tg_line)) {
                    ?>
                    <p class="hforfont">
                        <?php echo esc_html($tg_line); ?>
                    </p>
                <?php } ?>
                <?php if (!empty($img)) {
                    ?>
                    <img src="<?php echo esc_url_raw($img); ?>" width="26" alt="icon">
                <?php } ?>
            </header>
            <div class="row justify-content-center steps-box">
                <?php

                $lm_team_list = vc_param_group_parse_atts($atts['recent_news_multi']);

                foreach ($lm_team_list as $key => $value) {

                    $image = isset($value["image"]) ? $value["image"] : '';
                    $head = isset($value["head"]) ? $value["head"] : '';
                    $desc = isset($value["desc"]) ? $value["desc"] : '';

                    ?>
                    <div class="col-12 col-md-6 col-xl-4">
                        <div class="step-frame">
                            <?php if (!empty($image)) {
                                ?>
                                <div class="icon-image"><img src="<?php echo esc_url_raw($image) ?>" alt="icon"></div>
                            <?php } ?>
                            <div class="text">
                                <?php if (!empty($head)) {
                                    ?>
                                    <h3>
                                        <?php echo ($head) ?>
                                    </h3>
                                <?php } ?>
                                <?php if (!empty($desc)) {
                                    ?>
                                    <p>
                                        <?php echo esc_textarea($desc); ?>
                                    </p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </section>

    <?php
    $html = ob_get_clean();
    return $html;
}
add_shortcode('how_it_work_page_4', 'jobcircle_how_it_work_page_4_front');