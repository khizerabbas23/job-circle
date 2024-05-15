<?php
function jobcircle_main_banner()
{
    vc_map(
        array(
            'name' => __('Home Eight Banner'),
            'base' => 'jc_main_banner',
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
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Span Title'),
                    'param_name' => 'spn_title',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Descripton'),
                    'param_name' => 'desc',
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
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title'),
                    'param_name' => 'min_title',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Avatar Image'),
                    'param_name' => 'img1',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Avatar Image'),
                    'param_name' => 'img2',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Avatar Image'),
                    'param_name' => 'img3',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Avatar Image'),
                    'param_name' => 'img4',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Banner Image'),
                    'param_name' => 'bg_imgs',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Banner Image'),
                    'param_name' => 'bg_imgs2',
                ),
            ),
        )
    );
}
add_action('vc_before_init', 'jobcircle_main_banner');
function jobcircle_main_banner_frontend($atts, $content)
{
global $jobcircle_framework_options;
    $atts = shortcode_atts(
        array(

            'title' => '',
            'spn_title' => '',
            'desc' => '',
            'btn_url' => '',
            'btn_txt' => '',
            'min_title' => '',
            'img1' => '',
            'img2' => '',
            'img3' => '',
            'img4' => '',
            'bg_imgs' => '',
            'bg_imgs2' => '',

        ),
        $atts,
        'jobcircle_main_banner'
    );

    $title = isset($atts['title']) ? $atts['title'] : '';
    $spn_title = isset($atts['spn_title']) ? $atts['spn_title'] : '';
    $desc = isset($atts['desc']) ? $atts['desc'] : '';
    $btn_url = isset($atts['btn_url']) ? $atts['btn_url'] : '';
    $btn_txt = isset($atts['btn_txt']) ? $atts['btn_txt'] : '';
    $min_title = isset($atts['min_title']) ? $atts['min_title'] : '';
    $img1 = isset($atts['img1']) ? $atts['img1'] : '';
    $img2 = isset($atts['img2']) ? $atts['img2'] : '';
    $img3 = isset($atts['img3']) ? $atts['img3'] : '';
    $img4 = isset($atts['img4']) ? $atts['img4'] : '';
    $bg_imgs = isset($atts['bg_imgs']) ? $atts['bg_imgs'] : '';
    $bg_imgs2 = isset($atts['bg_imgs2']) ? $atts['bg_imgs2'] : '';

    ob_start();
    ?>

    <div class="visual-block visual-theme-8 bg-light-sky text-black pt-45 pt-md-70 pt-xl-100 pb-45 pb-md-50 pb-lg-50">
        <div class="container position-relative">
            <div class="row align-items-center justify-content-between">
                <div class="col-12 col-lg-5 col-xl-5 position-relative">
                    <!-- visual textbox -->
                    <div class="visual-textbox">

                        <h1>
                            <?php if (!empty($title) || !empty($spn_title)) {
                                ?>
                                <?php echo esc_html($title) ?><span class="text-outlined"><br>
                                    <?php echo esc_html($spn_title) ?>
                                </span>
                                <?php
                            } ?>
                        </h1>

                        <?php if (!empty($desc)) {
                            ?>
                            <p class="banner-themep">
                                <?php echo esc_textarea($desc) ?>
                            </p>
                            <?php
                        } 
                        $job_select_page = isset($jobcircle_framework_options['job_select_page']) ? $jobcircle_framework_options['job_select_page'] : '';
						$job_select_page_id = jobcircle_get_page_id_from_name($job_select_page);
						$job_select_page_url = get_permalink($job_select_page_id);
						?>
                        <!-- search form -->
                        <form class="form-search" action="<?php echo esc_url($job_select_page_url); ?>" method="get">
                            <div class="fields-holder bg-white text-black d-flex flex-wrap flex-md-nowrap">
                              <div class="form-group">
									<i class="jobcircle-icon-search icon"></i>
									<input class="form-control" type="search" name="keyword"
										placeholder="<?php esc_html_e('Search Job Title', 'jobcircle-frame') ?>">
								</div>
                            </div>
                            <?php if (!empty($btn_url) || !empty($btn_txt)) {
                                ?>
                                <button class="btn btn-orange btn-sm" href="<?php echo esc_html($btn_url) ?>"
                                    type="submit"><span class="btn-text">
                                        <?php echo esc_html($btn_txt) ?>
                                    </span></button>
                                <?php
                            } ?>
                        </form>
                        <!-- users box -->
                        <div class="users-box">
                            <?php if (!empty($min_title)) {
                                ?>
                                <strong class="title">
                                    <?php echo esc_html($min_title) ?>
                                </strong>
                                <?php
                            } ?>
                            <?php if (!empty($img1) || !empty($img2) || !empty($img3) || !empty($img4)) {
                                ?>
                                <ul class="users-list">
                                    <?php if (!empty($img1)) { ?>
                                        <li><img src="<?php echo esc_url_raw($img1) ?>" width="60" height="60" alt="User"></li>
                                    <?php }
                                    if (!empty($img1)) { ?>
                                        <li><img src="<?php echo esc_url_raw($img2) ?>" width="60" height="60" alt="User"></li>
                                    <?php }
                                    if (!empty($img1)) { ?>
                                        <li><img src="<?php echo esc_url_raw($img3) ?>" width="60" height="60" alt="User"></li>
                                    <?php }
                                    if (!empty($img1)) { ?>
                                        <li><img src="<?php echo esc_url_raw($img4) ?>" width="60" height="60" alt="User"></li>
                                    <?php } ?>
                                    <li><i class="jobcircle-icon-plus"></i></li>
                                </ul>
                                <?php
                            } ?>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-7 col-xl-7 d-flex justify-content-center justify-content-lg-end">
                    <!-- visual Image -->
                    <div class="visual-image position-relative">
                        <div class="image-holder">
                            <?php if (!empty($bg_imgs)) {
                                ?>
                                <img src="<?php echo esc_url_raw($bg_imgs) ?>" width="340" height="520"
                                    alt="Find your Job without any hassle">
                                <?php
                            } ?>
                        </div>
                        <div class="image-holder">
                            <?php if (!empty($bg_imgs2)) {
                                ?>
                                <img src="<?php echo esc_url_raw($bg_imgs2) ?>" width="340" height="520" alt="Jobcircle">
                                <?php
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    return ob_get_clean();
}

add_shortcode('jc_main_banner', 'jobcircle_main_banner_frontend');