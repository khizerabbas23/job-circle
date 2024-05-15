<?php
function jobcircle_how_its_work()
{
    vc_map(
        array(
            'name' => __('How Its Work 15'),
            'base' => 'jc_how_its_work',
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
                    'param_name' => 'jc_how_its_work_multi',
                    'params' => array(
                        array(
                            'type' => 'jobcircle_browse_img',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Image'),
                            'param_name' => 'img',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Mulit Title'),
                            'param_name' => 'multi_title',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Multi Description'),
                            'param_name' => 'multi_desc',
                        ),
                    )
                ),
            ),
        )
    );
}
add_action('vc_before_init', 'jobcircle_how_its_work');
//welcome Massage frontend
function jobcircle_how_its_work_frontend($atts, $content)
{
    $atts = shortcode_atts(
        array(

            'heading' => '',
            'title' => '',

            'jc_how_its_work_multi' => '',

        ), $atts, 'jobcircle_how_its_work'
    );

    $heading = isset($atts['heading']) ? $atts['heading'] : '';
    $title = isset($atts['title']) ? $atts['title'] : '';
    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';

    ob_start();
    ?>
    <section class="section section-theme-15 how-it-works-block pt-35 pt-md-50 pt-xl-90 pb-10 pb-md-50 pb-lg-80 pb-xxl-92">
        <div class="container">
            <!-- Section header -->
            <header class="section-header d-flex flex-column-reverse text-center mb-20 mb-lg-30 mb-xl-45">
                <?php if (!empty($heading)) {
                    ?>
                    <h2>
                        <?php echo esc_html($heading) ?>
                    </h2>
                <?php
                }
                if (!empty($title)){
                    ?>
                    <p>
                        <?php echo esc_html($title) ?>
                    </p>
                <?php } ?>
            </header>
            <div class="row justify-content-center justify-content-lg-start work-steps-holder">
                <?php

                $lm_team_list = vc_param_group_parse_atts($atts['jc_how_its_work_multi']);

                foreach ($lm_team_list as $key => $value) {

                    $img = isset($value['img']) ? $value['img'] : '';
                    $multi_title = isset($value['multi_title']) ? $value['multi_title'] : '';
                    $multi_desc = isset($value['multi_desc']) ? $value['multi_desc'] : '';

                    ?>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="work-frame">
                            <?php if (!empty($img)) {
                                ?>
                                <div class="icon-box"><img src="<?php echo esc_html($img) ?>" alt="icon"></div>
                            <?php } ?>
                            <div class="text">
                                <?php if (!empty($multi_title)) {
                                    ?>
                                    <h3>
                                        <?php echo esc_html($multi_title) ?>
                                    </h3>
                                <?php
                                }
                                if (!empty($multi_desc)) {
                                    ?>
                                    <p>
                                        <?php echo esc_html($multi_desc) ?>
                                    </p>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </section>
    
    <?php
    return ob_get_clean();

}
add_shortcode('jc_how_its_work', 'jobcircle_how_its_work_frontend');