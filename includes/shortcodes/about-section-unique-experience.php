<?php
function jobcircle_unique_experience()
{
    vc_map(
        array(
            'name' => __('About Unique Experience'),
            'base' => 'jc_unique_experience',
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
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Main Title'),
                    'param_name' => 'main_title',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Bold Title'),
                    'param_name' => 'bld_title',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Span Title'),
                    'param_name' => 'span_title',
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
                    'heading' => __('List Items'),
                    'param_name' => 'li_item_one',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('List Items'),
                    'param_name' => 'li_item_two',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('List Items'),
                    'param_name' => 'li_item_three',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Discover Business'),
                    'param_name' => 'discvr_bsns',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Discover Business Url'),
                    'param_name' => 'discvr_url',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Candidate Image'),
                    'param_name' => 'cndi_imag',
                ),
                array(
                    'type' => 'iconpicker',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Play Icon'),
                    'param_name' => 'play_icon',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Play Button Url'),
                    'param_name' => 'play_url',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Founder Name'),
                    'param_name' => 'fonder_name',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Founder Rank'),
                    'param_name' => 'fonder_rank',
                ),
                //group
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'experience_multi',
                    'params' => array(
                        array(
                            'type' => 'iconpicker',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Icon'),
                            'param_name' => 'multi_icn',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Counting'),
                            'param_name' => 'milti_cont_num',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Title'),
                            'param_name' => 'multi_title',
                        ),

                    ),
                )
            )


        )
    );
}
add_action('vc_before_init', 'jobcircle_unique_experience');


// Frontend Coding 

function jobcircle_unique_experience_front($atts, $content)
{

    $atts = shortcode_atts(
        array(


            'head' => '',
            'main_title' => '',
            'bld_title' => '',
            'span_title' => '',
            'desc' => '',
            'li_item_one' => '',
            'li_item_two' => '',
            'li_item_three' => '',
            'discvr_bsns' => '',
            'discvr_url' => '',
            'cndi_imag' => '',
            'play_icon' => '',
            'play_url' => '',
            'fonder_name' => '',
            'fonder_rank' => '',

            'experience_multi' => '',

        ),
        $atts,
        'jobcircle_unique_experience'
    );


    $head = isset($atts['head']) ? $atts['head'] : '';
    $main_title = isset($atts['main_title']) ? $atts['main_title'] : '';
    $bld_title = isset($atts['bld_title']) ? $atts['bld_title'] : '';
    $span_title = isset($atts['span_title']) ? $atts['span_title'] : '';
    $desc = isset($atts['desc']) ? $atts['desc'] : '';
    $li_item_one = isset($atts['li_item_one']) ? $atts['li_item_one'] : '';
    $li_item_two = isset($atts['li_item_two']) ? $atts['li_item_two'] : '';
    $li_item_three = isset($atts['li_item_three']) ? $atts['li_item_three'] : '';
    $discvr_bsns = isset($atts['discvr_bsns']) ? $atts['discvr_bsns'] : '';
    $discvr_url = isset($atts['discvr_url']) ? $atts['discvr_url'] : '';
    $cndi_imag = isset($atts['cndi_imag']) ? $atts['cndi_imag'] : '';
    $play_icon = isset($atts['play_icon']) ? $atts['play_icon'] : '';
    $play_url = isset($atts['play_url']) ? $atts['play_url'] : '';
    $fonder_name = isset($atts['fonder_name']) ? $atts['fonder_name'] : '';
    $fonder_rank = isset($atts['fonder_rank']) ? $atts['fonder_rank'] : '';


    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
    ob_start();
?>
    <section class="section section-about pt-35 pt-md-50 pt-lg-70 pt-xl-100 pb-15 pb-md-35 pb-lg-40">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-7 mb-35 mb-lg-0">
                    <div class="textbox">
                        <?php if (!empty($head)) {
                            ?>
                        <strong class="subtitle h5">
                                <?php echo esc_textarea($head); ?>
                        </strong>
                        <?php } ?>
                        <?php if (!empty($main_title) || !empty($bld_title) || !empty($span_title)) {
                        ?>
                            <h2><span>
                                    <?php echo esc_html($main_title) ?>
                                </span>
                                <?php echo esc_html($bld_title) ?> <span>
                                    <?php echo esc_textarea($span_title) ?>
                                </span>
                            </h2>
                        <?php
                        } ?>
                        <?php if (!empty($desc)) {
                        ?>
                            <p class="vry-godd">
                                <?= esc_textarea($desc) ?>
                            </p>
                        <?php
                        } ?>

                        <ul class="bullet-list">
                            <?php if (!empty($li_item_one)) {
                            ?>
                                <li>
                                    <?php echo esc_html($li_item_one) ?>
                                </li>
                            <?php
                            }
                            if (!empty($li_item_two)) {
                            ?>
                                <li>
                                    <?php echo esc_html($li_item_two) ?>
                                </li>
                            <?php
                            }
                            if (!empty($li_item_three)) { ?>
                                <li>
                                    <?php echo esc_html($li_item_three) ?>
                                </li>
                            <?php } ?>
                        </ul>
                        <?php if (!empty($discvr_url) || !empty($discvr_bsns)) { ?>
                            <a href="<?php echo esc_html($discvr_url) ?>" class="text-link"><?= esc_html($discvr_bsns) ?></a>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-12 col-lg-5">
                    <div class="video-box">
                        <?php
                        if (!empty($cndi_imag)) {
                        ?>
                            <img src="<?php echo esc_url_raw($cndi_imag); ?>" width="567" height="442" alt="Candidate Intro">
                        <?php
                        }
                        ?>
                        <?php if (!empty($play_url) || !empty($play_icon)) {
                        ?>
                            <a class="btn-play" data-fancybox href="<?php echo esc_html($play_url) ?>"><span class="about_btns <?php echo esc_html($play_icon) ?>"></span></a>
                        <?php
                        } ?>
                        <div class="video-caption">
                            <?php if (!empty($fonder_name)) {
                            ?>
                                <strong class="name h5">
                                    <?php echo esc_html($fonder_name) ?>
                                </strong>
                            <?php
                            } ?>
                            <?php if (!empty($fonder_rank)) {
                            ?>
                                <span class="position">
                                    <?php echo esc_html($fonder_rank) ?>
                                </span>
                            <?php
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="counters-block d-flex flex-wrap justify-content-between mt-35 mt-md-50 pt-35 pt-md-50 pt-lg-60 mb-0 pb-lg-20">
                    <?php
                    $lm_team_list = vc_param_group_parse_atts($atts['experience_multi']);

                    foreach ($lm_team_list as $key => $value) {

                        $multi_icn = isset($value["multi_icn"]) ? $value["multi_icn"] : '';
                        $milti_cont_num = isset($value["milti_cont_num"]) ? $value["milti_cont_num"] : '';
                        $multi_title = isset($value["multi_title"]) ? $value["multi_title"] : '';

                    ?>
                        <div class="counter-box">
                            <div class="icon">
                                <?php
                                if (!empty($multi_icn)) {
                                ?>
                                    <i class="<?= esc_html($multi_icn) ?>"></i>
                                <?php
                                }
                                ?>
                            </div>
                            <div class="counter-stats">
                                <strong class="numbers h2">
                                    <?php if (!empty($milti_cont_num)) {
                                    ?>
                                        <span data-purecounter-duration="2" data-purecounter-start="0" data-purecounter-end="<?= esc_html($milti_cont_num) ?>" data-purecounter-once="true" class="purecounter"><?php esc_html_e(0, 'jobcircle-frame') ?></span>
                                    <?php
                                    } ?>
                                </strong>
                                <?php if (!empty($multi_title)) {
                                ?>
                                    <span class="subtext">
                                        <?php echo esc_html($multi_title) ?>
                                    </span>
                                <?php
                                } ?>
                            </div>
                        </div>
                    <?php
                    } ?>
                </div>
            </div>
        </div>
    </section>
<?php
    $html = ob_get_clean();

    return $html;
}
add_shortcode('jc_unique_experience', 'jobcircle_unique_experience_front');
