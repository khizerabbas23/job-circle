<?php
function jobcircle_what_we_provide()
{
    vc_map(
        array(
            'name' => __('What We Provide'),
            'base' => 'jc_what_we_provide',
            'category' => __('Job Circle'),
            'params' => array(


                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title'),
                    'param_name' => 'main_title',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Span Title'),
                    'param_name' => 'span_title',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Descrition'),
                    'param_name' => 'desc',
                ),

                //group
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'provide_multi',
                    'params' => array(


                        array(
                            'type' => 'iconpicker',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Icon'),
                            'param_name' => 'multi_icn',
                        ),
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
                            'heading' => __('Url'),
                            'param_name' => 'url',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Description'),
                            'param_name' => 'description',
                        ),
                    ),
                )
            )


        )
    );
}
add_action('vc_before_init', 'jobcircle_what_we_provide');


// Frontend Coding 

function jobcircle_what_we_provide_front($atts, $content)
{

    $atts = shortcode_atts(
        array(

            'main_title' => '',
            'span_title' => '',
            'desc' => '',

            'provide_multi' => '',
        ),
        $atts,
        'jobcircle_what_we_provide'
    );

    $main_title = isset($atts['main_title']) ? $atts['main_title'] : '';
    $span_title = isset($atts['span_title']) ? $atts['span_title'] : '';
    $desc = isset($atts['desc']) ? $atts['desc'] : '';

    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
    ob_start();
?>
    <section class="section section-services pt-35 pt-md-50 pt-lg-65 pt-xl-80 pb-0">
        <div class="container">
            <!-- Section header -->
            <header class="section-header text-center mb-30 mb-md-45 mb-lg-50">
                <?php if (!empty($main_title) || !empty($span_title)) {
                ?>
                    <h2>
                        <?php echo jobcircle_esc_the_html($main_title) ?> <span class="text-primary">
                            <?php echo jobcircle_esc_the_html($span_title) ?>
                        </span>
                    </h2>
                <?php
                } ?>
                <div class="seprator"></div>
                <?php if (!empty($desc)) {
                ?>
                    <p>
                        <?php echo esc_textarea($desc) ?>
                    </p>
                <?php
                } ?>
            </header>
            <div class="row">
                <?php
                $lm_team_list = vc_param_group_parse_atts($atts['provide_multi']);

                if (!empty($lm_team_list)) {
                    foreach ($lm_team_list as $key => $value) {

                        $multi_icn = isset($value["multi_icn"]) ? $value["multi_icn"] : '';
                        $title = isset($value["title"]) ? $value["title"] : '';
                        $url = isset($value["url"]) ? $value["url"] : '';
                        $description = isset($value["description"]) ? $value["description"] : '';

                ?>
                        <div class="col-12 col-md-6 col-lg-4 mb-10 mb-md-25">
                            <!-- service Box -->
                            <article class="service-box">
                                <div class="icon-holder">
                                    <?php if (!empty($multi_icn)) {
                                    ?>
                                        <i class="<?php echo jobcircle_esc_the_html($multi_icn) ?>"></i>
                                    <?php
                                    } ?>
                                </div>
                                <div class="textbox">
                                    <?php if (!empty($url) || !empty($title)) {
                                    ?>
                                        <h3 class="h5"><a href="<?php echo esc_url($url) ?>"><?php echo jobcircle_esc_the_html($title) ?></a></h3>
                                    <?php
                                    } ?>
                                    <?php if (!empty($description)) {
                                    ?>
                                        <p>
                                            <?php echo esc_textarea($description) ?>
                                        </p>
                                    <?php
                                    } ?>
                                </div>
                            </article>
                        </div>
                <?php
                    }
                } ?>
            </div>
        </div>
    </section>
<?php
    $html = ob_get_clean();

    return $html;
}
add_shortcode('jc_what_we_provide', 'jobcircle_what_we_provide_front');
