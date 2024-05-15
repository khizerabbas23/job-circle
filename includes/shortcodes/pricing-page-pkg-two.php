<?php
function jobcircle_pkg_two() {
    vc_map(
        array(
            'name' => __('JC Package Two'),
            'base' => 'jc_pkg_two',
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
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Discription'),
                    'param_name' => 'disc',
                ),
               
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'mlti_price',
                    'params' => array(

                        //parameters for first multi group
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Package'),
                            'param_name' => 'pkg',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Package Price'),
                            'param_name' => 'pkg_price',
                        ),
                        
                        array(
                            'type' => 'jobcircle_browse_img',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Icon Image'),
                            'param_name' => 'icn_img',
                        ),
                     
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Job Posting'),
                            'param_name' => 'job_posting',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Featured Job'),
                            'param_name' => 'featured_job',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Job Displayed'),
                            'param_name' => 'job_displayed',
                        ),
                    
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Premium Support'),
                            'param_name' => 'premium_support',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Select Plan Link'),
                            'param_name' => 'slct_link',
                        ),
                      
                     
                    ),
                ),
            ),
        )
    );
}
add_action('vc_before_init', 'jobcircle_pkg_two');


// Frontend Coding 

function jobcircle_pkg_two_front( $atts, $content ) {

   $atts = shortcode_atts(
   array(
       //single parameters
    
'title' => '',
'disc' => '',

    
    //multi group parameter group name
    'mlti_price' => '',

   ), $atts, 'jobcircle_pkg_two'
);

$title = isset($atts["title"]) ? $atts["title"] : '';
$disc = isset($atts["disc"]) ? $atts["disc"] : '';

ob_start();
?>

<section class="section section-theme-1 packages-block bg-light-sky pt-35 pt-md-50 pt-lg-65 pt-xl-85 pt-xxl-110 pb-35 pb-md-50 pb-lg-65 pb-xl-85 pb-xxl-110">
				<div class="container">
					<!-- Section header -->
					<header class="section-header text-center mb-30 mb-md-45 mb-xl-60">
                        <?php
                        if(!empty($title) && !empty($disc)){
                            ?>
						<h2><?php echo esc_html($title);?></h2>
						<p><?php echo esc_textarea($disc);?></p>
                        <?php
                        }
                        ?>
					</header>
					<div class="row justify-content-center">
                <?php
                
                $lm_team_list = vc_param_group_parse_atts( $atts['mlti_price'] ); 
                $counter=1;       
                foreach ( $lm_team_list as $key => $value) {

    
    $pkg = isset($value["pkg"]) ? $value["pkg"] : '';
    $pkg_price = isset($value["pkg_price"]) ? $value["pkg_price"] : '';
    $icn_img = isset($value["icn_img"]) ? $value["icn_img"] : '';
    $slct_link = isset($value["slct_link"]) ? $value["slct_link"] : '';
    $job_posting = isset($value["job_posting"]) ? $value["job_posting"] : '';
    $featured_job = isset($value["featured_job"]) ? $value["featured_job"] : '';
    $job_displayed = isset($value["job_displayed"]) ? $value["job_displayed"] : '';
    $premium_support = isset($value["premium_support"]) ? $value["premium_support"] : '';
    
    if($counter == 1){
        $bg = 'package-box ';
        $text = '';
        $strong = '';
        $color = 'btn btn-white btn-sm';
        $width = '38';
        $height = '34';
    }
    elseif($counter == 2){
        $bg = 'bg-dark-green';
        $text = 'text-white';
		$strong = '<strong class="recommended-tag">Recommended</strong>';
		$color = 'btn btn-green btn-sm';
		$width = '55';
        $height = '49';
    }
    elseif($counter == 3){
        $bg = 'package-box ';
        $text = '';
        $strong = '';
        $color = 'btn btn-white btn-sm';
        $width = '52';
        $height = '52';
    }
    ?>
    
                         <div class="col-12 col-md-6 col-lg-4 mb-15 mb-md-30">
							<div class="package-box <?php echo jobcircle_esc_the_html($bg);?>">
								<div class="box-head <?php echo jobcircle_esc_the_html($text);?>">
                                    <?php 
                                    if(!empty($pkg) && !empty($pkg_price)){
                                        ?>
									<strong class="subtitle"><?php echo jobcircle_esc_the_html($pkg);?></strong>
                                    <?php echo jobcircle_esc_the_html($strong);?>
									<h3><?php echo jobcircle_esc_the_html($pkg_price);?></h3>
                                    <?php
                                    }
                                    ?>
									 
								</div>
								<div class="box-inner">
                                    <div class="icon">
                                        <?php 
                                        if(!empty($icn_img)){
                                            ?>
										<img src="<?php echo esc_url_raw($icn_img);?>" width="<?php echo jobcircle_esc_the_html($width) ?>" height="<?php echo jobcircle_esc_the_html($height) ?>" alt="Image Description">
                                        <?php
                                        }
                                        ?>
									</div>
									<ul class="list-unstyled features-list">
                                        <?php 
                                        if(!empty($job_posting) || !empty($featured_job) || !empty($job_displayed) || !empty($premium_support)){
                                            ?>
										<li><?php echo esc_html($job_posting);?></li>
										<li><?php echo esc_html($featured_job);?></li>
										<li><?php echo esc_html($job_displayed);?></li>
										<li><?php echo esc_html($premium_support);?></li>
                                        <?php
                                        }
                                        ?>
									</ul>
									<?php 
                                        if(!empty($slct_link)){
                                            ?>
									<a href="<?php echo esc_html($slct_link);?>" class="<?php echo jobcircle_esc_the_html($color) ?>"><span class="btn-text"><?php echo esc_html_e('Select Plan','jobcircle');?></span></a>
							         <?php
                                        }
                                        ?>
								</div>
							</div>
						</div>
                <?php
                 $counter++;
                }
                ?>
	             </div>
				</div>
			</section>
<?php
    
return  ob_get_clean();
}
add_shortcode( 'jc_pkg_two', 'jobcircle_pkg_two_front');