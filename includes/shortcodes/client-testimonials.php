<?php
function jobcircle_client_testimonials()
{
    vc_map(

        array(
            'name' => __('Client Testimonials'),
            'base' => 'jc_client_testimonials',
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
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Sub Title'),
                    'param_name' => 'sub_titl',
                ),
                //group
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'clint_review',
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Heading'),
                            'param_name' => 'heading',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Title'),
                            'param_name' => 'mlti_title',
                        ),
                        array(
                            'type' => 'jobcircle_browse_img',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Image'),
                            'param_name' => 'icn_img',
                        ),
                        array(
                            'type' => 'textarea',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Description'),
                            'param_name' => 'disc',
                        ),
                    ),
                )
            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_client_testimonials');
// Frontend Coding 
function jobcircle_client_testimonials_front($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'title' => '',
            'sub_titl' => '',

            'clint_review' => '',
        ),
        $atts,
        'jobcircle_client_testimonials'
    );
    $title = isset($atts['title']) ? $atts['title'] : '';
    $sub_titl = isset($atts['sub_titl']) ? $atts['sub_titl'] : '';
    ob_start()
?>
    <section class="section-testi-9 section-testimonial section-theme-9 featured_Jobs_Block">
        <div class="container">
            <div class="client_testimonials">
                <header class="section-header">
                    <?php
                    if (!empty($title)) { ?>
                        <p><?php echo esc_html($title) ?></p>
                    <?php
                    }
                    ?>
                    <?php
                    if (!empty($sub_titl)) { ?>
                        <h2><?php echo esc_html($sub_titl) ?></h2>
                    <?php
                    }
                    ?>
                </header>
                <div class="client_testimonials_slider">
                    <?php
                    $lm_team_list = vc_param_group_parse_atts($atts['clint_review']);
                    foreach ($lm_team_list as $key => $value) {
                        $heading = isset($value["heading"]) ? $value["heading"] : '';
                        $mlti_title = isset($value["mlti_title"]) ? $value["mlti_title"] : '';
                        $icn_img = isset($value["icn_img"]) ? $value["icn_img"] : '';
                        $disc = isset($value["disc"]) ? $value["disc"] : '';
                    ?>
                        <div>
                            <div class="client_review">
                                <div class="heading_bar">
                                    <div class="text_wrap">
                                        <?php
                                        if (!empty($heading)) {
                                        ?>
                                            <strong class="h5"><?php echo esc_html($heading) ?></strong>
                                        <?php
                                        }
                                        ?>
                                        <?php
                                        if (!empty($mlti_title)) { ?>
                                            <span class="text"><?php echo esc_html($mlti_title) ?></span>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="img_wrap">
                                        <?php
                                        if (!empty($icn_img)) { ?>
                                            <img src="<?php echo esc_url_raw($icn_img) ?>" alt="img">
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="stars_bar">
                                    <div class="stars_wrap">
                                        <i class="jobcircle-icon-star icon"></i>
                                        <i class="jobcircle-icon-star icon"></i>
                                        <i class="jobcircle-icon-star icon"></i>
                                        <i class="jobcircle-icon-star icon"></i>
                                        <i class="jobcircle-icon-star icon"></i>
                                    </div>
                                </div>
                                <?php
                                if (!empty($disc)) { ?>
                                    <p><?php echo esc_textarea($disc) ?></p>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
    </section>
<?php
    return ob_get_clean();
}
add_shortcode('jc_client_testimonials', 'jobcircle_client_testimonials_front');
