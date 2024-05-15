<?php
function jobcircle_banner_h_eleven()
{
    vc_map(
        array(
            'name' => __('Home Eleven Banner'),
            'base' => 'jc_banner_h_eleven',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Upload Image'),
                    'param_name' => 'upld_img',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Background Image'),
                    'param_name' => 'bg_img',
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
                    'heading' => __('Sub Title'),
                    'param_name' => 'sb_title',
                ),

                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Sub Title'),
                    'param_name' => 'sb_titl',
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
                    'heading' => __('Button Text'),
                    'param_name' => 'work_btn',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Button Url'),
                    'param_name' => 'work_url',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Button Text'),
                    'param_name' => 'talent_btn',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Button Url'),
                    'param_name' => 'talent_url',
                ),
            )
        )
    );

}
add_action('vc_before_init', 'jobcircle_banner_h_eleven');

//welcome Massage frontend
function jobcircle_banner_h_eleven_frontend($atts, $content)
{
    $atts = shortcode_atts(
        array(

            'title' => '',
            'sb_title' => '',
            'sb_titl' => '',
            'desc' => '',
            'work_btn' => '',
            'work_url' => '',
            'talent_btn' => '',
            'talent_url' => '',
            'bg_img' => '',
            'upld_img' => '',

        ),
        $atts,
        'jobcircle_banner_h_eleven'
    );
    $title = isset($atts['title']) ? $atts['title'] : '';
    $sb_title = isset($atts['sb_title']) ? $atts['sb_title'] : '';
    $sb_titl = isset($atts['sb_titl']) ? $atts['sb_titl'] : '';
    $desc = isset($atts['desc']) ? $atts['desc'] : '';
    $work_btn = isset($atts['work_btn']) ? $atts['work_btn'] : '';
    $work_url = isset($atts['work_url']) ? $atts['work_url'] : '';
    $talent_btn = isset($atts['talent_btn']) ? $atts['talent_btn'] : '';
    $talent_url = isset($atts['talent_url']) ? $atts['talent_url'] : '';
    $bg_img = isset($atts['bg_img']) ? $atts['bg_img'] : '';
    $upld_img = isset($atts['upld_img']) ? $atts['upld_img'] : '';

    ob_start();
    ?>
    <?php if (!empty($bg_img)) { ?>
        <div class="visual-block visal-theme-6 pt-120 pt-md-140 pt-xl-160 pb-20 pb-md-70"
            style="background-image: url('<?php echo esc_url_raw($bg_img) ?>');">
        <?php } ?>
        <div class="container position-relative">
            <div class="row align-items-center justify-content-between">
                <div class="col-12 col-lg-7 col-xl-6">
                    <!-- visual textbox -->
                    <div class="visual-textbox text-black">
                        <?php
                        if (!empty($title) || !empty($sb_title) || !empty($sb_titl)) { ?>
                            <h1>
                                <?php echo jobcircle_esc_the_html($title) ?><br>
                                <?php echo jobcircle_esc_the_html($sb_title) ?><br>
                                <?php echo jobcircle_esc_the_html($sb_titl) ?>
                            </h1>
                        <?php } ?>
                        <?php if (!empty($desc)) { ?>
                            <p>
                                <?php echo $desc; ?>
                            </p>
                        <?php } ?>
                        <div class="buttons-block pt-10 pb-30 pt-lg-50">
                            <?php if (!empty($work_url) || !empty($work_btn)) {
                                ?>
                                <a href="<?php echo jobcircle_esc_the_html($work_url) ?>"><button class="btn"><span>
                                            <?php echo jobcircle_esc_the_html($work_btn) ?>
                                        </span></button></a>
                                <?php
                            } ?>
                            <?php if (!empty($talent_url) || !empty($talent_btn)) {
                                ?>
                                <a href="<?php echo jobcircle_esc_the_html($talent_url) ?>"><button class="btn btn-gray"><span>
                                            <?php echo jobcircle_esc_the_html($talent_btn) ?>
                                        </span></button></a>
                                <?php
                            } ?>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-5 col-xl-6">
                    <div class="image-holder">
                        <?php if (!empty($upld_img)) { ?>
                            <img src="<?php echo esc_url_raw($upld_img) ?>" alt="image">
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('jc_banner_h_eleven', 'jobcircle_banner_h_eleven_frontend');