<?php
function jobcircle_contact_address()
{
    vc_map(
        array(
            'name' => __('Contact Address'),
            'base' => 'contact_address',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title'),
                    'param_name' => 'support_title',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Span Title'),
                    'param_name' => 'address_span_title',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Description'),
                    'param_name' => 'discr',
                ),
                array(
                    'type' => 'iconpicker',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Location Icon'),
                    'param_name' => 'loc_icn',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Office'),
                    'param_name' => 'office_address',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Office Address'),
                    'param_name' => 'enter_office_address',
                ),
                array(
                    'type' => 'iconpicker',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Message Icon'),
                    'param_name' => 'msg_icn',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Email'),
                    'param_name' => 'email_address',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Admin Email'),
                    'param_name' => 'enter_email_address',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Support Email'),
                    'param_name' => 'enter_sup_email_address',
                ),
                array(
                    'type' => 'iconpicker',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Phone Icon'),
                    'param_name' => 'phn_icn',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Phone'),
                    'param_name' => 'title_phone',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Contact Number'),
                    'param_name' => 'phone_one',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Helpline'),
                    'param_name' => 'phone_two',
                ),
            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_contact_address');
//welcome Massage frontend
function jobcircle_contact_address_frontend($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'support_title' => '',
            'address_span_title' => '',
            'discr' => '',
            'loc_icn' => '',
            'office_address' => '',
            'enter_office_address' => '',
            'msg_icn' => '',
            'email_address' => '',
            'enter_email_address' => '',
            'enter_sup_email_address' => '',
            'phn_icn' => '',
            'title_phone' => '',
            'phone_one' => '',
            'phone_two' => '',
        ),
        $atts,
        'jobcircle_contact_address'
    );
    $support_title = isset($atts['support_title']) ? $atts['support_title'] : '';
    $address_span_title = isset($atts['address_span_title']) ? $atts['address_span_title'] : '';
    $discr = isset($atts['discr']) ? $atts['discr'] : '';
    $loc_icn = isset($atts['loc_icn']) ? $atts['loc_icn'] : '';
    $office_address = isset($atts['office_address']) ? $atts['office_address'] : '';
    $enter_office_address = isset($atts['enter_office_address']) ? $atts['enter_office_address'] : '';
    $msg_icn = isset($atts['msg_icn']) ? $atts['msg_icn'] : '';
    $email_address = isset($atts['email_address']) ? $atts['email_address'] : '';
    $enter_email_address = isset($atts['enter_email_address']) ? $atts['enter_email_address'] : '';
    $enter_sup_email_address = isset($atts['enter_sup_email_address']) ? $atts['enter_sup_email_address'] : '';
    $phn_icn = isset($atts['phn_icn']) ? $atts['phn_icn'] : '';
    $title_phone = isset($atts['title_phone']) ? $atts['title_phone'] : '';
    $phone_one = isset($atts['phone_one']) ? $atts['phone_one'] : '';
    $phone_two = isset($atts['phone_two']) ? $atts['phone_two'] : '';
    $output = '';
    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
    ob_start();
?>
    <section class="section section-contact pt-35 pt-md-50 pt-lg-65 pb-40 pb-md-50 pb-xl-60">
        <div class="container">
            <!-- Section header -->
            <header class="section-header text-center mb-30 mb-md-45 mb-lg-60">
                <?php
                if (!empty($support_title) || !empty($address_span_title)) {
                ?>
                    <h2><?php echo esc_html($support_title) ?> <span class="text-primary"><?php echo esc_html(nl2br($address_span_title)) ?></span></h2>
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
            <div class="row">
                <div class="col-12 col-md-4 mb-25 mb-md-30">
                    <div class="contact-box">
                        <div class="icon-holder">
                            <?php if (!empty($loc_icn)) {
                            ?>
                                <i class="<?php echo esc_html($loc_icn) ?>"></i>
                            <?php
                            } ?>
                        </div>
                        <div class="textbox">
                            <?php
                            if (!empty($office_address)) {
                            ?>
                                <h3 class="h4"><?php echo esc_html($office_address) ?></h3>
                            <?php
                            }
                            ?>
                            <?php
                            if (!empty($enter_office_address)) {
                            ?>
                                <address class="address"><?php echo esc_html($enter_office_address) ?></address>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 mb-35 mb-md-30">
                    <div class="contact-box">
                        <div class="icon-holder">
                            <?php if (!empty($msg_icn)) {
                            ?>
                                <i class="<?php echo esc_html($msg_icn) ?>"></i>
                            <?php
                            } ?>
                        </div>
                        <div class="textbox">
                            <?php
                            if (!empty($email_address)) {
                            ?>
                                <h3 class="h4"><?php echo esc_html($email_address) ?></h3>
                            <?php
                            }
                            ?>
                            <p>
                                <?php
                                if (!empty($enter_email_address)) {
                                ?>
                                    <a href="mailto:<?php echo esc_html($enter_email_address) ?>"><?php echo esc_html($enter_email_address) ?></a><br>
                                <?php
                                }
                                ?>
                                <?php
                                if (!empty($enter_sup_email_address)) {
                                ?>
                                    <a href="mailto:<?php echo esc_html($enter_sup_email_address) ?>"><?php echo esc_html($enter_sup_email_address) ?></a>
                                <?php
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 mb-35 mb-md-45">
                    <div class="contact-box">
                        <div class="icon-holder">
                            <?php if (!empty($phn_icn)) {
                            ?>
                                <i class="<?php echo esc_html($phn_icn) ?>"></i>
                            <?php
                            } ?>
                        </div>
                        <div class="textbox">
                            <?php
                            if (!empty($title_phone)) {
                            ?>
                                <h3 class="h4"><?php echo esc_html($title_phone) ?></h3>
                            <?php
                            }
                            ?>
                            <p>
                                <?php
                                if (!empty($phone_one)) {
                                ?>
                                    <?php esc_html_e('Toll Free :', 'jobcircle-frame') ?> <a href="tel:<?php echo esc_html($phone_one) ?>"><?php echo esc_html($phone_one) ?></a><br>
                                <?php
                                }
                                ?>
                                <?php
                                if (!empty($phone_two)) {
                                ?>
                                    <a href="tel:<?php echo esc_html($phone_two) ?>"><?php echo esc_html($phone_two) ?></a>
                                <?php
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="map-holder">
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
    return ob_get_clean();
}
add_shortcode('contact_address', 'jobcircle_contact_address_frontend');
