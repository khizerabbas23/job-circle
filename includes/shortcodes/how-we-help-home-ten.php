<?php
function jobcircle_aw_help_ten()
{
    vc_map(
        array(
            'name' => __('How We Help'),
            'base' => 'aw_help_ten',
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
                    'param_name' => 'sub_title',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Discription'),
                    'param_name' => 'disc',
                ),
                

                //group
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'features_multi',
                    'params' => array(

                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Features'),
                            'param_name' => 'features',
                        ),
                        array(
                            'type' => 'jobcircle_browse_img',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Image'),
                            'param_name' => 'ionimage',
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
                            'type' => 'jobcircle_browse_img',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Image'),
                            'param_name' => 'mul_img',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Title'),
                            'param_name' => 'mul_title',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Heading'),
                            'param_name' => 'mul_head',
                        ),
                    ),
                )
            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_aw_help_ten');
// Frontend Coding 
function jobcircle_aw_help_ten_front($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'title' => '',
            'sub_title' => '',
            'disc' => '',
            //For Multi
            'features_multi' => '',
            'second_multi' => '',

        ),
        $atts,
        'jobcircle_aw_help_ten'
    );

    $title = isset($atts['title']) ? $atts['title'] : '';
    $sub_title = isset($atts['sub_title']) ? $atts['sub_title'] : '';
    $disc = isset($atts['disc']) ? $atts['disc'] : '';
    $custom_plan_price = isset($atts['nb_Circletitle']) && !empty($atts['nb_Circletitle']) ? $atts['nb_Circletitle'] : '';

    ob_start();
?>

    <section class="section section-theme-10 how-we-help-block pt-35 pt-md-50 pt-lg-75 pt-xxl-120 pb-35 pb-md-50 pb-lg-80 pb-xxl-100">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-5 col-lg-7">
                    <?php 
                    if(!empty($title)){
                        ?>
                    <p class="mb-5 mb-lg-10"><?php echo esc_html($title);?></p>
                    <?php
                    }
                    if(!empty($sub_title)){
                        ?>
                    <h2 class="showhead"><?php echo esc_html($sub_title);?></h2>
                    <?php
                    }
                    ?>
                </div>
                <div class="col-12 col-md-7 col-lg-5">
                    <?php
                    if(!empty($disc)){
                        ?>
                    <p><?php echo esc_textarea($disc);?></p>
                    <?php
                    }
                    ?>
                    <ul class="list-unstyled help-list">

                    <?php

                        $lm_team_list = vc_param_group_parse_atts($atts['features_multi']);

                        if (!empty($lm_team_list)) {
                            foreach ($lm_team_list as $key => $value) {
                                $features = isset($value['features']) ? $value['features'] : '';
                                $ionimage = isset($value['ionimage']) ? $value['ionimage'] : '';
                        ?>
                        <?php 
                        if(!empty($features) || !empty($ionimage)){
                            ?>
                                <li style="background: url(<?php echo esc_url_raw($ionimage) ?>;) no-repeat;  background-size: contain;"><?php echo esc_html($features);?></li>
                                <?php
                        }
                        ?>
                        <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="inner-frm">
                <div class="row justify-content-center">

                    <?php
                    $lm_team_list = vc_param_group_parse_atts($atts['second_multi']);
                    if (!empty($lm_team_list)) {
                        foreach ($lm_team_list as $key => $value) {

                            $mul_img  = isset($value["mul_img"]) ? $value["mul_img"] : '';
                            $mul_title = isset($value['mul_title']) ? $value['mul_title'] : '';
                            $mul_head = isset($value['mul_head']) ? $value['mul_head'] : '';
                    ?>
                            <div class="col-12 col-md-6 col-xl-4">
                                <div class="step-frame">
                                    <?php
                                    if(!empty($mul_img)){
                                        ?>
                                    <div class="icon-image"><img src="<?php echo esc_url_raw($mul_img);?>" alt="icon"></div>
                                    <?php
                                    }
                                    ?>
                                    <div class="text">
                                        <?php
                                        if(!empty($mul_title)){
                                            ?>
                                        <h3><?php echo esc_html($mul_title);?></h3>
                                        <?php 
                                        }
                                        if(!empty($mul_head)){
                                            ?>
                                        <p><?php echo esc_html($mul_head);?></p>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
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
add_shortcode('aw_help_ten', 'jobcircle_aw_help_ten_front');
