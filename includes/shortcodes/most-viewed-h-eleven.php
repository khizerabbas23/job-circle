<?php
function jobcircle_most_viewed_helven()
{
    vc_map(
        array(
            'name' => __('Most Viewed'),
            'base' => 'jc_most_viewed_helven',
            'category' => __('Job Circle'),
            'params' => array(
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
                    'heading' => __('Description'),
                    'param_name' => 'desc',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Upload Image'),
                    'param_name' => 'upld_img',
                ),
                
                //group
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'multi',
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Title'),
                            'param_name' => 'titl',
                        ),
                        array(
                            'type' => 'textarea',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Description'),
                            'param_name' => 'descc',
                        ),
                    ),
                )
            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_most_viewed_helven');
function jobcircle_most_viewed_helven_front($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'title' => '',
            'desc' => '',
            'upld_img' => '',

            'multi' => '',
        ),
        $atts,
        'jobcircle_most_viewed_helven'
    );
    $title = isset($atts['title']) ? $atts['title'] : '';
    $desc = isset($atts['desc']) ? $atts['desc'] : '';
    $upld_img = isset($atts['upld_img']) ? $atts['upld_img'] : '';

    ob_start();
    ?>
    			<section class="section section-theme-6 most-viewed-block bg-white pt-30 pt-md-50 pt-lg-75 pt-xxl-120 pb-35 pb-md-50 pb-lg-65 pb-xxl-100">
				<div class="container">
					<div class="row">
						<div class="col-12 col-lg-7">
							<header class="section-header d-flex flex-column mb-30 mb-md-40 mb-lg-45 mb-xl-65">
							<?php if(!empty($title)){?>	
                            <h2><?php echo esc_html($title)?></h2>
                            <?php }?>
                            <?php if(!empty($desc)) { ?>
								<p><?php echo esc_textarea($desc)?></p>
							<?php }?>
                            </header>
						</div>	
					</div>
					<div class="row align-items-center">
						<div class="col-12 col-md-6">
							<div class="text">
                <?php

                $lm_team_list = vc_param_group_parse_atts($atts['multi']);


                    foreach ($lm_team_list as $key => $value) {

                        $titl = isset($value['titl']) ? $value['titl'] : '';
                        $descc = isset($value['descc']) ? $value['descc'] : '';
                        ?>
                                    <div class="step-box">
                                    <?php if(!empty($titl)){?>
									<h3><?php echo esc_html($titl)?></h3>
                                    <?php }?>
                                    <?php if(!empty($descc)){?>
									<p><?php echo esc_textarea($descc)?></p>
								<?php }?>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
						</div>
						<div class="col-12 col-md-6">
							<div class="image-holder">
                            <?php if(!empty($upld_img)){?>
								<img src="<?php echo esc_url_raw($upld_img)?>" alt="image">
							<?php }?>
                            </div>
						</div>
					</div>
				</div>
			</section>
        <?php
        return ob_get_clean();
                }
add_shortcode('jc_most_viewed_helven', 'jobcircle_most_viewed_helven_front');