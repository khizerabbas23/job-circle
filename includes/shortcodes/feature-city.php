<?php
function jobcircle_feature_cat()
{
    vc_map(
        array(
            'name' => __('Feature Cities'),
            'base' => 'feature_cat',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'value' => '',
                    'heading' => 'Heading',
                    'param_name' => 'heading',
                    'value' => ''
                ),
                array(
                    'type' => 'textfield',
                    'value' => '',
                    'heading' => 'Span Heading',
                    'param_name' => 'span_heading',
                    'value' => ''
                ),
                array(
                    'type' => 'textfield',
                    'value' => '',
                    'heading' => 'Description',
                    'param_name' => 'desc',
                    'value' => ''
                ),
                array(
                    'type' => 'textfield',
                    'value' => '',
                    'heading' => 'Button Url',
                    'param_name' => 'comp_url',
                    'value' => ''
                ),
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'feature_cat_multi',
                    'params' => array(
                        array(
                            'type' => 'jobcircle_browse_img',
                            'value' => '',
                            'heading' => 'Image',
                            'param_name' => 'img',
                            'value' => ''
                        ),
                        array(
                            'type' => 'textfield',
                            'value' => '',
                            'heading' => 'Location',
                            'param_name' => 'location',
                            'value' => ''
                        ),
                        array(
                            'type' => 'textfield',
                            'value' => '',
                            'heading' => 'Url',
                            'param_name' => 'loc_url',
                            'value' => ''
                        ),
                        array(
                            'type' => 'textfield',
                            'value' => '',
                            'heading' => 'Available Post',
                            'param_name' => 'available_post',
                            'value' => ''
                        ),
                    )
                ),
            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_feature_cat');

function jobcircle_feature_cat_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(

            'heading' => '',
            'span_heading' => '',
            'desc' => '',
            'comp_url' => '',

            'feature_cat_multi' => '',

        ),
        $atts,
        'jobcircle_feature_cat'
    );

    $heading = isset($atts['heading']) ? $atts['heading'] : '';
    $span_heading = isset($atts['span_heading']) ? $atts['span_heading'] : '';
    $desc = isset($atts['desc']) ? $atts['desc'] : '';
    $comp_url = isset($atts['comp_url']) ? $atts['comp_url'] : '';
    ob_start();
?>
    <section class="section section-theme-3 featured-cities-block pt-35 pt-md-50 pt-lg-55 pt-xl-60 pb-35 pb-md-50 pb-lg-75 pb-xl-110">
        <div class="container">
            <div class="row justify-content-between mb-35 mb-lg-55">
                <div class="col-12 col-lg-8">
                    <!-- Section header -->
                    <header class="section-header text-center text-lg-start mb-30 m-lg-0">
                        <?php
                        if (!empty($heading) || !empty($span_heading)) {
                        ?>
                            <h2>
                                <?php echo esc_html($heading) ?> <span class="text-outlined">
                                    <?php echo esc_html($span_heading) ?>
                                </span>
                            </h2>
                        <?php
                        } ?>
                        <?php
                        if (!empty($desc)) { ?>
                            <p>
                                <?php echo esc_html($desc) ?>
                            </p>
                        <?php
                        } ?>
                    </header>
                </div>
                <div class="col-12 col-lg-4 text-center text-lg-end">
                    <?php
                    if (!empty($comp_url)) {
                    ?>
                        <a href="<?php echo esc_html($comp_url) ?>" class="btn-all mybtn"><span class="btn-text">
                                <?php esc_html_e('View All Locations', 'jobcircle-frame') ?>
                            </span><i class="jobcircle-icon-chevron-right"></i></a>
                    <?php
                    } ?>
                </div>
            </div>
            <div class="row align-items-center">


                <?php
                $l_teamlist = vc_param_group_parse_atts($atts['feature_cat_multi']);

                $counter = 1;
                foreach ($l_teamlist as $key => $value) {

                    $location = isset($value['location']) ? $value['location'] : '';
                    $img = isset($value['img']) ? $value['img'] : '';
                    $loc_url = isset($value['loc_url']) ? $value['loc_url'] : '';
                    $available_post = isset($value['available_post']) ? $value['available_post'] : '';

                    if ($counter == 1 || $counter == 4) {
                        $mainclass = '<div class="col-12 col-lg-4">
                    <div class="row">';
                        $clclass = 'col-md-6 col-lg-12';
                        $imgclass = '';
                        $lastdiv = '';
                    } elseif ($counter == 2 || $counter == 5) {
                        $mainclass = '';
                        $clclass = 'col-md-6 col-lg-12';
                        $imgclass = '';
                        $lastdiv = '</div>
                    </div>';
                    } elseif ($counter == 3) {
                        $mainclass = '<div class="col-12 col-lg-4">
                    <div class="row">';
                        $clclass = 'col-12';
                        $imgclass = 'large';
                        $caldiv = "<div>";
                        $lastdiv = '</div>
                     </div>';
                    } else {
                        break;
                    }
                ?>
                    <?php echo jobcircle_esc_the_html($mainclass)?> 
                    <div class="city-box <?php echo jobcircle_esc_the_html($imgclass) ?> <?php echo jobcircle_esc_the_html($clclass) ?> py-10 py-md-15 py-lg-20">
                        <?php
                        if (!empty($loc_url)) {
                        ?>
                            <a href="<?php echo esc_html($loc_url) ?>" class="city-box-holder">
                            <?php
                        } ?>
                            <div class="image-holder">
                                <?php
                                if (!empty($img)) {
                                ?>
                                    <img src="<?php echo esc_url_raw($img) ?>" alt="Job Circle">
                                <?php
                                } ?>
                            </div>
                            <div class="textbox">
                                <?php
                                if (!empty($location)) { ?>
                                    <strong class="h6">
                                        <?php echo ($location); ?>
                                    </strong>
                                <?php
                                } ?>
                                <?php
                                if (!empty($available_post)) { ?>
                                    <span class="subtitle">
                                        <?php echo jobcircle_esc_the_html($available_post); ?>
                                    </span>
                                <?php
                                } ?>
                            </div>
                            </a>
                    </div>
                    <?php echo jobcircle_esc_the_html($lastdiv) ?>
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
add_shortcode('feature_cat', 'jobcircle_feature_cat_frontend');
