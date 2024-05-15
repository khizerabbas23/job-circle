<?php
function jobcircle_home_four_banner(){
    vc_map(
        array(
            'name' => __('theme4'),
            'base' => 'jc_home_four_banner',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Search Job'),
                    'param_name' => 'srch_jb',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Short Description'),
                    'param_name' => 'shrt_disc',
                ),
                array(
                    'type' => 'attach_image',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Main Image'),
                    'param_name' => 'mn_img',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Job Button'),
                    'param_name' => 'jb_btn',
                ),

                //Group
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'multi_section',
                    'params' => array(


                        array(
                            'type' => 'attach_image',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Image'),
                            'param_name' => 'img',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Title'),
                            'param_name' => 'title',
                        ),


                    ),
                ),
            ),
        )
    );
}
add_action('vc_before_init', 'jobcircle_home_four_banner');


// Frontend Coding 

function jobcircle_home_four_banner_front($atts, $content)
{

    $atts = shortcode_atts(
        array(

            'srch_jb' => '',
            'shrt_disc' => '',
            'mn_img' => '',
            'jb_btn' => '',


            'multi_section' => '',

        ), $atts, 'jobcircle_home_four_banner'
    );

    $srch_jb = isset($atts['srch_jb']) ? $atts['srch_jb'] : '';
    $shrt_disc = isset($atts['shrt_disc']) ? $atts['shrt_disc'] : '';
    $mn_img = wp_get_attachment_image_src($atts["mn_img"], 'full');
    $jb_btn = isset($atts['jb_btn']) ? $atts['jb_btn'] : '';

    ob_start();
    ?>
    <div class="visual-block visal-theme-4 pt-100 pt-md-140 pt-xl-160 pb-45 pb-md-80 pb-lg-160">
        <div class="container position-relative">
            <div class="row justify-content-between">
                <div class="col-12 col-lg-7 col-xl-6">
                    <!-- visual textbox -->
                    <div class="visual-textbox text-white">
                        <?php if (!empty($srch_jb)) {
                            ?>
                            <p>
                                <?php jobcircle_esc_the_html($srch_jb) ?>
                            </p>
                        <?php } ?>
                        <?php if (!empty($shrt_disc)) {
                            ?>
                            <h1>
                                <?php echo nl2br($shrt_disc); ?>
                            </h1>
                        <?php } ?>
                        <!-- search form -->
                        <form class="form-search d-flex flex-column flex-lg-row justify-content-between" action="#">
                            <div class="fields-holder bg-white text-black d-flex flex-wrap flex-md-nowrap">
                                <div class="form-group">
                                    <i class="icon icon-search"></i>
                                    <input class="form-control" type="search" placeholder="Search Job Title">
                                </div>
                                <div class="form-group">
                                    <i class="form-jin"><img src="<?php echo Jobcircle_Plugin::root_url()?>/images/bars.png" width = "20" alt ="category icon"></i>
                                    <select class="select2" name="state" data-placeholder="Select Country">
                                        <option>
                                            <?php echo esc_html_e('All Locations', 'jobcircle-frame') ?>
                                        </option>
                                        <option value="AF">
                                            <?php echo esc_html_e('Afghanistan', 'jobcircle-frame') ?>
                                        </option>
                                        <option value="AX">
                                            <?php echo esc_html_e('Aland Islands', 'jobcircle-frame') ?>
                                        </option>
                                        <option value="AL">
                                            <?php echo esc_html_e('Albania', 'jobcircle-frame') ?>
                                        </option>
                                        <option value="DZ">
                                            <?php echo esc_html_e('Algeria', 'jobcircle-frame') ?>
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <button class="btn btn-sm" type="submit">
                                <?php if (!empty($jb_btn)) {
                                    ?>
                                    <span class="btn-text">
                                        <?php jobcircle_esc_the_html($jb_btn); ?>
                                    </span>
                                <?php } ?>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="col-12 col-lg-5 col-xl-6">
                    <?php if (!empty($mn_img)) {
                        ?>
                        <div class="image-holder"><img src="<?php echo esc_url_raw($mn_img[0]) ?>" alt="image"></div>
                    <?php } ?>
                </div>
            </div>
            <div class="row justify-content-center mt-30 mt-lg-50">
                <?php
                $lm_team_list = vc_param_group_parse_atts($atts['multi_section']);

                foreach ($lm_team_list as $key => $value) {

                    $title = isset($value["title"]) ? $value["title"] : '';
                    $img = wp_get_attachment_image_src($value["img"], 'full');

                    ?>
                    <div class="col-12 col-sm-6 col-xl-4">
                        <div class="feature-frame mb-20 mb-xl-0">
                            <?php if (!empty($img)) {
                                ?>
                                <img src="<?php echo esc_url_raw($img[0]) ?>" alt="icon">
                            <?php } ?>
                            <?php if (!empty($title)) {
                                ?>
                                <p>
                                    <?php jobcircle_esc_the_html($title); ?>
                                </p>
                            <?php }

                            ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
    <?php
    $html = ob_get_clean();
    return $html;
}
add_shortcode('jc_home_four_banner', 'jobcircle_home_four_banner_front');