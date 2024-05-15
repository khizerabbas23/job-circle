<?php
function jobcircle_subscribe_newsletter()
{

    vc_map(

        array(
            'name' => __('Subscribe Newsletter'),
            'base' => 'job_circle_subscribe_newsletter',
            'category' => __('Job Circle'),
            'params' => array(

                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title'),
                    'param_name' => 'head',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Short Description'),
                    'param_name' => 'expl',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Image'),
                    'param_name' => 'img_newsletter',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Button Url'),
                    'param_name' => 'btn_url',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Button Text'),
                    'param_name' => 'btn_head',
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
            ),
        )
    );
}
add_action('vc_before_init', 'jobcircle_subscribe_newsletter');
function jobcircle_subscribe_newsletter_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(
            'head'=>'',
            'expl'=>'',
            'img_newsletter' => '',
            'btn_url' => '',
            'btn_head' => '',
            'form_id' => '',
            'form_head' => '',
        ),
        $atts,
        'jobcircle_subscribe_newsletter'
    );
    $head = isset($atts['head']) ? $atts['head'] : '';
    $expl = isset($atts['expl']) ? $atts['expl'] : '';
    $img_newsletter = isset($atts['img_newsletter']) ? $atts['img_newsletter'] : '';
    $btn_url = isset($atts['btn_url']) ? $atts['btn_url'] : '';
    $btn_head = isset($atts['btn_head']) ? $atts['btn_head'] : '';
    $form_id = isset($atts['form_id']) ? $atts['form_id'] : '';
    $form_head = isset($atts['form_head']) ? $atts['form_head'] : '';
    ob_start();
    ?>

    <section class="section section-newsletter section-theme-2 pt-15 pt-md-35 pt-xxl-0 pb-60 pb-md-60 pb-lg-75 pb-xxl-110">
    <div class="container">
        <div class="section-newsletter-holder bg-dark-yellow text-white">
            <div class="row pt-35 pt-md-0">
                <div class="col-12 col-md-7 col-xl-6">
                    <div class="d-flex align-items-center h-100 py-md-35 py-lg-25 mb-35 mb-md-0">
                        <div class="textbox">
                            <?php
                            if(!empty($head)){
                                ?>
                                <h3><?php echo esc_html($head, 'jobcircle-frame'); ?></h3>
                                <?php
                            }?>
                            <?php
                            if(!empty($expl)){
                                ?>
                                <p><?php echo esc_textarea($expl, 'jobcircle-frame'); ?></p>
                                <?php
                            }?>
                            <?php
                            echo do_shortcode('[contact-form-7 id="' . esc_html($form_id) . '" title="' . esc_html($form_head) . '"]');
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-5 col-xl-6 d-flex justify-content-center">
                    <div class="d-flex align-items-end h-100">
                        <div class="image-holder">
                            <?php
                            if(!empty($img_newsletter)){
                                ?>
                                <img src="<?php echo esc_url_raw($img_newsletter)?>" width="427" height="335" alt="Subscribe Newsletter">
                                <?php
                            }?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <?php
    $html = ob_get_clean();
    return $html;
}

add_shortcode('job_circle_subscribe_newsletter', 'jobcircle_subscribe_newsletter_frontend');