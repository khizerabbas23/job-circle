<?php

function jobcircle_us_job()
{
    vc_map(
        array(
            'name' => __('USA Jobs'),
            'base' => 'jc_us_job',
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
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Heading'),
                    'param_name' => 'heading',
                ),
                //group
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'jobcircle_us_job_multi',
                    'params' => array(
                        array(
                            'type' => 'jobcircle_browse_img',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('City Image'),
                            'param_name' => 'city_img',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('City Name'),
                            'param_name' => 'city_name',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Url'),
                            'param_name' => 'url',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Number'),
                            'param_name' => 'number',
                        ),
                    )
                ),
            ),
        )
    );
}
add_action('vc_before_init', 'jobcircle_us_job');
//welcome Massage frontend
function jobcircle_us_job_frontend($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'title' => '',
            'heading' => '',
            'jobcircle_us_job_multi' => '',

        ), $atts, 'jobcircle_us_job'
    );

    $title = isset($atts['title']) ? $atts['title'] : '';
    $heading = isset($atts['heading']) ? $atts['heading'] : '';

    ob_start();
    ?>

    <section class="section section-theme-17 browse_categories usa-job">
        <div class="container">
            <div class="jobs-holder">
                <header class="section-header text-center mb-40 mb-md-35">
                    <?php if (!empty($title)) {
                        ?>
                        <p>
                            <?php echo esc_html($title) ?>
                        </p>
                    <?php }
                    if (!empty($heading)) { ?>
                        <h2><span class="text-outlined">
                                <?php echo esc_html($heading) ?>
                            </span></h2>
                    <?php } ?>
                </header>
                <div class="jobs-slider">
                    <div class="usa-jobs-slider">
                        <?php
                        $lm_team_list = vc_param_group_parse_atts($atts['jobcircle_us_job_multi']);
                        if(!empty($lm_team_list)){
                        foreach ($lm_team_list as $key => $value) {

                            $city_img = isset($value['city_img']) ? $value['city_img'] : '';
                            $city_name = isset($value['city_name']) ? $value['city_name'] : '';
                            $url = isset($value['url']) ? $value['url'] : '';
                            $number = isset($value['number']) ? $value['number'] : '';

                            ?>
                            <div>
                                <div class="image-holder">
                                    <?php if (!empty($city_img)) {
                                        ?>
                                        <img src="<?php echo esc_url_raw($city_img) ?>" alt="img">
                                    <?php }
                                    if (!empty($url || $city_name)) {
                                        ?>
                                        <a href="<?php echo jobcircle_esc_the_html($url) ?>" class="info-tag">
                                            <strong class="title">
                                                <?php echo esc_html($city_name) ?>
                                            </strong>

                                            <strong class="number">
                                                <?php echo esc_html($number) ?>
                                            </strong>
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php
                        }
                        }
                        ?>
                    </div>
                </div>
    </section>

    <?php
    return ob_get_clean();
}
add_shortcode('jc_us_job', 'jobcircle_us_job_frontend');