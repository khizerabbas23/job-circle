<?php
function jobcircle_arround_world()
{
    vc_map(
        array(
            'name' => __('Get Profile'),
            'base' => 'jc_arround_world',
            'category' => __('Job Circle'),
            'params' => array(

                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Background Image '),
                    'param_name' => 'bg_img',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Image '),
                    'param_name' => 'section_img',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title'),
                    'param_name' => 'title_get',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Span Title'),
                    'param_name' => 'title_profile',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Heading'),
                    'param_name' => 'title_get_notice',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Span Heading'),
                    'param_name' => 'title_around_world',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Discription'),
                    'param_name' => 'discr',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Discription'),
                    'param_name' => 'discr_two',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Button'),
                    'param_name' => 'find_more_btn',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Button Url'),
                    'param_name' => 'find_more_btn_url',
                ),
            )
        )
    );

}
add_action('vc_before_init', 'jobcircle_arround_world');

//welcome Massage frontend
function jobcircle_arround_world_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(

            'bg_img' => '',
            'section_img' => '',
            'title_get' => '',
            'title_profile' => '',
            'title_get_notice' => '',
            'title_around_world' => '',
            'discr' => '',
            'discr_two' => '',
            'find_more_btn' => '',
            'find_more_btn_url' => '',
        ),
        $atts,
        'jobcircle_arround_world');
    $bg_img = isset($atts['bg_img']) ? $atts['bg_img'] : '';
    $section_img = isset($atts['section_img']) ? $atts['section_img'] : '';
    $title_get = isset($atts['title_get']) ? $atts['title_get'] : '';
    $title_profile = isset($atts['title_profile']) ? $atts['title_profile'] : '';
    $title_get_notice = isset($atts['title_get_notice']) ? $atts['title_get_notice'] : '';
    $title_around_world = isset($atts['title_around_world']) ? $atts['title_around_world'] : '';
    $discr = isset($atts['discr']) ? $atts['discr'] : '';
    $discr_two = isset($atts['discr_two']) ? $atts['discr_two'] : '';
    $find_more_btn = isset($atts['find_more_btn']) ? $atts['find_more_btn'] : '';
    $find_more_btn_url = isset($atts['find_more_btn_url']) ? $atts['find_more_btn_url'] : '';
    $output = '';
    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
    ob_start();
    ?>
    <?php
    if (!empty($bg_img)) {
        ?>
        <section class="section bg-overlay section-notified pt-35 pt-md-50 pt-lg-80 pb-35 pb-md-50 pb-lg-80"
            style="background-image: url(<?php echo esc_url_raw($bg_img) ?>);">
             <?php
               }
             ?>
       <div class="container">
            <div class="row align-items-center align-items-xxxl-start">
                <div class="col-12 col-lg-6">
                    <div class="image-holder">
                        <?php
                        if (!empty($section_img)) {
                            ?>
                            <img src="<?php echo esc_url_raw($section_img); ?>" width="748" height="678"
                                alt="Get Your Profile to Get Noticed All Around The World">
                            <?php
                        }
                        ?>

                    </div>
                </div>
                <div class="col-12 col-lg-6 pt-lg-10">
                    <div class="textbox">
                        <?php
                        if (!empty($title_get) || !empty($title_profile) || !empty($title_get_notice) || !empty($title_around_world)) {
                            ?>
                            <h2 class="h1">
                                <?php echo esc_html($title_get) ?>
                                <span class="text-primary">
                                    <?php echo esc_html($title_profile) ?>
                                </span>
                                <?php echo esc_html($title_get_notice) ?>
                                <span class="text-primary">
                                    <?php echo esc_html($title_around_world) ?>
                                </span>
                            </h2>
                            <?php
                        }
                        if (!empty($discr)) {
                            ?>
                            <p>
                                <?php echo esc_html($discr) ?>
                            </p>
                            <?php
                        }
                        if (!empty($discr_two)) {
                            ?>
                            <p>
                                <?php echo esc_html($discr_two) ?>
                            </p>
                            <?php
                        }
                        if (!empty($find_more_btn) || !empty($find_more_btn_url)) {
                            ?>
                            <a href="<?php echo esc_html($find_more_btn_url) ?>" class="btn btn-primary"><span class="btn-text">
                                    <?php echo esc_html($find_more_btn) ?>
                                </span></a>
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
add_shortcode('jc_arround_world', 'jobcircle_arround_world_frontend');