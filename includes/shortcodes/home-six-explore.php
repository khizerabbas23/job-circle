<?php
function jobcircle_explore_section()
{
    vc_map(
        array(
            'name' => __('Explore Home Six'),
            'base' => 'jc_explore_section',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('TITLE'),
                    'param_name' => 'title',
                ),
                //group
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'multi_review',
                    'params' => array(
                        array(
                            'type' => 'jobcircle_browse_img',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Multi Image'),
                            'param_name' => 'mul_img',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Image url'),
                            'param_name' => 'img_url',
                        ),

                    ),
                )
            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_explore_section');

// Frontend Coding 
function jobcircle_explore_section_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(
            'title' => '',
            'multi_review' => '',

        ),
        $atts,
        'jobcircle_explore_section'
    );

    $title = isset($atts['title']) ? $atts['title'] : '';
    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';

    ob_start();
    ?>
    <section class="section section-theme-3 section-explores pt-35 pt-md-50 pb-35 pb-md-50">
        <div class="container">
            <div class="section-header mb-20 md-md-50 text-center">
                <?php
                if (!empty($title)) {
                    ?>
                    <h3 class="h6">
                        <?php echo esc_html($title); ?>
                    </h3>
                    <?php
                }
                ?>
            </div>
            <ul class="sites-list">
                <?php

                $lm_team_list = vc_param_group_parse_atts($atts['multi_review']);

                foreach ($lm_team_list as $key => $value) {
                    $mul_img = isset($value['mul_img']) ? $value['mul_img'] : '';
                    $img_url = isset($value['img_url']) ? $value['img_url'] : '';


                    ?>
                    <?php
                    if (!empty($mul_img) || !empty($img_url)) {
                        ?>
                        <li><a href="<?php echo esc_html($img_url) ?>"><img src="<?php echo esc_url_raw($mul_img); ?>"
                                    alt="Image Description"></a></li>
                        <?php
                    }
                    ?>
                    <?php
                }
                ?>
            </ul>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('jc_explore_section', 'jobcircle_explore_section_frontend');