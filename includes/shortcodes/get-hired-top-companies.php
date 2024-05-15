<?php
function jobcircle_get_hired_companies()
{
    vc_map(
        array(
            'name' => __('Get Hired Top Companies'),
            'base' => 'jc_get_hired_companies',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Heading'),
                    'param_name' => 'heading',
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
                            'heading' => __('Upload Image'),
                            'param_name' => 'upld_img',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Logo Url'),
                            'param_name' => 'url',
                        ),
                    ),
                )
            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_get_hired_companies');
// Frontend Coding 
function jobcircle_get_hired_companies_front($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'heading' => '',
            'logo' => '',
        ),
        $atts,
        'jobcircle_get_hired_companies'
    );
    $heading = isset($atts['heading']) ? $atts['heading'] : '';
    ob_start();
?>

    <section class="section section-theme-3 section-explores pt-35 pt-md-50 pb-35 pb-md-50">
        <div class="container">
            <div class="section-header mb-20 md-md-50 text-center">
                <h3 class="h6"><?php echo esc_html($heading) ?></h3>
            </div>
            <ul class="sites-list">
            <?php
            $lm_team_list = vc_param_group_parse_atts($atts['logo']);
            if(!empty($lm_team_list)) {
            foreach ($lm_team_list as $key => $value) {
                $upld_img = isset($value["upld_img"]) ? $value["upld_img"] : '';
                $url = isset($value["url"]) ? $value["url"] : '';
                
                if (!empty($upld_img) || !empty($url)) {
                ?>
                     <li><a href="<?php echo esc_html($url) ?>"><img src="<?php echo esc_url_raw($upld_img) ?>" alt="Image Description"></a></li>
                <?php
                }
            }
            } ?>
            </ul>
        </div>
    </section>

<?php
    return ob_get_clean();
}
add_shortcode('jc_get_hired_companies', 'jobcircle_get_hired_companies_front');
