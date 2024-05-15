<?php
function jobcircle_subscribe()
{
    vc_map(
        array(
            'name' => __('Subscribe News Letter'),
            'base' => 'subscribe',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Background Image'),
                    'param_name' => 'bg_img',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title'),
                    'param_name' => 'support_title',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Short Description'),
                    'param_name' => 'heading',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Button Text'),
                    'param_name' => 'sub_btn',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Image'),
                    'param_name' => 'section_img',
                ),
                 array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Form Id'),
                    'param_name' => 'form_id',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Form Heading'),
                    'param_name' => 'form_head',
                ),

            )
        )
    );

}
add_action('vc_before_init', 'jobcircle_subscribe');

//welcome Massage frontend
function jobcircle_subscribe_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(
            'bg_img' => '',
            'support_title' => '',
            'heading' => '',
            'sub_btn' => '',
            'section_img' => '',
            'form_id' => '',
            'form_head' => '',
        ),
        $atts,
        'jobcircle_subscribe'
    );
   

    $bg_img = isset($atts['bg_img']) ? $atts['bg_img'] : '';
    $section_img = isset($atts['section_img']) ? $atts['section_img'] : '';
    $support_title = isset($atts['support_title']) ? $atts['support_title'] : '';
    $heading = isset($atts['heading']) ? $atts['heading'] : '';
    $sub_btn = isset($atts['sub_btn']) ? $atts['sub_btn'] : '';
    $form_id = isset($atts['form_id']) ? $atts['form_id'] : '';
    $form_head = isset($atts['form_head']) ? $atts['form_head'] : '';
    ob_start();
    ?>
    <?php 
    if(!empty($bg_img)){
        ?>
	<section class="section bg-overlay bg-primary section-newsletter py-0" style="background-image: url('<?php echo esc_url_raw($bg_img, 'jobcircle-frame') ?>');">
        <?php
    }
    ?>
				<div class="container">
					<div class="row flex-md-row-reverse pt-35 pt-md-0">
						<div class="col-12 col-md-7 col-lg-6">
							<div class="d-flex align-items-center h-100 py-md-35 py-lg-25 mb-35 mb-md-0">
								<div class="textbox">
                                <?php 
                                    if(!empty($support_title)){
                                        ?>
                                   		<strong class="h4 subtitle"><?php echo esc_html($support_title) ?></strong>
                                        <?php
                                    }
                                    ?>
                                    <?php 
                                    if(!empty($heading)){
                                        ?>
                                   		<h2><?php echo esc_html($heading) ?></h2>
                                        <?php
                                    }
                                    ?>
                    <?php
                    echo do_shortcode('[contact-form-7 id="' . esc_html($form_id) . '" title="' . esc_html($form_head) . '"]');
                    ?>
									
								</div>
							</div>
						</div>
						<div class="col-12 col-md-5 col-lg-6 d-flex justify-content-center">
							<div class="d-flex align-items-end h-100">
								<div class="image-holder">
                                <?php 
                                    if(!empty($section_img)){
                                        ?>
                                   			<img src="<?php echo esc_url_raw($section_img)?>" width="517" height="496" alt="Support">
								            </div>
                                        <?php
                                    }
                                    ?>
							</div>
						</div>
					</div>
				</div>
			</section>
    <?php
    return ob_get_clean();
}
add_shortcode('subscribe', 'jobcircle_subscribe_frontend');