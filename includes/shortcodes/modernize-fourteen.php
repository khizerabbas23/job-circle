<?php
    function modernize() {
       vc_map(
    		   array(
    			   'name' => __( 'Rcruiters use Listox ' ),
    			   'base' => 'modernize',
    			   'category' => __( 'job Circle' ),
    			   'params' => array(
    			   
    				   array(
    					   'type' => 'textfield',
    					   'holder' => 'div',
    					   'class' => '',
    					   'heading' => __( 'Title' ),
    					   'param_name' => 'title',
    				   ),
    				   array(
    					   'type' => 'textfield',
    					   'holder' => 'div',
    					   'class' => '',
    					   'heading' => __( 'Sapn Title' ),
    					   'param_name' => 'span_title',
    				   ),
    								//group
    								array(
    								   'type' => 'param_group',
    								   'value' => '',
    								   'param_name' => 'modernize_multi',
    								   'params' => array(
    
    									   array(
    										   'type' => 'jobcircle_browse_img',
    										   'holder' => 'div',
    										   'class' => '',
    										   'heading' => __( 'image' ),
    										   'param_name' => 'img',
    									  ),    
										  array(
											'type' => 'textfield',
											'holder' => 'div',
											'class' => '',
											'heading' => __( 'Url' ),
											'param_name' => 'url',
									   ),                                          
    			  )
    			   )
    		   ),
    	   )
       );
    }
    add_action( 'vc_before_init', 'modernize' );
    
    //welcome Massage frontend
    function modernize_frontend( $atts, $content ) {
    
       $atts = shortcode_atts(
       array(
    	   'title' => '',
    	   'span_title' => '',
    	   'modernize_multi' => '',
       ), $atts, 'modernize'
    );
    $title  = isset($atts['title']) ? $atts['title'] : '';
    $span_title  = isset($atts['span_title']) ? $atts['span_title'] : '';
    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
  ob_start()  
?>
	<section class="section section-theme-14 faq_block remote_jobt">
	<div class="container">
		<div class="recruiters_holder">
			<?php
			if(!empty($title) && !empty($span_title)){
				?>
			<strong class="title"><?php echo esc_html($title) ?><br><?php echo esc_html($span_title) ?></strong>
			<?php
			}
			?>
			<ul class="logos_list">
			
			<?php
    			   $lm_team_list = vc_param_group_parse_atts( $atts['modernize_multi'] ); 
				   if(!empty($lm_team_list)){
    			   foreach ( $lm_team_list as $key => $value) {

                    $img  = isset($value['img']) ? $value['img'] : '';
                    $url  = isset($value['url']) ? $value['url'] : '';

    			?>	   
				   <li>
				   <div class="logo-holder">
					<?php
					if(!empty($img) && !empty($url)){
						?>
					  <a href="<?php echo esc_html($url) ?>"><img src="<?php echo esc_url_raw($img) ?>" alt="img"></a>
					   <?php
					}
					?>
				   </div>
			   </li>
    		   
    			   <?php
    			   }
				   ?>
    			
				   </ul>
				   </div>
			   </div>
		   </section>
    			   
    		   
    <?php
       return ob_get_clean();
				}
    }
    add_shortcode( 'modernize', 'modernize_frontend' );