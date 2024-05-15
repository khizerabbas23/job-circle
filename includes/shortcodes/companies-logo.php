<?php
function jobcircle_companies_logo()
{
    vc_map(
        array(
            'name' => __('Companies Logo'),
            'base' => 'jc_companies_logo',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title'),
                    'param_name' => 'title',
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
                            'heading' => __('Url'),
                            'param_name' => 'url',
                        ),
                    ),
                )
            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_companies_logo');
// Frontend Coding 
function jobcircle_companies_logo_front($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'title' => '',
            'logo' => '',
        ),
        $atts,
        'jobcircle_companies_logo'
    );
    $title = isset($atts['title']) ? $atts['title'] : '';
    ob_start();
    ?>
    <section class="section section-theme-5 get-hired-block pt-0 pb-35 pb-md-50 pb-lg-65 pb-xxl-100">
        <div class="container">
            <!-- Section header -->
            <header class="section-header d-flex flex-column text-center mb-0 mb-lg-40">
                <?php
                if (!empty($title)) {
                    ?>
                    <h2>
                        <?php echo esc_html($title); ?>
                    </h2>
                <?php } ?>
            </header>
            <ul class="list-inline logos-list">
                <?php
                $lm_team_list = vc_param_group_parse_atts($atts['logo']);
                        if(!empty($lm_team_list)) {
                foreach ($lm_team_list as $key => $value) {
                    $upld_img = isset($value["upld_img"]) ? $value["upld_img"] : '';
                    $url = isset($value["url"]) ? $value["url"] : '';
                    ?>
                    <li class="list-inline-item">
                        <?php
                        if (!empty($upld_img) && !empty($url)) {
                            ?>
                            <a href="<?php echo ($url) ?>">
                            <img src="<?php echo esc_url_raw($upld_img) ?>" alt="logo">
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
add_shortcode('jc_companies_logo', 'jobcircle_companies_logo_front');