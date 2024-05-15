<?php
function jobcircle_how_its_work_seven()
{
    vc_map(
        array(
            'name' => __('How Its Work Seven'),
            'base' => 'jc_how_its_work_seven',
            'category' => __('job Circle'),
            'params' => array(
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Sub Title'),
                    'param_name' => 'sub_title',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title'),
                    'param_name' => 'titl',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Description'),
                    'param_name' => 'desc',
                ),
                //group
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'customer_multi',
                    'params' => array(
                        array(
                            'type' => 'jobcircle_browse_img',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Image'),
                            'param_name' => 'icn_img',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Count Number'),
                            'param_name' => 'cont_num',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Title'),
                            'param_name' => 'mlti_title',
                        ),

                    ),
                )
            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_how_its_work_seven');
// Frontend Coding 

function jobcircle_how_its_work_seven_front($atts, $content)
{

    $atts = shortcode_atts(
        array(

            'sub_title' => '',
            'titl' => '',
            'desc' => '',

            'customer_multi' => '',

        ),
        $atts,
        'jobcircle_how_its_work_seven'
    );

    $sub_title = isset($atts['sub_title']) ? $atts['sub_title'] : '';
    $titl = isset($atts['titl']) ? $atts['titl'] : '';
    $desc = isset($atts['desc']) ? $atts['desc'] : '';

    ob_start()
        ?>

    <section class="section-theme-7 theme_seven_sec featured_Jobs_Block">
        <div class="container">
            <div class="works_info_wrap">
                <header class="section-header d-lg-flex justify-content-lg-between align-items-center">
                    <div class="wrap">
                        <p>
                            <?php if (!empty($sub_title)) {
                                ?>
                                <?php echo esc_textarea($sub_title) ?>
                                <?php
                            } ?>
                        </p>
                        <h2>
                            <?php if (!empty($titl)) {
                                ?>
                                <?php echo esc_html($titl) ?>
                                <?php
                            } ?>
                        </h2>
                    </div>
                    <div class="text_wrap">
                        <p>
                            <?php if (!empty($desc)) {
                                ?>
                                <?php echo esc_textarea($desc) ?>
                                <?php
                            } ?>
                        </p>
                    </div>
                </header>
                <div class="row">
                    <?php
                    $counter = 0;

                    $lm_team_list = vc_param_group_parse_atts($atts['customer_multi']);

                    foreach ($lm_team_list as $key => $value) {
                        if ($counter == 0) {
                            $infobox = '';
                            $col = 'mb-70 mb-lg-0';

                        } elseif ($counter == 1) {
                            $infobox = 'pos-top';
                            $col = 'mb-70 mb-lg-0';

                        } elseif ($counter == 2) {
                            $infobox = '';
                            $col = '';

                        } else {
                            $infobox = '';
                            $col = '';
                        }

                        $icn_img = isset($value["icn_img"]) ? $value["icn_img"] : '';
                        $cont_num = isset($value["cont_num"]) ? $value["cont_num"] : '';
                        $mlti_title = isset($value["mlti_title"]) ? $value["mlti_title"] : '';

                        ?>
                        <div class="col-12 col-lg-4 <?php echo $col ?>">
                            <div class="info_box <?php echo $infobox ?>">
                                <div class="icon_holder">
                                    <div class="icon_box">
                                        <?php if (!empty($icn_img)) {
                                            ?>
                                            <img src="<?php echo esc_url_raw($icn_img) ?>" alt="img">
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php if (!empty($cont_num)) {
                                    ?>
                                    <div class="count">
                                        <span class="number">
                                            <?php echo esc_html($cont_num) ?>
                                        </span>
                                    </div>
                                <?php }
                                if (!empty($mlti_title)) { ?>
                                    <strong class="title">
                                        <?php echo esc_html($mlti_title) ?>
                                    </strong>
                                <?php } ?>
                            </div>
                        </div>
                        <?php
                        $counter++;
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <?php

    return ob_get_clean();
}
add_shortcode('jc_how_its_work_seven', 'jobcircle_how_its_work_seven_front');