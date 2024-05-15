<?php

function jobcircle_stay_linked()

{

    vc_map(

        array(

            'name' => __('Stay Linked'),

            'base' => 'jc_stay_linked',

            'category' => __('Job Circle'),

            'params' => array(

                array(

                    'type' => 'jobcircle_browse_img',

                    'holder' => 'div',

                    'class' => '',

                    'heading' => __('Section Background Image '),

                    'param_name' => 'bg_img',

                ),

                array(

                    'type' => 'textfield',

                    'holder' => 'div',

                    'class' => '',

                    'heading' => __('Heading'),

                    'param_name' => 'heading',

                ),

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

                    'heading' => __('Span Title'),

                    'param_name' => 'span_title',

                ),

                array(

                    'type' => 'textfield',

                    'holder' => 'div',

                    'class' => '',

                    'heading' => __('Span Title With Us'),

                    'param_name' => 'span_title_withus',

                ),

                array(

                    'type' => 'textfield',

                    'holder' => 'div',

                    'class' => '',

                    'heading' => __('Upload Button'),

                    'param_name' => 'upload_btn',

                ),
                array(

                    'type' => 'textfield',

                    'holder' => 'div',

                    'class' => '',

                    'heading' => __('Upload Url'),

                    'param_name' => 'upload_url',

                ),


                array(

                    'type' => 'jobcircle_browse_img',

                    'holder' => 'div',

                    'class' => '',

                    'heading' => __('Section Image '),

                    'param_name' => 'section_img',

                ),



            )

        )

    );



}

add_action('vc_before_init', 'jobcircle_stay_linked');



//welcome Massage frontend

function jobcircle_stay_linked_frontend($atts, $content)

{



    $atts = shortcode_atts(

        array(



            'bg_img' => '',

            'title' => '',

            'heading' => '',

            'span_title' => '',

            'span_title_withus' => '',



            'upload_btn' => '',
	 'upload_url' => '',
            'section_img' => '',

        ),

        $atts,

        'jobcircle_stay_linked'

    );

    $bg_img = isset($atts['bg_img']) ? $atts['bg_img'] : '';

    $section_img = isset($atts['section_img']) ? $atts['section_img'] : '';



    $heading = isset($atts['heading']) ? $atts['heading'] : '';

    $title = isset($atts['title']) ? $atts['title'] : '';

    $span_title = isset($atts['span_title']) ? $atts['span_title'] : '';
$upload_url = isset($atts['upload_url']) ? $atts['upload_url'] : '';

    $span_title_withus = isset($atts['span_title_withus']) ? $atts['span_title_withus'] : '';

    



    $upload_btn = isset($atts['upload_btn']) ? $atts['upload_btn'] : '';

    $output = '';

    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';

    ob_start();

    ?>

    <?php

    if(!empty($bg_img)){

        ?>

        <section class="section bg-overlay section-workspace pt-35 pb-0 pt-md-40" style="background-image: url('<?php echo esc_url_raw($bg_img) ?>');">

        <?php 

    }

	?>

				<div class="container">

					<div class="row">

						<div class="col-12 col-md-6">

							<div class="d-flex align-items-center h-100 pb-35 pb-md-45 pb-lg-55">

								<div class="textbox">

                                <?php

                         if(!empty($heading)){

                               ?>

        			<strong class="h3 subtitle"><?php echo esc_html($heading) ?></strong>

                    <?php 

                         }

	                    ?><?php

                        if(!empty($title) || ($span_title) || ($span_title_withus)){

                              ?>

									<h2 class="h1"><?php echo esc_html($title);?><span class="text-primary"> <?php echo esc_html($span_title);?> </span><?php echo esc_html($span_title_withus) ?></h2>

                                    <?php

                        }

                                if(!empty($upload_btn) && !empty($upload_url)){

                                    ?>

                            	<a href="<?php echo esc_html($upload_url) ?>" class="btn btn-primary"><span class="btn-text"><?php echo esc_html($upload_btn) ?></span></a>

                                    <?php 

                                }

                                ?>

								</div>

							</div>

						</div>

						<div class="col-12 col-md-6 d-flex justify-content-end">

							<div class="d-flex align-items-end h-100">

								<div class="image-holder">

                                <?php

                                if(!empty($section_img)){

                                    ?>

                                <img src="<?php echo esc_url_raw($section_img) ?>" width="649" height="680" alt="Job-Circle">

                                    <?php 

                                }

                                ?>

								</div>

							</div>

						</div>

					</div>

				</div>

			</section>

    <?php

    return ob_get_clean();

}

add_shortcode('jc_stay_linked', 'jobcircle_stay_linked_frontend');