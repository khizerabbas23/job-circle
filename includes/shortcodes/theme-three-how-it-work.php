<?php
function jobcircle_how_it_work_three() {
   
   vc_map(
      
       array(
           'name' => __( 'HOW ITS WORK' ),
           'base' => 'job_circle_how_it_work_three',
           'category' => __( 'Job Circle' ),
           'params' => array(
               

            array(
                'type' => 'textfield',
                'holder' => 'div',
                'class' => '',
                'heading' => __( 'Title' ),
                'param_name' => 'h_two_head',
            ),
            array(
                'type' => 'textfield',
                'holder' => 'div',
                'class' => '',
                'heading' => __( 'Span Title' ),
                'param_name' => 'color_head',
            ),
            array(
                'type' => 'textarea',
                'holder' => 'div',
                'class' => '',
                'heading' => __( 'Discription' ),
                'param_name' => 'disc',
            ),
            array(
                'type' => 'jobcircle_browse_img',
                'holder' => 'div',
                'class' => '',
                'heading' => __( 'Image' ),
                'param_name' => 'image_work',
            ),
            array(
                'type' => 'jobcircle_browse_img',
                'holder' => 'div',
                'class' => '',
                'heading' => __( 'Search Image' ),
                'param_name' => 'img_search',
            ),            
            
      //group
      array(
       'type' => 'param_group',
       'value' => '',
       'param_name' => 'service_multi',
       'params' => array(


           array(
               'type' => 'textfield',
               'holder' => 'div',
               'class' => '',
               'heading' => __( 'Number' ),
               'param_name' => 'numb',
           ),
           array(
            'type' => 'textfield',
            'holder' => 'div',
            'class' => '',
            'heading' => __( 'Title' ),
            'param_name' => 'strong_head',
        ),
        array(
            'type' => 'textarea',
            'holder' => 'div',
            'class' => '',
            'heading' => __( 'Explaination' ),
            'param_name' => 'expl',
        ),
           ),
       )
           )
       
           
       )
   );
}
add_action( 'vc_before_init', 'jobcircle_how_it_work_three' );


// Frontend Coding 

function jobcircle_how_it_work_three_front( $atts, $content ) {

   $atts = shortcode_atts(
   array(
       
       'h_two_head' => '',
       'color_head' => '',
       'disc' => '',
       'image_work' => '',
       'img_search' => '',

       'service_multi'=>'',

   ), $atts, 'jobcircle_how_it_work_three'
);

$h_two_head = isset($atts['h_two_head']) ? $atts['h_two_head'] : '';
$color_head = isset($atts['color_head']) ? $atts['color_head'] : '';
$disc = isset($atts['disc']) ? $atts['disc'] : '';
$image_work = isset($atts['image_work']) ? $atts['image_work'] : '';
$img_search = isset($atts['img_search']) ? $atts['img_search'] : '';



ob_start();
?>
<section class="section section-theme-2 how-work-block pt-35 pt-md-50 pt-lg-75 pt-xl-110 pb-35 pb-md-50 pb-lg-75 pb-xl-110">
<div class="container">
    <!-- Section header -->
    <header class="section-header text-center mb-30 mb-md-45 mb-xl-60">
        <?php
        if(!empty($h_two_head) || !empty($color_head)){
            ?>
            <h2><?php echo  esc_html($h_two_head); ?> <span class="text-outlined"><?php echo esc_html($color_head); ?></span></h2>
            <?php
        }?>
        <?php
        if(!empty($disc)){
            ?>
            <p><?php echo esc_textarea($disc); ?></p>
            <?php
        }?>
        
    </header>
    <div class="row">
        <div class="col-12 col-lg-6 col-xxl-5 mb-15 mb-md-30 mb-lg-0">
            <ul class="how-work-list">
<?php
$lm_team_list = vc_param_group_parse_atts( $atts['service_multi'] ); 
       
foreach ( $lm_team_list as $key => $value) {

             $numb  = isset($value["numb"]) ? $value["numb"] : '';
             $strong_head  = isset($value["strong_head"]) ? $value["strong_head"] : '';
             $expl  = isset($value["expl"]) ? $value["expl"] : '';
?>
                       <li>
                       <div class="num-box">
                       <?php
                        if(!empty($numb)){
                        ?>
                        <span class="number"><?php echo esc_html($numb)?></span>
                        <?php
                        }?>
                           
                       </div>
                       <div class="textbox">
                       <?php
                        if(!empty($strong_head)){
                        ?>
                        <strong class="h5"><?php echo esc_html($strong_head)?></strong>
                        <?php
                        }?>
                        <?php
                        if(!empty($expl)){
                        ?>
                        <p><?php echo esc_textarea($expl)?></p>
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
           <div class="col-12 col-lg-6 col-xxl-7">
               <div class="work-img-box">
               <?php
                        if(!empty($image_work)){
                        ?>
                        <img src="<?php echo esc_url_raw($image_work)?>" alt="How It Works?">
                        <?php
                        }
                    ?> 
                   
                   <div class="img-search">
                   <?php
                        if(!empty($img_search)){
                        ?>
                        <img src="<?php echo esc_url_raw($img_search)?>" alt="Search">
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
$html =  ob_get_clean();
return $html;
}
add_shortcode( 'job_circle_how_it_work_three', 'jobcircle_how_it_work_three_front');