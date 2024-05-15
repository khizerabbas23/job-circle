<?php
function jobcircle_mobile_app()
{
    vc_map(

        array(
            'name' => __('Mobile App'),
            'base' => 'job_cirle_mobile_app',
            'category' => __('Job Circle'),
            'params' => array(

                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Heading'),
                    'param_name' => 'head',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Description'),
                    'param_name' => 'para',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Playstore Link'),
                    'param_name' => 'ply_link',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Playstore image'),
                    'param_name' => 'ply_img',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Apple link'),
                    'param_name' => 'apl_link',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Apple image'),
                    'param_name' => 'apl_img',
                ),

                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('playstore '),
                    'param_name' => 'play_img',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Apple image'),
                    'param_name' => 'apple_img',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Ico image'),
                    'param_name' => 'ico_img',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Mail image'),
                    'param_name' => 'mail_img',
                ),




            ),
        )
    );
}
add_action('vc_before_init', 'jobcircle_mobile_app');
function jobcircle_mobile_app_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(
            'head' => '',
            'para' => '',
            'ply_link' => '',
            'ply_img' => '',
            'apl_link' => '',
            'apl_img' => '',
            'play_img' => '',
            'apple_img' => '',
            'ico_img' => '',
            'mail_img' => '',

        ),
        $atts,
        'jobcircle_mobile_app'
    );

    $head = isset($atts['head']) ? $atts['head'] : '';
    $para = isset($atts['para']) ? $atts['para'] : '';
    $ply_link = isset($atts['ply_link']) ? $atts['ply_link'] : '';
    $ply_img = isset($atts['ply_img']) ? $atts['ply_img'] : '';
    $apl_link = isset($atts['apl_link']) ? $atts['apl_link'] : '';
    $apl_img = isset($atts['apl_img']) ? $atts['apl_img'] : '';
    $play_img = isset($atts['play_img']) ? $atts['play_img'] : '';
    $apple_img = isset($atts['apple_img']) ? $atts['apple_img'] : '';
    $ico_img = isset($atts['ico_img']) ? $atts['ico_img'] : '';
    $mail_img = isset($atts['mail_img']) ? $atts['mail_img'] : '';

    ob_start();
    ?>
    <section class="section section-theme-1 section-downloads pt-35 pt-md-0 pb-50 pb-md-75 pb-lg-75 pb-xl-110 pb-xxl-150">
        <div class="container">
            <header class="section-header text-center mb-30 mb-md-40 mb-lg-50">
                <?php
                if (!empty($head)) {
                    ?>
                    <h2>
                        <?php echo esc_html($head) ?>
                    </h2>
                    <?php
                } ?>
                <?php
                if (!empty($para)) {
                    ?>
                    <p>
                        <?php echo ($para) ?>
                    </p>
                    <?php
                } ?>
            </header>
            <div class="app-buttons">
                <?php
                if (!empty($ply_link) || !empty($ply_img)) {
                    ?>
                    <a href="<?php echo esc_html($ply_link) ?>"><img src="<?php echo esc_url_raw($ply_img) ?>"
                            alt="Google Play"></a>
                    <?php
                } ?>
                <?php
                if (!empty($apl_link) || !empty($apl_img)) {
                    ?>
                    <a href="<?php echo esc_html($apl_link) ?>"><img src="<?php echo esc_url_raw($apl_img) ?>"
                            alt="App Store"></a>
                    <?php
                } ?>
            </div>
            <?php
            if (!empty($play_img)) {
                ?>
                <div class="icon ico01"><img src="<?php echo esc_url_raw($play_img) ?>" alt="Image Description"></div>
                <?php
            } ?>
            <?php
            if (!empty($ico_img)) {
                ?>
                <div class="icon ico02"><img src="<?php echo esc_url_raw($ico_img) ?> " alt="Image Description"></div>
                <?php
            } ?>
            <?php
            if (!empty($apple_img)) {
                ?>
                <div class="icon ico03"><img src="<?php echo esc_url_raw($apple_img) ?>" alt="Image Description"></div>
                <?php
            } ?>
            <?php
            if (!empty($mail_img)) {
                ?>
                <div class="icon ico04"><img src="<?php echo esc_url_raw($mail_img) ?>" alt="Image Description"></div>
                <?php
            } ?>
        </div>
    </section>

    <?php
    return ob_get_clean();
}

add_shortcode('job_cirle_mobile_app', 'jobcircle_mobile_app_frontend');