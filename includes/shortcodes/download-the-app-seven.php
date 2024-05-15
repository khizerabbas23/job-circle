<?php
function jobcircle_download_the_app()
{
    vc_map(
        array(
            'name' => __('Download the App'),
            'base' => 'download_the_app',
            'category' => __('job Circle'),
            'params' => array(
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
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Main Image'),
                    'param_name' => 'mn_img',
                ),
                //Group
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'jobcircle_download_the_app_multi_sec',
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
                            'heading' => __('URL'),
                            'param_name' => 'url',
                        ),

                    ),
                ),
            ),
        )
    );
}
add_action('vc_before_init', 'jobcircle_download_the_app');


// Frontend Coding 

function jobcircle_download_the_app_front($atts, $content)
{

    $atts = shortcode_atts(
        array(

            'head' => '',
            'desc' => '',
            'lst_one' => '',
            'lst_two' => '',
            'lst_three' => '',
            'mn_img' => '',

            'jobcircle_download_the_app_multi_sec' => '',

        ), $atts, 'jobcircle_download_the_app'
    );

    $head = isset($atts['head']) ? $atts['head'] : '';
    $desc = isset($atts['desc']) ? $atts['desc'] : '';
    $lst_one = isset($atts['lst_one']) ? $atts['lst_one'] : '';
    $lst_two = isset($atts['lst_two']) ? $atts['lst_two'] : '';
    $lst_three = isset($atts['lst_three']) ? $atts['lst_three'] : '';
    $mn_img = isset($atts['mn_img']) ? $atts['mn_img'] : '';

    ob_start();
    ?>
    <section class="apps-block section-theme-7 bg-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-md-6 col-lg-7 col-xl-6">
                    <div class="text">
                        <?php
                        if (!empty($head)) {
                            ?>
                            <h2>
                                <?php echo esc_html($head) ?>
                            </h2>
                        <?php
                        } ?>
                        <?php
                        if (!empty($desc)) {
                            ?>
                            <p>
                                <?php echo esc_html($desc) ?>
                            </p>
                            <?php
                        } ?>
                        <ul class="list-unstyled list">
                            <?php if (!empty($lst_one)) {
                                ?>
                                <li>
                                    <?php echo esc_html($lst_one) ?>
                                </li>
                                <?php
                            } ?>
                            <?php
                            if (!empty($lst_two)) {
                                ?>
                                <li>
                                    <?php echo esc_html($lst_two) ?>
                                </li>
                                <?php
                            } ?>
                            <?php
                            if (!empty($lst_three)) {
                                ?>
                                <li>
                                    <?php echo esc_html($lst_three) ?>
                                </li>
                            <?php
                            } ?>
                        </ul>
                        <div class="download-btns">
                            <?php

                            $lm_team_list = vc_param_group_parse_atts($atts['jobcircle_download_the_app_multi_sec']);

                            foreach ($lm_team_list as $key => $value) {

                                $img = isset($value["img"]) ? $value["img"] : '';
                                $url = isset($value["url"]) ? $value["url"] : '';

                                ?>
                                <?php if (!empty($url) || !empty($img)) {
                                    ?>
                                    <a href="<?php echo esc_html($url); ?>"><img src="<?php echo esc_url_raw($img); ?>"
                                            alt="google"></a>
                                <?php } ?>

                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-5 col-xl-6">
                    <div class="image-holder d-flex justify-content-center">
                        <?php
                        if (!empty($mn_img)) {
                            ?>
                            <img src="<?php echo esc_url_raw($mn_img); ?>" alt="jobcircle">
                        <?php
                        } ?>

                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <?php
    $html = ob_get_clean();
    return $html;
}
add_shortcode('download_the_app', 'jobcircle_download_the_app_front');