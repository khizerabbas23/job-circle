<?php
function jobcircle_contact_form_two()
{
    vc_map(
        array(
            'name' => __('Contact Form Two'),
            'base' => 'jb_contact_form_two',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Contact US'),
                    'param_name' => 'contct_us',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Short Description'),
                    'param_name' => 'short_desc',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Fill The Form Explanation'),
                    'param_name' => 'fill_form',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Highligted Text'),
                    'param_name' => 'high_text',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Form Id'),
                    'param_name' => 'form_id',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Form Heading'),
                    'param_name' => 'form_head',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Google Map'),
                    'param_name' => 'ggle_map',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Address Heading'),
                    'param_name' => 'addrs_head',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Address Paragraph'),
                    'param_name' => 'addrs_para',
                ),

                //group
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'contact_form_two',
                    'params' => array(
                        array(
                            'type' => 'iconpicker',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Put Icons'),
                            'param_name' => 'icon',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Heading'),
                            'param_name' => 'head',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Description'),
                            'param_name' => 'descp',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Contact'),
                            'param_name' => 'contact',
                        ),
                    )
                )
            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_contact_form_two');
//welcome Massage frontend
function jobcircle_contact_form_two_frontend($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'contct_us' => '',
            'short_desc' => '',
            'fill_form' => '',
            'high_text' => '',
            'form_id' => '',
            'form_head' => '',
            'ggle_map' => '',
            'addrs_head' => '',
            'addrs_para' => '',
            'contact_form_two' => '',
        ),
        $atts,
        'jobcircle_contact_form_two'
    );
    $contct_us = isset($atts['contct_us']) ? $atts['contct_us'] : '';
    $short_desc = isset($atts['short_desc']) ? $atts['short_desc'] : '';
    $fill_form = isset($atts['fill_form']) ? $atts['fill_form'] : '';
    $high_text = isset($atts['high_text']) ? $atts['high_text'] : '';
    $form_id = isset($atts['form_id']) ? $atts['form_id'] : '';
    $form_head = isset($atts['form_head']) ? $atts['form_head'] : '';
    $ggle_map = isset($atts['ggle_map']) ? $atts['ggle_map'] : '';
    $addrs_head = isset($atts['addrs_head']) ? $atts['addrs_head'] : '';
    $addrs_para = isset($atts['addrs_para']) ? $atts['addrs_para'] : '';
    $output = '';
    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
    ob_start();
?>
    <section class="section section-contact section-theme-1 pt-35 pt-md-50 pt-lg-75 pt-xl-100 pt-xxl-120 pb-35 pb-md-50 pb-lg-75 pb-xl-100 pb-xxl-120  th-good contact-2">
        <div class="container">
            <!-- Section header -->
            <header class="section-header mb-30 mb-md-45 mb-xl-60">
                <?php
                if (!empty($contct_us)) {
                ?>
                    <strong class="subtitle"><?php echo esc_html($contct_us); ?></strong>
                <?php
                } ?>

                <?php
                if (!empty($short_desc)) {
                ?>
                    <h2><?php echo esc_html($short_desc); ?></h2>
                <?php
                } ?>
                <?php
                if (!empty($fill_form) || !empty($high_text)) {
                ?>
                    <p><?php echo esc_html($fill_form); ?> <strong><?php echo esc_html($high_text); ?></strong></p>
                <?php
                } ?>
            </header>
            <div class="row justify-content-between">
                <div class="col-12 col-md-6 mb-40 mb-md-0">
                    <!-- Contact Form -->
                    <?php
                    echo do_shortcode('[contact-form-7 id="' . esc_html($form_id) . '" title="' . esc_html($form_head) . '"]');
                    ?>
                </div>
                <div class="col-12 col-md-6 col-xl-5">
                    <ul class="contact-support">
                        <li>
                            <div class="contact-box">
                                <div class="icon-holder">
                                    <i class="jobcircle-icon-map-pin"></i>
                                </div>
                                <div class="textbox">
                                    <?php if (!empty($addrs_head)) { ?>
                                        <h3 class="h4"><?php echo esc_html($addrs_head) ?>:</h3>
                                    <?php } ?>
                                    <?php if (!empty($addrs_para)) { ?>
                                        <address><?php echo esc_html($addrs_para) ?></address>
                                    <?php } ?>
                                </div>
                            </div>
                        </li>
                        <?php
                        $lm_team_list = vc_param_group_parse_atts($atts['contact_form_two']);
                        if (!empty($lm_team_list)) {
                            $counter = '1';
                            foreach ($lm_team_list as $key => $value) {
                                if ($counter == 1) {
                                    $icon = 'jobcircle-icon-phone';
                                } elseif ($counter == 2) {
                                    $icon = 'jobcircle-icon-contact';
                                }
                                $head  = isset($value["head"]) ? $value["head"] : '';
                                $descp  = isset($value["descp"]) ? $value["descp"] : '';
                                $contact  = isset($value["contact"]) ? $value["contact"] : '';
                        ?>
                                <li>
                                    <div class="contact-box">
                                        <div class="icon-holder">
                                            <?php if (!empty($icon)) { ?>
                                                <i class="<?php echo esc_html($icon) ?>"></i>
                                            <?php } ?>
                                        </div>
                                        <div class="textbox">
                                            <?php if (!empty($head)) { ?>
                                                <h3 class="h4"><?php echo esc_html($head) ?>:</h3>
                                            <?php } ?>
                                            <?php
                                            if (!empty($descp) || !empty($contact)) {
                                            ?>
                                                <p>
                                                    <?php echo esc_html($descp) ?><br>
                                                    <a href="tel:<?php echo esc_html($contact) ?>"><?php echo esc_html($contact) ?></a>
                                                </p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </li>
                        <?php
                                $counter++;
                            }
                        }
                        ?>
                        <li>
                            <a href="#" class="btn btn-green btn-sm"><span class="btn-text"><?php esc_html_e('Live Support', 'jobcircle-frame'); ?></span></a>
                        </li>
                    </ul>
                </div>
                <div class="col-12 mt-40 mt-md-60 mt-lg-80">
                    <div class="map-holder">
                        <?php if (!empty($ggle_map)) { ?>
                            <iframe src="<?php echo esc_html($ggle_map); ?>" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
    return ob_get_clean();
}
add_shortcode('jb_contact_form_two', 'jobcircle_contact_form_two_frontend');
