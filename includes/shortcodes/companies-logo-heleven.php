<?php
function jobcircle_companies_logo_helevn()
{
    vc_map(
        array(
            'name' => __('H-eleven Companies Logo'),
            'base' => 'jc_companies_logo_helevn',
            'category' => __('Job Circle'),
            'params' => array(
                //group   
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'about',
                    'params' => array(
                        array(
                            'type' => 'jobcircle_browse_img',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Upload Image'),
                            'param_name' => 'image',
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
add_action('vc_before_init', 'jobcircle_companies_logo_helevn');
// Frontend Coding 
function jobcircle_companies_logo_helevn_front($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'about' => '',
        ),
        $atts,
        'jobcircle_companies_logo_helevn'
    );
    ob_start();
?>
    <section class="section jc-cst-mrgn section-theme-6 learning-block pb-10 pb-md-50 pb-lg-40 pb-xxl-60">
        <div class="container">
            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                    <ul class="list-inline logos-list">
                        <?php
                        $lm_team_list = vc_param_group_parse_atts($atts['about']);
                        if (!empty($lm_team_list)) {
                            foreach ($lm_team_list as $key => $value) {
                                $image = isset($value["image"]) ? $value["image"] : '';
                                $url = isset($value["url"]) ? $value["url"] : '';
                        ?>
                                <li class="list-inline-item">
                                    <?php if (!empty($url) || !empty($image)) { ?>
                                        <a href="<?php echo esc_html($url) ?>"><img src="<?php echo esc_url_raw($image) ?>" alt="logo"></a>
                                    <?php } ?>
                                </li>
                        <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>
<?php
    return ob_get_clean();
}
add_shortcode('jc_companies_logo_helevn', 'jobcircle_companies_logo_helevn_front');
