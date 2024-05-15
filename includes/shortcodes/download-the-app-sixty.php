<?php
function jobcircle_download_app()
{
    vc_map(
        array(
            'name' => __('Download Mobile App S'),
            'base' => 'jobcircle_download_app',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Add Image'),
                    'param_name' => 'add_img',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Outline'),
                    'param_name' => 'outline',
                ),
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
                    'heading' => __('Upload Image'),
                    'param_name' => 'upld_img',
                ),
            ),
        )
    );
}
add_action('vc_before_init', 'jobcircle_download_app');
function jobcircle_download_app_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(
            'outline' => '',
            'title' => '',
            'desc' => '',
            'ply_img_url' => '',
            'ply_img' => '',
            'apple_img_url' => '',
            'apple_img' => '',
            'upld_img' => '',
            'add_img' => '',




        ),
        $atts,
        'jobcircle_download_app'
    );

    $title = isset($atts['title']) ? $atts['title'] : '';
    $outline = isset($atts['outline']) ? $atts['outline'] : '';
    $desc = isset($atts['desc']) ? $atts['desc'] : '';
    $ply_img_url = isset($atts['ply_img_url']) ? $atts['ply_img_url'] : '';
    $ply_img = isset($atts['ply_img']) ? $atts['ply_img'] : '';
    $apple_img_url = isset($atts['apple_img_url']) ? $atts['apple_img_url'] : '';
    $apple_img = isset($atts['apple_img']) ? $atts['apple_img'] : '';
    $upld_img = isset($atts['upld_img']) ? $atts['upld_img'] : '';
    $add_img = isset($atts['add_img']) ? $atts['add_img'] : '';



    ob_start();
    ?>
    <section class="apps-block section-theme-12 pb-60 pt-30">
        <div class="container">
            <?php
            if (!empty($add_img)) {
                ?>
                <div class="row align-items-center" style="background-image: url(<?php echo esc_url_raw($add_img); ?>)">
                    <?php
            }
            ?>
                <div class="col-12 col-md-6 col-lg-5">
                    <div class="text">
                        <?php
                        if (!empty($outline)) {
                            ?>
                            <span>
                                <?php echo esc_html($outline); ?>
                            </span>
                            <?php
                        } ?>
                        <?php
                        if (!empty($title)) {
                            ?>
                            <h2 class="showhead">
                                <?php echo esc_html($title); ?>
                            </h2>
                            <?php
                        }
                        ?>
                        <?php
                        if (!empty($desc)) {
                            ?>
                            <p>
                                <?php echo esc_textarea($desc); ?>
                            </p>
                            <?php
                        }
                        ?>
                        <div class="download-btns">
                            <?php
                            if (!empty($ply_img_url) || !empty($ply_img)) {
                                ?>
                                <a href="<?php echo esc_html($ply_img_url); ?>"><img src="<?php echo esc_url_raw($ply_img); ?>"
                                        alt="google"></a>
                                <?php
                            }
                            ?>
                            <?php
                            if (!empty($apple_img_url) || !empty($apple_img)) {
                                ?>
                                <a href="<?php echo esc_html($apple_img_url); ?>"><img
                                        src="<?php echo esc_url_raw($apple_img); ?>" alt="apple"></a>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-7">
                    <div class="image-holder d-flex justify-content-center">
                        <?php
                        if (!empty($upld_img)) {
                            ?>
                            <img src="<?php echo esc_url_raw($upld_img); ?>" alt="image">
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
    ?>

    <?php
    return ob_get_clean();
}

add_shortcode('jobcircle_download_app', 'jobcircle_download_app_frontend');