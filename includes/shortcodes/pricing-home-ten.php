<?php
function jobcircle_hten_pricing()
{
    vc_map(
        array(
            'name' => __('Pricing Home Ten'),
            'base' => 'jc_hten_pricing',
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
                    'heading' => __('Sub Title'),
                    'param_name' => 'sub_title',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Questions'),
                    'param_name' => 'ques',
                ),
                array(
                    'type' => 'iconpicker',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Questions'),
                    'param_name' => 'ques_icon',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('FAQ'),
                    'param_name' => 'faq',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('FAQ Link'),
                    'param_name' => 'faq_link',
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
                    'param_name' => 'multi_review',
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Multi Title'),
                            'param_name' => 'multi_title',
                        ),
                        array(
                            'type' => 'textarea',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Multi Price'),
                            'param_name' => 'multi_price',
                        ),
                        
                        array(
                            'type' => 'textarea',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Feature One'),
                            'param_name' => 'feature_one',
                        ),
                        array(
                            'type' => 'textarea',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Feature Two'),
                            'param_name' => 'feature_two',
                        ),
                        array(
                            'type' => 'textarea',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Feature Three'),
                            'param_name' => 'feature_three',
                        ),
                        array(
                            'type' => 'textarea',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Feature Four'),
                            'param_name' => 'feature_four',
                        ),
                        array(
                              'type' => 'textfield',
                              'holder' => 'div',
                              'class' => '',
                              'heading' => __('Product ID'),
                              'param_name' => 'product_id',
                            ),
                    ),
                )
            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_hten_pricing');


// Frontend Coding 

function jobcircle_hten_pricing_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(
            'title' => '',
            'sub_title' => '',
            'ques' => '',
            'ques_icon' => '',
            'faq' => '',
            'faq_link' => '',
            'upld_img' => '',

            'multi_review' => '',
        ),
        $atts,
        'jobcircle_hten_pricing'
    );

    $title = isset($atts['title']) ? $atts['title'] : '';
    $sub_title = isset($atts['sub_title']) ? $atts['sub_title'] : '';
    $ques = isset($atts['ques']) ? $atts['ques'] : '';
    $ques_icon = isset($atts['ques_icon']) ? $atts['ques_icon'] : '';
    $faq = isset($atts['faq']) ? $atts['faq'] : '';
    $faq_link = isset($atts['faq_link']) ? $atts['faq_link'] : '';

    $upld_img  = isset($atts["upld_img"]) ? $atts["upld_img"] : '';

    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
    ob_start();
?>
    	    <?php if (!empty($upld_img)) {
                                ?>
    <section class="section section-theme-10 pricing-plan-block pt-30 pt-md-40 pt-lg-80 pt-xxl-90 pb-30 pb-md-50 pb-lg-100 pb-xxl-120" style="background-image: url('<?php echo jobcircle_esc_the_html($upld_img) ?>');">
		<?php
                                } ?>
				<div class="container">

					<!-- Section header -->
					<header class="section-header d-flex flex-column-reverse text-center mb-10 mb-md-30 mb-lg-45">
                        <?php 
                        if(!empty($title)){
                            ?>
						<h2><?php echo esc_html($title);?></h2>
						<?php
                        }
                        if(!empty($sub_title)){
                        ?>
						<p><?php echo esc_html($sub_title);?></p>
                        <?php
                        }
                        ?>
					</header>
					<div class="row justify-content-center">
                <?php

                $lm_team_list = vc_param_group_parse_atts($atts['multi_review']);
                ?>
                <?php
                $counter = 0;
                foreach ($lm_team_list as $key => $value) {
                    $multi_title  = isset($value["multi_title"]) ? $value["multi_title"] : '';
                    $multi_price  = isset($value["multi_price"]) ? $value["multi_price"] : '';
                    $feature_one  = isset($value["feature_one"]) ? $value["feature_one"] : '';
                    $feature_two  = isset($value["feature_two"]) ? $value["feature_two"] : '';
                    $feature_three  = isset($value["feature_three"]) ? $value["feature_three"] : '';
                    $feature_four  = isset($value["feature_four"]) ? $value["feature_four"] : '';
                    $product_id  = isset($value["product_id"]) ? $value["product_id"] : '';
                   
                    if($counter == 0){
                        $recom = '';
                        $span = '';
                    }
                    elseif($counter == 1){
                        $recom = 'recommended';
                        $span ='<span class="tag">Recommended</span>';
                    }
                    elseif($counter == 2){
                        $recom = '';
                        $span = '';
                    }

                ?>

                        <div class="col-12 col-md-6 col-lg-4">
							<div class="pricing-plan <?php echo jobcircle_esc_the_html($recom);?>">
								<div class="card-head">
								    <?php if(!empty($span)){
									 echo jobcircle_esc_the_html($span);
									}
                                    if(!empty($multi_title)){
                                        ?>
									<span class="title"><?php echo esc_html($multi_title);?> </span>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    if(!empty($multi_price)){
                                     ?>
									<strong class="price"><sup><?php echo esc_html_e('$','jobcircle-frame');?></sup><?php echo esc_html($multi_price);?><sub><?php echo esc_html_e('/mo','jobcircle-frame');?></sub></strong>
                                    <?php
                                    }
                                    ?>
								</div>
								<ul class="feature-list">
                                    <?php 
                                    if(!empty($feature_one)){
                                    ?>    
                                    <li><?php echo esc_html($feature_one);?></li>
                                    <?php 
                                    }
                                     if(!empty($feature_two)){
                                         ?>
									<li><?php echo esc_html($feature_two);?></li>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    if(!empty($feature_three)){
                                    ?>
									<li><?php echo esc_html($feature_three);?></li>
									<?php 
                                    }
                                    if(!empty($feature_four)){
                                        ?>
									<li><?php echo esc_html($feature_four);?></li>
                                    <?php 
                                    }
                                    ?>
								</ul>
								<?php
								if(!empty($product_id)){
                                        ?>
                                <div class="pricing_wrap">
								<a class="jobcircle-user-pkg-buybtn" data-id="<?php echo $product_id; ?>">
								<button class="btn"><span><?php echo esc_html_e('Get Started','jobcircle-frame');?></span></button>
								</a>
								</div>
								<?php 
                                    }
                                    ?>
							</div>
                                </div>
                <?php
                $counter++;
               }
               
                ?>
            
            </div>
					<div class="row">
						<col-12 class="d-flex justify-content-center">
                        <?php 
                        if(!empty($ques) || !empty($faq) || !empty($ques_icon) || !empty($faq_link)){
                            ?>
							<p class="lead"><span class=" <?php echo esc_html($ques_icon);?>"></span><?php echo esc_html($ques);?> <a href="<?php echo esc_html($faq_link);?>"><?php echo esc_html($faq);?></a></p>
                            <?php
                        }
                        ?>
						</col-12>
					</div>
				</div>
			</section>


<?php
    return ob_get_clean();
                        }
add_shortcode('jc_hten_pricing', 'jobcircle_hten_pricing_frontend');