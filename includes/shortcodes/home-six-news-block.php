<?php
function jobcircle_home_six_news_block()
{
    vc_map(
        array(
            'name' => __('Home Six News Blocks'),
            'base' => 'jc_home_six_news_block',
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
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('heading'),
                    'param_name' => 'head',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Button'),
                    'param_name' => 'bttn',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Button Url'),
                    'param_name' => 'bttn_url',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Feature List'),
                    'param_name' => 'feature_list',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Bcak Image'),
                    'param_name' => 'back_img',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Upper Right Image'),
                    'param_name' => 'upr_right_img',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Lower Left Image'),
                    'param_name' => 'lwr_left_img',
                ),
            ),
        )
    );
}
add_action('vc_before_init', 'jobcircle_home_six_news_block');
function jobcircle_home_six_news_block_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(
            'title' => '',
            'head' => '',
            'bttn' => '',
            'feature_list' => '',
            'back_img' => '',
            'upr_right_img' => '',
            'lwr_left_img' => '',
            'bttn_url' => '',
        ),
        $atts,
        'jobcircle_home_six_news_block'
    );

    $title = isset($atts['title']) ? $atts['title'] : '';
    $head = isset($atts['head']) ? $atts['head'] : '';
    $bttn = isset($atts['bttn']) ? $atts['bttn'] : '';
    $feature_list = isset($atts['feature_list']) ? $atts['feature_list'] : '';
    $back_img = isset($atts['back_img']) ? $atts['back_img'] : '';
    $upr_right_img = isset($atts['upr_right_img']) ? $atts['upr_right_img'] : '';
    $lwr_left_img = isset($atts['lwr_left_img']) ? $atts['lwr_left_img'] : '';
    $bttn_url = isset($atts['bttn_url']) ? $atts['bttn_url'] : '';
    
    ob_start();
    ?>

    <section class="section section-theme-3 section-experts pt-15px pt-md-30 pb-35 pb-md-50 pb-lg-65 pb-xl-85 pb-xxl-110">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="matched-jobs-block">
                        <div class="section-header">
                            <?php
                            if (!empty($title)) {
                                ?>
                                <h1>
                                    <?php echo esc_html($title); ?>
                                </h1>
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
                            <?php
                            if (!empty($bttn) && !empty($bttn_url)) {
                                ?>
                                <a href="<?php echo esc_html($bttn_url) ?>" class="btn btn-brown btn-sm"><span class="btn-text">
                                        <?php echo esc_html($bttn); ?>
                                    </span></a>
                                <?php
                            }
                            ?>
                            <ul class="list-unstyled features-list">
                                <?php
                                if (!empty($feature_list)) {
                                    ?>
                                    <li>
                                        <?php echo esc_html($feature_list); ?>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="image-holder">
                            <div class="image-wrap">
                                <?php
                                if (!empty($back_img)) {
                                    ?>
                                    <img src="<?php echo esc_url_raw($back_img); ?>" width="568" height="563"
                                        alt="Image Description">
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="img-info">
                                <?php
                                if (!empty($upr_right_img)) {
                                    ?>
                                    <img src="<?php echo esc_url_raw($upr_right_img); ?>" width="328" height="221"
                                        alt="Image Description">
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="img-graph">
                                <?php
                                if (!empty($lwr_left_img)) {
                                    ?>
                                    <img src="<?php echo esc_url_raw($lwr_left_img); ?>" width="208" height="191"
                                        alt="Image Description">
                                    <?php
                                }
                                ?>
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
add_shortcode('jc_home_six_news_block', 'jobcircle_home_six_news_block_frontend');