<?php
function counter_coustomiser()
{
    vc_map(
        array(
            'name' => __('Counter customers are satisfied'),
            'base' => 'jc_unique_counter_coustomiser',
            'category' => __('Job Circle'),
            'params' => array(
                //group
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'counter_coustomiser_multi',
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
                            'heading' => __('Number'),
                            'param_name' => 'number',
                        ),
                    )
                ),
            )
        )
    );
}
add_action('vc_before_init', 'counter_coustomiser');
// Frontend Coding 
function counter_coustomiser_front($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'counter_coustomiser_multi' => '',
        ),
        $atts,
        'counter_coustomiser'
    );
    ob_start();
?>
    <section class="section section-about our-counter section-theme-1 pt-35 pt-md-50 pt-lg-70 pt-xl-100 pt-xxl-120 pb-35 pb-md-50 pb-lg-70 pb-xl-100 pb-xxl-120">
        <div class="container">
            <!-- Section header -->
            <div class="row">
                <div class="counters-block d-flex flex-wrap justify-content-between mt-md-25 mt-xl-50 pt-35 pt-md-50 pt-lg-60 mb-0 pb-0">
                    <?php
                    $lm_team_list = vc_param_group_parse_atts($atts['counter_coustomiser_multi']);
                    $counter = 0;
                    foreach ($lm_team_list as $key => $value) {
                        $title = isset($value["title"]) ? $value["title"] : '';
                        $number = isset($value["number"]) ? $value["number"] : '';
                        if ($counter == 0) {
                            $specialclass = '%';
                        } elseif ($counter == 1) {
                            $specialclass = '.0';
                        } elseif ($counter == 2) {
                            $specialclass = 'M';
                        } elseif ($counter == 3) {
                            $specialclass = '+';
                        }
                    ?>
                        <div class="counter-box">
                            <div class="counter-stats">
                                <?php if (!empty($number) || !empty($specialclass)) { ?>
                                    <strong class="numbers h2">
                                        <span data-purecounter-duration="2" data-purecounter-start="0" data-purecounter-end="<?php echo esc_html($number) ?>" data-purecounter-once="true" class="purecounter"><?php echo jobcircle_esc_the_html($number) ?></span><?php echo jobcircle_esc_the_html($specialclass) ?>
                                    </strong>
                                <?php } ?>
                                <?php if (!empty($title)) { ?>
                                    <span class="subtext"><?php echo esc_html($title) ?></span>
                                <?php } ?>
                            </div>
                        </div>
                    <?php
                        $counter++;
                    }
                    ?>
                </div>
    </section>
<?php
    $html = ob_get_clean();
    return $html;
}
add_shortcode('jc_unique_counter_coustomiser', 'counter_coustomiser_front');
