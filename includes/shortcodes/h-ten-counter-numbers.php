<?php
function jobcircle_counter_box()
{
    vc_map(
        array(
            'name' => __('Counter Numbers'),
            'base' => 'jc_counter_box',
            'category' => __('Job Circle'),
            'params' => array(

                //group
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'counter_multi',
                    'params' => array(
                        array(
                            'type' => 'jobcircle_browse_img',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Brand Image'),
                            'param_name' => 'img',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Count Number'),
                            'param_name' => 'countnbr',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Extra Number'),
                            'param_name' => 'extraountnbr',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Title'),
                            'param_name' => 'title',
                        ),
                    ),
                )
            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_counter_box');

// Frontend Coding 

function jobcircle_counter_box_front($atts, $content)
{
    $atts = shortcode_atts(
        array(     
            'counter_multi' => '',
        ), $atts, 'jobcircle_counter_box'
    );

    ob_start()
        ?>
			
            <div class="section section-theme-10 pt-35 pt-md-50 pt-lg-75 pt-xxl-120 pb-0 pb-md-30 pb-lg-80 pb-xxl-100">
				<div class="container">
					<div class="row justify-content-center justify-content-md-between">
						<div class="counters-block">
                    <?php
                    $lm_team_list = vc_param_group_parse_atts($atts['counter_multi']);
                    foreach ($lm_team_list as $key => $value) {

                        $img	 = isset($value["img"]) ? $value["img"] : '';
                        $countnbr = isset($value["countnbr"]) ? $value["countnbr"] : '';
                        $extraountnbr = isset($value["extraountnbr"]) ? $value["extraountnbr"] : '';
                        $title = isset($value["title"]) ? $value["title"] : '';
                        ?>
                            <div class="counter-box">
								<div class="counter-stats">
                                <?php if(!empty($img)){ ?>
									<img class="icon" src="<?php echo esc_url_raw($img) ?>" alt="icon">
                                    <?php } ?>
                                    <?php if(!empty($countnbr) || !empty($extraountnbr)){ ?>
									<strong class="h2">
										<span data-purecounter-duration="1" data-purecounter-start="0" data-purecounter-end="<?php echo esc_html($countnbr) ?>" data-purecounter-once="true" class="purecounter"><?php echo esc_html($countnbr) ?></span><?php echo esc_html($extraountnbr) ?>
									</strong>
                                    <?php } ?>
                                    <?php if(!empty($title)){ ?>
									<span class="subtext"><?php echo esc_html($title) ?></span>
                                    <?php } ?>
								</div>
							</div>
                        <?php
                    }
                    ?>
              </div>
					</div>
				</div>
			</div>
    <?php
    return ob_get_clean();
}
add_shortcode('jc_counter_box', 'jobcircle_counter_box_front');