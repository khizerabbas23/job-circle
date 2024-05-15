<?php
function jobcircle_market_place_h_eleven()
{
    vc_map(
        array(
            'name' => __('Market Place'),
            'base' => 'jc_market_place_h_eleven',
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
                        array(
                            'type' => 'jobcircle_browse_img',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Image'),
                            'param_name' => 'img_before',
                        ),
                    ),
                )
            )


        )
    );
}
add_action('vc_before_init', 'jobcircle_market_place_h_eleven');
// Frontend Coding 
function jobcircle_market_place_h_eleven_front($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'title' => '',
            'desc' => '',
            'upld_img' => '',

            'multi' => '',
        ),
        $atts,
        'jobcircle_market_place_h_eleven'
    );

    $title = isset($atts['title']) ? $atts['title'] : '';
    $desc = isset($atts['desc']) ? $atts['desc'] : '';
    $upld_img = isset($atts['upld_img']) ? $atts['upld_img'] : '';
    ob_start();
    ?>
    			<section class="section section-theme-6 marktplace-block bg-white pt-20 pt-md-40 pt-lg-65 pt-xxl-100 pb-50 pb-md-40 pb-lg-50 pb-xxl-90">
				<div class="container">
					<div class="row align-items-center">
						<div class="col-12 col-md-6 order-2 order-md-1">
							<div class="image-holder">
                            <?php
                                if(!empty($upld_img)){ ?>    
                            <img src="<?php echo esc_url_raw($upld_img)?>" alt="image"></div>
						<?php }?>
                        </div>
						<div class="col-12 col-md-6 order-1 order-md-2">
							<div class="text-box">
                            <?php
                                if(!empty($title)){ ?>		
								<h2><?php echo esc_html($title)?></h2>
								<?php }?>
                                <?php
                                if(!empty($desc)){ ?>
                                <p><?php echo esc_textarea($desc)?></p>
								<?php }?>
                                <ul class="list-unstyled list">
                <?php

                $lm_team_list = vc_param_group_parse_atts($atts['multi']);


                    foreach ($lm_team_list as $key => $value) {

                        $titl = isset($value['titl']) ? $value['titl'] : '';
                        $descc = isset($value['descc']) ? $value['descc'] : '';
                        $img_before = isset($value['img_before']) ? $value['img_before'] : '';
                        ?>
                                    <li>
                                        <?php
                                        if(!empty($titl)){ ?>
										<strong><?php echo esc_html($titl)?></strong>
										<?php }?>
                                        <?php
                                        if(!empty($descc)){ ?>
                                        <p><?php echo esc_textarea($descc)?></p>
									<?php }?>
                                        </li>
                                <?php
                                }
                                ?>
                                </ul>
							</div>
						</div>
					</div>
				</div>
			</section>
        <?php
        return ob_get_clean();
                }

add_shortcode('jc_market_place_h_eleven', 'jobcircle_market_place_h_eleven_front');