<?php
function jobcircle_banner_sixteen()
{
    vc_map(
        array(
            'name' => __('Home Banner 60'),
            'base' => 'jobcircle_banner_sixteen',
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
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title'),
                    'param_name' => 'titl',
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
                    'heading' => __('Url'),
                    'param_name' => 'work_url',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Url'),
                    'param_name' => 'find_url',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Image'),
                    'param_name' => 'img',
                ),

            ),
        )
    );
}
add_action('vc_before_init', 'jobcircle_banner_sixteen');
function jobcircle_banner_sixteen_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(
            'bg_img' => '',
            'titl' => '',
            'desc' => '',
            'work_url' => '',
            'find_url' => '',
            'img' => '',

        ),
        $atts,
        'jobcircle_banner_sixteen'
    );

    $bg_img = isset($atts['bg_img']) ? $atts['bg_img'] : '';
    $titl = isset($atts['titl']) ? $atts['titl'] : '';
    $desc = isset($atts['desc']) ? $atts['desc'] : '';
    $work_url = isset($atts['work_url']) ? $atts['work_url'] : '';
    $find_url = isset($atts['find_url']) ? $atts['find_url'] : '';
    $img = isset($atts['img']) ? $atts['img'] : '';

    ob_start();
    ?>
    <?php if (!empty($bg_img)) { ?>
        <div class="visual-block visual-theme-12 pt-80 pt-md-150 pb-40 pb-md-65 pb-xl-85"
            style="background: url(<?php echo esc_url_raw($bg_img) ?>)">
        <?php } ?>
        <div class="container position-relative">
            <div class="row justify-content-between">
                <div class="col-12 col-lg-6 col-xl-6 position-relative">
                    <!-- visual textbox -->
                    <div class="visual-textbox">
                        <?php if (!empty($titl)) { ?>
                            <h1>
                                <?php echo jobcircle_esc_the_html($titl) ?>
                            </h1>
                        <?php } ?>
                        <?php if (!empty($desc)) { ?>
                            <p>
                                <?php echo jobcircle_esc_the_html($desc) ?>
                            </p>
                        <?php } ?>
                        <div class="popular-searches">
                            <ul>
                                <?php if (!empty($work_url)) { ?>
                                    <li><a class="active" href="<?php echo jobcircle_esc_the_html($work_url) ?>">
                                            <?php echo esc_html_e('Find Work', 'jobcircle-rame') ?>
                                        </a></li>
                                <?php } ?>
                                <?php if (!empty($find_url)) { ?>
                                    <li><a href="<?php echo jobcircle_esc_the_html($find_url) ?>">
                                            <?php echo esc_html_e('Find talent', 'jobcircle-rame') ?>
                                        </a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-xl-6 d-flex justify-content-center align-items-center">
                    <!-- visual Image -->
                    <div class="visual-image position-relative">
                        <?php
                        if (!empty($img)) {
                            ?>
                            <img src="<?php echo esc_url_raw($img) ?>" width="642" height="494"
                                alt="Find The Perfect Job For You">
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('jobcircle_banner_sixteen', 'jobcircle_banner_sixteen_frontend');