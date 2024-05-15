<?php
function jobcircle_clients_review()
{
    vc_map(
        array(
            'name' => __('Clients Reviews'),
            'base' => 'clients_testemonials',
            'category' => __('Job Circle'),
            'params' => array(
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
                    'heading' => __('Tag Line'),
                    'param_name' => 'tg_lline',
                ),
                //Group
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'recent_multi_clients_testemonials',
                    'params' => array(
                        array(
                            'type' => 'jobcircle_browse_img',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Image'),
                            'param_name' => 'image',
                        ),
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
                            'heading' => __('Tag Line'),
                            'param_name' => 'tg_line',
                        ),
                        array(
                            'type' => 'textarea',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Description'),
                            'param_name' => 'desc',
                        ),
                    ),
                ),
            ),
        )
    );
}
add_action('vc_before_init', 'jobcircle_clients_review');
// Frontend Coding 
function jobcircle_clients_review_front($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'titl' => '',
            'tg_lline' => '',
            'recent_multi_clients_testemonials' => '',
        ),
        $atts,
        'jobcircle_clients_review'
    );
    $titl = isset($atts['titl']) ? $atts['titl'] : '';
    $tg_lline = isset($atts['tg_lline']) ? $atts['tg_lline'] : '';

    ob_start();
?>
    <section class="section section-theme-1 section-quotes related-categories bg-light-gray pt-35 pt-md-50 pt-lg-65 pt-xl-80 pt-xxl-110 pb-35 pb-md-50 pb-lg-65 pb-xl-80 pb-xxl-110">
        <div class="container">
            <div class="row justify-content-between mb-25 mb-lg-40">
                <div class="col-12 col-lg-8 col-xl-5">
                    <!-- Section header -->
                    <header class="section-header text-center text-lg-start mb-10 m-lg-0">
                        <?php
                        if (!empty($titl)) {
                        ?>
                            <h2><?php echo esc_html($titl) ?></h2>
                        <?php
                        }
                        ?>
                        <?php
                        if (!empty($tg_lline)) {
                        ?>
                            <p><?php echo esc_html($tg_lline) ?></p>
                        <?php
                        } ?>
                    </header>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="quotes-slider">
                        <?php
                        $lm_teamdfdgd_list = vc_param_group_parse_atts($atts['recent_multi_clients_testemonials']);
                        foreach ($lm_teamdfdgd_list as $key => $value) {
                            $image = isset($value["image"]) ? $value["image"] : '';
                            $head = isset($value["head"]) ? $value["head"] : '';
                            $tg_line = isset($value["tg_line"]) ? $value["tg_line"] : '';
                            $desc = isset($value["desc"]) ? $value["desc"] : '';
                        ?>
                            <div class="slick-slide">
                                <div class="quotes-box">
                                    <div class="author-box">
                                        <div class="social-icon"><i class="jobcircle-icon-facebook"></i></div>
                                        <div class="author-avatar">
                                            <?php
                                            if (!empty($image)) {
                                            ?>
                                                <img src="<?php echo esc_url_raw($image) ?>" width="119" height="119" alt="Linda Romania">
                                            <?php
                                            }
                                            ?>
                                        </div>
                                        <?php
                                        if (!empty($head) || !empty($tg_line)) {
                                        ?>
                                            <strong class="author-name h6"><?php echo esc_html($head) ?><?php esc_html_e(',', 'jobcircle-frame') ?> <span><?php echo esc_html($tg_line) ?></span></strong>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <blockquote>
                                        <?php
                                        if (!empty($desc)) {
                                        ?>
                                            <q><?php echo esc_html($desc) ?></q>
                                        <?php
                                        }
                                        ?>
                                    </blockquote>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
    $html =  ob_get_clean();
    return $html;
}
add_shortcode('clients_testemonials', 'jobcircle_clients_review_front');
