<?php
function jobcircle_banner_three()
{
    vc_map(
        array(
            'name' => __('Home Three banner'),
            'base' => 'jc_banner_three',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Background Image'),
                    'param_name' => 'bgrd_img',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title'),
                    'param_name' => 'titl',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Sub Title'),
                    'param_name' => 'sub_title',
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
                    'param_name' => 'btn_text',
                ),
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
                    'heading' => __('Candidate Image'),
                    'param_name' => 'can_img',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Candidate Image'),
                    'param_name' => 'can_img_o',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Candidate Image'),
                    'param_name' => 'can_img_s',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Candidate Image'),
                    'param_name' => 'can_img_t',
                ),
            ),
        )
    );
}
add_action('vc_before_init', 'jobcircle_banner_three');
function jobcircle_banner_three_frontend($atts, $content)
{
	global $jobcircle_framework_options;
    $atts = shortcode_atts(
        array(

            'bgrd_img' => '',
            'titl' => '',
            'sub_title' => '',
            'desc' => '',
            'btn_text' => '',
            'upld_img' => '',
            'can_img' => '',
            'can_img_o' => '',
            'can_img_s' => '',
            'can_img_t' => '',

        ),
        $atts,
        'jobcircle_banner_three'
    );

    $bgrd_img = isset($atts['bgrd_img']) ? $atts['bgrd_img'] : '';
    $titl = isset($atts['titl']) ? $atts['titl'] : '';
    $sub_title = isset($atts['sub_title']) ? $atts['sub_title'] : '';
    $desc = isset($atts['desc']) ? $atts['desc'] : '';
    $upld_img = isset($atts['upld_img']) ? $atts['upld_img'] : '';
    $can_img = isset($atts['can_img']) ? $atts['can_img'] : '';
    $can_img_o = isset($atts['can_img_o']) ? $atts['can_img_o'] : '';
    $can_img_s = isset($atts['can_img_s']) ? $atts['can_img_s'] : '';
    $can_img_t = isset($atts['can_img_t']) ? $atts['can_img_t'] : '';
    $btn_text = isset($atts['btn_text']) ? $atts['btn_text'] : '';

    ob_start();
    ?>
    <style>
        .visal-theme-2 {

            background-image: url(<?php echo ($bgrd_img);
            ?>);
        }
    </style>

    <div class="visual-block visual-theme-2 bg-dark-blue pt-100 pt-md-140 pt-xl-180 pb-45 pb-md-80 pb-lg-60 text-white">
        <div class="container position-relative">
            <div class="row justify-content-between">
                <div class="col-12 col-lg-7 col-xl-6 position-relative">
                    <!-- visual textbox -->
                    <div class="visual-textbox">
                        <?php
                        if (!empty($titl) || !empty($sub_title)) {
                            ?>
                            <h1>
                                <?php echo esc_html($titl); ?><span class="text-outlined">
                                    <?php echo esc_html($sub_title); ?>
                                </span>
                            </h1>

                        <?php } ?>
                        <?php
                        if (!empty($desc)) {
                            ?>
                            <p>
                                <?php echo esc_textarea($desc); ?>
                            </p>

                        <?php } 
                    	$job_select_page = isset($jobcircle_framework_options['job_select_page']) ? $jobcircle_framework_options['job_select_page'] : '';
						$job_select_page_id = jobcircle_get_page_id_from_name($job_select_page);
						$job_select_page_url = get_permalink($job_select_page_id);?>
                        <!-- search form -->
                        <form class="form-search" action="<?php echo esc_url($job_select_page_url); ?>" method="get">
                            <div class="fields-holder bg-white text-black d-flex flex-wrap flex-md-nowrap">
                                <div class="form-group">
									<i class="jobcircle-icon-search icon"></i>
									<input class="form-control" type="search" name="keyword"
										placeholder="<?php esc_html_e('Search Job Title', 'jobcircle-frame') ?>">

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
                            <?php
                            if (!empty($btn_text)) {
                                ?>
                                <button class="btn btn-dark-yellow btn-sm" type="submit"><span class="btn-text">
                                        <?php echo esc_html($btn_text); ?>
                                    </span></button>
                            <?php } ?>
                        </form>
                        <!-- users box -->
                        <div class="users-box">
                            <strong class="title">
                                <?php esc_html_e('14k active candidate', 'jobcircle-frame') ?>
                            </strong>
                            <ul class="users-list">
                                <?php
                                if (!empty($can_img)) {
                                    ?>
                                    <li><img src="<?php echo esc_url_raw($can_img); ?>" width="60" height="60" alt="User"></li>
                                <?php } ?>
                                <?php
                                if (!empty($can_img_o)) {
                                    ?>
                                    <li><img src="<?php echo esc_url_raw($can_img_o); ?>" width="60" height="60" alt="User">
                                    </li>
                                <?php } ?>
                                <?php
                                if (!empty($can_img_s)) {
                                    ?>
                                    <li><img src="<?php echo esc_url_raw($can_img_s); ?>" width="60" height="60" alt="User">
                                    </li>
                                <?php } ?>
                                <?php
                                if (!empty($can_img_t)) {
                                    ?>
                                    <li><img src="<?php echo esc_url_raw($can_img_t); ?>" width="60" height="60" alt="User">
                                    </li>
                                <?php } ?>
                                <li><i class="jobcircle-icon-plus"></i></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-5 col-xl-6 d-flex justify-content-center justify-content-lg-end">
                    <!-- visual Image -->
                    <div class="visual-image position-relative">
                        <?php
                        if (!empty($upld_img)) {
                            ?>
                            <img src="<?php echo esc_url_raw($upld_img); ?>" width="638" height="704" alt="Jobcircle">
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php

    return ob_get_clean();
}

add_shortcode('jc_banner_three', 'jobcircle_banner_three_frontend');