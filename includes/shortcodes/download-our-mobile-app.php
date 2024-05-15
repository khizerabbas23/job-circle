<?php
function jobcircle_download_our_app()
{
    vc_map(
        array(
            'name' => __('Download Our Mobile App'),
            'base' => 'jc_download_our_app',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title'),
                    'param_name' => 'title',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Description'),
                    'param_name' => 'desc',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Playstore Image Url'),
                    'param_name' => 'ply_img_url',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Playstore Image'),
                    'param_name' => 'ply_img',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Apple Image Url'),
                    'param_name' => 'apple_img_url',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Apple Image'),
                    'param_name' => 'apple_img',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Image'),
                    'param_name' => 'img1',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Image'),
                    'param_name' => 'img2',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Image'),
                    'param_name' => 'img3',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Image'),
                    'param_name' => 'img4',
                ),
            ),
        )
    );
}
add_action('vc_before_init', 'jobcircle_download_our_app');
function jobcircle_download_our_app_frontend($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'title' => '',
            'desc' => '',
            'ply_img_url' => '',
            'ply_img' => '',
            'apple_img_url' => '',
            'apple_img' => '',
            'img1' => '',
            'img2' => '',
            'img3' => '',
            'img4' => '',
        ),
        $atts,
        'jobcircle_download_our_app'
    );
    $title = isset($atts['title']) ? $atts['title'] : '';
    $desc = isset($atts['desc']) ? $atts['desc'] : '';
    $ply_img_url = isset($atts['ply_img_url']) ? $atts['ply_img_url'] : '';
    $ply_img = isset($atts['ply_img']) ? $atts['ply_img'] : '';
    $apple_img_url = isset($atts['apple_img_url']) ? $atts['apple_img_url'] : '';
    $apple_img = isset($atts['apple_img']) ? $atts['apple_img'] : '';
    $img1 = isset($atts['img1']) ? $atts['img1'] : '';
    $img2 = isset($atts['img2']) ? $atts['img2'] : '';
    $img3 = isset($atts['img3']) ? $atts['img3'] : '';
    $img4 = isset($atts['img4']) ? $atts['img4'] : '';
    ob_start();
    ?>
    <section class="section section-theme-2 section-downloads pt-35 pt-md-30 pb-50 pb-md-75 pb-lg-75 pb-xl-110 pb-xxl-150">
        <div class="container">
            <!-- Section header -->
            <header class="section-header text-center mb-30 mb-md-40 mb-lg-50">
                <?php if (!empty($title)) {
                    ?>
                    <h2>
                        <?php echo esc_html($title) ?>
                    </h2>
                    <?php
                }  
                if (!empty($desc)) {
                    ?>
                    <p>
                        <?php echo ($desc) ?>
                    </p>
                    <?php
                } ?>
            </header>
            <div class="app-buttons">
                <?php if (!empty($ply_img_url) || !empty($ply_img)) {
                    ?>
                    <a href="<?php echo esc_html($ply_img_url) ?>"><img src="<?php echo esc_url_raw($ply_img) ?>"
                            alt="Google Play"></a>
                    <?php
                } ?>
                <?php if (!empty($apple_img_url) || !empty($apple_img)) {
                    ?>
                    <a href="<?php echo esc_html($apple_img_url) ?>"><img src="<?php echo esc_url_raw($apple_img) ?>"
                            alt="App Store"></a>
                    <?php
                } ?>
            </div>
            <?php if (!empty($img1)) {
                ?>
                <div class="icon ico01"><img src="<?php echo esc_url_raw($img1) ?>" alt="Image Description">
                </div>
                <?php
            } ?>
            <?php if (!empty($img2)) {
                ?>
                <div class="icon ico02"><img src="<?php echo esc_url_raw($img2) ?>" alt="Image Description">
                </div>
                <?php
            } ?>
            <?php if (!empty($img3)) {
                ?>
                <div class="icon ico03"><img src="<?php echo esc_url_raw($img3) ?>" alt="Image Description">
                </div>
                <?php
            } ?>
            <?php if (!empty($img4)) {
                ?>
                <div class="icon ico04"><img src="<?php echo esc_url_raw($img4) ?>" alt="Image Description">
                </div>
                <?php
            } ?>
        </div>
    </section>
    <?php
    ?>
    <?php

    return ob_get_clean();
}

add_shortcode('jc_download_our_app', 'jobcircle_download_our_app_frontend');