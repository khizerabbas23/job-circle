<?php
function jobcircle_news_letter()
{
    vc_map(
        array(
            'name' => __('Home Six Newsletter'),
            'base' => 'jc_news_letter',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Tittle'),
                    'param_name' => 'title',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('heading'),
                    'param_name' => 'head',
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
add_action('vc_before_init', 'jobcircle_news_letter');
function jobcircle_news_letter_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(
            'head' => '',
            'title' => '',
            'img_newsletter' => '',
                        'form_id' => '',
            'form_head' => '',
        ), 
        $atts,
        'jobcircle_news_letter'
    );
    $title = isset($atts['title']) ? $atts['title'] : '';
    $head = isset($atts['head']) ? $atts['head'] : '';
    $img_newsletter = isset($atts['img_newsletter']) ? $atts['img_newsletter'] : '';
    $form_id = isset($atts['form_id']) ? $atts['form_id'] : '';
    $form_head = isset($atts['form_head']) ? $atts['form_head'] : '';
    ob_start();
    ?>

    <section class="section section-newsletter section-theme-3 pt-25 pt-md-50 pt-xxl-0 pb-60 pb-md-60 pb-lg-75 pb-xxl-130">
        <div class="container">
            <div class="section-newsletter-holder classicnewslatter">
                <div class="section-header text-center">
                    <div class="mail-icon">
                        <?php
                        if (!empty($img_newsletter)) {
                            ?>
                            <img src="<?php echo esc_url_raw($img_newsletter); ?>" width="91" height="91" alt="Newsletter">
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                    if (!empty($title)) {
                        ?>
                        <h2 class="h1">
                            <?php echo esc_html($title); ?>
                        </h2>
                        <?php
                    }
                    ?>
                    <?php
                    if (!empty($head)) {
                        ?>
                        <p>
                            <?php echo esc_html($head); ?>
                        </p>
                        <?php
                    }
                    ?>
                </div>
                 <?php
                echo do_shortcode('[contact-form-7 id="' . esc_html($form_id) . '" title="' . esc_html($form_head) . '"]');
                ?>
            </div>
        </div>
    </section>

    <?php
    $html = ob_get_clean();
    return $html;
}
add_shortcode('jc_news_letter', 'jobcircle_news_letter_frontend');