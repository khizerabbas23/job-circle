<?php
function jobcircle_hfifteen_get_matched() {
        vc_map(
           
            array(
                'name' => __( 'Get matched Home 15' ),
                'base' => 'jobcircle_hfifteen_get_matched',
                'category' => __( 'Job Circle' ),
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
    				'heading' => __( 'Paragraph' ),
    				'param_name' => 'para',
    			),
                array(
    				'type' => 'textfield',
    				'holder' => 'div',
    				'class' => '',
    				'heading' => __( 'Cv Button link' ),
    				'param_name' => 'cv_button_link',
    			),
                array(
    				'type' => 'jobcircle_browse_img',
    				'holder' => 'div',
    				'class' => '',
    				'heading' => __( 'Tick image' ),
    				'param_name' => 'tick_img',
    			),
                array(
    				'type' => 'textfield',
    				'holder' => 'div',
    				'class' => '',
    				'heading' => __( 'Tick Title' ),
    				'param_name' => 'tick_title',
    			),
    			array(
    				'type' => 'jobcircle_browse_img',
    				'holder' => 'div',
    				'class' => '',
    				'heading' => __( 'Get Job Image' ),
    				'param_name' => 'get_job_img',
    			),	
                array(
    				'type' => 'jobcircle_browse_img',
    				'holder' => 'div',
    				'class' => '',
    				'heading' => __( 'Background Get Job Image' ),
    				'param_name' => 'bg_get_job_img',
    			),	
                 
                   )
    					)
    				);
    	
    }
    add_action( 'vc_before_init', 'jobcircle_hfifteen_get_matched' );
    
    //welcome Massage frontend
    function jobcircle_hfifteen_get_matched_frontend( $atts, $content ) {
     
        $atts = shortcode_atts(
        array(
       
    		'title' => '',
    		'para' => '',
    		'cv_button_link' => '',
    		'tick_img' => '',
    		'tick_title' => '',
    		'get_job_img' => '',
    		'bg_get_job_img' => '',
        ), $atts, 'jobcircle_hfifteen_get_matched'
    );
    
    $title  = isset($atts['title']) ? $atts['title'] : '';
    $para  = isset($atts['para']) ? $atts['para'] : '';
    $cv_button_link  = isset($atts['cv_button_link']) ? $atts['cv_button_link'] : '';
    $tick_img  = isset($atts['tick_img']) ? $atts['tick_img'] : '';
  
    $tick_title  = isset($atts['tick_title']) ? $atts['tick_title'] : '';
    $get_job_img  = isset($atts['get_job_img']) ? $atts['get_job_img'] : '';
    $bg_get_job_img  = isset($atts['bg_get_job_img']) ? $atts['bg_get_job_img'] : '';
    
     $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
     
    ob_start();
    ?>
    <section class="section section-theme-15 get-jobs-block pt-0 pb-0">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-md-5">
                <div class="text-box">
                    <?php
                    if(!empty($title) || !empty($para)){
                        ?>
                    <h2><?php echo esc_html($title) ?></h2>
                    <p><?php echo esc_html($para) ?></p>
                    <?php
                    }
                    ?>
                    <div class="button">
                    <?php if(!empty($cv_button_link)){ ?>
                        <a href="<?php echo esc_html($cv_button_link) ?>" class="btn">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                            <span><?php esc_html_e('Upload your CV', 'jobcircle-frame') ?></span>
                        </a>
                        <?php } ?>
                    </div>
                    <?php
                    if(!empty($tick_img) || !empty($tick_title)){
                        ?>
                    <p><img class="tick" src="<?php echo esc_url_raw($tick_img) ?>" alt="tick"><?php echo esc_html($tick_title) ?></p>
              <?php
                    }
                    ?>
                </div>
            </div>
            <div class="col-12 col-md-7">
                <div class="image-holder">
                <?php
                    if(!empty($get_job_img)){
                        ?>
                    <img src="<?php echo esc_url_raw($get_job_img) ?>" alt="image">
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-image">
    <?php
         if(!empty($bg_get_job_img)){
             ?>
        <img src="<?php echo esc_url_raw($bg_get_job_img) ?>" alt="image">
        <?php
        }
        ?>
    </div>
</section>

    	<?php
    
    
        return ob_get_clean();
    
    }
    add_shortcode( 'jobcircle_hfifteen_get_matched', 'jobcircle_hfifteen_get_matched_frontend' );