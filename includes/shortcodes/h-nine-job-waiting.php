<?php
function jobcircle_jobe_waiting(){
    vc_map(
        array(
            'name' => __('Jobs Waiting'),
            'base' => 'jc_jobe_waiting',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Image '),
                    'param_name' => 'img',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title'),
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
                    'heading' => __('Search Button'),
                    'param_name' => 'seach_btn',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Search Button Url'),
                    'param_name' => 'seach_btn_url',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Apply Job Button'),
                    'param_name' => 'applybtn',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Apply Job Button Url'),
                    'param_name' => 'apply_btn_url',
                ),
            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_jobe_waiting');
//welcome Massage frontend
function jobcircle_jobe_waiting_frontend($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'img' => '',
            'heading' => '',
            'disc' => '',
            'seach_btn' => '',
            'seach_btn_url' => '',
            'applybtn' => '',
            'apply_btn_url' => '',
              ),
        $atts,
        'jobcircle_jobe_waiting');

    $title = isset($atts['img']) ? $atts['img'] : '';
    $heading = isset($atts['heading']) ? $atts['heading'] : '';
    $disc = isset($atts['disc']) ? $atts['disc'] : '';
    $seach_btn = isset($atts['seach_btn']) ? $atts['seach_btn'] : '';
    $seach_btn_url = isset($atts['seach_btn_url']) ? $atts['seach_btn_url'] : '';
    $applybtn = isset($atts['applybtn']) ? $atts['applybtn'] : '';
    $apply_btn_url = isset($atts['apply_btn_url']) ? $atts['apply_btn_url'] : '';

    
    ob_start();?>
			<section class="page-theme-9 section section-theme-9 jobs_waiting">
				<div class="container">
					<div class="holder">
						<div class="left_align">
							<div class="icon-hold">
                            <?php
                                if(!empty($title)){ ?>
								<img src="<?php echo esc_html($title) ?>" alt="img">
                                <?php
                                } ?>
							</div>
							<div class="text-hold">
                            <?php
                                if(!empty($heading)){ ?>
								<h2><?php echo esc_html($heading ) ?></h2>
                                <?php
                                } ?>
                                <?php
                                if(!empty($disc)){ ?>
								<p><?php echo esc_textarea($disc) ?></p>
                                <?php
                                } ?>
							</div>
						</div>
						<div class="right_align">
                          
                          <?php if(!empty($seach_btn_url) && !empty($seach_btn))
                          { ?>
							<a href="<?php echo esc_html($seach_btn_url) ?>" class="btn btn-white btn-sm"><?php echo esc_html($seach_btn) ?></a>
                             <?php
                          } ?>
                          <?php if(!empty($apply_btn_url) && !empty($applybtn))
                          { ?>
							<a href="<?php echo esc_html($apply_btn_url) ?>" class="btn btn-blue btn-sm"><span class="btn-text"><?php echo esc_html($applybtn) ?></span></a>
                            <?php
                          } ?>
						</div>
					</div>
				</div>
			</section>
    <?php
    return ob_get_clean();
}
add_shortcode('jc_jobe_waiting', 'jobcircle_jobe_waiting_frontend');