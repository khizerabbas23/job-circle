<?php
function about_our_company()
{
    vc_map(
        array(
            'name' => __('About Our Company'),
            'base' => 'jc_unique_about_our_company',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title'),
                    'param_name' => 'desig_title',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Heading'),
                    'param_name' => 'head',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Main Image'),
                    'param_name' => 'main_img',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Company Director Image'),
                    'param_name' => 'company_director_main_img',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Designation'),
                    'param_name' => 'c_director_post',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Direcctor Name'),
                    'param_name' => 'c_director_head',
                ),

                //group
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'about_our_company_multi',
                    'params' => array(

                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('List Title'),
                            'param_name' => 'list_title',
                        ),
                    )
                ),
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'about_our_company_second_multi',
                    'params' => array(

                        array(
                            'type' => 'textarea',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('First Paragraph'),
                            'param_name' => 'tab_pera',
                        ),

                        array(
                            'type' => 'textarea',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Second Paragraph'),
                            'param_name' => 'tab_rem',
                        ),
                    )

                ),
            )
        )
    );
}
add_action('vc_before_init', 'about_our_company');


// Frontend Coding 

function about_our_company_front($atts, $content)
{

    $atts = shortcode_atts(
        array(

            'desig_title' => '',
            'head' => '',
            'main_img' => '',
            'company_director_main_img' => '',
            'c_director_post' => '',
            'c_director_head' => '',


            'about_our_company_multi' => '',
            'about_our_company_second_multi' => '',

        ),
        $atts,
        'about_our_company'
    );

    $desig_title = isset($atts['desig_title']) && !empty($atts['desig_title']) ? $atts['desig_title'] : '';
    $head = isset($atts['head']) && !empty($atts['head']) ? $atts['head'] : '';
    $company_director_main_img = isset($atts['company_director_main_img']) && !empty($atts['company_director_main_img']) ? $atts['company_director_main_img'] : '';
    $c_director_post = isset($atts['c_director_post']) && !empty($atts['c_director_post']) ? $atts['c_director_post'] : '';
    $c_director_head = isset($atts['c_director_head']) && !empty($atts['c_director_head']) ? $atts['c_director_head'] : '';
    $main_img = isset($atts['main_img']) && !empty($atts['main_img']) ? $atts['main_img'] : '';
    ob_start();
?>
    <section class="section section-about our-company section-theme-1 pt-35 pt-md-50 pt-lg-70 pt-xl-100 pt-xxl-120 pb-35 pb-md-50 pb-lg-70 pb-xl-100 pb-xxl-120">
        <div class="container">
            <!-- Section header -->
            <header class="section-header mb-30 mb-md-45 mb-xl-60">
                <?php if (!empty($desig_title)) { ?>
                    <p class="fw-bold"><?php echo jobcircle_esc_the_html($desig_title)  ?></p>
                <?php
                }
                if (!empty($head)) { ?>
                    <h2><?php echo jobcircle_esc_the_html($head)  ?></h2>
                <?php } ?>
            </header>
            <div class="row">
                <div class="col-12 col-lg-7 mb-35 mb-lg-0">
                    <div class="textbox">
                        <ul class="nav nav-tabs nav-tabs-line mb-15 mb-lg-30">
                            <?php

                            $lm_team_list = vc_param_group_parse_atts($atts['about_our_company_multi']);
                            $counter = 1;
                            foreach ($lm_team_list as $key => $value) {

                                $list_title = isset($value["list_title"]) ? $value["list_title"] : '';

                                if ($counter == 1) {
                                    $active = 'active';
                                    $tabcls = $counter;
                                } else {
                                    $active = '';
                                    $tabcls = $counter;
                                }
                            ?>
                                <?php if (!empty($list_title)) { ?>
                                    <li><button class="nav-link <?php echo $active ?>" data-bs-toggle="tab" data-bs-target="#nav-tab0<?php echo jobcircle_esc_the_html($tabcls) ?>" type="button"><?php echo jobcircle_esc_the_html($list_title) ?></button></li>
                                <?php } ?>
                            <?php
                                $counter++;
                            }
                            ?>
                        </ul>
                        <?php
                        $lm_team_list = vc_param_group_parse_atts($atts['about_our_company_second_multi']);


                        $counter = 1;
                        foreach ($lm_team_list as $key => $value) {

                            $tab_pera = isset($value["tab_pera"]) ? $value["tab_pera"] : '';
                            $tab_rem = isset($value["tab_rem"]) ? $value["tab_rem"] : '';

                            if ($counter == 1) {
                                $active = 'show active';
                                $tab_id = $counter;
                            } else {
                                $active = '';
                                $tab_id = $counter;
                            }
                        ?>
                            <div class="tab-content">
                                <div class="tab-pane fade <?php echo jobcircle_esc_the_html($active); ?>" id="nav-tab0<?php echo jobcircle_esc_the_html($tab_id); ?>">
                                    <?php if (!empty($tab_pera)) {
                                    ?>
                                        <p> <?php echo esc_textarea($tab_pera); ?> </p>
                                    <?php }
                                    if (!empty($tab_rem)) {
                                    ?>
                                        <p> <?php echo esc_textarea($tab_rem); ?> </p>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php
                            $counter++;
                        }
                        ?>
                        <div class="about-author">
                            <div class="author-image">
                                <?php if (!empty($company_director_main_img)) { ?>
                                    <img src="<?php echo esc_url_raw($company_director_main_img) ?>" alt="Willimes Markoo">
                                <?php } ?>
                            </div>
                            <div class="author-info">
                                <?php if (!empty($c_director_post)) { ?>
                                    <span class="subtext"><?php echo jobcircle_esc_the_html($c_director_post) ?></span>
                                <?php }
                                if (!empty($c_director_head)) {
                                ?>
                                    <strong class="author-name"><?php echo jobcircle_esc_the_html($c_director_head) ?></strong>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-5">
                    <div class="about-image">
                        <?php if (!empty($main_img)) { ?>
                            <img src="<?php echo jobcircle_esc_the_html($main_img) ?>" width="560" height="570" alt="Intro">
                        <?php } ?>
                    </div>
                </div>

            </div>
        </div>
    </section>
<?php
    $html = ob_get_clean();

    return $html;
}
add_shortcode('jc_unique_about_our_company', 'about_our_company_front');
