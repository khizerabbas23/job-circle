<?php
function jobcircle_client_review()
{
    vc_map(
        array(
            'name' => __('Testimonial Our Customers'),
            'base' => 'jc_client_review',
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
                    'param_name' => 'jobcircle_client_review_multi',
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Multi Title'),
                            'param_name' => 'multi_title',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('FeedBack'),
                            'param_name' => 'feedback',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Client Name'),
                            'param_name' => 'client_name',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Client Designation'),
                            'param_name' => 'client_desig',
                        ),
                        array(
                            'type' => 'jobcircle_browse_img',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Company Image'),
                            'param_name' => 'company_img',
                        ),
                    )
                ),
            ),
        )
    );
}
add_action('vc_before_init', 'jobcircle_client_review');

//welcome Massage frontend
function jobcircle_client_review_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(
            'title' => '',
            'heading' => '',

            'jobcircle_client_review_multi' => '',

        ), $atts, 'jobcircle_client_review'
    );

    $title = isset($atts['title']) ? $atts['title'] : '';
    $heading = isset($atts['heading']) ? $atts['heading'] : '';
    $im_app_services = vc_param_group_parse_atts($atts['title']);
    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';

    ob_start();
    ?>
    <section class="section section-theme-17 browse_categories client-reviews">
        <div class="container">
            <div class="leading_brands">
                <header class="section-header mb-70 mb-lg-35">
                    <?php if (!empty($title)) {
                        ?>
                        <p>
                            <?php echo esc_html($title) ?>
                        </p>
                    <?php }
                    if (!empty($heading)) { ?>
                        <h2>
                            <?php echo esc_html($heading) ?>
                        </h2>
                    <?php } ?>
                </header>
                <div class="slider-wrap">
                    <div class="leading_brands_slider">
                        <?php

                        $lm_team_list = vc_param_group_parse_atts($atts['jobcircle_client_review_multi']);
if(!empty($lm_team_list)){
                        foreach ($lm_team_list as $key => $value) {

                            $company_img = isset($value['company_img']) ? $value['company_img'] : '';
                            $multi_title = isset($value['multi_title']) ? $value['multi_title'] : '';
                            $feedback = isset($value['feedback']) ? $value['feedback'] : '';
                            $client_name = isset($value['client_name']) ? $value['client_name'] : '';
                            $client_desig = isset($value['client_desig']) ? $value['client_desig'] : '';

                            ?>
                            <div>
                                <div class="client_review">
                                    <div class="heading_bar">
                                        <?php if (!empty($multi_title)) {
                                            ?>
                                            <strong class="title-quality">
                                                <?php echo esc_html($multi_title) ?>
                                            </strong>
                                        <?php } ?>
                                        <div class="stars">
                                            <i class="jobcircle-icon-star icon"></i>
                                            <i class="jobcircle-icon-star icon"></i>
                                            <i class="jobcircle-icon-star icon"></i>
                                            <i class="jobcircle-icon-star icon"></i>
                                            <i class="jobcircle-icon-star icon"></i>
                                        </div>
                                    </div>
                                    <div class="text_bar">
                                        <?php if (!empty($feedback)) {
                                            ?>
                                            <strong class="h5">"
                                                <?php echo esc_html($feedback) ?> "
                                            </strong>
                                        <?php
                                        } ?>
                                        <div class="refrence-holder">
                                            <div class="text-box">
                                                <?php if (!empty($client_name)) {
                                                    ?>
                                                    <strong class="h5">
                                                        <?php echo esc_html($client_name) ?>
                                                    </strong>
                                                <?php
                                                }
                                                if (!empty($client_desig)) { ?>
                                                    <p>-
                                                        <?php echo esc_html($client_desig) ?>
                                                    </p>
                                                <?php } ?>
                                            </div>
                                            <div class="logo-box">
                                                <?php if (!empty($company_img)) { ?>
                                                    <img src="<?php echo esc_url_raw($company_img) ?>" alt="logo">
                                                <?php
                                                } ?>
                                            </div>
                                        </div>
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
        </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('jc_client_review', 'jobcircle_client_review_frontend');