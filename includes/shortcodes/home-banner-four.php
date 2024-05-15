<?php
function jobcircle_home4_banner()
{
    vc_map(
        array(
            'name' => __('Home Banner 4'),
            'base' => 'jc_home4_banner',
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
                    'type' => 'jobcircle_browse_img',
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
                            'type' => 'jobcircle_browse_img',
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
add_action('vc_before_init', 'jobcircle_home4_banner');
// Frontend Coding 
function jobcircle_home4_banner_front($atts, $content)
{
    	global $jobcircle_framework_options;
    $atts = shortcode_atts(
        array(

            'srch_jb' => '',
            'shrt_disc' => '',
            'mn_img' => '',
            'jb_btn' => '',

            'multi_section' => '',

        ), $atts, 'jobcircle_home4_banner'
    );

    $srch_jb = isset($atts['srch_jb']) ? $atts['srch_jb'] : '';
    $shrt_disc = isset($atts['shrt_disc']) ? $atts['shrt_disc'] : '';
    $jb_btn = isset($atts['jb_btn']) ? $atts['jb_btn'] : '';
    $mn_img = isset($atts['mn_img']) ? $atts['mn_img'] : '';
    ob_start();
    ?>
    <div class="visual-theme-4 pt-100 pt-md-140 pt-xl-160 pb-45 pb-md-80 pb-lg-160">
        <div class="container position-relative">
            <div class="row justify-content-between">
                <div class="col-12 col-lg-7 col-xl-6">
                    <!-- visual textbox -->
                    <div class="visual-textbox text-white">
                        <?php if (!empty($srch_jb)) {
                            ?>
                            <p>
                                <?php echo esc_html($srch_jb) ?>
                            </p>
                        <?php } ?>
                        <?php if (!empty($shrt_disc)) {
                            ?>
                            <h1>
                                <?php echo ($shrt_disc); ?>
                            </h1>
                        <?php } 
                        $job_select_page = isset($jobcircle_framework_options['job_select_page']) ? $jobcircle_framework_options['job_select_page'] : '';
						$job_select_page_id = jobcircle_get_page_id_from_name($job_select_page);
						$job_select_page_url = get_permalink($job_select_page_id);
						?>
                        <!-- search form -->
                        <form class="form-search d-flex flex-column flex-lg-row justify-content-between" action="<?php echo esc_url($job_select_page_url); ?>" method="get">
                            <div class="fields-holder bg-white text-black d-flex flex-wrap flex-md-nowrap">
                                	<div class="form-group">
									<i class="jobcircle-icon-search icon"></i>
									<input class="form-control" type="search" name="keyword"
										placeholder="<?php esc_html_e('Search Job Title') ?>">

								</div>
                                <div class="form-group">
                       	<span class="icon mt-10"><img src="<?php echo Jobcircle_Plugin::root_url()?>/images/bars.png" width = "20" alt ="category icon"></span>
                                   <select class="select2" name="job_category"
										data-placeholder="<?php esc_html_e('Choose Category', 'jobcircle-frame') ?>">
										<option label="Placeholder"></option>
										<?php
										$cat_terms = get_terms(
											array(
												'taxonomy' => 'job_category',
											)
										);
										if (!empty($cat_terms)) {
											foreach ($cat_terms as $cat_term) {
												?>
												<option value="<?php echo esc_html($cat_term->slug) ?>"
													id="cat-<?php echo esc_html($cat_term->term_id) ?>">
													<?php echo esc_attr($cat_term->name) ?>
												</option>
												<?php
											}
											;
										}
										?>
									</select>
                                </div>
                            </div>
                            <button class="btn btn-sm" type="submit">
                                <?php if (!empty($jb_btn)) {
                                    ?>
                                    <span class="btn-text">
                                        <?php echo esc_html($jb_btn); ?>
                                    </span>
                                <?php } ?>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="col-12 col-lg-5 col-xl-6">
                    <?php if (!empty($mn_img)) {
                        ?>
                        <div class="image-holder"><img src="<?php echo esc_url_raw($mn_img) ?>" alt="image"></div>
                    <?php } ?>
                </div>
            </div>
            <div class="row justify-content-center mt-30 mt-lg-50">
                <?php
                $lm_team_list = vc_param_group_parse_atts($atts['multi_section']);
                foreach ($lm_team_list as $key => $value) {

                    $title = isset($value["title"]) ? $value["title"] : '';
                    $img = isset($value["img"]) ? $value["img"] : '';

                    ?>
                    <div class="col-12 col-sm-6 col-xl-4">
                        <div class="feature-frame mb-20 mb-xl-0">
                            <?php if (!empty($img)) {
                                ?>
                                <img src="<?php echo esc_url_raw($img) ?>" alt="icon">
                            <?php } ?>
                            <?php if (!empty($title)) {
                                ?>
                                <p>
                                    <?php echo esc_html($title); ?>
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
add_shortcode('jc_home4_banner', 'jobcircle_home4_banner_front');