<?php
function home_twlve_location()
{
    vc_map(
        array(
            'name' => __('Populor Jobs Location'),
            'base' => 'home_twlve_location',
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
                    'param_name' => 'home_twlve_location_multi',
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
                    )
                ),
            ),
        )
    );
}
add_action('vc_before_init', 'home_twlve_location');
//welcome Massage frontend
function home_twlve_location_frontend($atts, $content)
{
    $atts = shortcode_atts(
        array(

            'title' => '',
            'heading' => '',
            'home_twlve_location_multi' => '',

        ), $atts, 'home_twlve_location'
    );

    $title = isset($atts['title']) ? $atts['title'] : '';
    $heading = isset($atts['heading']) ? $atts['heading'] : '';
    $im_app_services = vc_param_group_parse_atts($atts['title']);
    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';

    ob_start();
    ?>

    <section
        class="section section-theme-11 featured-cities pt-30 pt-md-50 pt-lg-100 pb-30 pb-md-50 pb-lg-100 pt-xxl-90 pb-0">
        <div class="container">
            <header class="section-header d-flex flex-column-reverse text-center mb-30 mb-lg-42">
                <?php
                if (!empty($heading)) {
                    ?>
                    <h2 class="help_question_heading">
                        <?php echo ($heading) ?>
                    </h2>
                    <?php
                }
                if (!empty($title)) {
                    ?>
                    <p>
                        <?php echo esc_html($title) ?>
                    </p>
                <?php }
                ?>
            </header>
            <div class="row">
                <?php
                $counter = 1;
                $lm_team_list = vc_param_group_parse_atts($atts['home_twlve_location_multi']);

                foreach ($lm_team_list as $key => $value) {

                    $city_img = isset($value['city_img']) ? $value['city_img'] : '';
                    $city_name = isset($value['city_name']) ? $value['city_name'] : '';
                    $url = isset($value['url']) ? $value['url'] : '';

                    if ($counter == 1 || $counter == 3 || $counter == 5 || $counter == 6) {
                        $width = 'col-lg-3';
                    } elseif ($counter == 2 || $counter == 4) {
                        $width = 'col-lg-6';
                    }
                    ?>
                    <div class="col-12 col-md-6 <?php echo jobcircle_esc_the_html($width) ?> mb-20">
                        <div class="city-holder">
                            <?php
                            if (!empty($city_img) || !empty($url)) {
                                ?>
                                <a href="<?php echo esc_html($url) ?>">
                                    <img src="<?php echo esc_url_raw($city_img) ?>" alt="image">
                                </a>
                                <?php
                            }
                            if (!empty($city_name) || !empty($url)) {
                                ?>
                                <a href="<?php echo esc_html($url) ?>">
                                    <span class="city">
                                        <?php echo esc_html($city_name) ?>
                                    </span>
                                </a>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                    $counter++;
                }
                ?>

            </div>
        </div>
    </section>

    <?php
    return ob_get_clean();
}
add_shortcode('home_twlve_location', 'home_twlve_location_frontend');