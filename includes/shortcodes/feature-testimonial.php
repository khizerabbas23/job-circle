<?php
function jobcircle_featured_testonomy()
{
    vc_map(
        array(
            'name' => __('Featured Testonomy'),
            'base' => 'jc_featured_testonomy',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title'),
                    'param_name' => 'feat',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Span Title'),
                    'param_name' => 'test',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Discription'),
                    'param_name' => 'disc',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Background Image'),
                    'param_name' => 'bgrd_img',
                ),

                //group
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'img_multi',
                    'params' => array(

                        array(
                            'type' => 'jobcircle_browse_img',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Employe Image'),
                            'param_name' => 'emp_img',
                        ),
                    ),
                ),

                //GROUP 2
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'second_multi',
                    'params' => array(
                        array(
                            'type' => 'textarea',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Discription'),
                            'param_name' => 'disce',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Name'),
                            'param_name' => 'name',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Designation'),
                            'param_name' => 'ceo',
                        ),
                    ),
                )
            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_featured_testonomy');
// Frontend Coding 
function jobcircle_testimony_front($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'feat' => '',
            'test' => '',
            'disc' => '',
            'bgrd_img' => '',
            //For Multi
            'img_multi' => '',
            'second_multi' => '',

        ), $atts, 'jobcircle_featured_testonomy'
    );

    $feat = isset($atts['feat']) ? $atts['feat'] : '';
    $test = isset($atts['test']) ? $atts['test'] : '';
    $disc = isset($atts['disc']) ? $atts['disc'] : '';
    $bgrd_img = isset($atts['bgrd_img']) ? $atts['bgrd_img'] : '';
    $custom_plan_price = isset($atts['nb_Circletitle']) && !empty($atts['nb_Circletitle']) ? $atts['nb_Circletitle'] : '';
    ob_start();
    ?>
    <section class="section section-testimonials pt-35 pt-md-50 pt-lg-60 pb-20 pb-md-40">
        <div class="container">
            <!-- Section header -->
            <header class="section-header text-center mb-30 mb-md-45 mb-lg-50">
                <?php
                if (!empty($feat) || !empty($test)) {
                    ?>
                    <h2>
                        <?php echo esc_html($feat); ?> <span class="text-primary">
                            <?php echo esc_html($test); ?>
                        </span>
                    </h2>
                    <?php
                }
                ?>
                <div class="seprator"></div>
                <?php
                if (!empty($disc)) {
                    ?>
                    <p>
                        <?php echo esc_html($disc); ?>
                    </p>
                    <?php
                }
                ?>
            </header>
            <!-- Testimonials Block -->
            <div class="testimonials-block">
                <?php
                if (!empty($bgrd_img)) {
                    ?>
                    <div class="map-image">
                        <img src="
                    <?php echo esc_url_raw($bgrd_img); ?>" width="1004" height="599" alt="Featured featured_testonomy">
                    </div>
                    <?php
                }
                ?>
                <span class="quote-icon">
                    <?php esc_html_e('“', 'jobcircle-frame') ?>
                </span>
                <!-- Thumbnail Slider -->
                <div class="thumbnail-slider">
                    <?php
                    $lm_team_list = vc_param_group_parse_atts($atts['img_multi']);
                    if (!empty($lm_team_list)) {
                        foreach ($lm_team_list as $key => $value) {
                            $emp_img = isset($value['emp_img']) ? $value['emp_img'] : '';
                            ?>
                            <div class="slick-slide">
                                <?php
                                if (!empty($emp_img)) {
                                    ?>
                                    <div class="thumbnail">
                                        <img src="<?php echo esc_url_raw($emp_img); ?>" width="115" height="115" alt="Tom Affleck">
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <!-- Testimonials Slider -->
                <div class="testimonials-slider">
                    <?php
                    $lm_team_list = vc_param_group_parse_atts($atts['second_multi']);
                    if (!empty($lm_team_list)) {
                        foreach ($lm_team_list as $key => $value) {

                            $disce = isset($value["disce"]) ? $value["disce"] : '';
                            $name = isset($value['name']) ? $value['name'] : '';
                            $ceo = isset($value['ceo']) ? $value['ceo'] : '';
                            ?>
                            <div class="slick-slide">
                                <blockquote>
                                    <?php
                                    if (!empty($disce)) {
                                        ?>
                                        <q>
                                            <?php echo esc_textarea($disce); ?>
                                        </q>
                                        <?php
                                    }
                                    ?>
                                    <cite class="author-info">
                                        <?php
                                        if (!empty($name)) {
                                            ?>
                                            <strong class="author-name">
                                                <?php echo esc_html($name); ?>
                                            </strong>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if (!empty($ceo)) {
                                            ?>
                                            <?php echo esc_html($ceo); ?>
                                            <?php
                                        }
                                        ?>
                                    </cite>
                                </blockquote>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('jc_featured_testonomy', 'jobcircle_testimony_front');