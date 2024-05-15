<?php
function jobcircle_statrt_recruiting(){
    vc_map(
        array(
            'name' => __('Start Recruiting'),
            'base' => 'jc_statrt_recruiting',
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
                    'param_name' => 'title',
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
                    'heading' => __('Start Url'),
                    'param_name' => 'start_url',
                ),
            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_statrt_recruiting');
//welcome Massage frontend
function jobcircle_statrt_recruiting_frontend($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'img' => '',
            'title' => '',
            'disc' => '',
            'start_url' => '',
              ),
        $atts,
        'jobcircle_statrt_recruiting');
    
    $img = isset($atts['img']) ? $atts['img'] : '';
    $title = isset($atts['title']) ? $atts['title'] : '';
    $disc = isset($atts['disc']) ? $atts['disc'] : '';
    $start_url = isset($atts['start_url']) ? $atts['start_url'] : '';

    $output = '';
    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
    ob_start();?>
    <footer class="footer footer-theme-10">
			<div class="pri-footer pt-35 pt-lg-70 pt-xl-90 pb-35 pb-md-20">
				<div class="container">
					<div class="row mb-25 mb-md-40 mb-lg-60 mb-xl-100">
						<div class="col-12">
							<div class="call-to-action">
								<div class="text-row">
                                <?php
                    if(!empty($img)){ ?>
									<img class="icon" src="<?php echo esc_url_raw($img) ?>" alt="icon">
                                    <?php } ?>
                                    <?php
                    if(!empty($title)){ ?>
									<strong class="heading"><?php echo esc_html($title) ?></strong>
                                    <?php } ?>
                                    <?php
                    if(!empty($disc)){ ?>
									<p><?php echo esc_textarea($disc) ?></p>
                                    <?php } ?>
								</div>
								<button class="btn btn-sm btn-orange" type="submit">
								    <?php if(!empty($start_url)) { ?>
									<a href="<?php echo esc_html($start_url) ?>"> <?php } ?>
								    	<span class="btn-text"><?php echo esc_html_e('Start Now', 'jobecircle-frame') ?></span>
							    	</a>
								</button>
							</div>
						</div>
					</div>	</div>
					</div>
            </footer>
    <?php
    return ob_get_clean();
}
add_shortcode('jc_statrt_recruiting', 'jobcircle_statrt_recruiting_frontend');