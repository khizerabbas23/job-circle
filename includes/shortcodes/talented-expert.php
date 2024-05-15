<?php
function jobcircle_talented(){
    vc_map(
        array(
            'name' => __('Talented Experts'),
            'base' => 'jc_talented',
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
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Button'),
                    'param_name' => 'btn',
                ),
				array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Button Url'),
                    'param_name' => 'btn_url',
                ),
				array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title'),
                    'param_name' => 'title',
                ),
				array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Image'),
                    'param_name' => 'before_img',
                ),
				array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Image'),
                    'param_name' => 'after_img',
                ),
				array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Graph Image'),
                    'param_name' => 'ban_img_left',
                ),
            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_talented');
//welcome Massage frontend
function jobcircle_talented_frontend($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'heading' => '',
            'disc' => '',
            'btn' => '',
            'btn_url' => '',
            'title' => '',
            'ban_img_left' => '',
            'before_img' => '',
            'after_img' => '',
              ),
        $atts, 'jobcircle_talented');

    $heading = isset($atts['heading']) ? $atts['heading'] : '';
	$disc = isset($atts['disc']) ? $atts['disc'] : '';
	$btn = isset($atts['btn']) ? $atts['btn'] : '';
	$btn_url = isset($atts['btn_url']) ? $atts['btn_url'] : '';
	$title = isset($atts['title']) ? $atts['title'] : '';
	$ban_img_left = isset($atts['ban_img_left']) ? $atts['ban_img_left'] : '';
	$before_img = isset($atts['before_img']) ? $atts['before_img'] : '';
	$after_img = isset($atts['after_img']) ? $atts['after_img'] : '';

    $output = '';
    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
    ob_start();?>
			<section class="section section-theme-3 section-experts pt-15px pt-md-30 pb-35 pb-md-50 pb-lg-65 pb-xl-85 pb-xxl-110">
				<div class="container">
					<div class="row">
						<div class="col-12">
							<div class="matched-jobs-block">
								<div class="section-header">
								<?php
								if(!empty($heading)){ ?>
									<h1><?php echo esc_html($heading) ?></h1>
									<?php } ?>
									<?php
								if(!empty($disc)){ ?>
									<p><?php echo esc_textarea($disc) ?></p>
									<?php } ?>
									<?php
									if(!empty($btn_url) && !empty($btn)){ ?>
									<a href="<?php echo esc_html($btn_url) ?>" class="btn btn-brown btn-sm"><span class="btn-text">+ <?php echo esc_html($btn) ?></span></a>
									<?php } ?>
									<ul class="list-unstyled features-list">
									<?php
									if(!empty($title)){ ?>
										<li><?php echo esc_html($title) ?></li>
										<?php } ?>
									</ul>
								</div>
								<div class="image-holder">
									<div class="image-wrap">
									<?php
									if(!empty($before_img)){ ?>
										<img src="<?php echo esc_url_raw($before_img) ?>" width="568" height="563" alt="Image Description">
										<?php } ?>
									</div>
									<div class="img-info">
									<?php
									if(!empty($after_img)){ ?>
										<img src="<?php echo esc_url_raw($after_img) ?> " width="328" height="221" alt="Image Description">
										<?php } ?>
									</div>
									<div class="img-graph">
									<?php
									if(!empty($ban_img_left)){ ?>
										<img src="<?php echo esc_url_raw($ban_img_left) ?>" width="208" height="191" alt="Image Description">
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
    <?php
    return ob_get_clean();
}
add_shortcode('jc_talented', 'jobcircle_talented_frontend');