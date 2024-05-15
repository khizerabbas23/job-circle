<?php
function jobcircle_worlds_best_remote()
{
    vc_map(
        array(
            'name' => __('Find Worlds Best Remote'),
            'base' => 'jobcircle_worlds_best_remote',
            'category' => __('theme7'),
            'params' => array(
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Background Image'),
                    'param_name' => 'bg_img',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Image'),
                    'param_name' => 'icn_img',
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
                    'heading' => __('Description'),
                    'param_name' => 'desc',
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
                    'heading' => __('Total Number Top'),
                    'param_name' => 'ttl_num_top',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Job Submited Top'),
                    'param_name' => 'jb_sbmted_top',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Total Number Bottom'),
                    'param_name' => 'ttl_num_bottom',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Job Submited Bottom'),
                    'param_name' => 'jb_sbmted_bottom',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Post Button Resume'),
                    'param_name' => 'post_button_resume',
                ),

            ),
        )
    );
}
add_action('vc_before_init', 'jobcircle_worlds_best_remote');
function jobcircle_worlds_best_remote_frontend($atts, $content)
{
    $atts = shortcode_atts(
        array(

            'bg_img' => '',
            'icn_img' => '',
            'titl' => '',
            'desc' => '',
            'btn_txt' => '',
            'ttl_num_top' => '',
            'jb_sbmted_top' => '',
            'ttl_num_bottom' => '',
            'jb_sbmted_bottom' => '',
            'post_button_resume' => '',
        ),
        $atts,
        'jobcircle_worlds_best_remote'
    );

    $bg_img = isset($atts['bg_img']) ? $atts['bg_img'] : '';
    $icn_img = isset($atts['icn_img']) ? $atts['icn_img'] : '';
    $titl = isset($atts['titl']) ? $atts['titl'] : '';
    $desc = isset($atts['desc']) ? $atts['desc'] : '';
    $btn_txt = isset($atts['btn_txt']) ? $atts['btn_txt'] : '';
    $ttl_num_top = isset($atts['ttl_num_top']) ? $atts['ttl_num_top'] : '';
    $jb_sbmted_top = isset($atts['jb_sbmted_top']) ? $atts['jb_sbmted_top'] : '';
    $ttl_num_bottom = isset($atts['ttl_num_bottom']) ? $atts['ttl_num_bottom'] : '';
    $jb_sbmted_bottom = isset($atts['jb_sbmted_bottom']) ? $atts['jb_sbmted_bottom'] : '';
    $post_button_resume = isset($atts['post_button_resume']) ? $atts['post_button_resume'] : '';

    ob_start();
    ?>
    <?php if(!empty($bg_img)){ ?>
    <section class="section section-theme-13 remote-jobs-block text-white py-30 py-sm-50 py-md-60 py-lg-80 py-xl-100 py-xxl-178"
        style="background-image: url(<?php echo esc_url_raw($bg_img) ?>);">
        <?php } ?>
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 col-md-10 col-lg-9 d-flex flex-column align-items-center">
                    <?php
                    if (!empty($icn_img)) {
                        ?>
                        <img class="icon" src="<?php echo esc_url_raw($icn_img) ?>" alt="icon">
                        <?php
                    } ?>
                    <?php
                    if (!empty($titl)) {
                        ?>
                        <h2>
                            <?php echo esc_html($titl) ?>
                        </h2>
                        <?php
                    } ?>
                    <?php
                    if (!empty($desc)) {
                        ?>
                        <p>
                            <?php echo esc_textarea($desc) ?>
                        </p>
                        <?php
                    } ?>
                    <?php
                    if (!empty($btn_txt) || !empty($post_button_resume)) {
                        ?>
                        <a href="<?php echo esc_html($post_button_resume); ?>"><button class="btn btn-find"><span>
                                    <?php echo esc_html($btn_txt) ?>
                                </span></button></a>
                        <?php
                    } ?>
                    <?php
                    if (!empty($ttl_num_top) || !empty($jb_sbmted_top)) {
                        ?>
                        <div class="stats-circle top"><strong>
                                <?php echo esc_html($ttl_num_top) ?>
                            </strong>
                            <?php echo esc_html($jb_sbmted_top) ?>
                        </div>
                        <?php
                    } ?>
                    <?php if (!empty($ttl_num_bottom) || !empty($jb_sbmted_bottom)) {
                        ?>
                        <div class="stats-circle bottom"><strong>
                                <?php echo esc_html($ttl_num_bottom) ?>
                            </strong>
                            <?php echo esc_html($jb_sbmted_bottom) ?>
                        </div>
                        <?php
                    } ?>
                </div>
            </div>
        </div>
    </section>
    <?php
    ?>
    <?php

    return ob_get_clean();
}

add_shortcode('jobcircle_worlds_best_remote', 'jobcircle_worlds_best_remote_frontend');