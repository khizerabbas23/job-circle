<?php

    function how_to_job_search() {

       

       vc_map(

    	  

    		   array(

    			   'name' => __( 'How to Job Serach' ),

    			   'base' => 'how_to_job_search',

    			   'category' => __( 'job Circle' ),

    			   'params' => array(

    			   

    				   array(

    					   'type' => 'jobcircle_browse_img',

    					   'holder' => 'div',

    					   'class' => '',

    					   'heading' => __( 'Image' ),

    					   'param_name' => 'img',

    				   ),

    				   array(

    					   'type' => 'textfield',

    					   'holder' => 'div',

    					   'class' => '',

    					   'heading' => __( 'Span tital' ),

    					   'param_name' => 'span_tital',

    				   ),

					   array(

						'type' => 'textfield',

						'holder' => 'div',

						'class' => '',

						'heading' => __( 'Title' ),

						'param_name' => 'title',

					),

    

    								//group

    								array(

    								   'type' => 'param_group',

    								   'value' => '',

    								   'param_name' => 'how_to_job_search_multi',

    								   'params' => array(

    

    									   array(

    										   'type' => 'jobcircle_browse_img',

    										   'holder' => 'div',

    										   'class' => '',

    										   'heading' => __( 'Green Image' ),

    										   'param_name' => 'green_img',

    									  ),

                                          array(

    										   'type' => 'jobcircle_browse_img',

    										   'holder' => 'div',

    										   'class' => '',

    										   'heading' => __( 'White Image' ),

    										   'param_name' => 'white_img',

    									  ),

    									  array(

    									   'type' => 'textfield',

    									   'holder' => 'div',

    									   'class' => '',

    									   'heading' => __( 'Heading' ),

    									   'param_name' => 'head',

    								  ),

									  array(

										'type' => 'textfield',

										'holder' => 'div',

										'class' => '',

										'heading' => __( 'Heading Url' ),

										'param_name' => 'head_url',

								   ),

    			  )

    			   )

    		   ),

    	   )

       );

    }

    add_action( 'vc_before_init', 'how_to_job_search' );

    

    //welcome Massage frontend

    function how_to_job_search_frontend( $atts, $content ) {

    

       $atts = shortcode_atts(

       array(

    	   'img' => '',

    	   'span_tital' => '',

    	   'title' => '',

    	
    

    	   'how_to_job_search_multi' => '',

    

       ), $atts, 'how_to_job_search'

    );

    

    $img  = isset($atts['img']) ? $atts['img'] : '';

    $span_tital  = isset($atts['span_tital']) ? $atts['span_tital'] : '';

    $title  = isset($atts['title']) ? $atts['title'] : '';

   
    ob_start()

    ?>

	<section class="section section-theme-14 job_search_steps featured_jobp">

	<div class="container">

		<div class="row d-flex align-items-center mb-50 mb-lg-120">

			<div class="col-12 col-md-6">

				<div class="img-holder">

					<?php

					if(!empty($img)){

						?>

					<img src="<?php echo esc_url_raw($img) ?>" alt="img">

					<?php

					}

					?>

				</div>

			</div>

			<div class="col-12 col-md-6">

				<div class="text-holder">

					<?php

					if(!empty($span_tital)){

						?>

					<span class="title"><?php echo esc_html($span_tital) ?></span>

					<?php

					}

					?>

					<?php

					if(!empty($title)){

						?>

					<h2><?php echo esc_html($title) ?></h2>

					<?php

					}

					?>

					<ol class="steps_list"> 

					<?php

    			   $lm_team_list = vc_param_group_parse_atts( $atts['how_to_job_search_multi'] ); 

				   if(!empty($lm_team_list)){

    			   foreach ( $lm_team_list as $key => $value) {

    

    				   $head  = isset($value["head"]) ? $value["head"] : '';

    				   $green_img  = isset($value["green_img"]) ? $value["green_img"] : '';

    				   $white_img  = isset($value["white_img"]) ? $value["white_img"] : '';
					 $head_url  = isset($value["head_url"]) ? $value["head_url"] : '';


    				   ?>

					<li>

										<a href="<?php echo esc_html($head_url)?>">

											<div class="icon-hold">

												<?php

												if(!empty($green_img)){

													?>

												<img class="green-img" src="<?php echo esc_url_raw($green_img) ?>" alt="img">

												<?php

												}

												?>

												<?php

												if(!empty($white_img)){

													?>

												<img class="white-img" src="<?php echo esc_url_raw($white_img) ?>" alt="img">

											<?php

												}

												?>

											</div>

											<?php

											if(!empty($head)){

												?>

											<strong class="h5"><?php echo esc_html($head) ?></strong>

										    <?php

											}

											?>

										</a>

									</li>

                    			   <?php

                    			   }

                    			  ?>

				               </ol>

							</div>

						</div>

					</div>

                  </div>

				</div>

			</section>

    		   <?php

       return ob_get_clean();

				}

    }

    add_shortcode( 'how_to_job_search', 'how_to_job_search_frontend' );