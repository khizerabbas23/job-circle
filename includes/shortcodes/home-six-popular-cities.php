<?php
function jobcircle_home_six_popular_cities()
{
    vc_map(
        array(
            'name' => __('Home Six Popular Cities'),
            'base' => 'jc_home_six_popular_cities',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Tittle'),
                    'param_name' => 'title',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Feature List'),
                    'param_name' => 'feature_list',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Feature List'),
                    'param_name' => 'feature_list_two',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Button'),
                    'param_name' => 'bttn',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Bcakground Image'),
                    'param_name' => 'back_img',
                ),
            ),
        )
    );
}
add_action('vc_before_init', 'jobcircle_home_six_popular_cities');
function jobcircle_home_six_popular_cities_frontend($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'title' => '',
            'feature_list' => '',
            'feature_list_two' => '',
            'bttn' => '',
            'back_img' => '',

        ),
        $atts,
        'jobcircle_home_six_popular_cities'
    );
    $title = isset($atts['title']) ? $atts['title'] : '';
    $feature_list = isset($atts['feature_list']) ? $atts['feature_list'] : '';
    $feature_list_two = isset($atts['feature_list_two']) ? $atts['feature_list_two'] : '';
    $bttn = isset($atts['bttn']) ? $atts['bttn'] : '';
    $back_img = isset($atts['back_img']) ? $atts['back_img'] : '';
    ob_start();
    ?>

    <section class="section section-theme-3 popular-cities-listing pt-35 pt-md-50 pt-lg-70 pb-35 pb-md-50 pb-lg-65">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="matched-jobs-block">
                        <div class="section-header">
                            <?php
                            if (!empty($title)) {
                                ?>
                                <h2>
                                    <?php echo esc_html($title); ?>
                                </h2>
                                <?php
                            }
                            ?>
                            <ul class="steps-list">
                                <li>
                                    <i class="jobcircle-icon-check"></i>
                                    <?php
                                    if (!empty($feature_list)) {
                                        ?>
                                        <?php echo esc_html($feature_list); ?>
                                        <?php
                                    }
                                    ?>
                                </li>
                                <li>
                                    <i class="jobcircle-icon-check"></i>
                                    <?php
                                    if (!empty($feature_list_two)) {
                                        ?>
                                        <?php echo esc_html($feature_list_two); ?>
                                        <?php
                                    }
                                    ?>
                                </li>
                            </ul>
                            <?php
                            if (!empty($bttn)) {
                                ?>
                                <a href="https://modern.miraclesoftsolutions.com/dashboard/?account_tab=my-resume" class="btn btn-orange btn-sm"><span class="btn-text"><i
                                            class="jobcircle-icon-upload-cloud"></i>
                                        <?php echo esc_html($bttn); ?>
                                    </span></a>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="image-holder">
                            <?php
                            if (!empty($back_img)) {
                                ?>
                                <img src="<?php echo esc_url_raw($back_img); ?>" width="569" height="429"
                                    alt="Image Description">
                                <?php
                            }
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

add_shortcode('jc_home_six_popular_cities', 'jobcircle_home_six_popular_cities_frontend');