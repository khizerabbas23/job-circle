<?php
function jobcircle_download_app_hsx() {
    vc_map(
        array(
            'name' => __('Download The App'),
            'base' => 'jc_download_app_hsx',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Heading'),
                    'param_name' => 'head',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Description'),
                    'param_name' => 'desc',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Quality'),
                    'param_name' => 'qulity_on',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Quality'),
                    'param_name' => 'quality_tw',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Quality'),
                    'param_name' => 'quality_th',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Playstore Url'),
                    'param_name' => 'ply_link',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Upload Playstore Image'),
                    'param_name' => 'ply_img',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Apple Url'),
                    'param_name' => 'app_link',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Upload Apple Image'),
                    'param_name' => 'apple_img',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Upload Image'),
                    'param_name' => 'mobile_img',
                ),
            ),
        )
    );
}
add_action('vc_before_init', 'jobcircle_download_app_hsx');
function jobcircle_download_app_hsx_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(

            'head'=>'',
            'desc'=>'',
            'ply_link' => '',
            'ply_img' => '',
            'app_link' => '',
            'apple_img' => '',
            'quality_th' => '',
            'quality_tw' => '',
            'qulity_on' => '',
            'mobile_img' => '',

        ),
        $atts,
        'jobcircle_download_app_hsx'
    );
   
    $head = isset($atts['head']) ? $atts['head'] : '';
    $desc = isset($atts['desc']) ? $atts['desc'] : '';
    $ply_link = isset($atts['ply_link']) ? $atts['ply_link'] : '';
    $app_link = isset($atts['app_link']) ? $atts['app_link'] : '';
    $qulity_on = isset($atts['qulity_on']) ? $atts['qulity_on'] : '';
    $quality_tw = isset($atts['quality_tw']) ? $atts['quality_tw'] : '';
    $quality_th = isset($atts['quality_th']) ? $atts['quality_th'] : '';
    $ply_img = isset($atts['ply_img']) ? $atts['ply_img'] : '';
    $apple_img = isset($atts['apple_img']) ? $atts['apple_img'] : '';
    $mobile_img = isset($atts['mobile_img']) ? $atts['mobile_img'] : '';
    
ob_start();
?>
     <section class="section section-theme-4 apps-block bg-white pt-0 pt-md-30 pt-lg-60 pt-xxl-100 pb-35 pb-md-50 pb-lg-65 pb-xxl-100">
				<div class="container">
					<div class="row align-items-center">
						<div class="col-12 col-md-6">
							<div class="text">
                           <?php if(!empty($head)){ ?>
								<h2><?php echo esc_html($head) ?></h2>
                            <?php  } 
                            if(!empty($desc)){ ?>
								<p><?php echo esc_textarea($desc) ?></p>
                            <?php } ?>
								<ul class="list-unstyled list">
                                <?php   if(!empty($qulity_on)){ ?>
									<li><?php echo esc_html($qulity_on) ?></li>
                                <?php } 
                                if(!empty($quality_tw)){ ?>
									<li><?php echo esc_html($quality_tw) ?></li>
                                <?php }
                                  if(!empty($quality_th)){ ?>

									<li><?php echo esc_html($quality_th) ?></li>
                                <?php   } ?>

								</ul>
								<div class="download-btns">
                              <?php if(!empty($ply_img ) && !empty($ply_link)){ ?>
									<a href="<?php echo esc_html($ply_link) ?>"><img src="<?php echo esc_html($ply_img) ?>" alt="google"></a>
                                <?php }
                                  if(!empty($apple_img ) && !empty($app_link)){ ?>
									<a href="<?php echo esc_html($app_link) ?>"><img src="<?php echo esc_html($apple_img) ?>" alt="apple"></a>
                                    <?php } ?>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="image-holder">
                        <?php if(!empty($mobile_img)){ ?>
								<img src="<?php echo esc_url_raw($mobile_img) ?>" alt="image">
                                <?php } ?>
							</div>
						</div>
					</div>
				</div>
			</section>
<?php
    return ob_get_clean();
}

add_shortcode('jc_download_app_hsx', 'jobcircle_download_app_hsx_frontend');