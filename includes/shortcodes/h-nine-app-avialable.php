<?php
function jobcircle_app_avialabel(){
    vc_map(
        array(
            'name' => __('Apps Available'),
            'base' => 'jc_app_avialabel',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Heading'),
                    'param_name' => 'heading',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Discription'),
                    'param_name' => 'disc',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Image '),
                    'param_name' => 'googleimg',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Url'),
                    'param_name' => 'googleimg_url',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Image '),
                    'param_name' => 'appleimg',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Url'),
                    'param_name' => 'apple_url',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Image '),
                    'param_name' => 'img',
                ),
            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_app_avialabel');
//welcome Massage frontend
function jobcircle_app_avialabel_frontend($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'heading' => '',
            'disc' => '',
            'googleimg' => '',
            'googleimg_url' => '',
            'appleimg' => '',
            'apple_url' => '',
            'img' => '',
              ),
        $atts,
        'jobcircle_app_avialabel');

        $heading = isset($atts['heading']) ? $atts['heading'] : '';
        $disc = isset($atts['disc']) ? $atts['disc'] : '';
        $googleimg = isset($atts['googleimg']) ? $atts['googleimg'] : '';
        $googleimg_url = isset($atts['googleimg_url']) ? $atts['googleimg_url'] : '';
        $appleimg = isset($atts['appleimg']) ? $atts['appleimg'] : '';
        $apple_url = isset($atts['apple_url']) ? $atts['apple_url'] : '';
        $img = isset($atts['img']) ? $atts['img'] : '';

    $output = '';
    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
    ob_start();?>
					<section class="apps-block section-theme-9 bg-white">
				<div class="container">
					<div class="row align-items-center">
						<div class="col-12 col-md-6 col-lg-5">
							<div class="text">
                                <?php
                                if(!empty($heading)){ ?>
								<h2><?php echo esc_html($heading) ?></h2>
                                <?php
                                } ?>
                                <?php
                                if(!empty($disc)){ ?>
								<p><?php echo esc_textarea($disc) ?></p>
                                <?php
                            } ?>
                            
								<div class="download-btns">
                                <?php
                                if(!empty($googleimg) || !empty($googleimg_url)){ ?>
									<a href="<?php echo esc_html($googleimg_url) ?>"><img src="<?php echo esc_url_raw($googleimg) ?>" alt="google"></a>
                                    <?php
                                } ?>
                                <?php
                                if(!empty($appleimg) || !empty($apple_url)){ ?>
									<a href="<?php echo esc_html($apple_url) ?>"><img src="<?php echo esc_url_raw($appleimg) ?>" alt="apple"></a>
                                    <?php
                                } ?>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6 col-lg-7">
							<div class="image-holder d-flex justify-content-center">
                            <?php
                                if(!empty($img)){ ?>
								<img src="<?php echo esc_url_raw($img) ?>" alt="image">
                                <?php
                            } ?>
							</div>
						</div>
					</div>
				</div>
			</section>
    <?php
    return ob_get_clean();
}
add_shortcode('jc_app_avialabel', 'jobcircle_app_avialabel_frontend');