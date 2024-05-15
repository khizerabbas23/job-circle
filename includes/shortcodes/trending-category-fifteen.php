<?php
function jobcircle_trending_job()
{
    vc_map(

        array(
            'name' => __('Trending Jobs 15'),
            'base' => 'jobcircle_trending_job',
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
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Heading'),
                    'param_name' => 'heading',
                ),
                //group
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'treding_multi',
                    'params' => array(
			     array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Url'),
                            'param_name' => 'url',
                        ),

                            array(
                            'type' => 'jobcircle_browse_img',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Image'),
                            'param_name' => 'icn_img',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Title'),
                            'param_name' => 'm_title',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Heading'),
                            'param_name' => 'm_heading',
                        ),
  
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Sallery'),
                            'param_name' => 'sallery',
                        ),

                    ),
                )
            )


        )
    );
}
add_action('vc_before_init', 'jobcircle_trending_job');


// Frontend Coding 

function jobcircle_trending_job_front($atts, $content)
{

    $atts = shortcode_atts(
        array(

            'title' => '',
            'heading' => '',            

            'treding_multi' => '',

        ),
        $atts,
        'jobcircle_trending_job'
    );

    $title = isset($atts['title']) ? $atts['title'] : '';
    $heading = isset($atts['heading']) ? $atts['heading'] : '';

    ob_start()
        ?>
			<section class="section section-theme-15 trending-jobs-block pt-0 pt-lg-20 pt-xl-40 pb-35 pb-md-50 pb-lg-100 pb-xxl-120">
				<div class="container">
					<!-- Section header -->
					<header class="section-header d-flex flex-column-reverse text-center mb-20 mb-lg-30 mb-xl-45">
						<?php if(!empty($heading)){ ?>
						<h2 class="m-0"><?php echo esc_html($heading) ?></h2>
						<?php } ?>
						<?php if(!empty($title)){ ?>
						<p><?php echo esc_html($title) ?></p>
						<?php } ?>
					</header>
					<div class="trending-jobs-carousel">
                    <?php

                    $lm_team_list = vc_param_group_parse_atts($atts['treding_multi']);

                    foreach ($lm_team_list as $key => $value) {
						$url= isset($value["url"]) ? $value["url"] : '';
                        $icn_img= isset($value["icn_img"]) ? $value["icn_img"] : '';
                        $m_title = isset($value["m_title"]) ? $value["m_title"] : '';
                        $m_heading = isset($value["m_heading"]) ? $value["m_heading"] : '';
                        $sallery = isset($value["sallery"]) ? $value["sallery"] : '';

                        ?>
                       
                       		<div class="slide">
							<a href="<?php echo esc_html($url) ?>">
								<div class="text-info">
                                <style>
                                        
                                        .slide .text-info {
    background: transparent !important;
    transition: background 0.3s ease; /* Optional: Add a smooth transition effect */
}

.slide:hover .text-info {
    background: rgba(74, 89, 235, 0.8) !important;
}
                                    </style>
                                  
									<?php if(!empty($m_title)){ ?>
									<strong class="designation"><?php echo esc_html($m_title) ?></strong>
									<?php } ?>
									<?php if(!empty($m_heading)){ ?>
									<h3><?php echo esc_html($m_heading) ?></h3>
									<?php } ?>
									<?php if(!empty($sallery)){ ?>
									<strong class="price"><?php echo esc_html($sallery) ?></strong>
									<?php } ?>
								</div>
									<?php if(!empty($icn_img)){ ?>
								<img src="<?php echo esc_url_raw($icn_img) ?>" alt="image">
									<?php } ?>
							</a>
						</div>
                        <?php
                    }
                    ?>
                </div>
				</div>
			</section>
    <?php

    return ob_get_clean();
}
add_shortcode('jobcircle_trending_job', 'jobcircle_trending_job_front');
