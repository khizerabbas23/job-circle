<?php
function jobcircle_popular_cities()
{
    vc_map(

        array(
            'name' => __('Popular Cities Work'),
            'base' => 'jc_popular_cities',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Underline Image'),
                    'param_name' => 'lne_img',
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
                    'heading' => __('Underline Title'),
                    'param_name' => 'und_title',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Span Title'),
                    'param_name' => 'spn_title',
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
                    'param_name' => 'sec_tit',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Register Account'),
                    'param_name' => 'reg_acc',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Apply Job'),
                    'param_name' => 'app_job',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Image'),
                    'param_name' => 'sec_img',
                ),
                //group
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'cities_multi',
                    'params' => array(
                        array(
                            'type' => 'jobcircle_browse_img',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Image'),
                            'param_name' => 'mlti_img',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Title'),
                            'param_name' => 'mlti_title',
                        ),
                    ),
                )
            )


        )
    );
}
add_action('vc_before_init', 'jobcircle_popular_cities');


// Frontend Coding 

function jobcircle_popular_cities_front($atts, $content)
{

    $atts = shortcode_atts(
        array(

            'lne_img' => '',
            'title' => '',
            'und_title' => '',
            'spn_title' => '',
            'bg_img' => '',
            'sec_tit' => '',
            'reg_acc' => '',
            'app_job' => '',
           
            'sec_img' => '',

            'cities_multi' => '',
        ),
        $atts,
        'jobcircle_popular_cities'
    );

    $lne_img = isset($atts['lne_img']) ? $atts['lne_img'] : '';
    $title = isset($atts['title']) ? $atts['title'] : '';
    $und_title = isset($atts['und_title']) ? $atts['und_title'] : '';
    $spn_title = isset($atts['spn_title']) ? $atts['spn_title'] : '';
    $bg_img = isset($atts['bg_img']) ? $atts['bg_img'] : '';
    $sec_tit = isset($atts['sec_tit']) ? $atts['sec_tit'] : '';
    $reg_acc = isset($atts['reg_acc']) ? $atts['reg_acc'] : '';
    $app_job = isset($atts['app_job']) ? $atts['app_job'] : '';
    $sec_img = isset($atts['sec_img']) ? $atts['sec_img'] : '';
    ob_start();
    ?>
    <style>
        .section-theme-8 .section-header h2 .text-outlined:before {
            width: 100%;
            height: 6px;
            position: absolute;
            left: 0;
            bottom: -12px;
            content: "";
            background: url(<?php echo esc_url_raw($lne_img) ?>) no-repeat;
            background-size: 100% 100%;
        }

        .section-theme-8 .matched-jobs-block {
            background: #181818 url(<?php echo esc_url_raw($bg_img) ?>) no-repeat;
            background-size: cover;
            color: #fff;
            max-width: 100%;
        }
    </style>

    <section class="section section-theme-8 popular-cities-listing pt-45 pt-md-50 pt-lg-70 pb-35 pb-md-50 pb-lg-65">
        <div class="container">
            <!-- Section header -->
            <header class="section-header text-center mb-30 mb-md-45 mb-xl-50">
                <h2>
                    <?php if (!empty($title) || !empty($und_title) || !empty($spn_title)) {
                        ?>
                        <?php echo esc_html($title) ?> <span class="text-outlined">
                            <?php echo esc_html($und_title) ?>
                        </span>
                        <?php echo esc_html($spn_title) ?>
                        <?php
                    } ?>
                </h2>
            </header>
            <div class="row justify-content-center">

                <?php

                $lm_team_list = vc_param_group_parse_atts($atts['cities_multi']);

                foreach ($lm_team_list as $key => $value) {

                    $mlti_img = isset($value["mlti_img"]) ? $value["mlti_img"] : '';
                    $mlti_title = isset($value["mlti_title"]) ? $value["mlti_title"] : '';
                    $mlti_post = isset($value["mlti_post"]) ? $value["mlti_post"] : '';

                    $args = array(
                        'post_type' => 'jobs',  
                        'posts_per_page' => -1,  
                        'meta_query' => array(
                            'relation' => 'OR',
                            array(
                                'key' => 'jobcircle_field_loc_city',
                                'value' => esc_html($mlti_title),
                            ),
                            array(
                                'key' => 'jobcircle_field_loc_country',
                                'value' => esc_html($mlti_title),
                            ),
        
                        ),
                    );
                    $query = new WP_Query($args);
                    $post_fount=$query->found_posts;
                    ?>
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mb-25 mb-md-30">
                        <div class="popular-city-box">
                            <div class="img-holder">
                                <?php if (!empty($mlti_img)) {
                                    ?>
                                    <img src="<?php echo esc_url_raw($mlti_img) ?>" width="110" height="110" alt="Los Angeles">
                                    <?php
                                } ?>
                            </div>
                            <div class="textbox">
                                <?php if (!empty($mlti_title)) {
                                    ?>
                                    <strong class="title h6">
                                        <?php echo esc_html($mlti_title) ?>
                                    </strong>
                                    <?php
                                } ?>
                               
                                    <span class="subtext"><?php echo esc_html($post_fount)?>
                                    <?php echo esc_html_e('open positions' , 'jobcircle-frame') ?>
                                    </span>
                                   
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>

            </div>
            <div class="row">
                <div class="col-12 pt-35 pt-ld 65 pt-xl-100">
                    <div class="matched-jobs-block">
                        <div class="section-header">
                            <?php if (!empty($sec_tit)) {
                                ?>
                                <h2>
                                    <?php echo esc_html($sec_tit) ?>
                                </h2>
                                <?php
                            } ?>
                            <?php if (!empty($reg_acc) && !empty($app_job)) {
                                ?>
                                <ul class="steps-list">
                                    <li>
                                        <i class="jobcircle-icon-check"></i>
                                        <?php echo esc_html($reg_acc) ?>
                                    </li>
                                    <li>
                                        <i class="jobcircle-icon-check"></i>
                                        <?php echo esc_html($app_job) ?>
                                    </li>
                                </ul>
                                <?php
                            } ?>
                            
                               <a href="https://modern.miraclesoftsolutions.com/dashboard/?account_tab=my-resume" class="btn btn-orange btn-sm"><span class="btn-text"><i class="jobcircle-icon-upload-cloud"></i><?php esc_html_e('Upload Your CV','jobcircle-frame') ?></span></a>
                                       
                                    </span></a>
                             
                        </div>
                        <div class="image-holder">
                            <?php if (!empty($sec_img)) {
                                ?>
                                <img src="<?php echo esc_url_raw($sec_img) ?>" alt="Image Description">
                                <?php
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('jc_popular_cities', 'jobcircle_popular_cities_front');