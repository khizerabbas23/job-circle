<?php
function jobcircle_dont_get_answer_faq()
{
    vc_map(
        array(
            'name' => __('Dont Get Your Answer'),
            'base' => 'jc_dont_get_answer_faq',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Sub Title'),
                    'param_name' => 'sb_title',
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
                    'heading' => __('Button Url'),
                    'param_name' => 'btn_url',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Button Text'),
                    'param_name' => 'btn_txt',
                ),
            ),
        )
    );
}
add_action('vc_before_init', 'jobcircle_dont_get_answer_faq');
function jobcircle_dont_get_answer_faq_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(

            'sb_title' => '',
            'title' => '',
            'btn_url' => '',
            'btn_txt' => '',
        ),
        $atts,
        'jobcircle_dont_get_answer_faq'
    );

    $sb_title = isset($atts['sb_title']) ? $atts['sb_title'] : '';
    $title = isset($atts['title']) ? $atts['title'] : '';
    $btn_url = isset($atts['btn_url']) ? $atts['btn_url'] : '';
    $btn_txt = isset($atts['btn_txt']) ? $atts['btn_txt'] : '';

    ob_start();
    ?>
    <section class="section section-theme-1 section-faqs pt-15 pt-md-0 pb-50 pb-md-50 pb-lg-75 pb-xl-100 pb-xxl-125">
        <div class="container">
            <div class="textbox text-center">
                <strong class="subtitle">
                    <?php
                    if (!empty($sb_title)) {
                        ?>
                        <?php echo esc_html($sb_title) ?>
                    <?php
                    } ?>
                </strong>
                <h2>
                    <?php
                    if (!empty($title)) {
                        ?>
                        <?php echo esc_html($title) ?>
                    <?php
                    } ?>
                </h2>
                <?php if (!empty($btn_url) || !empty($btn_txt)) {
                    ?>
                    <a href="<?php echo esc_html($btn_url) ?>" class="btn btn-green btn-sm"><span class="btn-text">
                            <?php echo esc_html($btn_txt) ?>
                        </span></a>
                    <?php
                } ?>
            </div>
        </div>
    </section>
    <?php

    ?>
    <?php

    return ob_get_clean();
}

add_shortcode('jc_dont_get_answer_faq', 'jobcircle_dont_get_answer_faq_frontend');