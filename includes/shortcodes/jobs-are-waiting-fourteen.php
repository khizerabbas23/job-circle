<?php

    function jobcircle_jobs_are_waiting() {

       vc_map(

    		   array(

    			   'name' => __( 'Jobs are Waiting' ),

    			   'base' => 'jobs_are_waiting',

    			   'category' => __( 'job Circle' ),

    			   'params' => array(

    				   array(

    					   'type' => 'jobcircle_browse_img',

    					   'holder' => 'div',

    					   'class' => '',

    					   'heading' => __( 'MAin Bg Image' ),

    					   'param_name' => 'bg_img',

    				   ),

					   array(

						'type' => 'jobcircle_browse_img',

						'holder' => 'div',

						'class' => '',

						'heading' => __( 'MAin Image' ),

						'param_name' => 'bmain_img',

					),

					array(

						'type' => 'jobcircle_browse_img',

						'holder' => 'div',

						'class' => '',

						'heading' => __( 'Green BG Image' ),

						'param_name' => 'gbg_img',

					),

					array(

						'type' => 'jobcircle_browse_img',

						'holder' => 'div',

						'class' => '',

						'heading' => __( 'Icon Hold  Image' ),

						'param_name' => 'ihm_img',

					),

    				   array(

    					   'type' => 'textfield',

    					   'holder' => 'div',

    					   'class' => '',

    					   'heading' => __( 'Title' ),

    					   'param_name' => 'title',

    				   ),

					   array(

						'type' => 'textarea',

						'holder' => 'div',

						'class' => '',

						'heading' => __( 'Description' ),

						'param_name' => 'description',

					),

    

    								//group

    								array(

    								   'type' => 'param_group',

    								   'value' => '',

    								   'param_name' => 'jobs_are_waiting_multi',

    								   'params' => array(

    

    									

    									  array(

    									   'type' => 'textfield',

    									   'holder' => 'div',

    									   'class' => '',

    									   'heading' => __( 'Button Heading' ),

    									   'param_name' => 'b_heading',

    								  ),

									  array(

										'type' => 'textfield',

										'holder' => 'div',

										'class' => '',

										'heading' => __( 'Button Url' ),

										'param_name' => 'b_url',

								   ),

								   array(

									'type' => 'textfield',

									'holder' => 'div',

									'class' => '',

									'heading' => __( 'Button BG Colour' ),

									'param_name' => 'bg_colour',

							   ),

    								 

    

    			  )

    			   )

    		   ),

    	   )

       );

    }

    add_action( 'vc_before_init', 'jobcircle_jobs_are_waiting' );

    

    //welcome Massage frontend

    function jobcircle_jobs_are_waiting_frontend( $atts, $content ) {

    

       $atts = shortcode_atts(

       array(

    	   'bg_img' => '',

    	   'bmain_img' => '',

    	   'gbg_img' => '',

    	   'ihm_img' => '',

    	   'title' => '',

    	   'description' => '',

    

    	   'jobs_are_waiting_multi' => '',

    

       ), $atts, 'jobcircle_jobs_are_waiting'

    );

    

	$bg_img = isset($atts['bg_img']) ? $atts['bg_img'] : '';

	$bmain_img = isset($atts['bmain_img']) ? $atts['bmain_img'] : '';

	$gbg_img = isset($atts['gbg_img']) ? $atts['gbg_img'] : '';

    $ihm_img  = isset($atts['ihm_img']) ? $atts['ihm_img'] : '';

    $title  = isset($atts['title']) ? $atts['title'] : '';

    $description  = isset($atts['description']) ? $atts['description'] : '';



	ob_start()

    ?>

	<style>

		.section-theme-14.jobs_waiting .wrap-holder {

    background: url(<?php echo esc_url_raw($gbg_img) ?>);

    background-position: 50% 50%;

    background-size: cover;

    border-radius: 30px;

    padding: 20px;

    margin: 0 0 30px;



}

.jobs_waiting {

    padding: 40px 0;

    background: transparent !important;

    border-bottom: 1px solid #efefef;

}

	</style>

<section class="section section-theme-14 jobs_waiting border-bottom-0" 

<?php if(!empty($bg_img)) { ?>



style="background-image: url('<?php echo esc_url_raw($bg_img) ?>');"

<?php } ?>

>
<div class="container">
		<div class="wrap-holder">

			<div class="left_align">

				<div class="icon-hold">

				    <?php if(!empty($ihm_img)) { ?>

					<img src="<?php echo esc_url_raw($ihm_img) ?>" alt="img">

					<?php } ?>

				</div>

				<div class="text-hold">

				<?php if(!empty($title)) { ?>

					<h2><?php echo esc_html($title) ?></h2>

					<?php } ?>

					<?php if(!empty($description)) { ?>

					<p><?php echo esc_textarea($description) ?></p>

					<?php } ?>

					<div class="btns d-flex align-items-center">



					<?php

    			   $lm_team_list = vc_param_group_parse_atts( $atts['jobs_are_waiting_multi'] ); 

				   if(!empty($lm_team_list)){

    			   foreach ( $lm_team_list as $key => $value) {



					   $b_heading = isset($value['b_heading']) ? $value['b_heading'] : '';

					   $b_url = isset($value['b_url']) ? $value['b_url'] : '';

    				   $bg_colour  = isset($value["bg_colour"]) ? $value["bg_colour"] : '';

    				  

    				   ?>

    			    

    			    <?php if(!empty($b_url) || !empty($bg_colour) || !empty($b_heading)) { ?>

					<a href="<?php echo esc_html($b_url) ?>" class="btn btn-<?php echo esc_html($bg_colour) ?> btn-sm"><span class="btn-text"><?php echo esc_html($b_heading) ?></span></a>

					<?php } ?>

    			   <?php

    			   }

    			  ?>

				              </div>

				              </div>

			</div>

			<div class="right_align">

			<?php if(!empty($bmain_img)) { ?>

				<img src="<?php echo esc_url_raw($bmain_img) ?>" alt="img">

				<?php } ?>

			</div>

		</div>

				</div>
			</div>
			</section>



    			   

    		   <?php

       return ob_get_clean();

				}

    }

    add_shortcode( 'jobs_are_waiting', 'jobcircle_jobs_are_waiting_frontend' );