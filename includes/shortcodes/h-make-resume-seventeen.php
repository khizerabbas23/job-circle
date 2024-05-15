<?php

function jobcircle_make_resume()
{
    vc_map(
        array(
            'name' => __('Make Diffrence Resume 17'),
            'base' => 'jc_make_resume',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Background Image'),
                    'param_name' => 'bg_image',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Heading'),
                    'param_name' => 'heading',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Description'),
                    'param_name' => 'desc',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Main Image'),
                    'param_name' => 'main_image',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title'),
                    'param_name' => 'title',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Url'),
                    'param_name' => 'url',
                ),
            ),
        )
    );
}
add_action('vc_before_init', 'jobcircle_make_resume');

//welcome Massage frontend
function jobcircle_make_resume_frontend($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'bg_image' => '',
            'heading' => '',
            'desc' => '',
            'title' => '',
            'url' => '',
            'main_image' => '',
        ), $atts, 'jobcircle_make_resume'
    );
    $bg_image = isset($atts['bg_image']) ? $atts['bg_image'] : '';
    $heading = isset($atts['heading']) ? $atts['heading'] : '';
    $desc = isset($atts['desc']) ? $atts['desc'] : '';
    $title = isset($atts['title']) ? $atts['title'] : '';
    $url = isset($atts['url']) ? $atts['url'] : '';
    $main_image = isset($atts['main_image']) ? $atts['main_image'] : '';
    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';

    ob_start();
    ?>
    <section class="section section-theme-17 browse_categories make-resume">
        <div class="container">
            <?php if (!empty($bg_image)) {
                ?>
                <div class="online-resume" style="background-image: url(<?php echo esc_url_raw($bg_image) ?>);">
                <?php } ?>
                <div class="text-wrap">
                    <?php if (!empty($heading)) {
                        ?>
                        <h2>
                            <?php echo esc_html($heading) ?>
                        </h2>
                    <?php }
                    if (!empty($desc)) { ?>
                        <p>
                            <?php echo esc_html($desc) ?>
                        </p>
                    <?php } ?>
                    <a class="btn btn-orange btn-sm" href="<?php echo esc_html($url) ?>"><span class="btn-text">
                            <?php echo esc_html($title) ?>
                        </span></a>
                </div>
                <div class="right-img">
                    <?php if (!empty($main_image)) {
                        ?>
                        <img src="<?php echo esc_url_raw($main_image) ?>" alt="img">
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>

    <?php
    return ob_get_clean();
}
add_shortcode('jc_make_resume', 'jobcircle_make_resume_frontend');