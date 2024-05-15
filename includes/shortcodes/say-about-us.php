<?php
function jobcircle_customors_about_us() {
   vc_map(
      
       array(
           'name' => __( 'Customr Say About us' ),
           'base' => 'job_circle_customors_about_us',
           'category' => __( 'Job Circle' ),
           'params' => array(
               

            array(
                'type' => 'textfield',
                'holder' => 'div',
                'class' => '',
                'heading' => __( 'Heading' ),
                'param_name' => 'heading',
            ),
            array(
                'type' => 'textfield',
                'holder' => 'div',
                'class' => '',
                'heading' => __( 'Sub Heading' ),
                'param_name' => 'sub_heading',
            ),
           
            
      //group
      array(
       'type' => 'param_group',
       'value' => '',
       'param_name' => 'service_multi',
       'params' => array(

        array(
            'type' => 'iconpicker',
            'holder' => 'div',
            'class' => '',
            'heading' => __( 'Icon' ),
            'param_name' => 'multi_icn',
        ),
           array(
            'type' => 'jobcircle_browse_img',
            'holder' => 'div',
            'class' => '',
            'heading' => __( 'Image' ),
            'param_name' => 'multi_image',
        ),
        array(
            'type' => 'textfield',
            'holder' => 'div',
            'class' => '',
            'heading' => __( 'Aurthor Name' ),
            'param_name' => 'aurthor_name',
        ),
        array(
            'type' => 'textfield',
            'holder' => 'div',
            'class' => '',
            'heading' => __( 'Aurthor Field' ),
            'param_name' => 'aurthor_field',
        ),
          
        array(
            'type' => 'textarea',
            'holder' => 'div',
            'class' => '',
            'heading' => __( 'Description' ),
            'param_name' => 'descrip',
        ),
          
           ),
       )
           )
       
           
       )
   );
}
add_action( 'vc_before_init', 'jobcircle_customors_about_us' );


// Frontend Coding 

function jobcircle_customors_about_us_front( $atts, $content ) {

   $atts = shortcode_atts(
   array(
       
       'heading' => '',
       'sub_heading' => '',

       'service_multi'=>'',

   ), $atts, 'jobcircle_customors_about_us'
);

$heading = isset($atts['heading']) ? $atts['heading'] : '';
$sub_heading = isset($atts['sub_heading']) ? $atts['sub_heading'] : '';
  
$custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
ob_start();
?>

<section class="section section-theme-1 bg-light-gray section-quotes pt-35 pt-md-50 pt-lg-65 pt-xl-90 pt-xxl-120 pb-35px pb-md-50 pb-lg-65 pb-xl-90 pb-xxl-120">
				<div class="container">
					<header class="section-header text-center mb-30 mb-md-45 mb-xl-60">
						<div class="seprator"></div>
                        <?php
                       if(!empty($heading)){
                        ?>
						<h2><?php echo esc_html($heading)?></h2>
                        <?php
                    }?>
                     <?php
                       if(!empty($sub_heading)){
                        ?>
						<p><?php echo esc_html($sub_heading)?></p>
                        <?php
                    }?>
					</header>
					<div class="quotes-slider">
<?php
$lm_team_list = vc_param_group_parse_atts($atts['service_multi']); 
foreach ( $lm_team_list as $key => $value) {

    $multi_icn  = isset($value["multi_icn"]) ? $value["multi_icn"] : '';
    $multi_image  = isset($value["multi_image"]) ? $value["multi_image"] : '';
  $aurthor_name  = isset($value["aurthor_name"]) ? $value["aurthor_name"] : '';
 $aurthor_field  = isset($value["aurthor_field"]) ? $value["aurthor_field"] : '';
    $descrip  = isset($value["descrip"]) ? $value["descrip"] : '';
?>
                      <div class="slick-slide">
							<div class="quotes-box">
								<div class="author-box">
									<div class="social-icon">
                                    <?php
                       if(!empty($multi_icn)){
                        ?>
                                    <i class="<?php echo esc_html($multi_icn)?>"></i></div>
                                    <?php
                    }?>
									<div class="author-avatar">
                                    <?php
                       if(!empty($multi_image)){
                        ?>
										<img src="<?php echo esc_url_raw($multi_image)?>" width="119" height="119" alt="Linda Romania">
                                        <?php
                    }?>
									</div>
                                
                                    <?php
                       if(!empty($aurthor_name) || !empty($aurthor_field)){
                        ?>
									<strong class="author-name h6"><?php echo esc_html ($aurthor_name)?><span><?php echo esc_html ($aurthor_field)?></span></strong>
                                    <?php
                    }?>
								</div>
								<blockquote>
                                <?php
                       if(!empty($descrip)){
                        ?>
									<q><?php echo esc_textarea($descrip)?></q>
                                    <?php
                    }?>
								</blockquote>
							</div>
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
add_shortcode( 'job_circle_customors_about_us', 'jobcircle_customors_about_us_front');
