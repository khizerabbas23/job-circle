<?php
function jobcircle_companies_logo_sventeen()
{

    vc_map(
        array(
            'name' => __('H-seventeen Companies Logo'),
            'base' => 'jc_companies_logo_sevnteen',
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
add_action('vc_before_init', 'jobcircle_companies_logo_sventeen');

// Frontend Coding 

function jobcircle_companies_logo_svnteen_front($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'about' => '',
        ),
        $atts,
        'jobcircle_companies_logo_sventeen'
    );
    ob_start();
    ?>
  <section class="logos_area">
				<div class="container">
					<ul class="logos_list">
                        <?php
                        $lm_team_list = vc_param_group_parse_atts($atts['about']);
                    if(!empty($lm_team_list)){
                        foreach ($lm_team_list as $key => $value) {

                            $image = isset($value["image"]) ? $value["image"] : '';
                            $url = isset($value["url"]) ? $value["url"] : '';
                            
                            ?>
                            <li>
                                <?php if(!empty($url) && !empty($image)){
                                    ?>
							<a href="<?php echo jobcircle_esc_the_html($url) ?>"><img src="<?php echo esc_url_raw($image)?>" alt="img"></a>
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
add_shortcode('jc_companies_logo_sevnteen', 'jobcircle_companies_logo_svnteen_front');