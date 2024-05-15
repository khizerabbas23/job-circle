<?php
function jobcircle_candidate_portfolio()
{
    vc_map(
        array(
            'name' => __('Candidate Detail Portfolio'),
            'base' => 'jc_candidate_portfolio',
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
                    'param_name' => 'candidate_multi',
                    'params' => array(
                        array(
                            'type' => 'jobcircle_browse_img',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Upload Image'),
                            'param_name' => 'upld_img',
                        ),
                    ),
                ),
            ),
        )
    );
}
add_action('vc_before_init', 'jobcircle_candidate_portfolio');
function jobcircle_candidate_portfolio_frontend($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'title' => '',
            'candidate_multi' => '',
        ),
        $atts,
        'jobcircle_candidate_portfolio'
    );
    $title = isset($atts['title']) ? $atts['title'] : '';
    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';

    ob_start();
?>
    <div class="gallery-block">
        <?php
        if (!empty($title)) {
        ?>
            <h2 class="h5"><?php jobcircle_esc_the_html($title, 'jobcircle-frame') ?></h2>
        <?php
        }
        ?>
        <div class="gallery-slider bg-light-gray">
            <?php
            $lm_team_list = vc_param_group_parse_atts($atts['candidate_multi']);
            if (!empty($lm_team_list)) {

                foreach ($lm_team_list as $key => $value) {

                    $upld_img = isset($value["upld_img"]) ? $value["upld_img"] : '';
            ?>
                    <div class="slick-slide">
                        <?php
                        if (!empty($upld_img)) {
                        ?>
                            <div class="gallery-image"><img src="<?php echo esc_url_raw($upld_img, 'jobcircle-frame') ?>" width="283" height="231" alt="Portfolioy"></div>
                    </div>
                <?php
                        }
                ?>
        <?php
                }
            }
        ?>
        </div>
    </div>
<?php
    return ob_get_clean();
}
add_shortcode('jc_candidate_portfolio', 'jobcircle_candidate_portfolio_frontend');
