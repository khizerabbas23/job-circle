<?php
function jobcircle_job_portal_hsixteen()
{
    vc_map(
        array(
            'name' => __('Job Portal Hsixteen'),
            'base' => 'jobcircle_job_portal_hsixteen',
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
                    'heading' => __('Sub Title'),
                    'param_name' => 'sb_title',
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
                    'heading' => __('Looking Job Url'),
                    'param_name' => 'job_url',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Post Job Url'),
                    'param_name' => 'post_url',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Image'),
                    'param_name' => 'bg_img',
                ),
                //group
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'logo',
                    'params' => array(
                        array(
                            'type' => 'jobcircle_browse_img',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Image'),
                            'param_name' => 'upld_img',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Url'),
                            'param_name' => 'url',
                        ),
                    ),
                )
            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_job_portal_hsixteen');

// Frontend Coding 
function jobcircle_job_portal_hsixteen_front($atts, $content)
{

    $atts = shortcode_atts(
        array(

            'title' => '',
            'sb_title' => '',
            'desc' => '',
            'job_url' => '',
            'post_url' => '',
            'bg_img' => '',
            'logo' => '',

        ),
        $atts,
        'jobcircle_job_portal_hsixteen'
    );

    $title = isset($atts['title']) ? $atts['title'] : '';
    $sb_title = isset($atts['sb_title']) ? $atts['sb_title'] : '';
    $desc = isset($atts['desc']) ? $atts['desc'] : '';
    $job_url = isset($atts['job_url']) ? $atts['job_url'] : '';
    $post_url = isset($atts['post_url']) ? $atts['post_url'] : '';
    $bg_img = isset($atts['bg_img']) ? $atts['bg_img'] : '';


    ob_start();

    ?>
    <?php if (!empty($bg_img)) { ?>
        <section class="section section-theme-16 complete_job page-theme-16"
            style="background-image: url('<?php echo esc_url_raw($bg_img) ?>');">
        <?php } ?>
        <div class="container">
            <!-- Section header -->
            <header class="section-header d-flex flex-column mb-15 mb-md-30 mb-xl-40">
                <?php if (!empty($sb_title)) { ?>
                    <p>
                        <?php echo esc_html($sb_title) ?>
                    </p>
                <?php } ?>
                <?php if (!empty($title)) { ?>
                    <h2>
                        <?php echo esc_html($title) ?>
                    </h2>
                <?php } ?>
                <?php if (!empty($desc)) { ?>
                    <span class="text">
                        <?php echo esc_textarea($desc) ?>
                    </span>
                <?php } ?>
            </header>
            <div class="d-flex justify-content-center mb-30 mb-md-50 mb-xl-150">
                <?php if (!empty($job_url)) { ?>
                    <a class="btn btn-white btn-sm" href="<?php echo esc_html($job_url) ?>"><span class="btn-text">
                            <?php esc_html_e('Looking for Job?', 'jobcircle-frame') ?>
                        </span></a>
                <?php } ?>
                <?php if (!empty($post_url)) { ?>
                    <a class="btn btn-pink btn-sm" href="<?php echo esc_html($post_url) ?>"><span class="btn-text">
                            <?php esc_html_e('Post a Job', 'jobcircle-frame') ?>
                        </span></a>
                <?php } ?>
            </div>
            <ul class="logos_list">
                <?php
                $lm_team_list = vc_param_group_parse_atts($atts['logo']);
                if (!empty($lm_team_list)) {
                    foreach ($lm_team_list as $key => $value) {

                        $upld_img = isset($value["upld_img"]) ? $value["upld_img"] : '';
                        $url = isset($value["url"]) ? $value["url"] : '';

                        ?>
                        <li>
                            <?php if (!empty($upld_img) && !empty($url)) { ?>
                                <a href="<?php echo jobcircle_esc_the_html($url) ?>">
                                    <img src="<?php echo esc_url_raw($upld_img) ?>" alt="img">
                                </a>
                            <?php } ?>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('jobcircle_job_portal_hsixteen', 'jobcircle_job_portal_hsixteen_front');