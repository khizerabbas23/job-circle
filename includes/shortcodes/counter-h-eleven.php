<?php
function jobcircle_counter_eleven()
{
    vc_map(
        array(
            'name' => __('Counter Home Eleven'),
            'base' => 'jc_counter_eleven',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title '),
                    'param_name' => 'title_one',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('value '),
                    'param_name' => 'value_one',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title '),
                    'param_name' => 'title_two',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('value '),
                    'param_name' => 'value_two',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title '),
                    'param_name' => 'title_three',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('value '),
                    'param_name' => 'value_three',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title '),
                    'param_name' => 'title_four',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('value '),
                    'param_name' => 'value_four',
                ),
            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_counter_eleven');
//welcome Massage frontend
function jobcircle_counter_eleven_frontend($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'title_one' => '',
            'value_one' => '',
            'title_two' => '',
            'value_two' => '',
            'title_three' => '',
            'value_three' => '',
            'title_four' => '',
            'value_four' => '',
        ),
        $atts,
        'jobcircle_counter_eleven'
    );
    $title_one = isset($atts['title_one']) ? $atts['title_one'] : '';
    $value_one = isset($atts['value_one']) ? $atts['value_one'] : '';
    $title_two = isset($atts['title_two']) ? $atts['title_two'] : '';
    $value_two = isset($atts['value_two']) ? $atts['value_two'] : '';
    $title_three = isset($atts['title_three']) ? $atts['title_three'] : '';
    $value_three = isset($atts['value_three']) ? $atts['value_three'] : '';
    $title_four = isset($atts['title_four']) ? $atts['title_four'] : '';
    $value_four = isset($atts['value_four']) ? $atts['value_four'] : '';
    ob_start();
?>
    <div class="section section-theme-6">
        <div class="counters-block pb-30 pb-lg-60 pb-xl-85">
            <div class="container">
                <div class="row justify-content-center justify-content-md-between">
                    <div class="counter-box">
                        <div class="counter-stats">
                            <strong class="numbers h2">
                                <?php if (!empty($value_one)) { ?>
                                    <span data-purecounter-duration="1" data-purecounter-start="0" data-purecounter-end="<?php echo esc_html($value_one) ?>" data-purecounter-once="true" class="purecounter"><?php echo esc_html($value_one) ?></span><?php esc_html_e('%', 'jobcircle-frame') ?>
                                <?php } ?>
                            </strong>
                            <?php if (!empty($title_one)) { ?>
                                <span class="subtext"><?php echo esc_html($title_one) ?></span>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="counter-box">
                        <div class="counter-stats">
                            <strong class="numbers h2">
                                <?php if (!empty($value_two)) { ?>
                                    <span data-purecounter-duration="1" data-purecounter-start="0" data-purecounter-end="<?php echo esc_html($value_two) ?>" data-purecounter-once="true" class="purecounter"><?php echo esc_html($value_two) ?></span><?php esc_html_e('.0', 'jobcircle-frame') ?>
                                <?php } ?>
                            </strong>
                            <?php if (!empty($title_two)) { ?>
                                <span class="subtext"><?php echo esc_html($title_two) ?></span>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="counter-box">
                        <div class="counter-stats">
                            <strong class="numbers h2">
                                <?php if (!empty($value_three)) { ?>
                                    <span data-purecounter-duration="1" data-purecounter-start="0" data-purecounter-end="<?php echo esc_html($value_three) ?>" data-purecounter-once="true" class="purecounter"><?php echo esc_html($value_three) ?></span><?php esc_html_e('M', 'jobcircle-frame') ?>
                                <?php } ?>
                            </strong>
                            <?php if (!empty($title_three)) { ?>
                                <span class="subtext"><?php echo esc_html($title_three) ?></span>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="counter-box">
                        <div class="counter-stats">
                            <strong class="numbers h2">
                                <?php if (!empty($value_four)) { ?>
                                    <span data-purecounter-duration="1" data-purecounter-start="0" data-purecounter-end="<?php echo esc_html($value_four) ?>" data-purecounter-once="true" class="purecounter"><?php echo esc_html($value_four) ?></span><?php esc_html_e('+', 'jobcircle-frame') ?>
                                <?php } ?>
                            </strong>
                            <?php if (!empty($title_four)) { ?>
                                <span class="subtext"><?php echo esc_html($title_four) ?></span>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
    return ob_get_clean();
}
add_shortcode('jc_counter_eleven', 'jobcircle_counter_eleven_frontend');
