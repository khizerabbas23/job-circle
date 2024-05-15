<?php
function jobcircle_how_it_work_f()
{

    vc_map(

        array(
            'name' => __('Home Five How It Work'),
            'base' => 'jc_how_it_work_f',
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
                    'param_name' => 'sub_title',
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
                    'heading' => __('Background Image'),
                    'param_name' => 'bgrd_img',
                ),
                //group
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'box',
                    'params' => array(
                        array(
                            'type' => 'jobcircle_browse_img',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Icon Image'),
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
                            'heading' => __('Url'),
                            'param_name' => 'url',
                        ),
                    ),
                )
            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_how_it_work_f');

// Frontend Coding 

function jobcircle_how_it_work_f_front($atts, $content)
{
    $atts = shortcode_atts(
        array(

            'title' => '',
            'sub_title' => '',
            'upld_img' => '',
            'bgrd_img' => '',
            'box' => '',

        ), $atts, 'jobcircle_how_it_work_f'
    );

    $title = isset($atts['title']) ? $atts['title'] : '';
    $sub_title = isset($atts['sub_title']) ? $atts['sub_title'] : '';
    $upld_img = isset($atts['upld_img']) ? $atts['upld_img'] : '';
    $bgrd_img = isset($atts['bgrd_img']) ? $atts['bgrd_img'] : '';

    ob_start();
    ?>
<?php
    if (!empty($bgrd_img)) { ?>
<section class="section section-theme-5 how-work-block bg-light-sky pt-35 pt-md-50 pt-lg-75 pt-xxl-120 pb-0"
    style="background-image: url('<?php echo esc_url_raw($bgrd_img); ?>');">
    <?php } ?>
    <div class="container">
        <!-- Section header -->
        <header class="section-header d-flex flex-column text-center mb-50">
            <?php
                if (!empty($title)) { ?>
            <h2 class="order-2">
                <?php echo esc_html($title); ?>
            </h2>
            <?php } ?>
            <?php
                if (!empty($sub_title)) { ?>
            <p class="order-1">
                <?php echo esc_html($sub_title); ?>
            </p>
            <?php } ?>
        </header>
        <div class="row">
            <div class="col-12 col-md-8">
                <div class="work-content d-flex justify-content-between mt-25 mt-xl-50">
                    <div class="process-boxes">
                        <?php
                            $lm_team_list = vc_param_group_parse_atts($atts['box']);

                            foreach ($lm_team_list as $key => $value) {

                                $icn_img = isset($value["icn_img"]) ? $value["icn_img"] : '';
                                $titl = isset($value["titl"]) ? $value["titl"] : '';
                                $desc = isset($value["desc"]) ? $value["desc"] : '';
                                $url = isset($value["url"]) ? $value["url"] : '';

                                ?>
                        <div class="box">
                            <a href="<?php echo esc_html($url) ?>">
                                <div class="icon">
                                    <?php
                                            if (!empty($icn_img)) { ?>
                                    <img src="<?php echo esc_url_raw($icn_img) ?>" alt="icon">
                                    <?php } ?>
                                </div>
                                <?php
                                        if (!empty($titl)) { ?>
                                <h3>
                                    <?php echo esc_html($titl) ?>
                                </h3>
                                <?php } ?>
                                <?php
                                        if (!empty($desc)) { ?>
                                <p>
                                    <?php echo esc_textarea($desc) ?>
                                </p>
                                <?php } ?>
                            </a>
                        </div>
                        <?php
                            }
                            ?>
                    </div>
                    <div class="image-holder">
                        <?php
                            if (!empty($upld_img)) { ?>
                        <img src="<?php echo esc_url_raw($upld_img); ?>" alt="image">
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
    return ob_get_clean();
}
add_shortcode('jc_how_it_work_f', 'jobcircle_how_it_work_f_front');