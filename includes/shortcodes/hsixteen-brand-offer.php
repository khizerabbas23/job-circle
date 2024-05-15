<?php
function jobcircle_brnd_offer_hsixteen()
{
    vc_map(

        array(
            'name' => __('BRANDS OFFERS HSIXTEEN'),
            'base' => 'jobcircle_brnd_offer_hsixteen',
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
                    'heading' => __('Tag Line'),
                    'param_name' => 'tg_line',
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
                    'param_name' => 'faq_multi',
                    'params' => array(


                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Question'),
                            'param_name' => 'question',
                        ),
                        array(
                            'type' => 'textarea',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Answer'),
                            'param_name' => 'answer',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('ID'),
                            'param_name' => 'ids',
                        ),

                    ),
                )
            )


        )
    );
}
add_action('vc_before_init', 'jobcircle_brnd_offer_hsixteen');


// Frontend Coding 

function jobcircle_brnd_offer_hsixteen_front($atts, $content)
{

    $atts = shortcode_atts(
        array(
            'title' => '',
            'tg_line' => '',
            'upld_img' => '',

            'faq_multi' => '',

        ),
        $atts,
        'jobcircle_brnd_offer_hsixteen'
    );
    $title  = isset($atts['title']) ? $atts['title'] : '';
   $tg_line  = isset($atts['tg_line']) ? $atts['tg_line'] : '';
   $upld_img  = isset($atts['upld_img']) ? $atts['upld_img'] : '';


    ob_start();
    ?>
    <section class="section section-theme-16 faq_block brnd-offre">
				<div class="container">
					<div class="row mb-50 mb-lg-70 d-flex align-items-center">
						<div class="col-12 col-md-6">
							<!-- Section header -->
							<header class="section-header d-flex flex-column mb-15 mb-md-30 mb-xl-65">
                            <?php if(!empty($tg_line)){ ?> 
								<p><?php echo esc_html($tg_line)?></p>
                            <?php }?>
                            <?php if(!empty($title)){ ?> 
								<h2><?php echo esc_html($title)?></h2>
                            <?php }?>
							</header>
							<div class="accordion_holder" id="accordionExample">
								<ul class="accordion_list">

                <?php
                $lm_team_list = vc_param_group_parse_atts($atts['faq_multi']);
                foreach ($lm_team_list as $key => $value) {
                    $question = isset($value["question"]) ? $value["question"] : '';
                    $answer = isset($value["answer"]) ? $value["answer"] : '';
                    $ids = isset($value["ids"]) ? $value["ids"] : '';

                    // Check if it's the first item
                    if ($key === 1) {
                        $cls = 'true';
                        $show = 'show';
                        $colape = '';
                    } else {
                        $cls = '';
                        $show = '';
                        $colape = 'collapsed';
                    }

                    ?>
                    <li id="headingOne">
                        <?php if(!empty($ids) || !empty($cls) || !empty($colape)){
                            ?>
						<button type="button" class="<?php echo jobcircle_esc_the_html($colape) ?>" data-bs-toggle="collapse" data-bs-target="#<?php echo jobcircle_esc_the_html($ids) ?>" aria-expanded="<?php echo jobcircle_esc_the_html($cls)?>" aria-controls="<?php echo jobcircle_esc_the_html($ids) ?>">
						    <?php } ?>
							<i class="icon"></i>
							<?php if(!empty($question)){
							    ?>
							<strong class="title"><?php echo esc_html($question)?></strong>
							<?php } ?>
						</button>
						<?php if(!empty($ids)){
						    ?>
						<div id="<?php echo jobcircle_esc_the_html($ids) ?>" class="accordion-collapse collapse <?php echo jobcircle_esc_the_html( $show ) ?>" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
						    <?php } ?>
							<div class="acc-slide">
							    <?php if(!empty($answer)){
							        ?>
								<p><?php echo esc_textarea($answer)?></p>
								<?php } ?>
							</div>
						</div>
					</li>

                    <?php
                }
                ?>
                </ul>
                </div>
				</div>
                <div class="col-12 col-md-6">
							<div class="image-wrap">
                            <?php if(!empty($upld_img)){ ?> 
								<img src="<?php echo esc_url_raw($upld_img)?>" alt="img">
                            <?php }?>
							</div>
						</div>
				</div>
           </div>
			</section>

    <?php

    return ob_get_clean();
}
add_shortcode('jobcircle_brnd_offer_hsixteen', 'jobcircle_brnd_offer_hsixteen_front');