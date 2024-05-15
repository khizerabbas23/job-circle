<?php
function jobcircle_contact_form()
{
    vc_map(
        array(
            'name' => __('Contact Form'),
            'base' => 'contact_form',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title'),
                    'param_name' => 'drop_any_title',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Span Title'),
                    'param_name' => 'question_span_title',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Discription'),
                    'param_name' => 'discr',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Contact Form Id'),
                    'param_name' => 'contact_id',
                ), array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Contact Form Heading'),
                    'param_name' => 'contact_heading',
                ),
            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_contact_form');
//welcome Massage frontend
function jobcircle_contact_form_frontend($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'drop_any_title' => '',
            'question_span_title' => '',
            'discr' => '',
            'contact_id' => '',
            'contact_heading' => '',
        ),
        $atts,
        'jobcircle_contact_form'
    );
    $drop_any_title = isset($atts['drop_any_title']) ? $atts['drop_any_title'] : '';
    $question_span_title = isset($atts['question_span_title']) ? $atts['question_span_title'] : '';
    $discr = isset($atts['discr']) ? $atts['discr'] : '';
    $contact_id = isset($atts['contact_id']) ? $atts['contact_id'] : '';
    $contact_heading = isset($atts['contact_heading']) ? $atts['contact_heading'] : '';
    $output = '';
    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
    ob_start();
?>
    <section class="section section-contact pt-0 pb-35 pb-md-50 pb-lg-75 pb-xl-100">
        <div class="container">
            <!-- Section header -->
            <header class="section-header text-center mb-30 mb-md-45 mb-lg-50">
                <?php
                if (!empty($drop_any_title) || !empty($question_span_title)) {
                ?>
                    <h2><?php echo esc_html($drop_any_title) ?> <span class="text-primary"><?php echo esc_html($question_span_title) ?></span></h2>
                <?php
                }
                ?>
                <div class="seprator"></div>
                <?php
                if (!empty($discr)) {
                ?>
                    <p><?php echo esc_textarea($discr) ?></p>
                <?php
                }
                ?>
            </header>
            <?php
            echo do_shortcode('[contact-form-7 id="' . esc_html($contact_id) . '" title="' . esc_html($contact_heading) . '"]');
            ?>
        </div>
    </section>
<?php
    return ob_get_clean();
}
add_shortcode('contact_form', 'jobcircle_contact_form_frontend');
