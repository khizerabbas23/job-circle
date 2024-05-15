<?php
function jobcircle_explore()
{
    vc_map(
        array(
            'name' => __('Explore'),
            'base' => 'job_cirle_explore',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Uplod Image'),
                    'param_name' => 'upld_img',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Uplod Style Image'),
                    'param_name' => 'upld_style_img',
                ),
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
                    'heading' => __('Sb Heading'),
                    'param_name' => 'sb_head',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Discription'),
                    'param_name' => 'disc',
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
                    'heading' => __('Title One'),
                    'param_name' => 'titl_one',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title Two'),
                    'param_name' => 'titl_two',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title Three'),
                    'param_name' => 'titl_three',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title Four'),
                    'param_name' => 'titl_four',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title five'),
                    'param_name' => 'titl_five',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title Six'),
                    'param_name' => 'titl_six',
                ),
                //group
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'explore_multi',
                    'params' => array(


                        array(
                            'type' => 'jobcircle_browse_img',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Multi image'),
                            'param_name' => 'multi_img',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Image Url'),
                            'param_name' => 'img_url',
                        ),

                    ),
                )
            )


        )
    );
}
add_action('vc_before_init', 'jobcircle_explore');

// Frontend Coding 

function jobcircle_explore_front($atts, $content)
{

    $atts = shortcode_atts(
        array(

            'upld_img' => '',
            'upld_style_img' => '',
            'head' => '',
            'sb_head' => '',
            'disc' => '',
            'titl' => '',
            'titl_one' => '',
            'titl_two' => '',
            'titl_three' => '',
            'titl_four' => '',
            'titl_five' => '',
            'titl_six' => '',

            'explore_multi' => '',

        ), $atts, 'jobcircle_explore'
    );

    $upld_img = isset($atts['upld_img']) ? $atts['upld_img'] : '';
    $upld_style_img = isset($atts['upld_style_img']) ? $atts['upld_style_img'] : '';

    $head = isset($atts['head']) ? $atts['head'] : '';
    $sb_head = isset($atts['sb_head']) ? $atts['sb_head'] : '';
    $disc = isset($atts['disc']) ? $atts['disc'] : '';
    $titl = isset($atts['titl']) ? $atts['titl'] : '';
    $titl_one = isset($atts['titl_one']) ? $atts['titl_one'] : '';
    $titl_two = isset($atts['titl_two']) ? $atts['titl_two'] : '';
    $titl_three = isset($atts['titl_three']) ? $atts['titl_three'] : '';
    $titl_four = isset($atts['titl_four']) ? $atts['titl_four'] : '';
    $titl_five = isset($atts['titl_five']) ? $atts['titl_five'] : '';
    $titl_six = isset($atts['titl_six']) ? $atts['titl_six'] : '';

    $custom_plan_price = isset($atts['nb_heeratitle']) && !empty($atts['nb_heeratitle']) ? $atts['nb_heeratitle'] : '';
    ob_start();
    ?>

    <section
        class="section section-theme-1 section-explores bg-light-gray pt-35 pt-md-50 pt-lg-65 pt-xl-125 pb-35px pb-md-50 pb-lg-65 pb-xl-125">
        <div class="container">
            <div class="row flex-column-reverse flex-lg-row align-items-center">
                <div class="col-12 col-lg-6 mb-15 mb-lg-0">
                    <div class="explores-image-box">
                        <div class="img-pattern">
                            <?php
                            if (!empty($upld_style_img)) {
                                ?>
                                <img src="<?php echo esc_url_raw($upld_style_img) ?>" width="723" height="461"
                                    alt="Image Description">
                                <?php
                            } ?>
                        </div>
                        <div class="image-holder">
                            <?php
                            if (!empty($upld_img)) {
                                ?>
                                <img src="<?php echo esc_url_raw($upld_img) ?>" alt="Image Description">
                                <?php
                            } ?>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="section-header">
                        <?php
                        if (!empty($head) || !empty($sb_head)) {
                            ?>
                            <h2>
                                <?php echo esc_html($head) ?><span class="text-outlined">
                                    <?php echo esc_html($sb_head) ?>
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
                        <ul class="check-list">
                            <?php
                            if (!empty($titl)) {
                                ?>
                                <li>
                                    <?php echo esc_html($titl) ?>
                                </li>
                                <?php
                            } ?>
                            <?php
                            if (!empty($titl_one)) {
                                ?>
                                <li>
                                    <?php echo esc_html($titl_one) ?>
                                </li>
                                <?php
                            } ?>
                            <?php
                            if (!empty($titl_two)) {
                                ?>
                                <li>
                                    <?php echo esc_html($titl_two) ?>
                                </li>
                                <?php
                            } ?>

                        </ul>
                    </div>
                </div>
            </div>
            <div class="row align-items-center pt-35 pt-md-60 pt-lg-100">
                <div class="col-12 col-lg-6 col-xl-5 mb-30 mb-lg-0">
                    <div class="section-header mb-0">
                        <?php
                        if (!empty($titl_three) || !empty($titl_four) || !empty($titl_five)) {
                            ?>
                            <h2>
                                <?php echo esc_html($titl_three) ?> <span class="text-outlined">
                                    <?php echo esc_html($titl_four) ?>
                                </span>
                                <?php echo esc_html($titl_five) ?>
                            </h2>
                            <?php
                        } ?>
                        <?php
                        if (!empty($titl_six)) {
                            ?>
                            <p>
                                <?php echo esc_html($titl_six) ?>
                            </p>
                            <?php
                        } ?>
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-xl-7">
                    <ul class="sites-list">
                        <?php
                        $lm_team_list = vc_param_group_parse_atts($atts['explore_multi']);

                        foreach ($lm_team_list as $key => $value) {

                            $multi_img = isset($value['multi_img']) ? $value['multi_img'] : '';
                            $img_url = isset($value['img_url']) ? $value['img_url'] : '';


                            ?>
                            <?php
                            if (!empty($multi_img) || !empty($img_url)) {
                                ?>
                                <li><a href="<?php echo esc_html($img_url) ?>"><img src="<?php echo esc_url_raw($multi_img) ?>"
                                            alt="Image Description"></a></li>
                                <?php
                            } ?>
                        <?php
                        }
                        ?>
                        <li><a class="btn-more" href="#"><i class="jobcircle-icon-chevron-right"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('job_cirle_explore', 'jobcircle_explore_front');