<?php
function jobcircle_our_recruiters()
{
    vc_map(

        array(
            'name' => __('Our Recruiters'),
            'base' => 'jc_our_recruiters',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Heading'),
                    'param_name' => 'heading',
                ),
                //group
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'recurter_multi',
                    'params' => array(
                        array(
                            'type' => 'jobcircle_browse_img',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Brand Image'),
                            'param_name' => 'img',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Url'),
                            'param_name' => 'url',
                        ),

                    ),
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Icon Image'),
                    'param_name' => 'icon_img',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Url'),
                    'param_name' => 'iconurl',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Image'),
                    'param_name' => 'section_img',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Background Image'),
                    'param_name' => 'bg_img',
                ),
            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_our_recruiters');

// Frontend Coding 

function jobcircle_our_recruiters_front($atts, $content)
{
    $atts = shortcode_atts(
        array(

            'heading' => '',
            'icon_img' => '',
            'section_img' => '',
            'iconurl' => '',
            'bg_img' => '',

            'recurter_multi' => '',

        ), $atts, 'jobcircle_our_recruiters'
    );

    $heading = isset($atts['heading']) ? $atts['heading'] : '';
    $icon_img = isset($atts['icon_img']) ? $atts['icon_img'] : '';
    $section_img = isset($atts['section_img']) ? $atts['section_img'] : '';
    $bg_img = isset($atts['bg_img']) ? $atts['bg_img'] : '';
    $iconurl = isset($atts['iconurl']) ? $atts['iconurl'] : '';

    ob_start()
        ?>
    <section class="section section-theme-10 recruiters-block pt-30 pt-md-50 pt-lg-80 pt-xxl-90 pb-0">
        <div class="container">
            <!-- Section header -->
            <header class="section-header d-flex flex-column-reverse text-center mb-0 mb-md-20">
                <?php if (!empty($heading)) { ?>
                    <h2 class="text-white">
                        <?php echo esc_html($heading) ?>
                    </h2>
                <?php } ?>
            </header>
            <ul class="brands-list">
                <?php
                $lm_team_list = vc_param_group_parse_atts($atts['recurter_multi']);
                foreach ($lm_team_list as $key => $value) {

                    $img = isset($value["img"]) ? $value["img"] : '';
                    $url = isset($value["url"]) ? $value["url"] : '';
                    ?>
                    <?php if (!empty($url) || !empty($img)) { ?>
                        <li><a href="<?php echo esc_html($url) ?>"><img src="<?php echo esc_html($img) ?>" alt="logo"></a></li>
                    <?php }
                }
                ?>
            </ul>
            <div class="video-frame">
                <?php if (!empty($iconurl) || !empty($icon_img)) { ?>
                    <a href="<?php echo esc_html($iconurl) ?>" class="play-icon"><img src="<?php echo esc_url_raw($icon_img) ?>"
                            alt="play"></a>
                <?php } ?>
                <?php if (!empty($section_img)) { ?>
                    <img src="<?php echo esc_url_raw($section_img) ?>" alt="video">
                <?php } ?>
            </div>
        </div>
        <?php if (!empty($bg_img)) { ?>
            <div class="section-bg" style="background-image: url('<?php echo esc_url_raw($bg_img) ?>');"></div>
        <?php } ?>
    </section>
    <?php

    return ob_get_clean();
}
add_shortcode('jc_our_recruiters', 'jobcircle_our_recruiters_front');