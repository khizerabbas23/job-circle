<?php
function jobcircle_how_it_works()
{
    vc_map(
        array(
            'name' => __('Home Two How Its Work'),
            'base' => 'jc_how_it_works',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Heading'),
                    'param_name' => 'head',
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
                    'heading' => __('Title'),
                    'param_name' => 'titl',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Sub Title'),
                    'param_name' => 'sb_titl',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Background Image'),
                    'param_name' => 'bg_imgs',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('image'),
                    'param_name' => 'circle_image',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Explaination'),
                    'param_name' => 'expl',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Cv Text'),
                    'param_name' => 'upld_cv',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Cv Text Url'),
                    'param_name' => 'upld_cv_url',
                ),
                //group
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'work',
                    'params' => array(
                        array(
                            'type' => 'jobcircle_browse_img',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Upload Image'),
                            'param_name' => 'upld_img',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Number'),
                            'param_name' => 'numb',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Title'),
                            'param_name' => 'title',
                        ),
                        array(
                            'type' => 'textarea',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('paragraph'),
                            'param_name' => 'para',
                        ),
                    ),
                )
            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_how_it_works');
// Frontend Coding 
function jobcircle_how_it_works_front($atts, $content)
{

    $atts = shortcode_atts(
        array(

            'head' => '',
            'desc' => '',
            'bg_imgs' => '',
            'titl' => '',
            'sb_titl' => '',
            'circle_image' => '',
            'expl' => '',
            'upld_cv' => '',
            'upld_cv_url' => '',
            'work' => '',

        ), $atts, 'jobcircle_how_it_works');

    $bg_imgs = isset($atts['bg_imgs']) ? $atts['bg_imgs'] : '';
    $head = isset($atts['head']) ? $atts['head'] : '';
    $desc = isset($atts['desc']) ? $atts['desc'] : '';
    $titl = isset($atts['titl']) ? $atts['titl'] : '';
    $sb_titl = isset($atts['sb_titl']) ? $atts['sb_titl'] : '';
    $circle_image = isset($atts['circle_image']) ? $atts['circle_image'] : '';
    $expl = isset($atts['expl']) ? $atts['expl'] : '';
    $upld_cv = isset($atts['upld_cv']) ? $atts['upld_cv'] : '';
    $upld_cv_url = isset($atts['upld_cv_url']) ? $atts['upld_cv_url'] : '';
    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
  
    ob_start();
    ?>
    <section
        class="section section-theme-1 section-how-works pt-45 pt-md-50 pt-lg-65 pt-xl-85 pt-xxl-110 pb-60 pb-md-80 pb-xl-85 pb-xxl-110 pb-xxxl-150">
        <div class="container">
            <!-- Section header -->
            <header class="section-header text-center mb-30 mb-md-45 mb-xl-60">
                <div class="seprator"></div>
                <?php
                if (!empty($head)) {
                    ?>
                    <h2>
                        <?php echo esc_html($head) ?>
                    </h2>
                    <?php
                }
                if (!empty($desc)) {
                    ?>
                    <p>
                        <?php echo esc_textarea($desc) ?>
                    </p>
                    <?php
                } ?>
            </header>
            <div class="row mb-35 mb-lg-60 mb-xl-90">
                <?php
                $lm_team_list = vc_param_group_parse_atts($atts['work']);
                if (!empty($lm_team_list)) {
                    foreach ($lm_team_list as $key => $value) {

                        $upld_img = isset($value["upld_img"]) ? $value["upld_img"] : '';
                        $numb = isset($value["numb"]) ? $value["numb"] : '';
                        $title = isset($value["title"]) ? $value["title"] : '';
                        $para = isset($value["para"]) ? $value["para"] : '';

                        ?>
                        <div class="col-12 col-md-4 text-center mb-30 mb-md-0">
                            <div class="how-work-box">
                                <div class="icon">
                                    <?php
                                    if (!empty($upld_img)) {
                                        ?>
                                        <img src="<?php echo esc_url_raw($upld_img) ?>" alt="Image Description">
                                        <?php
                                    } ?>
                                </div>
                                <?php
                                if (!empty($numb)) {
                                    ?>
                                    <strong class="num">
                                        <?php echo esc_html($numb) ?>
                                    </strong>
                                    <?php
                                } ?>
                                <?php
                                if (!empty($title)) {
                                    ?>
                                    <strong class="h5">
                                        <?php echo esc_html($title) ?>
                                    </strong>
                                    <?php
                                } ?>
                                <?php
                                if (!empty($para)) {
                                    ?>
                                    <p>
                                        <?php echo esc_textarea($para) ?>
                                    </p>
                                    <?php
                                } ?>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            <div class="row">
                <div class="col-12">
                   <div class="matched-jobs-block" style="background-image: url(<?php echo jobcircle_esc_the_html($bg_imgs) ?>);">
                        <div class="section-header">
                            <?php
                            if (!empty($titl) || !empty($sb_titl)) {
                                ?>
                                <h2>
                                    <?php echo esc_html($titl) ?> <span class="text-outlined">
                                        <?php echo esc_html($sb_titl)?></span>.
                                </h2>
                                <?php
                            } ?>
                            <?php
                            if (!empty($expl)) {
                                ?>
                                <p>
                                    <?php echo esc_html($expl) ?>
                                </p>
                                <?php
                            } ?>
                            <?php
                            if (!empty($upld_cv) || !empty($upld_cv_url)) {
                                ?>
                                <a href="<?php echo esc_html($upld_cv_url) ?>" class="btn btn-green btn-sm">
                                    <span class="btn-text"><i class="jobcircle-icon-upload-cloud"></i>
                                        <?php echo esc_html($upld_cv) ?>
                                    </span>
                                </a>   
                            <?php
                            } ?>
                           
                        </div>
                        <div class="image-holder">
                            <?php
                            if (!empty($circle_image)) {
                                ?>
                                <img src="<?php echo esc_url_raw($circle_image) ?>" alt="Image Description">
                                <?php
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
    $html = ob_get_clean();
    return $html;
}
add_shortcode('jc_how_it_works', 'jobcircle_how_it_works_front');