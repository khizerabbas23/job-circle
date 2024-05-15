<?php
function over_recruite_hnin()
{
    vc_map(

        array(
            'name' => __('Over Recruite H-9'),
            'base' => 'over_recruite_hnin',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Recruiters Heading'),
                    'param_name' => 'rescter_heading',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Recruiters Discription'),
                    'param_name' => 'rescter_discr',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Image'),
                    'param_name' => 'img',
                ),

            )
        )
    );
}
add_action('vc_before_init', 'over_recruite_hnin');

//welcome Massage frontend
function over_recruite_hnin_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(

            'rescter_heading' => '',
            'rescter_discr' => '',
            'img' => '',
        ),
        $atts,
        'over_recruite_hnin'
    );

    $rescter_heading = isset($atts['rescter_heading']) ? $atts['rescter_heading'] : '';
    $rescter_discr = isset($atts['rescter_discr']) ? $atts['rescter_discr'] : '';
    $img = isset($atts['img']) ? $atts['img'] : '';

    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
    ob_start();
    ?>
    <div class="row align-items-center">
        <div class="col-12 mb-50 mb-lg-0 col-lg-6">
            <div class="recruite_text_info">
                <?php if (!empty($rescter_heading)) {
                    ?>
                    <h2>
                        <?php echo esc_html($rescter_heading) ?>
                    </h2>
                <?php }
                if (!empty($rescter_discr)) {
                    ?>
                    <p>
                        <?php echo esc_html($rescter_discr) ?>
                    </p>
                <?php } ?>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="logos_img">
                <?php if (!empty($img)) {
                    ?>
                    <img src="<?php echo esc_url_raw($img) ?>" alt="img">
                <?php } ?>
            </div>
        </div>
    </div>
    </div>
    </section>
    
    <?php

    return ob_get_clean();
}
add_shortcode('over_recruite_hnin', 'over_recruite_hnin_frontend');